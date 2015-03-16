<?php get_header(); ?>

<?php
	if (!empty($ybwp_data['opt-homelayout']) ) {
		if ($ybwp_data['opt-homelayout'] === "default" ) {
			$page_layout = $ybwp_data['opt-layout'];
		} else {
			$page_layout = $ybwp_data['opt-homelayout'];
		}
	} else {
		$page_layout = $ybwp_data['opt-layout'];
	}
?>

<div id="page-wrap" <?php post_class(); ?>>
	<?php
		if ( $page_layout === "Full Width" ) {
			$full_width_class = "full-width";
		} else {
			$full_width_class = "";
		}
	?>
	<div id="page-inner" class="container <?php echo $full_width_class; ?>">
		<div id="content" class="<?php sidebarPosClass($page_layout); ?> columns">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; endif; ?>

		</div> <!-- end #content -->
		<?php if ( ( $page_layout === "Centered Left Sidebar" ) || ( $page_layout === "Centered Right Sidebar" ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div>
</div> <!-- end page-wrap -->

<?php get_footer(); ?>