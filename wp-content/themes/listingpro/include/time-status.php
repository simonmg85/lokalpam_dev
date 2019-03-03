<?php 
				
	/* ============== Check TIme ============ */
	
	if (!function_exists('listingpro_check_time')) {
		function listingpro_check_time($postid,$status = false) {
			global $listingpro_options;
            $listing_layout = $listingpro_options['listing_views'];
		    $output='';
			$buisness_hours = listing_get_metabox_by_ID('business_hours', $postid);
			$twodays = array();
			
			/* echo '<pre>';
			print_r($buisness_hours);
			echo '</pre>'; */

			if(!empty($buisness_hours) && count($buisness_hours)>0){
				
				//$lat = listing_get_metabox('latitude');
				//$long = listing_get_metabox('longitude');
				
				//$timezone = getClosestTimezone($lat, $long);
				$timezone  = get_option('gmt_offset');
				$time = gmdate("H:i", time() + 3600*($timezone+date("I"))); 
				$day =  gmdate("l");
				$time = strtotime($time);
				$lang = get_locale();
				setlocale(LC_ALL, $lang.'.utf-8');
				$day = strftime("%A");
				$day = date_i18n( 'l', strtotime( '11/15-1976' ) );
				$day = ucfirst($day);
				$opennow = false;
				$todayOFF = true;
				$todayIsOpen = false;
				$twodays = array();
				$todayIsOpen = false;
				$todaycompleteopend = false;
				$newTimeOpen;
				$newTimeClose;
				$newTimeOpen1;
				$newTimeClose1;
				$totimesinaday = false;
				
				foreach($buisness_hours as $key=>$value){
				$keyArray[] = $key;
				
				if ( (strpos($key, $day."-") !== false) || (strpos($key, "-$day") !== false) || (strpos($key, $day."~") !== false) || (strpos($key, "~$day") !== false) ) {
					/* double day values */
					if((strpos($key, $day."-") !== false) || (strpos($key, "-$day") !== false)){
						$twodays = explode('-', $key);
					}elseif((strpos($key, $day."~") !== false) || (strpos($key, "~$day") !== false)){
						$twodays = explode('~', $key);
					}
					if(empty($dayToday)){
						list($dayToday) = explode('~', $key);
					}
					if( !empty($value['open']) && !empty($value['close']) ){
						
						/* if array */
						if( is_array($value['open']) && is_array($value['close']) ){
							$todayOFF = false;
							$lpOpen1 = '';
							$lpOpen2 = '';
							$lpClose1 = '';
							$lpClose2 = '';
							if( isset($value['open'][0]) && isset($value['close'][0]) ){
								if( !empty($value['open'][0]) && !empty($value['close'][0]) ){
									$lpOpen1 = $value['open'][0];
									$lpClose1 = $value['close'][0];
									$opencheck = $lpOpen1;
									$closecheck = $lpClose1;
									
									$lpOpen1 = str_replace(' ', '', $lpOpen1);
									$lpClose1 = str_replace(' ', '', $lpClose1);
									
									$lpOpen1 = strtotime($lpOpen1);
									$lpClose1 = strtotime($lpClose1);
									
									if(!empty($format) && $format == '24'){
										$newTimeOpen = date("H:i", $lpOpen1);
										$newTimeClose = date("H:i", $lpClose1);
									}else{						
										$newTimeOpen = date('h:i A', $lpOpen1);
										$newTimeClose = date('h:i A', $lpClose1);
									}
								
									$todayD = $twodays[0];
									$tomorrowD = $twodays[1];
									
									if($day==$todayD){
										if( ($time > $lpOpen1) ){
											$todayIsOpen = true;
										}
										
									}
									if($day==$tomorrowD){
										if( ($time < $lpClose1) ){
											$todayIsOpen = true;
										}
									}
									
									$nextdayhas = false;
									
									foreach($buisness_hours as $kkey=>$nval){
										if( (strpos($key, "-$day") !== false) || (strpos($key, "~$day") !== false) ){
											if((strpos($kkey, $day."-") !== false) || (strpos($kkey, $day."~") !== false) ){
												$nextdayhas = true;
											}elseif(strpos($kkey, "$day") !== false){
												$nextdayhas = true;
											}
										}
									}
									
									
									if( ($todayIsOpen==false) && ($nextdayhas==true) ){
										continue;
										
									}else{
									
										if( empty($opencheck) && empty($closecheck) ){
										    if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
										    {
                                                if($status == false)
                                                {
                                                    $output =   '<a title="24 hours open" class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-green "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('24 Hours Open', 'listingpro') .'</a>';
                                                }
                                                else
                                                {
                                                   $output = 'open';
                                                }
                                            }
                                            else
                                            {
                                                if($status == false){
                                                    $output = '<span class="grid-opened">'.esc_html__('24 hours open','listingpro').'</span>';
                                                }else{
                                                    $output = 'open';
                                                }
                                            }

											break;
										}
										elseif($todayOFF==false && $todayIsOpen==true){

                                            if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                            {
                                                if($status == false)
                                                {
                                                    $output =   '<a title="Open Now~" class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-green "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Open Now~', 'listingpro') .'</a>';
                                                }
                                                else
                                                {
                                                    $output = 'open';
                                                }
                                            }
                                            else
                                            {
                                                if($status == false){
                                                    $output = '<span class="grid-opened">'.esc_html__('Open Now~','listingpro').'</span>';
                                                }else{
                                                    $output = 'open';
                                                }
                                            }


											break;
										}
										
										elseif($todayOFF==false && $todayIsOpen==false){
                                            if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                            {
                                                if($status == false)
                                                {
                                                    $output =   '<a title="Closed Now~" class="lp-open-timing li-listing-clock-outer li-listing-clock red-tooltip status-red "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Closed Now!', 'listingpro') .'</a>';
                                                }
                                                else
                                                {
                                                    $output = 'close';
                                                }
                                            }
                                            else
                                            {
                                                if($status == false){
                                                    $output = '<span class="grid-closed">'.esc_html__('Closed Now!','listingpro').'</span>';
                                                }else{
                                                    $output = 'close';
                                                }
                                            }

											break;
										}
									}
									
								}
								
							}
							
							if( isset($value['open'][1]) && isset($value['close'][1]) ){
								if( !empty($value['open'][1]) && !empty($value['close'][1]) ){
									if( !empty($value['open'][1]) && !empty($value['close'][1]) ){
										$lpOpen2 = $value['open'][1];
										$lpClose2 = $value['close'][1];
										$opencheck = $lpOpen2;
										$closecheck = $lpClose2;
										
										$lpOpen2 = str_replace(' ', '', $lpOpen2);
										$lpClose2 = str_replace(' ', '', $lpClose2);
										
										$lpOpen2 = strtotime($lpOpen2);
										$lpClose2 = strtotime($lpClose2);
										
										if(!empty($format) && $format == '24'){
											$newTimeOpen = date("H:i", $lpOpen2);
											$newTimeClose = date("H:i", $lpClose2);
										}else{						
											$newTimeOpen = date('h:i A', $lpOpen2);
											$newTimeClose = date('h:i A', $lpClose2);
										}
										$todayD = $twodays[0];
										$tomorrowD = $twodays[1];
										
										if($day==$todayD){
											if( ($time > $lpOpen2) ){
												$todayIsOpen = true;
											}
											
										}
										if($day==$tomorrowD){
											if( ($time < $lpClose2) ){
												$todayIsOpen = true;
											}
										}
										
										$nextdayhas = false;
									
										foreach($buisness_hours as $kkey=>$nval){
											if( (strpos($key, "-$day") !== false) || (strpos($key, "~$day") !== false) ){
												if( (strpos($kkey, $day."-") !== false) || (strpos($kkey, $day."~") !== false)  ){
													$nextdayhas = true;
												}elseif(strpos($kkey, "$day") !== false){
													$nextdayhas = true;
												}
											}
										}
										
										
										if( ($todayIsOpen==false) && ($nextdayhas==true) ){
											continue;
											
										}else{

											if( empty($opencheck) && empty($closecheck) ){
												if($status == false){
													$output = '<span class="grid-opened">'.esc_html__('24 hours open','listingpro').'</span>';
												}else{
													$output = 'open';
												}
												break;
											}
											elseif($todayOFF==false && $todayIsOpen==true){
                                                if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                                {
                                                    if($status == false)
                                                    {
                                                        $output =   '<a title="Open Now~" class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-green "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Open Now~', 'listingpro') .'</a>';
                                                    }
                                                    else
                                                    {
                                                        $output = 'open';
                                                    }
                                                }
                                                else
                                                {
                                                    if($status == false){
                                                        $output = '<span class="grid-opened">'.esc_html__('Open Now~','listingpro').'</span>';
                                                    }else{
                                                        $output = 'open';
                                                    }
                                                }

												break;
											}
											
											elseif($todayOFF==false && $todayIsOpen==false){
                                                if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                                {
                                                    if($status == false)
                                                    {
                                                        $output =   '<a title="closed now~" class="lp-open-timing li-listing-clock-outer li-listing-clock red-tooltip status-red "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Closed Now~', 'listingpro') .'</a>';
                                                    }
                                                    else
                                                    {
                                                        $output = 'close';
                                                    }
                                                }
                                                else
                                                {
                                                    if($status == false){
                                                        $output = '<span class="grid-closed">'.esc_html__('Closed Now!','listingpro').'</span>';
                                                    }else{
                                                        $output = 'close';
                                                    }
                                                }

												break;
											}
										}
										
										
										
									}
								}
								
							}
						}
						/* if not array */
						else{
							
							$lpOpen = '';
							$lpClose = '';
							if( isset($value['open']) && isset($value['close']) ){
								if( !empty($value['open']) && !empty($value['close']) ){
									$todayOFF = false;
									$lpOpen = $value['open'];
									$lpClose = $value['close'];
									$opencheck = $lpOpen;
									$closecheck = $lpClose;
									
									$lpOpen = str_replace(' ', '', $lpOpen);
									$lpClose = str_replace(' ', '', $lpClose);
									
									$lpOpen = strtotime($lpOpen);
									$lpClose = strtotime($lpClose);
									
									if(!empty($format) && $format == '24'){
										$newTimeOpen = date("H:i", $lpOpen);
										$newTimeClose = date("H:i", $lpClose);
									}else{						
										$newTimeOpen = date('h:i A', $lpOpen);
										$newTimeClose = date('h:i A', $lpClose);
									}
									
									$todayD = $twodays[0];
									$tomorrowD = $twodays[1];
									/* echo '<br>';
									echo $tomorrowD; */
									if($day==$todayD){
										if( ($time > $lpOpen) ){
											$todayIsOpen = true;
										}
										
									}
									if($day==$tomorrowD){
										if( ($time < $lpClose) ){
											$todayIsOpen = true;
										}
									}
									
									$nextdayhas = false;
									
									foreach($buisness_hours as $kkey=>$nval){
										if( (strpos($key, "-$day") !== false) || (strpos($key, "~$day") !== false) ){
											if( (strpos($kkey, $day."-") !== false) || (strpos($kkey, $day."~") !== false)){
												$nextdayhas = true;
											}elseif(strpos($kkey, "$day") !== false){
												$nextdayhas = true;
											}
										}
									}
									
									
									if( ($todayIsOpen==false) && ($nextdayhas==true) ){
										continue;
										
									}else{

										if( empty($opencheck) && empty($closecheck) ){
                                            if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                            {
                                                if($status == false)
                                                {
                                                    $output =   '<a title="24 hours open" class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-green "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('24 Hours Open', 'listingpro') .'</a>';
                                                }
                                                else
                                                {
                                                    $output = 'open';
                                                }
                                            }
                                            else
                                            {
                                                if($status == false){
                                                    $output = '<span class="grid-opened">'.esc_html__('24 hours open','listingpro').'</span>';
                                                }else{
                                                    $output = 'open';
                                                }
                                            }

											break;
										}
										elseif($todayOFF==false && $todayIsOpen==true){
                                            if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                            {
                                                if($status == false)
                                                {
                                                    $output =   '<a title="open now~" class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-green "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Open Now~', 'listingpro') .'</a>';
                                                }
                                                else
                                                {
                                                     $output = 'open';
                                                }
                                            }
                                            else
                                            {
                                                if($status == false){
                                                    $output = '<span class="grid-opened">'.esc_html__('Open Now~','listingpro').'</span>';
                                                }else{
                                                    $output = 'open';
                                                }
                                            }

											break;
										}
										
										elseif($todayOFF==false && $todayIsOpen==false){
                                            if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                            {
                                                if($status == false)
                                                {
                                                    $output =   '<a title="close now~" class="lp-open-timing li-listing-clock-outer li-listing-clock red-tooltip status-red "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Closed Now!', 'listingpro') .'</a>';
                                                }
                                                else
                                                {
                                                     $output = 'close';
                                                }
                                            }
                                            else
                                            {
                                                if($status == false){
                                                    $output = '<span class="grid-closed">'.esc_html__('Closed Now!','listingpro').'</span>';
                                                }else{
                                                    $output = 'close';
                                                }
                                            }

											break;
										}
									}
									
								}
								
							}
							
						}
					}
				}
				else{
					/* single day values */
					if( !empty($value['open']) && !empty($value['close']) ){
						/* if array */
						if( is_array($value['open']) && is_array($value['close']) ){
							if($day == $key){
								$todayOFF = false;
								$lpOpen1 = '';
								$lpOpen2 = '';
								$lpClose1 = '';
								$lpClose2 = '';
								if( isset($value['open'][0]) && isset($value['close'][0]) ){
									if( !empty($value['open'][0]) && !empty($value['close'][0]) ){
										$lpOpen1 = $value['open'][0];
										$lpClose1 = $value['close'][0];
										$opencheck = $lpOpen1;
										$closecheck = $lpClose1;
										
										$lpOpen1 = str_replace(' ', '', $lpOpen1);
										$lpClose1 = str_replace(' ', '', $lpClose1);
										
										$lpOpen1 = strtotime($lpOpen1);
										$lpClose1 = strtotime($lpClose1);
										
										if(!empty($format) && $format == '24'){
											$newTimeOpen = date("H:i", $lpOpen1);
											$newTimeClose = date("H:i", $lpClose1);
										}else{						
											$newTimeOpen = date('h:i A', $lpOpen1);
											$newTimeClose = date('h:i A', $lpClose1);
										}
										
										if( $time > $lpOpen1 && $time < $lpClose1 ){
											$todayIsOpen = true;
										}
										
										if( ($todayIsOpen==false) && (isset($value['open'][1]) && isset($value['close'][1]) ) ){
										
										}else{
										
											if( empty($opencheck) && empty($closecheck) ){
                                                if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                                {
                                                    if($status == false)
                                                    {
                                                        $output =   '<a title="24 hours open" class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-green "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('24 Hours Open', 'listingpro') .'</a>';
                                                    }
                                                    else
                                                    {
                                                        $output = 'open';
                                                    }
                                                }
                                                else
                                                {
                                                    if($status == false){
                                                        $output = '<span class="grid-opened">'.esc_html__('24 hours open','listingpro').'</span>';
                                                    }else{
                                                        $output = 'open';
                                                    }
                                                }

												break;
											}
											elseif($todayOFF==false && $todayIsOpen==true){
                                                if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                                {
                                                    if($status == false)
                                                    {
                                                        $output =   '<a title="open now~" class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-green "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Open Now~', 'listingpro') .'</a>';
                                                    }
                                                    else
                                                    {
                                                        $output = 'open';
                                                    }
                                                }
                                                else
                                                {
                                                    if($status == false){
                                                        $output = '<span class="grid-opened">'.esc_html__('Open Now~','listingpro').'</span>';
                                                    }else{
                                                        $output = 'open';
                                                    }
                                                }

												break;
											}
											
											elseif($todayOFF==false && $todayIsOpen==false){
                                                if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                                {
                                                    if($status == false)
                                                    {
                                                        $output =   '<a title="closed now~" class="lp-open-timing li-listing-clock-outer li-listing-clock red-tooltip status-red "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Closed Now!', 'listingpro') .'</a>';
                                                    }
                                                    else
                                                    {
                                                        $output = 'close';
                                                    }
                                                }
                                                else
                                                {
                                                    if($status == false){
                                                        $output = '<span class="grid-closed">'.esc_html__('Closed Now!','listingpro').'</span>';
                                                    }else{
                                                        $output = 'close';
                                                    }
                                                }

												break;
											}
										}
										
									}
								}
								
								if( isset($value['open'][1]) && isset($value['close'][1]) ){
									if( !empty($value['open'][1]) && !empty($value['close'][1]) ){
										if( !empty($value['open'][1]) && !empty($value['close'][1]) ){
											$lpOpen2 = $value['open'][1];
											$lpClose2 = $value['close'][1];
											$opencheck = $lpOpen2;
											$closecheck = $lpClose2;
											
											$lpOpen2 = str_replace(' ', '', $lpOpen2);
											$lpClose2 = str_replace(' ', '', $lpClose2);
											
											$lpOpen2 = strtotime($lpOpen2);
											$lpClose2 = strtotime($lpClose2);
											
											if(!empty($format) && $format == '24'){
												$newTimeOpen = date("H:i", $lpOpen2);
												$newTimeClose = date("H:i", $lpClose2);
											}else{						
												$newTimeOpen = date('h:i A', $lpOpen2);
												$newTimeClose = date('h:i A', $lpClose2);
											}
											if( $time > $lpOpen2 && $time < $lpClose2 ){
												$todayIsOpen = true;
											}
											
											
											if( empty($opencheck) && empty($closecheck) ){
                                                if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                                {
                                                    if($status == false)
                                                    {
                                                        $output =   '<a title="24 hours open" class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-green "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('24 Hours Open', 'listingpro') .'</a>';
                                                    }
                                                    else
                                                    {
                                                        $output = 'open';
                                                    }
                                                }
                                                else
                                                {
                                                    if($status == false){
                                                        $output = '<span class="grid-opened">'.esc_html__('24 hours open','listingpro').'</span>';
                                                    }else{
                                                        $output = 'open';
                                                    }
                                                }

												break;
											}
											elseif($todayOFF==false && $todayIsOpen==true){
                                                if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                                {
                                                    if($status == false)
                                                    {
                                                        $output =   '<a title="open now~" class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-green "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Open Now~', 'listingpro') .'</a>';
                                                    }
                                                    else
                                                    {
                                                        $output = 'open';
                                                    }
                                                }
                                                else
                                                {
                                                    if($status == false){
                                                        $output = '<span class="grid-opened">'.esc_html__('Open Now~','listingpro').'</span>';
                                                    }else{
                                                        $output = 'open';
                                                    }
                                                }

												break;
											}
											
											elseif($todayOFF==false && $todayIsOpen==false){
                                                if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                                {
                                                    if($status == false)
                                                    {
                                                        $output =   '<a title="close now~" class="lp-open-timing li-listing-clock-outer li-listing-clock red-tooltip status-red "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Closed Now!', 'listingpro') .'</a>';
                                                    }
                                                    else
                                                    {
                                                        $output = 'close';
                                                    }
                                                }
                                                else
                                                {
                                                    if($status == false){
                                                        $output = '<span class="grid-closed">'.esc_html__('Closed Now!','listingpro').'</span>';
                                                    }else{
                                                        $output = 'close';
                                                    }
                                                }

												break;
											}
											
											
											
										}
									}
									
								}
							}	
							
						}
						/* if not array */
						else{
							
							if($day == $key){
							
								$opencheck = $value['open'];
								$open = $value['open'];
								$open = str_replace(' ', '', $open);
								$close = $value['close'];
								$closecheck = $value['close'];
								$close = str_replace(' ', '', $close);
								
								if(!empty($open) && !empty($close)){
									$todayOFF=false;
									$open = strtotime($open);
									$close = strtotime($close);
									if(!empty($format) && $format == '24'){
										$newTimeOpen = date("H:i", $open);
										$newTimeClose = date("H:i", $close);
									}else{						
										$newTimeOpen = date('h:i A', $open);
										$newTimeClose = date('h:i A', $close);
									}
									if( $time > $open && $time < $close ){
										$todayIsOpen = true;
									}
									
									if( empty($opencheck) && empty($closecheck) ){
                                        if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                        {
                                            if($status == false)
                                            {
                                                $output =   '<a title="24 hours open" class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-green "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('24 Hours Open', 'listingpro') .'</a>';
                                            }
                                            else
                                            {
                                                $output = 'open';
                                            }
                                        }
                                        else
                                        {
                                            if($status == false){
                                                $output = '<span class="grid-opened">'.esc_html__('24 hours open','listingpro').'</span>';
                                            }else{
                                                $output = 'open';
                                            }
                                        }

										break;
									}
									elseif($todayOFF==false && $todayIsOpen==true){
                                        if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                        {
                                            if($status == false)
                                            {
                                                $output =   '<a title="open now~" class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-green "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Open Now~', 'listingpro') .'</a>';
                                            }
                                            else
                                            {
                                                $output = 'open';
                                            }
                                        }
                                        else
                                        {
                                            if($status == false){
                                                $output = '<span class="grid-opened">'.esc_html__('Open Now~','listingpro').'</span>';
                                            }else{
                                                $output = 'open';
                                            }
                                        }

										break;
									}
									
									elseif($todayOFF==false && $todayIsOpen==false){
                                        if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                                        {
                                            if($status == false)
                                            {
                                                $output =   '<a title="close now" class="lp-open-timing li-listing-clock-outer li-listing-clock red-tooltip status-red "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Closed Now!', 'listingpro') .'</a>';
                                            }
                                            else
                                            {
                                                $output = 'close';
                                            }
                                        }
                                        else
                                        {
                                            if($status == false){
                                                $output = '<span class="grid-closed">'.esc_html__('Closed Now!','listingpro').'</span>';
                                            }else{
                                                $output = 'close';
                                            }
                                        }

										break;
									}
											
								}
								
							}
						}
					}
					else{
						if($day == $key){
                            if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                            {
                                if($status == false)
                                {
                                    $output =   '<a title="24 hours open" class="lp-open-timing li-listing-clock-outer li-listing-clock green-tooltip status-green "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('24 Hours Open', 'listingpro') .'</a>';
                                }
                                else
                                {
                                    $output = 'open';
                                }
                            }
                            else
                            {
                                if($status == false){
                                    $output =  '<span class="grid-opened">'.esc_html__('24 hours open','listingpro').'</span>';
                                    break;
                                }else{
                                    $output = 'open';
                                }
                            }

						}
					}
				}
				
			}
				
			if(is_array($keyArray) && !in_array($day, $keyArray) && $todayOFF== true ){
                if( $listing_layout == 'list_view_v2' || $listing_layout == 'grid_view_v2' )
                {
                    $output =   '<a title="day off" class="lp-open-timing li-listing-clock-outer li-listing-clock red-tooltip status-red "><i class="fa fa-clock-o" aria-hidden="true"></i> '. esc_html__('Day Off!', 'listingpro') .'</a>';
                }
                else
                {
                    $output = '<span class="grid-closed">'.esc_html__('Day Off!','listingpro').'</span>';
                }

			}
			}else{
				if($status == true){
                    $output = 'close';


				}
			}
			return $output;
		}
	}