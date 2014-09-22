<?php
add_action( 'admin_init', 'rw_register_portfolio_meta_boxes' );

function rw_register_portfolio_meta_boxes() {
	global $meta_boxes;
	global $wpdb;

	$prefix = 'yb_';
	$meta_boxes = array();

	/* ----------------------------------------------------- */
	// PORTFOLIO FILTER ARRAY
	$types = get_terms('portfolio_filter', 'hide_empty=0');
	$types_array[0] = 'All categories';
	if($types) {
		foreach($types as $type) {
			$types_array[$type->term_id] = $type->name;
		}
	}

	/* ----------------------------------------------------- */
	// Project Info Metabox
	/* ----------------------------------------------------- */
	$meta_boxes[] = array(
		'id' => 'portfolio_info',
		'title' => 'Project Information',
		'pages' => array( 'portfolio' ),
		'context' => 'normal',

		'fields' => array(
			// array(
			// 		'name'	=> 'Title Bar',
			// 		'id'		=> $prefix . "titlebar",
			// 		'type'		=> 'select',
			// 		'options'	=> array(
			// 			'titlebar'		=> 'Title & Subtitle',
			// 			'notitlebar'		=> 'No Title Bar'
			// 		),
			// 		'multiple'	=> false,
			// 		'std'		=> array( 'title' )
			// ),
			// array(
			// 	'name'		=> 'Subtitle',
			// 	'id'		=> $prefix . 'subtitle',
			// 	'clone'		=> false,
			// 	'type'		=> 'text',
			// 	'std'		=> ''
			// ),
			array(
				'name'	=> 'Client',
				'id'		=> $prefix . 'portfolio-client',
				'desc'		=> 'Leave empty if you do not want to show this.',
				'clone'	=> false,
				'type'		=> 'text',
				'std'		=> ''
			),
			array(
				'name'	=> 'Project link',
				'id'		=> $prefix . 'portfolio-link',
				'desc'		=> 'URL to the Project if available (Do not forget the http://)',
				'clone'	=> false,
				'type'		=> 'text',
				'std'		=> ''
			),
			array(
				'name'	=> 'Detail Layout',
				'id'		=> $prefix . 'portfolio-detaillayout',
				'desc'		=> 'Choose Layout for Detailpage',
				'type'		=> 'select',
				'options'	=> array(
					'wide'			=> 'Full Width',
					'sidebyside'	=> 'Side by Side'
				),
				'multiple'	=> false,
				'std'		=> array( 'no' )
			),
			array(
				'name'	=> 'Show Project Details?',
				'id'		=> $prefix . "portfolio-details",
				'type'		=> 'checkbox',
				'std'		=> true
			),
			array(
				'name'	=> 'Show Related Projects?',
				'id'		=> $prefix . "portfolio-relatedposts",
				'type'		=> 'checkbox',
				'desc'		=> 'This overwrites the global settings from Theme Options'
			),
			array(
				'name'	=> 'Link to Lightbox',
				'id'		=> $prefix . "portfolio-lightbox",
				'type'		=> 'select',
				'options'	=> array(
					'false'	=> 'false',
					'true'		=> 'true'
				),
				'multiple'	=> false,
				'std'		=> array( 'false' ),
				'desc'		=> 'Open Image in a Lightbox (on Overview, Homepage & Related Posts)'
			)
		)
	);

	/* ----------------------------------------------------- */
	// Project Slides Metabox
	/* ----------------------------------------------------- */
	$meta_boxes[] = array(
		'id'		=> 'portfolio_slides',
		'title'		=> 'Project Slides',
		'pages'	=> array( 'portfolio' ),
		'context' 	=> 'normal',

		'fields'	=> array(
			array(
				'name'	=> 'Project Slider Images',
				'desc'		=> 'Upload up to 20 project images for a slideshow - or only one to display a single image. <br /><br /><strong>Notice:</strong> The Preview Image will be the Image set as Featured Image.',
				'id'		=> $prefix . 'screenshot',
				'type'		=> 'plupload_image',
				'max_file_uploads' => 20,
			)

		)
	);

	/* ----------------------------------------------------- */
	// Project Video Metabox
	/* ----------------------------------------------------- */
	$meta_boxes[] = array(
		'id'		=> 'portfolio_video',
		'title'		=> 'Project Video',
		'pages'	=> array( 'portfolio' ),
		'context' 	=> 'normal',

		'fields'	=> array(
			array(
				'name'	=> 'Video Source',
				'id'		=> $prefix . 'source',
				'type'		=> 'select',
				'options'	=> array(
					'youtube'	=> 'Youtube',
					'vimeo'	=> 'Vimeo',
					'own'		=> 'Own Embed Code'
				),
				'multiple'	=> false,
				'std'		=> array( 'no' )
			),
			array(
				'name'	=> 'Video URL or own Embedd Code<br />(Audio Embedd Code is possible, too)',
				'id'	=> $prefix . 'embed',
				'desc'	=> 'Just paste the ID of the video (E.g. http://www.youtube.com/watch?v=<strong>GUEZCxBcM78</strong>) you want to show, or insert own Embed Code. <br />This will show the Video <strong>INSTEAD</strong> of the Image Slider.<br /><strong>Of course you can also insert your Audio Embedd Code!</strong><br /><br /><strong>Notice:</strong> The Preview Image will be the Image set as Featured Image..',
				'type' 	=> 'textarea',
				'std' 	=> "",
				'cols' 	=> "40",
				'rows' 	=> "8"
			)
		)
	);

	foreach ( $meta_boxes as $meta_box ) {
		new RW_Meta_Box( $meta_box );
	}

}

?>
