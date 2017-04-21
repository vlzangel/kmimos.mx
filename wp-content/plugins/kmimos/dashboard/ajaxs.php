<?php
	require_once("../../../../vlz_config.php");

	$conn_my = new mysqli($host, $user, $pass, $db);

	extract($_POST);

	switch ($action) {

		case 'administradores':

			$sql = "
				SELECT 
					SQL_CALC_FOUND_ROWS
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
				LIMIT $pagina, 10
			";

			$result = $conn_my->query($sql);

			$num_rows = $conn_my->query('SELECT FOUND_ROWS() AS cantidad');
			$paginas = $num_rows->fetch_assoc();
			$paginas = $paginas['cantidad'];

			$item_by_page = 10;
			$paginacion = "";

			$resultados = "";
			while( $admin = $result->fetch_assoc() ){
				extract($admin);

				$tipo = $conn_my->query("SELECT meta_value AS tipo FROM wp_usermeta WHERE user_id = {$id} AND meta_key = 'tipo_usuario' LIMIT $pagina, 10");

				if($tipo->num_rows > 0 ){
					$tipo = $tipo->fetch_assoc();
					$tipo = $tipo['tipo'];
				}else{
					$tipo = "Administrador";
				}

				$resultados .= "
				<tr class='editar_tipo_usuario' data-id='{$admin['id']}' data-tipo='{$tipo}'>
					<td> <a href='".$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/?i=".md5($id)."'> {$admin['nombre']} </a> </td>
					<td>{$admin['email']}</td>
					<td style='width: 150px;'> <span>{$tipo}</span> </td>
				</tr>";

			}

			$t = $total_registros+$paginas;
			if($t > $item_by_page){
				$ps = ceil($t/$item_by_page);
				for( $i=1; $i<$ps; $i++){
					$active = ( $pagina == ($i-1) || ($pagina == 0 && $i == 1)  ) ? "kmimos_paginacion_activa" : "";
					$paginacion .= "<span class='kmimos_paginacion_item {$active}' onclick='listar_administradores(".($i-1).")' ".$active.">".$i."</span>";
				}
			}else{
				$paginacion .= "<span class='kmimos_paginacion_item kmimos_paginacion_activa'>1</span>";
			}
			$w = 40*$ps;
			
			$resultados = $resultados."===="."<div class='kmimos_paginacion'>".$paginacion."</div>";

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

		case "paginas":
			$xpagina = $_POST['pagina']*10;

			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM wp_posts WHERE post_type = 'page' AND post_status = 'publish' LIMIT $xpagina, 10";
			$paginas = $conn_my->query($sql);

			$num_rows = $conn_my->query('SELECT FOUND_ROWS() AS cantidad');
			$total_registros = $num_rows->fetch_assoc();
			$total_registros = $total_registros['cantidad'];

			$item_by_page = 10;
			$paginacion = "";

			$resultados = [];
			$resultados["log"] = $sql;
			if( $paginas->num_rows > 0 ){
				while( $xpagina = $paginas->fetch_assoc() ){
					extract($xpagina);

					$num_rows = $conn_my->query("SELECT meta_value AS descripcion FROM wp_postmeta WHERE post_id = '{$ID}' AND meta_key = 'kmimos_descripcion'");
					$descripcion = $num_rows->fetch_assoc();
					$descripcion = ($descripcion['descripcion'] != null) ? $descripcion['descripcion'] : "";

					$resultados["registros"][] = [
						$ID,
						($descripcion),
						($post_title),
						$post_name
					];
				}
			} 

			$t = $total_registros;
			if($t > $item_by_page){
				$ps = ceil($t/$item_by_page)+1;
				for( $i=1; $i<$ps; $i++){
					$active = ( $pagina == ($i-1) || ($pagina == 0 && $i == 1)  ) ? "kmimos_paginacion_activa" : "";
					$resultados["paginas"][] = [
						$i,
						$active
					];
				}
			}

			$resultados["total"] = $total_registros;

			echo json_encode(utf8_encode($resultados));

		break;

		case "update_descripcion":
			$xtipo = $conn_my->query("SELECT meta_value AS descripcion FROM wp_postmeta WHERE post_id = {$id} AND meta_key = 'kmimos_descripcion'");
			$desc = utf8_decode($desc);
			if($xtipo->num_rows == 0 ){
				$conn_my->query("INSERT INTO wp_postmeta VALUES (NULL, {$id}, 'kmimos_descripcion', '{$desc}')");
			}else{
				$conn_my->query("UPDATE wp_postmeta SET meta_value = '{$desc}' WHERE post_id = '{$id}' AND meta_key = 'kmimos_descripcion';");
			}
		break;
		
	}

	return;
?>