=== ShortPixel Critical CSS ===
Contributors: shortpixel
Donate link: https://www.paypal.me/resizeImage
Tags: critical css, optimize, above the fold, speed up, SEO
Requires at least: 4.7
Requires PHP: 5.6
Tested up to: 6.6
Stable tag: 1.0.5
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Critical CSS plugin by ShortPixel to speed up your website. Easy to use, works on any website.

== Description ==

With ShortPixel Critical CSS plugin, your website can automatically generate above-the-fold CSS for your web pages.
This means your website will **load faster** and **get better scores** with online testing tools like PageSpeed Insights or GTmetrix.

**IMPORTANT NOTICE: Plugin closure!**
<strong>We would like to inform you that the ShortPixel Critical CSS plugin and criticalcss.co service will be closed starting December 1st, 2024, and will no longer be available.</strong>

The Critical CSS functionality has now been integrated into the <a href="https://wordpress.org/plugins/fastpixel-website-accelerator/" target="_blank">FastPixel Caching plugin</a>, and we highly recommend transitioning to this new plugin as soon as possible to ensure continued functionality and support.

If you have any questions, please feel free to contact us at <a href="mailto:help@shortpixel.com">help@shortpixel.com</a>.

**How it works?**

* ShortPixel's Critical CSS (CCSS) plugin uses our brand new service to generate the critical CSS for your website's pages.
* The generated CCSS is inserted into the web pages while the original .css files are deferred. This makes the pages load faster.
* The plugin starts generating the CCSS for each visited page and retrieves it from the ShortPixel Critical CSS Service. This is done using WP CRON jobs that run in the background without user intervention and without slowing down the website.
* The edited pages will have the CCSS automatically generated.

**Features**

* The CCSS plugin can be configured to keep Critical CSS rules based on the page URL or for each page template. This can help optimize the number of CCSS files needed.
* Additional flexibility: the website administrator can manually configure additional Critical CSS rules to be included in the generated Critical CSS.
* Our plugin integrates with WP Rocket and Elementor, if they are present, in order to leverage the cache support and deliver Critical CSS more effectively.

The plugin was forked from the <a href="https://wordpress.org/plugins/wp-criticalcss/"> WP Critical CSS</a> plugin, modified to use ShortPixel's Critical CSS service and enhanced with new features.

