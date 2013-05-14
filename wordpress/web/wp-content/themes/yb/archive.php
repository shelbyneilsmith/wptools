<?php get_header(); ?>
			
	<div id="content">

	    <?php if (is_category()) { ?>
		    <h1 class="archive-title">
			    <span>Posts Categorized:</span> <?php single_cat_title(); ?>
	    	</h1>
	    
	    <?php } elseif (is_tag()) { ?> 
		    <h1 class="archive-title">
			    <span>Posts Tagged:</span> <?php single_tag_title(); ?>
		    </h1>
	    
	    <?php } elseif (is_author()) { 
	    	global $post;
	    	$author_id = $post->post_author;
	    ?>
		    <h1 class="archive-title">
		    	<span>Posts By:</span> <?php echo get_the_author_meta('display_name', $author_id); ?>
		    </h1>
	    <?php } elseif (is_day()) { ?>
		    <h1 class="archive-title">
				<span>Daily Archives:</span> <?php the_time('l, F j, Y'); ?>
		    </h1>

		<?php } elseif (is_month()) { ?>
		    <h1 class="archive-title">
    	    	<span>Monthly Archives:</span> <?php the_time('F Y'); ?>
	        </h1>
	
	    <?php } elseif (is_year()) { ?>
	        <h1 class="archive-title">
	    	    <span>Yearly Archives:</span> <?php the_time('Y'); ?>
	        </h1>
	    <?php } ?>

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