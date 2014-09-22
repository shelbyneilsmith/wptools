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
		<div id="content" class="<?php echo $sidebar_pos; ?> <?php echo $contentColumns; ?> columns">

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
