<?php/* 
 *
 * Template Name: register 
 *
 */
?>
<?php  get_header(); ?>


<header class="row">
	<aside id="top" style="height: 2vh;"> 
	</aside>
	<div class="container " id="banner">
		<article class="col-sm-6">
			<img src="/img/kmibox-grandpet-400x97.png" class="img-responsive">
			<h4>Una cajita mensual llena de sorpresas para tu mascota</h4>
			<img src="/img/personaje-400x353.png" class="img-responsive hidden-xs hidden-sm">
		</article>
		<article class="col-sm-6 text-left" style="border-radius:10px; background:#f4f4f4; padding:15px;">
			<form class="inline-form">
				<h3>Registrate</h3>
				<hr>

				<div id="fase1" class="form-group row">
					<div class="col-sm-6">
						<label>Nombre</label>					
						<input type="text" class="form-control" name="nombre" placeholder="Nombre">
					</div>
					<div class="col-sm-6">
						<label>Apellido</label>					
						<input type="text" class="form-control" name="apellido" placeholder="Apellido">
					</div>					
				</div>

				<div id="fase2" class="form-group row">
					<div class="col-sm-6">
						<label>Teléfono móvil</label>
						<input type="text" class="form-control" name="telf_movil" placeholder="Tel&eacute;fono movil">
					</div>
					<div class="col-sm-6">
						<label>Teléfono casa</label>
						<input type="text" class="form-control" name="telf_casa" placeholder="Tel&eacute;fono Casa">
					</div>
				</div>

				<div id="fase3" class="form-group row">
					<div class="col-sm-6">
						<label>Sexo</label>
						<select class="form-control" placeholder="Sexo">
							<option>Femenino</option>
							<option>Masculino</option>
						</select>
					</div>
					<div class="col-sm-6">
						<label>Edad</label>
						<select class="form-control" placeholder="Edad">
							<?php for( $i=15; $i<100; $i++){ ?>
							<option><?php echo "{$i} Años"; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<div id="fase4" class="form-group">
					<label>¿Cómo nos conoció?</label>
					<select class="form-control">
						<option>Casa</option>
						<option>Familia / Otros</option>
					</select>
				</div>

				<div id="fase5" class="form-group row">

					<div class="col-sm-6">
						<label>Email</label>					
						<input type="text" class="form-control" name="email" placeholder="Email">
					</div>
					<div class="col-sm-6">
						<label>Confirmar email</label>					
						<input type="text" class="form-control" name="email_repeat" placeholder="Confirmar email">
					</div>
				</div>

				<div id="fase6" class="form-group row">
					<div class="col-sm-6">
						<label>Clave</label>					
						<input type="text" class="form-control" name="pass" placeholder="Clave">
					</div>
					<div class="col-sm-6">
						<label>Confirmar Clave</label>					
						<input type="text" class="form-control" name="pass_repeat" placeholder="Confirmar clave">
					</div>
				</div>
				
				<div class="form-group row">
					<aside class="col-sm-12">			
						<button class="hidden col-sm-4 btn-sm-kmibox-default btn btn-sm-kmibox">Atras</button>
						<button class="hidden col-sm-4 pull-right btn btn-sm-kmibox">Continuar</button>

						<button class="col-sm-4 pull-right btn-fullwidth btn btn-sm-kmibox">Crear cuenta</button>
					</aside>

					<aside class="col-sm-12 text-center">
						<br>
						<a href="/login" > <h4>Iniciar sesion</h4> </a>
					</aside>
				</div>
			</form>
		</article>
	</div>
	<br>
	<br>
</header>


<?php get_footer();
