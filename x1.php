<?php
	function redimencionar($base, $subpath, $img){
		$origen = $base."avatares/".$subpath."/".$img;
		$destino = $base."avatares_new/".$subpath."/".$img;
	
		if( !file_exists($base."avatares_new/".$subpath."/") ){
	    	@mkdir($base."avatares_new/".$subpath."/");
	    }

		$sExt = @mime_content_type( $origen );

	    switch( $sExt ) {
	        case 'image/jpeg':
	            $aImage = @imageCreateFromJpeg( $origen );
	        break;
	        case 'image/gif':
	            $aImage = @imageCreateFromGif( $origen );
	        break;
	        case 'image/png':
	            $aImage = @imageCreateFromPng( $origen );
	        break;
	        case 'image/wbmp':
	            $aImage = @imageCreateFromWbmp( $origen );
	        break;
	    }

	    $nWidth  = 400;
	    $nHeight = 400;

	    $aSize = @getImageSize( $origen );

	    if( $aSize[0] == 0 ){
	    	//@unlink($origen);
	    	echo $origen." ==> Tamaño en cero (0)<br>";
	    }else{
		    if( $aSize[0] > $aSize[1] ){
		        $nHeight = @round( ( $aSize[1] * $nWidth ) / $aSize[0] );
		    }else{
		        $nWidth = @round( ( $aSize[0] * $nHeight ) / $aSize[1] );
		    }

		    $aThumb = @imageCreateTrueColor( $nWidth, $nHeight );

		    @imageCopyResampled( $aThumb, $aImage, 0, 0, 0, 0, $nWidth, $nHeight, $aSize[0], $aSize[1] );

		    @imagejpeg( $aThumb, $destino );

		    @imageDestroy( $aImage );
		    @imageDestroy( $aThumb );

	    }

	}

	function reducir($base, $id){
		if( is_dir($base) ){
	    	if ($dh = opendir($base."avatares/".$id)) { 
		        while (($file = readdir($dh)) !== false) { 
		            if ( $file!="." && $file != ".." ){ 
	            		redimencionar($base, $id, $file);
	            		//echo $base."avatares/".$id."/".$file."<br>";
		            } 
		        } 
		      	closedir($dh);
	        }
	    }
	}

	$base = "wp-content/uploads/cuidadores/";

/*	if( !file_exists($base."avatares_new/") ){
    	mkdir($base."avatares_new/");
    }*/

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