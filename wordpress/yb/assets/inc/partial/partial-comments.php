<?php global $ybwp_data; ?>

<?php if(!$ybwp_data['opt-checkbox-pagecomments']) { ?>
	<?php yb_comments(); ?>
<?php } ?>