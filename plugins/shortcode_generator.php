<?php

/*
	Begin Create Shortcode Generator Options
*/

add_action('admin_menu', 'pp_shortcode_generator');

function pp_shortcode_generator() {
  
  global $page_postmetas;
	if ( function_exists('add_meta_box') && isset($page_postmetas) && count($page_postmetas) > 0 ) {  
		add_meta_box( 'shortcode_metabox', 'Shortcode Generator', 'pp_shortcode_generator_options', 'page', 'normal', 'high' );
		add_meta_box( 'shortcode_metabox', 'Shortcode Generator', 'pp_shortcode_generator_options', 'post', 'normal', 'high' );    
	}

}

function pp_shortcode_generator_options() {
  	
  	$plugin_url = get_stylesheet_directory_uri().'/plugins/shortcode_generator';

	//Begin shortcode array
	$shortcodes = array(
		'dropcap' => array(
			'attr' => array(),
			'desc' => array(),
			'content' => TRUE,
		),
		'quote' => array(
			'attr' => array(),
			'desc' => array(),
			'content' => TRUE,
		),
		'one_half' => array(
			'attr' => array(),
			'desc' => array(),
			'content' => TRUE,
			'repeat' => 1,
		),
		'one_third' => array(
			'attr' => array(),
			'desc' => array(),
			'content' => TRUE,
			'repeat' => 2,
		),
		'one_fourth' => array(
			'attr' => array(),
			'desc' => array(),
			'content' => TRUE,
			'repeat' => 3,
		),
	);

?>
<script>
jQuery(document).ready(function(){ 
	jQuery('#shortcode_select').change(function() {
  		var target = jQuery(this).val();
  		jQuery('.rm_section').css('display', 'none');
  		jQuery('#div_'+target).css('display', '');
	});	
	
	jQuery('.code_area').click(function() { 
		document.getElementById(jQuery(this).attr('id')).focus();
    	document.getElementById(jQuery(this).attr('id')).select();
	});
	
	jQuery('.button').click(function() { 
		var target = jQuery(this).attr('id');
		var gen_shortcode = '';
  		gen_shortcode+= '['+target;
  		
  		if(jQuery('#'+target+'_attr_wrapper .attr').length > 0)
  		{
  			jQuery('#'+target+'_attr_wrapper .attr').each(function() {
				gen_shortcode+= ' '+jQuery(this).attr('name')+'="'+jQuery(this).val()+'"';
			});
		}
		
		gen_shortcode+= ']\n';
		
		if(jQuery('#'+target+'_content').length > 0)
  		{
  			gen_shortcode+= jQuery('#'+target+'_content').val()+'\n[/'+target+']\n';
  			
  			var repeat = jQuery('#'+target+'_content_repeat').val();
  			for (count=1;count<=repeat;count=count+1)
			{
				if(count<repeat)
				{
					gen_shortcode+= '['+target+']\n';
					gen_shortcode+= jQuery('#'+target+'_content').val()+'\n[/'+target+']\n';
				}
				else
				{
					gen_shortcode+= '['+target+'_last]\n';
					gen_shortcode+= jQuery('#'+target+'_content').val()+'\n[/'+target+'_last]';
				}
			}
  		}
  		
  		jQuery('#'+target+'_code').val(gen_shortcode);
	});
});
</script>

	<div style="padding:20px 10px 10px 10px">
	<?php
		if(!empty($shortcodes))
		{
	?>
			<strong>Select Shortcode:</strong>
			<select id="shortcode_select">
				<option value="">---Select---</option>
			
	<?php
			foreach($shortcodes as $shortcode_name => $shortcode)
			{
	?>
	
			<option value="<?php echo $shortcode_name; ?>"><?php echo $shortcode_name; ?></option>
	
	<?php
			}
	?>
			</select>
	<?php
		}
	?>
	
	<br/><br/>
	
	<?php
		if(!empty($shortcodes))
		{
			foreach($shortcodes as $shortcode_name => $shortcode)
			{
	?>
	
			<div id="div_<?php echo $shortcode_name; ?>" class="rm_section" style="display:none">
				<div class="rm_title">
					<h3><?php echo ucfirst($shortcode_name); ?></h3>
					<div class="clearfix"></div>
				</div>
				
				<div class="rm_text" style="padding: 10px 0 20px 0">
				
				<!-- img src="<?php echo $plugin_url.'/'.$shortcode_name.'.png'; ?>" alt=""/><br/><br/><br/ -->
				
				<?php
					if(isset($shortcode['content']) && $shortcode['content'])
					{
						if(isset($shortcode['content_text']))
						{
							$content_text = $shortcode['content_text'];
						}
						else
						{
							$content_text = 'Your Content';
						}
				?>
				
				<strong><?php echo $content_text; ?>:</strong><br/>
				<input type="hidden" id="<?php echo $shortcode_name; ?>_content_repeat" value="<?php echo $shortcode['repeat']; ?>"/>
				<textarea id="<?php echo $shortcode_name; ?>_content" style="width:100%;height:70px" rows="3" wrap="off"></textarea><br/><br/>
				
				<?php
					}
				?>
			
				<?php
					if(isset($shortcode['attr']) && !empty($shortcode['attr']))
					{
				?>
						
						<div id="<?php echo $shortcode_name; ?>_attr_wrapper">
						
				<?php
						foreach($shortcode['attr'] as $attr => $type)
						{
				?>
				
							<?php echo '<strong>'.ucfirst($attr).'</strong>: '.$shortcode['desc'][$attr]; ?><br/><br/>
							
							<?php
								switch($type)
								{
									case 'text':
							?>
							
									<input type="text" id="<?php echo $shortcode_name; ?>_text" style="width:100%" class="attr" name="<?php echo $attr; ?>"/>
							
							<?php
									break;
									
									case 'select':
							?>
							
									<select id="<?php echo $shortcode_name; ?>_select" style="width:25%" class="attr" name="<?php echo $attr; ?>">
									
										<?php
											if(isset($shortcode['options']) && !empty($shortcode['options']))
											{
												foreach($shortcode['options'] as $select_key => $option)
												{
										?>
										
													<option value="<?php echo $select_key; ?>"><?php echo $option; ?></option>
										
										<?php	
												}
											}
										?>							
									
									</select>
							
							<?php
									break;
								}
							?>
							
							<br/><br/>
				
				<?php
						} //end attr foreach
				?>
				
						</div>
				
				<?php
					}
				?>
				<br/>
				
				<input type="button" id="<?php echo $shortcode_name; ?>" value="Generate Shortcode" class="button"/>
				
				<br/><br/><br/>
				
				<strong>Shortcode:</strong><br/>
				<textarea id="<?php echo $shortcode_name; ?>_code" style="width:90%;height:70px" rows="3" readonly="readonly" class="code_area" wrap="off"></textarea>
				
				</div>
				
			</div>
	
	<?php
			} //end shortcode foreach
		}
	?>
	
</div>

<?php

}

/*
	End Create Shortcode Generator Options
*/

?>