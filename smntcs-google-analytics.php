<?php
/**
 * Plugin Name:           SMNTCS Google Analytics
 * Plugin URI:            https://github.com/nielslange/smntcs-google-analytics/
 * Description:           Adds <a href="https://analytics.google.com/">Google Analytics</a> to your site.
 * Author:                Niels Lange
 * Author URI:            https://nielslange.de
 * Text Domain:           smntcs-google-analytics
 * Version:               3.3
 * Requires PHP:          7.4
 * Requires at least:     5.5
 * License:               GPL v2 or later
 * License URI:           https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package SMNTCS_Google_Analytics
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class SMNTCS_Google_Analytics
 */
class SMNTCS_Google_Analytics {

	/**
	 * SMNTCS_Google_Analytics constructor.
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_customize' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_settings_link' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_gtag' ), 10, 0 );
		add_action( 'wp_footer', array( $this, 'enqueue' ), 1, 0 );
	}

	/**
	 * Register customizer settings.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer instance.
	 * @return void
	 */
	public function register_customize( $wp_customize ) {
		$wp_customize->add_section(
			'smntcs_google_analytics_section',
			array(
				'priority' => 150,
				'title'    => __( 'Google Analytics', 'smntcs-google-analytics' ),
			)
		);

		$wp_customize->add_setting(
			'smntcs_google_analytics_tracking_code',
			array(
				'type' => 'option',
			)
		);

		$wp_customize->add_control(
			'smntcs_google_analytics_tracking_code',
			array(
				'label'       => __( 'Google Analytics tracking code', 'smntcs-google-analytics' ),
				'description' => __( 'Enter your measurement ID, for example G-XXXXXXXXXX, or paste the full tracking code from Google Analytics.', 'smntcs-google-analytics' ),
				'section'     => 'smntcs_google_analytics_section',
				'type'        => 'textarea',
			)
		);

		$wp_customize->add_setting(
			'smntcs_google_analytics_ip_anonymization',
			array(
				'default' => '',
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			'smntcs_google_analytics_ip_anonymization',
			array(
				'label'   => __( 'IP Anonymization', 'smntcs-google-analytics' ),
				'section' => 'smntcs_google_analytics_section',
				'type'    => 'checkbox',
			)
		);
	}

	/**
	 * Add settings link to plugin list.
	 *
	 * @param array $url Array of links.
	 * @return array
	 */
	public function plugin_settings_link( $url ) {
		$admin_url     = admin_url( 'customize.php?autofocus[control]=smntcs_google_analytics_tracking_code' );
		$settings_link = '<a href="' . $admin_url . '">' . __( 'Settings', 'smntcs-google-analytics' ) . '</a>';
		array_unshift( $url, $settings_link );

		return $url;
	}

	/**
	 * Enqueue tracking code.
	 *
	 * The setting accepts either a measurement ID such as G-XXXXXXXXXX or the
	 * full tracking code copied from Google Analytics. A bare ID is wrapped in
	 * the standard gtag.js snippet so it is never printed as plain text.
	 *
	 * @return void
	 */
	public function enqueue() {
		if ( is_admin() ) {
			return;
		}

		$tracking = trim( (string) get_option( 'smntcs_google_analytics_tracking_code' ) );
		if ( '' === $tracking ) {
			return;
		}

		// A measurement ID is loaded through enqueue_gtag() instead.
		if ( self::is_measurement_id( $tracking ) ) {
			return;
		}

		if ( get_option( 'smntcs_google_analytics_ip_anonymization' ) ) {
			$tracking = str_replace(
				"ga('send', 'pageview');",
				"ga('send', 'pageview'); \n ga('set', 'anonymizeIp', true);",
				$tracking
			);
		}

		echo $tracking; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Check whether a value is a Google tag ID rather than a tracking snippet.
	 *
	 * @param string $value The saved setting.
	 * @return bool True for IDs such as G-XXXXXXXXXX, GT-XXXXXXX, AW-XXXXXXXXX or UA-XXXXXX-X.
	 */
	public static function is_measurement_id( $value ) {
		return (bool) preg_match( '/^(G|GT|AW|DC|UA)-[A-Z0-9-]+$/i', $value );
	}

	/**
	 * Load gtag.js when the setting holds a measurement ID.
	 *
	 * @return void
	 */
	public function enqueue_gtag() {
		$id = strtoupper( trim( (string) get_option( 'smntcs_google_analytics_tracking_code' ) ) );
		if ( ! self::is_measurement_id( $id ) ) {
			return;
		}

		wp_enqueue_script(
			'smntcs-google-analytics-gtag',
			'https://www.googletagmanager.com/gtag/js?id=' . rawurlencode( $id ),
			array(),
			null, // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- The URL is versioned by Google.
			array( 'strategy' => 'async' )
		);

		$config = get_option( 'smntcs_google_analytics_ip_anonymization' ) ? ', { anonymize_ip: true }' : '';
		wp_add_inline_script(
			'smntcs-google-analytics-gtag',
			'window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag(\'js\', new Date()); gtag(\'config\', ' . wp_json_encode( $id ) . $config . ');',
			'before'
		);
	}
}

new SMNTCS_Google_Analytics();
