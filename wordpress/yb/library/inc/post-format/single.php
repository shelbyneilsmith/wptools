<div class="post clearfix">

	<?php if ( has_post_thumbnail() ) { ?>
	<div class="post-image">
		<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" title="<?php the_title(); ?>" rel="bookmark">
			<?php the_post_thumbnail('standard'); ?>
		</a>
	</div>
	<?php } ?>

	<a href="#" class="post-icon standard"></a>

	<div class="post-content">
		<div class="post-title">
			<h1><?php the_title(); ?></h1>
		</div>
		<div class="post-meta"><?php get_template_part( 'library/inc/meta' ); ?></div>
		<div class="post-excerpt"><?php the_content(); ?></div>
		<div class="post-tags clearfix"><?php the_tags( '', '', ''); ?></div>
	</div>

</div>

