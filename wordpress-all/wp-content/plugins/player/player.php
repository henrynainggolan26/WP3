<?php
/*
Plugin Name: Players
Description: Players Plugin
Version: 1.0
Author: Henry
*/
include 'widget_player.php';
include "widget_search.php";

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

add_shortcode( 'sitepoint_player_form', 'player_shortcode' );
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

add_action( 'wp_enqueue_scripts', 'add_scripts' );
function add_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-autocomplete' );
	wp_register_style( 'jquery-ui-styles','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' );
	wp_enqueue_style( 'jquery-ui-styles' );
	wp_register_script( 'my_autocomplete', plugin_dir_url( __FILE__ ) . '/js/my-autocomplete.js', array( 'jquery', 'jquery-ui-autocomplete' ), '1.0', false );
	wp_localize_script( 'my_autocomplete', 'my_autocomplete', array( 'urlrrr' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'my_autocomplete' );
	wp_enqueue_style( 'prefix-style', plugins_url('style.css', __FILE__) );
}

function my_action_autocomplete_post_callback() {
	$keyword = isset($_POST['search']) ? $_POST['search'] : null;
	$args = array('s' => $keyword );
	$arrayAvailable = [];
	$the_query = new WP_Query($args);

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$title = get_the_title();
			$obj = new StdClass();
			$obj->label = $title;
			$obj->value = $title;
			$arrayAvailable[] = $obj;	
		}
		wp_reset_query();
	}
	wp_send_json($arrayAvailable);
}

add_shortcode('shortcode_display_autocomplete', 'display_autocomplete');
function display_autocomplete(){
	if($_GET['search_name'] == ""){
	}
	else{
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ): 1;
		$keyword = isset($_GET['search_name']) ? $_GET['search_name'] : null;
		$args = array('s' => $keyword ,
			'posts_per_page' => 5,
			'paged'         => $paged,
			);

		$the_query = new WP_Query($args);

		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> 
				<?php echo "</br>";
			}
			wp_reset_query();
		}
		else{ 
			?>
			<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			<?php
		}
		$big = 999999999;

		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $the_query->max_num_pages,
			) );
	}
}

add_filter('widget_text', 'do_shortcode');

add_action( 'init', 'create_team_players' );
function create_team_players() {
    register_post_type( 'national_players',
        array(
            'labels' => array(
                'name' => 'National Players',
                'singular_name' => 'National Player',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New National Player',
                'edit' => 'Edit',
                'edit_item' => 'Edit National Player',
                'new_item' => 'New National Player',
                'view' => 'View',
                'view_item' => 'View National Player',
                'search_items' => 'Search National Player',
                'not_found' => 'No National Players found',
                'not_found_in_trash' => 'No National Players found in Trash',
                'parent' => 'Parent National Player'
                ),

            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url( 'image/image.ico', __FILE__ ),
            'has_archive' => true
            )
	);
}

add_filter('rwmb_meta_boxes', 'team_members_register_meta_boxes');
function team_members_register_meta_boxes($meta_boxes){
    $meta_boxes[] = array(
        'id'         => 'national_players',
        'title'      => __( 'Other Information', 'textdomain' ),
        'post_types' => 'national_players',
        'context'    => 'normal',
        'priority'   => 'high',
        'fields' => array(
            array(
                'name'  => __( 'National', 'textdomain' ),
                'desc'  => 'Format: Example : English',
                'id'    => 'tmnational',
                'type'  => 'text',
                ),
            array(
                'name'  => __( 'Website', 'textdomain' ),
                'desc'  => 'Format: www.example.com',
                'id'    => 'tmwebsite',
                'type'  => 'text',
                ),
            array(
                'name'  => __( 'Image', 'textdomain' ),
                'desc'  => 'Format: *JPG/*JPEG',
                'id'    => 'tmimage',
                'max_file_uploads'=>1,  
                'type'  => 'image',
                ),
            ),
	); return $meta_boxes;
}

function custom_excerpt_length( $length ) {
    return 5;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function display_team_player($atts){
    /*$attributes = shortcode_atts(
        array(
            'national' => '',
            ), 
        $atts
        );*/

$post_type = array( 'post_type' => 'national_players', );
$result = new WP_Query( $post_type);
?>

<div class="row" style="background:#e5e0e0" >
    <?php
    while ( $result->have_posts() ) : $result->the_post();
    $national = get_post_meta( get_the_ID(), 'tmnational', true );
    $website = get_post_meta( get_the_ID(), 'tmwebsite', true );
    $id_image = get_post_meta( get_the_ID(), 'tmimage', true ); 
    $temp_image = wp_get_attachment_image_src( $id_image, array('200', '200') );
    ?>

    <div class="col-sm-6 blog-main">
        <p>
            <img src="<?php echo $temp_image[0];?>" class="picture">
            <h4><center><?php echo the_title();?></center></h4>
            <h5><center><?php echo $national;?></center></h5>
            <p align="left"><?php echo the_excerpt();?></p>
                <!-- 
                <?php
                if ($attributes['national'] == 'show') {
                    echo "<p><center> National :".$national."</center></p>";

                }
                ?>-->
            </p>
        </div>
        <?php
        endwhile;
        ?>
    </div>
    <?php
}
add_shortcode('shortcode_display_team_player', 'display_team_player');