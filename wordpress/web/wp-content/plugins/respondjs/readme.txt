=== Respond.js ===
Contributors: Ramoonus
Donate link: http://www.ramoonus.nl/donate/
Tags: css3, css, javascript, media, internet explorer, media queries, responsive
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 1.2.0

Respond.js is a fast & lightweight polyfill for min/max-width CSS3 Media Queries (for IE 6-8, and more).
== Description ==
A fast & lightweight polyfill for min/max-width CSS3 Media Queries (for IE 6-8, and more)

* Copyright 2011: Scott Jehl, scottjehl.com
* Dual licensed under the MIT or GPL Version 2 licenses. 
 
The goal of this script is to provide a fast and lightweight (3kb minified / 1kb gzipped) script to enable [responsive web designs](http://www.alistapart.com/articles/responsive-web-design/) in browsers that don't support CSS3 Media Queries - in particular, Internet Explorer 8 and under. It's written in such a way that it will probably patch support for other non-supporting browsers as well (more information on that soon).

If you're unfamiliar with the concepts surrounding Responsive Web Design, you can read up [here](http://www.alistapart.com/articles/responsive-web-design/) and also [here](http://filamentgroup.com/examples/responsive-images/)

= How to get it working =

- Craft your CSS with min/max-width media queries to adapt your layout from mobile (first) all the way up to desktop
- Follow each of your media query closing braces with this closing comment (handy for scanning the stylesheet anyway, IMHO):

<pre>
    @media screen and (min-width: 480px){
        ...styles for 480px and up go here
    }/*/mediaquery*/
</pre>
 
== Installation ==
1. Upload `respondjs/` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

Its recommended to flush the cache after upgrading.

== Changelog ==
= 1.2.0 =
* Based on Respond.js 1.2.0
* Readme updated

= 1.1 =
* Based on Respond.js 1.1

= 1.0.0.1 =
* Based on Respond.js 1.0.0

= 1.0.0 =
* First version (8-5-2011)