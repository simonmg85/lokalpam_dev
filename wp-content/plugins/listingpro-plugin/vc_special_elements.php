<?php
/*------------------------------------------------------*/
/* ListingPro Columns Element
/*------------------------------------------------------*/

$locations = get_terms('location', array('hide_empty' => false));
$loc = array();
foreach($locations as $location) {
    $loc[$location->name] = $location->term_id;
}

$categories = get_terms('listing-category', array('hide_empty' => false));
$cats = array();
foreach($categories as $category) {
    $cats[$category->name] = $category->term_id;
}


vc_map( array(
    "name"                      => esc_html__("ListingPro Columns Element", "js_composer"),
    "base"                      => 'listingpro_columns',
    "category"                  => esc_html__('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => esc_html__("Column Left Image","js_composer"),
            "param_name"  => "listing_cols_left_img",
            "value"       => get_template_directory_uri()."/assets/images/columns.png",
            "description" => ""
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("First Column Title","js_composer"),
            "param_name"	=> "listing_first_col_title",
            "value"			=> "1- Claimed"
        ),
        array(
            'type'        => 'textarea',
            'heading'     => esc_html__( 'First Column Description', 'js_composer' ),
            'param_name'  => 'listing_first_col_desc',
            'value'       => 'Best way to start managing your business listing is by claiming it so you can update.'
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Second Column Title","js_composer"),
            "param_name"	=> "listing_second_col_title",
            "value"			=> "2- Promote"
        ),
        array(
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Second Column Description', 'js_composer' ),
            'param_name'  => 'listing_second_col_desc',
            'value'       => 'Promote your business to target customers who need your services or products.'
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Third Column Title","js_composer"),
            "param_name"	=> "listing_third_col_title",
            "value"			=> "3- Convert"
        ),
        array(
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Third Column Description', 'js_composer' ),
            'param_name'  => 'listing_third_col_desc',
            'value'       => 'Turn your visitors into paying customers with exciting offers and services on your page.'
        ),
    ),
) );
function listingpro_shortcode_columns($atts, $content = null) {
    extract(shortcode_atts(array(
        'listing_cols_left_img'      => get_template_directory_uri()."/assets/images/columns.png",
        'listing_first_col_title'    => '1- Claimed',
        'listing_first_col_desc'     => 'Best way to start managing your business listing is by claiming it so you can update.',
        'listing_second_col_title' 	 => '2- Promote',
        'listing_second_col_desc' 	 => 'Promote your business to target customers who need your services or products.',
        'listing_third_col_title' 	 => '3- Convert',
        'listing_third_col_desc' 	 => 'Turn your visitors into paying customers with exciting offers and services on your page.',
    ), $atts));

    $output = null;

    $leftImg = '';
    if (!empty($listing_cols_left_img)) {
        $bgImage = wp_get_attachment_image_src( $listing_cols_left_img, 'full' );
        $leftImg = '<img src="'.$bgImage[0].'" alt="">';
    }else{
        $leftImg = '';
    }

    $output .='
	<div class="promotional-element listingpro-columns">
		<div class="listingpro-row padding-top-60 padding-bottom-60">
			<div class="promotiona-col-left">
				'.$leftImg.'
			</div>
			<div class="promotiona-col-right">
				<article>
					<h3>'.$listing_first_col_title.'</h3>
					<p>'.$listing_first_col_desc.'</p>
				</article>
				<article>
					<h3>'.$listing_second_col_title.'</h3>
					<p>'.$listing_second_col_desc.'</p>
				</article>
				<article>
					<h3>'.$listing_third_col_title.'</h3>
					<p>'.$listing_third_col_desc.'</p>
				</article>
			</div>
		</div>
	</div>';

    return $output;
}
add_shortcode('listingpro_columns', 'Listingpro_shortcode_columns');
/*------------------------------------------------------*/
/* Promotional Element
/*------------------------------------------------------*/

vc_map( array(
    "name"                      => esc_html__("Listingpro Promotional Element", "js_composer"),
    "base"                      => 'listingpro_promotional',
    "category"                  => esc_html__('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => esc_html__("Banner Left Image","js_composer"),
            "param_name"  => "listing_element_left_img",
            "value"       => get_template_directory_uri()."/assets/images/adss.png",
            "description" => ""
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Element Title","js_composer"),
            "param_name"	=> "listing_element_title",
            "value"			=> ""
        ),
        array(
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Element Description', 'js_composer' ),
            'param_name'  => 'element_desc',
            'value'       => ''
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Element Link Title', 'js_composer' ),
            'param_name'  => 'element_link_title',
            'description' => esc_html__( 'Add Link Title', 'js_composer' ),
            'default'	  => '',
            'value'       => '',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Element Link URL', 'js_composer' ),
            'param_name'  => 'element_link_url',
            'description' => esc_html__( 'Add URL here', 'js_composer' ),
            'default'	  => '',
            'value'       => '',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Element Phone Number', 'js_composer' ),
            'param_name'  => 'element_phone_number',
            'description' => esc_html__( '', 'js_composer' ),
            'default'	  => '',
            'value'       => '',
        ),
    ),
) );
function listingpro_shortcode_promotion($atts, $content = null) {
    extract(shortcode_atts(array(
        'listing_element_left_img'      => get_template_directory_uri()."/assets/images/adss.png",
        'listing_element_title'         => '',
        'element_desc' 					=> '',
        'element_link_title' 		  	=> '',
        'element_link_url' 		  		=> '',
        'element_phone_number' 		  	=> '',
    ), $atts));

    $output = null;

    $leftImg = '';
    if (!empty($listing_element_left_img)) {
        $bgImage = wp_get_attachment_image_src( $listing_element_left_img, 'full' );
        $leftImg = '<img src="'.$bgImage[0].'" alt="">';
    }else{
        $leftImg = '';
    }

    $output .='
	<div class="promotional-element">
		<div class="promotional-row">
			<div class="promotiona-col-left">
				'.$leftImg.'
			</div>
			<div class="promotiona-col-right">
				<h3>'.$listing_element_title.'</h3>
				<p>'.$element_desc.'</p>
				<a href="'.$element_link_url.'" class="lp-sent-btn">'.$element_link_title.'</a>
				<p class="phone_content">'.$element_phone_number.'</p>
			</div>
		</div>
	</div>';

    return $output;
}
add_shortcode('listingpro_promotional', 'Listingpro_shortcode_promotion');


/*------------------------------------------------------*/
/* Promotional Element Services
/*------------------------------------------------------*/

vc_map( array(
    "name"                      => esc_html__("Listingpro Promotional Services", "js_composer"),
    "base"                      => 'listingpro_pro_services',
    "category"                  => esc_html__('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => esc_html__("Banner Left Image","js_composer"),
            "param_name"  => "listing_pro_services_img",
            "value"       => get_template_directory_uri()."/assets/images/servcs1.png",
            "description" => ""
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Element Title","js_composer"),
            "param_name"	=> "listing_pro_services_title",
            "value"			=> ""
        ),
        array(
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Element Description', 'js_composer' ),
            'param_name'  => 'pro_services_desc',
            'value'       => ''
        ),
    ),
) );
function listingpro_shortcode_pro_services($atts, $content = null) {
    extract(shortcode_atts(array(
        'listing_pro_services_img'      => get_template_directory_uri()."/assets/images/servcs1.png",
        'listing_pro_services_title'         => '',
        'pro_services_desc' 					=> '',
    ), $atts));

    $output = null;

    $thumbImg = '';
    if (!empty($listing_pro_services_img)) {
        $bgImage = wp_get_attachment_image_src( $listing_pro_services_img, 'full' );
        $thumbImg = '<img src="'.$bgImage[0].'" alt="">';
    }else{
        $thumbImg = '';
    }

    $output .='
	<div class="promotional-service">
		<div class="promotiona-thumb">
			'.$thumbImg.'
		</div>
		<div class="promotiona-text-details">
			<h3>'.$listing_pro_services_title.'</h3>
			<p>'.$pro_services_desc.'</p>
		</div>
	</div>';

    return $output;
}
add_shortcode('listingpro_pro_services', 'Listingpro_shortcode_pro_services');


/*------------------------------------------------------*/
/* Promotional Element Timeline
/*------------------------------------------------------*/

vc_map( array(
    "name"                      => esc_html__("Listingpro Promotional Timeline", "js_composer"),
    "base"                      => 'listingpro_pro_timeline',
    "category"                  => esc_html__('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Timeline Title","js_composer"),
            "param_name"	=> "listing_pro_timeline_title",
            "value"			=> ""
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Timeline Short Description","js_composer"),
            "param_name"	=> "pro_timeline_short_desc",
            "value"			=> ""
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Timeline First Title","js_composer"),
            "param_name"	=> "pro_timeline_title_first",
            "value"			=> ""
        ),
        array(
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Timeline First Description', 'js_composer' ),
            'param_name'  => 'pro_timeline_desc_first',
            'value'       => ''
        ),
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => esc_html__("Timeline Right Image","js_composer"),
            "param_name"  => "pro_timeline_first_img",
            "value"       => get_template_directory_uri()."/assets/images/time1.png",
            "description" => ""
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Timeline Second Title","js_composer"),
            "param_name"	=> "pro_timeline_title_second",
            "value"			=> ""
        ),
        array(
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Timeline Second Description', 'js_composer' ),
            'param_name'  => 'pro_timeline_desc_second',
            'value'       => ''
        ),
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => esc_html__("Timeline Left Image","js_composer"),
            "param_name"  => "pro_timeline_second_img",
            "value"       => get_template_directory_uri()."/assets/images/time2.png",
            "description" => ""
        ),
    ),
) );
function listingpro_shortcode_pro_timeline($atts, $content = null) {
    extract(shortcode_atts(array(
        'listing_pro_timeline_title'      => '',
        'pro_timeline_short_desc'         => '',
        'pro_timeline_title_first' 		  => '',
        'pro_timeline_desc_first' 		  => '',
        'pro_timeline_first_img' 		  => get_template_directory_uri()."/assets/images/time1.png",
        'pro_timeline_title_second' 		  => '',
        'pro_timeline_desc_second' 		  => '',
        'pro_timeline_second_img' 		  => get_template_directory_uri()."/assets/images/time2.png",
    ), $atts));

    $output = null;

    $timelilneImg1 = '';
    if (!empty($pro_timeline_first_img)) {
        $bgImage = wp_get_attachment_image_src( $pro_timeline_first_img, 'full' );
        $timelilneImg1 = '<img src="'.$bgImage[0].'" alt="">';
    }else{
        $timelilneImg1 = '';
    }

    $timelilneImg2 = '';
    if (!empty($pro_timeline_second_img)) {
        $bgImage = wp_get_attachment_image_src( $pro_timeline_second_img, 'full' );
        $timelilneImg2 = '<img src="'.$bgImage[0].'" alt="">';
    }else{
        $timelilneImg2 = '';
    }

    $output .='
	<div class="promotional-timeline">
		<div class="top-desc">
			<h2>'.$listing_pro_timeline_title.'</h2>
			<p>'.$pro_timeline_short_desc.'</p>
		</div>
		<div class="timeline-section">
			<div class="promotional-text-details">
				<h3>'.$pro_timeline_title_second.'</h3>
				<p>'.$pro_timeline_desc_second.'</p>
			</div>
			<div class="promotional-thumb">
				'.$timelilneImg1.'
			</div>
		</div>
		<div class="timeline-section">
			<div class="promotional-thumb">
				'.$timelilneImg2.'
			</div>
			<div class="promotional-text-details">
				<h3>'.$pro_timeline_title_first.'</h3>
				<p>'.$pro_timeline_desc_first.'</p>
			</div>
		</div>
	</div>';

    return $output;
}
add_shortcode('listingpro_pro_timeline', 'Listingpro_shortcode_pro_timeline');


/*------------------------------------------------------*/
/* Promotional Element Presentaion
/*------------------------------------------------------*/

vc_map( array(
    "name"                      => esc_html__("Listingpro Promotional Presentaion", "js_composer"),
    "base"                      => 'listingpro_pro_presentation',
    "category"                  => esc_html__('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Presentaion Title","js_composer"),
            "param_name"	=> "presentation_title",
            "value"			=> ""
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Presentaion Short Description","js_composer"),
            "param_name"	=> "presentation_short_desc",
            "value"			=> ""
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Presentaion First Title","js_composer"),
            "param_name"	=> "presentation_title_first",
            "value"			=> ""
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Presentaion First Designation', 'js_composer' ),
            'param_name'  => 'presentation_designation_first',
            'value'       => ''
        ),
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => esc_html__("Presentaion First Image","js_composer"),
            "param_name"  => "presentation_first_img",
            "value"       => get_template_directory_uri()."/assets/images/presentation.png",
            "description" => ""
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Presentaion Second Title","js_composer"),
            "param_name"	=> "presentation_title_second",
            "value"			=> ""
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Presentaion Second Designation', 'js_composer' ),
            'param_name'  => 'presentation_designation_second',
            'value'       => ''
        ),
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => esc_html__("Presentaion Left Image","js_composer"),
            "param_name"  => "presentation_second_img",
            "value"       => get_template_directory_uri()."/assets/images/presentation2.png",
            "description" => ""
        ),
    ),
) );
function listingpro_shortcode_presentation($atts, $content = null) {
    extract(shortcode_atts(array(
        'presentation_title'      				=> '',
        'presentation_short_desc'         		=> '',
        'presentation_title_first' 		  		=> '',
        'presentation_designation_first' 		=> '',
        'presentation_first_img' 		  		=> get_template_directory_uri()."/assets/images/presentation.png",
        'presentation_title_second' 		  	=> '',
        'presentation_designation_second' 		=> '',
        'presentation_second_img' 		  		=> get_template_directory_uri()."/assets/images/presentation2.png",
    ), $atts));

    $output = null;

    $presentationImg1 = '';
    if (!empty($presentation_first_img)) {
        $bgImage = wp_get_attachment_image_src( $presentation_first_img, 'full' );
        $presentationImg1 = '<img src="'.$bgImage[0].'" alt="">';
    }else{
        $presentationImg1 = '';
    }

    $presentationImg2 = '';
    if (!empty($presentation_second_img)) {
        $bgImage = wp_get_attachment_image_src( $presentation_second_img, 'full' );
        $presentationImg2 = '<img src="'.$bgImage[0].'" alt="">';
    }else{
        $presentationImg2 = '';
    }

    $output .='
	<div class="promotional-presentation">
		<div class="top-desc">
			<h2>'.$presentation_title.'</h2>
			<p>'.$presentation_short_desc.'</p>
		</div>
		<div class="presentation-section">
			<div class="presentation-text-details">
				<h3>'.$presentation_title_first.'</h3>
				<p>'.$presentation_designation_first.'</p>
			</div>
			<div class="presentation-thumb">
				'.$presentationImg1.'
			</div>
		</div>
		<div class="presentation-section">
			<div class="presentation-text-details">
				<h3>'.$presentation_title_second.'</h3>
				<p>'.$presentation_designation_second.'</p>
			</div>
			<div class="presentation-thumb">
				'.$presentationImg2.'
			</div>
		</div>
	</div>';

    return $output;
}
add_shortcode('listingpro_pro_presentation', 'listingpro_shortcode_presentation');


/*------------------------------------------------------*/
/* Promotional Element Support
/*------------------------------------------------------*/

