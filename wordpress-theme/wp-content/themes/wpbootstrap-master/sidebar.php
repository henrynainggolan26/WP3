

<!--     <div class="well">
        <h4>Blog Search</h4>
        <div class="input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">
                    <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
        </div>
        
    </div> -->

    <!-- Blog Categories Well -->
    
        
        <?php if ( is_active_sidebar( 'right_sidebar' ) ) : 
            dynamic_sidebar( 'right_sidebar' ); 
            endif;
            ?>
        
        <!-- /.row -->
    
    <!-- Side Widget Well -->
    
