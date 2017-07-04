<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wolive_ajax {

        public $ajax_nonce;

        public function __construct($nonce) {
                $self->ajax_nonce = $none;
        }

        public static function addFrontEndScripts () {
                if (!is_preview()) {
                        wp_enqueue_script( 'woliveFrontEnd',  plugins_url("/assets/js/frontend.js",WOLIVE__PLUGIN_FILE), array( 'jquery' ) );

                        $page = Wolive::getPageData();

                        if (is_array($page)) {
                        $data  = array();
                        
                        //$data["original_url "] = $data_["original_url"];
                        $data["url"] = $page["original_url"];
                        $data["ajax_url"] =  admin_url( 'admin-ajax.php' );
                        
                        $page_encoded = base64_encode( serialize($page));
                        $data["dp"] = wolive::checkSum($page_encoded);
                        
                        wp_localize_script( 'woliveFrontEnd', 'wo_front_end', $data );

                        }
                }
        }
}


