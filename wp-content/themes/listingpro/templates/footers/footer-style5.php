<?php 
global $listingpro_options;
	$copy_right = $listingpro_options['copy_right'];
	$footer_logo    =   $listingpro_options['footer_logo'];
    $footer_address = $listingpro_options['footer_address'];
    $phone_number = $listingpro_options['phone_number'];
    $author_info = $listingpro_options['author_info'];
    $fb = $listingpro_options['fb'];
    $tw = $listingpro_options['tw'];
    $gog = $listingpro_options['gog'];
    $insta = $listingpro_options['insta'];
    $tumb = $listingpro_options['tumb'];
    $fyout = $listingpro_options['f-yout'];
    $flinked = $listingpro_options['f-linked'];
    $fpintereset = $listingpro_options['f-pintereset'];
    $fvk = $listingpro_options['f-vk'];
    $footer_style = $listingpro_options['footer_style'];
?>

<!--footer 5-->
<div class="clearfix"></div>
<footer class="footer-style4">
        <div class="padding-top-60 padding-bottom-60">
            <div class="container">
                <div class="row">
                    <?php
                        $grid = $listingpro_options['footer_layout'] ? $listingpro_options['footer_layout'] : '12';

                        $i = 1;
                        foreach (explode('-', $grid) as $g) {
                            echo '<div class="clearfix col-md-' . $g . ' col-' . $i . '">';
                            dynamic_sidebar("footer-sidebar-$i");
                            echo '</div>';
                            $i++;
                        }

                    ?>
                </div>
            </div>
        </div>

        <div class="footer5-bottom-area lp-footer-bootom-border">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <?php if(!empty($tw) || !empty($gog) || !empty($fb) || !empty($insta) || !empty($tumb) || !empty($fpintereset) || !empty($flinked) || !empty($fyout) || !empty($fvk)){ ?>
                                    <ul class="social-icons footer-social-icons">
                                        <?php if(!empty($fb)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($fb); ?>" target="_blank">
                                                    <?php echo listingpro_icons('facebook'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($gog)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($gog); ?>" target="_blank">
                                                    <?php echo listingpro_icons('google'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($tw)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($tw); ?>" target="_blank">
                                                    <?php echo listingpro_icons('tw-footer'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($insta)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($insta); ?>" target="_blank">
                                                    <?php echo listingpro_icons('instagram'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($fyout)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($fyout); ?>" target="_blank">
                                                    <?php echo listingpro_icons('ytwite'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($flinked)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($flinked); ?>" target="_blank">
                                                    <?php echo listingpro_icons('linkedin'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($fpintereset)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($fpintereset); ?>" target="_blank">
                                                    <?php echo listingpro_icons('pinterest'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($tumb)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($tumb); ?>" target="_blank">
                                                    <?php echo listingpro_icons('tumbler'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($fvk)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($fvk); ?>" target="_blank">
                                                    <?php echo listingpro_icons('vk'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>

                                    </ul>
                                <?php } ?>
                    </div>
                    <?php
                        if( !empty( $copy_right ) ):
                    ?>
                    <div class="col-md-7">
                        <span class="copyrights"><?php echo $copy_right; ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
</footer>