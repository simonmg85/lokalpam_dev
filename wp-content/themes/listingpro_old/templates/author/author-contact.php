<?php$authorID   =   $GLOBALS['authorID'];$author_fb    =   get_the_author_meta( 'facebook', $authorID );$author_tw    =   get_the_author_meta( 'twitter', $authorID );$author_pin    =   get_the_author_meta( 'pinterest', $authorID );$author_insta    =   get_the_author_meta( 'instagram', $authorID );$author_gp    =   get_the_author_meta( 'google', $authorID );$author_link    =   get_the_author_meta( 'linkedin', $authorID );$author_phone    =   get_the_author_meta( 'phone', $authorID );$author_website    =   get_the_author_meta( 'url', $authorID );$author_email    =   get_the_author_meta( 'email', $authorID );$author_address    =   get_the_author_meta( 'address', $authorID );?><div class="author-contact-wrap">    <div class="row">        <div class="col-md-6 col-md-offset-3">            <?php get_template_part( 'templates/single-list/listing-details-style3/sidebar/lead-form' ); ?>        </div>        <div class="clearfix"></div>    </div><!--    <h4 class="author-contact-second-heading">--><?php //echo esc_html__( 'Social' ); ?><!--</h4>--></div>