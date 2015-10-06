<?php global $ybwp_data; ?>

<!-- Facebook Open Graph Meta Tags -->
<?php if ( !empty($ybwp_data['opt-media-fbimg']) ) : ?>
	<meta property="og:image" content="<?php echo $ybwp_data['opt-media-fbimg']['url'] ?>"/>
<?php endif; ?>

	<meta property="og:title" content="<?php echo get_the_title(); ?>"/>
	<meta property="og:url" content="<?php echo get_permalink(); ?>"/>
	<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>"/>

<?php
	if ( !empty($ybwp_data['opt-preset-sitetype']) ) {
		if ( $ybwp_data['opt-preset-sitetype'] === "Miscellaneous" ) {
			$site_type = $ybwp_data['opt-text-misc-sitetype'];
		} else {
			$site_type = $ybwp_data['opt-preset-sitetype'];
		}
	} else {
		$site_type = "Miscellaneous";
	}
?>
<?php if ( $site_type !== '' ) : ?>
	<meta property="og:type" content="<?php echo $site_type; ?>"/>
<?php endif; ?>
