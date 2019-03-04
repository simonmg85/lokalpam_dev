		<?php 
			global $listingpro_options;
			$type = 'listing';
			$term_id = '';
			$taxName = '';
			$termID = '';
			$term_ID = '';
			$termName = '';
			$sterm = '';	
			$sloc = '';	
			$termName = '';	
			$locName = '';
			$feature_ID = '';
			$lpstag = '';			
			$catterm = '';	
			$parent = '';	
			$loc_ID = '';
			$locationID = '';
			global $paged;
			$taxTaxDisplay = true;
			
			if( !isset($_GET['s'])){
				$queried_object = get_queried_object();
				if(!empty($queried_object)){
					$term_id = $queried_object->term_id;
					$taxName = $queried_object->taxonomy;
					if(!empty($term_id)){
						$termID = get_term_by('id', $term_id, $taxName);
						$termName = $termID->name;
						$parent = $termID->parent;
						$term_ID = $termID->term_id;
						if(is_tax('location')){
							$loc_ID = $termID->term_id;
						}
						elseif(is_tax('features')){
							$feature_ID = $termID->term_id;
						}elseif(is_tax('list-tags')){
							$lpstag = $termID->term_id;
						}
					
						
					}
				}	
			}elseif(isset($_GET['lp_s_cat']) || isset($_GET['lp_s_tag']) || isset($_GET['lp_s_loc'])){
				
				if(isset($_GET['lp_s_cat']) && !empty($_GET['lp_s_cat'])){
					$sterm = $_GET['lp_s_cat'];
					$term_ID = $_GET['lp_s_cat'];
					$termo = get_term_by('id', $sterm, 'listing-category');
					$termName = esc_html__('Results For','listingpro').' <span class="font-bold term-name">'.$termo->name.'</span>';
					$parent = $termo->parent;
				}	
				if(isset($_GET['lp_s_cat']) && empty($_GET['lp_s_cat']) && isset($_GET['lp_s_tag']) && !empty($_GET['lp_s_tag'])){
					$sterm = $_GET['lp_s_tag'];
					$lpstag = $sterm;
					$termo = get_term_by('id', $sterm, 'list-tags');
					$termName = esc_html__('Results For','listingpro').' <span class="font-bold">'.$termo->name.'</span>';
				}
				if(isset($_GET['lp_s_cat']) && !empty($_GET['lp_s_cat']) && isset($_GET['lp_s_tag']) && !empty($_GET['lp_s_tag'])){
					$sterm = $_GET['lp_s_tag'];
					$lpstag = $sterm;
					
					$termo = get_term_by('id', $sterm, 'list-tags');
					$termName = esc_html__('Results For','listingpro').' <span class="font-bold">'.$termo->name.'</span>';
				}
				
				if(isset($_GET['lp_s_loc']) && !empty($_GET['lp_s_loc'])){
					$sloc = $_GET['lp_s_loc'];
					$loc_ID = $_GET['lp_s_loc'];
					if(is_numeric($sloc)){
						$sloc = $sloc;
						$termo = get_term_by('id', $sloc, 'location');
						$locName = esc_html__('In ','listingpro').$termo->name;
					}
					else{
						$checkTerm = listingpro_term_exist($sloc,'location');
						if(!empty($checkTerm)){
							$locTerm = get_term_by('name', $sloc, 'location');
							$loc_ID = $locTerm->term_id;
							
							$locName = esc_html__('In ', 'listingpro').'<span class="font-bold">'.$locTerm->name.'</span>';
						}
						else{
							$locName = esc_html__('In ', 'listingpro').'<span class="font-bold">'.$sloc.'</span>';
						}
					}
					
				}
			}
			
			$emptySearchTitle = '';
			if( empty($_GET['lp_s_tag']) && isset($_GET['lp_s_tag']) && empty($_GET['lp_s_cat']) && isset($_GET['lp_s_cat']) && empty($_GET['lp_s_loc']) && isset($_GET['lp_s_loc']) ){
						$emptySearchTitle = esc_html__('Most recent ', 'listingpro');
					}
			
			
			$listing_style ='1';
			$listingView ='grid_view';
			$GridClass='';
			$ListClass='';
			$listing_style = $listingpro_options['listing_style'];
			if(isset($_GET['list-style']) && !empty($_GET['list-style'])){
				$listing_style = $_GET['list-style'];
			}
			$listingView = $listingpro_options['listing_views'];
			if($listingView == 'grid_view'){
				$GridClass= 'active';
			}elseif($listingView == 'list_view'){
				$ListClass= 'active';
			}
		?>
			<div class="listing-style-<?php echo esc_attr($listing_style); ?>">
				<div class="search-row">
					
					<form autocomplete="off" class="clearfix" method="post" enctype="multipart/form-data" id="searchform">
						<?php
							$searchfilter = $listingpro_options['enable_search_filter'];
							if(!empty($searchfilter) && $searchfilter=='1'){
						?>
						<div class="form-inline lp-filter-inner">
							<div class="more-filter open_filter clearfix">
								
                                <?php
                                $priceOPT = $listingpro_options['enable_price_search_filter'];
                                if(!empty($priceOPT) && $priceOPT=='1'){
                                    $lp_priceSymbol = $listingpro_options['listing_pricerange_symbol'];
                                    $lp_priceSymbol2 = $lp_priceSymbol.$lp_priceSymbol;
                                    $lp_priceSymbol3 = $lp_priceSymbol2.$lp_priceSymbol;
                                    $lp_priceSymbol4 = $lp_priceSymbol3.$lp_priceSymbol;
                                    ?>
                                    <div class="form-group lp-border-bottom padding-top-5 padding-bottom-10">
										<p><?php echo esc_html__( 'Select Price Range', 'listingpro' );?></p>
                                        <div class="currency-signs clearfix search-filter-attr text-center">
											
                                            <ul class="clearfix">
                                                <li class="simptip-position-top simptip-movable" data-tooltip="<?php echo esc_html__( 'Inexpensive', 'listingpro' );?>" id="one"><a href="#" data-price="inexpensive"><?php echo $lp_priceSymbol; ?></a></li>
                                                <li class="simptip-position-top simptip-movable" data-tooltip="<?php echo esc_html__( 'Moderate', 'listingpro' );?>" id="two"><a href="#" data-price="moderate"><?php echo $lp_priceSymbol2; ?></a></li>
                                                <li class="simptip-position-top simptip-movable" data-tooltip="<?php echo esc_html__( 'Pricey', 'listingpro' );?>" id="three"><a href="#" data-price="pricey"><?php echo $lp_priceSymbol3; ?></a></li>
                                                <li class="simptip-position-top simptip-movable" data-tooltip="<?php echo esc_html__( 'Ultra High End', 'listingpro' );?>" id="four"><a href="#" data-price="ultra_high_end"><?php echo $lp_priceSymbol4; ?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                <?php } ?>
                                <div class="search-filter-attr">

									<?php
										$lp_bestmatch_on = $listingpro_options['enable_best_changed_search_filter'];
										if(!empty($lp_bestmatch_on) && $lp_bestmatch_on=='1' ){
									?>
											<div class="lp-filter-wrap-app text-right clearfix padding-bottom-10 padding-top-10 lp-border-bottom">
												<span><?php echo esc_html__( 'Best Match', 'listingpro' );?></span>
												<input value="" class="form-control switch-checkbox-hidden" type="hidden">
												<label class="switch">
													<span class="app-filter-loader"><i class="fa fa-cog" aria-hidden="true"></i></span>
													<input value="bestmatch" id="bestmatch" class="form-control switch-checkbox" type="checkbox">
													<div class="slider round"></div>
												</label>
											</div>
									<?php } ?>
                                </div>
								<?php
									$highViewOPT = $listingpro_options['enable_most_viewed_search_filter'];
									if( !empty($highViewOPT) && $highViewOPT=='1' ){ 
								?>
									<div class="search-filter-attr">
										<div class="lp-filter-wrap-app text-right clearfix">
											<span><?php echo esc_html__( 'Most Viewed', 'listingpro' );?></span>
											<input value="" class="form-control switch-checkbox-hidden" type="hidden">
											<label class="switch">
												<span class="app-filter-loader"><i class="fa fa-cog" aria-hidden="true"></i></span>
												<input value="mostviewed" id="mostviewed" class="form-control switch-checkbox" type="checkbox">
												<div class="slider round"></div>
											</label>
										</div>
									</div>
								<?php } ?>
                                <?php
                                $openTimeOPT = $listingpro_options['enable_opentime_search_filter'];
                                if(!empty($openTimeOPT) && $openTimeOPT=='1'){
                                    ?>
                                    <div class="search-filter-attr">
                                        <div class="lp-filter-wrap-app text-right clearfix">
                                            <span><?php echo esc_html__( 'Open Now', 'listingpro' );?></span>
                                            <input value="" class="form-control switch-checkbox-hidden" type="hidden">
                                            <label class="switch">
                                                <span class="app-filter-loader"><i class="fa fa-cog" aria-hidden="true"></i></span>
                                                <input value="close" class="form-control switch-checkbox listing_openTime" type="checkbox">
                                                <div class="slider round"></div>
                                            </label>
                                        </div>
                                       
                                    </div>
                                   
                                <?php } ?>
                                <div class="search-filters form-group clearfix">
								<?php
									$highRatOPT = $listingpro_options['enable_high_rated_search_filter'];
									$highRewOPT = $listingpro_options['enable_most_reviewed_search_filter'];
									if( (!empty($highRatOPT) && $highRatOPT=='1')||(!empty($highRewOPT) && $highRewOPT=='1') ){
								?>
									<div class="search-filters clearfix">
										<ul class="search-filter-attr">

											<?php if($highRatOPT=='1'){ ?>
                                                <div class="lp-filter-wrap-app text-right clearfix">
                                                    <span><?php echo esc_html__( 'Highest Rated', 'listingpro' );?></span>
                                                    <input value="" class="form-control switch-checkbox-hidden" type="hidden">
                                                    <label class="switch">
                                                        <span class="app-filter-loader"><i class="fa fa-cog" aria-hidden="true"></i></span>
                                                        <input value="listing_rate" id="listingRate" class="form-control switch-checkbox" type="checkbox">
                                                        <div class="slider round"></div>
                                                    </label>
                                                </div>

											<?php } ?>
											<?php if($highRewOPT=='1'){ ?>
                                                <div class="lp-filter-wrap-app text-right clearfix">
                                                    <span><?php echo esc_html__( 'Most Reviewed', 'listingpro' );?></span>
                                                    <input value="" class="form-control switch-checkbox-hidden" type="hidden">
                                                    <label class="switch">
                                                        <span class="app-filter-loader"><i class="fa fa-cog" aria-hidden="true"></i></span>
                                                        <input value="listing_reviewed" id="listingReviewed" class="form-control switch-checkbox" type="checkbox">
                                                        <div class="slider round"></div>
                                                    </label>
                                                </div>
											<?php } ?>
											
										</ul>
									</div>
								<?php } ?>
                                </div>
								<?php
									$catsOPT = $listingpro_options['enable_cats_search_filter'];
									if(!empty($catsOPT) && $catsOPT=='1'){
								?>
									
									<div class="form-group padding-bottom-10 padding-top-10 pull-right margin-right-0 clearfix">
										<p><?php echo esc_html__( 'Select Category', 'listingpro' );?></p>
										<div class="input-group border-dropdown">
											<div class="input-group-addon lp-border"><i class="fa fa-list"></i></div>
											<select class="comboboxCategory tag-select-four" name="searchcategory" id="searchcategory">
												<option value=""><?php echo esc_html__( 'All Categories', 'listingpro' );?></option>
												<?php 
													$args = array(
													'post_type' => 'listing',
													'order' => 'ASC',
													'hide_empty' => false,
													'parent' => 0,
													);
													
													$locations = get_terms( 'listing-category',$args);
													foreach($locations as $location) {
														if($term_ID == $location->term_id){
															$selected = 'selected';
														}else{
															$selected = '';
														}
														echo '<option '.$selected.' value="'.$location->term_id.'">'.$location->name.'</option>';
														$sub = get_term_children( $location->term_id, 'listing-category' );
														foreach ( $sub as $subID ) {
															if($term_ID == $subID){
																$selected = 'selected';
															}else{
																$selected = '';
															}
															$term = get_term_by( 'id', $subID, 'listing-category' );
															echo '<option '.$selected.' class="sub_cat" value="'.$term->term_id.'">-&nbsp;&nbsp;'.$term->name.'</option>';
														}
													}		
												?>	
											</select>
										</div>
									</div>
								<?php }else{ ?>
								
										<div class="input-group border-dropdown" style="display:none">
											<div class="input-group-addon lp-border"><i class="fa fa-list"></i></div>
											<select class="comboboxCategory tag-select-four" name="searchcategory" id="searchcategory">
												<option value=""><?php echo esc_html__( 'All Categories', 'listingpro' );?></option>
												<?php 
													$args = array(
													'post_type' => 'listing',
													'order' => 'ASC',
													'hide_empty' => false,
													'parent' => 0,
													);
													
													$locations = get_terms( 'listing-category',$args);
													foreach($locations as $location) {
														if($term_ID == $location->term_id){
															$selected = 'selected';
														}else{
															$selected = '';
														}
														echo '<option '.$selected.' value="'.$location->term_id.'">'.$location->name.'</option>';
														$sub = get_term_children( $location->term_id, 'listing-category' );
														foreach ( $sub as $subID ) {
															if($term_ID == $subID){
																$selected = 'selected';
															}else{
																$selected = '';
															}
															$term = get_term_by( 'id', $subID, 'listing-category' );
															echo '<option '.$selected.' class="sub_cat" value="'.$term->term_id.'">-&nbsp;&nbsp;'.$term->name.'</option>';
														}
													}		
												?>	
											</select>
										</div>
								
								<?php } ?>
							</div>
						</div>
						<?php }else{ ?>
							
								<select style = "display:none" class="comboboxCategory tag-select-four" name="searchcategory" id="searchcategory">
										<option value=""><?php echo esc_html__( 'All Categories', 'listingpro' );?></option>
										<?php 
											$args = array(
											'post_type' => 'listing',
											'order' => 'ASC',
											'hide_empty' => false,
											'parent' => 0,
											);
											
											$locations = get_terms( 'listing-category',$args);
											foreach($locations as $location) {
												if($term_ID == $location->term_id){
													$selected = 'selected';
												}else{
													$selected = '';
												}
												echo '<option '.$selected.' value="'.$location->term_id.'">'.$location->name.'</option>';
												$sub = get_term_children( $location->term_id, 'listing-category' );
												foreach ( $sub as $subID ) {
													if($term_ID == $subID){
														$selected = 'selected';
													}else{
														$selected = '';
													}
													$term = get_term_by( 'id', $subID, 'listing-category' );
													echo '<option '.$selected.' class="sub_cat" value="'.$term->term_id.'">-&nbsp;&nbsp;'.$term->name.'</option>';
												}
											}		
										?>	
									</select>
						
						
						<?php } ?>
						<input type="hidden" name="lp_search_loc" id="lp_search_loc" value="<?php echo $loc_ID; ?>" />
						<?php if($taxTaxDisplay == true){ ?>
							
							<?php 
								
								$count = 1;
								$featureName;
								$features = listingpro_get_term_meta($term_ID,'lp_category_tags');
								if(empty($features)){
									$features = listingpro_get_term_meta($parent,'lp_category_tags');
									
								}
								if(!empty($features)){ ?>
									
									<div class="form-inline lp-features-filter tags-area">
										<div class="form-group">
											
											<div class="input-group margin-right-0">
												
												<ul>
													<?php
													foreach($features as $feature){
														$terms = get_term_by('id', $feature, 'features');
														if(!empty($terms)){
															$featurCount = lp_count_postcount_taxonomy_term_byID('listing','features', $terms->term_id);
															if(!empty($featurCount)){
																echo '<li>';
																	echo '<div class="pad-bottom-10 checkbox ">';
																		echo '<input type="checkbox" name="searchtags[]'.$count.'" id="check_'.$count.'" class="searchtags" value="'.$terms->term_id.'">';
																		echo '<label for="'.$terms->term_id.'">'.$terms->name.'</label>';
																	echo '</div>';
																echo '</li>';
															}
															$count++;	
														}
													}
													?>
												</ul>	
											</div>
										</div>
									</div>
								<?php
								}
								?>
						<?php } ?>
						
						<input type="submit" value="" style="display: none;">
						<input type="hidden" name="clat">
						<input type="hidden" name="clong">
                        <div class="clearfix"></div>
						
					</form>
					
					<div class="lp-s-hidden-ara hide">
						<?php
							
							if(!empty($lpstag)){
								echo '<input type="hidden" id="lpstag" value="'.$lpstag.'">';
							}
							echo '<input type="hidden" id="lp_current_query" value="'.$_GET['select'].'">';
							if( empty($features) && !empty($feature_ID) ){
										echo '<input type="checkbox" name="searchtags[]" id="check_featuretax" class="searchtags" value="'.$feature_ID.'" checked>';
							}
						?>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="LPtagsContainer "></div>
				</div>

                <div class="col-md-12 lp-additional-appview-filter-new">

					<?php
					$term_id = '';
					if( !isset($_GET['s'])){
						$queried_object = get_queried_object();
						$term_id = $queried_object->term_id;
					}elseif( isset($_GET['lp_s_cat']) ){
						$term_id = $_GET['lp_s_cat'];
					}

					echo '<h3>'.esc_html__("More Option", "listingpro").'</h3>';
					/* multicheck on off */
					$getSwithButtonFieldsFilter = lp_get_extrafields_filter('checkbox', $term_id, false);
					if(!empty($getSwithButtonFieldsFilter)){
						?>
                        <div class="lp_more_filter_data_section lp_extrafields_select">

							<?php
							echo '<ul class="filter_data_switch_on_off">';
							foreach ($getSwithButtonFieldsFilter as $fieldPostID => $fieldVal) {
								echo '
								<li>
									<label class="filter_checkbox_container">'.$fieldVal.'
										<input type="checkbox" value="'.$fieldVal.'" name="lp_extrafields_select[]">
										<span class="filter_checkbox_checkmark"></span>
									</label>
								</li>
							';
							}
							echo '</ul>';
							?>

                        </div>
						<?php
					}
					/* checkbox */
					$getSwithButtonFieldsFilter = lp_get_extrafields_filter('check', $term_id, false);
					if(!empty($getSwithButtonFieldsFilter)){
						?>
                        <div class="lp_more_filter_data_section lp_extrafields_select">

							<?php

							foreach ($getSwithButtonFieldsFilter as $fieldPostID => $fieldVal) {
								echo '<h3>' . $fieldVal . '</h3>';
								echo '<ul class="lp_filter_checkbox">';
								echo '
								<li>
									
									<label class="filter_checkbox_container">'.$fieldVal.'
										<input type="checkbox" value="'.$fieldVal.'" name="lp_extrafields_select[]">
										<span class="filter_checkbox_checkmark"></span>
									</label>
								</li>
							';
								echo '</ul>';
							}

							?>

                        </div>
						<?php
					}

					?>
                    <!-- for multicheck -->
					<?php
					$getExtraFieldsFilter = lp_get_extrafields_filter('checkboxes', $term_id, false);
					if(!empty($getExtraFieldsFilter)){

						?>
                        <div class="lp_more_filter_data_section lp_extrafields_select">

							<?php
							foreach ($getExtraFieldsFilter as $fieldPostID => $fieldVal) {
								echo '<h3>' . $fieldVal . '</h3>';
								echo '<ul class="lp_filter_checkbox">';
								$getFieldsValue = listing_get_metabox_by_ID('multicheck-options', $fieldPostID);
								if (!empty($getFieldsValue)) {
									$getFieldsArray = explode(",", $getFieldsValue);
									if (!empty($getFieldsArray)) {
										foreach ($getFieldsArray as $optionVal) {
											$optionVal = trim($optionVal);
											echo '
													<li>
														<label class="filter_checkbox_container">'.$optionVal.'
															<input type="checkbox" value="'.$optionVal.'" name="lp_extrafields_select[]">
															<span class="filter_checkbox_checkmark"></span>
														</label>
													</li>
												';
										}
									}
								}
								echo '</ul>';
							}
							?>

                        </div>
					<?php } ?>

                    <!-- for radio -->
					<?php
					$getRadioFieldsFilter = lp_get_extrafields_filter('radio', $term_id, false);
					if(!empty($getRadioFieldsFilter)){

						?>

                        <div class="lp_more_filter_data_section lp_extrafields_select">
							<?php
							foreach ($getRadioFieldsFilter as $fieldPostID => $fieldVal) {
								echo '<h3>' . $fieldVal . '</h3>';
								echo '<ul class="lp_filter_checkbox">';

								$getFieldsValue = listing_get_metabox_by_ID('radio-options', $fieldPostID);
								if (!empty($getFieldsValue)) {
									$getFieldsArray = explode(",", $getFieldsValue);
									if (!empty($getFieldsArray)) {
										foreach ($getFieldsArray as $optionVal) {
											$optionVal = trim($optionVal);

											echo '
													<li>
														<label class="filter_radiobox_container">'.$optionVal.'
														  <input type="radio" name="radio" value="'.$optionVal.'" name="lp_extrafields_select[]">
														  <span class="filter_radio_select"></span>
														</label>
													</li>
												';
										}
									}
								}

								echo '</ul>';
							}
							?>

                        </div>
						<?php
					}
					?>


                    <!-- for Dropdown -->
					<?php
					$getRadioFieldsFilter = lp_get_extrafields_filter('select', $term_id, false);
					if(!empty($getRadioFieldsFilter)){

						?>

                        <div class="lp_more_filter_data_section lp_extrafields_select">
							<?php
							foreach ($getRadioFieldsFilter as $fieldPostID => $fieldVal) {
								echo '<h3>' . $fieldVal . '</h3>';
								echo '<ul class="lp_filter_checkbox">';

								$getFieldsValue = listing_get_metabox_by_ID('select-options', $fieldPostID);
								if (!empty($getFieldsValue)) {
									$getFieldsArray = explode(",", $getFieldsValue);
									if (!empty($getFieldsArray)) {
										foreach ($getFieldsArray as $optionVal) {
											$optionVal = trim($optionVal);

											echo '
													<li>
														<label class="filter_radiobox_container">'.$optionVal.'
														  <input type="radio" name="radio" value="'.$optionVal.'" name="lp_extrafields_select[]">
														  <span class="filter_radio_select"></span>
														</label>
													</li>
												';
										}
									}
								}

								echo '</ul>';
							}
							?>

                        </div>
						<?php
					}
					?>
                </div>

			</div>