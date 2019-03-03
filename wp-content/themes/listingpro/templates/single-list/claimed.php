<?php
global $listingpro_options;
$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
$lp_detail_page_styles = $listingpro_options['lp_detail_page_styles'];
$showClaim = true;

if(isset($listingpro_options['lp_listing_claim_switch'])){
    if($listingpro_options['lp_listing_claim_switch']==1){
        $claimed_section = listing_get_metabox('claimed_section');
        if(empty($claimed_section)){
            $showClaim = true;
        }
        elseif($claimed_section == 'claimed') {
            $showClaim = false;
        }
        elseif($claimed_section == 'not_claimed') {
            $showClaim = true;
        }

    }else{
        $showClaim = false;
    }
}
else{
    $showClaim = false;
}


if($showClaim==true) {
    if ( ( $lp_detail_page_styles == 'lp_detail_page_styles3' || $lp_detail_page_styles == 'lp_detail_page_styles4' ) && !wp_is_mobile()) {

        ?>
        <p>
            <span><?php echo listingpro_icons('building'); ?> <?php echo esc_html__('Own or work here?', 'listingpro'); ?></span>
            <?php

            /* added by zaheer on 25 feb */

            if( is_user_logged_in() )
            {
                ?>
                <a href="#" class="md-trigger claimformtrigger2" data-modal="modal-2"><?php echo esc_html__('Claim Now!', 'listingpro'); ?></a>
                <a href="#" class="claimformtrigger md-trigger"><?php echo esc_html__('Claim Now!', 'listingpro'); ?></a>
                <?php
            }
            else
            {
                ?>
                <a class="md-trigger claimformtrigger2" data-modal="modal-3"><?php echo esc_html__('Claim Now!', 'listingpro'); ?></a>
                <a class="claimformtrigger md-trigger" data-modal="modal-3"><?php echo esc_html__('Claim Now!', 'listingpro'); ?></a>
                <?php
            }
            ?>
        </p>
        <?php
    } else {
        ?>
        <div class="claim-area">
			<span class="phone-icon">
				<!-- <i class="fa fa-building-o"></i> -->
                <?php echo listingpro_icons('building'); ?>
                <strong><?php echo esc_html__('Own or work here?', 'listingpro'); ?></strong>
			</span>
            <?php
            /* added by zaheer on 25 feb */


            if (is_user_logged_in()) {
                ?>
                <a class="phone-number md-trigger claimformtrigger2" data-modal="modal-2">
                    <?php echo esc_html__('Claim Now!', 'listingpro'); ?>
                </a>
                <a class="phone-number claimformtrigger md-trigger">
                    <?php echo esc_html__('Claim Now!', 'listingpro'); ?>
                </a>
                <?php
            } else {

                ?>
                <?php if ($listing_mobile_view == 'app_view' && wp_is_mobile()) { ?>

                    <a class="phone-number md-trigger claimformtrigger2" data-toggle="modal" data-target="#app-view-login-popup">
                        <?php echo esc_html__('Claim Now!', 'listingpro'); ?>
                    </a>
                    <a class="phone-number claimformtrigger md-trigger" data-toggle="modal" data-target="#app-view-login-popup">
                        <?php echo esc_html__('Claim Now!', 'listingpro'); ?>
                    </a>
                <?php } else { ?>

                    <a class="phone-number md-trigger claimformtrigger2" data-modal="modal-3">
                        <?php echo esc_html__('Claim Now!', 'listingpro'); ?>
                    </a>
                    <a class="phone-number md-trigger" data-modal="modal-3">
                        <?php echo esc_html__('Claim Now!', 'listingpro'); ?>
                    </a>


                    <?php
                }
            }
            ?>
        </div>
        <?php
    }
}

?>