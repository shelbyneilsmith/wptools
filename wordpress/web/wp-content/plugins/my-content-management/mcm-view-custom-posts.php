<?php
/*
@type = string = post_type 
@display = string: custom, full, excerpt, list
@taxonomy = string = taxonomy
@term = string = term slug
@count = integer = number of posts to display
@order = string = orderby options: none,ID,author,title,date,modified,parent,rand,comment_count,menu_order,meta_value,meta_value_num
@direction = string = ASC/DESC
@meta_key = Custom key if order by menu_order
@template = template name or template if $display = 'custom'
@offset = number of items to skip
@id = specific post ID
@custom = custom variable; can be anything
@operator = IN, NOT IN, or AND
*/

function mcm_get_single_post( $type, $id ) {
	return mcm_get_show_posts( $type, 'full', 'all','','','','','','','','',$id,'','','','','','','' );
}

function mcm_get_show_posts(  $type, $display, $taxonomy, $term, $count, $order, $direction, $meta_key, $template, $cache, $offset, $id, $custom_wrapper, $custom, $operator, $year='', $month='', $week='', $day='' ) {
global $mcm_templates, $mcm_types;
$templates = $mcm_templates; $types = $mcm_types;
	$the_cache = false;
	if ( $cache != false ) {
		$cache_key = md5( $type . $display . $taxonomy . $term . $count . $order . $direction . $meta_key . $template . $offset . $id . $year . $month . $week . $day);
		$the_cache = get_transient( "mcm_$cache_key" );
	}
	if ( $the_cache ) { 
		return $the_cache; 
	} else {
	$keys = array_keys($types);
	$mcm = true;
	// check if this post type is coming from MCM
	$post_types = explode( ',', $type );
	$types = array();
	foreach ( $post_types as $t ) {
		if ( !in_array($t,$keys,true) && in_array('mcm_'.$t,$keys,true ) ) { // second argument negative in tot
			$types[] = 'mcm_'.$t;
		} else {
			$types[] = $t;
		}
	}
	$primary = $types[0];
		if ( !in_array($primary,$keys,true) && !in_array('mcm_'.$primary,$keys,true ) ) {
			$wrapper = ( $template != '' )?$template:'mcm_people';
			$mcm = false;		
		} else {
			$wrapper = ( $template != '' )?$template:$primary;
		}
	if ($taxonomy != 'all') {
		$taxonomies = explode( ',', $taxonomy );
		$taxes = array();
		foreach ( $taxonomies as $tax ) {
			$search = array( 'category_' );
			$tax_root = str_replace( $search,'',$taxonomy );
			if ( in_array( $tax_root, $keys, true ) ) { 
				$taxes[] = $tax; 
			} else { 
				if ( in_array( 'mcm_'.$tax_root,$keys,true ) ) {
					$taxes[] = 'mcm_'.$tax;
				} else {
					$taxes[] = $tax;
				}
			}
		}
	}
	// get wrapper element
	if ( $display == 'custom' ) {
		$elem = '';
		$wrapper = $template;
	} else {
		$elem = ( isset($templates[$wrapper]['wrapper']['list'][$display]) )?$templates[$wrapper]['wrapper']['list'][$display]:'div';	
	}
	$wrapper = trim($wrapper);
	$column = 'odd';
	$return = '';
	
	if ( $id == false ) {
		// set up arguments for loop
		wp_reset_query();
		$args = array( 'post_type' => $types, 'posts_per_page'=>$count, 'orderby'=>$order, 'order'=>$direction );
		if ( $year != '' ) { $args['year'] = (int) $year; }
		if ( $month != '' ) { $args['monthnum'] = (int) $month; }
		if ( $day != '' ) { $args['day'] = (int) $day; }
		if ( $week != '' ) { $args['w'] = (int) $week; }
		if ( $offset != false ) { $args['offset']= (int) $offset; }
		// if there is a taxonomy, and there's a term, but just one taxonomy
		if ($taxonomy != 'all' && strpos( $taxonomy, ',') === false ) {
			if ( $term == '' ) {
				// don't include the query if no terms
			} else {
				if ( strpos($term, ',' ) !== false ) {
					$term = explode( ',',$term );
				}
				$args['tax_query'] = array( array( 'taxonomy' => $taxes[0], 'field' => 'slug', 'terms' => $term, 'operator'=>$operator ) ); 
			}
		}
		// if there are multiple taxonomies and multiple terms
		if ( strpos( $taxonomy, ',' ) !== false && strpos($term, ',' ) !== false ) {
			$terms = explode( ',', $term );
			$i = 0;
			$tax_query = array();
			foreach ( $taxes as $t ) {
				$array = array( 'taxonomy' => $t, 'field' => 'slug', 'terms' => $terms[$i], 'operator'=>$operator );
				$tax_query[] = $array;
				$i++;
			}
			$tax_query['relation']='AND';
			$args['tax_query'] = $tax_query; 
		}

		if ( $order == 'meta_value' || $order == 'meta_value_num' ) { $args['meta_key'] = $meta_key; }
		
		$debug = false;
		if ( $debug ) {
		echo "<pre>";
		print_r($args);
		echo "</pre>";
		}
		$loop = new WP_Query( $args );
		$last_term = false;
		$last_post = false;
		$first = true;
		while ( $loop->have_posts() ) : $loop->the_post();
			$p = array();
			$id = get_the_ID();
			$p['id'] = $id;
			$p['permalink'] = get_permalink();
			$p['link_title'] = "<a href='".get_permalink()."'>".get_the_title()."</a>";			
			$p['title'] = get_the_title();			
			$p['excerpt'] = wpautop( get_the_excerpt() );
			$p['excerpt_raw'] = get_the_excerpt();
			$p['content'] = do_shortcode( wpautop( get_the_content() ) );
			$p['content_raw'] = get_the_content();
			$p['thumbnail'] = get_the_post_thumbnail( $id, 'thumbnail', array( 'class'=>'mcm_thumbnail', 'alt'=>trim( strip_tags( get_the_title( $id ) ) ), 'title'=>'' ) );
			$p['medium'] = get_the_post_thumbnail( $id, 'medium', array( 'class'=>'mcm_medium', 'alt'=>trim( strip_tags( get_the_title( $id ) ) ), 'title'=>'' ) );
			$p['large'] = get_the_post_thumbnail( $id, 'large', array( 'class'=>'mcm_large', 'alt'=>trim( strip_tags( get_the_title( $id ) ) ), 'title'=>'' ) );
			$p['full'] = get_the_post_thumbnail( $id, 'full', array( 'class'=>'mcm_large', 'alt'=>trim( strip_tags( get_the_title( $id ) ) ), 'title'=>'' ) );
			$p['shortlink'] = wp_get_shortlink();
			$p['modified'] = get_the_modified_date();
			$p['date'] = get_the_time( get_option('date_format') );
			$p['fulldate'] = get_the_time( 'F j, Y' );
			$p['author'] = get_the_author();
				$postclass = implode( ' ',get_post_class() );
			$p['postclass'] = $postclass;
			$p['terms'] = ($taxonomy != 'all')?get_the_term_list( $id, $taxonomy,'',', ','' ):'';
			$custom_fields = get_post_custom();
				foreach ( $custom_fields as $key=>$value ) {
					if ( is_array( $value ) ) {
						if ( is_array( $value[0] ) ) {
							$p[$key] = explode( ", ", $value[0] );
						} else {
							$p[$key] = $value[0];
						}
					}
				}
			if ( isset($p['_email']) ) { $p['_email'] = apply_filters('mcm_munge',$p['_email'], $p['_email'], $custom ); }
			// use this filter to insert any additional custom template tags required		
			$p = apply_filters('mcm_extend_posts', $p, $p, $custom );
			// This filter is used to insert alphabetical headings. You can probably find another use for it.
			$return = apply_filters('mcm_filter_posts',$return, $p, $last_term, $elem, $type, $first, $last_post, $custom );
			$first = false;
			$last_term = get_the_title();
			$last_post = $p;
			$this_post = mcm_run_template( $p, $display, $column, $wrapper );
			$return .= apply_filters('mcm_filter_post',$this_post, $p, $custom );
			switch ($column) {
				case 'odd':	$column = 'even';	break;
				case 'even': $column = 'odd';	break;
			}
		endwhile;
		wp_reset_postdata();
	} else {
		$ids = explode(",",$id);
		foreach ( $ids as $v ) {
			$the_post = get_post( $v );
			$p['id'] = $the_post->ID;
			$p['excerpt'] = wpautop( $the_post->post_excerpt );
			$p['excerpt_raw'] = $the_post->post_excerpt;
			$p['content'] = do_shortcode( wpautop( $the_post->post_content ) );
			$p['content_raw'] = $the_post->post_content;
			$p['thumbnail'] = get_the_post_thumbnail( $the_post->ID, 'thumbnail', array( 'class'=>'', 'alt'=>trim( strip_tags( get_the_title() ) ), 'title'=>'' ) );
			$p['medium'] = get_the_post_thumbnail( $the_post->ID, 'medium', array( 'class'=>'', 'alt'=>trim( strip_tags( get_the_title() ) ), 'title'=>'' ) );
			$p['large'] = get_the_post_thumbnail( $the_post->ID, 'large', array( 'class'=>'', 'alt'=>trim( strip_tags( get_the_title() ) ), 'title'=>'' ) );
			$p['full'] = get_the_post_thumbnail( $the_post->ID, 'full', array( 'class'=>'', 'alt'=>trim( strip_tags( get_the_title() ) ), 'title'=>'' ) );
			$p['permalink'] = get_permalink( $the_post->ID );
			$p['link_title'] = "<a href='".get_permalink( $the_post->ID )."'>".$the_post->post_title."</a>";				
			$p['title'] = $the_post->post_title;
			$p['shortlink'] = wp_get_shortlink( $the_post->ID );
			$p['modified'] = date( get_option('date_format'), strtotime( $the_post->post_modified ) );
			$p['date'] = date( get_option('date_format'), strtotime( $the_post->post_date ) );
			$p['fulldate'] = date( 'F j, Y', strtotime( $the_post->post_date ) );		
			$p['author'] = get_the_author_meta( 'display_name', $the_post->post_author );
				$postclass = implode( ' ',get_post_class( '',$the_post->ID ) );
			$p['postclass'] = $postclass;				
			$p['terms'] = ($taxonomy != 'all')?get_the_term_list( $the_post->ID, $taxonomy,'',', ','' ):'';
			$custom_fields = get_post_custom( $the_post->ID );
				foreach ( $custom_fields as $key=>$value ) {
					if ( is_array( $value ) ) {
						if ( is_array( $value[0] ) ) {
							$p[$key] = explode( ", ", $value[0] );
						} else {
							$p[$key] = $value[0];
						}
					}
				}
			if ( isset($p['_email']) ) { $p['_email'] = apply_filters('mcm_munge',$p['_email'], $p['_email'], $custom ); }
			$p = apply_filters('mcm_extend_posts', $p, $p, $custom );
			$this_post = mcm_run_template( $p, $display, $column, $wrapper );
			$return .= apply_filters('mcm_filter_post',$this_post, $p, $custom );
			switch ($column) {
				case 'odd':	$column = 'even';	break;
				case 'even': $column = 'odd';	break;
			}
		}
	}
	if ( $elem != '' ) { $front = "<$elem class='list-wrapper'>"; $back = "</$elem>"; } else { $elem = $unelem = '';}
	
	if ( $display != 'custom' ) {
	$return = "
		<div class='mcm_posts $primary $display'>
		$front
			$return
		$back
		</div>";
	} else {
		if ( $custom_wrapper != '' ) {
			$return = "<$custom_wrapper class='mcm_posts $primary $display'>$return</$custom_wrapper>";
		} else {
			$return = $return;
		}
	}
	$return = str_replace("\r\n",'',$return);		
		if ( $cache != false ) { 
			$time = (is_numeric($cache))?$cache:24;
			set_transient( "mcm_$cache_key", $return, 60*60*$time );
		} 
	}
	return $return;
}

