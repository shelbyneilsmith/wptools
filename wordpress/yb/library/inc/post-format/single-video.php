<div class="post clearfix">

	<div class="post-video">
		<?php echo get_post_meta($post->ID, '_format_video_embed', true); ?>
	</div>

	<a href="<?php echo get_post_format_link('video'); ?>" class="post-icon video"></a>

	<div class="post-content">
		<div class="post-title">
			<h1><?php the_title(); ?></h1>
		</div>
		<div class="post-meta"><?php get_template_part( 'library/inc/meta' ); ?></div>
		<div class="post-excerpt"><?php the_content(); ?></div>
		<div class="post-tags clearfix"><?php the_tags( '', '', ''); ?></div>
	</div>

</div>