/* Custom JS Here */



jQuery(document).ready(function() {

	var distance_range = 'Radius: ' + jQuery( '#distance_range' ).val() + 'KM';
	jQuery('#pac-container #distance_c').html( distance_range );

	google.maps.event.addDomListener(window, 'load', initialize);

	jQuery(document).on('click', '#btn_location', function(event) {
		getLocation();
	});

	jQuery(document).on('change', '#searchform #distance_range', function(){
		var distance_range = 'Radius: ' + jQuery( '#distance_range' ).val() + 'KM';
		jQuery('#pac-container #distance_c').html( distance_range );

		if ( typeof jQuery("#pac-input").val() != 'undefined' && jQuery("#pac-input").val() != "" ) {
			jQuery( '#pac-input' ).attr( 'data-zoom', '' );
			listingproc_update_results();
		}
		else{
			var err_html 	= '<div id="msg_error" class="error_box msg_error" style="display: block;">Please enter a location for radius filter to work.</div>';
			jQuery('#distance_range_div').append( err_html );

			setTimeout(function(){
				jQuery( '#msg_error' ).remove();
			}, 3000);

		}
	});


});


function listingproc_update_results() {
	var docHeight = jQuery( document ).height();
	jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
	jQuery('#full-overlay').css('height',docHeight+'px');
	jQuery('#content-grids').html(' ');
	jQuery('.solitaire-infinite-scroll').remove();
	jQuery('#content-grids').addClass('content-loading');
	jQuery('.lp-filter-pagination').hide();
	listStyle = jQuery("#page").data('list-style');
	var inexpensive='';
	moderate = '';
	pricey = '';
	ultra = '';
	averageRate = '';
	mostRewvied = '';
	listing_openTime = '';

	inexpensive = jQuery('.currency-signs #one').find('.active').data('price');
	moderate = jQuery('.currency-signs #two').find('.active').data('price');
	pricey = jQuery('.currency-signs #three').find('.active').data('price');
	ultra = jQuery('.currency-signs #four').find('.active').data('price');

	averageRate = jQuery('.search-filters li#listingRate').find('.active').data('value');
	mostRewvied = jQuery('.search-filters li#listingReviewed').find('.active').data('value');
	listing_openTime = jQuery('.search-filters li#listing_openTime').find('.active').data('value');

	var tags_name = [];
	tags_name = jQuery('.tags-area input[type=checkbox]:checked').map(function(){
		return jQuery(this).val();
	}).get();

	jQuery.ajax({
		type: 'POST',
		dataType: 'json',
		url: ajax_search_term_object.ajaxurl,
		data: {
			'action': 'ajax_search_tags',
			'tag_name': jQuery("#searchtags").val(),
			'cat_id': jQuery("#searchcategory").val(),
			'loc_id': jQuery("#lp_search_loc").val(),

			'my_comming_from' 	: 'search',

			'sloc_address' : jQuery("#pac-input").val(),
			'my_lat' 	: jQuery("#pac-input").attr( 'data-lat' ),
			'my_lng' 	: jQuery("#pac-input").attr( 'data-lng' ),
			'my_bounds_ne_lat' 	: jQuery("#pac-input").attr( 'data-ne-lat' ),
			'my_bounds_ne_lng' 	: jQuery("#pac-input").attr( 'data-ne-lng' ),
			'my_bounds_sw_lat' 	: jQuery("#pac-input").attr( 'data-sw-lat' ),
			'my_bounds_sw_lng' 	: jQuery("#pac-input").attr( 'data-sw-lng' ),
			'data_zoom' 	: jQuery( '#pac-input' ).attr( 'data-zoom'),
			'distance_range' 	: jQuery("#distance_range").val(),

			'inexpensive':inexpensive,
			'moderate':moderate,
			'pricey':pricey,
			'ultra':ultra,
			'averageRate':averageRate,
			'mostRewvied':mostRewvied,
			'listing_openTime':listing_openTime,
			'tag_name':tags_name,
			'list_style': listStyle
		},
		success: function(data){
			jQuery('#full-overlay').remove();
			if(data){
				listing_update(data);
			}
		}
	});
}