// A simple function to get data stored in a custom field
if ( !function_exists('mcm_custom_field') ) {
	function mcm_get_custom_field($field,$id='') {
		global $post;
		$id = ($id != '')?$id:$post->ID;
		$custom_field = get_post_meta($id, $field, true);
		return $custom_field;
	}
}
function mcm_custom_field( $field,$before,$after,$id='' ) {
	$value = mcm_get_custom_field($field, $id);
	if ( $value ) {
		if ( is_array( $value ) ) {
			foreach ( $value as $v ) {
				echo $before.$v.$after;
			}
		} else {
			echo $before.$value.$after;
		}
	}
}

function mcm_run_template( $post, $display, $column, $type ) {
global $mcm_templates; $templates = $mcm_templates;
	$return = '';
	$post['column'] = $column;
	$postclass = $post['postclass'];
	switch ( $display ) {
		case 'custom':
			$template = $type;
			return mcm_draw_template($post,$template);
		break;
		case 'full':
			$wrapper = ( isset($templates[$type]['wrapper']['item']['full']) )?$templates[$type]['wrapper']['item']['full']:'div';
		
			if ( $wrapper != '' ) { $pre = "<$wrapper class='$postclass $column'>"; $posttag = "</$wrapper>"; } else { $pre = $posttag = '';}
			
			if ( isset($templates[$type]['full']) && trim( $templates[$type]['full'] ) != '' ) {
				$return .= "$pre
				".mcm_draw_template($post,$templates[$type]['full'])."
				$posttag";
			} else {
				$return .= "
					<h2>$post[title]</h2>
					$post[content]
					<p>$post[link_title]</p>";
			}
		break;
		case 'excerpt':
			$wrapper = ( isset($templates[$type]['wrapper']['item']['excerpt']) )?$templates[$type]['wrapper']['item']['excerpt']:'div';
			
			if ( $wrapper != '' ) { $pre = "<$wrapper class='$postclass $column'>"; $posttag = "</$wrapper>"; } else { $pre = $posttag = '';}

			if ( isset($templates[$type]['excerpt']) && trim( $templates[$type]['excerpt'] ) != '' ) {
				$return .= "$pre
				".mcm_draw_template($post,$templates[$type]['excerpt'])."
				$posttag";
			} else {		
				$return .= "
					<h3>$post[title]</h3>
					$post[excerpt]
					<p>$post[link_title]</p>";
			}
		break;
		case 'list':
			$wrapper = ( isset($templates[$type]['wrapper']['item']['list']) )?$templates[$type]['wrapper']['item']['list']:'li';
			
			if ( $wrapper != '' ) { $pre = "<$wrapper class='$postclass $column'>"; $posttag = "</$wrapper>"; } else { $pre = $posttag = '';}
			if ( isset($templates[$type]['list']) && trim( $templates[$type]['list'] ) != '' ) {
				$return .= "$pre
				".mcm_draw_template($post,$templates[$type]['list'])."
				$posttag";
			} else {		
				$return .= "$post[link_title]\n";
			}
		break;
		default:
			$wrapper = 'div';
			$return .= "
					<h3>$post[title]</h3>
					$post[excerpt]
					<p>$post[link_title]</p>";			
		break;
	}
	return $return;
}
/*
function mcm_draw_template( $array,$template ) {
	//1st argument: array of details
	//2nd argument: template to print details into
	foreach ($array as $key=>$value) {
		if ( !is_object($value) ) {
			$search = "{".$key."}";
			$template = stripcslashes(str_replace($search,$value,$template));
		} else {
		}
	}
	return trim($template);
}
*/
function mcm_draw_template( $array='',$template='' ) {
	//1st argument: array of details
	//2nd argument: template to print details into
	$template = stripcslashes($template);
	foreach ($array as $key=>$value) {
		if ( !is_object($value) ) {
			if ( strpos( $template, "{".$key ) !== false ) { // only check for tag parts that exist
				preg_match_all('/{'.$key.'\b(?>\s+(?:before="([^"]*)"|after="([^"]*)")|[^\s]+|\s+){0,2}}/', $template, $matches, PREG_PATTERN_ORDER );
				if ( $matches ) {
					$before = ( isset( $matches[1][0] ) )?$matches[1][0]:'';
					$after = ( isset( $matches[2][0] ) )?$matches[2][0]:'';
					$value = ( $value == '' )?'':$before.$value.$after;
					$whole_thang = ( isset( $matches[0][0] ) )?$matches[0][0]:'';
					$template = str_replace( $whole_thang, $value, $template );
				}
			}
		} 
	}
	return stripslashes( trim( mc_clean_template($template) ) );
}
// function cleans unreplaced template tags out of the template. 
// Necessary for custom fields, which do not exist in array if empty.
function mc_clean_template( $template ) {
	preg_match_all('/{[\w]*\b(?>\s+(?:before="([^"]*)"|after="([^"]*)")|[^\s]+|\s+){0,2}}/', $template, $matches, PREG_PATTERN_ORDER );

	if ( $matches ) {
		foreach ( $matches[0] as $match ) {
		$template = str_replace( $match, '', $template );
		}
	}
	return $template;
}

