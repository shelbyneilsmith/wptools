<?php global $ybwp_data; ?>
<div class="sharebox clearfix">
	<h4><?php _e('Share this Story', 'yb'); ?></h4>
	<div class="social-icons clearfix">
		<ul>
			<?php if($ybwp_data['opt-checkbox-sharingboxfacebook'] == true) { ?>
			<li class="social-facebook">
				<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" title="<?php _e( 'Facebook', 'yb' ) ?>" target="_blank"><?php _e( 'Facebook', 'yb' ) ?></a>
			</li>
			<?php } ?>
			<?php if($ybwp_data['opt-checkbox-sharingboxtwitter'] == true) { ?>
			<li class="social-twitter">
				<a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" title="<?php _e( 'Twitter', 'yb' ) ?>" target="_blank"><?php _e( 'Twitter', 'yb' ) ?></a>
			</li>
			<?php } ?>
			<?php if($ybwp_data['opt-checkbox-sharingboxlinkedin'] == true) { ?>
			<li class="social-linkedin">
				<a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink();?>&amp;title=<?php the_title();?>" title="<?php _e( 'LinkedIn', 'yb' ) ?>" target="_blank"><?php _e( 'LinkedIn', 'yb' ) ?></a>
			</li>
			<?php } ?>
			<?php if($ybwp_data['opt-checkbox-sharingboxdigg'] == true) { ?>
			<li class="social-digg">
				<a href="http://digg.com/submit?phase=2&amp;url=<?php the_permalink() ?>&amp;bodytext=&amp;tags=&amp;title=<?php echo urlencode(the_title('', '', false)) ?>" target="_blank" title="<?php _e( 'Digg', 'yb' ) ?>"><?php _e( 'Digg', 'yb' ) ?></a>
			</li>
			<?php } ?>
			<?php if($ybwp_data['opt-checkbox-sharingboxdelicious'] == true) { ?>
			<li class="social-delicious">
				<a href="http://www.delicious.com/post?v=2&amp;url=<?php the_permalink() ?>&amp;notes=&amp;tags=&amp;title=<?php echo urlencode(the_title('', '', false)) ?>" title="<?php _e( 'Delicious', 'yb' ) ?>" target="_blank"><?php _e( 'Delicious', 'yb' ) ?></a>
			</li>
			<?php } ?>
			<?php if($ybwp_data['opt-checkbox-sharingboxgoogleplus'] == true) { ?>
			<li class="social-googleplus">
				<a href="https://plus.google.com/share?url=<?php the_permalink() ?>&amp;title=<?php echo urlencode(the_title('', '', false)) ?>" title="<?php _e( 'Google+', 'yb' ) ?>" target="_blank"><?php _e( 'Google+', 'yb' ) ?>+</a>
			</li>
			<?php } ?>
			<?php if($ybwp_data['opt-checkbox-sharingboxemail'] == true) { ?>
			<li class="social-email">
				<a href="mailto:?subject=<?php the_title();?>&amp;body=<?php the_permalink() ?>" title="<?php _e( 'E-Mail', 'yb' ) ?>" target="_blank"><?php _e( 'E-Mail', 'yb' ) ?>+</a>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>