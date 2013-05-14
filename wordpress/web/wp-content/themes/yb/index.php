<?php get_header(); ?>
			
	<div id="content">
	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
				<header class="article-header">
			
					<h1 class="entry-title single-title"><?php the_title(); ?></h1>
			
					<p class="byline vcard">
						By <span class="author"><?php the_author_posts_link(); ?></span> on <time class="updated" datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time('F jS, Y'); ?></time> in <?php the_category(', '); ?>.
					</p>
		
				</header> <!-- end article header -->
	
				<section class="entry-content">
					<?php the_content(); ?>
				</section> <!-- end article section -->
		
				<footer class="article-footer">
					<?php the_tags('<p class="tags"> ', ', ', '</p>'); ?>
				</footer> <!-- end article footer -->
	
				<?php //comments_template(); ?>
	
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
	
		    <article id="post-not-found" class="hentry clearfix">
			    <h1>Oops, Post Not Found!</h1>
	    	</article>
	
	    <?php endif; ?>
                
    </div> <!-- end #content -->
	<?php get_sidebar(); ?>

<?php get_footer(); ?>
