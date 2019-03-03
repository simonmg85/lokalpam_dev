<table class="table wp-list-table widefat fixed striped posts">
										<thead>
										<tr>
											<!-- <th><?php echo esc_html__('No.', 'listingpro-plugin'); ?></th> -->

											<th id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></th>


												<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
												<a><span><?php echo esc_html__('Receipt/inovice#', 'listingpro-plugin'); ?></span><span class="sorting-indicator"></span></a>
												</th>

												<th class="manage-column column-tags"><?php echo esc_html__('Date', 'listingpro-plugin'); ?></th>
												<th class="manage-column column-tags"><?php echo esc_html__('Method', 'listingpro-plugin'); ?></th>
												<th class="manage-column column-tags"><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
												<th class="manage-column column-tags"><?php echo esc_html__('Status', 'listingpro-plugin'); ?></th>
											</tr>
										</thead>
										<tbody>
												
													<?php
													global $wpdb;
													$counter = 1;
													$table = "listing_orders";
													$table =$dbprefix.$table;
													$results = array();
													if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
														$query = "";
														$query = "SELECT * from $table ORDER BY main_id DESC";
														$results = $wpdb->get_results( $query);		
													}
													if(!empty($results)){
														
													foreach($results as $Index=>$Value){
														$invoiceStatus = $Value->status;
														?>

														<tr>
															<th scope="row" class="check-column">			
																<input type="checkbox">
															</th>


															<!-- <td><?php echo $counter; ?></td> -->
																<td class="manage-column column-categories"><?php echo $Value->order_id; ?></td>
																<td class="manage-column column-categories"><?php echo date(get_option('date_format'), strtotime($Value->date)) ?></td>
																<td class="manage-column column-categories"><?php echo $Value->payment_method; ?></td>
																<td class="manage-column column-categories"><?php echo $Value->price.$Value->currency; ?></td>
																

																<td class="manage-column column-categories">
																	<?php
																			if(!empty($invoiceStatus)){
																				if($invoiceStatus=="success"){ ?>
																					<input class="alert alert-success" type="button" value="<?php echo esc_html__('Active', 'listingpro-plugin'); ?>" >
																				<?php
																				}elseif($invoiceStatus=="failed"){ ?>
																					<input class="alert alert-danger" type="button" value="<?php echo esc_html__('Failed', 'listingpro-plugin'); ?>" >
																				<?php 
																				}elseif($invoiceStatus=="pending" || $invoiceStatus=="in progress"){ ?>
																					<input class="alert alert-info" type="button" value="<?php echo esc_html__('Pending', 'listingpro-plugin'); ?>" >
																				<?php 
																				} ?>

																	<?php
																		}
																	?>
																</td>
																
																
															</tr>

															<?php
															$counter++;
														}
													}
														?>
													
													
											</tbody>

											<tfoot>
												<tr>
													<th class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></th>

													<th class="manage-column column-title column-primary sortable desc">
														<a><span>Receipt/inovice#</span>
															<span class="sorting-indicator"></span></a></th>
															<th class="manage-column column-tags"><?php echo esc_html__('Date', 'listingpro-plugin'); ?></th>
															<th class="manage-column column-tags"><?php echo esc_html__('Method', 'listingpro-plugin'); ?></th>
															<th class="manage-column column-tags"><?php echo esc_html__('Price', 'listingpro-plugin'); ?></th>
															<th class="manage-column column-tags"><?php echo esc_html__('Status', 'listingpro-plugin'); ?></th>
														</tr>
													</tfoot>
												</table>