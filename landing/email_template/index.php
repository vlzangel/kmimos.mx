<?php
$http = (isset($_SERVER['HTTPS']))? 'https://' : 'http://' ;

$username = 'italo';

include ("club-paticipante-referido.php");
echo "$html.<br>";

include("club-referido-existe.php");
echo "$html.<br>";

include("club-referido-primera-reserva.php");
echo "$html.<br>";

include("club-paticipante-referido.php");
echo "$html.<br>";

include("club-nuevo-usuario.php");
echo "$html.<br>";

include("club-registro-participante.php");
echo "$html.<br>";
