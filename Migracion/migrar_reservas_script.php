<?php

	$conn_my = new mysqli("localhost", "root", "", 'kmimos.reservas');

	$hoy = date("Y-m-d H:i:s");

    $sql = "
        INSERT INTO
            wp_posts 
        VALUES (
            NULL, 
            1, 
            '".$hoy."', 
            '".$hoy."', 
            '', 
            'Orden - {$token}', 
            '', 
            'wc-completed', 
            'closed', 
            'closed', 
            '', 
            'orden-{$token}', 
            '', 
            '', 
            '".$hoy."',
            '".$hoy."',
            '', 
            0,
            'http://www.kmimos.com.mx/?post_type=shop_order',
            0, 
            'shop_order', 
            '', 
            0
        );
    ";
    $conn_my->query($sql);

    echo $sql."<br><br>";

    $id_order = $conn_my->insert_id;

    $sql = "
        INSERT INTO wp_postmeta VALUES(
            
            (NULL, '{$id_order}', '_customer_user',                         '367'),
            (NULL, '{$id_order}', '_order_total',                           '128.40'),
            (NULL, '{$id_order}', '_order_key',                             'wc_order_{$token}'),

            (NULL, '{$id_order}', '_order_stock_reduced',                   '1'),
            (NULL, '{$id_order}', '_cart_discount_tax',                     '0'),
            (NULL, '{$id_order}', '_cart_discount',                         '0'),
            (NULL, '{$id_order}', '_order_version',                         '2.5.5'),
            (NULL, '{$id_order}', '_payment_method',                        'Migrado'),
            (NULL, '{$id_order}', '_recorded_sales',                        'yes'),
            (NULL, '{$id_order}', '_download_permissions_granted',          '1'),
            (NULL, '{$id_order}', '_order_shipping_tax',                    '0'),
            (NULL, '{$id_order}', '_order_tax',                             '0'),
            (NULL, '{$id_order}', '_order_shipping',                        ''),
            (NULL, '{$id_order}', '_payment_method_title',                  'Migrado'),
            (NULL, '{$id_order}', '_created_via',                           'checkout'),
            (NULL, '{$id_order}', '_customer_user_agent',                   '',
            (NULL, '{$id_order}', '_customer_ip_address',                   '::1'),
            (NULL, '{$id_order}', '_prices_include_tax',                    'yes'),
            (NULL, '{$id_order}', '_order_currency',                        'MXN')
        );
    ";
    $conn_my->query( $sql );

    echo $sql."<br><br>";

	$sql = "
		INSERT INTO
            wp_posts 
        VALUES (
            NULL, 
            367, 
            '".$hoy."', 
            '".$hoy."', 
            '', 
            'Reserva - {$token}', 
            '', 
            'complete', 
            'closed', 
            'closed', 
            '', 
            'reserva-{$token}', 
            '', 
            '', 
            '".$hoy."',
            '".$hoy."',
            '', 
            {$id_order},
            'http://www.kmimos.com.mx/?post_type=wc_booking',
            0, 
            'wc_booking', 
            '', 
            0
        );
	";
	$conn_my->query($sql);
    echo $sql."<br><br>";
	$id_reserva = $conn_my->insert_id;








    $sql = "
        INSERT INTO
            wp_woocommerce_order_items
        VALUES (
            NULL, 
            'Hospedaje - Pedro P.', 
            'line_item', 
            '{$id_order}'
        );
    ";
    $conn_my->query($sql);
    $id_item = $conn_my->insert_id;

    echo $sql."<br><br>";

    $sql = "
        INSERT INTO wp_woocommerce_order_itemmeta VALUES(

            (NULL, '{$id_item}', 'Reserva ID', '{$id_reserva}'),

            (NULL, '{$id_item}', 'Duración', '9 Dias'),

            (NULL, '{$id_item}', 'Mascotas Medianos', '1'),
            (NULL, '{$id_item}', 'Mascotas Pequeños', '1'),

            (NULL, '{$id_item}', '_line_total',    '128.4'),
            (NULL, '{$id_item}', '_line_subtotal', '128.4'),

            (NULL, '{$id_item}', 'Fecha de Reserva', '11 marzo, 2017'),

            (NULL, '{$id_item}', '_product_id', '150448'),





            (NULL, '{$id_item}', 'Ofrecido por', 'Cuidador Kmimos'),
            (NULL, '{$id_item}', '_wc_deposit_meta', 'a:1:{s:6:\"enable\";s:2:\"no\";}'),
            (NULL, '{$id_item}', '_line_tax_data', 'a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}'),
            (NULL, '{$id_item}', '_line_tax', '0'),
            (NULL, '{$id_item}', '_line_subtotal_tax', '0'),
            (NULL, '{$id_item}', '_variation_id', '0'),
            (NULL, '{$id_item}', '_tax_class', ''),
            (NULL, '{$id_item}', '_qty', '1')
        );
    ";
    $conn_my->query( $sql );

    echo $sql."<br><br>";


    $num_mascotas = array(
        150449 => 1,          
        150450 => 2
    );

    $num_mascotas = serialize($num_mascotas);

	$sql = "
        INSERT INTO wp_postmeta VALUES(
            (NULL, '{$id_reserva}', '_booking_customer_id',     '367'),
            (NULL, '{$id_reserva}', '_booking_all_day',         '1'),
            (NULL, '{$id_reserva}', '_booking_end',             '20170219235959'),
            (NULL, '{$id_reserva}', '_booking_start',           '20170217000000'),
            (NULL, '{$id_reserva}', '_booking_cost',            '128.4'),
            (NULL, '{$id_reserva}', '_booking_persons',         '{$num_mascotas}'),
            (NULL, '{$id_reserva}', '_booking_order_item_id',   '{$id_item}'),
            (NULL, '{$id_reserva}', '_booking_product_id',      '150448')
        );
    ";

    echo $sql."<br><br>";
    $conn_my->query( $sql );




    $sql = "
        INSERT INTO
            wp_posts 
        VALUES (
            NULL, 
            367, 
            '".$hoy."', 
            '".$hoy."', 
            '', 
            'Orden del vendedor - prueba', 
            '', 
            'complete', 
            'closed', 
            'closed', 
            '', 
            'reserva-de-prueba-0001', 
            '', 
            '', 
            '".$hoy."',
            '".$hoy."',
            '', 
            {$id_order},
            'http://www.kmimos.com.mx/?post_type=wc_booking',
            0, 
            'shop_order_vendor', 
            '', 
            0
        );
    ";
    $conn_my->query($sql);

    echo $sql."<br><br>";

    $id_order_vendor = $conn_my->insert_id;

    $sql = "
        INSERT INTO wp_postmeta VALUES
            (NULL, '{$id_order_vendor}', '_order_total',               '128.40'),
            (NULL, '{$id_order_vendor}', '_cart_discount_tax',         '0'),
            (NULL, '{$id_order_vendor}', '_order_shipping_tax',        '0'),
            (NULL, '{$id_order_vendor}', '_order_currency',            'MXN'),
            (NULL, '{$id_order_vendor}', '_cart_discount',             '0'),
            (NULL, '{$id_order_vendor}', '_order_shipping',            '0'),
            (NULL, '{$id_order_vendor}', '_order_tax',                 '0')
        );
    ";
    $conn_my->query( $sql );

    echo $sql."<br><br>";


	

?>