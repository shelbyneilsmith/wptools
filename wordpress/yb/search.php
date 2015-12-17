<?php get_header(); ?>

<div id="page-wrap" <?php post_class(); ?>>

	<div id="title">
		<div class="container">
			<div class="sixteen columns">
				<h1 class="page-title"><?php _e('Search Results for', 'yb') ?> <?php the_search_query(); ?></h1>

				<?php get_template_part('assets/inc/partial/partial', 'breadcrumbs'); ?>
			</div>
		</div>
	</div>

	<div id="page-inner" class="container">

		<div id="content" class="">

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

					<div class="search-meta"><?php get_template_part( 'assets/inc/partial/partial', 'meta' ); ?></div>

				</div>
			<?php endwhile; ?>

			<?php get_template_part( 'assets/inc/partial/partial', 'pagination' ); ?>

		<?php else : ?>

			<h2><?php _e('No results found.', 'yb') ?></h2>

		<?php endif; ?>

	</div> <!-- end #content -->

	<?php get_sidebar(); ?>

</div> <!-- #page-inner -->

</div> <!-- #page-wrap -->

<?php get_footer(); ?>
