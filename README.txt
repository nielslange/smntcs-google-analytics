=== SMNTCS Google Analytics ===
 
Contributors: nielslange
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=KFV2UW8YGYNAE
Tags: Google Analytics, Tracking, IP Anonymization, Anonymize IP
Version: 2.5
Tested up to: 5.7
Requires at least: 5.5
Requires PHP: 7.0
License: GPLv2+
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html

Adds Google Analytics tracking code to your site and anonymize visitors IP address if necessary.

== Description ==

> <strong>Google Analytics</strong><br>
> Google Analytics is one of the best tracking systems available. It allows you to analyze how you visitors found you, via which pages they enter your site, via which pages they leave your site and which pages they visit during their session. 

= SMNTCS Google Analytics =
SMNTCS Google Analytics enables you to add the Google Analytics tracking code to your website. 

= IP Anonymization =
Since version 2.0 it's possible to anonymize the IP of your visitor, which is required by law in some countries.    

== Installation ==

1. Upload `smntcs-google-analytics` to the `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress
3. Go to https://www.google.com/analytics/, add a new site and copy the tracking code
4. Go to `Appearance → Customize → Google Analytics` and paste your tracking code
5. Anonymize visitors IP address if necessary

== Frequently Asked Questions ==

= Why am I not able to save the verification code? =

This issue might be caused by a security plugin. If you use a security plugin, e.g. Wordfence, then disable it so save your verification code and activate it once you’re done.

== Screenshots ==

1. Paste you Google Analytics tracking code in the customizer

== Changelog ==

= 2.5 =
* [Test up to 5.7](https://github.com/nielslange/smntcs-google-analytics/issues/11)
* [Add build tools](https://github.com/nielslange/smntcs-google-analytics/issues/9)
* [Add Add GitHub Actions](https://github.com/nielslange/smntcs-google-analytics/issues/10)

= 2.4 =
* Test up to 5.3
* Add build tools

= 2.3 =
* Test up to 5.2

= 2.2 =
* Test up to 5.1

= 2.1 =
* Add FAQ

= 2.0 =
* Use Customizer instead of options page

= 1.4 =
* Add donation link

= 1.3 =
* Update textdomain

= 1.2 =
* Fix tracking code visibility

= 1.1 =
* Fix plugin title

= 1.0 =
* Initial release
