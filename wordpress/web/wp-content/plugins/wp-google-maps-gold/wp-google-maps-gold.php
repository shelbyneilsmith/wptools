<?php
/*
Plugin Name: WP Google Maps - Gold Add-on
Plugin URI: http://www.wpgmaps.com
Description: This is the Gold add-on for WP Google Maps. This enables mass-marker support and advanced map styling through the wizard.
Version: 3.02
Author: WP Google Maps
Author URI: http://www.wpgmaps.com
 *
 *
 * 3.02
 * Fixed the bug that caused the directions box to show above the map by default
 * Fixed the bug whereby an address was already hard-coded into the "To" field of the directions box
 * Fixed the bug that caused the traffic layer to show by default
 *
 * 3.01
 * Added the functionality to list your markers below your map
 * Added more advanced directions functionality
 * Fixed small bugs
 * Fixed a bug that caused a fatal error when trying to activate the plugin on some hosts.
 *
 * 3.0
 * Plugin now supports multiple maps on one page (there is a known issue on the Gold add-on that shows another maps markers on the map your are on when using the zoom in/out function. I am working on this.
 * Bicycle directions now added
 * Walking directions now added
 * "Avoid tolls" now added to the directions functionality
 * "Avoid highways" now added to directions functionality
 * New setting: open links in a new window
 * Added functionality to reset the default marker image if required.
 *
 * 2.8
 * Fixed the bug that was causing both the bicycle layer and traffic layer to show all the time
 *
 * 2.7
 * Added traffic layer
 * Added bicycle layer
 *
 * 2.6
 * Added additional map settings
 * Added support for KML/GeoRSS layers.
 *
 * 2.5
 * Markers now automatically close when you click on another marker.
 * Russian localization added
 * The "To" field in the directions box now shows the address and not the GPS co-ords.
 *
 * 2.4
 * Added support for localization
 *
 * 2.3
 * Fixed the bug that caused slow loading times with sites that contain a high number of maps and markers
 *
 * 2.2
 * Added functionality for 'Titles' for each marker
 *
 * 2.1
 * Added functionality for WordPress MU
 *
 * 2.0
 * Added Map Alignment functionality
 * Added Map Type functionality
 * Started using the Geocoding API Version 3  instead of Version 2 - quicker results!
 * Fixed bug that didnt import animation data for CSV files
 * fixed zoom bug
 *
 * 1.1
 * Added support for advanced styling
 * Fixed a few bugs with the jQuery script
 * Fixed the shortcode bug where the map wasnt displaying when two or more short codes were one the post/page
 * Fixed a bug that wouldnt save the icon on editing a marker in some instances
 *
 *
 * 
*/

global $wpgmza_gold_version;
global $wpgmza_t;
global $wpgmza_p;
global $wpgmza_g;
$wpgmza_gold_version = "3.01";
$wpgmza_gold_string = "gold";
$wpgmza_p = true;
$wpgmza_g = true;



register_activation_hook( __FILE__, 'wpgmaps_gold_activate' );
register_deactivation_hook( __FILE__, 'wpgmaps_gold_deactivate' );
add_action('init', 'wpgmza_register_gold_version');
add_action('admin_head', 'wpgmaps_head_gold');
add_action('admin_footer', 'wpgmaps_reload_map_on_post_gold');

function wpgmaps_gold_activate() { wpgmza_cURL_response_gold("activate"); }
function wpgmaps_gold_deactivate() { wpgmza_cURL_response_gold("activate"); }


function wpgmza_register_gold_version() {
    if (!get_option('WPGMZA_GOLD')) {
        add_option('WPGMZA_GOLD',array("version" => $wpgmza_gold_version, "version_string" => $wpgmza_gold_string));
    }
}



