<?php global $ybwp_data; ?>

<?php if( $ybwp_data['opt-checkbox-authorinfo'] ) { ?>

<div id="author-info" class="clearfix">
	<div class="author-image two columns">
		<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( get_the_author_meta('user_email'), '35', '' ); ?></a>
	</div>

	<div class="fourteen columns author-bio">
		<h4><?php _e('About the Author', 'yb'); ?></h4>
		<?php the_author_meta('description'); ?>
	</div>
</div>

<?php } ?>