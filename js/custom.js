var $j = jQuery.noConflict();

/* jquery.imagefit 
 *
 * Version 0.2 by Oliver Boermans <http://www.ollicle.com/eg/jquery/imagefit/>
 *
 * Extends jQuery <http://jquery.com>
 *
 */
(function($) {
	$.fn.imagefit = function(options) {
		var fit = {
			all : function(imgs){
				imgs.each(function(){
					fit.one(this);
					})
				},
			one : function(img){
				$(img)
					.width('100%').each(function()
					{
						$(this).height(Math.round(
							$(this).attr('startheight')*($(this).width()/$(this).attr('startwidth')))
						);
					})
				}
		};
		
		this.each(function(){
				var container = this;
				
				// store list of contained images (excluding those in tables)
				var imgs = $('img', container).not($("table img"));
				
				// store initial dimensions on each image 
				imgs.each(function(){
					$(this).attr('startwidth', $(this).width())
						.attr('startheight', $(this).height())
						.css('max-width', $(this).attr('startwidth')+"px");
				
					fit.one(this);
				});
				// Re-adjust when window width is changed
				$(window).bind('resize', function(){
					fit.all(imgs);
				});
			});
		return this;
	};
})(jQuery);

$j.fn.getIndex = function(){
	var $jp=$j(this).parent().children();
    return $jp.index(this);
}
 
jQuery.fn.extend({
  slideRight: function() {
    return this.each(function() {
    	jQuery(this).show();
    });
  },
  slideLeft: function() {
    return this.each(function() {
    	jQuery(this).hide();
    });
  },
  slideToggleWidth: function() {
    return this.each(function() {
      var el = jQuery(this);
      if (el.css('display') == 'none') {
        el.slideRight();
      } else {
        el.slideLeft();
      }
    });
  }
});

$j.fn.setNav = function(){
	$j('#main_menu li ul').css({display: 'none'});

	$j('#main_menu li').each(function()
	{	
		var $jsublist = $j(this).find('ul:first');
		
		$j(this).hover(function()
		{	
			$jsublist.css({opacity: 1});
			
			$jsublist.stop().css({overflow:'hidden', height:'auto', display:'none'}).fadeIn(200, function()
			{
				$j(this).css({overflow:'visible', height:'auto', display: 'block'});
			});	
		},
		function()
		{	
			$jsublist.stop().css({overflow:'hidden', height:'auto', display:'none'}).fadeOut(200, function()
			{
				$j(this).css({overflow:'hidden', display:'none'});
			});	
		});	
		
	});
	
	$j('#main_menu li').each(function()
	{
		
		$j(this).hover(function()
		{	
			$j(this).find('a:first').addClass('hover');
		},
		function()
		{	
			$j(this).find('a:first').removeClass('hover');
		});	
		
	});
	
	$j('#menu_wrapper .nav ul li ul').css({display: 'none'});

	$j('#menu_wrapper .nav ul li').each(function()
	{	
		
		var $jsublist = $j(this).find('ul:first');
		
		$j(this).hover(function()
		{	
			$jsublist.css({opacity: 1});
			
			$jsublist.stop().css({overflow:'hidden', height:'auto', display:'none'}).fadeIn(200, function()
			{
				$j(this).css({overflow:'visible', height:'auto', display: 'block'});
			});	
		},
		function()
		{	
			$jsublist.stop().css({overflow:'hidden', height:'auto', display:'none'}).fadeOut(200, function()
			{
				$j(this).css({overflow:'hidden', display:'none'});
			});	
		});	
		
	});
	
	$j('#menu_wrapper .nav ul li').each(function()
	{
		
		$j(this).hover(function()
		{	
			$j(this).find('a:first').addClass('hover');
		},
		function()
		{	
			$j(this).find('a:first').removeClass('hover');
		});	
		
	});
}

