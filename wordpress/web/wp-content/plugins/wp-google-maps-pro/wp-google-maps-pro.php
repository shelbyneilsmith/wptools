<?php
/*
Plugin Name: WP Google Maps - Pro Add-on
Plugin URI: http://www.wpgmaps.com
Description: This is the Professional add-on plugin for WP Google Maps. The Professional add-on enables you to add descriptions, pictures, links and custom icons to your markers as well as allows you to download your markers to a CSV file for quick editing and re-upload them when complete.
Version: 4.02
Author: WP Google Maps
Author URI: http://www.wpgmaps.com
 *
 * 4.02
 * Fixed the bug that caused the directions box to show above the map by default
 * Fixed the bug whereby an address was already hard-coded into the "To" field of the directions box
 * Fixed the bug that caused the traffic layer to show by default
 *
 * 4.01
 * Added the functionality to list your markers below the map
 * Added more advanced directions functionality
 * Fixed small bugs
 * Fixed a bug that caused a fatal error when trying to activate the plugin on some hosts.
 *
 * 4.0
 * Plugin now supports multiple maps on one page
 * Bicycle directions now added
 * Walking directions now added
 * "Avoid tolls" now added to the directions functionality
 * "Avoid highways" now added to directions functionality
 * New setting: open links in a new window
 * Added functionality to reset the default marker image if required.
 *
 * 3.12
 * Fixed the bug that told users they had an outdated plugin when in fact they never
 *
 * 3.11
 * Fixed the bug that was causing both the bicycle layer and traffic layer to show all the time
 * 
 * 3.10
 * Added the bicycle layer
 * Added the traffic layer
 * Fixed the bug that was not allowing users to overwrite existing data when uploading a CSV file
 *
 * 3.9
 * Added support for KML/GeoRSS layers.
 * Fixed the directions box styling error in Firefox.
 * Fixed the bug whereby users couldnt change the default location without adding a marker first.
 * When the "Directions" link is clicked on, the "From" field is automatically highlighted for the user.
 * Added additional settings
 *
 * 3.8
 * Markers now automatically close when you click on another marker.
 * Russian localization added
 * The "To" field in the directions box now shows the address and not the GPS co-ords.
 *
 * 3.7
 * Added support for localization
 *
 * 3.6
 * Fixed the bug that caused slow loading times with sites that contain a high number of maps and markers
 *
 * 3.5
 * Fixed the bug where sometimes the short code wasnt working for home pages
 *
 * 3.4
 * Added functionality for 'Titles' for each marker
 *
 * 3.3
 * Added functionality for WordPress MU
 *
 * 3.2
 * Fixed a bug where in IE the zoom checkbox was showing
 * Fixed the bug where the map wasnt saving correctly in some instances

 * 3.1
 * Fixed redirect problem
 * Fixed bug that never created the default map on some systems

 * 3.0
 * Added Map Alignment functionality
 * Added Map Type functionality
 * Started using the Geocoding API Version 3  instead of Version 2 - quicker results!
 * Fixed bug that didnt import animation data for CSV files
 * Fixed zoom bug

 * 2.1
 * Fixed a few bugs with the jQuery script
 * Fixed the shortcode bug where the map wasnt displaying when two or more short codes were one the post/page
 * Fixed a bug that wouldnt save the icon on editing a marker in some instances
 *
 * 
 *
*/


global $wpgmza_pro_version;
global $wpgmza_pro_string;
$wpgmza_pro_version = "4.01";
$wpgmza_pro_string = "pro";

global $wpgmza_p;
global $wpgmza_t;
$wpgmza_p = true;
$wpgmza_t = "pro";


global $wpgmza_post_nonce;
$wpgmza_post_nonce = md5(time());


add_action('admin_head', 'wpgmaps_upload_csv');
add_action('init', 'wpgmza_register_pro_version');


function wpgmaps_pro_activate() { wpgmza_cURL_response_pro("activate"); }
function wpgmaps_pro_deactivate() { wpgmza_cURL_response_pro("activate"); }



function wpgmza_register_pro_version() {
    global $wpgmza_pro_version;
    global $wpgmza_pro_string;
    if (!get_option('WPGMZA_PRO')) {
        add_option('WPGMZA_PRO',array("version" => $wpgmza_pro_version, "version_string" => $wpgmza_t));
    } else {
        update_option('WPGMZA_PRO',array("version" => $wpgmza_pro_version, "version_string" => $wpgmza_t));
    }
}

