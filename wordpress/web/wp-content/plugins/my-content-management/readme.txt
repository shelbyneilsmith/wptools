=== My Content Management ===
Contributors: joedolson
Donate link: http://www.joedolson.com/donate.php
Tags: custom post types, post types, faq, testimonials, staff, glossary, sidebars, content management
Requires at least: 3.2.1
Tested up to: 3.4.2
License: GPLv2 or later
Stable tag: trunk

Creates a set of common custom post types for advanced content management: FAQ, Testimonials, people (staff, contributors, etc.), and others!
 
== Description ==

My Content Management creates a suite of custom post types, each with an appropriate custom taxonomy and a set of commonly needed custom fields. The purpose of the plug-in is to provide a single common interface to create commonly needed extra content tools. 

Almost every web site I work on requires some kind of special content: testimonials, frequently asked questions, lists of staff -- you name it. There are plug-ins available for almost all of these - but they're all different. Different interfaces, different ways to display information, different default styling for how they're shown on the page. 

I wrote this plug-in so that I have all of these features available to me in a single installation: every one with the same interface, with common methods for displaying on a site. Each custom post type also includes a few commonly used custom fields available in templates. (e.g., a phone number field for listings of staff members.)

There's no default styling outside of whatever your theme offers for the elements used. There is default HTML, but it can be 100% replaced through the included templating system, or by creating your own theme template documents to display these specific content types. 

