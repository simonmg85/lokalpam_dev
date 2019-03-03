<?php
/**
 * The template for displaying Listing Tags.
 */
global $listingpro_options;

$listing_mobile_view            =   $listingpro_options['single_listing_mobile_view'];

if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
{
    get_header('app-view');
}
else
{
    get_header();
}
$listing_style = $listingpro_options['listing_style'];
if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
{
    get_template_part( 'mobile/templates/listing-with-map-app' );
}else{
    switch($listing_style) {

        case '1': get_template_part( 'templates/listing-simple' );
            break;

        case '2': get_template_part( 'templates/listing-with-sidebar' );
            break;

        case '3': get_template_part( 'templates/listing-with-map' );
            break;

        case '4': get_template_part( 'templates/listing-with-header-filters' );
            break;

    }
}
if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
{
    get_footer('app-view');
}
else
{
    get_footer();
}