<?php
global $mcm_types,$mcm_fields,$mcm_extras,$mcm_enabled,$mcm_templates,
$default_mcm_types,$default_mcm_fields,$default_mcm_extras;

function mcm_posttypes() {
	global $mcm_types, $mcm_enabled;
	$types = $mcm_types; $enabled = $mcm_enabled;
	
	if ( is_array( $enabled ) ) {
		foreach ( $enabled as $key ) {
			$value =& $types[$key];		
			$labels = array(
				'name' => _x($value[3], 'post type general name'),
				'singular_name' => _x($value[2], 'post type singular name'),
				'add_new' => _x('Add New', $key),
				'add_new_item' => __('Add New '.$value[2]),
				'edit_item' => __('Edit '.$value[2]),
				'new_item' => __('New '.$value[2]),
				'view_item' => __('View '.$value[2]),
				'search_items' => __('Search '.$value[3]),
				'not_found' =>  __('No '.$value[1].' found'),
				'not_found_in_trash' => __('No '.$value[1].' found in Trash'), 
				'parent_item_colon' => ''
			);
			$raw = $value[4];
			$slug = ( !isset($raw['slug']) || $raw['slug'] == '' )?$key:$raw['slug'];
			$args = array(
				'labels' => $labels,
				'public' => $raw['public'],
				'publicly_queryable' => $raw['publicly_queryable'],
				'exclude_from_search'=> $raw['exclude_from_search'],
				'show_ui' => $raw['show_ui'],
				'show_in_menu' => $raw['show_in_menu'],
				'show_ui' => $raw['show_ui'], 
				'menu_icon' => ($raw['menu_icon']==null)?plugins_url('images',__FILE__)."/$key.png":$raw['menu_icon'],
				'query_var' => true,
				'rewrite' => array('slug'=>$slug,'with_front'=>false),
				'hierarchical' => $raw['hierarchical'],
				'menu_position' => 20,
				'has_archive' => true,
				'supports' => $raw['supports']
			); 
			register_post_type($key,$args);
		}
	}
}

function mcm_posttypes_messages( $messages ) {
	global $post, $post_ID, $mcm_types, $mcm_enabled;
	$types = $mcm_types; $enabled = $mcm_enabled;
	if ( is_array( $enabled ) ) {
		foreach ( $enabled as $key ) {
			$value = $types[$key];
			$messages[$key] = array(
				0 => '', // Unused. Messages start at index 1.
				1 => sprintf( __('%1$s Listing updated. <a href="%2$s">View %1$s listing</a>'), $value[2], esc_url( get_permalink($post_ID) ) ),
				2 => __('Custom field updated.'),
				3 => __('Custom field deleted.'),
				4 => sprintf( __('%s listing updated.'), $value[2] ),
				/* translators: %s: date and time of the revision */
				5 => isset($_GET['revision']) ? sprintf( __('%1$s restored to revision from %2$ss'), $value[2], wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => sprintf( __('%1$s published. <a href="%2$s">View %3$s listing</a>'), $value[2], esc_url( get_permalink($post_ID) ), $value[0] ),
				7 => sprintf( __('Product listing saved.'), $value[2] ),
				8 => sprintf( __('%1$s listing submitted. <a target="_blank" href="%2$s">Preview %3$s listing</a>'), $value[2], esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ), $value[0] ),
				9 => sprintf( __('%1$s listing scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview %3$s item</a>'),
				  $value[2], date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ), $value[0] ),
				10 => sprintf( __('%1$s draft updated. <a target="_blank" href="%s">Preview %3$s listing</a>'), $value[2], esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ), $value[0] ),
			);
		}
	}
	return $messages;
}


function mcm_taxonomies() {
	global $mcm_types,$mcm_enabled;
	$types = $mcm_types; $enabled = $mcm_enabled;
	if ( is_array( $enabled ) ) {
		foreach ( $enabled as $key ) {
			$value =& $types[$key];
			$cat_key = str_replace( 'mcm_','', $key );
			register_taxonomy(
				"mcm_category_$cat_key",	// internal name = machine-readable taxonomy name
				array( $key ),	// object type = post, page, link, or custom post-type
				array(
					'hierarchical' => true,
					'label' => "$value[2] Categories",	// the human-readable taxonomy name
					'query_var' => true,	// enable taxonomy-specific querying
					'rewrite' => array( 'slug' => "$cat_key-category" ),	// pretty permalinks for your taxonomy?
				)
			);
		}
	}
}

function mcm_add_custom_boxes() {
global $mcm_fields, $mcm_extras;
$fields = $mcm_fields; $extras = $mcm_extras;
	if ( is_array($fields) ) {
		foreach ( $fields as $key=>$value ) {
			mcm_add_custom_box( array($key=>$value),$extras[$key][0],$extras[$key][1] );
		}
	}
}


