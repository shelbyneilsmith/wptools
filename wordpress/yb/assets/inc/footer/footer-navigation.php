<?php global $ybwp_data; ?>

<?php if ( !empty($ybwp_data['opt-checkbox-footernav'] ) ) : ?>
	<div id="footer-nav">

	<?php wp_nav_menu( array(
		'theme_location' => 'footer-nav',
		'container' => 'nav',
		'container_id' => 'site-footer-nav',
		'container_class' => 'footer-nav'
	)); ?>

	</div>
<?php endif; ?>