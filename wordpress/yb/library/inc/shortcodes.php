<?php

/*-----------------------------------------------------------------------------------*/
/*	Simple Div w/ Class
/*-----------------------------------------------------------------------------------*/
function yb_div( $atts, $content = null) {
	extract( shortcode_atts( array(
		'class' => 'div-class'
	), $atts ) );
	return '<div class="clearfix '.$class. '">' . do_shortcode($content) . '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Content Box
/*-----------------------------------------------------------------------------------*/
function yb_box( $atts, $content = null) {
extract( shortcode_atts( array(
		'style' => '1',
		'class' => 'box-class'
		), $atts ) );
		return '<div class="'.$class.' clearfix style-' .$style. '">' . do_shortcode($content) . '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Simple Div w/ Class
/*-----------------------------------------------------------------------------------*/
function yb_placeholder_img( $atts, $content = null) {
	extract( shortcode_atts( array(
		'width' => 'width',
		'height' => 'height'
	), $atts ) );
	return '<img src="http://placehold.it/'.$width.'x'.$height.'" />';
}


/*-----------------------------------------------------------------------------------*/
/*	Accordion
/*-----------------------------------------------------------------------------------*/
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

/*-----------------------------------------------------------------------------------*/
/*	Alert
/*-----------------------------------------------------------------------------------*/
function yb_alert( $atts, $content = null) {

extract( shortcode_atts( array(
		'type' 	=> 'warning',
		'close'	=> 'true'
		), $atts ) );

		if($close == 'false') {
		  $var1 = '';
	  }
	  else{
		  $var1 = '<span class="close" href="#">x</span>';
	  }

		return '<div class="alert-message ' . $type . '">' . do_shortcode($content) . '' . $var1 . '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Br-Tag
/*-----------------------------------------------------------------------------------*/
function yb_br() {
	return '<br />';
}

/*-----------------------------------------------------------------------------------*/
/* Buttons
/*-----------------------------------------------------------------------------------*/
function yb_buttons( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'link'		=> '#',
		'size'		=> 'medium',
		'target'	=> '_self',
		'lightbox'	=> 'false',
		'type'		=> '',
		'altcolor'	=> 'false',
		'icon'		=> ''
	), $atts));

	if($lightbox == 'true') {
		$return = "prettyPhoto ";
	} else{
		$return = "";
	}
	// if($type == 'gradient') {
	// 	$returntype = "gradient ";
	// } else {
	// 	$returntype = "";
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

/*-----------------------------------------------------------------------------------*/
/*	HR Dividers
/*-----------------------------------------------------------------------------------*/
function yb_hr( $atts, $content = null) {
extract( shortcode_atts( array(
		'margin' => ''
		), $atts ) );

	 if($margin == '') {
		$return = "";
	 } else{
		$return = " style='margin:".$margin." !important;'";
	 }

	 return '<hr' .$return. '></hr>';
}


/*-----------------------------------------------------------------------------------*/
/*	Tagline
/*-----------------------------------------------------------------------------------*/
function yb_tagline( $atts, $content = null) {
extract( shortcode_atts( array(
		'style' => '1',
		'margin' => ''
		), $atts ) );

	 return '<div class="tagline">' . do_shortcode($content) . '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Gap Dividers
/*-----------------------------------------------------------------------------------*/

function yb_gap( $atts, $content = null) {

extract( shortcode_atts( array(
		'height' 	=> '10'
		), $atts ) );

		if($height == '') {
		  $return = '';
	  }
	  else{
		  $return = 'style="height: '.$height.'px;"';
	  }

		return '<div class="gap" ' . $return . '></div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Clear-Tag
/*-----------------------------------------------------------------------------------*/
function yb_clear() {
	 return '<div class="clear"></div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Columns
/*-----------------------------------------------------------------------------------*/
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

function yb_one_fifth( $atts, $content = null ) {
	return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}

function yb_one_fifth_last( $atts, $content = null ) {
	return '<div class="one_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function yb_two_fifth( $atts, $content = null ) {
	return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}

function yb_two_fifth_last( $atts, $content = null ) {
	return '<div class="two_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function yb_three_fifth( $atts, $content = null ) {
	return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}

function yb_three_fifth_last( $atts, $content = null ) {
	return '<div class="three_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function yb_four_fifth( $atts, $content = null ) {
	return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}

function yb_four_fifth_last( $atts, $content = null ) {
	return '<div class="four_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function yb_one_sixth( $atts, $content = null ) {
	return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}

function yb_one_sixth_last( $atts, $content = null ) {
	return '<div class="one_sixth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function yb_five_sixth( $atts, $content = null ) {
	return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}

function yb_five_sixth_last( $atts, $content = null ) {
	return '<div class="five_sixth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

/*-----------------------------------------------------------------------------------*/
/* Dropcap */
/*-----------------------------------------------------------------------------------*/
function yb_dropcap($atts, $content = null) {
	 extract(shortcode_atts(array(
		  'style'      => ''
	 ), $atts));

	 if($style == '') {
		$return = "";
	 }
	 else{
		$return = "dropcap-".$style;
	 }

	$out = "<span class='dropcap ". $return ."'>" .$content. "</span>";
	 return $out;
}

/*-----------------------------------------------------------------------------------*/
/* Media */
/*-----------------------------------------------------------------------------------*/

function yb_video($atts) {
	extract(shortcode_atts(array(
		'type' 	=> '',
		'id' 	=> '',
		'width' 	=> false,
		'height' 	=> false,
		'autoplay' 	=> ''
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
/*-----------------------------------------------------------------------------------*/
/* Media */
/*-----------------------------------------------------------------------------------*/

add_action('wp_head', 'gmaps_header');

function gmaps_header() {
	?>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<?php
}

function yb_map($atts) {

	// default atts
	$atts = shortcode_atts(array(
		'lat'   => '0',
		'lon'    => '0',
		'id' => 'map',
		'z' => '1',
		'w' => '400',
		'h' => '300',
		'maptype' => 'ROADMAP',
		'address' => '',
		'kml' => '',
		'kmlautofit' => 'yes',
		'marker' => '',
		'markerimage' => '',
		'traffic' => 'no',
		'bike' => 'no',
		'fusion' => '',
		'start' => '',
		'end' => '',
		'infowindow' => '',
		'infowindowdefault' => 'yes',
		'directions' => '',
		'hidecontrols' => 'false',
		'scale' => 'false',
		'scrollwheel' => 'true',
		'style' => ''
	), $atts);

	$returnme = '<div id="' .$atts['id'] . '" style="width:' . $atts['w'] . 'px;height:' . $atts['h'] . 'px;" class="google_map ' . $atts['style'] . '"></div>';

	//directions panel
	if($atts['start'] != '' && $atts['end'] != '')
	{
		$panelwidth = $atts['w']-20;
		$returnme .= '<div id="directionsPanel" style="width:' . $panelwidth . 'px;height:' . $atts['h'] . 'px;border:1px solid gray;padding:10px;overflow:auto;"></div><br>';
	}

	$returnme .= '
	<script type="text/javascript">
		var latlng = new google.maps.LatLng(' . $atts['lat'] . ', ' . $atts['lon'] . ');
		var myOptions = {
			zoom: ' . $atts['z'] . ',
			center: latlng,
			scrollwheel: ' . $atts['scrollwheel'] .',
			scaleControl: ' . $atts['scale'] .',
			disableDefaultUI: ' . $atts['hidecontrols'] .',
			mapTypeId: google.maps.MapTypeId.' . $atts['maptype'] . '
		};
		var ' . $atts['id'] . ' = new google.maps.Map(document.getElementById("' . $atts['id'] . '"),
		myOptions);
		';

		//kml
		if($atts['kml'] != '')
		{
			if($atts['kmlautofit'] == 'no')
			{
				$returnme .= '
				var kmlLayerOptions = {preserveViewport:true};
				';
			}
			else
			{
				$returnme .= '
				var kmlLayerOptions = {preserveViewport:false};
				';
			}
			$returnme .= '
			var kmllayer = new google.maps.KmlLayer(\'' . html_entity_decode($atts['kml']) . '\',kmlLayerOptions);
			kmllayer.setMap(' . $atts['id'] . ');
			';
		}

		//directions
		if($atts['start'] != '' && $atts['end'] != '')
		{
			$returnme .= '
			var directionDisplay;
			var directionsService = new google.maps.DirectionsService();
			 directionsDisplay = new google.maps.DirectionsRenderer();
			 directionsDisplay.setMap(' . $atts['id'] . ');
			directionsDisplay.setPanel(document.getElementById("directionsPanel"));

				var start = \'' . $atts['start'] . '\';
				var end = \'' . $atts['end'] . '\';
				var request = {
					origin:start,
					destination:end,
					travelMode: google.maps.DirectionsTravelMode.DRIVING
				};
				directionsService.route(request, function(response, status) {
					if (status == google.maps.DirectionsStatus.OK) {
						directionsDisplay.setDirections(response);
					}
				});


			';
		}

		//traffic
		if($atts['traffic'] == 'yes')
		{
			$returnme .= '
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap(' . $atts['id'] . ');
			';
		}

		//bike
		if($atts['bike'] == 'yes')
		{
			$returnme .= '
			var bikeLayer = new google.maps.BicyclingLayer();
			bikeLayer.setMap(' . $atts['id'] . ');
			';
		}

		//fusion tables
		if($atts['fusion'] != '')
		{
			$returnme .= '
			var fusionLayer = new google.maps.FusionTablesLayer(' . $atts['fusion'] . ');
			fusionLayer.setMap(' . $atts['id'] . ');
			';
		}

		//address
		if($atts['address'] != '')
		{
			$returnme .= '
			 var geocoder_' . $atts['id'] . ' = new google.maps.Geocoder();
			var address = \'' . $atts['address'] . '\';
			geocoder_' . $atts['id'] . '.geocode( { \'address\': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					' . $atts['id'] . '.setCenter(results[0].geometry.location);
					';

					if ($atts['marker'] !='')
					{
						//add custom image
						if ($atts['markerimage'] !='')
						{
							$returnme .= 'var image = "'. $atts['markerimage'] .'";';
						}
						$returnme .= '
						var marker = new google.maps.Marker({
							map: ' . $atts['id'] . ',
							';
							if ($atts['markerimage'] !='')
							{
								$returnme .= 'icon: image,';
							}
						$returnme .= '
							position: ' . $atts['id'] . '.getCenter()
						});
						';

						//infowindow
						if($atts['infowindow'] != '')
						{
							//first convert and decode html chars
							$thiscontent = htmlspecialchars_decode($atts['infowindow']);
							$returnme .= '
							var contentString = \'' . $thiscontent . '\';
							var infowindow = new google.maps.InfoWindow({
								content: contentString
							});

							google.maps.event.addListener(marker, \'click\', function() {
							  infowindow.open(' . $atts['id'] . ',marker);
							});
							';

							//infowindow default
							if ($atts['infowindowdefault'] == 'yes')
							{
								$returnme .= '
									infowindow.open(' . $atts['id'] . ',marker);
								';
							}
						}
					}
			$returnme .= '
				} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
			});
			';
		}

		//marker: show if address is not specified
		if ($atts['marker'] != '' && $atts['address'] == '')
		{
			//add custom image
			if ($atts['markerimage'] !='')
			{
				$returnme .= 'var image = "'. $atts['markerimage'] .'";';
			}

			$returnme .= '
				var marker = new google.maps.Marker({
				map: ' . $atts['id'] . ',
				';
				if ($atts['markerimage'] !='')
				{
					$returnme .= 'icon: image,';
				}
			$returnme .= '
				position: ' . $atts['id'] . '.getCenter()
			});
			';

			//infowindow
			if($atts['infowindow'] != '')
			{
				$returnme .= '
				var contentString = \'' . $atts['infowindow'] . '\';
				var infowindow = new google.maps.InfoWindow({
					content: contentString
				});

				google.maps.event.addListener(marker, \'click\', function() {
				  infowindow.open(' . $atts['id'] . ',marker);
				});
				';
				//infowindow default
				if ($atts['infowindowdefault'] == 'yes')
				{
					$returnme .= '
						infowindow.open(' . $atts['id'] . ',marker);
					';
				}
			}
		}

		$returnme .= '</script>';


		return $returnme;
}
add_shortcode('map', 'yb_map');

/*-----------------------------------------------------------------------------------*/
/*	Icons & Iconbox
/*-----------------------------------------------------------------------------------*/

function yb_icon( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'icon'      => 'mac'
	 ), $atts));

	$out = '<span class="iconbox-'. $icon .'"></span>';
	 return $out;
}

/*-----------------------------------------------------------------------------------*/

function yb_iconbox( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'icon'      => 'ok',
			'title'		=> '',
			'iconurl' 	=> ''
	 ), $atts));

	 $geticon = '';

	 if($iconurl != ''){
		 $geticon = '<span class="iconbox-none"><img src="'.$iconurl.'" /></span>';
	 }
	 else{
		 $geticon = '<span class="iconbox-'. $icon .'"></span>';
	 }

	$out = '<div class="iconbox">'.$geticon.'<h3>'. $title .'</h3>'. do_shortcode($content) . '</div>';
	 return $out;
}

/*-----------------------------------------------------------------------------------*/

function yb_miniicon( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'icon'      => 'ok'
	 ), $atts));

	$out = '<i class="icon-'. $icon .'"></i>';
	 return $out;
}