$j(document).ready(function(){ 

	$j(document).setNav();
	
	$j('#thin_nav').mouseenter(
    	function() {
    		setTimeout(function() {
				$j('#nav_wrapper').animate({"right": "0px"}, { duration: 300 });
 				$j(this).css('display', 'none');
			}, 300);
    	}
    );
    
    $j('#nav_wrapper').mouseleave(
    	function() {
    		$j(this).animate({"right": "-250px"}, { duration: 300 });
 			$j('#thin_nav').css('display', 'block');
    	}
    );
    
    $j('#nav_wrapper').touchwipe({
       	wipeRight: function(){ 
           	$j('#nav_wrapper').animate({"right": "-250px"}, { duration: 300 });
 			$j('#thin_nav').css('display', 'block');
       	}
    });
    
    $j('#thin_nav').touchwipe({
       	wipeLeft: function(){ 
           	$j('#nav_wrapper').animate({"right": "0px"}, { duration: 300 });
 			$j('#thin_nav').css('display', 'none');
       	}
    });

	$j('.pp_gallery a').fancybox({ 
		padding: 0,
		overlayColor: '#000', 
		transitionIn: 'fade',
		transitionOut: 'fade',
		overlayOpacity: 0.9
	});
	
	$j('.flickr li a').fancybox({ 
		prevEffect	: 'none',
		nextEffect	: 'none',
		helpers	: {
			title	: {
				type: 'outside'
			},
			overlay	: {
				opacity : 0.9,
				css : {
					'background-color' : '#000'
				}
			},
			thumbs	: {
				width	: 60,
				height	: 60
			}
		}
	});
	
	$j('a.fancy-gallery').fancybox({ 
		prevEffect	: 'none',
		nextEffect	: 'none',
		helpers	: {
			title	: {
				type: 'outside'
			},
			overlay	: {
				opacity : 0.9,
				css : {
					'background-color' : '#000'
				}
			},
			thumbs	: {
				width	: 60,
				height	: 60
			}
		}
	});
	
	$j('.img_frame').fancybox({ 
		padding: 0,
		overlayColor: '#000', 
		overlayOpacity: 0.9
	});
	
	$j('.lightbox_youtube').fancybox({ 
		padding: 0,
		overlayColor: '#000', 
		transitionIn: 'fade',
		transitionOut: 'fade',
		overlayOpacity: 0.9,
		scrolling: 'no'
	});
	
	$j('.lightbox_vimeo').fancybox({ 
		padding: 0,
		overlayColor: '#000', 
		transitionIn: 'fade',
		transitionOut: 'fade',
		overlayOpacity: 0.9,
		scrolling: 'no'
	});
	
	$j('.project_single').fancybox({ 
		padding: 0,
		overlayColor: '#000', 
		transitionIn: 'fade',
		transitionOut: 'fade',
		overlayOpacity: 0.9,
		scrolling: 'no'
	});
	
	$j('input[title!=""]').hint();
	
	$j('textarea[title!=""]').hint();
	
	if ($j(window).width() > 480) {
		$j('.one_fourth.gallery4').hover(
			function(){
				var $jthis = $j(this);
				$jthis.children('a').children('img').stop().animate({
						'height':'185px',
						'top':'0px',
						'left':'0px'
					}, 400);
					
			},
			function(){
				var $jthis = $j(this);
				$jthis.children('a').children('img').stop().animate({
					'height':'200px',
					'top':'0px',
					'left':'0px'
					}, 400);
			}
		);
		
		$j('.one_third.gallery3').hover(
			function(){
				var $jthis = $j(this);
				$jthis.children('a').children('img').stop().animate({
						'height':'240px',
						'top':'0px',
						'left':'0px'
					}, 400);
			},
			function(){
				var $jthis = $j(this);
				$jthis.children('a').children('img').stop().animate({
						'height':'260px',
						'top':'0px',
						'left':'0px'
					}, 400);
			}
		);
		
		$j('.one_half.gallery2').hover(
			function(){
				var $jthis = $j(this);
				$jthis.children('a').children('img').stop().animate({
						'height':'320px',
						'top':'0px',
						'left':'0px'
					}, 400);
			},
			function(){
				var $jthis = $j(this);
				$jthis.children('a').children('img').stop().animate({
					'height':'340px',
					'top':'0px',
					'left':'0px'
					}, 400);
			}
		);
		
		$j('.post_img').hover(
			function(){
				var $jthis = $j(this);
				$jthis.children('a').children('img').stop().animate({
						'height':'250px',
						'top':'0px',
						'left':'0px'
					}, 400);
			},
			function(){
				var $jthis = $j(this);
				$jthis.children('a').children('img').stop().animate({
					'height':'260px',
					'top':'0px',
					'left':'0px'
					}, 400);
			}
		);
	}
	
	$j('.post_img').click(
		function(event){
			$j(this).children('a').trigger('click');
		}
	);
	
	var calScreenHeight = $j(window).height()-108;
	$j('#page_content_wrapper').css('top', '0px');
	
	setTimeout(function() {
		$j('#menu_wrapper').fadeIn();
		$j('#jp_interface_1').fadeIn();
		$j('#controls').fadeIn();
		$j('#page_content_wrapper').show();
		$j('.page_control').fadeIn();
		$j('#page_maximize').trigger('click');
		$j('#tray-button').trigger('click');
	}, 0);
	
	var miniRightPos = 800;
	
	$j('#page_minimize').click(function(){
		var calScreenHeight = $j(window).height()-120;
		
		$j(this).css('display', 'none');
		$j('#page_maximize').css('display', 'block');
		$j('#page_content_wrapper').animate({ 'right': -miniRightPos+'px' }, 600);
		$j('.page_control').animate({ 'right': '25px' }, 400);
		$j('.personal_contact').fadeOut('slow');
		$j('.gallery_social').fadeOut('slow');
		$j('#kenburns_title').fadeIn('slow');
		$j('#kenburns_desc').fadeIn('slow');
	});
	
	$j('#page_maximize').click(function(){
		var calScreenHeight = $j(window).height()-120;
		
		$j(this).css('display', 'none');
		$j('#page_minimize').css('display', 'block');
		$j('#page_content_wrapper').animate({ 'right': '25px' }, 400);
		$j('.page_control').animate({ 'right': miniRightPos+'px' }, 400);
		$j('.personal_contact').fadeIn('slow');
		$j('.gallery_social').fadeIn('slow');
		$j('#kenburns_title').fadeOut('slow');
		$j('#kenburns_desc').fadeOut('slow');
	});
	
	// Create the dropdown base
	$j("<select />").appendTo("#menu_border_wrapper");
	
	// Create default option "Go to..."
	$j("<option />", {
	   "selected": "selected",
	   "value"   : "",
	   "text"    : "- Main Menu -"
	}).appendTo("#menu_border_wrapper select");
	
	// Populate dropdown with menu items
	$j(".nav li").each(function() {
	 var current_item = $j(this).hasClass('current-menu-item'); 
	 var el = $j(this).children('a');
	 var menu_text = el.text();

	 if($j(this).parent('ul.sub-menu').length > 0)
	 {
	 	menu_text = "- "+menu_text;
	 }
	 
	 if($j(this).parent('ul.sub-menu').parent('li').parent('ul.sub-menu').length > 0)
	 {
	 	menu_text = el.text();
	 	menu_text = "- - "+menu_text;
	 }
	 
	 if(current_item)
	 {
	 	$j("<option />", {
	 		 "selected": "selected",
	    	 "value"   : el.attr("href"),
	    	 "text"    : menu_text
		 }).appendTo("#menu_border_wrapper select");
	 }
	 else
	 {
	 	$j("<option />", {
	     	"value"   : el.attr("href"),
	     	"text"    : menu_text
	 	}).appendTo("#menu_border_wrapper select");
	 }
	});
	
	$j("#menu_border_wrapper select").change(function() {
  		window.location = $j(this).find("option:selected").val();
	});
	
});