vc_map( array(
    "name"                      => esc_html__("Listingpro Promotional Support", "js_composer"),
    "base"                      => 'listingpro_pro_support',
    "category"                  => esc_html__('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => esc_html__("Support Background Image","js_composer"),
            "param_name"  => "support_bg_img",
            "value"       => get_template_directory_uri()."/assets/images/support.jpg",
            "description" => ""
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Title","js_composer"),
            "param_name"	=> "support_title",
            "value"			=> "John Doe"
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Designation","js_composer"),
            "param_name"	=> "support_designation",
            "value"			=> "John Doe, CEO Abc Organisation"
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Description","js_composer"),
            "param_name"	=> "support_short_desc",
            "value"			=> "Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua  eiusmod tempor incididunt ut labore et dolore magna aliqua."
        ),
    ),
) );
function listingpro_shortcode_support($atts, $content = null) {
    extract(shortcode_atts(array(
        'support_bg_img'      	=> get_template_directory_uri()."/assets/images/support.jpg",
        'support_title'         => 'John Doe',
        'support_designation' 	=> 'John Doe, CEO Abc Organisation',
        'support_short_desc' 	=> 'Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua  eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    ), $atts));

    $output = null;

    $supportImg = '';
    if (!empty($support_bg_img)) {
        $bgImage = wp_get_attachment_image_src( $support_bg_img, 'full' );
        $supportImg = 'style="background-image: url('.$bgImage[0].');"';
    }else{
        $supportImg = '';
    }

    $output .='
	<div class="promotional-support" '.$supportImg.'>
		<div class="support-section">
			<div class="support-text-details">
				<div class="testi-detail">
					<p>'. $support_short_desc .'</p>
				</div>
				<h3>'.$support_title.'</h3>
				<p>'.$support_designation.'</p>
			</div>
		</div>
	</div>';

    return $output;
}
add_shortcode('listingpro_pro_support', 'listingpro_shortcode_support');


/*------------------------------------------------------*/
/* Promotional Element Call to Action
/*------------------------------------------------------*/

vc_map( array(
    "name"                      => esc_html__("Listingpro Call to Action", "js_composer"),
    "base"                      => 'listingpro_calltoaction',
    "category"                  => esc_html__('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => __("Select Listingpro Call to Action Style","js_composer"),
            "param_name"  => "listingpro_calltoaction_style",
            'value' => array(
                __( 'Call to Action with Button ', 'js_composer' ) => 'style1',
                __( 'Call to Action Style 3', 'js_composer' ) => 'style3',
                __( 'Call to Action without Button ', 'js_composer' ) => 'style2',

            ),
            'save_always' => true,
            "description" => "Select Call Out Style"
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Call to Action Title","js_composer"),
            "param_name"	=> "calltoaction_title",
            'dependency'  => array(
                'element' => 'listingpro_calltoaction_style',
                'value'   => array( 'style1', 'style2' )
            ),
            "value"			=> "Reach customers with confidence."
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Short Description","js_composer"),
            "param_name"	=> "calltoaction_desc",
            'dependency'  => array(
                'element' => 'listingpro_calltoaction_style',
                'value'   => array( 'style1', 'style2' )
            ),
            "value"			=> "Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore"
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Line 1","js_composer"),
            "param_name"	=> "style3_line1",
            "value"			=> "daily news &amp; tips",
            'dependency'  => array(
                'element' => 'listingpro_calltoaction_style',
                'value'   => 'style3'
            ),
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Line 2","js_composer"),
            "param_name"	=> "style3_line2",
            "value"			=> "Read Stories",
            'dependency'  => array(
                'element' => 'listingpro_calltoaction_style',
                'value'   => 'style3'
            ),
        ),
        array(
            "type"        => "attach_images",
            "class"       => "",
            "heading"     => __("Background Image","js_composer"),
            "param_name"  => "style3_line2_bg",
            "value"       => "",
            'dependency'  => array(
                'element' => 'listingpro_calltoaction_style',
                'value'   => array( 'style3' )
            ),

        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Button Text","js_composer"),
            "param_name"	=> "calltoaction_button",
            "value"			=> "Let's Promote Now",
            'dependency'  => array(
                'element' => 'listingpro_calltoaction_style',
                'value'   => array( 'style1', 'style3' )
            ),
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Button Link","js_composer"),
            "param_name"	=> "calltoaction_button_link",
            "value"			=> "#",
            'dependency'  => array(
                'element' => 'listingpro_calltoaction_style',
                'value'   => array( 'style1', 'style3' )
            ),
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Phone Number","js_composer"),
            "param_name"	=> "calltoaction_phone",
            "value"			=> "or, Call 1800-ListingPro",
            'dependency'  => array(
                'element' => 'listingpro_calltoaction_style',
                'value'   => 'style1'
            ),
        ),
    ),
) );

function listingpro_shortcode_calltoaction($atts, $content = null) {
    extract(shortcode_atts(array(

        'listingpro_calltoaction_style'      	=> 'style1',
        'calltoaction_title'      	=> "Reach customers with confidence.",
        'calltoaction_desc'         => "Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore",
        'calltoaction_button' 		=> "Let's Promote Now",
        'calltoaction_button_link' 	=> "#",
        'calltoaction_phone' 		=> "or, Call 1800-ListingPro",
        'style3_line1' 		=> "daily news &amp; tips",
        'style3_line2' 		=> "Read Stories",
        'style3_line2_bg' => ''
    ), $atts));

    $output = null;
    if( $listingpro_calltoaction_style == 'style3' )
    {
        if( !empty( $style3_line2_bg ) )
        {
            $style3_line2_bg    =   wp_get_attachment_url( $style3_line2_bg );
        }
        $output .=  '<div class="lp-read-news-overlay"></div>';
        $output .=  '<div class="lp-read-news">';
        if( !empty( $style3_line1 ) )   $output .=  '<p>'. $style3_line1 .'</p>';
        if( !empty( $style3_line2 ) )   $output .=  '<p class="large-size">'. $style3_line2 .'</p>';
        if( !empty( $calltoaction_button ) ) $output .=  '<a href="'. $calltoaction_button_link .'">'. $calltoaction_button .'</a>';
        $output .=  '</div>';
    }
    else if($listingpro_calltoaction_style == 'style1'){
        $output .='
	
	<div class="call-to-action">
		<div class="calltoaction-left-panel">
			<h3>'. $calltoaction_title .'</h3>
			<p>'.$calltoaction_desc.'</p>
		</div>
		<div class="calltoaction-right-panel">
			<a href="'.$calltoaction_button_link.'">'.$calltoaction_button.'</a>
			<p>'.$calltoaction_phone.'</p>
		</div>
	</div>';
    }else{
        $output .='
	
		<div class="call-to-action2 text-center">
			<div class="calltoaction-left-panel2">
				<h3>'. $calltoaction_title .'</h3>
				<h1>'.$calltoaction_desc.'</h1>
				<img src="'.get_template_directory_uri().'/assets/images/banner-arrow.png" alt="banner-arrow" class="banner-arrow">
			</div>
			
		</div>';

    }
    return $output;
}
add_shortcode('listingpro_calltoaction', 'listingpro_shortcode_calltoaction');


/*------------------------------------------------------*/
/* Promotional Element Thank you
/*------------------------------------------------------*/
$args = array(
    'sort_order' => 'asc',
    'sort_column' => 'post_title',
    'post_type' => 'page',
    'post_status' => 'publish'
);
$pages = get_pages( $args );

$thnxPage = array();
foreach($pages as $p) {
    $thnxPage[$p->post_title] = $p->ID;
}

vc_map( array(
    "name"                      => esc_html__("Listingpro Notification", "js_composer"),
    "base"                      => 'listingpro_thankyou',
    "category"                  => esc_html__('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => esc_html__("Notification Image","js_composer"),
            "param_name"  => "thankyou_img",
            "value"       => get_template_directory_uri()."/assets/images/thankyou.jpg",
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Notification Title","js_composer"),
            "param_name"	=> "thankyou_title",
            "value"			=> ""
        ),
        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => esc_html__("Select Notice","js_composer"),
            "param_name"  => "listingpro_notice",
            'value' => array(
                esc_html__( 'Success', 'js_composer' ) => 'success',
                esc_html__( 'Failed', 'js_composer' ) => 'failed',
            ),
            'save_always' => true,
            "description" => "Select notice that you want to show"
        ),
        array(
            "type"			=> "textarea",
            "class"			=> "",
            "heading"		=> esc_html__("Success Description","js_composer"),
            "param_name"	=> "success_text",
            'dependency' => array(
                'element' => 'listingpro_notice',
                'value' => 'success'
            ),
            "value"			=> esc_html__( 'An email receipt with detials about your order has been sent to email address provided.please keep it for your record', 'js_composer' ),
        ),
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => esc_html__("Icon with description","js_composer"),
            "param_name"  => "success_txt_img",
            'dependency' => array(
                'element' => 'listingpro_notice',
                'value' => 'success'
            ),
            "value"       => get_template_directory_uri()."/assets/images/email.jpg",
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Notification Description","js_composer"),
            "param_name"	=> "thankyou_desc",
            "value"			=> ""
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Redirect to Page', 'js_composer' ),
            'param_name'  => 'thankyou_goto_page',
            'description' => esc_html__( '', 'js_composer' ),
            'default'	  => 'default',
            'value'       => $thnxPage
        ),
    ),
) );

function listingpro_shortcode_thankyou($atts, $content = null) {
    extract(shortcode_atts(array(
        'thankyou_img'      	=> get_template_directory_uri()."/assets/images/thankyou.jpg",
        'thankyou_title' 		=> '',
        'listingpro_notice' 	=> '',
        'success_text' 			=> esc_html__( 'An email receipt with detials about your order has been sent to email address provided.please keep it for your record', 'js_composer' ),
        'success_txt_img' 		=> get_template_directory_uri()."/assets/images/email.jpg",
        'thankyou_desc' 		=> '',
        'thankyou_goto_page' 	=> '',
    ), $atts));

    $output = null;

    $thnkImg = '';
    if (!empty($thankyou_img)) {
        $bgImage = wp_get_attachment_image_src( $thankyou_img, 'full' );
        $thnkImg = '<img src="'.$bgImage[0].'" alt="">';
    }else{
        $thnkImg = '';
    }

    $thnkIcon = '';
    if (!empty($success_txt_img)) {
        $bgImage = wp_get_attachment_image_src( $success_txt_img, 'full' );
        $thnkIcon = '<img src="'.$bgImage[0].'" alt="">';
    }else{
        $thnkIcon = '';
    }

    $output .='
	<div class="thankyou-page">
		<div class="thankyou-icon">
			'. $thnkImg .'
		</div>
		<div class="thankyou-panel">
			<h3>'.$thankyou_title.'</h3>';
    if($listingpro_notice == 'success') {
        $output .='
				<div class="success-txt">';
        if(!empty($thnkIcon)) {
            $output .='
						<span>'.$thnkIcon.'</span>';
        }
        $output .='
					<p>'.$success_text.'</p>
				</div>';
    }
    $output .='
			<p>'.$thankyou_desc.'</p>
			<ul>
				<li>
					<a href="'.get_the_permalink($thankyou_goto_page).'">'.get_the_title( $thankyou_goto_page ).'</a>
				</li>
				<li>
					<a href="'.esc_url(home_url('/')).'">'.esc_html__('Home', 'listingpro-plugin').'</a>
				</li>
			</ul>
		</div>
	</div>';

    return $output;
}
add_shortcode('listingpro_thankyou', 'listingpro_shortcode_thankyou');


/*------------------------------------------------------*/
/* Listings
/*------------------------------------------------------*/

vc_map( array(
    "name"                      => __("Listing Entries", "js_composer"),
    "base"                      => 'listing_entries',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => esc_html__("Posts per page","js_composer"),
            "param_name"  => "number_posts",
            'value' => array(
                esc_html__( '3 Posts', 'js_composer' ) => '3',
                esc_html__( '6 Posts', 'js_composer' ) => '6',
                esc_html__( '9 Posts', 'js_composer' ) => '9',
                esc_html__( '12 Posts', 'js_composer' ) => '12',
                esc_html__( '15 Posts', 'js_composer' ) => '15',
            ),
            'save_always' => true,
            "description" => "Select number of posts you want to show"
        ),
    ),
) );
function listingpro_shortcode_listing_entries($atts, $content = null) {
    extract(shortcode_atts(array(
        'number_posts'   => '3'
    ), $atts));

    $output = null;
    $type = 'listing';
    $args=array(
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => $number_posts,
    );

    $listingcurrency = '';
    $listingprice = '';
    $listing_query = null;
    $listing_query = new WP_Query($args);

    $post_count =1;
    $output.='
	<div class="listing-second-view paid-listing lp-section-content-container lp-list-page-grid">
		<div class="listing-post">
			<div class="row">';
    if( $listing_query->have_posts() ) {
        while ($listing_query->have_posts()) : $listing_query->the_post();
            $phone = listing_get_metabox('phone');
            $website = listing_get_metabox('website');
            $email = listing_get_metabox('email');
            $latitude = listing_get_metabox('latitude');
            $longitude = listing_get_metabox('longitude');
            $gAddress = listing_get_metabox('gAddress');
            $priceRange = listing_get_metabox('price_status');
            $listingpTo = listing_get_metabox('list_price_to');
            $listingprice = listing_get_metabox('list_price');
            $isfavouriteicon = listingpro_is_favourite_grids(get_the_ID(),$onlyicon=true);
            $isfavouritetext = listingpro_is_favourite_grids(get_the_ID(),$onlyicon=false);
            $claimed_section = listing_get_metabox('claimed_section');
            $rating = get_post_meta( get_the_ID(), 'listing_rate', true );
            $rate = $rating;

            $output .= '
						<div class="col-md-4 col-sm-4 col-xs-12">
							<article>
								<figure>';
            if ( has_post_thumbnail()) {
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'listingpro-blog-grid' );
                if(!empty($image[0])){
                    $output.='
												<a href="'.get_the_permalink().'" >
													<img src="'. $image[0] .'" />
												</a>';
                }else{
                    $output.='
												<a href="'.get_the_permalink().'" >
													<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240', 'listingpro-plugin').'" alt="">
												</a>';
                }
            }else {
                $output.='
										<a href="'.get_the_permalink().'" >
											<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240', 'listingpro-plugin').'" alt="">
										</a>';
            }
            $output.='
									<figcaption>';
            if(!empty($listingprice)){
                $output .='
											<div class="listing-price">';
                $output .= esc_html($listingprice);
                if(!empty($listingpTo)){
                    $output .= ' - ';
                    $output .= esc_html($listingpTo);
                }
                $output.='
											</div>';
            }
            $output.='
										<div class="bottom-area">
											<div class="listing-cats">';
            $cats = get_the_terms( get_the_ID(), 'listing-category' );
            if(!empty($cats)){
                foreach ( $cats as $cat ) {
                    $term_link = get_term_link( $cat );
                    $output.='
														<a href="'.$term_link.'">
															'.$cat->name.'
														</a>';
                }
            }
            $output.='
											</div>';
            if(!empty($rate)) {
                $output .='
												<span class="rate">'.$rate.'<sup>/5</sup></span>';
            }
            $output .= '
											<h4>
												<a href="'.get_the_permalink().'">
													'.substr(get_the_title(), 0, 40).'
												</a>
											</h4>';
            if(!empty($gAddress)) {
                $output .= '
												<div class="listing-location">
													<p>'.$gAddress.'</p>
												</div>';
            }
            $output .= '
										</div>
									</figcaption>
								</figure>
							</article>
						</div>';
            if($post_count==3){
                $output .='<div class="clearfix"></div>';
                $post_count=1;
            }
            else{
                $post_count++;
            }
        endwhile;
    }
    $output .='
			</div>
		</div>
	</div>';

    return $output;
}
add_shortcode('listing_entries', 'listingpro_shortcode_listing_entries');


