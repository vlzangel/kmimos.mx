<?php
    include("../../../../../wp-load.php");

    extract($_POST);

    $HTML = "
    	<p style='text-align: justify;'>
    		<table>
    			<tr>
    				<td>
				    	<strong>Nombre:</strong><br>
				    	<strong>Email:</strong><br>
				    	<strong>Asunto:</strong><br>
				    	<strong>Mensaje:</strong>
				    </td>
				    <td>
			    		{$nombre}<br>
						{$email}<br>
						{$asunto}<br>
						{$mensaje}
				    </td>
	    		</tr>
	    	</table>
    	</p>
    ";

    $asunto = "Mensaje: {$asunto}";

    $info = kmimos_get_info_syte();

    // wp_mail($info["email"], $asunto, $HTML);
    wp_mail("a.veloz@kmimos.la", $asunto, $HTML);

    exit;
?>