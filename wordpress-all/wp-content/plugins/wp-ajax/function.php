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
add_shortcode('shortcode_display_autocomplete', 'display_autocomplete');


function googlemap_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "width" => '640',
      "height" => '480',
      "src" => ''
   ), $atts));
   return '<iframe width="'.$width.'" height="'.$height.'" src="'.$src.'&output=embed" ></iframe>';
}
add_shortcode("googlemap", "googlemap_function");

add_filter('widget_text', 'do_shortcode');