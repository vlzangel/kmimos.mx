<?php 
$HTML .="
	<!-- POPUPS REGISTRARTE -->
<div class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' id='myModal' style='    padding: 40px;'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
					<div class='popup-registrarte-1'>
						<p class='popup-tit'>REGISTRARME</p>
						<a href='#' class='km-btn-fb'><img src='/images/icon/km-redes/icon-fb-blanco.svg'>REGISTRARME CON FACEBOOK</a>
						<a href='#' class='km-btn-border'><img src='/images/icon/km-redes/icon-gmail.svg'>REGISTRARME CON GOOGLE</a>
						<div class='line-o'>
							<p class='text-line'>o</p>
							<div class='bg-line'></div>
						</div>
						<a href='#' class='km-btn-correo km-btn-popup-registrarte-1'><img src='/images/icon/km-redes/icon-mail-blanco.svg'>REGISTRARME POR CORREO ELECTRÓNICO</a>
						<p style='color: #979797; margin-top: 20px;'>Al crear una cuenta, aceptas las condiciones del servicio y la Política de privacidad de Kmimos.</p>
						<p><b>Dudas escríbenos</b></p>
						<div class='row'>
							<div class='col-xs-6 col-sm-4'><p><img style='width: 20px; margin-right: 5px; position: relative; top: -3px;' src='images/icon/km-redes/icon-wsp.svg'>Whatsapp</p></div>
							<div class='col-xs-6 col-sm-4'><p><a href='#'><img style='width: 15px; margin-right: 5px; position: relative; top: -1px;' src='images/icon/km-redes/icon-mail.svg'>a.vera@kmimos.la</a></p></div>
							<div class='col-xs-12 col-sm-4'><p><img style='width: 12px; margin-right: 5px; position: relative; top: -1px;' src='images/icon/km-redes/icon-cel.svg'>(55) 6178 0320</p></div>
						</div>
						<hr>
						<div class='row'>
							<div class='col-xs-5'>
								<p>¿Ya tienes una cuenta?</p>
							</div>
							<div class='col-xs-7'>
								<a href='#' class='km-btn-border'><b>INICIAR SESIÓN</b></a>
							</div>
						</div>
					</div>
				<div class='popuphide popup-registrarte-nuevo-correo'>
					<p style='color: #979797; text-align: center;'>Regístrate por <a href='#'>Facebook</a> o <a href='#'>Google</a></a></p>
						<h3 style='margin: 0; text-align: center;'>Completa tus datos</h3>
					<form id='form_nuevo_cliente' name='form_nuevo_cliente' enctype='multipart/form-data' method='POST'>	
						<div class='km-box-form'>
							<div class='content-placeholder'>
								<div class='label-placeholder'>
									<label>Nombre</label>
									<input type='text' id='nombre' name='nombre' class='input-label-placeholder' data-charset='alf'>
								</div>
								<div class='label-placeholder'>
									<label>Apellido</label>
									<input type='text' name='apellido' id='apellido' class='input-label-placeholder' data-charset='alf'>
								</div>
								<div class='label-placeholder'>
									<label>IFE/Documento de Identidad</label>
									<input type='text' name='dni' id='dni'  class='input-label-placeholder' data-charset='num'>
								</div>
								<div class='label-placeholder'>
									<label>Correo electrónico</label>
									<input type='mail' name='email_1' id='email_1' class='input-label-placeholder' data-charset='espalfnum'>
									<span id='resultado'></span>
								</div>
								<div class='label-placeholder'>
									<label>Crea tu contraseña</label>
									<input type='password' name='pass' id='pass' min='8' max='20'  class='input-label-placeholder'>
								</div>
								<div class='label-placeholder'>
									<label>Teléfono</label>
									<input type='text' name='movil' id='movil' class='input-label-placeholder' data-charset='num'>
								</div>
								<div class='km-datos-mascota'>
									<select class='km-datos-mascota-opcion' name='genero' id='genero'>
										<option value=''>Género</option>
										<option value='hombre'>Hombre</option>
										<option value='mujer'>Mujer</option>
									</select>
								</div>
								<div class='km-datos-mascota'>
									<select class='km-datos-mascota-opcion' name='edad' id='edad'>
										<option value=''>Edad</option>
										<option value='18-25'>18-25 años</option>
										<option value='25-35'>25-35 años</option>
										<option value='Mayor-46'>Mayor 46 años</option>
									</select>
								</div>
								<div class='km-datos-mascota'>
									<select class='km-datos-mascota-opcion' name='fumador' id='fumador'>
										<option value=''>Es Fumador</option>
										<option value='SI'>Si</option>
										<option value='NO'>No</option>
									</select>
								</div>
							</div>
						</div>
					</form>
					<span id='guardando'></span>
					<a href='#' id='siguiente' class='km-btn-correo km-btn-popup-registrarte-nuevo-correo' onclick='registroNuevoUsuario()'>SIGUIENTE</a>
					<div id='resp'></div>
					<p style='color: #979797; margin-top: 20px;'>Al crear una cuenta, aceptas las condiciones del servicio y la Política de privacidad de Kmimos.</p>
					<p><img style='width: 20px; margin-right: 5px; position: relative; top: -3px;'src='images/icon/km-redes/icon-wsp.svg'>En caso de dudas escríbenos al whatsapp</p>
						<hr>
					<div class='row'>
						<div class='col-xs-5'>
							<p>¿Ya tienes una cuenta?</p>
						</div>
						<div class='col-xs-7'>
							<a href='#' class='km-btn-border km-link-login'><b>INICIAR SESIÓN</b></a>
						</div>
					</div>
				</div>
				<div class='popuphide popup-registrarte-datos-mascota'>
						<h3 style='margin: 0; text-align: center;'>Datos de tus Mascotas</h3>
						<p style='text-align: center;'>Queremos conocer más sobre tus mascotas, llena los campos</p>
						<div class='km-datos-foto'>
							<a href='#'><img src='images/popups/registro-cuidador-foto.svg'></a>
						</div>
						<div class='km-box-form'>
							<div class='content-placeholder'>
								<div class='label-placeholder'>
									<label>Nombre de tu mascota</label>
									<input type='text' name='pet_name' value='' class='input-label-placeholder'>
								</div>
								<div class='km-datos-mascota'>
									<select class='km-datos-mascota-opcion' name='pet_type' id='pet_type' onchange='cambio_tipo()'>
										<option>Tipo de Mascota</option>
										<option value='2605'>Perros</option>
										<option value='2608'>Gatos</option>
									</select>
									<select class='km-datos-mascota-opcion' name='pet_breed' id='pet_breed'>
										<option>Raza de la Mascota</option>
										<option>Gatos</option>
										<option></option>
									</select>
								</div>
								<div class='label-placeholder'>
									<label>Color de tu mascota</label>
									<input type='text' name='colormascota' value='' class='input-label-placeholder'>
								</div>
								<div class='km-fecha-nacimiento'>
									<input type='text' name='fechanacmascota' placeholder='Fecha de Nacimiento' value='' class='date_from'>
								</div>
								<div class='km-datos-mascota'>
									<select class='km-datos-mascota-opcion' name='generomascota'>
										<option>Género</option>
										<option>Mascota A</option>
										<option>Mascota B</option>
									</select>
								</div>
							</div>
						</div>
						<div class='row' style='margin-bottom: 20px;'>
							<div class='col-xs-6 col-sm-3'>
								<div class='km-opcion'><img src='images/icon/icon-pequenio.svg' width='25'><br><div class='km-opcion-text'><b>PEQUEÑO</b><br>0 a 25 cm</div></div>
							</div>
							<div class='col-xs-6 col-sm-3'>
								<div class='km-opcion'><img src='images/icon/icon-mediano.svg' width='25'><br><div class='km-opcion-text'><b>MEDIANO</b><br>25 a 58cm</div></div>
							</div>
							<div class='col-xs-6 col-sm-3'>
								<div class='km-opcion'><img src='images/icon/icon-grande.svg' width='25'><br><div class='km-opcion-text'><b>GRANDE</b><br>58 a 73 cm</div></div>
							</div>
							<div class='col-xs-6 col-sm-3'>
								<div class='km-opcion'><img src='images/icon/icon-gigante.svg' width='25'><br><div class='km-opcion-text'><b>GIGANTE</b><br>73 a 200 cm</div></div>
							</div>
						</div>
						<div class='km-registro-checkbox'>
							<div class='km-registro-checkbox-opcion'>
								<p>Mascota Estilizada</p>
								<div class='km-check-1'>
									<input type='checkbox' value='None' id='km-check-1' name='check' />
									<label for='km-check-1'></label>
								</div>
							</div>
							<div class='km-registro-checkbox-opcion'>
								<p>Mascota Sociable</p>
								<div class='km-check-2'>
									<input type='checkbox' value='None' id='km-check-2' name='check' />
									<label for='km-check-2'></label>
								</div>
							</div>
						</div>
						<div class='km-registro-checkbox' style='margin-top: 0px;'>
							<div class='km-registro-checkbox-opcion'>
								<p>Agresiva con Humanos</p>
								<div class='km-check-3'>
									<input type='checkbox' value='None' id='km-check-3' name='check' />
									<label for='km-check-3'></label>
								</div>
							</div>
							<div class='km-registro-checkbox-opcion'>
								<p>Agresiva con Mascotas</p>
								<div class='km-check-4'>
									<input type='checkbox' value='None' id='km-check-4' name='check' />
									<label for='km-check-4'></label>
								</div>
							</div>
						</div>
						<a href='#' class='km-btn-correo km-btn-popup-registrarte-datos-mascota'>REGISTRARME</a>
						<p style='color: #979797; margin-top: 20px;'>Al crear una cuenta, aceptas las condiciones del servicio y la Política de privacidad de Kmimos.</p>
						<p><img style='width: 20px; margin-right: 5px; position: relative; top: -3px;' src='images/icon/km-redes/icon-wsp.svg'>En caso de dudas escríbenos al whatsapp</p>
					</div>
					<div class='popuphide popup-registrarte-final'>
						<h3 style='margin: 0; text-align: center;'>¡FELICIDADES MARÍA,<br>TU REGISTRO SE REALIZÓ CON ÉXITO!</h3>
						<img src='images/popups/km-registro-exitoso.png'>
						<a href='index-sesion.html' class='km-btn-correo'>REGRESAR AL INICIO</a>
					</div>
				</div>
			</div>
		</div>	
";