<?php global $ybwp_data; ?>

<?php if( !empty($ybwp_data['opt-checkbox-footerwidgets'] ) ) { ?>
  <div id="footer-widgets" class="clearfix">
	 <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widgets')); ?>
  </div>
<?php } ?>