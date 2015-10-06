<?php 

/* ------------------------------------------------------------------------ */
/* Head Cleanup */
/* ------------------------------------------------------------------------ */

function yb_head_cleanup() {
  global $ybwp_data;

  /* EditURI link */
  remove_action( 'wp_head', 'rsd_link' );

  /* windows live writer */
  remove_action( 'wp_head', 'wlwmanifest_link' );

  /* WP version */
  remove_action( 'wp_head', 'wp_generator' );

  /* remove feed links */
  remove_action('wp_head', 'feed_links_extra', 3 );
}

add_action('init', 'yb_head_cleanup');


/* ------------------------------------------------------------------------ */
/* Remove Emoji Rendering */
/* ------------------------------------------------------------------------ */

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/* ------------------------------------------------------------------------ */
/* RSS Head Links */
/* ------------------------------------------------------------------------ */

function yb_add_rss_to_head() {
  add_theme_support( 'automatic-feed-links' );
}
if ( !empty($ybwp_data['opt-checkbox-blogrss'] )) {
  add_action('init', 'yb_add_rss_to_head');
}

/* ------------------------------------------------------------------------ */
/* Set Locale File : What does this do? */
/* ------------------------------------------------------------------------ */

$locale = get_locale();
$locale_file = get_template_directory() . "/assets/languages/$locale.php";
if ( is_readable($locale_file) )
  require_once($locale_file);

/* ------------------------------------------------------------------------ */
/* Set Timezone */
/* ------------------------------------------------------------------------ */

function yb_sync_timezones(){
  $timezone = "America/Chicago";
  update_option( 'timezone_string', $timezone );
  date_default_timezone_set($timezone);
}
add_action('init', 'yb_sync_timezones');

/* ------------------------------------------------------------------------ */
/* Set Pretty Permalinks */
/* ------------------------------------------------------------------------ */

function yb_set_permalinks() {
  global $wp_rewrite;
  $wp_rewrite->set_permalink_structure( '/%postname%/' );
}
add_action( 'init', 'yb_set_permalinks');

/* ------------------------------------------------------------------------ */
/* Disable Admin Toolbar */
/* ------------------------------------------------------------------------ */

add_filter('show_admin_bar', '__return_false');

function cc_hide_admin_bar() {
  if (!current_user_can('edit_posts')) {
    show_admin_bar(false);
  }
}
add_action('set_current_user', 'cc_hide_admin_bar');

/* ------------------------------------------------------------------------ */
/* Remove Default Tagline */
/* ------------------------------------------------------------------------ */

function clear_default_tagline() {
  if (get_option( 'blogdescription', 'notfound') === "Just another WordPress site") {
    update_option( 'blogdescription', '' );
  }
}
add_action('after_setup_theme', 'clear_default_tagline');

/* ------------------------------------------------------------------------ */
/* Setup Default Pages */
/* ------------------------------------------------------------------------ */

function setup_default_pages() {
  if (get_option('this_has_run') != "yes") {
    $default_pages = array(
      'Home' => array(
        'content' => '',
        'template' => 'page.php',
        'slug' => '',
        'status' => 'publish',
        ),
      'Wireframes' => array(
        'content' => file_get_contents('http://www.ybdevel.com/dev/wireframes-copy_150430.txt'),
        'template' => 'page-wireframes.php',
        'slug' => 'wireframes',
        'status' => 'publish',
        ),
      );
    foreach ( $default_pages as $page_title => $page_var ) {
      $page_check = get_page_by_title($page_title);
      $new_page = array(
        'post_type' => 'page',
        'post_title' => $page_title,
        'post_name' => $page_var['slug'],
        'post_content' => $page_var['content'],
        'post_status' => $page_var['status'],
        'post_author' => 1,
        );
      if(!isset($page_check->ID)){
        $new_page_id = wp_insert_post($new_page);
        if(!empty($page_var['template'])){
          update_post_meta($new_page_id, '_wp_page_template', $page_var['template']);
        }
      }

      if ( $page_title === "Home" ) {
        $homeSet = get_page_by_title( $page_title );
        update_option( 'page_on_front', $homeSet->ID );
        update_option( 'show_on_front', 'page' );
      }
    }

    update_option( 'this_has_run', 'yes' );
  }
}
add_action('after_setup_theme', 'setup_default_pages');

/* ------------------------------------------------------------------------ */
/* exclude wireframes from the pages admin list */
/* ------------------------------------------------------------------------ */

function exclude_this_page( $query ) {
  global $pagenow, $wpdb;

  /* populate excluded ids */
  $exclude_pages = array('wireframes');
  $exclude_ids = array();

  foreach ( $exclude_pages as $page_slug ) {
    $page_check = get_page_by_path($page_slug);
    if ( isset($page_check->ID) ) {
      $exclude_ids[] = $page->ID;
    }
  }

  /* if not admin, return full query */
  if ( !is_admin() ) { 
    return $query; 
  }

  /* if edit page, exclude IDs from queries */
  if ( 'edit.php' == $pagenow && ( get_query_var('post_type') && 'page' == get_query_var('post_type') ) ) {
    $query->set( 'post__not_in', $exclude_ids );
    return $query;
  }
}
if ( ((WP_ENV != 'development') && (WP_ENV != 'staging')) ) {
  add_action( 'pre_get_posts' ,'exclude_this_page' );
}

