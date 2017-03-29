<?php
	include("../../../../vlz_config.php");

	$conn_my = new mysqli($host, $user, $pass, $db);

	extract($_POST);

	switch ($action) {

		case 'administradores':

			$sql = "
				SELECT 
					U.ID			AS id,
					U.user_email 	AS email,
					U.display_name 	AS nombre
				FROM 
					wp_users AS U 
				INNER JOIN wp_usermeta AS UM_1 ON ( U.ID = UM_1.user_id ) 
				WHERE 
					1=1 AND 
					( UM_1.meta_key = 'wp_capabilities' AND UM_1.meta_value = 'a:1:{s:13:\"administrator\";b:1;}' ) 
				GROUP BY 
					U.ID
			";

			$result = $conn_my->query($sql);

			$resultados = "";
			while( $admin = $result->fetch_assoc() ){
				extract($admin);

				$tipo = $conn_my->query("SELECT meta_value AS tipo FROM wp_usermeta WHERE user_id = {$id} AND meta_key = 'tipo_usuario'");

				if($tipo->num_rows > 0 ){
					$tipo = $tipo->fetch_assoc();
					$tipo = $tipo['tipo'];
				}else{
					$tipo = "Administrador";
				}

				$resultados .= "
				<tr>
					<td>{$admin['nombre']}</td>
					<td>{$admin['email']}</td>
					<td style='width: 150px;'> <span class='editar_tipo_usuario' data-id='{$admin['id']}' data-tipo='{$tipo}'>{$tipo}</span> </td>
				</tr>";

			}

			echo $resultados;

		break;

		case "update_tipo_usuario":

			$xtipo = $conn_my->query("SELECT meta_value AS tipo FROM wp_usermeta WHERE user_id = {$id} AND meta_key = 'tipo_usuario'");
			if($xtipo->num_rows == 0 ){
				$conn_my->query("INSERT INTO wp_usermeta VALUES (NULL, {$id}, 'tipo_usuario', '{$tipo}')");
			}else{
				$conn_my->query("UPDATE wp_usermeta SET meta_value = '{$tipo}' WHERE user_id = '{$id}' AND meta_key = 'tipo_usuario';");
			}

		break;
		
	}

	return;
?>