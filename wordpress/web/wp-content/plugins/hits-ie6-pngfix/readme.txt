=== HITS- IE6 PNGFix ===
Contributors: wpgwiggum
Tags: images, plugin, formatting, image, style, compatability, transparency
Donate Link: http://www.itegritysolutions.ca/community/wordpress/ie6-png-fix
Requires at least: 2.7
Tested up to: 3.4.1
Stable tag: 3.5.3

Adds IE6 Compatability for PNG transparency, courtesy of multiple choices for PNG fixes available

== Description ==

Upon installation and activation, this plugin will add the necessary code to your pages to take advantage of the approaches to getting the IE6 PNG Transparency issue solved.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload folder `hits-ie6-pngfix` to the `/wp-content/plugins/` directory.
1. Set the `/hits-ie6-pngfix/` folder to be writeable by the web server.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Optionally select the PNG Fix methods you wish to use.
1. Test and enjoy!

== Frequently Asked Questions ==

= Is this your first plugin? =

Yes, this is my first plugin. If you have any feedback, please visit my site!

= How can I help? =

You can help the plugin and other users by using the translation template file and providing translations in other languages. If you would like to help, visit my website and contact me!

= Why doesn't the plugin work with my site? =

After troubleshooting a few sites, there are usually a couple things to look for in your rendered HTML in IE6.
1. Make sure your CSS is applied prior to this plugin's code in your HEAD tags.
1. Make sure you have the correct CSS selectors defined (if applicable)
1. Check to see how the image is applied in CSS. I don't know how picky the fixes are.

= There are many options to choose from, which is the best? =

Unfortunately there isn't a single best PNG Fix method, otherwise everyone would be using it! Depending on how you have constructed your site, any of the fix methods offered can be the best for your situation. It might take a little testing, but you will find which one works best for you.

== Screenshots ==

1. This is the settings page. Pretty simple.
2. These are the various options you can select. After clicking save you are done!

== Upgrade Notice ==

= 3.5.3 =
* Minor performance increase

= 3.5.1 =
* Content over SSL fixed, further cleaning of code

= 3.4 =
* Removed custom Upgrade Text code, optimized performance

== Changelog ==

= 3.5.3 =
* Updates supported WordPress Version Number
* Minor performance increase
* [Updated September 24, 2012]

= 3.5.1 =
* Split the admin page from main php file to clean up code
* Fixed 3rd argument of add_options_page call into wordpress
* Delivers css and js with protocol relative URLs
* [Updated July 6, 2011]

= 3.4 =
* Removed custom Upgrade Text code. Will implement through readme
* [Updated April 16, 2011]

= 3.3.2 =
* Improved in-code documentation
* Updated readme document
* Optimized hooks into wordpress
* [Updated April 16, 2011]

= 3.3.1 =
* Location of clear.gif was not being set when plugin is installed, only when settings saved
* [Updated February 23, 2011]

= 3.2.1 =
* Fixed Supersleight method as the transparent gif did not have proper path to plugin
* Simplified how the clear image is being used, reducing files in plugin
* [Updated January 4, 2011]

= 3.1.5 =
* Added Portuguese Brazilian translation thanks to Gervásio A.
* Updated the Translation Template file hits-ie6-pngfix.pot to have all text and updated code line numbers for easier searching
* [Updated August 3, 2010]

= 3.1.4 =
* Fixed a problem with IE7 and 8 client side detection code
* [Updated July 16, 2010]

= 3.1.3 =
* Extra check to ensure that the Update Text doesn't appear if plugin is current (sorry about this)
* [Updated July 11, 2010]

= 3.1.2 =
* Fixed internal versioning so that the Update Text doesn't always appear
* [Updated June 22, 2010]

= 3.1.1 =
* Clarified option name for Server and Client side detection with a note
* [Updated June 12, 2010]

= 3.1.0 =
* Added support for pages that are cached
* [Updated June 12, 2010]

= 3.0.2 =
* Tested for WordPress 3.0
* [Updated May 12, 2010]

= 3.0 =
* French localization added, courtesy of Benoit
* Added a plugin Debug mode, providing more details via HTML comments for troubleshooting
* [Updated February 26, 2010]

= 2.9 =
* Fixed logic issue in code that handles upgrading the plugin version
* Proprty file for saving path of the plugin for .htc now attempted to write more often
* [Updated December 27, 2009]

= 2.8 =
* Added ability to show what has changed in the latest release right in the Plugin Listings
* Tweaked regex for the IE detection and case sensitivity
* [Updated December 18, 2009]

= 2.7 =
* Gave appropriate credit to SuperSleight creator
* Updated FAQ
* [Updated October 20, 2009]

= 2.6 =
* Changed IE6 detection method to rely on PHP code rather than HTML checks. Increases reliability of correctly making detection.
* [Updated September 19, 2009]

= 2.5 =
* Fixed UnitPNG and SuperSleight so that there wasn't 2 IE version checks resulting in there being bad output at the top of page for IE7
* Added DD_belatedPNG as another PNG fix method
* [Updated August 18, 2009]

= 2.4 =
* Added support for internationalization.
* Added screen shots for WordPress plugin page.
* Added HTML conditional statement to help in validation.
* [Updated August 14, 2009]

= 2.3 =
* Added basic handling if the properties file is not writeable.
* Added new code to better handle the upgrading of the plugin.
* [Updated August 2, 2009]

= 2.2 =
* Added SuperSleight as another PNG fix method
* Fixed the TwinHelix methods for servers that don't like the .htc file type
* The plugin will save the location of the blank.gif absolute URL into a property file for browsers to be able to find it all the time.
* Added simple html files to prevent directory access for servers that have it on
* [Updated July 24, 2009]

= 2.1 =
* Added ability to specify the CSS selector for the twinHelix methods
* [Updated July 19, 2009]

= 2.0 =
* Added ability to select from a list of PNG Fix methods
1. Twin Helix v1.0
1. Twin Helix v2.0 Alpha
1. Unit PNG Fix
* [Updated July 18, 2009]

= 1.2 =
* Tweaked the echo of the path for the javascript include file.
* [Updated July 17, 2009]

= 1.1 =
* Removed un-necessary files from the plugin directory
* [Updated July 15, 2009]

= 1.0 =
* First version
* [Created July 10, 2009]