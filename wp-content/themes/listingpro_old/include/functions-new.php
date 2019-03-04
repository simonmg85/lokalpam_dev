<?php

$listingpro_options =   get_option('listingpro_options');
//do not write above this line



/* ============== proceed only if version is active ============ */

//if( empty( $version2_active ) || $version2_active == 0 ) return false;
/* ============== version2 Style Load ============ */

add_action('wp_enqueue_scripts', 'listingpro_style_version2');

function listingpro_style_version2()

{

    wp_enqueue_style('version2-countdown', THEME_DIR . '/assets/lib/countdown/flipclock.css');
    wp_enqueue_style('version2-styles', THEME_DIR . '/assets/css/main-new.css');
    wp_enqueue_style('version2-colors', THEME_DIR . '/assets/css/colors-new.css');

//    wp_enqueue_style('version2-font-family', THEME_DIR . '/layouts/assets/css/font-family.css');

	//For events app view map
	if(is_singular('events') && wp_is_mobile()){
		wp_enqueue_script('singlepostmap-version2', THEME_DIR. '/assets/js/singlepostmap-new.js', 'jquery', '', true);
	}
}



/* ============== version2 scripts Load ============ */

add_action('wp_enqueue_scripts', 'listingpro_scripts_version2');

function listingpro_scripts_version2()
{

   global $listingpro_options;
   $listing_layout =   $listingpro_options['lp_detail_page_styles'];
   wp_enqueue_script('version-countdown-js', THEME_DIR. '/assets/lib/countdown/flipclock.min.js', 'jquery', '', true);
	if( ($listing_layout == 'lp_detail_page_styles4' || $listing_layout == 'lp_detail_page_styles3' && !wp_is_mobile())
	    || ($listing_layout == 'lp_detail_page_styles4' || $listing_layout == 'lp_detail_page_styles3' && $mobile_view == 'responsive_view' && wp_is_mobile()) )
	{
		wp_enqueue_script('singlepostmap-version2', THEME_DIR. '/assets/js/singlepostmap-new.js', 'jquery', '', true);
	}
   wp_enqueue_script('Main-Version2', THEME_DIR. '/assets/js/main-new.js', 'jquery', '', true);

}



/* ============== version2 dynamic options ============ */

require_once THEME_PATH . '/include/dynamic-options-new.php';



/* ============== Check TIme ============ */



if ( !function_exists('listingpro_check_time_v2' ) )

{

    function listingpro_check_time_v2($postid,$status = false)

    {

        $output='';

        $buisness_hours = listing_get_metabox_by_ID('business_hours', $postid);



        if( !empty( $buisness_hours ) && count( $buisness_hours ) > 0 )

        {

            if( !empty( $postid ) )

            {

                $lat = listing_get_metabox_by_ID('latitude',$postid);
                $long = listing_get_metabox_by_ID('longitude',$postid);

            }



            //$timezone = getClosestTimezone($lat, $long);

            $timezone  = get_option('gmt_offset');

            $time = gmdate("H:i", time() + 3600*($timezone+date("I")));

            $day =  gmdate("l");

            $time = strtotime($time);

            $lang = get_locale();

            setlocale(LC_ALL, $lang.'.utf-8');

            $day = strftime("%A");

            $day = ucfirst($day);

            foreach( $buisness_hours as $key => $value )

            {

                $keyArray[] = $key;

                if($day == $key){

                    $dayName = esc_html__('Today','listingpro');

                }else{

                    $dayName = $key;

                }

                $opencheck = $value['open'];

                $open = $value['open'];

                $open = str_replace(' ', '', $open);

                $closecheck = $value['close'];

                $close = $value['close'];

                $close = str_replace(' ', '', $close);

                $open = @strtotime($open);

                $close = @strtotime($close);

                $newTimeOpen = date('h:i A', $open);

                $newTimeClose = date('h:i A', $close);



                if($day == $key){

                    if( empty($opencheck) && empty($closecheck) ){

                        if($status == false){

                            $output = esc_html__('24 hours open','listingpro');

                        }else{

                            $output = 'open';

                        }

                    }

                    elseif($time > $open && $time < $close){

                        if($status == false){

                            $output = esc_html__('Open','listingpro');

                        }else{

                            $output = 'open';

                        }

                    }else{

                        if($status == false){

                            $output = esc_html__('Closed','listingpro');

                        }else{

                            $output = 'close';

                        }

                    }

                }



            }

            if(is_array($keyArray) && !in_array($day, $keyArray)){

                $output = esc_html__('Day Off!','listingpro');

            }

        }else{

            if($status == true){

                $output = 'close';

            }

        }

        return $output;

    }

}



/* ============== Top bar share icons ============ */

if( !function_exists( 'listingpro_sharing_topbar' ) )

{

    function listingpro_sharing_topbar()

    {

        global  $listingpro_options;

        $fb_h =   $listingpro_options['fb_h'];

        $tw_h =   $listingpro_options['tw_h'];

        $gog_h =   $listingpro_options['gog_h'];

        $insta_h =   $listingpro_options['insta_h'];

        $tumb_h =   $listingpro_options['tumb_h'];

        $f_yout_h =   $listingpro_options['f-yout_h'];

        $f_linked_h =   $listingpro_options['f-linked_h'];

        $f_pintereset_h =   $listingpro_options['f-pintereset_h'];

        $f_vk_h =   $listingpro_options['f-vk_h'];

        ?>

        <ul>

            <?php

            if( $fb_h != '' && $fb_h != '#' )

            {

                echo '<li><a href="'. $fb_h .'" target="_blank"><i class="fa fa-facebook"></i></a></li>';

            }

            if( $tw_h != '' && $tw_h != '#' )

            {

                echo '<li><a href="'. $tw_h .'" target="_blank"><i class="fa fa-twitter"></i></a></li>';

            }

            if( $gog_h != '' && $gog_h != '#' )

            {

                echo '<li><a href="'. $gog_h .'" target="_blank"><i class="fa fa-google-plus"></i></a></li>';

            }

            if( $insta_h != '' && $insta_h != '#' )

            {

                echo '<li><a href="'. $insta_h .'" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>';

            }

            if( $tumb_h != '' && $tumb_h != '#' )

            {

                echo '<li><a href="'. $tumb_h .'" target="_blank"><i class="fa fa-tumblr" aria-hidden="true"></i></a></li>';

            }

            if( $f_yout_h != '' && $f_yout_h != '#' )

            {

                echo '<li><a href="'. $f_yout_h .'" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>';

            }

            if( $f_linked_h != '' && $f_linked_h != '#' )

            {

                echo '<li><a href="'. $f_linked_h .'" target="_blank"><i class="fa fa-linkedin"></i></a></li>';

            }

            if( $f_pintereset_h != '' && $f_pintereset_h != '#' )

            {

                echo '<li><a href="'. $f_pintereset_h .'" target="_blank"><i class="fa fa-pinterest"></i></a></li>';

            }

            if( $f_vk_h != '' && $f_vk_h != '#' )

            {

                echo '<li><a href="'. $f_vk_h .'" target="_blank"><i class="fa fa-vk" aria-hidden="true"></i></a></li>';

            }

            ?>

        </ul>

        <?php

    }

}



/* ============== Detail Page Reviews ============ */

if( !function_exists('listingpro_get_all_reviews_v2 ') )

