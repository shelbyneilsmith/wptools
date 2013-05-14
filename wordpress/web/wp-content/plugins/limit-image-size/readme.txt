=== Limit Image Size ===
Contributors: cantuaria
Donate link: http://cantuaria.net.br/limit-image-size/
Tags: image, resize, limit, size, megapixel
Requires at least: 2.7.0
Tested up to: 3.4
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Limit Image Size will save space in disk and bandwith resizing large images when you upload them to WordPress.

== Description ==

Most users like to upload their fresh shotted pictures to WordPress directly from their digital camera, and what happens? Full disk, reach bandwith limit and slowdown the site with heavy images.

Limit Image Size is a smart plugin wich will limit the megapixel an image can have. When you upload an image, plugin will check if it have more megapixels than you limited, if so, the plugin will automatically resize the image to have that megapixel. This will save space in disk, site's bandwith and will make your site faster.

Limit Image Size works with 3 methods to resize, not all of them will be enabled on your site but the plugin will choose the best one available for you. The 3 methods are:

*	ImageMagick - The best method with the best performance, but requires that your host have installed the ImageMagick extension on your server.
*	WebService - This method sends a copy of your image to a webservice which will resize it and sends it back to your site. It's not the fastest way but is a good one for limited sites.
*	GD - This method is native to PHP but demands a lot of processing from your server. The plugin will use it only if no other method is available.

So, there is no cons to Limit Image Size. Just install it and you will never more need to care about the size of your pictures.

== Installation ==

1. Upload the plugin directory `limit-image-size` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure it at the Media menu in WordPress

== Frequently Asked Questions ==

= Will the quality of images be sacrified? =

No. In fact, you can also choose the quality of the final image, but it will not get this option everytime. When the options is ignored, the plugin will maintain the same quality.

= What's the ideal megapixel setting? =

We recommend no more than 1.5 megapixel for images. If your image have a square format, with 1 megapixel it will have the dimensions of 1.536px x 1.536px. Most users use monitors with less than 1.440 pixels wide, so with 1.5 megapixel your image will still be larger than the resolution of mosts users.

= Why can't every site use ImageMagick? =
Any site can use ImageMagick, but it must first be installed by your site's server. You can check if your server have ImageMagick installed in plugion options section at the menu Media.

= I got a Fatal Error message when uploading images after activating your plugin. What should I do? =
If a Fatar Error is displayed is because the site doesn't have enough memory to resize images. We have 4 recommendations in this case:
*	Ask your host to install ImageMagick which demands much less memory.
*	Try using the WebService, activating it's option at the menu Media.
*	If you're trying resize a PNG image disable the option Resize PNG images. PNG images uses a lot more memory than JPG images.
*	Ask your host to allow your site use more memory.

== Screenshots ==

1. Options page for Limit Image Size
2. Limit Image Size in Image description

== Changelog ==

= 1.0 =
* Limit Image Size now is fully compatible with MultiSite.
* Fixed the math calculation when resizing an image higher than wider.
* Fixed an issue which was informing a incorrect file size.

= 0.9 =
* First Public Version

== Upgrade Notice ==

= 1.0 =
* Limit Image Size now is fully compatible with MultiSite.
* Fixed the math calculation when resizing an image higher than wider.
* Fixed an issue which was informing a incorrect file size.

= 0.9 =
* First Public Version