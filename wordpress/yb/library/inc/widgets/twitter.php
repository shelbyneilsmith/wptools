<?php

class widget_twitter extends WP_Widget {

	// Widget Settings
	function widget_twitter() {
		$widget_ops = array('description' => __('Display your latest Tweets', 'yb') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'twitter' );
		$this->WP_Widget( 'twitter', __('yb.Twitter', 'yb'), $widget_ops, $control_ops );
	}

	// Widget Output
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$username = $instance['username'];
		$posts = $instance['posts'];

		$randomid = rand();
		// ------
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo '<ul id="twitter-'.$randomid.'"></ul>';
		echo "<script type='text/javascript'>
				jQuery(document).ready(function($){
					$.getJSON('http://api.twitter.com/1/statuses/user_timeline/".$username.".json?count=".$posts."&callback=?', function(tweets){
					$('#twitter-".$randomid."').html(tz_format_twitter(tweets));
				}); });
			</script>";
		echo $after_widget;
		// ------
	}

	// Update
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['posts'] = strip_tags( $new_instance['posts'] );

		return $instance;
	}

	// Backend Form
	function form($instance) {

		$defaults = array( 'title' => 'Twitter Widget', 'posts' => '3', 'username' => 'helloyb' ); // Default Values
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>">Twitter Username:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'posts' ); ?>">Number of Posts:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'posts' ); ?>" name="<?php echo $this->get_field_name( 'posts' ); ?>" value="<?php echo $instance['posts']; ?>" />
		</p>

    <?php }
}

// Add Widget
function widget_twitter_init() {
	register_widget('widget_twitter');
}
add_action('widgets_init', 'widget_twitter_init');

?>