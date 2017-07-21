<?php
    include("../../../../../../vlz_config.php");
    include("../funciones/kmimos_funciones_db.php");

    $db = new db( new mysqli($host, $user, $pass, $db) );

    extract($_POST);

    $rangos = $db->get_var(" SELECT meta_value FROM wp_postmeta WHERE post_id = '{$servicio}' AND meta_key = '_wc_booking_availability' ", "meta_value");
    $rangos = unserialize($rangos);

    $rangos_2 = array();

    foreach ($rangos as $key => $value) {

        if( $value["from"] != $inicio && $value["to"] != $fin ){

            $temp = array(
                "type" => "custom",
                "bookable" => "no",
                "priority" => "10",
                "from" => $value["from"],
                "to" => $value["to"]
            );

            $rangos_2[] = $temp;

        }
    }
    
    $rangos = serialize($rangos_2);
    $db->query(" UPDATE wp_postmeta SET meta_value = '{$rangos}' WHERE post_id = '{$servicio}' AND meta_key = '_wc_booking_availability' ");
?>