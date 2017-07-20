<?php

	$query = '';
	foreach ($_GET as $key => $value) {
		$separador = (!empty($query))? '&' : '' ;
		if( $key == 'utm_campaign'){
			$value = 'landing_' . $_GET['utm_campaign']; 
		}
		$query .= $separador.$key.'='.$value;
	}

?>

<!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Kmimos | Volaris</title>

        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=Lato:700,900" rel="stylesheet">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/kmimos.css">

    <script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-56422840-1', 'auto');
	  ga('send', 'pageview');

	</script>
	
    </head>
    <body id="waypoint">       
       	<div class="col-sm-12">

			<section class="row" id="section-1">
	       	 	<article id="top-content" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<h1>¿Te vas de viaje?</h1>
					<h2>Deja a tu mascota con un CUIDADOR CERTIFICADO. <strong>Libre de jaulas y encierros.</strong></h2>
	       	 	</article>
				<article id="top-image" class="col-md-12">
					<img src="img/bg-section1a.jpg" width="100%">
				</article>
			</section>
			<div class="clearfix"></div>

			<section class="row bg-white">
	       	 	<article id="article-1-button" class="col-xs-12 text-center">
		       	 	<a href="https://www.kmimos.com.mx/?<?php echo $query; ?>" class="btn btn-kmimos">Buscar Cuidador Disponible</a>
	       	 	</article>
				<div class="clearfix"></div>
	       	 	<article class="col-sm-12"  id="section1-footer">
	       	 		<h3>Contamos con una Red de m&aacute;s de 700 Cuidadores Certificados</h3> 
	       	 	</article>
			</section>
			<div class="clearfix"></div>

			<section class="content">
				<div class="row" id="section-content">

					<section id="section-3" class="col-xs-12 bg-white">
				       	 	<article class="row">
				       	 		<div class="col-xs-12 col-sm-12 col-md-4 text-center">
				       	 			<img src="img/s1.png" class="img-responsive">
				       	 		</div>
				       	 		<div class="col-xs-12 col-sm-12 col-md-8">
					       	 		<p><br>Tu perro ser&aacute; un huesped dentro de la casa del cuidador certificado que escojas.</p>
				       	 		</div>
				       	 	</article>
				       	 	<article class="row">
				       	 		<div class="col-xs-12 col-sm-12 col-md-4 text-center">
				       	 			<img src="img/s2.png" class="img-responsive">
				       	 		</div>
				       	 		<div class="col-xs-12 col-sm-12 col-md-8">
				       	 			<p><br>Dormir&aacute; como un rey en salas, sof&aacute; y a veces ¡hasta en la cama del cuidador!</p>
				       	 		</div>
				       	 	</article>
				       	 	<article class="row">
				       	 		<div class="col-xs-12 col-sm-12 col-md-4 text-center">
				       	 			<img src="img/s3.png" class="img-responsive">
				       	 		</div>
				       	 		<div class="col-xs-12 col-sm-12 col-md-8">
				       	 			<p><br>¡Tu amigo estar&aacute; protegido por una cobertura de servicios veterinarios durante su estad&iacute;a!</p>
				       	 		</div>
				       	 	</article>
				       	 	<article class="row">
				       	 		<div class="col-xs-12 col-sm-12 col-md-4 text-center">
				       	 			<img src="img/s4.png" class="img-responsive">
				       	 		</div>
				       	 		<div class="col-xs-12 col-sm-12 col-md-8">
				       	 			<p>El tamaño de tu perro y el cuidador que elijas determinar&aacute; el costo del servicio.<br>
				       	 		Por ejemplo: para un perro chico la estad&iacute;a costar&aacute entre 100 a 200 pesos</p>
				       	 		</div>
				       	 	</article>
					</section>

					<section id="section-4" class="col-xs-12">
						<dir class="container">

							<article class="col-xs-6 col-sm-6 col-md-4 text-right pull-right">
								<img src="img/logo.png" class="img-responsive" id="section4-logo">
							</article>
							<article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<h2>
									Promoci&oacute;n por ser cliente<br>
									<span class="color-volaris">VOLARIS</span>, si te suscribes HOY:
								</h2>
							</article>
							<article id="avion" class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
								<img src="img/avion.png" class="img-responsive">
							</article>
							<article id="section-4-cuadro" class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
								<h2 class="color-volaris">Obt&eacute;n</h2>
								<h2 class="monto">$150</h2>
								<h3 class="color-volaris">DE DESCUENTO</h3>
								<span>En tu primera reserva</span>
							</article>

						</dir>
					</section>

					<section id="section-5" class="col-sm-12 bg-volaris">
						<dir class="bg-transparent container">
							<article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label class="col-xs-3">
									1.</label>
								<p class="col-xs-9">
									<strong>¡SUSCRIBETE</strong> 
									y recibe el Newsletter con lo mejor de nuestro post! o</p>
							</article>
							<article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label class="col-xs-3">
									2.</label>
								<p class="col-xs-9">
									Entra a www.kmimos.com.mx y reg&iacute;strate.</p>
							</article>
							<article id="section-5-paso3" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label class="col-xs-3">
									3.</label>
								<p class="col-xs-9">
									Una vez que hayas hecho cualquiera de las dos, en el transcurso del d&iacute;a recibir&aacute;s tu cup&oacute;on de descuento en tu correo.</p>
							</article>
							<article id="section-5-form" class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-right">
								<input type="text" value="" name="email" id="email">
								<button id="newsletter" style="border:0px; background: transparent; "><img src="img/flecha.png" width="52px"></button>
								<br>
								<div id="msg-content" class="text-left" style="
									padding: 10px;
								    background: transparent;
								    border-radius: 50px;
								    width: 90%;
								    border: 1px solid #fff;
								    margin-top: 10px;
								    text-align: center;
								    display: none;
								">	
									<span id="mensaje"></span>
								</div>
							</article>
							<article class="col-xs-12 text-center">
								<h1>¿Cómo es tu proceso para reservar?</h1>
							</article>
						</dir>
					</section>
					<section class="col-sm-12" id="section-7">

						<div class="container">
							<div class="col-sm-4">
								<img src="img/img1.png" class="img-responsive">
								<p class="section-7-principal">Entra en www.kmimos.com.mx Busca y Compara Cuidadores Cerca de Ti</p>
							</div>
							<div class="col-sm-8">
								<article class="col-sm-6">
									<img src="img/img2.png" class="img-responsive">
									<p class="section-7-secundario">Una vez que escojas a tu cuidador, p&iacute;cale a "RESERVAR"</p>
								</article>
								<article class="col-sm-6">
									<img src="img/img3.png" class="img-responsive">
									<p class="section-7-secundario">Lleva a tu amigo a la casa del cuidador (o selecciona transportaci&oacute;n si quieres que pasen por &eacute;l)</p>
								</article>
								<article class="col-sm-6">
									<img src="img/img4.png" class="img-responsive">
									<p class="section-7-secundario">Recibes fotos y v&iacute;deos diarios de tu perro durante su estad&iacute;a</p>
								</article>
								<article class="col-sm-6">
									<img src="img/img5.png" class="img-responsive">
									<p class="section-7-secundario">Tu Perro Regresa a casa FELIZ al final de la estad&iacute;a</p>
								</article>
							</div>
						</div>
					</section>

					<div class="bg-gris col-sm-12">					
						<div class="row">
							<section id="section-6" class="text-center">
								<div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center color-volaris">
									<h1>P&iacute;cale al video de abajo, te va a encantar la nueva alianza VOLARIS - KMIMOS</h1>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3" id="video">
									<iframe src="https://www.youtube.com/embed/8T_yhObrq3s" 
										frameborder="0" allowfullscreen width="100%" height="100%"></iframe>
								</div>
							</section>
							<section id="section-6-action" class="bg-volaris text-center col-sm-12">
								<div class="col-xs-12 col-sm-12 col-md-6">
									<span>
										<strong>NUESTRA PROMESA:</strong><br>
										Tu mascota regresa feliz
									</span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6">
									<a href="https://www.kmimos.com.mx/?<?php echo $query ?>" class="btn btn-kmimos-inverso">Buscar Cuidador Disponible</a>
								</div>
								<div class="clearfix"></div>
							</section>
						</div>
					</div>

					<section id="contactos" class="col-sm-12">
						<div class="container bg-black">
							<article class="col-xs-12 col-sm-6" style="margin-top:10px;margin-bottom:10px;">
								<span>Cont&aacute;ctanos a:</span> 
								<span>Llamada: 01 800 056 4667 </span>
								<span>Whatsapp: (55) 6892 2182 </span>
								<br>
								<span>contactomex@kmimos.la</span>
							</article>
							<article class="col-xs-12 col-sm-6 text-right">
								<img src="img/logo.png" class="img-responsive logo-kmimos" width="150px" >
								<img src="img/logo-volaris.png" class="img-responsive logo-volaris" width="150px">
							</article>
						</div>
					</section>

				</div>
				<div class="clearfix"></div>
			</section>


		</div>

		<script
		  src="https://code.jquery.com/jquery-2.2.4.min.js?<?php echo time(); ?>"
		  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
		  crossorigin="anonymous"></script>
	    <script src="js/wow.js  "></script>
	    <script src="js/main.js?v=1.0.0"></script>
    

    
    </body>
</html>
