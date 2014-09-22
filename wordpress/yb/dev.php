<?php global $ybwp_data; ?>
<!doctype html>
<html>
	<head>
		<title><?php echo get_bloginfo('name'); ?> Project Links</title>
		<link rel="stylesheet" href="http://www.ybdevel.com/dev/css/screen.css">

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0" />
	</head>

	<div class="logo">
		<img src="http://www.ybdevel.com/dev/images/yb-logo.png" alt="">
	</div>

	<div id="design-directory">

		<div class="banner">
			<h1 class="page-title"><?php echo get_bloginfo('name'); ?> Project Links</h1>
		</div>

		<div class="links">
			<div id="wireframe-links">
				<h3>Wireframes</h3>
				<?php wp_nav_menu( array('menu' => 'Wireframes Navigation' )); ?>
			</div>

			<div id="styletile-links">
				<h3>Style Tiles</h3>
				<a class="style-viewer-link" href="/styletiles/">View All</a>
				<br><br>
				<?php echo styleTileLinks($ybwp_data['opt-text-styletilesnum'], range('a', 'z')); ?>
			</div>
		</div>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php the_content(); ?>

			<?php endwhile; endif; ?>

	</div>

	<body>

	</body>
</html>