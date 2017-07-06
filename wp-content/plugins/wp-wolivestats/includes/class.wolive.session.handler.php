<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.geolocation.php');

class Wolive_Session_Handler {

    private $_cookie;

    private $_session_expiring;

    private $_session_expiration;

    private $_timestamp;

    private $_has_cookie = false;

    private $_table;

    public $_customer_id;

    protected $_data = array();
    
    protected $_data_extra = array();


    // MetaData
    //

    public $_ip;
    protected $_user_id= null;
    protected $_country;
    protected $_browser;
    protected $_platform;
    protected $_language;
    protected $_user_agent;
    protected $_s_width;
    protected $_s_height;


    public function __construct() {



        global $wpdb;

        $this->_cookie = 'wp_wolive_' . COOKIEHASH;
        $this->_table  = $wpdb->prefix .WOLIVE_TBL_SESSION;

        if ( $cookie = $this->get_session_cookie() ) {
            $this->_customer_id        = $cookie[0];
            $this->_session_expiration = $cookie[1];
            $this->_session_expiring   = $cookie[2];
            $this->_has_cookie         = true;

            // Update session if its close to expiring
            if ( time() > $this->_session_expiring ) {
                $this->set_session_expiration();
                $this->update_session_timestamp( $this->_customer_id, $this->_session_expiration );
            }

            $this->_ip = Wolive_Geolocation::get_ip_address();
            
            if (empty($this->_ip)) {
                    $this->_ip = Wolive_Geolocation::get_external_ip_address();
            }


        } else {
		
	    $this->_customer_id = "NONE";    

            $this->set_session_expiration();
        }

        //$this->_data = $this->get_session_data();
        
        // Actions
        //add_action( 'wp_logout', array( $this, 'destroy_session' ));


    }

    public function set_customer_session_cookie( $set ) {
        if ( $set ) {
            // Set/renew our cookie
            $to_hash           = $this->_customer_id . '|' . $this->_session_expiration;
            $cookie_hash       = hash_hmac( 'md5', $to_hash, wp_hash( $to_hash ) );
            $cookie_value      = $this->_customer_id . '||' . $this->_session_expiration . '||' . $this->_session_expiring . '||' . $cookie_hash;
            $this->_has_cookie = true;

            // Set the cookie
            $this->wolive_setcookie($this->_cookie, $cookie_value, $this->_session_expiration);
            
        }
    }

