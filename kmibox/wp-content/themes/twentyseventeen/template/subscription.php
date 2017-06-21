<?php
/* 
 *
 * Template Name: purchase 
 *
 */
?>
<?php  get_header(); ?>

<header class="row">
	<aside id="top-compra" class="text-center"> 
		<span data-target='title' class="compra-titulo">Selecciona el tamaño de tu perrhijo</span>
	</aside>
</header>



<!-- Fase #1 Tamaño -->
<section data-fase="1" class="container">
	<article class="text-center hidden">
		<h2></h2> 
		<img src="#" class="img-responsive" width="300px">
		<button data-action="next" data-type="grande" class="btn btn-sm-kmibox">Seleccionar</button>
	</article>
</section>
<!-- Fase #2 Producto -->
<section data-fase="2" class="container hidden">
	<article class="col-sm-6 text-center ">
		<h2></h2>
		<img  src="/img/pequeno.png"  class="img-responsive" width="300px">
		<div>
			<i class="fa fa-circle"></i>
		</div>	
		<button data-action="next" data-type="" class="btn btn-sm-kmibox">Seleccionar</button>
		<p>asdasdasdasd</p>
	</article>
</section>
<!-- Fase #3 Plan -->
<section data-fase="3" class="container hidden">
	<article class="col-sm-6 text-center">
		<h2></h2>
		<img  src="/img/pequeno.png" class="img-responsive" width="300px">
		<button data-action="next" data-type="grande" class="btn btn-sm-kmibox">Seleccionar</button>
	</article>
</section>
<!-- Fase #4 Extras -->
<section data-fase="4" class="container hidden">
	<article class="col-sm-6 text-center ">
		<h2></h2>
		<img src="/img/pequeno.png"  class="img-responsive" width="300px">
		<button data-action="next" data-type="" class="btn btn-sm-kmibox">Seleccionar</button>
	</article>
</section>



<div class="container text-center">
	<h2>Todos los articulos de la kmibox son suministrados por:</h2>
</div>
<section id="marcas" class="text-center row">
	<div class="container">	
		<article class="col-sm-2 col-sm-offset-1">
			<img src="/img/Secciones-06.png" class="img-responsive"  width="200px">
		</article>
		<article class="col-sm-2">
			<img src="/img/Secciones-07.png" class="img-responsive"  width="200px">
		</article>
		<article class="col-sm-2">
			<img src="/img/Secciones-09.png" class="img-responsive"  width="200px">
		</article>
		<article class="col-sm-2">
			<img src="/img/Secciones-10.png" class="img-responsive"  width="200px">
		</article>
		<article class="col-sm-2">
			<img src="/img/Secciones-08.png" class="img-responsive"  width="200px">
		</article>
	</div>
</section>

<?php get_footer();
