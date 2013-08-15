<?php
/*
This is the custom post type post template.
If you edit the post type name, you've got
to change the name of this template to
reflect that name change.

i.e. if your custom post type is called
register_post_type( 'bookmarks',
then your single template should be
single-bookmarks.php

*/
?>

<?php get_header(); ?>
			
	<div id="content">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
				<header class="article-header">
			
					<h1 class="entry-title single-custom-post-type-title"><?php the_title(); ?></h1>
			
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