// End Harry Elements ====================================================================================== //
/*------------------------------------------------------*/
/* CLIENT TESTIMONIALS
/*------------------------------------------------------*/
vc_map( array(
    "name"                      => __("Client Testimonial", "js_composer"),
    "base"                      => 'listingpro_testimonial',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(

            'type'        => 'dropdown',
            'heading'     => __( 'Testimonial Style', 'js_composer' ),
            'param_name'  => 'style',
            'description' => __( 'Choose your testimonial style', 'js_composer' ),
            'default'	  => 'default',
            'value'       => array(
                __("Default, on a white background color", "js_composer") => "default",
                __("Inverted, on a dark background color", "js_composer") => "inverted"
            )
        ),
        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> __("Client Name","js_composer"),
            "param_name"	=> "name",
            "value"			=> ""
        ),
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => __("Client Avatar","js_composer"),
            "param_name"  => "avatar",
            "value"       => "",
            "description" => "Client image, the size should be smaller than 200 x 200px"
        ),
        array(
            'type'        => 'textarea',
            'heading'     => __( 'Testimonial Content', 'js_composer' ),
            'param_name'  => 'testimonial_content',
            'value'       => ''
        ),
        array(

            'type'        => 'textfield',
            'heading'     => __( 'Designation', 'js_composer' ),
            'param_name'  => 'designation',
            'description' => __( 'Add designation', 'js_composer' ),
            'default'	  => 'Manager',
            'value'       => '',
        ),
    ),
) );
function listingpro_shortcode_testimonial($atts, $content = null) {
    extract(shortcode_atts(array(
        'style'               => '',
        'name'                => '',
        'avatar'              => '',
        'testimonial_content' => '',
        'designation' 		  => '',
    ), $atts));

    $output = null;
    $style_class = null;

    if ( $style == 'inverted' ) $style_class = ' inverted';

    $output .= '
	<div class="testimonial-box testimonial'. $style_class .'">';
    $output .= '<div class="testimonial-image">
									<img alt="" src="'. wp_get_attachment_url($avatar) .'">
				</div>';
    $output .= '<div class="testimonial-msg triangle-isosceles top">
									<div class="testimonial-tit"> 
										<h3>'. esc_attr($name) .'</h3>
										<div class="testimonial-rating">';
    $output .= esc_attr($designation);


    $output .= '						</div>
									</div>
									<div class="testimonial-des">';

    if ( $testimonial_content ) {
        $output .= '
																	<p>'. wp_kses_post($testimonial_content) .'</p>';
    }
    $output .= '					</div>
					</div>';



    $output .= '</div>';


    return $output;
}
add_shortcode('listingpro_testimonial', 'Listingpro_shortcode_testimonial');

/*------------------------------------------------------*/
/* Locations
/*------------------------------------------------------*/
$categories = get_terms('location', array('hide_empty' => false));
$locations = array();
foreach($categories as $category) {
    $locations[$category->name] = $category->term_id;
}



vc_map( array(
    "name"                      => __("Locations", "js_composer"),
    "base"                      => 'locations',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(

        array(
            'type'        => 'dropdown',
            'heading'     => __( 'Category Styles', 'js_composer' ),
            'param_name'  => 'locstyles',
            'description' => __( 'Choose your Listing style', 'js_composer' ),
            'value'       => array(
                __("Abstracted View", "js_composer") => "loc_abstracted",
                __("Boxed View", "js_composer") => "loc_boxed",
                __("Boxed View 2", "js_composer") => "loc_boxed_2",
                __("Grid View", "js_composer") => "grid_abstracted"
            ),
            'save_always' => true,

        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Select location', 'js_composer' ),
            'param_name' => 'location_ids',
            'description' => __( 'Check the checkbox' ),
            'value' => $loc
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => __( 'Order', 'js_composer' ),
            'param_name'  => 'location_order',
            'description' => __( 'Order of locations', 'js_composer' ),
            'default'	  => 'default',
            'value'       => array(
                __("ASC", "js_composer") => "ASC",
                __("DESC", "js_composer") => "DESC"
            ),
            'save_always' => true,
        ),

    ),
) );
function listingpro_shortcode_locations($atts, $content = null) {
    extract(shortcode_atts(array(
        'location_ids'   => '',
        'location_order'   => 'ASC',
        'locstyles'    => 'loc_abstracted',
    ), $atts));
    require_once (THEME_PATH . "/include/aq_resizer.php");
    $output = null;
    global $listingpro_options;
    $listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
    if ($locstyles == 'loc_boxed_2') {
        $Locations = $location_ids;
        $ucat = array(
            'post_type' => 'listing',
            'hide_empty' => false,
            'order' => $location_order,
            'include' => $Locations
        );
        $allLocations = get_terms('location', $ucat);

        $output .= '<div class="lp-section-content-container"> <div class="lp-locations">';
        $output .= '   <div class="lp-locations-slider"> ';
        foreach ($allLocations as $location) {
            $location_image = listing_get_tax_meta($location->term_id, 'location', 'image');
            $childcount = 0;
            $loc_term_children_array = array();
            $loc_term_children = get_term_children($location->term_id, 'location');
            foreach ($loc_term_children as $childtermid) {
                $child = get_term_by('id', $childtermid, 'location');
                $childcount = $childcount + $child->count;
            }
            $totalListinginLoc = $location->count + $childcount;
            $imgurl = aq_resize($location_image, '185', '175', true, true, true);
            if (empty($imgurl)) {
                $imgurl = 'https://placeholdit.imgix.net/~text?txtsize=33&w=185&h=175';
            }
            $output .= '<div class="col-md-2 col-xs-6">
                        <div class="lp-location-box">
                            <div class="lp-location-thumb">
                                <a href="' . esc_url(get_term_link($location->term_id, 'location')) . '"><img src="' . $imgurl . '" alt="' . esc_attr($location->name) . '"></a>
                            </div>
                            <div class="lp-location-bottom">
                                <a href="' . esc_url(get_term_link($location->term_id, 'location')) . '"><span class="lp-cat-name">' . esc_attr($location->name) . '</span> <span class="lp-cat-list-count">' . esc_attr($totalListinginLoc) . ' ' . esc_html__('Listings', 'listingpro-plugin') . '</span></a>
                            </div>
                        </div>
                    </div>';
        }

        $output .= '   <div class="clearfix"></div> </div>';
        $output .= '</div></div>';
    } else {
        if($listing_mobile_view == 'app_view' && wp_is_mobile() ){
            $output .= '<div class="lp-section-content-container lp-location-slider clearfix">';

            $Locations = $location_ids;
            $ucat = array(
                'post_type' => 'listing',
                'hide_empty' => false,
                'order' => $location_order,
                'include'=> $Locations
            );
            $allLocations = get_terms( 'location',$ucat);


            foreach($allLocations as $location) {
                $location_image = listing_get_tax_meta($location->term_id,'location','image');

                $totalListinginLoc = lp_count_postcount_taxonomy_term_byID('listing','location', $location->term_id);

                $gridStyle = 'col-md-3 col-sm-3 col-xs-12 cities-app-view';

                $location_image_id = listing_get_tax_meta($location->term_id,'location','image_id');
                $image_alt = "";
                if( !empty($location_image_id) ){
                    $thumbnail_url = wp_get_attachment_image_src($location_image_id, 'listingpro_location270_400', true );
                    $image_alt = get_post_meta($location_image_id, '_wp_attachment_image_alt', true);
                    $imgurl = $thumbnail_url[0];
                }
                else{
                    $imgurl = aq_resize( $location_image, '270', '400', true, true, true);
                    if(empty($imgurl) ){
                        $imgurl = 'https://placeholdit.imgix.net/~text?txtsize=33&w=270&h=400';
                    }
                }



                $output .= '<div class="'.$gridStyle.'">
										<div class="city-girds lp-border-radius-8 location-girds4">
											<div class="city-thumb">
												<img src="'. $imgurl.'" alt="'.$image_alt.'" />
											</div>
											<div class="city-title text-center">
												<h3 class="lp-h3">
													<a href="'.esc_url( get_term_link( $location->term_id , 'location')).'">'.esc_attr($location->name).'</a>
												</h3>
												<label class="lp-listing-quantity">'.esc_attr($totalListinginLoc).' '.esc_html__('Listings', 'listingpro-plugin').'</label>
											</div>
											<a href="'.esc_url( get_term_link( $location )).'" class="overlay-link"></a>
										</div>
									</div>';
            }


            $output .= '</div>';

        }else{
            if($locstyles == "loc_abstracted") {
                $output .= '<div class="lp-section-content-container row">';

                $Locations = $location_ids;
                $ucat = array(
                    'post_type' => 'listing',
                    'hide_empty' => false,
                    'order' => $location_order,
                    'include'=> $Locations
                );
                $allLocations = get_terms( 'location',$ucat);

                $grid = 0;


                foreach($allLocations as $location) {
                    $location_image = listing_get_tax_meta($location->term_id,'location','image');

                    $totalListinginLoc = lp_count_postcount_taxonomy_term_byID('listing','location', $location->term_id);

                    if($grid == 0){
                        $gridStyle = 'col-md-6 col-sm-6  col-xs-12 cities-app-view';

                        $image_alt = "";
                        $location_image_id = listing_get_tax_meta($location->term_id,'location','image_id');
                        if( !empty($location_image_id) ){
                            $thumbnail_url = wp_get_attachment_image_src($location_image_id, 'listingpro_location570_455', true );
                            $image_alt = get_post_meta($location_image_id, '_wp_attachment_image_alt', true);
                            $imgurl = $thumbnail_url[0];
                        }
                        else{
                            $imgurl = aq_resize( $location_image, '570', '455', true, true, true);
                            if(empty($imgurl) ){
                                $imgurl = 'https://placeholdit.imgix.net/~text?txtsize=33&w=570&h=455';
                            }
                        }

                    }elseif($grid == 1){
                        $gridStyle = 'col-md-6 col-sm-6  col-xs-12 cities-app-view';

                        $image_alt = "";
                        $location_image_id = listing_get_tax_meta($location->term_id,'location','image_id');
                        if( !empty($location_image_id) ){
                            $thumbnail_url = wp_get_attachment_image_src($location_image_id, 'listingpro_location570_228', true );
                            $image_alt = get_post_meta($location_image_id, '_wp_attachment_image_alt', true);
                            $imgurl = $thumbnail_url[0];
                        }
                        else{
                            $imgurl = aq_resize( $location_image, '570', '228', true, true, true);
                            if(empty($imgurl) ){
                                $imgurl = 'https://placeholdit.imgix.net/~text?txtsize=33&w=570&h=228';
                            }
                        }

                    }else{
                        $gridStyle = 'col-md-3 col-sm-3 col-xs-12 cities-app-view';

                        $image_alt = "";
                        $location_image_id = listing_get_tax_meta($location->term_id,'location','image_id');
                        if( !empty($location_image_id) ){
                            $thumbnail_url = wp_get_attachment_image_src($location_image_id, 'listingpro_location270_197', true );
                            $image_alt = get_post_meta($location_image_id, '_wp_attachment_image_alt', true);
                            $imgurl = $thumbnail_url[0];
                        }
                        else{
                            $imgurl = aq_resize( $location_image, '270', '197', true, true, true);
                            if(empty($imgurl) ){
                                $imgurl = 'https://placeholdit.imgix.net/~text?txtsize=33&w=270&h=197';
                            }
                        }

                    }


                    $output .= '<div class="'.$gridStyle.'">
										<div class="city-girds lp-border-radius-8">
											<div class="city-thumb">
												<img src="'. $imgurl.'" alt="'.$image_alt.'" />
											</div>
											<div class="city-title text-center">
												<h3 class="lp-h3">
													<a href="'.esc_url( get_term_link( $location->term_id , 'location')).'">'.esc_attr($location->name).'</a>
												</h3>
												<label class="lp-listing-quantity">'.esc_attr($totalListinginLoc).' '.esc_html__('Listings', 'listingpro-plugin').'</label>
											</div>
											<a href="'.esc_url( get_term_link( $location )).'" class="overlay-link"></a>
										</div>
									</div>';
                    $grid++;
                }


                $output .= '</div>';
            }
            elseif($locstyles == "loc_boxed"){
                $output .= '<div class="lp-section-content-container row">';

                $Locations = $location_ids;
                $ucat = array(
                    'post_type' => 'listing',
                    'hide_empty' => false,
                    'order' => $location_order,
                    'include'=> $Locations,
                );
                $allLocations = get_terms( 'location',$ucat);


                foreach($allLocations as $location) {
                    $location_image = listing_get_tax_meta($location->term_id,'location','image');


                    $gridStyle = 'col-md-3 col-sm-3 col-xs-12 cities-app-view';

                    $image_alt = "";
                    $location_image_id = listing_get_tax_meta($location->term_id,'location','image_id');
                    if( !empty($location_image_id) ){
                        $thumbnail_url = wp_get_attachment_image_src($location_image_id, 'listingpro_location270_197', true );
                        $image_alt = get_post_meta($location_image_id, '_wp_attachment_image_alt', true);
                        $imgurl = $thumbnail_url[0];
                    }
                    else{
                        $imgurl = aq_resize( $location_image, '270', '197', true, true, true);
                        if(empty($imgurl) ){
                            $imgurl = 'https://placeholdit.imgix.net/~text?txtsize=33&w=270&h=197';
                        }
                    }

                    $totalListinginLoc = lp_count_postcount_taxonomy_term_byID('listing','location', $location->term_id);
                    $output .= '<div class="'.$gridStyle.'">
										<div class="city-girds lp-border-radius-8">
											<div class="city-thumb">
												<img src="'. $imgurl.'" alt="'.$image_alt.'" />
											</div>
											<div class="city-title text-center">
												<h3 class="lp-h3">
													<a href="'.esc_url( get_term_link( $location->term_id , 'location')).'">'.esc_attr($location->name).'</a>
												</h3>
												<label class="lp-listing-quantity">'.esc_attr($totalListinginLoc).' '.esc_html__('Listings', 'listingpro-plugin').'</label>
											</div>
											<a href="'.esc_url( get_term_link( $location )).'" class="overlay-link"></a>
										</div>
									</div>';
                }


                $output .= '</div>';
            }
            else{
                $output .= '<div class="lp-section-content-container row">';

                $Locations = $location_ids;
                $ucat = array(
                    'post_type' => 'listing',
                    'hide_empty' => false,
                    'order' => $location_order,
                    'include'=> $Locations
                );
                $allLocations = get_terms( 'location',$ucat);


                foreach($allLocations as $location) {
                    $location_image = listing_get_tax_meta($location->term_id,'location','image');
                    $totalListinginLoc = lp_count_postcount_taxonomy_term_byID('listing','location', $location->term_id);

                    $gridStyle = 'col-md-3 col-sm-3 col-xs-12 cities-app-view';

                    $image_alt = "";
                    $location_image_id = listing_get_tax_meta($location->term_id,'location','image_id');
                    if( !empty($location_image_id) ){
                        $thumbnail_url = wp_get_attachment_image_src($location_image_id, 'listingpro_location270_400', true );
                        $image_alt = get_post_meta($location_image_id, '_wp_attachment_image_alt', true);
                        $imgurl = $thumbnail_url[0];
                    }
                    else{
                        $imgurl = aq_resize( $location_image, '270', '400', true, true, true);
                        if(empty($imgurl) ){
                            $imgurl = 'https://placeholdit.imgix.net/~text?txtsize=33&w=270&h=400';
                        }
                    }


                    $output .= '<div class="'.$gridStyle.'">
										<div class="city-girds lp-border-radius-8 location-girds4">
											<div class="city-thumb">
												<img src="'. $imgurl.'" alt="'.$image_alt.'" />
											</div>
											<div class="city-title text-center">
												<h3 class="lp-h3">
													<a href="'.esc_url( get_term_link( $location->term_id , 'location')).'">'.esc_attr($location->name).'</a>
												</h3>
												<label class="lp-listing-quantity">'.esc_attr($totalListinginLoc).' '.esc_html__('Listings', 'listingpro-plugin').'</label>
											</div>
											<a href="'.esc_url( get_term_link( $location )).'" class="overlay-link"></a>
										</div>
									</div>';
                }


                $output .= '</div>';
            }


        }
    }
    return $output;
}
add_shortcode('locations', 'listingpro_shortcode_locations');



