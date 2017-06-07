<?php
    global $wpdb;
    $wlabel=$_wlabel_user->wlabel;
    $WLresult=$_wlabel_user->wlabel_result;
?>
<div class="section">
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
        SELECT DISTINCT
          users.user_login

        FROM
          wp_users AS users
          LEFT JOIN wp_usermeta AS usermeta ON (usermeta.user_id=users.ID AND usermeta.meta_key='_wlabel')
          LEFT JOIN wp_posts AS posts ON (posts.post_author=users.ID)
          LEFT JOIN wp_postmeta AS postmeta ON (postmeta.post_id=posts.post_parent AND postmeta.meta_key='_wlabel')

        WHERE
          (
            usermeta.meta_value = 'volaris'
            OR
            (postmeta.meta_value = 'volaris'  AND posts.post_type = 'wc_booking')
          )
          AND NOT
          posts.post_status LIKE '%cart%'

        ORDER BY
          users.ID DESC
    ";
/*
 */

    //var_dump($sql);
    //var_dump($wpdb);
    $users = $wpdb->get_results($sql);
    var_dump(count($users));
    var_dump($users);
    //var_dump($users[0]);


    $BUILDusers = array();
    foreach($users as $key => $user){
        //var_dump($user);
        $ID=$user->ID;
        $date=strtotime($user->post_date);
        $customer=$user->post_author;
        $status=$user->post_status;
        $order=$user->post_parent;
        $status_name=$status;

        $_metas_user = get_post_meta($ID);
        $_metas_order = get_post_meta($order);
        //var_dump($_metas_user);
        //var_dump($_metas_order);

        $IDproduct=$_metas_user['_user_product_id'][0];
        $IDcustomer=$_metas_user['_user_customer_id'][0];
        $IDorder_item=$_metas_user['_user_order_item_id'][0];

        //$_meta_WCorder = wc_get_order_item_meta($IDorder_item,'_line_total');
        $_meta_WCorder_line_total = wc_get_order_item_meta($IDorder_item,'_line_total');
        //var_dump($WCorder_items);

        //CUSTOMER
        $_metas_customer = get_user_meta($customer);
        $_customer_name = $_metas_customer['first_name'][0] . " " . $_metas_customer['last_name'][0];

        $product = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID ='$IDproduct'");
        //var_dump($product);

       $BUILDusers[$ID] = array();
       $BUILDusers[$ID]['user'] = $ID;
       $BUILDusers[$ID]['order'] = $order;
       $BUILDusers[$ID]['date'] = $date;
       $BUILDusers[$ID]['customer'] = $customer;
       $BUILDusers[$ID]['status'] = $status;
       $BUILDusers[$ID]['status_name'] = $status_name;
       $BUILDusers[$ID]['metas_user'] = $_metas_user;
       $BUILDusers[$ID]['metas_order'] = $_metas_order;
       $BUILDusers[$ID]['WCorder_line_total'] = $_meta_WCorder_line_total*1;
       //$BUILDusers[$ID][''] = ;
    }






     //CANTIDAD DE USUARIOS
     echo '<tr>';
         echo '<th>Cantidad de Usuarios</th>';
            $day_init=strtotime(date('m/d/Y',$WLresult->time));
            $day_last=strtotime(date('m/d/Y',time()));
            $day_more=(24*60*60);

            $amount_day=0;
            $amount_month=0;
            $amount_year=0;

            for($day=$day_init; $day<=$day_last ; $day=$day+$day_more){

                foreach($BUILDusers as $user){
                    if(strtotime(date('m/d/Y',$user['date']))==strtotime(date('m/d/Y',$day))){
                        $amount_user=0;
                        if($user['status']!='cancelled'){
                            $amount_user=$user['WCorder_line_total'];
                        }
                        $amount_user=(round($amount_user*100)/100);
                        $amount_day=$amount_day+$amount_user;
                        $amount_month=$amount_month+$amount_user;
                        $amount_year=$amount_year+$amount_user;
                    }
                }


                echo '<td class="day tdshow" data-check="day" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_day.'</td>';
                $amount_day=0;

                if(date('t',$day)==date('d',$day) || $day_last==$day){
                    echo '<td class="month tdshow" data-check="month" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_month.'</td>';
                    $amount_month=0;

                    if(date('m',$day)=='12' || $day_last==$day){
                        echo '<th class="year tdshow" data-check="year" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_year.'</th>';
                        $amount_year=0;
                    }
                }
            }
     echo '</tr>';


//CANTIDAD DE USUARIOS REGISTRADOS
echo '<tr>';
echo '<th>Cantidad de Usuarios Registrados</th>';
$day_init=strtotime(date('m/d/Y',$WLresult->time));
$day_last=strtotime(date('m/d/Y',time()));
$day_more=(24*60*60);

$amount_day=0;
$amount_month=0;
$amount_year=0;

for($day=$day_init; $day<=$day_last ; $day=$day+$day_more){

    foreach($BUILDusers as $user){
        if(strtotime(date('m/d/Y',$user['date']))==strtotime(date('m/d/Y',$day))){
            $amount_user=0;
            if($user['status']!='cancelled'){
                $amount_user=$user['WCorder_line_total'];
            }
            $amount_user=(round($amount_user*100)/100);
            $amount_day=$amount_day+$amount_user;
            $amount_month=$amount_month+$amount_user;
            $amount_year=$amount_year+$amount_user;
        }
    }


    echo '<td class="day tdshow" data-check="day" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_day.'</td>';
    $amount_day=0;

    if(date('t',$day)==date('d',$day) || $day_last==$day){
        echo '<td class="month tdshow" data-check="month" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_month.'</td>';
        $amount_month=0;

        if(date('m',$day)=='12' || $day_last==$day){
            echo '<th class="year tdshow" data-check="year" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_year.'</th>';
            $amount_year=0;
        }
    }
}
echo '</tr>';




//CANTIDAD DE USUARIOS RESERVANDO
echo '<tr>';
echo '<th>Cantidad de Usuarios de Reservas</th>';
$day_init=strtotime(date('m/d/Y',$WLresult->time));
$day_last=strtotime(date('m/d/Y',time()));
$day_more=(24*60*60);

$amount_day=0;
$amount_month=0;
$amount_year=0;

for($day=$day_init; $day<=$day_last ; $day=$day+$day_more){

    foreach($BUILDusers as $user){
        if(strtotime(date('m/d/Y',$user['date']))==strtotime(date('m/d/Y',$day))){
            $amount_user=0;
            if($user['status']!='cancelled'){
                $amount_user=$user['WCorder_line_total'];
            }
            $amount_user=(round($amount_user*100)/100);
            $amount_day=$amount_day+$amount_user;
            $amount_month=$amount_month+$amount_user;
            $amount_year=$amount_year+$amount_user;
        }
    }


    echo '<td class="day tdshow" data-check="day" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_day.'</td>';
    $amount_day=0;

    if(date('t',$day)==date('d',$day) || $day_last==$day){
        echo '<td class="month tdshow" data-check="month" data-month="'.date('n',$day).'" data-year="'.date('Y',$day).'">'.$amount_month.'</td>';
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



