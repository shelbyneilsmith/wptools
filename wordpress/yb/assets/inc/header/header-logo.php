<?php
$logo_url = "";
$logo_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';
?>

<?php echo "<$logo_tag class='site-title'>"; ?>
<?php if ( $logo_url ) { ?>
<a href="<?php echo home_url(); ?>/" title="<?php bloginfo('name') ?>" rel="home">
	<img src="<?php echo $logo_url; ?>" width="200" alt="<?php bloginfo('name'); ?>" />
</a>
<?php } else { ?>
<a href="<?php echo home_url(); ?>/" rel="home"><?php bloginfo('name'); ?></a>
<?php } ?>

<?php echo "</$logo_tag>"; ?>