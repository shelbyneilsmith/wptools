<div id="comments">
	<?php
		if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
			die ('Please do not load this page directly. Thanks!');

		if ( post_password_required() ) { ?>
			<?php _e('This post is password protected. Enter the password to view comments.', 'yb'); ?>
		<?php
			return;
		}
	?>

	<?php if ( have_comments() ) : ?>
		<h3 id="comments" class="title"><span><?php comments_number(__('Responses', 'yb'), __('Response (1)', 'yb'), __('Responses (%)', 'yb') );?></span></h3>

		<div class="navigation">
			<div class="next-posts"><?php previous_comments_link() ?></div>
			<div class="prev-posts"><?php next_comments_link() ?></div>
		</div>

		<ol class="commentlist clearfix">
			 <?php wp_list_comments(); ?>
		</ol>

		<div class="navigation">
			<div class="next-posts"><?php previous_comments_link() ?></div>
			<div class="prev-posts"><?php next_comments_link() ?></div>
		</div>
	<?php else : // this is displayed if there are no comments so far ?>
		<?php if ( comments_open() ) : ?>
			<!-- If comments are open, but there are no comments. -->

		 <?php else : // comments are closed ?>
			<p class="hidden"><?php _e('Comments are closed.', 'yb'); ?></p>

		<?php endif; ?>
	<?php endif; ?>


	<?php if ( comments_open() ) : ?>
		<?php

			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );

			//Custom Fields
			$fields =  array(
				'author'=> '<div id="respond-inputs" class="clearfix"><p><input name="author" type="text" value="' . __('Name (required)', 'yb') . '" size="30"' . $aria_req . ' /></p>',

				'email' => '<p><input name="email" type="text" value="' . __('E-Mail (required)', 'yb') . '" size="30"' . $aria_req . ' /></p></div>'
			);

			//Comment Form Args
			$comments_args = array(
				'fields' => $fields,
				'title_reply'=>'<h3 class="title"><span>'. __('Leave a reply', 'yb') .'</span></h3>',
				'comment_field' => '<div id="respond-textarea"><p><textarea id="comment" name="comment" aria-required="true" cols="58" rows="10" tabindex="4"></textarea></p></div>',
				'label_submit' => __('Submit comment','yb')
			);

			// Show Comment Form
			comment_form($comments_args);
		?>
	<?php endif; // if you delete this the sky will fall on your head ?>
</div>