/*-----------------------------------------------------------------------------------*/

function yb_retinaicon( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'icon'      => 'ok',
			'color'     => '#ffffff',
			'background' => '#999999',
			'circle'     => false,
			'align'		=> 'center',
			'size'      => 'small'
	 ), $atts));

	 if($size == 'large') {
		$return = " retinaicon-large";
	 }
	 elseif($size == 'medium') {
		$return = " retinaicon-medium";
	 }
	 elseif($size == 'small') {
		$return = " retinaicon-small";
	 }
	 else{
		$return = " retinaicon-small";
	 }

	 if($circle == true) {
		$return2 = " retinaicon-circ";
		$return3 = ' style="background-color:'.$background.'; color: '.$color.';"';
		$return4 = ' style="text-align: '.$align.' !important;"';
	 }
	 else{
		$return2 = "";
		$return3 = ' style="background-color: transparent; color: '.$color.';"';
		$return4 = ' style="text-align: '.$align.' !important;"';
	 }

	$out = '<span class="retinaicon '. $return .''. $return2 .'" '. $return4 .'><span class="retinaicon-'. $icon .'"'. $return3 .'></span></span>';
	 return $out;
}

/*-----------------------------------------------------------------------------------*/

function yb_retinaiconbox( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'icon'      => 'ok',
			'title'		=> '',
			'color'		=> '#999999',
			'background' => '#efefef',
			'circle'     => false
	 ), $atts));

	 if($circle == true) {
		$return2 = " retinaicon-circ";
		$return3 = ' style="background-color:'.$background.'; color: '.$color.';"';
	 }
	 else{
		$return2 = "";
		$return3 = ' style="background-color: transparent; color: '.$color.';"';
	 }

	$out = '<div class="retinaiconbox"><span class="retinaicon-'. $icon .''. $return2 .'" '. $return3 .'></span><h3>'. $title .'</h3>'. do_shortcode($content) . '</div>';
	 return $out;
}

