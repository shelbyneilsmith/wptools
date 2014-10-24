<?php
function yb_js_custom() {
global $ybwp_data;
global $data;
?>

<script type="text/javascript">

jQuery(document).ready(function($){
	<?php if(1==0) : ?>
	/* ------------------------------------------------------------------------ */
	/* Add PrettyPhoto - NEED TO REDO AND SET UP LIGHTBOX OPTIONS!!!  - KEEP COMMENTED OUT TIL THAT IS DONE */
		// var lightboxArgs = {
		// 	<?php if($data["lightbox_animation_speed"]): ?>
		// 		animation_speed: '<?php echo strtolower($data["lightbox_animation_speed"]); ?>',
		// 	<?php endif; ?>

		// 	overlay_gallery: <?php if($data["lightbox_gallery"]) { echo 'true'; } else { echo 'false'; } ?>,
		// 	autoplay_slideshow: <?php if($data["lightbox_autoplay"]) { echo 'true'; } else { echo 'false'; } ?>,

		// 	<?php if($data["lightbox_slideshow_speed"]): ?>
		// 		slideshow: <?php echo $data['lightbox_slideshow_speed']; ?>, /* light_rounded / dark_rounded / light_square / dark_square / facebook */
		// 	<?php endif; ?>
		// 	<?php if($data["lightbox_theme"]): ?>
		// 		theme: '<?php echo $data['lightbox_theme']; ?>',
		// 	<?php endif; ?>
		// 	<?php if($data["lightbox_opacity"]): ?>
		// 		opacity: <?php echo $data['lightbox_opacity']; ?>,
		// 	<?php endif; ?>

		// 	show_title: <?php if($data["lightbox_title"]) { echo 'true'; } else { echo 'false'; } ?>,

		// 	<?php if(!$data["lightbox_social"]) { echo 'social_tools: "",'; } ?>

		// 	deeplinking: false,
		// 	allow_resize: true, 			/* Resize the photos bigger than viewport. true/false */
		// 	counter_separator_label: '/', 	/* The separator for the gallery counter 1 "of" 2 */
		// 	default_width: 940,
		// 	default_height: 529
		// };

		// <?php if($data["lightbox_automatic"] == 0): ?>
		// 	// $('a[href$=jpg], a[href$=JPG], a[href$=jpeg], a[href$=JPEG], a[href$=png], a[href$=gif], a[href$=bmp]:has(img)').prettyPhoto(lightboxArgs);
		// <?php endif; ?>

		// // $('a[class^="prettyPhoto"], a[rel^="prettyPhoto"]').prettyPhoto(lightboxArgs);

		// <?php if($data["lightbox_smartphones"] == 1): ?>
		// 	var windowWidth = 	window.screen.width < window.outerWidth ?
		// 					window.screen.width : window.outerWidth;
		// 	var mobile = windowWidth < 500;

		// 	if(mobile){
		// 		// $('a[href$=jpg], a[href$=JPG], a[href$=jpeg], a[href$=JPEG], a[href$=png], a[href$=gif], a[href$=bmp]:has(img), a[class^="prettyPhoto"]').unbind('click.prettyphoto');
		// 	}
		// <?php endif; ?>
	<?php endif; ?>

	<?php if($ybwp_data['opt-checkbox-stickyheader'] == true) { ?>
		/* ------------------------------------------------------------------------ */
		/* Sticky header scripts */
			if (/Android|BlackBerry|iPhone|iPad|iPod|webOS/i.test(navigator.userAgent) === false) {
				$('#header-v1, #header-v2 #navigation, #header-v3 #navigation').waypoint('sticky');
			}
	<?php } ?>
});

</script>

<?php }
add_action( 'wp_footer', 'yb_js_custom', 100 );
?>