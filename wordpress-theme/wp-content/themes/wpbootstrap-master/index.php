        <?php get_header();?>
        <div class="row">
            <div class="col-lg-8">

                <?php 
                    if ( have_posts() ) : while ( have_posts() ) : the_post();
            
                        get_template_part( 'content', get_post_format() );
          
                    endwhile; endif; 
                ?>
                
                
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                <?php get_sidebar();  ?>

            </div>

        </div>
        <!-- /.row -->


        <hr>

        <!-- Footer -->
        <?php get_footer();?>
        
