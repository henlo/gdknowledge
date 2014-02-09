<?php

// Scripts
function my_scripts_method() {
    // wp_deregister_script( 'jquery' );
    // wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js');
    wp_enqueue_script( 'jquery' );
    wp_deregister_script( 'custom' );
    wp_register_script( 'custom', get_bloginfo('template_url') . '/js/custom.js');
    wp_enqueue_script( 'custom' );        
    wp_deregister_script( 'validate' );
    wp_register_script( 'validate', get_bloginfo('template_url') . '/js/jquery.validationEngine.js');
    wp_enqueue_script( 'validate' );
} 

add_action('wp_enqueue_scripts', 'my_scripts_method');
 
//Add support for WordPress 3.0's custom menus
add_action( 'init', 'register_my_menu' );
 
 // Shortcodes in widgets
add_filter('widget_text', 'do_shortcode');


// Disable email notification to authors when comment left
// function wp_notify_postauthor() { }
 
//Register area for custom menu
function register_my_menu() {
    register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
    register_nav_menu( 'secondary-menu', __( 'Secondary Menu' ) );
}

// Show home page link in menus
function home_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'home_page_menu_args' );

// Enable post thumbnails
add_theme_support('post-thumbnails');
set_post_thumbnail_size(520, 250, true);


//Some simple code for our widget-enabled sidebar
add_action( 'widgets_init', 'register_my_sidebars' );
function register_my_sidebars() {
	if ( function_exists('register_sidebar') ) {
		$args = array(
			'name'          => 'Default Right',
			'id'            => 'sidebar-default-right');
		register_sidebar($args);		
	}
}


//Enable post and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );
 
// Disable admin bar on site
add_theme_support( 'admin-bar', array( 'callback' => '__return_false') );
 
// Theme images directory shortcode
function my_url($atts, $content = null) {
  return get_bloginfo('url'); 
}
add_shortcode("url", "my_url");  
 
function my_template_url($atts, $content = null) {
  return get_bloginfo('template_url'); 
}
add_shortcode("template_url", "my_template_url");  
 
function my_images_url($atts, $content = null) {
  return get_bloginfo('template_url') . '/images'; 
}
add_shortcode("images_url", "my_images_url");

function my_main_domain($atts, $content = null) {
  return "http://dawson-hart.co.uk";
}
add_shortcode("main_domain", "my_main_domain");


/****** User Information ******/

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

/* File lister for recursive dirs */
function dir_tree($dir) {
   $path = '';
   $stack[] = $dir;
   while ($stack) {
       $thisdir = array_pop($stack);
       if ($dircont = scandir($thisdir)) {
           $i=0;
           while (isset($dircont[$i])) {
               if ($dircont[$i] !== '.' && $dircont[$i] !== '..') {
                   $current_file = "{$thisdir}/{$dircont[$i]}";
                   if (is_file($current_file)) {
                       $path[] = "{$thisdir}/{$dircont[$i]}";
                   } elseif (is_dir($current_file)) {
                        $path[] = "{$thisdir}/{$dircont[$i]}";
						$stack[] = $current_file;
                   }
               }
               $i++;
           }
       }
   }
   return $path;
}

function my_show_extra_profile_fields( $user ) { 

	$uploads  = '/wp-content/uploads';
	$mydir    = $_SERVER["DOCUMENT_ROOT"].$uploads;
	$sizelimit = 90;
	$flist = dir_tree($mydir);

	/* 	Run through the images in the uploads directories
		and create a list of avatars */

	foreach($flist as $path) {
		//print "<li>".$path;
		$ext = substr($path, -4);
		if( $ext == '.png' || $ext == '.jpg' ) {
			$size = getimagesize($path);
			if($size[0] <= $sizelimit && $size[1] <= $sizelimit && $size[0] == $size[1] ) {
				$hrefpath = explode($uploads,$path);
				$avatars[] = $uploads.$hrefpath[1];
			}
		}
	} 
	
	//print $mydir;
	//print "<pre>";
	//print_r($avatars);
	//print "</pre>";

	?>
	<h3>Extra profile information</h3>

	<table class="form-table">
		<tr>
			<th><label for="jobtitle">Job Title</label></th>

			<td>
				<input type="text" name="jobtitle" id="jobtitle" value="<?php echo esc_attr( get_the_author_meta( 'jobtitle', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>		
		<tr>
			<th><label for="department">Department</label></th>

			<td>
				<input type="text" name="department" id="department" value="<?php echo esc_attr( get_the_author_meta( 'department', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>		
		<tr>
			<th><label for="gdprofile">GD Profile</label></th>

			<td>
				<input type="text" name="gdprofile" id="gdprofile" value="<?php echo esc_attr( get_the_author_meta( 'gdprofile', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Enter the URL of the user's GD account.</span>
			</td>
		</tr>		
		<tr>
			<th><label for="linkedin">LinkedIn Profile</label></th>

			<td>
				<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Enter the URL of the user's LinkedIn account.</span>
			</td>
		</tr>
		
		<tr>
			<th><label for="avatar">Profile Picture URL</label></th>
			<td>
			<input type="text" name="avatar" id="avatar" value="<?php echo esc_attr( get_the_author_meta( 'avatar', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description">Click an image below (from your <a href="upload.php">Media Gallery</a>), or paste the URL to the image. Image should be small and square.<br/><strong>Don't forget to save!</strong></span>
			</td>
			</tr>
			<tr>
			<th><label>Click an image:</label></th>
			<td>
			<?php
			if( isset($avatars) ) {
				foreach( $avatars as $avatar) {
					print '<img src="'.$avatar.'" onclick="jQuery(\'#avatar\').val(\''.addslashes($avatar).'\')" style="width: 64px; height: 64px;" />';
				}
			}
			?>
			</td>
		</tr>		

	</table>
	<?php 
}

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
 
