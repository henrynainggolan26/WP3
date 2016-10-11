<?php get_header(); ?>
<?php get_sidebar('left'); ?>
<div class="col-sm-6 blog-main">
    <?php 
    if ( have_posts() ) : while ( have_posts() ) : the_post();
    get_template_part( 'content', get_post_format() );
    endwhile; endif; 
    if ( comments_open() || get_comments_number() ) : comments_template();
    endif;
    ?>
</div>
<?php get_sidebar('right'); ?>
<?php get_footer();?>