/*-----------------------------------------------------------------------------------*/
/*	Lists
/*-----------------------------------------------------------------------------------*/

function yb_list( $atts, $content = null ) {
	 extract(shortcode_atts(array(), $atts));
	$out = '<ul class="styled-list">'. do_shortcode($content) . '</ul>';
	 return $out;
}

/*-----------------------------------------------------------------------------------*/

function yb_item( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'icon'      => 'ok'
	 ), $atts));
	$out = '<li><i class="icon-'.$icon.'"></i>'. do_shortcode($content) . '</li>';
	 return $out;
}

/*-----------------------------------------------------------------------------------*/
/*	Member
/*-----------------------------------------------------------------------------------*/

function yb_member( $atts, $content = null) {
extract( shortcode_atts( array(
		'img' 	=> '',
		'name' 	=> '',
		'url'		=> '',
		'role'	=> '',
		'twitter' => '',
		'facebook' => '',
		'skype' => '',
		'google' => '',
		'linkedin' => '',
		'mail' => '',
		), $atts ) );

		if($url != '') {
		$returnurl = "<a href='".$url."'>";
		$returnurl2 = "</a>";
		} else {
		$returnurl = "";
		$returnurl2 = "";
		}

		if($img == '') {
		$return = "";
		} else{
		$return = "<div class='member-img'>".$returnurl."<img src='".$img."' />".$returnurl2."</div>";
		}



		if( $twitter != '' || $facebook != '' || $skype != '' || $google != '' || $linkedin != '' || $mail != '' ){
			$return8 = '<div class="member-social"><ul>';
			$return9 = '</ul></div>';

			if($twitter != '') {
			$return2 = '<li class="member-social-twitter"><a href="' .$twitter. '" target="_blank" title="Twitter">Twitter</a></li>';
			} else{
			  $return2 = '';
			}

			if($facebook != '') {
			$return3 = '<li class="member-social-facebook">facebook: <a href="' .$facebook. '" target="_blank" title="Facebook">Facebook</a></li>';
			} else{
				$return3 = '';
			}

			if($skype != '') {
			$return4 = '<li class="member-social-skype">skype: <a href="' .$skype. '" target="_blank" title="Skype">Skype</a></li>';
			} else{
				$return4 = '';
			}

			if($google != '') {
			$return5 = '<li class="member-social-google">google+: <a href="' .$google. '" target="_blank" title="Google+">Google</a></li>';
			} else{
				$return5 = '';
			}


			if($linkedin != '') {
			$return6 = '<li class="member-social-linkedin">linkedin: <a href="' .$linkedin. '" target="_blank" title="LinkedIn">Linkedin</a></li>';
			}
			else{
				$return6 = '';
			}

			if($mail != '') {
			$return7 = '<li class="member-social-email"><a href="mailto:' .$mail. '" title="Mail">Mail</a></li>';
			}
			else{
				$return7 = '';
			}
		}  else {
			$return2 = '';
			$return3 = '';
			$return4 = '';
			$return5 = '';
			$return6 = '';
			$return7 = '';
			$return8 = '';
			$return9 = '';
		}
		return '<div class="member">' .$return. '
			<h4>' .$name. '</h4>
			<div class="member-role">' .$role. '</div>' . do_shortcode($content) . '' .$return8. '' .$return2. '' .$return3. '' .$return4. '' .$return5. '' .$return6. '' .$return7. '' .$return9. '</div>';
}

