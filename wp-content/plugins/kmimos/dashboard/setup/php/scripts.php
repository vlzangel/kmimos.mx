<?php
	function paginas(){
		global $wpdb;
		$sql = "SELECT * FROM wp_posts WHERE post_type = 'page' AND post_status = 'publish'";
		$paginas = $wpdb->get_results($sql);
		$resultados = [];
		if( count($paginas) > 0 ){
			foreach ($paginas as $key => $value) {
				
				$descripcion = $wpdb->get_var("SELECT meta_value AS descripcion FROM wp_postmeta WHERE post_id = '{$value->ID}' AND meta_key = 'kmimos_descripcion'");
				if( $descripcion  == null){
					$descripcion  = "";
				}

				$resultados["registros"][] = [
					$value->ID,
					($descripcion),
					($value->post_title),
					$value->post_name
				];
			}
		}
		
		$json = json_encode($resultados);
		echo ( "<script> var paginas = jQuery.parseJSON( '".$json."' ); </script>" );
	}

	function administradores(){
		global $wpdb;
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
		";

		$result = $wpdb->get_results($sql);

		$resultados = [];
		if( count($result) > 0 ){
			foreach ($result as $admin) {

				$tipo = $wpdb->get_var("SELECT meta_value AS tipo FROM wp_usermeta WHERE user_id = {$admin->id} AND meta_key = 'tipo_usuario'");
				if($tipo == "" ){ $tipo = "Administrador"; }

				$resultados["registros"][] = [
					$admin->id,
					$admin->email,
					$admin->nombre,
					$tipo,
					md5($admin->id)
				];

				/*$resultados .= "
				<tr class='editar_tipo_usuario' data-id='{$admin['id']}' data-tipo='{$tipo}'>
					<td> <a href='".get_home_url()."/?i=".md5($id)."'> {$nombre} </a> </td>
					<td>{$email}</td>
					<td style='width: 150px;'> <span>{$tipo}</span> </td>
				</tr>";*/
			}

		}
		
		$json = json_encode($resultados);
		echo ( "<script> var administradores = jQuery.parseJSON( '".$json."' ); </script>" );
	}
?>