There's a [User's Guide available for purchase](http://www.joedolson.com/articles/my-content-management/guide/) offering 20 pages of detailed information on how to set up, use, and customize My Content Management.

All content can be displayed using the shortcode [my_content type='custom_post_type']. Other supported attributes include:

* type (single or comma-separated list of types)
* display (custom, full, excerpt, or list)
* taxonomy (slug for associated taxonomy: required to get list of terms associated with post; include a term to limit by term)
* term (term within named taxonomy)
* operator (IN, NOT IN, or AND) == how to treat the selected terms. Choose posts with that term, without that term, or using all terms supplied.
* count (number of items to display - default shows all)
* order (order to show items in - default order is "menu_order" )
* direction (whether sort is ascending, "ASC", or descending, "DESC" (default))
* meta_key ( custom field to sort by if 'order' is "meta_value" or "meta_value_num" )
* template ( set to a post type to use a template set by that post type. If "display" equals "custom", write a custom template. )
* custom_wrapper ( only used when custom template in use; wraps all results in this html element with appropriate classes)
* offset (integer: skip a number of posts before display.)
* id ( comma separated list of IDs to show a set of posts; single ID to show a single post.)
* cache (integer: number of hours to cache the results of this shortcode)
* year (integer)
* month (integer, 1-12)
* week (integer, 0-53)
* day (integer, 1-31)

A search form for any custom post type is accessible using the shortcode [custom_search type='custom_post_type']

You can create a site map for a specific post type and taxonomy using the [my_archive type='custom_post_type' taxonomy='taxonomy'] shortcode. Other supported attributes include all those above, plus:

* exclude (list of comma-separated taxonomy terms to exclude from the site map)
* include (list of comma-separated taxonomy terms to show on the site map)

The "id" attribute is not supported in the [my_archive] shortcode. (Because that would be silly.) The [my_archive] shortcode does support a "show_links" attribute which will turn on a navigation list to navigate to each displayed category.

Translating my plug-ins is always appreciated. Visit <a href="http://translate.joedolson.com">my translations site</a> to start getting your language into shape!

* Spanish (Tom Cloud) [1.1.2]

== Changelog ==

= 1.2.7 =

* Bug fix: Widget category limits did not work.
* Bug fix: Widget saving of template type did not work. 

= 1.2.6 =

* Bug fix: could not enable 'hierarchical' without disabling 'publicly_queryable'
* Bug fix: New post types display default templates instead of blank.
* Change: Edit button indicates what is being edited
* Change: add new form only visible on demand
* Added: support for has_archive in post type.
* Added option to delete custom post types.
* Performance improvement in template interpreter

= 1.2.5 =

* Added options for limiting by year, month, week, and day to shortcode.
* Added ability to edit the URL slug used by each custom post type.
* Added limiting by category to widget.
* Added automatic filtering of custom post types single-post view to use Full template as defined in back-end. 
* Fixed a variety of minor bugs. 

= 1.2.4 =

* Resolved bug with empty custom fields not resulting in replaced template tags.
* Added missing email address filter

= 1.2.3 =

* Released 5/17/2012
* Adjusted glossary filter to only link the first two instances of a glossary term on a given page.
* Added 'include' filter for My Archive shortcode.
* Added 'operator' option for Terms (values: in term, not in term, in all terms)
* Adjusted taxonomy and post-type checks to more easily handle types/taxonomies not created by MCM
* Bug fix: shortcut taxonomy post types not recognized.
* Fixed installation error which did not create default custom post types.
* Fixed bug in glosssary plug-in which filtered out content if Glossary post type not enabled.

= 1.2.2 =

* Released 5/7/2012
* Added option to add navigation links to My Archive view
* Added additional filter: mcm_filter_post.
* Added custom variable attribute to shortcode for use in filters.
* Added custom wrapper attribute for use with custom templates.
* Forces theme support for post thumbnails to avoid some errors in themes without.
* Bug fix in template tag attributes.

= 1.2.1 =

* Released 4/7/2012
* Bug fix: missing argument in widget view function.
* Bug fix: Didn't actually add the Spanish translation.

= 1.2.0 =

* Released 4/2/2012
* Added title as an option for widgets.
* Added 'cache' attribute to shortcodes. 
* Added support for showing lists incorporating multiple post types.
* Added editor for post type settings.
* Added ability to add new custom post type.
* Added save notices.
* Added support for two custom attributes in template tags: "before" and "after".
* Added Spanish translation.
* Bug fix: issue with archive shortcode using term name instead of slug.
* Bug fix: default value for My Content display mode was an invalid value.

= 1.1.2 =

* Released 2/23/2012
* Made arguments for mcm_content_filter more generic for broader use.
* Fixed bug where Glossary Filters threw error if Glossary extension was enabled without the Glossary post type.
* Fixed missing arguments in Custom Post List widget
* Added display type (list, excerpt, full) selection to Custom Post List widget
* Added number to display option to Custom Post List widget
* Added ordering selector to Custom Post List widget
* Added order direction selector to Custom Post List widget
* Fixed bug where sidebar widget picked up title value for currently active Post object.

= 1.1.1 =

* Fixes a bug where the glossary filter always triggered an admin notice, due to file inclusion order.

= 1.1.0 =

* Added supplemental plug-in to provide a glossary filter for content and an alphabet anchor list for glossaries.
* Glossary post type has option to include headings to correspond to alphabet anchor list.
* Added shortcode to display archive of entire custom taxonomy organized by term. 
* Added option to use My Content Management shortcodes with any post type, not just those created by My Content Management
* Added generic additional post type called 'Resources'
* Added ability to use a custom template with a given shortcode. 
* Bug fix: Template manager didn't appear immediately when enabling first custom post type
* Bug fix: Errors if disabling all custom post types
* Bug fix: Template manager sometimes showed custom fields not related to the current custom post type.
* Bug fix: Upgrade routine could delete customized templates.
* Bug fix: Support/donate/plug-in links weren't clickable.

= 1.0.6 =

* Whoops! All apologies for 1.0.5. I made it worse. Too much of a hurry.

= 1.0.5 =

* Variable naming error in 1.0.4 caused problem in list wrapper output.

= 1.0.4 =

* Would you believe that I left out the ability to change the sort direction? Ridiculous.
* List wrapper was wrapped around items instead of lists.
* Setting list or item wrappers to 'none' left empty brackets
* Setting list or item wrappers to 'none' was not remembered in settings.
* fixed fopen error on servers with allow_url_fopen disabled

= 1.0.3 =

* Fixes two bugs with custom taxonomy limits, courtesy @nickd32

= 1.0.2 = 

* Defined custom fields for testimonials and quotes were not appearing.
* Added 'title' as a custom field for testimonials and quotes.
* Corrected a too-generically named constant.

= 1.0.1 =

* Removed a stray variable which was triggering a warning.
* Added an array check before running a foreach loop on a sometimes-absent value

= 1.0.0 =

* Initial release

== Installation ==

1. Upload the `my-content-management` folder to your `/wp-content/plugins/` directory
2. Activate the plugin using the `Plugins` menu in WordPress
3. Visit the settings page at Settings > My Content Management to enable your needed content types.
4. Visit the appropriate custom post types sections to edit and create new content.
5. Use built-in widgets or shortcodes to display content. (Advanced users can create custom theme templates for displays.)

== Frequently Asked Questions ==

= Why don't you have any questions here? =

Hey. This was just launched. Got one to ask?

= I don't really get how to use this plug-in. =

Well, there really isn't one way to use this plug-in. There are many, many different ways to use it. I'd recommend buying the [User's Guide](http://www.joedolson.com/articles/my-content-management/guide/), which will walk you through many of the ways you can use this plug-in. Also, your purchase will help support me! Bonus!

== Screenshots ==

1. Settings Page

== Upgrade Notice ==

 * 1.2.5 A few new features, a couple of bug fixes.