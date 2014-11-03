<div class="container header-v3-container">

	<div class="sixteen columns">

		<?php get_template_part( 'library/inc/headers/headers', 'logo' ); ?>

		<?php if(!empty($ybwp_data['opt-checkbox-slogan'])) { ?>
			<div class="slogan"><?php echo get_bloginfo( 'description' ); ?></div>
		<?php } ?>

	</div>

</div>

<!-- <div class="clear"></div> -->

<div id="navigation" class="dropped">
	<div class="container">
		<div class="sixteen columns">
		<?php if (class_exists('Woocommerce') && !empty($ybwp_data['opt-checkbox-woocommerce']) && !empty($ybwp_data['opt-checkbox-woocommerceicon'])) { // Check if WooCommerce Exists ?>
				<?php get_template_part( 'library/inc/headers/headers', 'woocommerce' ); ?>
			<?php } ?>

			<?php get_template_part( 'library/inc/headers/headers', 'mainnav' ); ?>

			<?php if(!empty($ybwp_data['opt-checkbox-searchform'])) { ?>
				<?php get_template_part( 'library/inc/headers/headers', 'search' ); ?>
			<?php } ?>
		</div>
	</div>
</div>
