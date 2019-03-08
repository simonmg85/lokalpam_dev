<?php
$currentUserID = get_current_user_id();
$lpAllMessges = get_user_meta($currentUserID, 'lead_messages', true);
//$adminAvatar = listingpro_get_avatar_url($currentUserID, $size = '94');
$adminAvatar = listingpro_author_image();
$leadAvatar = '';
global $current_user;
$loadingIMG = get_template_directory_uri().'/assets/images/lp-loading.gif';
if(empty($lpAllMessges)){
	 ?>
		<div class="lp-blank-section">
			<div class="col-md-12 blank-left-side">
				<img src="<?php echo listingpro_icons_url('lp_blank_trophy'); ?>">
			   <h1><?php echo esc_html__('Nothing but this golden trophy!', 'listingpro'); ?></h1>
				<p class="margin-bottom-20"><?php echo esc_html__('You must be here for the first time. You will see messages here when user will contact you through lead form.', 'listingpro'); ?></p>				
			</div>
			
		</div>
        <?php
}else{
?>
<div class="user-recent-listings-inner tab-pane fade in active" id="inbox">
    <?php

        $latestLead = get_user_meta($currentUserID, 'latest_lead', true);

        $latestLeadArray = array();
        $latestRepliesArray = array();
        $post_id = '';
        $listing_title = '';
        $listing_url = '';
        $listing_data = '';
        $lead_mail = '';
        $name = '';
        $phone = '';
        $extras = array();
        $times = array();
        $replytimes = array();
        $messages = array();
        $replymessages = array();

        if(!empty($latestLead)){
            foreach($latestLead as $key=>$val){
                $post_id = $key;
                $lead_mail = $val;
                $listing_title = get_the_title($post_id);
                $listing_url = get_the_permalink($post_id);
                $listing_data = "<a href='$listing_url' class='listingDtlurl'>$listing_title</a>";
            }
            if(!empty($lpAllMessges)){
                $latestLeadArray = $lpAllMessges[$post_id][$lead_mail]['leads'];
                if (array_key_exists("replies",$lpAllMessges[$post_id][$lead_mail])){
                    $latestRepliesArray = $lpAllMessges[$post_id][$lead_mail]['replies'];
                }

                $name = $latestLeadArray['name'];
                $phone = $latestLeadArray['phone'];
                $times = $latestLeadArray['time'];
                $latestMessages = $latestLeadArray['message'];
                $extras = $latestLeadArray['extras'];
                if(!empty($latestRepliesArray)){
                    $replytimes = $latestRepliesArray['time'];
					if(!empty($replytimes)){
						if(is_array($replytimes)){
							$replytimes = array_reverse($replytimes);
						}
					}
                    $replymessages = $latestRepliesArray['message'];
                }

            }
        }?>
        <div class="col-md-3 padding-0 background-white lpinboxrightpart">
        <div class="lp-sender-info text-center background-white">
            <?php
                 $leadUID = '';
                if ( email_exists( $lead_mail ) ){
                    $leadUser = get_user_by( 'email', $lead_mail );
                    $leadUID = $leadUser->ID;
                    $leadAvatar = listingpro_get_avatar_url($leadUID, $size = '94');
                }else{
                    $leadAvatar = listingpro_icons_url('lp_def_author');
                } 
            ?>
            <div class="lp-sender-image">
                <img src="<?php echo $leadAvatar; ?>" >
            </div>
            <h6><?php echo $name; ?></h6>
            <?php
            if ( email_exists( $lead_mail ) ) {
                ?>
                <p><?php echo esc_html__('Registered User', 'listingpro'); ?></p>
                <?php
            }else{
                ?>
                <p><?php echo esc_html__('Unregistered User', 'listingpro'); ?></p>
                <?php
            }
            ?>

            <!--<p>Melbourne, Au</p>-->
        </div>
        <div class="lp-ad-click-outer">
            <div class="lp-general-section-title-outer">
                <p class="clarfix lp-general-section-title comment-reply-title active"> <?php echo esc_html__('Details', 'listingpro'); ?> <i class="fa fa-angle-right" aria-hidden="true"></i></p>
                <div class="lp-ad-click-inner" id="lp-ad-click-inner">

                    <ul class="lp-invoices-all-stats clearfix">
                        <li>
                            <h5><?php echo esc_html__('Listing', 'listingpro'); ?>  <span><?php echo $listing_data; ?></span></h5>
                        </li>
                        <li>
                            <h5><?php echo esc_html__('Email', 'listingpro'); ?>  <span><?php echo $lead_mail; ?></span></h5>
                        </li>
                        <li>
                            <h5><?php echo esc_html__('Phone', 'listingpro'); ?>  <span><?php echo $phone; ?></span></h5>
                        </li>
                        
                        <?php
                        if(!empty($extras)){
                            foreach($extras as $key=>$singleEtr){
                                if(!empty($key) && !empty( $singleEtr )){
                                    ?>
                                    <li>
                                        <h5><?php echo $key; ?> <span><?php echo $singleEtr; ?></span></h5>
                                    </li>
                                    <?php
                                }
                            }
                        }
                        ?>


                    </ul>
                </div>
            </div>
        </div>
    </div> 
    <div class="col-md-3 padding-0">
        <div class="lp-read-messages">
            <div class="lp-message-title">
                <h3><?php esc_html_e('Replied messages','listingpro'); ?></h3>
            </div>
            <?php
            $hasMessages = false;
            if(!empty($lpAllMessges)){
                foreach($lpAllMessges as $key=>$singleListingArray){
                    if(!empty($singleListingArray)){
                        foreach($singleListingArray as $emailkey=>$singleUserLeads){
                            $status = $singleUserLeads['status'];
                            if($status=="read"){
                                $hasMessages = true;
                                $leads = $singleUserLeads['leads'];
                                $name = $leads['name'];
                                $phone = $leads['phone'];
                                $timess = $leads['time'];
                                $latestTime = end($timess);
                                $messages = $leads['message'];
                                $latestMessge = end($messages);
                                $datatts = '';
                                $datatts = "data-listingid='$key'";
                                $datatts .= " data-email='$emailkey'";
                                $datatts .= " data-loader='$loadingIMG'";


                                ?>
                                <div class="lp-read-message-inner" <?php echo $datatts; ?>>
                                    <h5><?php echo substr($latestMessge, 0, 35).'...'; ?></h5>
                                    <p class="clearfix">
                                        <span><?php echo $name; ?></span>
                                        <span class="lp-inbox-date"><?php echo $latestTime; ?></span>
                                    </p>
                                </div>

                                <?php
                            }

                        }
                    }
                }
            }
            if(empty($hasMessages)){
                ?>
                <div class="lp-read-message-inner"><?php echo esc_html__('There is no replied message', 'listingpro'); ?></div>
                <?php
            }
            ?>
        </div>
        <div class="lp-read-messages lp-unread-messages">
            <div class="lp-message-title">
                <h3><?php esc_html_e('Un-Replied messages','listingpro'); ?></h3>
            </div>
            <?php
            $hasMessages = false;
            if(!empty($lpAllMessges)){
                foreach($lpAllMessges as $key=>$singleListingArray){
                    if(!empty($singleListingArray)){
                        foreach($singleListingArray as $emailkey=>$singleUserLeads){
                            $status = $singleUserLeads['status'];
                            if($status=="unread"){
                                $hasMessages = true;
                                $leads = $singleUserLeads['leads'];
                                $name = $leads['name'];
                                $phone = $leads['phone'];
                                $timess = $leads['time'];
                                $latestTime = end($timess);
                                $messages = $leads['message'];
                                $latestMessge = end($messages);
                                $datatts = '';
                                $datatts = "data-listingid='$key'";
                                $datatts .= " data-email='$emailkey'";
                                $datatts .= " data-loader='$loadingIMG'";
                                ?>
                                <div class="lp-read-message-inner" <?php echo $datatts; ?>>
                                    <h5><?php echo substr($latestMessge, 0, 35).'...'; ?></h5>
                                    <p class="clearfix">
                                        <span><?php echo $name; ?></span>
                                        <span class="lp-inbox-date"><?php echo $latestTime; ?></span>
                                    </p>
                                </div>

                                <?php
                            }

                        }
                    }
                }
            }
            if(empty($hasMessages)){
                ?>
                <div class="lp-read-message-inner"><?php echo esc_html__('There is no un-replied message', 'listingpro'); ?></div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="col-md-6 lp-inbox-outer lpinboxmiddlepart">
        
        <!-- box for internal messages -->
        <div class="row">
            <div class="lp-message-title">
                <?php
                if(!empty($messages)){
                    ?>
                    <h3><?php echo substr($messages[0], 0, 30).'...'?><?php echo esc_html__('On Lisitng ', 'listingpro');?></h3>
                    <?php
                }else{
                    ?>
                    <h3><?php esc_html_e('No Recent recent message thread found','listingpro'); ?></h3>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="lp_all_messages_box clearfix">
            <?php
            if(!empty($latestMessages)){
                $leadUID = '';
                if ( email_exists( $lead_mail ) ){
                    $leadUser = get_user_by( 'email', $lead_mail );
                    $leadUID = $leadUser->ID;
                    $leadAvatar = listingpro_get_avatar_url($leadUID, $size = '94');
                }else{
                    $leadAvatar = listingpro_icons_url('lp_def_author');
                }
                $latestMessages = array_reverse($latestMessages);
                echo '<div  class="lpsinglemsgbox clearfix">';
                echo '<div class="lpsinglemsgbox-inner">';
                /* leads */
				
				$msgCount = 1;
				$outputtMSG = null;
                foreach($latestMessages as $key=>$singlemessage){

                    /* replies */
                    if(!empty($replymessages)){
                        $replymessages = array_reverse($replymessages);
                        if(isset($replymessages[$key])){
                            echo '<div class="lpQest-outer lpreplyQest-outer">';

                            echo '<div class="lpQest"><div></div><p>'.$replymessages[$key].'</p></div>';

                            echo '<div class="lpQest-img-outer">';
                            echo '<div class="lpQest-image"><img src="'.$adminAvatar.'"></div>';
                            echo '<p>'.$current_user->user_login.'</p>';
                            echo '</div>';
                            echo '<div class="lpQestdate"><p>'.$replytimes[$key].'</p></div>';
                            echo '</div>';
                            echo PHP_EOL;
                        }
                    }
                    //messages
					
					ob_start();
                    echo '<div class="lpQest-outer">';
                    echo '<div class="lpQest-img-outer">';
                    echo '<div class="lpQest-image"><img src="'.$leadAvatar.'"></div>';
                    echo '<p>'.$name.'</p>';
                    echo '</div>';
                    echo '<div class="lpQest"><div></div><p>'.$singlemessage.'</p></div>';
                    echo '<div class="lpQestdate"><p>'.$times[$key].'</p></div>';
                    echo '</div>';
                    echo PHP_EOL;
					$outputtMSG = ob_get_contents();
					ob_end_clean();
					ob_flush();
					$msgCount++;

                }
				
				/* if replies are greater than messages*/
				if(!empty($replymessages)){
					$msgCount = $msgCount-1;
					
					$replySize = count($replymessages);
					if($replySize > $msgCount){
						
						for($i=$msgCount; $i<$replySize; $i++){
							echo '<div class="lpQest-outer lpreplyQest-outer">';

                            echo '<div class="lpQest"><div></div><p>'.$replymessages[$i].'</p></div>';

                            echo '<div class="lpQest-img-outer">';
                            echo '<div class="lpQest-image"><img src="'.$adminAvatar.'"></div>';
                            echo '<p>'.$current_user->user_login.'</p>';
                            echo '</div>';
                            echo '<div class="lpQestdate"><p>'.$replytimes[$i].'</p></div>';
                            echo '</div>';
                            echo PHP_EOL;
						}
					}
				}
				echo $outputtMSG;
                /* replies */
                /* if(!empty($replymessages)){
                    foreach($replymessages as $key=>$singleReply){

                        echo '<div class="lpQest-outer lpreplyQest-outer">';

                            echo '<div class="lpQest"><div></div><p>'.$singleReply.'</p></div>';

                            echo '<div class="lpQest-img-outer">';
                                    echo '<div class="lpQest-image"></div>';
                                    echo '<p>admin</p>';
                            echo '</div>';
                            echo '<div class="lpQestdate"><p>'.$replytimes[$key].'</p></div>';
                        echo '</div>';
                        echo PHP_EOL;
                    }
                } */
                echo '</div>';


                echo '</div>';
                ?>
                <form id="lp_leadReply" name="lp_leadReply" class="lp_leadReply clearfix" method="POST">
                    <textarea class="lp_replylead" name="lp_replylead" placeholder="<?php echo esc_html__('Reply to this', 'listingpro'); ?>" required></textarea>
                    <i class="lpthisloading fa fa-spinner fa-spin"></i>
                    <button type="submit" class="lppRocesesp"><?php echo esc_html__('Send message', 'listingpro'); ?></button>
                    <input type="hidden" name="lpleadmail" value="<?php echo $lead_mail; ?>">
                    <input type="hidden" name="lp_listing_id" value="<?php echo $post_id; ?>">
                </form>

                <?php
            }



            ?>
        </div>
        <!-- end box for internal messages -->
    </div>
    

</div>
<?php } ?>						