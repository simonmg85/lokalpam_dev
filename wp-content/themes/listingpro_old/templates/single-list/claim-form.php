<?php
global $listingpro_options;
$post_id='';
$post_title='';
$post_url='';
$post_author_id='';
$post_author_meta='';
$author_nicename='';
$author_url='';
$privacy_policy = $listingpro_options['payment_terms_condition'];
$privacy_claim = $listingpro_options['listingpro_privacy_claimform'];
$post_id = $post->ID;
$post_title = $post->post_title;
$post_url = get_permalink($post_id);

$post_author_id= $post->post_author;
$post_author_meta = get_user_by( 'id', $post_author_id );
//print_r($post_author_meta);
if(!empty($post_author_meta)){
    $author_nicename = $post_author_meta->user_nicename;
    $author_user_email = $post_author_meta->user_email;
}

$author_url = get_author_posts_url( $post_author_id);

$claimIMG = $listingpro_options['lp_listing_claim_image']['url'];

//paid claim
$paidclaim = $listingpro_options['lp_listing_paid_claim_switch'];
?>
<?php
if(class_exists('ListingproPlugin')) {
    if($paidclaim == 'yes'){
        ?>
        <div class="md-modal md-effect-3 single-page-popup planclaim-page-popup" id="modal-2">
            <div class="md-content claimform-box">
                <!-- <h3><?php //echo esc_html('Claim This Business', 'listingpro'); ?> ( <?php echo get_the_title(); ?> )</h3> -->

                <div class="lp-claim-plan-container">
                    <div class="lp-plan-card">
                        <div class="lp-plan-front lp-plan-face">
                            <div class="lp-claim-plans">
                                <?php echo do_shortcode('[listingpro_pricing plan_status="claim"]'); ?>
                            </div>
                        </div>
                        <div class="lp-plan-back lp-plan-face">
                            <form class="form-horizontal lp-form-planclaim-st"  method="post" id="claimform">

                                <div class="col-md-7 col-xs-12 padding-0">
                                    <div class="claim-details">
                                        <h2>
                                            <?php echo esc_html__('Claiming your business', 'listingpro'); ?>
                                        </h2>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="post_title" value="<?php echo esc_attr($post_title); ?>">
                                            <input type="hidden" class="form-control" name="post_url" value="<?php echo esc_attr($post_url); ?>">
                                            <input type="hidden" class="form-control" name="author_nicename" value="<?php echo esc_attr($author_nicename); ?>">
                                            <input type="hidden" class="form-control" name="author_url" value="<?php echo esc_attr($author_url); ?>">
                                            <input type="hidden" class="form-control" name="author_email" value="<?php echo esc_attr($author_user_email); ?>">
                                            <input type="hidden" class="form-control" name="post_id" value="<?php echo esc_attr($post_id); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo esc_html__('Full Name*', 'listingpro'); ?>
                                                <input type="text" name="fullname" id="fullname" placeholder="<?php echo esc_html__('Full Name', 'listingpro'); ?>">
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo esc_html__('Phone*', 'listingpro'); ?>
                                                <input type="text" name="phone" id="phoneClaim" placeholder="<?php echo esc_html__('111-111-234', 'listingpro'); ?>">
                                            </label>
                                        </div>
                                        <?php
                                        $paidClaim = lp_theme_option('lp_listing_paid_claim_switch');
                                        if($paidClaim=="yes"){
                                            ?>
                                            <div class="form-group">
												
												<input type="hidden" value= '' name="lp_claimed_plan" id="lp_claimed_plan">
                                                
                                            </div>

                                            <input type="hidden" id="claim_type"  name="claim_type" value="paidclaims">

                                            <?php
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label><?php echo esc_html__('Verfication Details', 'listingpro'); ?>
                                                <textarea class="form-control textarea1" rows="5" name="message" id="message" placeholder="<?php echo esc_html__('Detail description about your listing', 'listingpro'); ?>" required></textarea>
                                            </label>
                                        </div>

                                        <?php
                                        if(!empty($privacy_policy) && $privacy_claim=="yes"){
                                            ?>

                                            <div class="form-group lp_privacy_policy_Wrap">
                                                <input class="lpprivacycheckboxopt" id="reviewpolicycheck2" type="checkbox" name="reviewpolicycheck" value="true">
                                                <label for="reviewpolicycheck2"><a target="_blank" href="<?php echo get_the_permalink($privacy_policy); ?>" class="help" target="_blank"><?php echo esc_html__('I Agree', 'listingpro'); ?></a></label>
                                                <div class="help-text">
                                                    <a class="help" target="_blank"><i class="fa fa-question"></i></a>
                                                    <div class="help-tooltip">
                                                        <p><?php echo esc_html__('You agree & accept our Terms & Conditions for posting this information?', 'listingpro'); ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mr-bottom-0">
                                                <input type="submit" value="<?php echo esc_html__('Claim your business now!', 'listingpro'); ?>" class="lp-review-btn btn-second-hover" disabled>
                                                <i class="fa fa-circle-o-notch fa-spin fa-2x formsubmitting"></i>
                                                <span class="statuss"></span>
                                            </div>
                                            <?php
                                        }else{
                                            ?>
                                            <div class="form-group mr-bottom-0">
                                                <input type="submit" value="<?php echo esc_html__('Claim your business now!', 'listingpro'); ?>" class="lp-review-btn btn-second-hover">
                                                <i class="fa fa-circle-o-notch fa-spin fa-2x formsubmitting"></i>
                                                <span class="statuss"></span>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div class="secure-text">
                                            <i class="fa fa-lock"></i>
                                            <span><?php echo esc_html__('Secure claim process', 'listingpro'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5 col-xs-12 padding-0">

                                    <div class="claim-text">
                                        <?php
                                        if(!empty($claimIMG)){ ?>
                                            <img src="<?php echo $claimIMG; ?>" alt="">
                                        <?php }
                                        ?>
                                        <h3>
                                            <?php echo esc_html__('Why should I claim ?', 'listingpro'); ?>
                                        </h3>
                                        <p>
                                            <?php echo esc_html__('You can easily claim your business to unlock and access your dashboard where where you can get total of your business listings. You can start generating more leads by starting ads campaign or offer coupons or deals.', 'listingpro'); ?>
                                        </p>
                                    </div>
                                    <div class="claim-details">
                                        <ul>
                                            <li>
                                                <i class="fa fa-check-square-o"></i>
                                                <p><?php echo esc_html__('Earn claimed badge to indicate verified., add photos, video etc.', 'listingpro'); ?></p>
                                            </li>
                                            <li>
                                                <i class="fa fa-check-square-o"></i>
                                                <p><?php echo esc_html__('Edit business listing, add photos, video etc.', 'listingpro'); ?></p>
                                            </li>
                                            <li>
                                                <i class="fa fa-check-square-o"></i>
                                                <p><?php echo esc_html__('Promote your listing with ads to drive sales.', 'listingpro'); ?></p>
                                            </li>
                                            <li>
                                                <i class="fa fa-check-square-o"></i>
                                                <p><?php echo esc_html__('Start receiving messages from lead.', 'listingpro'); ?></p>
                                            </li>
                                            <li>
                                                <i class="fa fa-check-square-o"></i>
                                                <p><?php echo esc_html__('Create Deals/Coupons, add photos, video etc.', 'listingpro'); ?></p>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <a class="md-close lp-click-zindex"><i class="fa fa-close"></i></a>
                </div>
            </div>

        </div>
    <?php } ?>
<?php } ?>
<?php if($paidclaim == 'no') {  ?>
    <div class="md-modal md-effect-3 single-page-popup planclaim-page-popup planclaim-page-popup-st" id="modal-2">
        <div class="md-content claimform-box">
            <!-- <h3><?php //echo esc_html('Claim This Business', 'listingpro'); ?> ( <?php echo get_the_title(); ?> )</h3> -->

            <form class="form-horizontal lp-form-planclaim-st"  method="post" id="claimform">

                <div class="col-md-7 col-xs-12 padding-0">
                    <div class="claim-details">
                        <h2>
                            <?php echo esc_html__('Claiming your business', 'listingpro'); ?>
                        </h2>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="post_title" value="<?php echo esc_attr($post_title); ?>">
                            <input type="hidden" class="form-control" name="post_url" value="<?php echo esc_attr($post_url); ?>">
                            <input type="hidden" class="form-control" name="author_nicename" value="<?php echo esc_attr($author_nicename); ?>">
                            <input type="hidden" class="form-control" name="author_url" value="<?php echo esc_attr($author_url); ?>">
                            <input type="hidden" class="form-control" name="author_email" value="<?php echo esc_attr($author_user_email); ?>">
                            <input type="hidden" class="form-control" name="post_id" value="<?php echo esc_attr($post_id); ?>">
                        </div>
                        <div class="form-group">
                            <label><?php echo esc_html__('Full Name*', 'listingpro'); ?>
                                <input type="text" name="fullname" id="fullname" placeholder="<?php echo esc_html__('Full Name', 'listingpro'); ?>">
                            </label>
                        </div>
                        <div class="form-group">
                            <label><?php echo esc_html__('Phone*', 'listingpro'); ?>
                                <input type="text" name="phone" id="phoneClaim" placeholder="<?php echo esc_html__('111-111-234', 'listingpro'); ?>">
                            </label>
                        </div>
                        <?php
                        $paidClaim = lp_theme_option('lp_listing_paid_claim_switch');
                        if($paidClaim=="yes"){
                            ?>
                            <div class="form-group">
                                <a href="#" class="lp_want_to_check_plans" target="_blank"><?php echo esc_html__('See Plans Details?', 'listingpro'); ?></a>
                                <select class="form-control" id="lp_claimed_plan" name="lp_claimed_plan">
                                    <?php
                                    $claimedPalns = lp_get_claim_plans_function_array();
                                    if(!empty($claimedPalns)){
                                        foreach($claimedPalns as $plan_id=>$plan_name){
                                            echo '<option value="'.$plan_id.'">'.$plan_name.'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <input type="hidden" id="claim_type"  name="claim_type" value="paidclaims">

                            <?php
                        }
                        ?>
                        <div class="form-group">
                            <label><?php echo esc_html__('Verfication Details', 'listingpro'); ?>
                                <textarea class="form-control textarea1" rows="5" name="message" id="message" placeholder="<?php echo esc_html__('Detail description about your listing', 'listingpro'); ?>" required></textarea>
                            </label>
                        </div>

                        <?php
                        if(!empty($privacy_policy) && $privacy_claim=="yes"){
                            ?>

                            <div class="form-group lp_privacy_policy_Wrap">
                                <input class="lpprivacycheckboxopt" id="reviewpolicycheck2" type="checkbox" name="reviewpolicycheck" value="true">
                                <label for="reviewpolicycheck2"><a target="_blank" href="<?php echo get_the_permalink($privacy_policy); ?>" class="help" target="_blank"><?php echo esc_html__('I Agree', 'listingpro'); ?></a></label>
                                <div class="help-text">
                                    <a class="help" target="_blank"><i class="fa fa-question"></i></a>
                                    <div class="help-tooltip">
                                        <p><?php echo esc_html__('You agree & accept our Terms & Conditions for posting this information?.', 'listingpro'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mr-bottom-0">
                                <input type="submit" value="<?php echo esc_html__('Claim your business now!', 'listingpro'); ?>" class="lp-review-btn btn-second-hover" disabled>
                                <i class="fa fa-circle-o-notch fa-spin fa-2x formsubmitting"></i>
                                <span class="statuss"></span>
                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="form-group mr-bottom-0">
                                <input type="submit" value="<?php echo esc_html__('Claim your business now!', 'listingpro'); ?>" class="lp-review-btn btn-second-hover">
                                <i class="fa fa-circle-o-notch fa-spin fa-2x formsubmitting"></i>
                                <span class="statuss"></span>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="secure-text">
                            <i class="fa fa-lock"></i>
                            <span><?php echo esc_html__('Secure claim process', 'listingpro'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-xs-12 padding-0">

                    <div class="claim-text">
                        <?php
                        if(!empty($claimIMG)){ ?>
                            <img src="<?php echo $claimIMG; ?>" alt="">
                        <?php }
                        ?>
                        <h3>
                            <?php echo esc_html__('Why should I claim ?', 'listingpro'); ?>
                        </h3>
                        <p>
                            <?php echo esc_html__('You can easily claim your business to unlock and access your dashboard where where you can get total of your business listings. You can start generating more leads by starting ads campaign or offer coupons or deals.', 'listingpro'); ?>
                        </p>
                    </div>
                    <div class="claim-details">
                        <ul>
                            <li>
                                <i class="fa fa-check-square-o"></i>
                                <p><?php echo esc_html__('Earn claimed badge to indicate verified., add photos, video etc.', 'listingpro'); ?></p>
                            </li>
                            <li>
                                <i class="fa fa-check-square-o"></i>
                                <p><?php echo esc_html__('Edit business listing, add photos, video etc.', 'listingpro'); ?></p>
                            </li>
                            <li>
                                <i class="fa fa-check-square-o"></i>
                                <p><?php echo esc_html__('Promote your listing with ads to drive sales.', 'listingpro'); ?></p>
                            </li>
                            <li>
                                <i class="fa fa-check-square-o"></i>
                                <p><?php echo esc_html__('Start receiving messages from lead.', 'listingpro'); ?></p>
                            </li>
                            <li>
                                <i class="fa fa-check-square-o"></i>
                                <p><?php echo esc_html__('Create Deals/Coupons, add photos, video etc.', 'listingpro'); ?></p>
                            </li>
                        </ul>
                    </div>

                </div>
            </form>
            <a class="md-close lp-click-zindex"><i class="fa fa-close"></i></a>
        </div>
    </div>
<?php } ?>
<!-- Popup Close -->
<div class="md-overlay"></div>
<div class="claimform">
    <h3><?php echo esc_html__('Claim This Listing', 'listingpro');?></h3>
    <div class="">
        <form class="form-horizontal"  method="post" id="claimformmobile">
            <div class="form-group">
                <input type="hidden" class="form-control" name="post_title" value="<?php echo esc_attr($post_title); ?>">
                <input type="hidden" class="form-control" name="post_url" value="<?php echo esc_attr($post_url); ?>">
                <input type="hidden" class="form-control" name="author_nicename" value="<?php echo esc_attr($author_nicename); ?>">
                <input type="hidden" class="form-control" name="author_url" value="<?php echo esc_attr($author_url); ?>">
                <input type="hidden" class="form-control" name="author_email" value="<?php echo esc_attr($author_user_email); ?>">
                <input type="hidden" class="form-control" name="post_id" value="<?php echo esc_attr($post_id); ?>">
            </div>
            <div class="form-group">
                <textarea class="form-control textarea1" rows="5" name="message" id="lpmessage" placeholder="<?php echo esc_html__('Message:','listingpro');?>"></textarea>
            </div>
            <?php
            if(!empty($privacy_policy) && $privacy_claim=="yes"){
                ?>
                <div class="form-group lp_privacy_policy_Wrap">
                    <input class="lpprivacycheckboxopt" id="reviewpolicycheck3" type="checkbox" name="reviewpolicycheck" value="true">
                    <label for="reviewpolicycheck3"><a target="_blank" href="<?php echo get_the_permalink($privacy_policy); ?>" class="help" target="_blank"><?php echo esc_html__('I Agree', 'listingpro'); ?></a></label>
                    <div class="help-text">
                        <a class="help" target="_blank"><i class="fa fa-question"></i></a>
                        <div class="help-tooltip">
                            <p><?php echo esc_html__('You agree & accept our Terms & Conditions for posting this information?.', 'listingpro'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="form-group mr-bottom-0">
                    <input type="submit" value="<?php echo esc_html__('Submit','listingpro');?>" class="lp-review-btn btn-second-hover" disabled>
                    <i class="fa fa-circle-o-notch fa-spin fa-2x formsubmitting"></i>
                    <span class="statuss"></span>
                </div>
            <?php } else{ ?>
                <div class="form-group mr-bottom-0">
                    <input type="submit" value="<?php echo esc_html__('Submit','listingpro');?>" class="lp-review-btn btn-second-hover">
                    <i class="fa fa-circle-o-notch fa-spin fa-2x formsubmitting"></i>
                    <span class="statuss"></span>
                </div>
            <?php } ?>
        </form>
    </div>
</div>