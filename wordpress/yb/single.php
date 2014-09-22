<?php get_header(); ?>

<?php get_template_part( 'library/inc/titlebar' ); ?>

<?php
	if ($ybwp_data['opt-bloglayout'] === "default" ) {
		$page_layout = $ybwp_data['opt-layout'];
	} else {
		$page_layout = $ybwp_data['opt-bloglayout'];
	}
?>

<div id="page-wrap" class="clearfix">
	<?php
		if ( $page_layout === "Full Width" ) {
			$full_width_class = "full-width";
		} else {
			$full_width_class = "";
		}
	?>
	<div id="page-inner" class="container <?php echo $full_width_class; ?>">

		<?php
			if ( ( $page_layout === "Centered Left Sidebar" ) || ( $page_layout === "Centered Right Sidebar" ) ) {
				$contentColumns = "twelve";
				if ( $page_layout === "Centered Left Sidebar" ) {
					$sidebar_pos = 'sidebar-left';
				}
				if ( $page_layout === "Centered Right Sidebar" ) {
					$sidebar_pos = 'sidebar-right';
				}
			} else {
				$contentColumns = "sixteen";
				$sidebar_pos = '';
			}
		?>
		<div id="content" class="<?php echo $sidebar_pos; ?> <?php echo $contentColumns; ?> columns">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php get_template_part( 'library/inc/post-format/single', get_post_format() ); ?>

				<?php if( $ybwp_data['opt-checkbox-sharebox'] ) { ?>
					<?php get_template_part( 'library/inc/sharebox' ); ?>
				<?php } ?>

				<?php if( $ybwp_data['opt-checkbox-authorinfo'] ) { ?>
				<div id="author-info" class="clearfix">
					    <div class="author-image">
					    	<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( get_the_author_meta('user_email'), '35', '' ); ?></a>
					    </div>
					    <div class="author-bio">
					        <h4><?php _e('About the Author', 'yb'); ?></h4>
					        <?php the_author_meta('description'); ?>
					    </div>
				</div>
				<?php } ?>

				<?php if( $ybwp_data['opt-checkbox-relatedposts'] ) { ?>

				<div id="related-posts">
						<?php
						//for use in the loop, list 5 post titles related to first tag on current post
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

				<?php if ( !$ybwp_data['opt-checkbox-blogcomments'] ) : ?>
					<div class="comments"><?php comments_template(); ?></div>
				<?php endif; ?>

			<?php endwhile; endif; ?>

		</div> <!-- end #content -->
		<?php if ( ( $page_layout === "Centered Left Sidebar" ) || ( $page_layout === "Centered Right Sidebar" ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>