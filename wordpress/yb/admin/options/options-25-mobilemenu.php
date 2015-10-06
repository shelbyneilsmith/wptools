<?php
$this->sections[] = array(
	'icon'      => 'el-icon-lines',
	'title'     => __('Mobile Menu', 'yb'),
	'fields'    => array(
		array(
			'id'        => 'opt-checkbox-mobilemenu',
			'type'      => 'checkbox',
			'title'     => __('Enable Mobile Menu', 'yb'),
			'subtitle'  => __('Enable or disable the mobile menu features.', 'yb'),
			'default'   => '1'
		),
		array(
			'id'        => 'opt-select-mobilemenutype',
			'type'      => 'select',
			'title'     => __('Mobile Menu Type', 'yb'),
			'subtitle'  => __('Select the type of menu you want to use.', 'yb'),
			'required' => array('opt-checkbox-mobilemenu', '=', '1'),
			'options'   => array(
				'footer-nav' => '"Jump-to-footer" Navigation',
				'offscreen-nav' => 'Off-screen Navigation',
			),
			'default'   => 'offscreen-nav'
		),
		array(
			'id'        => 'opt-select-offscreenpos',
			'type'      => 'select',
			'title'     => __('Mobile Menu Offscreen Position', 'yb'),
			'subtitle'  => __('Select the direction the menu should appear from.', 'yb'),
			'required' => array('opt-select-mobilemenutype', '=', 'offscreen-nav'),
			'options'   => array(
				'top' => 'Top',
				'bottom' => 'Bottom',
				'left' => 'Left',
				'right' => 'Right',
			),
			'default'   => 'left'
		),
		array(
			'id'        => 'opt-select-mobilemenuanim',
			'type'      => 'select',
			'title'     => __('Mobile Menu Appearance Animation', 'yb'),
			'subtitle'  => __('Select the type of animation for the mobile menu.', 'yb'),
			'required' => array('opt-select-mobilemenutype', '=', 'offscreen-nav'),
			'options'   => array(
				'slide-over' => 'Basic Slide-over',
				'slide-push' => 'Content Push',
				'slide-reveal' => 'Basic Menu Reveal',
				'slide-along' => 'Reveal with Slide-along',
				'fall-down' => 'Menu Fall Down'
			),
			'default'   => 'slide-over'
		),
		array(
			'id'        => 'opt-checkbox-utilitynavmerge',
			'type'      => 'checkbox',
			'title'     => __('Merge Utility Nav w/ Main Nav', 'yb'),
			'required' => array('opt-checkbox-mobilemenu', '=', '1'),
			'subtitle'  => __('Check here to merge the utility nav within the mobile nav.', 'yb'),
			'default'   => '1'
		),
		array(
			'id'        => 'opt-select-menubtnpos',
			'type'      => 'select',
			'title'     => __('Menu Button Position', 'yb'),
			'subtitle'  => __('Select the position of the mobile menu button.', 'yb'),
			'required' => array('opt-checkbox-mobilemenu', '=', '1'),
			'options'   => array(
				'header-right' => 'Header Right Side',
				'header-left' => 'Header Left Side',
				'bottom-thumb-right' => 'Bottom of Screen Thumb - Right Side',
				'bottom-thumb-left' => 'Bottom of Screen Thumb - Left Side'
			),
			'default'   => 'header-right'
		),
	)
);
?>