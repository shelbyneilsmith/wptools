<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>

<?php
	$page_title = get_the_title();
?>

<div id="title">
	<div class="container full-width">
		<h1 class="page-title"><?php echo $page_title; ?></h1>

		<?php if( !empty($ybwp_data['opt-checkbox-breadcrumbs'] ) ) : ?>
			<?php echo $breadcrumbs; ?>
		<?php endif; ?>
	</div>
</div>

<div id="page-wrap" <?php post_class(); ?>>
	<div id="page-inner" class="container full-width">
		<div id="content">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php the_content(); ?>

				<?php if(!$ybwp_data['opt-checkbox-pagecomments']) { ?>
					<?php comments_template(); ?>
				<?php } ?>
			<?php endwhile; endif; ?>
		</div> <!-- end #content -->
	</div>
</div> <!-- end page-wrap -->

<?php get_footer(); ?>