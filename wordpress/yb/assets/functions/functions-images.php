<?php 

/* ------------------------------------------------------------------------ */
/* add post thumbnails */
/* ------------------------------------------------------------------------ */

function add_thumbnail_support() {
  if ( function_exists( 'add_image_size' ) ) {
    add_theme_support( 'post-thumbnails' );
  }
}
add_action('init', 'add_thumbnail_support');

/* ------------------------------------------------------------------------ */
/* add media sizes */
/* ------------------------------------------------------------------------ */

function add_custom_sizes() {
  if ( function_exists( 'add_image_size' ) ) {
    /* Bigger than medium, copy me */
    add_image_size( 'medium-plus', 700, 600, false ); 
  }
}
add_action('init', 'add_custom_sizes');

/* ------------------------------------------------------------------------ */
/* add thumbnail sizes to media browser */
/* https://codex.wordpress.org/Function_Reference/add_image_size#For_Media_Library_Images_.28Admin.29 */
/* ------------------------------------------------------------------------ */

function setup_custom_sizes( $sizes ) {
  return array_merge( $sizes, array(
    'medium-plus' => __( 'Medium Plus' ),
    ) );
}
add_filter( 'image_size_names_choose', 'setup_custom_sizes' );

/* ------------------------------------------------------------------------ */
/* disable width & height from inserted images */
/* ------------------------------------------------------------------------ */

function remove_width_attribute( $html ) {
  $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
  return $html;
}
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );

/* ------------------------------------------------------------------------ */
/* disable wrapping of images in p tags */
/* ------------------------------------------------------------------------ */

function filter_ptags_on_images($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

?>