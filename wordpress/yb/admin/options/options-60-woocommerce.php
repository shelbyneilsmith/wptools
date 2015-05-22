<?php
$this->sections[] = array(
	'title'     => __('WooCommerce', 'yb'),
	// 'desc'      => __('Redux Framework was created with the developer in mind. It allows for any theme developer to have an advanced theme panel with most of the features a developer would need. For more information check out the Github repo at: <a href="https://github.com/ReduxFramework/Redux-Framework">https://github.com/ReduxFramework/Redux-Framework</a>', 'yb'),
	'icon'      => 'el-icon-shopping-cart',
	// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields'    => array(
		array(
			'id'        => 'opt-checkbox-woocommerce',
			'type'      => 'checkbox',
			'title'     => __('WooCommerce', 'yb'),
			'subtitle'  => __('Check to use WooCommerce for this site.', 'yb'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-woocommerceicon',
			'type'      => 'checkbox',
			'title'     => __('Show Cart Icon in Header', 'yb'),
			'required' => array('opt-checkbox-woocommerce','=','1'),
			'subtitle'  => __('Check to show Cart Icon in Header', 'yb'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-woocommercelayout',
			'type'      => 'image_select',
			// 'compiler'  => true,
			'title'     => __('WooCommerce Pages Layout', 'yb'),
			'required' => array('opt-checkbox-woocommerce','=','1'),
			'subtitle'  => __('Select store content and sidebar alignment.', 'yb'),
			'options'   => array(
				'default' => array('alt' => 'Global Default',       'img' => '/wp-content/themes/yb/assets/images/admin/layout-default.png'),
				'Full Width' => array('alt' => 'Full Width', 'img' =>  '/wp-content/themes/yb/assets/images/admin/layout-fullwidth.png'),
				'Centered No Sidebar' => array('alt' => 'Centered No Sidebar', 'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
				'Centered Left Sidebar' => array('alt' => 'Centered Left Sidebar',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
				'Centered Right Sidebar' => array('alt' => 'Centered Right Sidebar', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
			),
			'default'   => 'default'
		),
		array(
			'id'        => 'opt-text-woocommercetitle',
			'type'      => 'text',
			'title'     => __('Woocommerce Title', 'yb'),
			'required' => array('opt-checkbox-woocommerce','=','1'),
			'default'   => 'woocommerce',
		),
		array(
			'id'        => 'opt-text-woocommercesubtitle',
			'type'      => 'text',
			'title'     => __('Woocommerce Subtitle', 'yb'),
			'required' => array('opt-checkbox-woocommerce','=','1'),
			'default'   => 'woocommerce Subtitle',
		),
		array(
			'id'        => 'opt-select-woocommercetitlebar',
			'type'      => 'select',
			'title'     => __('Woocommerce Titlebar', 'yb'),
			'required' => array('opt-checkbox-woocommerce','=','1'),
			'subtitle'  => __('Choose your Woocommerce Titlebar Layout', 'yb'),
			'options'   => array(
				'default' => 'default',
				'Background-Image Style 1' => 'Background-Image Style 1',
				'Background-Image Style 2' => 'Background-Image Style 2',
			),
			'default'   => 'default'
		),
		array(
			'id'        => 'opt-media-woocommercetitlebar',
			'type'      => 'media',
			'url'       => true,
			'title'     => __('Woocommerce Titlebar Image (If Woocommerce Titlebar Layout is set to Image)', 'yb'),
			'required' => array('opt-select-woocommercetitlebar','!=','default'),
			// 'compiler'  => 'true',
			//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			// 'desc'      => __('Upload your site\'s low-res logo here.', 'yb'),
			'subtitle'  => __('Upload a Woocommerce Titlebar Image.', 'yb'),
			// 'default'   => array('url' => 'http://s.wordpress.org/style/images/codeispoetry.png'),
			//'hint'      => array(
			//    'title'     => 'Hint Title',
			//    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
			//)
		),
		array(
			'id'        => 'opt-checkbox-woocommercebreadcrumbs',
			'type'      => 'checkbox',
			'title'     => __('Disable Breadcrumbs for Woocommerce', 'yb'),
			'required' => array('opt-checkbox-woocommerce','=','1'),
			'subtitle'  => __('Check to disable Breadcrumbs for Woocommerce', 'yb'),
			// 'desc'      => __('This is the description field, again good for additional info.', 'yb'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-woocomments',
			'type'      => 'checkbox',
			'title'     => __('Disable WooCommerce Comments', 'yb'),
			'subtitle'  => __('Check to disable comments on WooCommerce products.', 'yb'),
			'required' => array('opt-checkbox-woocommerce','=','1'),
			'default'   => '0'// 1 = on | 0 = off
		),
	),
);

?>