/*-----------------------------------------------------------------------------------*/

function yb_skill( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'percentage' => '0',
			'title'      => ''
	 ), $atts));
	$out = '<div class="skill-title">' .$title. '</div><div class="skillbar" data-perc="' .$percentage. '"><div class="skill-percentage"></div></div>';
	 return $out;
}

/*-----------------------------------------------------------------------------------*/
/* Pricing Table */
/*-----------------------------------------------------------------------------------*/

function yb_plan( $atts, $content = null ) {
	 extract(shortcode_atts(array(
		'name'      => 'Premium',
		'link'      => false,
		'linkname'      => 'Sign Up',
		'price'      => '39.00$',
		'per'      => false,
		'featured' => ''
	 ), $atts));

	 if($featured != '') {
		$return = "<div class='featured'>".$featured."</div>";
	 }
	 else{
		 $return = "";
	 }

	 if($per != false) {
		$return3 = "".$per."";
	 }
	 else{
		$return3 = "";
	 }

	 if($link != false) {
		$return2 = "<div class='signup'><a class='button' href='".$link."'>".$linkname."<span></span></a></div>";
	 }
	 else{
		$return2 = "";
	 }

	$out = "
		<div class='plan'>
			".$return."
			<div class='plan-head'><h3>".$name."</h3>
			<div class='price'>".$price." <span>".$return3."</span></div></div>
			<ul>" .do_shortcode($content). "</ul>
			".$return2."
		</div>";
	 return $out;
}

