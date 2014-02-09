<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="google-site-verification" content="2GCaianOxeBGQ02Tuiz8f3c2-w2vJvaXbnhQDmC3jAA" />
<link rel="icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | ".strip_tags(html_entity_decode($site_description));

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title> 
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
 

<?php
    /*
     *  Add this to support sites with sites with threaded comments enabled.
     */
    if ( is_singular() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );
 
    wp_head();
 
    wp_get_archives('type=monthly&format=link');
?>
</head>
<body id="<?php echo $post->post_name; ?>">

 
<div id="wrapper">
	
	<div id="topbar-container">
		<div id="topbar">
	<?php 
	// PRIMARY NAVIGATION MENU
	wp_nav_menu( 
		array( 	'sort_column' 		=> 'menu_order', 
				'menu_class' 		=> 'nav', 
				'container_id' 		=> 'primary-nav-container',
				'menu_id'         	=> 'primary-nav', 
				'theme_location' 	=> 'primary-menu' ) ); 
	?>
		<!--<a id="logo-small" href="<?php echo get_option('home'); ?>" alt="<?= bloginfo('name') ?>" title="<?= bloginfo('name') ?>"></a>-->
		<a id="logo-small" href="http://gdlaw.co.uk" alt="Goodman Derrick LLP" title="Goodman Derrick LLP"></a>
		</div>
	</div>

	

    <div id="header">

    	<div id="logo-box">
			<a id="logo" href="<?php echo get_option('home'); ?>" alt="<?= bloginfo('name') ?>" title="<?= bloginfo('name') ?>">Knowledge</a>
		
			<?php 
			// SECONDARY NAVIGATION MENU
			wp_nav_menu( 
				array( 	'sort_column' 		=> 'menu_order', 
						'menu_class' 		=> 'nav', 
						'container_id' 		=> 'secondary-nav-container',
						'menu_id'         	=> 'secondary-nav', 
						'theme_location' 	=> 'secondary-menu' ) ); 
			?>

		</div>


        <!-- RANDOM BANNER -->
        <div class="banner" id="banner<?php print rand(1,6); ?>">

			<div id="tagline">
				<h3>
				<?php
				print htmlspecialchars_decode(get_bloginfo('description'));
				?>
				</h3>
			</div>

        </div>

	    


    </div>

    <?php
    // Hide all protected posts
    if (!is_single()) { 
    	add_filter( 'posts_where', 'filter_where' ); 
    }
	$query = new WP_Query( $query_string );
	
	?>
  