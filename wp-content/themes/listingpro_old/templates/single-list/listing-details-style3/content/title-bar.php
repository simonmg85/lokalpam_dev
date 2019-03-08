<div class="lp-listing-title">
	<?php
	$b_logo =   $listingpro_options['business_logo_switch'];
	if( $b_logo ==true):
		$business_logo_url  =   '';
		$b_logo_default =   $listingpro_options['business_logo_default']['url'];
		$business_logo = listing_get_metabox_by_ID('business_logo',get_the_ID());

		$image_thumb = '';
		global $wpdb;
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $business_logo ));
		if(!empty($attachment)){
			$image_thumb = wp_get_attachment_image_src($attachment[0], 'thumbnail');
		}
		if( empty( $business_logo ) )
		{
			$business_logo_url  =   $b_logo_default;
		}
		else
		{
			if(!empty($attachment)){
				$business_logo_url  =   $image_thumb[0];
			}
		}
		if( !empty( $business_logo_url ) ):
         ?>

            <div class="lp-listing-logo">

               <img src="<?php echo $business_logo_url; ?>" alt="Listing Logo">

            </div>

        <?php endif; endif; ?>

    <div class="lp-listing-name">

        <h1><?php the_title(); ?> <?php echo $claim; ?></h1>
        <p class="lp-listing-name-tagline"><?php echo $tagline_text; ?></p>

    </div>

    <?php

    $allowedReviews = $listingpro_options['lp_review_switch'];

    if( !empty( $allowedReviews ) && $allowedReviews == 1 && get_post_status( $post->ID )== "publish" ):

        ?>

        <div class="lp-listing-title-rating">

            <?php if( $NumberRating > 0 ): ?><span class="lp-rating-avg <?php echo $rating_num_bg; ?>"><?php echo $rating; ?>/<sub>5</sub></span><span class="lp-rating-count"><?php echo $NumberRating; ?> <?php echo esc_html__( 'Reviews', 'listingpro' ); ?></span><?php endif; ?>
			
            <?php
            if( $NumberRating == 0 ):
            ?>
            <span class="lp-rating-count zero-with-top-margin"><?php echo esc_html__( 'Be the first to review', 'listingpro' ); ?></span>
            <?php endif; ?>

        </div>

    <?php endif; ?>

    <div class="clearfix"></div>

</div>