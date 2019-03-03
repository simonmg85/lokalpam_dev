<?php
add_action('init', 'create_post_type_claims');

function create_post_type_claims()
{
    $labels = array(
        'name' => _x('Claims', 'post type general name', 'listingpro-plugin'),
        'singular_name' => _x('Claim', 'post type singular name', 'listingpro-plugin'),
        'menu_name' => _x('Claims', 'admin menu', 'listingpro-plugin'),
        'name_admin_bar' => _x('Claim', 'add new on admin bar', 'listingpro-plugin'),
        'add_new' => _x('Add New', 'review', 'listingpro-plugin'),
        'add_new_item' => __('Add New Claim', 'listingpro-plugin'),
        'new_item' => __('New Claim', 'listingpro-plugin'),
        'edit_item' => __('Edit Claim', 'listingpro-plugin'),
        'view_item' => __('View Claim', 'listingpro-plugin'),
        'all_items' => __('All Claims', 'listingpro-plugin'),
        'search_items' => __('Search Claims', 'listingpro-plugin'),
        'parent_item_colon' => __('Parent Claims:', 'listingpro-plugin'),
        'not_found' => __('No reviews found.', 'listingpro-plugin'),
        'not_found_in_trash' => __('No reviews found in Trash.', 'listingpro-plugin')
    );
    
    $args = array(
        'labels' => $labels,
        'menu_icon' => 'dashicons-testimonial',
        'description' => __('Description.', 'listingpro-plugin'),
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'lp-claims'
        ),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => true,
        'menu_position' => 30,
        'supports' => array(
            'title'
        )
    );
    
    register_post_type('lp-claims', $args);
}

/**
 */
