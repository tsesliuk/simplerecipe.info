/**
 * Functionality specific to Twenty Thirteen.
 *
 * Provides helper functions to enhance the theme experience.
 */

( function( $ ) {

	$(".home .post .sostav_box, .category .post .sostav_box").each(function(){
		var sostavRegexp = $(this).text();
		sostavRegexp = sostavRegexp.replace(/:.*?,/g, ",");
		sostavRegexp = sostavRegexp.replace(/:.*?;/g, ".");
		$(this).html(sostavRegexp);
		
	});


	$(".post .time_box .hours").each(function(){
		var hoursRegexp = $(this).find(".symbols").text();
		if(hoursRegexp == "1"){
			$(this).find(".text").text("час");
		}
		if(hoursRegexp == "5" || hoursRegexp > "5"){
			$(this).find(".text").text(" часов");
		}
		if(hoursRegexp == "0"){
			$(this).find(".text, .symbols").text("");
		}
		if(hoursRegexp == ""){
			$(this).find(".text, .symbols").text("");
		}
	});

	var body    = $( 'body' ),
	    _window = $( window );

	/**
	 * Adds a top margin to the footer if the sidebar widget area is higher
	 * than the rest of the page, to help the footer always visually clear
	 * the sidebar.
	 */
	$( function() {
		if ( body.is( '.sidebar' ) ) {
			var sidebar   = $( '#secondary .widget-area' ),
			    secondary = ( 0 == sidebar.length ) ? -40 : sidebar.height(),
			    margin    = $( '#tertiary .widget-area' ).height() - $( '#content' ).height() - secondary;

			if ( margin > 0 && _window.innerWidth() > 999 )
				$( '#colophon' ).css( 'margin-top', margin + 'px' );
		}
	} );

	/**
	 * Enables menu toggle for small screens.
	 */
	( function() {
		var nav = $( '#site-navigation' ), button, menu;
		if ( ! nav )
			return;

		button = nav.find( '.menu-toggle' );
		if ( ! button )
			return;

		// Hide button if menu is missing or empty.
		menu = nav.find( '.nav-menu' );
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		$( '.menu-toggle' ).on( 'click.twentythirteen', function() {
			nav.toggleClass( 'toggled-on' );
		} );
	} )();

	/**
	 * Makes "skip to content" link work correctly in IE9 and Chrome for better
	 * accessibility.
	 *
	 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
	 */
	_window.on( 'hashchange.twentythirteen', function() {
		var element = document.getElementById( location.hash.substring( 1 ) );

		if ( element ) {
			if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
				element.tabIndex = -1;

			element.focus();
		}
	} );

	/**
	 * Arranges footer widgets vertically.
	 */
	if ( $.isFunction( $.fn.masonry ) ) {
		var columnWidth = body.is( '.sidebar' ) ? 228 : 245;

		$( '#secondary .widget-area' ).masonry( {
			itemSelector: '.widget',
			columnWidth: columnWidth,
			gutterWidth: 20,
			isRTL: body.is( '.rtl' )
		} );
	}

	function sizeParametersWidget(){
		var ParametersWidgetParentWidth = $(".parameters_table").parents(".sidebar-inner").width();
		$(".parameters_table").width(ParametersWidgetParentWidth);
	}
	sizeParametersWidget();

	$(window).resize(function(){
		sizeParametersWidget();
	});

	function windowSizeCheck(){
		windowWidth = $(window).width();
	}

	function ParametersWidgetTable() {		
		if(windowWidth < 980){
			$(".first_plan.parameters_table").css({"display":"none"});
		}
		else {
			var ParametersWidgetTableCont = $(".sostav_box").text().replace(/,/g,"</td></tr><tr><td>");
			ParametersWidgetTableCont = ParametersWidgetTableCont.replace(";","</td></tr>");
			ParametersWidgetTableCont = ParametersWidgetTableCont.replace(/:/g,"</td><td>");
			$(".widget-area .table").html("<tr><td>"+ParametersWidgetTableCont);
			$(".first_plan.parameters_table").css({"display":"block"});
		}
	}

	$(document).ready(function(){
		windowSizeCheck();
		ParametersWidgetTable();
	});	

	$(window).resize(function(){
		windowSizeCheck();
		ParametersWidgetTable();
	});	

	$( window ).resize(function() {
	  $( "#log" ).append( "<div>Handler for .resize() called.</div>" );
	});

	$(".scrolingTo").bind("click", function (t) {
        var n = $(this);
        $("html, body").stop().animate({
            scrollTop: $(n.attr("href")).offset().top
        }, 1500);
        t.preventDefault();
    });

	$(document).ready(function () {
	    $(window).scroll(function(){
	        var ScrollTop = parseInt($(window).scrollTop());
	        //console.log(ScrollTop);

	        if (ScrollTop > 100) {
	            $(".to_top").fadeIn();
	        }
	        else {
	        	$(".to_top").fadeOut(0);
	        }
	    });
	});

} )( jQuery );