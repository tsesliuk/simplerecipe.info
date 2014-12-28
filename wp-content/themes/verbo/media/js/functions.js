function reset_border_bottom(){
    jQuery('nav.base-nav ul.mythemes-menu > li').find('ul').each(function(){
        var width = parseInt( jQuery(this).parent('li').children('a').outerWidth() ) - 2;
        jQuery(this).parent('li').children('span.menu-delimiter') .css( { 'width' : width + 'px' });
    });
}
jQuery(function(){

    jQuery(".sostav_box").each(function(){
        var sostavRegexp = jQuery(this).text();
        sostavRegexp = sostavRegexp.replace(/:.*?,/g, ",");
        sostavRegexp = sostavRegexp.replace(/:.*?;/g, ".");
        jQuery(this).html(sostavRegexp);
        
    });

    jQuery(".post .post-short-info .hours").each(function(){
        var hoursRegexp = jQuery(this).find(".symbols").text();
        if(hoursRegexp == "1"){
            jQuery(this).find(".text").text("час");
        }
        if(hoursRegexp == "5" || hoursRegexp > "5"){
            jQuery(this).find(".text").text(" часов");
        }
        if(hoursRegexp == "0"){
            jQuery(this).find(".text, .symbols").text("");
        }
        if(hoursRegexp == ""){
            jQuery(this).find(".text, .symbols").text("");
        }
    });

    jQuery(function() {
      jQuery('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = jQuery(this.hash);
          target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            jQuery('html,body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });
    });

   
    jQuery(window).scroll(function (event) {
        var scroll = jQuery(window).scrollTop();
        if(scroll > 200) {jQuery(".to-start").fadeIn(500);} else {jQuery(".to-start").hide(0);}
    });   



    /* ADD PLUS AND ARROW FOR MENU ITEMS WITH SUB MENU */
    jQuery('nav.base-nav ul.mythemes-menu > li').find('ul').each(function(){
        if( !jQuery(this).parent('li').hasClass('submenu-arrow') ){
            jQuery(this).parent('li').addClass('submenu-arrow');
            jQuery(this).parent('li').children('a').append('<span class="menu-plus"></span>');
            var width = parseInt( jQuery(this).parent('li').children('a').outerWidth() ) - 2;
            jQuery(this).parent('li').append('<span class="menu-delimiter" style="width: ' + width + 'px;"></span>');
        }
    });

    /* ADD PLUS AND MINUS FOR MENU ITEMS WITH SUB MENU */
    jQuery( '.btn-collapse' ).click(function(){
        
        if( jQuery( this ).hasClass( 'collapsed' ) ){
            jQuery( this ).removeClass( 'collapsed' );
            jQuery( '.nav-collapse.in' ).each(function(){
                jQuery( this ).hide( 'slow' , function(){
                    jQuery( this ).removeClass( 'in' );
                    jQuery( this ).removeAttr( 'style' );
                });
            });
        }
        else{
            jQuery( '.btn-collapse' ).removeClass( 'collapsed' );
            jQuery( this ).addClass( 'collapsed' );

            var nav = jQuery( this ).attr( 'data-toggle' );

            jQuery( '.nav-collapse.in' ).each(function(){
                jQuery( this ).hide( 'slow' , function(){
                    jQuery( this ).removeClass( 'in' );
                    jQuery( this ).removeAttr( 'style' );
                });
            });

            jQuery( nav ).show( 'slow' , function(){
                jQuery( this ).addClass( 'in' );
                jQuery( this ).removeAttr( 'style' );
            });
        }
    });

    /* CHANGE BORDER BOTTOM ON WINDOW RESIZE */
    jQuery( window ).resize(function() {
         reset_border_bottom();
    });

  


    /* TAGS WITH COUNTER */
    jQuery( 'div.widget_tag_cloud div.tagcloud' ).append( '<div class="clear clearfix"></div>' );
    
    jQuery( 'div.widget_tag_cloud div.tagcloud a, div.widget_post_tags div.tagcloud a' ).each(function(){

        jQuery( this ).removeAttr( 'style' );
        jQuery( this ).removeAttr( 'class' );

        var text = jQuery( this ).text();
        var nr   = jQuery( this ).attr( 'title' ).split( " " )[0];


        jQuery( this ).html( '<span>' +
            '<span class="icon"><i class="icon-tag"></i></span>' +
            '<span class="tag-name">' + text + '</span>' +
            '<span class="counter">' + nr + '</span>' +
            '</span>'
        );

        var icon            = jQuery( this ).find( 'span.icon' );
        var name            = jQuery( this ).find( 'span.tag-name' );
        var counter         = jQuery( this ).find( 'span.counter' );

        var icon_width      = icon.outerWidth();
        var counter_width   = counter.outerWidth();

        var diff            = counter_width - icon_width;
        var name_width      = name.outerWidth();
        var width           = 0;

        if( diff < 0 ){
            diff            = 0;
            width           = name_width + icon_width;
            counter.css({ 'width' : icon_width + 'px' });    
        }else{
            width           = name_width + counter_width;
        }

        counter.css({ 'margin-left' : diff + 'px' });
        jQuery( this ).css({ 'width' : width + 'px' });
    });
});