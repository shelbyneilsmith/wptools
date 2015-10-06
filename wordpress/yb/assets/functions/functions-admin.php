<?php

/* custom login page */

/* calling your own login css so you can style it */
function yb_login_css() {
  echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/assets/styles/css/login.css">';
}

/* changing the logo link from wordpress.org to your site */
function yb_login_url() {  return home_url(); }

/* changing the alt text on the logo to show your site name */
function yb_login_title() { return get_option('blogname'); }

/* calling it only on the login page */
add_action('login_head', 'yb_login_css');
add_filter('login_headerurl', 'yb_login_url');
add_filter('login_headertitle', 'yb_login_title');

/* customize admin */

/* first, create a function that includes the path to your favicon */
function yb_admin_favicon() {
  $favicon_url = get_stylesheet_directory_uri() . '/admin-favicon.png';
  echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
}
/* run on admin and login pages */
add_action('login_head', 'yb_admin_favicon');
add_action('admin_head', 'yb_admin_favicon');

/* custom backend footer */
function yb_custom_admin_footer() {
  echo '<span id="footer-thankyou">'.__('Developed by ', 'yb').'<a href="http://yellowberri.com" target="_blank">Yellowberri</a></span>.&nbsp;';
}
add_filter('admin_footer_text', 'yb_custom_admin_footer');

/* rename admin sections */
function edit_admin_menus() {
  global $menu;
  /* Change Posts to Recipes */
  $menu[5][0] = __('Recipes', 'yb');
}
/* add_action( 'admin_menu', 'edit_admin_menus' ); */

/* custom admin icons */
/* icons found here: http://melchoyce.github.io/dashicons/ */
function custom_admin_icons() {

  echo '
  <style>
  #adminmenu #menu-posts-smile_profile div.wp-menu-image:before { content: "\f328"; }
  #adminmenu #menu-posts-testimonial div.wp-menu-image:before { content: "\f205"; }
  #adminmenu #menu-posts-specials div.wp-menu-image:before { content: "\f323"; }
  #adminmenu #menu-posts-staff div.wp-menu-image:before { content: "\f307"; }
  </style>
  ';
}
/* add_action( 'admin_head', 'custom_admin_icons' ); */

/* remove admin menus if disable by REDUX */
function remove_menus () {
  global $menu, $ybwp_data;

  $restricted = array();

  if ( empty($ybwp_data['opt-checkbox-blog'] )) {
    $restricted[] = __('Posts', 'yb');
  }
  if ( !empty($ybwp_data['opt-checkbox-mediamenu'] )) {
    $restricted[] = __('Media', 'yb');
  }
  if ( !empty($ybwp_data['opt-checkbox-pagecomments']) && (empty($ybwp_data['opt-checkbox-blog']) || !empty($ybwp_data['opt-checkbox-blogcomments'] )) && (empty($ybwp_data['opt-checkbox-woocommerce']) || !empty($ybwp_data['opt-checkbox-woocomments'] ) ) ) {
    $restricted[] = __('Comments', 'yb');
  }

  end ($menu);

  while (prev($menu)){
    $value = explode(' ',$menu[key($menu)][0]);
    if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
      unset($menu[key($menu)]);
    }
  }
}
add_action('admin_menu', 'remove_menus');
 ?>