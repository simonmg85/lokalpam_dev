<?php						
if( !function_exists('LP_operational_hours_form') ){
	function LP_operational_hours_form($postID,$edit){
		$output = '';
		$MondayOpen = '';
		$MondayClose = '';
		$TusedayOpen = '';
		$TusedayClose = '';
		$WednesdayOpen = '';
		$WednesdayClose = '';
		$ThursdayOpen = '';
		$ThursdayClose = '';
		$FridayOpen = '';
		$FridayClose = '';
		$SaturdayOpen = '';
		$SaturdayClose = '';
		$SundayOpen = '';
		$SundayClose = '';
		
		$MondayEnabled = 'disabled';
		$Mondaychecked = '';
		$TusedayEnabled = 'disabled';
		$Tusedaychecked = '';
		$WednesdayEnabled = 'disabled';
		$Wednesdaychecked = '';
		$ThursdayEnabled = 'disabled';
		$Thursdaychecked = '';
		$FridayEnabled = 'disabled';
		$Fridaychecked = '';
		$SaturdayEnabled = 'disabled';
		$Saturdaychecked = '';
		$SundayEnabled = 'disabled';
		$Sundaychecked = '';
		global $listingpro_options;
		
		// added for style2 button text
        $page_style =   $listingpro_options['listing_submit_page_style'];
        $add_hour_st = '';
        $removeStr      =   esc_html__( 'Remove', 'listingpro' );
        $removeData     =   esc_html__( 'Remove', 'listingpro' );
        if($page_style == 'style2'){
            $add_hour_st    =   'lp-add-hours-st';
            $removeStr      =   '<i class="fa fa-times"></i>';
        }
		$listingOphText = $listingpro_options['listing_oph_text'];
		$listing2timeslots = $listingpro_options['lp_hours_slot2'];
			$output .='
				
				<div class="form-group clearfix">
					<div class="day-hours" id="day-hours-BusinessHours" data-lpenabletwotimes="'.$listing2timeslots.'">
						<div class="hours-display">';
		if($edit == true && !empty($postID)){
			$buisness_hours = listing_get_metabox_by_ID('business_hours', $postID);
			
			if(!empty($buisness_hours)){	
				foreach($buisness_hours as $key=>$value){
						$output .='		<div class="hours">';
							if( !empty($value['open'])&& !empty($value['close'])){
								
								if( is_array($value['open']) && is_array($value['close']) ){
									
										$output .='<span class="weekday">'.$key.'</span>';
										if( isset($value['open'][0]) && isset($value['close'][0]) ){
											$output .='<span class="start">'.$value['open'][0].'</span>
											<input name="business_hours['.$key.'][open][0]" value="'.$value['open'][0].'" type="hidden">';
											$output .='<span>-</span>';
											$output .='<span class="end">'.$value['close'][0].'</span>
											<input name="business_hours['.$key.'][close][0]" value="'.$value['close'][0].'" type="hidden">';
										}
										
										if( isset($value['open'][1]) && isset($value['close'][1]) ){
									
											$output .='<span class="start">'.$value['open'][1].'</span>
											<input name="business_hours['.$key.'][open][1]" value="'.$value['open'][1].'" type="hidden">';
											$output .='<span>-</span>';
											$output .='<span class="end">'.$value['close'][1].'</span>
											<input name="business_hours['.$key.'][close][1]" value="'.$value['close'][1].'" type="hidden">';
										}
									
									$output .='<a class="remove-hours" href="#">'.$removeStr.'</a>';
									$output .='</div>';
									
								}else{
									$output .='
										<span class="weekday">'.$key.'</span>
										<span class="start">'.$value['open'].'</span>
										<span>-</span>
										<span class="end">'.$value['close'].'</span>
										<input name="business_hours['.$key.'][open]" value="'.$value['open'].'" type="hidden">
										<input name="business_hours['.$key.'][close]" value="'.$value['close'].'" type="hidden">
										<a class="remove-hours" href="#">'.$removeStr.'</a>
								        </div>
									';
								}
							}
							else{
								$output .='
									<span class="weekday">'.$key.'</span>
									<span class="start-end fullday">
									'.esc_html__('24 hours open', 'listingpro-plugin').'
									<input name="business_hours['.$key.'][open]" value="" type="hidden">
									<input name="business_hours['.$key.'][close]" value="" type="hidden">
									</span>
								';
								$output .='<a class="remove-hours" href="#">'.$removeStr.'</i></a>';
								$output .='</div>';
							}
			                
							/* if( !empty($value['open'])&& !empty($value['close'])){
								if( is_array($value['open']) && is_array($value['close']) ){
									$output .='<span>-</span>';
									foreach( $value['close'] as $valclose ){
										$output .='<span class="end">'.$valclose.'</span>
										<input name="business_hours['.$key.'][close]" value="'.$valclose.'" type="hidden">';
									}
									$output .='<a class="remove-hours" href="#">'.esc_html__( 'Remove', 'listingpro-plugin' ).'</a>';
									$output .='	
									</div>';
									
								}else{								
									$output .='<span>-</span>
										<span class="end">'.$value['close'].'</span>
										<a class="remove-hours" href="#">'.esc_html__( 'Remove', 'listingpro-plugin' ).'</a>';
											$output .='
												<input name="business_hours['.$key.'][open]" value="'.$value['open'].'" type="hidden">
												<input name="business_hours['.$key.'][close]" value="'.$value['close'].'" type="hidden">
											';
									$output .='	
									</div>';
								}
							} */
							
					
				}
			}
		}else{
		$output .='
				       
			                <div class="hours">
			                	<span class="weekday">'.esc_html__( 'Monday', 'listingpro-plugin' ).'</span>
			                	<span class="start">09:00</span>
			                	<span>-</span>
			                	<span class="end">17:00</span>
			                	<a class="remove-hours" href="#">'.$removeStr.'</i></a>
			                	<input name="business_hours['.esc_html__( 'Monday', 'listingpro-plugin' ).'][open]" value="09:00" type="hidden">
			                	<input name="business_hours['.esc_html__( 'Monday', 'listingpro-plugin' ).'][close]" value="17:00" type="hidden">
			                </div>
			                <div class="hours">
			                	<span class="weekday">'.esc_html__( 'Tuesday', 'listingpro-plugin' ).'</span>
			                	<span class="start">09:00</span>
			                	<span>-</span>
			                	<span class="end">17:00</span>
			                	<a class="remove-hours" href="#">'.$removeStr.'</a>
			                	<input name="business_hours['.esc_html__( 'Tuesday', 'listingpro-plugin' ).'][open]" value="09:00" type="hidden">
			                	<input name="business_hours['.esc_html__( 'Tuesday', 'listingpro-plugin' ).'][close]" value="17:00" type="hidden">
			                </div>
			                <div class="hours">
			                	<span class="weekday">'.esc_html__( 'Wednesday', 'listingpro-plugin' ).'</span>
			                	<span class="start">09:00</span>
			                	<span>-</span>
			                	<span class="end">17:00</span>
			                	<a class="remove-hours" href="#">'.$removeStr.'</a>
			                	<input name="business_hours['.esc_html__( 'Wednesday', 'listingpro-plugin' ).'][open]" value="09:00" type="hidden">
			                	<input name="business_hours['.esc_html__( 'Wednesday', 'listingpro-plugin' ).'][close]" value="17:00" type="hidden">
			                </div>
			                <div class="hours">
			                	<span class="weekday">'.esc_html__( 'Thursday', 'listingpro-plugin' ).'</span>
			                	<span class="start">09:00</span>
			                	<span>-</span>
			                	<span class="end">17:00</span>
			                	<a class="remove-hours" href="#">'.$removeStr.'</a>
			                	<input name="business_hours['.esc_html__( 'Thursday', 'listingpro-plugin' ).'][open]" value="09:00" type="hidden">
			                	<input name="business_hours['.esc_html__( 'Thursday', 'listingpro-plugin' ).'][close]" value="17:00" type="hidden">
			                </div>
			                <div class="hours">
			                	<span class="weekday">'.esc_html__( 'Friday', 'listingpro-plugin' ).'</span>
			                	<span class="start">09:00</span>
			                	<span>-</span>
			                	<span class="end">17:00</span>
			                	<a class="remove-hours" href="#">'.$removeStr.'</a>
			                	<input name="business_hours['.esc_html__( 'Friday', 'listingpro-plugin' ).'][open]" value="09:00" type="hidden">
			                	<input name="business_hours['.esc_html__( 'Friday', 'listingpro-plugin' ).'][close]" value="17:00" type="hidden">
			                </div>
			            ';
		}
		$output .= '</div>
				        <ul class="hours-select clearfix inline-layout up-4">
				            <li>
				                <select class="weekday select2">
									<option value="'.esc_html__( 'Monday', 'listingpro-plugin' ).'">'.esc_html__( 'Monday', 'listingpro-plugin' ).'</option>
									<option value="'.esc_html__( 'Tuesday', 'listingpro-plugin' ).'">'.esc_html__( 'Tuesday', 'listingpro-plugin' ).'</option>
									<option value="'.esc_html__( 'Wednesday', 'listingpro-plugin' ).'">'.esc_html__( 'Wednesday', 'listingpro-plugin' ).'</option>
									<option value="'.esc_html__( 'Thursday', 'listingpro-plugin' ).'">'.esc_html__( 'Thursday', 'listingpro-plugin' ).'</option>
									<option value="'.esc_html__( 'Friday', 'listingpro-plugin' ).'">'.esc_html__( 'Friday', 'listingpro-plugin' ).'</option>
									<option value="'.esc_html__( 'Saturday', 'listingpro-plugin' ).'" selected="">'.esc_html__( 'Saturday', 'listingpro-plugin' ).'</option>
									<option value="'.esc_html__( 'Sunday', 'listingpro-plugin' ).'">'.esc_html__( 'Sunday', 'listingpro-plugin' ).'</option>
				                </select>
				            </li>
				            <li>
				                <select class="hours-start select2">
									<option value="24:00">24:00 ('.esc_html__('midnight', 'listingpro-plugin').')</option>
									<option value="24:30">24:30 </option>
									<option value="01:00">01:00</option>
									<option value="01:30">01:30</option>
									<option value="02:00">02:00</option>
									<option value="02:30">02:30</option>
									<option value="03:00">03:00</option>
									<option value="03:30">03:30</option>
									<option value="04:00">04:00</option>
									<option value="04:30">04:30</option>
									<option value="05:00">05:00</option>
									<option value="05:30">05:30</option>
									<option value="06:00">06:00</option>
									<option value="06:30">06:30</option>
									<option value="07:00">07:00</option>
									<option value="07:30">07:30</option>
									<option value="08:00">08:00</option>
									<option value="08:30">08:30</option>
									<option value="09:00" selected="">09:00</option>
									<option value="09:30">09:30</option>
									<option value="10:00">10:00</option>
									<option value="10:30">10:30</option>
									<option value="11:00">11:00</option>
									<option value="11:30">11:30</option>
									<option value="12:00">12:00('.esc_html__('noon', 'listingpro-plugin').')</option>
									<option value="12:30">12:30</option>
									<option value="13:00">13:00</option>
									<option value="13:30">13:30</option>
									<option value="14:00">14:00</option>
									<option value="14:30">14:30</option>
									<option value="15:00">15:00</option>
									<option value="15:30">15:30</option>
									<option value="16:00">16:00</option>
									<option value="16:30">16:30</option>
									<option value="17:00">17:00</option>
									<option value="17:30">17:30</option>
									<option value="18:00">18:00</option>
									<option value="18:30">18:30</option>
									<option value="19:00">19:00</option>
									<option value="19:30">19:30</option>
									<option value="20:00">20:00</option>
									<option value="20:30">20:30</option>
									<option value="21:00">21:00</option>
									<option value="21:30">21:30</option>
									<option value="22:00">22:00</option>
									<option value="22:30">22:30</option>
									<option value="23:00">23:00</option>
									<option value="23:30">23:30</option>
				                </select>
				            </li>
				            <li>
				                <select class="hours-end select2">
									<option value="24:00">24:00 ('.esc_html__('midnight', 'listingpro-plugin').')</option>
									<option value="24:30">24:30 </option>
									<option value="01:00">01:00</option>
									<option value="01:30">01:30</option>
									<option value="02:00">02:00</option>
									<option value="02:30">02:30</option>
									<option value="03:00">03:00</option>
									<option value="03:30">03:30</option>
									<option value="04:00">04:00</option>
									<option value="04:30">04:30</option>
									<option value="05:00">05:00</option>
									<option value="05:30">05:30</option>
									<option value="06:00">06:00</option>
									<option value="06:30">06:30</option>
									<option value="07:00">07:00</option>
									<option value="07:30">07:30</option>
									<option value="08:00">08:00</option>
									<option value="08:30">08:30</option>
									<option value="09:00">09:00</option>
									<option value="09:30">09:30</option>
									<option value="10:00">10:00</option>
									<option value="10:30">10:30</option>
									<option value="11:00">11:00</option>
									<option value="11:30">11:30</option>
									<option value="12:00">12:00('.esc_html__('noon', 'listingpro-plugin').')</option>
									<option value="12:30">12:30</option>
									<option value="13:00">13:00</option>
									<option value="13:30">13:30</option>
									<option value="14:00">14:00</option>
									<option value="14:30">14:30</option>
									<option value="15:00">15:00</option>
									<option value="15:30">15:30</option>
									<option value="16:00">16:00</option>
									<option value="16:30">16:30</option>
									<option value="17:00" selected="">17:00</option>
									<option value="17:30">17:30</option>
									<option value="18:00">18:00</option>
									<option value="18:30">18:30</option>
									<option value="19:00">19:00</option>
									<option value="19:30">19:30</option>
									<option value="20:00">20:00</option>
									<option value="20:30">20:30</option>
									<option value="21:00">21:00</option>
									<option value="21:30">21:30</option>
									<option value="22:00">22:00</option>
									<option value="22:30">22:30</option>
									<option value="23:00">23:00</option>
									<option value="23:30">23:30</option>
				                </select>
								
				            </li>
								
							<li>
								<div class="checkbox form-group fulldayopen-wrap">
									<input type="checkbox" name="fulldayopen" id="fulldayopen" class="fulldayopen">
									<label for="fulldayopen">'.esc_html__('24 Hours' ,'listingpro-plugin').'</label>
								</div>
				                <button data-fullday = "'.esc_html__('24 hours open', 'listingpro-plugin').'" data-remove="'.$removeData.'" data-sorrymsg="'.esc_html__('Sorry','listingpro-plugin').'" data-alreadyadded="'.esc_html__('Already Added', 'listingpro-plugin').'" type="button" value="submit" class="ybtn ybtn--small add-hours '.$add_hour_st.'">';
                                    $output .='<span><i class="fa fa-plus-square"></i> </span>';
                                $output .='</button>
				            </li>
							';
							
							if($listing2timeslots=="enable"){
								$output .='
								<div class="lp-check-doubletime checkbox form-group ">
									<input type="checkbox" name="enable2ndday" id="enable2ndday" class="enable2ndday">
									<label for="enable2ndday">'.esc_html__('Add 2nd time slot?' ,'listingpro-plugin').'</label>
								</div>
								<ul class="hours-select clearfix inline-layout up-4 lp-slot2-time">
									
									<li>
										<select class="hours-start2 select2">
											<option value="24:00">24:00 ('.esc_html__('midnight', 'listingpro-plugin').')</option>
											<option value="24:30">24:30 </option>
											<option value="01:00">01:00</option>
											<option value="01:30">01:30</option>
											<option value="02:00">02:00</option>
											<option value="02:30">02:30</option>
											<option value="03:00">03:00</option>
											<option value="03:30">03:30</option>
											<option value="04:00">04:00</option>
											<option value="04:30">04:30</option>
											<option value="05:00">05:00</option>
											<option value="05:30">05:30</option>
											<option value="06:00">06:00</option>
											<option value="06:30">06:30</option>
											<option value="07:00">07:00</option>
											<option value="07:30">07:30</option>
											<option value="08:00">08:00</option>
											<option value="08:30">08:30</option>
											<option value="09:00" selected="">09:00</option>
											<option value="09:30">09:30</option>
											<option value="10:00">10:00</option>
											<option value="10:30">10:30</option>
											<option value="11:00">11:00</option>
											<option value="11:30">11:30</option>
											<option value="12:00">12:00('.esc_html__('noon', 'listingpro-plugin').')</option>
											<option value="12:30">12:30</option>
											<option value="13:00">13:00</option>
											<option value="13:30">13:30</option>
											<option value="14:00">14:00</option>
											<option value="14:30">14:30</option>
											<option value="15:00">15:00</option>
											<option value="15:30">15:30</option>
											<option value="16:00">16:00</option>
											<option value="16:30">16:30</option>
											<option value="17:00">17:00</option>
											<option value="17:30">17:30</option>
											<option value="18:00">18:00</option>
											<option value="18:30">18:30</option>
											<option value="19:00">19:00</option>
											<option value="19:30">19:30</option>
											<option value="20:00">20:00</option>
											<option value="20:30">20:30</option>
											<option value="21:00">21:00</option>
											<option value="21:30">21:30</option>
											<option value="22:00">22:00</option>
											<option value="22:30">22:30</option>
											<option value="23:00">23:00</option>
											<option value="23:30">23:30</option>
										</select>
									</li>
									<li>
										<select class="hours-end2 select2">
											<option value="24:00">24:00 ('.esc_html__('midnight', 'listingpro-plugin').')</option>
											<option value="24:30">24:30 </option>
											<option value="01:00">01:00</option>
											<option value="01:30">01:30</option>
											<option value="02:00">02:00</option>
											<option value="02:30">02:30</option>
											<option value="03:00">03:00</option>
											<option value="03:30">03:30</option>
											<option value="04:00">04:00</option>
											<option value="04:30">04:30</option>
											<option value="05:00">05:00</option>
											<option value="05:30">05:30</option>
											<option value="06:00">06:00</option>
											<option value="06:30">06:30</option>
											<option value="07:00">07:00</option>
											<option value="07:30">07:30</option>
											<option value="08:00">08:00</option>
											<option value="08:30">08:30</option>
											<option value="09:00">09:00</option>
											<option value="09:30">09:30</option>
											<option value="10:00">10:00</option>
											<option value="10:30">10:30</option>
											<option value="11:00">11:00</option>
											<option value="11:30">11:30</option>
											<option value="12:00">12:00('.esc_html__('noon', 'listingpro-plugin').')</option>
											<option value="12:30">12:30</option>
											<option value="13:00">13:00</option>
											<option value="13:30">13:30</option>
											<option value="14:00">14:00</option>
											<option value="14:30">14:30</option>
											<option value="15:00">15:00</option>
											<option value="15:30">15:30</option>
											<option value="16:00">16:00</option>
											<option value="16:30">16:30</option>
											<option value="17:00" selected="">17:00</option>
											<option value="17:30">17:30</option>
											<option value="18:00">18:00</option>
											<option value="18:30">18:30</option>
											<option value="19:00">19:00</option>
											<option value="19:30">19:30</option>
											<option value="20:00">20:00</option>
											<option value="20:30">20:30</option>
											<option value="21:00">21:00</option>
											<option value="21:30">21:30</option>
											<option value="22:00">22:00</option>
											<option value="22:30">22:30</option>
											<option value="23:00">23:00</option>
											<option value="23:30">23:30</option>
										</select>
										
									</li>
									<li></li>
								</ul>';
							}
							
					$output .='
				        </ul>
				    </div>
					

				</div>';
	
		return $output;
	}
}