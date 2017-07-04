<?php 
    /*
        Template Name: Contactanos
    */
    get_header();

	wp_enqueue_style('beneficios_kmimos', $home."/wp-content/themes/pointfinder/css/new/contactanos.css", array(), '1.0.0');
        
        $HTML = "
        	<form id='contactanos'>
        		<div id='campos'>
	        		<input type='text' id='nombre' placeholder='Nombre' required>
	        		<input type='email' id='email' placeholder='Correo Electr&oacute;nico' required>
                    <input type='text' id='asunto' placeholder='Asunto' required>
	        		<textarea id='mensaje' placeholder='Mensaje' required></textarea>
	        	</div>
        		<div id='botones'>
                    <span>Todos los campos son requeridos</span>
        			<input type='submit' value='Enviar' id='enviar'>
	        	</div>
                <div class='mensaje'>Mensaje Enviado Exitosamente!</div>
        	</form>
            <script>
                jQuery('#contactanos').submit(function(e){

                    jQuery('#enviar').attr('disabled', true);
                    jQuery('#enviar').addClass('bloquear');
                    jQuery('#enviar').attr('value', 'Enviando...');

                    var nom = jQuery('#nombre').val();
                    var mai = jQuery('#email').val();
                    var asu = jQuery('#asunto').val();
                    var msg = jQuery('#mensaje').val();

                    jQuery.post(
                        '".get_home_url()."/wp-content/themes/pointfinder/kmimos/contactanos/contactanos.php',
                        {
                            nombre: nom,
                            email: mai,
                            asunto: asu,
                            mensaje: msg
                        },
                        function(data){

                            jQuery('#enviar').attr('disabled', false);
                            jQuery('#enviar').removeClass('bloquear');
                            jQuery('#enviar').attr('value', 'Enviar');
                            jQuery('#contactanos .mensaje').show();

                            document.getElementById('contactanos').reset();

                            setTimeout(function(){ jQuery('#contactanos .mensaje').hide(); }, 3000);
                        }
                    );

                    e.preventDefault();
                });
            </script>
	    ";

	echo comprimir_styles($HTML);

    get_footer(); 
?>