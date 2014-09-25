<?php

$args = array(
    'numberposts' => -1,
    'post_type' => array('gallery'),
);

$galleries_arr = get_posts($args);
$galleries_select = array();
$galleries_select[''] = '';

foreach($galleries_arr as $gallery)
{
	$galleries_select[$gallery->post_title] = $gallery->ID;
}

function post_type_portfolios() {
	$labels = array(
    	'name' => __('Videos', 'post type general name'),
    	'singular_name' => _x('Video', 'post type singular name'),
    	'add_new' => __('Add New Video', 'book'),
    	'add_new_item' => __('Add New Video'),
    	'edit_item' => __('Edit Video'),
    	'new_item' => __('New Video'),
    	'view_item' => __('View Video'),
    	'search_items' => __('Search Videos'),
    	'not_found' =>  __('No Video found'),
    	'not_found_in_trash' => __('No Video found in Trash'), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title','editor', 'thumbnail'),
    	'menu_icon' => get_stylesheet_directory_uri().'/functions/images/sign.png'
	); 		

	register_post_type( 'portfolios', $args );
	
  	$labels = array(			  
  	  'name' => __( 'Video Sets', 'taxonomy general name' ),
  	  'singular_name' => __( 'Video Set', 'taxonomy singular name' ),
  	  'search_items' =>  __( 'Search Video Sets' ),
  	  'all_items' => __( 'All Video Sets' ),
  	  'parent_item' => __( 'Parent Video Set' ),
  	  'parent_item_colon' => __( 'Parent Video Set:' ),
  	  'edit_item' => __( 'Edit Video Set' ), 
  	  'update_item' => __( 'Update Video Set' ),
  	  'add_new_item' => __( 'Add New Video Set' ),
  	  'new_item_name' => __( 'New Video Set Name' ),
  	); 							  
  	
  	register_taxonomy(
		'portfoliosets',
		'portfolios',
		array(
			'public'=>true,
			'hierarchical' => true,
			'labels'=> $labels,
			'query_var' => 'portfoliosets',
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'portfoliosets', 'with_front' => false ),
		)
	);		  
} 
								  
add_action('init', 'post_type_portfolios');

function post_type_projects() {
	$labels = array(
    	'name' => __('Projects', 'post type general name'),
    	'singular_name' => __('Project', 'post type singular name'),
    	'add_new' => __('Add New Project', 'book'),
    	'add_new_item' => __('Add New Project'),
    	'edit_item' => __('Edit Project'),
    	'new_item' => __('New Project'),
    	'view_item' => __('View Project'),
    	'search_items' => __('Search Projects'),
    	'not_found' =>  __('No Project found'),
    	'not_found_in_trash' => __('No Project found in Trash'), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title','editor', 'thumbnail'),
    	'menu_icon' => get_stylesheet_directory_uri().'/functions/images/sign.png'
	); 		

	register_post_type( 'projects', $args );
	
  	$labels = array(			  
  	  'name' => __( 'Project Categories', 'taxonomy general name' ),
  	  'singular_name' => __( 'Project Category', 'taxonomy singular name' ),
  	  'search_items' =>  __( 'Search Project Categories' ),
  	  'all_items' => __( 'All Project Categories' ),
  	  'parent_item' => __( 'Parent Project Category' ),
  	  'parent_item_colon' => __( 'Parent Project Categories:' ),
  	  'edit_item' => __( 'Edit Project Category' ), 
  	  'update_item' => __( 'Update Project Category' ),
  	  'add_new_item' => __( 'Add New Project Category' ),
  	  'new_item_name' => __( 'New Project Category Name' ),
  	); 							  
  	
  	register_taxonomy(
		'projectcats',
		'projects',
		array(
			'public'=>true,
			'hierarchical' => true,
			'labels'=> $labels,
			'query_var' => 'projectcats',
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'projectcats', 'with_front' => false ),
		)
	);		  
} 
								  
add_action('init', 'post_type_projects');

add_filter( 'manage_posts_columns', 'rt_add_gravatar_col');
function rt_add_gravatar_col($cols) {
	$cols['thumbnail'] = __('Thumbnail');
	return $cols;
}

add_action( 'manage_posts_custom_column', 'rt_get_author_gravatar');
function rt_get_author_gravatar($column_name ) {
	if ( $column_name  == 'thumbnail'  ) {
		echo get_the_post_thumbnail(get_the_ID(), array(100, 100));
	}
}

/*
	Begin creating custom fields
*/

