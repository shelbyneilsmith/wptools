<?php global $ybwp_data; ?>

<?php $logo_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>

<?php echo "<$logo_tag class='site-title'>"; ?>
	<?php if ( !empty($ybwp_data['opt-media-logo']['url'] ) ) { ?>
		<a href="<?php echo home_url(); ?>/" title="<?php bloginfo('name') ?>" rel="home">
			<?php if ( !empty($ybwp_data['opt-media-logo2x']['url'] ) ) : ?>
				<img src="<?php echo $ybwp_data['opt-media-logo2x']['url'] ?>" width="<?php echo $ybwp_data['opt-media-logo']['width']; ?>" height="<?php echo $ybwp_data['opt-media-logo']['height']; ?>" alt="<?php bloginfo('name'); ?>" class="logo_retina" />
			<?php else : ?>
				<img src="<?php echo $ybwp_data['opt-media-logo']['url']; ?>" alt="<?php bloginfo('name'); ?>" class="logo_standard" />
			<?php endif; ?>
		</a>
	<?php } else { ?>
		<a href="<?php echo home_url(); ?>/" rel="home"><?php bloginfo('name'); ?></a>
	<?php } ?>

<?php echo "</$logo_tag>"; ?>
