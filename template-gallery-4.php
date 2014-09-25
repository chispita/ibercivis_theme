<?php
/**
 * Template Name: Home Page
 * The main template file for display project page.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
$page = get_page($post->ID);
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

//prepare data for pagintion
$offset_query = '';
if(!isset($_GET['page']) OR empty($_GET['page']) OR $_GET['page'] == 1)
{
    $current_page = 1;
}


//Get content gallery
$args = array(
    'numberposts' => -1,
    'order' => 'ASC',
    'orderby' => 'menu_order',
    'post_type' => array('projects'),
    'portfoliosets' => '',
);
if(!empty($term))
{
    $args['projectcats'].= $term;
}

$page_photo_arr = get_posts($args);


//Get all portfolio items for paging
$args = array(
    'numberposts' => -1,
    'order' => 'DESC',
    'orderby' => 'post_date',
    'post_type' => array('projects'),
    'projectcats' => 'home',
);
if(!empty($term))
{
    $args['projectcats'].= $term;
}

$all_photo_arr = get_posts($args);

//echo var_dump(get_posts($args));


$page_style = 'Right Sidebar';
$add_sidebar = TRUE;
$page_sidebar = 'Blog Sidebar';


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
elseif($bg_style == 'Random')
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

    $rnd_photo = $bg_photo_arr[rand(0, $count_photo-2)];
?>
<script type="text/javascript"> 
    jQuery.backstretch( "<?php echo $rnd_photo->guid; ?>", {speed: 'slow'} );
</script>

<?php
} // end if random image
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
    $isiAndroid = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Android');

    if($isiPad || $isiPhone || $isiAndroid) {
      $isiMovil = True;}
    else{
      $isiMovil = False;}

    if($isiMovil){
    	$pp_kenburns_frames_rate = 1;
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
<div id="page_content_wrapper" class="content_home">
    
    <div class="inner">

    	<div class="inner_wrapper">
	
	<?php
		$portfolio_sets_query = '';
	    if(!empty($term))
	    {
	    	$portfolio_sets_query.= $term;
	    	
	    	$obj_term = get_term_by('slug', $term, 'projectcats');
	    	$custom_title = $obj_term->name;
	    }
	    else
	    {
	    	$custom_title = get_the_title();
	    }
	?>
	<div id="page_caption" class="sidebar_content" style="padding-bottom:0">		
		<div style="float:left">
			<h1 class="cufon"><?php echo $custom_title; ?></h1>
		</div>
	</div>
    	
    	<div class="sidebar_content">
		
		<?php
			if(!empty($post->post_content) && empty($term))
			{
		?>
			<p><?php echo nl2br(stripslashes(html_entity_decode(do_shortcode($post->post_content)))); ?></p>
		<?php
			}
		?>

        <a href="experimentos" >
	        <h2 class="widgettitle tittlehome"> 
                <span style="color:;">
                    <?php echo strtoupper(_e( 'Highlighted Experiments', THEMEDOMAIN )); ?>
                </span>
            </h2>
        </a>
        
        <!-- Bucle de los proyectos -->

	<?php foreach($all_photo_arr as $key => $portfolio_item){
       		$image_url = '';
					
		if(has_post_thumbnail($portfolio_item->ID, 'large')){
			$image_id = get_post_thumbnail_id($portfolio_item->ID);
			$image_url = wp_get_attachment_image_src($image_id, 'full', true);
			$small_image_url = wp_get_attachment_image_src($image_id, 'gallery_2', true);
		}
			
		$portfolio_link_url = get_post_meta($portfolio_item->ID, 'portfolio_link_url', true);
     
        // 2013-06-03 CVG          
        // Donde se utiliza permalink_url ???
		if(empty($portfolio_link_url)){
			$permalink_url = get_permalink($portfolio_item->ID);} 
                else {
			$permalink_url = $portfolio_link_url;}
			
		$last_class = '';
		if(($key+1)%2==0){
			$last_class = 'last';
		}?>
	
		<div class="one_fourth <?php echo $last_class; ?>" style="margin-bottom:3%">
		<div class="one_fourth gallery4" style="width:100%">
        <?php 
            // 2013-10-02 CVG
            // Modification to does not view the experiments without translate
            //$pos = strpos( $portfolio_item->post_title,"(");
            //echo "***".$pos."***".$portfolio_item->post_title;
                ?>

                
			<?php if(!empty($image_url[0])) { 
                ?> 
                  		<a href="#project_<?php echo $key; ?>" class="project_single">
                		<img src="<?php echo $small_image_url[0]; ?>" alt="" class="one_fourth_img"/>
				</a>
                       		<div style="display:none;"> 
					<div id="project_<?php echo $key; ?>" style="width:860px;height:520px">
						<?php if(has_post_thumbnail($portfolio_item->ID, 'project_s')){
                                                    $project_image_url = wp_get_attachment_image_src($image_id, 'project_s', true);
                                                ?>

                                                <div class="project_thumb">
                                                	<img src="<?php echo $project_image_url[0]; ?>" alt=""/>
                                                </div>
                                                <div class="project_content">
                                                        <!-- Contenido de la ventana emergente -->
                                                	<h4><?php echo _e($portfolio_item->post_title); ?></h4>
                                         
                                                    <?php
                                                        // 2013-06-10 CVG
                                                        // Nos guardamos las posiciones anterior y posterior
                                                        // para poder navegar a los otros experimentos
                                                        $ant_key = ($key==0) ? count($all_photo_arr)-1 : $key-1;
                                                        $pos_key = ($key== count($all_photo_arr)-1)? 0 : $key+1;
                                                    ?>

                                                    <a href="#project_<?php echo $ant_key; ?>" class="project_single project_single_behind" >&nbsp;</a>
                                                    <a href="#project_<?php echo $pos_key; ?>" class="project_single project_single_forward" >&nbsp;</a>

                                                    <?php echo nl2br(__($portfolio_item->post_content)); ?>
                                                </div>
                                		<?php } ?>
					</div>
                                </div>
                	<?php } ?>        
		</div>
	
		<br class="clear"/>
        <!-- Titulo del Experimento -->
		<div class="portfolio_desc" style="width:170px;height:30px;">
	    		<div class="portfolio_header">
                    <a href="#project_<?php echo $key; ?>" class="project_single">
	                <h6 class="cufon"><?php echo _e($portfolio_item->post_title) ?></h6>
                    </a>
	    		</div>
	    	</div>
	</div>
	<?php } 
    ?>
</div>
<div class="sidebar_wrapper">
	<div class="sidebar_top"></div>    		
		<div class="sidebar">    			
			<div class="content">    			
				<ul class="sidebar_widget">
				<?php dynamic_sidebar($page_sidebar); ?>
    				</ul>
    			</div>    		
    		</div>
    		<br class="clear"/>    	
		<div class="sidebar_bottom"></div>
    		</div>
    	</div>
</div>
</div>
<br class="clear"/>
<?php get_footer(); ?>

<?php } ?> <!-- Cierre del foreach -->
