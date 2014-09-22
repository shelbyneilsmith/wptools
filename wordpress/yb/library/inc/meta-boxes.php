<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
 */

/********************* META BOX DEFINITIONS ***********************/

add_action( 'admin_init', 'rw_register_meta_boxes' );
function rw_register_meta_boxes()
{

	global $meta_boxes;
	global $wpdb;

	$prefix = 'yb_';
	$meta_boxes = array();

	/* ----------------------------------------------------- */
	// REGISTER CUSTOM ARRAYS
	/* ----------------------------------------------------- */
	// REVSLIDER ARRAY
	$revolutionslider = array();


	if(class_exists('RevSlider')){
		$revolutionslider[0] = 'Select a Slider';
		$slider = new RevSlider();
		$arrSliders = $slider->getArrSliders();
		foreach($arrSliders as $revSlider) {
			$revolutionslider[$revSlider->getAlias()] = $revSlider->getTitle();
		}
	}
	else{
		$revolutionslider[0] = 'Install RevolutionSlider Plugin first...';
	}

	/* ----------------------------------------------------- */
	// FLEXSLIDER FILTER ARRAY
	if (is_plugin_active('flexslider/wooslider.php')) {

		$flexslider = get_terms('slide-page');
		$flexslider_array[0] = 'Select a Slider';
		if($flexslider) {
			foreach($flexslider as $slider) {
				$flexslider_array[$slider->slug] = $slider->name;
			}
		}

	}
	else{
		$flexslider_array[0] = 'Install FlexSlider Plugin first...';
	}

	/* ----------------------------------------------------- */
	// Page Settings
	/* ----------------------------------------------------- */
	$default_titlebar = 'titlebar';

	if (isset($_GET['post'])) {
		$page_id = $_GET['post'];
		$page_title = get_the_title( $page_id );

		if ( $page_title === "Home" ) {
			$default_titlebar = 'notitlebar';
		}
	}

	$meta_boxes[] = array(
		'id' => 'pagesettings',
		'title' => 'Page Settings',
		'pages' => array( 'page' ),
		'context' => 'normal',
		'priority' => 'high',

		// List of meta fields
		'fields' => array(
			array(
				'name'	=> 'Title Bar',
				'id'		=> $prefix . "titlebar",
				'type'		=> 'select',
				'options'	=> array(
					'titlebar'		=> 'Standard Titlebar',
					'featuredimage'	=> 'Featured Image Style #1',
					'featuredimage2'	=> 'Featured Image Style #2',
					'revslider'		=> 'Revolution Slider',
					'flexslider'		=> 'FlexSlider',
					'notitlebar'		=> 'No Titlebar'
				),
				'multiple'	=> false,
				'std'		=> $default_titlebar
			),
			array(
				'name'	=> 'Show Breadcrumbs?',
				'id'		=> $prefix . "featuredimage-breadcrumbs",
				'type'		=> 'checkbox',
				'std'		=> true
			),
			array(
				'name'	=> 'Revolution Slider',
				'id'		=> $prefix . "revolutionslider",
				'type'		=> 'select',
				'options'	=> $revolutionslider,
				'multiple'	=> false
			),
			array(
				'name'	=> 'FlexSlider',
				'id'		=> $prefix . "flexslider",
				'type'		=> 'select',
				'options'	=> $flexslider_array,
				'multiple'	=> false
			)
			// array(
			// 	'name' => 'Select Portfolio Filters',
			// 	'id' => $prefix . "portfoliofilter",
			// 	'type' => 'select',
			// 	// Array of 'value' => 'Label' pairs for select box
			// 	'options' => $types_array,
			// 	// Select multiple values, optional. Default is false.
			// 	'multiple' => true,
			// 	'desc' => 'Optional: Choose what portfolio category you want to display on this page (If Portfolio Template chosen).'
			// ),
			// array(
			// 	'name'		=> 'Sidebar Shortcode',
			// 	'id'		=> $prefix . 'customsidebar',
			// 	'clone'		=> false,
			// 	'type'		=> 'text',
			// 	'std'		=> '',
			// 	'desc' => 'Optional: Insert Shortcode of your Sidebar and select Default or Sidebar Right Template.'
			// )
		)
	);

	foreach ( $meta_boxes as $meta_box ) {
		new RW_Meta_Box( $meta_box );
	}
}

/* ----------------------------------------------------- */
// Background Styling
/* ----------------------------------------------------- */

if( isset($ybwp_data['opt-checkbox-bgimg']) && $ybwp_data['opt-checkbox-bgimg'] ) {

	add_action( 'admin_init', 'rw_register_meta_boxes_background' );
	function rw_register_meta_boxes_background()
	{

		global $meta_boxes;

		$prefix = 'yb_';
		$meta_boxes = array();

		$meta_boxes[] = array(
			'id' => 'styling',
			'title' => 'Page Background Options',
			'pages' => array( 'post', 'page', 'portfolio' ),
			'context' => 'side',
			'priority' => 'low',

			// List of meta fields
			'fields' => array(
				array(
					'name'	=> __('Use Page\'s Featured Image as Background', 'yb'),
					'desc'		=> __('Overrides Settings in Theme Options and CSS.', 'yb'),
					'id'		=> $prefix . "page-bg-override",
					'type'		=> 'checkbox',
					'std'		=> false
				),
				array(
					'name'	=> __('Background Image Style', 'yb'),
					'id'		=> $prefix . "bgstyle",
					'type'		=> 'select',
					'options'	=> array(
						'stretch'	=> 'Stretch Image',
						'repeat'	=> 'Repeat',
						'no-repeat'	=> 'No-Repeat',
						'repeat-x'	=> 'Repeat-X',
						'repeat-y'	=> 'Repeat-Y'
					),
					'multiple'	=> false,
					'std'		=> array( 'stretch' )
				),
			)
		);

		foreach ( $meta_boxes as $meta_box ) {
			new RW_Meta_Box( $meta_box );
		}
	}

}