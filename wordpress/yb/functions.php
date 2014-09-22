<?php
/*
Author: Shelby Smith
URL: htp://yellowberri.com

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.

*/
// /* ------------------------------------------------------------------------ */
// /* Include REDUX Framework */
global $ybwp_data;

// if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/admin_redux/redux-framework/ReduxCore/framework.php' ) ) {
//     require_once( dirname( __FILE__ ) . '/admin_redux/redux-framework/ReduxCore/framework.php' );
// }
// if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/admin_redux/options-init.php' ) ) {
//     require_once( dirname( __FILE__ ) . '/admin_redux/options-init.php' );
// }
/**
 * Add Redux Framework & extras
 */
require get_template_directory() . '/admin/admin-init.php';

/* ------------------------------------------------------------------------ */
/* WP_HEAD GOODNESS
/* The default wordpress head is
/* a mess. Let's clean it up by
/* removing all the junk we don't
/* need.
/* ------------------------------------------------------------------------ */
	add_action('init', 'yb_head_cleanup');
	function yb_head_cleanup() {
		// EditURI link
		remove_action( 'wp_head', 'rsd_link' );
		// windows live writer
		remove_action( 'wp_head', 'wlwmanifest_link' );
		// WP version
		remove_action( 'wp_head', 'wp_generator' );
		// Remove feed links
		remove_action('wp_head', 'feed_links_extra', 3 );
		remove_action('wp_head', 'feed_links', 2 );
	} /* end yb head cleanup */

/* ------------------------------------------------------------------------ */
/* Basic permalink postname structure */
	add_action( 'init', function() {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
	} );


// function to find if page is blog page
	function is_blog () {
		global $post;
		$posttype = get_post_type($post );
		return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
	}

/* ------------------------------------------------------------------------ */
/* Translation
/* ------------------------------------------------------------------------ */

	/* ------------------------------------------------------------------------ */
	/* Translations can be filed in the library/languages/ directory */
	add_action('after_setup_theme', 'my_theme_setup');
	function my_theme_setup(){
		load_theme_textdomain( 'yb', get_template_directory() . '/library/languages' );
	}

	$locale = get_locale();
	$locale_file = get_template_directory() . "/library/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once($locale_file);

