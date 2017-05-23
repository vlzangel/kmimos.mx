<?php

    global $wpdb;
    //var_dump($_wlabel_user->GETuser());
    $wlabel=$_wlabel_user->wlabel;
    $WLresult=$_wlabel_user->wlabel_result;
    var_dump($WLresult->time);
    var_dump($wlabel);

?>
<div class="section">
    <div class="filter">
        <div class="type date" data-type="tddate">
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


    <div class="filter">
        <div class="type tdshow" data-type="tdcheck">
            <div class="day line">
                <label>Dias</label>
                <input type="checkbox" name="day" value="yes"/>
            </div>

            <div class="month line">
                <label>Mes</label>
                <input type="checkbox" name="month" value="yes" checked/>
            </div>

            <div class="year line">
                <label>Ano</label>
                <input type="checkbox" name="year" value="yes" checked/>
            </div>
        </div>
    </div>


    <div class="tables">
    <table cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th>Titulo</th>
            <?php
                $day_init=strtotime(date('m/d/Y',$WLresult->time));
                $day_last=strtotime(date('m/d/Y',time()));
                $day_more=(24*60*60);

                for($day=$day_init; $day<=$day_last ; $day=$day+$day_more){
                    echo '<th class="day tdshow" data-check="day" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.date('d/m/Y',$day).'</th>';//date('d',$day).'--'.
                    if(date('t',$day)==date('d',$day) || $day_last==$day){
                        echo '<th class="month tdshow" data-check="month" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.date('F/Y',$day).'</th>';
                        if(date('m',$day)=='12' || $day_last==$day){
                            echo '<th class="year tdshow" data-check="year" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.date('Y',$day).'</th>';
                        }
                    }
                }
            ?>

        </tr>
        </thead>
        <tbody>