/*-----------------------------------------------------------------------------------*/

function yb_pricing( $atts, $content = null ) {
	 extract(shortcode_atts(array(
		  'col'      => '3'
	 ), $atts));

	$out = "<div class='pricing-table col-".$col."'>" .do_shortcode($content). "</div><div class='clear'></div>";
	 return $out;
}

/*-----------------------------------------------------------------------------------*/
/*	Block & Pullquotes
/*-----------------------------------------------------------------------------------*/
function yb_blockquote( $atts, $content = null) {
extract( shortcode_atts( array(), $atts ) );

	return '<blockquote><p>' . do_shortcode($content) . '</p></blockquote>';
}

/*-----------------------------------------------------------------------------------*/

function yb_pullquote( $atts, $content = null ) {
	 extract(shortcode_atts(array(
		  'align'      => 'left'
	 ), $atts));

	 return '<span class="pullquote align-'.$align.'">' . do_shortcode($content) . '</span>';
}

/*-----------------------------------------------------------------------------------*/
/* Social Icons
/*-----------------------------------------------------------------------------------*/

function yb_social( $atts, $content = null) {

extract( shortcode_atts( array(
		'icon' 	=> 'twitter',
		'url'		=> '#',
		'target' 	=> '_blank'
		), $atts ) );

		$capital = ucfirst($icon);

		return '<div class="social-icon social-' . $icon . '"><a href="' . $url . '" title="' . $capital . '" target="' . $target . '">' . $capital . '</a></div>';
}

/*-----------------------------------------------------------------------------------*/
/* Styled Tables
/*-----------------------------------------------------------------------------------*/

function yb_table( $atts, $content = null) {

extract( shortcode_atts( array(
		'style' 	=> '1'
		), $atts ) );

		return '<div class="custom-table-' . $style . '">' . do_shortcode($content) . '</div>';
}

/*-----------------------------------------------------------------------------------*/
/* Testimonial
/*-----------------------------------------------------------------------------------*/

