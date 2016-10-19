<?php
function startwordpress_scripts() {

	wp_register_style( 'bootstrap',get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );
	wp_register_style( 'blog-post', get_template_directory_uri() . '/css/blog-post.css' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery.min.js', array('jquery'), '1.11.3', true );
	wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.7', true );


	wp_enqueue_style( 'bootstrap');
	wp_enqueue_style( 'blog-post');
	wp_enqueue_script( 'jquery');
	wp_enqueue_script( 'bootstrap');
}
add_action( 'wp_enqueue_scripts', 'startwordpress_scripts' );
// Support Featured Images
add_theme_support( 'post-thumbnails' );
function test_widgets_init() {

	register_sidebar( array(
		'name'          => 'Right Sidebar',
		'id'            => 'right_sidebar',
		'before_widget' => '<div class="well">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );
	

}
add_action( 'widgets_init', 'test_widgets_init' );

require_once('wp_bootstrap_navwalker.php');

register_nav_menus( array(  
  'primary' => __( 'Primary Navigation', 'wpbootstrap' ),  
  'secondary' => __('Secondary Navigation', 'wpbootstrap')  
) );

// function register_my_menus() {
//   register_nav_menus(
//     array(
//       'primary-menu' => __( 'Primary Menu' ),
//       'footer-menu' => __( 'Footer Menu' )
//     )
//   );
// }
// add_action( 'init', 'register_my_menus' );
