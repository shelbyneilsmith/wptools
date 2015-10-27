<?php global $ybwp_data; ?>

<?php if( !empty($ybwp_data['opt-checkbox-showblogtitle'] )) : $page_title = $ybwp_data['opt-text-blogtitle']; ?>
	<div id="title">
		<div class="container">
			<div class="sixteen columns">
				<h1 class="page-title blog-title"><?php echo $page_title; ?></h1>

				<?php if( !empty($ybwp_data['opt-checkbox-breadcrumbs']) && empty($ybwp_data['opt-checkbox-blogbreadcrumbs']) ) : ?>
					<?php get_template_part('assets/inc/partial/partial', 'breadcrumbs'); ?>
				<?php endif; ?>

			</div>
		</div>
	</div>
<?php endif; ?>