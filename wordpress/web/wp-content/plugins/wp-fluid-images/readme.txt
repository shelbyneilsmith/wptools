=== WP Fluid Images ===
Contributors: ramseyp
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9RMQ2E2LGVNJU
Tags: fluid, images, responsive 
Requires at least: 3.0
Tested up to: WordPress 3.4-beta4-20717
Stable tag: trunk

WP Fluid Images replaces the fixed width and height attributes so your images resize in a fluid or responsive design. 

== Description ==

WP Fluid Images runs when you insert an image into a Post or Page. It removes the fixed width and height attributes from the image tag. If you insert an image from the image uploader, by default, a width and height attribute is inserted into the image tag with fixed pixel values. This plugin prevents this from happening, because this can be problematic if your theme is built using responsive design methods. The plugin also adds a style tag near the end of the document that sets a max-width rule of 100%. This helps ensure that any image in a Post or Page won’t extend past the width of the Post or Page. 

If you resize an image in the Visual Editor, a new width and height attribute get added to the image. WP Fluid Images loads a jQuery script that examines the closest parent div for image tags. It calculate the image’s width as a percentage of the width of that div, removes the width and height attributes, and adds a style attribute with a width value set to the calculated percentage.

An image that is part of a WordPress gallery will have it's width attribute calculated as a percentage of its parent `.gallery-icon` element.

If you insert an image with a caption, instead of applying a style attribute with a width as a percentage to the image, the plugin will apply it to the `.wp-caption` div.

== Installation ==

1. Upload the folder `fluid-images` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= What is Fluid Images? =

Fluid Images is the concept of having images that size proportionally and smoothly as your web page's width increases or decreases. Ethan Marcotte wrote an article on the idea at A List Apart: http://www.alistapart.com/articles/fluid-images/
You can also learn more at his site: http://unstoppablerobotninja.com/entry/fluid-images/

= What is Responsive Web Design? =

Responsive Web Design is the idea of having your site's design adjust based on the width of the browser window. This allows you to create a single, adjustable design that works regardless of the size of the device, rather than building a design for desktop browsing, another for tablets, another for mobile phones, etc.

= How can I override the image widths in my theme? =

You can override the style rules by adding a more specific style in your theme's style sheet (style.css). The style added to wp_footer contains this declaration:
`img { max-width:100%; height:auto; }`

In your style sheet, add a declaration that has a parent element's tag, class, ID, or some combination, along with the `img` tag and your desired width and height.
Examples:
`body img { max-width: 90%; }`
`#content img { max-width: 99%; }

The greater specificity will override the plugin's default `img` max-width value.

== Changelog ==

= 1.1.2 =
Replaced the max-width value with 100%. Updated the Readme to include basic instructions on overriding the default img width value. Calculated percentages accurately for images that are part of a WordPress gallery. Updated the jQuery javascript to start at the `.hentry` element, rather than a `div` to take into account HTML5 elements.

= 1.1.1 =
Corrected error in the javascript. Thanks to Hans Kuijpers for catching the error.

= 1.1 =
The parent element used for calculating the width as a percentage is now .hentry, instead of .page or .post.
Detects if there is an enclosing .wp-caption div. If so, the percentage is calculated from that instead of the img tag.
Changed the style declaration that's written to wp-head to read: .hentry-img { max-width: 97%;}
Updated Paypal button code for donations.

= 1.0.1 =
Bugfix - corrected error in writing the style attribute on a resized image.
Bugfix - corrected selector to not include the body tag when selecting elements.

= 1.0 =
* Initial Release.

== Upgrade Notice ==

Initial Release.