<?php
// Paginas Permitiddas con este Estilos
$array_backpanel = ['bp_Reservas', 'bp_Reservas_old'];
if(in_array($_GET['page'], $array_backpanel)){
	include("style_backpanel.php");
}