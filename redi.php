<?php
	function redimencionar($base, $subpath, $img){
		
		if( file_exists($base."miniatura/".$subpath."_".$img) ){
			echo $base.$subpath."/".$img."<br>";
		}else{
			$sExt = @mime_content_type( $base.$subpath."/".$img );

		    switch( $sExt ) {
		        case 'image/jpeg':
		            $aImage = @imageCreateFromJpeg( $base.$subpath."/".$img );
		        break;
		        case 'image/gif':
		            $aImage = @imageCreateFromGif( $base.$subpath."/".$img );
		        break;
		        case 'image/png':
		            $aImage = @imageCreateFromPng( $base.$subpath."/".$img );
		        break;
		        case 'image/wbmp':
		            $aImage = @imageCreateFromWbmp( $base.$subpath."/".$img );
		        break;
		    }

		    $nWidth  = 400;
		    $nHeight = 400;

		    $aSize = @getImageSize( $base.$subpath."/".$img );

		    if( $aSize[0] == 0 ){
		    	unlink($base.$subpath."/".$img);
		    }else{
			    if( $aSize[0] > $aSize[1] ){
			        $nHeight = @round( ( $aSize[1] * $nWidth ) / $aSize[0] );
			    }else{
			        $nWidth = @round( ( $aSize[0] * $nHeight ) / $aSize[1] );
			    }

			    $aThumb = @imageCreateTrueColor( $nWidth, $nHeight );

			    @imageCopyResampled( $aThumb, $aImage, 0, 0, 0, 0, $nWidth, $nHeight, $aSize[0], $aSize[1] );

			    if( !file_exists($base."miniatura/") ){
			    	mkdir($base."miniatura/");
			    }

			    @imagejpeg( $aThumb, $base."miniatura/".$subpath."_".$img );

			    @imageDestroy( $aImage );
			    @imageDestroy( $aThumb );

		    }

		}
	}

	function reducir($id){
		$base = "wp-content/uploads/avatares_clientes/";
		if( is_dir($base) ){
	    	if ($dh = opendir($base.$id)) { 
		        while (($file = readdir($dh)) !== false) { 
		            if ( $file!="." && $file != ".." && $file != "miniatura" ){ 
	            		redimencionar($base, $id, $file);
		            } 
		        } 
		      	closedir($dh);
	        }
	    }
	}

	$base = "wp-content/uploads/avatares_clientes/";

    if( is_dir($base) ){
    	if ($dh = opendir($base)) { 
	        while (($file = readdir($dh)) !== false) { 
	            if ( $file!="." && $file != ".." && $file != "miniatura" ){ 
	            	reducir($file);
	            } 
	        } 
	      	closedir($dh);
        }
    }
?>