function mcm_add_custom_box( $fields,$post_type='post',$location='side' ) {
    if ( function_exists( 'add_meta_box' ) ) {
        foreach ( array_keys( $fields ) as $field ) {
            add_meta_box( $field, __( $field, 'sp' ), 'mcm_build_custom_box', $post_type, $location, 'default', $fields );
			//echo "$field, $post_type, $location, $fields";
        }
    }
}

function mcm_build_custom_box( $post, $fields ) {
	static $nonce_flag = false;
	// Run once
	if ( !$nonce_flag ) {
		mcm_echo_nonce();
		mcm_echo_hidden($fields['args'][$fields['id']]);
		$nonce_flag = true;
	}
	// Generate box contents
	$i = 0;
	foreach ( $fields['args'][$fields['id']] as $field ) {
		echo mcm_field_html( $field );
		$i++;
	}	
}
// this switch statement specifies different types of meta boxes
// you can add more types if you add a case and a corresponding function
// to handle it
function mcm_field_html( $args ) {
	switch ( $args[3] ) {
		case 'textarea':
			return mcm_text_area( $args );
		default:
			return mcm_text_field( $args );
	}
}
add_action( 'save_post', 'mcm_save_postdata', 1, 2 );
// this is the default text field meta box
function mcm_text_field( $args ) {
	global $post;
	$description = $args[2];
	// adjust data
	$args[2] = get_post_meta($post->ID, $args[0], true);
	$args[1] = __($args[1], 'sp' );
	$label_format =
		'<p><label for="%1$s"><strong>%2$s</strong></label></p>'.
		'<p><input style="width: 80%%;" type="text" name="%1$s" value="%3$s" /></p>';
		if ( $description != '' ) { $label_format .= '<p><em>'.$description.'</em></p>'; }
		return vsprintf( $label_format, $args );
}

// this is the text area meta box
function mcm_text_area ( $args ) {
	global $post;
	$description = $args[2];
	// adjust data
	$args[2] = get_post_meta($post->ID, $args[0], true);
	$args[1] = __($args[1], 'sp' );
	$label_format =
		'<p><label for="%1$s"><strong>%2$s</strong></label></p>'.
		'<p><textarea style="width: 90%%;" name="%1$s">%3$s</textarea></p>';
		if ( $description != '' ) { $label_format .= '<p><em>'.$description.'</em></p>'; }
	return vsprintf( $label_format, $args );
}

/* When the post is saved, saves our custom data */

function mcm_save_postdata($post_id, $post) {
	global $mcm_fields;
	$fields = $mcm_fields;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( isset( $_POST['mcm_nonce_name'] ) ) {
		if ( ! wp_verify_nonce( $_POST['mcm_nonce_name'], plugin_basename(__FILE__) ) ) {
			return $post->ID;
		}
	// Is the user allowed to edit the post or page?
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post->ID )) {
			return $post->ID;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post->ID )) {
			return $post->ID;
		}
	}
		// OK, we're authenticated: we need to find and save the data
		foreach ( $fields as $field ) {
			foreach ( $field as $key=>$value ) {	
				if (isset($_POST[$value[0]]) ) {
					$my_data[$value[0]] = $_POST[$value[0]];
				}
			}
		}
		// Add values of $my_data as custom fields
		// Let's cycle through the $my_data array!
		foreach ($my_data as $key => $value) {
			if ( 'revision' == $post->post_type  ) {
				// don't store custom data twice
				return;
			}
			// if $value is an array, make it a CSV (unlikely)
			$value = implode(',', (array)$value);
			if ( get_post_meta($post->ID, $key, FALSE) ) {
				// Custom field has a value.
				update_post_meta($post->ID, $key, $value);
			} else {
				// Custom field does not have a value.
				add_post_meta($post->ID, $key, $value);
			}
			if (!$value) {
				// delete blanks
				delete_post_meta($post->ID, $key);
			}
		}
	}
}
function mcm_echo_nonce() {
	// Use nonce for verification ... ONLY USE ONCE!
	echo sprintf(
		'<input type="hidden" name="%1$s" id="%1$s" value="%2$s" />',
		'mcm_nonce_name',
		wp_create_nonce( plugin_basename(__FILE__) )
	);
}

function mcm_echo_hidden($fields) {
	foreach ( $fields as $field ) {
		foreach ( $field as $key=>$value ) {
			$new_fields[] = $key;
		}
	}
	$value = implode(',',$new_fields);
	echo '<input type="hidden" name="mcm_fields" value="'.$value.'" />';
}


// defaults
$d_mcm_args = array(
				'public' => true,
				'publicly_queryable' => true,
				'exclude_from_search'=> false,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_ui' => true, 
				'menu_icon' => null,
				'hierarchical'=>true,
				'supports' => array('title','editor','author','thumbnail','excerpt','custom-fields'),
				'slug' => ''
			);

