<?php
/**
 * The Header for the template.
 *
 * @package WordPress
 */
 
$pp_theme_version = THEMEVERSION;
session_start();
 
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">

<title><?php wp_title('&lsaquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php
	/**
	*	Get favicon URL
	**/
	$pp_favicon = get_option('pp_favicon');
	
	if(!empty($pp_favicon))
	{
		$pp_favicon = THEMEUPLOADURL.$pp_favicon;
?>
		<link rel="shortcut icon" href="<?php echo $pp_favicon; ?>" />
<?php
	}
?>

<!-- Template stylesheet -->
<?php
	wp_enqueue_style("colorpicker.css", get_stylesheet_directory_uri()."/js/colorpicker/css/colorpicker.css", false, $pp_theme_version, "all");
	wp_enqueue_style("fancybox_css", get_stylesheet_directory_uri()."/js/fancybox/jquery.fancybox.css", false, $pp_theme_version, "all");
	wp_enqueue_style("fancybox_thumb_css", get_stylesheet_directory_uri()."/js/fancybox/jquery.fancybox-thumbs.css", false, $pp_theme_version, "all");
	wp_enqueue_style("grid_css", get_stylesheet_directory_uri()."/css/grid.css", false, $pp_theme_version, "all");

	$isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
	$isiPhone = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
	
	if ($isiPad || $isiPhone) {
		wp_enqueue_style("pp_ipad_style", get_stylesheet_directory_uri()."/css/ipad.css?t=".time(), false, $pp_theme_version, "all");
	}	
?>

<!-- script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.1/swfobject.js">
</script -->

<?php
	wp_enqueue_script("jquery", get_stylesheet_directory_uri()."/js/jquery.js", false, $pp_theme_version);
	wp_enqueue_script("jquery.ui_js", get_stylesheet_directory_uri()."/js/jquery.ui.js", false, $pp_theme_version);
	wp_enqueue_script("colorpicker.js", get_stylesheet_directory_uri()."/js/colorpicker.js", false, $pp_theme_version);
	wp_enqueue_script("fancybox_js", get_stylesheet_directory_uri()."/js/fancybox/jquery.fancybox.pack.js", false, $pp_theme_version);
	wp_enqueue_script("fancybox_thumb_js", get_stylesheet_directory_uri()."/js/fancybox/jquery.fancybox-thumbs.js", false, $pp_theme_version);
	wp_enqueue_script("jQuery_easing", get_stylesheet_directory_uri()."/js/jquery.easing.js", false, $pp_theme_version);
	wp_enqueue_script("jQuery_nivo", get_stylesheet_directory_uri()."/js/jquery.nivoslider.js", false, $pp_theme_version);
	wp_enqueue_script("jquery.touchwipe.1.1.1", get_stylesheet_directory_uri()."/js/jquery.touchwipe.1.1.1.js", false, $pp_theme_version);
	//wp_enqueue_script("jQuery_gmap", get_stylesheet_directory_uri()."/js/gmap.js", false, $pp_theme_version);
	wp_enqueue_script("jQuery_validate", get_stylesheet_directory_uri()."/js/jquery.validate.js", false, $pp_theme_version);
	wp_enqueue_script("browser_js", get_stylesheet_directory_uri()."/js/browser.js", false, $pp_theme_version);
	wp_enqueue_script("jquery_backstretch", get_stylesheet_directory_uri()."/js/jquery.backstretch.js", false, $pp_theme_version);
	wp_enqueue_script("hint.js", get_stylesheet_directory_uri()."/js/hint.js", false, $pp_theme_version);
	wp_enqueue_script("jquery.flip.min.js", get_stylesheet_directory_uri()."/js/jquery.flip.min.js", false, $pp_theme_version);
	wp_enqueue_script("jquery.mousewheel.min.js", get_stylesheet_directory_uri()."/js/fancybox/jquery.mousewheel-3.0.6.pack.js", false, $pp_theme_version);
	wp_enqueue_script("jquery.jplayer.min.js", get_stylesheet_directory_uri()."/js/jquery.jplayer.min.js", false, $pp_theme_version);
	wp_enqueue_script("kenburns.js", get_stylesheet_directory_uri()."/js/kenburns.js", false, $pp_theme_version);
	wp_enqueue_script("jwplayer.js", get_stylesheet_directory_uri()."/js/jwplayer.js", false, $pp_theme_version);
	wp_enqueue_script("custom_js", get_stylesheet_directory_uri()."/js/custom.js", false, $pp_theme_version);
	
	if(isset($_SESSION['pp_font']))
	{
		$pp_font = $_SESSION['pp_font'];
	}
	else
	{
		$pp_font = get_option('pp_font');
	}
	
	if(!empty($pp_font))
	{
		wp_enqueue_style('google_fonts', "http://fonts.googleapis.com/css?family=".$pp_font, false, "", "all");
	}
	else
	{
		wp_enqueue_style('google_fonts', "http://fonts.googleapis.com/css", false, "", "all");
	}
?> 

<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>

<!--[if IE]>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/ie.css" type="text/css" media="all"/>
<![endif]-->

<?php
$pp_enable_right_click = get_option('pp_enable_right_click');
$pp_right_click_text = get_option('pp_right_click_text');

if(!empty($pp_enable_right_click))
{
?>
<script type="text/javascript" language="javascript">
    $j(function() {
        $j(this).bind("contextmenu", function(e) {
        	<?php
        		if(!empty($pp_right_click_text))
        		{
        	?>
        		alert('<?php echo $pp_right_click_text; ?>');
        	<?php
        		}
        	?>
            e.preventDefault();
        });
    }); 
</script>
<?php
}
?>

<style type="text/css">

<?php
	$pp_h1_font_color = get_option('pp_h1_font_color');
	if(!empty($pp_h1_font_color))
	{
?>
.post_header h2, h1, h2, h3, h4, h5
{
	color: <?php echo $pp_h1_font_color; ?>;
}
<?php
	}
	
?>

<?php
	$pp_menu_font_size = get_option('pp_menu_font_size');
	
	if(!empty($pp_menu_font_size))
	{
?>
.nav li a { font-size:<?php echo $pp_menu_font_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_submenu_font_size = get_option('pp_submenu_font_size');
	
	if(!empty($pp_submenu_font_size))
	{
?>
.nav li ul li a { font-size:<?php echo $pp_submenu_font_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h1_size = get_option('pp_h1_size');
	
	if(!empty($pp_h1_size))
	{
?>
h1 { font-size:<?php echo $pp_h1_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h2_size = get_option('pp_h2_size');
	
	if(!empty($pp_h2_size))
	{
?>
h2 { font-size:<?php echo $pp_h2_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h3_size = get_option('pp_h3_size');
	
	if(!empty($pp_h3_size))
	{
?>
h3 { font-size:<?php echo $pp_h3_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h4_size = get_option('pp_h4_size');
	
	if(!empty($pp_h4_size))
	{
?>
h4 { font-size:<?php echo $pp_h4_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h5_size = get_option('pp_h5_size');
	
	if(!empty($pp_h5_size))
	{
?>
h5 { font-size:<?php echo $pp_h5_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h6_size = get_option('pp_h6_size');
	
	if(!empty($pp_h6_size))
	{
?>
h6 { font-size:<?php echo $pp_h6_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_link_color = get_option('pp_link_color');
	
	if(!empty($pp_link_color))
	{
?>
a { color:<?php echo $pp_link_color; ?>; }
<?php
	}
	
?>

<?php
	$pp_hover_link_color = get_option('pp_hover_link_color');
	
	if(!empty($pp_hover_link_color))
	{
?>
#page_content_wrapper a:hover, #page_content_wrapper a:active { background:<?php echo $pp_hover_link_color; ?>; }
<?php
	}
	
	$pp_active_skin_color = get_option('pp_active_skin_color');
	
	if(!empty($pp_active_skin_color))
	{
?>
#nav_wrapper, #thin_nav, .post_date { background: <?php echo $pp_active_skin_color; ?>; }
<?php
	}
?>

<?php
	$pp_button_bg_color = get_option('pp_button_bg_color');
	
	if(!empty($pp_button_bg_color))
	{
?>
input[type=submit], input[type=button], a.button { 
	background: <?php echo $pp_button_bg_color; ?>;
	text-shadow: -1px 0 1px #333;
}
<?php
	}
	
?>

<?php
	$pp_button_font_color = get_option('pp_button_font_color');
	
	if(!empty($pp_button_font_color))
	{
?>
input[type=submit], input[type=button], a.button { 
	color: <?php echo $pp_button_font_color; ?>;
}
input[type=submit]:hover, input[type=button]:hover, a.button:hover
{
	color: <?php echo $pp_button_font_color; ?>;
}
<?php
	}
	
?>

<?php
	$pp_button_border_color = get_option('pp_button_border_color');
	
	if(!empty($pp_button_border_color))
	{
?>
input[type=submit], input[type=button], a.button { 
	border: 1px solid <?php echo $pp_button_border_color; ?>;
}
<?php
	}
	
?>

<?php

$pp_h1_font_color = get_option('pp_h1_font_color');
if(!empty($pp_h1_font_color))
{
?>
.post_header h2, h1, h2, h3, h4, h5
{
	color: <?php echo $pp_h1_font_color; ?>;
}
<?php
}
if(isset($_SESSION['pp_font_family']))
{
    $pp_font_family = $_SESSION['pp_font_family'];
}
else
{
    $pp_font_family = get_option('pp_font_family');
}

if(!empty($pp_font_family))
{
?>
h1, h2, h3, h4, h5, h6, .nav li a, #kenburns_title, #kenburns_desc, .personal_contact h6 { font-family: '<?php echo $pp_font_family; ?>'; }		
<?php
}

$pp_menu_lower = get_option('pp_menu_lower');

if(!empty($pp_menu_lower))
{
?>
h1, h2, h3, h4, h5, h6, .nav li a, #gallery_title, #gallery_desc, .nav li a, .nav_page_number li { text-transform: none; }		
<?php
}

$pp_menu_font_color = get_option('pp_menu_font_color');

if(!empty($pp_menu_font_color))
{
?>
.nav li a, .nav_page_number li { color: <?php echo $pp_menu_font_color; ?>; }
.nav li ul { border-left: 1px solid <?php echo $pp_menu_font_color; ?>; }	
<?php
}

$pp_active_menu_font_color = get_option('pp_active_menu_font_color');

if(!empty($pp_active_menu_font_color))
{
?>
.nav li.current-menu-item > a, .nav li > a:hover, .nav li > a.hover, .nav li > a:active, .nav li.current-menu-parent > a, .nav li.current-menu-item ul li a:hover, .nav li ul li a:hover, .nav li ul li:hover a, .nav li ul li.current-menu-item a { color: <?php echo $pp_active_menu_font_color; ?>; }
<?php
}

$pp_menu_header_font_color = get_option('pp_menu_header_font_color');

if(!empty($pp_menu_header_font_color))
{
?>
h1.menu_header, #footer { color: <?php echo $pp_menu_header_font_color; ?>; }
<?php
}
?>

</style>

</head>

<body <?php body_class(); ?>>
<!-- php include("images/settings.php");-->

	<!-- Begin template wrapper -->
	<div id="wrapper">
	
		<div id="menu_wrapper">
			
			<!-- Begin logo -->
					
			<?php
				//get custom logo
				$pp_logo = get_option('pp_logo');
							
				if(empty($pp_logo))
				{
					$pp_logo = get_stylesheet_directory_uri().'/images/logo.png';
				}
				else
				{
					$pp_logo = THEMEUPLOADURL.$pp_logo;
				}
			?>

      <!-- Begin Modificacion 20130615 CVG para que aparezca la home_url segun el idioma -->
      <?php
      	$lang = substr(get_bloginfo('language' ),0,2);
        $pageURL = home_url();
        if( $lang != "es"){
        	$pageURL = home_url()."/?lang=".$lang;
        }
       ?>

			<a id="custom_logo" class="logo_wrapper" href="<?php echo $pageURL; ?>">
      	<img src="<?php echo $pp_logo?>" alt=""/>
      </a>
			<!-- End Modicacion 20130614 CVG -->
						
			<!-- End logo -->
		
		    <!-- Begin main nav -->
		    <div id="thin_nav"><img id="plus_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/images/menu_nav.png" alt=""/></div>
		    <div id="nav_wrapper">
		    	<div class="nav_wrapper_inner">

				<?php
		    			$pp_footer_social = get_option('pp_footer_social');
		    			if(!empty($pp_footer_social))
		    			{
		    		?>
		    		
		    		<div class="social_wrapper">
					    <ul>
						<?php
	    						$pp_digg_username = get_option('pp_digg_username');
	    						
	    						if(!empty($pp_digg_username))
	    						{
	    					?>
	    					<li><a title="Blog" href="http://blog.ibercivis.es" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social/digg.png" alt=""/></a></li>
	    					<?php
	    						}
	    					?>
					    	<?php
	    						$pp_twitter_username = get_option('pp_twitter_username');
	    						
	    						if(!empty($pp_twitter_username))
	    						{
	    					?>
	    					<li><a title="Twitter" href="http://twitter.com/<?php echo $pp_twitter_username; ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social/twitter.png" alt=""/></a></li>
	    					<?php
	    						}
	    					?>
	    					<?php
	    						$pp_facebook_username = get_option('pp_facebook_username');
	    						
	    						if(!empty($pp_facebook_username))
	    						{
	    					?>
	    					<li><a title="Facebook" href="http://facebook.com/<?php echo $pp_facebook_username; ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social/facebook.png" alt=""/></a></li>
	    					<?php
	    						}
	    					?>
	    					<?php
	    						$pp_flickr_username = get_option('pp_flickr_username');
	    						
	    						if(!empty($pp_flickr_username))
	    						{
	    					?>
	    					<li><a title="Flickr" href="http://flickr.com/people/<?php echo $pp_flickr_username; ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social/flickr.png" alt=""/></a></li>
	    					<?php
	    						}
	    					?>
	    					<?php
	    						$pp_youtube_username = get_option('pp_youtube_username');
	    						
	    						if(!empty($pp_youtube_username))
	    						{
	    					?>
	    					<li><a title="Youtube" href="http://youtube.com/channel/<?php echo $pp_youtube_username; ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social/youtube.png" alt=""/></a></li>
	    					<?php
	    						}
	    					?>
	    					<?php
	    						$pp_vimeo_username = get_option('pp_vimeo_username');
	    						
	    						if(!empty($pp_vimeo_username))
	    						{
	    					?>
	    					<li><a title="Vimeo" href="http://vimeo.com/<?php echo $pp_vimeo_username; ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social/vimeo.png" alt=""/></a></li>
	    					<?php
	    						}
	    					?>
	    					<?php
	    						$pp_tumblr_username = get_option('pp_tumblr_username');
	    						
	    						if(!empty($pp_tumblr_username))
	    						{
	    					?>
	    					<li><a title="Tumblr" href="http://<?php echo $pp_tumblr_username; ?>.tumblr.com" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social/tumblr.png" alt=""/></a></li>
	    					<?php
	    						}
	    					?>
	    					<?php
	    						$pp_google_username = get_option('pp_google_username');
	    						
	    						if(!empty($pp_google_username))
	    						{
	    					?>
	    					<li><a title="Google+" href="<?php echo $pp_google_username; ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social/google.png" alt=""/></a></li>
	    					<?php
	    						}
	    					?>
	    					<?php
	    						$pp_dribbble_username = get_option('pp_dribbble_username');
	    						
	    						if(!empty($pp_dribbble_username))
	    						{
	    					?>
	    					<li><a title="Dribbble" href="http://dribbble.com/<?php echo $pp_dribbble_username; ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social/dribbble.png" alt=""/></a></li>
	    					<?php
	    						}
	    					?>
	    					<?php
	    						$pp_linkedin_username = get_option('pp_linkedin_username');
	    						
	    						if(!empty($pp_linkedin_username))
	    						{
	    					?>
	    					<li><a title="Linkedin" href="<?php echo $pp_linkedin_username; ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social/linkedin.png" alt=""/></a></li>
	    					<?php
	    						}
	    					?>
	    					<?php
				        		$pp_pinterest_username = get_option('pp_pinterest_username');
				        		
				        		if(!empty($pp_pinterest_username))
				        		{
				        	?>
				        	<li><a title="Pinterest" href="http://pinterest.com/<?php echo $pp_pinterest_username; ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social/pinterest.png" alt=""/></a></li>
				        	<?php
				        		}
				        	?>
				        	<?php
				        		$pp_instagram_username = get_option('pp_instagram_username');
				        		
				        		if(!empty($pp_instagram_username))
				        		{
				        	?>
				        	<li><a title="Pinterest" href="http://instagram.com/<?php echo $pp_instagram_username; ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social/instagram.png" alt=""/></a></li>
				        	<?php
				        		}
				        	?>
					    </ul>
					</div>
					<?php
		    			}
		    		?>

		    		<!--<h1 class="menu_header"><?php echo _e( 'Menú', THEMEDOMAIN ); ?></h1><br/><br/>
		    	
		    		<hr class="small_menu_hr"/><br class="clear"/>-->
		    		
		    		<div id="menu_border_wrapper">
		    			<?php 	
		    			    //Get page nav
		    			    wp_nav_menu( 
		    			        	array( 
		    			        		'menu_id'			=> 'main_menu',
		    			        		'menu_class'		=> 'nav',
		    			        		'theme_location' 	=> 'primary-menu',
		    			        	) 
		    			    ); 
		    			?>
		    		</div>
		    		
		    		<br class="clear"/>

				<br/>


                                <?php
                                  $pageURL = curPageURL();
                                  $langURL = "lang";

                                  // Elimina el posible tag de lang que existiera
                                  $position  = strripos($pageURL, $langURL); 
                                  if ($position> 0){
                                     $pageURL = substr($pageURL, 0, $position-1);
                                  }
                              
                                  // Intercambiamos ? por &
                                  if( strripos($pageURL, "?") >0){ 
                                    $pageURL = $pageURL."&";}
                                  else{ 
                                    $pageURL = $pageURL."?";}
                      
                                                             
			?> 
<!-- 
	          		 	<div id="qtranslate-5" class="widget widget_qtranslate">
	          		 		<h4>
							<?php _e('LANGUAGE', THEMEDOMAIN) ?>
						</h4>
							<a class="lang-es active" href="<?php echo $pageURL ?>lang=es" title="Español"> Español </a> <br/>
							<a class="lang-en" href="<?php echo $pageURL ?>lang=en" title="English"> English </a>  <br/>
							<a class="lang-pt" href="<?php echo $pageURL ?>lang=pt" title="Português"> Português </a>
					</div >
-->
		    		
		    		<?php
		    			$pp_footer_text = get_option('pp_footer_text');
		    			if(!empty($pp_footer_text))
		    			{
		    				echo '<br class="clear"/><div id="footer">'.nl2br(stripslashes(html_entity_decode($pp_footer_text))).'</div>';
		    			}
		    		?>
		    	</div>
		    </div>
		    <!-- End main nav -->
		    
		</div>

		<br class="clear"/>
