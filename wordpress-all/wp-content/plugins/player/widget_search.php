<?php
class Widget_Search extends WP_Widget
{
	/**
	 * Register widget with WordPress.
	 */
	public function __construct(){
		$widget_ops = array( 
			'classname' => 'Widget_Search',
			'description' => 'search widget',
			);
		parent::__construct( 'Widget_Search', 'Search Widget', $widget_ops );
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
		?>
		<form action="" method="get">
			<div id="container">
				<input type="text" name="search_name" id="search"  placeholder="Search Here"/>
				<input type="submit" name="submit_name" id="submit" value="Search" />
			</div>
		</form>	
		<?php
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
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'Widget_Search'); ?></label>
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
function register_search_widget() {
	register_widget( 'Widget_Search' );
}
add_action( 'widgets_init', 'register_search_widget' );