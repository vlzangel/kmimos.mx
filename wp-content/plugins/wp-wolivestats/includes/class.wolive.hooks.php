<?php

/**


 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Wolive_hooks {

        private  $hooks_stats =  array();

        private $session;

        
        public function __construct() {

        
        }


        public  function registersHooks() {
                if (Wolive::is_request("admin")) {
                        $this->pluginHooks();
                }
                
                if (Wolive::is_request("frontend")){ // If user
                        $this->addActionsStats();
                        $this->doHooks4stats();
                }
        }
        public function setSession($session) {
                $this->session = $session;
        }

        public function pluginHooks () {
                add_action( 'plugins_loaded', array("Wolive_database", "update_db_check") );
        }

        public  function addActionsStats() {
                //$this->hooks_stats[]= array ( "hook" => "woocommerce_add_to_cart", "method" =>array($this->session, "woocommerce_add_to_cart") );
                //$this->hooks_stats[]= array ( "hook" => "wp_login", "method" =>array($this->session, "wp_login") );
                //$this->hooks_stats[]= array ( "hook" => "wp_enqueue_scripts", "method" =>array("Wolive_ajax", "addFrontEndScripts") );
                //$this->hooks_stats[]= array ( "hook" => "wp_ajax_wostats", "method" =>array("Wolive_session", "ajaxFrontEnd") );
                //$this->hooks_stats[]= array ( "hook" => "wp_ajax_nopriv_wostats", "method" =>array("Wolive_session", "ajaxFrontEnd") );
        }

        
        public function doHooks4stats () {       
                foreach ($this->hooks_stats as $hook) {
                       add_action($hook["hook"],  $hook["method"]);
               }
        }

        public static function woocommerce_cart_item_removed ($product_id) {
            
        }

}

