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

	<div class="post-gallery flexslider">
		<?php if ( $images = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image' ))){ ?>
		<ul class="slides">
			<?php foreach( $images as $image ) :  ?>
				<li><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'yb'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php echo wp_get_attachment_image($image->ID, $thumbnail_size); ?></a></li>
			<?php endforeach; ?>
		</ul>
		<?php } ?>
	</div>

	<a href="<?php echo get_post_format_link('gallery'); ?>" class="post-icon imagegallery"></a>

	<div class="post-content">
		<div class="post-title">
			<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'yb'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
				<?php the_title(); ?>
			</a></h2>
		</div>
		<div class="post-excerpt"><?php the_excerpt(); ?></div>
	</div>

	<div class="clear"></div>

	<div class="post-meta"><?php get_template_part( 'library/inc/meta' ); ?></div>

</div>

