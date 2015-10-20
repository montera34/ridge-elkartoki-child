/**
 * elkartoki theme javascript functions
 *
 * Contents:
 * 	1.	Single post Banner
 * 		1.1	Single post Banner Height and Content Centering
 * 		1.2	Single Parallax

/** *****************************************
 * 1.  Single post Banner
 ***************************************** */

/**
 * 1.1	Single post Banner Height and Content Centering
 *
 * Sets the height of the home banner to the window height and
 * centers the content
 *
 * @var int windowHeight	Height of the window, recalculated
 *   due to browser resizing
 * @var int innerHeight		Height of the $inner element
 * @var int verticalCenter	Calculates the top pos of $inner
 */

function setSingleHeight() {

	var windowHeight 	= jQuery(window).height(),
		innerHeight		= $inner.outerHeight(),
		goldenHeight	= windowHeight * 0.32,
		verticalCenter 	= ( ( goldenHeight ) - innerHeight ) / 2;

	jQuery( '.single #single-banner' ).height( goldenHeight );
	$inner.css( 'top', verticalCenter );

}

/**
 * 1.2  Single post Parallax
 *
 * Creates the parallax effect on the banner content, inlc.
 * fading the inner element
 */
function singleParallax(){
	
	if(jQuery('body').hasClass('single')){	
		var top = jQuery(this).scrollTop();			
		jQuery('.single #single-banner .bg').css({'background-position' : 'center ' + (top/5)+"px"});
	    $inner.css({'opacity' : 1-(top/400)});		
	}

}
/** *****************************************
 * 2.  Initialize
 ***************************************** */

jQuery.noConflict();
jQuery(document).ready(function(){

	// Images loaded
	jQuery('body').imagesLoaded(function(){
		setSingleHeight();
	});

	// User is scrolling
	jQuery(window).scroll(function() {
		if( ! isMobile()){
			singleParallax();
		}
	});

	// Browser has been resized
	jQuery(window).smartresize(function(){
		setSingleHeight();
	});

});
