<?php
/*
Plugin Name: Example Testimonial Form Plugin
Plugin URI: http://example.com
Description: Simple WordPress Testimonial Form
Version: 1.0
Author: Andry Setiawan
Author URI: http://tes.com
*/
add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
	add_menu_page( 'Testimonial Page', 'Show Testimonial', 'manage_options', 'admin_page/sp-show-testimonial.php', 'form_show_testimoni_delete', 'dashicons-tickets', 6  );
}

function html_table_testimonial_code()
{
	echo '<div class="wrap">
			<h2>Show Testimonial</h2>
		</div>';

	global $wpdb;
	$wp_testimonial = $wpdb->get_results( 
		"
		SELECT * 
		FROM testimonial
		"
	);
	echo 
		'<table border="1">
			<thead>
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone Number</th>
					<th>Testimonial</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				';
	if(count($wp_testimonial)>0)
	{
		$i=0;
		foreach ( $wp_testimonial as $testimoni ) 
		{
			$i++;
			echo '<tr><td>'.$i.'</td>';
			echo '<td>'.$testimoni->name.'</td>';
			echo '<td>'.$testimoni->email.'</td>';
			echo '<td>'.$testimoni->phone_number.'</td>';
			echo '<td>'.$testimoni->testimonial.'</td>';
			echo '<td><form action=" "method="post">
					<input type=hidden name="testimonial_id" value="'.$testimoni->id.'">
					<input type="submit" name="cf-deleted" value="Delete"/>
				</form>
				</td></tr>';
		}

	}
	else
	{
		echo '<tr><td colspan="6">Data Kosong</td></tr>';
	}

		echo'
			 </tbody>
		</table>';
	
}
function delete_testimonial()
{

	
	global $wpdb;
	if(isset($_POST['cf-deleted']))
	{
		$id = sanitize_text_field( $_POST["testimonial_id"] );
		$wpdb->delete( 'testimonial', array( 'id' => $id ) );
	}
}
function form_show_testimoni_delete()
{
	delete_testimonial();
	html_table_testimonial_code();
	
}
function html_from_code()
{
	echo '<form action="' .esc_url($_SERVER['REQUEST_URI']).'"method="post">';
	echo '<p>';
	echo 'Your Name (required) <br />';
	echo '<input type="text" name="cf-name" pattern="[a-zA-z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40" />';
	echo '</p>';
    echo '<p>';
    echo 'Your Email (required) <br />';
    echo '<input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Your Phone Number (required) <br />';
    echo '<input type="text" name="cf-phone" pattern="[0-9 ]+" value="' . ( isset( $_POST["cf-phone"] ) ? esc_attr( $_POST["cf-phone"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Testimonial (required) <br />';
    echo '<textarea rows="10" cols="35" name="cf-testimonial">' . ( isset( $_POST["cf-testimonial"] ) ? esc_attr( $_POST["cf-testimonial"] ) : '' ) . '</textarea>';
    echo '</p>';
    echo '<p><input type="submit" name="cf-submitted" value="Send"/></p>';
    echo '</form>';
}
function save_testimonial()
{
	global $wpdb;
	if(isset($_POST['cf-submitted']))
	{
		$name = sanitize_text_field( $_POST["cf-name"] );
        $email = sanitize_email( $_POST["cf-email"] );
        $phone_number = sanitize_text_field( $_POST["cf-phone"] );
        $testimonial = esc_textarea( $_POST["cf-testimonial"] );

        $wpdb->insert( 
			'testimonial', 
			array( 
				'name' => $name, 
				'email' => $email,
				'phone_number' => $phone_number,
				'testimonial' => $testimonial 
			), 
			array( 
				'%s', 
				'%s',
				'%s',
				'%s' 
			) 
		);

	}

}
function cf_shortcode()
{
	ob_start();
	save_testimonial();
	html_from_code();

	return ob_get_clean();
}

add_shortcode('testimonial_form', 'cf_shortcode');
include 'widget_testimonial.php';
?>