/*------------------------------------------------------*/
/* feature box
/*------------------------------------------------------*/
vc_map( array(
    "name"                      => __("Feature Box", "js_composer"),
    "base"                      => 'feature_box',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(

        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => __("Feature Image","js_composer"),
            "param_name"  => "box_style",
            'value' => array(
                __( 'Style 1', 'js_composer' ) => 'style1',
                __( 'Style 2', 'js_composer' ) => 'style2',
            ),
            'save_always' => true,
            "description" => "Put here feature image, Use Perfect size for better output."
        ),
        array(
            "type" => "textfield",
            "heading" => "Title for Description",
            "param_name" => "style_2_title",
            "value" => "",
            "dependency" => array(
                "element" => "box_style",
                "value" => "style2"
            )
        ),

        array(
            "type" => "textfield",
            "heading" => "Sub Title for Description",
            "param_name" => "style_2_stitle",
            "value" => "",
            "dependency" => array(
                "element" => "box_style",
                "value" => "style2"
            )
        ),

        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => __("Feature Image","js_composer"),
            "param_name"  => "feature_image",
            "value"       => "",
            "description" => "Put here feature image, Use Perfect size for better output."
        ),

        array(
            "type"        => "textarea",
            "class"       => "",
            "heading"     => __("Description about this element","js_composer"),
            "param_name"  => "fbox_desc",
            "value"       => "",
            "description" => "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusa ntium dolore mque<br> laud antium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi <br>
											arc hitecto beatae vitae dicta sunt explicabo."
        ),
        array(
            "type"        => "textfield",
            "class"       => "",
            "heading"     => __("Button Link (1)","js_composer"),
            "param_name"  => "botton_link1",
            "value"       => "",
            "description" => ""
        ),

        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => __("Button BG Image (1)","js_composer"),
            "param_name"  => "botton_image1",
            "value"       => "",
            "description" => "Please Use one either color or Bg image "
        ),


        array(
            "type"        => "textfield",
            "class"       => "",
            "heading"     => __("Button Link (2)","js_composer"),
            "param_name"  => "botton_link2",
            "value"       => "",
            "description" => ""
        ),
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => __("Button BG Image (2)","js_composer"),
            "param_name"  => "botton_image2",
            "value"       => "",
            "description" => "Please Use one either color or Bg image "
        ),
    ),
) );
function listingpro_shortcode_feature_box($atts, $content = null) {
    extract(shortcode_atts(array(
        'box_style'   => 'style1',
        'feature_image'   => '',
        'style_2_title'   => '',
        'style_2_stitle'   => '',
        'fbox_desc'   => '',
        'botton_link1'   => '',
        'botton_image1'   => '',
        'botton_link2'   => '',
        'botton_image2'   => '',
    ), $atts));

    $output = null;
    $FimageURL=null;
    $bottonImage1=null;
    $bottonImage2=null;

    if ( $feature_image ) {
        $imgurl = wp_get_attachment_image_src( $feature_image, 'full');
        $FimageURL = '<img src="'. $imgurl[0] .'">';
    }
    if ( $botton_image1 ) {
        $imgurl = wp_get_attachment_image_src( $botton_image1, 'full');
        $bottonImage1 = '<img src="'. $imgurl[0] .'">';
    }
    if ( $botton_image2 ) {
        $imgurl = wp_get_attachment_image_src( $botton_image2, 'full');
        $bottonImage2 = '<img src="'. $imgurl[0] .'">';
    }

    if ( $box_style == 'style1' ) {

        $output .= '<div class="lp-section-content-container row">';
        $output .= '<div class="col-md-12 text-center">
						<div class="nearby-banner">
							'.$FimageURL.'
						</div>
						<div class="nearby-description">
							<p>
								'.$fbox_desc.'

							</p>
						</div>';
        if(!empty($bottonImage1) || !empty($bottonImage2)) {
            $output .= '
							<ul class="nearby-download nearby-download-about nearby-download-top">
								<li>
									<a href="'.$botton_link1.'">
										'.$bottonImage1.'
									</a>
								</li>
								<li>
									<a href="'.$botton_link2.'">
										'.$bottonImage2.'
									</a>
								</li>
							</ul>';
        }
        $output .='
					</div>';
        $output .= '</div>';

    }elseif( $box_style == 'style2' ){

        $output .= '<div class="lp-section-content-container row">';

        $output .= '	<div class="col-md-6">
						<div class="">
							<Div class="lp-about-section-best-header">
								<h3 class="margin-top-0">'.$style_2_title.'</h3>
								<p>'.$style_2_stitle.'</p>
							</div>
							<div class="lp-about-section-best-description margin-top-45 ">
								<p class="paragraph-small">
								'.$fbox_desc.'
								</p>';
        if(!empty($bottonImage1) || !empty($bottonImage2)) {
            $output .= '
									<ul class="nearby-download nearby-download-about nearby-download-top">
										<li>
											<a href="'.$botton_link1.'">
												'.$bottonImage1.'
											</a>
										</li>
										<li>
											<a href="'.$botton_link2.'">
												'.$bottonImage2.'
											</a>
										</li>
									</ul>';
        }
        $output .='
							</div>
						</div><!-- ../section-content-container-->
					</div>
					<div class="col-md-6">
						<div class="">
							'.$FimageURL.'
						</div><!-- ../section-content-container-->
					</div>';
        $output .= '</div>';
    }

    return $output;
}
add_shortcode('feature_box', 'listingpro_shortcode_feature_box');


/*------------------------------------------------------*/
/* Listings with Multi Options
/*------------------------------------------------------*/
$locations = get_terms('location', array('hide_empty' => false));
$loc = array();
foreach($locations as $location) {
    $loc[$location->name] = $location->term_id;
}

$categories = get_terms('listing-category', array('hide_empty' => false));
$cats = array();
foreach($categories as $category) {
    $cats[$category->name] = $category->term_id;
}

vc_map( array(
    "name"                      => __("Listing By", "js_composer"),
    "base"                      => 'listing_options',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => esc_html__("Listing Options","js_composer"),
            "param_name"  => "listing_multi_options",
            'value' => array(
                esc_html__( 'By Category', 'js_composer' ) => 'cat_view',
                esc_html__( 'By Location', 'js_composer' ) => 'location_view',
                esc_html__( 'By Location and Category', 'js_composer' ) => 'location_cat_view',
                esc_html__( 'Recent', 'js_composer' ) => 'recent_view',
            ),
            'save_always' => true,
            "description" => "Select number of posts you want to show"
        ),
        array(
            "type"        	=> "dropdown",
            "class"       	=> "",
            "heading"     	=> esc_html__("Select Location","js_composer"),
            "param_name"  	=> "listing_loc",
            'value' 	  	=> $loc,
            'save_always' 	=> true,
            "dependency" 	=> array(
                "element" 	=> "listing_multi_options",
                "value" 	=> array("location_view", "location_cat_view")
            ),
            "description" => ""
        ),
        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => esc_html__("Select Category","js_composer"),
            "param_name"  => "listing_cat",
            'value' 	  => $cats,
            "dependency" 	=> array(
                "element" 	=> "listing_multi_options",
                "value" 	=> array("cat_view", "location_cat_view")
            ),
            'save_always' => true,
            "description" => ""
        ),
        array(
            "type"        => "textfield",
            "class"       => "",
            "heading"     => __("Listing per page","js_composer"),
            "param_name"  => "listing_per_page",
            "value"       => "",
            "description" => ""
        ),
        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => esc_html__("Listing Layout","js_composer"),
            "param_name"  => "listing_layout",
            'value' => array(
                esc_html__( 'List View', 'js_composer' ) => 'list_view',
                esc_html__( 'Grid View', 'js_composer' ) => 'grid_view',
            ),
            'save_always' => true,
            "description" => "Select lists layout"
        ),
        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => esc_html__("Styles","js_composer"),
            "param_name"  => "listing_grid_style",
            'value' => array(
                esc_html__( 'Grid Style 1', 'js_composer' ) => 'grid_view1',
                esc_html__( 'Grid Style 2', 'js_composer' ) => 'grid_view2',
                esc_html__( 'Grid Style 3', 'js_composer' ) => 'grid_view3',
                esc_html__( 'Grid Style 4', 'js_composer' ) => 'grid_view4',
                esc_html__( 'Grid Style 5', 'js_composer' ) => 'grid_view5',

            ),
            "dependency" => array(
                "element" => "listing_layout",
                "value" => "grid_view"
            ),
            'save_always' => true,
        ),
    ),
) );
function listingpro_shortcode_listing_options($atts, $content = null) {
    extract(shortcode_atts(array(
        'listing_multi_options'   	=> 'cat_view',
        'listing_loc'   			=> '',
        'listing_cat'   			=> '',
        'listing_per_page'   		=> '3',
        'listing_layout'   		=> 'grid_view',
        'listing_grid_style'   => 'grid_view1',
    ), $atts));

    $output = null;
    $type = 'listing';
    if ( $listing_multi_options == 'recent_view' ) {
        $args = array(
            'post_type'       => $type,
            'post_status'     => 'publish',
            'posts_per_page'  => $listing_per_page,
            'order'           => 'DESC',

        );
    }elseif ( $listing_multi_options == 'location_view' ) {
        $args = array(
            'post_type' => $type,
            'post_status'     => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'location',
                    'field' => 'id',
                    'terms' => $listing_loc
                )
            ),
            'posts_per_page' => $listing_per_page,
            'order'           	=> 'DESC'
        );
    }elseif ( $listing_multi_options == 'cat_view' ) {
        $args = array(
            'post_type' => $type,
            'post_status'     => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'listing-category',
                    'field' => 'id',
                    'terms' => $listing_cat,
                    'include_children' => false
                )
            ),
            'posts_per_page' => $listing_per_page,
            'order'           	=> 'DESC'
        );
    }
    elseif ( $listing_multi_options == 'location_cat_view' ) {
        $args = array(
            'post_type' => $type,
            'post_status'     => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'listing-category',
                    'field' => 'id',
                    'terms' => $listing_cat
                ),
                array(
                    'taxonomy' => 'location',
                    'field' => 'id',
                    'terms' => $listing_loc
                )
            ),
            'posts_per_page' => $listing_per_page,
            'order'           	=> 'DESC'
        );
    }

    $listing_query = null;
    $addClassListing = '';
    $listing_query = new WP_Query($args);
    global $listingpro_options;
    $listing_views = $listingpro_options['listing_views'];
    $GLOBALS['listing_layout_element']  =   $listing_layout;
    if( !empty( $GLOBALS['listing_layout_element'] ) || $GLOBALS['listing_layout_element'] != '' )
    {
        $addClassListing    =   'listing_' . $listing_layout;
    }
    else
    {
        if($listing_views == 'list_view') {
            $addClassListing = 'listing_list_view';

        }elseif($listing_views == 'grid_view') {
            $addClassListing = 'listing_grid_view';

        }else {
            $addClassListing = '';
        }
    }

    $listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];

    if( $listing_grid_style == 'grid_view5' && $listing_layout == 'grid_view' )
    {
        $GLOBALS['grid_col_class']  =   4;
        $GLOBALS['trending_el']  =   true;
        ob_start();
        if( $listing_query->have_posts() )
        {
            $output .=  '<div class="lp-section-content-container"><div class="lp-listings">';
            $output .=  '    <div class="row listing-slider">';
            while ($listing_query->have_posts()) : $listing_query->the_post();
                ob_start();
                get_template_part('templates/loop-grid-view');
                $output .= ob_get_contents();
                ob_end_clean();
                ob_flush();
            endwhile;
            $output .=  '   </div></div>';
            $output .=  '</div>';
        }
        ob_end_clean();
        ob_flush();
    }
    elseif( $listing_grid_style == 'grid_view3' && $listing_layout == 'grid_view' )
    {
        $GLOBALS['grid_col_class'] = 4;

        $output .= '<div class="lp-section-content-container listingcampaings"> <div class="lp-listings grid-style">';
        $output .= '    <div class="row">';
        if ($listing_query->have_posts()) {
            while ($listing_query->have_posts()) : $listing_query->the_post();
                ob_start();
                get_template_part('templates/loop-grid-view');
                $output .= ob_get_contents();
                ob_end_clean();
                ob_flush();
            endwhile;
        }
        $output .= '    <div class="clearfix"></div> </div>';
        if (!empty($grid3_button_text) && isset($grid3_button_text)) {
            $btn_href = '';
            if (!empty($grid3_button_link)) {
                $btn_href = ' href="' . $grid3_button_link . '"';
            }
            $output .= '    <div class="more-listings"><a' . $btn_href . '>' . $grid3_button_text . '</a></div>';
        }

        $output .= '</div></div>';
        wp_reset_postdata();

    }
    else
    {
        $output.='
	<div class="listing-simple '.$addClassListing.' listingcampaings">
		<div class="lp-section-content-container lp-list-page-grid row" id="content-grids" >';
        if ($listing_grid_style == 'grid_view1'){
            if( $listing_query->have_posts() ) {
                if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                {
                    if(($listing_layout == 'grid_view') && ($listing_views == 'grid_view' || $listing_views == 'grid_view2' || $listing_views == 'grid_view3' || $listing_views == 'list_view' || $listing_views == 'list_view3')) {
                        $output .= '<div class="map-view-list-container2">';

                    }else{

                        $output .= '<div class="map-view-list-containerlist">';
                    }
                }
                while ($listing_query->have_posts()) : $listing_query->the_post();
                    ob_start();
                    if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                    {
                        get_template_part('mobile/listing-loop-app-view');
                    }
                    else
                    {
                        get_template_part('listing-loop');
                    }
                    $output .= ob_get_contents();
                    ob_end_clean();
                    ob_flush();
                endwhile;
                if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                {
                    if(($listing_layout == 'grid_view') && ($listing_views == 'grid_view' || $listing_views == 'grid_view2' || $listing_views == 'grid_view3' || $listing_views == 'list_view' || $listing_views == 'list_view3')) {
                        $output .= '</div>';
                    }else{

                        $output .= '</div>';
                    }
                }
                $output .= '<div class="md-overlay"></div>';
            }
        }elseif ($listing_grid_style == 'grid_view2'){

            if( $listing_query->have_posts() ) {
                if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                {
                    if(($listing_layout == 'grid_view') && ($listing_views == 'grid_view' || $listing_views == 'grid_view2' || $listing_views == 'grid_view3' || $listing_views == 'list_view' || $listing_views == 'list_view3')) {
                        $output .= '<div class="map-view-list-container2">';

                    }else{

                        $output .= '<div class="map-view-list-containerlist">';
                    }
                }
                while ($listing_query->have_posts()) : $listing_query->the_post();
                    ob_start();
                    if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                    {
                        get_template_part('mobile/listing-loop-app-view');
                    }
                    else
                    {
                        get_template_part('templates/loop/loop2');
                    }

                    $output .= ob_get_contents();
                    ob_end_clean();
                    ob_flush();
                endwhile;
                if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                {
                    if(($listing_layout == 'grid_view') && ($listing_views == 'grid_view' || $listing_views == 'grid_view2' || $listing_views == 'grid_view3' || $listing_views == 'list_view' || $listing_views == 'list_view3')) {
                        $output .= '</div>';
                    }else{

                        $output .= '</div>';
                    }
                }
                $output .= '<div class="md-overlay"></div>';
            }

        }elseif ($listing_grid_style == 'grid_view4'){
            $GLOBALS['grid_view_element']  =   'grid_view4';
            if( $listing_query->have_posts() ) {
                if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                {

                    if(($listing_layout == 'grid_view') && ($listing_views == 'grid_view' || $listing_views == 'grid_view2' || $listing_views == 'grid_view3' || $listing_views == 'list_view' || $listing_views == 'list_view3')) {
                        $output .= '<div class="map-view-list-container2">';

                    }else{

                        $output .= '<div class="map-view-list-containerlist">';
                    }
                }
                while ($listing_query->have_posts()) : $listing_query->the_post();

                    ob_start();
                    if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                    {

                        get_template_part('mobile/listing-loop-app-view');
                    }
                    else
                    {
                        get_template_part('listing-loop');
                    }

                    $output .= ob_get_contents();
                    ob_end_clean();
                    ob_flush();
                endwhile;
                if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                {
                    if(($listing_layout == 'grid_view') && ($listing_views == 'grid_view' || $listing_views == 'grid_view2' || $listing_views == 'grid_view3' || $listing_views == 'list_view' || $listing_views == 'list_view3')) {
                        $output .= '</div>';
                    }else{

                        $output .= '</div>';
                    }
                }
                $output .= '<div class="md-overlay"></div>';
            }
        }
    }




    wp_reset_postdata();
    global $postGridCount;
    $postGridCount = '0';



    return $output;
}
add_shortcode('listing_options', 'listingpro_shortcode_listing_options');




