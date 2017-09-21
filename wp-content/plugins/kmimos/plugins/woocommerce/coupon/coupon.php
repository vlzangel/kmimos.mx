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
    return $valid;
};


//add_filter('woocommerce_coupon_is_valid_for_cart', 'filter_woocommerce_coupon_is_valid_for_cart', 10, 2 );
//remove_filter( 'woocommerce_coupon_is_valid_for_cart', 'filter_woocommerce_coupon_is_valid_for_cart', 10, 2 );
function filter_woocommerce_coupon_is_valid_for_cart($type, $instance ) {
    var_dump($type);
    var_dump($instance);
    return $type;
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

    if($CouponBooking=='Y'){
        //$detail = wc_add_notice('Cupon de Reserva', 'success');
        //$detail = wc_add_notice('Cupon de Reserva', 'notice');
        //$detail = wc_add_notice('Cupon de Reserva', 'error');

        //Validate 1
        if($CouponBooking_IdClient!='' && $CouponBooking_IdClient==$userId){

            //Validate 2
            if($CouponBooking_DateStart>time() || $CouponBooking_DateFinal<time()){
                $detail = wc_add_notice('CUPON NO CUMPLE CON LAS CONDICIONES: El cup&oacute;n es aplicable a partir de '.date('d/m/Y',$CouponBooking_DateStart).', hasta '.date('d/m/Y',$CouponBooking_DateFinal), 'notice');
                return false;
            }

            //Validate 4
            if($CouponBooking_action=='processing'){
                $detail = wc_add_notice('CUPON NO CUMPLE CON LAS CONDICIONES: El cup&oacute;n esta procesado', 'notice');
                return false;
            }

            //Validate 5
            $items = WC()->cart->get_cart();
            //$cart_data = WC()->cart->get_item_data( $cart_item );
            foreach($items as $id=>$item){
                $bookingStart=$item['booking']['_start_date'];
                $bookingEnd=$item['booking']['_end_date'];
                $bookingDuration=$item['booking']['_duration'];
                $bookingDuration=($bookingEnd-$bookingStart)/(60*60*24);

                if($CouponBooking_NumberNights>=$bookingDuration){
                    $detail = wc_add_notice('CUPON NO CUMPLE CON LAS CONDICIONES: Las noches de reserva deben ser mayor igual a '.$CouponBooking_NumberNights, 'notice');
                    return false;
                }
            }

            //Validate 6
            if($CouponBooking_Type == '2'){
                $sql= "
                        SELECT *
                        FROM wp_posts as posts
                          LEFT JOIN wp_postmeta as metas ON posts.ID = metas.post_id
                        WHERE
                          (posts.post_type = 'wc_booking')
                          AND
                          (posts.post_status NOT LIKE '%cart%' AND posts.post_status != 'cancelled')
                          AND
                          (metas.meta_key = '_booking_customer_id' AND metas.meta_value = '$userId')
                          AND
                          (posts.post_date >= '".date('Y-m-d',$CouponBooking_DateStart)."' AND posts.post_date <= '".date('Y-m-d',$CouponBooking_DateFinal)."')
                     ";

                $Bookings = $wpdb->get_results($sql);
                $Bookings_validate = array();
                foreach($Bookings as $Booking){
                    $Booking_postmeta = get_post_meta($Booking->ID);
                    $Booking_start=strtotime(filter_woocommerce_validate_variable('_booking_start',$Booking_postmeta));
                    $Booking_end=strtotime(filter_woocommerce_validate_variable('_booking_end',$Booking_postmeta));

                   if($Booking_start >= $CouponBooking_DateStart && $Booking_end <= $CouponBooking_DateFinal){
                       $Bookings_validate[]=$Booking;
                   }

                }

               if(count($Bookings)<$CouponBooking_NumberBookings){
                   $detail = wc_add_notice('CUPON NO CUMPLE CON LAS CONDICIONES: El cup&oacute;n es aplicable a partir de '.$CouponBooking_NumberBookings.' reservas', 'notice');
                   return false;
               }
            }

       }else{
            $detail = wc_add_notice('CUPON NO CUMPLE CON LAS CONDICIONES: El cup&oacute;n no coincide con el usuario asignado', 'notice');
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






//Available Coupon
//add_filter("woocommerce_coupon_is_valid","amount_woocommerce_coupon_is_valid",10,2);
//remove_filter( 'woocommerce_coupon_is_valid', 'filter_woocommerce_coupon_is_valid', 10, 2 );
function amount_woocommerce_coupon_is_valid($result,$coupon) {
    global $wpdb;
    //return false;

    $code=$coupon->code;
    var_dump($result);
    var_dump($code);
    var_dump($coupon);
    $coupon->individual_use=false;

    if (strpos($code, 'saldo') !== false) {
        var_dump('es de saldo');
        return true;
    }


    return $result;
}
?>