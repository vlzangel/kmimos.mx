<?php
//var_dump(get_current_user_id());
function coupon_message($type = 'success', $message=''){

    if($type == 'success'){
        echo '<div class="updated">'.$message.'</div>';

    }else if($type == 'updated'){
        echo '<div class="update-nag">'.$message.'</div>';

    }else if($type == 'error'){
        echo '<div class="error">'.$message.'</div>';
    }
}

if(isset($_POST["submit_csv_upload"])) {
    $separator=';';
    $lines=array();
    $row_header = array();
    $row_content = array('idclient', 'type', 'date_start', 'date_final', 'number_nights', 'number_bookings', 'coupon', 'amount', 'service', 'action');

    $file_time = time();
    $file_name = $_FILES['csv']['name'];
    $file_size = $_FILES['csv']['size'];
    $file_tempfile = $_FILES['csv']['tmp_name'];
    $file_type = $_FILES['csv']['type'];
    $file_detail = explode('.',$file_name);

    if(strtolower(array_pop($file_detail)) == 'csv'){
        $fopen = fopen($file_tempfile, 'r');
        while(($data = fgetcsv($fopen, 1000, $separator)) !== FALSE){

            if($row==0){
                foreach($data as $index=>$name){
                    $row_header[$index]=strtolower($name);
                }

            }else{

                $line=array();
                foreach($row_content as $content){
                    $index=array_search($content, $row_header);
                    $value=$data[$index];
                    $line[$content]=$value;
                }
                $lines[$line['coupon']]=$line;

            }

            $row++;
        }
        fclose($fopen);
        coupon_message('success','CSV Leido Correctamente');


    }else{
        coupon_message('error','no es un archivo CSV');
    }


    if(count($lines)>0){
        coupon_message('success','Extraidas '.count($lines).' Cupones del CSV');

        foreach($lines as $line){
            global $wpdb;
            $coupon = $line['coupon'];
            $couponID = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '".$coupon ."'" );

            $amount = $line['amount'];
            $date_start = strtotime($line['date_start']);
            $date_final = strtotime($line['date_final']);

            if(is_null($couponID)){
                $discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product

                $data = array(
                    'post_title' => $coupon,
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_author' => get_current_user_id(),
                    'post_type'		=> 'shop_coupon'
                );

                $couponID = wp_insert_post($data);
                update_post_meta($couponID, 'discount_type', $discount_type);
                update_post_meta($couponID, 'coupon_amount', $amount);
                update_post_meta($couponID, 'individual_use', 'no');
                update_post_meta($couponID, 'product_ids', '');
                update_post_meta($couponID, 'exclude_product_ids', '');
                update_post_meta($couponID, 'usage_limit', '');
                update_post_meta($couponID, 'expiry_date', date('Y-m-d',$date_final));
                update_post_meta($couponID, 'apply_before_tax', 'yes');
                update_post_meta($couponID, 'free_shipping', 'no');
                coupon_message('success','Creado '.$coupon);
            }

            update_post_meta($couponID, '_booking', 'Y');
            update_post_meta($couponID, '_booking_type', $line['type']);
            update_post_meta($couponID, '_booking_idclient', $line['idclient']);
            update_post_meta($couponID, '_booking_date_start', $date_start);
            update_post_meta($couponID, '_booking_date_final', $date_final);
            update_post_meta($couponID, '_booking_number_nights', $line['number_nights']);
            update_post_meta($couponID, '_booking_number_bookings', $line['number_bookings']);
            update_post_meta($couponID, '_booking_service', $line['service']);
            update_post_meta($couponID, '_booking_action', $line['action']);
            coupon_message('success','Actualizado '.$coupon);

        }
        coupon_message('success','Proceso Terminado');
    }

    echo '<pre>';
    //var_dump($lines);
    echo '</pre>';

}

?>

<h3>CUPONES DE RESERVAS</h3>


<form id="featured_upload" method="post" action="#" enctype="multipart/form-data">
    <input type="file" name="csv" id="csv"  multiple="false" value="Buscar CSV"/>
    <input class="button" id="submit_csv_upload" name="submit_csv_upload" type="submit" value="Cargar CSV" />
</form>