/*------------------------------------------------------*/
/* Listings
/*------------------------------------------------------*/

vc_map( array(
    "name"                      => __("Listing Posts", "js_composer"),
    "base"                      => 'listing_grids',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(

        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => esc_html__("Listing Layout","js_composer"),
            "param_name"  => "listing_layout",
            'value' => array(
                esc_html__( 'List View', 'js_composer' ) => 'list_view',
                esc_html__( 'Grid View', 'js_composer' ) => 'grid_view',
            ),
            'save_always' => true,
            "description" => "Select lists layout"
        ),
        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => esc_html__("Styles","js_composer"),
            "param_name"  => "listing_grid_style",
            'value' => array(
                esc_html__( 'Grid Style 1', 'js_composer' ) => 'grid_view1',
                esc_html__( 'Grid Style 2', 'js_composer' ) => 'grid_view2',
                esc_html__( 'Grid Style 3', 'js_composer' ) => 'grid_view3',
                esc_html__( 'Grid Style 4', 'js_composer' ) => 'grid_view4',
                esc_html__( 'Grid Style 5', 'js_composer' ) => 'grid_view5',

            ),
            "dependency" => array(
                "element" => "listing_layout",
                "value" => "grid_view"
            ),
            'save_always' => true,
            "description" => "Select number of posts you want to show"
        ),
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Button Text", "js_composer" ),
            "param_name" => "grid3_button_text",
            "description" => __( "Button for grid style 3, Leave empty to hide.", "js_composer" ),
            "dependency" => array(
                "element" => "listing_grid_style",
                "value" => "grid_view3"
            ),
        ),
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Button Link", "js_composer" ),
            "param_name" => "grid3_button_link",
            "description" => __( "Button link for grid style 3", "js_composer" ),
            "dependency" => array(
                "element" => "listing_grid_style",
                "value" => "grid_view3"
            ),
        ),
        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => esc_html__("Posts per page","js_composer"),
            "param_name"  => "number_posts",
            'value' => array(
                esc_html__( '3 Posts', 'js_composer' ) => '3',
                esc_html__( '6 Posts', 'js_composer' ) => '6',
                esc_html__( '9 Posts', 'js_composer' ) => '9',
                esc_html__( '12 Posts', 'js_composer' ) => '12',
                esc_html__( '15 Posts', 'js_composer' ) => '15',
            ),
            'save_always' => true,
            "description" => "Select number of posts you want to show"
        ),
    ),
) );
function listingpro_shortcode_listing_grids($atts, $content = null) {
    extract(shortcode_atts(array(
        'listing_grid_style'   => 'grid_view1',
        'number_posts'   => '3',
        'listing_layout'   => 'grid_view',
        'grid3_button_text'   => '',
        'grid3_button_link'   => '',
    ), $atts));

    $output = null;
    $type = 'listing';
    $args=array(
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => $number_posts,
    );

    $argsFOrADS =array(
        'orderby' => 'rand',
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => $number_posts,
        'meta_query' => array(
            'relation'=>'AND',
            array(
                'key'     => 'campaign_status',
                'value'   => array( 'active' ),
                'compare' => 'IN',
            ),
            array(
                'key'     => 'lp_random_ads',
                'value'   => array( 'active' ),
                'compare' => 'IN',
            ),
        ),
    );

    $listingcurrency = '';
    $listingprice = '';
    $addClassListing = '';
    $listing_query = null;
    $listing_query = new WP_Query($argsFOrADS);

    $found = $listing_query->found_posts;
    if(($found == 0)){
        $listing_query = null;
        $listing_query = new WP_Query($args);
    }


    $post_count =1;

    global $listingpro_options;
    $listing_views = $listingpro_options['listing_views'];

    $GLOBALS['listing_layout_element']  =   $listing_layout;
    if( !empty( $GLOBALS['listing_layout_element'] ) || $GLOBALS['listing_layout_element'] != '' )
    {
        $addClassListing    =   'listing_' . $listing_layout;
    }
    else
    {
        if($listing_views == 'list_view') {
            $addClassListing = 'listing_list_view';

        }elseif($listing_views == 'grid_view') {
            $addClassListing = 'listing_grid_view';

        }else {
            $addClassListing = '';
        }
    }
    $listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
    if( $listing_grid_style == 'grid_view5' && $listing_layout == 'grid_view' )
    {
        $GLOBALS['grid_col_class']  =   4;
        $GLOBALS['trending_el']  =   true;
        ob_start();
        if( $listing_query->have_posts() )
        {
            $output .=  '<div class="lp-section-content-container"><div class="lp-listings">';
            $output .=  '    <div class="row listing-slider">';
            while ($listing_query->have_posts()) : $listing_query->the_post();
                ob_start();
                get_template_part('templates/loop-grid-view');
                $output .= ob_get_contents();
                ob_end_clean();
                ob_flush();
            endwhile;
            $output .=  '   </div></div>';
            $output .=  '</div>';
        }
        ob_end_clean();
        ob_flush();
    }
    if( $listing_grid_style == 'grid_view3' && $listing_layout == 'grid_view' )
    {
        $GLOBALS['grid_col_class']  =   4;

        $output .=  '<div class="lp-section-content-container listingcampaings"> <div class="lp-listings grid-style">';
        $output .=  '    <div class="row">';
        if( $listing_query->have_posts() ) {
            while ($listing_query->have_posts()) : $listing_query->the_post();
                ob_start();
                get_template_part('templates/loop-grid-view');
                $output .= ob_get_contents();
                ob_end_clean();
                ob_flush();
            endwhile;
        }
        $output .=  '    <div class="clearfix"></div> </div>';
        if( !empty( $grid3_button_text ) && isset( $grid3_button_text ) )
        {
            $btn_href   =   '';
            if( !empty( $grid3_button_link ) )
            {
                $btn_href   =   ' href="'. $grid3_button_link .'"';
            }
            $output .=  '    <div class="more-listings"><a' . $btn_href . '>'. $grid3_button_text .'</a></div>';
        }

        $output .=  '</div></div>';
        wp_reset_postdata();
    }
    else
    {
        $output.='
	<div class="listing-simple '.$addClassListing.' listingcampaings">
		<div class="lp-section-content-container lp-list-page-grid row" id="content-grids" >';
        if ($listing_grid_style == 'grid_view1'){
            if( $listing_query->have_posts() ) {
                if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                {
                    if(($listing_layout == 'grid_view') && ($listing_views == 'grid_view' || $listing_views == 'grid_view2' || $listing_views == 'grid_view3' || $listing_views == 'list_view' || $listing_views == 'list_view3')) {
                        $output .= '<div class="map-view-list-container2">';

                    }else{

                        $output .= '<div class="map-view-list-containerlist">';
                    }
                }
                while ($listing_query->have_posts()) : $listing_query->the_post();
                    ob_start();
                    if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                    {
                        get_template_part('mobile/listing-loop-app-view');
                    }
                    else
                    {
                        get_template_part('listing-loop');
                    }
                    $output .= ob_get_contents();
                    ob_end_clean();
                    ob_flush();
                endwhile;
                if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                {
                    if(($listing_layout == 'grid_view') && ($listing_views == 'grid_view' || $listing_views == 'grid_view2' || $listing_views == 'grid_view3' || $listing_views == 'list_view' || $listing_views == 'list_view3')) {
                        $output .= '</div>';
                    }else{

                        $output .= '</div>';
                    }
                }
                $output .= '<div class="md-overlay"></div>';
            }
        }elseif ($listing_grid_style == 'grid_view2'){

            if( $listing_query->have_posts() ) {
                if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                {
                    if(($listing_layout == 'grid_view') && ($listing_views == 'grid_view' || $listing_views == 'grid_view2' || $listing_views == 'grid_view3' || $listing_views == 'list_view' || $listing_views == 'list_view3')) {
                        $output .= '<div class="map-view-list-container2">';

                    }else{

                        $output .= '<div class="map-view-list-containerlist">';
                    }
                }
                while ($listing_query->have_posts()) : $listing_query->the_post();
                    ob_start();
                    if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                    {
                        get_template_part('mobile/listing-loop-app-view');
                    }
                    else
                    {
                        get_template_part('templates/loop/loop2');
                    }

                    $output .= ob_get_contents();
                    ob_end_clean();
                    ob_flush();
                endwhile;
                if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                {
                    if(($listing_layout == 'grid_view') && ($listing_views == 'grid_view' || $listing_views == 'grid_view2' || $listing_views == 'grid_view3' || $listing_views == 'list_view' || $listing_views == 'list_view3')) {
                        $output .= '</div>';
                    }else{

                        $output .= '</div>';
                    }
                }
                $output .= '<div class="md-overlay"></div>';
            }

        }elseif ($listing_grid_style == 'grid_view4'){
            $GLOBALS['grid_view_element']  =   'grid_view4';
            if( $listing_query->have_posts() ) {
                if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                {

                    if(($listing_layout == 'grid_view') && ($listing_views == 'grid_view' || $listing_views == 'grid_view2' || $listing_views == 'grid_view3' || $listing_views == 'list_view' || $listing_views == 'list_view3')) {
                        $output .= '<div class="map-view-list-container2">';

                    }else{

                        $output .= '<div class="map-view-list-containerlist">';
                    }
                }
                while ($listing_query->have_posts()) : $listing_query->the_post();

                    ob_start();
                    if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                    {

                        get_template_part('mobile/listing-loop-app-view');
                    }
                    else
                    {
                        get_template_part('listing-loop');
                    }

                    $output .= ob_get_contents();
                    ob_end_clean();
                    ob_flush();
                endwhile;
                if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
                {
                    if(($listing_layout == 'grid_view') && ($listing_views == 'grid_view' || $listing_views == 'grid_view2' || $listing_views == 'grid_view3' || $listing_views == 'list_view' || $listing_views == 'list_view3')) {
                        $output .= '</div>';
                    }else{

                        $output .= '</div>';
                    }
                }
                $output .= '<div class="md-overlay"></div>';
            }
        }
        wp_reset_postdata();
        global $postGridCount;
        $postGridCount = '0';
        $output.='
		</div>
	</div>';
    }



    return $output;
}
add_shortcode('listing_grids', 'listingpro_shortcode_listing_grids');



/*------------------------------------------------------*/
/* Image gallery
/*------------------------------------------------------*/

vc_map( array(
    "name"                      => __("Image Gallery", "js_composer"),
    "base"                      => 'image_gallery',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(
            'type' => 'dropdown',
            'heading' => __('Image gallery styles', 'js_composer'),
            'param_name' => 'imagegallerystyle',
            'description' => __('Choose your Gallery style', 'js_composer'),
            'value' => array(
                __("Old Style", "js_composer") => "old_style",
                __("New Style", "js_composer") => "new_style"
            ),
            'save_always' => true
        ),
        array(
            "type"        => "attach_images",
            "class"       => "",
            "heading"     => __("Image for gallery","js_composer"),
            "param_name"  => "gallery_images",
            "value"       => "",
            "description" => "Upload image for gallery."
        ),
    ),
) );
function listingpro_shortcode_gallery($atts, $content = null) {
    extract(shortcode_atts(array(
        'imagegallerystyle' => '',
        'gallery_images' => ''
    ), $atts));

    $output = null;
    $imgIDs=null;
    $screenImage=null;
    $IDs = $gallery_images;

    $count = 1;
    if ($imagegallerystyle == "old_style") {
        $output .= '<div class="about-gallery  lp-section-content-container popup-gallery clearfix">';

        if (!empty($IDs)) {
            $imgIDs = explode(',',$IDs);
            foreach($imgIDs as $imgID){

                if($count == 1){
                    $imgurl = wp_get_attachment_image_src( $imgID, 'listingpro-gallery-thumb1');
                    $imgFull = wp_get_attachment_image_src( $imgID, 'full');
                    $screenImage = '<img src="'. $imgurl[0] .'">';

                    $output .= '	<div class="col-md-5 col-sm-5 about-gallery-box">
							<a href="'.$imgFull[0].'" class="image-popup">
								'.$screenImage.'
							</a>
						</div>';
                }elseif($count == 2){
                    $imgurl = wp_get_attachment_image_src( $imgID, 'listingpro-gallery-thumb2');
                    $imgFull = wp_get_attachment_image_src( $imgID, 'full');
                    $screenImage = '<img src="'. $imgurl[0] .'">';

                    $output .= '	<div class="col-md-4 col-sm-4 about-gallery-box">
							<a href="'.$imgFull[0].'" class="image-popup">
								'.$screenImage.'
							</a>
						</div>';
                }elseif($count == 3){
                    $imgurl = wp_get_attachment_image_src( $imgID, 'listingpro-gallery-thumb3');
                    $imgFull = wp_get_attachment_image_src( $imgID, 'full');
                    $screenImage = '<img src="'. $imgurl[0] .'">';

                    $output .= '	<div class="col-md-3 col-sm-3 about-gallery-box">
							<a href="'.$imgFull[0].'" class="image-popup">
								'.$screenImage.'
							</a>
						</div>';
                }elseif($count == 4){
                    $imgurl = wp_get_attachment_image_src( $imgID, 'listingpro-gallery-thumb4');
                    $imgFull = wp_get_attachment_image_src( $imgID, 'full');
                    $screenImage = '<img src="'. $imgurl[0] .'">';
                    $output .= '	<div class="col-md-7 col-sm-7 about-gallery-box">
							<a href="'.$imgFull[0].'" class="image-popup">
								'.$screenImage.'
							</a>
						</div>';
                }else{
                    $imgurl = wp_get_attachment_image_src( $imgID, 'listingpro-gallery-thumb2');
                    $imgFull = wp_get_attachment_image_src( $imgID, 'full');
                    $screenImage = '<img src="'. $imgurl[0] .'">';
                    $output .= '    <div class="col-md-4 col-sm-4 about-gallery-box">                            <a href="' . $imgFull[0] . '" class="image-popup">                                ' . $screenImage . '                            </a>                        </div>';
                }

                $count++;
            }
        }

        $output .= '</div>';
    } else {
        $output .= '<div class="about-gallery  popup-gallery clearfix about-gallery-style2">';
        if (!empty($IDs)) {
            $imgIDs = explode(',', $IDs);
            foreach ($imgIDs as $imgID) {
                if ($count == 1) {
                    $imgurl      = wp_get_attachment_image_src($imgID, 'listingpro-gallery-thumb1');
                    $imgFull     = wp_get_attachment_image_src($imgID, 'full');
                    $screenImage = '<img src="' . $imgurl[0] . '">';
                    $output .= '    <div class="col-md-2 col-sm-2 padding-0 about-gallery-box">                                    <a href="' . $imgFull[0] . '" class="image-popup">                                        ' . $screenImage . '                                    </a>                                </div>';
                } elseif ($count == 2) {
                    $imgurl      = wp_get_attachment_image_src($imgID, 'listingpro-gallery-thumb1');
                    $imgFull     = wp_get_attachment_image_src($imgID, 'full');
                    $screenImage = '<img src="' . $imgurl[0] . '">';
                    $output .= '    <div class="col-md-2 col-sm-2 padding-0 about-gallery-box">                                    <a href="' . $imgFull[0] . '" class="image-popup">                                        ' . $screenImage . '                                    </a>                                </div>';
                } elseif ($count == 3) {
                    $imgurl      = wp_get_attachment_image_src($imgID, 'listingpro-gallery-thumb1');
                    $imgFull     = wp_get_attachment_image_src($imgID, 'full');
                    $screenImage = '<img src="' . $imgurl[0] . '">';
                    $output .= '    <div class="col-md-2 col-sm-2 padding-0 about-gallery-box">                                    <a href="' . $imgFull[0] . '" class="image-popup">                                        ' . $screenImage . '                                    </a>                                </div>';
                } elseif ($count == 4) {
                    $imgurl      = wp_get_attachment_image_src($imgID, 'listingpro-gallery-thumb1');
                    $imgFull     = wp_get_attachment_image_src($imgID, 'full');
                    $screenImage = '<img src="' . $imgurl[0] . '">';
                    $output .= '    <div class="col-md-2 col-sm-2 padding-0 about-gallery-box">                                    <a href="' . $imgFull[0] . '" class="image-popup">                                        ' . $screenImage . '                                    </a>                                </div>';
                } else {
                    $imgurl      = wp_get_attachment_image_src($imgID, 'listingpro-gallery-thumb1');
                    $imgFull     = wp_get_attachment_image_src($imgID, 'full');
                    $screenImage = '<img src="' . $imgurl[0] . '">';
                    $output .= '    <div class="col-md-2 col-sm-2 padding-0 about-gallery-box">                                    <a href="' . $imgFull[0] . '" class="image-popup">                                        ' . $screenImage . '                                    </a>                                </div>';
                }

                $count++;
            }
        }

        $output .= '</div>';
    }

    return $output;
}
add_shortcode('image_gallery', 'listingpro_shortcode_gallery');

