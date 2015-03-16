<?php get_header(); ?>

<?php
	$page_title = 'Whoops!';
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

<div id="page-wrap">
	<div id="page-inner" class="container <?php echo $full_width_class; ?>">
		<div id="content" class="<?php sidebarPosClass($page_layout); ?>">

			<p><strong><?php _e("Looks like you've made a wrong turn somewhere. Let's get you back on track.", "yb") ?></strong></p>

			<p>You may not be able to find this page because of:</p>

			<ol type="a">
				<li>An <strong>out-of-date bookmark/favourite</strong></li>
				<li>A search engine that has an <strong>out-of-date listing for us</strong></li>
				<li>A <strong>mis-typed address</strong></li>
			</ol>

			<span align="center"><a href="<?php echo home_url(); ?>" target="_self" class="button alternative-1 large"><?php _e("Back to Home", "yb") ?></a></span>
		</div> <!-- end content -->

		<?php if ( ( $page_layout === "Centered Left Sidebar" ) || ( $page_layout === "Centered Right Sidebar" ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div>
</div> <!-- end page-wrap -->

<?php get_footer(); ?>
