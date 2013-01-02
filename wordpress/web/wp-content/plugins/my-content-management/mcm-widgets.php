<?php

add_action( 'widgets_init', create_function('', 'return register_widget("mcm_search_widget");') );

class mcm_search_widget extends WP_Widget {
	function mcm_search_widget() {
		parent::WP_Widget( false,$name=__('Custom Post Search','my-content-management') );
	}

	function widget($args, $instance) {
		extract($args);
		$the_title = apply_filters('widget_title',$instance['title']);
		$widget_title = empty($the_title) ? '' : $the_title;
		$widget_title = ($widget_title!='') ? $before_title . $widget_title . $after_title : '';		
		$post_type = $instance['mcm_widget_post_type'];		
		$search_form = mcm_search_form( $post_type );
		echo $before_widget;
		echo $widget_title;
		echo $search_form;
		echo $after_widget;
	}

	function form($instance) {
		global $mcm_enabled;
		$enabled = $mcm_enabled;
		$post_type = esc_attr($instance['mcm_widget_post_type']);
		$title = esc_attr($instance['title']);
	?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','my-content-management'); ?>:</label><br />
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>"/>
		</p>	
		<p>
		<label for="<?php echo $this->get_field_id('mcm_widget_post_type'); ?>"><?php _e('Post type to search','my-content-management'); ?></label> <select<?php echo $disabled; ?> id="<?php echo $this->get_field_id('mcm_widget_post_type'); ?>" name="<?php echo $this->get_field_name('mcm_widget_post_type'); ?>">
	<?php
		foreach( $enabled as $v ) {
			$display = ucfirst( str_replace( 'mcm_','',$v ) );
			$selected = ($post_type == $v)?' selected="selected"':'';
			echo "<option value='$v'$selected>$display</option>";
		}
	?>
		</select>
		</p>	
	<?php
	}

	function update($new_instance,$old_instance) {
		$instance = $old_instance;
		$instance['mcm_widget_post_type'] = strip_tags($new_instance['mcm_widget_post_type']);
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;		
	}	
}


add_action( 'widgets_init', create_function('', 'return register_widget("mcm_posts_widget");') );

class mcm_posts_widget extends WP_Widget {
	function mcm_posts_widget() {
		parent::WP_Widget( false,$name=__('Custom Post List','my-content-management') );
	}

	function widget($args, $instance) {
		extract($args);
		$the_title = apply_filters('widget_title',$instance['title']);
		$widget_title = empty($the_title) ? '' : $the_title;
		$widget_title = ($widget_title!='') ? $before_title . $widget_title . $after_title : '';		
		$post_type = $instance['mcm_posts_widget_post_type'];	
		$display = ( $instance['display'] == '' )?'list':$instance['display'];
		$count = ( $instance['count'] == '' )?-1:(int) $instance['count'];
		$order = ( $instance['order'] == '' )?'menu_order':$instance['order'];
		$direction = ( $instance['direction'] == '' )?'asc':$instance['direction'];
		$term = ( !isset( $instance['term'] ) )?'':$instance['term'];
		//  $type, $display, $taxonomy, $term, $count, $order, $direction, $meta_key, $template, $cache, $offset, $id. $custom_wrapper, $custom
		$taxonomy = str_replace( 'mcm_','mcm_category_',$post_type );
		$custom = mcm_get_show_posts( $post_type, $display, $taxonomy, $term, $count, $order, $direction, '', '', false, false, false, 'div', '','IN' );
		echo $before_widget;
		echo $widget_title;
		echo $custom;
		echo $after_widget;
	}

