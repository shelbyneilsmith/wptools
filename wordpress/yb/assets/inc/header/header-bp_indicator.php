<?php global $ybwp_data; ?>

<?php if ( ((WP_ENV == 'development') || (WP_ENV == 'staging')) && !empty($ybwp_data['opt-checkbox-bpindicator'] ) ) : ?>
  <div class="break-indicator"></div>
<?php endif; ?>