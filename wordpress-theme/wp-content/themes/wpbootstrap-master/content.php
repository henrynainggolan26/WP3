
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                <!-- Author -->
                <p class="lead">
                    by <a href="#"><?php the_author();?></a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php the_date();?></p>

                <hr>
                <?php if ( has_post_thumbnail() ) {?>

                <!-- Preview Image -->
                <div class="row">
                    <div class="col-md-4">
                        <?php   the_post_thumbnail('thumbnail'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php the_excerpt(); ?>
                    </div>
                </div>
                <?php } else { ?>
                <?php the_excerpt(); ?>
                <?php } ?>
                <a href="<?php comments_link(); ?>">
                        <?php
                        printf( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'textdomain' ), number_format_i18n(                       get_comments_number() ) ); ?>
                    </a>

                <hr>