<?php 

/* ------------------------------------------------------------------------ */
/* Add WooCommerce Support */
/* ------------------------------------------------------------------------ */

if ( !empty($ybwp_data['opt-checkbox-woocommerce']) && class_exists('Woocommerce') ) {
  /* add WooCommerce theme support */
  add_theme_support('woocommerce');

  /* disable WooCommerce CSS */
  add_filter( 'woocommerce_enqueue_styles', '__return_false' );
}

?>