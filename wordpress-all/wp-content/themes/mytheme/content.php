<div class="blog-main">
	<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
	<p class="blog-main-meta"><?php the_date(); ?> by <?php the_author(); ?></p>
	<?php the_content(); ?>
</div>