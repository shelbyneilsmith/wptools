<?php
/*
Theme YB - A bastardization of the Bones Theme, Developed by Eddie Machado
Chopped up and pooped on by: Shelby Smith and Dalton Rowe at Yellowberri Creative Studio
URL: http://yellowberri.com
*/

/*********************
LAUNCH YB
Let's fire off all the functions
and tools. I put it up here so it's
right up top and clean.
*********************/

// we're firing all out initial functions at the start
add_action('after_setup_theme','yb_ahoy', 15);

function yb_ahoy() {
	//if ( ! isset( $content_width ) ) $content_width = 900;
	
    // launching operation cleanup
    add_action('init', 'yb_head_cleanup');
    add_action('init', 'yb_menus');
    // remove WP version from RSS
    add_filter('the_generator', 'yb_rss_version');
    // clean up gallery output in wp
    add_filter('gallery_style', 'yb_gallery_style');

    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'yb_scripts_and_styles', 999);
    // ie conditional wrapper
    add_filter( 'style_loader_tag', 'yb_ie_conditional', 10, 2 );

    // launching this stuff after theme setup
    add_action('after_setup_theme','yb_theme_support');
    // adding sidebars to Wordpress (these are created in functions.php)
    add_action( 'widgets_init', 'yb_register_sidebars' );
    // adding the yb search form (created in functions.php)
    add_filter( 'get_search_form', 'yb_wpsearch' );

    // cleaning up random code around images
    add_filter('the_content', 'yb_filter_ptags_on_images');

} /* end yb ahoy */

/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function yb_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
  // remove WP version from css
  //add_filter( 'style_loader_src', 'yb_remove_wp_ver_css_js', 9999 );
  // remove Wp version from scripts
  //add_filter( 'script_loader_src', 'yb_remove_wp_ver_css_js', 9999 );

} /* end yb head cleanup */

// remove WP version from RSS
function yb_rss_version() { return ''; }

// remove WP version from scripts
function yb_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// remove injected CSS from gallery
function yb_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function yb_scripts_and_styles() {
  if (!is_admin()) {

    // register main stylesheet
    wp_register_style( 'yb-stylesheet', get_stylesheet_directory_uri() . '/library/css/screen.css', array(), '', 'all' );

    // ie-only style sheet
    wp_register_style( 'yb-ie-only', get_stylesheet_directory_uri() . '/library/css/ie.css', array(), '' );


    //adding scripts file in the footer
    wp_register_script( 'yb-js', get_stylesheet_directory_uri() . '/library/_scripts/scripts.js', array( 'jquery' ), '', true );
    
    //add_action('wp_enqueue_scripts', 'yb_scripts');
    //function yb_scripts() {
	    // comment reply script for threaded comments
	    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
	      wp_enqueue_script( 'comment-reply' );
	    }
	    
	    wp_enqueue_script( 'jquery' );
	    wp_enqueue_script( 'yb-js' );

	    wp_enqueue_style( 'yb-stylesheet' );
	    wp_enqueue_style('yb-ie-only');
    //}

  }
}

// adding the conditional wrapper around ie stylesheet
// source: http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/
function yb_ie_conditional( $tag, $handle ) {
	if ( 'yb-ie-only' == $handle )
		$tag = '<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
	return $tag;
}

/* Register the theme menus */
function yb_menus() {
	// wp menus
	add_theme_support( 'menus' );

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => 'Main Navigation',   // main nav in header
			'footer-nav' => 'Footer Navigation' // secondary nav in footer
		)
	);
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function yb_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support('post-thumbnails');

	// default thumb size
	set_post_thumbnail_size(125, 125, true);


	// wp custom background (thx to @bransonwerner for update)
/*
	add_theme_support( 'custom-background',
	    array(
	    'default-image' => '',  // background image default
	    'default-color' => '', // background color default (dont add the #)
	    'wp-head-callback' => '_custom_background_cb',
	    'admin-head-callback' => '',
	    'admin-preview-callback' => ''
	    )
	);
*/

	// rss thingy
	//add_theme_support('automatic-feed-links');

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	// adding post format support
/*
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	);
*/

} /* end yb theme support */


/************* COMMENT LAYOUT *********************/
		
// Comment Layout
function yb_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
	    <?php 
	    /*
	        this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
	        echo get_avatar($comment,$size='32',$default='<path_to_url>' );
	    */ 
	    ?>
	    <!-- custom gravatar call -->
	    <?php
	    	// create variable
	    	$bgauthemail = get_comment_author_email();
	    ?>
	    <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
	    <!-- end custom gravatar call -->
		<?php printf('<cite class="fn">%s</cite>', get_comment_author_link()) ?>
		<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time('F jS, Y'); ?> </a></time>
		<?php edit_comment_link('(Edit)','  ','') ?>

		<?php if ($comment->comment_approved == '0') : ?>
   			<div class="alert info">
      			<p>Your comment is awaiting moderation.</p>
      		</div>
		<?php endif; ?>
		<section class="comment_content clearfix">
			<?php comment_text() ?>
		</section>
		<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    <!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!


/************* SEARCH FORM LAYOUT *****************/

// Search Form
function yb_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">Search for:</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr('Search the Site...').'" />
    <input type="submit" id="searchsubmit" value="'. esc_attr('Search') .'" />
    </form>';
    return $form;
} // don't remove this bracket!


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
		echo '<li class="bpn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
	}
	echo '<li class="bpn-prev-link">';
	previous_posts_link('<<');
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="bpn-current">'.$i.'</li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="bpn-next-link">';
	next_posts_link('>>');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = "Last";
		echo '<li class="bpn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
	}
	echo '</ol></nav>'.$after."";
} /* end page navi */


/*
function post_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<ul class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
         if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
             	 echo "<li>";
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
                 echo "</li>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
         echo "</ul>\n";
     }
}
*/

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function yb_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


?>
