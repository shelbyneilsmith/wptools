<?php

add_action( 'admin_menu', 'wr2x_admin_menu_dashboard' );

/**
 *
 * RETINA DASHBOARD
 *
 */

function wr2x_admin_menu_dashboard () {
	$refresh = isset ( $_GET[ 'refresh' ] ) ? $_GET[ 'refresh' ] : 0;
	$ignore = isset ( $_GET[ 'ignore' ] ) ? $_GET[ 'ignore' ] : false;
	if ( $ignore )
		wr2x_add_ignore( $ignore );
	if ( $refresh )
		wr2x_calculate_issues();
	$flagged = count( wr2x_get_issues() );
	$warning_title = "Retina files";
	$menu_label = sprintf( __( 'Retina 2x %s' ), "<span class='update-plugins count-$flagged' title='$warning_title'><span class='update-count'>" . number_format_i18n( $flagged ) . "</span></span>" );
	add_media_page( 'WP Retina 2x', $menu_label, 'manage_options', 'wp-retina-2x', 'wpr2x_wp_retina_2x' ); 
}
 
function wpr2x_wp_retina_2x() {
	$view = isset ( $_GET[ 'view' ] ) ? $_GET[ 'view' ] : 'issues';
	$paged = isset ( $_GET[ 'paged' ] ) ? $_GET[ 'paged' ] : 1;
	$issues = $count = 0;
	$sizes = wr2x_get_image_sizes();
	$posts_per_page = 10; // TODO: HOW TO GET THE NUMBER OF MEDIA PER PAGES? IT IS NOT get_option('posts_per_page');
	$issues = wr2x_get_issues();
	$ignored = wr2x_get_ignores();
	
	if ( $view == 'replace' ) {
		require('wr2x_replace.php');
		return;
	}
	
	?>
	<div class='wrap'>
	<div id="icon-upload" class="icon32"><br></div>
	<h2>WP Retina 2x &#8226; Dashboard</h2>
	<p></p>
	<?php 
	
	if ( $view == 'upload' ) {
		require('wr2x_upload.php');
		return;
	}

	if ( $view == 'issues' ) {
		global $wpdb;
		$totalcount = $wpdb->get_var( $wpdb->prepare( "
			SELECT COUNT(*)
			FROM $wpdb->posts p
			WHERE post_status = 'inherit'
			AND post_type = 'attachment'
			AND ( post_mime_type = 'image/jpeg' OR
			post_mime_type = 'image/png' OR
			post_mime_type = 'image/gif' )
		", 0, 0 ) );
		$postin = count( $issues ) < 1 ? array( -1 ) : $issues;
		$query = new WP_Query( 
			array( 
				'post_status' => 'inherit',
				'post_type' => 'attachment',
				'post__in' => $postin,
				'paged' => $paged,
				'posts_per_page' => 10
			)
		);
	} 
	else if ( $view == 'ignored' ) {
		global $wpdb;
		$totalcount = $wpdb->get_var( $wpdb->prepare( "
			SELECT COUNT(*)
			FROM $wpdb->posts p
			WHERE post_status = 'inherit'
			AND post_type = 'attachment'
			AND ( post_mime_type = 'image/jpeg' OR
			post_mime_type = 'image/png' OR
			post_mime_type = 'image/gif' )
		", 0, 0 ) );
		$postin = count( $ignored ) < 1 ? array( -1 ) : $ignored;
		$query = new WP_Query( 
			array( 
				'post_status' => 'inherit',
				'post_type' => 'attachment',
				'post__in' => $postin,
				'paged' => $paged,
				'posts_per_page' => 10
			)
		);
	} 
	else {
		$query = new WP_Query( 
			array( 
				'post_status' => 'inherit',
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'paged' => $paged
			)
		);
		$totalcount = $query->found_posts;
	}
	$results = array();
	$count = $query->found_posts;
	$pagescount = $query->max_num_pages;
	foreach ( $query->posts as $post ) {
		$info = wr2x_retina_info( $post->ID );
		array_push( $results, array( 'post' => $post, 'info' => $info ) );		
	}
		
	?>
	<a id='wr2x_generate_button_all' href='?page=wp-retina-2x&view=<?php echo $view; ?>&refresh=true' class='button-primary' style='float: right;'><?php _e("Refresh issues", 'wp-retina-2x'); ?></a>
	<a id='wr2x_generate_button_all' onclick='wr2x_generate_all()' class='button-primary'><img style='position: relative; top: 3px; left: -2px; margin-right: 3px; width: 16px; height: 16px;' src='<?php echo trailingslashit( WP_PLUGIN_URL ) . trailingslashit( 'wp-retina-2x/img'); ?>photo-album--plus.png' /><?php _e("Generate for all files", 'wp-retina-2x'); ?></a> <span id='wr2x_progression'></span>
	
	<?php 
		if (isset ( $_GET[ 'refresh' ] ) ? $_GET[ 'refresh' ] : 0) {
			echo "<p style='color: green;'>";
			_e( "Issues has been refreshed.", 'wp-retina-2x' );
			echo "</p>";
		}
	?>
	
	<p><?php _e("This screen allows you to check the media for which the retina files are missing. You can then create the files independently for each media ('Generate' button) or for all of them ('Generate for all the files' button).", 'wp-retina-2x'); ?></p>

	<style>
		#wr2x-pages {
			float: right;
			position: relative;
			top: 12px;
		}
	
		#wr2x-pages a {
			text-decoration: none;
			border: 1px solid black;
			padding: 2px 5px;
			border-radius: 4px;
			background: #E9E9E9;
			color: lightslategrey;
			border-color: #BEBEBE;
		}
		
		#wr2x-pages .current {
			font-weight: bold;
		}
	</style>

	<div id='wr2x-pages'>
	<?php
	echo paginate_links(array(  
	  'base' => '?page=wp-retina-2x&view=' . $view . '%_%',
      'current' => $paged,
      'format' => '&paged=%#%',
      'total' => $pagescount,
      'prev_next' => false
    ));  
	?>
	</div>
	
	<ul class="subsubsub">
		<li class="all"><a <?php if ( $view == 'all' ) echo "class='current'"; ?> href='?page=wp-retina-2x&view=all'>All</a><span class="count">(<?php echo $totalcount; ?>)</span></li> |
		<li class="all"><a <?php if ( $view == 'issues' ) echo "class='current'"; ?> href='?page=wp-retina-2x&view=issues'>Issues</a><span class="count">(<?php echo count( $issues ); ?>)</span></li> |
		<li class="all"><a <?php if ( $view == 'ignored' ) echo "class='current'"; ?> href='?page=wp-retina-2x&view=ignored'>Ignored</a><span class="count">(<?php echo count( $ignored ); ?>)</span></li>
	</ul>
	<table class='wp-list-table widefat fixed media'>
		<thead><tr>
			<?php
			echo "<th style='font-size: 11px; font-family: Verdana;'>Title</th>";
			foreach ($sizes as $name => $attr) {
				echo "<th style='width: 80px; font-size: 11px; font-family: Verdana;' class='manage-column'>" . $name . "</th>";
			}
			
			echo "<th style='font-size: 11px; font-family: Verdana; width: 88px;'>Actions</th>";
			echo "<th style='font-size: 11px; font-family: Verdana; width: 62px;'></th>";
			echo "<th style='font-size: 11px; font-family: Verdana; width: 70px;'></th>";
			?>
		</tr></thead>
		<tbody>
			<?php
			foreach ($results as $index => $attr) {
				$meta = wp_get_attachment_metadata($attr['post']->ID);
				
				// Let's clean the issues status
				if ( $view != 'issues' ) {
					wr2x_update_issue_status( $attr['post']->ID, $issues, $attr['info'] );
				}
				
				$original_width = $meta['width'];
				$original_height = $meta['height'];
				echo "<tr>";
				echo "<td><a style='position: relative; top: -2px;' href='media.php?attachment_id=" . $attr['post']->ID . "&action=edit'>" . 
					$attr['post']->post_title . '<br />' .
					"<span style='font-size: 9px; line-height: 10px; display: block;'>" . $original_width . "×" . $original_height . "</span>";
					"</a></td>";
				foreach ($attr['info'] as $aindex => $aval) {
					echo "<td id='wr2x_" . $aindex .  "_" . $attr['post']->ID . "'>";
					if ( is_array( $aval ) ) {
						echo "<img title='Please upload a bigger original image.' style='margin-top: 3px; width: 16px; height: 16px;' src='" . trailingslashit( WP_PLUGIN_URL ) . trailingslashit( 'wp-retina-2x/img') . "exclamation.png' />" .
						"<span style='font-size: 9px; margin-left: 5px; position: relative; top: -4px;'><br />< " . $aval['width'] . "×" . $aval['height'] . "</span>";
					}
					else if ( $aval == 'EXISTS' ) {
						echo "<img style='margin-top: 3px; width: 16px; height: 16px;' src='" . trailingslashit( WP_PLUGIN_URL ) . trailingslashit( 'wp-retina-2x/img') . "tick-circle.png' />";
					}
					else if ( $aval == 'PENDING' ) {
						echo "<img title='Click on \"Generate\".' style='margin-top: 3px; width: 16px; height: 16px;' src='" . trailingslashit( WP_PLUGIN_URL ) . trailingslashit( 'wp-retina-2x/img') . "clock.png' />";
					}
					else if ( $aval == 'MISSING' ) {
						echo "<img title='The file related to this size is missing.' style='margin-top: 3px; width: 16px; height: 16px;' src='" . trailingslashit( WP_PLUGIN_URL ) . trailingslashit( 'wp-retina-2x/img') . "cross-small.png' />";
					}
					else if ( $aval == 'IGNORED' ) {
						echo "<img title='Retina disabled.' style='margin-top: 3px; width: 16px; height: 16px;' src='" . trailingslashit( WP_PLUGIN_URL ) . trailingslashit( 'wp-retina-2x/img') . "prohibition-small.png' />";
					}
					else {
						echo "<span style='position: relative; top: 3px;'>" . $aval . "</span>";
					}
					echo "</td>";
				}
				echo "<td><a style='position: relative; top: 0px;' onclick='wr2x_generate(" . $attr['post']->ID . ", true)' id='wr2x_generate_button_" . $attr['post']->ID . "' class='button-secondary'>" . __( "GENERATE", 'wp-retina-2x' ) . "</a></td>";
				
				if ( !wr2x_is_ignore( $attr['post']->ID ) ) {
					echo "<td><a style='position: relative; top: 0px;' href='?page=wp-retina-2x&view=" . $view . "&paged=" . $paged . "&ignore=" . $attr['post']->ID . "' id='wr2x_generate_button_" . $attr['post']->ID . "' class='button-secondary'>" . __( "IGNORE", 'wp-retina-2x' ) . "</a></td>";
				}

				echo "<td style='padding-top: 2px; padding-bottom: 0px;'>";
				$_GET["attachment_id"] = $attr['post']->ID;
				$url = "?page=wp-retina-2x&view=upload&pview=$view&paged=$paged&attachment_id=" . $attr['post']->ID;
				$url = wp_nonce_url( $url, "wr2x" );
				print "<a style='position: relative; top: 2px;' class='button-secondary' href='" . $url . "'>UPLOAD</a>";
				echo "</td>";
				
				echo "</tr>";
			}
			?>
		</tbody>
	</table>
	</div>
	<?php
	jordy_meow_footer();
}
?>