/* updates by zaheer on 25 feb */
function save_lp_claims_meta($post_id)
{
    global $listingpro_options;
    $c_mail_subject = $listingpro_options['listingpro_subject_listing_claim_approve'];
    $c_mail_body    = $listingpro_options['listingpro_content_listing_claim_approve'];
    
    $a_mail_subject = $listingpro_options['listingpro_subject_listing_claim_approve_old_owner'];
    $a_mail_body    = $listingpro_options['listingpro_content_listing_claim_approve_old_owner'];
    
    $admin_email   = '';
    $admin_email   = get_option('admin_email');
    $website_url   = site_url();
    $website_name  = get_option('blogname');
    $listing_title =  '';
    $listing_url   = '';
    $headers[]     = 'Content-Type: text/html; charset=UTF-8';
    
    
    
    $post_id   = $post_id;
    $post_type = get_post_type($post_id);
    
    if ("lp-claims" != $post_type)
        return;
    
    
    if (!empty($_POST['claimer']) && isset($_POST['claimer'])) {
        $new_author   = $_POST['claimer'];
        $claim_status = $_POST['claim_status'];
        $claimed_post = $_POST['claimed_listing'];
        if (empty($claimed_post)) {
            $claimed_post = listing_get_metabox_by_ID('claimed_listing', $post_id);
        }
        $listing_title    = get_the_title($claimed_post);
        $listing_url      = get_the_permalink($claimed_post);
        /* ====for claimer=== */
		
		$usermeta         = get_user_by('id', $new_author);
        $new_author_name  = $usermeta->user_login;
        $new_author_email = $usermeta->user_email;
		$user_name = $usermeta->user_login;

		$c_mail_subject_a = lp_sprintf2("$c_mail_subject", array(
			'website_url' => "$website_url",
			'listing_title' => "$listing_title",
			'listing_url' => "$listing_url",
			'website_name' => "$website_name",
			'user_name' => "$user_name",
		));
		
		$c_mail_body_a = lp_sprintf2("$c_mail_body", array(
			'website_url' => "$website_url",
			'listing_title' => "$listing_title",
			'listing_url' => "$listing_url",
			'website_name' => "$website_name",
			'user_name' => "$user_name",
		));
		
		
		$c_mail_body_a = lp_sprintf2("$c_mail_body", array(
			'website_url' => "$website_url",
			'listing_title' => "$listing_title",
			'listing_url' => "$listing_url",
			'website_name' => "$website_name",
			'user_name' => "$user_name",
		));
		
		
		
		$a_mail_subject_a = lp_sprintf2("$a_mail_subject", array(
			'website_url' => "$website_url",
			'listing_title' => "$listing_title",
			'listing_url' => "$listing_url",
			'website_name' => "$website_name",
			'user_name' => "$user_name",
		));
		
        
		
		$a_mail_body_a = lp_sprintf2("$a_mail_body", array(
			'website_url' => "$website_url",
			'listing_title' => "$listing_title",
			'listing_url' => "$listing_url",
			'website_name' => "$website_name",
			'user_name' => "$user_name",
		));
        
        $usermeta         = get_user_by('id', $new_author);
        $new_author_name  = $usermeta->user_login;
        $new_author_email = $usermeta->user_email;
        
        
        
        if (!empty($claim_status) && $claim_status == "approved") {
            
            $listing_author   = get_post_field('post_author', $claimed_post);
            $oldusermeta      = get_user_by('id', $listing_author);
            $old_author_email = $oldusermeta->user_email;
            
            listing_set_metabox('claimed_section', 'claimed', $claimed_post);
            listing_set_metabox('owner', $new_author, $post_id);
            
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            wp_mail($new_author_email, $c_mail_subject_a, $c_mail_body_a, $headers);
            
            wp_mail($old_author_email, $a_mail_subject_a, $a_mail_body_a, $headers);
			
            
            global $wpdb;
            $prefix = $wpdb->prefix;
            
            $update_data   = array(
                'post_author' => $new_author
            );
            $where         = array(
                'ID' => $claimed_post
            );
            $update_format = array(
                '%s'
            );
            $wpdb->update($prefix . 'posts', $update_data, $where, $update_format);
			
			/* updte data is listing order db */
			$orderTable = 'listing_orders';
			lp_change_listinguser_in_db($new_author, $claimed_post, $orderTable);
            
            listing_set_metabox('claimed_listing', $claimed_post, $post_id);
            
        } else if (!empty($claim_status) && $claim_status == "pending") {
            global $wpdb;
            $prefix = $wpdb->prefix;
            
            $update_data   = array(
                'post_author' => '1'
            );
            $where         = array(
                'ID' => $claimed_post
            );
            $update_format = array(
                '%s'
            );
            $wpdb->update($prefix . 'posts', $update_data, $where, $update_format);
           listing_set_metabox('claimed_section', '', $claimed_post);
        } else {
            listing_set_metabox('claimed_section', '', $claimed_post);
            return;
        }
        
        
    }
    
}
add_action('save_post', 'save_lp_claims_meta');

/* ============== ListingPro Custom post type columns ============ */

if (!function_exists('lp_claims_columns')) {
    function lp_claims_columns($columns)
    {
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => esc_html__('Title', 'listingpro-plugin'),
            'author' => esc_html__('Author', 'listingpro-plugin'),
            'status' => esc_html__('Status', 'listingpro-plugin'),
            'date' => esc_html__('Date', 'listingpro-plugin')
        );
    }
    add_filter('manage_lp-claims_posts_columns', 'lp_claims_columns');
}
/* ============== content for custom column ======================*/

if (!function_exists('listingpro_claims_columns_content')) {
    function listingpro_claims_columns_content($column_name, $post_ID)
    {
        
        if ($column_name == 'status') {
            $metabox = get_post_meta($post_ID, 'lp_' . strtolower(THEMENAME) . '_options', true);
            echo $metabox['claim_status'];
        }
        
    }
    add_action('manage_lp-claims_posts_custom_column', 'listingpro_claims_columns_content', 10, 2);
}

/* ============== change user id in db when change listing claim ======================*/

if(!function_exists('lp_change_listinguser_in_db')){
	
	function lp_change_listinguser_in_db($userID, $listingID, $table){
		//$table = 'listing_orders';
		$data = array('user_id'=>$userID);
		$where = array('post_id'=>$listingID);
		lp_update_data_in_db($table, $data, $where);
		
	}
}