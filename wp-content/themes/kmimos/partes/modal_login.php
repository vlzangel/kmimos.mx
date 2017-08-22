<?php
$HTML .= "
			<div id='modal_login' class='modal_login'>
		        <div class='modal_container'>
		            <div class='modal_box'>
		                <img id='close_login' src='".getTema()."/images/closebl.png' />

						<form id='form_login'>
		                	<div class='form_box'>
			                	<input type='text' id='usuario' placeholder='Correo El&eacute;ctronico'>
			                	<input type='password' id='clave' placeholder='Contraseña'>
		                	</div>
		                	<div class='botones_box'>
		                		<input type='submit' value='Ingresar' style='display: none;'>
		                		<span id='login_submit'>Ingresar</span>
		                	</div>
		                </form>

						<form id='form_recuperar'>
		                	<div class='form_box'>
			                	<input type='text' id='usuario' placeholder='Correo El&eacute;ctronico'>
		                	</div>
		                	<div class='botones_box'>
		                		<span id='login_submit'>Recuperar</span>
		                	</div>
		                </form>

		            </div>
		        </div>
		    </div>
		";
