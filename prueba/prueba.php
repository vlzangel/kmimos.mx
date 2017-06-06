<?php
	$descriptorspec = array(
	   0 => array("pipe", "r"),  // stdin es una tubería usada por el hijo para lectura
	   1 => array("pipe", "w"),  // stdout es una tubería usada por el hijo para escritura
	   2 => array("file", "./temp_error/error.txt", "a") // stderr es un fichero para escritura
	);

	$process = proc_open('git status', $descriptorspec, $pipes, NULL, NULL);

	if (is_resource($process)) {
	    // $pipes ahora será algo como:
	    // 0 => gestor de escritura conectado al stdin hijo
	    // 1 => gestor de lectura conectado al stdout hijo
	    // Cualquier error de salida será anexado a /tmp/error-output.txt

	    fwrite($pipes[0], '<?php print_r($_ENV); ?>');
	    fclose($pipes[0]);

	    echo "--".stream_get_contents($pipes[1])."--";
	    fclose($pipes[1]);

	    // Es importante que se cierren todas las tubería antes de llamar a
	    // proc_close para evitar así un punto muerto
	    $return_value = proc_close($process);

	    echo "command returned $return_value\n";
	}else{
		echo " is_resource(\$process): false ";
	}
?>