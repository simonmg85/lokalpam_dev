<?php
global $post;
$eid            =   get_the_ID();

$event_title    =   get_the_title();
$listing_ID     =   get_post_meta( $eid, 'event-lsiting-id', true );
$listing_url    =   get_the_permalink( $listing_ID );
$event_time     =   get_post_meta( $eid, 'event-time', true );
$event_loc      =   get_post_meta( $eid, 'event-loc', true );
$event_date     =   get_post_meta( $eid, 'event-date', true );
$event_img      =   get_post_meta( $eid, 'event-img', true );
$event_ticket_url =   get_post_meta( $eid, 'ticket-url', true );
if(isset($eid) && !empty($eid) && !empty($listing_ID)){
	if( empty( $event_img ) )
	{
		if( has_post_thumbnail( $eid ) )
		{
			$event_img  =   get_the_post_thumbnail_url( $eid, 'listingpro-gallery-thumb2' );
		}
		else
		{
			$event_img    =   'https://placeholdit.imgix.net/~text?txtsize=33&w=360&h=198';
		}
	}
$event_content  =   $post->post_content;
?>

<div class="col-md-4" data-title="<?php echo $event_title; ?>" data-postid="<?php echo get_the_ID(); ?>">
    <div class="lp-listing">
        <div class="lp-listing-top">
            <?php if( !empty( $event_ticket_url ) ): ?>
                <a target="_blank" href="<?php echo $event_ticket_url; ?>" class="event-grid-ticket"><i class="fa fa-tag" aria-hidden="true"></i><?php echo esc_html__( 'Get Tickets', 'listingpro' ); ?></a>
            <?php endif; ?>
            <div class="lp-listing-top-thumb event-grid-thumb">
                <a href="<?php echo get_permalink( $eid ); ?>"><img src="<?php echo $event_img; ?>" alt="<?php echo $event_title; ?>"></a>
            </div>
        </div>
        <div class="lp-listing-bottom">
            <?php
            if( !empty( $event_date ) ):
            ?>
            <a class="lp-listing-cat event-grid-date"><span><?php echo date_i18n( 'd', $event_date ); ?></span> <?php echo date_i18n( 'F', $event_date ); ?></a>
            <?php endif; ?>
            <?php
            if( !empty( $event_time ) ):
            ?>
            <a class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-red"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $event_time; ?></a>
            <?php endif; ?>
            <div class="clearfix"></div>
            <h4><a href="<?php echo get_permalink( $eid ); ?>"><?php echo $event_title; ?></a></h4>
            <?php
            if( !empty( $event_loc ) ):
            ?>
            <div class="lp-listing-cats">
                <a><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $event_loc; ?>,</a>
            </div>
            <?php endif; ?>
            <p><?php if(strlen( $event_content ) > 70 ){ echo substr( $event_content, 0, 70 ).'...'; } ?></p>
            <div class="event-hosted-grid">
                <label><strong><?php echo esc_html__( 'Hosted by:', 'listingpro' ); ?></strong></label>
                <h6><a href="<?php echo $listing_url; ?>"><?php echo get_the_title( $listing_ID ); ?></a> </h6>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php } ?>