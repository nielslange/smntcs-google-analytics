const { test, expect } = require( '@playwright/test' );

test.describe( 'Admin', () => {
	// Use Date.now() for unique microtime
	let microtime = ( Date.now() % 1000 ) / 1000;
	const code = `<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', '${ microtime }', 'auto');
		ga('send', 'pageview');
	</script>`;

	test.beforeEach( async ( { page } ) => {
		// Login to the admin panel
		await page.goto( 'http://localhost:8888/wp-login.php' );
		await page.fill( '#user_login', 'admin' );
		await page.fill( '#user_pass', 'password' );
		await page.click( '#wp-submit' );
		await expect( page.locator( 'body' ) ).toContainText( 'Dashboard' );
	} );

	test( 'can activate plugin, update settings, and verify meta tag', async ( {
		page,
	} ) => {
		// Activate the plugin if inactive
		await page.goto( 'http://localhost:8888/wp-admin/plugins.php' );
		const pluginRow = page.locator(
			'tr[data-slug="smntcs-google-analytics"]'
		);
		const isInactive = await pluginRow.getAttribute( 'class' );
		if ( isInactive.includes( 'inactive' ) ) {
			await page.click(
				'tr[data-slug="smntcs-google-analytics"] .activate a'
			);
		}

		// Update the plugin settings
		await page.goto( 'http://localhost:8888/wp-admin/customize.php' );
		await page.click(
			'#accordion-section-smntcs_google_analytics_section'
		);
		await page.fill(
			'#_customize-input-smntcs_google_analytics_tracking_code',
			`${ code }`
		);
		await page.click( '#save' );

		// Verify the updated meta tag on the front-end
		await page.goto( 'http://localhost:8888/' );
		await page.reload();
		const gaScript = await page.locator(
			'script[src="https://www.google-analytics.com/analytics.js"]'
		);
		await expect( gaScript ).toHaveCount( 1 ); // Check that the script is included once
	} );
} );
