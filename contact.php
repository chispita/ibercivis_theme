<?php
/**
 * Template Name: Contact
 * The main template file for display contact page.
 *
 * @package WordPress
*/


/**
*	if not submit form
**/
if(!isset($_GET['your_name']))
{

/**
*	Get Current page object
**/
$current_page = get_page($post->ID);
$current_page_id = '';

if(isset($current_page->ID))
{
    $current_page_id = $current_page->ID;
}

//Get Page Sidebar
$page_sidebar = get_post_meta($current_page_id, 'page_sidebar', true);
if(empty($page_sidebar))
{
	$page_sidebar = 'Contact Sidebar';
}

get_header(); 

//Get Page background style
$bg_style = get_post_meta($current_page_id, 'page_bg_style', true);

//Check browser and version for performance tuning
$isIE8 = ereg('MSIE 8',$_SERVER['HTTP_USER_AGENT']);
if($isIE8)
{
	$bg_style = 'Static Image';
}

if($bg_style == 'Static Image')
{
    if(has_post_thumbnail($current_page_id, 'full'))
    {
        $image_id = get_post_thumbnail_id($current_page_id); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        $pp_page_bg = $image_thumb[0];
    }
    else
    {
    	$pp_page_bg = get_stylesheet_directory_uri().'/../../uploads/2013/03/bg_home.jpg';
    }
?>
<script type="text/javascript"> 
    jQuery.backstretch( "<?php echo $pp_page_bg; ?>", {speed: 'slow'} );
</script>

<?php
} // end if static image
else
{
    $page_bg_gallery_id = get_post_meta($current_page_id, 'page_bg_gallery_id', true);
    $args = array( 
    	'post_type' => 'attachment', 
    	'numberposts' => -1, 
    	'post_status' => null, 
    	'post_parent' => $page_bg_gallery_id,
    	'order' => 'ASC',
    	'orderby' => 'menu_order',
    ); 
    $bg_photo_arr = get_posts( $args );
    $count_photo = count($bg_photo_arr);
?>

<script type="text/javascript">  
    									  
<?php
	//Get timer setting				
    $pp_homepage_slideshow_timer = get_option('pp_homepage_slideshow_timer');
    
    if(empty($pp_homepage_slideshow_timer))
    {
    	$pp_homepage_slideshow_timer = 5000;
    }
    else
    {
    	$pp_homepage_slideshow_timer = $pp_homepage_slideshow_timer*1000;
    }
    
    //Check if iPad or iPhone
    if($isiPad || $isiPhone) 
    {
    	$pp_kenburns_frames_rate = 10;
    }
    else
    {
    	$pp_kenburns_frames_rate = 30;
    }
?>
							  
$j(function(){
	$j('#kenburns_overlay').css('width', $j(window).width() + 'px');
	$j('#kenburns_overlay').css('height', $j(window).height() + 'px');
	$j('#kenburns').attr('width', $j(window).width());
	$j('#kenburns').attr('height', $j(window).height());
	$j(window).resize(function() {
		$j('#kenburns').remove();
		$j('#kenburns_overlay').remove();
		
		$j('body').append('<canvas id="kenburns"></canvas>');
		$j('body').append('<div id="kenburns_overlay"></div>');
	
	  	$j('#kenburns_overlay').css('width', $j(window).width() + 'px');
		$j('#kenburns_overlay').css('height', $j(window).height() + 'px');
		$j('#kenburns').attr('width', $j(window).width());
		$j('#kenburns').attr('height', $j(window).height());
		
			$j('#kenburns').kenburns({
			images:[
			<?php
			    foreach($bg_photo_arr as $key => $photo)
			    {
			        if(!empty($photo->guid))
			        {
			        	$image_url[0] = $photo->guid;
			        }
			
			?>
					'<?php echo $image_url[0]; ?>'
			<?php
					if($count_photo > ($key+1))
					{
						echo ',';
					}
				}
			?>
					],
			frames_per_second: <?php echo $pp_kenburns_frames_rate; ?>,
			display_time: <?php echo $pp_homepage_slideshow_timer; ?>,
			fade_time: 1000,
			zoom: 1.2,
			background_color:'#000000'
		});
	});
	$j('#kenburns').kenburns({
		images:[
		<?php
		    foreach($bg_photo_arr as $key => $photo)
		    {
		        if(!empty($photo->guid))
		        {
		        	$image_url[0] = $photo->guid;
		        }
		
		?>
				'<?php echo $image_url[0]; ?>'
		<?php
				if($count_photo > ($key+1))
				{
					echo ',';
				}
			}
		?>
				],
		frames_per_second: <?php echo $pp_kenburns_frames_rate; ?>,
		display_time: <?php echo $pp_homepage_slideshow_timer; ?>,
		fade_time: 1000,
		zoom: 1.2,
		background_color:'#000000'
	});				
});
    
</script>

<div id="kenburns_overlay"></div>
<canvas id="kenburns">
    <p>Your browser doesn't support canvas!</p>
</canvas>
<?php
	$galleries = get_posts(array('parent' => -1, 'post_type' => 'gallery', 'numberposts' => -1));
	$wp_galleries = array();
	foreach ($galleries as $gallery_list ) {
	       $wp_galleries[$gallery_list->ID]['title'] = $gallery_list->post_title;
	       $wp_galleries[$gallery_list->ID]['desc'] = $gallery_list->post_content;
	}
?>

<div id="kenburns_title" style="display:none"><?php echo $wp_galleries[$page_bg_gallery_id]['title']; ?></div>
<div id="kenburns_desc" style="display:none"><?php echo $wp_galleries[$page_bg_gallery_id]['desc']; ?></div>

<input type="hidden" id="pp_image_path" name="pp_image_path" value="<?php echo get_stylesheet_directory_uri(); ?>/images/"/>

<?php
} //End if ken burns slideshow
?>

<?php
	//Get page left contact info text
    $pp_contact_info_text = get_option('pp_contact_info_text');
?>
<div class="personal_contact">
    <h6><?php echo stripcslashes($pp_contact_info_text); ?></h6>
</div>

<!-- Begin content -->
<?php
	//Get social media sharing option
	$pp_social_sharing = get_option('pp_social_sharing');
	
	if(!empty($pp_social_sharing))
	{
?>
<div class="gallery_social">
    <div class="each">
    	<iframe class="facebook_button" src="//www.facebook.com/plugins/like.php?app_id=262802827073639&amp;href=<?php echo urlencode($current_page->guid); ?>&amp;send=false&amp;layout=box_count&amp;width=200&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=90" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:90px;" allowTransparency="true"></iframe>
    </div>
    <div class="each">				
    	<a href="https://twitter.com/share" data-text="<?php echo $current_page->post_title; ?>" data-url="<?php echo $current_page->guid; ?>" class="twitter-share-button" data-count="vertical">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
    </div>
    <div class="each">
    	<!-- Place this tag where you want the +1 button to render -->
    	<g:plusone size="tall" href="<?php echo $current_page->guid; ?>"></g:plusone>
    	
    	<!-- Place this render call where appropriate -->
    	<script type="text/javascript">
    	  (function() {
    	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    	    po.src = 'https://apis.google.com/js/plusone.js';
    	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
    	  })();
    	</script>
    </div>
</div>
<?php
	}
?>

<div class="page_control">
    <a id="page_minimize" href="#">
    	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon_minus.png" alt=""/>
    </a>
    <a id="page_maximize" href="#">
    	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon_plus.png" alt=""/>
    </a>
</div>

<div id="page_content_wrapper">

    <div class="inner">
    
    <div id="page_caption" class="sidebar_content full_width" style="padding-bottom:0">
    	<div style="float:left">
    		<h1 class="cufon"><?php the_title(); ?></h1>
    	</div>
    </div>
    
    <div class="sidebar_content">
    	
    	<!-- Begin main content -->
    	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>		

    				<?php do_shortcode(the_content()); ?><br/>

    			<?php endwhile; ?>
    			
    			<h4><?php _e( 'Send us a mail', THEMEDOMAIN ); ?></h4><br/>
    			
    			<?php
    				$pp_contact_form = unserialize(get_option('pp_contact_form_sort_data'));
    			?>
    			<form id="contact_form" method="post" action="<?php echo $current_page->guid; ?>">
    				<?php 
			    		if(is_array($pp_contact_form) && !empty($pp_contact_form))
			    		{
			    			foreach($pp_contact_form as $form_input)
			    			{
			    				switch($form_input)
			    				{
			    					case 1:
			    	?>
			        				<input id="your_name" name="your_name" type="text" style="width:47%"/>
			        				<label for="your_name"><?php echo _e( 'Name', THEMEDOMAIN ); ?>*</label>
			        				<br/><br/>			
			    	<?php
			    					break;
			    					
			    					case 2:
			    	?>
			    					
			        				<input id="email" name="email" type="text" style="width:47%"/>
			        				<label for="email"><?php echo _e( 'Mail', THEMEDOMAIN ); ?>*</label>
			        				<br/><br/>				
			    	<?php
			    					break;
			    					
			    					case 3:
			    	?>
			    					
			        				<textarea id="message" name="message" rows="7" cols="10" style="width:70%"></textarea>
			        				<label for="message"><?php echo _e( 'Message', THEMEDOMAIN ); ?>*</label>
			        				<br/><br/>				
			    	<?php
			    					break;
			    					
			    					case 4:
			    	?>
			    					
			        				<input id="address" name="address" type="text" style="width:47%"/>
			        				<label for="address"><?php echo _e( 'Address', THEMEDOMAIN ); ?></label>
			        				<br/><br/>			
			    	<?php
			    					break;
			    					
			    					case 5:
			    	?>
			    					
			        				<input id="phone" name="phone" type="text" style="width:47%"/>
			        				<label for="phone"><?php echo _e( 'Phone', THEMEDOMAIN ); ?></label>
			        				<br/><br/>			
			    	<?php
			    					break;
			    					
			    					case 6:
			    	?>
			    					
			        				<input id="mobile" name="mobile" type="text" style="width:47%"/>
			        				<label for="mobile"><?php echo _e( 'Mobil', THEMEDOMAIN ); ?></label>
			        				<br/><br/>				
			    	<?php
			    					break;
			    					
			    					case 7:
			    	?>
			    					
			        				<input id="company" name="company" type="text" style="width:47%"/>
			        				<label for="company"><?php echo _e( 'Company', THEMEDOMAIN ); ?></label>
			        				<br/><br/>				
			    	<?php
			    					break;
			    					
			    					case 8:
			    	?>
			    					
			        				<input id="country" name="country" type="text" style="width:47%"/>
			        				<label for="country"><?php echo _e( 'Country', THEMEDOMAIN ); ?></label>
			        				<br/><br/>				
			    	<?php
			    					break;
			    				}
			    			}
			    		}
			    	?>
			    	
			    	<?php
			    		$pp_contact_enable_captcha = get_option('pp_contact_enable_captcha');
			    		
			    		if(!empty($pp_contact_enable_captcha))
			    		{
			    	?>
			    		
			    		<br class="clear"/>
			    		<div id="captcha-wrap">
							<div class="captcha-box">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/get_captcha.php" alt="" id="captcha" />
							</div>
							<div class="text-box">
								<label>Escribe las siguientes palabras:</label>
								<input name="captcha-code" type="text" id="captcha-code">
							</div>
							<div class="captcha-action">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/refresh.jpg"  alt="" id="captcha-refresh" />
							</div>
						</div>
					
					<?php
					}
					?>
			    			    
			    	<br class="clear"/>
			    	<p style="margin-top:20px">
    					<input type="submit" value="Enviar"/>
    				</p>
    			</form>
    			<div id="reponse_msg"></div>
    	<!-- End main content -->
    	</div>
    	
    	<script>
			$j(document).ready(function(){ 
				<?php
				if(!empty($pp_contact_enable_captcha))
			    {
			    ?>
			    
				// refresh captcha
 				$j('img#captcha-refresh').click(function() {  
 						
 						change_captcha();
 				});
 				
 				function change_captcha()
 				{
 					document.getElementById('captcha').src="<?php echo get_stylesheet_directory_uri(); ?>/get_captcha.php?rnd=" + Math.random();
 				}
 				
 				<?php
 				}
 				?>
			
				$j.validator.setDefaults({
					submitHandler: function() { 
						<?php
						if(!empty($pp_contact_enable_captcha))
			    		{
			    		?>
						$j.ajax({
			  		    	type: 'GET',
			  		    	url: '<?php echo get_stylesheet_directory_uri(); ?>/get_captcha.php?check=true',
			  		    	data: $j('#contact_form').serialize(),
			  		    	success: function(msg){
			  		    		if(msg == 'true')
			  		    		{
			  		    			var actionUrl = $j('#contact_form').attr('action');
					    
					    			$j.ajax({
			  		    				type: 'GET',
			  		    				url: actionUrl,
			  		    				data: $j('#contact_form').serialize(),
			  		    				success: function(msg){
			  		    					$j('#contact_form').hide();
			  		    					$j('#reponse_msg').html('<br/>'+msg);
			  		    				}
					    			});
			  		    		}
			  		    		else
			  		    		{
			  		    			alert(msg);
			  		    		}
			  		    	}
					    });
					    <?php
 						} else {
 						?>
 							var actionUrl = $j('#contact_form').attr('action');
					    
					    	$j.ajax({
			  		    	    type: 'GET',
			  		    	    url: actionUrl,
			  		    	    data: $j('#contact_form').serialize(),
			  		    	    success: function(msg){
			  		    	    	$j('#contact_form').hide();
			  		    	    	$j('#reponse_msg').html('<br/>'+msg);
			  		    	    }
					    	});
 						
 						<?php
 						}
 						?>
					    
					    return false;
					}
				});
					    
					
				$j('#contact_form').validate({
					rules: {
					    your_name: "required",
					    email: {
					    	required: true,
					    	email: true
					    },
					    message: "required"
					},
					messages: {
					    your_name: "<?php echo _e( 'Please, insert your name.', THEMEDOMAIN ); ?>",
					    email: "<?php echo _e( 'Please, insert a valid mail.', THEMEDOMAIN ); ?>",
					    agree: "<?php echo _e( 'Please, insert a message.', THEMEDOMAIN ); ?>"
					}
				});
			});
		</script>
    	
    	<div class="sidebar_wrapper">
    			<div class="sidebar">
    				
    				<div class="content">
    				
    					<ul class="sidebar_widget">
    						<?php dynamic_sidebar($page_sidebar); ?>
    					</ul>
    					
    				</div>
    			
    			</div>
    			<br class="clear"/>
    
    	</div>
    </div>
 </div> 
<br class="clear"/>
<?php get_footer(); ?>		
				
<?php
}

