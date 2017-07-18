<?php

$page = 0;
$limit = 1;
$table = $_subscribe->table;
$total = $_subscribe->result("SELECT * FROM $table");
$result = $_subscribe->result("SELECT * FROM $table LIMIT 0, 30");

if(count($result)==0){
    $_subscribe->insert(array('name' => $name  ,'email' => $mail , 'source' => $section,'time' => time()));
    $return['message']='Ha sido Registrado';
}else{
    $return['message']='Ya se encuentra registrado';
}

?>


