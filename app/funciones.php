<?php

	function path(){
		return dirname(__DIR__)."/";
	}

	function home(){
        global $db;
		// $home = $db->get_var("SELECT option_value FROM wp_options WHERE option_name = 'siteurl'");
		$home = "http://192.168.0.105/kmis/new_kmimos.mx/";

		return $home;
	}
		
	function app_kmimos_get_foto($user_id){
        global $db;
        $name_photo = $db->get_var("SELECT meta_value FROM wp_usermeta WHERE user_id = {$user_id} AND meta_key = 'name_photo'");
        $base = "wp-content/uploads/avatares_clientes/miniatura/";
        $subPath = "wp-content/uploads/avatares_clientes/miniatura/{$user_id}_";
        $home = home().$base;
        if( empty($name_photo)  ){ $name_photo = "0"; }
        if( file_exists(path().$subPath."{$name_photo}") ){
            $img = "{$name_photo}";
        }else{
            if( file_exists(path().$subPath."0.jpg") ){
                $img = "0.jpg";
            }else{
                return home().'wp-content/themes/pointfinder/images/noimg.png';
            }
        }
        $img = home().$subPath.$img;
        return $img;
    }
		
	function app_kmimos_get_foto_cuidador($id){
        global $db;
        $cuidador = $db->get_row("SELECT * FROM cuidadores WHERE id = ".$id);
        $name_photo = $db->get_var("SELECT meta_value FROM wp_usermeta WHERE user_id = {$cuidador->user_id} AND meta_key = 'name_photo'");
        $base = "wp-content/uploads/cuidadores/avatares/miniatura/";
        $subPath = "wp-content/uploads/cuidadores/avatares/miniatura/{$id}_";
        $home = home().$base;
        if( empty($name_photo)  ){ $name_photo = "0"; }
        if( count(explode(".", $name_photo)) == 1 ){ $name_photo .= "jpg";  }
        if( file_exists(path().$subPath."{$name_photo}") ){
            $img = "{$name_photo}";
        }else{
            if( file_exists(path().$subPath."0.jpg") ){
                $img = "0.jpg";
            }else{
                return home().'wp-content/themes/pointfinder/images/noimg.png';
            }
        }
        $img = home().$subPath.$img;
        return $img;
    }

	function app_kmimos_get_fotos_galeria($id){
        $id_cuidador = $id-5000;
        $base = "wp-content/uploads/cuidadores/galerias/";
		$sub_path_galeria = "wp-content/uploads/cuidadores/galerias/miniatura/".$id_cuidador."/";
		$path_galeria = path().$sub_path_galeria;
		$home = home().$base;
        $imagenes = array();
        if( is_dir($path_galeria) ){
        	if ($dh = opendir($path_galeria)) { 
		        while (($file = readdir($dh)) !== false) { 
		            if (!is_dir($path_galeria.$file) && $file!="." && $file!=".."){ 
		            	$imagenes[] = home().$sub_path_galeria.$file;
		            } 
		        }
		      	closedir($dh);
            }
        }
        return $imagenes;
    }

?>