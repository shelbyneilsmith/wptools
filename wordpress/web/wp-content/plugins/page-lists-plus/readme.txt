=== Page Lists Plus ===
Contributors: Technokinetics
Donate link: http://www.technokinetics.com/donations/
Tags: navigation, menu, page list, link text, title attribute, page title, nofollow, redirect, wp_list_pages, sliding doors
Requires at least: 2.5
Tested up to: 2.9.2
Stable tag: 1.1.8

Adds customisation options to the wp_list_pages function used to create Page menus, all controlled through the WordPress dashboard.

== Description ==

Page Lists Plus adds customisation options to the wp_list_pages function used to create Page menus, all controlled through the dashboard.

By default, links in Page lists use the Page's title as both the link text and the title attribute. Page Lists Plus allows you to specify alternative link text and title attributes to be used instead.

Page Lists Plus also allows you remove items from Page lists or just unlink them, and to add rel="nofollow" or target="_blank" to links, or redirect them to a different url.

You can also use Page Lists Plus to add a "Home" link at the start of your Page lists and/or a "Contact" link at the end, and to add class="first_item" to the first item in a Page list or span tags inside all items in a Page list to help with styling.

== Installation ==

1. Download the plugin's zip file, extract the contents, and upload them to your wp-content/plugins folder.
2. Login to your WordPress dashboard, click ”Plugins”, and activate Page Lists Plus.
3. Customise your Page links through the Write Page or Manage Page screens. You will need to save the Page for the changes to take effect.

== Frequently Asked Questions ==

= Why won't Page Lists Plus work with older versions of WordPress? =

Page Lists Plus uses the add_meta_box() function to create new fields on the Write Page and Manage Page screens. This function doesn't exist in versions of WordPress earlier than 2.5.

= Disabling links breaks my layout! =

Some themes style Page lists assuming that every list item will contain a link. On these themes, unlinking an item will cause styling problems. If you know CSS, then you may be able to fix the styling by editing your style.css theme file. If not, then as a fall-back enable the "Unlink using javascript" option on the Settings > Page Lists Plus page in the dashboard.

= Will Page Lists Plus work with WordPress MU? =

No. At the moment, Page Lists Plus is not WPMU compatible.

== Screenshots ==

1. The Settings > Page Lists Plus page.
2. The Page Lists Plus box on a Page edit screen.