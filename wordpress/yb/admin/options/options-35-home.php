<?php
$this->sections[] = array(
	'title'     => __('Home', 'yb'),
	'icon'      => 'el-icon-home',
	// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields'    => array(
		array(
			'id'        => 'opt-homelayout',
			'type'      => 'image_select',
			// 'compiler'  => true,
			'title'     => __('Home Layout', 'yb'),
			'subtitle'  => __('Select home content and sidebar alignment. <br /><br /><i>(Note: For consistency and simplicity, if setting the home page to be full width, this will also apply to the header and footer, regardless of any other layout settings.)</i>', 'yb'),
			'options'   => array(
				'default' => array('alt' => 'Global Default',       'img' => '/wp-content/themes/yb/library/_images/layout-default.png'),
				'Full Width' => array('alt' => 'Full Width', 'img' =>  '/wp-content/themes/yb/library/_images/layout-fullwidth.png'),
				'Centered No Sidebar' => array('alt' => 'Centered No Sidebar', 'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
				'Centered Left Sidebar' => array('alt' => 'Centered Left Sidebar',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
				'Centered Right Sidebar' => array('alt' => 'Centered Right Sidebar', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
			),
			'default'   => 'Centered No Sidebar'
		),
		array(
			'id'        => 'opt-checkbox-homesidebar',
			'type'      => 'radio',
			'title'     => __('Home Page Sidebar', 'yb'),
			'subtitle'  => __('Choose which sidebar you want to appear on the home page.', 'yb'),
			'required' => array('opt-homelayout','=',array('Centered Left Sidebar', 'Centered Right Sidebar')),
			'data'      => 'sidebars'
		),
		// array(
		// 	'id'        => 'opt-web-fonts',
		// 	'type'      => 'media',
		// 	'title'     => __('Web Fonts', 'yb'),
		// 	'compiler'  => 'true',
		// 	'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
		// 	'desc'      => __('Basic media uploader with disabled URL input field.', 'yb'),
		// 	'subtitle'  => __('Upload any media using the WordPress native uploader', 'yb'),
		// 	'hint'      => array(
		// 		//'title'     => '',
		// 		'content'   => 'This is a <b>hint</b> tool-tip for the webFonts field.<br/><br/>Add any HTML based text you like here.',
		// 	)
		// ),
		// array(
		// 	'id'        => 'section-media-start',
		// 	'type'      => 'section',
		// 	'title'     => __('Media Options', 'yb'),
		// 	'subtitle'  => __('With the "section" field you can create indent option sections.', 'yb'),
		// 	'indent'    => true // Indent all options below until the next 'section' option is set.
		// ),
		// array(
		// 	'id'        => 'opt-media',
		// 	'type'      => 'media',
		// 	'url'       => true,
		// 	'title'     => __('Media w/ URL', 'yb'),
		// 	'compiler'  => 'true',
		// 	//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
		// 	'desc'      => __('Basic media uploader with disabled URL input field.', 'yb'),
		// 	'subtitle'  => __('Upload any media using the WordPress native uploader', 'yb'),
		// 	'default'   => array('url' => 'http://s.wordpress.org/style/images/codeispoetry.png'),
		// 	//'hint'      => array(
		// 	//    'title'     => 'Hint Title',
		// 	//    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
		// 	//)
		// ),
		// array(
		// 	'id'        => 'section-media-end',
		// 	'type'      => 'section',
		// 	'indent'    => false // Indent all options below until the next 'section' option is set.
		// ),
		// array(
		// 	'id'        => 'media-no-url',
		// 	'type'      => 'media',
		// 	'title'     => __('Media w/o URL', 'yb'),
		// 	'desc'      => __('This represents the minimalistic view. It does not have the preview box or the display URL in an input box. ', 'yb'),
		// 	'subtitle'  => __('Upload any media using the WordPress native uploader', 'yb'),
		// ),
		// array(
		// 	'id'        => 'media-no-preview',
		// 	'type'      => 'media',
		// 	'preview'   => false,
		// 	'title'     => __('Media No Preview', 'yb'),
		// 	'desc'      => __('This represents the minimalistic view. It does not have the preview box or the display URL in an input box. ', 'yb'),
		// 	'subtitle'  => __('Upload any media using the WordPress native uploader', 'yb'),
		// ),
		// array(
		// 	'id'        => 'opt-gallery',
		// 	'type'      => 'gallery',
		// 	'title'     => __('Add/Edit Gallery', 'so-panels'),
		// 	'subtitle'  => __('Create a new Gallery by selecting existing or uploading new images using the WordPress native uploader', 'so-panels'),
		// 	'desc'      => __('This is the description field, again good for additional info.', 'yb'),
		// ),
		// array(
		// 	'id'            => 'opt-slider-label',
		// 	'type'          => 'slider',
		// 	'title'         => __('Slider Example 1', 'yb'),
		// 	'subtitle'      => __('This slider displays the value as a label.', 'yb'),
		// 	'desc'          => __('Slider description. Min: 1, max: 500, step: 1, default value: 250', 'yb'),
		// 	'default'       => 250,
		// 	'min'           => 1,
		// 	'step'          => 1,
		// 	'max'           => 500,
		// 	'display_value' => 'label'
		// ),
		// array(
		// 	'id'            => 'opt-slider-text',
		// 	'type'          => 'slider',
		// 	'title'         => __('Slider Example 2 with Steps (5)', 'yb'),
		// 	'subtitle'      => __('This example displays the value in a text box', 'yb'),
		// 	'desc'          => __('Slider description. Min: 0, max: 300, step: 5, default value: 75', 'yb'),
		// 	'default'       => 75,
		// 	'min'           => 0,
		// 	'step'          => 5,
		// 	'max'           => 300,
		// 	'display_value' => 'text'
		// ),
		// array(
		// 	'id'            => 'opt-slider-select',
		// 	'type'          => 'slider',
		// 	'title'         => __('Slider Example 3 with two sliders', 'yb'),
		// 	'subtitle'      => __('This example displays the values in select boxes', 'yb'),
		// 	'desc'          => __('Slider description. Min: 0, max: 500, step: 5, slider 1 default value: 100, slider 2 default value: 300', 'yb'),
		// 	'default'       => array(
		// 		1 => 100,
		// 		2 => 300,
		// 	),
		// 	'min'           => 0,
		// 	'step'          => 5,
		// 	'max'           => '500',
		// 	'display_value' => 'select',
		// 	'handles'       => 2,
		// ),
		// array(
		// 	'id'            => 'opt-slider-float',
		// 	'type'          => 'slider',
		// 	'title'         => __('Slider Example 4 with float values', 'yb'),
		// 	'subtitle'      => __('This example displays float values', 'yb'),
		// 	'desc'          => __('Slider description. Min: 0, max: 1, step: .1, default value: .5', 'yb'),
		// 	'default'       => .5,
		// 	'min'           => 0,
		// 	'step'          => .1,
		// 	'max'           => 1,
		// 	'resolution'    => 0.1,
		// 	'display_value' => 'text'
		// ),
		// array(
		// 	'id'        => 'opt-spinner',
		// 	'type'      => 'spinner',
		// 	'title'     => __('JQuery UI Spinner Example 1', 'yb'),
		// 	'desc'      => __('JQuery UI spinner description. Min:20, max: 100, step:20, default value: 40', 'yb'),
		// 	'default'   => '40',
		// 	'min'       => '20',
		// 	'step'      => '20',
		// 	'max'       => '100',
		// ),
		// array(
		// 	'id'        => 'switch-on',
		// 	'type'      => 'switch',
		// 	'title'     => __('Switch On', 'yb'),
		// 	'subtitle'  => __('Look, it\'s on!', 'yb'),
		// 	'default'   => true,
		// ),
		// array(
		// 	'id'        => 'switch-off',
		// 	'type'      => 'switch',
		// 	'title'     => __('Switch Off', 'yb'),
		// 	'subtitle'  => __('Look, it\'s on!', 'yb'),
		// 	'default'   => false,
		// ),
		// array(
		// 	'id'        => 'switch-custom',
		// 	'type'      => 'switch',
		// 	'title'     => __('Switch - Custom Titles', 'yb'),
		// 	'subtitle'  => __('Look, it\'s on! Also hidden child elements!', 'yb'),
		// 	'default'   => 0,
		// 	'on'        => 'Enabled',
		// 	'off'       => 'Disabled',
		// ),
		// array(
		// 	'id'        => 'switch-fold',
		// 	'type'      => 'switch',
		// 	'required'  => array('switch-custom', '=', '1'),
		// 	'title'     => __('Switch - With Hidden Items (NESTED!)', 'yb'),
		// 	'subtitle'  => __('Also called a "fold" parent.', 'yb'),
		// 	'desc'      => __('Items set with a fold to this ID will hide unless this is set to the appropriate value.', 'yb'),
		// 	'default'   => false,
		// ),
		// array(
		// 	'id'        => 'opt-patterns',
		// 	'type'      => 'image_select',
		// 	'tiles'     => true,
		// 	'required'  => array('switch-fold', 'equals', '0'),
		// 	'title'     => __('Images Option (with pattern=>true)', 'yb'),
		// 	'subtitle'  => __('Select a background pattern.', 'yb'),
		// 	'default'   => 0,
		// 	'options'   => $sample_patterns
		// ,
		// ),
		// array(
		// 	'id'        => 'opt-homepage-layout',
		// 	'type'      => 'sorter',
		// 	'title'     => 'Layout Manager Advanced',
		// 	'subtitle'  => 'You can add multiple drop areas or columns.',
		// 	'compiler'  => 'true',
		// 	'options'   => array(
		// 		'enabled'   => array(
		// 			'highlights'    => 'Highlights',
		// 			'slider'        => 'Slider',
		// 			'staticpage'    => 'Static Page',
		// 			'services'      => 'Services'
		// 		),
		// 		'disabled'  => array(
		// 		),
		// 		'backup'    => array(
		// 		),
		// 	),
		// 	'limits' => array(
		// 		'disabled'  => 1,
		// 		'backup'    => 2,
		// 	),
		// ),

		// array(
		// 	'id'        => 'opt-homepage-layout-2',
		// 	'type'      => 'sorter',
		// 	'title'     => 'Homepage Layout Manager',
		// 	'desc'      => 'Organize how you want the layout to appear on the homepage',
		// 	'compiler'  => 'true',
		// 	'options'   => array(
		// 		'disabled'  => array(
		// 			'highlights'    => 'Highlights',
		// 			'slider'        => 'Slider',
		// 		),
		// 		'enabled'   => array(
		// 			'staticpage'    => 'Static Page',
		// 			'services'      => 'Services'
		// 		),
		// 	),
		// ),
		// array(
		// 	'id'        => 'opt-slides',
		// 	'type'      => 'slides',
		// 	'title'     => __('Slides Options', 'yb'),
		// 	'subtitle'  => __('Unlimited slides with drag and drop sortings.', 'yb'),
		// 	'desc'      => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', 'yb'),
		// 	'placeholder'   => array(
		// 		'title'         => __('This is a title', 'yb'),
		// 		'description'   => __('Description Here', 'yb'),
		// 		'url'           => __('Give us a link!', 'yb'),
		// 	),
		// ),
		// array(
		// 	'id'        => 'opt-presets',
		// 	'type'      => 'image_select',
		// 	'presets'   => true,
		// 	'title'     => __('Preset', 'yb'),
		// 	'subtitle'  => __('This allows you to set a json string or array to override multiple preferences in your theme.', 'yb'),
		// 	'default'   => 0,
		// 	'desc'      => __('This allows you to set a json string or array to override multiple preferences in your theme.', 'yb'),
		// 	'options'   => array(
		// 		'1'         => array('alt' => 'Preset 1', 'img' => ReduxFramework::$_url . '../sample/presets/preset1.png', 'presets' => array('switch-on' => 1, 'switch-off' => 1, 'switch-custom' => 1)),
		// 		'2'         => array('alt' => 'Preset 2', 'img' => ReduxFramework::$_url . '../sample/presets/preset2.png', 'presets' => '{"slider1":"1", "slider2":"0", "switch-on":"0"}'),
		// 	),
		// ),
		// array(
		// 	'id'            => 'opt-typography',
		// 	'type'          => 'typography',
		// 	'title'         => __('Typography', 'yb'),
		// 	//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
		// 	'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
		// 	'font-backup'   => true,    // Select a backup non-google font in addition to a google font
		// 	//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
		// 	//'subsets'       => false, // Only appears if google is true and subsets not set to false
		// 	//'font-size'     => false,
		// 	//'line-height'   => false,
		// 	//'word-spacing'  => true,  // Defaults to false
		// 	//'letter-spacing'=> true,  // Defaults to false
		// 	//'color'         => false,
		// 	//'preview'       => false, // Disable the previewer
		// 	'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
		// 	'output'        => array('h2.site-description'), // An array of CSS selectors to apply this font style to dynamically
		// 	'compiler'      => array('h2.site-description-compiler'), // An array of CSS selectors to apply this font style to dynamically
		// 	'units'         => 'px', // Defaults to px
		// 	'subtitle'      => __('Typography option with each property can be called individually.', 'yb'),
		// 	'default'       => array(
		// 		'color'         => '#333',
		// 		'font-style'    => '700',
		// 		'font-family'   => 'Abel',
		// 		'google'        => true,
		// 		'font-size'     => '33px',
		// 		'line-height'   => '40px'),
		// 	'preview' => array('text' => 'ooga booga'),
		// ),
	),
);
?>