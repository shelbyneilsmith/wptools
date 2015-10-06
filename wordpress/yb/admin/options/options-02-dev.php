<?php
$this->sections[] = array(
	'title'     => __('Dev/Design', 'yb'),
	'icon'      => 'el-icon-idea',
	// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields'    => array(
		array(
			'id'        => 'opt-checkbox-bpindicator',
			'type'      => 'checkbox',
			'title'     => __('Enable breakpoint indicator for responsive development.', 'yb'),
			'subtitle'  => __('This will only show in development environments.', 'yb'),
			'default'   => '1'
		),
		array(
			'id'        => 'opt-checkbox-wireframes',
			'type'      => 'checkbox',
			'title'     => __('Enable wireframes options.', 'yb'),
			'subtitle'  => __('This will only show in development environments.', 'yb'),
			'default'   => '1'
		),
	),
);

$this->sections[] = array(
	'type' => 'divide',
);

?>