<?php
/**
 * Plugin Name:           SMNTCS Google Analytics
 * Plugin URI:            https://github.com/nielslange/smntcs-google-analytics/
 * Description:           Adds <a href="https://analytics.google.com/">Google Analytics</a> to your site.
 * Author:                Niels Lange
 * Author URI:            https://nielslange.de
 * Text Domain:           smntcs-google-analytics
 * Version:               2.9
 * Requires PHP:          5.6
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
		add_action( 'wp_footer', array( $this, 'enqueue' ) );
	}

	/**
	 * Register customizer settings.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer instance.
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

	/**
	 * Add settings link to plugin list.
	 *
	 * @param array $url Array of links.
	 *
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
	 */
	public function enqueue() {
		if ( ! is_admin() ) {
			$tracking = get_option( 'smntcs_google_analytics_tracking_code' );

			if ( $tracking ) {
				if ( true === get_option( 'smntcs_google_analytics_ip_anonymization' ) ) {
					$tracking = str_replace(
						"ga('send', 'pageview');",
						"ga('send', 'pageview'); \n ga('set', 'anonymizeIp', true);",
						$tracking
					);
				}
				echo $tracking; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}

}

new SMNTCS_Google_Analytics();
