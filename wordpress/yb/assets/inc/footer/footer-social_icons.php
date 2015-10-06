<?php global $ybwp_data; ?>

<?php if( !empty($ybwp_data['opt-checkbox-socialfooter']) && outputSocialIcons() ) { ?>

  <?php get_template_part('assets/inc/partial/partial', 'social_icons'); ?>

<?php } ?>