function initialize() {
	var input = document.getElementById('pac-input');
	var autocomplete = new google.maps.places.Autocomplete(input);
	autocomplete.addListener('place_changed', function () {
		var place = autocomplete.getPlace();

		jQuery( '#pac-input' ).attr( 'data-zoom', '' );

		var loc_lat 	= place.geometry.location.lat();
		var loc_lng 	= place.geometry.location.lng();

		console.log(place.geometry.location.lat());
		console.log(place.geometry.location.lng());
		console.log(place.geometry.viewport.getCenter().lat());
		console.log(place.geometry.viewport.getCenter().lng());

		jQuery( '#pac-input' ).attr( 'data-lat', loc_lat );
		jQuery( '#pac-input' ).attr( 'data-lng', loc_lng );

		jQuery( '#pac-input' ).attr( 'data-center-lat', place.geometry.viewport.getCenter().lat() );
		jQuery( '#pac-input' ).attr( 'data-center-lng', place.geometry.viewport.getCenter().lng() );

		jQuery( '#pac-input' ).attr( 'data-ne-lat', place.geometry.viewport.getNorthEast().lat() );
		jQuery( '#pac-input' ).attr( 'data-ne-lng', place.geometry.viewport.getNorthEast().lng() );
		jQuery( '#pac-input' ).attr( 'data-sw-lat', place.geometry.viewport.getSouthWest().lat() );
		jQuery( '#pac-input' ).attr( 'data-sw-lng', place.geometry.viewport.getSouthWest().lng() );

		listingproc_update_results();

	});
}


function listingproc_get_radius( center_lat, center_lng, ne_lat, ne_lng ){

	// r = radius of the earth in statute miles
	var r = 6371.0;

	// Convert lat or lng from decimal degrees into radians (divide by 57.2958)
	var lat1 = center_lat / 57.2958;
	var lon1 = center_lng / 57.2958;
	var lat2 = ne_lat / 57.2958;
	var lon2 = ne_lng / 57.2958;

	// distance = circle radius from center to Northeast corner of bounds
	return r * Math.acos(Math.sin(lat1) * Math.sin(lat2) + Math.cos(lat1) * Math.cos(lat2) * Math.cos(lon2 - lon1));

}


function getLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition( initMap );
	}
}// getLocation


function initMap( position ) {
	var geocoder = new google.maps.Geocoder();
	geocodeLatLng( geocoder, position.coords.latitude, position.coords.longitude );
}// initMap


function geocodeLatLng( geocoder, lat, lng ) {
	var latlng 		= {lat : lat, lng : lng};
  geocoder.geocode({'location': latlng}, function(results, status) {
    if (status === 'OK') {
      if (results[1]) {

				jQuery( '#pac-input' ).attr( 'data-zoom', '' );

				jQuery( '#pac-input' ).val( results[1].formatted_address );
				jQuery( '#pac-input' ).attr( 'data-lat', lat );
				jQuery( '#pac-input' ).attr( 'data-lng', lng );
				listingproc_update_results();
      }
    }
  });
}// geocodeLatLng


function listingproc_update_markers( map ){
	map.on( 'zoomend dragend', function(){

		var bounds 	= map.getBounds();
		window.bounds 	= bounds;

		console.log(window.bounds);

		//jQuery( '#pac-input' ).val('');

		jQuery( '#pac-input' ).attr( 'data-zoom', 'yes' );

		jQuery( '#pac-input' ).attr( 'data-ne-lat', bounds._northEast.lat );
		jQuery( '#pac-input' ).attr( 'data-ne-lng', bounds._northEast.lng );
		jQuery( '#pac-input' ).attr( 'data-sw-lat', bounds._southWest.lat );
		jQuery( '#pac-input' ).attr( 'data-sw-lng', bounds._southWest.lng );

		listingproc_update_results();
	});
}// listingproc_update_markers


var hasOwnProperty = Object.prototype.hasOwnProperty;
function listingproc_isEmpty(obj) {

    // null and undefined are "empty"
    if (obj == null) return true;

    // Assume if it has a length property with a non-zero value
    // that that property is correct.
    if (obj.length > 0)    return false;
    if (obj.length === 0)  return true;

    // If it isn't an object at this point
    // it is empty, but it can't be anything *but* empty
    // Is it empty?  Depends on your application.
    if (typeof obj !== "object") return true;

    // Otherwise, does it have any properties of its own?
    // Note that this doesn't handle
    // toString and valueOf enumeration bugs in IE < 9
    for (var key in obj) {
        if (hasOwnProperty.call(obj, key)) return false;
    }

    return true;
}// listingproc_isEmpty
