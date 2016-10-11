<?php
/*
Plugin Name: Players
Description: Players Plugin
Version: 1.0
Author: Henry
*/
add_action( 'admin_menu', 'my_admin_menu' );
function my_admin_menu() {
	add_menu_page( 'Player', 'Player', 'manage_options', 'admin_player/admin_player_page.php', 'player_admin_page', 'dashicons-tickets', 6  );
}
function show_player(){
	?>
	<div class="wrap">
		<h2>Show Player</h2>
	</div>
	<?php
	global $blog_id;
	global $wpdb;
	$result = $wpdb->get_results("SELECT * FROM players WHERE blog_id = $blog_id"); 
	echo "<table border='1' cellpadding='3' align='center'>"; 
	echo "<tr><th> ID </th> <th> Name </th>  <th> Club </th> <th> Position </th><th> Age </th><th> Action </th></tr>";
	foreach ($result as $key) {
		echo '<tr><td>'.$key->id.'</td>';
		echo '<td>'.$key->name.'</td>';
		echo '<td>'.$key->club.'</td>';
		echo '<td>'.$key->position.'</td>';
		echo '<td>'.$key->age.'</td>';
		echo '<td><form action="'.esc_url($_SERVER['REQUEST_URI']).'" method="post">
		<input type=hidden name="id_player" value="'.$key->id.'">
		<input type="submit" name="edit" value="Edit">
		<input type="submit" name="delete" value="Delete"></form>
		</td></tr>';
	}
}
function delete_player(){
	global $blog_id;
	global $wpdb;
	if(isset($_POST['delete'])){
		$id = sanitize_text_field($_POST["id_player"]);
		$wpdb->delete('players', array('id'=>$id, 'blog_id' => $blog_id));
	}
}
function edit_player(){
	global $wpdb;
	if(isset($_POST['edit'])){
		$id = sanitize_text_field($_POST["id_player"]);
		$player = $wpdb->get_row("SELECT * FROM players WHERE id = '".$id."'");
		$name = $player->name;
		$club = $player->club;
		$position = $player->position;
		$age = $player->age;
		echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
		echo '<h2>';
		echo 'Edit Players<br/>';
		echo '</h2>';
		echo '<p>';
		echo 'Name (required) <br/>';
		echo '<input type="text" name="player-name" pattern="[a-zA-Z0-9 ]+" value="'.$name.'" size="40" />';
		echo '</p>';
		echo '<p>';
		echo 'Club (required) <br/>';
		echo '<input type="text" name="player-club" pattern="[a-zA-Z0-9 ]+" value="'.$club.'" size="40" />';
		echo '</p>';
		echo '<p>';
		echo 'Position (required) <br/>';
		echo '<input type="text" name="player-position" pattern="[a-zA-Z0-9 ]+" value="'.$position.'" size="40" />';
		echo '</p>';
		echo '<p>';
		echo 'Age (required) <br/>';
		echo '<input type="text" name="player-age" pattern="[0-9]+" value="'.$age.'" size="10" />';
		echo '</p>';
		echo '<p><input type="submit" name="player-save" value="Send"></p>';
		echo '<p><input type=hidden name="id_player_hidden" value="'.$id.'"></p>';
		echo '</form>';
	}
	if(isset($_POST['player-save'])){ 
		$id = sanitize_text_field($_POST["id_player_hidden"]);
		$name = sanitize_text_field($_POST["player-name"]);
		$club = sanitize_text_field($_POST["player-club"]);
		$position = sanitize_text_field($_POST["player-position"]);
		$age = sanitize_text_field($_POST["player-age"]);
		$wpdb->update(
			'players',
			array(
				'name' => $name,
				'club' => $club,
				'position' => $position,
				'age' => $age
				),
			array('id' => $id),
			array(
				'%s',
				'%s',
				'%s',
				'%d'
				),
			array('%d')
			);
	}
}
function form_input_player() {
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
	echo '<p>';
	echo 'Name (required) <br/>';
	echo '<input type="text" name="player-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["player-name"] ) ? esc_attr( $_POST["player-name"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Club (required) <br/>';
	echo '<input type="text" name="player-club" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["player-club"] ) ? esc_attr( $_POST["player-club"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Position (required) <br/>';
	echo '<input type="text" name="player-position" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["player-position"] ) ? esc_attr( $_POST["player-position"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Age (required) <br/>';
	echo '<input type="text" name="player-age" pattern="[0-9]+" value="' . ( isset( $_POST["player-age"] ) ? esc_attr( $_POST["player-age"] ) : '' ) . '" size="10" />';
	echo '</p>';
	echo '<p><input type="submit" name="player-submitted" value="Save"></p>';
	echo '</form>';
}
function insert_player(){
	global $blog_id;
	global $wpdb;
	if(isset($_POST['player-submitted'])){
		$name = sanitize_text_field($_POST["player-name"]);
		$club = sanitize_text_field($_POST["player-club"]);
		$position = sanitize_text_field($_POST["player-position"]);
		$age = sanitize_text_field($_POST["player-age"]);
		$wpdb->insert(
			'players',
			array(
				'name' => $name,
				'club' => $club,
				'position' => $position,
				'age' => $age,
				'blog_id' => $blog_id
				),
			array(
				'%s',
				'%s',
				'%s',
				'%d',
				'%d'
				)
			); ;
	}
}
function player_shortcode() {
	ob_start();
	insert_player();
	form_input_player();
	return ob_get_clean();
}
function player_admin_page(){
	edit_player();
	delete_player();
	show_player();
}
add_shortcode( 'sitepoint_player_form', 'player_shortcode' );

include 'widget_player.php';