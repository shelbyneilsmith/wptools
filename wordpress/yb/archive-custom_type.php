<?php get_header(); ?>

<?php
	if (is_category()) {
		$page_title = _e('Category Archive for', 'yb') . '&#8216;' . single_cat_title() . '&#8217;';
	} elseif( is_tag() ) {
		$page_title = _e('Posts Tagged', 'yb') . '&#8216;' . single_tag_title() . '&#8217;';
	} elseif (is_day()) {
		$page_title = _e('Archive for', 'yb') . the_time('F jS, Y');
	} elseif (is_month()) {
		$page_title = _e('Archive for', 'yb') . the_time('F, Y');
	} elseif (is_year()) {
		$page_title = _e('Archive for', 'yb') . the_time('Y');
	} elseif (is_author()) {
		$page_title = _e('Author Archive', 'yb');
	} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
		$page_title = _e('Blog Archives', 'yb');
	} elseif (is_shop()) {
		$page_title = woocommerce_page_title();
	}

	$page_layout = $ybwp_data['opt-layout'];

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
		<div id="content" class="<?php sidebarPosClass($page_layout); ?> <?php echo $ybwp_data['opt-select-blogpostlayout']; ?>">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part( 'assets/inc/content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php get_template_part( 'assets/inc/nav' ); ?>

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