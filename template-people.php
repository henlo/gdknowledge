<?php
/*
Template Name: People
*/
get_header(); ?>
 

	<?php  
		dynamic_sidebar('Default Left'); 
	?>


	<div id="blog-people" class="blog">    

		<!-- TEMPLATE-PEOPLE.PHP -->

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
		dynamic_sidebar('Default Right'); 
	?>
	


<?php get_footer(); ?>