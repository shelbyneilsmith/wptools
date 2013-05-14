=== WP Retina 2x ===
Contributors: TigrouMeow
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JAWE2XWH7ZE5U
Tags: retina, iphone, macbookpro, apple, images, admin, attachment, media, files
Requires at least: 3.5
Tested up to: 3.5
Stable tag: 0.9.6

Make your website look beautiful and smooth on Retina (high-DPI) displays.

== Description ==

This plugin creates the image files required by the Retina (high-DPI) displays and it displays them to your visitors accordingly. Your website will now look beautiful and smooth on every device.

It handles two different methods to serves the images to your visitors. Pick the one that works best with your hosting and environment. Support was added for WordPress Multi-site.

== Changelog ==

= 0.9.6 =
= Fix: warnings when uploading/replacing an image file.

= 0.9.4 =
* Fix: esthetical issue related to the icons in the Retina dashboard.
* Fix: warnings when uploading/replacing an image file.

= 0.9.2 =
* Changed: Media Replace is not used anymore, the code has been embedded in the plugin directly.

= 0.9 =
* Fix: code cleaning.
* Fix: no more notices in case there are weird/unsupported/broken image files.

= 0.8 =
* Fix: Works with WP 3.5.

= 0.4.2 =
* Updated: to the new version of Retina.js (client-method).
* Fix: updated rewrite-rule (server-method) that works with multi-site.

= 0.4 =
* Fix: support for Network install (multi-site). Thanks to Jeremy (Retina-Images).

= 0.3.4 =
* Changed: Retina.js updated to its last version (should be slighlty faster).
* Changed: Retina-Images updated to its last version (now handles 404 error, yay!).
* Fix: using a Retina display, the Retina Dashboard was not looking very nice.
* Fix: the "ignored" media for retina are handled in a better way.
* Changed: the FAQ was improved.

= 0.3.0 =
* Fix: was not generating the images properly on multisite WordPress installs.
* Added: warning message if using the server-side method without the pretty permalinks.
* Added: warning message if using the server-side method on a multisite WordPress install.
* Changed: the client-method (retina.js) is now used by default.

= 0.2.9 =
* Fix: in a few cases, the retina images were not generated (for no apparent reasons).

= 0.2.8 =
* Fix: the retina image was not being generated if equal to the resolution of the original image.
* Added: optimization and enhancement of the issues management.
* Added: a little counter icon to show the number of issues.
* Added: an 'IGNORE' button to hide issues that should not be.

= 0.2.6 =
* Fix: simplified version of the .htaccess directive.
* Fix: new version of the client-side method (Retina.js), works 100x faster.

= 0.2.4 =
* Fix: SQL optimization & memory usage huge improvement.

= 0.2.2 =
* Fix: the recommended resolution shown wasn't the most adequate one.
* Fix: in a few cases, the .htaccess wasn't properly generated.
* Fix: files were renamed to avoid conflicts.
* Added: paging for the Retina Dashboard.
* Added: 'Generate for all files' handles and shows if there are errors.

= 0.2.1 =
* Removed 'error_reporting' (triggers warnings and notices with other plugins).
* Fix: on uninstall/disable, the .htaccess will be updated properly.

= 0.2 =
* Added: the Retina Dashboard.
* Added: can now generate Retina files in bulk.
* Fixed: the cropped images were not 'cropped'.
* Added: The Retina Dashboard and the Media Library's column can be disabled via the settings.
* Fix: resolved more PHP warning and notices.

= 0.1.8 =
* Fix: resolved PHP warnings and notices.

= 0.1.6 =
* Changed: simplified the code of the server-side method.

= 0.1.4 =
* Fixed: the wrong resolution was displayed in the Retina column of the Media Manager.

= 0.1 =
* Very first release.

== Installation ==

Quick and easy installation:

1. Upload the folder `wp-retina-2x` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Check the settings of WP Retina 2x in the WordPress administration screen.
4. Check your Media Library where you can find the new 'Retina' column.
5. Check the Retina Dashboard.
6. Read the tutorial about the plugin on <a href='http://www.totorotimes.com/news/retina-display-wordpress-plugin'>Totoro Times</a>.

== Frequently Asked Questions ==

