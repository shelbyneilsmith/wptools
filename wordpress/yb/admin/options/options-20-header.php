<?php
$this->sections[] = array(
	'title'     => __('Header', 'yb'),
	'icon'      => 'el-icon-hand-up',
	'fields'    => array(
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
	),
);

?>