<?php get_header(); ?>

<div id="page-wrap four-oh-four">

	<div id="title">
		<div class="container">
			<div class="sixteen columns">
				<h1 class="page-title">Sorry, this page was not found.</h1>

				<?php get_template_part('assets/inc/partial/partial', 'breadcrumbs'); ?>
			</div>
		</div>
	</div>

	<div id="page-inner" class="container">
		
		<div id="content" class="">

			<p>You may not be able to find this page because of:</p>

			<ol type="a">
				<li>An <strong>out-of-date bookmark/favourite</strong></li>
				<li>A search engine that has an <strong>out-of-date listing for us</strong></li>
				<li>A <strong>mis-typed address</strong></li>
			</ol>

			<span align="center"><a href="<?php echo home_url(); ?>" target="_self" class="button alternative-1 large"><?php _e("Back to Home", "yb") ?></a></span>
		</div> <!-- #content -->

		<?php get_sidebar(); ?>
		
	</div> <!-- #page-inner -->

</div> <!-- #page-wrap -->

<?php get_footer(); ?>