/*------------------------------------------------------*/
/* Video testimonials
/*------------------------------------------------------*/

vc_map( array(
    "name"                      => __("Video Testimonials", "js_composer"),
    "base"                      => 'video_testimonials',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(


        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => __("Video preview Image","js_composer"),
            "param_name"  => "screen_image",
            "value"       => "",
            "description" => "Please upload preview Image Size(580x386)"
        ),

        array(
            "type"        => "textfield",
            "class"       => "",
            "heading"     => __("Video URL","js_composer"),
            "param_name"  => "video_url",
            "value"       => "",
            "description" => "You can use direct URL from youtube, vimeo, dailymotion or any other wordpress supported website"
        ),

        array(
            "type"        => "textfield",
            "class"       => "",
            "heading"     => __("Testimonial Title","js_composer"),
            "param_name"  => "testi_title",
            "value"       => "",
            "description" => ""
        ),
        array(
            "type"        => "textfield",
            "class"       => "",
            "heading"     => __("Author name","js_composer"),
            "param_name"  => "author_name",
            "value"       => "",
            "description" => ""
        ),
        array(
            "type"        => "textfield",
            "class"       => "",
            "heading"     => __("Author Company","js_composer"),
            "param_name"  => "author_company",
            "value"       => "",
            "description" => ""
        ),
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => __("Author Avatar","js_composer"),
            "param_name"  => "author_image",
            "value"       => "",
            "description" => "Please upload preview Image Size(60x60)"
        ),
        array(
            "type"        => "textarea",
            "class"       => "",
            "heading"     => __("Testimonial Content","js_composer"),
            "param_name"  => "testi_content",
            "value"       => "",
            "description" => ""
        ),

    ),
) );
function listingpro_shortcode_video_box($atts, $content = null) {
    extract(shortcode_atts(array(
        'screen_image'   => '',
        'video_url'   => '',
        'testi_title'   => '',
        'author_name'   => '',
        'author_company'   => '',
        'author_image'   => '',
        'testi_content'   => '',

    ), $atts));

    $output = null;
    $screenImage=null;
    $authorImage=null;


    if ( $screen_image ) {
        $imgurl = wp_get_attachment_image_src( $screen_image, 'full');
        $screenImage = '<img src="'. $imgurl[0] .'">';
    }
    if ( $author_image ) {
        $imgurl = wp_get_attachment_image_src( $author_image, 'listingpro-author-thumb');
        $authorImage = '<img src="'. $imgurl[0] .'">';
    }


    $output .= '<div class="testimonial lp-section-content-container row">';

    $output .= '<div class="col-md-6">
						<div class="video-thumb">
								'.$screenImage.'
							<a href="'.$video_url.'" class="overlay-video-thumb popup-vimeo">
								<i class="fa fa-play-circle-o"></i>
							</a>
						</div><!-- ../video-thumb -->
					</div>';

    $output .= '<div class="col-md-6">
						<div class="testimonial-inner-box">
							<h3 class="margin-top-0">'.$testi_title.'</h3>.
							<div class="testimonial-description lp-border-radius-5">
								<p>'.esc_attr($testi_content).'	</p>
							</div><!-- ../testimonial-description -->
							<div class="testimonial-user-info user-info">
								<div class="testimonial-user-thumb user-thumb">
									'.$authorImage.'
								</div>
								<div class="testimonial-user-txt user-text">
									<label class="testimonial-user-name user-name">'.$author_name.'</label><br>
									<label class="testimonial-user-position user-position">'.$author_company.'</label>
								</div>
							</div><!-- ../testimonial-user-info -->
						</div><!-- ../testimonial-inner-box -->
					</div>';

    $output .= '</div>';


    return $output;
}
add_shortcode('video_testimonials', 'listingpro_shortcode_video_box');

/*------------------------------------------------------*/
/* Listings
/*------------------------------------------------------*/
function blog_category_field($settings, $value) {
    $categories = get_terms('category');
    //$dependency = vc_generate_dependencies_attributes($settings);
    $dependency = ( function_exists( 'vc_generate_dependencies_attributes' ) )
        ? vc_generate_dependencies_attributes( $settings ) : '';
    $data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';

    $selected = '';
    foreach($categories as $category) {
        $selected = '';
        if ($value!=='' && $category->term_id == $value) {
            $selected = ' selected="selected"';
        }
        $data .= '<option class="'.$category->slug.'" value="'.$category->term_id.'"'.$selected.'>' . $category->name . ' (' . $category->count . ' Posts)</option>';
    }
    $selectedd = '';
    if(empty($value)){
        $selectedd = ' selected="selected"';
    }
    $data .= '<option class="" value="" '.$selectedd.'>' .esc_html__('All Categories', 'listingpro-plugin').'</option>';
    $data .= '</select>';
    return $data;
}
vc_add_shortcode_param('blog_category' , 'blog_category_field');

vc_map( array(
    "name"                      => __("Blog Grids", "js_composer"),
    "base"                      => 'blog_grids',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(
        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => __("Select Blog Element Style","js_composer"),
            "param_name"  => "blog_style",
            'value' => array(
                __( 'Blog Grid ', 'js_composer' ) => 'style1',
                __( 'Blog Masnory ', 'js_composer' ) => 'style2',
                __( 'Blog Cirlce ', 'js_composer' ) => 'style3',

            ),
            'save_always' => true,
            "description" => "Select Blog Style"
        ),
        array(
            "type" => "blog_category",
            "holder" => "div",
            "heading" => "Category",
            "param_name" => "category",
            "class"       => "hide_in_vc_editor",
            "admin_label"     => true,
        ),
        array(
            "type"        => "textfield",
            "class"       => "",
            "heading"     => __("No. of posts","js_composer"),
            "param_name"  => "blog_per_page",
            "value"       => "3",
            "description" => ""
        ),
    ),
) );
function listingpro_shortcode_blog_grids($atts, $content = null) {
    extract(shortcode_atts(array(

        'blog_style'   => 'style1',
        'category'   => '',
        'blog_per_page' => '3',
    ), $atts));

    $output = null;

    if($blog_style == 'style1'){
        $output .= '<div class="lp-section-content-container lp-blog-grid-container row">';

        $type = 'post';
        $args=array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => "$blog_per_page",
            'cat' => $category,
        );

        $my_query = null;
        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ) {
            while ($my_query->have_posts()) : $my_query->the_post();
                $imgurl = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'listingpro-blog-grid');
                if($imgurl){
                    $thumbnail = $imgurl[0];
                }else{
                    $thumbnail = 'https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240';
                }
                $categories = get_the_category(get_the_ID());
                $separator = ' ';
                $catoutput = '';
                if ( ! empty( $categories ) ) {
                    foreach( $categories as $category ) {
                        $catoutput .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" >' . esc_html( $category->name ) . '</a>' . $separator;
                    }
                }

                $author_avatar_url = get_user_meta(get_the_author_meta( 'ID' ), "listingpro_author_img_url", true);
                $avatar ='';
                if(!empty($author_avatar_url)) {
                    $avatar =  $author_avatar_url;
                } else {
                    $avatar_url = listingpro_get_avatar_url (get_the_author_meta( 'ID' ), $size = '51' );
                    $avatar =  $avatar_url;
                }
                $output .= '<div class="col-md-4 col-sm-4 lp-blog-grid-box">
                                    <div class="lp-blog-grid-box-container lp-border lp-border-radius-8">
                                        <div class="lp-blog-grid-box-thumb">
                                            <a href="'.get_the_permalink().'">
                                                <img src="'.$thumbnail.'" alt="blog-grid-1-410x308" />
                                            </a>
                                        </div>
                                        <div class="lp-blog-grid-box-description text-center">
                                                <div class="lp-blog-user-thumb margin-top-subtract-25">
                                                    <img class="avatar" src="'.esc_url($avatar).'" alt="">
                                                </div>
                                                <div class="lp-blog-grid-category">
                                                    '.trim( $catoutput, $separator ).'
                                                </div>
                                                <div class="lp-blog-grid-title">
                                                    <h4 class="lp-h4">
                                                        <a href="'.get_the_permalink().'">'.get_the_title().'</a>
                                                    </h4>
                                                </div>
                                                <ul class="lp-blog-grid-author">
                                                    <li>
                                                        <a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">
                                                            <i class="fa fa-user"></i>
                                                            <span>'.get_the_author().'</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-calendar"></i>
                                                        <span>'.get_the_date(get_option('date_format')).'</span>
                                                    </li>
                                                </ul><!-- ../lp-blog-grid-author -->
                                        </div>
                                    </div>
                                </div>';
            endwhile;
        }



        $output .= '</div>';
    }elseif($blog_style == 'style2'){

        $output .= '<div class="lp-section-content-container lp-blog-grid-container row">';

        $type = 'post';
        $args=array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => "$blog_per_page",
            'cat' => $category,
        );
        $gridNumber = 1;
        $my_query = null;
        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ) {
            while ($my_query->have_posts()) : $my_query->the_post();
                if($gridNumber == 1){
                    $imgurl = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'listingpro-blog-grid3');
                    if($imgurl){
                        $thumbnail = $imgurl[0];
                    }else{
                        $thumbnail = 'https://placeholdit.imgix.net/~text?txtsize=33&w=672&h=430';
                    }
                }else{
                    $imgurl = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'listingpro-blog-grid');
                    if($imgurl){
                        $thumbnail = $imgurl[0];
                    }else{
                        $thumbnail = 'https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240';
                    }



                }
                $categories = get_the_category(get_the_ID());
                $separator = ' ';
                $catoutput = '';
                if ( ! empty( $categories ) ) {
                    foreach( $categories as $category ) {
                        $catoutput .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" >' . esc_html( $category->name ) . '</a>' . $separator;
                    }
                }

                $author_avatar_url = get_user_meta(get_the_author_meta( 'ID' ), "listingpro_author_img_url", true);
                $avatar ='';
                if(!empty($author_avatar_url)) {
                    $avatar =  $author_avatar_url;
                } else {
                    $avatar_url = listingpro_get_avatar_url (get_the_author_meta( 'ID' ), $size = '51' );
                    $avatar =  $avatar_url;
                }

                if($gridNumber == 1){
                    $output .= '<div class="lp-blog-grid-box col-md-12">
                                    <div class="lp-blog-grid-box-container lp-blog-grid-box-container-first-post lp-border-radius-8 ">
                                            <div class="col-md-5 lp-blog-style2-outer padding-right-0 lp-border">
                                                <div class="lp-blog-style2-inner">
                                                    <div class="lp-blog-user-thumb2">
                                                        <a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'"><img class="avatar" src="'.esc_url($avatar).'" alt=""></a>
                                                    </div>
                                                    
                                                    <div class="lp-blog-grid-title">
                                                        <h4 class="lp-h4">
                                                            <a href="'.get_the_permalink().'">'.substr(get_the_title(), 0, 29).'</a>
                                                        </h4>
                                                        <p>'.substr(strip_tags(get_the_content()),0,150).'..</p>
                                                    </div>
                                                    <ul class="lp-blog-grid-author">
                                                        <li>
                                                            
                                                                <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                                                                <span>'.trim( $catoutput, $separator ).'</span>
                                                            
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-calendar"></i>
                                                            <span>'.get_the_date(get_option('date_format')).'</span>
                                                        </li>
                                                    </ul><!-- ../lp-blog-grid-author -->
                                                    <div class="blog-read-more">
                                                        <a href="'.get_the_permalink().'" class="watch-video">'.esc_html__('Read More', 'listingpro-plugin').'</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="lp-blog-grid-box-thumb col-md-7 padding-right-0 padding-left-0">
                                                <a href="'.get_the_permalink().'">
                                                    <img src="'.$thumbnail.'" alt="blog-grid-1-410x308" />
                                                </a>
                                            </div>
                                        
                                        
                                    </div>
                                </div>';
                    if($gridNumber == 1){
                        $output .= '<div class="clearfix"></div>';
                    }
                }else{

                    $output .= '<div class="col-md-4 col-sm-4 lp-blog-grid-box">
                                    <div class="lp-blog-grid-box-container lp-blog-grid-box-container-style2 lp-border-radius-8">
                                        <div class="lp-blog-grid-box-thumb">
                                            <a href="'.get_the_permalink().'">
                                                <img src="'.$thumbnail.'" alt="blog-grid-1-410x308" />
                                            </a>
                                        </div>
                                        <div class="lp-blog-grid-box-description  lp-border lp-blog-grid-box-description2">
                                                <div class="lp-blog-user-thumb margin-top-subtract-25">
                                                    <a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'"><img class="avatar" src="'.esc_url($avatar).'" alt=""></a>
                                                </div>
                                                
                                                <div class="lp-blog-grid-title">
                                                    <h4 class="lp-h4">
                                                        <a href="'.get_the_permalink().'">'.substr(get_the_title(), 0, 29).'</a>
                                                    </h4>
                                                    <p>'.substr(strip_tags(get_the_content()),0,95).'..</p>
                                                </div>
                                                <ul class="lp-blog-grid-author lp-blog-grid-author2">
                                                    <li>
                                                        <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                                                        <span>'.trim( $catoutput, $separator ).'</span>
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-calendar"></i>
                                                        <span>'.get_the_date(get_option('date_format')).'</span>
                                                    </li>
                                                </ul><!-- ../lp-blog-grid-author -->
                                                <div class="blog-read-more">
                                                        <a href="'.get_the_permalink().'" class="watch-video">'.esc_html__('Read More', 'listingpro-plugin').'</a>
                                                </div>
                                        </div>
                                    </div>
                                </div>';
                    if($gridNumber2==3){
                        $output .='<div class="clearfix"></div>';

                    }
                    $gridNumber2++;
                }


                $gridNumber++;
            endwhile;
        }



        $output .= '</div>';

    }else{
        $output .= '<div class="lp-section-content-container lp-section-content-container-style3">';

        $type = 'post';
        $args=array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => '4',
            'cat' => $category,
        );

        $my_query = null;
        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ) {
            while ($my_query->have_posts()) : $my_query->the_post();
                $imgurl = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'listingpro-thumb4');
                if($imgurl){
                    $thumbnail = $imgurl[0];
                }else{
                    $thumbnail = 'https://placeholdit.imgix.net/~text?txtsize=33&w=270&h=270';
                }



                $output .= '<div class="col-md-3 col-sm-3 lp-blog-style3">
                                    <div class="lp-blog-grid-box-container">
                                        <div class="lp-blog-grid-box-thumb">
                                            <a href="'.get_the_permalink().'">
                                                <img src="'.$thumbnail.'" alt="blog-grid-1-270x270" />
                                            </a>
                                        </div>
                                        <div class="lp-blog-grid-box-description text-center">
                                                
                                                <div class="lp-blog-grid-title">
                                                    <h4 class="lp-h4">
                                                        <a href="'.get_the_permalink().'">'.get_the_title().'</a>
                                                    </h4>
                                                </div>
                                               
                                        </div>
                                    </div>
                                </div>';
            endwhile;
        }



        $output .= '</div>';
    }
    return $output;
}
add_shortcode('blog_grids', 'listingpro_shortcode_blog_grids');
/*------------------------------------------------------*/
/* Content boxes
/*------------------------------------------------------*/
vc_map( array(
    "name" => __("content boxes", "my-text-domain"),
    "base" => "content_boxes",
    "category"  => __('Listingpro', 'js_composer'),
    "as_parent" => array('only' => 'content_box'),
    "content_element" => true,
    "show_settings_on_create" => false,
    "is_container" => true,
    "params" => array(
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Element title", "js_composer" ),
            "param_name" => "moderen_title",
            "value"       => "How Its Actually Work",
            'save_always' => true,
            "description" => "Enter Element Title"
        ),
    ),
    "js_view" => 'VcColumnView'
) );
function listingpro_shortcode_content_box_container( $atts, $content = null ) {
    extract(shortcode_atts(array(

        'moderen_title'   => '',
    ), $atts));
    $output = null;

    $output .= ' <div class="about-box-container">';
    $output .= '	<div class="lp-section-content-container clearfix">';

    $output .= 				do_shortcode($content);

    $output .= '	</div>';
    $output .= '</div>';



    return $output;
}
add_shortcode( 'content_boxes', 'listingpro_shortcode_content_box_container' );


