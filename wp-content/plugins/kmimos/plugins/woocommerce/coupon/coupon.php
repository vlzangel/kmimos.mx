<?php
add_action('post_edit_form_tag', 'filter_woocommerce_add_edit_form_multipart_encoding');
function filter_woocommerce_add_edit_form_multipart_encoding() {
    echo ' enctype="multipart/form-data"';

}

//COUPON FILTER
function filter_woocommerce_validate_variable($variable='',$variables){
    $return='';
    if($variable!=''){
        if(array_key_exists($variable,$variables)){
            $return = $variables[$variable][0];
        }
    }
    return $return;
}


//add_filter( 'woocommerce_coupon_is_valid_for_product', 'filter_woocommerce_coupon_is_valid_for_product', 10, 4 );
//remove_filter( 'woocommerce_coupon_is_valid_for_product', 'filter_woocommerce_coupon_is_valid_for_product', 10, 4 );
function filter_woocommerce_coupon_is_valid_for_product( $valid, $product, $instance, $values ) {
    var_dump($valid);
    //var_dump($values);
    //var_dump($product);
    var_dump($instance);
    return false;//$valid
};


//add_filter('woocommerce_coupon_is_valid_for_cart', 'filter_woocommerce_coupon_is_valid_for_cart', 10, 2 );
//remove_filter( 'woocommerce_coupon_is_valid_for_cart', 'filter_woocommerce_coupon_is_valid_for_cart', 10, 2 );
function filter_woocommerce_coupon_is_valid_for_cart($type, $instance ) {
    var_dump($type);
    var_dump($instance);
    return false;//$type
};


add_filter("woocommerce_coupon_is_valid","filter_woocommerce_coupon_is_valid",10,2);
//remove_filter( 'woocommerce_coupon_is_valid', 'filter_woocommerce_coupon_is_valid', 10, 2 );
function filter_woocommerce_coupon_is_valid($result,$coupon) {
    global $wpdb;
    //return false;
    //var_dump($coupon);

    $code=$coupon->code;
    $postId = $coupon->id;
    $discount_type = $coupon->discount_type;
    $coupon_amount = $coupon->coupon_amount;
    $userId=get_current_user_id();

    $postmeta = get_post_meta($postId);
    $CouponBooking=filter_woocommerce_validate_variable('_booking',$postmeta);
    $CouponBooking_Type=filter_woocommerce_validate_variable('_booking_type',$postmeta);
    $CouponBooking_IdClient=filter_woocommerce_validate_variable('_booking_idclient',$postmeta);
    $CouponBooking_DateStart=filter_woocommerce_validate_variable('_booking_date_start',$postmeta);
    $CouponBooking_DateFinal=filter_woocommerce_validate_variable('_booking_date_final',$postmeta);
    $CouponBooking_NumberNights=filter_woocommerce_validate_variable('_booking_number_nights',$postmeta);
    $CouponBooking_NumberBookings=filter_woocommerce_validate_variable('_booking_number_bookings',$postmeta);
    $CouponBooking_service=filter_woocommerce_validate_variable('_booking_service',$postmeta);
    $CouponBooking_action=filter_woocommerce_validate_variable('_booking_action',$postmeta);
    //$CouponBooking_=filter_woocommerce_validate_variable('_booking_',$postmeta);

    //var_dump($code);
    //var_dump($postmeta);
    //var_dump($CouponBooking);
    if($CouponBooking=='Y'){
        var_dump('Cupon de reserva');

        //Validate 1
        if($CouponBooking_IdClient!='' && $CouponBooking_IdClient==$userId){

            //Validate 2
            if($CouponBooking_DateStart>time() || $CouponBooking_DateFinal<time()){
                var_dump('Validate 2');
                return false;
            }

            //Validate 4
            if($CouponBooking_action=='processing'){
                var_dump('Validate 4');
                return false;
            }

            //Validate 5
            $items = WC()->cart->get_cart();
            //$cart_data = WC()->cart->get_item_data( $cart_item );
            foreach($items as $id=>$item){
                $bookingStart=$item['booking']['_start_date'];
                $bookingEnd=$item['booking']['_end_date'];
                $bookingDuration=($bookingEnd-$bookingStart)/(60*60*24);
                $bookingDuration=$item['booking']['_duration'];

                if($CouponBooking_NumberNights>$bookingDuration){
                    var_dump('Validate 5');
                    return false;
                }
            }

            //Validate 6
            if($CouponBooking_Type == 2){
                $sql= "
                        SELECT *
                        FROM wp_posts as posts
                          LEFT JOIN wp_postmeta as metas ON posts.ID = metas.post_id
                        WHERE
                          (posts.post_type >= 'wc_booking')
                          AND
                          (posts.post_status NOT LIKE '%cart%' AND posts.post_status != 'cancelled')
                          AND
                          (metas.meta_key = '_booking_customer_id' AND metas.meta_value = '$userId')
                          AND
                          (posts.post_date >= $CouponBooking_DateStart AND posts.post_date <= $CouponBooking_DateFinal)
                     ";

                $Bookings = $wpdb->get_results($sql);
                $Bookings_validate = array();
                foreach($Bookings as $Booking){
                    $Booking_postmeta = get_post_meta($Booking->ID);
                    $Booking_start=strtotime(filter_woocommerce_validate_variable('_booking_start',$Booking_postmeta));
                    $Booking_end=strtotime(filter_woocommerce_validate_variable('_booking_end',$Booking_postmeta));
                    $Bookings_validate[]=$Booking;
                    /*
                                       if($Booking_start >= $CouponBooking_DateStart && $Booking_end <= $CouponBooking_DateFinal){
                                           $Bookings_validate[]=$Booking;
                                       }
                   */
                   }
                   if(count($Bookings_validate)<$CouponBooking_NumberBookings){
                       var_dump('Validate 6');
                       return false;
                   }


               }



                           }else{
                               var_dump('Validate 1');
                               return false;
                           }
                       }

                       return true;
                   }

                   /** COUPON ADMIN MENU **/
add_action('admin_menu', 'filter_woocommerce_coupon_add_menu');
function filter_woocommerce_coupon_add_menu(){
    if(function_exists('add_menu_page')){
        add_submenu_page( 'woocommerce', 'CouponBooking', 'Cupones de Reservas', 'manage_options', 'coupon-booking', 'woocommerce_custom_coupon_booking' );
        //add_menu_page('subscribe', 'Subscribe', 8, basename(__FILE__), 'subscribe_download', '', 996);
        //add_submenu_page(basename(dirname(dirname(__FILE__))), 'subscribe', 'Subscriptores', 8,basename(__FILE__), 'subscribe_download');
    }
}

function woocommerce_custom_coupon_booking() {
    include_once(__DIR__.'/panel.php');

}
?>