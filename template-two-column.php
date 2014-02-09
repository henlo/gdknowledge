<?php 
/*
Template Name: Two Columns
*/
get_header(); ?>
 
    <div id="twocol-content-main" class="content">    

        <!-- template-three-column.php -->

        <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
 
        <div class="post">
 
            <div class="entry">
            <?php the_content(); ?>
 
            </div>
  
        </div>
 
        <?php endwhile; ?>

        <?php endif; ?>
        
    </div>

    <div id="twocol-sidebar-right" class="sidebar-right">
    <?php  
        dynamic_sidebar('Default Right'); 
    ?>
    </div>
    


<?php get_footer(); ?>