vc_map( array(
    "name"                      => __("Single Content Box", "js_composer"),
    "base"                      => 'content_box',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "content_element" => true,
    "as_child" => array('only' => 'content_boxes'),
    "params"                    => array(
        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => __("Select Single Content Box Sryle","js_composer"),
            "param_name"  => "single_content_box_style",
            'value' => array(
                __( 'Old Style ', 'js_composer' ) => 'classic',
                __( 'New Style ', 'js_composer' ) => 'moderen',

            ),
            'save_always' => true,
            "description" => "Select Single Content Box Style"
        ),
        array(
            "type"        => "textfield",
            "class"       => "",
            "heading"     => __("Title","js_composer"),
            "param_name"  => "content_title",
            "value"       => "PLANNING",
            "description" => "Title fot content"
        ),
        array(
            "type"        => "textarea",
            "class"       => "",
            "heading"     => __("Content","js_composer"),
            "param_name"  => "content_desc",
            "value"       => "Sed ut perspiciatis unde omnis iste natus error sit v oluptatem accusantium or sit v oluptatem accusantiumor sit v oluptatem ",
            "description" => "Some text"
        ),
        array(
            "type"        => "icon",
            "class"       => "",
            "heading"     => __("Content","js_composer"),
            "param_name"  => "content_icon",
            "value"       => "",
            "description" => "Select Icon"
        ),


    ),
) );
function listingpro_shortcode_content_box($atts, $content = null) {
    extract(shortcode_atts(array(
        'single_content_box_style'   => 'classic',
        'content_title'   => 'PLANNING',
        'content_desc'   => 'Sed ut perspiciatis unde omnis iste natus error sit v oluptatem accusantium or sit v oluptatem accusantiumor sit v oluptatem',
        'content_icon'   => '',
    ), $atts));

    $output = null;

    if($single_content_box_style == 'classic'){
        $output .= '<div class="col-md-3 col-sm-6 about-box text-center">
						<div class="about-box-inner lp-border-radius-5 lp-border">
							<div class="about-box-slide">
								<div class="about-box-icon">
									<!-- Inspection icon by Icons8 -->
									<i class="fa fa-'.$content_icon.'"></i>
								</div>
								<div class="about-box-title clearfix">
									<h4>'.$content_title.'</h4>
								</div>
								<div class="about-box-description">
									<p class="paragraph-small">
										'.$content_desc.'
									</p>
								</div>
							</div>
						</div>
					</div>';
    }else{

        $output .= '<div class="col-md-4 col-sm-6 about-box about-box-style2">
						<div class="about-box-inner lp-border-radius-5 lp-border">
							<div class="about-box-slide">
								<div class="about-box-icon-style2">
									<!-- Inspection icon by Icons8 -->
									<i class="fa fa-'.$content_icon.'"></i>
								</div>
								<div class="about-box-title-style2 clearfix">
									<h4>'.$content_title.'</h4>
								</div>
								<div class="about-box-description-style2">
									<p class="paragraph-small">
										'.$content_desc.'
									</p>
								</div>
							</div>
						</div>
					</div>';
    }

    return $output;
}
add_shortcode('content_box', 'listingpro_shortcode_content_box');

/*------------------------------------------------------*/
/* Partners Logos
/*------------------------------------------------------*/
vc_map( array(
    "name" => __("listingpro Partners", "js_composer"),
    "base" => "listingpro_partners",
    "as_parent" => array('only' => 'listingpro_partner'),
    "content_element" => true,
    "show_settings_on_create" => false,
    "is_container" => true,
    "params" => array(
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Element title", "js_composer" ),
            "param_name" => "partner_title",
            "value"       => "10000+ clients trust us to electrify their events",
            'save_always' => true,
            "description" => "Enter Element Title"
        ),
    ),
    "js_view" => 'VcColumnView'
) );
function listingpro_shortcode_listingpro_partners_container( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'partner_title'   => '',
    ), $atts));
    $output = null;

    $output .= ' <div class="travel-brands padding-bottom-30 padding-top-30">';
    $output .= '	<div class="row">';

    $output .= 				do_shortcode($content);

    $output .= '	</div>';
    $output .= '</div>';



    return $output;
}
add_shortcode( 'listingpro_partners', 'listingpro_shortcode_listingpro_partners_container' );

vc_map( array(
    "name"                      => __("Single Partner Logo", "js_composer"),
    "base"                      => 'listingpro_partner',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "content_element" => true,
    "as_child" => array('only' => 'listingpro_partners'),
    "params"                    => array(
        array(
            "type"        => "attach_image",
            "class"       => "",
            "heading"     => __("Partner logo ","js_composer"),
            "param_name"  => "p_image1",
            "value"       => "",
            "description" => "Put here Partner logo."
        ),
        array(
            "type"        => "textfield",
            "class"       => "",
            "heading"     => __("Logo Url","js_composer"),
            "param_name"  => "p_image1_url",
            "value"       => "#",
            "description" => ""
        ),
    ),
) );
function listingpro_shortcode_listingpro_partner($atts, $content = null) {
    extract(shortcode_atts(array(
        'p_image1'		=> '',
        'p_image1_url'		=> '',
    ), $atts));

    $output = null;

    $pimahe1 = '';
    if ( $p_image1 ) {
        $imgurl = wp_get_attachment_image_src( $p_image1, 'full');

        if($imgurl){
            $thumbnail = $imgurl[0];
        }else{
            $thumbnail = 'https://placeholdit.imgix.net/~text?txtsize=33&txt=570%C3%97228&w=570&h=228';
        }
    }
    $output .= '<div class="col-md-2 partner-box text-center">
					<div class="partner-box-inner">
						<div class="partner-image">
							<a href="'.$p_image1_url.'"><img src="'.$thumbnail.'" /></a>
						</div>
					</div>
				</div>';
    return $output;
}
add_shortcode('listingpro_partner', 'listingpro_shortcode_listingpro_partner');


/*------------------------------------------------------*/
/* Activities
/*------------------------------------------------------*/

vc_map( array(
    "name"                      => __("Activities", "js_composer"),
    "base"                      => 'lp_activities',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(

        array(
            "type"        => "dropdown",
            "class"       => "",
            "heading"     => esc_html__("Number of Activities","js_composer"),
            "param_name"  => "number_posts",
            'value' => array(
                esc_html__( '3 Posts', 'js_composer' ) => '3',
                esc_html__( '4 Posts', 'js_composer' ) => '4',
                esc_html__( '5 Posts', 'js_composer' ) => '5',
                esc_html__( '6 Posts', 'js_composer' ) => '6',
                esc_html__( '7 Posts', 'js_composer' ) => '7',
            ),
            'save_always' => true,
            "description" => "Select number of activities you want to show"
        ),
    ),
) );

function listingpro_shortcode_lp_activities($atts, $content = null) {
    extract(shortcode_atts(array(
        'number_posts'   => '5',
    ), $atts));
    require_once (THEME_PATH . "/include/aq_resizer.php");
    $output = null;

    $args   =   array(
        'post_type' => 'lp-reviews',
        'post_status' => 'publish',
        'posts_per_page' => 5,
    );
    $activities  =   new WP_Query( $args );
    if( $activities->have_posts() ) :
        $counter    =   1;
        $output .=  '<div class="lp-activities"><div class="lp-section-content-container"> ';
        $output .=  '    <div class="row">';
        while ( $activities->have_posts() ) : $activities->the_post();
            global $post;
            $r_meta     =   get_post_meta( get_the_ID(), 'lp_listingpro_options', true );
            $LID        =   $r_meta['listing_id'];
            $rating     =   $r_meta['rating'];

            $adStatus = get_post_meta( $LID, 'campaign_status', true );
            $CHeckAd = '';
            $adClass = '';
            if($adStatus == 'active'){
                $CHeckAd = '<span>'.esc_html__('Ad','listingpro').'</span>';
                $adClass = 'promoted';
            }
            $author_avatar_url = get_user_meta( $post->post_author, "listingpro_author_img_url", true);
            $avatar;
            if( !empty( $author_avatar_url ) )
            {
                $avatar =  $author_avatar_url;

            }
            else
            {
                $avatar_url = listingpro_get_avatar_url ( $post->post_author, $size = '55' );
                $avatar =  $avatar_url;
            }
            $interests = '';
            $Lols = '';
            $loves = '';
            $interVal = esc_html__('Interesting', 'listingpro');
            $lolVal = esc_html__('Lol', 'listingpro');
            $loveVal = esc_html__('Love', 'listingpro');

            $interests = listing_get_metabox_by_ID('review_'.$interVal.'',get_the_ID());
            $Lols = listing_get_metabox_by_ID('review_'.$lolVal.'',get_the_ID());
            $loves = listing_get_metabox_by_ID('review_'.$loveVal.'',get_the_ID());


            if( empty( $interests ) )
            {
                $interests = 0;
            }
            if( empty( $Lols ) )
            {
                $Lols = 0;
            }
            if( empty( $loves ) )
            {
                $loves = 0;
            }
            $reacted_msg    =   esc_html__('You already reacted', 'listingpro');
            $gallery = get_post_meta(get_the_ID(), 'gallery_image_ids', true);

            $img_url    =   'https://placeholdit.imgix.net/~text?txtsize=33&w=360&h=267';
            $img_url2   =   'https://placeholdit.imgix.net/~text?txtsize=33&w=165&h=97';
            $img_url3   =   'https://placeholdit.imgix.net/~text?txtsize=33&w=500&h=300';
            if( !empty( $gallery ) )
            {
                $imagearray = explode(',', $gallery);
                $image      = wp_get_attachment_image_src( $imagearray[0], 'full');
                $first_img  =   $imagearray[0];
                if ( !empty( $image[0] ) )
                {
                    $img_url = aq_resize( $image[0], '360', '267', true, true, true);
                    $img_url2 = aq_resize( $image[0], '165', '97', true, true, true);
                    $img_url3 = aq_resize( $image[0], '500', '300', true, true, true);
                }
            }
            $lp_liting_title    =   get_the_title( $LID );
            if( strlen( $lp_liting_title ) > 35 )
            {
                $lp_liting_title    =   substr( $lp_liting_title, 0, 35 ).'...';
            }

            $rating_num_bg  =   '';
            $rating_num_clr  =   '';

            if( $rating < 3 ){ $rating_num_bg  =   'num-level1'; $rating_num_clr  =   'level1'; }
            if( $rating < 4 ){ $rating_num_bg  =   'num-level2'; $rating_num_clr  =   'level2'; }
            if( $rating < 5 ){ $rating_num_bg  =   'num-level3'; $rating_num_clr  =   'level3'; }
            if( $rating >= 5 ){ $rating_num_bg  =   'num-level4'; $rating_num_clr  =   'level4'; }
            if( $counter == 1 )
            {

                $output .=  '
                <div class="col-md-4"> 
                    <div class="lp-activity">
                        <div class="lp-activity-top">
                            <a href="'. get_permalink( $LID ) .'" class="lp-activity-author-thumb"><img src="'. esc_attr($avatar) .'" alt="'. get_the_title() .'"></a>
                            <a href="'. get_permalink( $LID ) .'" class="lp-activity-thumb"><img class="hidden-md hidden-lg" src="'. $img_url3 .'" alt="'. get_the_title() .'"><img class="hidden-sm hidden-xs" src="'. $img_url .'" alt="'. get_the_title() .'"></a>
                        </div>
                        <div class="lp-activity-bottom">
                            <div class="lp-activity-review-writer">
                                <a href="'. get_permalink( $LID ) .'">'. get_the_author() .'</a> 
                                <p>'.esc_html__('Wrote a review', 'listingpro' ).'</p>
                            </div>
                            <div class="lp-listing-stars clearfix">
                           <div class="lp-rating-stars-outer">
                                <span class="lp-star-box ';
                if( $rating > 0 ){ $output .= 'filled'.' '.$rating_num_clr; }
                $output .=  '"><i class="fa fa-star" aria-hidden="true"></i></span>
                                <span class="lp-star-box ';
                if( $rating > 1 ){ $output .= 'filled'.' '.$rating_num_clr; }
                $output .=  '"><i class="fa fa-star" aria-hidden="true"></i></span>
                                <span class="lp-star-box ';
                if( $rating > 2  ){ $output .= 'filled'.' '.$rating_num_clr; }
                $output .=  '"><i class="fa fa-star" aria-hidden="true"></i></span>
                                <span class="lp-star-box ';
                if( $rating > 3 ){ $output .= 'filled'.' '.$rating_num_clr; }
                $output .=  '"><i class="fa fa-star" aria-hidden="true"></i></span>
                                <span class="lp-star-box ';
                if( $rating > 4 ){ $output .= 'filled'.' '.$rating_num_clr; }
                $output .=  '"><i class="fa fa-star" aria-hidden="true"></i></span>
</div>
                                <span class="lp-rating-num">'. $rating .'</span>
                            </div>
                            <h3><a href="'. get_permalink( $LID ) .'">'. $lp_liting_title .'</a></h3>
                            <strong>'. substr( get_the_title(), 0, 35 ) .'</strong>
                            <div class="lp-activity-description">
                                <p>'. substr( $post->post_content, '0', '130' ) .' <a href="'. get_permalink( $LID ) .'">'.esc_html__('Continue Reading', 'listingpro' ).'</a></p>
                                <div class="activity-reactions">
                                    <a href="#" data-restype="'.$interVal.'" data-reacted ="'.$reacted_msg.'" data-id="'.get_the_ID().'" data-score="'.esc_attr($interests).'" class="review-interesting review-reaction"><i class="fa fa-thumbs-o-up"></i><span class="react-msg"></span>'.esc_html('Interesting','listingpro').' <span class="react-count">'. $interests .'</span></a>
                                    <a href="#" data-restype="'.$lolVal.'" data-reacted ="'.$reacted_msg.'" data-id="'.get_the_ID().'" data-score="'.esc_attr($Lols).'" class="review-lol review-reaction"><i class="fa fa-smile-o"></i> <span class="react-msg"></span> <span class="react-msg"></span>'.esc_html('LOL','listingpro').' <span class="react-count">'.$Lols.'</span></a>
                                    <a href="#" data-restype="'.$loveVal.'" data-reacted ="'.$reacted_msg.'" data-id="'.get_the_ID().'" data-score="'.esc_attr($loves).'" class="review-love review-reaction"><i class="fa fa-heart-o"></i><span class="react-msg"></span> <span class="react-msg"></span>'.esc_html('Love','listingpro').' <span class="react-count">'.$loves.'</span></a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>';

            }
            if( $counter > 1 )
            {
                $bottom_class   =   '';
                if( $counter == 4 || $counter == 5 )
                {
                    $bottom_class   =   'bottom0';
                }
                if( $counter == 2 )
                {
                    $output .=  '<div class="col-md-8">';
                    $output .=  '    <div class="row">';
                }
                $output .=  '
                <div class="col-md-6">
                    <div class="lp-activity style2 '. $bottom_class .'">
                        <div class="lp-activity-top">
                            <div class="row">
                                <div class="lp-activity-thumb col-md-6">
                                    <a href="#" class="lp-activity-author-thumb"><img src="'. esc_attr($avatar) .'" alt=""></a>
                                    <a href="' . get_permalink( $LID ) . '"><img class="hidden-xs hidden-sm" src="'. $img_url2 .'" alt="'. get_the_title() .'"><img class="hidden-md hidden-lg" src="'. $img_url3 .'" alt="'. get_the_title() .'"></a>
                                </div>
                                <div class="lp-activity-top-right col-md-6">
                                    <div class="lp-activity-review-writer">
                                        <a href="'. get_permalink( $LID ) .'">'. get_the_author() .'</a> 
                                <p>'.esc_html__('Wrote a review', 'listingpro' ).'</p>
                                    </div>
                                    <div class="lp-listing-stars clearfix">
                           <div class="lp-rating-stars-outer">
                                        <span class="lp-star-box ';
                if( $rating > 0 ){ $output .= 'filled'.' '.$rating_num_clr; }
                $output .=  '"><i class="fa fa-star" aria-hidden="true"></i></span>
                                        <span class="lp-star-box ';
                if( $rating > 1 ){ $output .= 'filled'.' '.$rating_num_clr; }
                $output .=  '"><i class="fa fa-star" aria-hidden="true"></i></span>
                                        <span class="lp-star-box ';
                if( $rating > 2  ){ $output .= 'filled'.' '.$rating_num_clr; }
                $output .=  '"><i class="fa fa-star" aria-hidden="true"></i></span>
                                        <span class="lp-star-box ';
                if( $rating > 3 ){ $output .= 'filled'.' '.$rating_num_clr; }
                $output .=  '"><i class="fa fa-star" aria-hidden="true"></i></span>
                                        <span class="lp-star-box ';
                if( $rating > 4 ){ $output .= 'filled'.' '.$rating_num_clr; }
                $output .=  '"><i class="fa fa-star" aria-hidden="true"></i></span>
</div>
                                        <span class="lp-rating-num">'. $rating;
                if( $rating == '' ){ $output   .=  0; }
                if( $rating == 1 || $rating == 2 || $rating == 3 || $rating == 4 || $rating == 5 ){ $output .= '.0';}
                $output.= '</span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="lp-activity-bottom">
                            <h3><a href="'. get_permalink( $LID ) .'">'. $lp_liting_title .'</a></h3>
                            <strong>'. substr( get_the_title(), 0, 35 ) .'</strong>
                        </div>
                        
                        <div class="lp-activity-description">
                            <p>'. substr( $post->post_content, 0, 80 ) .' <a href="'. get_permalink( $LID ) .'">'.esc_html__('Continue Reading', 'listingpro' ).'</a></p>
                            <div class="activity-reactions small-btns">
                                <a href="#" data-restype="'.$interVal.'" data-reacted ="'.$reacted_msg.'" data-id="'.get_the_ID().'" data-score="'.esc_attr($interests).'" class="review-interesting review-reaction"><i class="fa fa-thumbs-o-up"></i><span class="react-msg"></span>'.esc_html('Interesting','listingpro').' <span class="react-count">'. $interests .'</span></a>
                                <a href="#" data-restype="'.$lolVal.'" data-reacted ="'.$reacted_msg.'" data-id="'.get_the_ID().'" data-score="'.esc_attr($Lols).'" class="review-lol review-reaction"><i class="fa fa-smile-o"></i> <span class="react-msg"></span> <span class="react-msg"></span>'.esc_html('LOL','listingpro').' <span class="react-count">'.$Lols.'</span></a>
                                <a href="#" data-restype="'.$loveVal.'" data-reacted ="'.$reacted_msg.'" data-id="'.get_the_ID().'" data-score="'.esc_attr($loves).'" class="review-love review-reaction"><i class="fa fa-heart-o"></i><span class="react-msg"></span> <span class="react-msg"></span>'.esc_html('Love','listingpro').' <span class="react-count">'.$loves.'</span></a>
                            </div> 
                        </div>
                    </div>
                </div>';
                if( $counter == 5 || $counter == $activities->found_posts )
                {
                    $output .=  '    </div>';
                    $output .=  '</div>';
                }

            }

            $counter++;
        endwhile; wp_reset_postdata();
        $output .=  '   </div></div>';
        $output .=  '</div>';
    endif;


    return $output;
}
add_shortcode('lp_activities', 'listingpro_shortcode_lp_activities');


