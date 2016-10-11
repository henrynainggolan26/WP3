<?php
function bootstrapstarter_enqueue_styles() {
	wp_register_style('bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css' );
	$dependencies = array('bootstrap');
	wp_enqueue_style( 'bootstrapstarter-style', get_stylesheet_uri(), $dependencies ); 
}
add_action( 'wp_enqueue_scripts', 'bootstrapstarter_enqueue_styles' );

function bootstrapstarter_enqueue_scripts() {
	$dependencies = array('jquery');
	wp_enqueue_script('bootstrap', get_template_directory_uri().'/bootstrap/js/bootstrap.min.js', $dependencies, '', true );
}
add_action( 'wp_enqueue_scripts', 'bootstrapstarter_enqueue_scripts' );

function bootstrapstarter_wp_setup() {
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'bootstrapstarter_wp_setup' );

function bootstrapstarter_register_menu() {
	register_nav_menus( array(  
		'primary' => __( 'Primary Navigation', 'mytheme' ),  
		'secondary' => __('Secondary Navigation', 'mytheme')  
		) );
}
add_action( 'init', 'bootstrapstarter_register_menu' );

function bootstrapstarter_widgets_init() {
	register_sidebar( array(
		'name'          => 'Left Sidebar',
		'id'            => 'sidebar-left',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		) );
	register_sidebar( array(
		'name'          => 'Right Sidebar',
		'id'            => 'sidebar-right',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		) );
}
add_action( 'widgets_init', 'bootstrapstarter_widgets_init' );

function custom_header(){
	$defaults = array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => 0,
		'height'                 => 0,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => '',
		'header-text'            => true,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
		);
	return $defaults;
}
add_theme_support( 'custom-header', custom_header() );


function new_excerpt_more($more) {
	return '';
}
add_filter('excerpt_more', 'new_excerpt_more' );

function the_excerpt_more_link($excerpt){
	$excerpt .= '... <a href="'. get_permalink() . '">continue reading</a>.';
	return $excerpt;
}
add_filter( 'the_excerpt', 'the_excerpt_more_link', 1 );

/*
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 */

define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
require_once dirname( __FILE__ ) . '/inc/options-framework.php';

// Loads options.php from child or parent theme
$optionsfile = locate_template( 'options.php' );
load_template( $optionsfile );

/*
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 *
 * You can delete it if you not using that option
 */