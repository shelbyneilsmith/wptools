<?php global $ybwp_data; ?>

<div class="copyright-text">
	<?php if( !empty($ybwp_data['opt-textarea-copyright'] )) { ?>
		<?php echo $ybwp_data['opt-textarea-copyright']; ?>
	<?php } else { ?>
		Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name') ?>
	<?php } ?>
</div>