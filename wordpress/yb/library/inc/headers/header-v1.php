<div class="container <?php echo $full_width_class; ?> header-v1-container">

	<div class="four columns">
		<?php get_template_part( 'library/inc/headers/headers', 'logo' ); ?>
	</div>

	<div id="navigation" class="twelve columns clearfix">

		<?php if ( !empty($ybwp_data['opt-checkbox-searchform'] ) ) : ?>
			<?php get_template_part( 'library/inc/headers/headers', 'search' ); ?>
		<?php endif; ?>

		<?php if (class_exists('Woocommerce') && !empty($ybwp_data['opt-checkbox-woocommerce']) && !empty($ybwp_data['opt-checkbox-woocommerceicon'])) { // Check if WooCommerce Exists ?>
			<?php get_template_part( 'library/inc/headers/headers', 'woocommerce' ); ?>
		<?php } ?>

		<?php get_template_part( 'library/inc/headers/headers', 'mainnav' ); ?>
	</div>

</div>
