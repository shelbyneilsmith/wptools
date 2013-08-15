<?php get_header(); ?>
			
	<div id="content">
							
	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			    <header class="article-header">
				
				    <h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				
					<?php echo yb_byline($post); ?>
			
			    </header> <!-- end article header -->
		
			    <section class="entry-content">
			
				    <?php //the_post_thumbnail( 'bones-thumb-300' ); ?>
			
				    <?php the_excerpt('<span class="read-more">Read More &raquo;</span>'); ?>
		
			    </section> <!-- end article section -->
			
			    <footer class="article-footer">
					<?php the_tags('<p class="tags"> ', ', ', '</p>'); ?>
			    </footer> <!-- end article footer -->
		
		    </article> <!-- end article -->
	
	    <?php endwhile; ?>	
	
	        <?php if (function_exists('yb_pagination')) { ?>
		        <?php yb_pagination(); ?>
	        <?php } else { ?>
		        <nav class="yb-pagination">
			        <ul>
				        <li class="prev-link"><?php next_posts_link('&laquo; Older Entries') ?></li>
				        <li class="next-link"><?php previous_posts_link('Newer Entries &raquo;') ?></li>
			        </ul>
	    	    </nav>
	        <?php } ?>
	
	    <?php else : ?>
	
		    <article id="post-not-found">
			    <h1>Oops, Post Not Found!</h1>
	    	</article>
	
	    <?php endif; ?>
                
    </div> <!-- end #content -->
	<?php get_sidebar(); ?>

<?php get_footer(); ?>