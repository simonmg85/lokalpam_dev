<?php
if(!function_exists('listingpro_get_all_reviews')){
	function listingpro_get_all_reviews($postid){
		
		global $listingpro_options;
		$showReport = true;
		if( isset($listingpro_options['lp_detail_page_review_report_button']) ){
			if( $listingpro_options['lp_detail_page_review_report_button']=='off' ){
				$showReport = false;
			}
		}
        $lp_multi_rating_state    	=   $listingpro_options['lp_multirating_switch'];

        if( $lp_multi_rating_state == 1 && !empty( $lp_multi_rating_state ) )
        {
            $lp_multi_rating_fields_active	=	array();
            for ($x = 1; $x <= 5; $x++) {
                $field_active   =   '';
               if( isset( $listingpro_options['lp_multi_ratiing'.$x.'_switch'] ) )
               {
                   $field_active    =    $listingpro_options['lp_multi_ratiing'.$x.'_switch'];
               }
                if( $field_active == 1 )
                {
                    
                    $field_active_label			=	$listingpro_options['lp_multi_ratiing'.$x.'_label_switch'];

                    $lp_multi_rating_fields_active['field'.$x]['label']			=	$field_active_label;
                    
                }
            }

        }

		?>
		
		<?php
		$currentUserId = get_current_user_id();
		$key = 'reviews_ids';
		$review_idss = listing_get_metabox_by_ID($key ,$postid);
		$review_ids = '';
		if( !empty($review_idss) ){
			$review_ids = explode(",",$review_idss);
		}
		
		$active_reviews_ids = array();
		if( !empty($review_ids) && is_array($review_ids) ){
			$review_ids = array_unique($review_ids);
			foreach($review_ids as $reviewID){
				if(get_post_status($reviewID)=="publish"){
					$active_reviews_ids[] = $reviewID;
				}
			}
			if(count($active_reviews_ids) == 1){
				$label = esc_html__('Review for ','listingpro').get_the_title($postid);
			}else{
				$label = esc_html__('Reviews for ','listingpro').get_the_title($postid);
			}
			echo '<h3 class="comment-reply-title">'.count($active_reviews_ids).' '.$label.'</h3>';
		}
		else{			
		}
		
		if( !empty($review_ids) && count($review_ids)>0 ){
			$review_ids = array_reverse($review_ids, true);
			echo '<div class="reviews-section">';
			//foreach( $review_ids as $key=>$review_id ){
				$args = array(
					'post_type'  => 'lp-reviews',
					'orderby'    => 'date',
					'order'      => 'DESC',
					'post__in'	 => $review_ids,
					'post_status'	=> 'publish',
					'posts_per_page'	=> -1
			 	);
			 	$query = new WP_Query( $args );
 				if ( $query->have_posts() ) {
					echo '';
					while ( $query->have_posts() ) {
						$query->the_post();
						global $post;
						echo '<article class="review-post">';
						// moin here strt
						$review_reply = '';
						$review_reply = listing_get_metabox_by_ID('review_reply' ,get_the_ID());
						
						$review_reply_time = '';
						$review_reply_time = listing_get_metabox_by_ID('review_reply_time' ,get_the_ID());
						$review_reply_time=date_create($review_reply_time);
						$review_reply_time = date_format($review_reply_time,"F j, Y h:i:s a");
						// moin here ends

						$rating = listing_get_metabox_by_ID('rating' ,get_the_ID());
						$rate = $rating;
						$gallery = get_post_meta(get_the_ID(), 'gallery_image_ids', true);
						$author_id = $post->post_author;
						
						$author_avatar_url = get_user_meta($author_id, "listingpro_author_img_url", true); 
						$avatar;
						if(!empty($author_avatar_url)) {
							$avatar =  $author_avatar_url;

						} else { 			
							$avatar_url = listingpro_get_avatar_url ( $author_id, $size = '94' );
							$avatar =  $avatar_url;

						}
						$user_reviews_count = count_user_posts( $author_id , 'lp-reviews' );
						?>
						<figure>
							<div class="review-thumbnail">
                                <a href="<?php echo get_author_posts_url($author_id); ?>">
								<img src="<?php  echo esc_attr($avatar); ?>" alt="">
                                </a>
							</div>
                            <figcaption>
                                <h4><a href="<?php echo get_author_posts_url($author_id); ?>"><?php the_author(); ?></a></h4>
                                <p><i class="fa fa-star"></i> <?php echo $user_reviews_count; ?> <?php esc_html_e('Reviews','listingpro'); ?></p>


                            </figcaption>
						</figure>
						<section class="details">
							<div class="top-section">
								<h3><?php the_title(); ?></h3>
								<time><?php echo get_the_time('F j, Y g:i a'); ?></time>
								<div class="review-count">
                                    <?php
                                    if( $lp_multi_rating_state == 1 && !empty( $lp_multi_rating_state ) )
                                    {
                                        echo '<a href="#" data-rate-box="multi-box-'.$post->ID.'" class="open-multi-rate-box"><i class="fa fa-chevron-down" aria-hidden="true"></i>'. esc_html__( 'View All', 'listingpro' ) .'</a>';
                                        $post_rating_data   =   get_post_meta( $post->ID, 'lp_listingpro_options', true );
                                        ?>
                                        <div class="lp-multi-star-wrap" id="multi-box-<?php echo $post->ID; ?>">
                                            <?php
                                            foreach ( $lp_multi_rating_fields_active as $k => $v )
                                            {
                                                $field_rating_val   =   '';
                                               if( isset($post_rating_data[$k]) )
                                               {
                                                   $field_rating_val   =   $post_rating_data[$k];
                                               }
                                                ?>
                                                <div class="lp-multi-star-field rating-with-colors <?php echo review_rating_color_class($field_rating_val); ?>">
                                                    <label><?php echo $v['label'];  ?></label>
                                                    <p>
                                                        <i class="fa <?php if( $field_rating_val > 0 ){echo 'fa-star'; }else{echo 'fa-star-o';} ?>" aria-hidden="true"></i>
                                                        <i class="fa <?php if( $field_rating_val > 1 ){echo 'fa-star'; }else{echo 'fa-star-o';} ?>" aria-hidden="true"></i>
                                                        <i class="fa <?php if( $field_rating_val > 2 ){echo 'fa-star'; }else{echo 'fa-star-o';} ?>" aria-hidden="true"></i>
                                                        <i class="fa <?php if( $field_rating_val > 3 ){echo 'fa-star'; }else{echo 'fa-star-o';} ?>" aria-hidden="true"></i>
                                                        <i class="fa <?php if( $field_rating_val > 4 ){echo 'fa-star'; }else{echo 'fa-star-o';} ?>" aria-hidden="true"></i>
                                                    </p>
                                                    <span class="lp-multi-star-label-start"><?php echo $v['label_start']; ?></span>
                                                    <span class="lp-multi-star-label-end"><?php echo $v['label_end']; ?></span>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
									<?php

										$review_rating = listing_get_metabox_by_ID('rating' ,get_the_ID());

                                   ?>
									<div class="rating rating-with-colors <?php echo review_rating_color_class($review_rating); ?>">
										<?php
											listingpro_ratings_stars('rating', get_the_ID());
										?>
									</div>
									<?php echo lp_cal_listing_rate(get_the_ID(),'lp_review', true); ?>
								</div>
							</div>
							<div class="content-section">
								<p><?php the_content(); ?></p>
								<?php if( !empty($gallery) ){ ?>
								<div class="images-gal-section">
									<div class="row">
										<div class="img-col review-img-slider">
											<?php
												//image gallery
												$imagearray = explode(',', $gallery);
												foreach( $imagearray as $image ){
													$imgGal = wp_get_attachment_image( $image, 'listingpro-review-gallery-thumb', '', '' );
													$imgGalFull = wp_get_attachment_image_src( $image,  'full');
														echo '<a class="galImgFull" href="'.$imgGalFull[0].'">'.$imgGal.'</a>';
												}
											?>
										</div>
									</div>
								</div>
								<?php } ?>
								<?php
										$interests = '';
										$Lols = '';
										$loves = '';
										$interVal = esc_html__('Interesting', 'listingpro');
										$lolVal = esc_html__('Lol', 'listingpro');
										$loveVal = esc_html__('Love', 'listingpro');
										
										$interests = listing_get_metabox_by_ID('review_'.$interVal.'',get_the_ID());
										$Lols = listing_get_metabox_by_ID('review_'.$lolVal.'',get_the_ID());
										$loves = listing_get_metabox_by_ID('review_'.$loveVal.'',get_the_ID());
										
										
										if(empty($interests)){
											$interests = 0;
										}
										if(empty($Lols)){
											$Lols = 0;
										}
										if(empty($loves)){
											$loves = 0;
										}
								?>
								<div class="bottom-section">
									<form action="#">
										<span><?php echo esc_html__('Was this review ...?', 'listingpro'); ?></span>
										<ul>
											<li>
												<a class="instresting reviewRes" href="#" data-reacted ="<?php echo esc_html__('You already reacted', 'listingpro'); ?>" data-restype='<?php  echo $interVal; ?>' data-id='<?php the_ID(); ?>' data-score='<?php echo esc_attr($interests); ?>'>
													<i class="fa fa-thumbs-o-up"></i><?php echo esc_html__('Interesting', 'listingpro'); ?><span class="interests-score"><?php if(!empty($interests)) echo $interests; ?></span>
													<span class="lp_state"></span>
												</a>
												
											</li>
											<li>
												<a class="lol reviewRes" href="#" data-reacted ="<?php echo esc_html__('You already reacted', 'listingpro'); ?>" data-restype='<?php echo $lolVal; ?>' data-id='<?php the_ID(); ?>' data-score='<?php echo esc_attr($Lols); ?>'>
													<i class="fa fa-smile-o"></i><?php echo esc_html__('Lol', 'listingpro'); ?><span class="interests-score"><?php if(!empty($Lols)) echo $Lols; ?></span>
													<span class="lp_state"></span>
												</a>
												
											</li>
											<li>
												<a class="love reviewRes" href="#" data-reacted ="<?php echo esc_html__('You already reacted', 'listingpro'); ?>" data-restype='<?php echo $loveVal; ?>' data-id='<?php the_ID(); ?>' data-id='<?php the_ID(); ?>' data-score='<?php echo esc_attr($loves); ?>'>
													<i class="fa fa-heart-o"></i><?php echo esc_html__('Love', 'listingpro'); ?><span class="interests-score"><?php if(!empty($loves)) echo $loves; ?></span>
													<span class="lp_state"></span>
												</a>
												
											</li>
											<?php
											if( $showReport==true && is_user_logged_in() ){ ?>
													<li id="lp-report-review">
														<a data-postid="<?php echo get_the_ID(); ?>"  data-reportedby="<?php echo $currentUserId; ?>" data-posttype="reviews" href="#" id="lp-report-this-review" class="report"><i class="fa fa-flag" aria-hidden="true"></i><?php esc_html_e('Report','listingpro'); ?></a>
													</li>
											<?php } ?>
										</ul>
									</form>
								</div>
							</div>
						</section>
						
						<?php if(!empty($review_reply)) { ?>
							<section class="details detail-sec">
								<div class="owner-response">
									<h3><?php esc_html_e('Owner Response', 'listingpro'); ?></h3>
										<?php
										if(!empty($review_reply_time)) { ?>
											<time><?php echo $review_reply_time; ?></time>
										<?php } ?>
											<p><?php echo $review_reply; ?></p>
										
								</div>
							</section>
							<?php } ?>
						<!-- moin here ends-->
						<?php
						echo '</article>';
					}
					echo '';
					wp_reset_postdata();
				} else {}
			//}
			echo '</div>';
		} 
		
	}
}



if(!function_exists('listingpro_get_all_reviews_app_view')){
    function listingpro_get_all_reviews_app_view($postid){

        global $listingpro_options;
        $showReport = true;
        if( isset($listingpro_options['lp_detail_page_review_report_button']) ){
            if( $listingpro_options['lp_detail_page_review_report_button']=='off' ){
                $showReport = false;
            }
        }
        $lp_multi_rating_state    	=   $listingpro_options['lp_multirating_switch'];

        if( $lp_multi_rating_state == 1 && !empty( $lp_multi_rating_state ) )
        {
            $lp_multi_rating_fields_active	=	array();
            for ($x = 1; $x <= 5; $x++) {
                $field_active   =   '';
                if( isset( $listingpro_options['lp_multi_ratiing'.$x.'_switch'] ) )
                {
                    $field_active    =    $listingpro_options['lp_multi_ratiing'.$x.'_switch'];
                }
                if( $field_active == 1 )
                {

                    $field_active_label			=	$listingpro_options['lp_multi_ratiing'.$x.'_label_switch'];

                    $lp_multi_rating_fields_active['field'.$x]['label']			=	$field_active_label;

                }
            }

        }
        ?>
        <?php
        $key = 'reviews_ids';
        $review_idss = listing_get_metabox_by_ID($key ,$postid);
        $review_ids = '';
        $currentUserId = get_current_user_id();
        if( !empty($review_idss) ){
            $review_ids = explode(",",$review_idss);
        }
        $active_reviews_ids = array();
        if( !empty($review_ids) && is_array($review_ids) ){
            $review_ids = array_unique($review_ids);
            foreach($review_ids as $reviewID){
                if(get_post_status($reviewID)=="publish"){
                    $active_reviews_ids[] = $reviewID;
                }
            }
            if(count($active_reviews_ids) == 1){
                $label = esc_html__('Review for ','listingpro').get_the_title($postid);
            }else{
                $label = esc_html__('Reviews for ','listingpro').get_the_title($postid);
            }
            //echo '<h3 class="comment-reply-title">'.count($active_reviews_ids).' '.$label.'</h3>';
        }
        else{
        }
        if( !empty($review_ids) && count($review_ids)>0 ){
            $review_ids = array_reverse($review_ids, true);
            echo '<div class="reviews-section">';
            //foreach( $review_ids as $key=>$review_id ){
            $args = array(
                'post_type'  => 'lp-reviews',
                'orderby'    => 'date',
                'order'      => 'ASC',
                'post__in'   => $review_ids,
                'post_status'   => 'publish'
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {
                echo '';
                while ( $query->have_posts() ) {
                    $query->the_post();
                    global $post;
                    echo '<article class="review-post">';
                    // moin here strt
                    $review_reply = '';
                    $review_reply = listing_get_metabox_by_ID('review_reply' ,get_the_ID());
                    $review_reply_time = '';
                    $review_reply_time = listing_get_metabox_by_ID('review_reply_time' ,get_the_ID());
                    // moin here ends
                    $rating = listing_get_metabox_by_ID('rating' ,get_the_ID());
                    $rate = $rating;
                    $gallery = get_post_meta(get_the_ID(), 'gallery_image_ids', true);
                    $author_id = $post->post_author;
                    $author_avatar_url = get_user_meta($author_id, "listingpro_author_img_url", true);
                    $avatar;
                    if(!empty($author_avatar_url)) {
                        $avatar =  $author_avatar_url;
                    } else {
                        $avatar_url = listingpro_get_avatar_url ( $author_id, $size = '94' );
                        $avatar =  $avatar_url;
                    }
                    $user_reviews_count = count_user_posts( $author_id , 'lp-reviews' );
                    ?>
                    <figure>
                        <div class="clearfix">
                            <div class="review-thumbnail">
                                <a href="<?php echo get_author_posts_url($author_id); ?>">
                                    <img src="<?php  echo esc_attr($avatar); ?>" alt="">
                                </a>
                            </div>
                            <figcaption>
                                <h3><?php the_title(); ?></h3>
                                <time><?php echo get_the_time('F j, Y g:i a'); ?></time>
                                <div class="review-count">
                                    <?php
                                    if( $lp_multi_rating_state == 1 && !empty( $lp_multi_rating_state ) )
                                    {
                                        echo '<a href="#" data-rate-box="multi-box-'.$post->ID.'" class="open-multi-rate-box"><i class="fa fa-chevron-down" aria-hidden="true"></i>'. esc_html__( 'View All', 'listingpro' ) .'</a>';
                                        $post_rating_data   =   get_post_meta( $post->ID, 'lp_listingpro_options', true );
                                        ?>
                                        <div class="lp-multi-star-wrap" id="multi-box-<?php echo $post->ID; ?>">
                                            <?php
                                            foreach ( $lp_multi_rating_fields_active as $k => $v )
                                            {
                                                $field_rating_val   =   '';
                                                if( isset($post_rating_data[$k]) )
                                                {
                                                    $field_rating_val   =   $post_rating_data[$k];
                                                }
                                                ?>
                                                <div class="lp-multi-star-field rating-with-colors <?php echo review_rating_color_class($field_rating_val); ?>">
                                                    <label><?php echo $v['label'];  ?></label>
                                                    <p>
                                                        <i class="fa <?php if( $field_rating_val > 0 ){echo 'fa-star'; }else{echo 'fa-star-o';} ?>" aria-hidden="true"></i>
                                                        <i class="fa <?php if( $field_rating_val > 1 ){echo 'fa-star'; }else{echo 'fa-star-o';} ?>" aria-hidden="true"></i>
                                                        <i class="fa <?php if( $field_rating_val > 2 ){echo 'fa-star'; }else{echo 'fa-star-o';} ?>" aria-hidden="true"></i>
                                                        <i class="fa <?php if( $field_rating_val > 3 ){echo 'fa-star'; }else{echo 'fa-star-o';} ?>" aria-hidden="true"></i>
                                                        <i class="fa <?php if( $field_rating_val > 4 ){echo 'fa-star'; }else{echo 'fa-star-o';} ?>" aria-hidden="true"></i>
                                                    </p>
                                                    <span class="lp-multi-star-label-start"><?php echo $v['label_start']; ?></span>
                                                    <span class="lp-multi-star-label-end"><?php echo $v['label_end']; ?></span>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
									<?php

										$review_rating = listing_get_metabox_by_ID('rating' ,get_the_ID());

                                   ?>
                                    <div class="rating rating-with-colors <?php echo review_rating_color_class($review_rating); ?>">
                                        <?php
                                        listingpro_ratings_stars('rating', get_the_ID());
                                        ?>
                                    </div>
                                    <?php echo lp_cal_listing_rate(get_the_ID(),'lp_review', true); ?>
                                </div>
                            </figcaption>
                        </div>
                    </figure>
                    <section class="details">
                        <div class="content-section">
                            <p><?php the_content(); ?></p>
                            <?php if( !empty($gallery) ){ ?>
                                <div class="images-gal-section">
                                    <div class="row">
                                        <div class="img-col review-img-slider">
                                            <?php
                                            //image gallery
                                            $imagearray = explode(',', $gallery);
                                            foreach( $imagearray as $image ){
                                                $imgGal = wp_get_attachment_image( $image, 'listingpro-review-gallery-thumb', '', '' );
                                                $imgGalFull = wp_get_attachment_image_src( $image,  'full');
                                                echo '<a class="galImgFull" href="'.$imgGalFull[0].'">'.$imgGal.'</a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php
                            $interests = '';
                            $Lols = '';
                            $loves = '';
                            $interVal = esc_html__('Interesting', 'listingpro');
                            $lolVal = esc_html__('Lol', 'listingpro');
                            $loveVal = esc_html__('Love', 'listingpro');
                            $interests = listing_get_metabox_by_ID('review_'.$interVal.'',get_the_ID());
                            $Lols = listing_get_metabox_by_ID('review_'.$lolVal.'',get_the_ID());
                            $loves = listing_get_metabox_by_ID('review_'.$loveVal.'',get_the_ID());
                            if(empty($interests)){
                                $interests = 0;
                            }
                            if(empty($Lols)){
                                $Lols = 0;
                            }
                            if(empty($loves)){
                                $loves = 0;
                            }
                            ?>
                            <div class="bottom-section">
                                <form action="#">
                                    <span><?php echo esc_html__('Was this review ...?', 'listingpro'); ?></span>
                                    <ul>
                                        <li>
                                            <a class="instresting reviewRes" href="#" data-reacted ="<?php echo esc_html__('You already reacted', 'listingpro'); ?>" data-restype='<?php  echo $interVal; ?>' data-id='<?php the_ID(); ?>' data-score='<?php echo esc_attr($interests); ?>'>
                                                <i class="fa fa-thumbs-o-up"></i><?php echo esc_html__('Interesting', 'listingpro'); ?><span class="interests-score"><?php if(!empty($interests)) echo $interests; ?></span>
                                                <span class="lp_state"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="lol reviewRes" href="#" data-reacted ="<?php echo esc_html__('You already reacted', 'listingpro'); ?>" data-restype='<?php echo $lolVal; ?>' data-id='<?php the_ID(); ?>' data-score='<?php echo esc_attr($Lols); ?>'>
                                                <i class="fa fa-smile-o"></i><?php echo esc_html__('Lol', 'listingpro'); ?><span class="interests-score"><?php if(!empty($Lols)) echo $Lols; ?></span>
                                                <span class="lp_state"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="love reviewRes" href="#" data-reacted ="<?php echo esc_html__('You already reacted', 'listingpro'); ?>" data-restype='<?php echo $loveVal; ?>' data-id='<?php the_ID(); ?>' data-id='<?php the_ID(); ?>' data-score='<?php echo esc_attr($loves); ?>'>
                                                <i class="fa fa-heart-o"></i><?php echo esc_html__('Love', 'listingpro'); ?><span class="interests-score"><?php if(!empty($loves)) echo $loves; ?></span>
                                                <span class="lp_state"></span>
                                            </a>
                                        </li>
                                        <?php
                                        if( $showReport==true && is_user_logged_in() ){ ?>
                                            <li id="lp-report-review">
                                                <a data-postid="<?php echo get_the_ID(); ?>"  data-reportedby="<?php echo $currentUserId; ?>" data-posttype="reviews" href="#" id="lp-report-this-review" class="report"><i class="fa fa-flag" aria-hidden="true"></i><?php esc_html_e('Report','listingpro'); ?></a>
                                            </li>
                                        <?php } ?>

                                    </ul>
                                </form>
                            </div>
                        </div>
                    </section>
                    <?php if(!empty($review_reply)) { ?>
                        <section class="details detail-sec">
                            <div class="owner-response">
                                <h3><?php esc_html_e('Owner Response', 'listingpro'); ?></h3>
                                <?php
                                if(!empty($review_reply_time)) { ?>
                                    <time><?php echo $review_reply_time; ?></time>
                                <?php } ?>
                                <p><?php echo $review_reply; ?></p>
                            </div>
                        </section>
                    <?php } ?>
                    <!-- moin here ends-->
                    <?php
                    echo '</article>';
                }
                echo '';
                wp_reset_postdata();
            } else {}
            //}
            echo '</div>';
        }
    }
}

?>