function yb_testimonial( $atts, $content = null) {
extract( shortcode_atts( array(
		'author' => ''
		), $atts ) );
		return '<div class="testimonial">' . do_shortcode($content) . '</div><div class="testimonial-author">' .$author. '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Tabs
/*-----------------------------------------------------------------------------------*/

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


/*-----------------------------------------------------------------------------------*/
/* Toggle */
/*-----------------------------------------------------------------------------------*/

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

/*-----------------------------------------------------------------------------------*/
/*	Latest Projects
/*-----------------------------------------------------------------------------------*/

// function yb_portfolio($atts){
// 	extract(shortcode_atts(array(
// 			'projects'      => '4',
// 			'title' => 'Portfolio',
// 			'show_title' => 'yes',
// 			'columns' => '4',
// 			'filters' => 'all'
// 	 ), $atts));

// 	global $post;
// 	global $data;

// 	if ( $data['check_portfoliotype'] == true ) {

// 		$args = array(
// 			'post_type' => 'portfolio',
// 			'posts_per_page' => $projects,
// 			'order'          => 'DESC',
// 			'orderby'        => 'date',
// 			'post_status'    => 'publish'
// 		 );

// 		 if($filters != 'all'){

// 			// string to array
// 			$str = $filters;
// 			$arr = explode(',', $str);
// 			//var_dump($arr);

// 			$args['tax_query'][] = array(
// 				'taxonomy' => 'portfolio_filter',
// 				'field' 	=> 'slug',
// 				'terms' 	=> $arr
// 			);
// 		}


// 		 $randomid = rand();

// 		 query_posts( $args );
// 		 $out = '';

// 		if( have_posts() ) :

// 			if($show_title == 'yes'){
// 				$out .= '<h3 class="title"><span>'.$title.'</span></h3>';
// 			}

// 			if($columns == '3'){
// 				$return = 'one-third';
// 			}
// 			elseif($columns == '2'){
// 				$return = 'eight';
// 			}
// 			else{
// 				$return = 'four';
// 			}


// 			$out .= '<div class="latest-portfolio negative-wrap">';
// 			while ( have_posts() ) : the_post();

// 				$out .= '<div class="portfolio-item '.$return.' columns">';


// 				$embedd = '';

// 					if( get_post_meta( get_the_ID(), 'yb_portfolio-lightbox', true ) == "true") {
// 						$lightboxtype = '<span class="overlay-lightbox"></span>';
// 						if( get_post_meta( get_the_ID(), 'yb_embed', true ) != "") {
// 								if ( get_post_meta( get_the_ID(), 'yb_source', true ) == 'youtube' ) {
// 									$link = '<a href="http://www.youtube.com/watch?v='.get_post_meta( get_the_ID(), 'yb_embed', true ).'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
// 								} else if ( get_post_meta( get_the_ID(), 'yb_source', true ) == 'vimeo' ) {
// 									$link = '<a href="http://vimeo.com/'. get_post_meta( get_the_ID(), 'yb_embed', true ) .'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
// 								} else if ( get_post_meta( get_the_ID(), 'yb_source', true ) == 'own' ) {
// 									$randomid = rand();
// 									$link = '<a href="#embedd-video-'.$randomid.'" class="prettyPhoto" title="'. get_the_title() .'" rel="prettyPhoto[portfolio]">';
// 									$embedd = '<div id="embedd-video-'.$randomid.'" class="embedd-video"><p>'. get_post_meta( get_the_ID(), 'yb_embed', true ) .'</p></div>';
// 								}
// 						} else {
// 							$link = '<a href="'. wp_get_attachment_url( get_post_thumbnail_id() ) .'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
// 						}
// 					}
// 					else{
// 						$lightboxtype = '<span class="overlay-link"></span>';
// 						$link = '<a href="'. get_permalink() .'" title="'. get_the_title() .'">';
// 						$embedd = '';
// 					}


// 				if ( has_post_thumbnail()) {

// 						$portfolio_thumbnail= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'eight-columns' );

// 						if(get_post_meta( get_the_ID(), "yb_subtitle", true ) != '' ) {
// 							$subtitle = get_post_meta( get_the_ID(), "yb_subtitle", true );
// 						} else {
// 							$subtitle = substr(get_the_excerpt(),0,25).'...';
// 						}

// 						$out .= '<div class="portfolio-it">
// 							'. $link . '<span class="portfolio-pic"><img src="'.$portfolio_thumbnail[0].'" /><div class="portfolio-overlay">'. $lightboxtype .'</div></span></a>
// 							<a href="'. get_permalink() .'" title="'. get_the_title() .'" class="portfolio-title"><h4>'. get_the_title() .'</h4><span>'.$subtitle.'</span></a>
// 						</div>';

// 						$out .= $embedd;

// 				}

// 				 $out .='</div>';

// 			endwhile;

// 			$out .='</div><div class="clear"></div>';

// 			 wp_reset_query();

// 		endif;

// 		return $out;
// 	}
// }
// add_shortcode('portfolio', 'yb_portfolio');

/*-----------------------------------------------------------------------------------*/
/*	Latest Blog
/*-----------------------------------------------------------------------------------*/

function yb_bloglist($atts){
	extract(shortcode_atts(array(
			'posts'      => '4',
			'title' => 'Latest Blog Entries',
			'show_title' => 'yes',
			'categories' => 'all'
	 ), $atts));

	 global $post;

	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $posts,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'post_status'    => 'publish'
	 );

	 if($categories != 'all'){

		// string to array
		$str = $categories;
		$arr = explode(',', $str);
		//var_dump($arr);

		$args['tax_query'][] = array(
			'taxonomy' 	=> 'category',
			'field' 	=> 'slug',
			'terms' 	=> $arr
		);
	}

	 query_posts( $args );
	 $out = '';



	if( have_posts() ) :

		if($show_title == 'yes'){
			$out .= '<h3 class="title"><span>'.$title.'</span></h3>';
		}

		while ( have_posts() ) : the_post();

			$out .= '<div class="latest-blog-list clearfix"><div class="blog-list-item-date">'.get_the_time('d').'<span>'.get_the_time('M').'</span></div>
					<div class="blog-list-item-description">
						<h4><a href="'.get_permalink().'" title="' . get_the_title() . '">'.get_the_title() .'</a></h4>
						<span>'.get_comments_number().' '.__( 'Comments', 'yb' ) .'</span>
						<div class="blog-list-item-excerpt">'.limit_words(get_the_excerpt(), '20').'... <a href="'. get_permalink() . '">' .__( 'Read More &rarr;', 'yb' ) . '</a></div>
					</div>
					</div>';

		endwhile;

		$out .='<div class="clear"></div>';

		 wp_reset_query();

	endif;

	return $out;
}
add_shortcode('bloglist', 'yb_bloglist');

/*-----------------------------------------------------------------------------------*/
/*	Latest Blog
/*-----------------------------------------------------------------------------------*/

