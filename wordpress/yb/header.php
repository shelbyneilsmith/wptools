<!DOCTYPE html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<?php global $ybwp_data; ?>
<head>
	<meta charset="utf-8">

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<meta http-equiv="cleartype" content="on">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include_once( 'library/inc/fb_open_graph.php' ); ?>

	<?php if(!empty($ybwp_data['media-favicon_front']['url'])) { ?><link rel="shortcut icon" href="<?php echo $ybwp_data['media-favicon_front']['url']; ?>"><?php } ?>

	<?php if(!empty($ybwp_data['media-favicon_iphone']['url'])) { ?><link rel="apple-touch-icon" href="<?php echo $ybwp_data['media-favicon_iphone']['url']; ?>"><?php } ?>

	<?php if(!empty($ybwp_data['media-favicon_iphone_retina']['url'])) { ?><link rel="apple-touch-icon" sizes="114x114" href="<?php echo $ybwp_data['media-favicon_iphone_retina']['url']; ?>"><?php } ?>

	<?php if(!empty($ybwp_data['media-favicon_ipad']['url'])) { ?><link rel="apple-touch-icon" sizes="72x72" href="<?php echo $ybwp_data['media-favicon_ipad']['url']; ?>"><?php } ?>

	<?php if(!empty($ybwp_data['media-favicon_ipad_retina']['url'])) { ?><link rel="apple-touch-icon" sizes="144x144" href="<?php echo $ybwp_data['media-favicon_ipad_retina']['url']; ?>"><?php } ?>

	<?php if ( !empty($ybwp_data['opt-checkbox-blog'] )) : ?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php endif; ?>

	<?php if( !empty($ybwp_data['opt-checkbox-pagecomments']) || !empty($ybwp_data['opt-checkbox-blogcomments'] ) ) : ?>
		<?php if ( is_single() && comments_open() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php endif; ?>

	<?php wp_head(); ?>

	<!--<script type="text/javascript" src="//wurfl.io/wurfl.js"></script>-->

	<?php if (!empty($ybwp_data['opt-text-typekitid'])) : ?>
		<script src="//use.typekit.net/<?php echo $ybwp_data['opt-text-typekitid']; ?>.js"></script>
		<script>try{Typekit.load();}catch(e){}</script>
	<?php endif; ?>
	<!-- end of wordpress head -->
</head>

<body <?php body_class(); ?><?php main_bg(); ?>>
	<?php if ( ((WP_ENV == 'development') || (WP_ENV == 'staging')) && !empty($ybwp_data['opt-checkbox-bpindicator'] ) ) : ?>
		<div class="break-indicator"></div>
	<?php endif; ?>
	<?php
		if ( !empty($ybwp_data['opt-layout']) && !empty($ybwp_data['opt-homelayout']) ) {
			if ( ( $ybwp_data['opt-layout'] === "Full Width" ) || ( $ybwp_data['opt-homelayout'] === "Full Width" ) ) {
				$full_width_class = "full-width";
			} else {
				$full_width_class = "";
			}
		}
	?>

	<div id="wrapper">

		<?php if( !empty($ybwp_data['opt-checkbox-topbar'] ) ) { ?>
			<div id="topbar" class="clearfix">
				<div class="container <?php echo $full_width_class; ?>">
					<?php if(!empty($ybwp_data['opt-textarea-callus'])) { ?>
						<div class="callus column"><?php echo $ybwp_data['opt-textarea-callus']; ?></div>
					<?php } ?>
					<?php if( !empty($ybwp_data['opt-checkbox-socialtopbar'] ) ) { ?>
						<?php if (outputSocialIcons()) : ?>
						<nav class="social-icons clearfix column">
							<ul>
								<?php echo outputSocialIcons(); ?>
							</ul>
						</nav>
						<?php endif; ?>
					<?php } ?>
					<?php if ( !empty($ybwp_data['opt-checkbox-utilnav'] ) ) : ?>
						<?php
							if ( $ybwp_data['opt-checkbox-utilitynavmerge'] ) {
								$utilmerge = ' util-merge';
							} else {
								$utilmerge = '';
							}
						?>
						<?php wp_nav_menu( array('theme_location' => 'util-nav', 'container' => 'nav', 'container_id' => 'util-nav-header', 'container_class' => "util-nav$utilmerge column" )); ?>
					<?php endif; ?>
				</div>
			</div> <!-- end topbar -->
		<?php } ?>

		<?php
			if(!empty($ybwp_data['opt-header_layout'])) {
				$header_id = $ybwp_data['opt-header_layout'];
			} else {
				$header_id = "v1";
			}
		?>

		<header id="header-<?php echo $header_id; ?>" class="site-masthead clearfix">
				<?php include_once('library/inc/headers/header-'.$header_id.'.php'); ?>
		</header><!-- site masthead-->
