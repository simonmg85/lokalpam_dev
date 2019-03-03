<?php
global $listingpro_options;
$listing_style  =   $listingpro_options['lp_detail_page_styles'];
?>
<?php
if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
{
?>
    <div class="open-hours">
<?php
}
?>
	<!-- <h2><?php echo esc_html__('Opening Hours', 'listingpro');?></h2> -->
	<?php

	$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
	$format = $listingpro_options['timing_option'];
		$buisness_hours = listing_get_metabox('business_hours');
		
		if(!empty($buisness_hours) && is_array($buisness_hours)){
				//$lat = listing_get_metabox('latitude');
				//$long = listing_get_metabox('longitude');
			//$timezone = getClosestTimezone($lat, $long);
			
			$timezone  = get_option('gmt_offset');
			$time = gmdate("H:i", time() + 3600*($timezone+date("I"))); 
			$day =  gmdate("l");
			$lang = get_locale();
			setlocale(LC_ALL, $lang.'.utf-8');
			$day = strftime("%A");
			$day = date_i18n( 'l', strtotime( '11/15-1976' ) );
			$day = ucfirst($day);
			$time = strtotime($time);
			$twodays = array();
			$todayOFF = true;
			$todayIsOpen = false;
			$todaycompleteopend = false;
			$newTimeOpen;
			$newTimeClose;
			$newTimeOpen1;
			$newTimeClose1;
			$totimesinaday = false;
			
			
            $dayName = esc_html__('Today','listingpro');
            if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
            {
                echo '<div class="today-hrs pos-relative"><ul>';
            }
            else
            {
                echo '<div class="lp-today-timing"><strong>'.listingpro_icons('todayTime').' '.$dayName.'</strong>';
            }

			
			
			/* newcode */
			$isfistTimeSlot = false;
			$issecondTimeSlot = false;
			$isthirdTimeSlot = false;
			$singleDtime = false;
			$doubleDtime = false;
			$twoDtime = false;
			$getTodayTimes = array();
			foreach($buisness_hours as $dKey=>$vDay){
				if ( (strpos($dKey, $day."-") !== false) || (strpos($dKey, "-".$day) !== false) ||(strpos($dKey, $day."~") !== false) || (strpos($dKey, "~".$day) !== false)  ) {
					$getTodayTimes[$dKey] = $vDay;
					$twoDtime = true;
					$todayOFF = false;
				}elseif($dKey==$day){
					$getTodayTimes[$dKey] = $vDay;
					$todayOFF = false;
				}
			}
			
			if(count($getTodayTimes) > 1){
				$doubleDtime = true;
			}
			
			if( empty($doubleDtime) && empty($twoDtime) ){
				$singleDtime = true;
			}
			
			
			
			/* 2 days time and double time */
			if(!empty($twoDtime) && !empty($doubleDtime)){
				$timeDay1Open = null;
				$timeDay2Open = null;
				$timeDay1Close = null;
				$timeDay2Close = null;
				$timeDay3Open = null;
				$timeDay3Close = null;
				
				
				
				foreach($getTodayTimes as $thisK=>$thisV){
					
					
					$todayIsNextD = false;
					$todayIsTodayD = false;
					if(  (substr_compare( $thisK, '-'.$day, -strlen( '-'.$day ) )==0) || (substr_compare( $thisK, '~'.$day, -strlen( '-'.$day ) )==0) ){
						$todayIsNextD = true;
					}elseif( (substr_compare( $thisK, $day.'-', -strlen( $day.'-' ) )==1) || (substr_compare( $thisK, $day.'~', -strlen( $day.'~' ) )==1) ){
						$todayIsTodayD = true;
					}
					
					if(!empty($todayIsNextD)){
						if( isset( $getTodayTimes[$thisK]['open'] ) ){
							if( is_array( $getTodayTimes[$thisK]['open'] ) ){
								$timeDay1Open = $getTodayTimes[$thisK]['open'][0];
								$timeDay1Close = $getTodayTimes[$thisK]['close'][0];
							}else{
								$timeDay1Open = $getTodayTimes[$thisK]['open'];
								$timeDay1Close = $getTodayTimes[$thisK]['close'];
							}
						}
						
					}elseif(!empty($todayIsTodayD)){
						if( isset( $getTodayTimes[$thisK]['close'] ) ){
							if( is_array( $getTodayTimes[$thisK]['close'] ) ){
								$timeDay2Open = $getTodayTimes[$thisK]['open'][1];
								$timeDay2Close = $getTodayTimes[$thisK]['close'][1];
							}else{
								$timeDay2Open = $getTodayTimes[$thisK]['open'];
								$timeDay2Close = $getTodayTimes[$thisK]['close'];
							}
						}
					}elseif(empty($todayIsNextD) && empty($todayIsTodayD) ){
						//only single day
						if( isset( $getTodayTimes[$thisK]['open'] ) ){
							if( is_array( $getTodayTimes[$thisK]['open'] ) ){
								$timeDay1Open = $getTodayTimes[$thisK]['open'][0];
								$timeDay1Close = $getTodayTimes[$thisK]['close'][0];
							}else{
								$timeDay1Open = $getTodayTimes[$thisK]['open'];
								$timeDay1Close = $getTodayTimes[$thisK]['close'];
							}
						}
						
						
						if( is_array( $getTodayTimes[$thisK]['close'] ) ){
								$timeDay2Open = $getTodayTimes[$thisK]['open'][1];
								$timeDay2Close = $getTodayTimes[$thisK]['close'][1];
							}else{
								$timeDay2Open = $getTodayTimes[$thisK]['open'];
								$timeDay2Close = $getTodayTimes[$thisK]['close'];
							}
						
						
					}
					
					
					
				}
				
				if( !empty($timeDay1Open) && !empty($timeDay2Open) && !empty($timeDay1Close) && !empty($timeDay2Close) ){
					/* double time and 2 days both */
					$lpOpen1 = str_replace(' ', '', $timeDay1Open);
					$lpClose1 = str_replace(' ', '', $timeDay1Close);
					
					$lpOpen1 = strtotime($lpOpen1);
					$lpClose1 = strtotime($lpClose1);
					
					$opencheck = $lpOpen1;
					$closecheck = $lpClose1;
					
					if(!empty($format) && $format == '24'){
						$newTimeOpen = date("H:i", $lpOpen1);
						$newTimeClose = date("H:i", $lpClose1);
					}else{						
						$newTimeOpen = date('h:i A', $lpOpen1);
						$newTimeClose = date('h:i A', $lpClose1);
					}
					$lpOpen1 = strtotime(date("H:i", $lpOpen1));
					$lpClose1 = strtotime(date("H:i", $lpClose1));
					
					//2nd time
					$lpOpen2 = str_replace(' ', '', $timeDay2Open);
					$lpClose2 = str_replace(' ', '', $timeDay2Close);
					
					$lpOpen2 = strtotime($lpOpen2);
					$lpClose2 = strtotime($lpClose2);
					
					if(!empty($format) && $format == '24'){
						$newTimeOpen1 = date("H:i", $lpOpen2);
						$newTimeClose1 = date("H:i", $lpClose2);
					}else{						
						$newTimeOpen1 = date('h:i A', $lpOpen2);
						$newTimeClose1 = date('h:i A', $lpClose2);
					}
					
					$lpOpen2 = strtotime(date("H:i", $lpOpen2));
					$lpClose2 = strtotime(date("H:i", $lpClose2));
					
					
					$thirdTearTime = false;
					$lpOpen3 = null;
					$lpClose3 = null;
					//3rd time
					if( !empty($timeDay3Open) && !empty($timeDay3Close) ){
						$thirdTearTime = true;
						$lpOpen3 = str_replace(' ', '', $timeDay3Open);
						$lpClose3 = str_replace(' ', '', $timeDay3Close);
						
						$lpOpen3 = strtotime($lpOpen3);
						$lpClose3 = strtotime($lpClose3);
						
						if(!empty($format) && $format == '24'){
							$newTimeOpen1 = date("H:i", $lpOpen3);
							$newTimeClose1 = date("H:i", $lpClose3);
						}else{						
							$newTimeOpen1 = date('h:i A', $lpOpen3);
							$newTimeClose1 = date('h:i A', $lpClose3);
						}
						
						$lpOpen3 = strtotime(date("H:i", $lpOpen3));
						$lpClose3 = strtotime(date("H:i", $lpClose3));
					}
					
					
					
					
					if(!empty($thirdTearTime)){
						if($time < $lpClose3){
							$isthirdTimeSlot = true;
							$todayIsOpen = true;
						}
					}elseif($time > $lpOpen1 || $time > $lpOpen2){
						
						if($time > $lpOpen1 && $time < $lpClose1){
							//first time
							$todayIsOpen = true;
							$isfistTimeSlot = true;
						}
						elseif($time > $lpOpen2){
							//second time
							if(!empty($todayIsNextD)){
								if($time < $lpClose2){
									$todayIsOpen = true;
									$issecondTimeSlot = true;
								}
							}else{
								if($time > $lpClose2){
									$todayIsOpen = true;
									$issecondTimeSlot = true;
								}
							}
							
							if(!empty($issecondTimeSlot)){
								$newTimeOpen = $newTimeOpen1;
								$newTimeClose = $newTimeClose1;
							}
						}
						
					}
					
					if( empty($opencheck) && empty($closecheck) ){
						if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ){
							echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
							echo '<span><a class="Opened">'.esc_html__('24 hours open','listingpro').'</a></span>';
							echo '</li>';
						}else{
							echo '<span class="lp-timing-status pull-right status-open">'.esc_html__('24 hours open','listingpro').'</span>';
						}

					}elseif(!empty($todayIsOpen)){
						//opened now
						if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ) {
							echo '<li class="today-timing clearfix"><strong>' . listingpro_icons('todayTime') . '</strong>';
							echo '<a class="Opened">' . esc_html__('Open Now~', 'listingpro') . '</a>';
							if( $listing_mobile_view == 'responsive_view' || !wp_is_mobile() ){
								echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
							}
						}else{
							echo '<span class="lp-timing-status status-open">'.esc_html__('Open Now~','listingpro').'</span>';
						}
					}else{
						//closed now
						if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ){
							echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
							echo '<a class="closed">'.esc_html__('Closed Now!','listingpro').'</a>';
							echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
						}
						else
						{
							echo '<span class="lp-timing-status status-close">'.esc_html__('Closed Now!','listingpro').'</span>';
							echo '<span class="lp-timings">' . $newTimeOpen . ' - ' . $newTimeClose . '</span>';
						}
					}
					
					
				}
				
			}
			/* only two times */
			elseif(!empty($twoDtime) && empty($doubleDtime)){
				$timeDay1Open = null;
				$timeDay1Close = null;
				$todayIsNextD = false;
				foreach($getTodayTimes as $thisK=>$thisV){
					
					if( (strpos($thisK, "-".$day)) ||  (strpos($thisK, "~".$day)) ){
						$todayIsNextD = true;
					}
					$timeDay1Open = $getTodayTimes[$thisK]['open'];
					$timeDay1Close = $getTodayTimes[$thisK]['close'];
				}
				
				$lpOpen1 = str_replace(' ', '', $timeDay1Open);
				$lpClose1 = str_replace(' ', '', $timeDay1Close);
				
				$lpOpen1 = strtotime($lpOpen1);
				$lpClose1 = strtotime($lpClose1);
				
				$opencheck = $lpOpen1;
				$closecheck = $lpClose1;
				
				if(!empty($format) && $format == '24'){
					$newTimeOpen = date("H:i", $lpOpen1);
					$newTimeClose = date("H:i", $lpClose1);
				}else{						
					$newTimeOpen = date('h:i A', $lpOpen1);
					$newTimeClose = date('h:i A', $lpClose1);
				}
				
				$lpOpen1 = strtotime(date("H:i", $lpOpen1));
				$lpClose1 = strtotime(date("H:i", $lpClose1));
				
				if($time > $lpOpen1){
					if(!empty($todayIsNextD)){
						if($time < $lpClose1){
							$todayIsOpen = true;
						}
					}else{
						if($time > $lpClose1){
							$todayIsOpen = true;
						}
					}
				}
				
					if( empty($opencheck) && empty($closecheck) ){
						if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ){
							echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
							echo '<span><a class="Opened">'.esc_html__('24 hours open','listingpro').'</a></span>';
							echo '</li>';
						}else{
							echo '<span class="lp-timing-status pull-right status-open">'.esc_html__('24 hours open','listingpro').'</span>';
						}

					}elseif(!empty($todayIsOpen)){
						//opened now
						if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ) {
							echo '<li class="today-timing clearfix"><strong>' . listingpro_icons('todayTime') . '</strong>';
							echo '<a class="Opened">' . esc_html__('Open Now~', 'listingpro') . '</a>';
							if( $listing_mobile_view == 'responsive_view' || !wp_is_mobile() ){
								echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
							}
						}else{
							echo '<span class="lp-timing-status status-open">'.esc_html__('Open Now~','listingpro').'</span>';
						}
					}else{
						//closed now
						if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ){
							echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
							echo '<a class="closed">'.esc_html__('Closed Now!','listingpro').'</a>';
							echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
						}
						else
						{
							echo '<span class="lp-timing-status status-close">'.esc_html__('Closed Now!','listingpro').'</span>';
							echo '<span class="lp-timings">' . $newTimeOpen . ' - ' . $newTimeClose . '</span>';
						}
					}
				
				
			}
			/* only double TIme and single time */
			elseif(!empty($getTodayTimes)){
				
				$timeDayOpens = null;
				$timeDayCloses = null;
				
				$timeDayOpen1 = null;
				$timeDayOpen2 = null;
				$timeDayClose1 = null;
				$timeDayClose2 = null;
				$isfistTimeSlot = false;
				$issecondTimeSlot = false;
				
				if(isset($getTodayTimes[$day]['open']) && isset($getTodayTimes[$day]['close'])){
					$timeDayOpens = $getTodayTimes[$day]['open'];
					$timeDayCloses = $getTodayTimes[$day]['close'];
				}
				
				if( is_array($timeDayOpens) && is_array($timeDayCloses) ){
					/* two times in single day */
					$timeDayOpen1 = $timeDayOpens[0];
					$timeDayOpen2 = $timeDayOpens[1];
					$timeDayClose1 = $timeDayCloses[0];
					$timeDayClose2 = $timeDayCloses[1];
					
					$lpOpen1 = str_replace(' ', '', $timeDayOpen1);
					$lpClose1 = str_replace(' ', '', $timeDayClose1);
					
					$lpOpen1 = strtotime($lpOpen1);
					$lpClose1 = strtotime($lpClose1);
					
					$opencheck = $lpOpen1;
					$closecheck = $lpClose1;
					
					if(!empty($format) && $format == '24'){
						$newTimeOpen = date("H:i", $lpOpen1);
						$newTimeClose = date("H:i", $lpClose1);
					}else{						
						$newTimeOpen = date('h:i A', $lpOpen1);
						$newTimeClose = date('h:i A', $lpClose1);
					}
					$lpOpen1 = strtotime(date("H:i", $lpOpen1));
					$lpClose1 = strtotime(date("H:i", $lpClose1));
					
					//2nd time
					$lpOpen2 = str_replace(' ', '', $timeDayOpen2);
					$lpClose2 = str_replace(' ', '', $timeDayClose2);
					
					$lpOpen2 = strtotime($lpOpen2);
					$lpClose2 = strtotime($lpClose2);
					
					if(!empty($format) && $format == '24'){
						$newTimeOpen1 = date("H:i", $lpOpen2);
						$newTimeClose1 = date("H:i", $lpClose2);
					}else{						
						$newTimeOpen1 = date('h:i A', $lpOpen2);
						$newTimeClose1 = date('h:i A', $lpClose2);
					}
					
					$lpOpen2 = strtotime(date("H:i", $lpOpen2));
					$lpClose2 = strtotime(date("H:i", $lpClose2));
					
					if($time > $lpOpen1 || $time > $lpOpen2){
						
						if($time > $lpOpen1 && $time < $lpClose1){
							//first time
							$todayIsOpen = true;
							$isfistTimeSlot = true;
							$issecondTimeSlot = false;
						}
						elseif($time > $lpOpen2 && $time < $lpClose2){
							//second time
							$todayIsOpen = true;
							$issecondTimeSlot = true;
							$isfistTimeSlot = false;
							
						}
						
						if(!empty($issecondTimeSlot)){
							$newTimeOpen = $newTimeOpen1;
							$newTimeClose = $newTimeClose1;
						}
						
					}
					
					if( empty($opencheck) && empty($closecheck) ){
						if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ){
							echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
							echo '<span><a class="Opened">'.esc_html__('24 hours open','listingpro').'</a></span>';
							echo '</li>';
						}else{
							echo '<span class="lp-timing-status pull-right status-open">'.esc_html__('24 hours open','listingpro').'</span>';
						}

					}elseif(!empty($todayIsOpen)){
						//opened now
						if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ) {
							echo '<li class="today-timing clearfix"><strong>' . listingpro_icons('todayTime') . '</strong>';
							echo '<a class="Opened">' . esc_html__('Open Now~', 'listingpro') . '</a>';
							if( $listing_mobile_view == 'responsive_view' || !wp_is_mobile() ){
								echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
							}
						}else{
							echo '<span class="lp-timing-status status-open">'.esc_html__('Open Now~','listingpro').'</span>';
						}
					}else{
						//closed now
						if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ){
							echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
							echo '<a class="closed">'.esc_html__('Closed Now!','listingpro').'</a>';
							echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
						}
						else
						{
							echo '<span class="lp-timing-status status-close">'.esc_html__('Closed Now!','listingpro').'</span>';
							echo '<span class="lp-timings">' . $newTimeOpen . ' - ' . $newTimeClose . '</span>';
						}
					}
					
					
				}else{
					/* single time in single day */
					$timeDayOpen1 = $timeDayOpens;
					$timeDayClose1 = $timeDayCloses;
					
					$lpOpen1 = str_replace(' ', '', $timeDayOpen1);
					$lpClose1 = str_replace(' ', '', $timeDayClose1);
					
					$lpOpen1 = strtotime($lpOpen1);
					$lpClose1 = strtotime($lpClose1);
					$opencheck = $lpOpen1;
					$closecheck = $lpClose1;
					
					if(!empty($format) && $format == '24'){
						$newTimeOpen = date("H:i", $lpOpen1);
						$newTimeClose = date("H:i", $lpClose1);
					}else{						
						$newTimeOpen = date('h:i A', $lpOpen1);
						$newTimeClose = date('h:i A', $lpClose1);
					}
					$lpOpen1 = strtotime(date("H:i", $lpOpen1));
					$lpClose1 = strtotime(date("H:i", $lpClose1));
					
					if($time > $lpOpen1 && $time < $lpClose1){
						$todayIsOpen = true;
					}
					
					if( empty($opencheck) && empty($closecheck) ){
						if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ){
							echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
							echo '<span><a class="Opened">'.esc_html__('24 hours open','listingpro').'</a></span>';
							echo '</li>';
						}else{
							echo '<span class="lp-timing-status pull-right status-open">'.esc_html__('24 hours open','listingpro').'</span>';
						}

					}elseif(!empty($todayIsOpen)){
						//opened now
						if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ) {
							echo '<li class="today-timing clearfix"><strong>' . listingpro_icons('todayTime') . '</strong>';
							echo '<a class="Opened">' . esc_html__('Open Now~', 'listingpro') . '</a>';
							if( $listing_mobile_view == 'responsive_view' || !wp_is_mobile() ){
								echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
							}
						}else{
							echo '<span class="lp-timing-status status-open">'.esc_html__('Open Now~','listingpro').'</span>';
						}
					}else{
						//closed now
						if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ){
							echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
							echo '<a class="closed">'.esc_html__('Closed Now!','listingpro').'</a>';
							echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
						}
						else
						{
							echo '<span class="lp-timing-status status-close">'.esc_html__('Closed Now!','listingpro').'</span>';
							echo '<span class="lp-timings">' . $newTimeOpen . ' - ' . $newTimeClose . '</span>';
						}
					}
					
					
				}
				
			}
			elseif(!empty($getTodayTimes) || empty($todayOFF)){
				
			}
			
			if($todayOFF == true){
				if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' ){
					echo '<li class="today-timing clearfix"><strong>' . listingpro_icons('todayTime') . ' ' . $day . '</strong>';
					echo '<span><a class="closed dayoff">' . esc_html__('Day Off!', 'listingpro') . '</a></span></li>';
				}else{
					echo '<span class="lp-timing-status pull-right status-close">'.esc_html__('Day Off!','listingpro').'</span>';
				}
			}
			
			/* end of newcode */
			
			
            if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
            {
                echo '</ul>';
            }
            else
            {
                echo '</div>';
            }
			
			/*===============================open time section ends=================== */

            if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
            {
                if ($listing_mobile_view == 'app_view' && wp_is_mobile()) {
                    echo '<a href="#" class="show-all-timings">' . esc_html__('Show More', 'listingpro') . '</a>';
                } else {
                    echo '<a href="#" class="show-all-timings">' . esc_html__('Show all timings', 'listingpro') . '</a>';
                }
            }
            if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
            {
                echo '<ul class="hidding-timings">';
            }
            else
            {
                echo '<ul class="lp-today-timing all-days-timings">';
            }
			
			foreach($buisness_hours as $key=>$value){
				$dayName = $key;
				$lpDayName = lp_get_translated_day($dayName);
				if( !empty($value['open']) && is_array($value['open']) && !empty($value['close']) && is_array($value['close']) ){
					/* double time */
					$twodays = explode('-', $key);
					
					if ( (strpos($key, '-') !== false) || (strpos($key, '~') !== false) ) {
					}
					else
                    {
                        if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
                        {
                            echo '<li class="clearfix lpdoubltimes"><strong>' . $lpDayName . '</strong>';
                        }
                        else
                        {
                            echo '<li class="clearfix"><strong>'.$lpDayName.'</strong>';
                            echo '<span  class="lp-timings">';
                        }
						if( isset($value['open'][0]) && isset($value['close'][0]) ){
							if( !empty($value['open'][0]) && !empty($value['close'][0]) ){
								$openlp1 = str_replace(' ', '', $value['open'][0]);
								$closelp1 = str_replace(' ', '', $value['close'][0]);
								$openlp1 = strtotime($openlp1);
								$closelp1 = strtotime($closelp1);
								if(!empty($format) && $format == '24'){
									$newTimeOpen = date("H:i", $openlp1);
									$newTimeClose = date("H:i", $closelp1);
								}else{						
									$newTimeOpen = date("h:i A", $openlp1);
									$newTimeClose = date("h:i A", $closelp1);
								}
                                if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
                                {
                                    echo '<span>' . $newTimeOpen;
                                    echo ' - ' . $newTimeClose . '</span>';
                                }
                                else
                                {
                                    echo $newTimeOpen.' - ' . $newTimeClose;
                                }
								
								foreach($buisness_hours as $keyy=>$valuee){
									if( (strpos($key, "-$day") !== false) || (strpos($key, "~$day") !== false) ){
										if ( (strpos($keyy, '-') !== false) || (strpos($keyy, '~') !== false) ) {
											if ( strpos($keyy, '-') !== false){
												list($dayName) = explode('-', $dayName);
											}elseif(strpos($keyy, '~') !== false){
												list($dayName) = explode('~', $dayName);
											}
											
											if($key==$dayName){
												if( isset($valuee['open'][0]) && isset($valuee['close'][0]) ){
													if( !empty($valuee['open'][0]) && !empty($valuee['close'][0]) ){
														$newTimeOpend = '';
														$newTimeClosed = '';
														$openlpp1 = str_replace(' ', '', $valuee['open'][0]);
														$closelpp1 = str_replace(' ', '', $valuee['close'][0]);
														$openlpp1 = strtotime($openlpp1);
														$closelpp1 = strtotime($closelpp1);
														if( !empty($openlpp1) && !empty($closelpp1) ){
															if(!empty($format) && $format == '24'){
																$newTimeOpend = date("H:i", $openlpp1);
																$newTimeClosed = date("H:i", $closelpp1);
															}else{						
																$newTimeOpend = date("h:i A", $openlpp1);
																$newTimeClosed = date("h:i A", $closelpp1);
															}
															echo '<em>'.$newTimeOpend;
															echo ' - '.$newTimeClosed.'</em>';
														}
														
														
													}
												}
												if( isset($valuee['open'][1]) && isset($valuee['close'][1]) ){
													if( !empty($valuee['open'][1]) && !empty($valuee['close'][1]) ){
														$openlpp2 = str_replace(' ', '', $valuee['open'][1]);
														$closelpp2 = str_replace(' ', '', $valuee['close'][1]);
														$openlpp2 = strtotime($openlpp2);
														$closelpp2 = strtotime($closelpp2);
														if(!empty($format) && $format == '24'){
															$newTimeOpen = date("H:i", $openlpp2);
															$newTimeClose = date("H:i", $closelpp2);
														}else{						
															$newTimeOpen = date("h:i A", $openlpp2);
															$newTimeClose = date("h:i A", $closelpp2);
														}
                                                        if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
                                                        {
                                                            echo '<em>' . $newTimeOpen;
                                                            echo ' - ' . $newTimeClose . '</em>';
                                                        }
                                                        else
                                                        {
                                                            echo '<br>'. $newTimeOpen.' - ' . $newTimeClose;
                                                        }
													}
												}
												break;
											}
										}
									}
								}
							}
						}
						
						if( isset($value['open'][1]) && isset($value['close'][1]) ){
							if( !empty($value['open'][1]) && !empty($value['close'][1]) ){
								$openlp1 = str_replace(' ', '', $value['open'][1]);
								$closelp1 = str_replace(' ', '', $value['close'][1]);
								$openlp1 = strtotime($openlp1);
								$closelp1 = strtotime($closelp1);
								if(!empty($format) && $format == '24'){
									$newTimeOpen = date("H:i", $openlp1);
									$newTimeClose = date("H:i", $closelp1);
								}else{						
									$newTimeOpen = date("h:i A", $openlp1);
									$newTimeClose = date("h:i A", $closelp1);
								}

                                if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
                                {
                                    echo '<em>' . $newTimeOpen;
                                    echo ' - ' . $newTimeClose . '</em>';
                                }
                                else
                                {
                                    echo '<br>'. $newTimeOpen.' - ' . $newTimeClose;
                                                        }
							}
						}
                        if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
                        {
                            echo '</li>';
                        }
                        else
                        {
                            echo '</span></li>';
                        }
					}
					
				}
				else{
					/* single time */
					$opencheck = $value['open'];
					$open = $value['open'];
					$open = str_replace(' ', '', $open);
					$close = $value['close'];
					$closecheck = $value['close'];
					$close = str_replace(' ', '', $close);
					$open = strtotime($open);
					$close = strtotime($close);
					if(!empty($format) && $format == '24'){
						$newTimeOpen = date("H:i", $open);
						$newTimeClose = date("H:i", $close);
					}else{						
						$newTimeOpen = date('h:i A', $open);
						$newTimeClose = date('h:i A', $close);
					}
					if ( strpos($dayName, '-') !== false ){
						list($dayName) = explode('-', $dayName);
					}
					if ( strpos($dayName, '~') !== false ){
						list($dayName) = explode('~', $dayName);
					}
					$lpDayName = lp_get_translated_day($dayName);
					echo '<li><strong>'.$lpDayName.'</strong>';

					if(!empty($opencheck)&& !empty($closecheck)){
                        if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
                        {
                            echo '<span>' . $newTimeOpen . ' - ' . $newTimeClose . '</span></li>';
                        }
                        else
                        {
                            echo '<span class="lp-timings">' . $newTimeOpen . ' - ' . $newTimeClose . '</span></li>';
                        }
					}
					else
                    {
                        if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
                        {
                            echo '<span class="Opened">' . esc_html__('24 hours open', 'listingpro') . '</span></li>';
                        }
                        else
                        {
                            echo '<span class="lp-timing-status pull-right status-open">'.esc_html__('24 hours open', 'listingpro').'</span></li>';
                        }
					}
				}
				
				
			}
			echo '</ul>';
            if( $listing_style == 'lp_detail_page_styles3' || $listing_style == 'lp_detail_page_styles4' )
            {
                echo '<a data-contract="'. esc_html__( 'Contract', 'listingpro' ) .'" data-expand="'. esc_html__( 'Expand', 'listingpro' ) .'" href="#" class="toggle-all-days"><i class="fa fa-plus" aria-hidden="true"></i> '. esc_html__( 'Expand', 'listingpro' ) .'</a>';
            }
            if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
            {
                echo '</div>';
            }
			
		}
		
	?>
<?php
if( $listing_style != 'lp_detail_page_styles3' && $listing_style != 'lp_detail_page_styles4' )
{
?>
    </div>
<?php
}
?>
