<div id="navigation" class="clearfix">
	<?php wp_nav_menu( array('theme_location' => 'main-nav', 'container' => 'nav', 'container_id' => 'main-nav-header', 'container_class' => "main-nav drop-menu" )); ?>

	<?php get_template_part('assets/inc/partial/partial', 'search'); ?>
	<?php get_template_part('assets/inc/header/header', 'utility_nav'); ?>
</div>