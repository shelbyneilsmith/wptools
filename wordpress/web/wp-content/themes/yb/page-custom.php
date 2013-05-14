<?php
/*
Template Name: Custom Page Example
*/
?>

<?php get_header(); ?>
			
	<div id="content">
	
	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
			<h1 class="page-title"><?php the_title(); ?></h1>
		
		    <section id="post-<?php the_ID(); ?>" <?php post_class('entry-content'); ?>>
		    
			    <?php the_content(); ?>
			    
			</section> <!-- end article section -->
		
	    <?php endwhile; endif; ?>    
	    
	</div> <!-- end #content -->
	
	<?php get_sidebar(); ?>

<?php get_footer(); ?>