$default_mcm_types = array( 
	'mcm_faq'=>array(__('faq','my-content-management'),__('faqs','my-content-management'),__('FAQ','my-content-management'),__('FAQs','my-content-management'),$d_mcm_args),
	'mcm_people'=>array(__('person','my-content-management'),__('people','my-content-management'),__('Person','my-content-management'),__('People','my-content-management'),$d_mcm_args),  
	'mcm_testimonials'=>array(__('testimonial','my-content-management'),__('testimonials','my-content-management'),__('Testimonial','my-content-management'),__('Testimonials','my-content-management'),$d_mcm_args),	
	'mcm_locations'=>array(__('location','my-content-management'),__('locations','my-content-management'),__('Location','my-content-management'),__('Locations','my-content-management'), $d_mcm_args),
	'mcm_quotes'=>array(__('quote','my-content-management'),__('quotes','my-content-management'),__('Quote','my-content-management'),__('Quotes','my-content-management'), $d_mcm_args),
	'mcm_glossary'=>array(__('glossary term','my-content-management'),__('glossary terms','my-content-management'),__('Glossary Term','my-content-management'),__('Glossary Terms','my-content-management'), $d_mcm_args),
	'mcm_portfolio'=>array(__('portfolio item','my-content-management'),__('portfolio items','my-content-management'),__('Portfolio Item','my-content-management'),__('Portfolio Items','my-content-management'), $d_mcm_args),
	'mcm_resources'=>array(__('resource','my-content-management'),__('resources','my-content-management'),__('Resource','my-content-management'),__('Resources','my-content-management'), $d_mcm_args)
);

// @fields multidimensional array: array( 'Box set'=> array( array( '_name','label','type') ) )
// @post_type string post_type
// @location string side/normal/advanced
// add custom fields to the custom post types
$default_mcm_fields = 
	array (
		__('Personal Information','my-content-management') => 
		array (
			array( '_title', __('Title','my-content-management'), '','mcm_text_field'),
			array( '_subtitle',__('Subtitle','my-content-management'),'','mcm_text_field'),
			array( '_business',__('Business','my-content-management'),'','mcm_text_field' ),
			array( '_phone', __('Phone Number','my-content-management'), '','mcm_text_field'),
			array( '_email', __('E-mail','my-content-management'), '', 'mcm_text_field')
		),
		__('Location Info','my-content-management') =>
		array (
			array( '_street',__('Street Address','my-content-management'),'','mcm_text_field'),
			array( '_city',__('City','my-content-management'),'','mcm_text_field'),
			array( '_neighborhood',__('Neighborhood','my-content-management'),'','mcm_text_field'),
			array( '_state',__('State','my-content-management'),'','mcm_text_field'),
			array( '_country',__('Country','my-content-management'),'','mcm_text_field'),
			array( '_postalcode',__('Postal Code','my-content-management'),'','mcm_text_field'),				
			array( '_phone',__('Phone','my-content-management'),'','mcm_text_field'),
			array( '_fax',__('Fax','my-content-management'),'','mcm_text_field'),
			array( '_business',__('Business Name','my-content-management'),'','mcm_text_field'),
			array( '_email',__('Contact Email','my-content-management'),'','mcm_text_field')
		),
		__('Quotation Info','my-content-management') =>
		array (
			array( '_url',__('URL','my-content-management'),'','mcm_text_field'),
			array( '_title',__('Title','my-content-management'),'','mcm_text_field'),
			array( '_location',__('Location','my-content-management'),'','mcm_text_field')		
		),
		__('Testimonial Info','my-content-management') =>
		array (
			array( '_url',__('URL','my-content-management'),'','mcm_text_field'),
			array( '_title',__('Title','my-content-management'),'','mcm_text_field'),
			array( '_location',__('Location','my-content-management'),'','mcm_text_field')		
		),
		__('Portfolio Info','my-content-management') =>
		array (
			array( '_medium',__('Medium','my-content-management'),'','mcm_text_field'),
			array( '_width',__('Width','my-content-management'),'','mcm_text_field'),
			array( '_height',__('Height','my-content-management'),'','mcm_text_field'),
			array( '_depth',__('Depth','my-content-management'),'','mcm_text_field'),
			array( '_price',__('Price','my-content-management'),'','mcm_text_field'),
			array( '_year',__('Year','my-content-management'),'','mcm_text_field')
		),
		__('Resource Info','my-content-management') =>
		array (
			array( '_authors',__('Additional Authors','my-content-management'),'','mcm_text_field'),
			array( '_licensing',__('License Terms','my-content-management'),'','mcm_text_area'),
			array( '_show',__('Show on','my-content-management'),'This is a label for advanced use in themes','mcm_text_field')
		)
	);

$default_mcm_extras = 
	array( 
		__('Personal Information','my-content-management') => array( 'mcm_people','side' ),
		__('Location Info','my-content-management') => array( 'mcm_locations','side' ),
		__('Testimonial Info','my-content-management') =>	array( 'mcm_testimonials','side' ),
		__('Quotation Info','my-content-management') =>	array( 'mcm_quotes', 'side' ),
		__('Portfolio Info','my-content-management') => array( 'mcm_portfolio', 'side' ),
		__('Resource Info','my-content-management') => array( 'mcm_resources', 'side' )		
	);