/* ------------------------------------------------------------------------ */
/* Includes
/* ------------------------------------------------------------------------ */
	/* ------------------------------------------------------------------------ */
	/* Misc Includes */
	// include_once('library/inc/googlefonts.php'); // Load Google Fonts
	include_once('library/inc/enqueue.php'); // Enqueue JavaScripts & CSS
	include_once('library/inc/customjs.php'); // Load Custom JS
	include_once('library/inc/shortcodes.php'); // Load Shortcodes

	if ( empty($ybwp_data['opt-checkbox-blogbreadcrumbs']) && empty($ybwp_data['opt-checkbox-woocommercebreadcrumbs'] )) {
		include_once('library/inc/breadcrumbs.php'); // Load Breadcrumbs
	}

	// if ( $data['check_portfoliotype'] == true ) {
	// 	include_once('library/inc/cpt-portfolio.php'); // Portfolio
	// }
	// /* -------------------------------- ---------------------------------------- */
	// /* Widget Includes */
	include_once('library/inc/widgets/embed.php');
	include_once('library/inc/widgets/sponsor.php');
	include_once('library/inc/widgets/contact.php');
	include_once('library/inc/widgets/custommenu.php');

	if ( !empty($ybwp_data['opt-checkbox-twitterwidget'] )) {
		include_once('library/inc/widgets/twitter.php');
	}
	if ( !empty($ybwp_data['opt-checkbox-facebookwidget'] )) {
		include_once('library/inc/widgets/facebook.php');
	}
	// if ( $data['check_portfoliotype'] == true ) {
	// 	include_once('library/inc/widgets/portfolio.php');
	// }

	// /* ------------------------------------------------------------------------ */
	// /* Include Meta Box Script */
	define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/library/inc/meta-box' ) );
	define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/library/inc/meta-box' ) );
	require_once RWMB_DIR . 'meta-box.php';
	include 'library/inc/meta-boxes.php';
	// if ( $data['check_portfoliotype'] == true ) {
	// 	include 'library/inc/portfolio-meta-boxes.php';
	// }

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
	// 		array(
	// 			'name'     				=> 'CF-Post-Formats', // The plugin name
	// 			'slug'     				=> 'cf-post-formats', // The plugin slug (typically the folder name)
	// 			'source'   				=> get_template_directory_uri() . '/library/plugins/cf-post-formats.zip', // The plugin source
	// 			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
	// 			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
	// 			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
	// 			'force_deactivation' 		=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
	// 			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
	// 		),
	// 		array(
	// 			'name'     				=> 'Recent Tweets Widget', // The plugin name
	// 			'slug'     				=> 'recent-tweets-widget', // The plugin slug (typically the folder name)
	// 			'source'   				=> get_template_directory_uri() . '/library/plugins/recent-tweets-widget.zip', // The plugin source
	// 			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
	// 			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
	// 			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
	// 			'force_deactivation' 		=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
	// 			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
	// 		),
	// 		array(
	//            		'name'      => 'Contact Form 7',
	//            		'slug'      => 'contact-form-7',
	//            		'required'  => false,
	//            ),
	//            array(
	// 			'name'     				=> 'SMK Sidebar Generator', // The plugin name
	// 			'slug'     				=> 'smk-sidebar-generator', // The plugin slug (typically the folder name)
	// 			'source'   				=> get_template_directory_uri() . '/library/plugins/smk-sidebar-generator.zip', // The plugin source
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
/* Comment Layout */

	function yb_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; ?>

		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">

				<div class="avatar"><?php echo get_avatar($comment, $size = '50'); ?></div>

				<div class="comment-text">

				 <div class="author">
					<span><?php if($comment->comment_author_url == '' || $comment->comment_author_url == 'http://Website'){ echo get_comment_author(); } else { echo comment_author_link(); } ?></span>
					<div class="date">
					<?php printf(__('%1$s at %2$s', 'yb'), get_comment_date(),  get_comment_time() ) ?></a><?php edit_comment_link( __( '(Edit)', 'yb'),'  ','' ) ?>
						&middot; <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>  </div>
				 </div>

				 <div class="text"><?php comment_text() ?></div>


				 <?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'yb' ) ?></em>
					<br />
					<?php endif; ?>

				</div>

		</div>
	<?php
	}

// format the byline
	function yb_byline($post) {
		$author_id = $post->post_author;
		$category = get_the_category($post->ID);

		if ($category) {
			$cat_text = ' in <a href="'. esc_url( get_category_link( get_cat_ID( $category[0]->cat_name ) ) ) .'">'. $category[0]->cat_name .'</a>';
		} else {
			$cat_text = "";
		}

		return '<p class="byline">By <span class="author"><a href="'. get_author_posts_url( get_the_author_meta( 'ID', $author_id ) ) .'">'. get_the_author_meta( 'display_name', $author_id ) .'</a></span> on <time class="updated" datetime="'. get_the_time('Y-m-j', $post->ID) .'" pubdate>'. get_the_time('F jS, Y', $post->ID) .'</time>'. $cat_text .'</p>';

	}

/*********************
PAGE NAVI
*********************/

	// Numeric Page Navi (built into the theme by default)
	function yb_pagination($before = '', $after = '') {
		global $wpdb, $wp_query;
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;
		if ( $numposts <= $posts_per_page ) { return; }
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		$pages_to_show = 7;
		$pages_to_show_minus_1 = $pages_to_show-1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}
		echo $before.'<nav class="page-navigation"><ol class="yb_page_navi clearfix">'."";
		if ($start_page >= 2 && $pages_to_show < $max_page) {
			$first_page_text = "First";
			echo '<li class="first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
		}
		echo '<li class="prev-link">';
		previous_posts_link('<<');
		echo '</li>';
		for($i = $start_page; $i  <= $end_page; $i++) {
			if($i == $paged) {
				echo '<li class="current">'.$i.'</li>';
			} else {
				echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
			}
		}
		echo '<li class="next-link">';
		next_posts_link('>>');
		echo '</li>';
		if ($end_page < $max_page) {
			$last_page_text = "Last";
			echo '<li class="last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
		}
		echo '</ol></nav>'.$after."";
	} /* end page navi */

	function yb_pagination_2($pages = '', $range = 4) {
		$showitems = ($range * 2)+1;

		global $paged;
		if(empty($paged)) $paged = 1;

		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}

		if(1 != $pages) {
			echo "<span class='allpages'>" . __('Page', 'yb') . " ".$paged." " . __('of', 'yb') . " ".$pages."</span>";
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; " . __('First', 'yb') . "</a>";
			if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; " . __('Previous', 'yb') . "</a>";

			echo '<nav class="page-navigation"><ol class="yb_page_navi clearfix">'."";
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
					echo ($paged == $i)? "<li class=\"current\">".$i."</li>":"<li><a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a></li>";
				}
			}
			echo '</ol></nav>';

			if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">" . __('Next', 'yb') . " &rsaquo;</a>";
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>" . __('Last', 'yb') . " &raquo;</a>";
		}
	}

