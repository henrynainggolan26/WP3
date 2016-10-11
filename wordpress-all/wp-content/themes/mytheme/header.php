<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="blog-masthead" style="background:#e5e0e0">
        <div class="container">
            <?php wp_nav_menu( array('theme_location' => 'primary', 'menu_class' => 'blog-nav list-inline'));?>
        </div>
    </div>
    <div class="container">
        <div class="blog-header">
            <h1 class="blog-title"><img src="<?php echo of_get_option('upload_logo'); ?>" alt=""></h1>
            <?php $description = of_get_option('blog_desc'); ?>
            <?php if($description) { ?>
            <p class="lead blog-description"><?php echo $description ?></p><?php } ?>
        </div>    
        <div class="row">