<!DOCTYPE html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<?php global $ybwp_data; ?>
<head>
	<meta charset="utf-8">

	<title>
	<?php
		$page_title = '';

		if (!is_front_page()) {
			$page_title .= wp_title('');
			$page_title .= " | ";
		}
		$page_title .= get_bloginfo('name');
		$page_title .= " - ";
		$page_title .= get_bloginfo('description');

		echo $page_title;
	?>
	</title>

	<!-- Google Chrome Frame for IE -->
	<meta http-equiv="cleartype" content="on">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!-- mobile meta (hooray!) -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Facebook Open Graph Meta Tags -->
	<?php if ( !empty($ybwp_data['opt-media-fbimg']) ) : ?>
	<meta property="og:image" content="<?php echo $ybwp_data['opt-media-fbimg']['url'] ?>"/>
	<?php endif; ?>

	<meta property="og:title" content="<?php echo $page_title; ?>"/>
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

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Mobile Specific Metas & Favicons
	========================================================= -->
	<?php if(!empty($ybwp_data['media-favicon_front']['url'])) { ?><link rel="shortcut icon" href="<?php echo $ybwp_data['media-favicon_front']['url']; ?>"><?php } ?>

	<?php if(!empty($ybwp_data['media-favicon_iphone']['url'])) { ?><link rel="apple-touch-icon" href="<?php echo $ybwp_data['media-favicon_iphone']['url']; ?>"><?php } ?>

	<?php if(!empty($ybwp_data['media-favicon_iphone_retina']['url'])) { ?><link rel="apple-touch-icon" sizes="114x114" href="<?php echo $ybwp_data['media-favicon_iphone_retina']['url']; ?>"><?php } ?>

	<?php if(!empty($ybwp_data['media-favicon_ipad']['url'])) { ?><link rel="apple-touch-icon" sizes="72x72" href="<?php echo $ybwp_data['media-favicon_ipad']['url']; ?>"><?php } ?>

	<?php if(!empty($ybwp_data['media-favicon_ipad_retina']['url'])) { ?><link rel="apple-touch-icon" sizes="144x144" href="<?php echo $ybwp_data['media-favicon_ipad_retina']['url']; ?>"><?php } ?>

	<!-- WordPress Stuff
	========================================================= -->
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if( !empty($ybwp_data['opt-checkbox-pagecomments']) || !empty($ybwp_data['opt-checkbox-blogcomments'] ) ) : ?>
		<?php if ( is_single() && comments_open() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php endif; ?>

	<?php wp_head(); ?>
	<!-- end of wordpress head -->
	<!--<script type="text/javascript" src="//wurfl.io/wurfl.js"></script>-->

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
			<div id="topbar" class="clearfix <?php if($ybwp_data['opt-checkbox-socialtopbar'] == false) { echo 'no-social'; } ?>">
				<div class="container <?php echo $full_width_class; ?>">
				<?php if(!empty($ybwp_data['opt-textarea-callus'])) { ?>
					<?php if( !empty($ybwp_data['opt-checkbox-socialtopbar'] ) || !empty($ybwp_data['opt-checkbox-utilnav'] ) ) { ?>
						<div class="eight columns">
					<?php } else { ?>
						<div class="sixteen columns">
					<?php } ?>
							<div class="callus"><?php echo $ybwp_data['opt-textarea-callus']; ?></div>
							<div class="clear"></div>
					</div>
					<?php if( !empty($ybwp_data['opt-checkbox-socialtopbar']) || !empty($ybwp_data['opt-checkbox-utilnav'] ) ) { ?>
						<div class="eight columns">
					<?php } ?>
				<?php } else { ?>
					<?php if( !empty($ybwp_data['opt-checkbox-socialtopbar'] ) || !empty($ybwp_data['opt-checkbox-utilnav'] ) ) { ?>
						<div class="sixteen columns">
					<?php } ?>
				<?php } ?>
						<?php if( !empty($ybwp_data['opt-checkbox-socialtopbar'] ) ) { ?>
							<?php if (outputSocialIcons()) : ?>
							<nav class="social-icons clearfix">
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
							<?php wp_nav_menu( array('theme_location' => 'util-nav', 'container' => 'nav', 'container_id' => 'util-nav-header', 'container_class' => "util-nav$utilmerge" )); ?>
						<?php endif; ?>
					<?php if( !empty($ybwp_data['opt-checkbox-socialtopbar'] ) || !empty($ybwp_data['opt-checkbox-utilnav'] ) ) { ?>
						</div>
					<?php } ?>
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
