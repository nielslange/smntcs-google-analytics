=== SMNTCS Google Analytics ===

Contributors:       nielslange
Tags:               Google Analytics, Tracking, IP Anonymization, Anonymize IP
Stable tag:         2.8
Tested up to:       6.1
Requires PHP:       5.6
Requires at least:  5.5
License:            GPL v2 or later
License URI:        https://www.gnu.org/licenses/gpl-2.0.html

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

= 2.8 (2022.12.03) =

- Test up to 6.1

= 2.7 (2022.05.09) =

- Test up to 6.0

= 2.6 (2021.04.27) =
- Test up to 5.8
- [Add e2e tests](https://github.com/nielslange/smntcs-google-analytics/issues/2)

= 2.5 (2021.04.27) =
- Test up to 5.7
- [Add build tools](https://github.com/nielslange/smntcs-google-analytics/issues/9)
- [Add GitHub Actions](https://github.com/nielslange/smntcs-google-analytics/issues/10)

= 2.4 (2019.12.21) =
- Test up to 5.3
- Add build tools

= 2.3 (2019.06.28) =
- Test up to 5.2

= 2.2 (2019.06.28) =
- Test up to 5.1

= 2.1 (2016.12.24) =
- Add FAQ

= 2.0 (2016.09.11) =
- Use Customizer instead of options page

= 1.4 (2016.07.20) =
- Add donation link

= 1.3 (2016.07.20) =
- Update textdomain

= 1.2 (2016.07.20) =
- Fix tracking code visibility

= 1.1 (2016.07.20) =
- Fix plugin title

= 1.0 (2016.07.20) =
- Initial release
