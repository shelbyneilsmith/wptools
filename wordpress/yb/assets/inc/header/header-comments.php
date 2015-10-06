<?php global $ybwp_data; ?>

<?php if( !empty($ybwp_data['opt-checkbox-pagecomments']) || !empty($ybwp_data['opt-checkbox-blogcomments'] ) ) : ?>
	<?php if ( is_single() && comments_open() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php endif; ?>