<?php/* 
 *
 * Template Name: login 
 *
 */
?>
<?php  get_header(); ?>


<header class="row">
	<aside id="top" style="height: 2vh;"> 
	</aside>
	<div class="container " id="banner">
		<article class="col-sm-6">
			<a href="/"><img src="/img/kmibox-grandpet-400x97.png" class="img-responsive"></a>
			<h4>Una cajita mensual llena de sorpresas para tu mascota</h4>
			<img src="/img/personaje-400x353.png" class="img-responsive">
		</article>
		<article class="col-sm-4 col-sm-offset-1">
			<form class="inline-form text-left"  style="border-radius:10px; background:#f4f4f4; padding:15px;">
				<h3>Iniciar sesion</h3>
				<hr>

				<div class="form-group row">
					<label class="col-sm-2">Email</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="email" placeholder="Email">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2">Clave</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="pass" placeholder="Clave">
					</div>
				</div>
				
				<div class="form-group row">
					<div class="col-sm-12 text-right">
						<button class="btn btn-sm-kmibox btn-fullwidth">Iniciar Sesion</button>
					</div>
					<br>
					<br>
					<aside class="col-sm-12 text-center">
						<a href="/register" > <h4>Crear Cuenta</h4> </a>
					</aside>
				</div>

			</form>
		</article>
	</div>
</header>


<?php get_footer();
