<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class cridio_Recaptcha_Scripts
 */
class cridio_Recaptcha_Scripts {
    /**
     * Initialize scripts
     */
    public static function init() {
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend' ) );
        add_filter( 'cridio_asynchronous_scripts', array( __CLASS__, 'asynchronous_scripts' ) );
    }

    /**
     * Adds JavaScript files to load asynchronously using async defer attributes
     */
    public static function asynchronous_scripts( $handles ) {
        $handles[] = 'recaptcha';
        $handles[] = 'cridio-recaptcha';
        return $handles;
    }

    /**
     * Loads frontend files
     */
    public static function enqueue_frontend() {
        if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) {
            wp_enqueue_script( 'cridio-recaptcha', plugins_url( '/listingpro-plugin/assets/js/recaptcha.js' ), array(), true, true );
            wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit', array(), true, false );
        }
    }
}

cridio_Recaptcha_Scripts::init();