
<?php
/*
Plugin Name: National Players
Description: Declares a plugin that will create a custom post type displaying team players.
Version: 1.0
Author: Henry
*/

add_action( 'wp_enqueue_scripts', 'safely_add_stylesheet' );
function safely_add_stylesheet() {
    wp_enqueue_style( 'prefix-style', plugins_url('style.css', __FILE__) );
}

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
?>