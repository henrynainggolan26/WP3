<?php
/*
Plugin Name: Testimonial
Plugin URI: http://example.com
Description: Simple non-bloated WordPress Contact Form
Version: 1.0
Author: Agbonghama Collins
Author URI: http://w3guy.com
*/
add_action( 'admin_menu', 'my_admin_menu' );
function my_admin_menu() {
	add_menu_page( 'Testimonial', 'Testimonial', 'manage_options', 'admin_testimonial/admin_testimonial_page.php', 'testimonial_admin_page', 'dashicons-tickets', 6  );
}
function show_testimonial(){
	?>
	<div class="wrap">
		<h2>Show Testimonial</h2>
	</div>
	<?php
	global $blog_id;
	global $wpdb;
	$result = $wpdb->get_results("SELECT * FROM users WHERE blog_id = $blog_id"); 
	echo "<table border='1' cellpadding='3' align='center'>"; 
	echo "<tr><th> ID </th> <th> Name </th>  <th> Email </th> <th> Phone Number </th><th> Testimonial </th><th> Action </th></tr>";
	foreach ($result as $key) {
		echo '<tr><td>'.$key->id.'</td>';
		echo '<td>'.$key->name.'</td>';
		echo '<td>'.$key->email.'</td>';
		echo '<td>'.$key->phone_number.'</td>';
		echo '<td>'.$key->testimonial.'</td>';
		echo '<td><form action="'.esc_url($_SERVER['REQUEST_URI']).'" method="post">
		<input type=hidden name="id_testimonial" value="'.$key->id.'">
		<input type="submit" name="edit" value="Edit">
		<input type="submit" name="delete" value="Delete"></form>
		</td></tr>';
	}
}
function delete_testimonial(){
	global $blog_id;
	global $wpdb;
	if(isset($_POST['delete'])){
		$id = sanitize_text_field($_POST["id_testimonial"]);
		$wpdb->delete('users', array('id'=>$id, 'blog_id' => $blog_id));
	}
}
function edit_testimonial(){
	global $wpdb;
	if(isset($_POST['edit'])){
		$id = sanitize_text_field($_POST["id_testimonial"]);
		$myusers = $wpdb->get_row("SELECT * FROM users WHERE id = '".$id."'");
		$name_user = $myusers->name;
		$email_user = $myusers->email;
		$phonenumber_user = $myusers->phone_number;
		$testimonial_user = $myusers->testimonial;
		echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
		echo '<h2>';
		echo 'Edit Testimonial<br/>';
		echo '</h2>';
		echo '<p>';
		echo 'Your Name (required) <br/>';
		echo '<input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" value="'.$name_user.'" size="40" />';
		echo '</p>';
		echo '<p>';
		echo 'Your Email (required) <br/>';
		echo '<input type="email" name="cf-email" value="'.$email_user.'" size="40" />';
		echo '</p>';
		echo '<p>';
		echo 'Phone Number (required) <br/>';
		echo '<input type="text" name="cf-phonenumber" pattern="[0-9]+" value="'.$phonenumber_user.'" size="40" />';
		echo '</p>';
		echo '<p>';
		echo 'Your Testimonial (required) <br/>';
		echo '<textarea rows="10" cols="35" name="cf-testimonial">' .$testimonial_user. '</textarea>';
		echo '</p>';
		echo '<p><input type="submit" name="cf-save" value="Send"></p>';
		echo '<p><input type=hidden name="id_testimonialid" value="'.$id.'"></p>';
		echo '</form>';
	}
	if(isset($_POST['cf-save'])){ 
		$id = sanitize_text_field($_POST["id_testimonialid"]);
		$name = sanitize_text_field($_POST["cf-name"]);
		$email = sanitize_email($_POST["cf-email"]);
		$phonenumber = sanitize_text_field($_POST["cf-phonenumber"]);
		$testimonial = sanitize_text_field($_POST["cf-testimonial"]);
		$wpdb->update(
			'users',
			array(
				'name' => $name,
				'email' => $email,
				'phone_number' => $phonenumber,
				'testimonial' => $testimonial
				),
			array('id' => $id),
			array(
				'%s',
				'%s',
				'%s',
				'%s'
				),
			array('%d')
			);
	}
}
function html_form_code() {
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
	echo '<p>';
	echo 'Your Name (required) <br/>';
	echo '<input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Your Email (required) <br/>';
	echo '<input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Phone Number (required) <br/>';
	echo '<input type="text" name="cf-phonenumber" pattern="[0-9]+" value="' . ( isset( $_POST["cf-phonenumber"] ) ? esc_attr( $_POST["cf-phonenumber"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Your Testimonial (required) <br/>';
	echo '<textarea rows="10" cols="35" name="cf-testimonial">' . ( isset( $_POST["cf-testimonial"] ) ? esc_attr( $_POST["cf-testimonial"] ) : '' ) . '</textarea>';
	echo '</p>';
	echo '<p><input type="submit" name="cf-submitted" value="Send"></p>';
	echo '</form>';
}
function insert_testimonial(){
	global $blog_id;
	global $wpdb;
	if(isset($_POST['cf-submitted'])){
		$name = sanitize_text_field($_POST["cf-name"]);
		$email = sanitize_email($_POST["cf-email"]);
		$phonenumber = sanitize_text_field($_POST["cf-phonenumber"]);
		$testimonial = sanitize_text_field($_POST["cf-testimonial"]);
		$wpdb->insert(
			'users',
			array(
				'name' => $name,
				'email' => $email,
				'phone_number' => $phonenumber,
				'testimonial' => $testimonial,
				'blog_id' => $blog_id
				),
			array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%d'
				)
			);
	}
}
function cf_shortcode() {
	ob_start();
	insert_testimonial();
	html_form_code();
	return ob_get_clean();
}
function testimonial_admin_page(){
	edit_testimonial();
	delete_testimonial();
	show_testimonial();
}
add_shortcode( 'sitepoint_contact_form', 'cf_shortcode' );

function register_sidebars_secondary() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar 5', 'twentysixteen' ),
		'id'            => 'sidebar-5',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'id' => 'sidebar_6',
			'name' => __( 'Sidebar 6', 'twentysixteen' ),
			'description' => __( 'A short description of the sidebar.', 'twentysixteen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
}
add_action( 'widgets_init', 'register_sidebars_secondary' );
include 'widget_testimonial.php';
include 'widget_search.php';