    function wolive_setcookie( $name, $value, $expire = 0, $secure = false ) {
    if ( ! headers_sent() ) {
        setcookie( $name, $value, $expire, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, $secure);
    } elseif ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        headers_sent( $file, $line );
        trigger_error( "{$name} cookie cannot be set - headers already sent by {$file} on line {$line}", E_USER_NOTICE );
    }
}

    public function has_session() {
        return isset( $_COOKIE[ $this->_cookie ] ) || $this->_has_cookie;
    }

    public function set_session_expiration() {
        $this->_session_expiring   = time() + intval( apply_filters( 'wolive_session_expiring', 60 * 60 * 24*5 ) ); // 47 Hours.
        $this->_session_expiration = time() + intval( apply_filters( 'wolive_session_expiration', 60 * 60 * 24*5 ) ); // 48 Hours.
    }

    public function generate_customer_id () {
        if ( is_user_logged_in() ) {
            return get_current_user_id();
        } else {
            require_once( ABSPATH . 'wp-includes/class-phpass.php');
            $hasher = new PasswordHash( 8, false );
            return md5( $hasher->get_random_bytes( 32 ) );
        }


    }

    public function get_session_id() {
	    
         if (!$this->has_session() ) {
                    $this->save_data();
                    $this->set_customer_session_cookie(true);
	    } else {
		
	    }

            return $this->_customer_id;
    }

    public function get_session_cookie() {
        if ( empty( $_COOKIE[ $this->_cookie ] ) || ! is_string( $_COOKIE[ $this->_cookie ] ) ) {
            return false;
        }
        
        list( $customer_id, $session_expiration, $session_expiring, $cookie_hash ) = explode( '||', $_COOKIE[ $this->_cookie ] );
        $to_hash = $customer_id . '|' . $session_expiration;
        $hash    = hash_hmac( 'md5', $to_hash, wp_hash( $to_hash ) );
        if ( empty( $cookie_hash ) || ! hash_equals( $hash, $cookie_hash ) ) {
            return false;
        }
        return array( $customer_id, $session_expiration, $session_expiring, $cookie_hash );
    }

    public function get_session_data() {
        return $this->has_session() ? (array) $this->get_session( $this->_customer_id, array() ) : array();
    }


    public function save_data() {

        if ( !$this->has_session() ) {
                global $wpdb;


            $data =  null;
            if (!empty($this->_data) ) {
                $data = maybe_serialize( $this->_data );
            }

            // navegadores
            
            $this->set_metadata();

            $wpdb->insert(
                $this->_table,
                array(
                    'session_value' => $data ,
                    'session_expiry' => $this->_session_expiration,
                    'ip' => $this->_ip,
                    'country' => $this->_country,
                    'browser' => $this->_browser,
                    'platform' => $this->_platform,
                    'language' => $this->_language,
                    'user_agent' => $this->_user_agent,
                    's_width' => $this->_s_width,
                    's_height' => $this->_s_height,
                    'timestamp' => $this->_timestamp,
                ),
                array(
                    '%s',
                    '%s',
		    '%s',
		    '%s',

                )
	);
	    
	    $this->_customer_id = $wpdb->insert_id;

            wp_cache_set( WOLIVE_CACHE_SESSION. $this->_customer_id, $this->_data, WOLIVE_SESSION_CACHE_GROUP, $this->_session_expiration - time() );
            $this->_dirty = false;
        }
        
    }


    public function set_metadata () {



            $this->_ip = Wolive_Geolocation::get_ip_address();

            if (empty($this->_ip)) {
                $this->_ip = Wolive_Geolocation::get_external_ip_address();
            }

            // Country
            $country = Wolive_Geolocation::geolocate_ip($this->_ip);
            $this->_country=$country["country"];

            
            // Browser and Stuff
            require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.user.agent.php');
            $this->_user_agent =  Wolive_User_Agent::get_ua();

            $browser = Wolive_User_Agent::get_browser($this->_user_agent);
            $this->_browser =$browser["browser"]; 
            $this->_platform =$browser["platform"]; 
            $this->_language = Wolive_User_Agent::get_language();

            // Screen
            @$this->_s_width= $_POST["sw"];
            @$this->_s_height= $_POST["sh"];

            //Timestamp
            //
            $this->_timestamp = date_i18n( 'U' );


    }

    public function save_data_item ($key, $value) {
            $this->_data_extra[$key] = $value; 
            $this->wolive_setcookie("wolive_extra_data",  json_encode($this->_data_extra), $this->_session_expiration);

    }
        
    public function destroy_session() {
        // Clear cookie
        //wc_setcookie( $this->_cookie, '', time() - YEAR_IN_SECONDS, apply_filters( 'wc_session_use_secure_cookie', false ) );
 
        $this->delete_session( $this->_customer_id );

        // Clear data
        $this->_data        = array();
        $this->_dirty       = false;
        $this->_customer_id = $this->generate_customer_id();
    }

    public function nonce_user_logged_out( $uid ) {
        return $this->has_session() && $this->_customer_id ? $this->_customer_id : $uid;
    }


    public function get_session( $customer_id, $default = false ) {
        global $wpdb;

                
        return null;
        /*
        // Try get it from the cache, it will return false if not present or if object cache not in use
        $value = wp_cache_get( WOLIVE_CACHE_SESSION . $customer_id, WOLIVE_SESSION_CACHE_GROUP);

        if ( false === $value ) {
            $value = $wpdb->get_var( $wpdb->prepare( "SELECT session_value FROM $this->_table WHERE session_key = %s", $customer_id ) );

            if ( is_null( $value ) ) {
                $value = $default;
            }

            wp_cache_add( WOLIVE_CACHE_SESSION . $customer_id, $value, WOLIVE_SESSION_CACHE_GROUP, $this->_session_expiration - time() );
        }
         */
        return maybe_unserialize( $value );
    }


    public function delete_session( $customer_id ) {
        global $wpdb;

        wp_cache_delete( WOLIVE_CACHE_SESSION . $customer_id, WOLIVE_SESSION_CACHE_GROUP );
        
        $wpdb->delete(
            $this->_table,
            array(
                'session_key' => $customer_id
            )
        );
    }

    public function update_session_timestamp( $customer_id, $timestamp ) {
        global $wpdb;

        $wpdb->update(
            $this->_table,
            array(
                'session_expiry' => $timestamp
            ),
            array(
                'session_id' => $customer_id
            ),
            array(
                '%d'
            )
        );
    }

    
    public function update_user_id( $id ) {
        global $wpdb;

        $wpdb->update(
            $this->_table,
            array(
                'user_id' => $id
            ),
            array(
                'session_id' => $this->get_session_id() 
            ),
            array(
                '%d'
            )
        );
    }


        // Another Data

        
}
