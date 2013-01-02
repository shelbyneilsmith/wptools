<?php
/*
Plugin Name: WP Google Maps
Plugin URI: http://www.wpgmaps.com
Description: The easiest to use Google Maps plugin! Create custom Google Maps with high quality markers containing locations, descriptions, images and links. Add your customized map to your WordPress posts and/or pages quickly and easily with the supplied shortcode. No fuss.
Version: 5.02
Author: WP Google Maps
Author URI: http://www.wpgmaps.com
*/

error_reporting(E_ERROR);
global $wpgmza_version;
global $wpgmza_p_version;
global $wpgmza_t;
global $wpgmza_tblname;
global $wpgmza_tblname_maps;
global $wpdb;
global $wpgmza_p;
global $wpgmza_g;
global $short_code_active;
global $wpgmza_current_map_id;
global $debug;
global $debug_step;
global $debug_start;
$debug = false;
$debug_step = 0;
$wpgmza_p = false;
$wpgmza_g = false;
$wpgmza_tblname = $wpdb->prefix . "wpgmza";
$wpgmza_tblname_maps = $wpdb->prefix . "wpgmza_maps";
$wpgmza_version = "5.02";
$wpgmza_p_version = "5.02";
$wpgmza_t = "basic";

add_action('admin_head', 'wpgmaps_head');
add_action('admin_footer', 'wpgmaps_reload_map_on_post');
register_activation_hook( __FILE__, 'wpgmaps_activate' );
register_deactivation_hook( __FILE__, 'wpgmaps_deactivate' );
add_action('init', 'wpgmaps_init');
add_action('admin_menu', 'wpgmaps_admin_menu');
add_filter('widget_text', 'do_shortcode');

$debug_start = (float) array_sum(explode(' ',microtime()));




function wpgmaps_activate() {
    global $wpdb;
    global $wpgmza_version;
    $table_name = $wpdb->prefix . "wpgmza";
    $table_name_maps = $wpdb->prefix . "wpgmza_maps";

    wpgmaps_debugger("activate_start");


    wpgmaps_handle_db();

    $wpgmza_data = get_option("WPGMZA");
    if (!$wpgmza_data) {
        // load first map as an example map (i.e. if the user has not installed this plugin before, this must run
        $res_maps = $wpdb->get_results("SELECT * FROM $table_name_maps");
        $wpdb->show_errors();
        if (!$res_maps) { $rows_affected = $wpdb->insert( $table_name_maps, array(
                                                                    "map_title" => "Your first map",
                                                                    "map_start_lat" => "51.5081290",
                                                                    "map_start_lng" => "-0.1280050",
                                                                    "map_width" => "600",
                                                                    "map_height" => "400",
                                                                    "map_width_type" => "px",
                                                                    "map_height_type" => "px",
                                                                    "map_start_location" => "51.5081290,-0.1280050",
                                                                    "map_start_zoom" => "5",
                                                                    "directions_enabled" => '1',
                                                                    "default_marker" => "0",
                                                                    "alignment" => "0",
                                                                    "styling_enabled" => "0",
                                                                    "styling_json" => "",
                                                                    "active" => "0",
                                                                    "type" => "1",
                                                                    "bicycle" => "2",
                                                                    "traffic" => "2",
                                                                    "dbox" => "1",
                                                                    "dbox_width" => "250",
                                                                    "listmarkers" => "0",
                                                                    "listmarkers_advanced" => "0",
                                                                    "ugm_enabled" => "0",
                                                                    "mass_marker_support" => "1")
                                                                    ); }
    } else {
        $rows_affected = $wpdb->insert( $table_name_maps, array(    "map_start_lat" => "".$wpgmza_data['map_start_lat']."",
                                                                    "map_start_lng" => "".$wpgmza_data['map_start_lng']."",
                                                                    "map_title" => "Your Map",
                                                                    "map_width" => "".$wpgmza_data['map_width']."",
                                                                    "map_height" => "".$wpgmza_data['map_height']."",
                                                                    "map_width_type" => "".$wpgmza_data['map_width_type']."",
                                                                    "map_height_type" => "".$wpgmza_data['map_height_type']."",
                                                                    "map_start_location" => "".$wpgmza_data['map_start_lat'].",".$wpgmza_data['map_start_lng']."",
                                                                    "map_start_zoom" => "".$wpgmza_data['map_start_zoom']."",
                                                                    "default_marker" => "".$wpgmza_data['map_default_marker']."",
                                                                    "type" => "".$wpgmza_data['map_type']."",
                                                                    "alignment" => "".$wpgmza_data['map_align']."",
                                                                    "styling_enabled" => "0",
                                                                    "styling_json" => "",
                                                                    "active" => "0",
                                                                    "directions_enabled" => "".$wpgmza_data['directions_enabled']."",
                                                                    "bicycle" => "".$wpgmza_data['bicycle']."",
                                                                    "traffic" => "".$wpgmza_data['traffic']."",
                                                                    "dbox" => "".$wpgmza_data['dbox']."",
                                                                    "dbox_width" => "".$wpgmza_data['dbox_width']."",
                                                                    "listmarkers" => "".$wpgmza_data['listmarkers']."",
                                                                    "listmarkers_advanced" => "".$wpgmza_data['listmarkers_advanced']."",
                                                                    "ugm_enabled" => "".$wpgmza_data['ugm_enabled']."",
                                                                    "mass_marker_support" => "1"

                                                                ) );
        delete_option("WPGMZA");

    }
    // load first marker as an example marker
    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE `map_id` = '1'");
    if (!$results) { $rows_affected = $wpdb->insert( $table_name, array( 'map_id' => '1', 'address' => 'London', 'lat' => '51.5081290', 'lng' => '-0.1280050' ) ); }




    wpgmza_cURL_response("activate");
    //check to see if you have write permissions to the plugin folder (version 2.2)
    if (!wpgmaps_check_permissions()) { wpgmaps_permission_warning(); } else { wpgmaps_update_all_xml_file(); }
    wpgmaps_debugger("activate_end");
}
function wpgmaps_deactivate() { wpgmza_cURL_response("deactivate"); }
function wpgmaps_init() {
    wp_enqueue_script("jquery");
    $plugin_dir = basename(dirname(__FILE__))."/languages/";
    load_plugin_textdomain( 'wp-google-maps', false, $plugin_dir );
    }

function wpgmaps_reload_map_on_post() {
    wpgmaps_debugger("reload_map_start");
    if (isset($_POST['wpgmza_savemap'])){
        
        $res = wpgmza_get_map_data($_GET['map_id']);
        $wpgmza_lat = $res->map_start_lat;
        $wpgmza_lng = $res->map_start_lng;
        $wpgmza_width = $res->map_width;
        $wpgmza_height = $res->map_height;
        $wpgmza_width_type = $res->map_width_type;
        $wpgmza_height_type = $res->map_height_type;
        $wpgmza_map_type = $res->type;
        if (!$wpgmza_map_type || $wpgmza_map_type == "" || $wpgmza_map_type == "1") { $wpgmza_map_type = "ROADMAP"; }
        else if ($wpgmza_map_type == "2") { $wpgmza_map_type = "SATELLITE"; }
        else if ($wpgmza_map_type == "3") { $wpgmza_map_type = "HYBRID"; }
        else if ($wpgmza_map_type == "4") { $wpgmza_map_type = "TERRAIN"; }
        else { $wpgmza_map_type = "ROADMAP"; }
        $start_zoom = $res->map_start_zoom;
        if ($start_zoom < 1 || !$start_zoom) { $start_zoom = 5; }
        if (!$wpgmza_lat || !$wpgmza_lng) { $wpgmza_lat = "51.5081290"; $wpgmza_lng = "-0.1280050"; }

        ?>
        <script type="text/javascript" >
        jQuery(function() {
            jQuery("#wpgmza_map").css({
		height:'<?php echo $wpgmza_height; ?><?php echo $wpgmza_height_type; ?>',
		width:'<?php echo $wpgmza_width; ?><?php echo $wpgmza_width_type; ?>'

            });
            var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat; ?>,<?php echo $wpgmza_lng; ?>);
            MYMAP.init('#wpgmza_map', myLatLng, <?php echo $start_zoom; ?>);
            UniqueCode=Math.round(Math.random()*10010);
            MYMAP.placeMarkers('<?php echo wpgmaps_get_marker_url($_GET['map_id']); ?>?u='+UniqueCode,<?php echo $_GET['map_id']; ?>);

        });
        </script>
        <?php
    }
    wpgmaps_debugger("reload_map_end");


}
function wpgmaps_get_marker_url($mapid = false) {

    if (!$mapid) {
        $mapid = $_POST['map_id'];
    }
    if (!$mapid) {
        $mapid = $_GET['map_id'];
    }
    if (!$mapid) {
        global $wpgmza_current_map_id;
        $mapid = $wpgmza_current_map_id;
    }

    if (is_multisite()) {
        global $blog_id;
        return wpgmaps_get_plugin_url()."/".$blog_id."-".$mapid."markers.xml";
    } else {
        if (function_exists(wpgmza_register_pro_version)) {
            $prov = get_option("WPGMZA_PRO");
            $wpgmza_pro_version = $prov['version'];

            return wpgmaps_get_plugin_url()."/".$mapid."markers.xml";
        } else {
            return wpgmaps_get_plugin_url()."/".$mapid."markers.xml";
        }

    }



}


