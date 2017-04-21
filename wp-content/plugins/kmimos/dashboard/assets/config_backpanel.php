<?php
// Paginas Permitiddas con este Estilos
$array_backpanel = ['bp_reservas', 'bp_conocer_cuidador'];
if(in_array($_GET['page'], $array_backpanel)){
	include("style_backpanel.php");
}