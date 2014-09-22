<?php
$this->sections[] = array(
	'title'     => __('Dev/Design', 'yb'),
	'icon'      => 'el-icon-idea',
	// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields'    => array(
		array(
			'id'        => 'opt-checkbox-wireframes',
			'type'      => 'checkbox',
			'title'     => __('Enable wireframes options.', 'yb'),
			'subtitle'  => __('This will only show in development environments.', 'yb'),
			'default'   => '1'
		),
		array(
			'id'        => 'opt-checkbox-styletiles',
			'type'      => 'checkbox',
			'title'     => __('Enable styletiles options.', 'yb'),
			'subtitle'  => __('This will only show in development environments.', 'yb'),
			'default'   => '1'
		),
		array(
			'id'        => 'opt-text-styletilesnum',
			'type'      => 'text',
			'title'     => __('Number of StyleTiles', 'yb'),
			'subtitle'  => __('Please specify how many styletiles you want to use. <br />(No more than 26, you psychopath)', 'yb'),
			'required' => array('opt-checkbox-styletiles', '=', '1'),
			'default'   => '3',
		),
		array(
			'id'        => 'opt-text-colorsnum',
			'type'      => 'text',
			'title'     => __('Number of Colors in Color Palette', 'yb'),
			'subtitle'  => __('Please specify how many colors are in your color palette.', 'yb'),
			'required' => array('opt-checkbox-styletiles', '=', '1'),
			'default'   => '5',
		),
	),
);

$this->sections[] = array(
	'type' => 'divide',
);

?>