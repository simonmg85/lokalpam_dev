<?php
if(session_id() == '') {
    session_start();
}
//session_start();

/**
 * PayPal API
 */
if ( ! class_exists('wp_PayPalAPI') ) {

    class wp_PayPalAPI {

        /**
         * Start express checkout
         */
        function StartExpressCheckout() {

            global $listingpro_options, $wp_rewrite;
			$lpURLChar = '?';
			if ($wp_rewrite->permalink_structure == ''){
				$lpURLChar = '&';
			}
            $paypal_api_environment = $listingpro_options['paypal_api'];
            $paypal_success = $listingpro_options['payment-checkout'];
            $paypal_success = get_permalink($paypal_success);
            $paypal_success .=$lpURLChar.'lpcheckstatus=success';
            $paypal_fail = $listingpro_options['payment-checkout'];
            $paypal_fail = get_permalink($paypal_fail);
            $paypal_fail .=$lpURLChar.'lpcheckstatus=fail';
            $paypal_api_username = $listingpro_options['paypal_api_username'];
            $paypal_api_password = $listingpro_options['paypal_api_password'];
            $paypal_api_signature = $listingpro_options['paypal_api_signature'];
            $currency_code = $listingpro_options['currency_paid_submission'];

            if ( $paypal_api_environment != 'sandbox' && $paypal_api_environment != 'live' )
                trigger_error('Environment does not defined! Please define it at the plugin configuration page!', E_USER_ERROR);

            /*if ( $paypal_fail === FALSE || ! is_numeric($paypal_fail) )
              trigger_error('Cancel page not defined! Please define it at the plugin configuration page!', E_USER_ERROR);

            if ( $paypal_success === FALSE || ! is_numeric($paypal_success) )
              trigger_error('Success page not defined! Please define it at the plugin configuration page!', E_USER_ERROR);*/

            global $pricetotal, $adsType,  $listing_id, $price_package, $ads_duration;

            $_SESSION['pricetotal'] = $pricetotal;
            $_SESSION['adsType'] = $adsType;
            $_SESSION['listing_id'] = $listing_id;
            $_SESSION['price_package'] = $price_package;
            $_SESSION['ads_duration'] = $ads_duration;

            $lpPayDesc = null;
            $lpPayDesc = esc_html__('listing title', 'listingpro'). ':'.get_the_title($listing_id).' ';
            $lpPayDesc .= esc_html__('price', 'listingpro').':'.$pricetotal;
            $PAYMENTREQUEST_0_DESC = $lpPayDesc;
            $AMT = $pricetotal;


            $CURRENCYCODE = $currency_code;

            /* global $wpdb;
            $result = $wpdb->get_results( "SELECT * FROM wp_url" );

            foreach ( $result as $info ) {
              $url = $info->url;
            } */
            $url = get_template_directory_uri();

            // FIELDS
            $fields = array(
                'USER' => urlencode($paypal_api_username),
                'PWD' => urlencode($paypal_api_password),
                'SIGNATURE' => urlencode($paypal_api_signature),
                'VERSION' => urlencode('72.0'),
                'PAYMENTREQUEST_0_PAYMENTACTION' => urlencode('Sale'),
                'PAYMENTREQUEST_0_AMT0' => urlencode($AMT),
                'PAYMENTREQUEST_0_CUSTOM' => urlencode($listing_id),
                'PAYMENTREQUEST_0_AMT' => urlencode($AMT),
                'PAYMENTREQUEST_0_ITEMAMT' => urlencode($AMT),
                'ITEMAMT' => urlencode($AMT),
                'PAYMENTREQUEST_0_CURRENCYCODE' => urlencode($CURRENCYCODE),
                'RETURNURL' => urlencode( $url.'/include/paypal/form-handler2.php?func=confirm'),
                'CANCELURL' => urlencode($paypal_fail),
                'METHOD' => urlencode('SetExpressCheckout'),
                'POSTID' => urlencode('postid')
            );

            $fields['PAYMENTREQUEST_0_CUSTOM'] = $listing_id;

            if ( isset($PAYMENTREQUEST_0_DESC) )
                $fields['PAYMENTREQUEST_0_DESC'] = $PAYMENTREQUEST_0_DESC;

            if ( isset($paypal_success) )
                $_SESSION['RETURN_URL'] = $paypal_success;

            if ( isset($paypal_fail) )
                $fields['CANCELURL'] = $paypal_fail;

            $fields['PAYMENTREQUEST_0_QTY0'] = 1;
            $fields['PAYMENTREQUEST_0_AMT'] = $fields['PAYMENTREQUEST_0_AMT'];


            if ( isset($_POST['TAXAMT']) ) {
                $fields['PAYMENTREQUEST_0_TAXAMT'] = $_POST['TAXAMT'];
                $fields['PAYMENTREQUEST_0_AMT'] += $_POST['TAXAMT'];
            }


            if ( isset($_POST['HANDLINGAMT']) ) {
                $fields['PAYMENTREQUEST_0_HANDLINGAMT'] = $_POST['HANDLINGAMT'];
                $fields['PAYMENTREQUEST_0_AMT'] += $_POST['HANDLINGAMT'];
            }

            if ( isset($_POST['SHIPPINGAMT']) ) {
                $fields['PAYMENTREQUEST_0_SHIPPINGAMT'] = $_POST['SHIPPINGAMT'];
                $fields['PAYMENTREQUEST_0_AMT'] += $_POST['SHIPPINGAMT'];
            }

            $fields_string = '';

            foreach ( $fields as $key => $value )
                $fields_string .= $key.'='.$value.'&';

            rtrim($fields_string,'&');

            // CURL
            $ch = curl_init();

            if ( $paypal_api_environment == 'sandbox' )
                curl_setopt($ch, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
            elseif ( $paypal_api_environment == 'live' )
                curl_setopt($ch, CURLOPT_URL, 'https://api-3t.paypal.com/nvp');

            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSLVERSION, 6); //6 is for TLSV1.2

            //execute post
            $result = curl_exec($ch);

            //close connection
            curl_close($ch);

            parse_str($result, $result);

            if ( $result['ACK'] == 'Success' ) {

                if ( $paypal_api_environment == 'sandbox' )
                    header('Location: https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token='.$result['TOKEN']);
                elseif ( $paypal_api_environment == 'live' )
                    header('Location: https://www.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token='.$result['TOKEN']);
                exit;

            } else {
                print_r($result);
            }

        }

        /**
         * Validate payment
         */
        function ConfirmExpressCheckout() {

            global $listingpro_options;
            $paypal_api_environment = $listingpro_options['paypal_api'];
            $paypal_success = $listingpro_options['payment_success'];
            $paypal_success = get_permalink($paypal_success);
            $paypal_fail = $listingpro_options['payment_fail'];
            $paypal_fail = get_permalink($paypal_fail);
            $paypal_api_username = $listingpro_options['paypal_api_username'];
            $paypal_api_password = $listingpro_options['paypal_api_password'];
            $paypal_api_signature = $listingpro_options['paypal_api_signature'];

            // FIELDS
            $fields = array(
                'USER' => urlencode($paypal_api_username),
                'PWD' => urlencode($paypal_api_password),
                'SIGNATURE' => urlencode($paypal_api_signature),
                'PAYMENTREQUEST_0_PAYMENTACTION' => urlencode('Sale'),
                'VERSION' => urlencode('72.0'),
                'TOKEN' => urlencode($_GET['token']),
                'METHOD' => urlencode('GetExpressCheckoutDetails')
            );

            $fields_string = '';
            foreach ( $fields as $key => $value )
                $fields_string .= $key.'='.$value.'&';
            rtrim($fields_string,'&');

            // CURL
            $ch = curl_init();

            if ( $paypal_api_environment == 'sandbox' )
                curl_setopt($ch, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
            elseif ( $paypal_api_environment == 'live' )
                curl_setopt($ch, CURLOPT_URL, 'https://api-3t.paypal.com/nvp');

            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSLVERSION, 6); //6 is for TLSV1.2

            //execute post
            $result = curl_exec($ch);
            //close connection
            curl_close($ch);

            parse_str($result, $result);
            $listing_id =  $result['PAYMENTREQUEST_0_CUSTOM'];
            if ( $result['ACK'] == 'Success' ) {
                //wp_PayPalAPI::SavePayment($result, 'pending');
                $var = new wp_PayPalAPI();
                $var->SavePayment($result, 'pending');
                $var->DoExpressCheckout($result,$listing_id);
                //wp_PayPalAPI::DoExpressCheckout($result);

            } else {
                $var = new wp_PayPalAPI();
                $var->SavePayment($result, 'failed');
                //wp_PayPalAPI::SavePayment($result, 'failed');
            }
        }

        /**
         * Close transaction
         */
        function DoExpressCheckout($result,$listing_id) {

            global $listingpro_options;
            $paypal_api_environment = $listingpro_options['paypal_api'];
            $paypal_success = $listingpro_options['payment_success'];
            $paypal_success = get_permalink($paypal_success);
            $paypal_fail = $listingpro_options['payment_fail'];
            $paypal_fail = get_permalink($paypal_fail);
            $paypal_api_username = $listingpro_options['paypal_api_username'];
            $paypal_api_password = $listingpro_options['paypal_api_password'];
            $paypal_api_signature = $listingpro_options['paypal_api_signature'];

            // FIELDS
            $fields = array(
                'USER' => urlencode($paypal_api_username),
                'PWD' => urlencode($paypal_api_password),
                'SIGNATURE' => urlencode($paypal_api_signature),
                'VERSION' => urlencode('72.0'),
                'PAYMENTREQUEST_0_PAYMENTACTION' => urlencode('Sale'),
                'PAYERID' => urlencode($result['PAYERID']),
                'TOKEN' => urlencode($result['TOKEN']),
                'PAYMENTREQUEST_0_AMT' => urlencode($result['AMT']),
                'PAYMENTREQUEST_0_CURRENCYCODE' => urlencode($result['CURRENCYCODE']),
                'METHOD' => urlencode('DoExpressCheckoutPayment')
            );

            $fields_string = '';
            foreach ( $fields as $key => $value)
                $fields_string .= $key.'='.$value.'&';
            rtrim($fields_string,'&');

            // CURL
            $ch = curl_init();

            if ( $paypal_api_environment == 'sandbox' )
                curl_setopt($ch, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
            elseif ( $paypal_api_environment == 'live' )
                curl_setopt($ch, CURLOPT_URL, 'https://api-3t.paypal.com/nvp');

            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSLVERSION, 6); //6 is for TLSV1.2

            //execute post
            $result = curl_exec($ch);
            //close connection
            curl_close($ch);

            parse_str($result, $result);
            if ( $result['ACK'] == 'Success' ) {
                wp_PayPalAPI::UpdatePayment($result, 'success',$listing_id);
            } else {
                wp_PayPalAPI::UpdatePayment($result, 'failed',$listing_id);
            }
        }

        /**
         * Save payment result into database
         */
        function SavePayment($result, $status) {
            global $wpdb;
            $dbprefix = $wpdb->prefix;

        }

        /**
         * Update payment
         */
        function UpdatePayment($result, $status,$listing_id) {
            if($status=="success"){

                global $wpdb,$listingpro_options;
                $dbprefix = $wpdb->prefix;
                $pricetotal = $_SESSION['pricetotal'];
                $adsType = $_SESSION['adsType'];
                //$listing_id  =  $_SESSION['listing_id'];
                $price_package  =  $_SESSION['price_package'];
                $ads_duration = $_SESSION['ads_duration'];


                $currentdate = date("d-m-Y");
                $exprityDate = date('Y-m-d', strtotime($currentdate. ' + '.$ads_durations.' days'));
                $exprityDate = date('d-m-Y', strtotime( $exprityDate ));


                $my_post = array(
                    'post_title'    => $listing_id,
                    'post_status'   => 'publish',
                    'post_type' => 'lp-ads',
                );
                $adID = wp_insert_post( $my_post );

                if($adsType=="byduration"){}else{
                    //cpc
                    listing_set_metabox('remaining_balance', $pricetotal, $adID);
                }
				listing_set_metabox('duration', $ads_duration, $adID);
				listing_set_metabox('budget', $pricetotal, $adID);
                listing_set_metabox('ads_mode', $adsType, $adID);
                listing_set_metabox('ads_listing', $listing_id, $adID);

                listing_set_metabox('ad_status', 'Active', $adID);
                listing_set_metabox('ad_date', '', $adID);
                listing_set_metabox('ad_expiryDate', '', $adID);

                listing_set_metabox('campaign_id', $adID, $listing_id);
                update_post_meta( $listing_id, 'campaign_status', 'active' );



                if( !empty($price_package) ){
                    foreach( $price_package as $val ){
                        update_post_meta( $listing_id, $val, 'active' );
                    }
                }

                if( !empty($price_package) ){
                    listing_set_metabox('ad_type', $price_package, $adID);
                }

                $tID = $result['PAYMENTINFO_0_TRANSACTIONID'];
                $token = $result['TOKEN'];
                $payment_method = 'paypal';

                lp_save_campaign_data($adID, $tID, $payment_method, $token, $status, $pricetotal, $pricetotal, $listing_id, $adsType, $ads_duration,$pricetotal);


            }

        }



    }
}