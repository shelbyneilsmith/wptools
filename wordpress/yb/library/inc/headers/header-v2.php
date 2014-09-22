<div class="container <?php echo $full_width_class; ?> header-v2-container">

	<div class="four columns alpha">
		<?php get_template_part( 'library/inc/headers/headers', 'logo' ); ?>
	</div>

	<div class="twelve columns">
		<?php if(!empty($ybwp_data['opt-checkbox-searchform'])) { ?>
			<?php get_template_part( 'library/inc/headers/headers', 'search' ); ?>
		<?php } ?>

		<?php if (class_exists('Woocommerce') && !empty($ybwp_data['opt-checkbox-woocommerce']) && !empty($ybwp_data['opt-checkbox-woocommerceicon'])) { // Check if WooCommerce Exists ?>
			<?php get_template_part( 'library/inc/headers/headers', 'woocommerce' ); ?>
		<?php } ?>

		<?php if(!empty($ybwp_data['opt-checkbox-slogan'])) { ?>
			<div class="slogan"><?php echo get_bloginfo( 'description' ); ?></div>
		<?php } ?>
	</div>
</div>

<div id="navigation" class="dropped clearfix">
	<div class="container <?php echo $full_width_class; ?>">
		<div class="sixteen columns">
			<?php get_template_part( 'library/inc/headers/headers', 'mainnav' ); ?>
		</div>
	</div>
</div>

