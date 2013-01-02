<!doctype html>  

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
	
	<head>
		<meta charset="utf-8">
		
		<title><?php wp_title(''); ?></title>
		
		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="cleartype" content="on">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
		
		<!-- icons & favicons (for more: http://themble.com/support/adding-icons-favicons/) -->
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
				
  		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		
		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->
	    <script type="text/javascript">
			if(navigator.userAgent.indexOf('Silk') != -1) {
				document.write('<link rel="stylesheet" type="text/css" href="<?php echo WP_CONTENT_URL; ?>/themes/bones/library/css/fire.css" />');
			}
		</script>
        <script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>
			
	</head>
	
	<body <?php body_class(); ?>>
	
		<div id="wrapper" class="hfeed clearfix">
			
		    <header>
		    	<div id="header-inner" class="clearfix">
		    	
			    	<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
			    	<!-- be sure to change the img src to actual path of logo image -->
			    	<<?php echo $heading_tag; ?> id="site-title"><a href="<?php bloginfo('url') ?>/" title="<?php bloginfo('name') ?>" rel="home"><img src="/wp-content/themes/bones/library/_images/mainLogo.png" alt="<?php bloginfo('name') ?>" /></a></<?php echo $heading_tag; ?>>
						<!-- if you'd like to use the site description you can un-comment it below -->
						<?php // bloginfo('description'); ?>
		            <nav role="navigation" class="main">
								<?php //bones_main_nav(); ?>
		                <ul class="nav">
		                    <?php wp_list_pages('title_li=&depth=0&sort_column=menu_order'); ?>
		                </ul>
		            </nav>
		    
				</div>
			</header><!-- #header-->
		
		    <div id="main" class="clearfix">
