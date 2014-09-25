<?php
/**
 * The main template file for display category page.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
$page = get_page($post->ID);

/**
*	Get current page id
**/

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}

get_header();

//Get Page background style

$pp_blog_bg = get_option('pp_blog_bg'); 
			
if(empty($pp_blog_bg))
	{
	    $pp_blog_bg = '/../../uploads/2013/03/bg_home.jpg';
	}
	else
	{
	    $pp_blog_bg = THEMEUPLOADURL.$pp_blog_bg;
}
?>
<script type="text/javascript"> 
    jQuery.backstretch( "<?php echo $pp_blog_bg; ?>", {speed: 'slow'} );
</script>

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
    	<iframe class="facebook_button" src="//www.facebook.com/plugins/like.php?app_id=262802827073639&amp;href=<?php echo urlencode($page->guid); ?>&amp;send=false&amp;layout=box_count&amp;width=200&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=90" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:90px;" allowTransparency="true"></iframe>
    </div>
    <div class="each">				
    	<a href="https://twitter.com/share" data-text="<?php echo __($page->post_title); ?>" data-url="<?php echo $page->guid; ?>" class="twitter-share-button" data-count="vertical">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
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

<div id="page_content_wrapper">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    		<div id="page_caption" class="sidebar_content full_width" style="padding-bottom:0">
                
    			<div style="float:left">
    				<h1 class="cufon"><?php printf( __( ' %s', '' ), '' . single_cat_title( '', false ) . '' ); ?></h1>
    			</div>
    		</div>
    		<div class="sidebar_content">
<?php

global $more; $more = false; # some wordpress wtf logic

if (have_posts()) : while (have_posts()) : the_post();

	$image_thumb = '';
								
	if(has_post_thumbnail(get_the_ID(), 'large'))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, array(16,16), false);
        //echo ' 0:'.$image_thumb[0];
        //echo ' 1:'.$image_thumb[1];
        //echo ' 2:'.$image_thumb[2];

	  	$pp_blog_image_width = 600;
		$pp_blog_image_height = 260;
	}
?>

<!-- Begin each blog post -->
<div class="post_wrapper">

    <!--
    <?php
        
    	if(!empty($image_thumb))
    	{
    		//$small_image_url = wp_get_attachment_image_src($image_id, 'blog', true);
        ?>
    
        <br class="clear"/>
        <div class="post_img">
        </div>
    <?php
    	}
    ?>
    -->
    
    <br/>
   
    
    <div class="post_date">
	    <div class="month"><?php the_time('M'); ?></div>
	    <div class="date"><?php the_time('j'); ?></div>
	    <div class="year"><?php the_time('Y'); ?></div>
	</div>
    
    <div class="post_header">
    	<h5 class="cufon"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
    	<div class="post_detail">
    	    <a href="<?php the_permalink(); ?>#comments">
                <?php comments_number( __('0 Comment',THEMEDOMAIN), __('1 Comment',THEMEDOMAIN), '% '.__('Comments')); ?>
            </a> 
    	</div>
    </div>
    
    <br class="clear"/>
    
    <?php
    	$pp_blog_display_full = get_option('pp_blog_display_full');
    	
    	if(!empty($pp_blog_display_full))
    	{
    		the_content();
    	}
    	else
    	{
    	    the_excerpt();
    ?>   
    		<a href="<?php the_permalink(); ?>"><?php echo __( 'Read more', THEMEDOMAIN ); ?> →</a>
    <?php
    	}
    ?>
</div>
<!-- End each blog post -->

<?php endwhile; endif; ?>
    	<div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
    	<div class="sidebar_wrapper">
    	    <div class="sidebar_top"></div>
    	    <div class="sidebar">
    	    	<div class="content">
    	    		<ul class="sidebar_widget">
    	    		<?php dynamic_sidebar('Category Sidebar'); ?>
    	    		</ul>
    	    	</div>
    	    </div>
    	    <br class="clear"/>
    	    <div class="sidebar_bottom"></div>
    	</div>
    <!-- End main content -->
<br class="clear"/>
<?php get_footer(); ?>
