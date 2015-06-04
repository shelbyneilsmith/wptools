<!DOCTYPE html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<?php
	global $ybwp_data;
?>
<head>
	<meta charset="utf-8">

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<meta http-equiv="cleartype" content="on">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include_once( 'assets/inc/fb_open_graph.php' ); ?>

	<link rel="shortcut icon" href="/wp-content/themes/yb/favicon.png">

	<?php if ( !empty($ybwp_data['opt-checkbox-blog'] )) : ?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php endif; ?>

	<?php if( !empty($ybwp_data['opt-checkbox-pagecomments']) || !empty($ybwp_data['opt-checkbox-blogcomments'] ) ) : ?>
		<?php if ( is_single() && comments_open() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php endif; ?>

	<?php wp_head(); ?>

	<?php if (!empty($ybwp_data['opt-text-typekitid'])) : ?>
		<script>
		(function(d) {
			var config = {
				kitId: '<?php echo $ybwp_data['opt-text-typekitid']; ?>',
				scriptTimeout: 3000
			},
			h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
		})(document);
		</script>
		<style>
		.wf-loading {
			visibility: hidden;
		}
		.wf-active {
			visibility: visible;
		}
		</style>
	<?php endif; ?>
	<!-- end of wordpress head -->
</head>

<body <?php body_class(); ?>>
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
		<header class="site-masthead clearfix">
			<div class="container <?php echo $full_width_class; ?>">
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

				<?php
					$logo_url = "";
					$logo_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';
				?>

				<?php echo "<$logo_tag class='site-title'>"; ?>
					<?php if ( $logo_url ) { ?>
						<a href="<?php echo home_url(); ?>/" title="<?php bloginfo('name') ?>" rel="home">
							<img src="<?php echo $logo_url; ?>" width="200" alt="<?php bloginfo('name'); ?>" />
						</a>
					<?php } else { ?>
						<a href="<?php echo home_url(); ?>/" rel="home"><?php bloginfo('name'); ?></a>
					<?php } ?>

				<?php echo "</$logo_tag>"; ?>

				<div id="navigation" class="clearfix">
					<?php if ( !empty($ybwp_data['opt-checkbox-searchform'] ) ) : ?>
						<form action="<?php echo home_url(); ?>/" class="header-searchform" method="get">
							<input type="text" id="header-s" name="s" value="" autocomplete="off" />
							<input type="submit" value="Search" id="header-searchsubmit" />
						</form>
					<?php endif; ?>

					<?php if (class_exists('Woocommerce') && !empty($ybwp_data['opt-checkbox-woocommerce']) && !empty($ybwp_data['opt-checkbox-woocommerceicon'])) { // Check if WooCommerce Exists ?>
						<?php global $woocommerce; ?>
						<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" id="header-cart" title="<?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>">View Cart</a>
					<?php } ?>

					<?php wp_nav_menu( array('theme_location' => 'main-nav', 'container' => 'nav', 'container_id' => 'main-nav-header', 'container_class' => "main-nav drop-menu" )); ?>
				</div>
			</div>
		</header><!-- site masthead-->