function wpgmaps_user_javascript_gold() {
    global $short_code_active;
    global $wpgmza_current_map_id;
    global $wpgmza_short_code_array;



    if ($short_code_active) {
        $ajax_nonce = wp_create_nonce("wpgmza");

        ?>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript" src="<?php echo wpgmaps_get_plugin_url(); ?>/js/markerclusterer.js"></script>
        <link rel='stylesheet' id='wpgooglemaps-css'  href='<?php echo wpgmaps_get_plugin_url(); ?>/css/wpgmza_style.css' type='text/css' media='all' />
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

                        if ($wpgmza_default_icon[$wpgmza_cmd] == "0") { $wpgmza_default_icon[$wpgmza_cmd] = ""; }
                        if (!$wpgmza_map_type[$wpgmza_cmd] || $wpgmza_map_type[$wpgmza_cmd] == "" || $wpgmza_map_type[$wpgmza_cmd] == "1") { $wpgmza_map_type[$wpgmza_cmd] = "ROADMAP"; }
                        else if ($wpgmza_map_type[$wpgmza_cmd] == "2") { $wpgmza_map_type[$wpgmza_cmd] = "SATELLITE"; }
                        else if ($wpgmza_map_type[$wpgmza_cmd] == "3") { $wpgmza_map_type[$wpgmza_cmd] = "HYBRID"; }
                        else if ($wpgmza_map_type[$wpgmza_cmd] == "4") { $wpgmza_map_type[$wpgmza_cmd] = "TERRAIN"; }
                        else { $wpgmza_map_type[$wpgmza_cmd] = "ROADMAP"; }
                        $start_zoom[$wpgmza_cmd] = $res->map_start_zoom;
                        if ($start_zoom[$wpgmza_cmd] < 1 || !$start_zoom[$wpgmza_cmd]) { $start_zoom[$wpgmza_cmd] = 5; }
                        if (!$wpgmza_lat[$wpgmza_cmd] || !$wpgmza_lng[$wpgmza_cmd]) { $wpgmza_lat[$wpgmza_cmd] = "51.5081290"; $wpgmza_lng[$wpgmza_cmd] = "-0.1280050"; }

                        $wpgmza_styling_enabled[$wpgmza_cmd] = $res->styling_enabled;
                        $wpgmza_styling_json[$wpgmza_cmd] = $res->styling_json;


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


            <?php if ($wpgmza_styling_enabled[$wpgmza_cmd] == "1" && $wpgmza_styling_json[$wpgmza_cmd] != "" && $wpgmza_styling_enabled[$wpgmza_cmd] != null) { ?>

            var wpgmza_adv_styling_json = <?php echo html_entity_decode(stripslashes($wpgmza_styling_json[$wpgmza_cmd])); ?>;

            <?php } ?>



            var MYMAP_<?php echo $wpgmza_cmd; ?> = {
                map: null,
                bounds: null,
                mc: null
            }
            MYMAP_<?php echo $wpgmza_cmd; ?>.init = function(selector, latLng, zoom) {


              var myOptions = {
                zoom:zoom,
                center: latLng,
                zoomControl: <?php if ($wpgmza_settings['wpgmza_settings_map_zoom'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                panControl: <?php if ($wpgmza_settings['wpgmza_settings_map_pan'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                mapTypeControl: <?php if ($wpgmza_settings['wpgmza_settings_map_type'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                streetViewControl: <?php if ($wpgmza_settings['wpgmza_settings_map_streetview'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                mapTypeId: google.maps.MapTypeId.<?php echo $wpgmza_map_type[$wpgmza_cmd]; ?>
              }
              <?php if ($wpgmza_styling_enabled[$wpgmza_cmd] == "1" && $wpgmza_styling_json[$wpgmza_cmd] != "" && $wpgmza_styling_enabled[$wpgmza_cmd] != null) { ?>
              var WPGMZA_STYLING = new google.maps.StyledMapType(wpgmza_adv_styling_json,{name: "WPGMZA STYLING"});
              <?php } ?>


               this.map = new google.maps.Map(jQuery(selector)[0], myOptions);

              <?php if ($wpgmza_styling_enabled[$wpgmza_cmd] == "1" && $wpgmza_styling_json[$wpgmza_cmd] != "" && $wpgmza_styling_enabled[$wpgmza_cmd] != null) { ?>
                this.map.mapTypes.set('WPGMZA STYLING', WPGMZA_STYLING);
                this.map.setMapTypeId('WPGMZA STYLING');
              <?php } ?>


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
                    marker_array = []; // for mcluster
                    marker_array2 = []; // for mlist
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

                                            marker_array.push(marker);
                                            marker_array2[wpmgza_marker_id] = marker;
                                    }
                        });
                        var mcOptions = {
                        gridSize: 50,
                        maxZoom: 15,
                        styles: [{
                        height: 53,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m1.png",
                        width: 53
                        },
                        {
                        height: 56,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m2.png",
                        width: 56
                        },
                        {
                        height: 66,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m3.png",
                        width: 66
                        },
                        {
                        height: 78,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m4.png",
                        width: 78
                        },
                        {
                        height: 90,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m5.png",
                        width: 90
                        }] };
                        MYMAP_<?php echo $wpgmza_cmd; ?>.mc = new MarkerClusterer(MYMAP_<?php echo $wpgmza_cmd; ?>.map, marker_array, mcOptions);
                });
            }





                <?php } // end foreach loop ?>


            function openInfoWindow(marker_id) {
                google.maps.event.trigger(marker_array2[marker_id], 'click');
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



function wpgmaps_admin_javascript_gold() {
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
        if ($start_zoom < 1 || !$start_zoom) { $start_zoom = 5; }
        if (!$wpgmza_lat || !$wpgmza_lng) { $wpgmza_lat = "51.5081290"; $wpgmza_lng = "-0.1280050"; }
    
        $wpgmza_styling_enabled = $res->styling_enabled;
        $wpgmza_styling_json = $res->styling_json;
    ?>




    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo wpgmaps_get_plugin_url(); ?>/css/data_table.css" />

    <script type="text/javascript" src="<?php echo wpgmaps_get_plugin_url(); ?>/js/markerclusterer.js"></script>
    <script type="text/javascript" src="<?php echo wpgmaps_get_plugin_url(); ?>/js/jquery.dataTables.js"></script>
    <script type="text/javascript" >
    jQuery(function() {


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
                        MYMAP.placeMarkers('<?php echo wpgmaps_get_marker_url(); ?>?u='+UniqueCode,<?php echo $_GET['map_id']; ?>);
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

                        var wpgmza_edit_address = jQuery("#wpgmza_hid_marker_address_"+cur_id).val();
                        var wpgmza_edit_title = jQuery("#wpgmza_hid_marker_title_"+cur_id).val();
                        var wpgmza_edit_desc = jQuery("#wpgmza_hid_marker_desc_"+cur_id).val();
                        var wpgmza_edit_pic = jQuery("#wpgmza_hid_marker_pic_"+cur_id).val();
                        var wpgmza_edit_link = jQuery("#wpgmza_hid_marker_link_"+cur_id).val();
                        var wpgmza_edit_icon = jQuery("#wpgmza_hid_marker_icon_"+cur_id).val();
                        var wpgmza_edit_anim = jQuery("#wpgmza_hid_marker_anim_"+cur_id).val();
                        var wpgmza_edit_infoopen = jQuery("#wpgmza_hid_marker_infoopen_"+cur_id).val();


                        jQuery("#wpgmza_edit_id").val(cur_id);

                        jQuery("#wpgmza_add_address").val(wpgmza_edit_address);
                        jQuery("#wpgmza_add_title").val(wpgmza_edit_title);
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
                        var wpgm_address = "0";
                        var wpgm_title = "0";
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



            <?php if ($wpgmza_styling_enabled == "1" && $wpgmza_styling_json != "" && $wpgmza_styling_enabled != null) { ?>

            var wpgmza_adv_styling_json = <?php echo html_entity_decode(stripslashes($wpgmza_styling_json)); ?>;

            <?php } ?>



            var MYMAP = {
                map: null,
                bounds: null,
                mc: null
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
            <?php if ($wpgmza_styling_enabled == "1" && $wpgmza_styling_json != "" && $wpgmza_styling_enabled != null) { ?>
            var WPGMZA_STYLING = new google.maps.StyledMapType(wpgmza_adv_styling_json,{name: "WPGMZA STYLING"});
            <?php } ?>

            this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
            
            <?php if ($wpgmza_styling_enabled == "1" && $wpgmza_styling_json != "" && $wpgmza_styling_enabled != null) { ?>
            this.map.mapTypes.set('WPGMZA STYLING', WPGMZA_STYLING);
            this.map.setMapTypeId('WPGMZA STYLING');
            <?php } ?>

            
            
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
                                                //MYMAP.map.setCenter(this.position);
                                        });
                                        //MYMAP.map.fitBounds(MYMAP.bounds);

                                        google.maps.event.addListener(MYMAP.map, 'zoom_changed', function() {
                                            zoomLevel = MYMAP.map.getZoom();

                                            jQuery("#wpgmza_start_zoom").val(zoomLevel);
                                            
                                          });
                                        google.maps.event.addListener(MYMAP.map, 'center_changed', function() {
                                            var location = MYMAP.map.getCenter();
                                            jQuery("#wpgmza_start_location").val(location.lat()+","+location.lng());
                                            jQuery("#wpgmaps_save_reminder").show();
                                        });


                                    marker_array.push(marker);
                                    this.myclick=function(i) {
                                        google.maps.event.trigger(marker_array[i], 'click');
                                    };
                                }
                        });
                    var mcOptions = {
                        gridSize: 50,
                        maxZoom: 15};
                    MYMAP.mc = new MarkerClusterer(MYMAP.map, marker_array, mcOptions);
                });
            }

        </script>
        <script type="text/javascript" src="<?php echo wpgmaps_get_plugin_url(); ?>/js/wpgmaps.js"></script>
<?php
}

}


