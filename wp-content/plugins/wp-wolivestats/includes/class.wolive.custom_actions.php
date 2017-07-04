<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Wolive_custom_actions {
        
        protected static $_instance = null;
        private $hooks =  null;


        public function __construct() {
                $this->initHooks();
        }
	private function initHooks () {

	    if (WL() -> is_enable_tracking() )
                add_action ("wolive_init", array ($this, "registerEvents"));
        }

        private function includes () {
        }

        private function initVars() {
                
        }

	public function registerEvents () {

                WL()->addActionType(array (
                        "name" => "login",
                        "title"=> "user login"
		    ));

                WL()->addActionType(array (
                        "name" => "logout",
                        "title"=> "logout"
                ));



                 $this->hooks =  array();
                $this->hooks[]= array ( 
                        "hook" => "wp_login", 
                        "method" =>array($this, "wp_login") ,
                        "type" => "action" 
		    );

                $this->hooks[]= array ( 
                        "hook" => "wp_logout", 
                        "method" =>array($this, "wp_logout") ,
                        "type" => "action" 
                );

		
                $this->registerHooks(); 
	}

        public function registerHooks () {
                foreach ($this->hooks as $hook) {
                    if ($hook["type"] == "action" ) {
                        if ($hook["hook"] == "wp_login") 
                            add_action($hook["hook"],  $hook["method"],10,2);
                        else 
                            add_action($hook["hook"],  $hook["method"]);
                    }
               }
        }
        
        public static function instance() {
                if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
                }
		return self::$_instance;
	}

        public function wp_login($user_login, $user) {
            $user =  get_user_by("slug", $user_login);
            if ( in_array( 'customer', (array) $user->roles ) ) {
                $data = array();
                $data["id"] = $user->ID;                
                WL()->addAction("login", $data);

                WL()->updateIdSession($user->ID);
            }
	}

	public function wp_logout() {
	    $user = wp_get_current_user(); 
            if ( in_array( 'customer', (array) $user->roles ) ) {
                $data = array();
                $data["id"] = 0;                
                WL()->addAction("logout", $data);
            }
	}


}


function WL_ACTIONS () {
        return Wolive_custom_actions::instance();
}


$GLOBALS['wolive_actions'] = WL_ACTIONS();
