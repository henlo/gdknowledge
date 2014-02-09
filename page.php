<?php get_header(); ?>
 

    <div id="default-sidebar-left" class="sidebar-left">
    <?php  
        dynamic_sidebar('Default Left'); 
    ?>
    </div>


    <div id="default-content-main" class="content">    

        <!-- PAGE.PHP -->

        <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

 
        <div class="single-post">
 
            <div class="entry">
	    
            <?php the_content(); ?>
 
            </div>
  
        </div>
 
        <?php endwhile; ?>

        <?php endif; ?>
        
    </div>

    <div id="default-sidebar-right" class="sidebar-right">
    <?php  
        dynamic_sidebar('Default Right'); 
    ?>
    </div>
    


<?php get_footer(); ?>