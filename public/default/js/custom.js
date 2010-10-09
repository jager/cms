jQuery.noConflict();

// Innitiate Main Menu
jQuery(document).ready(function() { 
	jQuery('ul#menu').superfish(); 
});

//Homepage Slideshow navigation
function paginate(idx, slide){	
	return '<a href="" title="" class="ie6"><img src="layout/images/transparent.png" alt="" width="13" height="13" class="ie6" /></a>';
}

//News Scroller (Widget)
jQuery(document).ready(function() {
 
 	jQuery('.news-scroller').cycle({ 
	    fx: 'scrollVert',
		speed: 1500,
		rev: true,
		timeout: 4000,
		next: '.news-next', 
	    prev: '.news-previous',
	    easing: 'easeInOutQuint'
	 });      
 
});

//Contact Form
jQuery(document).ready(function() {

	//Define URL to PHP mail file
	url = "sendmail.php";
	
	//Activate jQuery form validation
	jQuery("#jaybich-contact").validate({
	
		submitHandler: function() {
		
			//Define data string
			var datastring = jQuery("#jaybich-contact").serialize();
			
			//Submit form
			jQuery.ajax({
				type: "POST",
				url: url,
				data: datastring,
				success: function(){
					jQuery('#jaybich-contact').slideUp();
					jQuery('#sent').fadeIn();
				}
			});
		}
	
	});
			
});

//Comments Form
jQuery(document).ready(function() {
	
	//Activate jQuery form validation
	jQuery(".comments-form").validate();
			
});

//Portfolio thumbnail
jQuery(document).ready(function(){

	jQuery('.portfolio-box a').hover(function() {
		
		//Show darkenned hover over thumbnail image
		jQuery(this).find('img').stop(true, true).animate({opacity:0.5},400);

	}, function() {
		
		//Hide darkenned hover over thumbnail image
		jQuery(this).find('img').stop(true, true).animate({opacity:1},400);
			
	});

});

//Portfolio thumbnail
jQuery(document).ready(function(){

	jQuery('.portfolio-image a').hover(function() {
		
		//Show darkenned hover over thumbnail image
		jQuery(this).find('img').stop(true, true).animate({opacity:0.5},400);

	}, function() {
		
		//Hide darkenned hover over thumbnail image
		jQuery(this).find('img').stop(true, true).animate({opacity:1},400);
			
	});

});

//Image Buttons
jQuery(document).ready(function(){

	jQuery('.image-button').css({opacity:.75});

	jQuery('.image-button').hover(function() {
		
		jQuery(this).stop(true, true).animate({opacity:1},100);

	}, function() {

		jQuery(this).stop(true, true).animate({opacity:.75},100);
			
	});

});

//Portfolio Fancybox
jQuery(document).ready(function() {
	
	jQuery("a.lightbox").fancybox({
		'transitionIn'	:	'fade',
		'transitionOut'	:	'fade',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	true,
		'titlePosition' :   'inside'
	});
	
});

//ukrywanie
jQuery(document).ready(function(){
    if ( jQuery("table.hider").length != false ) {
        jQuery("table.hider").hide();
    }
    jQuery("h3.switch").bind("click", function() {
        jQuery(this).next().toggle();
    })
})