<?php

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

    $BUILDbookings = array();
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
        <tr data-day="'.date('d',$date).'" data-month="'.date('n',$date).'" data-year="'.date('Y',$date).'" data-status="'.$status.'">
            <td>'.$booking->ID.'</td>
            <td>'.date('d/m/Y',$date).'</td>
            <td>'.$_customer_name.'</td>
            <td>'.$status_name.'</td>
            <td>'.$_meta_WCorder_line_total.'</td>
            <td>'.$_meta_WCorder_line_total*0.17.'</td>
            <td>'.$_meta_WCorder_line_total*0.17*0.4.'</td>
            <td>'.$_meta_WCorder_line_total*0.17*0.6.'</td>
            <td>'.$customer.'</td>
            <td>'.$customer.'</td>
        </tr>
        ';
        //echo $html;


       $BUILDbookings[$ID] = array();
       $BUILDbookings[$ID]['booking'] = $ID;
       $BUILDbookings[$ID]['order'] = $order;
       $BUILDbookings[$ID]['date'] = $date;
       $BUILDbookings[$ID]['customer'] = $customer;
       $BUILDbookings[$ID]['status'] = $status;
       $BUILDbookings[$ID]['status_name'] = $status_name;
       $BUILDbookings[$ID]['metas_booking'] = $_metas_booking;
       $BUILDbookings[$ID]['metas_order'] = $_metas_order;
       $BUILDbookings[$ID]['WCorder_line_total'] = $_meta_WCorder_line_total*1;
       //$BUILDbookings[$ID][''] = ;
    }






            //TOTAL DE MONTO DE RESERVAS
             echo '<tr>';
                 echo '<th>Monto de Reservas</th>';
                    $day_init=strtotime(date('m/d/Y',$WLresult->time));
                    $day_last=strtotime(date('m/d/Y',time()));
                    $day_more=(24*60*60);

                    $amount_day=0;
                    $amount_month=0;
                    $amount_year=0;

                    for($day=$day_init; $day<=$day_last ; $day=$day+$day_more){

                        foreach($BUILDbookings as $booking){
                            if(strtotime(date('m/d/Y',$booking['date']))==strtotime(date('m/d/Y',$day))){
                                $amount_booking=0;
                                if($booking['status']!='cancelled'){
                                    $amount_booking=$booking['WCorder_line_total'];
                                }
                                $amount_booking=(round($amount_booking*100)/100);
                                $amount_day=$amount_day+$amount_booking;
                                $amount_month=$amount_month+$amount_booking;
                                $amount_year=$amount_year+$amount_booking;
                            }
                        }


                        echo '<th class="day tdshow" data-check="day" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_day.'</th>';
                        $amount_day=0;

                        if(date('t',$day)==date('d',$day) || $day_last==$day){
                            echo '<th class="month tdshow" data-check="month" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_month.'</th>';
                            $amount_month=0;

                            if(date('m',$day)=='12' || $day_last==$day){
                                echo '<th class="year tdshow" data-check="year" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_year.'</th>';
                                $amount_year=0;
                            }
                        }
                    }
             echo '</tr>';


            //TOTAL DE MONTO DE COMISION
            echo '<tr>';
            echo '<th>Comision</th>';
            $day_init=strtotime(date('m/d/Y',$WLresult->time));
            $day_last=strtotime(date('m/d/Y',time()));
            $day_more=(24*60*60);

            $amount_day=0;
            $amount_month=0;
            $amount_year=0;

            for($day=$day_init; $day<=$day_last ; $day=$day+$day_more){

                foreach($BUILDbookings as $booking){
                    if(strtotime(date('m/d/Y',$booking['date']))==strtotime(date('m/d/Y',$day))){
                        $amount_booking=0;
                        if($booking['status']!='cancelled'){
                            $amount_booking=$booking['WCorder_line_total']*0.17;
                        }
                        $amount_booking=(round($amount_booking*100)/100);
                        $amount_day=$amount_day+$amount_booking;
                        $amount_month=$amount_month+$amount_booking;
                        $amount_year=$amount_year+$amount_booking;
                    }
                }


                echo '<th class="day tdshow" data-check="day" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_day.'</th>';
                $amount_day=0;

                if(date('t',$day)==date('d',$day) || $day_last==$day){
                    echo '<th class="month tdshow" data-check="month" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_month.'</th>';
                    $amount_month=0;

                    if(date('m',$day)=='12' || $day_last==$day){
                        echo '<th class="year tdshow" data-check="year" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_year.'</th>';
                        $amount_year=0;
                    }
                }
            }
            echo '</tr>';


            //TOTAL DE MONTO DE COMISION DE KMIMOS
            echo '<tr>';
            echo '<th>Comision de  kmimos</th>';
            $day_init=strtotime(date('m/d/Y',$WLresult->time));
            $day_last=strtotime(date('m/d/Y',time()));
            $day_more=(24*60*60);

            $amount_day=0;
            $amount_month=0;
            $amount_year=0;

            for($day=$day_init; $day<=$day_last ; $day=$day+$day_more){

                foreach($BUILDbookings as $booking){
                    if(strtotime(date('m/d/Y',$booking['date']))==strtotime(date('m/d/Y',$day))){
                        $amount_booking=0;
                        if($booking['status']!='cancelled'){
                            $amount_booking=$booking['WCorder_line_total']*0.17*0.6;
                        }
                        $amount_booking=(round($amount_booking*100)/100);
                        $amount_day=$amount_day+$amount_booking;
                        $amount_month=$amount_month+$amount_booking;
                        $amount_year=$amount_year+$amount_booking;
                    }
                }


                echo '<th class="day tdshow" data-check="day" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_day.'</th>';
                $amount_day=0;

                if(date('t',$day)==date('d',$day) || $day_last==$day){
                    echo '<th class="month tdshow" data-check="month" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_month.'</th>';
                    $amount_month=0;

                    if(date('m',$day)=='12' || $day_last==$day){
                        echo '<th class="year tdshow" data-check="year" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_year.'</th>';
                        $amount_year=0;
                    }
                }
            }
            echo '</tr>';


            //TOTAL DE MONTO DE COMISION DE VOLARIS
            echo '<tr>';
            echo '<th>Comision de '.$wlabel.'</th>';
            $day_init=strtotime(date('m/d/Y',$WLresult->time));
            $day_last=strtotime(date('m/d/Y',time()));
            $day_more=(24*60*60);

            $amount_day=0;
            $amount_month=0;
            $amount_year=0;

            for($day=$day_init; $day<=$day_last ; $day=$day+$day_more){

                foreach($BUILDbookings as $booking){
                    if(strtotime(date('m/d/Y',$booking['date']))==strtotime(date('m/d/Y',$day))){
                        $amount_booking=0;
                        if($booking['status']!='cancelled'){
                            $amount_booking=$booking['WCorder_line_total']*0.17*0.4;
                        }
                        $amount_booking=(round($amount_booking*100)/100);
                        $amount_day=$amount_day+$amount_booking;
                        $amount_month=$amount_month+$amount_booking;
                        $amount_year=$amount_year+$amount_booking;
                    }
                }


                echo '<th class="day tdshow" data-check="day" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_day.'</th>';
                $amount_day=0;

                if(date('t',$day)==date('d',$day) || $day_last==$day){
                    echo '<th class="month tdshow" data-check="month" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_month.'</th>';
                    $amount_month=0;

                    if(date('m',$day)=='12' || $day_last==$day){
                        echo '<th class="year tdshow" data-check="year" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_year.'</th>';
                        $amount_year=0;
                    }
                }
            }
            echo '</tr>';



 ?>
        </tbody>
    </table>
    </div>
</div>