/* ------------------------------------------------------------------------ */
/* Custom Excerpt Length */

	function new_excerpt_length($length) {
		global $ybwp_data;
		return $ybwp_data['opt-text-excerptlength'];
	}
	add_filter('excerpt_length', 'new_excerpt_length');

// Changing excerpt more
	if( !empty($ybwp_data['opt-checkbox-readmore']) ) { // Admin Option Check
		function new_excerpt_more($more) {
			global $post;
			return '… <a href="'. get_permalink($post->ID) . '" class="read-more-link">' . '' . __('read more', 'yb') . ' &rarr;' . '</a>';
		}
		add_filter('excerpt_more', 'new_excerpt_more');
	}

// Word Limiter
	function limit_words($string, $word_limit) {
		$words = explode(' ', $string);
		return implode(' ', array_slice($words, 0, $word_limit));
	}

/* ------------------------------------------------------------------------ */
/* Post Thumbnails */
	if ( function_exists( 'add_image_size' ) ) add_theme_support( 'post-thumbnails' );

	if ( function_exists( 'add_image_size' ) ) {
		add_image_size( 'standard', 700, 300, true );			// Standard Blog Image
		add_image_size( 'blog-medium', 320, 210, true );		// Medium Blog Image
		add_image_size( 'sixteen-columns', 940, 475, true ); 	// for portfolio wide
		add_image_size( 'ten-columns', 640, 500, true );		// for portfolio side-by-side
		add_image_size( 'eight-columns', 460, 300, true ); 		// perfect for responsive - adjust height in CSS
		add_image_size( 'eight-columns-thin', 460, 250, true ); // Portfolio 1 Col / perfect for responsive - adjust height in CSS
		add_image_size( 'widget-thumb', 60, 60, true ); 				// used for widget thumbnail
	}

/* ------------------------------------------------------------------------ */
/* Add RSS Links to head section */
	add_theme_support( 'automatic-feed-links' );

/* ------------------------------------------------------------------------ */
/* WP 3.1 Post Formats */
	add_theme_support( 'post-formats', array('gallery', 'link', 'quote', 'audio', 'video'));

