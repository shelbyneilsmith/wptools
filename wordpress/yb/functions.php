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
/*     Custom Post Type : book     */
/* ------------------------------------------------------------------------ */

/*
*  Captial, plural      Books
*  Captial, singular    Book
*  Lowercase, plural    books
*  Lowercase, singular   book
*/

function cpt_book_init() {
  $labels = array(
    'name'  => 'Books',
    'singular_name' => 'Book',
    'menu_name' => 'Books',
    'name_admin_bar' => 'Book',
    'add_new'  => 'Add New', 'book',
    'add_new_item' => 'Add New Book',
    'new_item'  => 'New Book',
    'edit_item'  => 'Edit Book',
    'view_item'  => 'View Book',
    'all_items' => 'All Books',
    'search_items' => 'Search Books',
    'parent_item_colon' => 'Parent Books:',
    'not_found' => 'No books found.',
    'not_found_in_trash' => 'No books found in Trash.',
  );
 
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'book' ),
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => true,
    'menu_position' => null,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' )
  );
 
  register_post_type( 'book', $args );
}
 
//add_action( 'init', 'cpt_book_init' );

/* ------------------------------------------------------------------------ */
/*     Custom Taxonomy : genre     */
/* ------------------------------------------------------------------------ */

/*
*  Capital, plural      Genres
*  Capital, singular     Genre
*  Lowercase, singular   genre
*  Custom post type    book
*/

function create_book_taxonomies() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => 'Genres',
    'singular_name' => 'Genre',
    'search_items' => 'Search Genres',
    'all_items' => 'All Genres',
    'parent_item' => 'Parent Genre',
    'parent_item_colon' => 'Parent Genre:',
    'edit_item' => 'Edit Genre',
    'update_item' => 'Update Genre',
    'add_new_item' => 'Add New Genre',
    'new_item_name' => 'New Genre Name',
    'menu_name' => 'Genres',
  );

  $args = array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'genre' ),
  );

  register_taxonomy( 'genre', array( 'book' ), $args );
}

//add_action( 'init', 'create_book_taxonomies', 0 );

?>