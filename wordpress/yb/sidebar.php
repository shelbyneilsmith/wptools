<?php if ( is_sidebar_page() === true ) : ?>

	<div id="main-sidebar">
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

<?php endif; ?>
