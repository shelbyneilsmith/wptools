<?php get_header(); ?>

<?php echo titlebar(); ?>

<?php
	$page_layout = $ybwp_data['opt-layout'];

	if ( $page_layout === "Full Width" ) {
		$full_width_class = "full-width";
	} else {
		$full_width_class = "";
	}
?>

<div id="page-wrap" <?php post_class(); ?>>
	<div id="page-inner" class="container <?php echo $full_width_class; ?>">
		<div id="content" class="<?php sidebarPosClass($page_layout); ?> columns <?php echo $ybwp_data['opt-select-blogpostlayout']; ?>">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php get_template_part( 'library/inc/post-format/content', get_post_format() ); ?>

			<?php endwhile; ?>

			<?php get_template_part( 'library/inc/nav' ); ?>

			<?php else : ?>

				<h2><?php _e('Not Found', 'yb') ?></h2>

			<?php endif; ?>

		</div> <!-- end #content -->

		<?php if ( ( $page_layout === "Centered Left Sidebar" ) || ( $page_layout === "Centered Right Sidebar" ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>