<?php
	$footer= of_get_option('footer_copy_right');
?>
</div><!-- /.row -->
</div><!-- /.container -->
<footer class="blog-footer">
	<div class="container">
		<?php wp_nav_menu( array('theme_location' => 'secondary', 'menu_class' => 'blog-nav list-inline'));?>
	</div>
	<div class="row">
		<div class="col-lg-12">
				<?php 
					if(!empty($footer)){
						echo "<p align=center>".$footer."</p>";
					}
					else{
						echo "<p align=center>Copyright © My Theme Wordpress 2016</p>";
					} 
				?>
		</div>
	</div>
</footer>
<script type="text/javascript">var BASE = "<?php echo home_url() ?>";</script>
<?php wp_footer(); ?>
</body>
</html>