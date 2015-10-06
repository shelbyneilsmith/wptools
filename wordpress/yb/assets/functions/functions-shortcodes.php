<?php

/* div with class */
function yb_div( $atts, $content = null) {
	extract( shortcode_atts( array( 'class' => '' ), $atts ) );
	return '<div class="clearfix '.$class. '">' . do_shortcode($content) . '</div>';
}


/*  section w/ centered container */
function yb_section( $atts, $content = null) {

	$yb_section_array = array(
		'class'   => '',
		'bgcolor'   => '',
		'bgimage'   => '',
		'parallax'  => 'false',
		'padding' => '',
		'border' => 'none'
		);

	extract( shortcode_atts( $yb_section_array, $atts ));

	if ($parallax == 'false') { $var1 = ''; }
	else { $var1 = 'section-parallax'; }

	$var2 = '';

	if ($bgimage != '') { $var2 = 'background-image: url(' . $bgimage . ');'; }

	return '<div class="'. $class . ' section ' . $var1 . '" style="background-color: ' . $bgcolor . '; border: ' . $border . '; padding: ' . $padding . '; ' . $var2 . '"><div class="container clearfix">' . do_shortcode($content) . '</div></div>';
}

/* content box */
function yb_box( $atts, $content = null) {
	extract( shortcode_atts( array(
		'style' => '1',
		'class' => ''
		), $atts ) );
	return '<div class="'.$class.' clearfix style-' .$style. '">' . do_shortcode($content) . '</div>';
}

/* placeholder image */
function yb_placeholder_img( $atts, $content = null) {
	extract( shortcode_atts( array(
		'width' => 'width',
		'height' => 'height',
		'float' => 'none'
		), $atts ) );

	if ( $float == 'left' ) {
		$margin = " margin: 0 20px 20px 0;";
	} else if ( $float == 'right' ) {
		$margin = " margin: 0 0px 20px 20px;";
	} else {
		$margin = "";
	}

	return '<img style="float: '.$float.';'.$margin.'" src="http://placehold.it/'.$width.'x'.$height.'" />';
}


/* accordion */
function yb_accordion($atts, $content=null, $code) {

	extract(shortcode_atts(array(
		'open' => '1'
		), $atts));

	if (!preg_match_all("/(.?)\[(accordion-item)\b(.*?)(?:(\/))?\](?:(.+?)\[\/accordion-item\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	}
	else {
		$output = '';
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);

			$output .= '<div class="accordion-title"><a href="#">' . $matches[3][$i]['title'] . '</a></div><div class="accordion-inner">' . do_shortcode(trim($matches[5][$i])) .'</div>';
		}
		return '<div class="accordion" rel="'.$open.'">' . $output . '</div>';

	}

}

/* buttons */
function yb_buttons( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'link'    => '#',
		'size'    => 'medium',
		'target'  => '_self',
		'lightbox'  => 'false',
		'type'    => '',
		'altcolor'  => 'false',
		'icon'    => ''
		), $atts));

	if($lightbox == 'true') {
		$return = "prettyPhoto ";
	} else{
		$return = "";
	}
	// if($type == 'gradient') {
	//  $returntype = "gradient ";
	// } else {
	//  $returntype = "";
	// }
	if($altcolor == 'true') {
		$returncolor = "alt ";
	} else {
		$returncolor = "";
	}
	if($icon == '') {
		$return2 = "";
	}
	else{
		$return2 = "<i class='icon-".$icon."'></i>";
	}

	$out = "<a href=\"" .$link. "\" target=\"" .$target. "\" class=\"button ".$return.$type." ".$returncolor.$size."\" rel=\"slides[buttonlightbox]\">". $return2 . "". do_shortcode($content). "</a>";
	return $out;
}

/*  gap dividers */
function yb_gap( $atts, $content = null) {

	extract( shortcode_atts( array(
		'height'  => '10'
		), $atts ) );

	if($height == '') {
		$return = '';
	}
	else{
		$return = 'style="height: '.$height.'px;"';
	}

	return '<div class="gap" ' . $return . '></div>';
}

/*  columns */
function yb_one_third( $atts, $content = null ) {
	return '<div class="one_third">' . do_shortcode($content) . '</div>';
}