function wpgmza_gold_addon_display() {

    $res = wpgmza_get_map_data($_GET['map_id']);

    
    if ($res->styling_enabled) { $wpgmza_adv_styling[$res->styling_enabled] = "SELECTED"; } else { $wpgmza_adv_styling[2] = "SELECTED"; }

    

    $ret .= "
        <div style=\"display:block; overflow:auto; background-color:#FFFBCC; padding:10px; border:1px solid #E6DB55; margin-top:35px; margin-bottom:5px;\">
            <h2 style=\"padding-top:0; margin-top:0;\">".__("Advanced Map Styling","wp-google-maps")."</h2>
            <p>".__("Use the <a href='http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html' target='_BLANK'>Google Maps API Styled Map Wizard</a> to get your style settings","wp-google-maps")."!</p>
                <form action='' method='post' id='wpgmaps_gold_option_styling'>
                    <table>
                    <input type=\"hidden\" name=\"wpgmza_map_id\" id=\"wpgmza_map_id\" value=\"".$_GET['map_id']."\" />
                        <tr style='margin-bottom:20px;'>
                            <td>".__("Enable Advanced Styling","wp-google-maps")."?:</td>
                            <td>
                                <select id='wpgmza_adv_styling' name='wpgmza_adv_styling'>
                                    <option value=\"1\" ".$wpgmza_adv_styling[1].">".__("Yes","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_adv_styling[2].">".__("No","wp-google-maps")."</option>
                                </select>
                            </td>
                         </tr>
                         <tr>
                            <td valign='top'>".__("Paste the JSON data here","wp-google-maps").":</td>
                            <td><textarea name=\"wpgmza_adv_styling_json\" id=\"wpgmza_adv_styling_json\" rows=\"8\" cols=\"40\">".stripslashes($res->styling_json)."</textarea></td>
                         </tr>
                     </table>
                    <p class='submit'><input type='submit' name='wpgmza_save_style_settings' value='".__("Save Style Settings","wp-google-maps")." &raquo;' /></p>
                </form>
        </div>
    ";
    return $ret;


}




function wpgmaps_reload_map_on_post_gold() {
    if (isset($_POST['wpgmza_save_style_settings'])){
        $wpgmza_gold_data = get_option('WPGMZA_GOLD');
        $wpgmza_styling_enabled = $wpgmza_gold_data['styling_enabled'];
        

        ?>
        <script type="text/javascript" >
        jQuery(function() {
            jQuery("#wpgmza_map").css({
		height:<?php echo $wpgmza_height; ?>,
		width:<?php echo $wpgmza_width; ?>

            });
            var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat; ?>,<?php echo $wpgmza_lng; ?>);
            MYMAP.init('#wpgmza_map', myLatLng, <?php echo $start_zoom; ?>);
            UniqueCode=Math.round(Math.random()*10010);
            MYMAP.placeMarkers('<?php echo wpgmaps_get_marker_url(); ?>?u='+UniqueCode);

        });
        </script>
        <?php
    }


}


