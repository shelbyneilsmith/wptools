<?php
/*
Author: Shelby Smith
URL: htp://yellowberri.com

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.

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
	include_once('library/inc/enqueue.php'); // Enqueue JavaScripts & CSS
	include_once('library/inc/customjs.php'); // Load Custom JS
	include_once('library/inc/shortcodes.php'); // Load Shortcodes
	include_once('library/inc/utils.php'); // Load Utility Functions

	// if ( $data['check_portfoliotype'] == true ) {
	// 	include_once('library/inc/cpt-portfolio.php'); // Portfolio
	// }

	/* -------------------------------- ---------------------------------------- */
	/* Widget Includes */
	include_once('library/inc/widgets/embed.php');
	include_once('library/inc/widgets/sponsor.php');
	include_once('library/inc/widgets/contact.php');
	include_once('library/inc/widgets/custommenu.php');
	if ( !empty($ybwp_data['opt-checkbox-facebookwidget'] )) {
		include_once('library/inc/widgets/facebook.php');
	}
	// if ( !empty($ybwp_data['opt-checkbox-twitterwidget'] )) {
	// 	include_once('library/inc/widgets/twitter.php');
	// }
	// if ( $data['check_portfoliotype'] == true ) {
	// 	include_once('library/inc/widgets/portfolio.php');
	// }

	/* ------------------------------------------------------------------------ */
	/* Include Meta Box Script */
	define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/library/inc/meta-box' ) );
	define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/library/inc/meta-box' ) );
	require_once RWMB_DIR . 'meta-box.php';
	include 'library/inc/meta-boxes.php';
	// if ( $data['check_portfoliotype'] == true ) {
	// 	include 'library/inc/portfolio-meta-boxes.php';
	// }

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
			add_image_size( 'standard', 700, 300, true );			// Standard Blog Image
			add_image_size( 'blog-medium', 320, 210, true );		// Medium Blog Image
			add_image_size( 'sixteen-columns', 940, 475, true ); 	// for portfolio wide
			add_image_size( 'ten-columns', 640, 500, true );		// for portfolio side-by-side
			add_image_size( 'eight-columns', 460, 300, true ); 		// perfect for responsive - adjust height in CSS
			add_image_size( 'eight-columns-thin', 460, 250, true ); 	// Portfolio 1 Col / perfect for responsive - adjust height in CSS
			add_image_size( 'widget-thumb', 60, 60, true ); 		// used for widget thumbnail
		}
	}

	/* WP 3.1 Post Formats */
	// Add various post formats to use in the theme
	add_action('init', 'setup_post_formats_support');
	function setup_post_formats_support() {
		add_theme_support( 'post-formats', array('gallery', 'link', 'quote', 'audio', 'video'));
	}

	/* Translation/Localisation */
	/* Translations can be filed in the library/languages/ directory */
	add_action('init', 'my_theme_setup');
	function my_theme_setup(){
		load_theme_textdomain( 'yb', get_template_directory() . '/library/languages' );
	}

	$locale = get_locale();
	$locale_file = get_template_directory() . "/library/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once($locale_file);

	/* Basic permalink postname structure */
	add_action( 'init', function() {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
	} );

	/* Disable Admin Bar for Subscribers (Not Admins) */
	add_action('set_current_user', 'cc_hide_admin_bar');
	function cc_hide_admin_bar() {
		if (!current_user_can('edit_posts')) {
			show_admin_bar(false);
		}
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
					'content' => file_get_contents('http://www.ybdevel.com/dev/designcopy.txt'),
					'template' => 'dev.php',
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
		if( !is_admin() )
			return $query;
		global $pagenow, $wpdb;
		if( 'edit.php' == $pagenow && ( get_query_var('post_type') && 'page' == get_query_var('post_type') ) )
			foreach ( $exclude_pages as $page_slug ) {
				$page = get_page_by_path($page_slug);
				if ($page) {
					$query->set( 'post__not_in', array($page->ID) ); // array page ids
				} else {
					return $query;
				}
			}
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
		if ( !empty($ybwp_data['opt-checkbox-utilnav'] )) {
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
		if ( ((WP_ENV == 'development') || (WP_ENV == 'staging')) && !empty($ybwp_data['opt-checkbox-wireframes'] )) {
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

			if ( !empty($ybwp_data['opt-checkbox-blog'] )) {
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

			if( !empty($ybwp_data['opt-checkbox-footerwidgets'] )) {
				$footercolumns = "four";

				if(!empty($ybwp_data['opt-select-footercolumns'])) {
					if($ybwp_data['opt-select-footercolumns'] == "4"){ $footercolumns = "four"; }
					elseif($ybwp_data['opt-select-footercolumns'] ==  "3"){ $footercolumns = "one-third"; }
					elseif($ybwp_data['opt-select-footercolumns'] ==  "2"){ $footercolumns = "eight"; }
					elseif($ybwp_data['opt-select-footercolumns'] ==  "1"){ $footercolumns = "sixteen"; }
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

			if (!empty($ybwp_data['opt-checkbox-woocommerce']) && class_exists('Woocommerce')){
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
/* Automatic Plugin Activation */
/* ------------------------------------------------------------------------ */

	require_once('library/inc/plugin-activation.php');

	if ( !empty($ybwp_data['opt-checkbox-woocommerce'] )) {
		$woocommerce_plugin = array(
			'name'     				=> 'WooCommerce', // The plugin name
			'slug'     				=> 'woocommerce', // The plugin slug (typically the folder name)
			'source'   				=> 'http://downloads.wordpress.org/plugin/woocommerce.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 		=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		);
	} else {
		$woocommerce_plugin = '';
	}

	// add_action('tgmpa_register', 'yb_register_required_plugins');
	// function yb_register_required_plugins() {
		$plugins = array(
			$woocommerce_plugin,
	// 		array(
	// 			'name'     				=> 'Slider Revolution', // The plugin name
	// 			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
	// 			'source'   				=> get_template_directory_uri() . '/library/plugins/revslider.zip', // The plugin source
	// 			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
	// 			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
	// 			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
	// 			'force_deactivation' 		=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
	// 			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
	// 		),
	// 		array(
	// 			'name'     				=> 'FlexSlider', // The plugin name
	// 			'slug'     				=> 'flexslider', // The plugin slug (typically the folder name)
	// 			'source'   				=> get_template_directory_uri() . '/library/plugins/flexslider.zip', // The plugin source
	// 			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
	// 			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
	// 			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
	// 			'force_deactivation' 		=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
	// 			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
	// 		),
	// 		array(
	// 			'name'     				=> 'Post Types Order', // The plugin name
	// 			'slug'     				=> 'post-types-order', // The plugin slug (typically the folder name)
	// 			'source'   				=> get_template_directory_uri() . '/library/plugins/post-types-order.zip', // The plugin source
	// 			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
	// 			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
	// 			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
	// 			'force_deactivation' 		=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
	// 			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
	// 		),
		);

	// }

	/**
	* Array of configuration settings. Amend each line as needed.
	* If you want the default strings to be available under your own theme domain,
	* leave the strings uncommented.
	* Some of the strings are added into a sprintf, so see the comments at the
	* end of each line for what each argument will be.
	*/
	$config = array(
		'domain'       		=> 'yb',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         			// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 			// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 			// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      		=> true,                       		// Show admin notices or not
		'is_automatic'    		=> true,					// Automatically activate plugins after installation or not
		'message' 			=> '',						// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'yb' ),
			'menu_title'                       			=> __( 'Install Plugins', 'yb' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'yb' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'yb' ),
			'notice_can_install_required'     		=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'	=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  			=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    		=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'	=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 			=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 			=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 			=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  	=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'yb' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'yb' ),
			'complete' 						=> __( 'All plugins installed and activated successfully. %s', 'yb' ), // %1$s = dashboard link
			'nag_type'						=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa($plugins, $config);

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
		echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/library/css/login.css">';
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

	function custom_menu_order($menu_ord) {
		if (!$menu_ord) return true;

		return array(
			'index.php', // Dashboard
			'separator1', // First separator
			'edit.php?post_type=page', // Pages
			'edit.php', // Posts
			'edit.php?post_type=events',
			'edit.php?post_type=staff',
			'edit.php?post_type=gg_galleries',
			'edit.php?post_type=soliloquy',
			'upload.php', // Media
			'link-manager.php', // Links
			'edit-comments.php', // Comments
			'separator2', // Second separator
			'themes.php', // Appearance
			'plugins.php', // Plugins
			'users.php', // Users
			'tools.php', // Tools
			'options-general.php', // Settings
			'separator-last', // Last separator
		);
	}
	//add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
	//add_filter('menu_order', 'custom_menu_order');

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

	// Don't show the toolbar on front-end facing pages. This can be disabled to restore dashboard control.
	add_filter('show_admin_bar', '__return_false');

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
	add_action('pre_post_update', 'yb_page_menus_save_post' );
	function yb_page_menus_save_post( $post_id )
	{
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'yb_page_menus_nonce' ) ) return;

		// if( !current_user_can( 'edit_post' ) ) return;

		// save the data with update_post_meta
		$page_obj = get_post($post_id);
		$all_menus = wp_get_nav_menus();

		foreach ( $all_menus as $menu ) {
			// die(print_r($menu));
			$menuID = (int) $menu->term_id;
			if (isset($_POST['nav-menu-group']) && in_array($menu->name, $_POST['nav-menu-group'])) {
				if ( !checkMenuForPage($menuID, $post_id) ) {
					$itemData = array(
						'menu-item-object-id' => $post_id,
						'menu-item-title' 	=> get_the_title($post_id),
						'menu-item-url' 		=> get_permalink($post_id),
						'menu-item-object' 	=> 'page',
						'menu-item-position'  	=> $page_obj->menu_order,
						'menu-item-type' 	=> 'post_type',
						'menu-item-status' 	=> 'publish'
					);
					remove_action( 'save_post', 'yb_page_menus_save_post' );
					wp_update_nav_menu_item( $menuID, 0, $itemData );
					add_action( 'save_post', 'yb_page_menus_save_post' );
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
/* EOF
/* ------------------------------------------------------------------------ */
?>