= What does this plugin do? =
It creates the image files required by the Retina devices. In the case the resolution of the original images are not high enough, you will see a warning in the Media Library where you will be able to re-upload bigger images. The plugin then recognizes different devices and send the images required accordingly.

= What are those new images? =
The new images use the same name as your original files, with an "@2x" string added right before the extension. For example, if you have a Gundam-150x150.jpg file, a new Gundam-150x150@2x.jpg will be created. Its size will be doubled. This naming convention actually comes from Apple.

= Can I create all the Retina images at once for my whole Media Library? =
Yes, check the Retina Dashboard screen (under the Media menu).

= I don't have a Retina device, how can I check whether it works or not? =
Go to the closest Apple Store and try it out! More seriously, you can check the "Debug" option in the plugin settings. Then your blog will always behave as if the client is using a Retina Display.

= Does it work for other High-DPI devices? =
I tried it on a few High-DPI mobile devices and it works fine.

= I use a Responsive (or another kind of) theme, but the logo I uploaded is not displayed as Retina, why? =
The plugin can transform the images that go through the WordPress API and the 'Image Sizes' properly. Themes often uses a one-time customized size for the logo, and for that reason the image wouldn't be taken care of by the plugin. The easiest way to go around this is to create the Retina image by yourself. For example, if you are logo is 200x100 and named 'logo.png', upload a 400x200 version of that logo named 'logo@2x.png' next to the other one. It should them work immediately.

= My logo / images appeared twice bigger on Retina, and blurry! =
Let's say you have a logo which is 200x400. The retina logo would be 400*800, but it should STILL be shown as a 200x400 image relatively to the rest of your website. The workaround is to keep it simple and neat: always set the (normal) width and the height for all your images (in HTML directly or via CSS).

= I am using a slideshow / sliders plugin, and I have scaling issues! =
That is unfortunately one of the main issues to expect with all this "Retina" technology thing. It is not related to WP Retina 2x at all and the person that can help you the best is the developer of the slideshow/sliders plugin. Of course if I can do something to help or enhance WP Retina 2x is some way I will definitely do it. 

= It doesn't work, what should I check? =
* Are the images created? Check the Retina Dasboard (under Media).
* Are you using an "Image Size" in your posts that is NOT "Full Size"? The plugin generates Retina images for all your images except (obviously) the "Full Sizes" and the ones you opted-out in the Settings.
* Are you using Cloudflare? The Cloudflare cache is too "powerful" at the moment, so please set the plugin to use the Client-side method.

= It's not working with multisite + subdomains + the server-method, what can I do? =
Jeremy the creator of "Retina-Images" helped me with this issue. Thanks to him, it nows work perfectly since WP Retina 2x 0.4! Although you will have to do edit the .htaccess file by yourself, and to add the RewriteRule "^files/(.+) wp-content/plugins/wp-retina-2x/wr2x_image.php?ms=true&file=$1 [L]" as the first RewriteRule.

= It still doesn't work! =
Create a new support thread <a href='http://wordpress.org/support/plugin/wp-retina-2x'>here</a> or contact me directly, and always send me a screenshot copy of your "Image Sizes" settings in Settings -> Media, and another screenshot of your Retina Dashboard. I will do my best to help you.

= This plugin is cool, how can I thank you? =
Thanks for asking! :p Please visit Totoro Times (http://www.totorotimes.com), and please talk about this plugin and this website to your friends :) That would definitely be cool. You can also make a donation, that already happened and got me very surprised, and I will send you a postcard from Japan if you like ^^

= I still don't understand a thing! =
Please check my tutorial and introduction to Retina Displays on <a href='http://www.totorotimes.com/news/retina-display-wordpress-plugin'>Totoro Times</a>.

= Can I contact you? =
Yes, sure, you can! But since the plugin got popular, I get many emails everyday which consume almost 10% of my whole lifetime (not kidding! + it's rarely issues coming from the plugin itself). So now I ask you to visit my website <a href='http://www.totorotimes.com'>Totoro Times</a>, pick a page you like, and share it on Facebook, Twitter or your own website. I hope you understand :) Thanks a lot!

== Screenshots ==

1. A new column in the Media Library.
2. Basic Settings
3. Advanced Settings
4. Retina Dashboard

== Wishlist ==

Do you have suggestions? Feel free to contact me at http://www.totorotimes.com.