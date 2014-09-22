<div class="post clearfix">

	<a href="<?php echo get_post_format_link('link'); ?>" class="post-icon link"></a>

	<div class="post-content">
		<div class="post-title">
			<h1><a href="<?php echo esc_attr(get_post_meta($post->ID, '_format_link_url', true)); ?>" title="<?php printf( esc_attr__('Link to %s', 'yb'), the_title_attribute('echo=0') ); ?>" rel="bookmark" target="_blank">
				<?php the_title(); ?>
			</a></h1>
		<div class="post-link"><?php echo esc_attr(get_post_meta($post->ID, '_format_link_url', true)); ?></div>
		</div>
		<div class="post-meta"><?php get_template_part( 'library/inc/meta' ); ?></div>
		<div class="post-excerpt"><?php the_content(); ?></div>
		<div class="post-tags clearfix"><?php the_tags( '', '', ''); ?></div>
	</div>

</div>