function wpgmaps_head_gold() {
   if (isset($_POST['wpgmza_save_style_settings'])){

        global $wpdb;
        global $wpgmza_tblname_maps;

        $map_id = $_POST['wpgmza_map_id'];
        $styling_enabled = attribute_escape($_POST['wpgmza_adv_styling']);
        $styling_json = attribute_escape($_POST['wpgmza_adv_styling_json']);


        $rows_affected = $wpdb->query( $wpdb->prepare(
                "UPDATE $wpgmza_tblname_maps SET
                styling_enabled = %d,
                styling_json = %s
                WHERE id = %d",

                $styling_enabled,
                $styling_json,
                $map_id)
        );



//    update_option('WPGMZA_GOLD', $data);
//    $wpgmza_data_gold = get_option('WPGMZA_GOLD');
    echo "
    <div class='updated'>
        Your Map Style settings have been saved.
    </div>
    ";
   }




}

function wpgmza_cURL_response_gold($action) {
    if (function_exists('curl_version')) {
        global $wpgmza_gold_version;
        global $wpgmza_gold_string;
        $request_url = "http://www.wpgmaps.com/api/rec.php?action=$action&dom=".$_SERVER['HTTP_HOST']."&ver=".$wpgmza_gold_version.$wpgmza_gold_string;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
    }

}
/*
add_action('init', 'wpgmaps_gold_activate_au');
function wpgmaps_gold_activate_au() {
	require_once ('wp_autoupdate.php');
        global $wpgmza_gold_version;
	$wpgmaps_plugin_remote_path = 'http://wpgmaps.com/api/update-gold.php';
	$wptuts_plugin_slug = plugin_basename(__FILE__);
	new wp_auto_update_gold ($wpgmza_gold_version, $wpgmaps_plugin_remote_path, $wptuts_plugin_slug);
}
*/

?>