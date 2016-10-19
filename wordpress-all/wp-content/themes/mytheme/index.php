<?php
if(of_get_option('maintenance_checkbox') == 1){
	echo "Maintenance";
}
else{
	get_header();
	get_sidebar('left');
	?>

	<div class="col-sm-6 blog-main"> 
		<?php 
		if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php 
		$count = of_get_option('limit_post_text');
		if ($count == "0") { break; }
		else { ?>
		<?php
		get_template_part( 'content', get_post_format() ); $count++;}
		endwhile;endif; 
		if ( comments_open() || get_comments_number() ) : comments_template();
		endif;
		?>
	</div>
	<?php get_sidebar('right'); ?>
	<?php get_footer(); }?>