function yb_one_third_last( $atts, $content = null ) {
	return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function yb_two_third( $atts, $content = null ) {
	return '<div class="two_third">' . do_shortcode($content) . '</div>';
}

function yb_two_third_last( $atts, $content = null ) {
	return '<div class="two_third last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function yb_one_half( $atts, $content = null ) {
	return '<div class="one_half">' . do_shortcode($content) . '</div>';
}

function yb_one_half_last( $atts, $content = null ) {
	return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function yb_one_fourth( $atts, $content = null ) {
	return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}

function yb_one_fourth_last( $atts, $content = null ) {
	return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function yb_three_fourth( $atts, $content = null ) {
	return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}

function yb_three_fourth_last( $atts, $content = null ) {
	return '<div class="three_fourth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

/* media */
function yb_video($atts) {
	extract(shortcode_atts(array(
		'type'  => '',
		'id'  => '',
		'width'   => false,
		'height'  => false,
		'autoplay'  => ''
		), $atts));

	if ($height && !$width) $width = intval($height * 16 / 9);
	if (!$height && $width) $height = intval($width * 9 / 16);
	if (!$height && !$width){
		$height = 315;
		$width = 560;
	}

	$return = '';

	$autoplay = ($autoplay == 'yes' ? '1' : false);

	if($type == "vimeo") $return = "<div class='video-embed'><iframe src='http://player.vimeo.com/video/$id?autoplay=$autoplay&amp;title=0&amp;byline=0&amp;portrait=0' width='$width' height='$height' class='iframe'></iframe></div>";

	else if($type == "youtube") $return = "<div class='video-embed'><iframe src='http://www.youtube.com/embed/$id?HD=1;rel=0;showinfo=0' width='$width' height='$height' class='iframe'></iframe></div>";

	if (!empty($id)){
		return $return;
	}
}

/* social icons */
function yb_social( $atts, $content = null) {

	extract( shortcode_atts( array(
		'icon'  => 'twitter',
		'url'   => '#',
		'target'  => '_blank'
		), $atts ) );

	$capital = ucfirst($icon);

	return '<div class="social-icon social-' . $icon . '"><a href="' . $url . '" title="' . $capital . '" target="' . $target . '">' . $capital . '</a></div>';
}

/*  tabs */
function yb_tabgroup( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'style' => 'horizontal',
		), $atts));

	$GLOBALS['tab_count'] = 0;
	$i = 1;
	$randomid = rand();

	do_shortcode( $content );

	if( is_array( $GLOBALS['tabs'] ) ){

		foreach( $GLOBALS['tabs'] as $tab ){
			if( $tab['icon'] != '' ){
				$icon = '<i class="icon-'.$tab['icon'].'"></i>';
			}
			else{
				$icon = '';
			}
			$tabs[] = '<li class="tab"><a href="#panel'.$randomid.$i.'">'.$icon . $tab['title'].'</a></li>';
			$panes[] = '<div class="panel" id="panel'.$randomid.$i.'"><p>'.$tab['content'].'</p></div>';
			$i++;
			$icon = '';
		}
		$return = '<div class="tabset tabstyle-'.$style.' clearfix"><ul class="tabs">'.implode( "\n", $tabs ).'</ul><div class="panels">'.implode( "\n", $panes ).'</div></div>';
	}
	return $return;
}
add_shortcode( 'tabgroup', 'yb_tabgroup' );

function yb_tab( $atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'icon'  => ''
		), $atts));

	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'icon' => $icon, 'content' =>  do_shortcode( $content ) );
	$GLOBALS['tab_count']++;
}
add_shortcode( 'tab', 'yb_tab' );


/* toggle */
function yb_toggle( $atts, $content = null){
	extract(shortcode_atts(array(
		'title' => '',
		'icon' => '',
		'open' => "false"
		), $atts));

	if($icon == '') {
		$return = "";
	}
	else{
		$return = "<i class='icon-".$icon."'></i>";
	}

	if($open == "true") {
	 $return2 = "active";
 }
 else{
	 $return2 = '';
 }

 return '<div class="toggle"><div class="toggle-title '.$return2.'">'.$return.''.$title.'<span></span></div><div class="toggle-inner"><p>'. do_shortcode($content) . '</p></div></div>';
}

/* pre process shortcodes */
function pre_process_shortcode($content) {
	global $shortcode_tags;

	/* backup current registered shortcodes and clear them all out */
	$orig_shortcode_tags = $shortcode_tags;
	remove_all_shortcodes();

	add_shortcode('div', 'yb_div');
	add_shortcode('section', 'yb_section');
	add_shortcode('box', 'yb_box');

	add_shortcode('one_third', 'yb_one_third');
	add_shortcode('one_third_last', 'yb_one_third_last');
	add_shortcode('two_third', 'yb_two_third');
	add_shortcode('two_third_last', 'yb_two_third_last');
	add_shortcode('one_half', 'yb_one_half');
	add_shortcode('one_half_last', 'yb_one_half_last');
	add_shortcode('one_fourth', 'yb_one_fourth');
	add_shortcode('one_fourth_last', 'yb_one_fourth_last');
	add_shortcode('three_fourth', 'yb_three_fourth');
	add_shortcode('three_fourth_last', 'yb_three_fourth_last');

	add_shortcode('gap', 'yb_gap');

	add_shortcode('yb_button', 'yb_buttons');

	add_shortcode('placeholder_img', 'yb_placeholder_img');

	add_shortcode('accordion', 'yb_accordion');

	add_shortcode('embedvideo', 'yb_video');

	add_shortcode('social', 'yb_social');

	add_shortcode('toggle', 'yb_toggle');

	/* do the shortcode (only the one above is registered) */
	$content = do_shortcode($content);

	/* put the original shortcodes back */
	$shortcode_tags = $orig_shortcode_tags;

	return $content;
}


add_filter('the_content', 'pre_process_shortcode', 7);

/* allow shortcodes in widgets */
add_filter('widget_text', 'pre_process_shortcode', 7);

/* TODO: Add allow shortcodes in ACF WYSIWYG */

/* add TinyMCE buttons to editor */
add_action('init', 'add_button');

function add_button() {
	if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
	{
		add_filter('mce_external_plugins', 'add_plugin');
		add_filter('mce_buttons_3', 'register_button_3');
		add_filter('mce_buttons_4', 'register_button_4');
	}
}

/* Define Position of TinyMCE Icons */
function register_button_3($buttons) {
	array_push($buttons, "div", "section", "box", "one_half", "one_third", "two_third", "one_fourth", "three_fourth", "gap");
	return $buttons;
}
function register_button_4($buttons) {
	array_push($buttons, "yb_button", "placeholder_img", "accordion", "video", "socialmedia", "tabs", "toggle");
	return $buttons;
}

function add_plugin($plugin_array) {
	global $data;

	$plugin_array['div'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['section'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['box'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['one_half'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['one_third'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['two_third'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['one_fourth'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['three_fourth'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['gap'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['yb_button'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['placeholder_img'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['accordion'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['video'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['socialmedia'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['tabs'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';
	$plugin_array['toggle'] = get_template_directory_uri().'/assets/inc/tinymce/tinymce.js';

	return $plugin_array;
}
?>