<?php
/*
Plugin Name: Doom Clock
Description: Customizable countdown timer sidebar widget based on jQuery plugin of the same name
Author: Josh Clark
Version: 1
Author URI: http://khameleon.org/work
*/

class DoomClockWidget extends WP_Widget {
	function DoomClockWidget() {
		$widget_ops = array(
			'classname' => 'DoomClockWidget',
			'description' => 'Displays a countdown clock in the sidebar.'
		);
		
		$this->WP_Widget('DoomClockWidget', 'Countdown clock', $widget_ops);
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array('title' => '', 'date' => ''));
		$title = $instance['title'];
		$date = $instance['date'];
		?>
		
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('date'); ?>">Date: <input class="widefat" id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="date" value="<?php echo attribute_escape($date); ?>" /></label></p>
		
		<?php
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['date'] = $new_instance['date'];
		
		return $instance;
	}
	
	function widget($args, $instance) {
		
	}
}