<?php get_header(); ?>
 
    <div id="blog-content-main" class="content">
        <!-- CATEGORY.PHP -->

        <?php 

        $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
          <?php /* If this is a category archive */ if (is_category() || is_tag()) { ?>
            <h1><?php single_cat_title(); ?> know how</h1>
          <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
            <h1><?php the_time('F jS, Y'); ?> know how</h1>
          <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
            <h1><?php the_time('F, Y'); ?> know how</h1>
          <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
            <h1><?php the_time('Y'); ?> know how</h1>
          <?php /* If this is an author archive */ } elseif (is_author()) { ?>
            <h1>Author Archive</h1>
          <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
            <h1>Blog Archives</h1>
        <?php }

        $count = 0;
        if(have_posts()) : ?><?php while(have_posts()) : the_post(); 
            $postclass = ($count == 0 ? 'post' : 'post halfwidth');

            if( !$count && $_GET['s'] ) {
                print '<h1>Search results:</h1>';
            }

            $count++;

         ?>        
 
        <div class="<?php print $postclass; ?>">

            <div class="post-date">
                &#8226; <?php the_time('M'); ?> &#8226;
                <span><?php the_time('Y'); ?></span>
            </div>

            <div class="post-content">
                <h2 class="post-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>

                <div class="post-excerpt">
                    <?php the_excerpt(); ?>
                    <ul class="post-authors">
                            <?php 
                            $a_authors = get_post_meta( get_the_ID(), 'multiple_authors' );
                            if( is_array($a_authors[0]) ) {
                                foreach ($a_authors[0] as $key => $author_id) {
                                    $author = get_user_meta( $author_id );
                                    print '<li><a href="/author/'.$author['nickname'][0].'/">'.$author['first_name'][0].' '.$author['last_name'][0].'</a><br />';
                                    if( strlen($author['jobtitle'][0]) >= 1 ) print $author['jobtitle'][0];
                                    if( strlen($author['department'][0]) >= 1 ) print ', '.$author['department'][0];
                                    print '</li>';
                                }
                            }
                            ?>
                        </ul>                    
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
        
        <p>Sorry, no posts matched your criteria.</p>
        
        <?php endif; ?>
    </div>
    <div id="blog-sidebar-right" class="sidebar-right">
        <?php dynamic_sidebar('Default Right'); ?>
    </div>

<?php get_footer(); ?>
