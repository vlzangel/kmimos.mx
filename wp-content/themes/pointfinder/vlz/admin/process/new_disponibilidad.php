<?php
    include("../../../../../../vlz_config.php");
    include("../funciones/kmimos_funciones_db.php");

    $db = new db( new mysqli($host, $user, $pass, $db) );

    extract($_POST);

    $rangos = $db->get_var(" SELECT meta_value FROM wp_postmeta WHERE post_id = '{$servicio}' AND meta_key = '_wc_booking_availability' ", "meta_value");
    $rangos = unserialize($rangos);

    $temp = array(
    	"type" => "custom",
        "bookable" => "no",
        "priority" => "10",
        "from" => $inicio,
        "to" => $fin
    );

    $rangos[] = $temp;
    
    $rangos = serialize($rangos);
    $db->query(" UPDATE wp_postmeta SET meta_value = '{$rangos}' WHERE post_id = '{$servicio}' AND meta_key = '_wc_booking_availability' ");

    $rangos = $db->get_var(" SELECT meta_value FROM wp_postmeta WHERE post_id = '{$servicio}' AND meta_key = '_wc_booking_availability' ", "meta_value");
    $rangos = unserialize($rangos);
?>