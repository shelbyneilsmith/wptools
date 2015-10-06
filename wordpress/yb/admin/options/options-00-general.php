<?php
$this->sections[] = array(
	'icon'      => 'el-icon-cogs',
	'title'     => __('General Settings', 'yb'),
	'fields'    => array(
		array(
			'id'        => 'opt-preset-sitetype',
			'type'      => 'image_select',
			'presets'   => true,
			'title'     => __('Site Type', 'yb'),
			'subtitle'  => __('Choose a basic site type to apply group of settings to speed up development!', 'yb'),
			'default'   => 'Miscellaneous',
			'options'   => array(
				'Miscellaneous'	=> array('alt' => 'Miscellaneous', 'img' 	=> '', 'presets'	=> array( 'opt-checkbox-blog' => '0' )),
				'Blog'         		=> array('alt' => 'Blog/News', 'img' 	=> '', 'presets' 	=> array( 'opt-checkbox-blog' => '1' )),
				'Political'		=> array('alt' => 'Political', 'img' 		=> '', 'presets' 	=> array( 'opt-checkbox-blog' => '0' )),
				'Restaurant'	=> array('alt' => 'Restaurant', 'img' 	=> '', 'presets' 	=> array( 'opt-checkbox-blog' => '0' )),
				'Band'		=> array('alt' => 'Band/Musician', 'img' 	=> '', 'presets' 	=> array( 'opt-checkbox-blog' => '0' )),
				'Portfolio'		=> array('alt' => 'Portfolio/Artist', 'img' 	=> '', 'presets' 	=> array( 'opt-checkbox-blog' => '0' )),
				'e-Commerce'	=> array('alt' => 'e-Commerce', 'img' 	=> '', 'presets' 	=> array( 'opt-checkbox-woocommerce' => '1' )),
			),
		),
		array(
			'id'        => 'opt-text-misc-sitetype',
			'type'      => 'text',
			'title'     => __('Site Type (If Miscellaneous)', 'yb'),
			'subtitle'  => __('Please specify what type of site this is <br />(mostly for Facebook meta tag purposes).', 'yb'),
			'required' => array('opt-preset-sitetype', '=', 'Miscellaneous'),
			'default'   => 'Miscellaneous',
		),
		array(
			'id'        => 'section-misc-start',
			'type'      => 'section',
			'title'     => __('Miscellaneous Settings', 'yb'),
			'indent'    => false
		),
		array(
			'id'        => 'opt-text-typekitid',
			'type'      => 'text',
			'title'     => __('Typekit ID', 'yb'),
			'subtitle'  => __('If you want to use Typekit on this site, enter the kid ID', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-checkbox-dashicons',
			'type'      => 'checkbox',
			'title'     => __('Enable Wordpress Dashicons for Front-end Use', 'yb'),
			'subtitle' => __('See <a href="https://developer.wordpress.org/resource/dashicons" target="_blank">https://developer.wordpress.org/resource/dashicons</a> for more information.', 'yb'),
			'default'   => '0'
		),
		array(
			'id'        => 'opt-checkbox-breadcrumbs',
			'type'      => 'checkbox',
			'title'     => __('Enable Breadcrumbs on Regular Pages', 'yb'),
			'default'   => '0'
		),
		array(
			'id'        => 'opt-checkbox-pagecomments',
			'type'      => 'checkbox',
			'title'     => __('Disable Comments for all Content Pages (not Blog)', 'yb'),
			'subtitle'  => __('Be careful: Page specific Settings get overwritten.', 'yb'),
			'default'   => '1'
		),
		array(
			'id'        => 'opt-checkbox-disquscomments',
			'type'      => 'checkbox',
			'title'     => __('Use Disqus for all Comments', 'yb'),
			'default'   => '1'
		),
		array(
			'id'        => 'opt-checkbox-mediamenu',
			'type'      => 'checkbox',
			'title'     => __('Disable Media item from showing in Admin menu', 'yb'),
			'subtitle'  => __('Check here to disable the Media item from showing in the main Wordpress menu.', 'yb'),
			'default'   => '0'
		),
		array(
			'id'        => 'opt-color-chrome-theme',
			'type'      => 'color_rgba',
			'title'     => __('Chrome Theme Color', 'yb'),
			'subtitle'  => __('Meta tag to customize Android chrome tabs', 'yb'),
			'options'   => array(
				'show_palette_only'         => true,
				'show_selection_palette' => false,
				'show_alpha' => false,
			),
			'default'   => '0',
		),
		array(
			'id'        => 'section-misc-end',
			'type'      => 'section',
			'indent'    => false
		),
	)
);

?>