<?php	
	$HTML .='
		<!-- POPUP CONOCE AL CUIDADOR -->
		<div id="popup-conoce-cuidador" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<div class="popup-iniciar-sesion-1">
						<p class="popup-tit">Solicitud para conocer al @Cuidador</p>
						<div>
						<p>Para poder conocer al cuidador primero tienes que:</p>
							<ol>
								<li>Haberte registrado en nuestro portal y haber iniciado sesión.</li>
								<li>Completar todos los datos requeridos en tu perfil</li>
								<li>Completar tu lista de mascotas en tu perfil</li>
							</ol>
						</div>
						<form id="conoce_cuidador">
							<div class="km-fecha-nacimiento">
								<input type="text" name="fech_conocer" id="fech_conocer" placeholder="¿Cuando deseas conocer al cuidador?" class="date_from">
							</div>
							<div class="km-datos-mascota">
								<select class="km-datos-mascota-opcion" name="hora_conoce" id="hora_conoce">
									<option value="">¿A qué hora te convendría la reunión?</option>
			                        	<option value="07:00:00" data-id="7">07:00  a.m.</option>
			                        	<option value="07:30:00" data-id="7.5">07:30  a.m.</option>
			                        	<option value="08:00:00" data-id="8">08:00  a.m.</option>
			                        	<option value="08:30:00" data-id="8.5">08:30  a.m.</option>
			                        	<option value="09:00:00" data-id="9">09:00  a.m.</option>
			                        	<option value="09:30:00" data-id="9.5">09:30  a.m.</option>
			                        	<option value="10:00:00" data-id="10">10:00  a.m.</option>
			                        	<option value="10:30:00" data-id="10.5">10:30  a.m.</option>
			                        	<option value="11:00:00" data-id="11">11:00  a.m.</option>
			                        	<option value="11:30:00" data-id="11.5">11:30  a.m.</option>
			                        	<option value="12:00:00" data-id="12">12:00  m</option>
			                        	<option value="12:30:00" data-id="12.5">12:30  m</option>
			                        	<option value="13:00:00" data-id="13">01:00  p.m.</option>
			                        	<option value="13:30:00" data-id="13.5">01:30  p.m.</option>
			                        	<option value="14:00:00" data-id="14">02:00  p.m.</option>
			                        	<option value="14:30:00" data-id="14.5">02:30  p.m.</option>
			                        	<option value="15:00:00" data-id="15">03:00  p.m.</option>
			                        	<option value="15:30:00" data-id="15.5">03:30  p.m.</option>
			                        	<option value="16:00:00" data-id="16">04:00  p.m.</option>
			                        	<option value="16:30:00" data-id="16.5">04:30  p.m.</option>
			                        	<option value="17:00:00" data-id="17">05:00  p.m.</option>
			                        	<option value="17:30:00" data-id="17.5">05:30  p.m.</option>
			                        	<option value="18:00:00" data-id="18">06:00  p.m.</option>
			                        	<option value="18:30:00" data-id="18.5">06:30  p.m.</option>
			                        	<option value="19:00:00" data-id="19">07:00  p.m.</option>
			                        </select>
							</div>
							<div class="label-placeholder">
								<label>¿Dónde deseas conocer al cuidador?</label>
								<input type="text" name="lugar_conoce" id="lugar_conoce" class="input-label-placeholder" data-charset="alf">
							</div>
							<div class="label-placeholder">
								<label>¿Qué mascotas requieren el servicio?</label>
								<input type="text" name="pet_conoce" id="pet_conoce" class="input-label-placeholder" data-charset="alf">
							</div>
							<div class="km-fecha-nacimiento">
								<input type="text" name="fech_conocer" id="fech_conocer" placeholder="¿Desde cuando requieres el servicio?" class="date_from">
							</div>
							<div class="km-fecha-nacimiento">
								<input type="text" name="fech_conocer" id="fech_conocer" placeholder="¿Hasta cuando requieres el servicio?" class="date_from">
							</div>

							<a href="#" id="login_submit" class="km-btn-basic">ENVIAR SOLICITUD</a>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- FIN POPUP CONOCE AL CUIDADOR -->
';