<?php
global $listingpro_options;
$lp_detail_page_styles = $listingpro_options['lp_detail_page_styles'];
$header_viewss  =   $listingpro_options['header_views'];

if( $header_viewss == 'header_with_topbar_menu' )
{
    ?>
    <div class="lp-header-user-nav">
        <?php
        if ( !is_user_logged_in() )
        {
            ?>
            <a class="header-login-btn md-trigger" data-modal="modal-3">
                <i class="fa fa-user" aria-hidden="true"></i>
            </a>
            <?php
        }
        else
        {
            $current_user = wp_get_current_user();
            $u_display_name = $current_user->display_name;
            if(empty($u_display_name))
            {
                $u_display_name = $current_user->nickname;
            }
            global $listingpro_options;
            $authorURL = $listingpro_options['listing-author'];
            ?>
            <div class="lp-join-now after-login lp-join-user-info lp-join-now-v2">
                <ul>
                    <li class="juname">
                        <?php
                        if ( is_plugin_active( 'listingpro-plugin/plugin.php' ) ) {
                            ?>
                            <a href="<?php echo esc_url($authorURL); ?>" class="juname">
                                <img src="<?php echo listingpro_author_image(); ?>" alt="userimg" height="34" width="34" />
                            </a>
                        <?php } ?>
                        <?php
                        $dashURL = listingpro_url('listing-author');
                        if(!empty($dashURL)){
                            $currentURL = $dashURL;
                            $perma = '';
                            $dashQuery = 'dashboard=';
                            global $wp_rewrite;
                            if ($wp_rewrite->permalink_structure == ''){
                                $perma = "&";
                            }else{
                                $perma = "?";
                            }
                            ?>
                            <ul class="lp-user-menu list-style-none">
                                <li class="lp-user-welcome"><?php echo esc_html__( 'Hello', 'listingpro' ). ' ' .esc_html($u_display_name); ?></li>
                                <li><a href="<?php echo listingpro_url('listing-author'); ?>"><?php esc_html_e('Dashboard','listingpro'); ?> </a></li>
                                <li><a href="<?php echo $currentURL.$perma.$dashQuery.'update-profile'; ?>"><?php esc_html_e('Update Profile','listingpro'); ?></a></li>
                                <li><a href="<?php echo wp_logout_url( esc_url(home_url('/')) ); ?>"><?php esc_html_e('Sign out ','listingpro'); ?></a></li>
                            </ul>
                        <?php } ?>
                    </li>
                </ul>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
else
{
    if (!is_user_logged_in()) {
        ?>
        <div class="lp-join-now">
                                <span>
                                    <!-- Contacts icon by Icons8 -->
                                    <?php echo listingpro_icons('contacts'); ?>
                                </span>
            <a class=" md-trigger" data-modal="modal-3"><?php esc_html_e('Join Now', 'listingpro'); ?></a>
        </div>
    <?php }else{
        $current_user = wp_get_current_user();
        $u_display_name = $current_user->display_name;
        if(empty($u_display_name)){
            $u_display_name = $current_user->nickname;
        }
        global $listingpro_options;
        $authorURL = $listingpro_options['listing-author'];
        ?>
        <div class="lp-join-now after-login lp-join-user-info">
            <ul>
                <li>
                                        <span>
                                            <img src="<?php echo listingpro_author_image(); ?>" alt="userimg" />
                                        </span>
                    <?php

                    if ( is_plugin_active( 'listingpro-plugin/plugin.php' ) ) {
                        ?>
                        <a href="<?php echo esc_url($authorURL); ?>">
                            <?php
                            echo  esc_html($u_display_name);
                            ?>
                        </a>
                    <?php }else{ ?>
                        <a href="<?php echo get_author_posts_url($current_user->ID); ?>">
                            <?php
                            echo  esc_html($u_display_name);
                            ?>
                        </a>
                    <?php } ?>
                    <?php
                    $dashURL = listingpro_url('listing-author');
                    if(!empty($dashURL)){
                        $currentURL = $dashURL;
                        $perma = '';
                        $dashQuery = 'dashboard=';
                        global $wp_rewrite;
                        if ($wp_rewrite->permalink_structure == ''){
                            $perma = "&";
                        }else{
                            $perma = "?";
                        }
                        ?>
                        <ul class="lp-user-menu list-style-none">
                            <li><a href="<?php echo listingpro_url('listing-author'); ?>"><?php esc_html_e('Dashboard','listingpro'); ?> </a></li>
                            <li><a href="<?php echo $currentURL.$perma.$dashQuery.'update-profile'; ?>"><?php esc_html_e('Update Profile','listingpro'); ?></a></li>
                            <li><a href="<?php echo wp_logout_url( esc_url(home_url('/')) ); ?>"><?php esc_html_e('Sign out ','listingpro'); ?></a></li>
                        </ul>
                    <?php } ?>
                </li>
            </ul>
        </div>
        <?php
    }

}
?>