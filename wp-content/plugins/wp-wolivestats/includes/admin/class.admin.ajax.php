<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class Wolive_AdminAjax {

    public function __construct() {
        $this->initHooks();
    }

    public static function initHooks () {
        if (current_user_can("install_plugins") ) {
            add_action( 'wp_ajax_getOverview', array( "Wolive_AdminAjax", "getOverview" ));
            add_action( 'wp_ajax_getWoocommerce', array( "Wolive_AdminAjax", "getWoocommerce" ));
            add_action( 'wp_ajax_getScopeTime', array( "Wolive_AdminAjax", "getScopeTime" ));
            add_action( 'wp_ajax_getUsersOnline', array( "Wolive_AdminAjax", "getUsersOnline" ));
            add_action( 'wp_ajax_getAllUsers', array( "Wolive_AdminAjax", "getAllUsers" ));
            add_action( 'wp_ajax_getUser', array( "Wolive_AdminAjax", "getUser" ));
            add_action( 'wp_ajax_scopeOverview', array( "Wolive_AdminAjax", "scopeOverview" ));
	    add_action( 'wp_ajax_getReport', array( "Wolive_AdminAjax", "getReport" ));
	    add_action( 'wp_ajax_getfeedBack', array( "Wolive_AdminAjax", "checkLicense" ));

	    // Options Page
	    add_action( 'wp_ajax_wolive_checkLicense', array( "Wolive_AdminAjax", "checkLicense" ));
        }
    }

    public static function getOverview () {
        $response = array ();

        // User
        $response["online"] = Wolive_AdminModel::get_online_users();
        $response["online_users"] = Wolive_AdminModel::get_online_users_data();

        $response["user_type"] = Wolive_AdminModel::get_users_platforms();
        $response["total_visits"] = Wolive_AdminModel::get_today_users();
        $response["total_actions"] = Wolive_AdminModel::get_today_actions();
        $response["time_average"] = floatval(Wolive_AdminModel::get_user_time_average()->timeAverage);

        $response["last_users"] = Wolive_AdminModel::get_last_users();

        // Live 
        $response["actions_hour"] = Wolive_AdminModel::get_actions_by_hour();
        $response["visits_hour"] = Wolive_AdminModel::get_visits_by_hour();

        // Website
        $response["popular_pages"] = Wolive_AdminModel::get_popular_pages_today(0,7);
        //$response["popular_search"] = Wolive_AdminModel::get_live_searchs();
        $response["popular_referers"] = Wolive_AdminModel::get_live_referers(0,7);

        $response ["timestamp"] = date_i18n("U");
        $response ["HOUR"] = date_i18n("H");

        echo json_encode($response);
        wp_die();
    }


    public static function getWoocommerce () {
        $response = array ();
        $response["today"] = Wolive_AdminModel::get_today_sales();
        $response["today"]->today_cars = Wolive_AdminModel::get_today_cars();
        $response["today_popular_products"] = Wolive_AdminModel::get_today_popular_products();
        $response["cart_live"] = Wolive_AdminModel::get_cart_live();
        $response["n_cart"] = Wolive_AdminModel::get_live_n_cars();

        $response["cart_hour"] = Wolive_AdminModel::get_today_cars_by_hour();
        $response["order_hour"] = Wolive_AdminModel::get_today_sales_by_hour();
        $response["last_orders"] = Wolive_AdminModel::get_last_orders();


        $response ["timestamp"] = date_i18n("U");
        $response ["HOUR"] = date_i18n("H");

        echo json_encode($response);

        wp_die();

    }

    public static function getScopeTime() {

        $method =  $_POST["method"];

        $response = array();
        if ($method == "getOnline") {
            $response["online"] = Wolive_AdminModel::get_online_users();
        }

        if ($method == "getUserData") {
            $response["online_users"] = Wolive_AdminModel::get_online_users_data();
        }

        if ($method == "getVisits") {
            $response["total_visits"] = Wolive_AdminModel::get_today_users();
            $response["total_actions"] = Wolive_AdminModel::get_today_actions();
            $response["time_average"] = floatval(Wolive_AdminModel::get_user_time_average()->timeAverage);
        }

        if ($method == "getLastUsers") {
            $response["last_users"] = Wolive_AdminModel::get_last_users();
        }

        if ($method == "getLivePages") {
            $response["popular_pages"] = Wolive_AdminModel::get_popular_pages_today(0,7);
            $response["popular_referers"] = Wolive_AdminModel::get_live_referers(0,7);
        }

        if ($method == "getGraphUserType") {
            $response["user_type"] = Wolive_AdminModel::get_users_platforms();
        }

        if ( $method == "getGraphToday"  ) {
            $response["actions_hour"] = Wolive_AdminModel::get_actions_by_hour();
            $response["visits_hour"] = Wolive_AdminModel::get_visits_by_hour();
        }


        if ( $method == "getTodayStore"  ) {
            $response["today"] = Wolive_AdminModel::get_today_sales();
            $response["today"]->today_cars = Wolive_AdminModel::get_today_cars();
        }

        if ( $method == "getPopularProducts"  ) {
            $response["today_popular_products"] = Wolive_AdminModel::get_today_popular_products();
        }

        if ( $method == "getCartLive"  ) {
            $response["cart_live"] = Wolive_AdminModel::get_cart_live();
            $response["n_cart"] = Wolive_AdminModel::get_live_n_cars();
        }

        if ( $method == "getGraphHourWoo"  ) {
            $response["cart_hour"] = Wolive_AdminModel::get_today_cars_by_hour();
            $response["order_hour"] = Wolive_AdminModel::get_today_sales_by_hour();
        }

        if ( $method == "getOrders"  ) {
            $response["last_orders"] = Wolive_AdminModel::get_last_orders();
        }

        $response ["method"] = $method;
        $response ["timestamp"] = date_i18n("U");
        $response ["HOUR"] = date_i18n("H");

        echo json_encode($response);
        wp_die();
    }

    public static function OrdersAdmin () {
        echo json_encode(Wolive_AdminModel::get_today_sales());
        wp_die();
    }

    public static function getUsersOnline () {
        $response = array ();
        $response= Wolive_AdminModel::get_users_online();
        $response ["timestamp"] = date_i18n("U");
        $response ["HOUR"] = date_i18n("H");
        echo json_encode( $response);
        wp_die();
    }

    public static function getAllUsers () {
        $response = Wolive_AdminModel::get_last_users_filter();
        $response ["timestamp"] = date_i18n("U");
        $response ["HOUR"] = date_i18n("H");
        echo json_encode($response);
        wp_die();
    }

    public static function getUser() {
        $id_user = (int) $_POST["id"];

        $timestamp = "";
        if (!empty($_POST["timestamp"]))
            $timestamp = (int) $_POST["timestamp"];

        $response = Wolive_AdminModel::getUser($id_user, $timestamp);
        echo json_encode($response);
        wp_die();
    }

    public static function scopeOverview () {
        $response = array();
        $timestamp = $_POST["timestamp"];
        $response["actions"] = Wolive_AdminModel::scopeOverview($timestamp);

        $response["timestamp"] = date_i18n("U");

        echo json_encode($response);                
        wp_die();
    }

    public static function getReport () {
        $type=$_POST["report_type"];
        $filter_date=$_POST["report_date"];

        if ($type ==  "visits") {
                $response = Wolive_AdminReports::getVisits($filter_date);
	}


	if ($type ==  "search") {
                $response = Wolive_AdminReports::getSearch($filter_date);
	}

	if ($type ==  "search") {
                $response = Wolive_AdminReports::getSearch($filter_date);
	}


	if ($type ==  "post") {
                $response = Wolive_AdminReports::getPost($filter_date);
	}

	if ($type ==  "url") {
                $response = Wolive_AdminReports::getURL($filter_date);
	}

	if ($type ==  "countries") {
                $response = Wolive_AdminReports::getMetadata("country",$filter_date);
	}

	
	if ($type ==  "platforms") {
                $response = Wolive_AdminReports::getMetadata("platform",$filter_date);
	}

	
	if ($type ==  "browsers") {
                $response = Wolive_AdminReports::getMetadata("browser",$filter_date);
	}

	if ($type ==  "languages") {
                $response = Wolive_AdminReports::getMetadata("language",$filter_date);
	}


	if ($type ==  "screens") {
                $response = Wolive_AdminReports::getScreen($filter_date);
	}

	
	if ($type ==  "referers") {
	    $response = Wolive_AdminReports::getReferers($filter_date);
	    
	}

        if ( $type == "addtocart" )  {
	    $response = Wolive_AdminReports::getAddToCart($filter_date);
	}

        if ( $type == "removecart" )  {
	    $response = Wolive_AdminReports::getRemoveFromCart($filter_date);
	}

        if ( $type == "coupons" )  {
	    $response = Wolive_AdminReports::getCoupons($filter_date);
        }



        $response ["timestamp"] = date_i18n("U");
        $response ["HOUR"] = date_i18n("H");

        echo json_encode($response);
        wp_die();
    }

    public static function checkLicense () {
	$license =  get_option('wolive_license_key');
	$activation_date =  get_option('wolive_time') ;
	$currenTime = current_time( 'timestamp' ) - 24*60*60*30;
	if ($activation_date > $currenTime ) {
	    echo json_encode( array("code" => 1) );
 	    wp_die();
	}

	$wl_status_license = woliveAdmin_CheckLicense($license);
	if (! ($wl_status_license == -2))
	    update_option( "wolive_license_status", $wl_status_license );
	else 
		$wl_status_license = 1;

	echo json_encode( array("status" => $wl_status_license) );
        wp_die();
    }    

}




return new Wolive_AdminAjax();
