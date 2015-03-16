<?php
$this->sections[] = array(
	'title'     => __('Home', 'yb'),
	'icon'      => 'el-icon-home',
	'fields'    => array(
		array(
			'id'        => 'opt-homelayout',
			'type'      => 'image_select',
			'title'     => __('Home Layout', 'yb'),
			'subtitle'  => __('Select home content and sidebar alignment. <br /><br /><i>(Note: For consistency and simplicity, if setting the home page to be full width, this will also apply to the header and footer, regardless of any other layout settings.)</i>', 'yb'),
			'options'   => array(
				'default' => array('alt' => 'Global Default',       'img' => '/wp-content/themes/yb/assets/images/layout-default.png'),
				'Full Width' => array('alt' => 'Full Width', 'img' =>  '/wp-content/themes/yb/assets/images/layout-fullwidth.png'),
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
	),
);
?>