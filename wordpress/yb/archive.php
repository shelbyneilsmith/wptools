<?php get_header(); ?>

<?php
	$page_title = $ybwp_data['opt-text-blogtitle'];
	$extra_title_class = "blog-h1 ";
	if ( $ybwp_data['opt-bloglayout'] !== "default" ) {
		$full_width_class = "";
	}

	// Get Blog Layout from Theme Options
	if( $ybwp_data['opt-select-blogpostlayout'] == 'blog-medium' ) {
		$blogtype = 'medium';
	} else {
		$blogtype = 'large';
	}

	if ($ybwp_data['opt-bloglayout'] === "default" ) {
		$page_layout = $ybwp_data['opt-layout'];
	} else {
		$page_layout = $ybwp_data['opt-bloglayout'];
	}
?>

<?php if( !empty($ybwp_data['opt-checkbox-showblogtitle'] ) : ?>
	<div id="title">
		<div class="container <?php echo $full_width_class; ?>">
			<h1 class="page-title"><?php echo $page_title; ?></h1>

			<?php if( !empty($ybwp_data['opt-checkbox-breadcrumbs']) && empty($ybwp_data['opt-checkbox-blogbreadcrumbs']) ) : ?>
				<?php echo $breadcrumbs; ?>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>

<div id="page-wrap" <?php post_class(); ?>>
	<?php
		if ( $page_layout === "Full Width" ) {
			$full_width_class = "full-width";
		} else {
			$full_width_class = "";
		}
	?>
	<div id="page-inner" class="container <?php echo $full_width_class; ?>">
		<div id="content" class="<?php sidebarPosClass($page_layout); ?> <?php echo $ybwp_data['opt-select-blogpostlayout']; ?>">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part( 'assets/inc/content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php get_template_part( 'assets/inc/nav' ); ?>

			<?php else : ?>
				<h2><?php _e('Not Found', 'yb') ?></h2>
			<?php endif; ?>

		</div>

		<?php if ( ( $page_layout === "Centered Left Sidebar" ) || ( $page_layout === "Centered Right Sidebar" ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>