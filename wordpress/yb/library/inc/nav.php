<div id="pagination" class="clearfix">
	<?php global $ybwp_data; ?>
	<?php if ( $ybwp_data['opt-select-pagination'] === "1" ) : ?>
		<?php yb_pagination(); ?>
	<?php elseif ($ybwp_data['opt-select-pagination'] === "2" ) : ?>
		<?php yb_pagination_2(); ?>
	<?php endif; ?>
</div>
<p class="hidden"><?php posts_nav_link(); ?></p>