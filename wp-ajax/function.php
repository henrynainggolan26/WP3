<?php
/*
Plugin Name: WP Ajax
Version: 1.0
Author: Henry
*/
include "widget_search.php";

function add_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-autocomplete' );
	wp_register_style( 'jquery-ui-styles','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' );
	wp_enqueue_style( 'jquery-ui-styles' );
	wp_register_script( 'my_autocomplete', plugin_dir_url( __FILE__ ) . '/js/my-autocomplete.js', array( 'jquery', 'jquery-ui-autocomplete' ), '1.0', false );
	wp_localize_script( 'my_autocomplete', 'my_autocomplete', array( 'urlrrr' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'my_autocomplete' );
}

add_action( 'wp_enqueue_scripts', 'add_scripts' );

add_action( 'wp_ajax_autocomplete_post', 'my_action_autocomplete_postcallback' );
add_action( 'wp_ajax_nopriv_autocomplete_post', 'my_action_autocomplete_postcallback' );

add_action( 'wp_ajax_get_value', 'my_action_get_value_callback' );
add_action( 'wp_ajax_nopriv_get_value', 'my_action_get_value_callback' );

function my_action_autocomplete_postcallback() {
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
				$the_query->the_post();
				the_title(); 
				echo "</br>";
				//the_content();
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
add_shortcode('shortcode_display_autocomplete', 'display_autocomplete');