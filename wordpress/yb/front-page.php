<?php get_header(); ?>

<div id="page-wrap" <?php post_class(); ?>>

	<div id="page-inner" class="container">

		<div id="content" class="">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php the_content(); ?>

			<?php endwhile; endif; ?>

		</div> <!-- end #content -->

		<?php get_sidebar(); ?>

	</div> <!-- #page-inner -->

</div> <!-- #page-wrap -->

<?php get_footer(); ?>