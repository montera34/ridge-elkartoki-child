/**
 * ThemeTrust javascript functions
 *
 * Contents:
 * 	1.	Module Variables
 * 	2.	Mobile Detection
 * 	3.	Isotope
 * 		3.1	Filter Nav
 * 		3.2	Isotope Initialization
 * 		3.3	Set the Number of Columns
 * 		3.4 Isotope Grid Resize
 * 	4.	Home Banner
 * 		4.1	Home Banner Height and Content Centering
 * 		4.2	Home Parallax
 * 	5.	Misc.
 * 		5.1	Menu initialization
 *  6.	Initialize
 */

/**
 * 1.  Module Variables
 *
 * @var $gridcontainer	DOM element that is parent to the
 *   portfolio items
 * @var $inner			DOM element that contains the banner content
 * @var windowHeight	The height of the viewport
 * @var scroll			The distance scrolled from the top in px
 */

var $gridContainer 	= jQuery( '.thumbs' ),
	$inner 			= jQuery('#home-banner .inner'),
	windowHeight 	= jQuery(window).height(),
	scroll 			= jQuery(window).scrollTop(),
    $masonry        = jQuery('.masonry').length,
	$thumbs 		= jQuery('.thumbs .small'),
    breakpoints     = {
        "Large": [9999, 4], // *3* columns for all larger screens
        "Medium":[800, 2], // For *Medium* screens of *1100 to 700*, set Isotope to *2* columns
        "Small": [500,  1] // For *Small* screens below *700*, set Isotope to *1* column
    };

/**
 *
 * 2.  Mobile Detection
 *
 * @returns {string[]}	User agent
 */

function isMobile(){
    return (
        (navigator.userAgent.match(/Android/i)) ||
		(navigator.userAgent.match(/webOS/i)) ||
		(navigator.userAgent.match(/iPhone/i)) ||
		(navigator.userAgent.match(/iPod/i)) ||
		(navigator.userAgent.match(/iPad/i)) ||
		(navigator.userAgent.match(/BlackBerry/))
    );
}

/** *****************************************
 * 3.  Isotope
 ***************************************** */

/**
 * 3.1  Filter Navigation
 *
 * Binds the Isotope filtering function to clicks on the
 * portfolio filter links using the data-filter attribute
 */

function filterInit() {

	var $filterNavA = jQuery( '#filter-nav a' );

	$filterNavA.click( function(){

		var selector = jQuery(this).attr( 'data-filter' );

		$gridContainer.isotope({
			filter: selector,
			hiddenStyle : {
				opacity: 0,
				scale : 1
			}
		});

		if ( ! jQuery(this).hasClass( 'selected' ) ) {
			jQuery(this).parents( '#filter-nav' ).find( '.selected' ).removeClass( 'selected' );
			jQuery(this).addClass( 'selected' );
		}

		return false;
	});
}

/**
 * 3.2  Layout detection
 *
 * Look for the .masonry class on the main element and return the layout mode
 * and related variables.
 *
 * @return str layoutTT  Either masonry or fitRows
 */
function layoutDetection(){

    var layoutMode = '';

    if( $masonry > 0 )
        layoutMode = 'masonry';
    else
        layoutMode = 'fitRows';

    return layoutMode;

}

/**
 * 3.3  Isotope Initialization
 *
 * Check to see if the layout mode is set to masonry, and
 * defaults to fitRows if the .masonry class is not found.
 * Initializes Isotope on the $gridContainer var
 *
 * @see §1
 */

function isotopeInit() {

    var layoutMode = layoutDetection(), // Get layout mode
        colW       = setColumns(), // Set number of columns
        options    = {
            resizable: true,
            masonry: {
                columnWidth: colW
            }
        };

    // Only add the option for layoutMode if not masonry
    
    options.layoutMode = "masonry";

	// Initialize Isotope on the parent div
	$gridContainer.isotope( options );

	jQuery(".thumbs").css("visibility", "visible");
}

/**
 * 3.4	Set the number of columns
 *
 * Changes the number of columns based on screen size (viewport)
 *
 * To change the number of columns, change @var columns for each
 * desired resolution.
 *
 * @var int columns	 Number of columns
 * @var int gridW	 Width of the Isotope parent element
 * @var int windowW	 Width of the browser window
 * @var int gutterW	 Width of the margin (1.3636em)
 */

