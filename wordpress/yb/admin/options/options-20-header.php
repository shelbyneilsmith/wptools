<?php
$this->sections[] = array(
	'title'     => __('Header', 'yb'),
	'icon'      => 'el-icon-hand-up',
	'fields'    => array(
		array(
			'id'        => 'opt-header_layout',
			'type'      => 'image_select',
			'compiler'  => true,
			'title'     => __('Select Header Layout', 'yb'),
			'options'   => array(
				'v1' => array('alt' => 'Logo/Nav Inline',       'img' => get_bloginfo('template_directory')."/library/_images/headers/header1.jpg"),
				'v2' => array('alt' => 'Logo Left, Nav Dropped',  'img' => get_bloginfo('template_directory')."/library/_images/headers/header4.jpg"),
				'v3' => array('alt' => 'Logo Centered, Nav Dropped', 'img' => get_bloginfo('template_directory')."/library/_images/headers/header5.jpg"),
			),
			'default'   => 'v2'
		),
		array(
			'id'        => 'opt-checkbox-slogan',
			'type'      => 'checkbox',
			'title'     => __('Show Slogan', 'yb'),
			'subtitle'  => __('Check to show site slogan (for supported header types only)', 'yb'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'section-topbar-start',
			'type'      => 'section',
			'title'     => __('Top Bar Options', 'yb'),
			'indent'    => false // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'opt-checkbox-topbar',
			'type'      => 'checkbox',
			'title'     => __('Show Topbar', 'yb'),
			'subtitle'  => __('Check to show Topbar (Callus Text & Social Media)', 'yb'),
			'default'   => '1'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-textarea-callus',
			'type'      => 'textarea',
			'title'     => __('Call Us Text', 'yb'),
			'subtitle'  => __('Enter your Call us Text (HTML allowed)', 'yb'),
			'default' => ''
		),
		array(
			'id'        => 'opt-checkbox-socialtopbar',
			'type'      => 'checkbox',
			'title'     => __('Show Social Icons in Topbar', 'yb'),
			'subtitle'  => __('Check to show Social Icons in Topbar (Configure Icons in Social Media)', 'yb'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'section-nav-search-options-start',
			'type'      => 'section',
			'title'     => __('General Navigation & Search Options', 'yb'),
			'indent'    => false // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'opt-checkbox-utilnav',
			'type'      => 'checkbox',
			'title'     => __('Enable Utility Navigation', 'yb'),
			'subtitle'  => __('Check to enable Utility Navigation and show in Header', 'yb'),
			'default'   => '1'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-searchform',
			'type'      => 'checkbox',
			'title'     => __('Show Searchform', 'yb'),
			'subtitle'  => __('Check to show Searchform in Navigation Bar', 'yb'),
			'default'   => '1'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-stickyheader',
			'type'      => 'checkbox',
			'title'     => __('Activate Sticky Header (Experimental)', 'yb'),
			'subtitle'  => __('Check to activate sticky Header (Experimental)', 'yb'),
			'default'   => '0'// 1 = on | 0 = off
		),
	),
);

?>