function mcm_search_form( $post_type ) {
// no arguments
	if (strpos($post_type,'mcm_') === 0 ) { $post_type = $post_type; } else { $post_type = 'mcm_'.$post_type; }
	$nonce = "<input type='hidden' name='_wpnonce' value='".wp_create_nonce('mcm-nonce')."' />";
	$return = "
	<div class='search_container'>
		<form action='".home_url()."' method='get'>
		<div>
		$nonce
		<input type='hidden' name='customsearch' value='$post_type' />
		</div>
		<label for='csearch'>Search</label> <input type='text' class='text' name='s' id='csearch' />
		<input type='submit' value='Search' class='btn'	/>
		</form>	
	</div>";
	return $return;
}

function mcm_searchfilter($query) {
	if ( isset($_GET['customsearch']) ) {
		if ($query->is_search) {
			// Insert the specific post type you want to search
			$post_type = esc_attr( $_GET['customsearch'] );
			$query->set( 'post_type', $post_type );
		}
		return $query;
	}
}
add_filter( 'mcm_munge','mcm_munge', 10, 3 );
function mcm_munge($address) {
    $address = strtolower($address);
    $coded = "";
    $unmixedkey = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.@";
    $inprogresskey = $unmixedkey;
    $mixedkey="";
    $unshuffled = strlen($unmixedkey);
    for ($i = 0; $i <= strlen($unmixedkey); $i++) {
		$ranpos = rand(0,$unshuffled-1);
		$nextchar = $inprogresskey{$ranpos};
		$mixedkey .= $nextchar;
		$before = substr($inprogresskey,0,$ranpos);
		$after = substr($inprogresskey,$ranpos+1,$unshuffled-($ranpos+1));
		$inprogresskey = $before.''.$after;
		$unshuffled -= 1;
    }
    $cipher = $mixedkey;

    $shift = strlen($address);

    $txt = "<script type=\"text/javascript\">\n" .
           "<!-"."-\n";
    for ($j=0; $j<strlen($address); $j++) {
		if (strpos($cipher,$address{$j}) == -1 ) {
			$chr = $address{$j};
			$coded .= $address{$j};
		} else {
			$chr = (strpos($cipher,$address{$j}) + $shift) % strlen($cipher);
			$coded .= $cipher{$chr};
		}
    }

    $txt .= "\ncoded = \"" . $coded . "\"\n" .
	"  key = \"".$cipher."\"\n".
	"  shift=coded.length\n".
	"  link=\"\"\n".
	"  for (i=0; i<coded.length; i++) {\n" .
	"    if (key.indexOf(coded.charAt(i))==-1) {\n" .
	"      ltr = coded.charAt(i)\n" .
	"      link += (ltr)\n" .
	"    }\n" .
	"    else {     \n".
	"      ltr = (key.indexOf(coded.charAt(i))-
shift+key.length) % key.length\n".
	"      link += (key.charAt(ltr))\n".
	"    }\n".
	"  }\n".
	"document.write(\"<a href='mailto:\"+link+\"'>\"+link+\"</a>\")\n" .
	"\n".
        "//-"."->\n" .
        "<" . "/script><noscript>N/A" .
	"<"."/noscript>";
    return $txt;
}