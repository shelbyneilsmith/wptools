<?php get_header(); ?>
			
	<div id="content">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
				<header class="article-header">
			
					<h1 class="entry-title single-title"><?php the_title(); ?></h1>
			
					<?php echo yb_byline($post); ?>
		
				</header> <!-- end article header -->
	
				<section class="entry-content">
				
					<?php the_content(); ?>
					
				</section> <!-- end article section -->
		
				<footer class="article-footer">
					<?php the_tags('<p class="tags"> ', ', ', '</p>'); ?>
				</footer> <!-- end article footer -->
	
				<?php //comments_template(); ?>
	
			</article> <!-- end article -->
	
		<?php endwhile; endif; ?>

	</div> <!-- end #content -->
	<?php get_sidebar(); ?>

<?php get_footer(); ?>