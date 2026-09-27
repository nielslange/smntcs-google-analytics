=== SMNTCS Google Analytics ===

Contributors:       nielslange
Tags:               google analytics, analytics, gtag, tracking, statistics
Requires at least:  5.5
Tested up to:       7.1
Requires PHP:       7.4
Stable tag:         3.3
License:            GPL v2 or later
License URI:        https://www.gnu.org/licenses/gpl-2.0.html

Adds Google Analytics to your site with just your measurement ID or the full tracking code, plus optional IP anonymisation.

== Description ==

SMNTCS Google Analytics adds [Google Analytics](https://analytics.google.com/) tracking to every page of your site.

In the Customizer you can either enter your measurement ID, for example `G-XXXXXXXXXX`, or paste the full tracking code that Google Analytics gives you. When you enter an ID, the plugin loads the official gtag.js script for you.

= Features =

* Enter a GA4 measurement ID or paste the full tracking code
* Loads gtag.js asynchronously so it does not slow down your pages
* Optional IP anonymisation

== Installation ==

1. Upload `smntcs-google-analytics` to the `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress
3. Go to https://www.google.com/analytics/, add a new site and copy the tracking code
4. Go to `Appearance → Customize → Google Analytics` and paste your tracking code
5. Anonymize visitors IP address if necessary

== Frequently Asked Questions ==

= Why am I not able to save the verification code? =

This issue might be caused by a security plugin. If you use a security plugin, e.g. Wordfence, then disable it to save your verification code and activate it once you’re done.

= Where do I find my measurement ID? =

In Google Analytics, go to Admin, then Data streams, and open your web stream. The measurement ID starts with G-.

= Why am I not able to save the tracking code? =

A security plugin such as Wordfence may block script code in the Customizer. Enter only your measurement ID instead, or pause the security plugin while you save.

== Screenshots ==

1. Paste your Google Analytics tracking code in the customizer

== Changelog ==

= 3.3 (2026.09.27) =

- Remove duplicated FAQ entries from the readme

= 3.2 (2026.09.26) =

- Test up to WordPress 7.1
- Update development dependencies and GitHub Actions
- Accept a measurement ID such as G-XXXXXXXXXX and load gtag.js for it, instead of printing the ID on the page

= 3.1 (2023.10.30) =
- Test up to WordPress 6.7

= 3.0 (2023.10.22) =

- Test up to WordPress 6.6
- Migrate from Cypress to Playwright

= 2.9 (2023.10.15) =

- Test up to WordPress 6.4

= 2.8 (2022.12.03) =

- Test up to WordPress 6.1

= 2.7 (2022.05.09) =

- Test up to WordPress 6.0

= 2.6 (2021.04.27) =
- Test up to WordPress 5.8
- [Add e2e tests](https://github.com/nielslange/smntcs-google-analytics/issues/2)

= 2.5 (2021.04.27) =
- Test up to WordPress 5.7
- [Add build tools](https://github.com/nielslange/smntcs-google-analytics/issues/9)
- [Add GitHub Actions](https://github.com/nielslange/smntcs-google-analytics/issues/10)

= 2.4 (2019.12.21) =
- Test up to WordPress 5.3
- Add build tools

= 2.3 (2019.06.28) =
- Test up to WordPress 5.2

= 2.2 (2019.06.28) =
- Test up to WordPress 5.1

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
