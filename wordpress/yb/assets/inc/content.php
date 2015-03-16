<?php
	global $data;
	global $blogtype;
	if ($blogtype == 'medium') {
		$thumbnail_size = 'blog-medium';
	}
	if ($blogtype == 'large') {
		$thumbnail_size = 'standard';
	}
?>

<div class="post clearfix">

	<?php if ( has_post_thumbnail() ) { ?>
	<div class="post-image">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'yb'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
			<?php the_post_thumbnail($thumbnail_size); ?>
		</a>
	</div>
	<?php } if ( has_post_thumbnail() == '' && $blogtype == 'medium' ) { ?>
	<div class="post-image">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'yb'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><div class="no-post-image"></div></a>
	</div>
	<?php } ?>

	<a href="#" class="post-icon standard"></a>

	<div class="post-content">
		<div class="post-title">
			<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'yb'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</div>
		<div class="post-excerpt"><?php the_excerpt(); ?></div>
	</div>

	<div class="clear"></div>
	<div class="post-meta"><?php get_template_part( 'assets/inc/meta' ); ?></div>

</div>

