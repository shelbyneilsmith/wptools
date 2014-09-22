<?php global $ybwp_data; ?>
<?php
	if (!empty($ybwp_data['opt-layout']) ) {
		if ( $ybwp_data['opt-layout'] === "Full Width" ) {
			$full_width_class = "full-width";
		} else {
			$full_width_class = "";
		}
	}
?>

<?php if (is_singular('portfolio')) { // Begin: Single Projects Title bar ?>

		<div id="title">
			<div class="container <?php echo $full_width_class; ?>">
				<div class="ten columns">
					<h1 class="page-title"><?php the_title(); ?></h1>
				</div>
				<div class="projects-nav">
					<?php next_post_link('<div class="next">%link</div>', __('Next', 'yb')); ?>
					<?php previous_post_link('<div class="prev">%link</div>', __('Previous', 'yb')); ?>
				</div>
			</div>
		</div>

	<!-- End: Projects Title Bar -->
<?php } elseif (is_blog()) { //Begin: Single Blog Title bar ?>
	<?php
		if ( $ybwp_data['opt-bloglayout'] !== "default" ) {
			$full_width_class = "";
		}
	?>
	<?php if ( $ybwp_data['opt-select-blogtitlebar'] == 'Background-Image Style 1' ) { ?>

		<div id="alt-title" class="post-thumbnail" style="background-image: url( <?php echo $ybwp_data['opt-media-blogtitlebar']; ?> );">
			<div class="container <?php echo $full_width_class; ?>">
				<div class="blog-h1 page-title"><?php echo $ybwp_data['opt-text-blogtitle']; ?></div>
			</div>
		</div>
		<?php if(!empty($ybwp_data['opt-checkbox-blogbreadcrumbs'])){ ?>
			<div id="alt-breadcrumbs">
				<div class="container <?php echo $full_width_class; ?>">
					<?php yb_breadcrumbs(); ?>
				</div>
			</div>
		<?php } ?>

	<?php /* ---------------------------------------------------------------------------------------*/ ?>
	<?php } elseif ( $ybwp_data['opt-select-blogtitlebar'] == 'Background-Image Style 2' ) { ?>

		<div id="alt-title-2" class="post-thumbnail" style="background-image: url( <?php echo $ybwp_data['opt-media-blogtitlebar']; ?> );">
			<div class="container <?php echo $full_width_class; ?>">
				<div class="ten columns">
					<div class="blog-h1 page-title"><?php echo $ybwp_data['opt-text-blogtitle']; ?></div>
				</div>
				<?php if(!empty($ybwp_data['opt-checkbox-blogbreadcrumbs'])){ ?>
					<div id="breadcrumbs" class="six columns">
						<?php  yb_breadcrumbs(); ?>
					</div>
				<?php } ?>
			</div>
		</div>

	<?php /* ---------------------------------------------------------------------------------------*/ ?>
	<?php } else { ?>

		<div id="title">
			<div class="container <?php echo $full_width_class; ?>">
				<div class="ten columns">
					<div class="blog-h1 page-title"><?php echo $ybwp_data['opt-text-blogtitle']; ?></div>
				</div>
				<?php if(!empty($ybwp_data['opt-checkbox-blogbreadcrumbs'])) { ?>
					<div id="breadcrumbs" class="six columns">
						<?php yb_breadcrumbs(); ?>
					</div>
				<?php } ?>
			</div>
		</div>

	<?php } ?>

<?php } else {  ?>

	<?php if (is_archive()) { ?>
		<div id="title">
			<div class="container <?php echo $full_width_class; ?>">
				<div class="ten columns">

					<?php /* If this is a category archive */ if (is_category()) { ?>
						<h1 class="page-title"><?php _e('Category Archive for', 'yb') ?> &#8216;<?php single_cat_title(); ?>&#8217; </h1>

					<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
						<h1 class="page-title"><?php _e('Posts Tagged', 'yb') ?> &#8216;<?php single_tag_title(); ?>&#8217;</h1>

					<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
						<h1 class="page-title"><?php _e('Archive for', 'yb') ?> <?php the_time('F jS, Y'); ?></h1>

					<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
						<h1 class="page-title"><?php _e('Archive for', 'yb') ?> <?php the_time('F, Y'); ?></h1>

					<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
						<h1 class="page-title"><?php _e('Archive for', 'yb') ?> <?php the_time('Y'); ?></h1>

					<?php /* If this is an author archive */ } elseif (is_author()) { ?>
						<h1 class="page-title"><?php _e('Author Archive', 'yb') ?></h1>

					<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
						<h1 class="page-title"><?php _e('Blog Archives', 'yb') ?></h1>
					<?php } ?>

				</div>
				<?php if(!empty($ybwp_data['opt-checkbox-breadcrumbs']) && (get_post_meta( get_option('page_for_posts'), 'yb_featuredimage-breadcrumbs', true ) == true)) { ?>
					<div id="breadcrumbs" class="six columns">
						<?php yb_breadcrumbs(); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } else { ?>
		<?php if ( is_404() ) { ?>
		<!-- Titlebar Type: Default Titlebar -->

			<div id="title">
				<div class="container <?php echo $full_width_class; ?>">
					<div class="ten columns">
						<h1 class="page-title">Whoops!</h1>
					</div>
				</div>
			</div>

		<?php } else { ?>

			<?php if ( has_post_thumbnail() && get_post_meta( get_the_ID(), 'yb_titlebar', true ) == 'featuredimage' ) { ?>
			<!-- Titlebar Type: Featured Image Style 1  -->

				<div id="alt-title" class="post-thumbnail" style="background-image: url( <?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' ); echo $src[0]; ?> );">
					<div class="container <?php echo $full_width_class; ?>">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</div>
				</div>

				<?php if(!empty($ybwp_data['opt-checkbox-breadcrumbs']) && (get_post_meta( get_the_ID(), 'yb_featuredimage-breadcrumbs', true ) == true)) { ?>
					<div id="alt-breadcrumbs">
						<div class="container <?php echo $full_width_class; ?>">
							<?php yb_breadcrumbs(); ?>
						</div>
					</div>
				<?php } ?>

			<?php /* ---------------------------------------------------------------------------------------*/ ?>

			<?php } elseif ( has_post_thumbnail() && get_post_meta( get_the_ID(), 'yb_titlebar', true ) == 'featuredimage2' ) { ?>
			<!-- Titlebar Type: Feature Image Style 2 -->

				<div id="alt-title-2" class="post-thumbnail" style="background-image: url( <?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' ); echo $src[0]; ?> );">
					<div class="container <?php echo $full_width_class; ?>">
						<div class="ten columns">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
						<?php if(!empty($ybwp_data['opt-checkbox-breadcrumbs']) && (get_post_meta( get_the_ID(), 'yb_featuredimage-breadcrumbs', true ) == true)) { ?>
							<div id="breadcrumbs" class="six columns">
								<?php  yb_breadcrumbs(); ?>
							</div>
						<?php } ?>
					</div>
				</div>

			<?php /* ---------------------------------------------------------------------------------------*/ ?>

			<?php } elseif (get_post_meta( get_the_ID(), 'yb_titlebar', true ) == 'revslider') { ?>
			<!-- Titlebar Type: Revolution Slider -->

				<div class="clear"></div>

				<?php if(class_exists('RevSlider')){ putRevSlider(get_post_meta( get_the_ID(), 'yb_revolutionslider', true )); } ?>

			<?php /* ---------------------------------------------------------------------------------------*/ ?>

			<?php } elseif (get_post_meta( get_the_ID(), 'yb_titlebar', true ) == 'flexslider') { ?>
			<!-- Titlebar Type: FlexSlider -->

				<div id="title-flexslider">
					<div class="container <?php echo $full_width_class; ?>">
						<div class="sixteen columns">
							<?php echo do_shortcode('[wooslider slide_page="'.get_post_meta( get_the_ID(), 'yb_flexslider', true ).'" slider_type="slides" limit="5"]'); ?>
						</div>
					</div>
				</div>

			<?php /* ---------------------------------------------------------------------------------------*/ ?>

			<?php } elseif (get_post_meta( get_the_ID(), 'yb_titlebar', true ) == 'notitlebar') { ?>
			<?php } else { ?>
			<!-- Titlebar Type: Default Titlebar -->

				<div id="title">
					<div class="container <?php echo $full_width_class; ?>">
						<div class="ten columns">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
						<?php if(!empty($ybwp_data['opt-checkbox-breadcrumbs']) && (get_post_meta( get_the_ID(), 'yb_featuredimage-breadcrumbs', true ) == true)) { ?>
							<div id="breadcrumbs" class="six columns">
								<?php  yb_breadcrumbs(); ?>
							</div>
						<?php } ?>
					</div>
				</div>

			<?php } ?>
		<?php } ?>
		<!-- End: Title Bar -->
	<?php } ?>
<?php } ?>