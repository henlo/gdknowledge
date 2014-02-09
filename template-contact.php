<?php
/*
Template Name: Contact Form
*/


if(isset($_POST['submitted'])) {
	if(trim($_POST['contactName']) === '') {
		$nameError = 'Please enter your name.';
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}

	if(trim($_POST['email']) === '')  {
		$emailError = 'Please enter your email address.';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	if(trim($_POST['comments']) === '') {
		$commentError = 'Please enter a message.';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}

	if(!isset($hasError)) {
		$emailTo = 'jcaulfield@gdlaw.co.uk,jhellyer@gdlaw.co.uk';
		$subject = '[GD Knowledge] Contact from '.$name;
		$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
		$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		wp_mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}
} 


get_header(); ?>

    <div id="contact" class="content">
        <!-- TEMPLATE-CONTACT.PHP -->

        <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
 
        <div class="single-post">
 
            <div class="entry">
	    
            <?php 

            if( isset($emailSent) && $emailSent == true ) { ?>
				<div class="thanks">
					<p>Thank you, your email was sent successfully. We will respond to you within 24 hours.</p>
				</div>
				<?php 
			} else { 
				the_content(); 
				if( isset($hasError) || isset($captchaError) ) { ?>
					<p class="error">Sorry, an error occured.<p>
			<?php 
				}
			} 


			if( !$emailSent ) {
			?> 
			<form action="<?php the_permalink(); ?>" id="contactForm" class="frm" method="post">
				<p class="error">There was a problem with the information you entered. Please check the fields highlighted in red and resubmit the form</p>
				<ul>
					<li>
						<label for="contactName">Name:</label>
						<input type="text" name="contactName" id="contactName" value="" class="validate text" />
					</li>
					<li>
						<label for="email">Email:</label>
						<input type="text" name="email" id="email" value="" class="validate email" />
					</li>
					<li>
						<label for="commentsText">Message:</label>
						<textarea name="comments" id="commentsText" rows="20" cols="30" class="text"></textarea>
					</li>
					<li>
						<button id="submitform" type="submit">Send email</button>
					</li>
				</ul>
				<input type="hidden" name="submitted" id="submitted" value="true" />
			</form>

			<?php
			}
			?>

            </div>
  
        </div>
 
        <?php endwhile;

        endif; ?>

    </div>

    <div id="blog-sidebar-right" class="sidebar-right">
        <?php dynamic_sidebar('Default Right'); ?>
    </div>


<?php 
get_footer(); 
?>