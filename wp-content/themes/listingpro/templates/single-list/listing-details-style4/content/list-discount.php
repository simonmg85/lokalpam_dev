<?php

$listing_discount_data =   get_post_meta( get_the_ID(), 'listing_discount_data', true );

if( isset( $listing_discount_data ) && is_array( $listing_discount_data ) && !empty( $listing_discount_data ) ):
echo '<div class="list-discount-outer">';
    require_once (THEME_PATH . "/include/aq_resizer.php");



    $strNow =   strtotime("NOW");

    $discount_counter   =   1;

    $col_class  =   'col-md-12';

    $nopadding  =   'no-padding-sidebar';

    $post_author_id = get_post_field( 'post_author', get_the_ID() );

    $discount_displayin =   get_user_meta( $post_author_id, 'discount_display_area', true );

    if( $discount_displayin == 'content' )

    {

        $col_class  =   'col-md-6';

        $nopadding  =   'no-padding-discount';

    }



    foreach ( $listing_discount_data as $key => $discount_data ):

        if( ( $strNow < $discount_data['disExpE'] || empty( $discount_data['disExpE'] ) ) && ( $strNow > $discount_data['disExpS'] || empty( $discount_data['disExpS'] ) ) ) :

            $img_url    =   'https://placeholdit.imgix.net/~text?w=100&h=100';

            if( !empty( $discount_data['disImg'] ) )

            {

                $img_url  = aq_resize( $discount_data['disImg'], '100', '100', true, true, true);

            }

            ?>

            <div class="<?php echo $col_class; ?> <?php echo $nopadding; ?>">

                <div class="lp-widget lp-discount-widget">

                    <div class="lp-discount-top">

                        <?php

                        if( $discount_data['disOff'] ) echo '<span class="lp-discount-thumb-tagline">'. $discount_data['disOff'] .'</span>';

                        ?>

                        <div class="lp-discount-thumb">

                            <img src="<?php echo $img_url; ?>" alt="<?php echo $discount_data['disHea']; ?>">

                        </div>

                    </div>

                    <div class="lp-discount-bottom">

                        <?php

                        if( !empty( $discount_data['disHea'] ) ){ echo '<strong class="dishead">'. $discount_data['disHea'] .'</strong>'; }

                        ?>

                        <?php

                        if( !empty( $discount_data['disDes'] ) ){ echo $discount_data['disDes']; }

                        ?>

                        <?php

                        if( !empty( $discount_data['disExpE'] ) ) :

                            ?>

                            <p><strong><?php echo esc_html__( 'Validity:', 'listingpro' ); ?></strong> <?php echo date_i18n( get_option('date_format'), $discount_data['disExpE'] ); ?></p>

                            <div class="lp-discount-count-wrap">

                                <div id="lp-discount-countdown-<?php echo $discount_counter; ?>" class="lp-discount-countdown lp-countdown"
                                     data-label-days="<?php echo esc_html__('days', 'listingpro'); ?>"
                                    data-label-hours="<?php echo esc_html__('hours', 'listingpro'); ?>"
                                    data-label-mints="<?php echo esc_html__('min', 'listingpro') ?>"
                                     data-day="<?php echo date('d', $discount_data['disExpE'] ); ?>"
                                     data-month="<?php echo date('m', $discount_data['disExpE'] )-1; ?>"
                                     data-year="<?php echo date('Y', $discount_data['disExpE'] ); ?>"></div>

                            </div>

                        <?php endif; ?>

                    </div>

                    <?php
					
					$bnt_text_def   =   esc_html__( 'Click Here', 'listingpro' );
                   if( empty( $discount_data['disBT'] ) )
                   {
                       $discount_data['disBT'] =   $bnt_text_def;
                   }

                    if( isset( $discount_data['disBT'] ) && !empty( $discount_data['disBT'] ) ):

                        ?>

                        <a data-html="<?php echo $discount_data['disBT'] ; ?>" data-target-code="dicount-copy-<?php echo $discount_counter; ?>" <?php if( isset( $discount_data['disBL'] ) && !empty( $discount_data['disBL'] ) ): echo 'target="_blank" href="'. $discount_data['disBL'] .'"';  endif; ?> class="lp-discount-btn <?php if( empty( $discount_data['disBL'] ) ){ echo 'lp-copy-code'; } ?>"><?php echo $discount_data['disBT'] ; ?></a>

                    <?php endif; ?>
                    <?php
                    if( empty( $discount_data['disBL'] ) ):
                        ?>
                        <div class="dis-code-copy-pop extra-bottom dicount-copy-<?php echo $discount_counter; ?>" id="dicount-copy-<?php echo $discount_counter; ?>">

                            <div class="dis-code-copy-pop-inner">

                                <div class="dis-code-copy-pop-inner-cell">

                                    <p><?php echo esc_html__( 'Copy to clipboard', 'listingpro' ); ?></p>

                                    <p class="dis-code-copy-wrap"><input class="code-top-copy-<?php echo $discount_counter; ?>" type="text" value="<?php echo $discount_data['disCod']; ?>"> <a data-target-code="dicount-copy-<?php echo $discount_counter; ?>" href="#" class="copy-now" data-coppied-label="<?php echo esc_html__( 'Copied', 'listingpro' ); ?>"><?php echo esc_html__( 'Copy', 'listingpro' ); ?></a></p>

                                </div>

                            </div>

                        </div>
                    <?php endif; ?>

                </div>

            </div>

            <?php

            $discount_counter++;

        endif;

    endforeach;

    echo '<div class="clearfix"></div>';
echo '</div>';
endif;