<?php
/*
Template Name: Subscribe
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

	if(trim($_POST['companyName']) === '') {
		$companyError = 'Please enter your company name.';
		$hasError = true;
	} else {
		$company = trim($_POST['companyName']);
	}	

	$phone = trim($_POST['phone']);

	if(!isset($hasError)) {
		$emailTo = 'jcaulfield@gdlaw.co.uk,jhellyer@gdlaw.co.uk';
		$subject = '[GD Knowledge] Subscribe to newsletter from '.$name;
		$body = "Name: $name \n\nEmail: $email \n\nCompany: $company \n\nPhone: $phone";
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
					<p>Thank you, you have subscribed to GD On-line.</p>
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
			<form action="<?php the_permalink(); ?>" id="subscribeForm" class="frm" method="post">
				<p class="error">There was a problem with the information you entered. Please check the fields highlighted in red and resubmit the form</p>
				<ul>
					<li>
						<label for="contactName">Name:</label>
						<input type="text" name="contactName" id="contactName" value="" class="validate text" />
					</li>
					<li>
						<label for="companyName">Company Name:</label>
						<input type="text" name="companyName" id="companyName" value="" class="validate text" />
					</li>
					<li>
						<label for="phone">Phone:</label>
						<input type="text" name="phone" id="phone" value="" class="text" />
					</li>					
					<li>
						<label for="email">Email:</label>
						<input type="text" name="email" id="email" value="" class="validate email" />
					</li>
					<li>
						<button id="submitform" type="submit">Subscribe</button>
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