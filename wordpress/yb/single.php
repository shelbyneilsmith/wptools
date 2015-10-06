<?php get_header(); ?>


<div id="page-wrap" <?php post_class(); ?>>

	<?php get_template_part('assets/inc/partial/partial', 'blog_title'); ?>

	<div id="page-inner" class="container">
	
		<div id="content">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php get_template_part( 'assets/inc/content/content', get_post_format() ); ?>

				<?php get_template_part('assets/inc/partail/partial', 'sharebox' ); ?>
				<?php get_template_part('assets/inc/partial/partial', 'author_info'); ?>
				<?php get_template_part('assets/inc/partial/partial', 'related_posts'); ?>
				<?php get_template_part('assets/inc/partial/partial', 'comments'); ?>

			<?php endwhile; endif; ?>

		</div> <!-- end #content -->
		<?php get_sidebar(); ?>
	</div><!-- #page-inner -->
</div><!-- #page-wrap -->

<?php get_footer(); ?>