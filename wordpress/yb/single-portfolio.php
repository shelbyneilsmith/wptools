<?php get_header(); ?>

<?php echo titlebar(); ?>

<div id="page-wrap" <?php post_class(); ?>>
	<div id="page-inner" class="container">

		<div id="content">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php if ( get_post_meta( get_the_ID(), 'yb_portfolio-detaillayout', true ) == "wide" ) {
				get_template_part( 'library/inc/portfolio/wide' );
			} else {
				get_template_part( 'library/inc/portfolio/sidebyside' );
			}
			?>

			<?php if( get_post_meta( get_the_ID(), 'yb_portfolio-relatedposts', true ) == 1 ) { // Show related Posts Projects specific ?>

				<div class="clear"></div>

				<div id="portfolio-related-post">

					<h3 class="title"><span><?php _e('Related Projects', 'yb'); ?></span></h3>

					<?php
					$terms = get_the_terms( $post->ID , 'portfolio_filter', 'string');
					$term_ids = array_values( wp_list_pluck( $terms,'term_id' ) );
					$second_query = new WP_Query( array(
						'post_type' => 'portfolio',
						'tax_query' => array(
							array(
								'taxonomy' => 'portfolio_filter',
								'field' => 'id',
								'terms' => $term_ids,
								'operator'=> 'IN' //Or 'AND' or 'NOT IN'
							)),
						'posts_per_page' => 4,
						'ignore_sticky_posts' => 1,
						'orderby' => 'date',  // 'rand' for random order
						'post__not_in'=>array($post->ID)
					) );

					//Loop through posts and display...
					if($second_query->have_posts()) {
						while ($second_query->have_posts() ) : $second_query->the_post(); ?>

						      <div class="portfolio-item four columns">

								    <?php // Define if Lightbox Link or Not

									$embedd = '';

									if( get_post_meta( get_the_ID(), 'yb_portfolio-lightbox', true ) == "true") {
										$lightboxtype = '<span class="overlay-lightbox"></span>';
										if( get_post_meta( get_the_ID(), 'yb_embed', true ) != "") {
												if ( get_post_meta( get_the_ID(), 'yb_source', true ) == 'youtube' ) {
													$link = '<a href="http://www.youtube.com/watch?v='.get_post_meta( get_the_ID(), 'yb_embed', true ).'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
							    				} else if ( get_post_meta( get_the_ID(), 'yb_source', true ) == 'vimeo' ) {
							    					$link = '<a href="http://vimeo.com/'. get_post_meta( get_the_ID(), 'yb_embed', true ) .'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
							    				} else if ( get_post_meta( get_the_ID(), 'yb_source', true ) == 'own' ) {
							    					$randomid = rand();
							    					$link = '<a href="#embedd-video-'.$randomid.'" class="prettyPhoto" title="'. get_the_title() .'" rel="prettyPhoto[portfolio]">';
							    					$embedd = '<div id="embedd-video-'.$randomid.'" class="embedd-video"><p>'. get_post_meta( get_the_ID(), 'yb_embed', true ) .'</p></div>';
												}
										} else {
											$link = '<a href="'. wp_get_attachment_url( get_post_thumbnail_id() ) .'" class="prettyPhoto" rel="prettyPhoto[portfolio]" title="'. get_the_title() .'">';
							    		}
							    	}
									else{
										$lightboxtype = '<span class="overlay-link"></span>';
										$link = '<a href="'. get_permalink() .'" title="'. get_the_title() .'">';
										$embedd = '';
									} ///// ?>

									<?php if ( has_post_thumbnail()) { ?>
										<div class="portfolio-it">
									  		<?php echo $link; ?><span class="portfolio-pic"><?php the_post_thumbnail('eight-columns'); ?><div class="portfolio-overlay"><?php echo $lightboxtype; ?></div></span></a>
									  		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="portfolio-title"><h4><?php the_title(); ?></h4>
									  		<span><?php if(get_post_meta( get_the_ID(), "yb_subtitle", true ) != '' ) { echo get_post_meta( get_the_ID(), "yb_subtitle", true ); } else { echo substr(get_the_excerpt(),0,25).'...'; } ?></span></a>
									  	</div>
									  	<?php echo $embedd; ?>
									<?php } ?>

						      </div>
						   <?php endwhile; wp_reset_query(); ?>
					<?php } ?>

				</div> <!-- end of portfolio-related-posts -->

			<?php } //end related specific ?>

			<div class="clear"></div>

			<div class="sixteen columns portfolio-comments"><?php comments_template(); ?></div>

			<?php endwhile; endif; ?>

		</div> <!-- end of content -->
	</div>
</div> <!-- end of page-wrap -->

<?php get_footer(); ?>