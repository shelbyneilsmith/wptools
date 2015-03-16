<?php get_header(); ?>

<?php
	$page_title = get_the_title();
	$page_layout = $ybwp_data['opt-woocommercelayout'];

	if ( $page_layout === "Full Width" ) {
		$full_width_class = "full-width";
	} else {
		$full_width_class = "";
	}
?>

<div id="title">
	<div class="container <?php echo $full_width_class; ?>">
		<h1 class="page-title"><?php echo $page_title; ?></h1>

		<?php if( !empty($ybwp_data['opt-checkbox-breadcrumbs'] ) ) : ?>
			<?php echo $breadcrumbs; ?>
		<?php endif; ?>
	</div>
</div>

<div id="page-wrap" <?php post_class(); ?>>
	<div id="page-inner" class="container <?php echo $full_width_class; ?>">
		<div id="content" class="<?php sidebarPosClass($page_layout); ?> columns">
			<?php woocommerce_content(); ?>
		</div> <!-- end #content -->

		<?php if ( ( $page_layout === "Centered Left Sidebar" ) || ( $page_layout === "Centered Right Sidebar" ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div>
</div> <!-- end page-wrap -->

<?php get_footer(); ?>