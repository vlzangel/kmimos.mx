<?php

//include_once(dirname(dirname(dirname(__DIR__))).'/wlabel.php');
//$return['message']=$_wlabel_user->LogOut();

//FILE
$module=$_GET['module'];
$urlbase=$_GET['urlbase'];
$file='/csv/detalle_'.$module.'_'.date('Ymd',time()).'.csv';
$file_path=dirname(__FILE__).$file;
$file_url=$urlbase.$file;


$text="";
$text.=$_GET['title']."\n\n";
$text.=$_GET['data'];


////// CREATE CSV
$handle = fopen($file_path,'w+');
fwrite($handle,$text);
fclose($handle);

$return['message']='Exportado';
$return['file']='<a class="file" href="'.$file_url.'">Ver CSV</a>';
echo json_encode($return);
?>