Currently, the plugin while in its BETA version, is 100% free to use. Just install it on your website, configure it and test the results with a tool like [Google PageSpeed Insights](https://pagespeed.web.dev/) or [GTMetrix](https://gtmetrix.com/)

For questions or support, please contact us directly [here](https://shortpixel.com/contact)

**Other plugins by ShortPixel**

* [FastPixel Caching](https://wordpress.org/plugins/fastpixel-website-accelerator/) - WP Optimization made easy
* [ShortPixel Image Optimizer](https://wordpress.org/plugins/shortpixel-image-optimiser/) - Image optimization & compression for all the images on your website, including WebP & AVIF delivery
* [ShortPixel Adaptive Images](https://wordpress.org/plugins/shortpixel-adaptive-images/) - On-the-fly image optimization & CDN delivery
* [Enable Media Replace](https://wordpress.org/plugins/enable-media-replace/) - Easily replace images or files in Media Library
* [reGenerate Thumbnails Advanced](https://wordpress.org/plugins/regenerate-thumbnails-advanced/) - Easily regenerate thumbnails
* [Resize Image After Upload](https://wordpress.org/plugins/resize-image-after-upload/) - Automatically resize each uploaded image
* [WP SVG Images](https://wordpress.org/plugins/wp-svg-images/) - Secure upload of SVG files to Media Library

== Installation ==

Just search for "ShortPixel Critical CSS" in the plugin section of your website and install it as you would do with any other plugin.

== Frequently Asked Questions ==

= Is this plugin free? =

As long as the plugin is in the BETA testing phase, it is completely free to use.

= How can I report a problem? =

Go to [our contact page](https://shortpixel.com/contact).

= Does this work inside paywalls or membership websites/pages? =

Not at this time. Since ShortPixel.com cannot currently access protected websites, the webpage must be publicly visible to work. Depending on demand, we may add a feature to allow use on protected websites/pages as well.

= What happens if I update the site content or change my theme? =

The plugin's css cache is automatically purged for that post or term, and queued again the next time the user requests it.

= What happens when I update a plugin or theme? =

The entire cache is flushed, regardless of the purge setting.

= Does this support all caching plugins? =

Currently only WP-Rocket is supported. Others can be added as integrations upon request.

= Which host is supported? =

In general, any host. Some hosts like WPEngine provide special support for server cache cleanup.

= What does the '/nocache/' in the queued URLs mean? =

This is used as a special version of the web page that forcibly disables supported caching and minify plugins to ensure critical CSS is created without complications. From an SEO perspective, these URLs are safe because they are not referenced anywhere and Google cannot crawl them.

= Where do I report security bugs found in this plugin? =
Please report security bugs found in the source code of the ShortPixel Critical CSS plugin through the [Patchstack Vulnerability Disclosure Program](https://patchstack.com/database/vdp/shortpixel-critical-css). The Patchstack team will assist you with verification, CVE assignment, and notify the developers of this plugin.

== Screenshots ==

1. Settings page (Settings > ShortPixel Critical CSS)

2. Processed pages log (Settings > ShortPixel Critical CSS > Processed log tab)


== Changelog ==

= 1.0.5 =
Release date: September 20, 2024
* Added the notification about the plugin closure on December 1st, 2024.

= 1.0.4 =
Release date: April 29, 2024
* Tweak: Added a "Remove Expired" button to clear the processed log of entries older than 30 days;
* Fix: Updated the text domain of the plugin to correct internationalization;
* Language: 3 new strings added, 1 updated, 0 fuzzed and 0 deprecated.

= 1.0.3 =
Release date: April 8, 2024
* Fix: Patched a Broken Access Control vulnerability, found by the PatchStack team (thanks!);
* Fix: Increased the overall security of the plugin by adding sanitization, nonce check and authorization.
* Language: 0 new strings added, 0 updated, 0 fuzzed, and 0 deprecated.

= 1.0.2 =
Release date: January 18, 2024
* Fix inlining style that contains "\0" escape sequences, eg. content: "\00a0";

= 1.0.1 =
Release date: September 28, 2023
* New: added a note that the website must be visited for the plugin to generate the critical CSS;
* Fix: fully tested with PHP 8.1 & 8.2, no more deprecation warnings;
* Fix: a fatal error was triggered with PHP 5.6 and older WordPress versions due to a missing function;
* Fix: a critical error was thrown when used with WP Rocket on WP Engine;
* Language: 0 new strings added, 1 updated, 0 fuzzed, and 0 deprecated.

= 1.0.0 =
Release date: March 15, 2023
* New: Added support for generating Critical CSS per post type (including custom post types);
* New: When you change the theme, the Critical CSS cache is automatically purged;
* New: Added a button in the settings to clear the CSS cache;
* New: Added the "Delete" action for the API Queue;
* New: Actions similar to those for the API queue have been added for the WebCheck queue;
* New: API key detection when using other ShortPixel plugins;
* New: added help contact form for easier support requests;
* Tweak: Improved the appearance of the generated CSS in the Processed Log pop-up;
* Tweak: When selecting cache methods for WordPress templates or Custom Post Types, all suboptions are enabled by default;
* Fix: Various improvements to the WebCheck and API queues, as well as the Processed Log;
* Fix: Some links were getting a double `nocache` at the end, resulting in a 404 when trying to generate the Critical CSS;
* Fix: Caching settings are no longer lost after switching themes;
* Fix: WP Cron notification can now be dismissed;
* Fix: Updated the texts and improved the general appearance of the plugin settings page;

= 0.9.10 =

* Fix warning when Fallback CSS not set

= 0.9.9 =

* Initial version