function save_extra_user_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
	update_user_meta( $user_id, 'avatar', $_POST['avatar'] );
	update_user_meta( $user_id, 'jobtitle', $_POST['jobtitle'] );
	update_user_meta( $user_id, 'department', $_POST['department'] );
	update_user_meta( $user_id, 'gdprofile', $_POST['gdprofile'] );
	update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
}


// Show author info
function my_author_info( $atts ) {

	extract( shortcode_atts( array(
		'class' => 'default',
		'show_pic' => 0
	), $atts ) );

	ob_start();
	?>
    <div class="author <?php print $class; ?>">
        <!--<h3>Author details</h3> -->
        <?php 
        $author_info = get_user_meta( $user_id ); 

        $a_authors = get_post_meta( get_the_ID(), 'multiple_authors' );

		if( is_array($a_authors[0]) ) {
    		foreach ($a_authors[0] as $key => $author_id) {
    			$author = get_user_meta( $author_id );
		    	if( strlen($author['avatar'][0]) ) {
		        	$avatar = $author['avatar'][0];
		        } else {
		        	$avatar = get_bloginfo('template_url').'/images/mystery-man.jpg';
		        }
    			$authorname = $author['first_name'][0].' '.$author['last_name'][0];
    			$profilelink = '<a class="opennewtab" href="'.$author['gdprofile'][0].'">'.$authorname.'</a>';		
    			?>
		        
		        <ul class="author-info">
		        	<li class="author-image"><img title="<?php print $authorname; ?>" src="<?php print $avatar; ?>" /></li>
		        	<li class="author-name"><strong><?php print $authorname ?></strong></li>
		        	<?php if( strlen($author['jobtitle'][0]) >= 1 ) {  ?> <li class="author-jobtitle"><?php print $author['jobtitle'][0] ?></li> <?php } ?>
		        	<?php if( strlen($author['department'][0]) >= 1 ) {  ?> <li class="author-department"><?php print $author['department'][0] ?></li> <?php } ?>
		        	<li class="author-articles"><a href="/author/<?php print $author['nickname'][0]; ?>/">See all articles by this author</a></li>

		        </ul>
		        <?php
    		}
    	}        
        ?>
    </div>

    <?php

    $output = ob_get_contents();
	ob_end_clean();
	return $output;

}
add_shortcode("author_info", "my_author_info");


// Featured post in rh column
function my_featured_post( $atts ) {

    query_posts( array ( 'category_name' => 'featured', 'posts_per_page' => 1 ) );

    ob_start();
    if(have_posts()) : ?><?php while(have_posts()) : the_post(); 
    ?>

    <div id="rh-featured">
        <div class="post-date">
            &#8226; <?php the_time('M'); ?> &#8226;
            <span><?php the_time('Y'); ?></span>
        </div>		
        <div class="thumbnail">
        <?php 

        if( has_post_thumbnail() ) the_post_thumbnail('thumbnail'); 
        else print '<img src="'.get_bloginfo('template_url').'/images/featured-default.jpg" alt="Featured" />';

        ?>
        </div>
        <div class="featured-content">
        	<h3>
            <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
            </a>
        	</h3>
            
            <div class="excerpt">
            <?php the_excerpt(); ?>
            </div>

            <div class="tags">
            	<?php
				$tags = wp_get_post_tags(get_the_ID());
				$taglist = '<ul><li class="icon">&nbsp;</li>';
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
    endwhile;
    endif; 

    $output = ob_get_contents();
	ob_end_clean();
	wp_reset_query();
	return $output;

}
add_shortcode("featured_posts", "my_featured_post");

// Function to exclude password protected posts
function filter_where( $where = '' ) {
    // exclude password protected
    $where .= " AND post_password = ''";
    return $where;
}

