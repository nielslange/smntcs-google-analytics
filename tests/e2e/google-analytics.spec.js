/**
 * The tracking code setting takes a measurement ID (loaded through gtag.js) or a full snippet (printed as is).
 * Requests to Google are blocked: the specs check the markup, not Google.
 */
import { test, expect } from '@wordpress/e2e-test-utils-playwright';

const CODE = '#_customize-input-smntcs_google_analytics_tracking_code';
const ANONYMIZE = '#_customize-input-smntcs_google_analytics_ip_anonymization';

async function saveSettings( page, { code, anonymize = false } ) {
	await page.goto(
		'/wp-admin/customize.php?autofocus[control]=smntcs_google_analytics_tracking_code'
	);
	await page.locator( CODE ).fill( code );
	await page.locator( ANONYMIZE ).setChecked( anonymize );
	const save = page.locator( '#save' );
	if ( await save.isEnabled() ) {
		await save.click();
		await expect( save ).toHaveValue( 'Published' );
	}
}

async function visitFrontEnd( browser ) {
	const context = await browser.newContext( {
		storageState: { cookies: [], origins: [] },
	} );
	await context.route( /google(tagmanager|-analytics)\.com/, ( route ) =>
		route.abort()
	);
	const page = await context.newPage();
	await page.goto( '/' );
	return { context, page };
}

test.describe( 'Google Analytics', () => {
	test.afterAll( async ( { browser } ) => {
		const page = await browser.newPage();
		await saveSettings( page, { code: '' } );
		await page.close();
	} );

	test( 'adds a Settings link to the Customizer control', async ( {
		page,
	} ) => {
		await page.goto( '/wp-admin/plugins.php' );
		const link = page
			.locator( 'tr[data-slug="smntcs-google-analytics"]' )
			.getByRole( 'link', { name: 'Settings' } );
		await expect( link ).toHaveAttribute(
			'href',
			/customize\.php\?autofocus(%5B|\[)control(%5D|\])=smntcs_google_analytics_tracking_code/
		);
	} );

	test( 'loads gtag.js for a measurement ID', async ( { page, browser } ) => {
		await saveSettings( page, { code: 'G-TEST1234' } );

		const visitor = await visitFrontEnd( browser );
		await expect(
			visitor.page.locator(
				'script[src="https://www.googletagmanager.com/gtag/js?id=G-TEST1234"]'
			)
		).toHaveCount( 1 );
		const inline = visitor.page.locator(
			'#smntcs-google-analytics-gtag-js-before'
		);
		// Text assertions skip <script> contents, so read textContent.
		expect( await inline.textContent() ).toContain(
			"gtag('config', \"G-TEST1234\")"
		);
		await visitor.context.close();
	} );

	test( 'anonymizes IPs for a measurement ID when enabled', async ( {
		page,
		browser,
	} ) => {
		await saveSettings( page, { code: 'G-TEST1234', anonymize: true } );

		const visitor = await visitFrontEnd( browser );
		expect(
			await visitor.page
				.locator( '#smntcs-google-analytics-gtag-js-before' )
				.textContent()
		).toContain( '{ anonymize_ip: true }' );
		await visitor.context.close();
	} );

	test( 'prints a full tracking snippet once', async ( { page, browser } ) => {
		await saveSettings( page, {
			code: `<script src="https://www.google-analytics.com/analytics.js" data-smntcs-test></script>`,
		} );

		const visitor = await visitFrontEnd( browser );
		await expect(
			visitor.page.locator( 'script[data-smntcs-test]' )
		).toHaveCount( 1 );
		await expect(
			visitor.page.locator( 'script[src*="googletagmanager.com/gtag"]' )
		).toHaveCount( 0 );
		await visitor.context.close();
	} );
} );