/* ------------------------------------------------------------------------ */
/* Set up default pages */
	add_action('init', 'setup_default_pages');
	function setup_default_pages() {

		$default_pages = array(
			'Home' => array(
				'content' => 'This is the page content',
				'template' => '',
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
	add_action('init', 'register_yb_menus');
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

	$footercolumns = "four";

	if(!empty($ybwp_data['opt-select-footercolumns'])) {
		if($ybwp_data['opt-select-footercolumns'] == "4"){ $footercolumns = "four"; }
		elseif($ybwp_data['opt-select-footercolumns'] ==  "3"){ $footercolumns = "one-third"; }
		elseif($ybwp_data['opt-select-_footercolumns'] ==  "2"){ $footercolumns = "eight"; }
		elseif($ybwp_data['opt-select-footercolumns'] ==  "1"){ $footercolumns = "sixteen"; }
	}
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

/* ------------------------------------------------------------------------ */
/* WooCommerce
/* ------------------------------------------------------------------------ */
if (!empty($ybwp_data['opt-checkbox-woocommerce']) && class_exists('Woocommerce')){

	// Add WooCommerce Theme Support
	add_theme_support('woocommerce');

	// Disable WooCommerce CSS
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
}

	// Disable Admin Bar for Subscribers (Not Admins)
	add_action('set_current_user', 'cc_hide_admin_bar');
	function cc_hide_admin_bar() {
		if (!current_user_can('edit_posts')) {
			show_admin_bar(false);
		}
	}

/************* CUSTOM LOGIN PAGE *****************/

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

/************* CUSTOMIZE ADMIN *******************/

/*
I don't really recommend editing the admin too much
as things may get funky if WordPress updates. Here
are a few funtions which you can choose to use if
you like.
*/

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


// Page Menus Meta Box
add_action( 'add_meta_boxes', 'yb_page_menus_add_meta_box' );
// /**
//  * Adds the meta box to the page screen
//  */
function yb_page_menus_add_meta_box( $post_type ) {
	add_meta_box(
		'yb_page_menus-meta-box', // id, used as the html id att
		__('Add to Menus'), // meta box title, like "Page Attributes"
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

//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

// Add mobile menu body classes
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

function outputSocialIcons() {
	global $ybwp_data;

	$socialicons = '';

	if( $ybwp_data['opt-text-social-twitter'] != "" ) {
		$socialicons .= '<li class="social-twitter"><a href="http://www.twitter.com/'.$ybwp_data['opt-text-social-twitter'].'" target="_blank" title="'.__( 'Twitter', 'yb' ).'">'.__( 'Twitter', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-forrst'] != "" ) {
		$socialicons .= '<li class="social-forrst"><a href="'.$ybwp_data['opt-text-social-forrst'].'" target="_blank" title="'.__( 'Forrst', 'yb' ).'">'.__( 'Forrst', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-dribbble'] != "" ) {
		$socialicons .= '<li class="social-dribbble"><a href="'.$ybwp_data['opt-text-social-dribbble'].'" target="_blank" title="'.__( 'Dribbble', 'yb' ).'">'.__( 'Dribbble', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-flickr'] != "" ) {
		$socialicons .= '<li class="social-flickr"><a href="'.$ybwp_data['opt-text-social-flickr'].'" target="_blank" title="'.__( 'Flickr', 'yb' ).'">'.__( 'Flickr', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-facebook'] != "" ) {
		$socialicons .= '<li class="social-facebook"><a href="'.$ybwp_data['opt-text-social-facebook'].'" target="_blank" title="'.__( 'Facebook', 'yb' ).'">'.__( 'Facebook', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-skype'] != "" ) {
		$socialicons .= '<li class="social-skype"><a href="'.$ybwp_data['opt-text-social-skype'].'" target="_blank" title="'.__( 'Skype', 'yb' ).'">'.__( 'Skype', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-digg'] != "" ) {
		$socialicons .= '<li class="social-digg"><a href="'.$ybwp_data['opt-text-social-digg'].'" target="_blank" title="'.__( 'Digg', 'yb' ).'">'.__( 'Digg', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-google'] != "" ) {
		$socialicons .= '<li class="social-google"><a href="'.$ybwp_data['opt-text-social-google'].'" target="_blank" title="'.__( 'Google', 'yb' ).'">'.__( 'Google+', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-instagram'] != "" ) {
		$socialicons .= '<li class="social-instagram"><a href="'.$ybwp_data['opt-text-social-instagram'].'" target="_blank" title="'.__( 'Instagram', 'yb' ).'">'.__( 'Instagram', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-linkedin'] != "" ) {
		$socialicons .= '<li class="social-linkedin"><a href="'.$ybwp_data['opt-text-social-linkedin'].'" target="_blank" title="'.__( 'LinkedIn', 'yb' ).'">'.__( 'LinkedIn', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-vimeo'] != "" ) {
		$socialicons .= '<li class="social-vimeo"><a href="'.$ybwp_data['opt-text-social-vimeo'].'" target="_blank" title="'.__( 'Vimeo', 'yb' ).'">'.__( 'Vimeo', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-yahoo'] != "" ) {
		$socialicons .= '<li class="social-yahoo"><a href="'.$ybwp_data['opt-text-social-yahoo'].'" target="_blank" title="'.__( 'Yahoo', 'yb' ).'">'.__( 'Yahoo', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-tumblr'] != "" ) {
		$socialicons .= '<li class="social-tumblr"><a href="'.$ybwp_data['opt-text-social-tumblr'].'" target="_blank" title="'.__( 'Tumblr', 'yb' ).'">'.__( 'Tumblr', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-youtube'] != "" ) {
		$socialicons .= '<li class="social-youtube"><a href="'.$ybwp_data['opt-text-social-youtube'].'" target="_blank" title="'.__( 'YouTube', 'yb' ).'">'.__( 'YouTube', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-deviantart'] != "" ) {
		$socialicons .= '<li class="social-deviantart"><a href="'.$ybwp_data['opt-text-social-deviantart'].'" target="_blank" title="'.__( 'DeviantArt', 'yb' ).'">'.__( 'DeviantArt', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-behance'] != "" ) {
		$socialicons .= '<li class="social-behance"><a href="'.$ybwp_data['opt-text-social-behance'].'" target="_blank" title="'.__( 'Behance', 'yb' ).'">'.__( 'Behance', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-pinterest'] != "" ) {
		$socialicons .= '<li class="social-pinterest"><a href="'.$ybwp_data['opt-text-social-pinterest'].'" target="_blank" title="'.__( 'Pinterest', 'yb' ).'">'.__( 'Pinterest', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-text-social-delicious'] != "" ) {
		$socialicons .= '<li class="social-delicious"><a href="'.$ybwp_data['opt-text-social-delicious'].'" target="_blank" title="'.__( 'Delicious', 'yb' ).'">'.__( 'Delicious', 'yb' ).'</a></li>';
	}
	if( $ybwp_data['opt-checkbox-social-rss'] ) {
		$socialicons .= '<li class="social-rss"><a href="'.get_bloginfo('rss2_url').'" target="_blank" title="'.__( 'RSS', 'yb' ).'">'.__( 'RSS', 'yb' ).'</a></li>';
	}

	return $socialicons;
}

function main_bg() {
	global $ybwp_data, $post;

	$opt_bg = '';

	if ( ( !empty($ybwp_data['opt-checkbox-bgimg']) && !empty($ybwp_data['opt-media-bgimg']['url'] ) ) || ( has_post_thumbnail() && get_post_meta( get_the_ID(), 'yb_page-bg-override', true ) ) ) {
		if ( has_post_thumbnail() && get_post_meta( get_the_ID(), 'yb_page-bg-override', true ) ) {
			$bg_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' );
			$bg_src = $bg_src[0];
			$bg_style = get_post_meta( get_the_ID(), 'yb_bgstyle', true );
		} else {
			$bg_src = $ybwp_data['opt-media-bgimg']['url'];
			$bg_style = $ybwp_data['opt-select-bgimgstyle'];
		}
		$opt_bg .= 'style="background-image: url('.$bg_src.');';
		if ( $bg_style == 'stretch' ) {
			$opt_bg .= ' background-repeat: no-repeat;';
			$opt_bg .= ' background-size: 100%;';
		} else {
			$opt_bg .= ' background-repeat: '.$bg_style.';';
		}
		if ( $bg_style == 'no-repeat' ) {
			$opt_bg .= 'background-position: center;';
		}
		$opt_bg .= '"';
	}
	echo $opt_bg;
}

// Dev/Styletile Functions
function styleTileLinks($options = 1, $abc) {
	global $ybwp_data;
	$output = "<ul class='style-tile-links'>";
	$i = 0;

	while ($i < $options) {
		$output .= "<li><a href='http://www.ybdevel.com/dev/styletile.php?option=" . $abc[$i] . "&pathroot=" . get_template_directory_uri() . "&palettenum=" . $ybwp_data['opt-text-colorsnum'] . "'>Option " . strtoupper($abc[$i]) . "</a></li>";
		$i++;
	}

	$output .= "</ul>";
	return $output;
}

function iframeTiles($tiles = 1, $abc) {
	global $ybwp_data;
	$i = 0;
	$output = '';

	while ($i < $tiles) {
		$output .= '<iframe class="style-tile-iframe tile-' . ($i + 1) . '" src="http://www.ybdevel.com/dev/styletile.php?option=' . $abc[$i] . '&pathroot=' . get_template_directory_uri() . '&palettenum=' . $ybwp_data['opt-text-colorsnum'] . '" frameborder="0"></iframe>';
		$i++;
	}

	return $output;
}

/* ------------------------------------------------------------------------ */
/* EOF
/* ------------------------------------------------------------------------ */
?>