function wpgmaps_admin_edit_marker_javascript() {
    wpgmaps_debugger("edit_marker_start");

    $res = wpgmza_get_marker_data($_GET['id']);
        $wpgmza_lat = $res->lat;
        $wpgmza_lng = $res->lng;
        $wpgmza_map_type = "ROADMAP";
        
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");

        ?>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <link rel='stylesheet' id='wpgooglemaps-css'  href='<?php echo wpgmaps_get_plugin_url(); ?>/css/wpgmza_style.css' type='text/css' media='all' />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo wpgmaps_get_plugin_url(); ?>/css/data_table.css" />
        <script type="text/javascript" src="<?php echo wpgmaps_get_plugin_url(); ?>/js/jquery.dataTables.js"></script>
        <script type="text/javascript" >
            jQuery(document).ready(function(){
                    function wpgmza_InitMap() {
                        var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat; ?>,<?php echo $wpgmza_lng; ?>);
                        MYMAP.init('#wpgmza_map', myLatLng, 15);
                    }
                    jQuery("#wpgmza_map").css({
                        height:400,
                        width:400
                    });
                    wpgmza_InitMap();
            });

            var MYMAP = {
                map: null,
                bounds: null
            }
            MYMAP.init = function(selector, latLng, zoom) {
                  var myOptions = {
                    zoom:zoom,
                    center: latLng,
                    zoomControl: <?php if ($wpgmza_settings['wpgmza_settings_map_zoom'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                    panControl: <?php if ($wpgmza_settings['wpgmza_settings_map_pan'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                    mapTypeControl: <?php if ($wpgmza_settings['wpgmza_settings_map_type'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                    streetViewControl: <?php if ($wpgmza_settings['wpgmza_settings_map_streetview'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                    mapTypeId: google.maps.MapTypeId.<?php echo $wpgmza_map_type; ?>
                  }
                this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
                this.bounds = new google.maps.LatLngBounds();

                updateMarkerPosition(latLng);


                var marker = new google.maps.Marker({
                    position: latLng,
                    map: this.map,
                    draggable: true
                });
                google.maps.event.addListener(marker, 'drag', function() {
                    updateMarkerPosition(marker.getPosition());
                });
            }
            function updateMarkerPosition(latLng) {
                jQuery("#wpgmaps_marker_lat").val(latLng.lat());
                jQuery("#wpgmaps_marker_lng").val(latLng.lng());
            }


        </script>
        <?php

    wpgmaps_debugger("edit_marker_end");

}

function wpgmaps_admin_javascript_basic() {
    global $wpdb;
    global $wpgmza_tblname_maps;
    $ajax_nonce = wp_create_nonce("wpgmza");
    wpgmaps_debugger("admin_js_basic_start");

    if (is_admin() && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "edit_marker") {
        wpgmaps_admin_edit_marker_javascript();

    }

    else if (is_admin() && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "edit") {

        if ($debug) { echo ""; }

        if (!$_GET['map_id']) { break; }
        wpgmaps_update_xml_file($_GET['map_id']);
        //$wpgmza_data = get_option('WPGMZA');

        $res = wpgmza_get_map_data($_GET['map_id']);
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
        
        $wpgmza_lat = $res->map_start_lat;
        $wpgmza_lng = $res->map_start_lng;
        $wpgmza_width = $res->map_width;
        $wpgmza_height = $res->map_height;
        $wpgmza_width_type = $res->map_width_type;
        $wpgmza_height_type = $res->map_height_type;
        $wpgmza_map_type = $res->type;
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
    <link rel='stylesheet' id='wpgooglemaps-css'  href='<?php echo wpgmaps_get_plugin_url(); ?>/css/wpgmza_style.css' type='text/css' media='all' />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo wpgmaps_get_plugin_url(); ?>/css/data_table.css" />
    <script type="text/javascript" src="<?php echo wpgmaps_get_plugin_url(); ?>/js/jquery.dataTables.js"></script>
    <script type="text/javascript" >
    jQuery(function() {


                jQuery(document).ready(function(){
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
                        height:'<?php echo $wpgmza_height; ?><?php echo $wpgmza_height_type; ?>',
                        width:'<?php echo $wpgmza_width; ?><?php echo $wpgmza_width_type; ?>'

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
                                //jQuery("#wpgmza_tr_"+cur_id).css("display","none");
                        });


                    });


                    jQuery(".wpgmza_edit_btn").live("click", function() {
                        var cur_id = jQuery(this).attr("id");
                        var wpgmza_edit_address = jQuery("#wpgmza_hid_marker_address_"+cur_id).val();
                        var wpgmza_edit_title = jQuery("#wpgmza_hid_marker_title_"+cur_id).val();
                        jQuery("#wpgmza_edit_id").val(cur_id);
                        jQuery("#wpgmza_add_address").val(wpgmza_edit_address);
                        jQuery("#wpgmza_add_title").val(wpgmza_edit_title);
                        jQuery("#wpgmza_addmarker_div").hide();
                        jQuery("#wpgmza_editmarker_div").show();
                    });



                    jQuery("#wpgmza_addmarker").click(function(){
                        jQuery("#wpgmza_addmarker").hide();
                        jQuery("#wpgmza_addmarker_loading").show();

                        var wpgm_address = "0";
                        var wpgm_gps = "0";
                        var wpgm_map_id = "0";
                        if (document.getElementsByName("wpgmza_add_address").length > 0) { wpgm_address = jQuery("#wpgmza_add_address").val(); }
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }


                        geocoder.geocode( { 'address': wpgm_address, 'language': 'russian'}, function(results, status) {
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
                                    address: wpgm_address,
                                    lat: wpgm_lat,
                                    lng: wpgm_lng
                                };

                                jQuery.post(ajaxurl, data, function(response) {
                                        wpgmza_InitMap();
                                        jQuery("#wpgmza_marker_holder").html(response);
                                        jQuery("#wpgmza_addmarker").show();
                                        jQuery("#wpgmza_addmarker_loading").hide();
                                        wpgmza_reinitialisetbl();
                                });

                            } else {
                                alert("Geocode was not successful for the following reason: " + status);
                            }
                        });


                    });


                    jQuery("#wpgmza_editmarker").click(function(){

                        jQuery("#wpgmza_editmarker_div").hide();
                        jQuery("#wpgmza_editmarker_loading").show();


                        var wpgm_edit_id;
                        wpgm_edit_id = parseInt(jQuery("#wpgmza_edit_id").val());
                        var wpgm_address = "0";
                        var wpgm_map_id = "0";
                        var wpgm_gps = "0";
                        if (document.getElementsByName("wpgmza_add_address").length > 0) { wpgm_address = jQuery("#wpgmza_add_address").val(); }
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
                                    address: wpgm_address,
                                    lat: wpgm_lat,
                                    lng: wpgm_lng
                                };

                                jQuery.post(ajaxurl, data, function(response) {
                                    wpgmza_InitMap();
                                    jQuery("#wpgmza_add_address").val("");
                                    jQuery("#wpgmza_add_title").val("");
                                    jQuery("#wpgmza_marker_holder").html(response);
                                    jQuery("#wpgmza_addmarker_div").show();
                                    jQuery("#wpgmza_editmarker_loading").hide();
                                    jQuery("#wpgmza_edit_id").val("");
                                    wpgmza_reinitialisetbl();
                                });

                            } else {
                                alert("Geocode was not successful for the following reason: " + status);
                            }
                        });



                    });
            });

            });



            var MYMAP = {
                map: null,
                bounds: null
            }
            MYMAP.init = function(selector, latLng, zoom) {
                  var myOptions = {
                    zoom:zoom,
                    center: latLng,
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
                if (zoomLevel == 0) {
                  MYMAP.map.setZoom(10);
                }
                });
                google.maps.event.addListener(MYMAP.map, 'center_changed', function() {
                    var location = MYMAP.map.getCenter();
                    jQuery("#wpgmza_start_location").val(location.lat()+","+location.lng());
                    jQuery("#wpgmaps_save_reminder").show();
                });

                google.maps.event.addListener(MYMAP.map, 'click', function() {
                        infoWindow.close();
                });


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
                                    var wpmgza_map_id = jQuery(this).find('map_id').text();
                                    if (wpmgza_map_id == map_id) {
                                        var wpmgza_address = jQuery(this).find('address').text();
                                        var lat = jQuery(this).find('lat').text();
                                        var lng = jQuery(this).find('lng').text();
                                        var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
                                        MYMAP.bounds.extend(point);
                                        var marker = new google.maps.Marker({
                                                position: point,
                                                map: MYMAP.map


                                        });

                                        var html='<strong>'+wpmgza_address+'</strong>';

                                        google.maps.event.addListener(marker, 'click', function() {
                                                infoWindow.close();
                                                infoWindow.setContent(html);
                                                infoWindow.open(MYMAP.map, marker);
                                                //MYMAP.map.setCenter(this.position);

                                        });

                                    }

                            });
                    });
            }






        </script>
<?php
}
    wpgmaps_debugger("admin_js_basic_end");

}


