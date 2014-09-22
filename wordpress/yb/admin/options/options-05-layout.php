<?php
$this->sections[] = array(
	'title'     => __('Layout', 'yb'),
	'icon'      => 'el-icon-website',
	// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields'    => array(
		array(
			'id'        => 'opt-layout',
			'type'      => 'image_select',
			// 'compiler'  => true,
			'title'     => __('Main Layout', 'yb'),
			'subtitle'  => __('Select main content and sidebar alignment.', 'yb'),
			'options'   => array(
				'Full Width' => array('alt' => 'Full Width', 'img' =>  '/wp-content/themes/yb/library/_images/layout-fullwidth.png'),
				'Centered No Sidebar' => array('alt' => 'Centered No Sidebar', 'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
				'Centered Left Sidebar' => array('alt' => 'Centered Left Sidebar',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
				'Centered Right Sidebar' => array('alt' => 'Centered Right Sidebar', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
			),
			'default'   => 'Centered Right Sidebar'
		),
	),
);

?>