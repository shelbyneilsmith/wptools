<div id="main-sidebar" class="four columns">
	<?php
		if(is_blog()){
			/* Blog Sidebar */
			if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Blog Sidebar') );
		} else {
			/* Page Sidebar */
			if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Main Sidebar') );
		}
	?>
</div>