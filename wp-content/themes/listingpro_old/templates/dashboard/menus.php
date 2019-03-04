<?php
$current_user = wp_get_current_user();
$user_id = $current_user->ID;



$m_args =   array(
	'post_type' => 'listing',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'author' => $user_id,
	'meta_key' => 'lp-listing-menu',
	'meta_compare' => 'EXISTS'
);

$m_listings             =   new WP_Query($m_args);
$count_m_listings       =   $m_listings->found_posts;

$menu_groups_data       =   get_user_meta( $user_id, 'user_menu_groups' );
$menu_groups_data       =   @$menu_groups_data[0];

$menu_types_data        =   get_user_meta( $user_id, 'user_menu_types' );
$menu_types_data        =   @$menu_types_data[0];


$currentURL = '';
$perma = '';
$dashQuery = 'dashboard=';
$currentURL = get_permalink();
global $wp_rewrite;
if ($wp_rewrite->permalink_structure == ''){
	$perma = "&";
}else{
	$perma = "?";
}
global $listingpro_options;
$image_gallery   =   '';
$image_gallery_opt  =   $listingpro_options['menu_gallery_dashoard'];
if( $image_gallery_opt == 1 )
{
	$image_gallery  =   'data-multiple="true"';
}
$img_menu_dashoard_show = lp_theme_option('img_menu_dashoard');
if($img_menu_dashoard_show == 0) {
	$img_menu_dashoard_show = false;
}else{
	$img_menu_dashoard_show = true;
}
?>
<script>
    jQuery(document).ready(function (e) {
        if( jQuery('.menu-tabs').length != 0 )
        {
            jQuery('.menu-tabs').each(function (index) {
                var targetTabID =   jQuery(this).attr('id');
                jQuery( '#'+targetTabID ).tabs();
            });
        }
        if( jQuery('.menu-type-count-val').length != 0 )
        {
            jQuery('.menu-type-count-val').each(function (index) {
                var targetMenuCount =   jQuery(this).attr('id'),
                    menuCountVal    =   jQuery(this).val();

                jQuery('.'+targetMenuCount).text(jQuery('#'+targetMenuCount).val());
            });
        }
        if( jQuery('.menu-group-count-val').length != 0 )
        {
            jQuery('.menu-group-count-val').each(function (index) {
                var targetMenuCount =   jQuery(this).attr('id'),
                    menuCountVal    =   jQuery(this).val();

                jQuery('.'+targetMenuCount).text(jQuery('#'+targetMenuCount).val());
            });
        }
        if( jQuery('.menu-items-count-val').length != 0 )
        {
            jQuery('.menu-items-count-val').each(function (index) {
                var targetMenuCount =   jQuery(this).attr('id'),
                    menuCountVal    =   jQuery(this).val();

                jQuery('.'+targetMenuCount).text(jQuery('#'+targetMenuCount).val());
            });
        }
    });
