<?php
global $listingpro_options;
$sub_cats       =   $listingpro_options['lp_listing_sub_cats'];
if( is_tax( 'listing-category' ) && $sub_cats == 'show' ):

    $sub_cats_loc   =   $listingpro_options['lp_listing_sub_cats_lcation'];

    $queried_object = get_queried_object();
    $parent_id = $queried_object->term_id;
    $child_cats =   get_terms(
        'listing-category',
        array(
            'hide_empty' => false,
            'parent' => $parent_id
        )
    );
    if( !empty( $child_cats ) ):

        require_once (THEME_PATH . "/include/aq_resizer.php");
        ?>
        <div class="lp-child-cats-tax style-<?php echo $sub_cats_loc; ?>">
            <div class="lp-child-cats-tax-slider" data-child-loc="<?php echo $sub_cats_loc; ?>">
                <?php
                foreach ( $child_cats as $child_cat ):
                    $term_banner    =   get_term_meta( $child_cat->term_id,'lp_category_banner', true );
                    $term_link  =   get_term_link( $child_cat );
                    if( empty( $term_banner ) )
                    {
//                        $banner_url =   'https://placeholdit.imgix.net/~text?txtsize=33&w=246&h=126';
                        $banner_url =   'https://placeholdit.imgix.net/~text?txtsize=33&w=246&h=126';
                    }
                    else
                    {
//                        $banner_url =    aq_resize( $term_banner, '246', '126', true, true, true);
                        $banner_url =    aq_resize( $term_banner, '246', '126', true, true, true);
                    }
                    ?>
                    <div class="<?php if($sub_cats_loc == 'content'){echo 'col-grid-3';}else{ echo 'col-grid-5'; } ?> lp-child-cats-tax-wrap">
                        <div class="lp-child-cats-tax-inner">
                            <div class="lp-child-cat-tax-thumb">
                                <img src="<?php echo $banner_url; ?>" alt="<?php echo $child_cat->name; ?>">
                            </div>
                            <div class="lp-child-cat-tax-name">
                                <a href="<?php echo $term_link; ?>">
                                    <?php echo $child_cat->name; ?>
                                    <span><?php echo $child_cat->count; ?>
                                        <?php
                                        if( $child_cat->count == 1 ):
                                            ?>
                                            <?php echo esc_html__( 'Listing', 'listingpro' ); ?>
                                        <?php else: ?>
                                            <?php echo esc_html__( 'Listings', 'listingpro' ); ?>
                                        <?php endif; ?>
                                                    </span>

                                </a>

                            </div>
                        </div>
                    </div>
                <?php endforeach;; ?>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php endif; endif; ?>