	function form($instance) {
		global $mcm_enabled;
		$enabled = $mcm_enabled;
		$post_type = esc_attr($instance['mcm_posts_widget_post_type']);
		$display = esc_attr($instance['display']);
		$count = (int) $instance['count'];
		$direction = esc_attr($instance['direction']);		
		$order = esc_attr($instance['order']);
		$title = esc_attr($instance['title']);
		$term = ( isset($instance['term']) )?esc_attr($instance['term']):'';		
	?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','my-content-management'); ?>:</label><br />
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>"/>
		</p>	
		<p>
		<label for="<?php echo $this->get_field_id('mcm_posts_widget_post_type'); ?>"><?php _e('Post type to list','my-content-management'); ?></label> <select id="<?php echo $this->get_field_id('mcm_posts_widget_post_type'); ?>" name="<?php echo $this->get_field_name('mcm_posts_widget_post_type'); ?>">
	<?php
		foreach( $enabled as $v ) {
			$dis = ucfirst( str_replace( 'mcm_','',$v ) );
			$selected = ($post_type == $v)?' selected="selected"':'';
			echo "<option value='$v'$selected>$dis</option>";
		}
	?>
		</select>
		</p>	
		<p>
		<label for="<?php echo $this->get_field_id('display'); ?>"><?php _e('Template','my-content-management'); ?></label> <select id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>">
		<option value='list'<?php echo ($display == 'list')?' selected="selected"':''; ?>><?php _e('List','my-content-management'); ?></option>
		<option value='excerpt'<?php echo ($display == 'excerpt')?' selected="selected"':''; ?>><?php _e('Excerpt','my-content-management'); ?></option>
		<option value='full'<?php echo ($display == 'full')?' selected="selected"':''; ?>><?php _e('Full','my-content-management'); ?></option>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Display order','my-content-management'); ?></label> <select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
		<option value='menu_order'<?php echo ($order == 'menu_order')?' selected="selected"':''; ?>><?php _e('Menu Order','my-content-management'); ?></option>
		<option value='none'<?php echo ($order == 'none')?' selected="selected"':''; ?>><?php _e('None','my-content-management'); ?></option>
		<option value='ID'<?php echo ($order == 'ID')?' selected="selected"':''; ?>><?php _e('Post ID','my-content-management'); ?></option>
		<option value='author'<?php echo ($order == 'author')?' selected="selected"':''; ?>><?php _e('Author','my-content-management'); ?></option>
		<option value='title'<?php echo ($order == 'title')?' selected="selected"':''; ?>><?php _e('Post Title','my-content-management'); ?></option>
		<option value='date'<?php echo ($order == 'date')?' selected="selected"':''; ?>><?php _e('Post Date','my-content-management'); ?></option>
		<option value='modified'<?php echo ($order == 'modified')?' selected="selected"':''; ?>><?php _e('Post Modified Date','my-content-management'); ?></option>
		<option value='rand'<?php echo ($order == 'rand')?' selected="selected"':''; ?>><?php _e('Random','my-content-management'); ?></option>
		<option value='comment_count'<?php echo ($order == 'comment_count')?' selected="selected"':''; ?>><?php _e('Number of comments','my-content-management'); ?></option>	
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number to display','my-content-management'); ?></label> <input type="text" size="3" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $count; ?>" /><br /><span>(<?php _e('-1 to display all posts','my-content-management'); ?>)</span>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('direction'); ?>"><?php _e('Order direction','my-content-management'); ?></label> <select id="<?php echo $this->get_field_id('direction'); ?>" name="<?php echo $this->get_field_name('direction'); ?>">
		<option value='modified'<?php echo ($direction == 'asc')?' selected="selected"':''; ?>><?php _e('Ascending (A-Z)','my-content-management'); ?></option>
		<option value='rand'<?php echo ($direction == 'desc')?' selected="selected"':''; ?>><?php _e('Descending (Z-A)','my-content-management'); ?></option>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('term'); ?>"><?php _e('Category (single term or comma-separated list)','my-content-management'); ?>:</label><br />
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('term'); ?>" name="<?php echo $this->get_field_name('term'); ?>" value="<?php echo $term; ?>"/>
		</p>		
	<?php
	}

	function update($new_instance,$old_instance) {
		$instance = $old_instance;
		$instance['mcm_posts_widget_post_type'] = strip_tags($new_instance['mcm_posts_widget_post_type']);
		$instance['display'] = strip_tags($new_instance['display']);
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['direction'] = strip_tags($new_instance['direction']);
		$instance['count'] = ( $new_instance['count']== '' )?-1:(int) $new_instance['count'];
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['term'] = strip_tags($new_instance['term']);		
		return $instance;		
	}
}
