<?php get_header(); ?>
    <div id="blog-content-main" class="content">
        <!-- INDEX.PHP -->

        <?php 

        

        $count = 0;
        if(have_posts()) : while(have_posts()) : the_post(); 

            $postclass = ($count == 0 ? 'post' : 'post halfwidth');

            if( !$count && $_GET['s'] ) {
                print '<h1>Search results:</h1>';
            }

            $count++;
        ?>
 
        <div class="<?php print $postclass; ?>">

            <div class="post-date">
                <!--
                &#8226; <?php the_time('M'); ?> &#8226;
                <span><?php the_time('j'); ?></span>
                <div><?php the_time('M'); ?></div>
                -->
                &#8226; <?php the_time('M'); ?> &#8226;
                <span><?php the_time('Y'); ?></span>
            </div>

            <div class="post-content">
                <h2 class="post-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>

                <div class="post-excerpt">
                    <?php the_excerpt(); ?>
                </div>

                <div class="post-tags">
                    <?php
                    $tags = wp_get_post_tags(get_the_ID());
                    $taglist = '<ul><li class="icon">Topics</li>';
                    $bullet = '';
                    foreach ($tags as $tag){
                        $tag_link = get_tag_link($tag->term_id);        
                        $taglist .= "<li>".$bullet."</li><li><a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
                        $taglist .= "{$tag->name}";
                        $taglist .= "</a></li>";    
                        $bullet = " | ";
                    }
                    print $taglist."</ul>";
                    ?>
                </div>

            </div>

        </div>

		<?php 

        if( $count%2 != 0 ) print '<hr />';

        endwhile; else: ?>
        
        <h1>Sorry, no posts matched your criteria.</h1>
        <p>Please try searching again or browse to another page on the site.</p>

        <?php endif; ?>

    </div>

    <div id="blog-sidebar-right" class="sidebar-right">
        <?php dynamic_sidebar('Default Right'); ?>
    </div>

<?php get_footer(); ?>