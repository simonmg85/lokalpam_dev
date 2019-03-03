<?php 
	$lp_images_count = '555';
    $lp_images_size = '999999999999999999999999999999999999999999999999999';
    $lp_imagecount_notice = '';
    $lp_imagesize_notice = '';
    if(lp_theme_option('lp_listing_reviews_images_count_switch')=='yes')
    {
        $lp_images_count = lp_theme_option('lp_listing_reviews_images_counter');
        $lp_imagecount_notice= esc_html__("Max. allowed images are ", 'listingpro');
        $lp_imagecount_notice .= $lp_images_count;
    }
    if(lp_theme_option('lp_listing_reviews_images_size_switch')=='yes'){
        $lp_images_size = lp_theme_option('lp_listing_reviews_images_sizes');
        $lp_imagesize_notice= esc_html__('Max. allowed images size is ', 'listingpro');
        $lp_imagesize_notice .= $lp_images_size. esc_html__(' Mb', 'listingpro');
        $lp_images_size = $lp_images_size * 1000000;
    }
	$rID = '';
	/* edit review form submit */
	if(isset($_POST['reviewID']) && !empty($_POST['reviewID'])){
		$rewiewID = $_POST['reviewID'];
		$rID = $rewiewID;
		$rating = $_POST['rating'];
		$title = $_POST['post_title'];
		$desc = $_POST['post_description'];
		
		$review_postData = array(
			  'ID'           => $rewiewID,
			  'post_title'   => $title,
			  'post_content' => $desc,
		  );
		wp_update_post( $review_postData );
		
		$oldRate = listing_get_metabox_by_ID('rating', $rewiewID);
		listing_set_metabox('rating', $rating, $rewiewID);
		
		$listing_id = listing_get_metabox_by_ID('listing_id', $rewiewID);
		
		$action = 'update';
		listingpro_set_listing_ratings($rewiewID, $listing_id , $rating , $action);
		
		
		if ( !empty($_FILES['post_gallery']) ) {
					$ids = array();
					$files = $_FILES['post_gallery'];  			
					foreach ($files['name'] as $key => $value) { 							
						if ($files['name'][$key]) { 					
							$file = array(
								'name' => $files['name'][$key],	 					
								'type' => $files['type'][$key], 						
								'tmp_name' => $files['tmp_name'][$key], 						
								'error' => $files['error'][$key], 						
								'size' => $files['size'][$key]
							); 					
							$_FILES = array ("post_gallery" => $file); 					
							$count = 0;					
							foreach ($_FILES as $file => $array) {
								$newupload = listingpro_handle_attachment($file,$rewiewID,$set_thu=false); 									 $ids[] =$newupload;									  $count++;					
							}
						}
					}
					if( is_array($ids) && count($ids)>0 ){
						$img_ids = implode(",", $ids);
						update_post_meta($rewiewID, 'gallery_image_ids', $img_ids);
						
					}
				}
				
				$currentURL = '';
				$perma = '';
				$dashQuery = 'dashboard=reviews';
				global $currentURL;
				global $wp_rewrite;
				if ($wp_rewrite->permalink_structure == ''){
					$perma = "&";
				}else{
					$perma = "?";
				}
				wp_redirect($currentURL.$perma.$dashQuery);
	}
	/* end edit review form submit */
	
	?>
	<?php
		$rating = listing_get_metabox_by_ID('rating' ,get_the_ID());
		$gallery = get_post_meta(get_the_ID(), 'gallery_image_ids', true);
		//$currentURL = '';
		global $currentURL;
		$perma = '';
		$dashQuery = 'dashboard=review-edit';
		//$currentURL = get_permalink();
		global $wp_rewrite;
		if ($wp_rewrite->permalink_structure == ''){
			$perma = "&";
		}else{
			$perma = "?";
		}
		
	?>
			<div class="review-form" id="review-section">
				<div class="aligncenter">
				
					<form  id = "rewies_edit-form" data-imgcount="<?php echo $lp_images_count; ?>" data-imgsize="<?php echo $lp_images_size; ?>" data-countnotice="<?php echo $lp_imagecount_notice;?>" data-sizenotice="<?php echo $lp_imagesize_notice; ?>" name = "rewies_form" action = "<?php echo $currentURL.$perma.$dashQuery;?> " method = "post" enctype="multipart/form-data">
						<div class = "col-md-6 padding-left-0">
							<div class="form-group margin-bottom-40">
								<p class="padding-bottom-15"><?php esc_html_e('Your Rating','listingpro'); ?></p>
								<div class="list-style-none form-review-stars">
									<input type="hidden" name="rating" class="rating-tooltip" data-filled="fa fa-star fa-2x" data-empty="fa fa-star-o fa-2x" value="<?php echo $rating; ?>" />
									<div class="review-emoticons">
										<div class="review angry"><?php echo listingpro_icons('angry'); ?></div>
										<div class="review cry"><?php echo listingpro_icons('crying'); ?></div>
										<div class="review sleeping"><?php echo listingpro_icons('sleeping'); ?></div>
										<div class="review smily"><?php echo listingpro_icons('smily'); ?></div>
										<div class="review cool"><?php echo listingpro_icons('cool'); ?></div>
									</div>
								</div>
							</div>
						</div>
						
						<div class = "col-md-6 pull-right padding-right-0">
							
							<?php
								if(!empty($gallery)){
									if (strpos($gallery, ',') !== false) {
										echo '<ul class="gallery-thumbs">';
										$gallArray = explode(',', $gallery);
										foreach($gallArray as $imgID){
											$imgGalFull = wp_get_attachment_image_src( $imgID,  'thumbnail');
											echo '<li>';
												echo '<img width="32" height="32" src="'.$imgGalFull[0].'" alt="">';
											echo '</li>';
										}
										echo '</ul>';
									}
									else{
										echo '<ul class="gallery-thumbs">';
											$imgGalFull = wp_get_attachment_image_src( $gallery,  'thumbnail');
											echo '<li>';
												echo '<img width="32" height="32" src="'.$imgGalFull[0].'" alt="">';
											echo '</li>';
										echo '</ul>';
									}
								}
							?>
							
							<div class="form-group submit-images">
								<label for = "post_gallery submit-images"><?php esc_html_e('Select New Images','listingpro'); ?></label>
								<a href="#" class="browse-imgs"><?php esc_html_e('Browse','listingpro'); ?></a>
								<input type = "file" class="dashboard-edit-filter-input2" id = "filer_input2" name = "post_gallery[]" multiple="multiple"/>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-group">
							<label for = "post_title"><?php esc_html_e('Title','listingpro'); ?></label>
							<input type = "text" id = "post_title" class="form-control" name = "post_title" value="<?php echo get_the_title(); ?>" />
						</div>
						<div class="form-group">
							<label for = "post_description"><?php esc_html_e('Review','listingpro'); ?></label>
							<textarea id = "post_description" class="form-control" rows="8" name = "post_description" ><?php echo get_the_content(); ?></textarea>
						</div>
						<p class="form-submit post-reletive">
							<input name="submit_review" type="submit" id="submit" class="lp-review-reply-btn" value="<?php esc_html_e('Submit Review','listingpro'); ?>"> 
							<input type="hidden" name="reviewID" value="<?php echo get_the_ID(); ?>">
							
						</p>
					</form>
				</div>
			</div>