{

    function listingpro_get_all_reviews_v2($postid)

    {

        global $listingpro_options;

        $showReport = true;

        if( isset( $listingpro_options['lp_detail_page_review_report_button'] ) )

        {

            if( $listingpro_options['lp_detail_page_review_report_button']=='off' )

            {

                $showReport = false;

            }

        }

        $lp_multi_rating_state    	=   $listingpro_options['lp_multirating_switch'];



        if( $lp_multi_rating_state == 1 && !empty( $lp_multi_rating_state ) )

        {
            $lp_multi_rating_fields_active	=	array();

            for ($x = 1; $x <= 4; $x++) {

                $field_active	=	$listingpro_options['lp_multi_ratiing'.$x.'_switch'];
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

        if( !empty( $review_idss ) )

        {

            $review_ids = explode(",",$review_idss);

        }



        $active_reviews_ids = array();



        if( !empty( $review_ids ) && is_array( $review_ids ) )

        {

            $review_ids = array_unique($review_ids);

            foreach( $review_ids as $reviewID )

            {

                if( get_post_status($reviewID )=="publish" )

                {

                    $active_reviews_ids[] = $reviewID;

                }

            }

            $l_title    =   get_the_title($postid);

            if( isset($GLOBALS['listID'] ) && !empty( $GLOBALS['listID'] ) )

            {

                $l_title    =   '<a href="'. get_permalink( $postid ) .'">'. get_the_title( $postid ) .'</a>';

            }

            if( count( $active_reviews_ids ) == 1 )

            {

                $label = esc_html__('Review for ','listingpro').$l_title;

            }else{

                $label = esc_html__('Reviews for ','listingpro').$l_title;

            }

            echo '<h4 class="lp-total-reviews">'.count($active_reviews_ids).' '. $label .'</h4>';

        }

        else

        {



        }

        if( !empty( $review_ids ) && count( $review_ids ) > 0 )

        {

            $review_ids = array_reverse($review_ids, true);

            //foreach( $review_ids as $key=>$review_id ){

            $args = array

            (

                'post_type'  => 'lp-reviews',

                'orderby'    => 'date',

                'order'      => 'ASC',

                'post__in'	 => $review_ids,

                'post_status'	=> 'publish'

            );

            $query = new WP_Query( $args );

            if ( $query->have_posts() )

            {

                echo '';

                while ( $query->have_posts() )

                {

                    $query->the_post();

                    global $post;

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

                    $avatar='';

                    if( !empty( $author_avatar_url ) )

                    {

                        $avatar =  $author_avatar_url;



                    }

                    else

                    {

                        $avatar_url = listingpro_get_avatar_url ( $author_id, $size = '94' );

                        $avatar =  $avatar_url;

                    }

                    $user_reviews_count = count_user_posts( $author_id , 'lp-reviews' );





                    $interests = '';

                    $Lols = '';

                    $loves = '';

                    $interVal = esc_html__('Interesting', 'listingpro');

                    $lolVal = esc_html__('Lol', 'listingpro');

                    $loveVal = esc_html__('Love', 'listingpro');



                    $interests = listing_get_metabox_by_ID('review_'.$interVal.'',get_the_ID());

                    $Lols = listing_get_metabox_by_ID('review_'.$lolVal.'',get_the_ID());

                    $loves = listing_get_metabox_by_ID('review_'.$loveVal.'',get_the_ID());





                    if( empty( $interests ) )

                    {

                        $interests = 0;

                    }

                    if( empty( $Lols ) )

                    {

                        $Lols = 0;

                    }

                    if( empty( $loves ) )

                    {

                        $loves = 0;

                    }

                    $reacted_msg    =   esc_html__('You already reacted', 'listingpro');

                    $rating_num_bg  =   '';

                    $rating_num_clr  =   '';



                   if( $rating < 2 ){ $rating_num_bg  =   'num-level1'; $rating_num_clr  =   'level1'; }
                   if( $rating < 3 ){ $rating_num_bg  =   'num-level2'; $rating_num_clr  =   'level2'; }
                   if( $rating < 4 ){ $rating_num_bg  =   'num-level3'; $rating_num_clr  =   'level3'; }
                   if( $rating >= 4 ){ $rating_num_bg  =   'num-level4'; $rating_num_clr  =   'level4'; }



                    ?>

                    <div class="lp-listing-review">

                        <div class="lp-review-left">

                            <div class="lp-review-thumb">
                                <a href="<?php echo get_author_posts_url($author_id); ?>">
                                <img src="<?php  echo esc_attr($avatar); ?>" alt="">
                                </a>
                            </div>

                            <span class="lp-review-name"><a href="<?php echo get_author_posts_url($author_id); ?>"><?php the_author(); ?></a></span>

                            <span class="lp-review-count"><i class="fa fa-star" aria-hidden="true"></i> <?php echo $user_reviews_count; ?> <?php esc_html_e('Reviews','listingpro'); ?></span>



                        </div>

                        <div class="lp-review-right">

                            <div class="lp-review-right-top">

                                <strong><?php the_title(); ?></strong>

                                <time><?php echo get_the_time('F j, Y g:i a'); ?></time>

                                <div class="lp-review-stars">

                                    <?php

                                    if( $lp_multi_rating_state == 1 && !empty( $lp_multi_rating_state ) )

                                    {

                                        echo '<a href="#" data-rate-box="multi-box-'.$post->ID.'" class="open-multi-rate-box"><i class="fa fa-chevron-down" aria-hidden="true"></i> '. esc_html__( 'View All', 'listingpro' ) .'</a>';

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
                                                <div class="lp-multi-star-field">
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

                                    <div class="lp-listing-stars">
                                        <div class="lp-rating-stars-outer">
                                            <span class="lp-star-box <?php if($rating >= 1){echo 'filled'.' '.$rating_num_clr;}?>"><i class="fa fa-star" aria-hidden="true"></i></span>

                                            <span class="lp-star-box <?php if($rating >= 2){echo 'filled'.' '.$rating_num_clr;}?>"><i class="fa fa-star" aria-hidden="true"></i></span>

                                            <span class="lp-star-box <?php if($rating >= 3){echo 'filled'.' '.$rating_num_clr;}?>"><i class="fa fa-star" aria-hidden="true"></i></span>

                                            <span class="lp-star-box <?php if($rating >= 4){echo 'filled'.' '.$rating_num_clr;}?>"><i class="fa fa-star" aria-hidden="true"></i></span>

                                            <span class="lp-star-box <?php if($rating >= 5){echo 'filled'.' '.$rating_num_clr;}?>"><i class="fa fa-star" aria-hidden="true"></i></span>
                                        </div>
                                        <?php

                                        if( $rating != 0 ):

                                        ?>

                                        <span class="lp-rating-num <?php echo $rating_num_bg; ?>"><?php echo $rating; ?><?php if( $rating == 1 || $rating == 2 || $rating == 3 || $rating == 4 || $rating == 5 ){ echo '.0';} ?> </span>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            </div>

                            <div class="lp-review-right-content">

                                <?php the_content(); ?>

                                <?php

                                if( !empty($gallery) ) {

                                    $imagearray = explode(',', $gallery);

                                    $imagearray_count = count($imagearray);

                                    if ($imagearray_count > 0) {

                                        require_once (THEME_PATH . "/include/aq_resizer.php");

                                        ?>

                                        <div class="lp-reivew-gallery">

                                            <div class="row">

                                                <div class="listing-review-slider" data-review-thumbs="<?php echo $imagearray_count; ?>">

                                                    <?php

                                                    foreach ($imagearray as $image) {

                                                        $imgGalFull = wp_get_attachment_image_src($image, 'full');

                                                        $imgGalThum  = aq_resize( $imgGalFull[0], '150', '115', true, true, true);

                                                        echo '<div class="col-md-3"><a href="' . $imgGalFull[0] . '" class="galImgFull" rel="prettyPhoto[gallery2]"><img src="' . $imgGalThum . '" alt=""></a></div>';

                                                    }

                                                    ?>

                                                </div>

                                            </div>

                                        </div>

                                        <?php

                                    }

                                }

                                ?>

                                <div class="lp-review-right-bottom">

                                    <span id="lp-review-text-align"><?php echo esc_html__('Was this review ...?', 'listingpro'); ?></span>

                                    <a href="#" data-restype="<?php echo $interVal; ?>" data-reacted ="<?php echo $reacted_msg; ?>" data-id="<?php the_ID(); ?>" data-score="<?php echo esc_attr($interests); ?>" class="review-interesting review-reaction"><i class="fa fa-thumbs-o-up"></i><span class="react-msg"></span> <?php esc_html_e('Interesting','listingpro'); ?> <span class="react-count"><?php echo $interests; ?></span></a>

                                    <a href="#" data-restype="<?php echo $lolVal; ?>" data-reacted ="<?php echo $reacted_msg; ?>" data-id="<?php the_ID(); ?>" data-score="<?php echo esc_attr($Lols); ?>" class="review-lol review-reaction"><i class="fa fa-smile-o"></i> <span class="react-msg"></span> <span class="react-msg"></span><?php esc_html_e('LOL','listingpro'); ?> <span class="react-count"><?php echo $Lols; ?></span></a>

                                    <a href="#" data-restype="<?php echo $loveVal; ?>" data-reacted ="<?php echo $reacted_msg; ?>" data-id="<?php the_ID(); ?>" data-score="<?php echo esc_attr($loves); ?>" class="review-love review-reaction"><i class="fa fa-heart-o"></i><span class="react-msg"></span> <span class="react-msg"></span><?php esc_html_e('Love','listingpro'); ?> <span class="react-count"><?php echo $loves; ?></span></a>

                                    <?php

                                    if( $showReport == true && is_user_logged_in() ):

                                        ?>

                                        <a id="lp-report-this-review" href="#" class="review-love" data-postid="<?php echo get_the_ID(); ?>"  data-reportedby="<?php echo $currentUserId; ?>" data-posttype="reviews"><i class="fa fa-flag" aria-hidden="true"></i> <?php esc_html_e('Report','listingpro'); ?></a>

                                        <?php

                                    endif;

                                    ?>

                                </div>

                            </div>
	                        <?php if(!empty($review_reply)) { ?>
                                <div class="lp-deatil-reply-review-area">
                                    <div class="owner-response">
                                        <h3><?php esc_html_e('Author Response', 'listingpro'); ?></h3>
				                        <?php
				                        if(!empty($review_reply_time)) { ?>
                                            <time><?php echo $review_reply_time; ?></time>
				                        <?php } ?>
                                        <p><?php echo $review_reply; ?></p>
                                    </div>
                                </div>
	                        <?php } ?>
                        </div>

                        <div class="clearfix"></div>

                    </div>

                    <?php

                }

                echo '';

                wp_reset_postdata();

            }

            else

            {



            }

            //}

        }

    }

}

if( !function_exists( 'activity_reviews' ) )

{

    function activity_reviews( $review_id, $author_id )

    {

        global $listingpro_options;

        $showReport = true;

        if( isset( $listingpro_options['lp_detail_page_review_report_button'] ) )

        {

            if( $listingpro_options['lp_detail_page_review_report_button']=='off' )

            {

                $showReport = false;

            }

        }

        $lp_multi_rating_state    	=   $listingpro_options['lp_multirating_switch'];



        if( $lp_multi_rating_state == 1 && !empty( $lp_multi_rating_state ) )

        {

            $lp_multi_rating_fields_active	=	array();

            for ($x = 1; $x <= 4; $x++) {
                $field_active	=	$listingpro_options['lp_multi_ratiing'.$x.'_switch'];
                if( $field_active == 1 )
                {
                    
                    $field_active_label			=	$listingpro_options['lp_multi_ratiing'.$x.'_label_switch'];

                    $lp_multi_rating_fields_active['field'.$x]['label']			=	$field_active_label;
                    

                }

            }



        }
        $currentUserId = get_current_user_id();
        $review_reply = '';
        $review_reply = listing_get_metabox_by_ID('review_reply' ,$review_id);



        $review_reply_time = '';

        $review_reply_time = listing_get_metabox_by_ID('review_reply_time' ,$review_id);

        // moin here ends



        $rating = listing_get_metabox_by_ID('rating' ,$review_id);

        $rate = $rating;

        $gallery = get_post_meta($review_id, 'gallery_image_ids', true);

        $author_avatar_url = get_user_meta($author_id, "listingpro_author_img_url", true);

        $avatar= '';

        if( !empty( $author_avatar_url ) )

        {

            $avatar =  $author_avatar_url;



        }

        else

        {

            $avatar_url = listingpro_get_avatar_url ( $author_id, $size = '94' );

            $avatar =  $avatar_url;

        }

        $user_reviews_count = count_user_posts( $author_id , 'lp-reviews' );





        $interests = '';

        $Lols = '';

        $loves = '';

        $interVal = esc_html__('Interesting', 'listingpro');

        $lolVal = esc_html__('Lol', 'listingpro');

        $loveVal = esc_html__('Love', 'listingpro');



        $interests = listing_get_metabox_by_ID('review_'.$interVal.'',$review_id);

        $Lols = listing_get_metabox_by_ID('review_'.$lolVal.'',$review_id);

        $loves = listing_get_metabox_by_ID('review_'.$loveVal.'',$review_id);





        if( empty( $interests ) )

        {

            $interests = 0;

        }

        if( empty( $Lols ) )

        {

            $Lols = 0;

        }

        if( empty( $loves ) )

        {

            $loves = 0;

        }

        $reacted_msg    =   esc_html__('You already reacted', 'listingpro');

        $rating_num_bg  =   '';

        $rating_num_clr  =   '';



        if( $rating < 3 ){ $rating_num_bg  =   'num-level1'; $rating_num_clr  =   'level1'; }

        if( $rating < 4 ){ $rating_num_bg  =   'num-level2'; $rating_num_clr  =   'level2'; }

        if( $rating < 5 ){ $rating_num_bg  =   'num-level3'; $rating_num_clr  =   'level3'; }

        if( $rating >= 5 ){ $rating_num_bg  =   'num-level4'; $rating_num_clr  =   'level4'; }

        ?>

        <div class="lp-listing-review">

            <div class="lp-review-left">

                <div class="lp-review-thumb">

                    <img src="<?php  echo esc_attr($avatar); ?>" alt="">

                </div>

	            <?php
	            $authorOBJ = get_user_by( 'ID', $author_id );
	            $author_display_name = $authorOBJ->display_name;
	            ?>

                <span class="lp-review-name"><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo $author_display_name; ?></a></span>

                <span class="lp-review-count"><i class="fa fa-star" aria-hidden="true"></i> <?php echo $user_reviews_count; ?> <?php esc_html_e('Reviews','listingpro'); ?></span>



            </div>

            <div class="lp-review-right">

                <div class="lp-review-right-top">

                    <strong><?php echo get_the_title( $review_id ); ?></strong>

                    <time>

                        <?php

                            echo human_time_diff( get_the_time('U', $review_id) ). ' ' .esc_html__( 'Ago', 'listingpro' );

                            //echo get_the_time('F j, Y g:i a', $review_id);

                        ?>

                    </time>

                    <div class="lp-review-stars">

                        <?php

                        if( $lp_multi_rating_state == 1 && !empty( $lp_multi_rating_state ) )

                        {

                            echo '<a href="#" data-rate-box="multi-box-'.$review_id.'" class="open-multi-rate-box"><i class="fa fa-chevron-down" aria-hidden="true"></i> '. esc_html__( 'View All', 'listingpro' ) .'</a>';

                            $post_rating_data   =   get_post_meta( $review_id, 'lp_listingpro_options', true );

                            ?>

                            <div class="lp-multi-star-wrap" id="multi-box-<?php echo $review_id; ?>">

                                <?php

                                foreach ( $lp_multi_rating_fields_active as $k => $v )

                                {
                                    $field_rating_val   =   '';
								   if( isset($post_rating_data[$k]) )
								   {
									   $field_rating_val   =   $post_rating_data[$k];
								   }
                                    ?>
                                    <div class="lp-multi-star-field">
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

                        <div class="lp-listing-stars">
                            <div class="lp-rating-stars-outer">

                            <span class="lp-star-box <?php if($rating >= 1){echo 'filled'.' '.$rating_num_clr;}?>"><i class="fa fa-star" aria-hidden="true"></i></span>

                            <span class="lp-star-box <?php if($rating >= 2){echo 'filled'.' '.$rating_num_clr;}?>"><i class="fa fa-star" aria-hidden="true"></i></span>

                            <span class="lp-star-box <?php if($rating >= 3){echo 'filled'.' '.$rating_num_clr;}?>"><i class="fa fa-star" aria-hidden="true"></i></span>

                            <span class="lp-star-box <?php if($rating >= 4){echo 'filled'.' '.$rating_num_clr;}?>"><i class="fa fa-star" aria-hidden="true"></i></span>

                            <span class="lp-star-box <?php if($rating >= 5){echo 'filled'.' '.$rating_num_clr;}?>"><i class="fa fa-star" aria-hidden="true"></i></span>

                            <?php

                            if( $rating != 0 ):

                                ?>
                            </div>
                                <span class="lp-rating-num <?php echo $rating_num_bg; ?>"><?php echo $rating; ?><?php if( $rating == 1 || $rating == 2 || $rating == 3 || $rating == 4 || $rating == 5 ){ echo '.0';} ?> </span>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <div class="lp-review-right-content">

                    <?php

                    $content_post = get_post( $review_id );

                    $content = $content_post->post_content;

                    echo '<p>'. $content .'</p>';

                    ?>

                    <p></p>

                    <?php

                    if( !empty($gallery) ) {

                        $imagearray = explode(',', $gallery);

                        $imagearray_count = count($imagearray);

                        if ($imagearray_count > 0) {

                            require_once (THEME_PATH . "/include/aq_resizer.php");

                            ?>

                            <div class="lp-reivew-gallery">

                                <div class="row">

                                    <div class="listing-review-slider" data-review-thumbs="<?php echo $imagearray_count; ?>">

                                        <?php

                                        foreach ($imagearray as $image) {

                                            $imgGalFull = wp_get_attachment_image_src($image, 'full');

                                            $imgGalThum  = aq_resize( $imgGalFull[0], '150', '115', true, true, true);

                                            echo '<div class="col-md-3"><a href="' . $imgGalFull[0] . '" class="galImgFull" rel="prettyPhoto[gallery2]"><img src="' . $imgGalThum . '" alt=""></a></div>';

                                        }

                                        ?>

                                    </div>

                                </div>

                            </div>

                            <?php

                        }

                    }

                    ?>

                    <div class="lp-review-right-bottom">

                        <?php echo esc_html__('Was this review ...?', 'listingpro'); ?>

                        <a href="#" data-restype="<?php echo $interVal; ?>" data-reacted ="<?php echo $reacted_msg; ?>" data-id="<?php the_ID(); ?>" data-score="<?php echo esc_attr($interests); ?>" class="review-interesting review-reaction"><i class="fa fa-thumbs-o-up"></i><span class="react-msg"></span> <?php esc_html_e('Interesting','listingpro'); ?> <span class="react-count"><?php echo $interests; ?></span></a>

                        <a href="#" data-restype="<?php echo $lolVal; ?>" data-reacted ="<?php echo $reacted_msg; ?>" data-id="<?php the_ID(); ?>" data-score="<?php echo esc_attr($Lols); ?>" class="review-lol review-reaction"><i class="fa fa-smile-o"></i> <span class="react-msg"></span> <span class="react-msg"></span><?php esc_html_e('LOL','listingpro'); ?> <span class="react-count"><?php echo $Lols; ?></span></a>

                        <a href="#" data-restype="<?php echo $loveVal; ?>" data-reacted ="<?php echo $reacted_msg; ?>" data-id="<?php the_ID(); ?>" data-score="<?php echo esc_attr($loves); ?>" class="review-love review-reaction"><i class="fa fa-heart-o"></i><span class="react-msg"></span> <span class="react-msg"></span><?php esc_html_e('Love','listingpro'); ?> <span class="react-count"><?php echo $loves; ?></span></a>

                        <?php

                        if( $showReport == true && is_user_logged_in() ):

                            ?>

                            <a id="lp-report-this-review" href="#" class="review-love" data-postid="<?php echo get_the_ID(); ?>"  data-reportedby="<?php echo $currentUserId; ?>" data-posttype="reviews"><i class="fa fa-flag" aria-hidden="true"></i> <?php esc_html_e('Report','listingpro'); ?></a>

                            <?php

                        endif;

                        ?>

                    </div>

                </div>

            </div>

            <div class="clearfix"></div>

        </div>

        <?php

    }

}



/* ============== ListingPro Price Range Symbol ============ */

if( !function_exists('listing_price_range_symbol' ) )

{

    function listing_price_range_symbol( $postid )

    {

        $priceRange = listing_get_metabox_by_ID('price_status', $postid);

        $listingpTo = listing_get_metabox('list_price_to');

        $listingprice = listing_get_metabox_by_ID('list_price', $postid);

        $return =   array();

        $dollars = '';

        $tip = '';

        if( ($priceRange != 'notsay' && !empty($priceRange)) || !empty($listingpTo) || !empty($listingprice) )

        {

            if( $priceRange == 'notsay' )

            {

                $dollars = '';

                $tip = '';



            }

            elseif( $priceRange == 'inexpensive' )

            {

                $dollars = '1';

                $tip = esc_html__('Inexpensive', 'listingpro');



            }

            elseif( $priceRange == 'moderate' )

            {

                $dollars = '2';

                $tip = esc_html__('Moderate', 'listingpro');



            }

            elseif( $priceRange == 'pricey' )

            {

                $dollars = '3';

                $tip = esc_html__('Pricey', 'listingpro');



            }

            elseif ( $priceRange == 'ultra_high_end' )

            {

                $dollars = '4';

                $tip = esc_html__('Ultra High End', 'listingpro');

            }



            global $listingpro_options;

            $lp_priceSymbol = $listingpro_options['listing_pricerange_symbol'];

            $return['dollars']  =   $dollars;

            $return['symbol']   =   $lp_priceSymbol;

            $return['tip']      =   $tip;



            return $return;

        }

    }

}



/* ============== ListingPro Price Range ============ */

if( !function_exists('listing_price_range' ) )

{

    function listing_price_range( $postid )

    {

        $listingpTo = listing_get_metabox('list_price_to');

        $listingprice = listing_get_metabox_by_ID('list_price', $postid);



        if( is_singular( 'listing' ) )

        {

            if( !empty( $listingpTo ) || !empty( $listingprice ) )

            {

                echo '<span class="lp-listing-price-range">';

                if( !empty( $listingprice ) )

                {

                    echo esc_html($listingprice);

                }

                if(!empty( $listingpTo ) )

                {

                    echo ' - ';

                    echo esc_html($listingpTo);

                }

                echo '</span>';

            }

        }

        else

        {

            if( !empty( $listingpTo ) || !empty( $listingprice ) )

            {

                $currency  =   listing_price_range_symbol(get_the_ID());



                echo '<div class="lp-listing-price-range">';

                echo '<span class="lp-listing-price-range-currency">'. $currency['symbol'] .'</span>';

                echo '<span class="lp-listing-price-range-text">';

                if( !empty( $listingprice ) )

                {

                    echo esc_html($listingprice);

                }

                if(!empty( $listingpTo ) )

                {

                    echo ' - ';

                    echo esc_html($listingpTo);

                }

                echo '</span>';

                echo '</div>';

            }

        }



    }

}



/* ============== ListingPro sidebar extra fields ============ */

if( !function_exists('listing_all_extra_fields_v2_right' ) )

{

    function listing_all_extra_fields_v2_right( $postid )

    {

        $output = '';

        $count = 1;

        $metaboxes = get_post_meta($postid, 'lp_' . strtolower(THEMENAME) . '_options_fields', true);

        if( !empty( $metaboxes ) )

        {

            unset( $metaboxes['lp_feature'] );

            $bottom35   =   '';

            if( !empty( $metaboxes ) )

            {

                $numberOF = count($metaboxes);

                if( $numberOF > 5 )

                {

                    $bottom35   =   'bottom35';

                }

                $output = null;

                $output .= '<div class="lp-listing-additional-details lp-widget-inner-wrap '. $bottom35 .'">';

                $output .= '  <h4>'. esc_html__('Additional Details', 'listingpro') .'</h4>';

                $output .= '<ul>';



                foreach( $metaboxes as $slug => $value )

                {

                    $queried_post = get_page_by_path( $slug,OBJECT,'form-fields' );

                    if( !empty( $queried_post ) )

                    {

                        $dieldsID = $queried_post->ID;

                        if( is_array( $value ) )

                        {

                            $value = implode(', ', $value);

                        }

                        if( !empty( $value ) && $value == 'Yes' || $value == 'yes' )

                        {

                            $value  =   '<i class="fa fa-check" aria-hidden="true"></i>';

                        }

                        if(!empty($value)){

                            $output .= '<li><label>'.get_the_title($dieldsID).'</label><span>'.$value.'</span></li>';

                        }

                    }

                    if( $count == 5 ) break;

                    $count++;

                }

                $output .= '</ul>';

                if( $numberOF > 5 )

                {

                    $count = 1;

                    $output .=  '<ul class="additional-detail-hidden">';

                    foreach( $metaboxes as $slug => $value )

                    {

                        if( $count > 5 )

                        {

                            $queried_post = get_page_by_path( $slug,OBJECT,'form-fields' );

                            if( !empty( $queried_post ) )

                            {

                                $dieldsID = $queried_post->ID;

                                if( is_array( $value ) )

                                {

                                    $value = implode(', ', $value);

                                }

                                if( !empty( $value ) && $value == 'Yes' || $value == 'yes' )

                                {

                                    $value  =   '<i class="fa fa-check" aria-hidden="true"></i>';

                                }

                                if(!empty($value)){

                                    $output .= '<li><label>'.get_the_title($dieldsID).'</label><span>'.$value.'</span></li>';

                                }

                            }

                        }

                        $count++;

                    }

                    $output .=  '</ul>';

                    $output .=  '<button data-contract="'. esc_html__( 'Contract', 'listingpro' ) .'" data-expand="'. esc_html__( 'Expand', 'listingpro' ) .'" class="toggle-additional-details"><i class="fa fa-plus" aria-hidden="true"></i> '. esc_html__('Expand', 'listingpro') .'</button>';

                }

                $output .=  '</div>';

            }



            return $output;

        }



    }

}

if( !function_exists('listing_all_extra_fields_v2') )

{

function listing_all_extra_fields_v2( $postid )

    {

        $output = '';

        $count = 0;

        $metaboxes = get_post_meta($postid, 'lp_' . strtolower(THEMENAME) . '_options_fields', true);

        if( !empty($metaboxes ) )

        {

            unset( $metaboxes['lp_feature'] );
            if(!empty($metaboxes)){

                $numberOF = count( $metaboxes );

                $output = null;
                $output .=  '<h4 class="lp-detail-section-title">'. esc_html__('Additional Details', 'listingpro') .'</h4>';
                $output .= '<div class="lp-listing-specs">';
                $output .= '<ul>';



                foreach( $metaboxes as $slug => $value )

                {

                        $queried_post = get_page_by_path( $slug,OBJECT,'form-fields' );

                        if( !empty($queried_post ) )

                        {

                            $dieldsID = $queried_post->ID;

                            if( is_array( $value ) )

                            {

                                $value = implode(', ', $value);

                            }

                            if( !empty( $value ) )

                            {

                                $output .= '<li><label>'.get_the_title($dieldsID).'</label><span>'.$value.'</span></li>';

                            }

                        }

                    }



                $output .= '</ul>';

                $output .= '<div class="clearfix"></div></div>';

                // closing

            }

            return $output;

        }

    }

}



/* ============== Listingpro Sharing ============ */

if( !function_exists('listingpro_sharing_v2' ) )

{

    function listingpro_sharing_v2()

    {

        ?>

        <a href="" class="lp-single-sharing"><i class="fa fa-share-alt" aria-hidden="true"></i> <?php echo esc_html__('Share', 'listingpro');?></a>

        <div class="md-overlay hide"></div>

        <div class="social-icons post-socials smenu">

            <div>

                <a href="<?php echo listingpro_social_sharing_buttons('facebook'); ?>" target="_blank"><!-- Facebook icon by Icons8 -->

                    <i class="fa fa-facebook"></i>

                </a>

            </div>

            <div>

                <a href="<?php echo listingpro_social_sharing_buttons('gplus'); ?>" target="_blank"><!-- Google Plus icon by Icons8 -->

                    <i class="fa fa-google-plus"></i>

                </a>

            </div>

            <div>

                <a href="<?php echo listingpro_social_sharing_buttons('twitter'); ?>" target="_blank"><!-- twitter icon by Icons8 -->

                    <i class="fa fa-twitter"></i>

                </a>

            </div>

            <div>

                <a href="<?php echo listingpro_social_sharing_buttons('linkedin'); ?>" target="_blank"><!-- linkedin icon by Icons8 -->

                    <i class="fa fa-linkedin"></i>

                </a>

            </div>

            <div>

                <a href="<?php echo listingpro_social_sharing_buttons('pinterest'); ?>" target="_blank"><!-- pinterest icon by Icons8 -->

                    <i class="fa fa-pinterest"></i>

                </a>

            </div>

            <div>

                <a href="<?php echo listingpro_social_sharing_buttons('reddit'); ?>" target="_blank"><!-- reddit icon by Icons8 -->

                    <i class="fa fa-reddit"></i>

                </a>

            </div>

            <div>

                <a href="<?php echo listingpro_social_sharing_buttons('stumbleupon'); ?>" target="_blank"><!-- stumbleupon icon by Icons8 -->

                    <i class="fa fa-stumbleupon"></i>

                </a>

            </div>

            <div>

                <a href="<?php echo listingpro_social_sharing_buttons('del'); ?>" target="_blank"><!-- delicious icon by Icons8 -->

                    <i class="fa fa-delicious"></i>

                </a>

            </div>

            <div class="clearfix"></div>

        </div>

        <?php

    }

}



/* ============== is favourite or not only ============ */

if ( !function_exists('listingpro_is_favourite_v2' ) )

{

    function listingpro_is_favourite_v2( $postid )

    {

        $favposts = ( isset( $_COOKIE['newco'] ) ) ? explode(',', (string) $_COOKIE['newco']) : array();

        $favposts = array_map('absint', $favposts); // Clean cookie input, it's user input!

        $return =   'no';

        if ( in_array( $postid,$favposts  ) )

        {

            $return =   'yes';

        }

        return $return;

    }

}



/* ============== ListingPro Add to favorite ============ */

add_action('wp_ajax_listingpro_add_favorite_v2',        'listingpro_add_favorite_v2');

add_action('wp_ajax_nopriv_listingpro_add_favorite_v2', 'listingpro_add_favorite_v2');



if( !function_exists('listingpro_add_favorite_v2' ) )

{

    function listingpro_add_favorite_v2()

    {

        // Load current favourite posts from cookie

        $favposts = (isset($_COOKIE['newco'])) ? explode(',', (string) $_COOKIE['newco']) : array();

        $favposts = array_map('absint', $favposts); // Clean cookie input, it's user input!



        // Add (or remove) favourite post IDs

        $favposts[] = $_POST['post-id'];

        $type = $_POST['type'];



        //$path = parse_url(get_option('siteurl'), PHP_URL_PATH);

        //$host = parse_url(get_option('siteurl'), PHP_URL_HOST);

        // Update cookie with new favourite posts

        $time_to_live = 3600 * 24 * 30; // 30 days

        setcookie('newco', implode(',', array_unique($favposts)), time() + $time_to_live ,"/");



        $done = json_encode(array("type"=>$type,"active"=>'yes',"id"=>$favposts, 'text' => esc_html__('Saved', 'listingpro')));

        die($done);



    }

}



/* ============== ListingPro Remove from favorite ============ */

add_action('wp_ajax_listingpro_remove_favorite_v2',        'listingpro_remove_favorite_v2');

add_action('wp_ajax_nopriv_listingpro_remove_favorite_v2', 'listingpro_remove_favorite_v2');



if( !function_exists('listingpro_remove_favorite_v2' ) )

{

    function listingpro_remove_favorite_v2()

    {

        // Load current favourite posts from cookie

        $favposts = (isset($_COOKIE['newco'])) ? explode(',', (string) $_COOKIE['newco']) : array();

        $favposts = array_map('absint', $favposts); // Clean cookie input, it's user input!



        // Add (or remove) favourite post IDs

        $favpostsd = $_POST['post-id'];

        $type = $_POST['type'];

        foreach( $favposts as $index => $value)

        {

            if($value == $favpostsd)

            {

                unset($favposts[$index]);

            }



        }





        //$path = parse_url(get_option('siteurl'), PHP_URL_PATH);

        //$host = parse_url(get_option('siteurl'), PHP_URL_HOST);

        // Update cookie with new favourite posts

        $time_to_live = 3600 * 24 * 30; // 30 days

        setcookie('newco', implode(',', array_unique($favposts)), time() + $time_to_live ,"/");



        $done = json_encode(array("type"=>$type, "remove"=>'yes',"id"=>$favposts, 'text'=> esc_html__('Save', 'listingpro')));

        die($done);



    }

}


/* ============== ListingPro add announcement ============ */

add_action('wp_ajax_add_announcements_cb', 'add_announcements_cb');
add_action('wp_ajax_nopriv_add_announcements_cb', 'add_announcements_cb');
if( !function_exists('add_announcements_cb') )

{

function add_announcements_cb()

    {
        $return                     =   array();
        $lp_listing_announcements   =   array();

        $user_id    =   get_current_user_id();
        $user_idd   =   $_POST['user_id'];

        $announcement_data['annMsg']    =   $_POST['annMsg'];
        $announcement_data['annBT']    =   $_POST['annBT'];
        $announcement_data['annBL']    =   $_POST['annBL'];
        $announcement_data['annLI']    =   $_POST['annLI'];
        $announcement_data['annSt']    =   $_POST['annSt'];
        $announcement_data['annTI']    =   $_POST['annTI'];
        $announcement_data['annType']    =   $_POST['annType'];
        $announcement_data['annIC']    =   $_POST['annIC'];
        $announcement_data['annStatus']    =   1;

        $annUP      =   $_POST['annUP'];
        $annID      =   $_POST['annID'];
        $annLI      =   $_POST['annLI'];

        if( $user_id != $user_idd )
        {
            $return['status']   =   'error';
            $return['msg']      =   esc_html__('Invalid User Session', 'listingpro');
            die( json_encode( $return ) );

        }

        if( $annID != '' && $annUP == 'yes' )
        {
            $annID_arr  =   explode( '-', $annID );
            $ann_index  =   $annID_arr[1];
            $existing_data  =   get_post_meta( $annLI, 'lp_listing_announcements', true );

            $existing_data[$ann_index]['annMsg']    =   $_POST['annMsg'];
            $existing_data[$ann_index]['annBT']    =   $_POST['annBT'];
            $existing_data[$ann_index]['annBL']    =   $_POST['annBL'];
            $existing_data[$ann_index]['annSt']    =   $_POST['annSt'];
            $existing_data[$ann_index]['annTI']    =   $_POST['annTI'];
            $existing_data[$ann_index]['annType']    =   $_POST['annType'];
            $existing_data[$ann_index]['annIC']    =   $_POST['annIC'];

            update_post_meta( $annLI, 'lp_listing_announcements', $existing_data );

            $return['status'] = 'success';
            $return['msg'] = esc_html__('Announcement updated', 'listingpro');


            die(json_encode($return));

        }
        elseif ( $annID != '' && $annUP == 'on-off' )
        {
            $annID_arr  =   explode( '-', $annID );
            $ann_index  =   $annID_arr[1];
            $status =   $_POST['status'];
            if( $status ==  'active' )
            {
                $status =   0;
            }
            elseif ( $status == 'inactive' )
            {
                $status =   1;
            }
            $existing_data  =   get_post_meta( $annID_arr[0], 'lp_listing_announcements', true );
            $target_data    =   $existing_data[$ann_index];

            $existing_data[$ann_index]['annStatus']    =   $status;

            update_post_meta( $annID_arr[0], 'lp_listing_announcements', $existing_data );

            $return['status'] = $status;
            die(json_encode($return));

        }

        else

        {

            $checkStatus = lp_validate_listing_action($annLI, 'announcment');
            if(empty($checkStatus)){
                $return['status']   =   'error';
                $return['msg']      =   esc_html__( 'Announcements are not allowed with this listing', 'listingpro' );
                die( json_encode( $return ) );
            }

            $data_arr[] =   $announcement_data;
            $existing_data  =   get_post_meta( $annLI, 'lp_listing_announcements', true );

            if( is_array( $existing_data ) && !empty( $existing_data ) )

            {

                $new_data   =   array_merge( $existing_data, $data_arr );
                update_post_meta( $annLI, 'lp_listing_announcements', $new_data );

                $return['status'] = 'success';
                $return['msg'] = esc_html__( 'Announcement added successfully', 'listingpro' );

                die(json_encode($return));

            }
            else
            {
                update_post_meta( $annLI, 'lp_listing_announcements', $data_arr );
                $return['status'] = 'success';
                $return['msg'] = esc_html__( 'Announcement added successfully', 'listingpro' );

                die(json_encode($return));
            }

        }

    }

}



/* ============== ListingPro add Offers ============ */

add_action('wp_ajax_add_offer_cb', 'add_offer_cb');

add_action('wp_ajax_nopriv_add_offer_cb', 'add_offer_cb');



if( !function_exists( 'add_offer_cb' ) )

{

    function add_offer_cb()

    {

        $user_id    =   get_current_user_id();

        $user_idd   =   $_POST['user_id'];



        $listing_offer_data['offerTitle']     =   $_POST['offerTitle'];

        $listing_offer_data['offerDes']     =   $_POST['offerDes'];

        $listing_offer_data['offerExp']      =   strtotime( $_POST['offerExp'] );

        $listing_offer_data['offerBT']      =   $_POST['offerBT'];

        $listing_offer_data['offerBL']      =   $_POST['offerBL'];

        $listing_offer_data['offerLI']     =   $_POST['offerLI'];

        $listing_offer_data['offerImg']     =   $_POST['offerImg'];



        $offerID      =   $_POST['offerID'];

        $offerUP      =   $_POST['offerUP'];



        if( $user_id != $user_idd )

        {

            $return['status']   =   'error';

            $return['msg']      =   esc_html__('Invalid User Session', 'listingpro');

            die( json_encode( $return ) );

        }

        $data_arr[] =   $listing_offer_data;

        if( $offerUP == 'yes' && $offerID != '' )

        {

            $offerID_arr        =   explode( '-', $offerID );



            $existing_offers    =   get_post_meta( $offerID_arr[1], 'lp_listing_offers', true );

            $listing_offer_data['offerImg']  =   $existing_offers[$offerID_arr[0]]['offerImg'];



            $existing_offers[$offerID_arr[0]]   =   $listing_offer_data;



            update_post_meta( $offerID_arr[1], 'lp_listing_offers', $existing_offers );

            $return['status']   =   'success';

            $return['msg']      =   esc_html__('offer updated', 'listingpro');



            die( json_encode( $return ) );

        }

        else

        {

            $existing_offers                =   get_post_meta( $_POST['offerLI'], 'lp_listing_offers', true );

            if( $existing_offers != '' && $existing_offers != false )

            {

                $new_data   =   array_merge( $existing_offers, $data_arr );

                update_post_meta( $_POST['offerLI'], 'lp_listing_offers', $new_data );



                $return['status']   =   'success';

                $return['msg']      =   esc_html__('offer added', 'listingpro');

                die( json_encode( $return ) );

            }

            else

            {

                update_post_meta( $_POST['offerLI'], 'lp_listing_offers', $data_arr );



                $return['status']   =   'success';

                $return['msg']      =   esc_html__('offer added', 'listingpro');

                die( json_encode( $return ) );

            }

        }

        $return['status']   =   'error';

        $return['msg']      =   esc_html__('Something went wrong', 'listingpro');

        die( json_encode( $return ) );

    }

}





add_action('wp_ajax_add_menu_type_cb', 'add_menu_type_cb');

add_action('wp_ajax_nopriv_add_menu_type_cb', 'add_menu_type_cb');



if( !function_exists( 'add_menu_type_cb' ) )

{

    function add_menu_type_cb()

    {

        $user_id        =   get_current_user_id();

        $user_idd       =   $_POST['user_id'];



        $type_data['type']    =   $_POST['type'];

        $data_arr[] =   $type_data;



        if( $user_id != $user_idd )

        {

            $return['status']   =   'error';

            $return['msg']      =   esc_html__('Invalid User Session', 'listingpro');

            die( json_encode( $return ) );

        }



        $existing_data  =   get_user_meta( $user_id, 'user_menu_types', true );

        if( is_array( $existing_data ) && !empty( $existing_data ) )

        {

            $new_data   =   array_merge( $existing_data, $data_arr );

            update_user_meta( $user_id, 'user_menu_types', $new_data );

            $return['status']   =   'success';

            $return['msg']      =   esc_html__('Something went wrong', 'listingpro');

            die( json_encode( $return ) );

        }

        else

        {

            update_user_meta( $user_id, 'user_menu_types', $data_arr );

            $return['status']   =   'success';

            $return['msg']      =   esc_html__('Something went wrong', 'listingpro');

            die( json_encode( $return ) );

        }

    }

}





add_action('wp_ajax_add_menu_group_cb', 'add_menu_group_cb');

add_action('wp_ajax_nopriv_add_menu_group_cb', 'add_menu_group_cb');



if( !function_exists( 'add_menu_group_cb' ) )

{

    function add_menu_group_cb()

    {

        $user_id        =   get_current_user_id();

        $user_idd       =   $_POST['user_id'];



        $type_data['group']    =   $_POST['group'];

        $data_arr[] =   $type_data;



        if( $user_id != $user_idd )

        {

            $return['status']   =   'error';

            $return['msg']      =   esc_html__('Invalid User Session', 'listingpro');

            die( json_encode( $return ) );

        }



        $existing_data  =   get_user_meta( $user_id, 'user_menu_groups', true );

        if( is_array( $existing_data ) && !empty( $existing_data ) )

        {

            $new_data   =   array_merge( $existing_data, $data_arr );

            update_user_meta( $user_id, 'user_menu_groups', $new_data );

            $return['status']   =   'success';

            $return['msg']      =   esc_html__('Something went wrong', 'listingpro');

            die( json_encode( $return ) );

        }

        else

        {

            update_user_meta( $user_id, 'user_menu_groups', $data_arr );

            $return['status']   =   'success';

            $return['msg']      =   esc_html__('Something went wrong', 'listingpro');

            die( json_encode( $return ) );

        }

    }

}



add_action('wp_ajax_add_menu_cb', 'add_menu_cb');
add_action('wp_ajax_nopriv_add_menu_cb', 'add_menu_cb');
if( !function_exists( 'add_menu_cb' ) )

{
	function add_menu_cb()
	{
		$user_id        =   get_current_user_id();
		$user_idd       =   $_POST['user_id'];
		$data_arr       =   array();

		if( isset( $_POST['menuUp'] ) && $_POST['menuUp'] == 'yes' )
		{
			$mTitle    =   esc_html( $_POST['mTitle'] );
			$mDetail    =   esc_html( $_POST['mDetail'] );
			$mOldPrice    =   $_POST['mOldPrice'];
			$mNewPrice    =   $_POST['mNewPrice'];
			$mQuoteT    =   $_POST['mQuoteT'];
			$mQuoteL    =   $_POST['mQuoteL'];
			$mLink    =   $_POST['mLink'];
			$menuID    =   $_POST['menuID'];
			$LID    =   $_POST['LID'];
			$mImage    =   $_POST['mImage'];
			$mType  =   $_POST['mType'];
			$mGroup  =   $_POST['mGroup'];

			$menuID_arr     =   explode( '_', $menuID );
			$menu_type      =   str_replace( '-', ' ', $menuID_arr[0]);
			$menu_group     =   str_replace( '-', ' ', $menuID_arr[1]);
			$menu_indx      =   $menuID_arr[2];

		}
		else
		{
			$menu_data['mTitle']    =   esc_html( $_POST['mTitle'] );
			$menu_data['mDetail']    =   esc_html( $_POST['mDetail'] );
			$menu_data['mOldPrice']    =   $_POST['mOldPrice'];
			$menu_data['mNewPrice']    =   $_POST['mNewPrice'];
			$menu_data['mQuoteL']    =   $_POST['mQuoteL'];
			$menu_data['mQuoteT']    =   $_POST['mQuoteT'];
			$menu_data['mListing']    =   $_POST['mListing'];
			$menu_data['mLink']    =   $_POST['mLink'];
			$menu_data['mImage']    =   $_POST['mImage'];
			$menu_data['mType']    =   $_POST['mType'];
			$menu_data['mGroup']    =   $_POST['mGroup'];

		}

		if( $user_id != $user_idd )

		{
			$return['status']   =   'error';
			$return['msg']      =   esc_html__('Invalid User Session', 'listingpro');
			die( json_encode( $return ) );
		}

		if( isset( $_POST['menuUp'] ) && $_POST['menuUp'] == 'yes' )
		{
			$existing_menus     =   get_post_meta( $LID, 'lp-listing-menu', true );
			$target_arr =   $existing_menus[$menu_type][$menu_group][$menu_indx];

			if( $menu_type == $_POST['mType'] && $menu_group == $_POST['mGroup'] )
			{
				$target_arr['mDetail']  = $mDetail;
				$target_arr['mTitle']   =   $mTitle;
				$target_arr['mNewPrice']    =   $mNewPrice;
				$target_arr['mOldPrice']    =   $mOldPrice;
				$target_arr['mQuoteT']    =   $mQuoteT;
				$target_arr['mQuoteL']    =   $mQuoteL;
				$target_arr['mLink']    =   $mLink;
				$target_arr['mImage']    =   $mImage;

				$existing_menus[$menu_type][$menu_group][$menu_indx]    =   $target_arr;
				update_post_meta( $LID, 'lp-listing-menu', $existing_menus );

				$return['status']   =   'success';
				$return['msg']      =   esc_html__('Menu item updated successfully', 'listingpro');
				die( json_encode( $return ) );
			}
			else
			{

				unset( $existing_menus[$menu_type][$menu_group][$menu_indx] );
				$group_count =   count( $existing_menus[$menu_type][$menu_group] );
				if( $group_count == 0 )
				{
					unset( $existing_menus[$menu_type][$menu_group] );
				}

				$type_count =  count( $existing_menus[$menu_type] );

				if( $type_count == 0 )
				{
					unset( $existing_menus[$menu_type] );

				}

				$new_menu_data_arr  =   array();
				$new_menu_data_arr['mDetail']  = $mDetail;
				$new_menu_data_arr['mTitle']   =   $mTitle;
				$new_menu_data_arr['mNewPrice']    =   $mNewPrice;
				$new_menu_data_arr['mOldPrice']    =   $mOldPrice;
				$new_menu_data_arr['mQuoteT']    =   $mQuoteT;
				$new_menu_data_arr['mQuoteL']    =   $mQuoteL;
				$new_menu_data_arr['mLink']    =   $mLink;
				$new_menu_data_arr['mImage']    =   $mImage;
				$new_menu_data_arr['mListing']    =   $LID;
				$new_menu_data_arr['mGroup']    =   $mGroup;
				$new_menu_data_arr['mType']    =   $mType;

				$existing_menus[$_POST['mType']][$_POST['mGroup']][]    =   $new_menu_data_arr;
				update_post_meta( $LID, 'lp-listing-menu', $existing_menus );

				$return['status']   =   'success';
				$return['msg']      =   esc_html__('Menu item updated successfully', 'listingpro');
				die( json_encode( $return ) );
			}

		}
		else
		{
			$checkStatus = lp_validate_listing_action($_POST['mListing'], 'menu');
			if(empty($checkStatus)){
				$return['status']   =   'error';
				$return['msg']      =   'Event not   with this listing';
				die( json_encode( $return ) );
			}
			$existing_menus     =   get_post_meta( $_POST['mListing'], 'lp-listing-menu', true );
			if( is_array( $existing_menus ) && !empty( $existing_menus ) )
			{
				if( is_array( $_POST['mType'] ) )
				{
					foreach ( $_POST['mType'] as $k => $v )
					{
						if( is_array( $_POST['mGroup'] ) )
						{
							foreach ( $_POST['mGroup'] as $mGroup )
							{
								$data_arr[$v][$mGroup][]   =   $menu_data;
							}
						}
						else
						{
							$data_arr[$v][$menu_data['mGroup']][]   =   $menu_data;
						}

					}
				}
				$new_data   =   array_merge_recursive( $existing_menus, $data_arr );

				update_post_meta( $_POST['mListing'], 'lp-listing-menu', $new_data );

				$return['status']   =   'success';
				$return['msg']      =   esc_html__('Menu item added successfully', 'listingpro');
				$return['data'] =   $new_data;
				die( json_encode( $return ) );

			}
			else
			{
				if( is_array( $_POST['mType'] ) )
				{
					foreach ( $_POST['mType'] as $k => $v )
					{
						if( is_array( $_POST['mGroup'] ) )
						{
							foreach ( $_POST['mGroup'] as $mGroup )
							{
								$data_arr[$v][$mGroup][]   =   $menu_data;
							}
						}
						else
						{
							$data_arr[$v][$menu_data['mGroup']][]   =   $menu_data;
						}

					}
				}
				update_post_meta( $_POST['mListing'], 'lp-listing-menu', $data_arr );

				$return['status']   =   'success';
				$return['msg']      =   esc_html__('Menu item added successfully', 'listingpro');
				$return['data']      =   $data_arr;
				die( json_encode( $return ) );
			}
		}



	}

}





/* ============== ListingPro add Discount codes ============ */

add_action('wp_ajax_add_discount_cb', 'add_discount_cb');
add_action('wp_ajax_nopriv_add_discount_cb', 'add_discount_cb');

if( !function_exists( 'add_discount_cb' ) )
{
    function add_discount_cb()

    {

        $return                 =   array();
        $listing_discount_data  =   array();

        $user_id    =   get_current_user_id();
        $user_idd   =   $_POST['user_id'];

        $listing_discount_data['disHea']     =   $_POST['disHea'];
        $listing_discount_data['disCod']     =   $_POST['disCod'];
        $listing_discount_data['disExpS']     =   strtotime( $_POST['disExpS'] );
        $listing_discount_data['disExpE']     =   strtotime( $_POST['disExpE'] );
        $listing_discount_data['disBT']      =   $_POST['disBT'];
        $listing_discount_data['disBL']      =   $_POST['disBL'];
        $listing_discount_data['disLI']      =   $_POST['disLI'];
        $listing_discount_data['disDes']     =   $_POST['disDes'];
        $listing_discount_data['disID']      =   $_POST['disID'];
        $listing_discount_data['disImg']      =   $_POST['disImg'];
        $listing_discount_data['disOff']      =   $_POST['disOff'];
        $listing_discount_data['disSta']      =   $_POST['disSta'];

        $listing_id    =   $listing_discount_data['disLI'];
        if( $listing_id == '' || $listing_id == null )
        {
            $listing_id =  $listing_discount_data['disID'];
        }
        if( $user_id != $user_idd )
        {
            $return['status']   =   'error';
            $return['msg']      =   esc_html__('Invalid User Session', 'listingpro');
            die( json_encode( $return ) );
        }

        $disUp      =   $_POST['disUp'];
        if( $disUp == 'yes' )
        {
            $disID_arr  =   explode( '-', $_POST['disID'] );
            $data_index =   $disID_arr[1];

            $existing_data  =   get_post_meta( $listing_id, 'listing_discount_data', true );

            $existing_data[$data_index]['disHea']     =   $_POST['disHea'];
            $existing_data[$data_index]['disCod']     =   $_POST['disCod'];
            $existing_data[$data_index]['disExpS']     =   strtotime( $_POST['disExpS'] );
            $existing_data[$data_index]['disExpE']     =   strtotime( $_POST['disExpE'] );
            $existing_data[$data_index]['disBT']      =   $_POST['disBT'];
            $existing_data[$data_index]['disBL']      =   $_POST['disBL'];
            $existing_data[$data_index]['disDes']     =   $_POST['disDes'];
            $existing_data[$data_index]['disOff']      =   $_POST['disOff'];
			$existing_data[$data_index]['disImg']      =   $_POST['disImg'];

            update_post_meta( $listing_id, 'listing_discount_data', $existing_data );

            $return['status']   =   'success';
			 $return['msg']      =   esc_html__('Coupon Updated successfully', 'listingpro');
            die( json_encode( $return ) );
        }
        else
        {
            $checkStatus = lp_validate_listing_action($listing_id, 'deals');
            if(empty($checkStatus)){
                $return['status']   =   'error';
                $return['msg']      =   esc_html__( 'Coupons are not allowed with this listing', 'listingpro' );
                die( json_encode( $return ) );
            }

            $data_arr[]   = $listing_discount_data;
            $existing_data  =   get_post_meta( $listing_id, 'listing_discount_data', true );
            if( is_array( $existing_data ) && !empty( $existing_data ) )
            {
                $new_data   =   array_merge( $existing_data, $data_arr );
                update_post_meta( $listing_id, 'listing_discount_data', $new_data );
                $return['status']   =   'success';
                $return['msg']      =   esc_html__('Coupon Created successfully', 'listingpro');
                die( json_encode( $return ) );
            }
            else
            {
                update_post_meta( $listing_id, 'listing_discount_data', $data_arr );
                $return['status']   =   'success';
                $return['msg']      =   esc_html__('Coupon Created successfully', 'listingpro');
                die( json_encode( $return ) );
            }
        }
        $return['status']   =   'success';
        $return['msg']      =   esc_html__('Coupon Created successfully', 'listingpro');
        $return['discount_Data']      =   $listing_discount_data['disID'];
        die( json_encode( $return ) );
    }
}



/* ============== Listingpro delete announcements/Discount Codes ============ */
add_action('wp_ajax_del_ann_dis_menu_cb', 'del_ann_dis_menu_cb');
add_action('wp_ajax_nopriv_del_ann_dis_menu_cb', 'del_ann_dis_menu_cb');
if( !function_exists( 'del_ann_dis_menu_cb' ) )

{

	function del_ann_dis_menu_cb()

	{

		$return =   array();



		$user_id        =   get_current_user_id();
		$user_idd       =   $_POST['user_id'];

		$delType        =   $_POST['delType'];
		$targetID       =   $_POST['targetID'];
		$delIDS         =   $_POST['delIDS'];



		if( $user_id != $user_idd )

		{

			$return['status']   =   'error';

			$return['msg']      =   esc_html__('Invalid User Session', 'listingpro');

			die( json_encode( $return ) );

		}
		if( $delType == 'event' )
		{
			$eLID   =   get_post_meta( $targetID, 'event-lsiting-id', true );

			delete_post_meta( $eLID, 'event_id' );
			wp_delete_post( $targetID, true );

			$return['status'] = 'success';
			$return['msg'] = esc_html__('Data deleted', 'listingpro');

			die(json_encode($return));
		}
		if( $delType == 'dis' )
		{

			$targetID_arr       =   explode( '-', $targetID );
			$target_index       =   $targetID_arr[1];
			$target_listing     =   $targetID_arr[0];

			$target_data    =   get_post_meta( $target_listing, 'listing_discount_data', true );
			unset( $target_data[$target_index] );
			if( count( $target_data ) == 0 )
			{
				delete_post_meta( $target_listing, 'listing_discount_data' );
			}
			else
			{
				update_post_meta( $target_listing, 'listing_discount_data', $target_data );
			}



			$return['status'] = 'success';

			$return['msg'] = esc_html__('Data deleted', 'listingpro');

			die(json_encode($return));

		}

		if( $delType == 'ann' )

		{

			$targetID_arr       =   explode( '-', $targetID );

			$target_index       =   $targetID_arr[1];

			$target_listing     =   $targetID_arr[0];



			$existing_data  =   get_post_meta( $target_listing, 'lp_listing_announcements', true );

			unset( $existing_data[$target_index] );

			$remaining  =   count( $existing_data );



			if( $remaining == 0 )

			{

				delete_post_meta( $target_listing, 'lp_listing_announcements' );

			}

			else

			{

				update_post_meta( $target_listing, 'lp_listing_announcements', $existing_data );

			}



			$return['status'] = 'success';

			$return['msg'] = esc_html__('Data deleted', 'listingpro');

			die(json_encode($return));

		}

		if( $delType == 'offer' )

		{

			$delIDS_Arr   =   explode( ',', $delIDS );



			$LID    =   $delIDS_Arr[1];

			$INX    =   $delIDS_Arr[0];

			$lp_listing_offers  =   get_post_meta( $LID, 'lp_listing_offers', true );
			unset( $lp_listing_offers[$INX] );
			if( empty( $lp_listing_offers ) )

			{
				delete_post_meta( $LID, 'lp_listing_offers' );
			}

			else

			{
				update_post_meta( $LID, 'lp_listing_offers', $lp_listing_offers );
			}

			$return['status'] = 'success';
			$return['msg'] = esc_html__('Data deleted', 'listingpro');
			die(json_encode($return));

		}



		if( $delType == 'menu' )

		{

			$menuID_arr     =   explode( '_', $targetID );
			$menu_type      =   str_replace( '-', ' ', $menuID_arr[0]);
			$menu_group     =   str_replace( '-', ' ', $menuID_arr[1]);
			$menu_indx      =   $menuID_arr[2];

			$existing_menus =   get_post_meta( $delIDS, 'lp-listing-menu', true );
			$array1 = count($existing_menus[$menu_type]);
			$array2 =   count($existing_menus[$menu_type][$menu_group]);
			unset( $existing_menus[$menu_type][$menu_group][$menu_indx] );
			$count2 =   count($existing_menus[$menu_type][$menu_group]);

			if( $count2 == 0 )
			{
				unset( $existing_menus[$menu_type][$menu_group] );
			}
			$count1 = count($existing_menus[$menu_type]);
			if( $count1 == 0 )
			{
				unset( $existing_menus[$menu_type] );
			}
			update_post_meta( $delIDS, 'lp-listing-menu', $existing_menus );

			$return['status'] = 'success';
			$return['msg'] = esc_html__('Data deleted', 'listingpro');

			die(json_encode($return));

		}

		if( $delType == 'type' )
		{
			$menu_types_data        =   get_user_meta( $user_id, 'user_menu_types' );
			$del_all                =   $_POST['dellAll'];
			$menu_types_data        =   $menu_types_data[0];
			$type_key               =   $menu_types_data[$targetID]['type'];
			$del_res                =   '';

			if( $del_all == 1 )
			{
				del_menu_data_by_user( $user_id, $delType, $type_key );
			}
			unset( $menu_types_data[$targetID] );
			update_user_meta( $user_id, 'user_menu_types', $menu_types_data );

			$return['status'] = 'success';
			$return['msg'] = esc_html__('Data deleted', 'listingpro');


			die(json_encode($return));
		}

		if( $delType == 'group' )
		{
			$menu_groups_data       =   get_user_meta( $user_id, 'user_menu_groups' );
			$del_all                =   $_POST['dellAll'];
			$menu_groups_data       =   $menu_groups_data[0];
			$group_Key              =   $menu_groups_data[$targetID]['group'];

			if( $del_all == 1 )
			{
				del_menu_data_by_user( $user_id, $delType, $group_Key );
			}
			unset( $menu_groups_data[$targetID] );
			update_user_meta( $user_id, 'user_menu_groups', $menu_groups_data );

			$return['status'] = 'success';
			$return['msg'] = esc_html__('Data deleted', 'listingpro');

			die(json_encode($return));
		}

		$return['status'] = 'fail';
		$return['msg'] = esc_html__('Bad Request', 'listingpro');
		die(json_encode($return));

	}

}


add_action('wp_ajax_del_all_menu_cb', 'del_all_menu_cb');
add_action('wp_ajax_nopriv_del_all_menu_cb', 'del_all_menu_cb');
if( !function_exists( 'del_all_menu_cb' ) )
{
    function del_all_menu_cb()
    {
        $user_id        =   get_current_user_id();
        $user_idd       =   $_POST['user_id'];
        $lid            =   $_POST['lid'];

        if( $user_id != $user_idd )
        {
            $return['status']   =   'error';
            $return['msg']      =   esc_html__('Invalid User Session', 'listingpro');
            die( json_encode( $return ) );
        }
        else
        {
            delete_post_meta( $lid, 'lp-listing-menu' );
            $return['status']   =   'success';
            $return['msg']      =   esc_html__('Menu Items deleted successfully', 'listingpro');
            die( json_encode( $return ) );
        }
    }
}

add_action('wp_ajax_discount_display_area', 'discount_display_area');

add_action('wp_ajax_nopriv_discount_display_area', 'discount_display_area');



if( !function_exists( 'discount_display_area' ) )

{

    function discount_display_area()

    {

        $user_idd   =   get_current_user_id();

        $userID       =   $_POST['userID'];

        $thisval        =   $_POST['thisval'];



        if( $userID != $user_idd )

        {

            $return['status']   =   'error';

            $return['msg']      =   esc_html__('Invalid User Session', 'listingpro');

            die( json_encode( $return ) );

        }

        update_user_meta( $userID, 'discount_display_area', $thisval );

        $return['status'] = 'success';

        $return['msg'] = $thisval.'-'.$userID;

        die(json_encode($return));

    }

}



add_action('wp_ajax_author_review_tab_cb', 'author_review_tab_cb');
add_action('wp_ajax_nopriv_author_review_tab_cb', 'author_review_tab_cb');
//author_review_tab_cb

if( !function_exists( 'author_review_tab_cb' ) )

{
    function author_review_tab_cb()
    {
        $reviewStyle    =   $_POST['reviewStyle'];
        $listID         =   $_POST['listID'];
        $authorID       =   $_POST['authorID'];

        if( $reviewStyle == 'style1' )
        {
            ?>
            <div id="submitreview" class="clearfix">
                <?php
                listingpro_get_all_reviews( $listID );
                ?>
            </div>
            <?php
        }
        else
        {
            ?>
            <div class="lp-listing-reviews">
                <?php
                listingpro_get_all_reviews_v2($GLOBALS['listID']);
                ?>
            </div>
            <?php
        }
        ?>
        <?php

        die();

    }

}



add_action('wp_ajax_author_archive_tabs_cb', 'author_archive_tabs_cb');
add_action('wp_ajax_nopriv_author_archive_tabs_cb', 'author_archive_tabs_cb');
if( !function_exists( 'author_archive_tabs_cb' ) )
{
    function author_archive_tabs_cb()
    {

        $tabType        =   $_POST['tabType'];
        $reviewStyle    =   $_POST['reviewStyle'];
        $authorID       =   $_POST['authorID'];
        $listingLayout       =   $_POST['listingLayout'];
        $GLOBALS['authorID']  =   $authorID;
        if( $tabType == 'reviews' )
        {
            if( $reviewStyle == 'style1' )
            {
                get_template_part( 'templates/author/author-reviews-style1' );
            }
            elseif ( $reviewStyle == 'style2' )
            {
                get_template_part( 'templates/author/author-reviews-style2' );
            }
        }
        elseif ( $tabType == 'photos' )
        {
            get_template_part( 'templates/author/author-photos' );
        }
        elseif ( $tabType == 'aboutme' )
        {
            get_template_part( 'templates/author/author-about' );
        }
        elseif ( $tabType == 'contact' )
        {
            get_template_part( 'templates/author/author-contact' );
        }
        elseif ( $tabType   ==  'mylistings' )
        {
            $GLOBALS['my_listing_views']    =   $listingLayout;
            get_template_part( 'templates/author/author-listings' );
        }

        die();
    }
}







add_action('wp_ajax_author_archive_listings_cb', 'author_archive_listings_cb');

add_action('wp_ajax_nopriv_author_archive_listings_cb', 'author_archive_listings_cb');

if( !function_exists( 'author_archive_listings_cb' ) )

{

    function author_archive_listings_cb()

    {

        $paged        =   $_POST['pageNum'];



        global $listingpro_options;

        $author_list_view   =   'grid_view_v2';

        if( isset( $listingpro_options['my_listing_views'] ) )

            $author_list_view   =   $listingpro_options['my_listing_views'];

        $type = 'listing';

        $postsonpage = '';

        if(isset($listingpro_options['my_listing_per_page'])){

            $postsonpage = $listingpro_options['my_listing_per_page'];

        }

        else{

            $postsonpage = 9;

        }

        $args=array(

            'post_type' => $type,

            'post_status' => 'publish',

            'posts_per_page' => $postsonpage,

            'order' => 'ASC',

            'paged'       => $paged,

            'author' => 1,

        );



        $my_query = null;

        $my_query = new WP_Query($args);





        if( $my_query->have_posts() ) {

            while ($my_query->have_posts()) : $my_query->the_post();

                if( $author_list_view == 'grid_view_v2' )

                {

                    get_template_part( 'layouts/loop-grid-view' );

                }

                elseif ( $author_list_view == 'list_view_v2' )

                {

                    get_template_part( 'layouts/loop-list-view' );

                }

                else

                {

                    get_template_part( 'listing-loop' );

                }



            endwhile;

        }

        echo '<div class="md-overlay"></div>';



        die();

    }

}



/* ============== Listingpro compaigns ============ */

if( !function_exists('listingpro_get_campaigns_listing_v2' ) )

{

    function listingpro_get_campaigns_listing_v2( $ad_style, $campaign_type, $IDSonly, $taxQuery=array(), $searchQuery=array(),$priceQuery=array(),$s=null, $noOfListings = null, $posts_in = null )

    {


        $adsType = array(

            'lp_random_ads',

            'lp_detail_page_ads',

            'lp_top_in_search_page_ads'

        );



        global $listingpro_options;

        $listing_style = '';

        $listing_style = $listingpro_options['listing_style'];

        $postNumber = '';

        if($listing_style == '3' && !is_front_page()){

            if(empty($noOfListings)){

                $postNumber = 2;

            }

            else{

                $postNumber = $noOfListings;

            }



        }else{

            if(empty($noOfListings)){

                $postNumber = 3;

            }

            else{

                $postNumber = $noOfListings;

            }

        }





        if( !empty($campaign_type) ){

            if( in_array($campaign_type, $adsType, true) ){



                $TxQuery = array();

                if( !empty( $taxQuery ) && is_array($taxQuery)){

                    $TxQuery = $taxQuery;

                }elseif(!empty($searchQuery) && is_array($searchQuery)){

                    $TxQuery = $searchQuery;

                }

                $args = array(

                    'orderby' => 'rand',

                    'post_type' => 'listing',

                    'post_status' => 'publish',

                    'posts_per_page' => $postNumber,

                    'tax_query' => $TxQuery,

                    'meta_query' => array(

                        'relation'=>'AND',

                        array(

                            'key'     => 'campaign_status',

                            'value'   => array( 'active' ),

                            'compare' => 'IN',

                        ),

                        array(

                            'key'     => $campaign_type,

                            'value'   => array( 'active' ),

                            'compare' => 'IN',

                        ),

                        $priceQuery,

                    ),

                );

                if(!empty($s)){

                    $args = array(

                        'orderby' => 'rand',

                        'post_type' => 'listing',

                        'post_status' => 'publish',

                        's' => $s,

                        'posts_per_page' => $postNumber,

                        'tax_query' => $TxQuery,

                        'meta_query' => array(

                            'relation'=>'AND',

                            array(

                                'key'     => 'campaign_status',

                                'value'   => array( 'active' ),

                                'compare' => 'IN',

                            ),

                            array(

                                'key'     => $campaign_type,

                                'value'   => array( 'active' ),

                                'compare' => 'IN',

                            ),

                            $priceQuery,

                        ),

                    );

                }
				
				if(!empty($posts_in)){
					$args['post__in'] = $posts_in;
				}

                $idsArray = array();

                $the_query = new WP_Query( $args );

                if ( $the_query->have_posts() ) {

                    while ( $the_query->have_posts() ) {

                        $the_query->the_post();

                        if( $IDSonly==TRUE ){

                            $idsArray[] =  get_the_ID();



                        }

                        else{

                            if(is_singular('listing') ){

                                get_template_part( 'templates/details-page-ads' );

                            }

                            elseif(is_page() && is_active_sidebar( 'default-sidebar' )){

                                get_template_part( 'templates/details-page-ads' );

                            }

                            else{

                                $listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];

                                if( $listing_mobile_view == 'app_view' && wp_is_mobile() ){

                                    get_template_part( 'mobile/listing-loop-app-view' );

                                }else

                                {

                                    if( $ad_style == 'list' || $ad_style == 'grid' )

                                    {

                                        get_template_part( 'layouts/loop-list-view' );

                                    }

                                    if( $ad_style == 'sidebar' )

                                    {

                                        get_template_part( 'layouts/templates/sidebar-loop' );

                                    }



                                }

                            }



                        }



                        wp_reset_postdata();

                    }

                    if( $IDSonly==TRUE ){

                        if(!empty($idsArray)){

                            return $idsArray;

                        }

                    }



                }







            }

        }





    }

}



/* ============== ListingPro category menu ============ */



if (!function_exists('listingpro_categoies_menu')) {



    function listingpro_categoies_menu() {

        $defaults = array(

            'theme_location'  => 'category_menu',

            'container'       => 'false',

            'menu_class'      => '',

            'menu_id'         => '',

            'echo'            => true,

            'fallback_cb'     => '',

            'items_wrap'      => '<ul id="menu-category" class="%2$s lp-user-menu list-style-none">%3$s</ul>',

        );

            return wp_nav_menu( $defaults );

    }



}


add_action('wp_ajax_select2_ajax_dashbaord_listing', 'select2_ajax_dashbaord_listing');
add_action('wp_ajax_nopriv_select2_ajax_dashbaord_listing', 'select2_ajax_dashbaord_listing');
if( !function_exists( 'select2_ajax_dashbaord_listing' ) )
{
    function select2_ajax_dashbaord_listing()
    {
        $return = array();
        if( is_user_logged_in() )
        {
            $user_id        =   get_current_user_id();
	        $targetPlanMetaKey  =   'menu';
	        if( isset($_GET['targetPlanMetaKey']) )
	        {
		        $targetPlanMetaKey  =   $_GET['targetPlanMetaKey'];
	        }
            $search_results = new WP_Query( array(
                's'=> $_GET['q'],
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => 50,
                'post_type' => 'listing',
                'author' => $user_id
            ) );

            if( $search_results->have_posts() ) :
                while( $search_results->have_posts() ) : $search_results->the_post();
	                $checkStatus = lp_validate_listing_action($search_results->post->ID, $targetPlanMetaKey);
	                $disabled   =   'no';
	                if( empty( $checkStatus ) )
	                {
		                $disabled   =   'yes';
	                }
                    // shorten the title a little

                    $title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;
	                $return[] = array( $search_results->post->ID, $title, $disabled ); // array( Post ID, Post Title )
                endwhile;
            endif;
        }

        echo json_encode( $return );
        die;

    }
}
add_action('wp_ajax_select2_ajax_dashbaord_listing_unique', 'select2_ajax_dashbaord_listing_unique');
add_action('wp_ajax_nopriv_select2_ajax_dashbaord_listing_unique', 'select2_ajax_dashbaord_listing_unique');
if( !function_exists( 'select2_ajax_dashbaord_listing_unique' ) )
{
	function select2_ajax_dashbaord_listing_unique()
	{
		$return = array();
		if( is_user_logged_in() )
		{
			$user_id        =   get_current_user_id();

			$uniqueMetaKey  =   'event_id';
			$planmetakey  =   'events';
			if( isset( $_GET ) )
			{
				$uniqueMetaKey  =   $_GET['uniqueMetaKey'];
				$planmetakey    =   $_GET['planmetakey'];
			}

			$search_results = new WP_Query( array(
				's'=> $_GET['q'],
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => 50,
				'post_type' => 'listing',
				'author' => $user_id,
				'meta_key' => $uniqueMetaKey,
				'meta_compare' => 'NOT EXISTS'
			) );

			if( $search_results->have_posts() ) :
				while( $search_results->have_posts() ) : $search_results->the_post();

					$checkStatus = lp_validate_listing_action($search_results->post->ID, $planmetakey);
					$disabled   =   'no';
					if( empty( $checkStatus ) )
					{
						$disabled   =   'yes';
					}

					// shorten the title a little
					$title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;
					$return[] = array( $search_results->post->ID, $title, $disabled ); // array( Post ID, Post Title )
				endwhile;
			endif;
		}

		echo json_encode( $return );
		die;

	}
}

add_action('wp_ajax_add_events_cb', 'add_events_cb');
add_action('wp_ajax_nopriv_add_events_cb', 'add_events_cb');
if( !function_exists( 'add_events_cb' ) )
{
	function add_events_cb()
	{
		$user_id        =   get_current_user_id();
		$user_idd       =   $_POST['eUID'];

		if( $user_id != $user_idd )
		{
			$return['status']   =   'error';
			$return['msg']      =   esc_html__('Invalid User Session', 'listingpro');
			die( json_encode( $return ) );
		}
		else
		{
			if( $_POST['eUp'] == 'yes' )
			{
				$eTitle =   $_POST['eTitle'];
				$eDesc =   $_POST['eDesc'];
				$eDate =   $_POST['eDate'];
				$eTime =   $_POST['eTime'];
				$eLoc =   $_POST['eLoc'];
				$eLat =   $_POST['eLat'];
				$eLon =   $_POST['eLon'];
				$eTUrl =   $_POST['eTUrl'];
				$eID =   $_POST['eID'];
				$eImg =   $_POST['eImg'];

				$event_data = array(
					'ID'           => $eID,
					'post_title'   => $eTitle,
					'post_content' => $eDesc,
				);

				$event_id   =   wp_update_post( $event_data );

				if( !is_wp_error( $event_id ) )
				{
					update_post_meta( $event_id, 'event-date', strtotime( $eDate ) );
					update_post_meta( $event_id, 'event-time', $eTime );
					update_post_meta( $event_id, 'event-loc', $eLoc );
					update_post_meta( $event_id, 'event-lat', $eLat );
					update_post_meta( $event_id, 'event-lon', $eLon );
					update_post_meta( $event_id, 'ticket-url', $eTUrl );
					update_post_meta( $event_id, 'event-img', $eImg );

					$return['status']   =   'success';
					$return['msg']      =   esc_html__('event updated successfully', 'listingpro');
					die( json_encode( $return ) );
				}
				else
				{
					$return['status']   =   'error';
					$return['msg']      =   esc_html__('Error while updating event', 'listingpro');
					die( json_encode( $return ) );
				}

			}
			else
			{
				$eTitle =   $_POST['eTitle'];
				$eDesc =   $_POST['eDesc'];
				$eDate =   $_POST['eDate'];
				$eTime =   $_POST['eTime'];
				$eLoc =   $_POST['eLoc'];
				$eLat =   $_POST['eLat'];
				$eLon =   $_POST['eLon'];
				$eTUrl =   $_POST['eTUrl'];
				$eLID =   $_POST['eLID'];
				$eUtils =   stripslashes( $_POST['eUtils'] );
				$eImg =   $_POST['eImg'];
				$eImgID =   $_POST['eImgID'];

				$eUtils_array   =   explode( '*', $eUtils );
				$eUtils_array   =   array_filter( $eUtils_array );
				$eUtils_ar      =   array();
				foreach ( $eUtils_array as $item )
                {
                    $item_arr   =   explode( '|', $item );
                    $eUtils_ar[$item_arr[0]] =   $item_arr[1];
                }

				$event_data =   array(
					'post_title'    => $eTitle,
					'post_content'  =>  $eDesc,
					'post_author' =>    $user_id,
					'post_status' =>    'publish',
					'post_type' => 'events'
				);
				$checkStatus = lp_validate_listing_action($eLID, 'events');
				if(empty($checkStatus)){
					$return['status']   =   'error';
					$return['msg']      =   'Event not allowed with this listing';
					die( json_encode( $return ) );
				}

				$event_id   =   wp_insert_post( $event_data );
				if( !is_wp_error( $event_id ) )
				{
					set_post_thumbnail( $event_id, $eImgID );

					update_post_meta( $event_id, 'event-date', strtotime( $eDate ) );
					update_post_meta( $event_id, 'event-time', $eTime );
					update_post_meta( $event_id, 'event-loc', $eLoc );
					update_post_meta( $event_id, 'event-lat', $eLat );
					update_post_meta( $event_id, 'event-lon', $eLon );
					update_post_meta( $event_id, 'ticket-url', $eTUrl );
					update_post_meta( $event_id, 'event-utilities', $eUtils_ar );
					update_post_meta( $event_id, 'event-lsiting-id', $eLID );
					update_post_meta( $event_id, 'event-img', $eImg );

					update_post_meta( $eLID, 'event_id', $event_id );

					$return['status']   =   'success';
					$return['msg']      =   esc_html__('event created successfully', 'listingpro');
					die( json_encode( $return ) );
				}
				else
				{
					$return['status']   =   'error';
					$return['msg']      =   esc_html__('Error while creating event', 'listingpro');
					die( json_encode( $return ) );
				}
			}
		}
	}
}

add_action('wp_ajax_event_attending_cb', 'event_attending_cb');
add_action('wp_ajax_nopriv_event_attending_cb', 'event_attending_cb');
if( !function_exists( 'event_attending_cb' ) )
{
    function event_attending_cb()
    {
        $eID    =   $_POST['eID'];
        $eUID   =   $_POST['eUID'];

        $get_event_attending_user_ids  =   get_post_meta( $eID, 'attending-users', true );
        $get_user_events                =   get_user_meta( $eUID, 'user-events', true );

        if( empty( $get_event_attending_user_ids ) )
        {
            $get_event_attending_user_ids   =   array( $eUID );
        }
        else
        {
            $get_event_attending_user_ids[] =   $eUID;
        }
        if( empty( $get_user_events ) )
        {
            $get_user_events    =   array( $eID );
        }
        else
        {
            $get_user_events[]  =   $eID;
        }

        update_post_meta( $eID, 'attending-users', $get_event_attending_user_ids );
        update_user_meta( $eUID, 'user-events', $get_user_events );

        $attendies_count    =   count( get_post_meta( $eID, 'attending-users', true ) );

        $going_count    =   $attendies_count.' '.esc_html__( 'going', 'listingpro' );
        $return['status'] = 'success';
        $return['total_attending'] = $going_count;
        $return['user_ids_arr'] = $get_event_attending_user_ids;
        $return['user_events_arr'] = $get_user_events;

        die(json_encode($return));
    }
}


function post_type_events() {
	global $listingpro_options;
	$eventsSLUG = '';
	if(class_exists('ReduxFramework')){
		$eventsSLUG = $listingpro_options['events_slug'];
		$eventsSLUG = trim($eventsSLUG);
	}
	if(empty($eventsSLUG)){
		$eventsSLUG = 'events';
	}
    $labels = array(
        'name' => _x('Events', 'post type general name', 'listingpro-plugin'),
        'singular_name' => _x('Events', 'post type singular name', 'listingpro-plugin'),
        'add_new' => _x('Add New Event', 'book', 'listingpro-plugin'),
        'add_new_item' => __('Add New Event', 'listingpro-plugin'),
        'edit_item' => __('Edit Event', 'listingpro-plugin'),
        'new_item' => __('New Event', 'listingpro-plugin'),
        'view_item' => __('View Event', 'listingpro-plugin'),
        'search_items' => __('Search Events', 'listingpro-plugin'),
        'not_found' =>  __('No Event found', 'listingpro-plugin'),
        'not_found_in_trash' => __('No Event found in Trash', 'listingpro-plugin'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite'   => array( 'slug' => $eventsSLUG ),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail'),
    );

    register_post_type( 'events', $args );
}

add_action('init', 'post_type_events');


add_action( 'add_meta_boxes', 'event_details_meta' );
add_action( 'save_post', 'save_event_metas' );
function event_details_meta()
{
    add_meta_box( 'event_meta_box', __( 'Event Details', 'lsitingpro' ), 'event_meta_box', 'events' );
}
function event_meta_box( $post )
{
	wp_nonce_field( basename( __FILE__ ), 'event_meta_box_nonce' );
	$event_id   =   $post->ID;

	$event_date         =   get_post_meta( $event_id, 'event-date', true );
	$event_time         =   get_post_meta( $event_id, 'event-time', true );
	$event_lon          =   get_post_meta( $event_id, 'event-lat', true );
	$event_lat         	=   get_post_meta( $event_id, 'event-lon', true );
	$event_loc			=   get_post_meta( $event_id, 'event-loc', true );
	$event_ticket_url   =   get_post_meta( $event_id, 'ticket-url', true );
	$lsiting_id   =   get_post_meta( $event_id, 'event-lsiting-id', true );

	?>
    <div class="inside">
        <table class="form-table lp-metaboxes">
            <tbody>
            <tr id="lp_field_event_listing">
                <th>
                    <label for="tagline_text">
                        <strong>Listing</strong>
                    </label>
                </th>
                <td>
                    <div class="type_listing add_item_medium">
                        <input value="<?php echo get_the_title($lsiting_id); ?>" type="text" name="s" class="unique-for-events form-control search-autocomplete lpautocomplete" placeholder="Search">
                        <input type="hidden" name="event-lsiting-id" id="lpautocompletSelec" value="<?php echo $lsiting_id; ?>">
                        <i class="lp-listing-sping fa-li fa fa-spinner fa-spin"></i>
                        <div class="lpsuggesstion-box"></div>
                    </div>
                </td>
            </tr>
            <tr id="lp_field_event_date">
                <th>
                    <label for="tagline_text">
                        <strong>Date</strong>
                    </label>
                </th>
                <td>
                    <input <?php if( !empty( $event_date ) ): ?> value="<?php echo date( 'M d, Y', $event_date ); ?>" <?php endif; ?> type="text" name="event_date" id="event_date">
                </td>
            </tr>
            <tr id="lp_field_event_time">
                <th>
                    <label for="tagline_text">
                        <strong>Time</strong>
                    </label>
                </th>
                <td>
                    <input value="<?php echo $event_time; ?>" type="text" name="event_time" id="event_time">
                </td>
            </tr>
            <tr id="lp_field_event_loc">
                <th>
                    <label for="tagline_text">
                        <strong>Location</strong>
                    </label>
                </th>
                <td>
                    <input value="<?php echo $event_loc; ?>" type="text" name="event_loc" id="event_loc">
                    <input value="<?php echo $event_lat; ?>" type="hidden" name="event_lat" id="event_lat">
                    <input value="<?php echo $event_lon; ?>" type="hidden" name="event_lon" id="event_lon">
                </td>
            </tr>
            <tr id="lp_field_event_ticket_url">
                <th>
                    <label for="tagline_text">
                        <strong>Ticket URL</strong>
                    </label>
                </th>
                <td>
                    <input value="<?php echo $event_ticket_url; ?>" type="text" name="event_ticket_url" id="event_ticket_url">
                </td>
            </tr>
			<?php wp_nonce_field( '', 'events_meta_nonce' ); ?>
            </tbody>
        </table>
    </div>
	<?php

}
function save_event_metas( $post_id  )
{
	if (  ! isset( $_POST['events_meta_nonce'] ) && empty( $_POST['events_meta_nonce'] )) {
		return;
	}
	$post_type = get_post_type($post_id);
	if ( "events" != $post_type ) return;

	if( $_SERVER['REQUEST_METHOD'] == 'POST' )
	{
		$event_date = strtotime( $_POST['event_date'] );
		$event_time = $_POST['event_time'];
		$event_loc = $_POST['event_loc'] ;
		$event_lat = $_POST['event_lat'] ;
		$event_lon = $_POST['event_lon'] ;
		$event_ticket_url = $_POST['event_ticket_url'];
		$eLID   =   $_POST['event-lsiting-id'];

		update_post_meta( $eLID, 'event_id', $post_id );

		update_post_meta( $post_id, 'event-lsiting-id', $eLID );
		update_post_meta( $post_id, 'event-date', $event_date );
		update_post_meta( $post_id, 'event-time', $event_time );
		update_post_meta( $post_id, 'event-loc', $event_loc );
		update_post_meta( $post_id, 'event-lat', $event_lat );
		update_post_meta( $post_id, 'event-lon', $event_lon );
		update_post_meta( $post_id, 'ticket-url', $event_ticket_url );
	}


}




if(!function_exists('show_map_pop_cb')){
    function show_map_pop_cb() {
        if ( isset($_REQUEST) ) {
            $LPpostID    =   $_REQUEST['LPpostID'];
            ?>
            <div id="quickmap<?php echo $LPpostID; ?>" class="quickmap"></div>
            <?php
        }
        die();
    }
}
add_action( 'wp_ajax_show_map_pop_cb', 'show_map_pop_cb' );
add_action( 'wp_ajax_nopriv_show_map_pop_cb', 'show_map_pop_cb' );


if( !function_exists( 'ajax_response_markup' ) ){
    function ajax_response_markup($returnData = false){
		
		if(empty($returnData)){
        ?>
			<div class="lp-notifaction-area lp-notifaction-error" data-error-msg="<?php echo esc_html__('Something went wrong!', 'listingpro'); ?>">
				<div class="lp-notifaction-area-outer">
					<div class="lp-notifi-icons"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE2SURBVFhH7dhBaoQwFMZxoZu5w5ygPc7AlF6gF5gLtbNpwVVn7LKQMG4b3c9ZCp1E3jdEEI1JnnGRP7h5Iv4wKmiRy+U8qkT7Wkn1VpblA43Yqn7abSWb+luqRxpNZ3D6oP+zUO+cSIPT57jqc/1p4I7G0xmUwXEibdxJ/j7T2D1OZDAOcSD7y9ruaexfTGR0HIqBZMOhECQ7DvkgF8OhOcjFccgFmQyHxpDJcWgIuRoc6iFl87kqHOqunFQfBtltQr3QrnVkLWsHxHLT7rTZ95y5cvflXgNy6IHo3ZNCHZMhx55WQh6TIV1eJcmQLji0OHIODi2G9MEhdmQIDrEhY+BQdGRMHIqG5MChYKSNC/puHSkIqQ+qOXGoh5TqQOPpvi7N06x/JQF1SI0TQmxolMvl3CuKG6LJpCW33jxQAAAAAElFTkSuQmCC"></div>
					<div class="lp-notifaction-inner">
						<h4></h4>
						<p></p>
					</div>
				</div>
			</div>
        <?php
		}else{
			/* data return */
			return '
				<div class="lp-notifaction-area lp-notifaction-error" data-error-msg="'.esc_html__('Something went wrong!', 'listingpro').'">
				<div class="lp-notifaction-area-outer">
					<div class="lp-notifi-icons"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE2SURBVFhH7dhBaoQwFMZxoZu5w5ygPc7AlF6gF5gLtbNpwVVn7LKQMG4b3c9ZCp1E3jdEEI1JnnGRP7h5Iv4wKmiRy+U8qkT7Wkn1VpblA43Yqn7abSWb+luqRxpNZ3D6oP+zUO+cSIPT57jqc/1p4I7G0xmUwXEibdxJ/j7T2D1OZDAOcSD7y9ruaexfTGR0HIqBZMOhECQ7DvkgF8OhOcjFccgFmQyHxpDJcWgIuRoc6iFl87kqHOqunFQfBtltQr3QrnVkLWsHxHLT7rTZ95y5cvflXgNy6IHo3ZNCHZMhx55WQh6TIV1eJcmQLji0OHIODi2G9MEhdmQIDrEhY+BQdGRMHIqG5MChYKSNC/puHSkIqQ+qOXGoh5TqQOPpvi7N06x/JQF1SI0TQmxolMvl3CuKG6LJpCW33jxQAAAAAElFTkSuQmCC"></div>
					<div class="lp-notifaction-inner">
						<h4></h4>
						<p></p>
					</div>
				</div>
			</div>
			';
		}
    }
}

/*  */
add_action( 'publish_to_trash', 'delete_events_permanently' );
if(!function_exists('delete_events_permanently')){
	function delete_events_permanently( $post )
	{
	   if( $post->post_type != 'events' ) return false;

	   $listing_id =   get_post_meta( $post->ID, 'event-lsiting-id', true );
	   delete_post_meta( $listing_id, 'event_id' );
	   wp_delete_post( $post->ID, true );

	}
}

add_action('wp_ajax_select2_ajax_dashbaord_listing_camp', 'select2_ajax_dashbaord_listing_camp');
add_action('wp_ajax_nopriv_select2_ajax_dashbaord_listing_camp', 'select2_ajax_dashbaord_listing_camp');
if( !function_exists( 'select2_ajax_dashbaord_listing_camp' ) )
{
    function select2_ajax_dashbaord_listing_camp()
    {
        $return = array();
        if( is_user_logged_in() )
        {
            $user_id        =   get_current_user_id();
            $search_results = new WP_Query( array(
                's'=> $_GET['q'],
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => 50,
                'post_type' => 'listing',
                'author' => $user_id,
				'meta_key' => 'campaign_status',
                'meta_compare' => 'NOT EXISTS'
            ) );

            if( $search_results->have_posts() ) :
                while( $search_results->have_posts() ) : $search_results->the_post();
                    // shorten the title a little
                    $title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;
                    $return[] = array( $search_results->post->ID, $title ); // array( Post ID, Post Title )
                endwhile;
            endif;
        }

        echo json_encode( $return );
        die;

    }
}


/* Time format function  */
if( !function_exists('listing_time_format' ) )
{
    function listing_time_format( $displayTIme = null ,$inputValue = null )
    {
		$newTimedisplay = '';
		$newTimeinput = '';
		global $listingpro_options;
		$format = $listingpro_options['timing_option'];
		if(!empty($displayTIme)){
			$displayTIme = str_replace(' ', '', $displayTIme);
			$displayTIme = strtotime($displayTIme);
			
			if(!empty($format) && $format == '24'){
				$newTimedisplay = date("H:i", $displayTIme);
			}else{						
				$newTimedisplay = date('h:i A', $displayTIme);
			}
			return $newTimedisplay;
		}elseif(!empty($inputValue)){
			$inputValue = strtotime($inputValue);
			
			if(!empty($format) && $format == '24'){
				$newTimeinput = date("H:i", $inputValue);
			}else{						
				$newTimeinput = date('h:ia', $inputValue);
			}
			return $newTimeinput;
		}
	}
}

function del_menu_data_by_user( $user_id, $del_type, $key )
{
	$m_args =   array(
		'post_type' => 'listing',
		'fields' => 'ids',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'author' => $user_id,
		'meta_key' => 'lp-listing-menu',
		'meta_compare' => 'EXISTS'
	);

	$menus_array  = array();
	$m_listings             =   new WP_Query($m_args);
	if( $m_listings->have_posts() )
	{
		foreach ( $m_listings->posts as $lid )
		{
			$lp_listing_menus   =   get_post_meta( $lid, 'lp-listing-menu', true );
			if( $del_type == 'type' )
			{
				unset($lp_listing_menus[$key]);
			}
            elseif ( $del_type == 'group' )
			{
				foreach ( $lp_listing_menus as $menu_type => $menu_groups_arr )
				{
					foreach ( $menu_groups_arr as $k => $v )
					{
						if( $k == $key )
						{
							unset( $lp_listing_menus[$menu_type][$key] );
							if( count( $lp_listing_menus[$menu_type] ) == 0 )
							{
								unset( $lp_listing_menus[$menu_type] );
							}
						}
					}
				}
			}
			if( count( $lp_listing_menus ) == 0 )
			{
				delete_post_meta( $lid, 'lp-listing-menu' );
			}
			else
			{
				update_post_meta( $lid, 'lp-listing-menu', $lp_listing_menus );
			}
			$menus_array[$lid]   =   $lp_listing_menus;
		}
	}
}

add_action('wp_ajax_ajax_search_child_cats', 'ajax_search_child_cats');
add_action('wp_ajax_nopriv_ajax_search_child_cats', 'ajax_search_child_cats');
if( !function_exists( 'ajax_search_child_cats' ) )
{
	function ajax_search_child_cats()
	{
		global $listingpro_options;
		$sub_cats_loc   =   $listingpro_options['lp_listing_sub_cats_lcation'];
		$col_grid_class =   'col-grid-5';
		if( $sub_cats_loc == 'content' )
		{
			$col_grid_class =   'col-grid-3';
		}


		$return =   array();
		$parent_id = $_POST['parent_id'];
		$output =   '';
		$parent_term    =   get_term( $parent_id, 'listing-category' );

		$term_name  =   $parent_term->name;

		$child_cats =   get_terms(
			'listing-category',
			array(
				'hide_empty' => false,
				'parent' => $parent_id
			)
		);
		if( empty( $child_cats ) )
		{
			$return['status']    =   'not';
			$return['term_name']   =   $term_name;
			die(json_encode($return));
		}
		else
		{
			require_once (THEME_PATH . "/include/aq_resizer.php");

			$output .=  '<div class="lp-child-cats-tax-slider" data-child-loc="'.$sub_cats_loc.'">';
			foreach ( $child_cats as $child_cat ):
				$listings_label =   esc_html('Listing', 'listingpro');
				if( $child_cat->count > 1 )
				{
					$listings_label =   esc_html( 'Listings', 'listingpro' );
				}
				$term_banner    =   get_term_meta( $child_cat->term_id,'lp_category_banner', true );
				$term_link  =   get_term_link( $child_cat );
				if( empty( $term_banner ) )
				{
					$banner_url =   'https://placeholdit.imgix.net/~text?txtsize=33&w=246&h=126';
				}
				else
				{
					$banner_url =    aq_resize( $term_banner, '246', '126', true, true, true);
				}
				$output .=  '<div class="'. $col_grid_class .' lp-child-cats-tax-wrap">';
				$output .=  '   <div class="lp-child-cats-tax-inner">';
				$output .=  '       <div class="lp-child-cat-tax-thumb"><img src="'. $banner_url .'" alt="'.$child_cat->name.'"></div>';
				$output .=  '       <div class="lp-child-cat-tax-name">';
				$output .=  '           <a href="'. $term_link .'">'.$child_cat->name;
				$output .=  '                <span>'. $child_cat->count .' '.$listings_label.'</span>';
				$output .=  '           </a>';
				$output .=  '       </div>';
				$output .=  '   </div>';
				$output .=  '</div>';
			endforeach;
			$output .=  '</div>';


			$return['status']   =   'found';
			$return['child_cats']   =   $output;
			$return['term_name']   =   $term_name;
			die(json_encode($return));
		}
	}
}