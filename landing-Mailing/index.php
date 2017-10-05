<!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link href="https://fonts.googleapis.com/css?family=Lato:700,900" rel="stylesheet">
		<style>
			body{
				background: #fff;
				color: #3a3a3a;
				font-family: "Lato", sans-serif;
				font-weight: 900!important;
				word-wrap: break-word;
			}
			section{clear: both;}

			strong{font-weight: 900;}
			.col6{width: 50%;}
			.col12{width: 100%;}
			[class*="col"]{
				float: left;
			}
			/***************************************/
			/*  CABECERA                           */
			/***************************************/
			.container-fluid{padding: 0px!important; margin: 0px!important;width: 100%!important;background:#9c2a81!important;}
			#top-kmimos{padding-right: 11px; padding-top: 7px; width: 21%;}
			#top-volaris{padding-right: 8px; width: 30%;}
			.contenido {background: #9c2a81!important;width: 100%; height: 45%;margin-top: -7%;}
			.contenido p {font-size: 16pt;color: #fff;text-align: right;top: 10%; position: relative;right: 10%;}
			.btn-reserva{width: 45%; position: relative; left: 45%;margin-top: 10%;}
			/***************************************/
			/*  Section-1                          */
			/***************************************/
			#section-1{background: #fff;color: #000;font-weight: lighter;height: 75%;overflow: hidden}
			#section-1 h1{margin-bottom: 10px;font-size: 30pt;margin-top: 3%;margin-left: 4%;}
			#section-1 h2{margin-bottom: 10px;font-size: 20pt;margin-top: 45%; margin-left: 7%;}
			#section-1 img{width: 50%; margin-top: 8%;}
			.sp {margin-left: -10%;}
			#top-content p {font-size: 15pt; text-align: center; margin-bottom: 3%;}
			/***************************************/
			/*  Section-2                          */
			/***************************************/
			#section-2{background: #fff;color: #000;font-weight: lighter;height: 70%;overflow: hidden}
			#section-2 h1{font-size: 22pt;margin-left: 5%;}
			#section-2 h2{margin-bottom: 10px;font-size: 27pt;margin-top: 12%;}
			#section-2 img{width: 70%;margin-bottom: 10%;margin-top: 6%;margin-left: 20%;}
			#section-2 p {font-size: 14pt; text-align: center;margin-top: -6%;margin-bottom: 5%;}
			.clas-o{position: relative; left: 49%; color: #a92382; font-size: 17pt;margin-top: -9%;}
			/***************************************/
			/*  Section-content                    */
			/***************************************/
			#section-content{background: #fff;}

			/***************************************/
			/*  Section-3                          */
			/***************************************/
			#section-3{background: #fff;color: #000;font-weight: lighter;height: 40%;overflow: hidden}
			#section-3 h1{margin-bottom: 10px;font-size: 30pt;margin-top: 3%;}
			#section-3 h2{margin-bottom: 10px;font-size: 27pt;margin-top: 12%;}
			#section-3 img{width: 70%;margin-bottom: 10%;margin-top: 6%;margin-left: 20%;}
			#section-3 p {font-size: 15pt; text-align: center; color: #000;}
		

			
			#contactos {
				background: black;
				color: #fff;
			}
			#contactos img{
				display: inline-block;
				text-align: right;
				margin: 10px;
				margin-left: 70%; 
			}
		</style>
    </head>
    <body style="width: 600px; margin:auto auto; font-size: 18px;">
    	<div style="background:#000;padding-left: 0px;padding-right: 0px;">
	    	<div style="padding-left: 0px;padding-right: 0px;">
	    		<!-- <img id="top-volaris" src="http://mx.kmimos.dev/landing/landing/img/logo-top-volaris.jpg"> -->
	    		<img id="top-volaris" src="'.$http.$_SERVER["HTTP_HOST"].'/landing/img/logo-top-volaris.jpg">
	    	</div>
	    	<div class="clearfix"></div>
    	</div>
       	<div class="container-fluid">       		
    	   	<div>       		
				<div class="col6">
					<!-- <a href="#"><img src="https://kmimos.com.mx/landing/img/Image-1.jpg" style="width: 100%;margin-left: -3%;"></a> -->
					<img src="'.$http.$_SERVER["HTTP_HOST"].'/landing/img/Image-1.jpg" style="width: 100%;margin-left: 0%;height: 45%;">
				</div>
				<div class="col6" >
					<div class="contenido">
	    				<p>Viaja tranquilo <br> deja a tu perro seguro <br> en el hogar de una <br>verdadera familia</p>
	    				<!-- <img src="https://kmimos.com.mx/landing/img/Button-2.jpg" alt="boton 1" class="btn-reserva"> -->
	    				<a href="https://www.kmimos.com.mx/"><img src="'.$http.$_SERVER["HTTP_HOST"].'/landing/img/Button-2.jpg" alt="boton 1" class="btn-reserva"></a>
	    			</div>
				</div>
			</div>
		</div>			
		<section class="text-center" id="section-1">
       	 	<article id="top-content" class="col12">
				<h1><span style="color: #a92382;">+1000</span> Cuidadores Certificados</h1>
				<p>Conoce Kmimos, una red de <span style="color: #a92382;">Cuidadores Certificados que <br> hospedan a tu mascota</span> en su hogar para que t&uacute; viajes tranquilo</p>
       	 	</article>
			<article class="col6">
				<h2>Kmimos te ofrece:</h2>
			</article>
			<article class="col6">
				<div class="col12 sp">
					<div class="col6">
						<!-- <img src="https://kmimos.com.mx/landing/img/Icon-1.png" alt="" style="margin-top: 37%;"> -->
						<img src="'.$http.$_SERVER["HTTP_HOST"].'/landing/img/Icon-1.png" alt="" style="margin-top: 37%;">
					</div>
					<div class="col6" style="font-size: 12pt;">
						<p class="parr">Cuidadores Certificados <br> que pasaron por pruebas <br>psicom&eacute;tricas y de <br> conocimiento veterinario</p>
					</div>
				</div>
				<div class="col12 sp" style=" margin-top: 4%;">
					<div class="col6">
						<!-- <img src="https://kmimos.com.mx/landing/img/Icon-2.png" alt=""> -->
						<img src='.$http.$_SERVER["HTTP_HOST"].'/landing/img/Icon-2.png" alt="">
					</div>
					<div class="col6" style=" font-size: 12pt;">
						<p class="parr">Cobertura de serv&iacute;cios <br> veterinarios durante <br> toda su estad&iacute;a</p>
					</div>
				</div>
			</article>
		</section>
		<section class="content" id="section-2">
			<div id="section-content">
				<article id="proceso-reserva" class="bg-volaris col12 text-center">
					<h1>¡Reserva con Kmimos al viaja con Volaris!</h1>
				</article>
			</div>
			<div class="col12">
				<div class="col6">
					<!-- <img src="https://kmimos.com.mx/landing/img/Image-2.jpg" style="margin-left: 26%;"> -->
					<img src="'.$http.$_SERVER["HTTP_HOST"].'/landing/img/Image-2.jpg" style="margin-left: 26%;">
					<p style="margin-left: 30%;">D&eacute;jalo en tu ciudad <br> de origen</p>
				</div>
				<div class="col6">
					<!-- <img src="https://kmimos.com.mx/landing/img/Image-3.jpg" style="margin-left: 8%;"> -->
					<img src="'.$http.$_SERVER["HTTP_HOST"].'/landing/img/Image-3.jpg" style="margin-left: 8%;">
					<p style="margin-left: -22%;">Que lo apapache un <br>cuidador en tu destino</p>
				</div>
				<div class="clas-o col12">&Oacute;</div>
			</div>
		</section>
		<section class="content" id="section-3">
			<div class="col12">
				<p><span style="color: #a92382;">¡Aprovecha nuestras promociones de </span>noviembre y diciembre<span style="color: #a92382;">!</span></p>
				<p><span style="color: #a92382;">¡Disfruta de tu viaje. Tu mejor amigo estar&aacute; en buenas manos!</span></p>
			</div>
			<div class="col12">
				<div class="col6">
					<!-- <a href="#"><img src="https://kmimos.com.mx/landing/img/Button-1.jpg" alt=""></a> -->
					<a href="#"><img src="'.$http.$_SERVER["HTTP_HOST"].'/landing/img/Button-1.jpg" alt=""></a>
				</div>
				<div class="col6">
					<!-- <a href="#"><img src="https://kmimos.com.mx/landing/img/Button-2.jpg" alt=""></a> -->
					<a href="#"><img src="http://mx.kmimos.dev/landing/img/Button-2.jpg" alt=""></a>
				</div>
			</div>
		</section>
		<section id="contactos" class="col12">
			<div class="container bg-black">
				<article class="text-right">
					<!-- <img src="https://kmimos.com.mx/landing/img/Logo-Kmimos.png" class="img-responsive logo-kmimos" width="150px" > -->
					<img src="'.$http.$_SERVER["HTTP_HOST"].'/landing/img/Logo-Kmimos.png" class="img-responsive logo-kmimos" width="150px" >
				</article>
			</div>
		</section>
    </body>
</html>
