<!DOCTYPE html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<title>
		<?php
			if (!is_front_page()) {
				wp_title('');
				echo " | ";
			}
			bloginfo('name');
			echo " - ";
			bloginfo('description');
		?>
		</title>

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="cleartype" content="on">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- icons & favicons (for more: http://themble.com/support/adding-icons-favicons/) -->
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">

		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->
		<!--<script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>-->

	</head>

	<body <?php body_class(); ?>>

		<div id="wrapper">

			<header class="site-masthead">
				<div class="masthead-inner">

					<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>

					<!-- be sure to change the img src to actual path of logo image -->
					<<?php echo $heading_tag; ?> id="site-title">
						<a href="<?php bloginfo('url') ?>/" title="<?php bloginfo('name') ?>" rel="home">
							<img src="/wp-content/themes/yb/library/_images/mainLogo.png" alt="<?php bloginfo('name') ?>" />
						</a>
					</<?php echo $heading_tag; ?>>

					<!-- if you'd like to use the site description you can un-comment it below -->
					<?php // bloginfo('description'); ?>

					<?php //wp_nav_menu( array('theme_location' => 'aux-nav', 'container' => 'nav', 'container_id' => 'aux-nav-header', 'container_class' => 'aux-nav' )); ?>

					<?php wp_nav_menu( array('theme_location' => 'main-nav', 'container' => 'nav', 'container_id' => 'main-nav-header', 'container_class' => 'main-nav' )); ?>

				</div>
			</header><!-- site masthead-->

		    <section id="main">
