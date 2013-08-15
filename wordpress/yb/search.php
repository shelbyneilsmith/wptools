<?php get_header(); ?>
			
	<div id="content">
	
		<h1 class="archive-title"><span>Search Results for:</span> <?php echo esc_attr(get_search_query()); ?></h1>
	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
				<header class="article-header">
			
					<h3 class="search-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			
					<?php echo yb_byline($post); ?>
		
				</header> <!-- end article header -->
	
				<section class="entry-content">
				    <?php the_excerpt('<span class="read-more">Read more &raquo;</span>'); ?>
	
				</section> <!-- end article section -->
			
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
	    		<h1>No Results Found.</h1>
	    		<p>Try your search again.</p>
		    </article>
	
	    <?php endif; ?>
				
	</div> <!-- end #content -->
	<?php get_sidebar(); ?>

<?php get_footer(); ?>