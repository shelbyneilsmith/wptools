<?php get_header(); ?>

<?php
	$page_layout = $ybwp_data['opt-layout'];

	if ( $page_layout === "Full Width" ) {
		$full_width_class = "full-width";
	} else {
		$full_width_class = "";
	}
?>

<div id="title">
	<div class="container <?php echo $full_width_class; ?>">
		<h1 class="page-title"><?php _e('Search Results for', 'yb') ?> <?php the_search_query(); ?></h1>

		<?php if( !empty($ybwp_data['opt-checkbox-breadcrumbs'] ) ) : ?>
			<?php echo $breadcrumbs; ?>
		<?php endif; ?>
	</div>
</div>

<div id="page-wrap" <?php post_class(); ?>>

	<div id="page-inner" class="container <?php echo $full_width_class; ?>">

		<div id="content" class="<?php sidebarPosClass($page_layout); ?>">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="search-result clearfix">

					<div class="search-content">
						<div class="search-title">
							<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'yb'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
								<?php the_title(); ?>
							</a></h2>
						</div>
						<div class="search-excerpt"><?php the_excerpt(); ?></div>
					</div>

					<div class="clear"></div>
					<div class="search-meta"><?php get_template_part( 'assets/inc/meta' ); ?></div>

				</div>
			<?php endwhile; ?>

			<?php get_template_part( 'assets/inc/nav' ); ?>

			<?php else : ?>
				<h2><?php _e('No results found.', 'yb') ?></h2>
			<?php endif; ?>
		</div> <!-- end #content -->

		<?php if ( ( $page_layout === "Centered Left Sidebar" ) || ( $page_layout === "Centered Right Sidebar" ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>
