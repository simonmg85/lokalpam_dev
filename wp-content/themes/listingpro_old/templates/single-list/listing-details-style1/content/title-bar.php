<div class="post-meta-info">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="post-meta-left-box">
                    <?php if (function_exists('listingpro_breadcrumbs')) listingpro_breadcrumbs(); ?>
                    <h1><?php the_title(); ?> <?php echo $claim; ?></h1>
                    <?php if(!empty($tagline_text)) {
                        if($tagline_show=="true"){?>
                            <p><?php echo $tagline_text; ?></p>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="post-meta-right-box text-right clearfix margin-top-20">
                    <ul class="post-stat">
                        <?php
                        $favrt  =   listingpro_is_favourite_new(get_the_ID());
                        ?>
                        <li id="fav-container">
                            <a class="email-address <?php if($favrt == 'yes'){echo 'remove-fav';}else{echo 'add-to-fav';} ?>" data-post-type="detail" href="" data-post-id="<?php echo get_the_ID(); ?>" data-success-text="<?php echo esc_html__('Saved', 'listingpro') ?>">
                                <i class="fa <?php echo listingpro_is_favourite(get_the_ID(),$onlyicon=true); ?>"></i>
                                <span class="email-icon">
												<?php echo listingpro_is_favourite(get_the_ID(),$onlyicon=false); ?>
											</span>

                            </a>
                        </li>
                        <li class="reviews sbutton">
                            <?php listingpro_sharing(); ?>
                        </li>
                    </ul>
                    <div class="padding-top-30">
								<span class="rating-section">
									<?php
                                    $NumberRating = listingpro_ratings_numbers($post->ID);
                                    if($NumberRating != 0){
                                        echo lp_cal_listing_rate(get_the_ID());
                                        ?>
                                        <span>
												<small><?php echo $NumberRating; ?></small>
												<br>
                                            <?php echo esc_html__('Ratings', 'listingpro'); ?>
											</span>
                                        <?php
                                    }else{
                                        echo lp_cal_listing_rate(get_the_ID());
                                    }
                                    ?>
								</span>
                        <?php if(!empty($resurva_url)){ ?>
                            <a href="" class="secondary-btn make-reservation">
                                <i class="fa fa-calendar-check-o"></i>
                                <?php echo esc_html__('Book Now', 'listingpro'); ?>
                            </a>
                            <div class="ifram-reservation">
                                <div class="inner-reservations">
                                    <a href="#" class="close-btn"><i class="fa fa-times"></i></a>
                                    <iframe src="<?php echo esc_url($resurva_url); ?>" name="resurva-frame" frameborder="0"></iframe>
                                </div>
                            </div>
                        <?php }else{
                            if (class_exists('ListingReviews')) {
                                $allowedReviews = $listingpro_options['lp_review_switch'];
                                if(!empty($allowedReviews) && $allowedReviews=="1"){
                                    if(get_post_status($post->ID)=="publish"){

                                        ?>
                                        <a href="#reply-title" class="secondary-btn" id="clicktoreview">
                                            <i class="fa fa-star"></i>
                                            <?php echo esc_html__('Submit Review', 'listingpro'); ?>
                                        </a>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>