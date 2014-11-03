<div class="post clearfix">

	<div class="post-gallery flexslider">
		<?php if ( $images = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image' ))){ ?>
		<ul class="slides">
			<?php foreach( $images as $image ) :  ?>
				<li><?php echo wp_get_attachment_link($image->ID, 'standard'); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php } ?>
	</div>

	<a href="<?php echo get_post_format_link('gallery'); ?>" class="post-icon imagegallery"></a>

	<div class="post-content">
		<div class="post-title">
			<h1><?php the_title(); ?></h1>
		</div>
		<div class="post-meta"><?php get_template_part( 'library/inc/meta' ); ?></div>
		<div class="post-excerpt"><?php the_content(); ?></div>
		<div class="post-tags clearfix"><?php the_tags( '', '', ''); ?></div>
	</div>

</div>