$postmetas = 
	array (
		
		'portfolios' => array(
			array("section" => "Content Type", "id" => "portfolio_type", "type" => "select", "title" => "Video Type", "description" => "Select content type for this portfolio item:", 
				"items" => array(
					"Youtube Video" => "Youtube Video", 
					"Vimeo Video" => "Vimeo Video", 
					"Self-Hosted Video" => "Self-Hosted Video",
				)),
				
				array("section" => "Content Type", "id" => "portfolio_video_id", "title" => "Youtube or Vimeo Video ID", "description" => "If you select Youtube Video or Vimeo Video. Enter your video ID here:"),
				array("section" => "Content Type", "id" => "portfolio_mp4_url", "title" => "Video URL (.mp4 file format)", "description" => "If you select Self-Hosted. Enter your video URL (.mp4 file format):"),
		),
		
		'post' => array(
			array("section" => "Background Style", "id" => "post_bg_style", "type" => "select", "title" => "Background Style", "description" => "Select background options for this post", "items" => 
			array(	"Static Image" => "Static Image", 
					"Slideshow" => "Slideshow", 
				)),
		
			array("section" => "Background Gallery", "id" => "post_bg_gallery_id", "type" => "select", "title" => "Background Gallery", "description" => "If you select \"Slideshow\" as background style. Select a gallery here:", "items" => $galleries_select),
		),
);

function create_meta_box() {

	global $postmetas;
	
	if(!isset($_GET['post_type']) OR empty($_GET['post_type']))
	{
		if(isset($_GET['post']) && !empty($_GET['post']))
		{
			$post_obj = get_post($_GET['post']);
			$_GET['post_type'] = $post_obj->post_type;
		}
		else
		{
			$_GET['post_type'] = 'post';
		}
	}
	
	if ( function_exists('add_meta_box') && isset($postmetas) && count($postmetas) > 0 ) {  
		foreach($postmetas as $key => $postmeta)
		{
			if($_GET['post_type']==$key && !empty($postmeta))
			{
				add_meta_box( 'metabox', ucfirst($key).' Options', 'new_meta_box', $key, 'side', 'high' );  
			}
		}
	}

}  

function new_meta_box() {
	global $post, $postmetas;
	
	if(!isset($_GET['post_type']) OR empty($_GET['post_type']))
	{
		if(isset($_GET['post']) && !empty($_GET['post']))
		{
			$post_obj = get_post($_GET['post']);
			$_GET['post_type'] = $post_obj->post_type;
		}
		else
		{
			$_GET['post_type'] = 'post';
		}
	}

	echo '<input type="hidden" name="myplugin_noncename" id="myplugin_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	$meta_section = '';

	foreach ( $postmetas as $key => $postmeta ) {
	
		if($_GET['post_type'] == $key)
		{
		
			foreach ( $postmeta as $each_meta ) {
		
				$meta_id = $each_meta['id'];
				$meta_title = $each_meta['title'];
				$meta_description = $each_meta['description'];
				$meta_section = $postmeta['section'];
				
				$meta_type = '';
				if(isset($each_meta['type']))
				{
					$meta_type = $each_meta['type'];
				}
				
				echo "<br/><strong>".$meta_title."</strong><hr class='pp_widget_hr'/>";
				echo "<div class='pp_widget_description'>$meta_description</div>";
				
				if ($meta_type == 'checkbox') {
					$checked = get_post_meta($post->ID, $meta_id, true) == '1' ? "checked" : "";
					echo "<input type='checkbox' name='$meta_id' id='$meta_id' value='1' $checked /></p>";
				}
				else if ($meta_type == 'select') {
					echo "<p><select name='$meta_id' id='$meta_id'>";
					
					if(!empty($each_meta['items']))
					{
						foreach ($each_meta['items'] as $key => $item)
						{
							echo '<option value="'.$item.'"';
							
							if($item == get_post_meta($post->ID, $meta_id, true))
							{
								echo ' selected ';
							}
							
							echo '>'.$key.'</option>';
						}
					}
					
					echo "</select></p>";
				}
				else if ($meta_type == 'textarea') {
					echo "<p><textarea name='$meta_id' id='$meta_id' class='code' style='width:100%' rows='7'>".get_post_meta($post->ID, $meta_id, true)."</textarea></p>";
				}			
				else {
					echo "<p><input type='text' name='$meta_id' id='$meta_id' class='code' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:99%' /></p>";
				}
			}
		}
	}
	
	echo '<br/>';

}

function save_postdata( $post_id ) {

	global $postmetas;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( isset($_POST['myplugin_noncename']) && !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) )) {
		return $post_id;
	}

	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;

	// Check permissions

	if ( isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return $post_id;
		} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}

	// OK, we're authenticated

	if ( $parent_id = wp_is_post_revision($post_id) )
	{
		$post_id = $parent_id;
	}
	
	foreach ( $postmetas as $postmeta ) {
		foreach ( $postmeta as $each_meta ) {
	
			if ($_POST[$each_meta['id']]) {
				update_custom_meta($post_id, $_POST[$each_meta['id']], $each_meta['id']);
			}
			
			if ($_POST[$each_meta['id']] == "") {
				delete_post_meta($post_id, $each_meta['id']);
			}
		
		}
	}

}

function update_custom_meta($postID, $newvalue, $field_name) {

	if (!get_post_meta($postID, $field_name)) {
		add_post_meta($postID, $field_name, $newvalue);
	} else {
		update_post_meta($postID, $field_name, $newvalue);
	}

}

//init

add_action('admin_menu', 'create_meta_box'); 
add_action('save_post', 'save_postdata');  

/*
	End creating custom fields
*/

?>
