<?php global $ybwp_data; ?>
<!doctype html>
<html>
<head>
	<title><?php echo get_bloginfo('name'); ?> Wireframes</title>
	<link rel="stylesheet" href="http://www.ybdevel.com/dev/css/screen.css">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0" />
</head>

<body>
	<div class="logo">
		<a href="//yellowberri.com">
			<img src="http://www.ybdevel.com/dev/images/yb-logo.png" alt="Yellowberri">
		</a>
	</div>

	<div id="design-directory">

		<div class="banner">
			<h1 class="page-title"><?php echo get_bloginfo('name'); ?> Wireframes</h1>
		</div>

		<div class="links">
			<div id="wireframe-links">
				<?php wp_nav_menu( array('menu' => 'Wireframes Navigation' )); ?>
			</div>
		</div>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; endif; ?>

	</div>
</body>
</html>