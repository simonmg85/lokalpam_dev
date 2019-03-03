<?php
require_once(ABSPATH . 'wp-admin/includes/screen.php');
//form submit
if( !empty($_POST['payment_submitt']) && isset($_POST['payment_submitt']) ){

    global $wpdb;
    $dbprefix = '';
    $dbprefix = $wpdb->prefix;
    $table_name = $dbprefix.'listing_orders';
    $order_id = '';
    $results = '';
    $order_id = $_POST['order_id'];
    $date = date('d-m-Y');
    $update_data = array('date' => $date, 'status' => 'success', 'used' => '1');
    $where = array('order_id' => $order_id);
    $update_format = array('%s', '%s');
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
        $wpdb->update($dbprefix.'listing_orders', $update_data, $where, $update_format);
    }

    $postid= $_POST['post_id'];
    $my_post;
    $listing_status = get_post_status( $postid );
    if($listingpro_options['listings_admin_approved']=="no" || $listing_status=="publish"){
        $my_post = array(
            'ID'           => $postid,
            'post_date'  => date("Y-m-d H:i:s"),
            'post_status'   => 'publish',
        );
    }
    else{
        $my_post = array(
            'ID'           => $postid,
            'post_date'  => date("Y-m-d H:i:s"),
            'post_status'   => 'pending',
        );
    }
    wp_update_post( $my_post );
    $ex_plan_id = listing_get_metabox_by_ID('Plan_id', $postid);
    $new_plan_id = listing_get_metabox_by_ID('changed_planid', $postid);
    if(!empty($new_plan_id)){
        if( $ex_plan_id != $new_plan_id ){
            lp_cancel_stripe_subscription($postid, $ex_plan_id);
            listing_set_metabox('Plan_id',$new_plan_id, $postid);
            listing_set_metabox('changed_planid','', $postid);
        }
    }

    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
        $thepost = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$dbprefix."listing_orders WHERE post_id = %d", $postid ) );
    }

    $post_author_id = get_post_field( 'post_author', $postid );
    $user = get_user_by( 'id', $post_author_id );
    $useremail = $user->user_email;
    $user_name = $user->user_login;

    $admin_email = '';
    $admin_email = get_option( 'admin_email' );

    $listing_id = $postid;
    $listing_title = get_the_title($postid);
    $invoice_no = $thepost->order_id;
    $payment_method = $thepost->payment_method;

    $plan_title = $thepost->plan_name;
    $plan_price = $thepost->price.$thepost->currency;
    $listing_url = get_the_permalink($listing_id);


    //to admin
    $mail_subject = $listingpro_options['listingpro_subject_purchase_activated_admin'];
    $website_url = site_url();
    $website_name = get_option('blogname');

    $formated_mail_subject = lp_sprintf2("$mail_subject", array(
        'website_url' => "$website_url",
        'website_name' => "$website_name",
        'user_name' => "$user_name",
    ));

    $mail_content = $listingpro_options['listingpro_content_purchase_activated_admin'];

    $formated_mail_content = lp_sprintf2("$mail_content", array(
        'website_url' => "$website_url",
        'listing_title' => "$listing_title",
        'plan_title' => "$plan_title",
        'plan_price' => "$plan_price",
        'listing_url' => "$listing_url",
        'invoice_no' => "$invoice_no",
        'website_name' => "$website_name",
        'payment_method' => "$payment_method",
        'user_name' => "$user_name",
    ));


    $headers1[] = 'Content-Type: text/html; charset=UTF-8';
    wp_mail( $admin_email, $formated_mail_subject, $formated_mail_content, $headers1);
    // to user

    $mail_subject2 = $listingpro_options['listingpro_subject_purchase_activated'];
    $website_url = site_url();

    $formated_mail_subject2 = lp_sprintf2("$mail_subject2", array(
        'website_url' => "$website_url",
        'website_name' => "$website_name",
        'user_name' => "$user_name",
    ));

    $mail_content2 = $listingpro_options['listingpro_content_purchase_activated'];
    $formated_mail_content2 = lp_sprintf2("$mail_content2", array(
        'website_url' => "$website_url",
        'listing_title' => "$listing_title",
        'plan_title' => "$plan_title",
        'plan_price' => "$plan_price",
        'listing_url' => "$listing_url",
        'invoice_no' => "$invoice_no",
        'website_name' => "$website_name",
        'payment_method' => "$payment_method",
        'user_name' => "$user_name",
    ));

    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    wp_mail( $useremail, $formated_mail_subject2, $formated_mail_content2, $headers);

}


/* --------------------delete invoice data------------------- */
if( isset($_POST['delete_invoice']) && !empty($_POST['delete_invoice']) ){

    $main_id = $_POST['main_id'];
    if( !empty($main_id) ){
        $table = 'listing_orders';
        $where = array('main_id'=>$main_id);
        lp_delete_data_in_db($table, $where);

    }

}

/*---------------------------------------------------
				adding invoice page
----------------------------------------------------*/

