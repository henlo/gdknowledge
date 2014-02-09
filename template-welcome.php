<?php
/*
Template Name: Home
*/
get_header(); ?>
 
	<div id="blog-welcome" class="blog">    

		<!-- TEMPLATE-WELCOME.PHP -->

        <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
 
        <div class="post">
 
            <div class="entry">
            <?php the_content(); ?>
 
            </div>
  
        </div>
 
		<?php endwhile; ?>

		<?php endif; ?>
		
	</div>


	<?php  
		// Uncomment if you want a homepage sidebar
		// dynamic_sidebar('Home'); 
	?>
	


<?php get_footer(); ?>