/*------------------------------------------------------*/
/* Trending Listings
/*------------------------------------------------------*/

//vc_map( array(
//    "name"                      => __("Trending Listings", "js_composer"),
//    "base"                      => 'trending_listings',
//    "category"                  => __('Listingpro', 'js_composer'),
//    "description"               => '',
//    "params"                    => array(
//
//        array(
//            "type"        => "dropdown",
//            "class"       => "",
//            "heading"     => esc_html__("Trending Duration","js_composer"),
//            "param_name"  => "duration",
//            'value' => array(
//                esc_html__( 'Weekly', 'js_composer' ) => 'weekly',
//                esc_html__( 'Monthly', 'js_composer' ) => 'monthly',
//                esc_html__( 'Yearly', 'js_composer' ) => 'yearly',
//            ),
//            'save_always' => true,
//        ),
//        array(
//            "type"        => "dropdown",
//            "class"       => "",
//            "heading"     => esc_html__("Number of Listings","js_composer"),
//            "param_name"  => "number_posts",
//            'value' => array(
//                esc_html__( '3 Posts', 'js_composer' ) => '3',
//                esc_html__( '4 Posts', 'js_composer' ) => '4',
//                esc_html__( '5 Posts', 'js_composer' ) => '5',
//                esc_html__( '6 Posts', 'js_composer' ) => '6',
//                esc_html__( '7 Posts', 'js_composer' ) => '7',
//                esc_html__( '8 Posts', 'js_composer' ) => '8',
//                esc_html__( '9 Posts', 'js_composer' ) => '9',
//                esc_html__( '10 Posts', 'js_composer' ) => '10',
//            ),
//            'save_always' => true,
//            "description" => "Select number of listings you want to show"
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "",
//            "heading" => __( "Button Text", "js_composer" ),
//            "param_name" => "activity_btn_text",
//            "description" => __( "Leave empty to hide.", "js_composer" ),
//        ),
//        array(
//            "type" => "textfield",
//            "class" => "",
//            "heading" => __( "Button Link", "js_composer" ),
//            "param_name" => "activity_btn_link",
//            "description" => __( "", "js_composer" ),
//        ),
//    ),
//) );
//
//function listingpro_shortcode_trending($atts, $content = null) {
//    extract(shortcode_atts(array(
//        'number_posts'   => '3',
//        'duration'   => 'weekly',
//        'activity_btn_text'    => '',
//        'activity_btn_link'    => '',
//    ), $atts));
//    require_once (THEME_PATH . "/include/aq_resizer.php");
//    $output = null;
//
//
////    $type   =   'view';
////    $dataResponse = array();
////    $currentUserId = get_current_user_id();
////
////    $dayNow = date("l");
////    $yearNow = date("Y");
////    $monthNow = date("F");
////    $lpTodayDate = date('Y-m-d');
////    $lpTodayTime = strtotime($lpTodayDate);
////    $opt_name = $currentUserId.'_'.$type.'_'.$yearNow;
////    $lpUserOpt = get_option($opt_name);
////    $table = "listing_stats";
////
////
////    if( !empty( $type ) )
////    {
////        $condition = "user_id='$currentUserId' AND action_type='$type'";
////        $getRow = lp_get_data_from_db($table, '*', $condition);
////        echo '<pre>';
////        print_r( $getRow );
////        echo '</pre>';
////        if( $duration == 'weekly' )
////        {
////            $lpWeekeArray = lp_get_days_of_week($lpTodayDate);
////            if(!empty($lpWeekeArray))
////            {
////                foreach($lpWeekeArray as $singleDay)
////                {
////                    if(!empty($getRow))
////                    {
////                        foreach($getRow as $singleRow)
////                        {
////                            if(isset($singleRow->date))
////                            {
////                                $singleRowDate = $singleRow->date;
////                                if($singleRowDate==$singleDay)
////                                {
////                                    $dataResponse[$singleRow->counts]   =   $singleRow->listing_id .' ';
////                                }
////                            }
////                        }
////                    }
////                }
////
////            }
////        }
////        if( $duration == 'monthly' )
////        {
////            $monthNo = date("m");
////            $yearNo = date("Y");
////
////            $condition = "user_id='$currentUserId' AND action_type='$type' AND MONTH(FROM_UNIXTIME(date))='$monthNo'";
////            $getRow = lp_get_data_from_db($table, '*', $condition);
////
////            $daysOfMonth = lp_get_days_of_month($monthNo, $yearNo);
////
////            if(!empty($daysOfMonth))
////            {
////                $count = 1;
////                foreach($daysOfMonth as $singleDay)
////                {
////                    if(!empty($getRow))
////                    {
////                        foreach($getRow as $singleRow)
////                        {
////                            if(isset($singleRow->date))
////                            {
////                                $singleRowDate = $singleRow->date;
////                                if($singleRowDate==$singleDay)
////                                {
////                                    $dataResponse[$singleRow->counts]   =   $singleRow->listing_id;
////                                }
////                            }
////                        }
////                    }
////                    $count++;
////                }
////            }
////        }
////        if( $duration == 'yearly' )
////        {
////            $monthNo = date("m");
////            $yearNo = date("Y");
////            $condition = "user_id='$currentUserId' AND action_type='$type' AND YEAR(FROM_UNIXTIME(date))='$yearNo'";
////            $getRow = lp_get_data_from_db($table, '*', $condition);
////            $allMonths = lp_get_all_months();
////
////            if(!empty($allMonths))
////            {
////                foreach($allMonths as $singleMonth)
////                {
////                    if(!empty($getRow))
////                    {
////                        foreach($getRow as $singleRow)
////                        {
////                            if(isset($singleRow->date))
////                            {
////                                $singleRowDate = $singleRow->date;
////                                $thisMonth = date('F', $singleRowDate);
////                                if($thisMonth==$singleMonth){
////                                    $dataResponse[$singleRow->counts]   =   $singleRow->listing_id;
////                                }
////                            }
////                        }
////                    }
////                }
////            }
////        }
////        echo '<pre>';
////        print_r( $dataResponse );
////        echo '</pre>';
////    }
//
//
//    $args   =   array(
//        'post_type' => 'listing',
//        'post_status' => 'publish',
//        'posts_per_page' => $number_posts,
//        'meta_key'  =>  'post_views_count',
//        'orderby' => 'meta_value_num'
//
//    );
//    $trending   =   new WP_Query( $args );
//    $GLOBALS['grid_col_class']  =   4;
//    $GLOBALS['trending_el']  =   true;
//    $activity_btn   =   '';
//    if( !empty( $activity_btn_text ) && !empty( $activity_btn_link ) )
//    {
//        $activity_btn   =   '<a class="element-inner-button" href="'. $activity_btn_text .'">'. $activity_btn_text .'</a>';
//    }
//
//    if( $trending->have_posts() ) :
//        $output .=  '<div class="lp-section-content-container"><div class="lp-listings">';
//        $output .=  $activity_btn;
//        $output .=  '    <div class="row listing-slider">';
//        while ( $trending->have_posts() ) : $trending->the_post();
//            ob_start();
//            get_template_part('templates/loop-grid-view');
//            $output .= ob_get_contents();
//            ob_end_clean();
//            ob_flush();
//        endwhile; wp_reset_postdata();
//        $output .=  '   </div></div>';
//        $output .=  '</div>';
//    endif;
//
//    return $output;
//}
//add_shortcode('trending_listings', 'listingpro_shortcode_trending');

/*------------------------------------------------------*/
/* LP DISCOUNTS
/*------------------------------------------------------*/
vc_map( array(
    "name"                      => __("ListingPro Discounts", "js_composer"),
    "base"                      => 'lp_discounts',
    "category"                  => __('Listingpro', 'js_composer'),
    "description"               => 'A list of all available discounts',
) );

function listingpro_shortcode_discounts($atts, $content = null) {
    extract(shortcode_atts(array(

    ), $atts));
    $output = null;

    $d_args =   array(
        'post_type' => 'listing',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_key' => 'listing_discount_data',
        'meta_compare' => 'EXISTS'
    );
    $d_listings  =   new WP_Query($d_args);
    if( $d_listings->have_posts() ) :
        $output .=  '<div class="lp-listings-discounts">';
        $output .=  '    <div class="row">';
        while ( $d_listings->have_posts() ) : $d_listings->the_post();
            global $post;
            $lid    =   get_the_ID();
            $listing_discount_data  =   get_post_meta( $post->ID, 'listing_discount_data', true );

            if( isset( $listing_discount_data ) && is_array( $listing_discount_data ) && !empty( $listing_discount_data ) ):
                $GLOBALS['listing_discount_data']  =   $listing_discount_data;
                ob_start();
                get_template_part('templates/discount-template');
                $output .= ob_get_contents();
                ob_end_clean();
                ob_flush();
            endif;
        endwhile; wp_reset_postdata();
        $output .=  '    </div>';
        $output .=  '</div>';
    endif;
    return $output;
}
add_shortcode('lp_discounts', 'listingpro_shortcode_discounts');

vc_map( array(
    "name"                      => esc_html__("ListingPro Venders Element", "js_composer"),
    "base"                      => 'listingpro_venders',
    "category"                  => esc_html__('Listingpro', 'js_composer'),
    "description"               => '',
    "params"                    => array(

        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("First Column Title","js_composer"),
            "param_name"	=> "listing_first_title",
            "value"			=> "520156",
            'save_always' => true,
        ),

        array(
            "type"			=> "textfield",
            "class"			=> "",
            "heading"		=> esc_html__("Second Column Title","js_composer"),
            "param_name"	=> "listing_second_title",
            "value"			=> "Vendors/Entertainer Hired",
            'save_always' => true,
        ),


    ),
) );
function listingpro_shortcode_venders($atts, $content = null) {
    extract(shortcode_atts(array(

        'listing_first_title'    => '520156',
        'listing_second_title'    => 'Vendors/Entertainer Hired',

    ), $atts));

    $output = null;



    $output .='
	<div class="listingpro-venderds">
		<div class="padding-top-60 padding-bottom-60">
		
			<div class="">
				
				<div class="text-center">
					<h3>'.$listing_first_title.'</h3>
					<p>'.$listing_second_title.'</p>
				</div>
			</div>
		</div>
	</div>';

    return $output;
}
add_shortcode('listingpro_venders', 'Listingpro_shortcode_venders');


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_listingpro_partners extends WPBakeryShortCodesContainer {
    }
    class WPBakeryShortCode_content_boxes extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_listingpro_partner extends WPBakeryShortCode {
    }
    class WPBakeryShortCode_content_box extends WPBakeryShortCode {
    }
}