/* ------------------------------------------------------------------------ */
/* create the default menus */
/* ------------------------------------------------------------------------ */

function yb_register_menus() {

  global $ybwp_data;
  $util_nav = $ybwp_data['opt-checkbox-utilnav'];
  $wireframes = $ybwp_data['opt-checkbox-wireframes'];

  add_theme_support( 'menus' );

  $menus = array(
    'Main Navigation' => array(
      'slug' => 'main-nav',
      'menu_items' => array(
        'Home' => array(
          'url' => site_url(),
          'slug' => 'home'
          ),
        )
      ),
    'Footer Navigation' => array(
      'slug' => 'footer-nav',
      'menu_items' => array(
        'Home' => array(
          'url' => site_url(),
          'slug' => 'home'
          ),
        )
      )
    );

  /* optional utility navigation */
  if ( !empty( $util_nav ) ) {
    $menus['Utility Navigation'] = array(
      'slug' => 'util-nav',
      'menu_items' => array()
      );
  }

  /* the menu for the wireframes pages. only shows in dev environments */
  if ( ((WP_ENV == 'development') || (WP_ENV == 'staging')) && !empty( $wireframes )) {
    $menus['Wireframes Navigation'] = array(
      'slug' => 'wireframes-nav',
      'menu_items' => array(
        'Home' => array(
          'url' => site_url(),
          'slug' => 'home'
          ),
        )
      );
  }

  /* create menus */
  foreach( $menus as $menu_title => $menu_var ) {

    /* register new nav menu */
    register_nav_menu( $menu_var['slug'], $menu_title );

    if( !is_nav_menu($menu_title) ) {
      $menu_id = wp_create_nav_menu( $menu_title );

      /* populate menu items */
      foreach( $menu_var['menu_items'] as $menu_item_name => $menu_item_args ) {
        $page_obj = get_page_by_path($menu_item_args['slug']);
        $item = array( 
          'menu-item-object' => 'page', 
          'menu-item-type' => 'post_type', 
          'menu-item-object-id' => $page_obj->ID, 
          'menu-item-url' => $menu_item_args['url'], 
          'menu-item-title' => $menu_item_name, 
          'menu-item-status' => 'publish', 
          'menu-item-position' => $page_obj->menu_order 
          );
        wp_update_nav_menu_item( $menu_id, 0, $item );
      }

      $locations = get_theme_mod( 'nav_menu_locations' );
      $locations[$menu_var['slug']] = $menu_id;
      set_theme_mod('nav_menu_locations', $locations);
    }
  }
}
add_action('after_setup_theme', 'yb_register_menus');

/* ------------------------------------------------------------------------ */
/* create sidebars */
/* ------------------------------------------------------------------------ */

function yb_register_sidebars() {
  global $ybwp_data;
  $blog_sidebar = $ybwp_data['opt-checkbox-blog'];
  $footer_widgets = $ybwp_data['opt-checkbox-footerwidgets'];
  $footer_cols = $ybwp_data['opt-select-footercolumns'];
  $shop_widgets = $ybwp_data['opt-checkbox-woocommerce'];

  /* primary Widgets */
  register_sidebar(array(
    'name' => __('Main Sidebar','yb'),
    'id' => 'main-sidebar',
    'description' => __('The main (primary) sidebar.','yb'),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
    ));

  /* blog widgets */
  if ( !empty( $blog_sidebar )) {
    register_sidebar(array(
      'name' => __('Blog Sidebar','yb' ),
      'id'   => 'blog-sidebar',
      'description'   => __( 'These are widgets for the Blog sidebar.','yb' ),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h3 class="title"><span>',
      'after_title'   => '</span></h3>'
      ));
  }

  /* footer widgets */
  if( !empty( $footer_widgets )) {
    $footercolumns = "four";

    if(!empty( $footer_cols )) {
      if( $footer_cols == "4" ){ $footercolumns = "four"; }
      elseif( $footer_cols ==  "3" ){ $footercolumns = "one-third"; }
      elseif( $footer_cols ==  "2" ){ $footercolumns = "eight"; }
      elseif( $footer_cols ==  "1" ){ $footercolumns = "sixteen"; }
    }

    register_sidebar(array(
      'name' => __('Footer Widgets','yb' ),
      'id'   => 'footer-widgets',
      'description'   => __( 'These are widgets for the Footer.','yb' ),
      'before_widget' => '<div id="%1$s" class="widget %2$s '.$footercolumns.' columns">',
      'after_widget'  => '</div>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>'
      ));
  }

  /* shop widgets */
  if ( !empty( $shop_widgets ) && class_exists('Woocommerce') ) {
    register_sidebar(array(
      'name' => __('Shop Widgets','yb' ),
      'id'   => 'shop-widgets',
      'description'   => __( 'These are widgets for the Shop sidebar.','yb' ),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h3 class="title"><span>',
      'after_title'   => '</span></h3>'
      ));
  }

}
if (function_exists('register_sidebar')) {
  add_action( 'widgets_init', 'yb_register_sidebars' );
}

?>