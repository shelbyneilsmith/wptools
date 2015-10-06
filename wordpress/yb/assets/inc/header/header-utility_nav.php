<?php global $ybwp_data; ?>

<?php if ( !empty($ybwp_data['opt-checkbox-utilnav'] ) ) : ?>
	<?php
		if ( $ybwp_data['opt-checkbox-utilitynavmerge'] ) {
			$utilmerge = ' util-merge';
		} else {
			$utilmerge = '';
		}
	?>
	<?php wp_nav_menu( array('theme_location' => 'util-nav', 'container' => 'nav', 'container_id' => 'util-nav-header', 'container_class' => "util-nav$utilmerge" )); ?>
<?php endif; ?>