<?php
/*
Plugin Name: DoomClock
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
		$instance = wp_parse_args( (array) $instance, array('title' => '', 'date' => '', 'time' => '', 'timezone' => '', 'bordercolor' => ''));
		
		$title = $instance['title'];
		$date = $instance['date'];
		$time = $instance['time'];
		$timezone = $instance['timezone'];
		$bordercolor = $instance['bordercolor'];
		?>
		
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('date'); ?>">Date: <input class="widefat" id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="date" value="<?php echo attribute_escape($date); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('time'); ?>">Time: <input class="widefat" id="<?php echo $this->get_field_id('time'); ?>" name="<?php echo $this->get_field_name('time'); ?>" type="time" value="<?php echo attribute_escape($time); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('timezone'); ?>">Timezone:<br>
		<select class="widefat" id="<?php echo $this->get_field_id('timezone'); ?>" name="<?php echo $this->get_field_name('timezone'); ?>">
			<?php echo wp_timezone_choice($timezone); ?>
		</select></p>
		<p><label for="<?php echo $this->get_field_id('bordercolor'); ?>">Border Color: <input class="widefat" id="<?php echo $this->get_field_id('bordercolor'); ?>" name="<?php echo $this->get_field_name('bordercolor'); ?>" type="text" value="<?php echo attribute_escape($bordercolor); ?>" /></label></p>
		
		<?php
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['date'] = $new_instance['date'];
		$instance['time'] = $new_instance['time'];
		$instance['timezone'] = $new_instance['timezone'];
		$instance['bordercolor'] = $new_instance['bordercolor'];
		
		return $instance;
	}
	
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		
		$timezone = $instance['timezone'];
		$time = new \DateTime('now', new DateTimeZone($timezone));
		$timezone_offset = $time->format('P');
		
		$datetime = date('Y-m-d\TH:i:s', strtotime($instance['date'] . 'T' . $instance['time'] . ':00') - (integer) $timezone_offset * 3600);
		
		echo
		$before_widget,
			$before_title,
				$title,
			$after_title,
			
			"<time style='border: 2px solid {$bordercolor};' datetime='{$datetime}'></time>",
		$after_widget;
		
		wp_enqueue_script('jquery.doomclock', plugins_url('jquery.doomclock.js', __FILE__));
		wp_enqueue_script('doomclock-invoke', plugins_url('doomclock-invoke.js', __FILE__));
		wp_enqueue_style('doomclock', plugins_url('doomclock.css', __FILE__));
	}
}

add_action('widgets_init', create_function('', 'return register_widget("DoomClockWidget");'));

?>