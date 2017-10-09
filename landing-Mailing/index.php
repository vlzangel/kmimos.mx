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
				font-weight: 900!important;
				font-family: "Lato", sans-serif;
			}
			section{clear: both;}
	
			strong{font-weight: 900;}
			.container-fluid{padding: 0px!important; margin: 0px!important;width:100%!important; background:#9c2a81!important;}
			.sp {margin-left: -10%;}
			#top-volaris{width: 45%;}
			#img-1{width:100%; margin-left: 0%; height: 284px;}
			#contenedor-1{background: #9c2a81!important; width: 100%; height: 283.5px; margin-top: 0px!important;}
			#p-contenedor-1{font-size: 17pt; color: #fff; text-align: right; margin-top: 0px!important; position: relative; right: 0%; padding-top:27px; padding-right:20px;}
			#btn-img{width: 55%; position: relative; margin-left: 85px; margin-top: 5%;}
			#h1-1{margin-bottom: 10px; font-size: 22pt; margin-top: 3%; margin-left: 65px;}
			#p-contenedor-2{font-size: 15pt; text-align: center; margin-bottom: 3%;}
			#h2-1{margin-bottom: 10px; font-size: 14pt; margin-top: 32%; margin-left: 15%;}
			#img-contenedor-2{width:70%;margin-bottom: 10%;margin-top: 5%;}
			#p2-contenedor-2{font-size: 12pt; text-align: center; margin-top: -6%; margin-bottom: 5%;}
			@media (min-width: 1280px){}
			@media (min-width: 766px) and (max-width: 999px){
				#img-1{width:100%; margin-left: 0%; height: 284px;}
				#contenedor-1{background: #9c2a81!important; width: 100%; height: 283.5px; margin-top: 0px!important;}
				#p-contenedor-1{font-size: 14pt; color: #fff; text-align: right; margin-top: 0px!important; position: relative; right: 0%; padding-top:27px; padding-right:20px;}
				#btn-img{width: 55%; position: relative; margin-left: 85px; margin-top: 0%;}
				#h1-1{margin-bottom: 10px; font-size: 18pt; margin-top: 3%; margin-left: 65px;}
				#p-contenedor-2{font-size: 13pt; text-align: center; margin-bottom: 3%;}
				#h2-1{margin-bottom: 10px; font-size: 14pt; margin-top: 32%; margin-left: 15%;}
			}
			@media (min-width: 581px) and (max-width: 765px){
				#img-1{width:100%; margin-left: 0%; height: 284px;}
				#contenedor-1{background: #9c2a81!important; width: 100%; height: 283.5px; margin-top: 0px!important;}
				#p-contenedor-1{font-size: 14pt; color: #fff; text-align: right; margin-top: 0px!important; position: relative; right: 0%; padding-top:27px; padding-right:20px;}
				#btn-img{width: 55%; position: relative; margin-left: 85px; margin-top: 0%;}
				#h1-1{margin-bottom: 10px; font-size: 18pt; margin-top: 3%; margin-left: 65px;}
				#p-contenedor-2{font-size: 13pt; text-align: center; margin-bottom: 3%;}
				#h2-1{margin-bottom: 10px; font-size: 12pt; margin-top: 32%; margin-left: 15%;}
			}
			@media (min-width: 481px) and (max-width: 580px){
				#img-1{width:100%; margin-left: 0%; height: 284px;}
				#contenedor-1{background: #9c2a81!important; width: 100%; height: 283.5px; margin-top: 0px!important;}
				#p-contenedor-1{font-size: 14pt; color: #fff; text-align: right; margin-top: 0px!important; position: relative; right: 0%; padding-top:27px; padding-right:20px;}
				#btn-img{width: 55%; position: relative; margin-left: 85px; margin-top: 0%;}
				#h1-1{margin-bottom: 10px; font-size: 18pt; margin-top: 3%; margin-left: 65px;}
				#p-contenedor-2{font-size: 13pt; text-align: center; margin-bottom: 3%;}
				#h2-1{margin-bottom: 10px; font-size: 12pt; margin-top: 32%; margin-left: 15%;}
			}
			@media (min-width: 381px) and (max-width: 480px){
				#img-1{width:100%; margin-left: 0%; height: 284px;}
				#contenedor-1{background: #9c2a81!important; width: 100%; height: 283.5px; margin-top: 0px!important;}
				#p-contenedor-1{font-size: 14pt; color: #fff; text-align: right; margin-top: 0px!important; position: relative; right: 0%; padding-top:27px; padding-right:20px;}
				#btn-img{width: 55%; position: relative; margin-left: 85px; margin-top: 0%;}
				#h1-1{margin-bottom: 10px; font-size: 18pt; margin-top: 3%; margin-left: 65px;}
				#p-contenedor-2{font-size: 13pt; text-align: center; margin-bottom: 3%;}
				#h2-1{margin-bottom: 10px; font-size: 11pt; margin-top: 32%; margin-left: 15%;}
			}
			@media (min-width: 280px) and (max-width: 380px){
				#img-1{width:100%; margin-left: 0%; height: 284px;}
				#contenedor-1{background: #9c2a81!important; width: 100%; height: 283.5px; margin-top: 0px!important;}
				#p-contenedor-1{font-size: 14pt; color: #fff; text-align: right; margin-top: 0px!important; position: relative; right: 0%; padding-top:27px; padding-right:20px;}
				#btn-img{width: 55%; position: relative; margin-left: 85px; margin-top: 0%;}
				#h1-1{margin-bottom: 10px; font-size: 18pt; margin-top: 3%; margin-left: 65px;}
				#p-contenedor-2{font-size: 13pt; text-align: center; margin-bottom: 3%;}
				#h2-1{margin-bottom: 10px; font-size: 11pt; margin-top: 32%; margin-left: 15%;}
				#img-contenedor-2{width:70%;margin-bottom: 10%;margin-top: 5%;}
				#p2-contenedor-2{font-size: 12pt; text-align: center; margin-top: -6%; margin-bottom: 5%;}
			}
		</style>
    </head>
    <body style="min-width: 500px; max-width: 500px; margin:auto auto;">
    	<div style="background:#000; margin-top: 1px;">
	    	<div style="padding-left: 0px; padding-right: 0px;">
	    		<img id="top-volaris" src="http://kmimosmx.sytes.net/QA1/prueba_email/img/logo-top-volaris.jpg">
	    	</div>
	    	<div class="clearfix"></div>
    	</div>
       	<div class="container-fluid">       		     		
			<div style="width: 50%; float: left;">
				<img src="http://kmimosmx.sytes.net/QA1/prueba_email/img/Image-1.jpg" id="img-1">
			</div>
				<div style="width: 50%; float: left;">
					<div id="contenedor-1">
	    				<p id="p-contenedor-1">Viaja tranquilo <br> deja a tu perro seguro <br> en el hogar de una <br> verdadera familia</p>
	    				
	    				<a href="https://www.kmimos.com.mx/?wlabel=volaris">
	    					<img src="http://kmimosmx.sytes.net/QA1/prueba_email/img/Button-2.jpg" alt="boton 1" id="btn-img"></a>
	    			</div>
				</div>
		</div>			
		<section style="background: #fff; color: #000; font-weight: lighter; height: 75%;">
       	 	<article id="top-content" style="width:100%;">
				<h1 id="h1-1">
				    <span style="color: #a92382;">+1000</span> Cuidadores Certificados</h1>
				<p id="p-contenedor-2">Conoce Kmimos, una red de <span style="color: #a92382;">Cuidadores Certificados que <br> hospedan a tu mascota</span> en su hogar para que t&uacute; viajes tranquilo</p>
       	 	</article>
			<article style="width: 50%; float: left;">
				<h2 id="h2-1">Kmimos te ofrece:</h2>
			</article>
			<article style="width: 50%; float: left;">
				<div style="width:100%;">
					<div style="width: 50%; float: left; margin-left: -5%;">
						<img id="img-contenedor-2" src="http://kmimosmx.sytes.net/QA1/prueba_email/img/Icon-1.png">
					</div>
					<div style="width: 50%; float: left; font-size: 12pt; margin-left: -5%;">
						<p id="p2-contenedor-2">Cuidadores Certificados que pasaron por pruebas psicom&eacute;tricas y de conocimiento veterinario</p>
					</div>
				</div>
				<div style="width: 100%; margin-top: 4%; float: left; margin-left: -5%;">
					<div style="width: 50%; float: left;">
						<img id="img-contenedor-2" src="http://kmimosmx.sytes.net/QA1/prueba_email/img/Icon-2.png" 
						style="margin-left: -5%;">
					</div>
					<div style="width: 50%; float: left; margin-top: 7%; margin-left: -5%;">
						<p id="p2-contenedor-2">Cobertura de serv&iacute;cios veterinarios durante toda su estad&iacute;a</p>
					</div>
				</div>
			</article>
		</section>
		<section style="background: #fff; color: #000; font-weight: lighter; height: 70%;">
			<h1 style="font-size: 20pt; margin-left: 8%;">¡Reserva con Kmimos al viaja con Volaris!</h1>
			<div style="width: 50%; float: left;">
				<img src="http://kmimosmx.sytes.net/QA1/prueba_email/img/Image-2.jpg" style="width: 70%; margin-bottom: 10px!important; margin-left: 93px!important;">
			</div>
			<div style="width: 50%; float: left;">
				<img src="http://kmimosmx.sytes.net/QA1/prueba_email/img/Image-3.jpg" style="width: 70%; margin-bottom: 10px!important; margin-left: 40px!important;">
			</div>
			<div style="width: 45%; float: left;">
				<p style="margin-left: 70px!important; text-align: center; margin-top: -8px!important; font-size: 14pt!important;">D&eacute;jalo en tu ciudad <br> de origen
				</p>
			</div>
			<div style="width: 10%; float: left;">
				<span style="color: #a92382; font-size: 14pt; margin-left: 45px!important;">&Oacute;</span>
			</div>
			<div style="width: 45%; float: left;">
				<p style="font-size: 14pt!important; text-align: center; margin-top: 10px!important; margin-left: -18px!important;">Que lo apapache un <br>cuidador en tu destino</p>
			</div>
		</section>
		<section style="background: #fff;color: #000;font-weight: lighter;height: 40%;">
			<div style="width: 100%;">
				<p style="font-size: 16pt;text-align: center;color: #000;"><span style="color: #a92382;">¡Aprovecha nuestras promociones de </span>noviembre y diciembre<span style="color: #a92382;">!</span></p>
				<p style="font-size: 16pt; text-align: center; color: #000;"><span style="color: #a92382;">¡Disfruta de tu viaje. Tu mejor amigo estar&aacute; en buenas manos!</span></p>
			</div>
			<div style="width: 100%;">
				<div style="width: 50%; float: left;">
					<a href="https://www.kmimos.com.mx/?wlabel=volaris"><img src="http://kmimosmx.sytes.net/QA1/prueba_email/img/Button-1.jpg" style="width: 70%;margin-bottom: 10%;margin-top: 8%;margin-left: 14%;"></a>
				</div>
				<div style="width: 50%; float: left;">
					<a href="https://www.kmimos.com.mx/?wlabel=volaris"><img src="http://kmimosmx.sytes.net/QA1/prueba_email/img/Button-2.jpg" style="width: 70%;margin-bottom: 10%;margin-top: 8%;margin-left: 14%;"></a>
				</div>
			</div>
		</section>
		<section style="background: black;color: #fff; width: 100%;">
			<div>
				<article>
					<img src="kmimosmx.sytes.net/QA1/prueba_email/img/Logo-Kmimos.png" style="display: inline-block;text-align: right;margin: 10px;margin-left: 70%; width: 25%;">
				</article>
			</div>
		</section>
    </body>
</html>
