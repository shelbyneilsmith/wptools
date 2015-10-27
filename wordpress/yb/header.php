<!DOCTYPE html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<?php global $ybwp_data; ?>

<head>
	<meta charset="utf-8">

	<?php get_template_part('assets/inc/header/header', 'title'); ?>

	<?php get_template_part('assets/inc/header/header', 'meta'); ?>

	<link rel="shortcut icon" href="/wp-content/themes/yb/favicon.ico">
	<link rel="shortcut icon" href="/wp-content/themes/yb/favicon.png">

	<?php get_template_part('assets/inc/header/header', 'blog_pingback'); ?>

	<!-- start wordpress head -->
	<?php wp_head(); ?>
	<!-- end wordpress head -->

	<?php get_template_part('assets/inc/header/header', 'comments'); ?>
	<?php get_template_part('assets/inc/header/header', 'typekit'); ?>

	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>

<body <?php body_class(); ?>>

	<?php get_template_part('assets/inc/header/header', 'bp_indicator'); ?>

	<div id="wrapper">
		<header id="site-masthead" class="clearfix">
			<div class="container">
				<?php get_template_part('assets/inc/partial/partial', 'search'); ?>
				<?php get_template_part('assets/inc/header/header', 'utility_nav'); ?>

				<?php get_template_part('assets/inc/header/header', 'logo'); ?>

				<?php get_template_part('assets/inc/header/header', 'main_nav'); ?>
			</div>
		</header><!-- .site-masthead-->