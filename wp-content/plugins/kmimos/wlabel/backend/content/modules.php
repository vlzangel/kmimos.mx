<div class="modules">
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
     ";

   //var_dump($sql);
   //var_dump($wpdb);
   $bookings = $wpdb->get_results($sql);
   //var_dump($bookings);

   foreach($bookings as $key => $booking) {
      //var_dump($booking);

      $_metas_booking = get_post_meta($booking->ID);
      $_metas_order = get_post_meta($booking->post_parent);
      //var_dump($_metas);

      //CLIENTE
      $_metas_user = get_user_meta($_metas_booking['_booking_customer_id'][0]);
      $_order = $_metas_user['first_name'][0] . " " . $_metas_user['last_name'][0];

      $product = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID = " . $_metas_booking['_booking_product_id'][0]);
      //var_dump($product);

      var_dump($booking);
   }


 ?>



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


</div>

