<?php
/*
Author: Shelby Smith
URL: htp://yellowberri.com
*/

global $ybwp_data;

/* ------------------------------------------------------------------------ */
/* Includes */
/* ------------------------------------------------------------------------ */

/* redux */
require get_template_directory() . '/admin/admin-init.php';

/* theme setup */
include_once('assets/functions/functions-setup.php');

/* js and css */
include_once('assets/functions/functions-enqueue.php');

/* shortcodes */
include_once('assets/functions/functions-shortcodes.php');

/* image and media options */
include_once('assets/functions/functions-images.php');

/* admin customization */
include_once('assets/functions/functions-admin.php');

/* utility functions */
include_once('assets/functions/functions-utils.php');

/* redux layout functions */
include_once('assets/functions/functions-layout.php');

/* page menus  */
include_once('assets/functions/functions-page_menus.php');

/* add ACF options pages (ACF v5) */
/*include_once('assets/functions/functions-options.php');*/

/* woocommerce */
include_once('assets/functions/functions-woocommerce.php');

/* ------------------------------------------------------------------------ */
/* Widget includes */
/* ------------------------------------------------------------------------ */

/*include_once('assets/inc/widgets/widget-sponsor.php');*/
/*include_once('assets/inc/widgets/widget-contact.php');*/

/* ------------------------------------------------------------------------ */
/* Custom Functions */
/* ------------------------------------------------------------------------ */


?>