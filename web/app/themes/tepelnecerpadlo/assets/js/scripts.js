jQuery( document ).ready( function() {

    /* DOM mod */
    jQuery(function () {

        jQuery('.iconsearch').click(function() {
            jQuery( '#site-search.site-search' ).slideToggle();
        });

        jQuery('#close-search').click(function() {
            jQuery( '#site-search.site-search' ).slideToggle();
        });

    });





    // Youtube video bs wrapper
    jQuery(function () {

        var ytb = jQuery('[src*="https://www.youtube.com"]');

        if ( jQuery(ytb).parent('.embed-container').length == 0 ) {
            jQuery(ytb).wrap('<div class="ytbv col-xs-12 col-sm-6"><div class="embed-container"></div></div>');
        }

        jQuery('.ytbv').each(function(){
            var testss = jQuery(this).next('.ytbv');
            if (testss.length > 0 ) {
                jQuery(this).next('.ytbv').addBack().wrapAll('<div class="row ytbcontainer"></div>');
            }
            else {
                if ( jQuery(this).parent('.row').length == 0 ) {
                    jQuery(this).wrap('<div class="row ytbcontainer"></div>');
                    jQuery(this).addClass('col-xs-12').removeClass('col-sm-6');
                }
            }
        });

    });




    // Check responsivity with jQuery
    /* run test on initial page load */
    checkSize();
    /* run test on resize of the window */
    jQuery(window).resize( checkSize );

    //Function to the css rule
    function checkSize(){
        if ( jQuery(".sampleclass").css("max-width")=="6px" ) {
            //console.log ('all-devices');
        }
        if ( jQuery(".sampleclass").css("max-width")=="5px" ) {
            //console.log ('x-large-desktop');
        }
        if ( jQuery(".sampleclass").css("max-width")=="4px" ) {
            //console.log ('large-desktop');
        }
        if ( jQuery(".sampleclass").css("max-width")=="3px" ) {
            //console.log ('desktop');
            jQuery( '#site-search.site-search' ).hide();
        }
        if ( jQuery(".sampleclass").css("max-width")=="2px" ) {
            //console.log ('handheld');
        }
        if ( jQuery(".sampleclass").css("max-width")=="1px" ) {
            //console.log ('small-hand');
        }
    }




    /* smooth scroll to top */
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 200) {
            jQuery('#back-top').css('right','13px');
        }
        else {
            jQuery('#back-top').css('right','-50px');
        }
    });
    jQuery('#back-top a').click(function () {
        jQuery('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });




    /* disable empty search form */
    jQuery('.search-form').submit(function(e) {
        var s = jQuery( this ).find(".search-field");
        if (!s.val()) { // if s has no value, prevent the default submission and focus on the search input
            e.preventDefault();
            jQuery('.search-field').focus();
        }
    });






    /* Google map */
    (function($) {

        /* render_map */

        function render_map( $el ) {

            // var
            var $markers = $el.find('.marker');
            // vars
            var args = {
                zoom		: 16,
                center		: new google.maps.LatLng(0, 0),
                mapTypeId	: google.maps.MapTypeId.ROADMAP
            };

            // create map
            var map = new google.maps.Map( $el[0], args);

            // add a markers reference
            map.markers = [];

            // add markers
            $markers.each(function(){

                add_marker( $(this), map );

            });

            // center map
            center_map( map );

        }

        /*
         *  add_marker
         *
         *  This function will add a marker to the selected Google Map
         *
         *  @type	function
         *  @date	8/11/2013
         *  @since	4.3.0
         *
         *  @param	$marker (jQuery element)
         *  @param	map (Google Map object)
         *  @return	n/a
         */

        function add_marker( $marker, map ) {

            // var
            var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

            // create marker
            var marker = new google.maps.Marker({
                position	: latlng,
                map			: map
            });

            // add to array
            map.markers.push( marker );

            // if marker contains HTML, add it to an infoWindow
            if( $marker.html() )
            {
                // create info window
                var infowindow = new google.maps.InfoWindow({
                    content		: $marker.html()
                });

                // show info window when marker is clicked
                google.maps.event.addListener(marker, 'click', function() {

                    infowindow.open( map, marker );

                });
            }

        }

        /*
         *  center_map
         *
         *  This function will center the map, showing all markers attached to this map
         *
         *  @type	function
         *  @date	8/11/2013
         *  @since	4.3.0
         *
         *  @param	map (Google Map object)
         *  @return	n/a
         */

        function center_map( map ) {

            // vars
            var bounds = new google.maps.LatLngBounds();

            // loop through all markers and create bounds
            $.each( map.markers, function( i, marker ){

                var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

                bounds.extend( latlng );

            });

            // only 1 marker?
            if( map.markers.length == 1 )
            {
                // set center of map
                map.setCenter( bounds.getCenter() );
                map.setZoom( 16 );
            }
            else
            {
                // fit to bounds
                map.fitBounds( bounds );
            }

        }

        /*
         *  document ready
         *
         *  This function will render each map when the document is ready (page has loaded)
         *
         *  @type	function
         *  @date	8/11/2013
         *  @since	5.0.0
         *
         *  @param	n/a
         *  @return	n/a
         */

        $(document).ready(function(){

            $('#map').each(function(){

                render_map( $(this) );

            });

        });

    })(jQuery);


    var siteContentHeight = jQuery('footer#colophon').outerHeight();
    jQuery('#content.site-content').css({ 'margin-bottom': siteContentHeight, 'box-shadow':'0 0 30px rgba(0, 0, 0, 0.5)', 'background-color':'white' });




} ); // jQuery( document ).ready
