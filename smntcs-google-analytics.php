<?php
/*
Plugin Name: SMNTCS Google Analytics
Description: Adds <a href="https://analytics.google.com/">Google Analytics</a> to your site
Author: Niels Lange
Author URI: http://www.nielslange.de
Text Domain: smntcs-google-analytics
Domain Path: /languages/
Version: 1.2.0 
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

// Define WP_CONTENT_URL
if (!defined('WP_CONTENT_URL'))
      define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
if (!defined('WP_CONTENT_DIR'))
      define('WP_CONTENT_DIR', ABSPATH.'wp-content');

// Define WP_PLUGIN_URL
if (!defined('WP_PLUGIN_URL'))
      define('WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins');
if (!defined('WP_PLUGIN_DIR'))
      define('WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins');

// Activate plugin
register_activation_hook(__FILE__, 'activate_google_analytics');
function activate_google_analytics() {
	add_option('google_analytics_tracking_code', '');
}

// Deactivate plugin
register_deactivation_hook(__FILE__, 'deactive_google_analytics');
function deactive_google_analytics() {
	delete_option('google_analytics_tracking_code');
}

// Initialize plugin
function admin_init_google_analytics() {
	register_setting('google_analytics', 'google_analytics_tracking_code');
}

// Add menu item in backend
function admin_menu_google_analytics() {
	add_options_page('Google Analytics', 'Google Analytics', 'manage_options', 'google-analytics', 'options_page_google_analytics');
}

// Add options page in backend
function options_page_google_analytics() {
	include(WP_PLUGIN_DIR.'/smntcs-google-analytics/options.php');
}

// Run main function
function google_analytics() {
    printf(get_option('google_analytics_tracking_code'));
}

// Initialize show plugin in backend
if (is_admin()) {
	add_action('admin_init', 'admin_init_google_analytics');
	add_action('admin_menu', 'admin_menu_google_analytics');
}

// Show site verification code in frontend
if (!is_admin()) {
	add_action('wp_footer', 'google_analytics');
}

// Load translation(s)
add_action('plugins_loaded', 'smntcs_ga_load_textdomain');
function smntcs_ga_load_textdomain() {
	load_plugin_textdomain( 'smntcs-google-analytics', false, false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

// Add settings link on plugin page
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'smntcs_ga_plugin_settings_link' );
function smntcs_ga_plugin_settings_link($links) {
	$settings_link = '<a href="options-general.php?page=google-analytics">' . __('Settings', 'smntcs-google-analytics') . '</a>';
	array_unshift($links, $settings_link);
	return $links;
}
