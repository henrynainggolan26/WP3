<?php
class Widget_Player extends WP_Widget
{
	/**
	 * Register widget with WordPress.
	 */
	public function __construct(){
		$widget_ops = array( 
			'classname' => 'Widget_Player',
			'description' => 'Widget Player',
		);
		parent::__construct( 'Widget_Player', 'Widget Player', $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance){ 
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		global $blog_id; 
		global $wpdb;
		$result = $wpdb->get_results( 
			"SELECT * FROM players WHERE blog_id = $blog_id ORDER BY RAND() LIMIT 1" 
			);
		if(count($result)>0){
			echo "<table border='1' cellpadding='2' align='center'>"; 
			echo "<tr><th> Name </th>  <th> Club </th> <th> Position </th><th> Age </th></tr>";
			foreach ( $result as $player ) 
			{
				echo '<td>'.$player->name.'</td>';
				echo '<td>'.$player->club.'</td>';
				echo '<td>'.$player->position.'</td>';
				echo '<td>'.$player->age.'</td></tr>';
			}
			echo'</table>';
		}
		else{
			echo "Data empty";
		}
		echo $args['after_widget'];
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance)
	{
		if( $instance) {
			$title = esc_attr($instance['title']);
		} else {
			$title = '';
		}?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'Widget_Player'); ?></label>
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
// register Widget_Testimonial widget
function register_player_widget() {
	register_widget( 'Widget_Player' );
}
add_action( 'widgets_init', 'register_player_widget' );