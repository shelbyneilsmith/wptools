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
			'id'        => 'section-bgimg-start',
			'type'      => 'section',
			'title'     => __('Main Background Image Options', 'yb'),
			'indent'    => false
		),
		array(
			'id'        => 'opt-checkbox-bgimg',
			'type'      => 'checkbox',
			'title'     => __('Enable Main Background Image Options', 'yb'),
			'subtitle'  => __('Check if you want to control the main background images here and override css.', 'yb'),
			'default'   => '0'
		),
		array(
			'id'        => 'opt-media-bgimg',
			'type'      => 'media',
			'url'       => true,
			'title'     => __('Main Background Image Upload', 'yb'),
			'subtitle'  => __('Upload the image you want to use as your main background.', 'yb'),
			'required' => array('opt-checkbox-bgimg', '=', '1')
		),
		array(
			'id'        => 'opt-select-bgimgstyle',
			'type'      => 'select',
			'title'     => __('Background Image Style', 'yb'),
			'subtitle'  => __('Choose the style you want for your main bg image.', 'yb'),
			'options'   => array(
				'stretch' => 'Stretch Image',
				'repeat' => 'Repeat',
				'no-repeat' => 'No-Repeat',
				'repeat-x' => 'Repeat-X',
				'repeat-y' => 'Repeat-Y',
			),
			'default'   => 'stretch'
		),
		array(
			'id'        => 'section-bgimg-end',
			'type'      => 'section',
			'indent'    => false
		),
		array(
			'id'        => 'section-misc-start',
			'type'      => 'section',
			'title'     => __('Miscellaneous Settings', 'yb'),
			'indent'    => false
		),
		array(
			'id'        => 'opt-typography-body',
			'type'      => 'typography',
			'title'     => __('Body Font', 'yb'),
			'subtitle'  => __('Specify the body font properties. <br /><i>Please use css to set your other site fonts.</i>', 'yb'),
			'google'    => true,
			'default'   => array(
				'color'         => '#555',
				'font-size'     => '16px',
				'font-family'   => 'Arial, Helvetica, sans-serif',
				'font-weight'   => 'Normal',
				'line-height' => '24px'
			),
			'compiler' => array( 'body' )
		),
		array(
			'id'        => 'opt-text-typekitid',
			'type'      => 'text',
			'title'     => __('Typekit ID', 'yb'),
			'subtitle'  => __('If you want to use Typekit on this site, enter the kid ID', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-select-pagination',
			'type'      => 'select',
			'title'     => __('Pagination Type', 'yb'),
			'subtitle'  => __('Choose the style of pagination for archive pages.', 'yb'),
			'options'   => array(
				'1' => 'Pagination Style 1',
				'2' => 'Pagination Style 2',
			),
			'default'   => '1'
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
			'id'        => 'opt-checkbox-mediamenu',
			'type'      => 'checkbox',
			'title'     => __('Disable Media item from showing in Admin menu', 'yb'),
			'subtitle'  => __('Check here to disable the Media item from showing in the main Wordpress menu.', 'yb'),
			'default'   => '0'
		),
		array(
			'id'        => 'opt-checkbox-bpindicator',
			'type'      => 'checkbox',
			'title'     => __('Enable breakpoint indicator for responsive development.', 'yb'),
			'subtitle'  => __('This will only show in development environments.', 'yb'),
			'default'   => '0'
		),
		array(
			'id'        => 'section-misc-end',
			'type'      => 'section',
			'indent'    => false
		),
		array(
			'id'        => 'section-favicons-start',
			'type'      => 'section',
			'title'     => __('Favicons', 'yb'),
			'indent'    => false
		),
		array(
			'id'        => 'media-favicon_front',
			'type'      => 'media',
			'preview'   => false,
			'title'     => __('Favicon Upload (16x16)', 'yb'),
			'subtitle'  => __('Upload your Favicon (16x16px ico/png - use favicon.cc to make sure it\'s fully compatible)', 'yb'),
		),
		array(
			'id'        => 'media-favicon_iphone',
			'type'      => 'media',
			'preview'   => false,
			'title'     => __('Apple iPhone Icon Upload (57x57)', 'yb'),
			'subtitle'  => __('Upload your Apple Touch Icon (57x57px png)', 'yb'),
		),
		array(
			'id'        => 'media-favicon_iphone_retina',
			'type'      => 'media',
			'preview'   => false,
			'title'     => __('Apple iPhone Retina Icon Upload (114x114)', 'yb'),
			'subtitle'  => __('Upload your Apple Touch Icon (114x114px png)', 'yb'),
		),
		array(
			'id'        => 'media-favicon_ipad',
			'type'      => 'media',
			'preview'   => false,
			'title'     => __('Apple iPad Icon Upload (72x72)', 'yb'),
			'subtitle'  => __('Upload your Apple Touch Icon (72x72px png)', 'yb'),
		),
		array(
			'id'        => 'media-favicon_ipad_retina',
			'type'      => 'media',
			'preview'   => false,
			'title'     => __('Apple iPad Retina Icon Upload (144x144px)', 'yb'),
			'subtitle'  => __('Upload your Apple Touch Retina Icon (144x144px png)', 'yb'),
		),
		array(
			'id'        => 'section-favicons-end',
			'type'      => 'section',
			'indent'    => false
		),
	)
);

?>