//if submit form
else
{

	/*
	|--------------------------------------------------------------------------
	| Mailer module
	|--------------------------------------------------------------------------
	|
	| These module are used when sending email from contact form
	|
	*/
	
	//Get your email address
	$contact_email = get_option('pp_contact_email');
	
	//Enter your email address, email from contact form will send to this addresss. Please enter inside quotes ('myemail@email.com')
	define('DEST_EMAIL', $contact_email);
	
	//Change email subject to something more meaningful
	define('SUBJECT_EMAIL', __( 'Email from contact form', THEMEDOMAIN ));
	
	//Thankyou message when message sent
	define('THANKYOU_MESSAGE', __( 'Thank you ! We will in contact with you.', THEMEDOMAIN ));
	
	//Error message when message can't send
	define('ERROR_MESSAGE', __( 'An error happened. Please, try later.', THEMEDOMAIN ));
	
	
	/*
	|
	| Begin sending mail
	|
	*/
	
	$from_name = $_GET['your_name'];
	$from_email = $_GET['email'];
	
	$headers = "";
   	$headers.= 'From: '.$from_name.'<'.$from_email.'>'.PHP_EOL;
   	$headers.= 'Reply-To: '.$from_name.'<'.$from_email.'>'.PHP_EOL;
   	$headers.= 'Return-Path: '.$from_name.'<'.$from_email.'>'.PHP_EOL;        // these two to set reply address
   	$headers.= "Message-ID: <".time()."webmaster@".$_SERVER['SERVER_NAME'].">".PHP_EOL;
   	$headers.= "X-Mailer: PHP v".phpversion().PHP_EOL;                  // These two to help avoid spam-filters
	
	$message = 'Name: '.$from_name.PHP_EOL;
	$message.= 'Email: '.$from_email.PHP_EOL.PHP_EOL;
	$message.= 'Message: '.PHP_EOL.$_GET['message'];
	
	if(isset($_GET['address']))
	{
		$message.= 'Address: '.$_GET['address'].PHP_EOL;
	}
	
	if(isset($_GET['phone']))
	{
		$message.= 'Phone: '.$_GET['phone'].PHP_EOL;
	}
	
	if(isset($_GET['mobile']))
	{
		$message.= 'Mobile: '.$_GET['mobile'].PHP_EOL;
	}
	
	if(isset($_GET['company']))
	{
		$message.= 'Company: '.$_GET['company'].PHP_EOL;
	}
	
	if(isset($_GET['country']))
	{
		$message.= 'Country: '.$_GET['country'].PHP_EOL;
	}
	    
	
	if(!empty($from_name) && !empty($from_email) && !empty($message))
	{
		wp_mail(DEST_EMAIL, SUBJECT_EMAIL, $message, $headers);
	
		echo THANKYOU_MESSAGE;
		
		exit;
	}
	else
	{
		echo ERROR_MESSAGE;
		
		exit;
	}
	
	/*
	|
	| End sending mail
	|
	*/
}

?>
