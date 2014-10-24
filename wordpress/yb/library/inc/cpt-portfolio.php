<?php
/* ----------------------------------------------------- */
/* portfolio Custom Post Type */
/* ----------------------------------------------------- */

// Adds Custom Post Type
add_action('init', 'portfolio_register');

// Adds columns in the admin view for thumbnail and taxonomies
add_filter( 'manage_edit-portfolio_columns', 'portfolio_edit_columns' );
add_action( 'manage_posts_custom_column', 'portfolio_column_display', 10, 2 );

// Allows filtering of posts by taxonomy in the admin view
add_action( 'restrict_manage_posts', 'portfolio_add_taxonomy_filters' );

function portfolio_register() {

	global $data;

	$labels = array(
		'name' => __( 'Portfolio', 'yb' ),
		'singular_name' => __( 'Portfolio Item', 'yb' ),
		'add_new' => __( 'Add New Item', 'yb' ),
		'add_new_item' => __( 'Add New Portfolio Item', 'yb' ),
		'edit_item' => __( 'Edit Portfolio Item', 'yb' ),
		'new_item' => __( 'Add New Portfolio Item', 'yb' ),
		'view_item' => __( 'View Item', 'yb' ),
		'search_items' => __( 'Search Portfolio', 'yb' ),
		'not_found' => __( 'No portfolio items found', 'yb' ),
		'not_found_in_trash' => __( 'No portfolio items found in trash', 'yb' )
	);

	$args = array(
		'labels' => $labels,
		//'singular_label' => __('Project'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array('slug' => $data['text_portfolioslug']), // Permalinks format
		'supports' => array('title', 'editor', 'thumbnail', 'comments')
	);

	 register_post_type( 'portfolio' , $args );
}

register_taxonomy("portfolio_filter", array("portfolio"), array("hierarchical" => true, "label" => "Portfolio Filter", "singular_label" => "Project Filter", "rewrite" => true));

/**
 * Add Columns to Portfolio Edit Screen
 * http://wptheming.com/2010/07/column-edit-pages/
 */

function portfolio_edit_columns( $portfolio_columns ) {
	$portfolio_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => _x('Title', 'column name', 'yb'),
		"thumbnail" => __('Thumbnail', 'portfolioposttype'),
		"portfolio_filter" => __('Filter', 'portfolioposttype'),
		"author" => __('Author', 'portfolioposttype'),
		"comments" => __('Comments', 'portfolioposttype'),
		"date" => __('Date', 'portfolioposttype'),
	);
	$portfolio_columns['comments'] = '<div class="vers"><img alt="Comments" src="' . esc_url( admin_url( 'images/comment-grey-bubble.png' ) ) . '" /></div>';
	return $portfolio_columns;
}

function portfolio_column_display( $portfolio_columns, $post_id ) {

	// Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview

	switch ( $portfolio_columns ) {

		// Display the thumbnail in the column view
		case "thumbnail":
			$width = (int) 35;
			$height = (int) 35;
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

			// Display the featured image in the column view if possible
			if ( $thumbnail_id ) {
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			}
			if ( isset( $thumb ) ) {
				echo $thumb;
			} else {
				echo __('None', 'portfolioposttype');
			}
			break;

		// Display the portfolio tags in the column view
		case "portfolio_filter":

		if ( $category_list = get_the_term_list( $post_id, 'portfolio_filter', '', ', ', '' ) ) {
			echo $category_list;
		} else {
			echo __('None', 'portfolioposttype');
		}
		break;
	}
}

/**
 * Adds taxonomy filters to the portfolio admin page
 * Code artfully lifed from http://pippinsplugins.com
 */

function portfolio_add_taxonomy_filters() {
	global $typenow;

	// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array( 'portfolio_filter' );

	// must set this to the post type you want the filter(s) displayed on
	if ( $typenow == 'portfolio' ) {

		foreach ( $taxonomies as $tax_slug ) {
			$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
			$tax_obj = get_taxonomy( $tax_slug );
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if ( count( $terms ) > 0) {
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>$tax_name</option>";
				foreach ( $terms as $term ) {
					echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
				}
				echo "</select>";
			}
		}
	}
}

/* ----------------------------------------------------- */
/* EOF */
/* ----------------------------------------------------- */

?>