function listingpro_register_invocies_page() {
    add_menu_page(
        __( 'Listings Invoices', 'listingpro-plugin' ),
        'Invoices',
        'manage_options',
        'lp-listings-invoices',
        'listingpro_invoices_page',
        plugins_url( 'listingpro-plugin/images/invoices.png' ),
        30
    );
    wp_enqueue_style("panel_style", WP_PLUGIN_URL."/listingpro-plugin/assets/css/custom-admin-pages.css", false, "1.0", "all");

}
add_action( 'admin_menu', 'listingpro_register_invocies_page' );

if(!function_exists('listingpro_invoices_page')){
    function listingpro_invoices_page(){
        //adding css

        wp_enqueue_style('bootstrapcss', get_template_directory_uri() . '/assets/lib/bootstrap/css/bootstrap.min.css');
        wp_enqueue_script('bootstrapadmin', get_template_directory_uri() . '/assets/lib/bootstrap/js/bootstrap.min.js', 'jquery', '', true);
        global $wpdb;
        $dbprefix = '';
        $dbprefix = $wpdb->prefix;
        $table_name = $dbprefix.'listing_orders';
        ?>
        <div class="wrap listingpro-coupons">
            <h1 class="wp-heading-inline"><?php esc_html_e('Listings Invoices', 'listingpro-plugin');  ?></h1>


            <div class="clearfix"></div>
            <ul class="subsubsub lpbackendtabs">
                <li class="all current" data-tab="tab-1"><a><?php echo esc_html__('All', 'listingpro-plugin'); ?> <span class="count"></span></a> |</li>
                <li class="publish" data-tab="tab-2"><a>Success <span class="count"></span></a> |</li>
                <li class="pending" data-tab="tab-3"><a><?php echo esc_html__('Pending', 'listingpro-plugin'); ?> <span class="count"></span></a> |</li>
                <li class="failed" data-tab="tab-4"><a><?php echo esc_html__('Failed', 'listingpro-plugin'); ?> <span class="count"></span></a></li>
            </ul>

            <form id="posts-filter" method="get">

                <div class="tablenav top">

                    <div class="alignleft actions bulkactions lp_backend_inv_filter">
                        <label for="bulk-action-selector-top" class="screen-reader-text"><?php echo esc_html__('All Types', 'listingpro-plugin'); ?></label>
                        <select class="lp_invoiceInput">
                            <option value="">
                                <?php echo esc_html__('All Methods', 'listingpro-plugin'); ?>
                            </option>

                            <option value="paypal">
                                <?php echo esc_html__('Paypal', 'listingpro-plugin'); ?>
                            </option>

                            <option value="stripe">
                                <?php echo esc_html__('Stripe', 'listingpro-plugin'); ?>
                            </option>

                            <option value="2checkout">
                                <?php echo esc_html__('2 Checkout', 'listingpro-plugin'); ?>
                            </option>

                            <option value="wire">
                                <?php echo esc_html__('Wire', 'listingpro-plugin'); ?>
                            </option>

                        </select>

                    </div>

                    <div class="alignleft actions bulkactions lp_backend_inv_filter">
                        <label for="bulk-action-selector-top" class="screen-reader-text"><?php echo esc_html__('All Status', 'listingpro-plugin'); ?></label>
                        <select  class="lp_invoiceStatusInput" id="bulk-action-selector-top">
                            <option value="">
                                <?php echo esc_html__('All Status', 'listingpro-plugin'); ?>
                            </option>

                            <option value="success">
                                <?php echo esc_html__('Success', 'listingpro-plugin'); ?>
                            </option>

                            <option value="in progress">
                                <?php echo esc_html__('Pending', 'listingpro-plugin'); ?>
                            </option>

                            <option value="failed">
                                <?php echo esc_html__('Failed', 'listingpro-plugin'); ?>
                            </option>
                        </select>

                    </div>
                    <div class="alignright">
                        <p class="search-box">
                            <input type="search" id="lp_invoiceInput" onkeyup="lpSearchDataInInvoice()" class="button" placeholder="<?php echo esc_html__('Search Invoices', 'listingpro-plugin'); ?>">
                        </p>
                    </div>

                    <br class="clear">
                </div>


                <div class="listingpro_coupon_table">
                    <!--all -->
                    <div id="tab-1" class="lp-backendtabs-content current">
                        <?php
                        include_once 'templates/invoice_temp/all.php';
                        ?>

                    </div>

                    <!--success -->
                    <div id="tab-2" class="lp-backendtabs-content">
                        <?php
                        include_once 'templates/invoice_temp/success.php';
                        ?>
                    </div>


                    <!--pending -->
                    <div id="tab-3" class="lp-backendtabs-content">
                        <?php
                        include_once 'templates/invoice_temp/pending.php';
                        ?>
                    </div>

                    <!--failed -->
                    <div id="tab-4" class="lp-backendtabs-content">
                        <?php
                        include_once 'templates/invoice_temp/failed.php';
                        ?>
                    </div>

                </div>

            </form>



        </div>

        <!--search-->
        <script>
            function lpSearchDataInInvoice() {
                var input, filter, table, tr, td, i;
                input = document.getElementById("lp_invoiceInput");
                filter = input.value.toUpperCase();
                table = document.getElementsByClassName("wp-list-table");
                for (j = 0; j < table.length; j++) {
                    tr = table[j].getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            }



        </script>



        <!--endsearch-->
        <?php
    }
}
?>