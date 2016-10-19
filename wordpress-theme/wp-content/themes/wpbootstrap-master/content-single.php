
                <h2><?php the_title(); ?></h2>

                <!-- Author -->
                <p class="lead">
                    by <a href="#"><?php the_author();?></a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php the_date();?></p>

                <hr>
                <?php if ( has_post_thumbnail() ) {
                  the_post_thumbnail();
                } ?>
                <?php the_content();?>

                <hr>