<?php get_header(); ?>

<?php get_template_part( 'library/inc/titlebar' ); ?>

<?php
	$page_layout = $ybwp_data['opt-layout'];

	if ( $page_layout === "Full Width" ) {
		$full_width_class = "full-width";
	} else {
		$full_width_class = "";
	}
?>

<div id="page-wrap" class="clearfix">
	<div id="page-inner" class="container <?php echo $full_width_class; ?>">

		<?php if ( $ybwp_data['opt-layout'] !== "1" ) {
				$contentColumns = "twelve";
				if ( $ybwp_data['opt-layout'] === "2" ) {
					$sidebar_pos = 'sidebar-left';
				} else {
					$sidebar_pos = 'sidebar-right';
				}
			} else {
				$contentColumns = "sixteen";
				$sidebar_pos = '';
			}
		?>

		<div id="content" class="<?php echo $sidebar_pos; ?> <?php echo $contentColumns; ?> columns">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php the_content(); ?>

				<?php if( $ybwp_data['opt-checkbox-sharebox'] ) { ?>
					<?php get_template_part( 'library/inc/sharebox' ); ?>
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