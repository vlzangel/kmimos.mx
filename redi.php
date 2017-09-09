<?php
	function redimencionar($base, $subpath, $img){
		
		if( file_exists($base."miniatura/".$subpath."/".$img) ){
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
		    	//@unlink($base.$subpath."/".$img);
		    	echo $base.$subpath."/".$img." ==> Tamaño en cero (0)<br>";
		    }else{
			    if( $aSize[0] > $aSize[1] ){
			        $nHeight = @round( ( $aSize[1] * $nWidth ) / $aSize[0] );
			    }else{
			        $nWidth = @round( ( $aSize[0] * $nHeight ) / $aSize[1] );
			    }

			    $aThumb = @imageCreateTrueColor( $nWidth, $nHeight );

			    @imageCopyResampled( $aThumb, $aImage, 0, 0, 0, 0, $nWidth, $nHeight, $aSize[0], $aSize[1] );

			    if( !file_exists($base."avatares_new/".$subpath."/") ){
			    	@mkdir($base."avatares_new/".$subpath."/");
			    }

			    @imagejpeg( $aThumb, $base."avatares_new/".$subpath."/".$img );

			    @imageDestroy( $aImage );
			    @imageDestroy( $aThumb );

		    }

		}
	}

	function reducir($base, $id){
		if( is_dir($base) ){
	    	if ($dh = opendir($base."avatares/".$id)) { 
		        while (($file = readdir($dh)) !== false) { 
		            if ( $file!="." && $file != ".." ){ 
	            		redimencionar($base, $id, $file);
		            } 
		        } 
		      	closedir($dh);
	        }
	    }
	}

	$base = "wp-content/uploads/cuidadores/";

	if( !file_exists($base."avatares_new/") ){
    	mkdir($base."avatares_new/");
    }

    if( is_dir($base) ){
    	if ($dh = opendir($base."avatares/")) { 
	        while (($file = readdir($dh)) !== false) { 
	            if ( $file!="." && $file != ".."){ 
	            	reducir($base, $file);
	            } 
	        } 
	      	closedir($dh);
        }
    }
?>