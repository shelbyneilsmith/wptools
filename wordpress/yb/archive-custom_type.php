<?php get_header(); ?>

<div id="page-wrap" <?php post_class(); ?>>

	<?php get_template_part('assets/inc/partial/partial', 'title_archive'); ?>

	<div id="page-inner" class="container">

		<div id="content" class="">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php get_template_part( 'assets/inc/content/content', get_post_format() ); ?>

			<?php endwhile; ?>

			<?php get_template_part( 'assets/inc/partial/partial', 'pagination' ); ?>

			<?php else : ?>

				<h2><?php _e('Not Found', 'yb') ?></h2>

			<?php endif; ?>

		</div> <!-- #content -->

	<?php get_sidebar(); ?>

	</div><!-- #page-inner -->

</div><!-- #page-wrap -->

<?php get_footer(); ?>