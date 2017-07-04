<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wolive_session extends Wolive_Session_Handler {

        #public $ajax_nonce;
        
        private $dbctrl = null;
        private $cookie;

        public function __construct() {
                #$this->ajax_nonce = wp_create_nonce( WOLIVE_NONCE );
                $this->dbctrl = new Wolive_database();
                $this->cookie = "wolive";

                parent::__construct();
        }


        private static function  addSession() {

                if (!$this->_has_cookie) {
                        
                
                }
        }


        // function to registerAction

        public static function __callStatic($name, $arguments)
        {

        }
}

