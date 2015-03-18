<?php
/* ------------------------------------------------------------------------ */
/* function to find if page is blog page */
/* ------------------------------------------------------------------------ */
	function is_blog () {
		global $post;
		$posttype = get_post_type($post );
		return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
	}

/* ------------------------------------------------------------------------ */
/* Sidebar Position Class */
/* ------------------------------------------------------------------------ */
	function sidebarPosClass($page_layout) {
		if ( ( $page_layout === "Centered Left Sidebar" ) || ( $page_layout === "Centered Right Sidebar" ) ) {
			$contentColumns = "twelve";
			if ( $page_layout === "Centered Left Sidebar" ) {
				$sidebar_pos = 'sidebar-left';
			}
			if ( $page_layout === "Centered Right Sidebar" ) {
				$sidebar_pos = 'sidebar-right';
			}
		} else {
			$contentColumns = "sixteen";
			$sidebar_pos = '';
		}

		echo $sidebar_pos . ' ' . $contentColumns;
	}

/* ------------------------------------------------------------------------ */
/* Comment Layout */
/* ------------------------------------------------------------------------ */

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

/* ------------------------------------------------------------------------ */
/* Breadcrumbs Layout */
/* ------------------------------------------------------------------------ */
	function yb_breadcrumbs() {
		global $ybwp_data;

		$crumbs = '';
		$showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter = '/'; // delimiter between crumbs
		$home = get_bloginfo('name'); // text for the 'Home' link
		$blog = $ybwp_data['opt-text-blogbreadcrumb'];
		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$before = '<span class="current">'; // tag before the current crumb
		$after = '</span>'; // tag after the current crumb

		global $post;
		$homeLink = home_url();

		if (is_home() || is_front_page()) {

			if ($showOnHome == 1) $crumbs .= '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ' . $blog . '</a></div>';

		} else {

			$crumbs .= '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

			if ( is_category() ) {
				$thisCat = get_category(get_query_var('cat'), false);
				if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
				$crumbs .= $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;

			} elseif ( is_search() ) {
				$crumbs .= $before . 'Search results for "' . get_search_query() . '"' . $after;

			} elseif ( is_day() ) {
				$crumbs .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
				$crumbs .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
				$crumbs .= $before . get_the_time('d') . $after;

			} elseif ( is_month() ) {
				$crumbs .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
				$crumbs .= $before . get_the_time('F') . $after;

			} elseif ( is_year() ) {
				$crumbs .= $before . get_the_time('Y') . $after;

			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					$crumbs .= '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
					if ($showCurrent == 1) $crumbs .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
					$crumbs .= $cats;
					if ($showCurrent == 1) $crumbs .= $before . get_the_title() . $after;
				}

			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object(get_post_type());
				$crumbs .= $before . $post_type->labels->singular_name . $after;

			} elseif ( is_attachment() ) {
				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID); $cat = $cat[0];
				$crumbs .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				$crumbs .= '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
				if ($showCurrent == 1) $crumbs .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

			} elseif ( is_page() && !$post->post_parent ) {
				if ($showCurrent == 1) $crumbs .= $before . get_the_title() . $after;

			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					$crumbs .= $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) $crumbs .= ' ' . $delimiter . ' ';
				}
				if ($showCurrent == 1) $crumbs .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

			} elseif ( is_tag() ) {
				$crumbs .= $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;

			} elseif ( is_author() ) {
				 global $author;
				$userdata = get_userdata($author);
				$crumbs .= $before . 'Articles posted by ' . $userdata->display_name . $after;

			} elseif ( is_404() ) {
				$crumbs .= $before . 'Error 404' . $after;
			}

			if ( get_query_var('paged') ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $crumbs .= ' (';
				$crumbs .= __('Page', 'yb') . ' ' . get_query_var('paged');
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $crumbs .= ')';
			}

			$crumbs .= '</div>';

		}
		return $crumbs;
	}

/* ------------------------------------------------------------------------ */
/* Byline Formatting */
/* ------------------------------------------------------------------------ */
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

/* ------------------------------------------------------------------------ */
/* Page Navigation Options */
/* ------------------------------------------------------------------------ */
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
/* Word Limiter */
/* ------------------------------------------------------------------------ */
	function limit_words($string, $word_limit) {
		$words = explode(' ', $string);
		return implode(' ', array_slice($words, 0, $word_limit));
	}

/* ------------------------------------------------------------------------ */
/* Output Social Icons */
/* ------------------------------------------------------------------------ */
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
		if( $ybwp_data['opt-text-social-googleplus'] != "" ) {
			$socialicons .= '<li class="social-googleplus"><a href="'.$ybwp_data['opt-text-social-googleplus'].'" target="_blank" title="'.__( 'Google+', 'yb' ).'">'.__( 'Google+', 'yb' ).'</a></li>';
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

/* ------------------------------------------------------------------------ */
/* Dev/Styletile Functions */
/* ------------------------------------------------------------------------ */
	function styleTileLinks($options = 1, $abc) {
		global $ybwp_data;
		$output = "<ul class='style-tile-links'>";
		$i = 0;

		if ( !empty($ybwp_data['opt-checkbox-styletilestk']) && !empty($ybwp_data['opt-text-typekitid']) ) {
			$typekit_id = "&tkid=" . $ybwp_data['opt-text-typekitid'];
		} else {
			$typekit_id = '';
		}

		while ($i < $options) {
			$output .= "<li><a href='http://www.ybdevel.com/dev/styletile.php?option=" . $abc[$i] . "&pathroot=" . get_template_directory_uri() . "&palettenum=" . $ybwp_data['opt-text-colorsnum'] . $typekit_id . "'>Option " . strtoupper($abc[$i]) . "</a></li>";
			$i++;
		}

		$output .= "</ul>";
		return $output;
	}

	function iframeTiles($tiles = 1, $abc) {
		global $ybwp_data;
		$i = 0;
		$output = '';

		if ( !empty($ybwp_data['opt-checkbox-styletilestk']) && !empty($ybwp_data['opt-text-typekitid']) ) {
			$typekit_id = "&tkid=" . $ybwp_data['opt-text-typekitid'];
		} else {
			$typekit_id = '';
		}

		while ($i < $tiles) {
			$output .= '<iframe class="style-tile-iframe tile-' . ($i + 1) . '" src="http://www.ybdevel.com/dev/styletile.php?option=' . $abc[$i] . '&pathroot=' . get_template_directory_uri() . '&palettenum=' . $ybwp_data['opt-text-colorsnum'] . $typekit_id . '" frameborder="0"></iframe>';
			$i++;
		}

		return $output;
	}

?>