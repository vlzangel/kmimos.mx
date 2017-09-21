<h3>CUPONES DE RESERVAS</h3>
<form id="featured_upload" method="post" action="#" enctype="multipart/form-data">
    <input type="file" name="csv" id="csv"  multiple="false" value="Buscar CSV"/>
    <input class="button" id="submit_csv_upload" name="submit_csv_upload" type="submit" value="Cargar CSV" />
</form>

<?php
//var_dump(get_current_user_id());
function coupon_message($type = 'success', $message=''){

    if($type == 'success'){
        echo '<div class="updated" style="margin: 5px 0; padding: 10px 15px;">'.$message.'</div>';

    }else if($type == 'update'){
        echo '<div class="update-nag" style="margin: 5px 0; display: block !important;">'.$message.'</div>';

    }else if($type == 'error'){
        echo '<div class="error" style="margin: 5px 0; padding: 10px 15px;">'.$message.'</div>';
    }
}

if(isset($_POST["submit_csv_upload"])) {
    $process=true;
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
        coupon_message('success','Iniciando lectura del CSV');
        while(($data = fgetcsv($fopen, 1000, $separator)) !== FALSE){

            if($row==0){
                foreach($data as $index=>$name){
                    $row_header[$index]=strtolower($name);
                }

                coupon_message('update','Cabecera del CSV Procesada <strong>'.implode(', ',$row_header).'</strong>');

            }else{

                $line=array();
                foreach($row_content as $content){
                    $index=array_search($content, $row_header);

                    if($index === false){
                        coupon_message('error','CSV corrupto en cabecera');
                        $process=false;
                        //exit();

                    }else{
                        $value=$data[$index];
                        $line[$content]=$value;
                    }
                }
                $lines[$line['coupon']]=$line;

            }

            $row++;
        }
        fclose($fopen);
        coupon_message('success','Lectura del CSV Culminada');


    }else{
        coupon_message('error','No es un archivo CSV');
        $process=false;
    }


    if($process) {
        if (count($lines) > 0) {
            coupon_message('success', 'Extraidos ' . count($lines) . ' Cupones');

            foreach ($lines as $line) {
                global $wpdb;
                $coupon = $line['coupon'];
                $couponID = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '" . $coupon . "'");

                $amount = $line['amount'];
                $date_start = strtotime($line['date_start']);
                $date_final = strtotime($line['date_final']);

                if (is_null($couponID)) {
                    $discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product

                    $data = array(
                        'post_title' => $coupon,
                        'post_content' => '',
                        'post_status' => 'publish',
                        'post_author' => get_current_user_id(),
                        'post_type' => 'shop_coupon'
                    );


                    $couponID = wp_insert_post($data);
                    update_post_meta($couponID, 'discount_type', $discount_type);
                    update_post_meta($couponID, 'coupon_amount', $amount);
                    update_post_meta($couponID, 'individual_use', 'no');
                    update_post_meta($couponID, 'product_ids', '');
                    update_post_meta($couponID, 'exclude_product_ids', '');
                    update_post_meta($couponID, 'usage_limit', '1');
                    update_post_meta($couponID, 'usage_limit_per_user', '1');
                    update_post_meta($couponID, 'expiry_date', date('Y-m-d', $date_final));
                    update_post_meta($couponID, 'apply_before_tax', 'yes');
                    update_post_meta($couponID, 'free_shipping', 'no');
                    coupon_message('success', 'Creado ' . $coupon);
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
                coupon_message('update', 'Actualizado ' . $coupon);

            }
            coupon_message('success', 'Proceso Terminado');

        } else {
            coupon_message('error', 'No se encontraron cupones en el CSV');

        }

    }else{
        coupon_message('error', 'Proceso no completado');

    }


    /*
    echo '<pre>';
    //var_dump($lines);
    echo '</pre>';
    */
}

?>