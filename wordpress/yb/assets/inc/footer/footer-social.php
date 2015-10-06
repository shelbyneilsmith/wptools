<?php global $ybwp_data; ?>

<?php if( !empty($ybwp_data['opt-checkbox-socialfooter']) && outputSocialIcons() ) { ?>
<div class="social-icons clearfix">
	<ul>
		<?php echo outputSocialIcons(); ?>
	</ul>
</div>
<?php } ?>