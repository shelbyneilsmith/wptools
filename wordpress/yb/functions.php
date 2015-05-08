<?php
/*
Author: Shelby Smith
URL: htp://yellowberri.com
*/

global $ybwp_data;

/* ------------------------------------------------------------------------ */
/* Includes
/* ------------------------------------------------------------------------ */
	/* ------------------------------------------------------------------------ */
	/* Include REDUX Framework */
	require get_template_directory() . '/admin/admin-init.php';

	/* ------------------------------------------------------------------------ */
	/* Misc Includes */
	include_once('assets/inc/enqueue.php'); // Enqueue JavaScripts & CSS
	include_once('assets/inc/shortcodes.php'); // Load Shortcodes
	include_once('assets/inc/utils.php'); // Load Utility Functions

	/* -------------------------------- ---------------------------------------- */
	/* Widget Includes */
	include_once('assets/inc/widgets/sponsor.php');
	include_once('assets/inc/widgets/contact.php');

/* ------------------------------------------------------------------------ */
/* YB THEME INIT
/* ------------------------------------------------------------------------ */
	/* First, let's remove all the unneeded stuff. */
	add_action('init', 'yb_head_cleanup');
	function yb_head_cleanup() {
		global $ybwp_data;
		// EditURI link
		remove_action( 'wp_head', 'rsd_link' );
		// windows live writer
		remove_action( 'wp_head', 'wlwmanifest_link' );
		// WP version
		remove_action( 'wp_head', 'wp_generator' );
		// Remove feed links
		remove_action('wp_head', 'feed_links_extra', 3 );
		/* Add RSS Links to head section */
		if ( !empty($ybwp_data['opt-checkbox-blogrss'] )) {
			add_theme_support( 'automatic-feed-links' );
		}
	}

	/* Post Thumbnails */
	add_action('init', 'setup_thumbnail_support');
	function setup_thumbnail_support() {
		if ( function_exists( 'add_image_size' ) ) add_theme_support( 'post-thumbnails' );

		if ( function_exists( 'add_image_size' ) ) {
			add_image_size( 'medium-plus', 800, 600, false ); // Bigger than medium, copy me.
		}
	}

	/* Add thumbnail sizes to Media */
	// https://codex.wordpress.org/Function_Reference/add_image_size#For_Media_Library_Images_.28Admin.29
	add_filter( 'image_size_names_choose', 'setup_custom_sizes' );

	function setup_custom_sizes( $sizes ) {
		return array_merge( $sizes, array(
			'medium-plus' => __( 'Medium Plus' ),
			) );
	}

	/* Translation/Localisation */
	/* Translations can be filed in the assets/languages/ directory */
	add_action('init', 'my_theme_setup');
	function my_theme_setup(){
		load_theme_textdomain( 'yb', get_template_directory() . '/assets/languages' );
	}

	$locale = get_locale();
	$locale_file = get_template_directory() . "/assets/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once($locale_file);

	/* Syncronize timezone */
	add_action('init', 'sync_timezones');
	function sync_timezones(){
		$timezone = "America/Chicago";
		update_option( 'timezone_string', $timezone );
		date_default_timezone_set($timezone);
	}

	/* Basic permalink postname structure */
	add_action( 'init', function() {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
	} );

	// Don't show the toolbar on front-end facing pages. This can be disabled to restore dashboard control.
	add_filter('show_admin_bar', '__return_false');

	/* Disable Admin Bar for Subscribers (Not Admins) */
	add_action('set_current_user', 'cc_hide_admin_bar');
	function cc_hide_admin_bar() {
		if (!current_user_can('edit_posts')) {
			show_admin_bar(false);
		}
	}

	/* Remove default tagline "Just another WordPress site" */
	add_action('after_setup_theme', 'clear_default_tagline');
	function clear_default_tagline() {
		update_option( 'blogdescription', '' );
	}

	/* ------------------------------------------------------------------------ */
	/* Set up default pages */
	/* ------------------------------------------------------------------------ */
	add_action('after_setup_theme', 'setup_default_pages');
	function setup_default_pages() {
		if (get_option('this_has_run') != "yes") {
			$default_pages = array(
				'Home' => array(
					'content' => '',
					'template' => 'template-full-width.php',
					'slug' => '',
					'status' => 'publish',
				),
				'Development/Design' => array(
					'content' => file_get_contents('http://www.ybdevel.com/dev/wireframes-copy_150430.txt'),
					'template' => 'page-dev.php',
					'slug' => 'dev',
					'status' => 'publish',
				),
				'StyleTiles' => array(
					'content' => '',
					'template' => 'styletiles.php',
					'slug' => 'styletiles',
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

	// exclude certain dev pages from the pages admin list
	function exclude_this_page( $query ) {
		$exclude_pages = array('dev', 'styletiles');
		$exclude_ids = array();

		foreach ( $exclude_pages as $page_slug ) {
			$page = get_page_by_path($page_slug);
			if ($page) {
				$exclude_ids[] = $page->ID;
			}
		}

		if( !is_admin() )
			return $query;

		global $pagenow, $wpdb;

		if( 'edit.php' == $pagenow && ( get_query_var('post_type') && 'page' == get_query_var('post_type') ) )
			$query->set( 'post__not_in', $exclude_ids ); // array page ids
		return $query;
	}
	if ( ((WP_ENV != 'development') && (WP_ENV != 'staging')) ) {
		add_action( 'pre_get_posts' ,'exclude_this_page' );
	}

	/* ------------------------------------------------------------------------ */
	/* Create the default menus */
	/* ------------------------------------------------------------------------ */
	add_action('after_setup_theme', 'register_yb_menus');
	function register_yb_menus() {
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

		// optional utility navigation
		if ( !empty( $util_nav )) {
			$menus['Utility Navigation'] = array(
					'slug' => 'util-nav',
					'menu_items' => array(
						// 'Home' => array(
						// 	'url' => site_url(),
						// 	'slug' => 'home'
						// ),
					)
			);
		}

		// the menu for the wireframes pages. only shows in dev environments
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

		foreach($menus as $menu_title => $menu_var) {
			register_nav_menu( $menu_var['slug'], $menu_title );
			if( !is_nav_menu($menu_title) ) {
				$menu_id = wp_create_nav_menu( $menu_title );

				foreach( $menu_var['menu_items'] as $menu_item_name => $menu_item_args ) {
					$page_obj = get_page_by_path($menu_item_args['slug']);
					$item = array ( 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-object-id' => $page_obj->ID, 'menu-item-url' => $menu_item_args['url'], 'menu-item-title' => $menu_item_name, 'menu-item-status' => 'publish', 'menu-item-position' => $page_obj->menu_order );
					wp_update_nav_menu_item( $menu_id, 0, $item );
				}

				$locations = get_theme_mod( 'nav_menu_locations' );
				$locations[$menu_var['slug']] = $menu_id;
				set_theme_mod('nav_menu_locations', $locations);
			}
		}
	}

	/* ------------------------------------------------------------------------ */
	/* Define Sidebars */
	/* ------------------------------------------------------------------------ */

	add_action( 'widgets_init', 'register_yb_sidebars' );
	function register_yb_sidebars() {
		global $ybwp_data;
		$blog_sidebar = $ybwp_data['opt-checkbox-blog'];
		$footer_widgets = $ybwp_data['opt-checkbox-footerwidgets'];
		$footer_cols = $ybwp_data['opt-select-footercolumns'];
		$shop_widgets = $ybwp_data['opt-checkbox-woocommerce'];

		if (function_exists('register_sidebar')) {

			/* ------------------------------------------------------------------------ */
			/* Primary Widgets */
			register_sidebar(array(
				'name' => __('Main Sidebar','yb'),
				'id' => 'main-sidebar',
				'description' => __('The main (primary) sidebar.','yb'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widgettitle">',
				'after_title' => '</h4>',
			));

			/* ------------------------------------------------------------------------ */
			/* Blog Widgets */

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

			/* ------------------------------------------------------------------------ */
			/* Footer Widgets */

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

			/* ------------------------------------------------------------------------ */
			/* Shop Widgets */

			if (!empty( $shop_widgets ) && class_exists('Woocommerce')){
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
	}

/* ------------------------------------------------------------------------ */
/* Custom Excerpt Length */
/* ------------------------------------------------------------------------ */
	function new_excerpt_length($length) {
		global $ybwp_data;
		return $ybwp_data['opt-text-excerptlength'];
	}
	add_filter('excerpt_length', 'new_excerpt_length');

/* ------------------------------------------------------------------------ */
/* Changing excerpt more */
/* ------------------------------------------------------------------------ */
	if( !empty($ybwp_data['opt-checkbox-readmore']) ) { // Admin Option Check
		function new_excerpt_more($more) {
			global $post;
			return '… <a href="'. get_permalink($post->ID) . '" class="read-more-link">' . '' . __('read more', 'yb') . ' &rarr;' . '</a>';
		}
		add_filter('excerpt_more', 'new_excerpt_more');
	}

/* ------------------------------------------------------------------------ */
/* WooCommerce */
/* ------------------------------------------------------------------------ */
	if (!empty($ybwp_data['opt-checkbox-woocommerce']) && class_exists('Woocommerce')){
		// Add WooCommerce Theme Support
		add_theme_support('woocommerce');

		// Disable WooCommerce CSS
		add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	}

/* ------------------------------------------------------------------------ */
/* Custom Login Page */
/* ------------------------------------------------------------------------ */

	// calling your own login css so you can style it
	function yb_login_css() {
		/* I couldn't get wp_enqueue_style to work :( */
		echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/assets/styles/css/login.css">';
	}

	// changing the logo link from wordpress.org to your site
	function yb_login_url() {  return home_url(); }

	// changing the alt text on the logo to show your site name
	function yb_login_title() { return get_option('blogname'); }

	// calling it only on the login page
	add_action('login_head', 'yb_login_css');
	add_filter('login_headerurl', 'yb_login_url');
	add_filter('login_headertitle', 'yb_login_title');

/* ------------------------------------------------------------------------ */
/* Customize Admin */
/* ------------------------------------------------------------------------ */

	// First, create a function that includes the path to your favicon
	function add_favicon() {
	  	$favicon_url = get_stylesheet_directory_uri() . '/admin-favicon.png';
		echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
	}

	// Now, just make sure that function runs when you're on the login page and admin pages
	add_action('login_head', 'add_favicon');
	add_action('admin_head', 'add_favicon');

	// Custom Backend Footer
	function yb_custom_admin_footer() {
		echo '<span id="footer-thankyou">'.__('Developed by ', 'yb').'<a href="http://yellowberri.com" target="_blank">Yellowberri</a></span>.&nbsp;';
	}
	add_filter('admin_footer_text', 'yb_custom_admin_footer');

	function edit_admin_menus() {
		global $menu;
		//var_dump($menu);
		$menu[5][0] = __('Recipes', 'yb'); // Change Posts to Recipes
	}
	//add_action( 'admin_menu', 'edit_admin_menus' );

	function custom_admin_icons() {
		// Change CSS selector to menu name.
		// Change content property to new icon code.
		// Icons found here: http://melchoyce.github.io/dashicons/

		echo '
			<style>
				#adminmenu #menu-posts-smile_profile div.wp-menu-image:before { content: "\f328"; }
				#adminmenu #menu-posts-testimonial div.wp-menu-image:before { content: "\f205"; }
				#adminmenu #menu-posts-specials div.wp-menu-image:before { content: "\f323"; }
				#adminmenu #menu-posts-staff div.wp-menu-image:before { content: "\f307"; }
			</style>
		';
	}
	//add_action( 'admin_head', 'custom_admin_icons' );

/* ------------------------------------------------------------------------ */
/* Add menus meta box to page edit screen */
/* ------------------------------------------------------------------------ */

	// Page Menus Meta Box
	add_action( 'add_meta_boxes', 'yb_page_menus_add_meta_box' );
	function yb_page_menus_add_meta_box( $post_type ) {
		add_meta_box(
			'yb_page_menus-meta-box', // id, used as the html id att
			__('Add to Menus', 'yb'), // meta box title, like "Page Attributes"
			'yb_page_menus_meta_box_cb', // callback function, spits out the content
			'page', // post type or page. We'll add this to pages only
			'side', // context (where on the screen
			'core' // priority, where should this go in the context?
		);
	}

	/**
	 * Callback function for our meta box.  Echos out the content
	 */
	function yb_page_menus_meta_box_cb( $post ) {
		global $post;

		wp_nonce_field( 'yb_page_menus_nonce', 'meta_box_nonce' );

		$menus = wp_get_nav_menus();

		echo "<p><strong>Add this page to the following menus:</strong></p>";
		foreach ( $menus as $menu ) {
			$checked = '';

			if ( checkMenuForPage($menu->term_id, $post->ID) ) {
				$checked = 'checked="checked"';
			}

			echo "<input type='checkbox' name='nav-menu-group[]' value='$menu->name' ".$checked." />$menu->name<br />";
		}
	}

	/**
	 * Save our custom field value
	 */
	add_action('pre_post_update', 'yb_page_menus_save_post', 13, 2 );
	function yb_page_menus_save_post( $post_id, $post_object ) {
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'yb_page_menus_nonce' ) ) return;

		// If this is just a revision, don't save in menu
		if ( wp_is_post_revision( $post_id ) )
			return;

		// save the data with update_post_meta
		$all_menus = wp_get_nav_menus();

		foreach ( $all_menus as $menu ) {
			// die(print_r($menu));
			$menuID = (int) $menu->term_id;
			if (isset($_POST['nav-menu-group']) && in_array($menu->name, $_POST['nav-menu-group'])) {
				if ( !checkMenuForPage($menuID, $post_id) ) {
					$itemData = array(
						'menu-item-object-id' 	=> $post_id,
						'menu-item-title' 		=> __(get_the_title($post_id)),
						'menu-item-url' 		=> get_permalink($post_id),
						'menu-item-object' 	=> 'page',
						'menu-item-position'  	=> $post_object->menu_order,
						'menu-item-type' 	=> 'post_type',
						'menu-item-status' 	=> 'publish'
					);
					remove_action( 'save_post', 'yb_page_menus_save_post', 13, 2 );
					wp_update_nav_menu_item( $menuID, 0, $itemData );
					add_action( 'save_post', 'yb_page_menus_save_post', 13, 2 );
				}
			} else {
				$isInMenu = checkMenuForPage($menuID, $post_id);
				if ( $isInMenu ) {
					wp_delete_post($isInMenu);
				}
			}
		}
	}

	function checkMenuForPage( $menuID, $pageID ) {
		global $wpdb;

		$menu_items = wp_get_nav_menu_items( $menuID );
		foreach( (array) $menu_items as $key => $menu_item) {
			$item_id = get_post_meta( $menu_item->ID, '_menu_item_object_id', true );
			if( $item_id == $pageID ) {
				return $menu_item->ID;
			}
		}
	}

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
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
		}
	}
	add_action('admin_menu', 'remove_menus');

/* ------------------------------------------------------------------------ */
/* Custom WP Title */
/* ------------------------------------------------------------------------ */

	function yb_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() ) {
			return $title;
		} // end if

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title = "$title $sep $site_description";
		} // end if

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 ) {
			$title = sprintf( __( 'Page %s', 'mayer' ), max( $paged, $page ) ) . " $sep $title";
		} // end if

		return $title;
	}
	add_filter( 'wp_title', 'yb_wp_title', 10, 2 );

