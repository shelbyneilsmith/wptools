<?php get_header(); ?>

<?php
	$page_title = get_the_title();
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

		<div id="content" class="<?php sidebarPosClass($page_layout); ?> columns">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php the_content(); ?>

				<?php if( $ybwp_data['opt-checkbox-sharebox'] ) { ?>
					<?php get_template_part( 'assets/inc/sharebox' ); ?>
				<?php } ?>

				<?php //if ( !$ybwp_data['opt-checkbox-blogcomments'] ) : // change "blogcomments" to whatever applies here ?>
					<div class="comments"><?php comments_template(); ?></div>
				<?php //endif; ?>
			<?php endwhile; endif; ?>

		</div> <!-- end #content -->

		<?php if ( ( $page_layout === "Centered Left Sidebar" ) || ( $page_layout === "Centered Right Sidebar" ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>