<div id="main-sidebar" class="sidebar">

	<?php if ( is_active_sidebar( 'main-sidebar' ) ) : ?>

		<?php dynamic_sidebar( 'main-sidebar' ); ?>

	<?php else : ?>

		<!-- This content shows up if there are no widgets defined in the backend. -->
		
		<div class="alert help">
			<p>Please activate some Widgets.</p>
		</div>

	<?php endif; ?>

</div>