/* ------------------------------------------------------------------------ */
/* Page Slug Body Class */
/* ------------------------------------------------------------------------ */
	function add_slug_body_class( $classes ) {
		global $post;
		if ( isset( $post ) ) {
			$classes[] = $post->post_type . '-' . $post->post_name;
		}
		return $classes;
	}
	add_filter( 'body_class', 'add_slug_body_class' );

/* ------------------------------------------------------------------------ */
/* Add mobile menu body classes */
/* ------------------------------------------------------------------------ */
	function add_mobile_menu_body_classes( $classes ) {
		global $ybwp_data;
		if ( !empty($ybwp_data['opt-checkbox-mobilemenu'] ) ) {
			$classes[] = 'mobile-menu';
			if ( $ybwp_data['opt-select-mobilemenutype'] === 'offscreen-nav' ) {
				$classes[] = 'offscreen-nav';
				$classes[] = 'mobilenav-pos-'.$ybwp_data['opt-select-offscreenpos'];
				$classes[] = 'mobilenav-anim-'.$ybwp_data['opt-select-mobilemenuanim'];
				$classes[] = 'mobilenav-btn-pos-'.$ybwp_data['opt-select-menubtnpos'];

				if ( $ybwp_data['opt-checkbox-utilitynavmerge'] ) {
					$classes[] = 'util-nav-merge';
				}
			}
		}

		return $classes;
	}
	add_filter( 'body_class', 'add_mobile_menu_body_classes' );

/* ------------------------------------------------------------------------ */
/* Disable Width & Height From Inserted Images */
/* ------------------------------------------------------------------------ */
	add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
	add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

	function remove_width_attribute( $html ) {
		$html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
		return $html;
	}

/* ------------------------------------------------------------------------ */
/* Disable Wrapping of Images in p Tags */
/* ------------------------------------------------------------------------ */

	function filter_ptags_on_images($content){
		return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	}

	add_filter('the_content', 'filter_ptags_on_images');

/* ------------------------------------------------------------------------ */
/* EOF
/* ------------------------------------------------------------------------ */
?>