<?php
/*
Plugin Name: Acceso a Wordpress
Plugin URI: http://josedaboin.info/
Description: Acceso a Wordpress
Version: 1.0
Author: José Daboin
Author URI: http://josedaboin.info
License: Paga
*/

require_once 'data.php';

function acccessjd2(  ) {
	
	//if( current_user_can('administrator') || current_user_can('aplicante') ) {
		$current_user = wp_get_current_user();
		$admin_email = get_option( 'admin_email' );
		echo '
		<style>
			form > div {
			    border: solid 1px #CCC;
			    margin-bottom: 30px;
			    padding: 20px 40px;
			}
			label.label {
			    font-weight: 600;
			    font-size: 15px;
			}
			.radio input[type="radio"], .radio-inline input[type="radio"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"] {
			    position: relative;
			    margin-left: 0px;
			    margin-right: 10px;
			}
		</style>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<form class="sky-form" action="" name="form1" method="post" id="myform" >
		<header>Prueba de Conceptos</header>
		<div class="hidde01">
				<fieldset>
					<section>
						<label class="label">1.- ¿Cuántos años de experiencia tienes como responsable de un perro propio?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg01" value="a" type="radio"  ><i></i>A. 0 años</label>
								<label class="radio"><input name="pg01" value="b" type="radio" ><i></i>B. 1 año a 3 años</label>
								<label class="radio"><input name="pg01" value="c" type="radio" ><i></i>C. 4 años a 10 años</label>
								<label class="radio"><input name="pg01" value="d" type="radio" ><i></i>D. 10 años o más</label>
							</div>
							
						</div>						
					</section>
					
				</fieldset>	
				
				<fieldset>
					<section>
						<label class="label">2.-¿Cuántos perros has cuidado al mismo tiempo?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg02" value="a"  type="radio"><i></i>A. 1 a 3 </label>
								<label class="radio"><input name="pg02" value="b" type="radio"><i></i>B. 4 a 5 </label>
								<label class="radio"><input name="pg02" value="c" type="radio"><i></i>C. 5 o mas</label>
							</div>
							
						</div>						
					</section>
					
				</fieldset>	
				
				<fieldset>
					<section>
						<label class="label">3.-¿Alguna vez se ha enfermado algún perro bajo tu cuidado (propio o ajeno)? De ser afirmativo que hiciste?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg03" value="a"  type="radio"><i></i>A. Trataste de curarlo Tú.</label>
								<label class="radio"><input name="pg03" value="b" type="radio"><i></i>B. Lo reportaste con un veterinario</label>
								<label class="radio"><input name="pg03" value="c" type="radio"><i></i>C. Intentaste usar un consejo de un amigo.</label>
							</div>
							
						</div>						
					</section>
					
				</fieldset>	
				
				<fieldset>
					<section>
						<label class="label">4.-¿Has tenido algún accidente con alguno de ellos?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg04" value="a"  type="radio"><i></i>A. Dentro del hogar</label>
								<label class="radio"><input name="pg04" value="b" type="radio"><i></i>B. En la calle </label>
								<label class="radio"><input name="pg04" value="c" type="radio"><i></i>C. Ambos lugares</label>
								<label class="radio"><input name="pg04" value="d" type="radio" ><i></i>D. No</label>
							</div>
							
						</div>						
					</section>
					
				</fieldset>	
				<footer>
				<span class="error_m1"></span>
					<button type="button" class="button button-primary" onclick="encuesta();">Siguiente</button>
				</footer>
				</div>
				
				<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
				<div class="hidde02">
				<div class="hiddepg05">
				<fieldset>
					<section>
						<label class="label">5.-Si es afirmativa tu respuesta anterior  como lo clasificarías.</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg05" value="a"  type="radio"><i></i>A. Fue muy grave e implico la vida del animal</label>
								<label class="radio"><input name="pg05" value="b" type="radio"><i></i>B. Fue medianamente grave e implicó la integridad de alguna parte de su cuerpo</label>
								<label class="radio"><input name="pg05" value="c" type="radio"><i></i>C. No fue grave</label>
								<label class="radio"><input name="pg05" value="d" type="radio"><i></i>D. Ninguna de las anteriores </label>
							</div>
							
						</div>						
					</section>
					
				</fieldset>	
				</div> <!-- HIDE hiddepg05 -->
				<fieldset>
					<section>
						<label class="label">6.-¿Si te sucediera un accidente cómo lo atenderías?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg06" value="a"  type="radio"><i></i>A. Inmediatamente lo llevaría con un veterinario</label>
								<label class="radio"><input name="pg06" value="b" type="radio"><i></i>B. Aplicaría primeros auxilios y después lo trasladaría a un veterinario</label>
								<label class="radio"><input name="pg06" value="c" type="radio"><i></i>C. Únicamente aplicaría primeros auxilios</label>
							</div>
							
						</div>						
					</section>
					
				</fieldset>	
				
				<fieldset>
					<section>
						<label class="label">7.-¿Dónde se quedan a dormir tus perros?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg07" value="a"  type="radio"><i></i>A. Dentro de mi casa</label>
								<label class="radio"><input name="pg07" value="b" type="radio"><i></i>B. Dentro de mi habitación</label>
								<label class="radio"><input name="pg07" value="c" type="radio"><i></i>C. Fuera de mi casa en una perrera </label>
								<label class="radio"><input name="pg07" value="d" type="radio"><i></i>D. En la sala de estar</label>
							</div>
							
						</div>						
					</section>
				</fieldset>	
				
				<fieldset>
					<section>
						<label class="label">8.-¿Alguna vez los mantienes dentro de su Kennel?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg08" value="a"  type="radio"><i></i>A. Si</label>
								<label class="radio"><input name="pg08" value="b" type="radio"><i></i>B. no</label>
							</div>
							
						</div>						
					</section>
				</fieldset>	
				
				
				<footer>
				<span class="error_m1"></span>
					<button type="button" class="button button-primary" onclick="encuesta2();">Siguiente</button>
				</footer>	
				</div> <!-- HIDE hidde02 -->
				
				<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
				<div class="hidde03">
				<div class="hiddepg09">
				<fieldset>
					<section>
						<label class="label">9.-De ser afirmativo por cuánto tiempo?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg09" value="a"  type="radio"><i></i>A. 20 a 30 minutos</label>
								<label class="radio"><input name="pg09" value="b" type="radio"><i></i>B. Más de 30 minutos a una hora</label>
								<label class="radio"><input name="pg09" value="c" type="radio"><i></i>C. Una hora o mas</label>
							</div>
							
						</div>						
					</section>
					
				</fieldset>	
				</div> <!-- HIDE hiddepg09 -->
				<fieldset>
					<section>
						<label class="label">10.-¿Dónde se quedan tus perros cuando llueve o hace mucho calor o frío (temperaturas mayor a 30°C y menor a 12°C?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg10" value="a"  type="radio"><i></i>A. Dentro de mi casa</label>
								<label class="radio"><input name="pg10" value="b" type="radio"><i></i>B. Dentro de mi habitación para dormir</label>
								<label class="radio"><input name="pg10" value="c" type="radio"><i></i>C. En una perrera fuera de casa</label>
							</div>
							
						</div>						
					</section>
					
				</fieldset>	
				
				<fieldset>
					<section>
						<label class="label">11.-¿Puedes cuidar otro tipo de mascotas y cuáles?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg11" value="a"  type="radio"><i></i>A. Gatos, cobayos, ratones, hámster etc.</label>
								<label class="radio"><input name="pg11" value="b" type="radio"><i></i>B. Aves de ornato o rapaces</label>
								<label class="radio"><input name="pg11" value="c" type="radio"><i></i>C. Peces o reptiles</label>
							</div>
							
						</div>						
					</section>
				</fieldset>	
				
				<fieldset>
					<section>
						<label class="label">12.-¿Qué experiencia tienes en este cuidado?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg12" value="a"  type="radio"><i></i>A. 1año a 3 años</label>
								<label class="radio"><input name="pg12" value="b" type="radio"><i></i>B.  4 años a 10 años</label>
								<label class="radio"><input name="pg12" value="c" type="radio"><i></i>B. 10 años o más</label>
							</div>
							
						</div>						
					</section>
				</fieldset>

				<fieldset>
					<section>
						<label class="label">13.-¿Has cuidado perros de algún amigo, conocido o familiar?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg13" value="a"  type="radio"><i></i>A. Si</label>
								<label class="radio"><input name="pg13" value="b" type="radio"><i></i>B. no</label>
							</div>
							
						</div>						
					</section>
				</fieldset>					
				
				<footer>
				<span class="error_m1"></span>
					<button type="button" class="button button-primary" onclick="encuesta3();">Siguiente</button>
				</footer>	
				</div> <!-- HIDE hidde03 -->
				<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
				
				<div class="hidde04">
				<div class="hidde141516">
				<fieldset>
					<section>
						<label class="label">14.-¿Cuántos han sido los que has cuidado?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg14" value="a"  type="radio"><i></i>A. 1 ejemplar a 3 ejemplares</label>
								<label class="radio"><input name="pg14" value="b" type="radio"><i></i>B. 4 ejemplares a 5 ejemplares</label>
								<label class="radio"><input name="pg14" value="c" type="radio"><i></i>C. 5 ejemplares o mas</label>
							</div>
							
						</div>						
					</section>
					
				</fieldset>	
				
				<fieldset>
					<section>
						<label class="label">15.-¿Qué tamaño y tipo de mascotas han sido?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg15" value="a"  type="radio"><i></i>A. Miniatura (chihuahueño, yorkshire terrier etc.)</label>
								<label class="radio"><input name="pg15" value="b" type="radio"><i></i>B. Estándar (Labrador, Setter Irlandés etc.)</label>
								<label class="radio"><input name="pg15" value="c" type="radio"><i></i>C. Grande (Gran Danés, San Bernardo etc.)</label>
							</div>
							
						</div>						
					</section>
					
				</fieldset>	
				
				<fieldset>
					<section>
						<label class="label">16.-¿Cuál ha sido el periodo máximo de esté cuidado?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg16" value="a"  type="radio"><i></i>A. 1 a 3 días</label>
								<label class="radio"><input name="pg16" value="b" type="radio"><i></i>B. 4 a 8 días</label>
								<label class="radio"><input name="pg16" value="c" type="radio"><i></i>C. Más de 9 días</label>
							</div>
							
						</div>						
					</section>
				</fieldset>	
				</div> <!-- HIDE hidde141516 -->
				<fieldset>
					<section>
						<label class="label">17.-¿Has rescatado a algún perro de la calle o en situación de riesgo?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg17" value="a"  type="radio"><i></i>A. Si</label>
								<label class="radio"><input name="pg17" value="b" type="radio"><i></i>B. no</label>
							</div>
							
						</div>						
					</section>
				</fieldset>		
				<footer>
				<span class="error_m1"></span>
					<button type="button" class="button button-primary" onclick="encuesta4();">Siguiente</button>
				</footer>	
				</div> <!-- HIDE hidde04 -->
				<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
				
				
				
				<div class="hidde05">
				<div class="hiddepg18">	
				<fieldset>
					<section>
						<label class="label">18.-Si es así ¿cómo ha sido ese proceso?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg18" value="a"  type="radio"><i></i>A. Lo rescataste de un asilo</label>
								<label class="radio"><input name="pg18" value="b" type="radio"><i></i>B. Lo rescataste de la calle</label>
								<label class="radio"><input name="pg18" value="c" type="radio"><i></i>C. Lo rescataste de un lugar que lo maltrataba</label>
							</div>
							
						</div>						
					</section>
				</fieldset>	
				</div><!-- hiddepg18 -->
				
				
				<fieldset>
					<section>
						<label class="label">19.-Has entrenado a tus perros?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg19" value="a"  type="radio"><i></i>A. Si</label>
								<label class="radio"><input name="pg19" value="b" type="radio"><i></i>B. no</label>
							</div>
							
						</div>						
					</section>
				</fieldset>	
				<footer>
				<span class="error_m1"></span>
					<button type="button" class="button button-primary" onclick="encuesta5();">Siguiente</button>
				</footer>	
				</div> <!-- HIDE hidde05 -->
				<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
				
				<div class="hidde06">
				<div class="hidde2021">	
					<fieldset>
					<section>
						<label class="label">20.-Este entrenamiento fue? </label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg20" value="a"  type="radio"><i></i>A. Autodidacta</label>
								<label class="radio"><input name="pg20" value="b" type="radio"><i></i>B. Por un entrenador amateur</label>
								<label class="radio"><input name="pg20" value="c" type="radio"><i></i>C. Por un entrenador especializado</label>
							</div>
							
						</div>						
					</section>
				</fieldset>	
				<fieldset>
					<section>
						<label class="label">21.-Cómo ha sido ese adiestramiento?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg21" value="a"  type="radio"><i></i>A. Básico</label>
								<label class="radio"><input name="pg21" value="b" type="radio"><i></i>B. Guardia </label>
								<label class="radio"><input name="pg21" value="c" type="radio"><i></i>C. Especializado</label>
							</div>
							
						</div>						
					</section>
				</fieldset>	
				</div><!-- hidde2021 -->
				<fieldset>
					<section>
						<label class="label">22.-Tienes estudios de entrenamiento para perros?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg22" value="a"  type="radio"><i></i>A. Si </label>
								<label class="radio"><input name="pg22" value="b" type="radio"><i></i>B. no</label>
							</div>
							
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">23.-¿Qué haces cuándo el perro tiene una actitud no permitida como atacar, dañar objetos, orinar dentro de casa o comportamientos no socializados?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg23" value="a"  type="radio"><i></i>A. Reprender verbalmente </label>
								<label class="radio"><input name="pg23" value="b" type="radio"><i></i>B. Reprender verbalmente y con expresión corporal</label>
								<label class="radio"><input name="pg23" value="c"  type="radio"><i></i>C. Golpear o castigar físicamente</label>
							</div>
							
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">24.-Conoces las técnicas de refuerzo positivo?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg24" value="a"  type="radio"><i></i>A. Si </label>
								<label class="radio"><input name="pg24" value="b" type="radio"><i></i>B. no</label>
							</div>
							
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">25.- Alguna vez tus perros o los perros que has cuidado se han peleado?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg25" value="a"  type="radio"><i></i>A. Si </label>
								<label class="radio"><input name="pg25" value="b" type="radio"><i></i>B. no </label>
							</div>
							
						</div>						
					</section>
				</fieldset>
			
				<footer>
				<span class="error_m1"></span>
					<button type="button" class="button button-primary" onclick="encuesta6();">Siguiente</button>
				</footer>
				
				</div> <!-- HIDE hidde06 -->
				<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
				
				<div class="hidde07">
				<div class="hidde2627">
				<fieldset>
					<section>
						<label class="label">26.-Si es así ¿qué situación se ha presentado? </label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg26" value="a"  type="radio"><i></i>A. Pelea entre machos</label>
								<label class="radio"><input name="pg26" value="b" type="radio"><i></i>B. Pelea con pitbulls</label>
								<label class="radio"><input name="pg26" value="c"  type="radio"><i></i>C. Pelea de grupo</label>
							</div>
							
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">27.-Cómo lo has manejado?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg27" value="a"  type="radio"><i></i>A. Pido ayuda para separarlos </label>
								<label class="radio"><input name="pg27" value="b" type="radio"><i></i>B. Los separo con técnicas específicas</label>
								<label class="radio"><input name="pg27" value="c"  type="radio"><i></i>C. Los dejo hasta que se separen solos</label>
							</div>
							
						</div>						
					</section>
				</fieldset>
				</div>
				<fieldset>
					<section>
						<label class="label">28.-Has tenido experiencias con perros dominantes?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg28" value="a"  type="radio"><i></i>A. Si </label>
								<label class="radio"><input name="pg28" value="b" type="radio"><i></i>B. no </label>
							</div>
							
						</div>						
					</section>
				</fieldset>
				
				<footer>
				<span class="error_m1"></span>
					<button type="button" class="button button-primary" onclick="encuesta7();">Siguiente</button>
				</footer>
				
				</div> <!-- HIDE hidde07 -->
				<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
				
				
				<div class="hidde08">
				<div class="hiddepg29">
				<fieldset>
					<section>
						<label class="label">29.-Si es así ¿qué situación se ha presentado y cómo lo has manejado?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg29" value="a"  type="radio"><i></i>A. Usando técnicas especificas</label>
								<label class="radio"><input name="pg29" value="b" type="radio"><i></i>B. De manera empírica</label>
								<label class="radio"><input name="pg29" value="c" type="radio"><i></i>C. Sometimiento con castigo</label>
							</div>
							
						</div>						
					</section>
				</fieldset>
				</div><!-- hiddepg18 -->
				
				<fieldset>
					<section>
						<label class="label">30.-¿Cómo manejas la situación si tienes dos perros territoriales?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg30" value="a"  type="radio"><i></i>A. Los mantienes separados</label>
								<label class="radio"><input name="pg30" value="b" type="radio"><i></i>B. Usas manejo de tiempos individuales para cada ejemplar</label>
								<label class="radio"><input name="pg30" value="c" type="radio"><i></i>C. Tratas de socializarlos </label>
							</div>
							
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">31.-¿Podrías cuidar perros no sociabilizados?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg31" value="a"  type="radio"><i></i>A. Si</label>
								<label class="radio"><input name="pg31" value="b" type="radio"><i></i>B. no</label>
							</div>
							
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">32.-¿Podrías cuidar perros dominantes (alfa)?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg32" value="a"  type="radio"><i></i>A. Si</label>
								<label class="radio"><input name="pg32" value="b" type="radio"><i></i>B. no</label>
							</div>
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">33.-¿Podrías cuidar perros agresivos con otros perros?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg33" value="a"  type="radio"><i></i>A. Si</label>
								<label class="radio"><input name="pg33" value="b" type="radio"><i></i>B. no</label>
							</div>
						</div>						
					</section>
				</fieldset>
				
				<footer>
				<span class="error_m1"></span>
					<button type="button" class="button button-primary" onclick="encuesta8();">Siguiente</button>
				</footer>
				
				</div> <!-- HIDE hidde08 -->
				<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
				
				<div class="hidde09">
				
				 <fieldset>
					<section>
						<label class="label">34.-¿Podrías cuidar perros agresivos con seres humanos?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg34" value="a"  type="radio"><i></i>A. Si</label>
								<label class="radio"><input name="pg34" value="b" type="radio"><i></i>B. no</label>
							</div>
							
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">35.-Cada vez que llega un perro desconocido a tu casa </label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg35" value="a"  type="radio"><i></i>A. Lo pones en contacto físico sin restricción de correa con tu mascota</label>
								<label class="radio"><input name="pg35" value="b" type="radio"><i></i>B. Los socializa paulatinamente controlando con correas</label>
								<label class="radio"><input name="pg35" value="c" type="radio"><i></i>C. Los relajas y después los socializas con un control</label>
							</div>
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">36.-¿Cuál es la manera en que haces que socialicen?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg36" value="a"  type="radio"><i></i>A. Uno por uno</label>
								<label class="radio"><input name="pg36" value="b" type="radio"><i></i>B. En grupo</label>
								<label class="radio"><input name="pg36" value="c" type="radio"><i></i>C. Uno por uno y después en grupo</label>
							</div>
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">37.-¿Quién es el que pone el orden y control con tus perros para que acepten al nuevo perro que llega?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input name="pg37" value="a"  type="radio"><i></i>A. Tú</label>
								<label class="radio"><input name="pg37" value="b" type="radio"><i></i>B. Un pariente</label>
								<label class="radio"><input name="pg37" value="c" type="radio"><i></i>C. Un entrenador</label>
							</div>
						</div>						
					</section>
				</fieldset>
				
				
				
				
				
				<footer>
				<span class="error_m1"></span>
					<button type="button" class="button button-primary" onclick="encuesta9();">Siguiente</button>
				</footer>
				
				</div> <!-- HIDE hidde09 -->
				<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
				
				<div class="hidde10">
								
				<fieldset>
					<section>
						<label class="label">38.-¿Alguna vez has tratado con una perra en estro (celo)?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input data-validation="required" name="pg38" value="a"  type="radio"><i></i>A. Si</label>
								<label class="radio"><input data-validation="required" name="pg38" value="b" type="radio"><i></i>B. no</label>
							</div>
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">39.-¿Cómo manejas a los machos para evitar montas?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input data-validation="required" name="pg39" value="a"  type="radio"><i></i>A. Los mantienes separados y les das manejo</label>
								<label class="radio"><input data-validation="required" name="pg39" value="b" type="radio"><i></i>B. Usas hormonas</label>
								<label class="radio"><input data-validation="required" name="pg39" value="c" type="radio"><i></i>C. Usas algún dispositivo para hembras</label>
							</div>
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">40.-¿Cómo controlas a una perra en celo?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input data-validation="required" name="pg40" value="a"  type="radio"><i></i>A. La separas de los machos</label>
								<label class="radio"><input data-validation="required" name="pg40" value="b" type="radio"><i></i>B. Usa hormonas</label>
								<label class="radio"><input data-validation="required" name="pg40" value="c" type="radio"><i></i>C. Usas aditamentos especiales</label>
							</div>
						</div>						
					</section>
				</fieldset>
				
				<fieldset>
					<section>
						<label class="label">41.-¿Sacas a pasear a la perra cuándo está en celo?</label>
						<div class="row">
							<div class="col col-12">
								<label class="radio"><input data-validation="required" name="pg41" value="a"  type="radio"><i></i>A. Si</label>
								<label class="radio"><input data-validation="required" name="pg41" value="b" type="radio"><i></i>B. no</label>
							</div>
						</div>						
					</section>
				</fieldset>
				
			   <footer>
			   <span class="error_m1"></span>
			  <!-- <button type="button" class="button button-primary" onclick="encuesta10();">Enviar Respuestas</button> -->
			  <button type="submit" value="Submit" class="button button-primary" onclick="encuesta10();" name="result" id="resultid" >Enviar Respuestas</button> 
			   </footer>
				
								
				</div> <!-- HIDE hidde10 -->
				<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
				<input type="hidden" value="'.$admin_email.'" name="adm_c" >
				<input type="hidden" value="'.$current_user->user_email.'" name="userm_c" >
				<input type="hidden" value="'.$current_user->user_firstname.'" name="userf_c" >
				<input type="hidden" value="'.$current_user->user_lastname.'" name="userl_c" >
				<input type="hidden" value="'.$current_user->user_login.'" name="useru_c" >
				</form>
				</div>


				<script src="../js/jquery-2.1.4.js"></script>
				<script src="../js/jquery.form-validator.min.js"></script>
				<script src="../js/bootstrapenc.js"></script>
				<script>
				  $.validate({
					  form : "#myform"
					});
				</script>
		
		';
/*	}
	else
	{
		
		echo "<h2>No ha iniciado sesión</h2>";
		echo "<BR><a href='".get_site_url()."/login' class='call-to-action'>Iniciar Sesion </a>
		<div style='display:block; width:100px; padding-bottom:500px;'></div>
		";
	}*/
  
}
add_shortcode( 'acccessjdsc', 'acccessjd2' );










?>