<?php
/**
 * Plugin Name: SMNTCS Google Analytics
 * Plugin URI: https://github.com/nielslange/smntcs-google-analytics/
 * Description: Adds <a href="https://analytics.google.com/">Google Analytics</a> to your site
 * Author: Niels Lange <info@nielslange.de>
 * Author URI: https://nielslange.de
 * Version: 2.4
 * Requires at least: 3.4
 * Requires PHP: 5.6
 * Tested up to: 5.3
 * License: GPL3+
 * License URI: https://www.gnu.org/licenses/gpl.html
 *
 * @category   Plugin
 * @package    WordPress
 * @subpackage SMNTCS Google Analytics
 * @author     Niels Lange <info@nielslange.de>
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Avoid direct plugin access
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '¯\_(ツ)_/¯' );
}

/**
 * Load text domain
 *
 * @since 1.0.0
 */
function smntcs_google_analytics_load_textdomain() {
	load_plugin_textdomain( 'smntcs-google-analytics', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'smntcs_google_analytics_load_textdomain' );

/**
 * Add Adobe Typekit Fonts to WordPress Customizer
 *
 * @param WP_Customize_Manager $wp_customize The instance of WP_Customize_Manager.
 * @return void
 * @since 1.0.0
 */
function smntcs_google_analytics_register_customize( $wp_customize ) {
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
			'label'   => __( 'Google Analytics tracking code', 'smntcs-google-analytics' ),
			'section' => 'smntcs_google_analytics_section',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'smntcs_google_analytics_ip_anonymization',
		array(
			'default' => false,
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
add_action( 'customize_register', 'smntcs_google_analytics_register_customize' );


/**
 * Add settings link on plugin page
 *
 * @param string $url The original URL.
 * @return string $url The updated URL.
 * @since 1.0.0
 */
function smntcs_ga_plugin_settings_link( $url ) {
	$admin_url     = admin_url( 'customize.php?autofocus[control]=smntcs_google_analytics_tracking_code' );
	$settings_link = '<a href="' . $admin_url . '">' . __( 'Settings', 'smntcs-google-analytics' ) . '</a>';
	array_unshift( $url, $settings_link );

	return $url;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'smntcs_ga_plugin_settings_link' );

/**
 * Load Adobe Typekit Fonts code and custom CSS
 *
 * @since 1.0.0
 */
function smntcs_google_analytics_enqueue() {
	if ( ! is_admin() && get_option( 'smntcs_google_analytics_tracking_code' ) ) {
		$tracking = get_option( 'smntcs_google_analytics_tracking_code' );
		if ( true === get_option( 'smntcs_google_analytics_ip_anonymization' ) ) {
			$anonymize = get_option( 'smntcs_google_analytics_ip_anonymization' );
			$tracking  = str_replace( "ga('send', 'pageview');", "ga('send', 'pageview'); \n ga('set', 'anonymizeIp', true);", $tracking );
		}
		print( $tracking ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
add_action( 'wp_footer', 'smntcs_google_analytics_enqueue' );
