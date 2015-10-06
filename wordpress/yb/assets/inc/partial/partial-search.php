<?php global $ybwp_data; ?>

<?php if ( !empty($ybwp_data['opt-checkbox-searchform'] ) ) : ?>
	<form action="<?php echo home_url(); ?>/" class="header-searchform" method="get">
		<input type="text" id="header-s" name="s" value="" autocomplete="off" />
		<input type="submit" value="Search" id="header-searchsubmit" />
	</form>
<?php endif; ?>