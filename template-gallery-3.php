<?php
/**
 * The main template file for display portfolio page.
 *
 * Template Name: Gallery 3 Columns
 * @package WordPress
 */

/**
*	Get all photos
**/ 

$menu_sets_query = '';

$portfolio_items = -1;

/**
*	Get Current page object
**/
$page = get_page($post->ID);
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

//Check if password protected
$portfolio_password = get_post_meta($current_page_id, 'portfolio_password', true);
if(!empty($portfolio_password))
{
	session_start();
	
	if(!isset($_SESSION['gallery_page_'.$current_page_id]) OR empty($_SESSION['gallery_page_'.$current_page_id]))
	{
		include (TEMPLATEPATH . "/templates/template-password.php");
		exit;
	}
}

//Get content gallery
$gallery_id = get_post_meta($current_page_id, 'page_gallery_id', true);

$args = array( 
	'post_type' => 'attachment', 
	'numberposts' => $portfolio_items, 
	'post_status' => null, 
	'post_parent' => $gallery_id,
	'order' => 'ASC',
	'orderby' => 'menu_order',
); 

//Get gallery images
$all_photo_arr = get_posts( $args );

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
    $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
	$isiPhone = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
    
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

<?php
	//Display main gallery contents
    if(!empty($all_photo_arr))
    {
?>

<?php
	//Get social media sharing option
	$pp_social_sharing = get_option('pp_social_sharing');
	
	if(!empty($pp_social_sharing))
	{
?>
<div class="gallery_social">
    <div class="each">
    	<iframe class="facebook_button" src="//www.facebook.com/plugins/like.php?app_id=262802827073639&amp;href=<?php echo urlencode($page->guid); ?>&amp;send=false&amp;layout=box_count&amp;width=200&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=90" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:90px;" allowTransparency="true"></iframe>
    </div>
    <div class="each">				
    	<a href="https://twitter.com/share" data-text="<?php echo $page->post_title; ?>" data-url="<?php echo $page->guid; ?>" class="twitter-share-button" data-count="vertical">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
    </div>
    <div class="each">
    	<!-- Place this tag where you want the +1 button to render -->
    	<g:plusone size="tall" href="<?php echo $page->guid; ?>"></g:plusone>
    	
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

<!-- Begin content -->
<div id="page_content_wrapper">
    
    <div class="inner">

    	<div class="inner_wrapper">
    	
    	<div id="page_caption" class="sidebar_content full_width" style="padding-bottom:0">
    		<div style="float:left">
    			<h1 class="cufon"><?php echo _e($post->post_title); ?></h1>
    		</div>
    	</div>
    	
    	<div class="sidebar_content full_width">
    		<?php
    			//Get page description
    			if(!empty($post->post_content))
    			{
    		?>
    			<p><?php echo nl2br(stripslashes(html_entity_decode(do_shortcode($post->post_content)))); ?></p>
    			<br/>
    		<?php
    			}
    		?>
    	
    	<?php
    		foreach($all_photo_arr as $key => $photo)
    		{
    			$small_image_url = get_stylesheet_directory_uri().'/images/000_70.png';
    			$hyperlink_url = get_permalink($photo->ID);
    			
    			if(!empty($photo->guid))
    			{
    				$image_url[0] = $photo->guid;
    			    $small_image_url = wp_get_attachment_image_src($photo->ID, 'gallery_3', true);
    			}
    			
    			$last_class = '';
    			if(($key+1)%3==0)
    			{
    				$last_class = 'last';
    			}
    	?>
    	
    	<div class="one_third <?php echo $last_class; ?> gallery3" style="margin-bottom:3%">
    		<?php 
    			if(!empty($small_image_url))
    			{
    				$pp_portfolio_enable_slideshow_title = get_option('pp_portfolio_enable_slideshow_title');
    		?>		
    				<a class="fancy-gallery" rel="fancybox-thumb" href="<?php echo $image_url[0]; ?>" <?php if(!empty($pp_portfolio_enable_slideshow_title)) { ?>title="<?php echo _e($photo->post_title); ?>"<?php } ?>>
    					<img src="<?php echo $small_image_url[0]; ?>" alt="" class="one_third_img"/>
    				</a>
    		<?php
    			}		
    		?>			
    		
    	</div>
    	
    	<?php
    		}
    	?>
    	</div>
    </div>
</div>
</div>
<br class="clear"/>
<?php get_footer(); ?>

<?php
    }
?>
