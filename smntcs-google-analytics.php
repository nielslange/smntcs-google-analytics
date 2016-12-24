<?php
/*
Plugin Name: SMNTCS Google Analytics
Description: Adds <a href="https://analytics.google.com/">Google Analytics</a> to your site
Author: Niels Lange
Author URI: http://www.nielslange.de
Text Domain: smntcs-google-analytics
Domain Path: /languages/
Version: 2.0.1
*/

/*  Copyright 2014-2016	Niels Lange (email : info@nielslange.de)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Avoid direct plugin access
if ( !defined( 'ABSPATH' ) ) exit;

// Load text domain
add_action('plugins_loaded', 'smntcs_google_analytics_load_textdomain');
function smntcs_google_analytics_load_textdomain() {
	load_plugin_textdomain( 'smntcs-google-analytics', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

// Add Adobe Typekit Fonts to WordPress Customizer
add_action( 'customize_register', 'smntcs_google_analytics_register_customize' );
function smntcs_google_analytics_register_customize( $wp_customize ) {
	$wp_customize->add_section( 'smntcs_google_analytics_section', array(
			'priority' 	=> 150,
			'title' 	=> __('Google Analytics', 'smntcs-google-analytics'),
	));

	$wp_customize->add_setting( 'smntcs_google_analytics_tracking_code', array(
			'type'		=> 'option',
	));

	$wp_customize->add_control( 'smntcs_google_analytics_tracking_code', array(
			'label' 	=> __('Google Analytics tracking code', 'smntcs-google-analytics'),
			'section' 	=> 'smntcs_google_analytics_section',
			'type' 		=> 'textarea',
	));

	$wp_customize->add_setting( 'smntcs_google_analytics_ip_anonymization', array(
			'default' 	=> false,
			'type'		=> 'option',
	));

	$wp_customize->add_control( 'smntcs_google_analytics_ip_anonymization', array(
			'label' 	=> __('IP Anonymization', 'smntcs-google-analytics'),
			'section' 	=> 'smntcs_google_analytics_section',
			'type' 		=> 'checkbox',
	));
}

// Add settings link on plugin page
add_filter("plugin_action_links_" . plugin_basename(__FILE__), 'smntcs_ga_plugin_settings_link' );
function smntcs_ga_plugin_settings_link($links) {
	$admin_url = admin_url( 'customize.php?autofocus[control]=smntcs_google_analytics_tracking_code' );
	$settings_link =  '<a href="' . $admin_url . '">' . __('Settings', 'smntcs-google-analytics') . '</a>';
	array_unshift($links, $settings_link);
	return $links;
}

// Load Adobe Typekit Fonts code and custom CSS
add_action('wp_footer', 'smntcs_google_analytics_enqueue');
function smntcs_google_analytics_enqueue() {
	if ( !is_admin() && get_option('smntcs_google_analytics_tracking_code') ) {
		$tracking = get_option('smntcs_google_analytics_tracking_code');
		if ( get_option('smntcs_google_analytics_ip_anonymization') == true ) {
			$anonymize = get_option('smntcs_google_analytics_ip_anonymization');
			$tracking = str_replace("ga('send', 'pageview');", "ga('send', 'pageview'); \n ga('set', 'anonymizeIp', true);", $tracking);
		}
		print($tracking);
	}
}