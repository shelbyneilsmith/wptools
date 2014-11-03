<?php
	global $data;
	global $blogtype;
?>

<div class="post clearfix">

	<?php if ($blogtype == 'medium') { ?>
	<div class="post-image">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'yb'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><div class="no-post-image-link"></div></a>
	</div>
	<?php } ?>

	<a href="<?php echo get_post_format_link('link'); ?>" class="post-icon link"></a>

	<div class="post-content">
		<div class="post-title">
			<h2><a href="<?php echo esc_attr(get_post_meta($post->ID, '_format_link_url', true)); ?>" title="<?php printf( esc_attr__('Link to %s', 'yb'), the_title_attribute('echo=0') ); ?>" rel="bookmark" target="_blank">
				<?php the_title(); ?>
			</a></h2>
		<div class="post-link"><?php echo esc_attr(get_post_meta($post->ID, '_format_link_url', true)); ?></div>
		</div>
		<div class="post-excerpt"><?php the_excerpt(); ?></div>
	</div>

	<div class="clear"></div>
	<div class="post-meta"><?php get_template_part( 'library/inc/meta' ); ?></div>

</div>