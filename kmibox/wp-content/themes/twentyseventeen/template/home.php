<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 
 Template Name: home */ 

get_header(); ?>

	<header class="row">
		<aside id="top"> 
			<div class="container">
				<img src="/img/logo-500x148.png"  >
			</div>
		</aside>
		<article>
			<div class="container" id="banner">
				<div class="col-xs-8 col-sm-7 col-md-6">
					<img src="/img/personaje-400x353.png" class="img-responsive">
				</div>
				<div id="banner-text" class="col-xs-12 col-sm-12 col-md-6">
					<img src="/img/kmibox-grandpet-400x97.png" class="img-responsive">
					<h2>Una cajita mensual llena de sorpresas para tu mascota</h2>
					<br>	
					<a href="/purchase" class="btn-kmibox">Quiero mi kmiBOX</a>	
				</div>
				<div class="col-xs-12 col-sm-6 hidden" id="banner-dog">
					<img src="/img/logo-120x35.png" class="img-responsive">
				</div>
			</div>			
		</article>
	</header>

	<section id='section-comment' class="row text-center ">
		<h2>Regálale un detalle al consentido de tu hogar!</h2>
	</section>

	<section id="como-funciona" class="row text-center">

		<h2>¿Como funciona?</h2>

		<article class="col-sm-12 col-md-6">
			<img src="/img/gato.png" class="img-responsive" width="300px">
			<p>
				Cada mes preparamos una caja especial para tu consentido con juguetes, snacks y productos sorpresa
			</p>
		</article>
		<article class="col-sm-12 col-md-6">
			<img src="/img/camion.png" class="img-responsive" width="300px">
			<p>
				Enviamos mensualmente una
				kmiBOX a tu hogar. Las cajas son
				enviadas al final de cada mes. Tu
				peludo disfrutará mucho!
			</p>
		</article>
	</section>

	<section class="row back-picture"></section>

	<section class="row text-center">
		<h2>¿Qué lleva dentro una <img src="/img/logo-text.png" class="logo-text"> ?</h2>
		<article class="col-sm-12">
			<img src="/img/Caja.png" class="img-responsive" width="100%">
		</article>
		<p class="col-sm-12">Todos los artículos de la <img src="/img/logo-text.png" class="logo-text"> son suministrados por <img src="/img/Gran pet 1.png" class="logo-text" width="16%"></p>
	</section>

	<section class="row back-kmibox text-center">
		<h2>¿Cómo consigo mi <img src="/img/logo-white-text.png" class="logo-text" width="20%"> ?</h2>
		<div class="col-xs-12 col-md-10 col-md-offset-1">
			<div class="row">
				<article class="col-sm-12 col-md-6">
					<img src="/img/icono 3.png" class="img-responsive" width="300px">
					<p>
						<span>Elige</span> el tamaño de
						tu consentido
					</p>
				</article>		
				<article class="col-sm-12 col-md-6">
					<img src="/img/icono 4.png" class="img-responsive" width="300px">
					<p>
						<span>Selecciona </span>el
						valor de kmibox
					</p>
				</article>		
			</div>
			<div class="row">
				<article class="col-sm-12 col-md-6">
					<img src="/img/icono 5.png" class="img-responsive" width="300px">
					<p>
						<span>Añade</span> un artículo
						especial 
					</p>
				</article>		

				<article class="col-sm-12 col-md-6">
					<img src="/img/icono 6.png" class="img-responsive" width="300px">
					<p>
						<span>Recibe</span> tu kmiBOX
					</p>
				</article>		
			</div>

		</div>
	</section>

	<section class="row text-center section-red">
		<h2 class="h-3x">LLÉVATELA AHORA MISMO POR</h2>
		<article class="col-xs-8 col-xs-offset-2 col-md-3 col-sm-offset-1 col-md-offset-1">
			<img src="/img/Peronaje 3.png" class="img-responsive">
		</article>

		<article class="col-xs-6 col-md-2">
			<img src="/img/Precio 1.png" class="img-responsive" >
		</article>
		<article class="col-xs-6 col-md-2">
			<img src="/img/Precio 2.png" class="img-responsive" >
		</article>

		<article class="col-xs-6 col-md-3">
			<img src="/img/Personaje 2.png" class="img-responsive">
		</article>

		<article class="col-xs-12">		
			<h2 class="subtitle">PESOS MENSUALES*</h2>
			<h3 class="subtitle">*Costo mensual. Aplica para suscripciones trimestral, semestral y anual</h3>
		</article>
	</section>

	<section class="row text-center">
		<h2>¡Regálasela a un amigo o un familiar!</h2>
		<div class="col-sm-12">
			<img src="/img/Elemento.png" id="regalo" class="img-responsive" >
		</div>
		<p>¡No pierdas la oportunidad de hacer feliz al perrhijo de cualquiera de tus amigos o
			familiares! Regala una suscripción de la kmiBOX y nosotros la haremos llegar mes con
			mes a ese peludito especial</p>
		<br>	
		<a href="/purchase" class="btn-kmibox">Quiero mi kmiBOX</a>	
	</section>

	<?php get_template_part( 'template-parts/footer/footer', 'page' ); ?>
<?php get_footer();
