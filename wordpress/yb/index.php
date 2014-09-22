<?php get_header(); ?>

<?php get_template_part( 'library/inc/titlebar' ); ?>

<?php
	// Get Blog Layout from Theme Options
	if( $ybwp_data['opt-select-blogpostlayout'] == 'blog-medium' ) {
		$blogtype = 'medium';
	} else {
		$blogtype = 'large';
	}
?>

<?php
	if ($ybwp_data['opt-bloglayout'] === "default" ) {
		$page_layout = $ybwp_data['opt-layout'];
	} else {
		$page_layout = $ybwp_data['opt-bloglayout'];
	}
?>

<div id="page-wrap" class="clearfix">
	<?php
		if ( $page_layout === "Full Width" ) {
			$full_width_class = "full-width";
		} else {
			$full_width_class = "";
		}
	?>
	<div id="page-inner" class="container <?php echo $full_width_class; ?>">

		<?php
			if ( ( $page_layout === "Centered Left Sidebar" ) || ( $page_layout === "Centered Right Sidebar" ) ) {
				$contentColumns = "twelve";
				if ( $page_layout === "Centered Left Sidebar" ) {
					$sidebar_pos = 'sidebar-left';
				}
				if ( $page_layout === "Centered Right Sidebar" ) {
					$sidebar_pos = 'sidebar-right';
				}
			} else {
				$contentColumns = "sixteen";
				$sidebar_pos = '';
			}
		?>
		<div id="content" class="<?php echo $sidebar_pos; ?> <?php echo $contentColumns; ?> columns <?php echo $ybwp_data['opt-select-blogpostlayout']; ?>">

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
