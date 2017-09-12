<?php  
	include(__DIR__."../../../../../../vlz_config.php");

    extract($_POST);
	
    $conn = new mysqli($host, $user, $pass, $db);

	$errores = array();

	if ($conn->connect_error) {
        echo 'false';
	}else{
		$name_photo = "";
        $user_photo = 0;
        if( $image != "" ){
            $name_photo = time();
            $user_photo = 1;
            $img = end(explode(',', $image));
            $sImagen = base64_decode($img);
            $dir = "../../../../uploads/avatares_clientes/{$user_id}/";
            @mkdir($dir);
            file_put_contents($dir.'temp.jpg', $sImagen);
            $sExt = mime_content_type( $dir.'temp.jpg' );
            switch( $sExt ) {
                case 'image/jpeg': $aImage = @imageCreateFromJpeg( $dir.'temp.jpg' ); break;
                case 'image/gif':  $aImage = @imageCreateFromGif( $dir.'temp.jpg' );  break;
                case 'image/png':  $aImage = @imageCreateFromPng( $dir.'temp.jpg' );  break;
                case 'image/wbmp': $aImage = @imageCreateFromWbmp( $dir.'temp.jpg' ); break;
            }
            $nWidth  = 800;
            $nHeight = 600;
            $aSize = getImageSize( $dir.'temp.jpg' );
            if( $aSize[0] > $aSize[1] ){
                $nHeight = round( ( $aSize[1] * $nWidth ) / $aSize[0] );
            }else{
                $nWidth = round( ( $aSize[0] * $nHeight ) / $aSize[1] );
            }
            $aThumb = imageCreateTrueColor( $nWidth, $nHeight );
            imageCopyResampled( $aThumb, $aImage, 0, 0, 0, 0, $nWidth, $nHeight, $aSize[0], $aSize[1] );
            imagejpeg( $aThumb, $dir.$name_photo.".jpg" );
            imageDestroy( $aImage );
            imageDestroy( $aThumb );
            unlink($dir."temp.jpg");
        }

        $existen = $conn->query( "SELECT * FROM wp_users WHERE ID = '{$userid}'" );
        if( $existen->num_rows > 0 ){
            
            $sql = "
                INSERT INTO wp_postmeta VALUES
                    (NULL, {$userid},'_wp_attached_file',   '{$image}'),
                    (NULL, {$userid}, 'name_pet',            '{$name_pet}'),
                    (NULL, {$userid}, 'type_pet',            '{$type_pet}'),
                    (NULL, {$userid}, 'race_pet',            '{$race_pet}'),
                    (NULL, {$userid}, 'colour_pet',          '{$colour_pet}'),
                    (NULL, {$userid}, 'date_birth',          '{$date_birth}'),
                    (NULL, {$userid}, 'gender_pet',          '{$gender_pet}'),
                    (NULL, {$userid}, 'size_pet',            '{$size_pet}'),
                    (NULL, {$userid}, 'pet_sterilized',      '{$pet_sterilized}'),
                    (NULL, {$userid}, 'pet_sociable',        '{$pet_sociable}'),
                    (NULL, {$userid}, 'aggresive_humans',    '{$aggresive_humans}'),
                    (NULL, {$userid}, 'aggresive_pets',      '{$aggresive_pets}'),
                    (NULL, {$userid}, 'rich_editing',        'true'),
                    (NULL, {$userid}, 'comment_shortcuts',   'false'),
                    (NULL, {$userid}, 'admin_color',         'fresh'),
                    (NULL, {$userid}, 'use_ssl',             '0'),
                    (NULL, {$userid}, 'show_admin_bar_front','false'),
                    (NULL, {$userid}, 'wp_capabilities',     'a:1:{s:10:\"subscriber\";b:1;}'),
                    (NULL, {$userid}, 'wp_user_level',       '0');
            ";
            $conn->query( utf8_decode( $sql ) );

            echo "Registrado"; //$user_id.;
        }else{
            echo "Usuario No registrado.";
            exit;
        }  
	}
?>