function wpgmaps_user_javascript_basic() {
    global $short_code_active;
    global $wpgmza_current_map_id;
    wpgmaps_debugger("u_js_b_start");

    if ($short_code_active) {

        $ajax_nonce = wp_create_nonce("wpgmza");

        
        $res = wpgmza_get_map_data($wpgmza_current_map_id);
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");

        $wpgmza_lat = $res->map_start_lat;
        $wpgmza_lng = $res->map_start_lng;
        $wpgmza_width = $res->map_width;
        $wpgmza_height = $res->map_height;
        $wpgmza_width_type = $res->map_width_type;
        $wpgmza_height_type = $res->map_height_type;
        $wpgmza_map_type = $res->type;
        if (!$wpgmza_map_type || $wpgmza_map_type == "" || $wpgmza_map_type == "1") { $wpgmza_map_type = "ROADMAP"; }
        else if ($wpgmza_map_type == "2") { $wpgmza_map_type = "SATELLITE"; }
        else if ($wpgmza_map_type == "3") { $wpgmza_map_type = "HYBRID"; }
        else if ($wpgmza_map_type == "4") { $wpgmza_map_type = "TERRAIN"; }
        else { $wpgmza_map_type = "ROADMAP"; }
        $start_zoom = $res->map_start_zoom;
        if ($start_zoom < 1 || !$start_zoom) { $start_zoom = 5; }
        if (!$wpgmza_lat || !$wpgmza_lng) { $wpgmza_lat = "51.5081290"; $wpgmza_lng = "-0.1280050"; }

        ?>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript" >


        jQuery(function() {


        jQuery(document).ready(function(){


            jQuery("#wpgmza_map").css({
                height:'<?php echo $wpgmza_height; ?><?php echo $wpgmza_height_type; ?>',
                width:'<?php echo $wpgmza_width; ?><?php echo $wpgmza_width_type; ?>'

            });
            var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat; ?>,<?php echo $wpgmza_lng; ?>);
            MYMAP.init('#wpgmza_map', myLatLng, <?php echo $start_zoom; ?>);
            UniqueCode=Math.round(Math.random()*10000);
            MYMAP.placeMarkers('<?php echo wpgmaps_get_marker_url($wpgmza_current_map_id); ?>?u='+UniqueCode,<?php echo $wpgmza_current_map_id; ?>);


            });

        });
        var MYMAP = {
            map: null,
            bounds: null
        }
        MYMAP.init = function(selector, latLng, zoom) {
          var myOptions = {
            zoom:zoom,
            center: latLng,
            zoomControl: <?php if ($wpgmza_settings['wpgmza_settings_map_zoom'] == "yes") { echo "false"; } else { echo "true"; } ?>,
            panControl: <?php if ($wpgmza_settings['wpgmza_settings_map_pan'] == "yes") { echo "false"; } else { echo "true"; } ?>,
            mapTypeControl: <?php if ($wpgmza_settings['wpgmza_settings_map_type'] == "yes") { echo "false"; } else { echo "true"; } ?>,
            streetViewControl: <?php if ($wpgmza_settings['wpgmza_settings_map_streetview'] == "yes") { echo "false"; } else { echo "true"; } ?>,
            mapTypeId: google.maps.MapTypeId.<?php echo $wpgmza_map_type; ?>
          }

          this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
          this.bounds = new google.maps.LatLngBounds();

            google.maps.event.addListener(MYMAP.map, 'click', function() {
                    infoWindow.close();
            });


        }
            var infoWindow = new google.maps.InfoWindow();
            <?php
                $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                $wpgmza_settings_infowindow_width = $wpgmza_settings['wpgmza_settings_infowindow_width'];
                if (!$wpgmza_settings_infowindow_width || !isset($wpgmza_settings_infowindow_width)) { $wpgmza_settings_infowindow_width = "200"; }
            ?>
            infoWindow.setOptions({maxWidth:<?php echo $wpgmza_settings_infowindow_width; ?>});

            google.maps.event.addDomListener(window, 'resize', function() {
            var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat; ?>,<?php echo $wpgmza_lng; ?>);
            MYMAP.map.setCenter(myLatLng);
            });
        MYMAP.placeMarkers = function(filename,map_id) {

            jQuery.get(filename, function(xml){
                    jQuery(xml).find("marker").each(function(){
                                    var wpmgza_map_id = jQuery(this).find('map_id').text();

                                    if (wpmgza_map_id == map_id) {
                                        var wpmgza_address = jQuery(this).find('address').text();
                                        var lat = jQuery(this).find('lat').text();
                                        var lng = jQuery(this).find('lng').text();

                                        var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
                                        MYMAP.bounds.extend(point);
                                        var marker = new google.maps.Marker({
                                                position: point,
                                                map: MYMAP.map
                                            });
                                        var html='<strong>'+wpmgza_address+'</strong>';

                                        google.maps.event.addListener(marker, 'click', function(evt) {
                                                infoWindow.close();
                                                infoWindow.setContent(html);
                                                infoWindow.open(MYMAP.map, marker);
                                                //MYMAP.map.setCenter(this.position);

                                        });
                                    }
                    });
            });
    }

        </script>
<?php
    }
    wpgmaps_debugger("u_js_b_end");
}




function wpgmaps_update_xml_file($mapid = false) {

//    wpgmaps_debugger("update_xml_start");

    if (!$mapid) {
        $mapid = $_POST['map_id'];
    }
    if (!$mapid) {
        $mapid = $_GET['map_id'];
    }
    global $wpdb;
    $dom = new DOMDocument('1.0');
    $dom->formatOutput = true;
    $channel_main = $dom->createElement('markers');
    $channel = $dom->appendChild($channel_main);
    $table_name = $wpdb->prefix . "wpgmza";


    // PREVIOUS VERSION HANDLING
    if (function_exists(wpgmza_register_pro_version)) {
            $prov = get_option("WPGMZA_PRO");
            $wpgmza_pro_version = $prov['version'];
                $results = $wpdb->get_results(
                    "
                    SELECT *
                    FROM $table_name
                    WHERE `map_id` = '$mapid'

                    "
                );
        }
        else {
            $results = $wpdb->get_results(
                "
                SELECT *
                FROM $table_name
                WHERE `map_id` = '$mapid'

                "
            );
        }




    foreach ( $results as $result )
    {
        $id = $result->id;
        $address = stripslashes($result->address);
        $description = stripslashes($result->desc);
        $pic = $result->pic;
        if (!$pic) { $pic = ""; }
        $icon = $result->icon;
        if (!$icon) { $icon = ""; }
        $link_url = $result->link;
        if ($link_url) {  } else { $link_url = ""; }
        $lat = $result->lat;
        $lng = $result->lng;
        $anim = $result->anim;
        $infoopen = $result->infoopen;
        $mtitle = stripslashes($result->title);
        $map_id = $result->map_id;

        $channel = $channel_main->appendChild($dom->createElement('marker'));
        $title = $channel->appendChild($dom->createElement('marker_id'));
        $title->appendChild($dom->CreateTextNode($id));
        $title = $channel->appendChild($dom->createElement('map_id'));
        $title->appendChild($dom->CreateTextNode($map_id));
        $title = $channel->appendChild($dom->createElement('title'));
        $title->appendChild($dom->CreateTextNode($mtitle));
        $title = $channel->appendChild($dom->createElement('address'));
        $title->appendChild($dom->CreateTextNode($address));
        $desc = $channel->appendChild($dom->createElement('desc'));
        $desc->appendChild($dom->CreateTextNode($description));
        $desc = $channel->appendChild($dom->createElement('pic'));
        $desc->appendChild($dom->CreateTextNode($pic));
        $desc = $channel->appendChild($dom->createElement('icon'));
        $desc->appendChild($dom->CreateTextNode($icon));
        $desc = $channel->appendChild($dom->createElement('linkd'));
        $desc->appendChild($dom->CreateTextNode($link_url));
        $bd = $channel->appendChild($dom->createElement('lat'));
        $bd->appendChild($dom->CreateTextNode($lat));
        $bd = $channel->appendChild($dom->createElement('lng'));
        $bd->appendChild($dom->CreateTextNode($lng));
        $bd = $channel->appendChild($dom->createElement('anim'));
        $bd->appendChild($dom->CreateTextNode($anim));
        $bd = $channel->appendChild($dom->createElement('infoopen'));
        $bd->appendChild($dom->CreateTextNode($infoopen));


    }
    if (is_multisite()) {
        global $blog_id;
        @$dom->save(WP_PLUGIN_DIR.'/'.plugin_basename(dirname(__FILE__)).'/'.$blog_id.'-'.$mapid.'markers.xml');
    } else {

        // PREVIOUS VERSION HANDLING
        if (function_exists(wpgmza_register_pro_version)) {
            $prov = get_option("WPGMZA_PRO");
            $wpgmza_pro_version = $prov['version'];
            @$dom->save(WP_PLUGIN_DIR.'/'.plugin_basename(dirname(__FILE__)).'/'.$mapid.'markers.xml');
        }
        else {
            @$dom->save(WP_PLUGIN_DIR.'/'.plugin_basename(dirname(__FILE__)).'/'.$mapid.'markers.xml');
        }

    }
    //wpgmaps_debugger("update_xml_end");
}



function wpgmaps_update_all_xml_file() {
    global $wpdb;

    $table_name = $wpdb->prefix . "wpgmza_maps";
    $results = $wpdb->get_results("SELECT `id` FROM $table_name WHERE `active` = 0");

    foreach ( $results as $result ) {
        $map_id = $result->id;
        wpgmaps_update_xml_file($map_id);
    }
}