function yb_blog($atts){
	extract(shortcode_atts(array(
			'posts'      => '4',
			'title' => 'Latest From the Blog',
			'show_title' => 'yes',
			'categories' => 'all'
	 ), $atts));

	 global $post;

	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $posts,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'post_status'    => 'publish'
	 );

	 if($categories != 'all'){

		// string to array
		$str = $categories;
		$arr = explode(',', $str);
		//var_dump($arr);

		$args['tax_query'][] = array(
			'taxonomy' 	=> 'category',
			'field' 	=> 'slug',
			'terms' 	=> $arr
		);
	}

	 query_posts( $args );
	 $out = '';



	if( have_posts() ) :

		if($show_title == 'yes'){
			$out .= '<h3 class="title"><span>'.$title.'</span></h3>';
		}

		$out .= '<div class="latest-blog negative-wrap">';

		while ( have_posts() ) : the_post();

			 //$text = strip_tags(yb_excerpt(20));

			$out .= '<div class="blog-item four columns">';

			if ( has_post_thumbnail()) {
				$blog_thumbnail= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'eight-columns' );
				$out .= '<a href="'.get_permalink().'" title="' . get_the_title() . '" class="blog-pic"><img src="'.$blog_thumbnail[0].'" /><div class="blog-overlay">';

					if ( has_post_format( 'audio' )) {
						$out .= '<span class="post-icon audio"></span>';
					}
					if ( has_post_format( 'gallery' )) {
						$out .= '<span class="post-icon imagegallery"></span>';
					}
					if ( has_post_format( 'link' )) {
						$out .= '<span class="post-icon link"></span>';
					}
					if ( has_post_format( 'quote' )) {
						$out .= '<span class="post-icon quote"></span>';
					}
					if ( has_post_format( 'video' )) {
						$out .= '<span class="post-icon video"></span>';
					}
					if ( get_post_format() == false ) {
						$out .= '<span class="post-icon standard"></span>';
					}

				$out .= '</div></a>';
			}

			$out .= '<div class="blog-item-description">
						<h4><a href="'.get_permalink().'" title="' . get_the_title() . '">'.get_the_title() .'</a></h4>
						<span>'.get_the_date().' / '.get_comments_number().' '.__( 'Comments', 'yb' ) .'</span>
					</div>';

			 $out .='<div class="blog-border"></div></div>';

		endwhile;

		$out .='</div><div class="clear"></div>';

		 wp_reset_query();

	endif;

	return $out;
}
add_shortcode('blog', 'yb_blog');

/*-----------------------------------------------------------------------------------*/
/*	Section
/*-----------------------------------------------------------------------------------*/
function yb_section( $atts, $content = null) {

extract( shortcode_atts( array(
	'bgcolor'		=> '#ffffff',
	'bgimage'		=> '',
	'parallax'	=> 'false',
	'padding' => '',
	'border' => 'none'
	), $atts ) );

	if($parallax == 'false') {
		$var1 = '';
	}
	else{
		$var1 = 'section-parallax';
	}

	$var2 = '';

	if($bgimage != ''){
		$var2 = 'background-image: url(' . $bgimage . ');';
	}

	 return '<div class="section ' . $var1 . '" style="background-color: ' . $bgcolor . '; border: ' . $border . '; padding: ' . $padding . '; ' . $var2 . '"><div class="container clearfix"><div class="sixteen columns">' . do_shortcode($content) . '</div></div></div>';
}

/*-----------------------------------------------------------------------------------*/
/*	Video Section
/*-----------------------------------------------------------------------------------*/
function yb_videosection( $atts, $content = null) {

extract( shortcode_atts( array(
	'fallback'		=> '',
	'mp4'			=> '',
	'webm'			=> '',
	'ogv'			=> '',
	'padding' 		=> '',
	'color'			=> '#777777',
	'overlay'		=> ''
	), $atts ) );

	$var2 = '';

	if($fallback != ''){
		$var2 = 'background-image: url(' . $fallback . ');';
	}

	 return '
	 <div class="videosection" style="padding: ' . $padding . '; color: ' . $color . ';">
		<div class="container clearfix">
			<div class="sixteen columns">' . do_shortcode($content) . '</div>
		</div>
		<div class="video-wrap"><video width="1920" height="800" preload="auto" autoplay loop="loop" muted="muted"><source src="' . $mp4 . '" type="video/mp4"><source src="' . $webm . '" type="video/webm"><source src="' . $ogv . '" type="video/ogg"></video></div>
		<div class="video-fallback" style="' . $var2 . '"></div>
		<div class="video-overlay" style="' . $overlay . '"></div>
	 </div>';
}

/* ----------------------------------------------------- */
/* Pre Process Shortcodes */
/* ----------------------------------------------------- */

