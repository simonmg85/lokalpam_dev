<div class="lp-listing-price-range lp-widget-inner-wrap">
	<?php

	$menuOption = false;

	$menuTitle = '';

	$menuImg = '';

	$menuMeta = get_post_meta($post->ID, 'menu_listing', true);

	if(!empty($menuMeta)){

		$menuTitle = $menuMeta['menu-title'];

		$menuImg = $menuMeta['menu-img'];

		$menuOption = true;

	}

	if( ( !empty($menuMeta) && $menuOption == true ) ) {

		?>

		<?php

		if (!empty($menuMeta) && $menuOption == true) {

			?>

            <p class="menu-hotel">

                <a href="#" class="open-modal">

					<?php echo listingpro_icons('resMenu'); ?>

                    <span>

						<?php if (!empty($menuTitle)) {

							echo $menuTitle;

						} else {

							echo esc_html__('See Full Menu', 'listingpro');

						} ?>

					</span>

                </a>

            <div class="hotel-menu">

                <div class="inner-menu">

                    <a href="#" class="close-menu-popup"><i class="fa fa-times"></i></a>

					<?php

					if( strpos( $menuImg, ',' ) )

					{

						$menuImg_arr    =   explode( ',', $menuImg );

						$menuImg_arr    =   array_filter( $menuImg_arr );

						foreach ( $menuImg_arr as $menuImgUrl )

						{

							echo '<img src="'. $menuImgUrl .'" alt="">';

						}

					}

					else

					{

						echo '<img src="'. $menuImg .'" alt="">';

					}

					?>



                </div>

            </div>

            </p>

		<?php }

	} ?>
    <?php
    $dollars  =   listing_price_range_symbol(get_the_ID());
    if( !empty( $dollars ) )
    {
        if( $dollars['dollars'] == '1' ){ $dollar_tip   =   esc_html__( 'Inexpensive', 'listingpro' ); }
        if( $dollars['dollars'] == '2' ){ $dollar_tip   =   esc_html__( 'Moderate', 'listingpro' ); }
        if( $dollars['dollars'] == '3' ){ $dollar_tip   =   esc_html__( 'Pricey', 'listingpro' ); }
        if( $dollars['dollars'] == '4' ){ $dollar_tip   =   esc_html__( 'Ultra High End', 'listingpro' ); }
    ?>
        <p class="pricey">
            <span class="pricey simptip-position-top simptip-movable" data-tooltip="<?php echo $dollar_tip; ?>">
                <span class="currency-sign <?php if($dollars['dollars'] > 0){ echo 'green';}; ?>"><?php echo $dollars['symbol']; ?></span>
                <span class="currency-sign <?php if($dollars['dollars'] > 1){ echo 'green';}; ?>"><?php echo $dollars['symbol']; ?></span>
                <span class="currency-sign <?php if($dollars['dollars'] > 2){ echo 'green';}; ?>"><?php echo $dollars['symbol']; ?></span>
                <span class="currency-sign <?php if($dollars['dollars'] > 3){ echo 'green';}; ?> currency-sign-last"><?php echo $dollars['symbol']; ?></span>
            </span>
            <?php echo esc_html__('Price Range', 'listingpro'); ?> <?php listing_price_range(get_the_ID()); ?>
        </p>
        <?php
    }
    ?>
    <?php get_template_part('templates/single-list/claimed' ); ?>
    <?php
    if($showReport == true && is_user_logged_in() ):
    ?>
        <p id="lp-report-listing">
            <span><img class="icon icons8-Flag-2" width="20" height="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAABAElEQVQ4T+1T0W2DUBDz3QTpBoyQERiBDZpJkAUDVN2gI6QbNBMkG4QNkgXgIotHlaYkNKjKV56EkLg7n5+xjWQREa8AsogwAEf0JzOzbUSs3f2T5PA9lcdfVpZl4+4Fyd1lC8kMQNF13UrgZvY+1qc5kisRE+BXVVX5zbX9QC5gAEszOwBodAvNRcQLgLWW/xnwfCHJhYAlzzljkZsFeO02T8Cp/zxdf4yG8lvbtlHX9Waa08+OgWFjZvtkTsVreGTaRaopfhuSMvPoSUl5kw937p5fyypJGVgpUZqUkn1CVFRV+06Ku3/MMrZkSaDNJetZgLe0fQLe67zf/f+u4QlxCbp3x7Q50wAAAABJRU5ErkJggg=="> <?php echo esc_html__('Want to report this?', 'listingpro'); ?></span>
            <a href="#" data-postid="<?php echo get_the_ID(); ?>"  data-reportedby="<?php echo $currentUserId; ?>" data-posttype="listing" href="#" id="lp-report-this-listing"><?php echo esc_html__('Report Now!', 'listingpro'); ?></a>
        </p>
    <?php endif; ?>
    <?php get_template_part('templates/single-list/claim-form' ); ?>
</div>