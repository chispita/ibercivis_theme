<?php
/**
 * The main template file for display portfolio page.
 *
 * Template Name: Gallery Fullscreen
 * @package WordPress
 */

/**
*	Get all photos
**/ 

$menu_sets_query = '';

$portfolio_items = -1;


//Get content gallery
$args = array( 
	'post_type' => 'attachment', 
	'numberposts' => $portfolio_items, 
	'post_status' => null, 
	'post_parent' => $post->ID,
	'order' => 'ASC',
	'orderby' => 'menu_order',
); 

//Get gallery images
$all_photo_arr = get_posts( $args );

get_header(); ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/supersized.css" type="text/css" media="screen" />

<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/supersized.3.1.3.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/supersized.shutter.js"></script>

<script type="text/javascript">  
    
    jQuery(function($){
    	$.supersized({
    	
    		//Functionality
    		slideshow               :   1,		//Slideshow on/off
    		autoplay				:	1,		//Slideshow starts playing automatically
    		start_slide             :   1,		//Start slide (0 is random)
    		random					: 	0,		//Randomize slide order (Ignores start slide)
    		<?php						
    			$pp_portfolio_slideshow_timer = get_option('pp_portfolio_slideshow_timer');
    			
    			if(empty($pp_portfolio_slideshow_timer))
    			{
    				$pp_portfolio_slideshow_timer = 5000;
    			}
    			else
    			{
    				$pp_portfolio_slideshow_timer = $pp_portfolio_slideshow_timer*1000;
    			}
    		?>
    		slide_interval          :   <?php echo $pp_portfolio_slideshow_timer; ?>,	//Length between transitions
    		<?php						
    			$pp_portfolio_slideshow_trans = get_option('pp_portfolio_slideshow_trans');
    			
    			if(empty($pp_portfolio_slideshow_trans))
    			{
    				$pp_portfolio_slideshow_trans = 1;
    			}
    		?>
    		transition              :   <?php echo $pp_portfolio_slideshow_trans; ?>, 		//0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
    		transition_speed		:	500,	//Speed of transition
    		new_window				:	1,		//Image links open in new window/tab
    		pause_hover             :   0,		//Pause slideshow on hover
    		keyboard_nav            :   1,		//Keyboard navigation on/off
    		performance				:	1,		//0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
    		image_protect			:	0,		//Disables image dragging and right click with Javascript

    		//Size & Position
    		min_width		        :   0,		//Min width allowed (in pixels)
    		min_height		        :   0,		//Min height allowed (in pixels)
    		vertical_center         :   1,		//Vertically center background
    		horizontal_center       :   1,		//Horizontally center background
    		<?php						
    			$pp_portfolio_enable_fit_image = get_option('pp_portfolio_enable_fit_image');
    			
    			if(empty($pp_portfolio_enable_fit_image))
    			{
    				$pp_portfolio_enable_fit_image = 1;
    			}
    			else
    			{
    				$pp_portfolio_enable_fit_image = 0;
    			}
    		?>
    		fit_portrait         	:   <?php echo $pp_portfolio_enable_fit_image; ?>,		//Portrait images will not exceed browser height
    		fit_landscape			:   <?php echo $pp_portfolio_enable_fit_image; ?>,		//Landscape images will not exceed browser width
    		
    		//Components
    		navigation              :   1,		//Slideshow controls on/off
    		thumbnail_navigation    :   0,		//Thumbnail navigation
    		slide_counter           :   0,		//Display slide numbers
    		slide_captions          :   1,		//Slide caption (Pull from "title" in slides array)
    		progress_bar			:	1,
    		slides 					:  	[		//Slideshow Images
    											  


<?php
	$homeslides = '';
    foreach($all_photo_arr as $key => $photo)
    {
        $hyperlink_url = get_permalink($photo->ID);
        
        if(!empty($photo->guid))
        {
        	$image_url[0] = $photo->guid;
        }
        $small_image_url = get_stylesheet_directory_uri().'/timthumb.php?src='.$image_url[0].'&amp;h=80&amp;w=130&amp;zc=1';

?>

	<?php $homeslides .= '{image : \''.$image_url[0].'\', thumb: \''.$small_image_url.'\'},'; ?>
	
<?php
	}
?>

    			<?php $homeslides = substr($homeslides,0,-1);
    			echo $homeslides; ?>						]
    									
    	}); 
    });
    
    $j(document).ready(function() {
    	$j(document).mouseenter( 
    	    function() {
    	    	$j('#thumb-tray').animate({"bottom": "0px"}, { duration: 300 });
    	    	$j('#kenburns_title').hide();
    	    	$j('#kenburns_desc').hide();
    	    }
    	);
    	$j(document).mouseleave( 
    	    function() { 
    	    	$j('#thumb-tray').animate({"bottom": "-88px"}, { duration: 300 });
    	    	$j('#kenburns_title').fadeIn('slow');
    	    	$j('#kenburns_desc').fadeIn('slow');
    	    }
		);
    });
    
</script>

<div id="thumb-tray" class="load-item">
    <div id="thumb-back"></div>
    <div id="thumb-forward"></div>
</div>



<input type="hidden" id="pp_image_path" name="pp_image_path" value="<?php echo get_stylesheet_directory_uri(); ?>/images/"/>

<div id="kenburns_title"><?php echo _e($post->post_title); ?></div>
<div id="kenburns_desc"><?php echo _e($post->post_content); ?></div>
		
<?php get_footer(); ?>
