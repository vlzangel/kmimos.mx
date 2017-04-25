<?php
// Paginas Permitiddas con este Estilos
$array_backpanel = [
	'bp_reservas', 
	'bp_conocer_cuidador', 
	'bp_usuarios', 
	'bp_suscriptores'
];
if(in_array($_GET['page'], $array_backpanel)){
	include("style_backpanel.php");
}