function pre_process_shortcode($content) {
	 global $shortcode_tags;

	 // Backup current registered shortcodes and clear them all out
	 $orig_shortcode_tags = $shortcode_tags;
	 remove_all_shortcodes();

	 add_shortcode('div', 'yb_div');
	 add_shortcode('box', 'yb_box');
	add_shortcode('section', 'yb_section');

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
	add_shortcode('one_fifth', 'yb_one_fifth');
	add_shortcode('one_fifth_last', 'yb_one_fifth_last');
	add_shortcode('two_fifth', 'yb_two_fifth');
	add_shortcode('two_fifth_last', 'yb_two_fifth_last');
	add_shortcode('three_fifth', 'yb_three_fifth');
	add_shortcode('three_fifth_last', 'yb_three_fifth_last');
	add_shortcode('four_fifth', 'yb_four_fifth');
	add_shortcode('four_fifth_last', 'yb_four_fifth_last');
	add_shortcode('one_sixth', 'yb_one_sixth');
	add_shortcode('one_sixth_last', 'yb_one_sixth_last');
	add_shortcode('five_sixth', 'yb_five_sixth');
	add_shortcode('five_sixth_last', 'yb_five_sixth_last');

	 add_shortcode('gap', 'yb_gap');
	 add_shortcode('hr', 'yb_hr');
	 add_shortcode('clear', 'yb_clear');

	 add_shortcode('yb_button', 'yb_buttons');

	 add_shortcode('placeholder_img', 'yb_placeholder_img');

	 add_shortcode('accordion', 'yb_accordion');
	 add_shortcode('alert', 'yb_alert');

	 add_shortcode('br', 'yb_br');

	add_shortcode('dropcap', 'yb_dropcap');

	add_shortcode('embedvideo', 'yb_video');

	add_shortcode('iconbox', 'yb_iconbox');
	add_shortcode('icon', 'yb_icon');
	add_shortcode('mini-icon', 'yb_miniicon');
	add_shortcode('retinaicon', 'yb_retinaicon');
	add_shortcode('retinaiconbox', 'yb_retinaiconbox');

	add_shortcode( 'gal', 'yb_gallery' );

	add_shortcode('list', 'yb_list');
	add_shortcode('list_item', 'yb_item');

	add_shortcode('member', 'yb_member');
	add_shortcode('skill', 'yb_skill');

	add_shortcode('plan', 'yb_plan');
	add_shortcode('pricing-table', 'yb_pricing');

	add_shortcode('blockquote', 'yb_blockquote');
	add_shortcode('pullquote', 'yb_pullquote');

	add_shortcode('videosection', 'yb_videosection');

	add_shortcode('social', 'yb_social');

	add_shortcode('custom_table', 'yb_table');

	add_shortcode('testimonial', 'yb_testimonial');

	add_shortcode('toggle', 'yb_toggle');

	add_shortcode('highlight', 'yb_highlight');

	add_shortcode('tagline', 'yb_tagline');

	 // Do the shortcode (only the one above is registered)
	 $content = do_shortcode($content);

	 // Put the original shortcodes back
	 $shortcode_tags = $orig_shortcode_tags;

	 return $content;
}


add_filter('the_content', 'pre_process_shortcode', 7);

// Allow Shortcodes in Widgets
add_filter('widget_text', 'pre_process_shortcode', 7);

/*-----------------------------------------------------------------------------------*/
/* Add TinyMCE Buttons to Editor */
/*-----------------------------------------------------------------------------------*/
add_action('init', 'add_button');

function add_button() {
	if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
	{
	  add_filter('mce_external_plugins', 'add_plugin');
	  add_filter('mce_buttons_3', 'register_button_3');
	  add_filter('mce_buttons_4', 'register_button_4');
	}
}

// Define Position of TinyMCE Icons
function register_button_3($buttons) {
	array_push($buttons, "div", "box", "section", "one_half", "one_third", "two_third", "one_fourth", "three_fourth", "one_fifth", "gap", "divider", "clear", "yb_button", "placeholder_img");
	return $buttons;
}
function register_button_4($buttons) {
	array_push($buttons, "accordion", "alert", "dropcap", "video", "maps", "icon", "miniicon", "iconbox", "retinaicon", "retinaiconbox", "member", "skill", "pricing", "projects", "blog", "bloglist", "testimonial", "pullquote", "socialmedia", "table", "tabs", "toggle", "list");
	return $buttons;
}

function add_plugin($plugin_array) {
	global $data;

	$plugin_array['div'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['box'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['section'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['one_half'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['one_third'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['two_third'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['one_fourth'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['three_fourth'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['one_fifth'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['gap'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['divider'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['clear'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['yb_button'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['placeholder_img'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['accordion'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['alert'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['dropcap'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['video'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['maps'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['icon'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['miniicon'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['iconbox'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['retinaicon'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['retinaiconbox'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['list'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['member'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['skill'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['pricing'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['pullquote'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['socialmedia'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['table'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['tabs'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['toggle'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	// $plugin_array['projects'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['blog'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['bloglist'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';
	$plugin_array['testimonial'] = get_template_directory_uri().'/library/inc/tinymce/tinymce.js';

	return $plugin_array;
}
?>