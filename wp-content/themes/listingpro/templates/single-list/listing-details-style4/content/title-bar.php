<div class="lp-listing-title">

    <div class="lp-listing-name">

        <h1><?php echo $lp_title;  ?> <?php echo $claim; ?></h1>

        <?php

        if( !empty( $tagline_text ) && $tagline_text != '&nbsp;' ):

            ?>

            <p class="lp-listing-name-tagline"><?php echo $tagline_text; ?></p>

        <?php endif; ?>

        <?php
        $allowedReviews = $listingpro_options['lp_review_switch'];
        if( !empty( $allowedReviews ) && $allowedReviews == 1 && get_post_status( $post->ID )== "publish" ):
            ?>
            <div class="lp-listing-title-rating">
                <?php if( $NumberRating > 0 ): ?>
                    <span class="lp-rating-avg <?php echo $rating_num_bg; ?>"><?php echo $rating; ?>/5</span>
                    <span class="lp-rating-count"><?php echo $NumberRating; ?> <?php echo esc_html__( 'Reviews', 'listingpro' ); ?></span>
                <?php endif; ?>
                <a href="" class="review-form-toggle"><i class="fa fa-star" aria-hidden="true"></i><?php echo esc_html__('Add Review ', 'listingpro'); ?></a>

            </div>

        <?php endif; ?>

    </div>

    <div class="lp-listing-action-btns buttons-in-header">

        <ul>

            <li><?php listingpro_sharing_v2(); ?></li>

            <li>

                <?php

                $favrt  =   listingpro_is_favourite_v2(get_the_ID());

                ?>

                <a href="" class="<?php if($favrt == 'yes'){echo 'remove-fav-v2';}else{echo 'add-to-fav-v2';} ?>" data-post-id="<?php echo get_the_ID(); ?>" data-post-type="detail">

                    <i class="fa <?php if($favrt == 'yes'){echo 'fa-bookmark';}else{echo 'fa-bookmark-o';} ?>" aria-hidden="true"></i>

                    <?php if($favrt == 'yes'){echo esc_html__('Saved', 'listingpro');}else{echo esc_html__('Save', 'listingpro');} ?>

                </a>

            </li>

            <?php

            if( !empty( $resurva_url ) ):

                ?>

                <div class="clearfix"></div>

                <li id="lp-book-now"><a href=""><i class="fa fa-calendar-check-o"></i> <?php echo esc_html__( 'Book Now', 'listingpro' ); ?></a></li>

            <?php endif; ?>

        </ul>

        <div class="clearfix"></div>

    </div>

    <div class="clearfix"></div>

</div>