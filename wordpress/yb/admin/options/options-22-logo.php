<?php
$this->sections[] = array(
	'icon'      => 'el-icon-flag',
	'title'     => __('Logo', 'yb'),
	'fields'    => array(
		array(
			'id'        => 'opt-media-logo',
			'type'      => 'media',
			'url'       => true,
			'title'     => __('Low-Res Logo Upload', 'yb'),
			'subtitle'  => __('Upload your site\'s low-res logo here.', 'yb'),
		),
		array(
			'id'        => 'opt-media-logo2x',
			'type'      => 'media',
			'url'       => true,
			'title'     => __('High-Res Logo Upload', 'yb'),
			'subtitle'  => __('Upload your Retina Logo. This should be your Logo in double size (If your logo is 100 x 20px, it should be 200 x 40px).', 'yb'),
		),
	)
);
?>