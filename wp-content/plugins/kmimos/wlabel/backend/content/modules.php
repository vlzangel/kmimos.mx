<div class="modules">

<pre>
    BACK LABEL (REPORTES)

    Reporte de Ventas

    Número de clientes comprando en un mes.
    Por cliente cuantas noches están comprando por mes.
    Venta bruta (incluyendo servicios) asociada por mes total  (Ej. Este mes vendiste tanto)
    Venta de cada persona por mes
    Venta neta kmimos total por mes (la que sale del 17% que le queda a kmimos)
    Partición de Volaris 40% de ese 17% por mes
    Partición de kmimos 60% de ese 17% por mes
    Contabilizar “En ese momento”

    I.            Total de ventas del mes  - Ej. Abril 10.000
    II.            Total de ventas – cancelaciones 10.000 - cancelaciones
    III.            Pendientes por cobrar (venta a futuro)  las que no se han pagado

    De los clientes
    Número de usuarios registrados (comprando o no)
    Número de usuarios comprando en el mes
    Número de usuarios totales que han comprado (Mes a Mes)

    Por nombre y apellido
    Que está pasando en el mes en curso
    Noche de ventas en el mes
    Servicios adicionales
    Tipo de reserva

    En General

    Mostrar totalote de cuanto me debe a mi Volaris (lo que le debe volaris a kmimos)
    Tomar en cuenta cuando se dio de alta el cliente
    Tiempo de acuerdo es de tres años
</pre>


    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>DATE</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>



<?php
   //var_dump($_wlabel_user->GETuser());
   $wlabel=$_wlabel_user->wlabel;
   var_dump($wlabel);
/*
             posts.*,

*/
   global $wpdb;

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

        $_metas_booking = get_post_meta($ID);
        $_metas_order = get_post_meta($order);
        //var_dump($_metas_booking);
        //var_dump($_metas_order);

        $IDproduct=$_metas_booking['_booking_product_id'][0];
        $IDcustomer=$_metas_booking['_booking_customer_id'][0];
        $IDorder_item=$_metas_booking['_booking_order_item_id'][0];


        $WCorder = wc_get_order($IDorder_item);
        //$_meta_WCorder = wc_get_order_item_meta($IDorder_item,'_line_total');
        $_meta_WCorder_line_total = wc_get_order_item_meta($IDorder_item,'_line_total');
       //var_dump($WCorder_items);
        var_dump($WCorder);

        //CUSTOMER
        $_metas_customer = get_user_meta($customer);
        $_customer_name = $_metas_customer['first_name'][0] . " " . $_metas_customer['last_name'][0];

        $product = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID ='$IDproduct'");
        //var_dump($product);

        $html='
        <tr data-day="'.date('d',$date).'" data-month="'.date('m',$date).'" data-year="'.date('Y',$date).'">
            <td>'.$booking->ID.'</td>
            <td>'.date('d/m/Y',$date).'</td>
            <td>'.$_customer_name.'</td>
            <td>'.$_meta_WCorder_line_total.'</td>
            <td>'.$_meta_WCorder_line_total*0.17.'</td>
            <td>'.$_meta_WCorder_line_total*0.17*0.4.'</td>
            <td>'.$_meta_WCorder_line_total*0.17*0.6.'</td>
            <td>'.$customer.'</td>
            <td>'.$customer.'</td>
            <td>'.$customer.'</td>
        </tr>
        ';
        echo $html;
    }


 ?>
        </tbody>
    </table>


</div>