function wpgmza_pro_menu() {
    global $wpgmza_pro_version;
    global $wpgmza_p_version;
    global $wpgmza_post_nonce;
    global $wpgmza_tblname_maps;
    global $wpdb;

    if (!wpgmaps_check_permissions()) { wpgmaps_permission_warning(); }

    if ($_GET['action'] == "edit") {
        
    }
    else if ($_GET['action'] == "new") {


        $def_data = get_option("WPGMZA_SETTINGS");

        $data['map_default_starting_lat'] = $map_start_lat;
        $data['map_default_starting_lng'] = $map_start_lng;
        $data['map_default_height'] = $map_height;
        $data['map_default_width'] = $map_width;
        $data['map_default_zoom'] = $map_start_zoom;
        $data['map_default_type'] = $type;
        $data['map_default_alignment'] = $alignment;
        $data['map_default_directions'] = $directions_enabled;
        $data['map_default_bicycle'] = $bicycle_enabled;
        $data['map_default_traffic'] = $traffic_enabled;
        $data['map_default_dbox'] = $dbox;
        $data['map_default_dbox_width'] = $dbox_width;
        $data['map_default_marker'] = $map_default_marker;

        if (isset($def_data['map_default_height'])) {
            $wpgmza_height = $def_data['map_default_height'];
        } else {
            $wpgmza_height = "400";
        }
        if (isset($def_data['map_default_width'])) {
            $wpgmza_width = $def_data['map_default_width'];
        } else {
            $wpgmza_width = "600";
        }
        if (isset($def_data['map_default_marker'])) {
            $wpgmza_def_marker = $def_data['map_default_marker'];
        } else {
            $wpgmza_def_marker = "0";
        }
        if (isset($def_data['map_default_alignment'])) {
            $wpgmza_def_alignment = $def_data['map_default_alignment'];
        } else {
            $wpgmza_def_alignment = "0";
        }
        if (isset($def_data['map_default_directions'])) {
            $wpgmza_def_directions = $def_data['map_default_directions'];
        } else {
            $wpgmza_def_directions = "0";
        }
        if (isset($def_data['map_default_bicycle'])) {
            $wpgmza_def_bicycle = $def_data['map_default_bicycle'];
        } else {
            $wpgmza_def_bicycle = "0";
        }
        if (isset($def_data['map_default_traffic'])) {
            $wpgmza_def_traffic = $def_data['map_default_traffic'];
        } else {
            $wpgmza_def_traffic = "0";
        }
        if (isset($def_data['map_default_dbox'])) {
            $wpgmza_def_dbox = $def_data['map_default_dbox'];
        } else {
            $wpgmza_def_dbox = "0";
        }
        if (isset($def_data['map_default_dbox_wdith'])) {
            $wpgmza_def_dbox_width = $def_data['map_default_dbox_width'];
        } else {
            $wpgmza_def_dbox_width = "500";
        }
        if (isset($def_data['map_default_listmarkers'])) {
            $wpgmza_def_listmarkers = $def_data['map_default_listmarkers'];
        } else {
            $wpgmza_def_listmarkers = "0";
        }
        if (isset($def_data['map_default_type'])) {
            $wpgmza_def_type = $def_data['map_default_type'];
        } else {
            $wpgmza_def_type = "1";
        }

        if (isset($def_data['map_default_zoom'])) {
            $start_zoom = $def_data['map_default_zoom'];
        } else {
            $start_zoom = 5;
        }
        if (isset($def_data['map_default_starting_lat']) && isset($def_data['map_default_starting_lng'])) {
            $wpgmza_lat = $def_data['map_default_starting_lat'];
            $wpgmza_lng = $def_data['map_default_starting_lng'];
        } else {
            $wpgmza_lat = "51.5081290";
            $wpgmza_lng = "-0.1280050";
        }


        $wpdb->insert( $wpgmza_tblname_maps, array(
            "map_title" => "New Map",
            "map_start_lat" => "$wpgmza_lat",
            "map_start_lng" => "$wpgmza_lng",
            "map_width" => "$wpgmza_width",
            "map_height" => "$wpgmza_height",
            "map_start_location" => "$wpgmza_lat,$wpgmza_lng",
            "map_start_zoom" => "$start_zoom",
            "default_marker" => "$wpgmza_def_marker",
            "alignment" => "$wpgmza_def_alignment",
            "styling_enabled" => "0",
            "styling_json" => "",
            "active" => "0",
            "directions_enabled" => "$wpgmza_def_directions",
            "type" => "$wpgmza_def_type",
            "bicycle" => "$wpgmza_def_bicycle",
            "traffic" => "$wpgmza_def_traffic",
            "dbox" => "$wpgmza_def_dbox",
            "dbox_width" => "$wpgmza_def_dbox_width",
            "listmarkers" => "$wpgmza_listmarkers")
        );
        $lastid = $wpdb->insert_id;
        $_GET['map_id'] = $lastid;
        //wp_redirect( admin_url('admin.php?page=wp-google-maps-menu&action=edit&map_id='.$lastid) );
        echo "<script>window.location = \"".get_option('siteurl')."/wp-admin/admin.php?page=wp-google-maps-menu&action=edit&map_id=".$lastid."\"</script>";
    }


    if (isset($_GET['map_id'])) {
        
        $res = wpgmza_get_map_data($_GET['map_id']);
        if (function_exists(wpgmza_register_gold_version)) { $addon_text = __("including Pro &amp; Gold add-ons","wp-google-maps"); } else { $addon_text = __("including Pro add-on","wp-google-maps"); }
        if (!$res->map_id || $res->map_id == "") { $wpgmza_data['map_id'] = 1; }
        if (!$res->default_marker || $res->default_marker == "" || $res->default_marker == "0") { $display_marker = "<img src=\"".wpgmaps_get_plugin_url()."/images/marker.png\" />"; } else { $display_marker = "<img src=\"".$res->default_marker."\" />"; }
        if ($res->map_start_zoom) { $wpgmza_zoom[intval($res->map_start_zoom)] = "SELECTED"; } else { $wpgmza_zoom[8] = "SELECTED"; }
        if ($res->type) { $wpgmza_map_type[intval($res->type)] = "SELECTED"; } else { $wpgmza_map_type[1] = "SELECTED"; }
        if ($res->alignment) { $wpgmza_map_align[intval($res->alignment)] = "SELECTED"; } else { $wpgmza_map_align[1] = "SELECTED"; }
        if ($res->directions_enabled) { $wpgmza_directions[intval($res->directions_enabled)] = "SELECTED"; } else { $wpgmza_directions[2] = "SELECTED"; }
        if ($res->bicycle) { $wpgmza_bicycle[intval($res->bicycle)] = "SELECTED"; } else { $wpgmza_bicycle[2] = "SELECTED"; }
        if ($res->traffic) { $wpgmza_traffic[intval($res->traffic)] = "SELECTED"; } else { $wpgmza_traffic[2] = "SELECTED"; }
        if ($res->dbox != "1") { $wpgmza_dbox[intval($res->dbox)] = "SELECTED"; } else { $wpgmza_dbox[1] = "SELECTED"; }

        if ($res->listmarkers == "1") { $listmarkers_checked = "CHECKED"; } else { }


        $wpgmza_csv = "<a href=\"".wpgmaps_get_plugin_url()."/csv.php\" title=\"".__("Download this as a CSV file","wp-google-maps")."\">".__("Download this data as a CSV file","wp-google-maps")."</a>";
        
    }
    echo "
       <div class='wrap'>
            <h1>WP Google Maps <small>($addon_text)</small></h1>
            <div class='wide'>
                    ".wpgmza_version_check()."
                    <h2>".__("Create your Map")."</h2>
                    $version_message
    <div style=\"display:block; overflow:auto; background-color:#FFFBCC; padding:10px; border:1px solid #E6DB55; margin-top:5px; margin-bottom:5px;\">
    <form action='' method='post' id='wpgmaps_options' name='wpgmza_map_form'>
                    <p></p>

                        <input type='hidden' name='http_referer' value='".$_SERVER['PHP_SELF']."' />
                        <input type='hidden' name='wpgmza_id' id='wpgmza_id' value='".$res->id."' />
                        <input id='wpgmza_start_location' name='wpgmza_start_location' type='hidden' size='40' maxlength='100' value='".$res->map_start_location."' />
                        <select id='wpgmza_start_zoom' name='wpgmza_start_zoom' style=\"display:none;\">
                            <option value=\"1\" ".$wpgmza_zoom[1].">1</option>
                            <option value=\"2\" ".$wpgmza_zoom[2].">2</option>
                            <option value=\"3\" ".$wpgmza_zoom[3].">3</option>
                            <option value=\"4\" ".$wpgmza_zoom[4].">4</option>
                            <option value=\"5\" ".$wpgmza_zoom[5].">5</option>
                            <option value=\"6\" ".$wpgmza_zoom[6].">6</option>
                            <option value=\"7\" ".$wpgmza_zoom[7].">7</option>
                            <option value=\"8\" ".$wpgmza_zoom[8].">8</option>
                            <option value=\"9\" ".$wpgmza_zoom[9].">9</option>
                            <option value=\"10\" ".$wpgmza_zoom[10].">10</option>
                            <option value=\"11\" ".$wpgmza_zoom[11].">11</option>
                            <option value=\"12\" ".$wpgmza_zoom[12].">12</option>
                            <option value=\"13\" ".$wpgmza_zoom[13].">13</option>
                            <option value=\"14\" ".$wpgmza_zoom[14].">14</option>
                            <option value=\"15\" ".$wpgmza_zoom[15].">15</option>
                            <option value=\"16\" ".$wpgmza_zoom[16].">16</option>
                            <option value=\"17\" ".$wpgmza_zoom[17].">17</option>
                            <option value=\"18\" ".$wpgmza_zoom[18].">18</option>
                            <option value=\"19\" ".$wpgmza_zoom[19].">19</option>
                            <option value=\"20\" ".$wpgmza_zoom[20].">20</option>
                            <option value=\"21\" ".$wpgmza_zoom[21].">21</option>
                        </select>

                    <table class='form-table'>
                        <tr>
                            <td>".__("Short code","wp-google-maps").":</td>
                            <td><input type='text' readonly name='shortcode' style='font-size:18px; text-align:center;' value='[wpgmza id=\"".$res->id."\"]' /> <small><i>".__("copy this into your post or page to display the map","wp-google-maps")."</i></td>
                        </tr>
                        <tr>
                            <td>".__("Map Name","wp-google-maps").":</td>
                            <td><input id='wpgmza_title' name='wpgmza_title' class='regular-text' type='text' size='20' maxlength='50' value='".$res->map_title."' /></td>
                        </tr>
                        <tr>
                             <td>".__("Map Dimensions","wp-google-maps").":</td>
                             <td>
                                ".__("Width","wp-google-maps").": <input id='wpgmza_width' name='wpgmza_width' type='text' size='4' maxlength='4' class='small-text' value='".$res->map_width."' /> px
                                &nbsp; &nbsp; &nbsp; &nbsp; 
                                ".__("Height","wp-google-maps").": <input id='wpgmza_height' name='wpgmza_height' type='text' size='4' maxlength='4' class='small-text' value='".$res->map_height."' /> px
                            </td>
                        </tr>

                    </table>
                    <br />
                    &nbsp; &nbsp; <a href='javascript:document.getElementById(\'wpgmaps_show_advanced\').style.display=\'none;\';document.getElementById(\'wpgmaps_hide_advanced\').style.display=\'\';' id='wpgmaps_show_advanced' title='".__("Show advanced options","wp-google-maps")."'>".__("Show advanced options","wp-google-maps")."</a>
                    <a href='javascript:document.getElementById(\'wpgmaps_hide_advanced\').style.display=\'none\';document.getElementById(\'wpgmaps_show_advanced\').style.display=\'\';' id='wpgmaps_hide_advanced' title='".__("Hide advanced options","wp-google-maps")."' style=\"display:none;\">".__("Hide advanced options","wp-google-maps")."</a>
                        
                    <table class='form-table' id='wpgmaps_advanced_options' style='display:none;'>
                        <tr>
                            <td>".__("Default Marker Image","wp-google-maps").":</td>
                            <td><span id=\"wpgmza_mm\">$display_marker</span> <input id=\"upload_default_marker\" name=\"upload_default_marker\" type='hidden' size='35' class='regular-text' maxlength='700' value='".$res->default_marker."' ".$wpgmza_act."/> <input id=\"upload_default_marker_btn\" type=\"button\" value=\"".__("Upload Image","wp-google-maps")."\" $wpgmza_act /> <a href=\"javascript:void(0);\" onClick=\"document.forms['wpgmza_map_form'].upload_default_marker.value = ''; var span = document.getElementById('wpgmza_mm'); while( span.firstChild ) { span.removeChild( span.firstChild ); } span.appendChild( document.createTextNode('')); return false;\" title=\"Reset to default\">-reset-</a> &nbsp; &nbsp; <small><i>".__("Get great map markers <a href='http://mapicons.nicolasmollet.com/' target='_BLANK' title='Great Google Map Markers'>here</a>","wp-google-maps")."</i></small></td>
                        </tr>

                        <tr>
                            <td>".__("Map type","wp-google-maps").":</td>
                            <td><select id='wpgmza_map_type' name='wpgmza_map_type' class='postform'>
                                <option value=\"1\" ".$wpgmza_map_type[1].">".__("Roadmap","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_map_type[2].">".__("Satellite","wp-google-maps")."</option>
                                <option value=\"3\" ".$wpgmza_map_type[3].">".__("Hybrid","wp-google-maps")."</option>
                                <option value=\"4\" ".$wpgmza_map_type[4].">".__("Terrain","wp-google-maps")."</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                             <td>".__("List all Markers","wp-google-maps").":</td>
                             <td>
                                <input id='wpgmza_listmarkers' name='wpgmza_listmarkers' type='checkbox' value='1' $listmarkers_checked /> ".__("List all markers below the map","wp-google-maps")."
                                
                            </td>
                        </tr>
                        <tr>
                            <td>".__("Map Alignment","wp-google-maps").":</td>
                            <td><select id='wpgmza_map_align' name='wpgmza_map_align' class='postform'>
                                <option value=\"1\" ".$wpgmza_map_align[1].">".__("Left","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_map_align[2].">".__("Center","wp-google-maps")."</option>
                                <option value=\"3\" ".$wpgmza_map_align[3].">".__("Right","wp-google-maps")."</option>
                                <option value=\"4\" ".$wpgmza_map_align[4].">".__("None","wp-google-maps")."</option>
                            </select>
                            </td>
                        </tr>

                        <tr>
                            <td>".__("Enable Directions?","wp-google-maps").":</td>
                            <td><select id='wpgmza_directions' name='wpgmza_directions' class='postform'>
                                <option value=\"1\" ".$wpgmza_directions[1].">".__("Yes","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_directions[2].">".__("No","wp-google-maps")."</option>
                            </select>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            ".__("Directions Box Open by Default?","wp-google-maps").":
                            <select id='wpgmza_dbox' name='wpgmza_dbox' class='postform'>
                                <option value=\"1\" ".$wpgmza_dbox[1].">".__("No","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_dbox[2].">".__("Yes, on the left","wp-google-maps")."</option>
                                <option value=\"3\" ".$wpgmza_dbox[3].">".__("Yes, on the right","wp-google-maps")."</option>
                                <option value=\"4\" ".$wpgmza_dbox[4].">".__("Yes, above","wp-google-maps")."</option>
                                <option value=\"5\" ".$wpgmza_dbox[5].">".__("Yes, below","wp-google-maps")."</option>
                            </select>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            ".__("Directions Box Width","wp-google-maps").":
                            <input id='wpgmza_dbox_width' name='wpgmza_dbox_width' type='text' size='4' maxlength='4' class='small-text' value='".$res->dbox_width."' /> px
                            </td>
                        </tr>
                        <tr>
                            <td>".__("Enable Bicycle Layer?","wp-google-maps").":</td>
                            <td><select id='wpgmza_bicycle' name='wpgmza_bicycle' class='postform'>
                                <option value=\"1\" ".$wpgmza_bicycle[1].">".__("Yes","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_bicycle[2].">".__("No","wp-google-maps")."</option>
                            </select>
                            &nbsp; &nbsp; &nbsp; &nbsp;

                            ".__("Enable Traffic Layer?","wp-google-maps").":
                            <select id='wpgmza_traffic' name='wpgmza_traffic' class='postform'>
                                <option value=\"1\" ".$wpgmza_traffic[1].">".__("Yes","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_traffic[2].">".__("No","wp-google-maps")."</option>
                            </select></td>
                        </tr>
                        <tr>
                            
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td>".__("KML/GeoRSS URL","wp-google-maps").":</td>
                            <td>
                             <input id='wpgmza_kml' name='wpgmza_kml' type='text' size='100' maxlength='700' class='regular-text' value='".$res->kml."' /> <em><small>".__("The KML/GeoRSS layer will over-ride most of your map settings")."</small></em></td>
                            </td>
                        </tr>
                        </table>
                            <div id=\"wpgmaps_save_reminder\" style=\"display:none;\"><span style=\"font-size:16px; color:#1C62B9;\">
                            ".__("Remember to save your map!","wp-google-maps")."
                            </span></div>

                            </div>

                            <p class='submit'><input type='submit' name='wpgmza_savemap' class='button-primary' value='".__("Save Map","wp-google-maps")." &raquo;' /></p>
                            <p style=\"width:600px; color:#808080;\">
                                ".__("Tip: Use your mouse to change the layout of your map. When you have positioned the map to your desired location, press \"Save Map\" to keep your settings.","wp-google-maps")."</p>

                            <div id=\"wpgmza_map\">&nbsp;</div>
                            <a name=\"wpgmaps_marker\" /></a>

                            <div style=\"display:block; overflow:auto; background-color:#FFFBCC; padding:10px; border:1px solid #E6DB55; margin-top:5px; margin-bottom:5px;\">

                                <h2 style=\"padding-top:0; margin-top:0;\">".__("Add a marker","wp-google-maps")."</h2>
                                <input type=\"hidden\" name=\"wpgmza_edit_id\" id=\"wpgmza_edit_id\" value=\"\" />
                                <p>
                                <table>
                                <tr>
                                    <td>".__("Title","wp-google-maps").": </td>
                                    <td><input id='wpgmza_add_title' name='wpgmza_add_title' type='text' size='35' maxlength='200' value='' /> &nbsp;<br /></td>

                                </tr>
                                <tr>
                                    <td>".__("Address/GPS","wp-google-maps").": </td>
                                    <td><input id='wpgmza_add_address' name='wpgmza_add_address' type='text' size='35' maxlength='200' value='' /> &nbsp;<br /></td>

                                </tr>

                                <tr><td valign='top'>".__("Description","wp-google-maps").": </td>
                                <td><textarea id='wpgmza_add_desc' name='wpgmza_add_desc' ".$wpgmza_act." rows='3' cols='37'></textarea>  &nbsp;<br /></td></tr>
                                <tr><td>".__("Pic URL","wp-google-maps").": </td>
                                <td><input id='wpgmza_add_pic' name=\"wpgmza_add_pic\" type='text' size='35' maxlength='700' value='' ".$wpgmza_act."/> <input id=\"upload_image_button\" type=\"button\" value=\"".__("Upload Image","wp-google-maps")."\" $wpgmza_act /> &nbsp; <small><i>(".__("Or paste image URL","wp-google-maps").")</i></small><br /></td></tr>
                                <tr><td>".__("Link URL","wp-google-maps").": </td>
                                    <td><input id='wpgmza_link_url' name='wpgmza_link_url' type='text' size='35' maxlength='700' value='' ".$wpgmza_act." /><small><i> ".__("Format: http://www.domain.com","wp-google-maps")."</i></small><br /></td></tr>
                                <tr><td>".__("Custom Marker","wp-google-maps").": </td>
                                <td><span id=\"wpgmza_cmm\"></span><input id='wpgmza_add_custom_marker' name=\"wpgmza_add_custom_marker\" type='hidden' size='35' maxlength='700' value='' ".$wpgmza_act."/> <input id=\"upload_custom_marker_button\" type=\"button\" value=\"".__("Upload Image","wp-google-maps")."\" $wpgmza_act /> &nbsp; <small><i>(".__("ignore if you want to use the defaul marker","wp-google-maps").")</i></small><br /></td></tr>
                                <tr>
                                    <td>".__("Animation","wp-google-maps").": </td>
                                    <td>
                                        <select name=\"wpgmza_animation\" id=\"wpgmza_animation\">
                                            <option value=\"0\">".__("None","wp-google-maps")."</option>
                                            <option value=\"1\">".__("Bounce","wp-google-maps")."</option>
                                            <option value=\"2\">".__("Drop","wp-google-maps")."</option>
                                    </td>
                                </tr>
                                <tr>
                                    <td>".__("InfoWindow open by default","wp-google-maps").": </td>
                                    <td>
                                        <select name=\"wpgmza_infoopen\" id=\"wpgmza_infoopen\">
                                            <option value=\"0\">".__("No","wp-google-maps")."</option>
                                            <option value=\"1\">".__("Yes","wp-google-maps")."</option>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <span id=\"wpgmza_addmarker_div\"><input type=\"button\" id='wpgmza_addmarker' class='button-primary' value='".__("Add Marker","wp-google-maps")."' /></span> <span id=\"wpgmza_addmarker_loading\" style=\"display:none;\">".__("Adding","wp-google-maps")."...</span>
                                        <span id=\"wpgmza_editmarker_div\" style=\"display:none;\"><input type=\"button\" id='wpgmza_editmarker' class='button-primary' value='".__("Save Marker","wp-google-maps")."' /></span><span id=\"wpgmza_editmarker_loading\" style=\"display:none;\">".__("Saving","wp-google-maps")."...</span>
                                    </td>
                                </tr>
                                </table>
                            </div>
                            <p>$wpgmza_act_msg</p>
                        </form>

                            <h2 style=\"padding-top:0; margin-top:0;\">".__("Your Markers","wp-google-maps")."</h2>
                            <div id=\"wpgmza_marker_holder\">
                                ".wpgmza_return_marker_list($_GET['map_id'])."
                            </div>




                            


                        ".wpgmza_return_pro_add_ons()."

                        

                    <p><br /><br />".__("WP Google Maps encourages you to make use of the amazing icons created by Nicolas Mollet's Maps Icons Collection","wp-google-maps")." <a href='http://mapicons.nicolasmollet.com'>http://mapicons.nicolasmollet.com/</a> ".__("and to credit him when doing so.","wp-google-maps")."</p>

                
            </div>
        </div>
    ";

}
function wpgmaps_action_callback_pro() {
        global $wpdb;
        global $wpgmza_tblname;
        $check = check_ajax_referer( 'wpgmza', 'security' );
        $table_name = $wpdb->prefix . "wpgmza";
        if ($check == 1) {

            if ($_POST['action'] == "add_marker") {
                  $ins_array = array( 'map_id' => $_POST['map_id'], 'title' => $_POST['title'], 'address' => $_POST['address'], 'desc' => $_POST['desc'], 'pic' => $_POST['pic'], 'icon' => $_POST['icon'], 'link' => $_POST['link'], 'lat' => $_POST['lat'], 'lng' => $_POST['lng'], 'anim' => $_POST['anim'], 'infoopen' => $_POST['infoopen'] );
                  
                  $rows_affected = $wpdb->insert( $table_name, $ins_array );
                   wpgmaps_update_xml_file($_POST['map_id']);
                   echo wpgmza_return_marker_list($_POST['map_id']);
            }

            if ($_POST['action'] == "edit_marker") {
                  $desc = $_POST['desc'];
                  $link = $_POST['link'];
                  $pic = $_POST['pic'];
                  $icon = $_POST['icon'];
                  $anim = $_POST['anim'];
                  $infoopen = $_POST['infoopen'];
                  $cur_id = intval($_POST['edit_id']);
                  $rows_affected = $wpdb->query("UPDATE $table_name SET `title` = '".$_POST['title']."', `address` = '".$_POST['address']."', `desc` = '$desc', `link` = '$link', `icon` = '$icon', `pic` = '$pic', `lat` = '".$_POST['lat']."', `lng` = '".$_POST['lng']."', `anim` = '$anim', `infoopen` = '$infoopen' WHERE `id`  = '$cur_id'");
                  wpgmaps_update_xml_file($_POST['map_id']);
                  echo wpgmza_return_marker_list($_POST['map_id']);
           }

            if ($_POST['action'] == "delete_marker") {
                $marker_id = $_POST['marker_id'];
                $wpdb->query(
                        "
                        DELETE FROM $wpgmza_tblname
                        WHERE `id` = '$marker_id'
                        LIMIT 1
                        "
                );
                wpgmaps_update_xml_file($_POST['map_id']);
                echo wpgmza_return_marker_list($_POST['map_id']);

            }
        }

	die(); // this is required to return a proper result

}
function wpgmza_return_pro_add_ons() {
    if (function_exists(wpgmza_register_gold_version)) { return wpgmza_gold_addon_display(); } else { return; }
}


function wpgmaps_tag_pro( $atts ) {
        global $wpgmza_current_map_id;
        extract( shortcode_atts( array(
		'id' => '1'
	), $atts ) );

        
        $wpgmza_current_map_id = $atts['id'];
        $res = wpgmza_get_map_data($atts['id']);
        //$wpgmza_data = get_option('WPGMZA');
        $map_align = $res->alignment;
        if (!$map_align || $map_align == "" || $map_align == "1") { $map_align = "float:left;"; }
        else if ($map_align == "2") { $map_align = "margin-left:auto !important; margin-right:auto; !important; align:center;"; }
        else if ($map_align == "3") { $map_align = "float:right;"; }
        else if ($map_align == "4") { $map_align = ""; }
        $map_style = "style=\"display:block; width:".$res->map_width."px; height:".$res->map_height."px; $map_align\"";

        global $short_code_active;
        $short_code_active = true;

        global $wpgmza_short_code_array;
        $wpgmza_short_code_array[] = $wpgmza_current_map_id;

        $d_enabled = $res->directions_enabled;
        $map_width = $res->map_width;
        
        // for marker list
        $default_marker = $res->default_marker;
        if ($default_marker) { $default_marker = "<img src='".$default_marker."' />"; } else { $default_marker = "<img src='".wpgmaps_get_plugin_url()."/images/marker.png' />"; }

        $dbox_width = $res->dbox_width;

        $dbox_option = $res->dbox;
        if ($dbox_option == "1") { $dbox_style = "display:none;"; }
        else if ($dbox_option == "2") { $dbox_style = "float:left; width:".$dbox_width."px; padding-right:10px; display:block; overflow:auto;"; }
        else if ($dbox_option == "3") { $dbox_style = "float:right; width:".$dbox_width."px; padding-right:10px; display:block; overflow:auto;"; }
        else if ($dbox_option == "4") { $dbox_style = "float:none; width:".$dbox_width."px; padding-bottom:10px; display:block; overflow:auto;"; }
        else if ($dbox_option == "5") { $dbox_style = "float:none; width:".$dbox_width."px; padding-top:10px; display:block; overflow:auto;"; }
        else { $dbox_style = "display:none;"; }
        
        // GET LIST OF MARKERS
        if ($res->listmarkers == 1) {
            global $wpdb;
            global $wpgmza_tblname;

            $results = $wpdb->get_results("
                SELECT *
                FROM $wpgmza_tblname
                WHERE `map_id` = '$wpgmza_current_map_id' ORDER BY `id` DESC
            ");
            

            $wpgmza_marker_list_output .= "
                    <table id=\"wpgmza_marker_list\" class=\"wpgmza_marker_list_class\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:".$map_width."px\">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        
                    </tr>
                    </thead>
                    <tbody>
            ";

            
            $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
            $wpgmza_image_height = $wpgmza_settings['wpgmza_settings_image_height'];
            $wpgmza_image_width = $wpgmza_settings['wpgmza_settings_image_width'];
            if (!$wpgmza_image_height || !isset($wpgmza_image_height)) { $wpgmza_image_height = "100"; }
            if (!$wpgmza_image_width || !isset($wpgmza_image_width)) { $wpgmza_image_width = "100"; }

            foreach ( $results as $result ) {
                $img = $result->pic;
                $wpgmaps_id = $result->id;
                $link = $result->link;
                $icon = $result->icon;
                $wpgmaps_lat = $result->lat;
                $wpgmaps_lng = $result->lng;
                $wpgmaps_address = $result->address;

                if (!$img) { $pic = ""; } else { 
                    $wpgmza_use_timthumb = $wpgmza_settings['wpgmza_settings_use_timthumb'];
                    if ($wpgmza_use_timthumb == "" || !isset($wpgmza_use_timthumb)) {
                        $pic = "<img src='".wpgmaps_get_plugin_url()."/timthumb.php?src=".$result->pic."&h=".$wpgmza_image_height."&w=".$wpgmza_image_width."&zc=1' title='' alt='' style=\"\" />";
                    } else  {
                        $pic = "<img src='".$result->pic."' class='wpgmza_map_image' style=\"float:right; margin:5px; height:".$wpgmza_image_height."px; width:".$wpgmza_image_width.".px\" />";
                    }
                }
                if (!$icon) { $icon = $default_marker; } else { $icon = "<img src='".$result->icon."' />"; }
                if ($d_enabled == "1") {
                    $wpgmaps_dir_text = "<br /><a href=\"javascript:void(0);\" id=\"$wpgmza_current_map_id\" title=\""._("Get directions to","wp-google-maps")." ".$result->title."\" class=\"wpgmza_gd\" wpgm_addr_field=\"".$wpgmaps_address."\" gps=\"$wpgmaps_lat,$wpgmaps_lng\">"._("Directions","wp-google-maps")."</a>";
                }
                if ($result->desc) {
                    $wpgmaps_desc_text = "<br />".$result->desc."";
                } else {
                    $wpgmaps_desc_text = "";
                }
                $wpgmza_marker_list_output .= "
                    <tr id=\"wpgmza_marker_".$result->id."\" mid=\"".$result->id."\" mapid=\".$result->map_id.\" class=\"wpgmaps_mlist_row\">
                        <td height=\"40\" class=\"wpgmaps_mlist_marker\">".$icon."</td>
                        <td valign=\"top\" align=\"left\" class=\"wpgmaps_mlist_info\">
                            <strong><a href=\"javascript:openInfoWindow($wpgmaps_id);\" id=\"wpgmaps_marker_$wpgmaps_id\" title=\"".$result->title."\">".$result->title."</a></strong>
                            $wpgmaps_desc_text
                            $wpgmaps_dir_text
                        </td>
                        
                    </tr>";
            }
            $wpgmza_marker_list_output .= "</tbody></table>";
            
        } else { $wpgmza_marker_list_output = ""; }


        $dbox_div = "
            <div id=\"wpgmaps_directions_edit_".$atts['id']."\" style=\"$dbox_style\" class=\"wpgmaps_directions_outer_div\">
                <h2>".__("Get Directions","wp-google-maps")."</h2>
                <div id=\"wpgmaps_directions_editbox_".$atts['id']."\">
                    <table>
                        <tr>
                            <td>".__("For","wp-google-maps").":</td><td>
                                <select id=\"wpgmza_dir_type_".$atts['id']."\" name=\"wpgmza_dir_type_".$atts['id']."\">
                                <option value=\"DRIVING\" selected=\"selected\">".__("Driving","wp-google-maps")."</option>
                                <option value=\"WALKING\">".__("Walking","wp-google-maps")."</option>
                                <option value=\"BICYCLING\">".__("Bicycling","wp-google-maps")."</option>
                                </select>
                                &nbsp;
                                <a href=\"javascript:void(0);\" mapid=\"".$atts['id']."\" id=\"wpgmza_show_options_".$atts['id']."\" onclick=\"wpgmza_show_options(".$atts['id'].");\" style=\"font-size:10px;\">".__("show options","wp-google-maps")."</a>
                                <a href=\"javascript:void(0);\" mapid=\"".$atts['id']."\" id=\"wpgmza_hide_options_".$atts['id']."\" onclick=\"wpgmza_hide_options(".$atts['id'].");\" style=\"font-size:10px; display:none;\">".__("hide options","wp-google-maps")."</a>
                            <div style=\"display:none\" id=\"wpgmza_options_box_".$atts['id']."\">
                                <input type=\"checkbox\" id=\"wpgmza_tolls_".$atts['id']."\" name=\"wpgmza_tolls_".$atts['id']."\" value=\"tolls\" /> ".__("Avoid Tolls","wp-google-maps")." <br />
                                <input type=\"checkbox\" id=\"wpgmza_highways_".$atts['id']."\" name=\"wpgmza_highways_".$atts['id']."\" value=\"highways\" /> ".__("Avoid Highways","wp-google-maps")."
                            </div>

                            </td>
                        </tr>
                        <tr><td>".__("From","wp-google-maps").":</td><td width='90%'><input type=\"text\" value=\"\" id=\"wpgmza_input_from_".$atts['id']."\" style='width:80%' /></td><td></td></tr>
                        <tr><td>".__("To","wp-google-maps").":</td><td width='90%'><input type=\"text\" value=\"\" id=\"wpgmza_input_to_".$atts['id']."\" style='width:80%' /></td><td></td></tr>
                        <tr>

                          <td>
                            </td><td>
                          <input onclick=\"javascript:void(0);\" class=\"wpgmaps_get_directions\" id=\"".$atts['id']."\" type=\"button\" value=\"".__("Go","wp-google-maps")."\"/>
                          </td>
                        </tr>
                    </table>
                </div>
                

        ";

        if ($dbox_option == "5" || $dbox_option == "1" || !isset($dbox_option)) {
            $ret_msg = "
                <style>
                .wpgmza_map img { max-width:none !important; }
                </style>

                <div id=\"wpgmza_map_".$atts['id']."\" class='wpgmza_map' $map_style>&nbsp;</div>
                $wpgmza_marker_list_output
                <div id=\"display:block; width:100%;\">

                    $dbox_div
                        <div id=\"wpgmaps_directions_notification_".$atts['id']."\" style=\"display:none;\">".__("Fetching directions...","wp-google-maps")."...</div>
                        <div id=\"wpgmaps_directions_reset_".$atts['id']."\" style=\"display:none;\"><a href='javascript:void(0)' onclick='wpgmza_reset_directions(".$atts['id'].");' id='wpgmaps_reset_directions' title='".__("Reset directions","wp-google-maps")."'>".__("Reset directions","wp-google-maps")."</a></div>
                        <div id=\"directions_panel_".$atts['id']."\"></div>
                    </div>
                </div>

            ";
        } else {
            $ret_msg = "
                <style>
                .wpgmza_map img { max-width:none !important; }
                </style>

                <div id=\"display:block; width:100%; overflow:auto;\">

                    $dbox_div
                        <div id=\"wpgmaps_directions_notification_".$atts['id']."\" style=\"display:none;\">".__("Fetching directions...","wp-google-maps")."...</div>
                        <div id=\"wpgmaps_directions_reset_".$atts['id']."\" style=\"display:none;\"><a href='javascript:void(0)' onclick='wpgmza_reset_directions(".$atts['id'].");' id='wpgmaps_reset_directions' title='".__("Reset directions","wp-google-maps")."'>".__("Reset directions","wp-google-maps")."</a></div>
                        <div id=\"directions_panel_".$atts['id']."\"></div>
                    </div>
                <div id=\"wpgmza_map_".$atts['id']."\" class='wpgmza_map' $map_style>&nbsp;</div>
                $wpgmza_marker_list_output
                </div>

            ";

        }

        return $ret_msg;
}


function wpgmaps_user_javascript_pro() {
    global $short_code_active;
    global $wpgmza_current_map_id;
    global $wpgmza_short_code_array;

    

    if ($short_code_active) {
        $ajax_nonce = wp_create_nonce("wpgmza");
        
        ?>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript" >
        jQuery(function() {



            jQuery(".wpgmaps_mlist_row").click(function() {
                var wpgmza_markerid = jQuery(this).attr("mid");
                openInfoWindow(wpgmza_markerid);
            });


            <?php
                    foreach ($wpgmza_short_code_array as $wpgmza_cmd) {
                        $res = wpgmza_get_map_data($wpgmza_cmd);

                        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");

                        $wpgmza_lat[$wpgmza_cmd] = $res->map_start_lat;
                        $wpgmza_lng[$wpgmza_cmd] = $res->map_start_lng;
                        $wpgmza_width[$wpgmza_cmd] = $res->map_width;
                        $wpgmza_height[$wpgmza_cmd] = $res->map_height;
                        $wpgmza_map_type[$wpgmza_cmd] = $res->type;
                        $wpgmza_default_icon[$wpgmza_cmd] = $res->default_marker;
                        $wpgmza_directions[$wpgmza_cmd] = $res->directions_enabled;
                        $kml[$wpgmza_cmd] = $res->kml;
                        $wpgmza_bicycle[$wpgmza_cmd] = $res->bicycle;
                        $wpgmza_traffic[$wpgmza_cmd] = $res->traffic;
                        $wpgmza_dbox[$wpgmza_cmd] = $res->dbox;
                        $wpgmza_dbox_width[$wpgmza_cmd] = $res->dbox_width;

                        $wpgmza_listmarkers[$wpgmza_cmd] = $res->listmarkers;

                        if ($wpgmza_default_icon[$wpgmza_cmd] == "0") { $wpgmza_default_icon[$wpgmza_cmd] = ""; }
                        if (!$wpgmza_map_type[$wpgmza_cmd] || $wpgmza_map_type[$wpgmza_cmd] == "" || $wpgmza_map_type[$wpgmza_cmd] == "1") { $wpgmza_map_type[$wpgmza_cmd] = "ROADMAP"; }
                        else if ($wpgmza_map_type[$wpgmza_cmd] == "2") { $wpgmza_map_type[$wpgmza_cmd] = "SATELLITE"; }
                        else if ($wpgmza_map_type[$wpgmza_cmd] == "3") { $wpgmza_map_type[$wpgmza_cmd] = "HYBRID"; }
                        else if ($wpgmza_map_type[$wpgmza_cmd] == "4") { $wpgmza_map_type[$wpgmza_cmd] = "TERRAIN"; }
                        else { $wpgmza_map_type[$wpgmza_cmd] = "ROADMAP"; }
                        $start_zoom[$wpgmza_cmd] = $res->map_start_zoom;
                        if ($start_zoom[$wpgmza_cmd] < 1 || !$start_zoom[$wpgmza_cmd]) { $start_zoom[$wpgmza_cmd] = 5; }
                        if (!$wpgmza_lat[$wpgmza_cmd] || !$wpgmza_lng[$wpgmza_cmd]) { $wpgmza_lat[$wpgmza_cmd] = "51.5081290"; $wpgmza_lng[$wpgmza_cmd] = "-0.1280050"; }



            ?>
            jQuery("<?php echo "#wpgmza_map_".$wpgmza_cmd; ?>").css({
                height:<?php echo $wpgmza_height[$wpgmza_cmd]; ?>,
                width:<?php echo $wpgmza_width[$wpgmza_cmd]; ?>

            });
            var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat[$wpgmza_cmd]; ?>,<?php echo $wpgmza_lng[$wpgmza_cmd]; ?>);
            MYMAP_<?php echo $wpgmza_cmd; ?>.init("<?php echo "#wpgmza_map_".$wpgmza_cmd; ?>", myLatLng, <?php echo $start_zoom[$wpgmza_cmd]; ?>);
            UniqueCode=Math.round(Math.random()*10000);
            MYMAP_<?php echo $wpgmza_cmd; ?>.placeMarkers('<?php echo wpgmaps_get_marker_url($wpgmza_cmd); ?>?u='+UniqueCode,<?php echo $wpgmza_cmd; ?>);

            
            <?php } // end foreach map loop ?>

            });
            
            var directionsDisplay = [];
            var directionsService = [];

            <?php foreach ($wpgmza_short_code_array as $wpgmza_cmd) { ?>

            // general directions settings and variables
            directionsDisplay[<?php echo $wpgmza_cmd; ?>];
            directionsService[<?php echo $wpgmza_cmd; ?>] = new google.maps.DirectionsService();
            var currentDirections = null;
            var oldDirections = [];
            var new_gps;


            var MYMAP_<?php echo $wpgmza_cmd; ?> = {
                map: null,
                bounds: null,
                mc: null
            }
            MYMAP_<?php echo $wpgmza_cmd; ?>.init = function(selector, latLng, zoom) {


              var myOptions = {
                zoom:zoom,
                center: latLng,
                scrollwheel: <?php if ($wpgmza_settings['wpgmza_settings_map_scroll'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                zoomControl: <?php if ($wpgmza_settings['wpgmza_settings_map_zoom'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                panControl: <?php if ($wpgmza_settings['wpgmza_settings_map_pan'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                mapTypeControl: <?php if ($wpgmza_settings['wpgmza_settings_map_type'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                streetViewControl: <?php if ($wpgmza_settings['wpgmza_settings_map_streetview'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                mapTypeId: google.maps.MapTypeId.<?php echo $wpgmza_map_type[$wpgmza_cmd]; ?>
              }


               this.map = new google.maps.Map(jQuery(selector)[0], myOptions);

               this.bounds = new google.maps.LatLngBounds();
                    directionsDisplay[<?php echo $wpgmza_cmd; ?>] = new google.maps.DirectionsRenderer({
                    'map': this.map,
                    'preserveViewport': true,
                    'draggable': true
                });
              directionsDisplay[<?php echo $wpgmza_cmd; ?>].setPanel(document.getElementById("directions_panel_<?php echo $wpgmza_cmd; ?>"));
              google.maps.event.addListener(directionsDisplay[<?php echo $wpgmza_cmd; ?>], 'directions_changed',
                function() {
                    if (currentDirections) {
                        oldDirections.push(currentDirections);

                    }
                    currentDirections = directionsDisplay[<?php echo $wpgmza_cmd; ?>].getDirections();
                    jQuery("#directions_panel_<?php echo $wpgmza_cmd; ?>").show();
                    jQuery("#wpgmaps_directions_notification_<?php echo $wpgmza_cmd; ?>").hide();
                    jQuery("#wpgmaps_directions_reset_<?php echo $wpgmza_cmd; ?>").show();
                });

                <?php if ($wpgmza_bicycle[$wpgmza_cmd] == "1") { ?>
                    var bikeLayer = new google.maps.BicyclingLayer();
                    bikeLayer.setMap(this.map);
                <?php } ?>
                <?php if ($wpgmza_traffic[$wpgmza_cmd] == "1") { ?>
                    var trafficLayer = new google.maps.TrafficLayer();
                    trafficLayer.setMap(this.map);
                <?php } ?>
                <?php if ($kml[$wpgmza_cmd] != "") { ?>
                    var georssLayer = new google.maps.KmlLayer('<?php echo $kml[$wpgmza_cmd]; ?>');
                    georssLayer.setMap(this.map);
                <?php } ?>
            }
            var infoWindow = new google.maps.InfoWindow();
            <?php
                $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                $wpgmza_settings_infowindow_width = $wpgmza_settings['wpgmza_settings_infowindow_width'];
                if (!$wpgmza_settings_infowindow_width || !isset($wpgmza_settings_infowindow_width)) { $wpgmza_settings_infowindow_width = "200"; }
            ?>
            infoWindow.setOptions({maxWidth:<?php echo $wpgmza_settings_infowindow_width; ?>});


            MYMAP_<?php echo $wpgmza_cmd; ?>.placeMarkers = function(filename,map_id) {
                    marker_array = [];
                        jQuery.get(filename, function(xml){
                                jQuery(xml).find("marker").each(function(){
                                        var wpgmza_def_icon = '<?php echo $wpgmza_default_icon[$wpgmza_cmd]; ?>';
                                        var wpmgza_map_id = jQuery(this).find('map_id').text();
                                        var wpmgza_marker_id = jQuery(this).find('marker_id').text();

                                        if (wpmgza_map_id == map_id) {
                                            var wpmgza_title = jQuery(this).find('title').text();
                                            var wpmgza_address = jQuery(this).find('address').text();
                                            var wpmgza_mapicon = jQuery(this).find('icon').text();
                                            var wpmgza_image = jQuery(this).find('pic').text();
                                            var wpmgza_desc  = jQuery(this).find('desc').text();
                                            var wpmgza_linkd = jQuery(this).find('linkd').text();
                                            var wpmgza_anim  = jQuery(this).find('anim').text();
                                            var wpmgza_infoopen  = jQuery(this).find('infoopen').text();
                                            if (wpmgza_title != "") {
                                                wpmgza_title = wpmgza_title+'<br />';
                                            }


                                            if (wpmgza_image != "") {

                                    <?php
                                        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                        $wpgmza_image_height = $wpgmza_settings['wpgmza_settings_image_height'];
                                        $wpgmza_image_width = $wpgmza_settings['wpgmza_settings_image_width'];
                                        if (!$wpgmza_image_height || !isset($wpgmza_image_height)) { $wpgmza_image_height = "100"; }
                                        if (!$wpgmza_image_width || !isset($wpgmza_image_width)) { $wpgmza_image_width = "100"; }

                                        $wpgmza_use_timthumb = $wpgmza_settings['wpgmza_settings_use_timthumb'];
                                        if ($wpgmza_use_timthumb == "" || !isset($wpgmza_use_timthumb)) { ?>
                                                wpmgza_image = "<br /><img src='<?php echo wpgmaps_get_plugin_url(); ?>/timthumb.php?src="+wpmgza_image+"&h=<?php echo $wpgmza_image_height; ?>&w=<?php echo $wpgmza_image_width; ?>&zc=1' title='' alt='' style=\"float:right; margin:5px;\" />";
                                    <?php } else  { ?>
                                                wpmgza_image = "<br /><img src='"+wpmgza_image+"' class='wpgmza_map_image' style=\"float:right; margin:5px; height:<?php echo $wpgmza_image_height; ?>px; width:<?php echo $wpgmza_image_width; ?>px\" />";
                                    <?php } ?>

                                            } else { wpmgza_image = "" }
                                            if (wpmgza_linkd != "") {
                                                <?php
                                                    $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                                    $wpgmza_settings_infowindow_links = $wpgmza_settings['wpgmza_settings_infowindow_links'];
                                                    if ($wpgmza_settings_infowindow_links == "yes") { $wpgmza_settings_infowindow_links = "target='_BLANK'";  }
                                                ?>

                                                wpmgza_linkd = "<a href='"+wpmgza_linkd+"' <?php echo $wpgmza_settings_infowindow_links; ?> title='<?php _e("More details","wp-google-maps"); ?>'><?php _e("More details","wp-google-maps"); ?></a><br />";
                                            }

                                            if (wpmgza_mapicon == "" || !wpmgza_mapicon) { if (wpgmza_def_icon != "") { wpmgza_mapicon = '<?php echo $wpgmza_default_icon[$wpgmza_cmd]; ?>'; } }


                                            var lat = jQuery(this).find('lat').text();
                                            var lng = jQuery(this).find('lng').text();
                                            var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
                                            MYMAP_<?php echo $wpgmza_cmd; ?>.bounds.extend(point);
                                            if (wpmgza_anim == "1") {
                                                var marker = new google.maps.Marker({
                                                        position: point,
                                                        map: MYMAP_<?php echo $wpgmza_cmd; ?>.map,
                                                        icon: wpmgza_mapicon,
                                                        animation: google.maps.Animation.BOUNCE
                                                });
                                            }
                                            else if (wpmgza_anim == "2") {
                                                var marker = new google.maps.Marker({
                                                        position: point,
                                                        map: MYMAP_<?php echo $wpgmza_cmd; ?>.map,
                                                        icon: wpmgza_mapicon,
                                                        animation: google.maps.Animation.DROP
                                                });
                                            }
                                            else {
                                                var marker = new google.maps.Marker({
                                                        position: point,
                                                        map: MYMAP_<?php echo $wpgmza_cmd; ?>.map,
                                                        icon: wpmgza_mapicon
                                                });
                                            }

                                            <?php
                                                    $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                                    $wpgmza_settings_infowindow_address = $wpgmza_settings['wpgmza_settings_infowindow_address'];
                                                    if ($wpgmza_settings_infowindow_address == "yes") {
                                            ?>
                                            wpmgza_address = "";
                                            <?php } ?>


                                            var html='<div class="wpgmza_markerbox">'
                                                +wpmgza_image+
                                                '<strong>'
                                                +wpmgza_title+
                                                '</strong>'+wpmgza_address+'<br /><span style="font-size:12px;">'
                                                +wpmgza_desc+
                                                '<br />'
                                                +wpmgza_linkd+
                                                ''+
                                                <?php if ($wpgmza_directions[$wpgmza_cmd] == 1) { ?>
                                                '<a href="javascript:void(0);" id="<?php echo $wpgmza_cmd; ?>" class="wpgmza_gd" wpgm_addr_field="'+wpmgza_address+'" gps="'+parseFloat(lat)+','+parseFloat(lng)+'"><?php _e("Get directions","wp-google-maps"); ?></a>'
                                                <?php } else { ?>
                                                ' '
                                                <?php } ?>
                                                +'</span></div>';
                                            if (wpmgza_infoopen == "1") {
                                                infoWindow.setContent(html);
                                                infoWindow.open(MYMAP_<?php echo $wpgmza_cmd; ?>.map, marker);
                                            }

                                            google.maps.event.addListener(marker, 'click', function(evt) {
                                                infoWindow.close();
                                                infoWindow.setContent(html);
                                                infoWindow.open(MYMAP_<?php echo $wpgmza_cmd; ?>.map, marker);
                                                //MYMAP.map.setCenter(this.position);
                                            });


                                        marker_array[wpmgza_marker_id] = marker;

                                    }
                        });

                });
            }
        
            <?php } // end foreach map loop ?>


            function openInfoWindow(marker_id) {
                google.maps.event.trigger(marker_array[marker_id], 'click');
                //infoWindow.setContent("km away from you.");
                //infoWindow.open(MYMAP_<?php echo $wpgmza_cmd; ?>, marker_array[0]);
            }




            function calcRoute(start,end,mapid,travelmode,avoidtolls,avoidhighways) {
                var request = {
                    origin:start,
                    destination:end,
                    travelMode: google.maps.DirectionsTravelMode[travelmode],
                    avoidHighways: avoidhighways,
                    avoidTolls: avoidtolls
                };
                
                directionsService[mapid].route(request, function(response, status) {
                  if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay[mapid].setDirections(response);
                  }
                });
              }
              function wpgmza_show_options(wpgmzamid) {
                  
                  jQuery("#wpgmza_options_box_"+wpgmzamid).show();
                  jQuery("#wpgmza_show_options_"+wpgmzamid).hide();
                  jQuery("#wpgmza_hide_options_"+wpgmzamid).show();
              }
              function wpgmza_hide_options(wpgmzamid) {
                  jQuery("#wpgmza_options_box_"+wpgmzamid).hide();
                  jQuery("#wpgmza_show_options_"+wpgmzamid).show();
                  jQuery("#wpgmza_hide_options_"+wpgmzamid).hide();
              }
            function wpgmza_reset_directions(wpgmzamid) {

                jQuery("#wpgmaps_directions_editbox_"+wpgmzamid).show();
                jQuery("#directions_panel_"+wpgmzamid).hide();
                jQuery("#wpgmaps_directions_notification_"+wpgmzamid).hide();
                jQuery("#wpgmaps_directions_reset_"+wpgmzamid).hide();
              }

             jQuery(".wpgmza_gd").live("click", function() {
                 
                var wpgmzamid = jQuery(this).attr("id");
                var end = jQuery(this).attr("wpgm_addr_field");
                jQuery("#wpgmaps_directions_edit_"+wpgmzamid).show();
                jQuery("#wpgmaps_directions_editbox_"+wpgmzamid).show();
                jQuery("#wpgmza_input_to_"+wpgmzamid).val(end);
                jQuery("#wpgmza_input_from_"+wpgmzamid).focus().select();

             });

             jQuery(".wpgmaps_get_directions").live("click", function() {
                 var wpgmzamid = jQuery(this).attr("id");

                 var avoidtolls = jQuery('#wpgmza_tolls_'+wpgmzamid).is(':checked');
                 var avoidhighways = jQuery('#wpgmza_highways_'+wpgmzamid).is(':checked');


                 var wpgmza_dir_type = jQuery("#wpgmza_dir_type_"+wpgmzamid).val();
                 var wpgmaps_from = jQuery("#wpgmza_input_from_"+wpgmzamid).val();
                 var wpgmaps_to = jQuery("#wpgmza_input_to_"+wpgmzamid).val();
                 if (wpgmaps_from == "" || wpgmaps_to == "") { alert("<?php _e("Please fill out both the 'from' and 'to' fields","wp-google-maps"); ?>"); }
                 else { calcRoute(wpgmaps_from,wpgmaps_to,wpgmzamid,wpgmza_dir_type,avoidtolls,avoidhighways); jQuery("#wpgmaps_directions_editbox_"+wpgmzamid).hide("slow"); jQuery("#wpgmaps_directions_notification_"+wpgmzamid).show("slow");  }

            });


    
    </script>
<?php
    
    }
}






function wpgmaps_admin_javascript_pro() {
    global $wpdb;
    global $wpgmza_tblname_maps;
    $ajax_nonce = wp_create_nonce("wpgmza");
    if (is_admin() && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "edit_marker") {
        wpgmaps_admin_edit_marker_javascript();

    }

    else if (is_admin() && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "edit") {
        wpgmaps_update_xml_file($_GET['map_id']);

        $res = wpgmza_get_map_data($_GET['map_id']);
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");

        
        $wpgmza_lat = $res->map_start_lat;
        $wpgmza_lng = $res->map_start_lng;
        $wpgmza_width = $res->map_width;
        $wpgmza_height = $res->map_height;
        $wpgmza_map_type = $res->type;
        $wpgmza_default_icon = $res->default_marker;
        $kml = $res->kml;
        $wpgmza_traffic = $res->traffic;
        $wpgmza_bicycle = $res->bicycle;
        $wpgmza_dbox = $res->dbox;
        $wpgmza_dbox_width = $res->dbox_width;


        if ($wpgmza_default_icon == "0") { $wpgmza_default_icon = ""; }
        if (!$wpgmza_map_type || $wpgmza_map_type == "" || $wpgmza_map_type == "1") { $wpgmza_map_type = "ROADMAP"; }
        else if ($wpgmza_map_type == "2") { $wpgmza_map_type = "SATELLITE"; }
        else if ($wpgmza_map_type == "3") { $wpgmza_map_type = "HYBRID"; }
        else if ($wpgmza_map_type == "4") { $wpgmza_map_type = "TERRAIN"; }
        else { $wpgmza_map_type = "ROADMAP"; }

        $start_zoom = $res->map_start_zoom;
        if ($start_zoom < 1 || !$start_zoom) {
            $start_zoom = 5;
        }
        if (!$wpgmza_lat || !$wpgmza_lng) {
            $wpgmza_lat = "51.5081290";
            $wpgmza_lng = "-0.1280050";
        }
    ?>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo wpgmaps_get_plugin_url(); ?>/css/data_table.css" />
    <script type="text/javascript" src="<?php echo wpgmaps_get_plugin_url(); ?>/js/jquery.dataTables.js"></script>
    <script type="text/javascript" >



    jQuery(function() {

        

        var wpgmzaTable;

                jQuery(document).ready(function(){
                    

                    jQuery("#wpgmaps_show_advanced").click(function() {
                      jQuery("#wpgmaps_advanced_options").show();
                      jQuery("#wpgmaps_show_advanced").hide();
                      jQuery("#wpgmaps_hide_advanced").show();

                    });
                    jQuery("#wpgmaps_hide_advanced").click(function() {
                      jQuery("#wpgmaps_advanced_options").hide();
                      jQuery("#wpgmaps_show_advanced").show();
                      jQuery("#wpgmaps_hide_advanced").hide();

                    });



                    wpgmzaTable = jQuery('#wpgmza_table').dataTable({
                        "bProcessing": true,
                        "aaSorting": [[ 0, "desc" ]]
                    });
                    function wpgmza_reinitialisetbl() {
                        wpgmzaTable.fnClearTable( 0 );
                        wpgmzaTable = jQuery('#wpgmza_table').dataTable({
                            "bProcessing": true
                        });
                    }
                    function wpgmza_InitMap() {
                        var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat; ?>,<?php echo $wpgmza_lng; ?>);
                        MYMAP.init('#wpgmza_map', myLatLng, <?php echo $start_zoom; ?>);
                        UniqueCode=Math.round(Math.random()*10000);
                        MYMAP.placeMarkers('<?php echo wpgmaps_get_marker_url($_GET['map_id']); ?>?u='+UniqueCode,<?php echo $_GET['map_id']; ?>);
                    }

                    jQuery("#wpgmza_map").css({
                            height:<?php echo $wpgmza_height; ?>,
                            width:<?php echo $wpgmza_width; ?>

                    });
                    var geocoder = new google.maps.Geocoder();
                    wpgmza_InitMap();




                    jQuery(".wpgmza_del_btn").live("click", function() {
                        var cur_id = jQuery(this).attr("id");
                        var wpgm_map_id = "0";
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }
                        var data = {
                                action: 'delete_marker',
                                security: '<?php echo $ajax_nonce; ?>',
                                map_id: wpgm_map_id,
                                marker_id: cur_id
                        };
                        jQuery.post(ajaxurl, data, function(response) {
                                wpgmza_InitMap();
                                jQuery("#wpgmza_marker_holder").html(response);
                                wpgmza_reinitialisetbl();
                                
                        });

                    });


                    jQuery(".wpgmza_edit_btn").live("click", function() {
                        var cur_id = jQuery(this).attr("id");

                        var wpgmza_edit_title = jQuery("#wpgmza_hid_marker_title_"+cur_id).val();
                        var wpgmza_edit_address = jQuery("#wpgmza_hid_marker_address_"+cur_id).val();
                        var wpgmza_edit_desc = jQuery("#wpgmza_hid_marker_desc_"+cur_id).val();
                        var wpgmza_edit_pic = jQuery("#wpgmza_hid_marker_pic_"+cur_id).val();
                        var wpgmza_edit_link = jQuery("#wpgmza_hid_marker_link_"+cur_id).val();
                        var wpgmza_edit_icon = jQuery("#wpgmza_hid_marker_icon_"+cur_id).val();
                        var wpgmza_edit_anim = jQuery("#wpgmza_hid_marker_anim_"+cur_id).val();
                        var wpgmza_edit_infoopen = jQuery("#wpgmza_hid_marker_infoopen_"+cur_id).val();


                        jQuery("#wpgmza_edit_id").val(cur_id);

                        jQuery("#wpgmza_add_title").val(wpgmza_edit_title);
                        jQuery("#wpgmza_add_address").val(wpgmza_edit_address);
                        jQuery("#wpgmza_add_desc").val(wpgmza_edit_desc);
                        jQuery("#wpgmza_add_pic").val(wpgmza_edit_pic);
                        jQuery("#wpgmza_link_url").val(wpgmza_edit_link);
                        jQuery("#wpgmza_animation").val(wpgmza_edit_anim);
                        jQuery("#wpgmza_infoopen").val(wpgmza_edit_infoopen);
                        jQuery("#wpgmza_add_custom_marker").val(wpgmza_edit_icon);
                        jQuery("#wpgmza_cmm").html("<img src='"+wpgmza_edit_icon+"' />");

                        jQuery("#wpgmza_addmarker_div").hide();
                        jQuery("#wpgmza_editmarker_div").show();


                    });



                    jQuery("#wpgmza_addmarker").click(function(){
                        jQuery("#wpgmza_addmarker").hide();
                        jQuery("#wpgmza_addmarker_loading").show();

                        var wpgm_title = "";
                        var wpgm_address = "0";
                        var wpgm_desc = "0";
                        var wpgm_pic = "0";
                        var wpgm_link = "0";
                        var wpgm_icon = "0";
                        var wpgm_gps = "0";

                        var wpgm_anim = "0";
                        var wpgm_infoopen = "0";
                        var wpgm_map_id = "0";
                        if (document.getElementsByName("wpgmza_add_title").length > 0) { wpgm_title = jQuery("#wpgmza_add_title").val(); }
                        if (document.getElementsByName("wpgmza_add_address").length > 0) { wpgm_address = jQuery("#wpgmza_add_address").val(); }
                        if (document.getElementsByName("wpgmza_add_desc").length > 0) { wpgm_desc = jQuery("#wpgmza_add_desc").val(); }
                        if (document.getElementsByName("wpgmza_add_pic").length > 0) { wpgm_pic = jQuery("#wpgmza_add_pic").val(); }
                        if (document.getElementsByName("wpgmza_link_url").length > 0) { wpgm_link = jQuery("#wpgmza_link_url").val(); }
                        if (document.getElementsByName("wpgmza_add_custom_marker").length > 0) { wpgm_icon = jQuery("#wpgmza_add_custom_marker").val(); }
                        if (document.getElementsByName("wpgmza_animation").length > 0) { wpgm_anim = jQuery("#wpgmza_animation").val(); }
                        if (document.getElementsByName("wpgmza_infoopen").length > 0) { wpgm_infoopen = jQuery("#wpgmza_infoopen").val(); }
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }

                        geocoder.geocode( { 'address': wpgm_address}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                wpgm_gps = String(results[0].geometry.location);
                                var latlng1 = wpgm_gps.replace("(","");
                                var latlng2 = latlng1.replace(")","");
                                var latlngStr = latlng2.split(",",2);
                                var wpgm_lat = parseFloat(latlngStr[0]);
                                var wpgm_lng = parseFloat(latlngStr[1]);


                                var data = {
                                    action: 'add_marker',
                                    security: '<?php echo $ajax_nonce; ?>',
                                    map_id: wpgm_map_id,
                                    title: wpgm_title,
                                    address: wpgm_address,
                                    desc: wpgm_desc,
                                    link: wpgm_link,
                                    icon: wpgm_icon,
                                    pic: wpgm_pic,
                                    anim: wpgm_anim,
                                    infoopen: wpgm_infoopen,
                                    lat: wpgm_lat,
                                    lng: wpgm_lng
                                };


                                jQuery.post(ajaxurl, data, function(response) {
                                        wpgmza_InitMap();
                                        jQuery("#wpgmza_marker_holder").html(response);
                                        jQuery("#wpgmza_addmarker").show();
                                        jQuery("#wpgmza_addmarker_loading").hide();

                                        jQuery("#wpgmza_add_title").val("");
                                        jQuery("#wpgmza_add_address").val("");
                                        jQuery("#wpgmza_add_desc").val("");
                                        jQuery("#wpgmza_add_pic").val("");
                                        jQuery("#wpgmza_link_url").val("");
                                        jQuery("#wpgmza_animation").val("None");
                                        jQuery("#wpgmza_edit_id").val("");
                                        wpgmza_reinitialisetbl();
                                });

                            } else {
                                alert("<?php _e("Geocode was not successful for the following reason","wp-google-maps"); ?>: " + status);
                            }
                        });



                    });
                    jQuery("#wpgmza_editmarker").click(function(){

                        jQuery("#wpgmza_editmarker_div").hide();
                        jQuery("#wpgmza_editmarker_loading").show();


                        var wpgm_edit_id;
                        wpgm_edit_id = parseInt(jQuery("#wpgmza_edit_id").val());
                        var wpgm_title = "";
                        var wpgm_address = "0";
                        var wpgm_desc = "0";
                        var wpgm_pic = "0";
                        var wpgm_link = "0";
                        var wpgm_anim = "0";
                        var wpgm_infoopen = "0";
                        var wpgm_icon = "";
                        var wpgm_map_id = "0";
                        var wpgm_gps = "0";
                        if (document.getElementsByName("wpgmza_add_title").length > 0) { wpgm_title = jQuery("#wpgmza_add_title").val(); }
                        if (document.getElementsByName("wpgmza_add_address").length > 0) { wpgm_address = jQuery("#wpgmza_add_address").val(); }
                        if (document.getElementsByName("wpgmza_add_desc").length > 0) { wpgm_desc = jQuery("#wpgmza_add_desc").val(); }
                        if (document.getElementsByName("wpgmza_add_pic").length > 0) { wpgm_pic = jQuery("#wpgmza_add_pic").val(); }
                        if (document.getElementsByName("wpgmza_link_url").length > 0) { wpgm_link = jQuery("#wpgmza_link_url").val(); }
                        if (document.getElementsByName("wpgmza_animation").length > 0) { wpgm_anim = jQuery("#wpgmza_animation").val(); }
                        if (document.getElementsByName("wpgmza_infoopen").length > 0) { wpgm_infoopen = jQuery("#wpgmza_infoopen").val(); }
                        if (document.getElementsByName("wpgmza_add_custom_marker").length > 0) { wpgm_icon = jQuery("#wpgmza_add_custom_marker").val(); }
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }

                        geocoder.geocode( { 'address': wpgm_address}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                wpgm_gps = String(results[0].geometry.location);
                                var latlng1 = wpgm_gps.replace("(","");
                                var latlng2 = latlng1.replace(")","");
                                var latlngStr = latlng2.split(",",2);
                                var wpgm_lat = parseFloat(latlngStr[0]);
                                var wpgm_lng = parseFloat(latlngStr[1]);

                                var data = {
                                        action: 'edit_marker',
                                        security: '<?php echo $ajax_nonce; ?>',
                                        map_id: wpgm_map_id,
                                        edit_id: wpgm_edit_id,
                                        title: wpgm_title,
                                        address: wpgm_address,
                                        lat: wpgm_lat,
                                        lng: wpgm_lng,
                                        icon: wpgm_icon,
                                        desc: wpgm_desc,
                                        link: wpgm_link,
                                        pic: wpgm_pic,
                                        anim: wpgm_anim,
                                        infoopen: wpgm_infoopen
                                };

                                jQuery.post(ajaxurl, data, function(response) {
                                    wpgmza_InitMap();
                                    jQuery("#wpgmza_marker_holder").html(response);
                                    jQuery("#wpgmza_addmarker_div").show();
                                    jQuery("#wpgmza_editmarker_loading").hide();
                                    jQuery("#wpgmza_add_title").val("");
                                    jQuery("#wpgmza_add_address").val("");
                                    jQuery("#wpgmza_add_desc").val("");
                                    jQuery("#wpgmza_add_pic").val("");
                                    jQuery("#wpgmza_link_url").val("");
                                    jQuery("#wpgmza_edit_id").val("");
                                    jQuery("#wpgmza_cmm").html("");
                                    wpgmza_reinitialisetbl();
                                });

                            } else {
                                alert("<?php _e("Geocode was not successful for the following reason","wp-google-maps"); ?>: " + status);
                            }
                        });





                    });
            });

            });


            var MYMAP = {
                map: null,
                bounds: null,
                mc: null
            }
            MYMAP.init = function(selector, latLng, zoom) {
              var myOptions = {
                zoom:zoom,
                
                center: latLng,
                scrollwheel: <?php if ($wpgmza_settings['wpgmza_settings_map_scroll'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                zoomControl: <?php if ($wpgmza_settings['wpgmza_settings_map_zoom'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                panControl: <?php if ($wpgmza_settings['wpgmza_settings_map_pan'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                mapTypeControl: <?php if ($wpgmza_settings['wpgmza_settings_map_type'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                streetViewControl: <?php if ($wpgmza_settings['wpgmza_settings_map_streetview'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                mapTypeId: google.maps.MapTypeId.<?php echo $wpgmza_map_type; ?>
              }
            this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
            this.bounds = new google.maps.LatLngBounds();

            google.maps.event.addListener(MYMAP.map, 'zoom_changed', function() {
                zoomLevel = MYMAP.map.getZoom();

                jQuery("#wpgmza_start_zoom").val(zoomLevel);

              });
            google.maps.event.addListener(MYMAP.map, 'center_changed', function() {
                var location = MYMAP.map.getCenter();
                jQuery("#wpgmza_start_location").val(location.lat()+","+location.lng());
                jQuery("#wpgmaps_save_reminder").show();
            });

            <?php if ($wpgmza_bicycle == "1") { ?>
            var bikeLayer = new google.maps.BicyclingLayer();
            bikeLayer.setMap(this.map);
            <?php } ?>
            <?php if ($wpgmza_traffic == "1") { ?>
            var trafficLayer = new google.maps.TrafficLayer();
            trafficLayer.setMap(this.map);
            <?php } ?>


            <?php if ($kml != "") { ?>
            var georssLayer = new google.maps.KmlLayer('<?php echo $kml; ?>');
            georssLayer.setMap(this.map);
            <?php } ?>
            }

            var infoWindow = new google.maps.InfoWindow();
            <?php
                $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                $wpgmza_settings_infowindow_width = $wpgmza_settings['wpgmza_settings_infowindow_width'];
                if (!$wpgmza_settings_infowindow_width || !isset($wpgmza_settings_infowindow_width)) { $wpgmza_settings_infowindow_width = "200"; }
            ?>
            infoWindow.setOptions({maxWidth:<?php echo $wpgmza_settings_infowindow_width; ?>});


            MYMAP.placeMarkers = function(filename,map_id) {
                marker_array = [];
                    jQuery.get(filename, function(xml){
                            jQuery(xml).find("marker").each(function(){
                                    var wpgmza_def_icon = '<?php echo $wpgmza_default_icon; ?>';
                                    var wpmgza_map_id = jQuery(this).find('map_id').text();

                                    if (wpmgza_map_id == map_id) {
                                        var wpmgza_title = jQuery(this).find('title').text();
                                        var wpmgza_address = jQuery(this).find('address').text();
                                        var wpmgza_mapicon = jQuery(this).find('icon').text();
                                        var wpmgza_image = jQuery(this).find('pic').text();
                                        var wpmgza_desc  = jQuery(this).find('desc').text();
                                        var wpmgza_anim  = jQuery(this).find('anim').text();
                                        var wpmgza_infoopen  = jQuery(this).find('infoopen').text();
                                        var wpmgza_linkd = jQuery(this).find('linkd').text();
                                        if (wpmgza_title != "") {
                                            wpmgza_title = wpmgza_title+'<br />';
                                        }
                                        if (wpmgza_image != "") {

                                    <?php
                                        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                        $wpgmza_image_height = $wpgmza_settings['wpgmza_settings_image_height'];
                                        $wpgmza_image_width = $wpgmza_settings['wpgmza_settings_image_width'];
                                        if (!$wpgmza_image_height || !isset($wpgmza_image_height)) { $wpgmza_image_height = "100"; }
                                        if (!$wpgmza_image_width || !isset($wpgmza_image_width)) { $wpgmza_image_width = "100"; }

                                        $wpgmza_use_timthumb = $wpgmza_settings['wpgmza_settings_use_timthumb'];
                                        if ($wpgmza_use_timthumb == "" || !isset($wpgmza_use_timthumb)) { ?>
                                                wpmgza_image = "<br /><img src='<?php echo wpgmaps_get_plugin_url(); ?>/timthumb.php?src="+wpmgza_image+"&h=<?php echo $wpgmza_image_height; ?>&w=<?php echo $wpgmza_image_width; ?>&zc=1' title='' alt='' style=\"float:right; margin:5px;\" />";
                                    <?php } else  { ?>
                                                wpmgza_image = "<br /><img src='"+wpmgza_image+"' class='wpgmza_map_image' style=\"float:right; margin:5px; height:<?php echo $wpgmza_image_height; ?>px; width:<?php echo $wpgmza_image_width; ?>px\" />";
                                    <?php } ?>

                                            } else { wpmgza_image = "" }
                                        if (wpmgza_linkd != "") {
                                                <?php
                                                    $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                                    $wpgmza_settings_infowindow_links = $wpgmza_settings['wpgmza_settings_infowindow_links'];
                                                    if ($wpgmza_settings_infowindow_links == "yes") { $wpgmza_settings_infowindow_links = "target='_BLANK'";  }
                                                ?>

                                                wpmgza_linkd = "<a href='"+wpmgza_linkd+"' <?php echo $wpgmza_settings_infowindow_links; ?> title='<?php _e("More details","wp-google-maps"); ?>'><?php _e("More details","wp-google-maps"); ?></a><br />";
                                            }
                                        if (wpmgza_mapicon == "" || !wpmgza_mapicon) { if (wpgmza_def_icon != "") { wpmgza_mapicon = '<?php echo $wpgmza_default_icon; ?>'; } }

                                        var lat = jQuery(this).find('lat').text();
                                        var lng = jQuery(this).find('lng').text();
                                        var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
                                        MYMAP.bounds.extend(point);
                                        if (wpmgza_anim == "1") {
                                        var marker = new google.maps.Marker({
                                                position: point,
                                                map: MYMAP.map,
                                                icon: wpmgza_mapicon,
                                                animation: google.maps.Animation.BOUNCE
                                        });
                                        }
                                        else if (wpmgza_anim == "2") {
                                            var marker = new google.maps.Marker({
                                                    position: point,
                                                    map: MYMAP.map,
                                                    icon: wpmgza_mapicon,
                                                    animation: google.maps.Animation.DROP
                                            });
                                        }
                                        else {
                                            var marker = new google.maps.Marker({
                                                    position: point,
                                                    map: MYMAP.map,
                                                    icon: wpmgza_mapicon
                                            });
                                        }
                                        //var html=''+wpmgza_image+'<strong>'+wpmgza_address+'</strong><br /><span style="font-size:12px;">'+wpmgza_desc+'<br />'+wpmgza_linkd+'</span>';
                                        <?php
                                                $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                                $wpgmza_settings_infowindow_address = $wpgmza_settings['wpgmza_settings_infowindow_address'];
                                                if ($wpgmza_settings_infowindow_address == "yes") {
                                        ?>
                                        wpmgza_address = "";
                                        <?php } ?>


                                        var html='<div id="wpgmza_markerbox">'
                                                +wpmgza_image+
                                                '<strong>'
                                                +wpmgza_title+
                                                '</strong>'+wpmgza_address+'<br /><span style="font-size:12px;">'
                                                +wpmgza_desc+
                                                '<br />'
                                                +wpmgza_linkd+
                                                ''
                                                +'</span></div>';
                                        if (wpmgza_infoopen == "1") {
                                            
                                            infoWindow.setContent(html);
                                            infoWindow.open(MYMAP.map, marker);
                                        }

                                        google.maps.event.addListener(marker, 'click', function() {
                                                infoWindow.close();
                                                infoWindow.setContent(html);
                                                infoWindow.open(MYMAP.map, marker);
                                                
//                                                MYMAP.map.setCenter(this.position);
                                        });
                                        //MYMAP.map.fitBounds(MYMAP.bounds);

                                    }

                        });
                });
            }

        </script>
<?php
}

}


function wpgmaps_upload_csv() {
    if (isset($_POST['wpgmza_uploadcsv_btn'])) {

        if (is_uploaded_file($_FILES['wpgmza_csvfile']['tmp_name'])) {
        
        global $wpdb;
        global $wpgmza_tblname;
        $handle = fopen($_FILES['wpgmza_csvfile']['tmp_name'], "r");
        $header = fgetcsv($handle);

        unset ($wpgmza_errormsg);
        if ($header[0] != "id") { $wpgmza_errormsg .= __("Header 1 should be 'id', not","wp-google-maps")." '$header[0]'<br />"; }
        if ($header[1] != "map_id") { $wpgmza_errormsg .= __("Header 2 should be 'map_id', not","wp-google-maps")." '$header[1]'<br />"; }
        if ($header[2] != "address") { $wpgmza_errormsg .= __("Header 3 should be 'address', not","wp-google-maps")." '$header[2]'<br />"; }
        if ($header[3] != "desc") { $wpgmza_errormsg .= __("Header 4 should be 'desc', not","wp-google-maps")." '$header[3]'<br />"; }
        if ($header[4] != "pic") { $wpgmza_errormsg .= __("Header 5 should be 'pic', not","wp-google-maps")." '$header[4]'<br />"; }
        if ($header[5] != "link") { $wpgmza_errormsg .= __("Header 6 should be 'link', not","wp-google-maps")." '$header[5]'<br />"; }
        if ($header[6] != "icon") { $wpgmza_errormsg .= __("Header 7 should be 'icon', not","wp-google-maps")." '$header[6]'<br />"; }
        if ($header[7] != "lat") { $wpgmza_errormsg .= __("Header 8 should be 'lat', not","wp-google-maps")." '$header[7]'<br />"; }
        if ($header[8] != "lng") { $wpgmza_errormsg .= __("Header 9 should be 'lng', not","wp-google-maps")." '$header[8]'<br />"; }
        if ($header[9] != "anim") { $wpgmza_errormsg .= __("Header 10 should be 'anim', not","wp-google-maps")." '$header[9]'<br />"; }
        if ($header[10] != "title") { $wpgmza_errormsg .= __("Header 11 should be 'title', not","wp-google-maps")." '$header[10]'<br />"; }
        if ($header[11] != "infoopen") { $wpgmza_errormsg .= __("Header 12 should be 'infoopen', not","wp-google-maps")." '$header[11]'<br />"; }
        if (isset($wpgmza_errormsg)) {
            echo "<div class='error below-h2'>".__("CSV import failed","wp-google-maps")."!<br /><br />$wpgmza_errormsg</div>";
            
        }
        else {
        while(! feof($handle)){
            if ($_POST['wpgmza_csvreplace'] == "Yes") { 
                $wpdb->show_errors();
                $wpdb->query("TRUNCATE TABLE $wpgmza_tblname");
                $wpdb->print_error();
            }
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $ra = $wpdb->insert( $wpgmza_tblname, array(
                    $header[1] => $data[1],
                    $header[2] => $data[2],
                    $header[3] => $data[3],
                    $header[4] => $data[4],
                    $header[5] => $data[5],
                    $header[6] => $data[6],
                    $header[7] => $data[7],
                    $header[8] => $data[8],
                    $header[9] => $data[9],
                    $header[10] => $data[10],
                    $header[11] => $data[11]
                    )
                );
             }

        }
        fclose($handle);
        echo "<div class='error below-h2'>".__("Your CSV file has been successfully imported","wp-google-maps")."</div>";
        }
    }
    }

}

function wpgmza_cURL_response_pro($action) {
    if (function_exists('curl_version')) {
        global $wpgmza_pro_version;
        global $wpgmza_pro_string;
        $request_url = "http://www.wpgmaps.com/api/rec.php?action=$action&dom=".$_SERVER['HTTP_HOST']."&ver=".$wpgmza_pro_version.$wpgmza_pro_string;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
    }

}

function wpgmza_pro_advanced_menu() {
    $wpgmza_csv = "<a href=\"".wpgmaps_get_plugin_url()."/csv.php\" title=\"".__("Download ALL marker data to a CSV file","wp-google-maps")."\">".__("Download ALL marker data to a CSV file","wp-google-maps")."</a>";

    echo "
        <div class=\"wrap\"><div id=\"icon-tools\" class=\"icon32 icon32-posts-post\"><br></div><h2>".__("Advanced Options","wp-google-maps")."</h2>
        <div style=\"display:block; overflow:auto; background-color:#FFFBCC; padding:10px; border:1px solid #E6DB55; margin-top:35px; margin-bottom:5px;\">
            $wpgmza_csv
            <br /><br /><strong>- ".__("OR","wp-google-maps")." -<br /><br /></strong><form enctype=\"multipart/form-data\" method=\"POST\">
                ".__("Upload CSV File","wp-google-maps").": <input name=\"wpgmza_csvfile\" type=\"file\" /><br />
                <input name=\"wpgmza_security\" type=\"hidden\" value=\"$wpgmza_post_nonce\" /><br />
                ".__("Replace existing data with data in file","wp-google-maps").": <input name=\"wpgmza_csvreplace\" type=\"checkbox\" value=\"Yes\" /><br />
                <input type=\"submit\" name=\"wpgmza_uploadcsv_btn\" value=\"".__("Upload File","wp-google-maps")."\" />
            </form>
        </div>



    ";
    

}

function wpgmaps_settings_page_pro() {


    echo"<div class=\"wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>".__("WP Google Map Settings","wp-google-maps")."</h2>";

    $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
    $wpgmza_settings_map_streetview = $wpgmza_settings['wpgmza_settings_map_streetview'];
    $wpgmza_settings_map_zoom = $wpgmza_settings['wpgmza_settings_map_zoom'];
    $wpgmza_settings_map_pan = $wpgmza_settings['wpgmza_settings_map_pan'];
    $wpgmza_settings_map_type = $wpgmza_settings['wpgmza_settings_map_type'];
    $wpgmza_settings_map_scroll = $wpgmza_settings['wpgmza_settings_map_scroll'];
    if ($wpgmza_settings_map_streetview == "yes") { $wpgmza_streetview_checked = "checked='checked'"; }
    if ($wpgmza_settings_map_zoom == "yes") { $wpgmza_zoom_checked = "checked='checked'"; }
    if ($wpgmza_settings_map_pan == "yes") { $wpgmza_pan_checked = "checked='checked'"; }
    if ($wpgmza_settings_map_type == "yes") { $wpgmza_type_checked = "checked='checked'"; }
    if ($wpgmza_settings_map_scroll == "yes") { $wpgmza_scroll_checked = "checked='checked'"; }

    if (function_exists(wpgmza_register_pro_version)) {
        $pro_settings1 = wpgmaps_settings_page_sub('infowindow');
        global $wpgmza_version;
        if (floatval($wpgmza_version) < 5) {
            $prov_msg = "<div class='error below-h1'><p>Please update your BASIC version of this plugin for all of these settings to work.</p></div>";
        }
    }

    echo "

            <form action='' method='post' id='wpgmaps_options'>
                <p>$prov_msg</p>

                $pro_settings1
                <h3>".__("Map Settings")."</h3>
                <table class='form-table'>
                    <tr>
                         <td width='200' valign='top'>".__("General Map Settings","wp-google-maps").":</td>
                         <td>
                                <input name='wpgmza_settings_map_streetview' type='checkbox' id='wpgmza_settings_map_streetview' value='yes' $wpgmza_streetview_checked /> ".__("Disable StreetView")."<br />
                                <input name='wpgmza_settings_map_zoom' type='checkbox' id='wpgmza_settings_map_zoom' value='yes' $wpgmza_zoom_checked /> ".__("Disable Zoom Controls")."<br />
                                <input name='wpgmza_settings_map_pan' type='checkbox' id='wpgmza_settings_map_pan' value='yes' $wpgmza_pan_checked /> ".__("Disable Pan Controls")."<br />
                                <input name='wpgmza_settings_map_type' type='checkbox' id='wpgmza_settings_map_type' value='yes' $wpgmza_type_checked /> ".__("Disable Map Type Controls")."<br />
                                <input name='wpgmza_settings_map_scroll' type='checkbox' id='wpgmza_settings_map_scroll' value='yes' $wpgmza_scroll_checked /> ".__("Disable Mouse Wheel Zoom")."<br />
                        </td>
                    </tr>
                </table>




                <p class='submit'><input type='submit' name='wpgmza_save_settings' class='button-primary' value='".__("Save Settings","wp-google-maps")." &raquo;' /></p>


            </form>
    ";

    echo "</div>";






}

function wpgmaps_settings_page_sub($section) {

    if ($section == "infowindow") {
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
        $wpgmza_set_img_width = $wpgmza_settings['wpgmza_settings_image_width'];
        $wpgmza_set_img_height = $wpgmza_settings['wpgmza_settings_image_height'];
        $wpgmza_set_use_timthumb = $wpgmza_settings['wpgmza_settings_use_timthumb'];
        $wpgmza_settings_infowindow_links = $wpgmza_settings['wpgmza_settings_infowindow_links'];
        $wpgmza_settings_infowindow_address = $wpgmza_settings['wpgmza_settings_infowindow_address'];

        $wpgmza_settings_infowindow_width = $wpgmza_settings['wpgmza_settings_infowindow_width'];

        if ($wpgmza_set_use_timthumb == "yes") { $wpgmza_timchecked = "checked='checked'"; }
        if (!isset($wpgmza_set_img_width) || $wpgmza_set_img_width == "") { $wpgmza_set_img_width = "100"; }
        if (!isset($wpgmza_set_img_height) || $wpgmza_set_img_height == "" ) { $wpgmza_set_img_height = "100"; }
        if (!isset($wpgmza_settings_infowindow_width) || $wpgmza_settings_infowindow_width == "") { $wpgmza_settings_infowindow_width = "200"; }
        if ($wpgmza_settings_infowindow_links == "yes") { $wpgmza_linkschecked = "checked='checked'"; }
        if ($wpgmza_settings_infowindow_address == "yes") { $wpgmza_addresschecked = "checked='checked'"; }

        return "
                <h3>".__("InfoWindow Settings")."</h3>
                <table class='form-table'>
                    <tr>
                         <td width='200'>".__("Default Image Width","wp-google-maps").":</td>
                         <td><input id='wpgmza_settings_image_width' name='wpgmza_settings_image_width' type='text' size='4' maxlength='4' value='$wpgmza_set_img_width' /> px </td>
                    </tr>
                    <tr>
                         <td>".__("Default Image Height","wp-google-maps").":</td>
                         <td><input id='wpgmza_settings_image_height' name='wpgmza_settings_image_height' type='text' size='4' maxlength='4' value='$wpgmza_set_img_height' /> px </td>
                    </tr>
                    <tr>
                         <td>".__("Image Thumbnails","wp-google-maps").":</td>
                         <td>
                                <input name='wpgmza_settings_use_timthumb' type='checkbox' id='wpgmza_settings_use_timthumb' value='yes' $wpgmza_timchecked /> ".__("Do not use TimThumb")." <em>
                                ".__("(Tick this if you are having problems viewing your thumbnail images)")."</em>
                        </td>
                    </tr>
                    <tr>
                         <td>".__("Max InfoWindow Width","wp-google-maps").":</td>
                         <td><input id='wpgmza_settings_infowindow_width' name='wpgmza_settings_infowindow_width' type='text' size='4' maxlength='4' value='$wpgmza_settings_infowindow_width' /> px <em>".__("(Minimum: 200px)")."</em></td>
                    </tr>
                    <tr>
                         <td>".__("Other settings","wp-google-maps").":</td>
                         <td>
                                <input name='wpgmza_settings_infowindow_links' type='checkbox' id='wpgmza_settings_infowindow_links' value='yes' $wpgmza_linkschecked /> ".__("Open links in a new window")." <em>
                                ".__("(Tick this if you want to open your links in a new window)")."</em>
                                <br /><input name='wpgmza_settings_infowindow_address' type='checkbox' id='wpgmza_settings_infowindow_address' value='yes' $wpgmza_addresschecked /> ".__("Hide the address field")."<br />
                        </td>
                    </tr>

                </table>
                <br /><br />
        ";


    }
}
function wpgmza_version_check() {
  global $wpgmza_version;
  $wpgmza_vc = floatval($wpgmza_version);
  if ($wpgmza_vc < 5.01) {
      echo "<div class='error below-h1'><big><Br />Please <a href=\"plugins.php\">update</a> your WP Google Maps (basic) version to 5.01     or newer in order to make use of the new functionality.<br /><br />
          Your version: $wpgmza_version<br /><Br /></big></div>";
  }
      
}

