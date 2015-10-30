<?php
class widget_video_embed extends WP_Widget {
	function widget_video_embed() {
		$widget_ops = array('description' => __('Embed Youtube or Vimeo Video', 'yb') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'video_embed' );
		$this->WP_Widget( 'video_embed', __('Video Embed', 'yb'), $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$vid_url = $instance['video_url'];
		// ------
		echo $before_widget;
		echo $before_title . $title . $after_title;
		$widget_id = $args['widget_id']; // Just in case.
		?>
		<?php
			preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $vid_url , $matches);
			$id = $matches[1];
			$width = '800px';
			$height = '450px';

			if (_is_youtube($vid_url)) {
				$vid_id = _youtube_video_id($vid_url);
				$embed_code = "<iframe id='ytplayer' type='text/html' width='$width' height='$height' src='https://www.youtube.com/embed/$vid_id?rel=0&showinfo=0&color=white&iv_load_policy=3' frameborder='0' allowfullscreen></iframe>";
			} else if (_is_vimeo($vid_url)) {
				$vid_id = _vimeo_video_id($vid_url);
				$embed_code = "<iframe src='https://player.vimeo.com/video/$vid_id' width='$width' height='$height' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
			} else {
				$embed_code = '<iframe width="420" height="315" src="https://www.youtube.com/embed/jNQXAC9IVRw" frameborder="0" allowfullscreen></iframe>';
			}
		?>
			<div class="vid-wrap">
				<?php echo $embed_code; ?>
			</div>
		<?php
		echo $after_widget;
		// ------
	}

	// Update
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['video_url'] = $new_instance['video_url'];

		return $instance;
	}

	// Backend Form
	function form($instance) {

		$defaults = array('title' => 'Video Embed', 'video_url' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('video_url'); ?>">Video URL:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('video_url'); ?>" name="<?php echo $this->get_field_name('video_url'); ?>" value="<?php echo $instance['video_url']; ?>" />
		</p>
	<?php }
}

// register Foo_Widget widget
function register_widget_video_embed() {
	register_widget( 'widget_video_embed' );
}
add_action( 'widgets_init', 'register_widget_video_embed' );

/////////////////////////
// vid util functions:
/////////////////////////

function _is_youtube($url) {
	return (preg_match('/youtu\.be/i', $url) || preg_match('/youtube\.com\/watch/i', $url));
}
function _is_vimeo($url) {
	return (preg_match('/vimeo\.com/i', $url));
}

function _youtube_video_id($url) {
	if(_is_youtube($url)) {
		$pattern = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
		preg_match($pattern, $url, $matches);
		if (count($matches) && strlen($matches[7]) == 11) {
			return $matches[7];
		}
	}

	return '';
}

function _vimeo_video_id($url) {
	if(_is_vimeo($url)) {
		$pattern = '/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/';
		preg_match($pattern, $url, $matches);
		if (count($matches)) {
			return $matches[2];
		}
	}

	return '';
}
?>