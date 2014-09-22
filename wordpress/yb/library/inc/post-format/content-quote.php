<?php
	global $blogtype;
?>

<div class="post clearfix">

	<?php if ($blogtype == 'medium') { ?>
	<div class="post-image">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'yb'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><div class="no-post-image-quote"></div></a>
	</div>
	<?php } ?>

	<a href="<?php echo get_post_format_link('quote'); ?>" class="post-icon quote"></a>

	<div class="post-content">
		<div class="post-quote">
			<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'yb'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
				<?php the_content(); ?>
			</a>

			<span class="quote-source"><a href="<?php echo get_post_meta($post->ID, '_format_quote_source_url', true); ?>" target="_blank">- <?php echo get_post_meta($post->ID, '_format_quote_source_name', true); ?></a></span>
			</h2>
		</div>
	</div>

	<div class="clear"></div>
	<div class="post-meta"><?php get_template_part( 'library/inc/meta' ); ?></div>

</div>

