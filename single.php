<?php 



if(isset($_POST['submitted'])) {
    if(trim($_POST['registerFName']) === '') {
        $formError['fname'] = 'Please enter your first name.';
        $hasError = true;
    } else {
        $fname = trim($_POST['registerFName']);
    }

    if(trim($_POST['registerSName']) === '') {
        $formError['sname'] = 'Please enter your last name.';
        $hasError = true;
    } else {
        $sname = trim($_POST['registerSName']);
    }    

    $company = trim($_POST['company']);

    if(trim($_POST['email']) === '')  {
        $formError['email'] = 'Please enter your email address.';
        $hasError = true;
    } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
        $formError['email'] = 'Please enter a valid email address.';
        $hasError = true;
    } else {
        $email = trim($_POST['email']);
    }

    if(!isset($hasError)) {
        $emailTo = 'jcaulfield@gdlaw.co.uk,henry@conscious.co.uk';
        $subject = '[GD Knowledge] Details received from '.$fname.' '.$sname;
        $body = "Name: $fname $sname \n\nEmail: $email \n\nCompany: $company";
        $headers = 'From: GD Knowledge <admin@gdknowledge.co.uk>' . "\r\n" . 'Reply-To: ' . $email;

        wp_mail($emailTo, $subject, $body, $headers);
        setcookie("isRegistered", 1, time()+2592000);
        header('location: '.$_POST['url']);

    } else {
        setcookie("isRegistered", 0, time()+3600);
    }
} else {
    if( !isset($_COOKIE['isRegistered']) ) setcookie("isRegistered", -1, time()+3600);
}



get_header();





?>

    <div id="single-content-main" class="content">    

    	<!-- SINGLE.PHP -->

        <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); 

        // If the post is in specified categories, show squeeze page
        if( in_category('startups') ) {                        

            if( isset($hasError) ) {
                // ERROR
                ?>
                <p class="error">Sorry, there was a problem with your submission. Please check the error(s) below:<p>
                    <ul>
                <?php 
                foreach ($formError as $key => $thisError) {
                    print "<li>$thisError</li>";
                }
                ?>
                </ul>
                <?php
                
            } 


            if( $_COOKIE['isRegistered'] <= 0 ) {
            ?> 
            <p><strong>Start-up Guides</strong> – to access our guides to the legal issues that start-ups face please register your contact information. Once you have registered you will be able to access all of our guides and we will alert you when new guides become available. If you would prefer not to receive updates please visit <a href="www.gdlaw.co.uk/mypreferences">www.gdlaw.co.uk/mypreferences</a>.
            <form action="<?php the_permalink(); ?>" id="registerForm" class="frm" method="post">                
                <ul>
                    <li>
                        <label for="registerFName">First Name:</label>
                        <input type="text" name="registerFName" id="registerFName" value="" class="validate text" />
                    </li>
                    <li>
                        <label for="registerSName">Last Name:</label>
                        <input type="text" name="registerSName" id="registerSName" value="" class="validate text" />
                    </li>
                    <li>
                        <label for="email">Email:</label>
                        <input type="text" name="email" id="email" value="" class="validate email" />
                    </li>
                    <li>
                        <label for="company">Company Name:</label>
                        <input type="text" name="company" id="company" value="" class="text" />
                    </li>
                    <li>
                        <button id="submitform" type="submit">Submit details and view article</button>
                    </li>
                </ul>
                <input type="hidden" name="submitted" id="submitted" value="true" />
                <input type="hidden" name="url" id="submitted" value="<?php the_permalink(); ?>" />
            </form>

            <?php
            } 

        } // end if in categories


        // print '<h1>'.in_category('startups').'</h1>;
        // If it's not in the categories or the email was sent or the cookie is set
        if( !in_category('startups') || $_COOKIE['isRegistered'] == 1 ) {
            ?>

            <div class="post">

                <div class="post-date">
                    <!--
                    &#8226; <?php the_time('M'); ?> &#8226;
                    <span><?php the_time('j'); ?></span>
                    <div><?php the_time('M'); ?></div>
                    -->
                    &#8226; <?php the_time('M'); ?> &#8226;
                    <span><?php the_time('Y'); ?></span>                    
                </div>      

                <div id="single-content-text">
                    
                <div id="title-container">
                    <div id="title">
                        <h1>
                        <?php the_title(); ?>
                        </h1>
                    </div>
                </div>

                <div id="share-buttons-container">
                  <ul id="share-buttons">
                    <li id="share-title">Share:</li>
                    <li id="share-linkedin">
                      <a href="#">&nbsp;</a>
                    </li>
                    <li id="share-twitter">
                      <a href="#">&nbsp;</a>
                    </li>
                    <li id="share-email">
                        <a href="mailto:?subject=An interesting article from Goodman Derrick&amp;body=I thought you might be interested to read '<?php the_title() ?>': <?php the_permalink() ?>" title="Share by Email">&nbsp;</a>
                    </li>
                  </ul>
                </div>        
                
                <hr class="invisible nomargin" />

                <?php 
                if(has_post_thumbnail()) { 
                    // the_post_thumbnail('medium'); 
                }
               
                echo do_shortcode('[author_info user_id='.$post->post_author.') class="profile-top"]');
                the_content(); 
                // echo do_shortcode('[author_info user_id='.$post->post_author.') class="profile-bottom"]');



               ?>

               </div>

            </div>

            <?php 
        


        comments_template(); 

        } //end startup if
        ?>


		<?php endwhile; else: ?>
 
        <p>Sorry, post not found.</p>
        
        <?php endif; ?>
    </div>        

    <div id="blog-sidebar-right" class="sidebar-right">
        <?php dynamic_sidebar('Default Right'); ?>
    </div>

    </div>

<?php get_footer(); ?>
