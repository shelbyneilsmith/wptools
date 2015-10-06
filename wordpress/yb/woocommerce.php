<?php get_header(); ?>

<div id="page-wrap" <?php post_class(); ?>>

  <?php get_template_part('assets/inc/partial/partial', 'title_page'); ?>

	<div id="page-inner" class="container">
	
		<div id="content" class="">

			<?php woocommerce_content(); ?>

		</div> <!-- #content -->

		<?php get_sidebar(); ?>
		
	</div> <!-- #page-inner -->

</div> <!-- #page-wrap -->

<?php get_footer(); ?>