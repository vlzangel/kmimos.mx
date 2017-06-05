<div class="section">
    <div class="filter">
        <div class="type date" data-type="trdate">
            <div class="month line">
                <label>Mes</label>
                <select name="month">
                    <option value="">Seleccionar ...</option>
                    <?php
                        for($month=1; $month<12 ; $month++){
                            echo '<option value="'.$month.'">'.date('F',strtotime(''.$month.'/1/'.date('Y',time()))).'</option>';
                        }
                    ?>
                </select>
            </div>

            <div class="year line">
                <label>Ano</label>
                <select name="year">
                    <option value="">Seleccionar ...</option>
                    <?php
                    $year_date=date('Y',time());
                    for($year=0; $year<5; $year++){
                        $year_option=$year_date-$year;
                        echo '<option value="'.$year_option.'">'.$year_option.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>


    <table cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Nombre de Cliente</th>
            <th>Estatus</th>
            <th>Monto de reserva</th>
            <th>Monto Kmimos</th>
            <th>Monto Partición Kmimos</th>
            <th>Monto Partición Volaris</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td>'</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="count"></td>
            <td class="count"></td>
            <td class="count"></td>
            <td class="count"></td>
        </tr>
        </tfoot>
        <tbody>



<?php
   global $wpdb;
   //var_dump($_wlabel_user->GETuser());
   $wlabel=$_wlabel_user->wlabel;
   var_dump($wlabel);

   $sql = "
         SELECT
             posts.*,
             posts.ID AS ID,
             posts.post_type AS ptype,
             posts.post_status AS status,
             posts.post_parent AS porder,
             posts.post_author AS customer
         FROM
             wp_posts AS posts
             LEFT JOIN wp_postmeta AS postmeta ON (postmeta.post_id=posts.ID AND postmeta.meta_key='_wlabel')
             LEFT JOIN wp_usermeta AS usermeta ON (usermeta.user_id=posts.post_author AND usermeta.meta_key='_wlabel')
         WHERE
             posts.post_type = 'wc_booking' AND
             (
                usermeta.meta_value = '{$wlabel}' OR
                postmeta.meta_value = '{$wlabel}'
             )
          ORDER BY
            posts.ID DESC
     ";

   //var_dump($sql);
   //var_dump($wpdb);
   $bookings = $wpdb->get_results($sql);
   //var_dump($bookings);

   foreach($bookings as $key => $booking){
        //var_dump($booking);
        $ID=$booking->ID;
        $date=strtotime($booking->post_date);
        $customer=$booking->post_author;
        $status=$booking->post_status;
        $order=$booking->post_parent;
        $status_name=$status;

        $_metas_booking = get_post_meta($ID);
        $_metas_order = get_post_meta($order);
        //var_dump($_metas_booking);
        //var_dump($_metas_order);

        $IDproduct=$_metas_booking['_booking_product_id'][0];
        $IDcustomer=$_metas_booking['_booking_customer_id'][0];
        $IDorder_item=$_metas_booking['_booking_order_item_id'][0];

        //$_meta_WCorder = wc_get_order_item_meta($IDorder_item,'_line_total');
        $_meta_WCorder_line_total = wc_get_order_item_meta($IDorder_item,'_line_total');
        //var_dump($WCorder_items);

        //CUSTOMER
        $_metas_customer = get_user_meta($customer);
        $_customer_name = $_metas_customer['first_name'][0] . " " . $_metas_customer['last_name'][0];

        $product = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID ='$IDproduct'");
        //var_dump($product);

        $html='
        <tr class="trshow" data-day="'.date('d',$date).'" data-month="'.date('n',$date).'" data-year="'.date('Y',$date).'" data-status="'.$status.'">
            <td>'.$booking->ID.'</td>
            <td>'.date('d/m/Y',$date).'</td>
            <td>'.$_customer_name.'</td>
            <td>'.$status_name.'</td>
            <td>'.$_meta_WCorder_line_total.'</td>
            <td>'.$_meta_WCorder_line_total*0.17.'</td>
            <td>'.$_meta_WCorder_line_total*0.17*0.4.'</td>
            <td>'.$_meta_WCorder_line_total*0.17*0.6.'</td>
        </tr>
        ';
        echo $html;
    }


 ?>
        </tbody>
    </table>
</div>