function wpgmaps_action_callback_basic() {
        global $wpdb;
        global $wpgmza_tblname;
        global $wpgmza_p;
        $check = check_ajax_referer( 'wpgmza', 'security' );
        $table_name = $wpdb->prefix . "wpgmza";

        if ($check == 1) {

            if ($_POST['action'] == "add_marker") {
                  $rows_affected = $wpdb->insert( $table_name, array( 'map_id' => $_POST['map_id'], 'address' => $_POST['address'], 'lat' => $_POST['lat'], 'lng' => $_POST['lng'] ) );
                  wpgmaps_update_xml_file($_POST['map_id']);
                  echo wpgmza_return_marker_list($_POST['map_id']);
           }
            if ($_POST['action'] == "edit_marker") {
                  $cur_id = $_POST['edit_id'];
                  $rows_affected = $wpdb->query( $wpdb->prepare( "UPDATE $table_name SET address = %s, lat = %f, lng = %f WHERE id = %d", $_POST['address'], $_POST['lat'], $_POST['lng'], $cur_id) );
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

function wpgmaps_load_maps_api() {
    wpgmaps_debugger("load_maps_api_start");
    wp_enqueue_script('google-maps' , 'http://maps.google.com/maps/api/js?sensor=true' , false , '3');
    wpgmaps_debugger("load_maps_api_end");
}

function wpgmaps_tag_basic( $atts ) {
        wpgmaps_debugger("tag_basic_start");
        global $wpgmza_current_map_id;
        extract( shortcode_atts( array(
		'id' => '1'
	), $atts ) );
        global $short_code_active;
        $wpgmza_current_map_id = $atts['id'];

        $res = wpgmza_get_map_data($atts['id']);
        $short_code_active = true;
        //$wpgmza_data = get_option('WPGMZA');
        $map_align = $res->alignment;


        $map_width_type = $res->map_width_type;
        $map_height_type = $res->map_height_type;

        if (!isset($map_width_type)) { $map_width_type == "px"; }
        if (!isset($map_height_type)) { $map_height_type == "px"; }


        if ($map_width_type == "%" && intval($res->map_width) > 100) { $res->map_width = 100; }
        if ($map_height_type == "%" && intval($res->map_height) > 100) { $res->map_height = 100; }

        if (!$map_align || $map_align == "" || $map_align == "1") { $map_align = "float:left;"; }
        else if ($map_align == "2") { $map_align = "margin-left:auto !important; margin-right:auto; !important; align:center;"; }
        else if ($map_align == "3") { $map_align = "float:right;"; }
        else if ($map_align == "4") { $map_align = ""; }
        $map_style = "style=\"display:block; overflow:auto; width:".$res->map_width."".$map_width_type."; height:".$res->map_height."".$map_height_type."; $map_align\"";


        $ret_msg .= "
            <style>
            #wpgmza_map img { max-width:none !important; }
            </style>
            <div id=\"wpgmza_map\" $map_style>&nbsp;</div>


        ";
        return $ret_msg;
        wpgmaps_debugger("tag_basic_end");
}

function wpgmaps_get_plugin_url() {
    if ( !function_exists('plugins_url') )
        return get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));
        return plugins_url(plugin_basename(dirname(__FILE__)));
}

function wpgmaps_head() {
    wpgmaps_debugger("head_start");

    global $wpgmza_tblname_maps;




    if (isset($_POST['wpgmza_savemap'])){
        global $wpdb;

        //var_dump($_POST);

        $map_id = attribute_escape($_POST['wpgmza_id']);
        $map_title = attribute_escape($_POST['wpgmza_title']);
        $map_height = attribute_escape($_POST['wpgmza_height']);
        $map_width = attribute_escape($_POST['wpgmza_width']);
        $map_width_type = attribute_escape($_POST['wpgmza_map_width_type']);
        $map_height_type = attribute_escape($_POST['wpgmza_map_height_type']);
        $map_start_location = attribute_escape($_POST['wpgmza_start_location']);
        $map_start_zoom = intval($_POST['wpgmza_start_zoom']);
        $type = intval($_POST['wpgmza_map_type']);
        $alignment = intval($_POST['wpgmza_map_align']);
        $directions_enabled = intval($_POST['wpgmza_directions']);
        $bicycle_enabled = intval($_POST['wpgmza_bicycle']);
        $traffic_enabled = intval($_POST['wpgmza_traffic']);
        $dbox = intval($_POST['wpgmza_dbox']);
        $dbox_width = attribute_escape($_POST['wpgmza_dbox_width']);
        $listmarkers = intval($_POST['wpgmza_listmarkers']);
        $listmarkers_advanced = intval($_POST['wpgmza_listmarkers_advanced']);


        $gps = explode(",",$map_start_location);
        $map_start_lat = $gps[0];
        $map_start_lng = $gps[1];
        $map_default_marker = $_POST['upload_default_marker'];
        $kml = attribute_escape($_POST['wpgmza_kml']);
        $fusion = attribute_escape($_POST['wpgmza_fusion']);

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
        $data['map_default_listmarkers'] = $listmarkers;
        $data['map_default_listmarkers_advanced'] = $listmarkers_advanced;
        $data['map_default_marker'] = $map_default_marker;
        $data['map_default_width_type'] = $map_width_type;
        $data['map_default_height_type'] = $map_height_type;



        $rows_affected = $wpdb->query( $wpdb->prepare(
                "UPDATE $wpgmza_tblname_maps SET
                map_title = %s,
                map_width = %s,
                map_height = %s,
                map_start_lat = %f,
                map_start_lng = %f,
                map_start_location = %s,
                map_start_zoom = %d,
                default_marker = %s,
                type = %d,
                alignment = %d,
                directions_enabled = %d,
                kml = %s,
                bicycle = %d,
                traffic = %d,
                dbox = %d,
                dbox_width = %s,
                listmarkers = %d,
                listmarkers_advanced = %d,
                fusion = %s,
                map_width_type = %s,
                map_height_type = %s
                WHERE id = %d",

                $map_title,
                $map_width,
                $map_height,
                $map_start_lat,
                $map_start_lng,
                $map_start_location,
                $map_start_zoom,
                $map_default_marker,
                $type,
                $alignment,
                $directions_enabled,
                $kml,
                $bicycle_enabled,
                $traffic_enabled,
                $dbox,
                $dbox_width,
                $listmarkers,
                $listmarkers_advanced,
                $fusion,
                $map_width_type,
                $map_height_type,
                $map_id)
        );

        //echo $wpdb->print_error();


        update_option('WPGMZA_SETTINGS', $data);
        

        echo "<div class='updated'>";
        _e("Your settings have been saved.");
        echo "</div>";

   }

   else if (isset($_POST['wpgmza_save_maker_location'])){
        global $wpdb;
        global $wpgmza_tblname;
        $mid = attribute_escape($_POST['wpgmaps_marker_id']);
        $wpgmaps_marker_lat = attribute_escape($_POST['wpgmaps_marker_lat']);
        $wpgmaps_marker_lng = attribute_escape($_POST['wpgmaps_marker_lng']);

        $rows_affected = $wpdb->query( $wpdb->prepare(
                "UPDATE $wpgmza_tblname SET
                lat = %s,
                lng = %s
                WHERE id = %d",

                $wpgmaps_marker_lat,
                $wpgmaps_marker_lng,
                $mid)
        );




        //update_option('WPGMZA', $data);
        echo "<div class='updated'>";
        _e("Your marker location has been saved.");
        echo "</div>";


   }
   else if (isset($_POST['wpgmza_save_settings'])){
        global $wpdb;
        $wpgmza_data['wpgmza_settings_image_width'] = attribute_escape($_POST['wpgmza_settings_image_width']);
        $wpgmza_data['wpgmza_settings_image_height'] = attribute_escape($_POST['wpgmza_settings_image_height']);
        $wpgmza_data['wpgmza_settings_use_timthumb'] = attribute_escape($_POST['wpgmza_settings_use_timthumb']);
        $wpgmza_data['wpgmza_settings_infowindow_width'] = attribute_escape($_POST['wpgmza_settings_infowindow_width']);
        $wpgmza_data['wpgmza_settings_infowindow_links'] = attribute_escape($_POST['wpgmza_settings_infowindow_links']);
        $wpgmza_data['wpgmza_settings_infowindow_address'] = attribute_escape($_POST['wpgmza_settings_infowindow_address']);
        $wpgmza_data['wpgmza_settings_map_streetview'] = attribute_escape($_POST['wpgmza_settings_map_streetview']);
        $wpgmza_data['wpgmza_settings_map_zoom'] = attribute_escape($_POST['wpgmza_settings_map_zoom']);
        $wpgmza_data['wpgmza_settings_map_pan'] = attribute_escape($_POST['wpgmza_settings_map_pan']);
        $wpgmza_data['wpgmza_settings_map_type'] = attribute_escape($_POST['wpgmza_settings_map_type']);
        $wpgmza_data['wpgmza_settings_map_scroll'] = attribute_escape($_POST['wpgmza_settings_map_scroll']);
        $wpgmza_data['wpgmza_settings_ugm_striptags'] = attribute_escape($_POST['wpgmza_settings_map_striptags']);
        update_option('WPGMZA_OTHER_SETTINGS', $wpgmza_data);
        echo "<div class='updated'>";
        _e("Your settings have been saved.");
        echo "</div>";


   }


    wpgmaps_debugger("head_end");

}






function wpgmaps_admin_menu() {
    add_menu_page('WPGoogle Maps', __('Maps','wp-google-maps'), 'manage_options', 'wp-google-maps-menu', 'wpgmaps_menu_layout', wpgmaps_get_plugin_url()."/images/map_app_small.png");
    if (function_exists(wpgmza_pro_advanced_menu)) {
        add_submenu_page('wp-google-maps-menu', 'WP Google Maps - Advanced Options', __('Advanced','wp-google-maps'), 'manage_options' , 'wp-google-maps-menu-advanced', 'wpgmaps_menu_advanced_layout');
    }
        add_submenu_page('wp-google-maps-menu', 'WP Google Maps - Settings', __('Settings','wp-google-maps'), 'manage_options' , 'wp-google-maps-menu-settings', 'wpgmaps_menu_settings_layout');

//    add_options_page('WP Google Maps', 'WP Google Maps', 'manage_options', 'wp-google-maps-menu', 'wpgmaps_menu_layout');
}
function wpgmaps_menu_layout() {
    //check to see if we have write permissions to the plugin folder
    //
    //
    wpgmaps_debugger("menu_start");


    if (!$_GET['action']) {

        wpgmza_map_page();

    } else {


        if ($_GET['action'] == "trash" && isset($_GET['map_id'])) {

            if ($_GET['s'] == "1") {
                if (wpgmaps_trash_map($_GET['map_id'])) {
                    //wp_redirect( admin_url('admin.php?page=wp-google-maps-menu') );
                    echo "<script>window.location = \"".get_option('siteurl')."/wp-admin/admin.php?page=wp-google-maps-menu\"</script>";
                } else {
                    _e("There was a problem deleting the map.");;
                }
            } else {
                $res = wpgmza_get_map_data($_GET['map_id']);
                echo "<h2>".__("Delete your map","wp-google-maps")."</h2><p>".__("Are you sure you want to delete the map","wp-google-maps")." <strong>\"".$res->map_title."?\"</strong> <br /><a href='?page=wp-google-maps-menu&action=trash&map_id=".$_GET['map_id']."&s=1'>".__("Yes","wp-google-maps")."</a> | <a href='?page=wp-google-maps-menu'>".__("No","wp-google-maps")."</a></p>";
            }


        }
        else if ($_GET['action'] == "edit_marker" && isset($_GET['id'])) {

            wpgmza_edit_marker($_GET['id']);

        }
        else {

            if (function_exists(wpgmza_register_pro_version)) {

                    $prov = get_option("WPGMZA_PRO");
                    $wpgmza_pro_version = $prov['version'];
                    if (floatval($wpgmza_pro_version) < 4.01 || $wpgmza_pro_version == null) {
                        wpgmaps_upgrade_notice();
                        wpgmza_pro_menu();
                    } else {
                        wpgmza_pro_menu();
                    }


            } else {
                wpgmza_basic_menu();

            }

        }
    }

    wpgmaps_debugger("menu_end");

}


function wpgmaps_menu_settings_layout() {
    wpgmaps_debugger("menu_settings_start");
    if (function_exists(wpgmza_register_pro_version)) {
        if (function_exists(wpgmaps_settings_page_pro)) {
            wpgmaps_settings_page_pro();
        }
    } else {
        wpgmaps_settings_page_basic();
    }



    wpgmaps_debugger("menu_settings_end");
}


function wpgmaps_settings_page_basic() {
    echo"<div class=\"wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>".__("WP Google Map Settings","wp-google-maps")."</h2>";

    $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
    $wpgmza_settings_map_streetview = $wpgmza_settings['wpgmza_settings_map_streetview'];
    $wpgmza_settings_map_zoom = $wpgmza_settings['wpgmza_settings_map_zoom'];
    $wpgmza_settings_map_pan = $wpgmza_settings['wpgmza_settings_map_pan'];
    $wpgmza_settings_map_type = $wpgmza_settings['wpgmza_settings_map_type'];
    if ($wpgmza_settings_map_streetview == "yes") { $wpgmza_streetview_checked = "checked='checked'"; }
    if ($wpgmza_settings_map_zoom == "yes") { $wpgmza_zoom_checked = "checked='checked'"; }
    if ($wpgmza_settings_map_pan == "yes") { $wpgmza_pan_checked = "checked='checked'"; }
    if ($wpgmza_settings_map_type == "yes") { $wpgmza_type_checked = "checked='checked'"; }

    if (function_exists(wpgmza_register_pro_version)) {
        $pro_settings1 = wpgmaps_settings_page_sub('infowindow');
        $prov = get_option("WPGMZA_PRO");
        $wpgmza_pro_version = $prov['version'];
        if (floatval($wpgmza_pro_version) < 3.9) {
            $prov_msg = "<div class='error below-h1'><p>Please note that these settings will only work with the Pro Addon version 3.9 and above. Your current version is $wpgmza_pro_version. To download the latest version, please email <a href='mailto:nick@wpgmaps.com'>nick@wpgmaps.com</a></p></div>";
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
                                
                        </td>
                    </tr>
                    
                </table>


                <p class='submit'><input type='submit' name='wpgmza_save_settings' class='button-primary' value='".__("Save Settings","wp-google-maps")." &raquo;' /></p>


            </form>
    ";

    echo "</div>";

    
}

function wpgmaps_menu_advanced_layout() {
    if (function_exists(wpgmza_register_pro_version)) {
        wpgmza_pro_advanced_menu();
    }

}

function wpgmza_map_page() {
    wpgmaps_debugger("map_page_start");

    if (function_exists(wpgmza_register_pro_version)) {
        echo"<div class=\"wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>".__("Your Maps","wp-google-maps")." <a href=\"admin.php?page=wp-google-maps-menu&action=new\" class=\"add-new-h2\">".__("Add New","wp-google-maps")."</a></h2>";
        wpgmaps_check_versions();
        wpgmaps_list_maps();
    } else {
        echo"<div class=\"wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>".__("Your Maps","wp-google-maps")."</h2>";
        echo"<p><i><a href='http://www.wpgmaps.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=mappage_1' title='".__("Pro Version")."'>".__("Create unlimited maps","wp-google-maps")."</a> ".__("with the","wp-google-maps")." <a href='http://www.wpgmaps.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=mappage_2' title='Pro Version'>".__("Pro Version","wp-google-maps")."</a> ".__("of WP Google Maps for only","wp-google-maps")." <strong>$14.99!</strong></i></p>";
        wpgmaps_list_maps();


    }
    echo "</div>";
    wpgmaps_debugger("map_page_end");

}
function wpgmaps_list_maps() {
    wpgmaps_debugger("list_maps_start");

    global $wpdb;
    global $wpgmza_tblname_maps;

    if ($wpgmza_tblname_maps) { $table_name = $wpgmza_tblname_maps; } else { $table_name = $wpdb->prefix . "wpgmza_maps"; }


    $results = $wpdb->get_results(
	"
	SELECT *
	FROM $table_name
        WHERE `active` = 0
        ORDER BY `id` DESC
	"
    );
    echo "

      <table class=\"wp-list-table widefat fixed \" cellspacing=\"0\">
	<thead>
	<tr>
		<th scope='col' id='id' class='manage-column column-id sortable desc'  style=''><span>".__("ID","wp-google-maps")."</span></th>
                <th scope='col' id='map_title' class='manage-column column-map_title sortable desc'  style=''><span>".__("Title","wp-google-maps")."</span></th>
                <th scope='col' id='map_width' class='manage-column column-map_width' style=\"\">".__("Width","wp-google-maps")."</th>
                <th scope='col' id='map_height' class='manage-column column-map_height'  style=\"\">".__("Height","wp-google-maps")."</th>
                <th scope='col' id='type' class='manage-column column-type sortable desc'  style=\"\"><span>".__("Type","wp-google-maps")."</span></th>
        </tr>
	</thead>
        <tbody id=\"the-list\" class='list:wp_list_text_link'>
";
    foreach ( $results as $result ) {
        if ($result->type == "1") { $map_type = __("Roadmap","wp-google-maps"); }
        else if ($result->type == "2") { $map_type = __("Satellite","wp-google-maps"); }
        else if ($result->type == "3") { $map_type = __("Hybrid","wp-google-maps"); }
        else if ($result->type == "4") { $map_type = __("Terrain","wp-google-maps"); }
        if (function_exists(wpgmza_register_pro_version)) {
            $trashlink = "| <a href=\"?page=wp-google-maps-menu&action=trash&map_id=".$result->id."\" title=\"Trash\">".__("Trash","wp-google-maps")."</a>";
        }
        echo "<tr id=\"record_".$result->id."\">";
        echo "<td class='id column-id'>".$result->id."</td>";
        echo "<td class='map_title column-map_title'><strong><big><a href=\"?page=wp-google-maps-menu&action=edit&map_id=".$result->id."\" title=\"".__("Edit","wp-google-maps")."\">".$result->map_title."</a></big></strong><br /><a href=\"?page=wp-google-maps-menu&action=edit&map_id=".$result->id."\" title=\"".__("Edit","wp-google-maps")."\">".__("Edit","wp-google-maps")."</a> $trashlink</td>";
        echo "<td class='map_width column-map_width'>".$result->map_width."</td>";
        echo "<td class='map_width column-map_height'>".$result->map_height."</td>";
        echo "<td class='type column-type'>".$map_type."</td>";
        echo "</tr>";


    }
    echo "</table>";
    wpgmaps_debugger("list_maps_end");
}

function wpgmaps_check_versions() {
    wpgmaps_debugger("check_versions_start");

    $prov = get_option("WPGMZA_PRO");
    $wpgmza_pro_version = $prov['version'];
    if (floatval($wpgmza_pro_version) < 3 || $wpgmza_pro_version == null) {
        wpgmaps_upgrade_notice();
    }


    wpgmaps_debugger("check_versions_end");
}

function wpgmza_basic_menu() {
    wpgmaps_debugger("bm_start");

    global $wpgmza_tblname_maps;
    global $wpdb;
    if (!wpgmaps_check_permissions()) { wpgmaps_permission_warning(); }
    if ($_GET['action'] == "edit" && isset($_GET['map_id'])) {

        $res = wpgmza_get_map_data($_GET['map_id']);


       if ($res->map_start_zoom) { $wpgmza_zoom[intval($res->map_start_zoom)] = "SELECTED"; } else { $wpgmza_zoom[8] = "SELECTED"; }
       if ($res->type) { $wpgmza_map_type[intval($res->type)] = "SELECTED"; } else { $wpgmza_map_type[1] = "SELECTED"; }
       if ($res->alignment) { $wpgmza_map_align[intval($res->alignment)] = "SELECTED"; } else { $wpgmza_map_align[1] = "SELECTED"; }

       if ($res->map_width_type == "%") { $wpgmza_map_width_type_percentage = "SELECTED"; } else { $wpgmza_map_width_type_px = "SELECTED"; }
       if ($res->map_height_type == "%") { $wpgmza_map_height_type_percentage = "SELECTED"; } else { $wpgmza_map_height_type_px = "SELECTED"; }


        $wpgmza_act = "disabled readonly";
        $wpgmza_act_msg = "<span style=\"font-size:16px; color:#666;\">".__("Add custom icons, titles, descriptions, pictures and links to your markers with the","wp-google-maps")." \"<a href=\"http://www.wpgmaps.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=below_marker\" title=\"".__("Pro Edition","wp-google-maps")."\" target=\"_BLANK\">".__("Pro Edition","wp-google-maps")."</a>\" ".__("of this plugin for just","wp-google-maps")." <strong>$14.99</strong></span>";
        $wpgmza_csv = "<p><a href=\"http://www.wpgmaps.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=csv_link\" title=\"".__("Pro Edition","wp-google-maps")."\">".__("Purchase the Pro Edition","wp-google-maps")."</a> ".__("of WP Google Maps and save your markers to a CSV file!","wp-google-maps")."</p>";
    }
        echo "

           <div class='wrap'>
                <h1>WP Google Maps</h1>
                <div class='wide'>



                    <h2>".__("Map Settings","wp-google-maps")."</h2>
                    <form action='' method='post' id='wpgmaps_options'>
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
                    <table>
                        <tr>
                            <td>".__("Short code","wp-google-maps").":</td>
                            <td><input type='text' readonly name='shortcode' style='font-size:18px; text-align:center;' value='[wpgmza id=\"".$res->id."\"]' /> <small><i>".__("copy this into your post or page to display the map","wp-google-maps")."</i></td>
                        </tr>
                        <tr>
                            <td>".__("Map Name","wp-google-maps").":</td>
                            <td><input id='wpgmza_title' name='wpgmza_title' type='text' size='20' maxlength='50' value='".$res->map_title."' /></td>
                        </tr>
                        <tr>
                             <td>".__("Width","wp-google-maps").":</td>
                             <td>
                             <input id='wpgmza_width' name='wpgmza_width' type='text' size='4' maxlength='4' value='".$res->map_width."' />
                             <select id='wpgmza_map_width_type' name='wpgmza_map_width_type'>
                                <option value=\"px\" $wpgmza_map_width_type_px>px</option>
                                <option value=\"%\" $wpgmza_map_width_type_percentage>%</option>
                             </select>

                            </td>
                        </tr>
                        <tr>
                            <td>".__("Height","wp-google-maps").":</td>
                            <td><input id='wpgmza_height' name='wpgmza_height' type='text' size='4' maxlength='4' value='".$res->map_height."' />
                             <select id='wpgmza_map_height_type' name='wpgmza_map_height_type'>
                                <option value=\"px\" $wpgmza_map_height_type_px>px</option>
                                <option value=\"%\" $wpgmza_map_height_type_percentage>%</option>
                             </select>

</td>
                        </tr>

                        <tr>
                            <td>".__("Default Marker Image","wp-google-maps").":</td>
                            <td><input id=\"upload_default_marker\" name=\"upload_default_marker\" type='hidden' size='35' maxlength='700' value='' ".$wpgmza_act."/> <input id=\"upload_default_marker_btn\" type=\"button\" value=\"".__("Upload Image","wp-google-maps")."\" $wpgmza_act /><small><i> ".__("available in the","wp-google-maps")." <a href=\"http://www.wpgmaps.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=default_marker\" title=\"".__("Pro Edition","wp-google-maps")."\" target=\"_BLANK\">".__("Pro Edition","wp-google-maps")."</a> ".__("only","wp-google-maps").".   </i></small></td>
                        </tr>
                        <tr>
                            <td>".__("Map type","wp-google-maps").":</td>
                            <td><select id='wpgmza_map_type' name='wpgmza_map_type'>
                                <option value=\"1\" ".$wpgmza_map_type[1].">".__("Roadmap","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_map_type[2].">".__("Satellite","wp-google-maps")."</option>
                                <option value=\"3\" ".$wpgmza_map_type[3].">".__("Hybrid","wp-google-maps")."</option>
                                <option value=\"4\" ".$wpgmza_map_type[4].">".__("Terrain","wp-google-maps")."</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>".__("Map Alignment","wp-google-maps").":</td>
                            <td><select id='wpgmza_map_align' name='wpgmza_map_align'>
                                <option value=\"1\" ".$wpgmza_map_align[1].">".__("Left","wp-google-maps")."</option>
                                <option value=\"2\" ".$wpgmza_map_align[2].">".__("Center","wp-google-maps")."</option>
                                <option value=\"3\" ".$wpgmza_map_align[3].">".__("Right","wp-google-maps")."</option>
                                <option value=\"4\" ".$wpgmza_map_align[4].">".__("None","wp-google-maps")."</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>".__("KML/GeoRSS URL","wp-google-maps").":</td>
                            <td>
                             <input id='wpgmza_kml' name='wpgmza_kml' type='text' size='100' maxlength='700' class='regular-text' value='' $wpgmza_act /><small><i> ".__("available in the","wp-google-maps")." <a href=\"http://www.wpgmaps.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=kml\" title=\"".__("Pro Edition","wp-google-maps")."\" target=\"_BLANK\">".__("Pro Edition","wp-google-maps")."</a> ".__("only","wp-google-maps").".   </i></small></td>
                            </td>
                        </tr>
                        <tr>
                            <td>".__("Fusion Table ID","wp-google-maps").":</td>
                            <td>
                             <input id='wpgmza_fusion' name='wpgmza_fusion' type='text' size='100' maxlength='700' class='small-text' value='' $wpgmza_act /><small><i> ".__("available in the","wp-google-maps")." <a href=\"http://www.wpgmaps.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=fusion\" title=\"".__("Pro Edition","wp-google-maps")."\" target=\"_BLANK\">".__("Pro Edition","wp-google-maps")."</a> ".__("only","wp-google-maps").".   </i></small></td>
                            </td>
                        </tr>


                        </table>
                            <div id=\"wpgmaps_save_reminder\" style=\"display:none;\"><span style=\"font-size:16px; color:#1C62B9;\">
                            ".__("Remember to save your map!","wp-google-maps")."
                            </span></div>
                            <p class='submit'><input type='submit' name='wpgmza_savemap' class='button-primary' value='".__("Save Map","wp-google-maps")." &raquo;' /></p>
                            <p style=\"width:600px; color:#808080;\">
                                ".__("Tip: Use your mouse to change the layout of your map. When you have positioned the map to your desired location, press \"Save Map\" to keep your settings.","wp-google-maps")."</p>


                            <div id=\"wpgmza_map\">&nbsp;</div>
                            <div style=\"display:block; overflow:auto; background-color:#FFFBCC; padding:10px; border:1px solid #E6DB55; margin-top:5px; margin-bottom:5px;\">
                                <h2 style=\"padding-top:0; margin-top:0;\">".__("Add a marker","wp-google-maps")."</h2>
                                <p>
                                <table>
                                <input type=\"hidden\" name=\"wpgmza_edit_id\" id=\"wpgmza_edit_id\" value=\"\" />
                                <tr>
                                    <td>".__("Title","wp-google-maps").": </td>
                                    <td><input id='wpgmza_add_title' name='wpgmza_add_title' type='text' size='35' maxlength='200' value='' $wpgmza_act /> &nbsp;<br /></td>

                                </tr>
                                <tr>
                                    <td>".__("Address/GPS","wp-google-maps").": </td>
                                    <td><input id='wpgmza_add_address' name='wpgmza_add_address' type='text' size='35' maxlength='200' value='' /> &nbsp;<br /></td>

                                </tr>

                                <tr><td>".__("Description","wp-google-maps").": </td>
                                    <td><textarea id='wpgmza_add_desc' name='wpgmza_add_desc' ".$wpgmza_act."></textarea>  &nbsp;<br /></td></tr>
                                <tr><td>".__("Pic URL","wp-google-maps").": </td>
                                    <td><input id='wpgmza_add_pic' name=\"wpgmza_add_pic\" type='text' size='35' maxlength='700' value='' ".$wpgmza_act."/> <input id=\"upload_image_button\" type=\"button\" value=\"".__("Upload Image","wp-google-maps")."\" $wpgmza_act /><br /></td></tr>
                                <tr><td>".__("Link URL","wp-google-maps").": </td>
                                    <td><input id='wpgmza_link_url' name='wpgmza_link_url' type='text' size='35' maxlength='700' value='' ".$wpgmza_act." /></td></tr>
                                <tr><td>".__("Custom Marker","wp-google-maps").": </td>
                                    <td><input id='wpgmza_add_custom_marker' name=\"wpgmza_add_custom_marker\" type='hidden' size='35' maxlength='700' value='' ".$wpgmza_act."/> <input id=\"upload_custom_marker_button\" type=\"button\" value=\"".__("Upload Image","wp-google-maps")."\" $wpgmza_act /> &nbsp;</td></tr>
                                <tr>
                                    <td>".__("Animation","wp-google-maps").": </td>
                                    <td>
                                        <select name=\"wpgmza_animation\" id=\"wpgmza_animation\" readonly disabled>
                                            <option value=\"0\">".__("None","wp-google-maps")."</option>
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>
                                        <span id=\"wpgmza_addmarker_div\"><input type=\"button\" class='button-primary' id='wpgmza_addmarker' value='".__("Add Marker","wp-google-maps")."' /></span> <span id=\"wpgmza_addmarker_loading\" style=\"display:none;\">".__("Adding","wp-google-maps")."...</span>
                                        <span id=\"wpgmza_editmarker_div\" style=\"display:none;\"><input type=\"button\" id='wpgmza_editmarker'  class='button-primary' value='".__("Save Marker","wp-google-maps")."' /></span><span id=\"wpgmza_editmarker_loading\" style=\"display:none;\">".__("Saving","wp-google-maps")."...</span>
                                    </td>

                                </tr>

                                </table>
                            </div>
                            <p>$wpgmza_act_msg</p>
                            <h2 style=\"padding-top:0; margin-top:0;\">".__("Your Markers","wp-google-maps")."</h2>
                            <div id=\"wpgmza_marker_holder\">
                                ".wpgmza_return_marker_list($_GET['map_id'])."
                            </div>

                            <br /><br />$wpgmza_csv

                            <table>
                                <tr>
                                    <td><img src=\"".wpgmaps_get_plugin_url()."/images/custom_markers.jpg\" width=\"160\" style=\"border:3px solid #808080;\" title=\"".__("Add detailed information to your markers!")."\" alt=\"".__("Add custom markers to your map!","wp-google-maps")."\" /><br /><br /></td>
                                    <td valign=\"middle\"><span style=\"font-size:18px; color:#666;\">".__("Add detailed information to your markers for only","wp-google-maps")." <strong>$14.99</strong>. ".__("Click","wp-google-maps")." <a href=\"http://www.wpgmaps.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=image1\" title=\"Pro Edition\" target=\"_BLANK\">".__("here","wp-google-maps")."</a></span></td>
                                </tr>
                                <tr>
                                    <td><img src=\"".wpgmaps_get_plugin_url()."/images/custom_marker_icons.jpg\" width=\"160\" style=\"border:3px solid #808080;\" title=\"".__("Add custom markers to your map!","wp-google-maps")."\" alt=\"".__("Add custom markers to your map!","wp-google-maps")."\" /><br /><br /></td>
                                    <td valign=\"middle\"><span style=\"font-size:18px; color:#666;\">".__("Add different marker icons, or your own icons to make your map really stand out!","wp-google-maps")."</span></td>
                                </tr>
                                <tr>
                                    <td><img src=\"".wpgmaps_get_plugin_url()."/images/get_directions.jpg\" width=\"160\" style=\"border:3px solid #808080;\" title=\"".__("Add custom markers to your map!","wp-google-maps")."\" alt=\"".__("Add custom markers to your map!","wp-google-maps")."\" /><br /><br /></td>
                                    <td valign=\"middle\"><span style=\"font-size:18px; color:#666;\">".__("Allow your visitors to get directions to your markers!","wp-google-maps")." ".__("Click","wp-google-maps")." <a href=\"http://www.wpgmaps.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=image2\" title=\"".__("Pro Edition","wp-google-maps")."\" target=\"_BLANK\">".__("here","wp-google-maps")."</a></span></td>
                                </tr>
                            </table>

                    </form>

                    <p><br /><br />".__("WP Google Maps encourages you to make use of the amazing icons created by Nicolas Mollet's Maps Icons Collection","wp-google-maps")." <a href='http://mapicons.nicolasmollet.com'>http://mapicons.nicolasmollet.com/</a> ".__("and to credit him when doing so.","wp-google-maps")."</p>
                </div>


            </div>



        ";



    wpgmaps_debugger("bm_end");

}



function wpgmza_edit_marker($mid) {
    global $wpgmza_tblname_maps;
    global $wpdb;
    if ($_GET['action'] == "edit_marker" && isset($mid)) {
        $res = wpgmza_get_marker_data($mid);
        echo "
           <div class='wrap'>
                <h1>WP Google Maps</h1>
                <div class='wide'>

                    <h2>".__("Edit Marker Location","wp-google-maps")." ".__("ID","wp-google-maps")."#$mid</h2>
                    <form action='?page=wp-google-maps-menu&action=edit&map_id=".$res->map_id."' method='post' id='wpgmaps_edit_marker'>
                    <p></p>

                    <input type='hidden' name='wpgmaps_marker_id' id='wpgmaps_marker_id' value='".$mid."' />
                    <div id=\"wpgmaps_status\"></div>
                    <table>

                        <tr>
                            <td>".__("Marker Latitude","wp-google-maps").":</td>
                            <td><input id='wpgmaps_marker_lat' name='wpgmaps_marker_lat' type='text' size='15' maxlength='100' value='".$res->lat."' /></td>
                        </tr>
                        <tr>
                            <td>".__("Marker Longitude","wp-google-maps").":</td>
                            <td><input id='wpgmaps_marker_lng' name='wpgmaps_marker_lng' type='text' size='15' maxlength='100' value='".$res->lng."' /></td>
                        </tr>

                    </table>
                    <p class='submit'><input type='submit' name='wpgmza_save_maker_location' class='button-primary' value='".__("Save Marker Location","wp-google-maps")." &raquo;' /></p>
                    <p style=\"width:600px; color:#808080;\">".__("Tip: Use your mouse to change the location of the marker. Simply click and drag it to your desired location.","wp-google-maps")."</p>


                    <div id=\"wpgmza_map\">&nbsp;</div>

                    <p>$wpgmza_act_msg</p>



                    </form>
                </div>


            </div>



        ";

    }



}





function wpgmaps_admin_scripts() {
    wpgmaps_debugger("admin_scripts_start");
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('my-wpgmaps-upload', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/upload.js', array('jquery','media-upload','thickbox'));
    wp_enqueue_script('my-wpgmaps-upload');
    wpgmaps_debugger("admin_scripts_end");

}
function wpgmaps_user_styles() {
    wp_register_style( 'wpgmaps-style', plugins_url('/css/wpgmza_style.css', __FILE__) );
    wp_enqueue_style( 'wpgmaps-style' );}

function wpgmaps_admin_styles() {
    wp_enqueue_style('thickbox');
}

if (isset($_GET['page']) && $_GET['page'] == 'wp-google-maps-menu') {
    wpgmaps_debugger("load_scripts_styles_start");

    add_action('admin_print_scripts', 'wpgmaps_admin_scripts');
    add_action('admin_print_styles', 'wpgmaps_admin_styles');
    wpgmaps_debugger("load_scripts_styles_end");
}

    add_action('wp_print_styles', 'wpgmaps_user_styles');



function wpgmza_return_marker_list($map_id,$admin = true,$width = "100%") {
    wpgmaps_debugger("return_marker_start");

    global $wpdb;
    global $wpgmza_tblname;

    $marker_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpgmza_tblname WHERE `map_id` = '$map_id';" ) );
    if ($marker_count > 2000) {
        return __("There are too many markers to make use of the live edit function. The maximum amount for this functionality is 2000 markers. Anything more than that number would crash your browser. In order to edit your markers, you would need to download the table in CSV format, edit it and re-upload it.","wp-google-maps");
    } else {



    $results = $wpdb->get_results("
	SELECT *
	FROM $wpgmza_tblname
	WHERE `map_id` = '$map_id' ORDER BY `id` DESC
    ");
    if ($admin) {
    $wpgmza_tmp .= "
        <table id=\"wpgmza_table\" class=\"display\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:$width;\">
        <thead>
        <tr>
            <th><strong>".__("ID","wp-google-maps")."</strong></th>
            <th><strong>".__("Icon","wp-google-maps")."</strong></th>
            <th><strong>".__("Title","wp-google-maps")."</strong></th>
            <th><strong>".__("Address","wp-google-maps")."</strong></th>
            <th><strong>".__("Description","wp-google-maps")."</strong></th>
            <th><strong>".__("Image","wp-google-maps")."</strong></th>
            <th><strong>".__("Link","wp-google-maps")."</strong></th>
            <th><strong>".__("Action","wp-google-maps")."</strong></th>
        </tr>
        </thead>
        <tbody>
    ";
    } else {
    $wpgmza_tmp .= "
        <div id=\"wpgmza_marker_holder_".$map_id."\">
        <table id=\"wpgmza_table_".$map_id."\" class=\"wpgmza_table\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:$width;\">
        <thead>
        <tr>
            <th><strong></strong></th>
            <th><strong>".__("Title","wp-google-maps")."</strong></th>
            <th><strong>".__("Address","wp-google-maps")."</strong></th>
            <th><strong>".__("Description","wp-google-maps")."</strong></th>
        </tr>
        </thead>
        <tbody>
    ";
    }


    $wpgmza_data = get_option('WPGMZA');
    if ($wpgmza_data['map_default_marker']) { $default_icon = "<img src='".$wpgmza_data['map_default_marker']."' />"; } else { $default_icon = "<img src='".wpgmaps_get_plugin_url()."/images/marker.png' />"; }

    foreach ( $results as $result ) {
        $img = $result->pic;
        $link = $result->link;
        $icon = $result->icon;

        if (!$img) { $pic = ""; } else { $pic = "<img src=\"".$result->pic."\" width=\"40\" />"; }
        if (!$icon) { $icon = $default_icon; } else { $icon = "<img src='".$result->icon."' />"; }
        if (!$link) { $linktd = ""; } else { $linktd = "<a href=\"".$result->link."\" target=\"_BLANK\" title=\"".__("View this link","wp-google-maps")."\">&gt;&gt;</a>"; }
        if ($admin) {
        $wpgmza_tmp .= "
            <tr id=\"wpgmza_tr_".$result->id."\">
                <td height=\"40\">".$result->id."</td>
                <td height=\"40\">".$icon."<input type=\"hidden\" id=\"wpgmza_hid_marker_icon_".$result->id."\" value=\"".$result->icon."\" /><input type=\"hidden\" id=\"wpgmza_hid_marker_anim_".$result->id."\" value=\"".$result->anim."\" /><input type=\"hidden\" id=\"wpgmza_hid_marker_infoopen_".$result->id."\" value=\"".$result->infoopen."\" /></td>
                <td>".$result->title."<input type=\"hidden\" id=\"wpgmza_hid_marker_title_".$result->id."\" value=\"".$result->title."\" /></td>
                <td>".$result->address."<input type=\"hidden\" id=\"wpgmza_hid_marker_address_".$result->id."\" value=\"".$result->address."\" /></td>
                <td>".$result->desc."<input type=\"hidden\" id=\"wpgmza_hid_marker_desc_".$result->id."\" value=\"".$result->desc."\" /></td>
                <td>$pic<input type=\"hidden\" id=\"wpgmza_hid_marker_pic_".$result->id."\" value=\"".$result->pic."\" /></td>
                <td>$linktd<input type=\"hidden\" id=\"wpgmza_hid_marker_link_".$result->id."\" value=\"".$result->link."\" /></td>
                <td width='170' align='center'>
                    <a href=\"#wpgmaps_marker\" title=\"".__("Edit this marker","wp-google-maps")."\" class=\"wpgmza_edit_btn\" id=\"".$result->id."\">".__("Edit","wp-google-maps")."</a> |
                    <a href=\"?page=wp-google-maps-menu&action=edit_marker&id=".$result->id."\" title=\"".__("Edit this marker","wp-google-maps")."\" class=\"wpgmza_edit_btn\" id=\"".$result->id."\">".__("Edit Location","wp-google-maps")."</a> |
                    <a href=\"javascript:void(0);\" title=\"".__("Delete this marker","wp-google-maps")."\" class=\"wpgmza_del_btn\" id=\"".$result->id."\">".__("Delete","wp-google-maps")."</a>
                </td>
            </tr>";
        } else {
        $wpgmza_tmp .= "
            <tr id=\"wpgmza_marker_".$result->id."\" mid=\"".$result->id."\" mapid=\"".$result->map_id."\" class=\"wpgmaps_mlist_row\">
                <td height=\"40\">".$icon."<input type=\"hidden\" id=\"wpgmza_hid_marker_icon_".$result->id."\" value=\"".$result->icon."\" /><input type=\"hidden\" id=\"wpgmza_hid_marker_anim_".$result->id."\" value=\"".$result->anim."\" /><input type=\"hidden\" id=\"wpgmza_hid_marker_infoopen_".$result->id."\" value=\"".$result->infoopen."\" /></td>
                <td>".$result->title."<input type=\"hidden\" id=\"wpgmza_hid_marker_title_".$result->id."\" value=\"".$result->title."\" /></td>
                <td>".$result->address."<input type=\"hidden\" id=\"wpgmza_hid_marker_address_".$result->id."\" value=\"".$result->address."\" /></td>
                <td>".$result->desc."<input type=\"hidden\" id=\"wpgmza_hid_marker_desc_".$result->id."\" value=\"".$result->desc."\" /></td>
            </tr>";
        }
    }
    if ($admin) {
        $wpgmza_tmp .= "</tbody></table>";
    } else {
        $wpgmza_tmp .= "</tbody></table></div>";
    }

    wpgmaps_debugger("return_marker_end");
    return $wpgmza_tmp;
    }
}




function wpgmaps_chmodr($path, $filemode) {
    if (!is_dir($path))
        return chmod($path, $filemode);

    $dh = opendir($path);
    while (($file = readdir($dh)) !== false) {
        if($file != '.' && $file != '..') {
            $fullpath = $path.'/'.$file;
            if(is_link($fullpath))
                return FALSE;
            elseif(!is_dir($fullpath) && !chmod($fullpath, $filemode))
                    return FALSE;
            elseif(!wpgmaps_chmodr($fullpath, $filemode))
                return FALSE;
        }
    }

    closedir($dh);

    if(chmod($path, $filemode))
        return TRUE;
    else
        return FALSE;
}

if (function_exists(wpgmza_register_pro_version)) {
    add_action('wp_ajax_add_marker', 'wpgmaps_action_callback_pro');
    add_action('wp_ajax_delete_marker', 'wpgmaps_action_callback_pro');
    add_action('wp_ajax_edit_marker', 'wpgmaps_action_callback_pro');
    add_action('template_redirect','wpgmaps_check_shortcode');

    if (function_exists(wpgmza_register_gold_version)) {
        add_action('wp_footer', 'wpgmaps_user_javascript_gold');
        add_action('admin_head', 'wpgmaps_admin_javascript_gold');
    } else {
        add_action('wp_footer', 'wpgmaps_user_javascript_pro');
        add_action('admin_head', 'wpgmaps_admin_javascript_pro');
    }
    add_shortcode( 'wpgmza', 'wpgmaps_tag_pro' );
} else {
    add_action('admin_head', 'wpgmaps_admin_javascript_basic');
    add_action('wp_ajax_add_marker', 'wpgmaps_action_callback_basic');
    add_action('wp_ajax_delete_marker', 'wpgmaps_action_callback_basic');
    add_action('wp_ajax_edit_marker', 'wpgmaps_action_callback_basic');
    add_action('template_redirect','wpgmaps_check_shortcode');
    add_action('wp_footer', 'wpgmaps_user_javascript_basic');
    add_shortcode( 'wpgmza', 'wpgmaps_tag_basic' );
}


function wpgmaps_check_shortcode() {
    wpgmaps_debugger("check_for_sc_start");
    global $posts;
    global $short_code_active;
    $short_code_active = false;
      $pattern = get_shortcode_regex();

      foreach ($posts as $wpgmpost) {
          preg_match_all('/'.$pattern.'/s', $wpgmpost->post_content, $matches);
          foreach ($matches as $match) {
            if (is_array($match)) {
                foreach($match as $key => $val) {
                    $pos = strpos($val, "wpgmza");
                    
                    if ($pos === false) { } else { $short_code_active = true; }
                }
            }
          }
      }
    wpgmaps_debugger("check_for_sc_end");
}
function wpgmza_cURL_response($action) {
    if (function_exists('curl_version')) {
        global $wpgmza_version;
        global $wpgmza_t;
        $request_url = "http://www.wpgmaps.com/api/rec.php?action=$action&dom=".$_SERVER['HTTP_HOST']."&ver=".$wpgmza_version.$wpgmza_t;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
    }

}

function wpgmaps_check_permissions() {
    $filename = dirname( __FILE__ ).'/wpgmaps.tmp';
    $testcontent = "Permission Check\n";
    $handle = @fopen($filename, 'w');
    if (@fwrite($handle, $testcontent) === FALSE) {
        @fclose($handle);
        add_option("wpgmza_permission","n");
        return false;
    }
    else {
        @fclose($handle);
        add_option("wpgmza_permission","y");
        return true;
    }


}
function wpgmaps_permission_warning() {
    echo "<div class='error below-h1'><big>";
    _e("The plugin directory does not have 'write' permissions. Please enable 'write' permissions (755) for ");
    echo "\"".dirname( __FILE__ )."\" ";
    _e("in order for this plugin to work! Please see ");
    echo "<a href='http://codex.wordpress.org/Changing_File_Permissions#Using_an_FTP_Client'>";
    _e("this page");
    echo "</a> ";
    _e("for help on how to do it.");
    echo "</big></div>";
}


// handle database check upon upgrade
function wpgmaps_update_db_check() {
    wpgmaps_debugger("update_db_start");

    global $wpgmza_version;
    if (get_option('wpgmza_db_version') != $wpgmza_version) {
        wpgmaps_handle_db();
    }

    // create all XML files
    wpgmaps_update_all_xml_file();

    wpgmaps_debugger("update_db_end");
}


add_action('plugins_loaded', 'wpgmaps_update_db_check');

function wpgmaps_handle_db() {
   wpgmaps_debugger("handle_db_start");

   global $wpdb;
   global $wpgmza_version;

   $table_name = $wpdb->prefix . "wpgmza";

    $sql = "
        CREATE TABLE `".$table_name."` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `map_id` int(11) NOT NULL,
          `address` varchar(700) NOT NULL,
          `desc` mediumtext NOT NULL,
          `pic` varchar(700) NOT NULL,
          `link` varchar(700) NOT NULL,
          `icon` varchar(700) NOT NULL,
          `lat` varchar(100) NOT NULL,
          `lng` varchar(100) NOT NULL,
          `anim` varchar(3) NOT NULL,
          `title` varchar(700) NOT NULL,
          `infoopen` varchar(3) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);

   $sql2 = "alter table `".$table_name."` modify `desc` MEDIUMTEXT ;";
   $wpdb->query($sql2);


    $table_name = $wpdb->prefix . "wpgmza_maps";
    $sql = "
        CREATE TABLE `".$table_name."` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `map_title` varchar(50) NOT NULL,
          `map_width` varchar(6) NOT NULL,
          `map_height` varchar(6) NOT NULL,
          `map_start_lat` varchar(700) NOT NULL,
          `map_start_lng` varchar(700) NOT NULL,
          `map_start_location` varchar(700) NOT NULL,
          `map_start_zoom` INT(10) NOT NULL,
          `default_marker` varchar(700) NOT NULL,
          `type` INT(10) NOT NULL,
          `alignment` INT(10) NOT NULL,
          `directions_enabled` INT(10) NOT NULL,
          `styling_enabled` INT(10) NOT NULL,
          `styling_json` mediumtext NOT NULL,
          `active` INT(1) NOT NULL,
          `kml` VARCHAR(700) NOT NULL,
          `bicycle` INT(10) NOT NULL,
          `traffic` INT(10) NOT NULL,
          `dbox` INT(10) NOT NULL,
          `dbox_width` varchar(10) NOT NULL,
          `listmarkers` INT(10) NOT NULL,
          `listmarkers_advanced` INT(10) NOT NULL,
          `ugm_enabled` INT(10) NOT NULL,
          `fusion` VARCHAR(100) NOT NULL,
          `map_width_type` VARCHAR(3) NOT NULL,
          `map_height_type` VARCHAR(3) NOT NULL,
          `mass_marker_support` INT(10) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
    ";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);



   add_option("wpgmza_db_version", $wpgmza_version);
   update_option("wpgmza_db_version",$wpgmza_version);
   wpgmaps_debugger("handle_db_end");
}

function wpgmza_get_map_data($map_id) {
    global $wpdb;
    global $wpgmza_tblname_maps;

    $result = $wpdb->get_results("
        SELECT *
        FROM $wpgmza_tblname_maps
        WHERE `id` = '".$map_id."' LIMIT 1
    ");
    
    $res = $result[0];
    
    return $result[0];

}
function wpgmza_get_marker_data($mid) {
    global $wpdb;
    global $wpgmza_tblname;

    $result = $wpdb->get_results("
        SELECT *
        FROM $wpgmza_tblname
        WHERE `id` = '".$mid."' LIMIT 1
    ");

    $res = $result[0];
    return $res;

}
function wpgmaps_upgrade_notice() {
    global $wpgmza_pro_version;
    echo "<div class='error below-h1'>
        <big><big>
            <p>Dear Pro User<br /></p>

            <p>We have recently added new functionality to the Pro version of this plugin. You are currently using the latest
            Basic version which needs the latest Pro version for all functionality to work. Your current Pro version is
            $wpgmza_pro_version - The latest Pro version is 4.01<br /></p>

            <p>You should have already received an email with the download link for the latest version, if not please
            <a href='http://www.wpgmaps.com/contact-us/'>contact us</a><br /><br /></p>
            <small>
            <p><strong>Installation Instructions:</strong><br />
            <ul>
                <li>- Once downloaded, please <strong>deactivate</strong> and <strong>delete</strong> your old Pro plugin (your marker and map information wont be affected at all).</li>
                <li>- <a href=\"".get_option('siteurl')."/wp-admin/plugin-install.php?tab=upload\" target=\"_BLANK\">Upload the new</a> plugin ZIP file.</li>
            </ul>
            </p>
            </small>
            <p>If you experience into any bugs, please let me know so that I can get it sorted out ASAP</p>

            <p>Kind regards,<br /><a href='http://www.wpgmaps.com/'>WP Google Maps</a></p>
        </big></big>
    </div>";
}
function wpgmaps_trash_map($map_id) {
    global $wpdb;
    global $wpgmza_tblname_maps;
    if (isset($map_id)) {
        $rows_affected = $wpdb->query( $wpdb->prepare( "UPDATE $wpgmza_tblname_maps SET active = %d WHERE id = %d", 1, $map_id) );
        return true;
    } else {
        return false;
    }


}

function wpgmaps_debugger($section) {

    global $debug;
    global $debug_start;
    global $debug_step;
    if ($debug) {
        $end = (float) array_sum(explode(' ',microtime()));
        echo "<!-- $section processing time: ". sprintf("%.4f", ($end-$debug_start))." seconds\n -->";
    }

}

function wpgmaps_filter(&$array) {
    $clean = array();
    foreach($array as $key => &$value ) {
        if( is_array($value) ) {
            wpgmaps_filter($value);
        } else {
            //$value = trim(strip_tags($value));
            if (get_magic_quotes_gpc()) {
                $data = stripslashes($value);
            }
            $data = mysql_real_escape_string($value);
        }
    }
}