function setColumns() {
	var columns,
		gridW 		= $gridContainer.width(),
		imageH		= jQuery('.img-inner a img').outerHeight(),
		windowW 	= jQuery(window).width();
		
    /** @see Isotope breakpoints above */
    if( gridW <= breakpoints.Small[0] ) {
        columns =  breakpoints.Small[1];
    } else if ( gridW <=  breakpoints.Medium[0] ) {
        columns =  breakpoints.Medium[1];
    } else {
        columns =  breakpoints.Large[1];
    }

	// Make sure the number is an integer (no fractions of a px)
	colW = Math.floor( gridW / columns );

	// Set the width using inline CSS
	$thumbs.each( function( id ){
		jQuery(this).css( 'width', colW + 'px' );
	});

	// Show the thumbs
	$thumbs.show();

	// Pass the colW variable
	return colW;
}

/**
 * 3.5	Grid Resize
 *
 * Resize the Isotope grid when resizing the window. Avoid
 * reinitializing Isotope.
 */
function gridResize() {

    var layoutMode  = layoutDetection(),
	    colW        = setColumns(),
        options     = {
            resizable: false,
            masonry: {
                columnWidth: colW
            }
        };
	$gridContainer.isotope( options );
}

/** *****************************************
 * 4.  Home Banner
 ***************************************** */

/**
 * 4.1	Home Banner Height and Content Centering
 *
 * Sets the height of the home banner to the window height and
 * centers the content
 *
 * @var int windowHeight	Height of the window, recalculated
 *   due to browser resizing
 * @var int innerHeight		Height of the $inner element
 * @var int verticalCenter	Calculates the top pos of $inner
 */

function setHomeHeight() {

	var windowHeight 	= jQuery(window).height(),
		innerHeight		= $inner.outerHeight(),
		goldenHeight	= windowHeight * 0.32, /** @see http://en.wikipedia.org/wiki/Golden_ratio */
		verticalCenter 	= ( ( goldenHeight ) - innerHeight ) / 2;

	jQuery( '.home #home-banner' ).height( goldenHeight );
	$inner.css( 'top', verticalCenter );

}

/**
 * 4.2  Home Parallax
 *
 * Creates the parallax effect on the banner content, inlc.
 * fading the inner element
 */
function homeParallax(){
	
	if(jQuery('body').hasClass('home')){	
		var top = jQuery(this).scrollTop();			
		jQuery('.home #home-banner .bg').css({'background-position' : 'center ' + (top/5)+"px"});
	    $inner.css({'opacity' : 1-(top/400)});		
	}

}

/** *****************************************
 * 5.  Misc
 ***************************************** */

/**
 * 5.1  Mobile Menu
 */

function navInit(){
	jQuery('#menu-toggle').on('click', function () {
	  	jQuery(this).toggleClass('active');
		jQuery('#site-header').toggleClass('toggled-on');
	});
}

/**
 * 5.3  Submenus
 *
 * Set collapsable submenus.
 */
// Toggle sub menus
function initSubMenus(){
	jQuery( ".nav-menu" ).find( "li.menu-item-has-children" ).click( function(){
		jQuery( ".nav-menu li" ).not( this ).find( "ul" ).next().slideToggle( 100 );
		jQuery( this ).find( "> ul" ).stop( true, true ).slideToggle( 100 );
		jQuery( this ).toggleClass( "active-sub-menu" );
		return false;
	});

	// Don't fire sub menu toggle if a user is trying to click the link
	jQuery( ".menu-item-has-children a" ).click( function(e) {
		e.stopPropagation();
		return true;
	});
}

/**
 * 5.4  Header/Sidebar Overflow Handler
 *
 * Removes fixed positioning of header/sidebar if widgets extend beyond screen height.
 */
// Toggle sub menus
function adjustSidebar(){
	var windowHeight 	= jQuery(window).height();
	var sidebarHeight 	= jQuery(".site-header .inside").height();
	if(sidebarHeight >= (windowHeight - 50)) {
		jQuery('#site-header').addClass('not-fixed');
		jQuery('#site-header').height(jQuery('body').height());
	}else{
		jQuery('#site-header').removeClass('not-fixed');
	}
}


/** *****************************************
 * 6.  Initialize
 ***************************************** */

jQuery.noConflict();
jQuery(document).ready(function(){

	// Document loaded
	
	initSubMenus();
	jQuery(".content-area").fitVids();
	
	
	navInit();

	// Images loaded
	jQuery('body').imagesLoaded(function(){
		setHomeHeight();
		filterInit();
		isotopeInit();
		gridResize();
		adjustSidebar();
	});


	// User is scrolling
	jQuery(window).scroll(function() {
		if( ! isMobile()){
			homeParallax();
		}
	});

	// Browser has been resized
	jQuery(window).smartresize(function(){
		gridResize();
		setHomeHeight();
		adjustSidebar();
	});

});