// List posts by sector
function my_cat_list( $atts ) { 

	extract( shortcode_atts( array(
		'parent_cat_id' => '1',
		'limit' => '3'
	), $atts ) );

	$a_cats = get_categories( array( 'child_of' => $parent_cat_id ) );

	ob_start();

	$sectorcount = 0;
	$output_contents = '<div id="contents"><ul>';

	foreach ($a_cats as $key => $array) {
		query_posts( array ( 'category_name' => $array->slug, 'posts_per_page' => $limit ) );

		?>
		<div class="sector-container" id="sector-<?php print $array->slug; ?>">
			<div class="sector-title"><h2><a name="<?php print $array->slug; ?>" href="<?php print get_category_link($array->cat_ID); ?>"><?php print $array->name; ?></a></h2></div>
			<?php

			if( $sectorcount ) $output_contents .= '<li class="divider">&#8226;</li>';
			$output_contents .= '<li><a href="/category/'.$array->slug.'">'.$array->name.'</a></li>';

			$first = ' first';
			if(have_posts()) : ?><?php while(have_posts()) : the_post(); 

			?>
			<div class="sector-post<?php print $first ?>">
				
		        <div class="post-date">
		        	<!--
		            &#8226; <?php the_time('M'); ?> &#8226;
		            <span><?php the_time('j'); ?></span>
		        	<div><?php the_time('M'); ?></div>
		        	-->
		        	&#8226; <?php the_time('M'); ?> &#8226;
	                <span><?php the_time('Y'); ?></span>	
		        </div>		  
		        <div class="sector-post-content">
			        <div class="post-title">
			        	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			        </div>
			        <div class="sector-post-excerpt">
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
		    	</div>
		    </div>
	        <?php 
	        $first = '';
	        endwhile;
	        endif; 
	        ?>

	    </div>
	    <?php
	    if( $sectorcount%2 == 1 ) print '<hr class="invisible" />';
	    $sectorcount++;
	}
	$output_contents .= '</ul></div>';

    $output = ob_get_contents();
	ob_end_clean();
	wp_reset_query();
	return $output_contents.$output;

}
add_shortcode("cat_list", "my_cat_list");


// List all posts
function my_post_list() { 

	ob_start();

	$the_query = new WP_Query( "showposts=9" );

    $count = 0;
    if($the_query->have_posts()) : while ( $the_query->have_posts() ) : $the_query->the_post(); 

    	if( in_category('startups') ) continue;

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
	    
	    <h1>Sorry, no posts matched your criteria.</h1>
	    <p>Please try searching again or browse to another page on the site.</p>

    <?php 

    endif;

    $output = ob_get_contents();
	ob_end_clean();
	wp_reset_postdata();
	return $output;

}
add_shortcode("post_list", "my_post_list");



/** Extra fields on post page **/

/* Define the custom box */

add_action( 'add_meta_boxes', 'hlextra_add_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'hlextra_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function hlextra_add_custom_box() {
    $screens = array( 'post' );
    foreach ($screens as $screen) {
        add_meta_box(
            'hlextra_multiauthor',
            __( 'Multiple Authors', 'hlextra_textdomain' ),
            'hlextra_inner_custom_box',
            $screen
        );
    }
}

/* Prints the box content */
function hlextra_inner_custom_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'hlextra_nonce' );

  // The actual fields for data entry
  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
  
  	echo '<table><tr><td style="vertical-align: top;"><p>Select multiple authors by holding Ctrl while clicking on required names</p><p>Selections made here will override the normal Post Author</p></td><td>';
	$a_authors = get_post_meta( $post->ID, 'multiple_authors' );
	$a_users = get_users();
	echo '<select name="hlextra_authors[]" size=30 multiple>';
	foreach( $a_users as $user ) {
		if( is_array($a_authors[0]) ) $selected = ( in_array($user->ID, $a_authors[0])  ? 'selected' : '' );
		echo '<option '.$selected.' value="'.$user->ID.'">'.$user->display_name.'</option>';
	}
	echo '</select></td></tr></table>';  
}

/* When the post is saved, saves our custom data */
function hlextra_save_postdata( $post_id ) {

  // First we need to check if the current user is authorised to do this action. 
  if ( 'page' == $_POST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return;
  } else {
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // Secondly we need to check if the user intended to change this value.
  if ( ! isset( $_POST['hlextra_nonce'] ) || ! wp_verify_nonce( $_POST['hlextra_nonce'], plugin_basename( __FILE__ ) ) )
      return;

  // Thirdly we can save the value to the database



  // Do something with $mydata 
  // either using 
  update_post_meta($post_id, 'multiple_authors', $_POST['hlextra_authors']);
  // or a custom table (see Further Reading section below)
}
 
?>
