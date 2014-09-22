<?php
$this->sections[] = array(
	'title'     => __('Footer', 'yb'),
	'icon'      => 'el-icon-hand-down',
	'fields'    => array(
		array(
			'id'        => 'opt-checkbox-footerwidgets',
			'type'      => 'checkbox',
			'title'     => __('Enable Widgetized Footer', 'yb'),
			'subtitle'  => __('Check to show widgetized Footer.', 'yb'),
			'default'   => '0'
		),
		array(
			'id'        => 'opt-select-footercolumns',
			'type'      => 'select',
			'title'     => __('Footer Widget Columns', 'yb'),
			'required' => array('opt-checkbox-footerwidgets', '=', '1'),
			'subtitle'  => __('Select how many columns you want in the footer.', 'yb'),
			'options'   => array(
				'4' => '4',
				'3' => '3',
				'2' => '2',
				'1' => '1',
			),
			'default'   => '4'
		),
		array(
			'id'        => 'opt-checkbox-footernav',
			'type'      => 'checkbox',
			'title'     => __('Enable Footer Navigation', 'yb'),
			'subtitle'  => __('Check to enable Footer Navigation and show in Site Footer', 'yb'),
			'default'   => '0'
		),
		array(
			'id'        => 'opt-checkbox-twitterbar',
			'type'      => 'checkbox',
			'title'     => __('Enable Twitter-Bar in Footer', 'yb'),
			'subtitle'  => __('Check to show Twitter-Bar in Footer.', 'yb'),
			'default'   => '0'
		),
		array(
			'id'        => 'opt-textarea-copyright',
			'type'      => 'textarea',
			'title'     => __('Copyright Text', 'yb'),
			'subtitle'  => __('Enter your Copyright Text (HTML allowed)', 'yb'),
			'default' => __('YB theme by <a href="http://yellowberri.com">Yellowberri</a>', 'yb'),
		),
		array(
			'id'        => 'opt-checkbox-socialfooter',
			'type'      => 'checkbox',
			'title'     => __('Show Social Icons in Footer', 'yb'),
			'subtitle'  => __('Check to show Social Icons in Footer (Configure Icons in Social Media)', 'yb'),
			'default'   => '1'
		),
		array(
			'id'        => 'opt-checkbox-backtotop',
			'type'      => 'checkbox',
			'title'     => __('Show Back-to-top Link in Footer', 'yb'),
			'subtitle'  => __('Check to show back-to-top link in Footer.', 'yb'),
			'default'   => '0'
		),
		array(
			'id'        => 'opt-textarea-analyticscode',
			'type'      => 'textarea',
			'title'     => __('Tracking Code', 'yb'),
			'subtitle'  => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'yb'),
			'validate'  => 'js',
			'default' => ''
		),
	),
);

$this->sections[] = array(
	'type' => 'divide',
);

?>