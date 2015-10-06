<?php
/* ------------------------------------------------------------------------ */
/* content.php */
/* Used to display information *within* the loop */
/* This is the fallback for content types not found:  */
/* EG: get_template_part('assets/inc/content/content', 'wonteverexist'); returns this template */
/* ------------------------------------------------------------------------ */
?>

<div class="content-post content-default clearfix">

	<?php if ( has_post_thumbnail() ) { ?>
	<div class="post-image">
		<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>" title="<?php the_title(); ?>" rel="bookmark">
			<?php the_post_thumbnail('standard'); ?>
		</a>
	</div>
	<?php } ?>

	<a href="#" class="post-icon standard"></a>

	<div class="post-content">
		<h2 class="post-title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?></h2>
			</a>
			<div class="post-meta"><?php get_template_part( 'assets/inc/partial/partial', 'meta' ); ?></div>
			<div class="post-excerpt"><?php the_content(); ?></div>
			<div class="post-tags clearfix"><?php the_tags( '', '', ''); ?></div>
		</div>

	</div>

