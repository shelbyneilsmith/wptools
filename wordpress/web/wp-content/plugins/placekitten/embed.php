<?php
/*
Plugin Name: placekitten
Plugin URI: http://dirtysuds.com
Description: Embed kitten
Author: Pat Hawks
Version: 1.00
Author URI: http://www.pathawks.com

Updates:
1.00 - First Version

  Copyright 2011 Pat Hawks  (email : pat@pathawks.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_shortcode( 'placekitten', 'placekitten_shortcode' );

function placekitten_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'height' => get_option('embed_size_h'),
		'width' => get_option('embed_size_w'),
	), $atts ) );

	$embed = '<img src="http://placekitten.com/'.$width.'/'.$height.'" height="'.$height.'" width="'.$width.'" alt="placekitten" />';

	return apply_filters( 'embed_pdf', $embed, $matches, $attr, $url, $rawattr  );
}