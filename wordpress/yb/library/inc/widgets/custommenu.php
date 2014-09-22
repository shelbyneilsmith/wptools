<?php

class WP_Nav_Menu_Widget_Desc extends WP_Widget {

	function __construct() {
		parent::WP_Widget(false, 'yb.SideNav', array('description' => 'Display a Side Navigation'));

	}

	function widget($args, $instance) {
		// Get menu
		$nav_menu = wp_get_nav_menu_object( $instance['nav_menu'] );

		if ( !$nav_menu )
			return;

		echo $args['before_widget'];

		//if ( !empty($instance['title']) )
		//	echo $args['before_title'] . $instance['title'] . $args['after_title'];

		wp_nav_menu( array( 'depth' => 1, 'menu' => $nav_menu ) );

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		return $instance;
	}

	function form( $instance ) {
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
		<?php
			foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
			}
		?>
			</select>
		</p>
		<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("WP_Nav_Menu_Widget_Desc");'));
?>