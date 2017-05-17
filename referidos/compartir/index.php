<?php
$url="";
if(isset($_GET['e'])){
	$url = "https://www.kmimos.com.mx/referidos/?r=".md5($_GET['e']);
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Kmimos - Clientes Referidos</title>

        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/kmimos.css">

		<meta property="og:url"           content="<?php echo $url; ?>" />
		<meta property="og:type"          content="website" />
		<meta property="og:title"         content="Kmimos - Clientes Referidos" />
		<meta property="og:description"   content="Suma huellas a nuestro club y gana descuentos" />
		<meta property="og:image"         content="https://mx.kmimos/referidos/img/1backgroundfoto.png" />
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-56422840-1', 'auto');
		  ga('send', 'pageview');
		</script>

	</head>
	<body>

		<div class="container">
			
			<header class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
				<img src="img/dogs-top.jpg" class="img-responsive" width="100%" alt="">
				<div class="col-md-12"><h1 id="subtitulo" class="col-md-offset-2 col-md-8 text-center">
					Felicidades ya formas partes del club!
				</h1><br>
				</div>
				<h1 class="text-center" style="font-size: 2.14em;">Suma huellas y gana descuentos</h1>
			</header>

			<section class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 text-center">
				<div class="row">
					<section class="col-xs-12 col-sm-4 col-md-3  text-right">
						<span id="bloque1">Es muy sencillo:</span><br>
					</section>

					<div class="col-xs-12 col-sm-4 col-md-4">
						<section id="bloque2" class="bloque">
							<span>Comparte a trav&eacute;s de los botones e invita a tus amigos a unirse a nuestro club.</span>
						</section>
						<section id="shared" class="text-right row">
							<?php if(!empty($url)){ ?>
							<div class="col-xs-4 col-sm-4 col-sm-4">
								<a class="twitter-share-button" target="_blank" href="https://twitter.com/intent/tweet?text=Suma huellas y gana descuentos <?php echo $url; ?>" class="btn-kmimos btn btn-lg">
									<img src="img/btntwitter.png" width="50px">
								</a>
							</div>
							<div class="col-xs-4 col-sm-4 col-sm-4">
								<a href="http://facebook.com/sharer.php?u=<?php echo $url; ?>"  target="_blank">
									<img src="img/btnfacebook.png" width="50px">
								</a>
							</div>
							<div class="col-xs-4 col-sm-4 col-sm-4">
								<span id="mail_publicar" data-target="1">
									<img src="img/btnemail.png" width="50px">
								</span>
							</div>
							<?php } else { ?>
								<a href="/referidos" class="btn btn-md" style="background: #9F159F; border-color:#9F159F;color:#fff;">Obtener enlace</a>
							<?php } ?>
						</section>					
					</div>
					<section id="bloque3" class="bloque col-xs-12 col-sm-4 col-md-4 ">
						<span>Por cada amigo que se una a nuestro club t&uacute; ganas 
						<span style="font-size:18px;color:#9F159F;text-decoration: underline;font-weight: bold;">150$</span> y tu amigo gana su primera noche de cuida <span style="font-size:18px;color:#9F159F;text-decoration: underline;font-weight: bold;">gratis.</span>
						</span>
					</section>

				</div>		
					<div id="info" class="col-sm-11 clearfix hidden">
						<strong style="color:#9F159F;font-size:23px;">copia el enlace y comparte con amigos y familiares</strong>
						<pre><strong><?php echo $url;?></strong></pre>
					</div>
			</section>

			<aside class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 text-center">
				<img src="img/opciones.png" class="img-responsive hidden-xs" >
			</aside>

		</div>
	
		<script
		  src="https://code.jquery.com/jquery-2.2.4.min.js?<?php echo time(); ?>"
		  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
		  crossorigin="anonymous"></script>
		<script>
		$(document).ready(function(){
			$("#mail_publicar").click(function(){
		        if($("#info").hasClass('hidden')){
		        	$("#info").removeClass('hidden');
				}else{
		        	$("#info").addClass('hidden');
				}

		    });
		});
		</script>

	</body>
</html>