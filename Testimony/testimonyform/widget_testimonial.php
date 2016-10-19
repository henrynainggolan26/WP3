<?php
/**
*
*/
class widget_testimonial extends WP_Widget
{
	
	public function __construct()
	{
		$widget_ops = array( 
			'classname' => 'widget_testimonial',
			'description' => 'Testimonial widget',
		);
		parent::__construct( 'widget_testimonial', 'Widget Testimonial', $widget_ops );
	}
	public function widget($args, $instance){
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		
		global $wpdb;
		$wp_testimonial = $wpdb->get_results( 
			"
			SELECT * 
			FROM testimonial
			LIMIT 1
			"
		);
		if(count($wp_testimonial)>0)
		{
			echo 
			'<table border="1">
				<thead>
					<tr>
						<th>No</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone Number</th>
						<th>Testimonial</th>
					</tr>
				</thead>
				<tbody>
					';
			$i=0;
			foreach ( $wp_testimonial as $testimoni ) 
			{
				$i++;
				echo '<tr><td>'.$i.'</td>';
				echo '<td>'.$testimoni->name.'</td>';
				echo '<td>'.$testimoni->email.'</td>';
				echo '<td>'.$testimoni->phone_number.'</td>';
				echo '<td>'.$testimoni->testimonial.'</td>';
			}
			echo'
			 </tbody>
		</table>';
	

		}
		else
		{
			echo "Kosong";
		}
		echo $args['after_widget'];


	}
	public function form($instance)
	{
		if( $instance) {
			$title = esc_attr($instance['title']);
			} else {
			$title = '';
		}?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'widget_testimonial'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php

	}
	public function update($new_instance, $old_instance){
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;

	}
}


// register Foo_Widget widget
function register_testimony_widget() {
    register_widget( 'widget_testimonial' );
}
add_action( 'widgets_init', 'register_testimony_widget' );
?>