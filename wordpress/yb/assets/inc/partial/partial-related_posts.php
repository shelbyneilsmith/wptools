<?php global $ybwp_data; ?>

<?php if( $ybwp_data['opt-checkbox-relatedposts'] ) { ?>

<div id="related-posts">
	<?php
							/* for use in the loop, list 5 post titles related to first tag on current post */
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
		?>

		<h3 class="title"><span><?php _e('Related Posts', 'yb'); ?></span></h3>

		<ul>
			<?php  $first_tag = $tags[0]->term_id;
			$args=array(
				'tag__in' => array($first_tag),
				'post__not_in' => array($post->ID),
				'showposts'=>3
				);
			$my_query = new WP_Query($args);
			if( $my_query->have_posts() ) {
				while ($my_query->have_posts()) : $my_query->the_post(); ?>
				<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?> <span>(<?php the_time(get_option('date_format')); ?>)</span></a></li>
				<?php
				endwhile;
				wp_reset_query();
			}
		}
		?>
	</ul>
</div>

<?php } ?>