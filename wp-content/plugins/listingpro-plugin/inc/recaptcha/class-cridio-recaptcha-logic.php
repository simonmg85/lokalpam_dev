<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class cridio_Recaptcha_Logic
 */
class cridio_Recaptcha_Logic {
    /**
     * Checks if reCAPTCHA is enabled
     
     */
    public static function is_recaptcha_enabled() {
		global $listingpro_options;
		$site_key = $listingpro_options['lp_recaptcha_site_key'];
		$secret_key = $listingpro_options['lp_recaptcha_secret_key'];

        if ( ! empty( $site_key ) && ! empty( $secret_key ) ) {
            return true;
        }

        return false;
    }

    /**
     * Checks if reCAPTCHA is valid
      */
    public static function is_recaptcha_valid( $recaptcha_response ) {
		global $listingpro_options;
		$secret_key = $listingpro_options['lp_recaptcha_secret_key'];
        $url = CRIDIO_RECAPTCHA_URL . '?secret=' . $secret_key . '&response=' . $recaptcha_response;

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );

        $output = curl_exec( $ch );
        $result = json_decode( $output, true );
		if ( array_key_exists( 'success', $result ) && 1 == $result['success'] ) {
			return true;
		}

        return false;
    }
}