</script>
<?php
ajax_response_markup();
?>
<!-- Modal -->
<div class="modal fade" id="dashboard-delete-modal" tabindex="-1" role="dialog" aria-labelledby="dashboard-delete-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
				<?php echo esc_html__( 'are you sure you want to delete?', 'listingpro'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo esc_html__( 'Cancel', 'listingpro' ); ?></button>
                <button type="button" class="btn btn-primary dashboard-confirm-del-btn"><?php echo esc_html__( 'Delete', 'lsitingpro' ); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade in active" id="lp-menus">
    <div class="panel with-nav-tabs panel-default lp-dashboard-tabs col-md-12 lp-left-panel-height padding-bottom0">
		<?php
		if( $count_m_listings == 0 ):
			?>
            <div class="lp-blank-section">
                <div class="col-md-9 blank-left-side">
                    <img src="<?php echo listingpro_icons_url('lp_blank_trophy'); ?>">
                    <h1><?php echo esc_html__('Nothing but this golden trophy!', 'listingpro'); ?></h1>
                    <p class="margin-bottom-20"><?php echo esc_html__('You must be here for the first time. If you like to add some thing, click the button below.', 'listingpro'); ?></p>
                    <button data-form="menu" class="lp-add-new-btn add-new-open-form hereIam"><span><i class="fa fa-plus" aria-hidden="true"></i></span><?php echo esc_html__('Add new menu', 'listingpro'); ?> </button>

                </div>
                <div class="col-md-3 blank-right-side">
                    <img src="<?php echo listingpro_icons_url('lp_blank_right_quote'); ?>">
                    <p><?php echo esc_html__('"Your time is limited, so dont waste it living someone elses life."', 'listingpro'); ?><strong><?php echo esc_html__('-Steve Jobs-', 'listingpro'); ?></strong></p>
                </div>
            </div>
		<?php
		else:
			?>
            <div class="lp-menu-step-one margin-top-20">
                <div class="lp-add-menu-outer clearfix">
                    <h5><?php esc_html_e('All Menus','listingpro'); ?></h5>
                    <button data-form="menu" class="lp-add-new-btn add-new-open-form"><span><i class="fa fa-plus" aria-hidden="true"></i></span> <?php esc_html_e('add new menu','listingpro'); ?></button>
                    <button data-url="<?php echo $currentURL.$perma.$dashQuery.'manage-types-groups'; ?>" class="lp-add-new-btn manage-group-types"><span><i class="fa fa-plus" aria-hidden="true"></i></span> <?php esc_html_e('Manage Types/Groups','listingpro'); ?></button>
					<?php if($img_menu_dashoard_show == true) { ?>
                        <button data-url="<?php echo $currentURL.$perma.$dashQuery.'services-screen'; ?>" class="lp-add-new-btn manage-group-types"><span><i class="fa fa-plus" aria-hidden="true"></i></span> <?php esc_html_e('Image Menu','listingpro'); ?></button>
					<?php } ?>
                </div>
                <div class="panel-body">
                    <div class="lp-main-title clearfix">
                        <div class="col-md-4"><p><?php esc_html_e('LISTING NAME','listingpro'); ?></p></div>
                        <div class="col-md-2"><p><?php esc_html_e('MENU TYPES','listingpro'); ?></p></div>
                        <div class="col-md-2"><p><?php esc_html_e('MENU GROUPS','listingpro'); ?></p></div>
                        <div class="col-md-4"><p><?php esc_html_e('MENU ITEMS','listingpro'); ?></p></div>
                    </div>
                    <div class="tab-content clearfix">
                        <div class="tab-pane fade in active" id="tab1default">
							<?php
							while ( $m_listings->have_posts() ): $m_listings->the_post();
								$lid    =   get_the_ID();
								$lp_listing_menus   =   get_post_meta( get_the_ID(), 'lp-listing-menu', true );
								if( $lp_listing_menus && is_array( $lp_listing_menus ) && !empty( $lp_listing_menus ) ):
									?>
                                    <div class="lp-listing-outer-container clearfix lp-menu-container-outer">
                                        <div class="col-md-4 lp-content-before-after" data-content="<?php esc_html_e('Listing Name','listingpro'); ?>">
                                            <div class="lp-invoice-number lp-listing-form">
                                                <label>
                                                    <p><?php echo get_the_title( $lid ); ?></p>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 lp-content-before-after" data-content="<?php esc_html_e('Menu Types','listingpro'); ?>">
                                            <div class="lp-menu-type">
                                                <p class="menu-type-count-<?php echo $lid; ?>">-</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2 lp-content-before-after" data-content="<?php esc_html_e('Menu Groups','listingpro'); ?>">
                                            <div class="lp-menu-type">
                                                <p class="menu-group-count-<?php echo $lid; ?>">-</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 lp-content-before-after" data-content="<?php esc_html_e('Menu Items','listingpro'); ?>">
                                            <div class="clearfix">
                                                <div class="pull-right">
                                                    <div class="lp-dot-extra-buttons">
                                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABtSURBVEhLYxgFgwN4R2UKekXl7gJhEBsqTDnwiM4N8YrO/Q/GUTlBUGHKAciVntG5O0DYJTSNHyo8UoFnVI61V0yuFZRLHQAyEBZ5PpHZllBhygHIMKjB/6hqMAiADKS6oUMPjGbpUUANwMAAAIAtN4uDPUCkAAAAAElFTkSuQmCC">
                                                        <ul class="lp-user-menu list-style-none">
                                                            <li><a href="" class="menu-edit" data-targetid="<?php echo $lid; ?>"><i class="fa fa-pencil-square-o"></i><span><?php echo esc_html__( 'Edit', 'listingpro'); ?></span></a></li>
                                                            <li><a href="" class="del-all-menu" data-uid="<?php echo $user_id; ?>" data-lid="<?php echo $lid; ?>"><i class="fa fa-trash-o"></i><span><?php echo esc_html__( 'Delete', 'listingpro'); ?></span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="lp-menu-type pull-left">
                                                    <p class="menu-items-count-<?php echo $lid; ?>">-</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div id="update-wrap-<?php echo $lid; ?>" style="display: none;">
                                            <div id="tabs-menu-<?php echo $lid; ?>" class="menu-tabs">
                                                <ul>
													<?php
													$tab_counter    =   0;
													$menu_type_count        =   0;
													$menu_groups_count      =   0;
													$menu_items_count      =   0;
													foreach ( $lp_listing_menus as $menu_type => $lp_listing_menu ):
														$tab_counter++;
														$menu_type_ar_cast  =   (array) $menu_type;
														$menu_type_count    +=   count($menu_type_ar_cast);
														?>
                                                        <li><a href="#tabs-menu-type-<?php echo $tab_counter; ?>"><?php echo $menu_type; ?></a></li>
													<?php endforeach; ?>
                                                </ul>
												<?php
												$tab_counterr    =   0;
												foreach ( $lp_listing_menus as $menu_type => $lp_listing_menu ):
													$tab_counterr++;
													$lp_listing_menu_arr_cast   =   (array) $lp_listing_menu;
													if( is_array( $lp_listing_menu_arr_cast ) && count( $lp_listing_menu_arr_cast > 0 ) ) {
														?>
                                                        <div id="tabs-menu-type-<?php echo $tab_counterr; ?>">
															<?php
															foreach ($lp_listing_menu as $menu_group => $listing_menu):
																$menu_group_arr_cast    =   (array) $menu_group;
																$menu_groups_count += count($menu_group_arr_cast);

																?>
                                                                <h6><?php echo $menu_group; ?></h6>
																<?php
																foreach ($listing_menu as $k => $lp_menu):
																	$k_arr_cast =   (array) $k;
																	$menu_items_count += count($k_arr_cast);

																	$menu_id = str_replace(' ', '-', $menu_type) . '_' . str_replace(' ', '-', $menu_group) . '_' . $k . '_' . $lid;
																	?>
                                                                    <div class="lp-menu-close-outer">
                                                                        <div class="lp-menu-closed clearfix ">
                                                                            <span class="lp-right-side-title"><?php echo $lp_menu['mTitle']; ?></span>
                                                                            <span class="lp-dot-extra-buttons"><i
                                                                                        class="fa fa-ellipsis-h"
                                                                                        aria-hidden="true"></i>
                                                                            <ul class="lp-user-menu list-style-none">
                                                                                <li><a class="edit-menu-item"
                                                                                       data-menuID="<?php echo $menu_id; ?>"
                                                                                       data-uid="<?php echo $user_id; ?>"
                                                                                       href=""><i class="fa fa-pencil"
                                                                                                  aria-hidden="true"></i><span><?php echo esc_html__('Edit', 'listingpro'); ?></span></a></li>
                                                                                <li><a href="" class="menu-del del-this"
                                                                                       data-LID="<?php echo $lp_menu['mListing']; ?>"
                                                                                       data-targetid="<?php echo $menu_id; ?>"
                                                                                       data-uid="<?php echo $user_id; ?>"><i
                                                                                                class="fa fa-trash"
                                                                                                aria-hidden="true"></i><span><?php echo esc_html__('Delete', 'listingpro'); ?></span></a></li>
                                                                            </ul>
					                                                    </span>
                                                                        </div>
                                                                        <div id="menu-update-<?php echo $menu_id; ?>"
                                                                             class="lp-menu-form-outer background-white"
                                                                             style="display: none">
                                                                            <div class="lp-menu-form-inner">
                                                                                <form class="row">

                                                                                    <div class="col-sm-12">
                                                                                        <div class="lp-menu-form-feilds">
                                                                                            <div class="row clearfix">
                                                                                                <div class="col-md-8">
                                                                                                    <div class="margin-bottom-10">
                                                                                                        <label for="menu-title-<?php echo $menu_id; ?>"><?php echo esc_html__('Menu Item', 'listingpro'); ?></label>
                                                                                                        <input name="menu-title-<?php echo $menu_id; ?>"
                                                                                                               id="menu-title-<?php echo $menu_id; ?>"
                                                                                                               type="text"
                                                                                                               class="form-control"
                                                                                                               placeholder="<?php echo esc_html__('Ex: Roasted Chicken', 'listingpro'); ?>"
                                                                                                               value="<?php echo $lp_menu['mTitle']; ?>">
                                                                                                    </div>
                                                                                                    <div class="margin-bottom-10">
                                                                                                        <label for="menu-detail-<?php echo $menu_id; ?>"><?php echo esc_html__('Short Description', 'listingpro'); ?></label>
                                                                                                        <textarea
                                                                                                                name="menu-detail-<?php echo $menu_id; ?>"
                                                                                                                id="menu-detail-<?php echo $menu_id; ?>"
                                                                                                                type="text"
                                                                                                                class="form-control"
                                                                                                                rows="3"
                                                                                                                placeholder="<?php echo esc_html__('Ex: Roasted Chicken', 'listingpro'); ?>"><?php echo $lp_menu['mDetail']; ?></textarea>
                                                                                                    </div>
                                                                                                    <div class="row">
																										<?php
																										if (empty($lp_menu['mQuoteT'])):
																											?>
                                                                                                            <div class="menu-price-wrap">
                                                                                                                <div class="col-sm-6">
                                                                                                                    <label for="menu-old-price-<?php echo $menu_id; ?>"><?php echo esc_html__('Regular Price', 'listingpro'); ?></label>
                                                                                                                    <input name="menu-old-price-<?php echo $menu_id; ?>"
                                                                                                                           id="menu-old-price-<?php echo $menu_id; ?>"
                                                                                                                           type="text"
                                                                                                                           class="form-control"
                                                                                                                           placeholder="<?php echo esc_html__('Ex: $10', 'listingpro'); ?>"
                                                                                                                           value="<?php echo $lp_menu['mOldPrice']; ?>">
                                                                                                                </div>
                                                                                                                <div class="col-sm-6">
                                                                                                                    <label for="menu-new-price-<?php echo $menu_id; ?>"><?php echo esc_html__('Sale Price', 'listingpro'); ?></label>
                                                                                                                    <input id="menu-new-price-<?php echo $menu_id; ?>"
                                                                                                                           name="menu-new-price-<?php echo $menu_id; ?>"
                                                                                                                           type="text"
                                                                                                                           class="form-control"
                                                                                                                           placeholder="<?php echo esc_html__('Ex: $10', 'listingpro'); ?>"
                                                                                                                           value="<?php echo $lp_menu['mNewPrice']; ?>">
                                                                                                                </div>
                                                                                                            </div>
																										<?php
																										else:
																											?>
                                                                                                            <div class="menu-quote-wrap">
                                                                                                                <div class="col-sm-6">
                                                                                                                    <label for="menu-quote-text-<?php echo $menu_id; ?>"><?php esc_html_e('Quote Text', 'listingpro'); ?></label>
                                                                                                                    <input id="menu-quote-text-<?php echo $menu_id; ?>"
                                                                                                                           type="text"
                                                                                                                           class="form-control"
                                                                                                                           value="<?php echo $lp_menu['mQuoteT']; ?>"
                                                                                                                           placeholder="<?php echo esc_html__('Ex: Quote', 'listingpro'); ?>">
                                                                                                                </div>
                                                                                                                <div class="col-sm-6">
                                                                                                                    <label for="menu-quote-link-<?php echo $menu_id; ?>"><?php esc_html_e('Quote Link', 'listingpro'); ?></label>
                                                                                                                    <input id="menu-quote-link-<?php echo $menu_id; ?>"
                                                                                                                           type="text"
                                                                                                                           class="form-control"
                                                                                                                           value="<?php echo $lp_menu['mQuoteL']; ?>"
                                                                                                                           placeholder="<?php echo esc_html__('Ex: hht://yourweb.com/page', 'listingpro'); ?>">
                                                                                                                </div>
                                                                                                            </div>
																										<?php endif; ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-4">
                                                                                                    <div class="jFiler-input-dragDrop pos-relative">
                                                                                                        <div <?php echo $image_gallery; ?>
                                                                                                                class="upload-field dashboard-upload-field edit-upload-<?php echo $menu_id; ?>">
                                                                                                            <input class="frontend-input-multiple"
                                                                                                                   type="hidden"
                                                                                                                   id="dis-old-img-<?php echo $menu_id; ?>"
                                                                                                                   value="<?php echo $lp_menu['mImage']; ?>">
																											<?php echo do_shortcode('[frontend-button]'); ?>
                                                                                                            <div class="menu-edit-imgs-wrap">
																												<?php
																												if (!empty($lp_menu['mImage'])):

																													if (strpos($lp_menu['mImage'], ',')) {
																														$gallery_arr = explode(',', $lp_menu['mImage']);
																														$gallery_arr = array_filter($gallery_arr);
																														$gal_img_count = 0;
																														foreach ($gallery_arr as $img_url) {
																															?>
                                                                                                                            <div class="menu-edit-img-wrap gal-img-count-<?php echo $gal_img_count; ?>">
                                                                                                                                <span data-src="<?php echo $img_url; ?>"
                                                                                                                                      data-target="dis-old-img-<?php echo $menu_id; ?>"
                                                                                                                                      class="remove-menu-img"><i
                                                                                                                                            class="fa fa-close"></i></span>
                                                                                                                                <img class="gal-img-count-<?php echo $gal_img_count; ?> lp-uploaded-img event-old-img-<?php echo $menu_id; ?>"
                                                                                                                                     src="<?php echo $img_url; ?>"
                                                                                                                                     alt="">
                                                                                                                            </div>
																															<?php
																															$gal_img_count++;
																														}
																													} else {
																														?>
                                                                                                                        <div class="menu-edit-img-wrap gal-img-count-single">
                                                                                                                        <span data-src="<?php echo $lp_menu['mImage']; ?>"
                                                                                                                              data-target="dis-old-img-<?php echo $menu_id; ?>"
                                                                                                                              class="remove-menu-img"><i
                                                                                                                                    class="fa fa-close"></i></span>
                                                                                                                            <img class="gal-img-count-single lp-uploaded-img event-old-img-<?php echo $menu_id; ?>"
                                                                                                                                 src="<?php echo $lp_menu['mImage']; ?>"
                                                                                                                                 alt="">
                                                                                                                        </div>
																														<?php
																													}
																													?>
																												<?php endif; ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="clearfix"></div>
                                                                                    <div class="clearfix lp-choose-menu">
                                                                                        <div class="lp-listing-selecter-drop form-group clearfix margin-bottom-0 lp-new-cat-wrape col-sm-6">
                                                                                            <label for="menu-type-<?php echo $menu_id; ?>"><?php echo esc_html__('Menu Type', 'listingpro'); ?></label>
                                                                                            <select id="menu-type-<?php echo $menu_id; ?>"
                                                                                                    name="menu-type-<?php echo $menu_id; ?>"
                                                                                                    class="form-control select2">
																								<?php
																								foreach ($menu_types_data as $menu_type_data) {
																									if ($menu_type_data['type'] == $menu_type) {
																										echo '<option selected>' . $menu_type_data['type'] . '</option>';
																									} else {
																										echo '<option>' . $menu_type_data['type'] . '</option>';
																									}

																								}
																								?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="lp-listing-selecter-drop col-sm-6">
                                                                                            <label for="menu-group-<?php echo $menu_id; ?>"><?php echo esc_html__('Menu Group', 'listingpro'); ?></label>
                                                                                            <select id="menu-group-<?php echo $menu_id; ?>"
                                                                                                    name="menu-group-<?php echo $menu_id; ?>"
                                                                                                    class="form-control select2">
																								<?php
																								foreach ($menu_groups_data as $menu_group_data) {
																									if ($menu_group_data['group'] == $menu_group) {
																										echo '<option selected>' . $menu_group_data['group'] . '</option>';
																									} else {
																										echo '<option>' . $menu_group_data['group'] . '</option>';
																									}
																								}
																								?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="lp-menu-save-btns clearfix">
                                                                                        <button class="lp-cancle-btn cancel-update-menu"><?php echo esc_html__('Cancel', 'listingpro'); ?></button>
                                                                                        <button data-LID="<?php echo $lp_menu['mListing']; ?>"
                                                                                                data-menuID="<?php echo $menu_id; ?>"
                                                                                                data-uid="<?php echo $user_id; ?>"
                                                                                                class="lp-save-btn lp-edit-menu"><?php echo esc_html__('save', 'listingpro'); ?></button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
																<?php
																endforeach;
															endforeach;
															?>
                                                        </div>
														<?php
													}
												endforeach;
												?>
                                                <input class="menu-type-count-val" type="hidden" value="<?php echo $menu_type_count; ?>" id="menu-type-count-<?php echo $lid; ?>">
                                                <input class="menu-group-count-val" type="hidden" value="<?php echo $menu_groups_count; ?>" id="menu-group-count-<?php echo $lid; ?>">
                                                <input class="menu-items-count-val" type="hidden" value="<?php echo $menu_items_count; ?>" id="menu-items-count-<?php echo $lid; ?>">
                                            </div>
                                        </div>
                                    </div>
								<?php endif; endwhile; wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
            </div>
		<?php endif;; ?>
        <div style="display: none;" id="menu-form-toggle" class="lp-menu-step-two margin-top-20">
            <div class="col-md-9 padding-0 padding-right15">
                <div class="lp-add-menu-outer clearfix">
                    <h5 class="margin-bottom-20"><?php esc_html_e('Create Menu','listingpro'); ?></h5>
                </div>
                <div class="panel-body margin-bottom-30">
                    <div class="lp-listing-selecter clearfix background-white">
                        <div class="form-group col-sm-6 ">
                            <div class="lp-listing-selecter-content margin-top-18">
                                <h5><?php esc_html_e('Select a Listing','listingpro'); ?></h5>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 ">
                            <div class="lp-listing-selecter-drop">
								<div class="lp-pp-noa-tip">
								    <i class="fa fa-exclamation" aria-hidden="true"></i> <?php echo esc_html__('Menu not allowed with this listing. Please upgrade your plan.', 'listingpro'); ?>
								</div>
                                <select data-metakey="menu" name="menu-listing" id="menu-listing" class="form-control select2-ajax">
                                    <option value="0"><?php echo esc_html__('Select Listing', 'listingpro'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-menu-close-outer lp-menu-open">
                    <div class="lp-menu-form-outer background-white">
                        <div class="lp-menu-form-inner">
                            <form class="row">
                                <div class="col-sm-4">
                                    <div class="jFiler-input-dragDrop pos-relative">
                                        <div <?php echo $image_gallery; ?> class="upload-field dashboard-upload-field new-file-upload">
											<?php echo do_shortcode('[frontend-button]'); ?>
                                            <div class="menu-edit-imgs-wrap">
                                                <input class="frontend-input-multiple" type="hidden"  value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8 padding-left-0">
                                    <div class="lp-menu-form-feilds">
                                        <div class="margin-bottom-10">
                                            <label for="menu-title"><?php esc_html_e('Menu Item','listingpro'); ?></label>
                                            <input name="menu-title" id="menu-title" type="text" class="form-control" placeholder="<?php echo esc_html__('Ex: Roasted Chicken', 'listingpro'); ?>">
                                        </div>
                                        <div class="margin-bottom-10">
                                            <label for="menu-detail"><?php esc_html_e('Short Description','listingpro'); ?></label>
                                            <textarea name="menu-detail" id="menu-detail" type="text" class="form-control" rows="3" placeholder="<?php echo esc_html__('Ex: Roasted Chicken', 'listingpro'); ?>"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="menu-price-wrap">
                                                <div class="col-sm-6">
                                                    <label for="menu-old-price"><?php esc_html_e('Regular Price','listingpro'); ?></label>
                                                    <input id="menu-old-price" type="text" class="form-control" placeholder="<?php echo esc_html__('Ex: $10', 'listingpro'); ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="menu-new-price"><?php esc_html_e('Sale Price','listingpro'); ?></label>
                                                    <input id="menu-new-price" name="menu-new-price" type="text" class="form-control"  placeholder="<?php echo esc_html__('Ex: $10', 'listingpro'); ?>">
                                                </div>
                                            </div>
                                            <div class="menu-quote-wrap" style="display: none">
                                                <div class="col-sm-6">
                                                    <label for="menu-quote-text"><?php esc_html_e('Quote Text','listingpro'); ?></label>
                                                    <input id="menu-quote-text" type="text" class="form-control" placeholder="<?php echo esc_html__('Ex: Quote', 'listingpro'); ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="menu-quote-link"><?php esc_html_e('Quote Link','listingpro'); ?></label>
                                                    <input id="menu-quote-link" type="text" class="form-control"  placeholder="<?php echo esc_html__('Ex: hht://yourweb.com/page', 'listingpro'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lp-invoices-all-stats-on-off">
                                            <span><?php esc_html_e('Popular Item','listingpro'); ?></span>
                                            <label class="switch">
                                                <input value="Yes" class="form-control switch-checkbox" type="checkbox" name="lp_form_fields_inn[235]">
                                                <div class="slider round"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="clearfix lp-choose-menu">
                                    <div class="lp-listing-selecter-drop form-group clearfix margin-bottom-0 lp-new-cat-wrape col-sm-6">
                                        <label for="menu-type"><?php esc_html_e('Menu Type','listingpro'); ?></label>
                                        <select multiple id="menu-type" name="menu-type" class="form-control select2">
											<?php
											if( $menu_types_data && is_array( $menu_types_data ) && !empty( $menu_types_data ) ):
												foreach ( $menu_types_data as $menu_type ):
													echo '<option>'. $menu_type['type'] .'</option>';
												endforeach;
											endif;
											?>
                                        </select>
                                        <input style="display: none;" type="text" class="form-control" name="menu-type-new" id="menu-type-new" placeholder="menu type" data-err="<?php echo esc_html__( 'Special characters not allowed' ); ?>">
                                        <a href="#" class="add-new-type"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__( 'Add New Type', 'listingpro' ); ?></a>
                                        <a href="#" data-uid="<?php echo $user_id; ?>" style="display: none;" class="save-new-type"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo esc_html__( 'save', 'listingpro' ); ?></a>

                                    </div>
                                    <div class="lp-listing-selecter-drop col-sm-6 clearfix">
                                        <label for="menu-group"><?php esc_html_e('Menu Group','listingpro'); ?></label>
                                        <select multiple id="menu-group" name="menu-group" class="form-control select2">
											<?php
											if( $menu_groups_data && is_array( $menu_groups_data ) && !empty( $menu_groups_data ) ):
												foreach ( $menu_groups_data as $menu_group ):
													echo '<option>'. $menu_group['group'] .'</option>';
												endforeach;
											endif;
											?>
                                        </select>
                                        <input style="display: none;" type="text" class="form-control" name="menu-group-new" id="menu-group-new" placeholder="menu group" data-err="<?php echo esc_html__( 'Special characters not allowed' ); ?>">
                                        <a href="#" class="add-new-group"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html__( 'Add New Group', 'listingpro' ); ?></a>
                                        <a href="#" data-uid="<?php echo $user_id; ?>" style="display: none;" class="save-new-group"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo esc_html__( 'save', 'listingpro' ); ?></a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="lp-menu-step-two-btn">
                    <button id="lp-save-menu" data-uid="<?php echo $user_id; ?>"><span><i class="fa fa-plus" aria-hidden="true"></i></span> <?php esc_html_e('add menu item','listingpro'); ?></button>
                </div>
            </div>
            <div class="col-md-3 padding-right-0 lp-right-panel-height">
                <div class="lp-ad-click-outer">
                    <div class="lp-general-section-title-outer">
                        <p id="reply-title" class="clarfix lp-general-section-title comment-reply-title active"> <?php echo esc_html__( 'Settings', 'listingpro' ); ?> <i class="fa fa-angle-down" aria-hidden="true"></i></p>
                        <div class="lp-ad-click-inner" id="lp-ad-click-inner">
                            <ul class="lp-invoices-all-stats clearfix coupons-fields-switch">
                                <li class="lp-invoices-all-stats-on-off">
                                    <h5 class="clearfix"><?php esc_html_e('Quote Button','listingpro'); ?>
                                        <label class="switch">
                                            <input data-target="quote-button" class="form-control switch-checkbox" type="checkbox">
                                            <div class="slider round"></div>
                                        </label>
                                    </h5>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>