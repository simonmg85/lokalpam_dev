<div class="outer_all_page_overflow">
    <div class="lp_all_page_overflow">
        <div class="col-md-12">

			<?php
			$term_id = '';
			if( !isset($_GET['s'])){
				$queried_object = get_queried_object();
				$term_id = $queried_object->term_id;
			}elseif( isset($_GET['lp_s_cat']) ){
				$term_id = $_GET['lp_s_cat'];
			}

			echo '<h2>'.esc_html__("More Option", "listingpro").'</h2>';
			/* multicheck on off */
			$getSwithButtonFieldsFilter = lp_get_extrafields_filter('checkbox', null, false);
			if(!empty($getSwithButtonFieldsFilter)){
				?>
                <div class="lp_more_filter_data_section lp_extrafields_select">

					<?php
					echo '<ul class="filter_data_switch_on_off">';
					foreach ($getSwithButtonFieldsFilter as $fieldPostID => $fieldVal) {
						echo '
							<li>
								<label class="filter_checkbox_container">'.$fieldVal.'
									<input class="lp-more-filter-vals" data-mfilterkey="'.$fieldVal.'" data-mfilterval="'.$fieldVal.'" type="checkbox" value="'.$fieldVal.'" name="lp_extrafields_select[]">
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
			$getSwithButtonFieldsFilter = lp_get_extrafields_filter('check', null, false);
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
									<input class="lp-more-filter-vals" data-mfilterkey="'.$fieldVal.'" data-mfilterval="'.$fieldVal.'" type="checkbox" value="'.$fieldVal.'" name="lp_extrafields_select[]">
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
			$getExtraFieldsFilter = lp_get_extrafields_filter('checkboxes', null, false);
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
														<input class="lp-more-filter-vals" data-mfilterkey="'.$fieldVal.'" data-mfilterval="'.$optionVal.'" type="checkbox" value="'.$optionVal.'" name="lp_extrafields_select[]">
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
			$getRadioFieldsFilter = lp_get_extrafields_filter('radio', null, false);
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
													  <input class="lp-more-filter-vals" data-mfilterkey="'.$fieldVal.'" data-mfilterval="'.$optionVal.'" type="radio" name="radio" value="'.$optionVal.'" name="lp_extrafields_select[]">
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
			$getRadioFieldsFilter = lp_get_extrafields_filter('select', null, false);
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
													  <input class="lp-more-filter-vals" data-mfilterkey="'.$fieldVal.'" data-mfilterval="'.$optionVal.'" type="radio" name="radio" value="'.$optionVal.'" name="lp_extrafields_select[]">
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


            <div class="outer_filter_show_result_cancel">
                <div class="filter_show_result_cancel">
                    <span id="filter_cancel_all"><?php echo esc_html__('Cancel', 'listingpro'); ?></span>

                    <input type="submit" value="<?php echo esc_html__('Show Results', 'listingpro'); ?>" id="filter_result">

                </div>
            </div>

        </div>
    </div>

</div>