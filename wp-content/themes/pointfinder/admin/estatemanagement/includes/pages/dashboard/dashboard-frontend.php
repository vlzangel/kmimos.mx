<script type="text/javascript">
    function jau_ver_municipios(CB){
		var id =  jQuery("#estados").val();
		var txt = jQuery("#estados option:selected").text();
        jQuery.ajax( {
            method: "POST",
                data: { estado: id },
            url: "<?php echo get_template_directory_uri(); ?>/vlz/ajax_municipios.php",
            beforeSend: function( xhr ) {
		    	jQuery("#municipios").html("<option value=''>Cargando Localidades</option>");
		    	console.log(jQuery('#municipios'))
            }
        }).done(function(data){
			jQuery("#municipios").html("<option value=''>Seleccione una Localidad</option>"+data);
            if( CB != undefined) {
                CB();
            }
        });
    }
</script>

<?php
/**********************************************************************************************************************************
*
* Custom Detail Fields Frontend Class
* 
* Author: Webbu Design
*
* Location: /public_html/wp-content/themes/pointfinder/admin/estatemanagement/includes/pages/dashboard/
*
***********************************************************************************************************************************/

if ( ! class_exists( 'PF_Frontend_Fields' ) ){
	class PF_Frontend_Fields{

		public $FieldOutput;
		public $ScriptOutput;
		public $ScriptOutputDocReady;
		public $VSORules;
		public $VSOMessages;
		public $PFHalf = 1;
		private $itemrecurringstatus = 0;

		function __construct($params = array()){	

			$defaults = array( 
		        'fields' => '',
		        'formtype' => '',
		        'sccval' => '',
				'errorval' => '',
				'post_id' => '',
				'sheader' => '',
				'sheadermes' => '',
				'current_user' => '',
				'dontshowpage' => 0,
				'redirect' => false
		    );

		    $params = array_merge($defaults, $params);

		    $setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','','');
			$setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
			$pfmenu_perout = PFPermalinkCheck();

			$lang_custom = '';

			if(function_exists('icl_object_id')) {
				$lang_custom = PF_current_language();
			}

				$this->FieldOutput = '<div class="golden-forms">';
				$this->FieldOutput .= '<form id="pfuaprofileform" enctype="multipart/form-data" name="pfuaprofileform" method="POST" action="">';
				$this->FieldOutput .= '<div class="pfsearchformerrors"><ul></ul><a class="button pfsearch-err-button">'.esc_html__('CERRAR','pointfindert2d').'</a></div>';
				if($params['sccval'] != ''){
					$this->FieldOutput .= '<div class="notification success" id="pfuaprofileform-notify"><div class="row"><p>'.$params['sccval'].'<br>'.$params['sheadermes'].'</p></div></div>';
					$this->ScriptOutput .= '$(document).ready(function(){$.pfmessagehide();});';
				}
				if($params['errorval'] != ''){
					$this->FieldOutput .= '<div class="notification error" id="pfuaprofileform-notify"><p>'.$params['errorval'].'</p></div>';
					$this->ScriptOutput .= '$(document).ready(function(){$.pfmessagehide();});';
				}
				$this->FieldOutput .= '<div class="">';
				$this->FieldOutput .= '<div class="">';
				$this->FieldOutput .= '<div class="row">';

				$main_submit_permission = true;
				$main_package_purchase_permission = false;
				$main_package_renew_permission = false;
				$main_package_limit_permission = false;
				$main_package_upgrade_permission = false;
				$main_package_expire_problem = false;

				$hide_button = false;

				switch ($params['formtype']) {
					
					case 'myshop':
						include("./wp-content/themes/pointfinder/vlz/admin/page_myshop.php");
					break;

					case 'mypets':
						
						$formaction = 'pfadd_new_pet';
						$noncefield = wp_create_nonce($formaction);
						$buttonid = 'pf-ajax-add-pet-button';
						$buttontext = esc_html__('AGREGAR MASCOTA','pointfindert2d');
						$user_id = $current_user->ID;
                        $count = ($params['count']!='')? $params['count']: 0;

						// BEGIN New style Italo
						if($count>0) {
						    $pets = explode(",",$params['list']);

						    $this->FieldOutput .= '<ul class="pfitemlists-content-elements pf3col" data-layout-mode="fitRows" style="position: relative; margin: 20px -15px 20px 0px;">';
						    foreach($pets as $pet){ 
							    $pet_detail = kmimos_get_pet_info($pet);

							    $photo = (!empty($pet_detail['photo']))? get_option('siteurl').'/'.$pet_detail['photo'] : get_option('siteurl').'/wp-content/themes/pointfinder/images/default.jpg';
							    $this->FieldOutput .= '
								<li class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wpfitemlistdata isotope-item text-center">
									<div class="pflist-item" style="background-color:#ffffff;">  
										<div class="pflist-item-inners">
											<div class="pflist-imagecontainer pflist-subitem" style="
												background-image: url('.$photo.')!important;
												background-size:contain;
												background-repeat:no-repeat;
												background-position:center;">
											<a href="'.$params['detail_url'].$pet.'">
												<div class="vlz_postada_cuidador" style="height:160px;width:100%;background-color:transparent;"></div>
												</div>
												<h3 class="kmi_link">'. get_the_title($pet).'</h3>
											</a>
											<br>
											<img src="'.get_home_url().'/wp-content/plugins/kmimos/assets/rating/100.png" width="50px">
										</div>
									</div>
								</li>';
							}
						    $this->FieldOutput .= '</ul>';
						}else{
							$this->FieldOutput .=  '
							<p>
								<img src="'.get_home_url().'/wp-content/plugins/kmimos/assets/rating/100.png" width="50px">
								No tienes ninguna mascota cargada
							</p>';
						}
					
                        $this->ScriptOutput .= "
                        jQuery('#pf-ajax-add-pet-button').on('click',function(e){
                            e.preventDefault();
                            jQuery('#pfuaprofileform').attr('action','?ua=newpet');
                            jQuery('#pfuaprofileform').submit();
                        });
                        ";

					break;
    
					case 'mypet':

				        $formaction = 'pfupdate_my_pet';
                        $noncefield = wp_create_nonce($formaction);
                        $buttonid = 'pf-ajax-update-pet-button';
                        $buttontext = esc_html__('ACTUALIZAR MASCOTA','pointfindert2d');
                        $pet_id = $params['pet_id'];
                        $current_pet = kmimos_get_pet_info($pet_id);

                        $photo_pet = (!empty($current_pet['photo']))? "/".$current_pet['photo']: "/wp-content/themes/pointfinder/images/noimg.png";

                        $tipos = kmimos_get_types_of_pets();
                        $tipos_str = "";
                        foreach ( $tipos as $tipo ) {
                            $tipos_str .= '<option value="'.$tipo->ID.'"';
                            if($tipo->ID == $current_pet['type']) $tipos_str .= ' selected';
                            $tipos_str .= '>'.esc_html( $tipo->name ).'</option>';
                        }

                       	global $wpdb;
                		$razas = $wpdb->get_results("SELECT * FROM razas ORDER BY nombre ASC");
                		$razas_str = "<option value=''>Favor Seleccione</option>";
                    	foreach ($razas as $value) {
                    		$razas_str .= '<option value="'.$value->id.'"';
                            if($value->id == $current_pet['breed']) $razas_str .= ' selected';
                            $razas_str .= '>'.esc_html( $value->nombre ).'</option>';
                    	}
                		$razas_str_gatos = "<option value=1>Gato</option>";

                		$generos = kmimos_get_genders_of_pets();
                		$generos_str = "";
                        foreach ( $generos as $genero ) {
                            $generos_str .= '<option value="'.$genero['ID'].'"';
                            if($genero['ID'] == $current_pet['gender']) $generos_str .= ' selected';
                            $generos_str .= '>'.esc_html( $genero['singular'] ).'</option>';
                        }

                        $tamanos = kmimos_get_sizes_of_pets();
                        $tamanos_str = "";
                        foreach ( $tamanos as $tamano ) {
                            $tamanos_str .= '<option value="'.$tamano['ID'].'"';
                            if($tamano['ID'] == $current_pet['size']) $tamanos_str .= ' selected';
                            $tamanos_str .= '>'.esc_html( $tamano['name'].' ('.$tamano['desc'].')' ).'</option>';
                        }

                        $si_no = array('no','si');
                        $esterilizado_str = "";
                        for ( $i=0; $i<2; $i++ ) {
                            $esterilizado_str .= '<option value="'.$i.'"';
                            if($i == (int)$current_pet['sterilized']) $esterilizado_str .= ' selected';
                            $esterilizado_str .= '>'.$si_no[$i].'</option>';
                        }

                        $sociable_str = "";
                        for ( $i=0; $i<count($si_no); $i++ ) {
                            $sociable_str .= '<option value="'.$i.'"';
                            if($i == (int)$current_pet['sociable']) $sociable_str .= ' selected';
                            $sociable_str .= '>'.$si_no[$i].'</option>';
                        }

                        $aggresive_humans_str = "";
                        for ( $i=0; $i<count($si_no); $i++ ) {
                            $aggresive_humans_str .= '<option value="'.$i.'"';
                            if($i == (int)$current_pet['aggresive_humans']) $aggresive_humans_str .= ' selected';
                            $aggresive_humans_str .= '>'.$si_no[$i].'</option>';
                        }

                        $aggresive_pets_str = "";
                        for ( $i=0; $i<count($si_no); $i++ ) {
                            $aggresive_pets_str .= '<option value="'.$i.'"';
                            if($i == (int)$current_pet['aggresive_pets']) $aggresive_pets_str .= ' selected';
                            $aggresive_pets_str .= '>'.$si_no[$i].'</option>';
                        }

                        $this->FieldOutput .= '
                            <style>
	                        	.cell50 {width: 50%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
	                        	.cell25 {width: 25%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
	                        	.cell33 {width: 33.333333333%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
	                        	.img_portada_pet{ position: relative; height: 400px; overflow: hidden; border: solid 1px #777; background: #EEE; }
	                        	.img_portada_pet_fondo{ position: absolute; top: -1px; left: -1px; width: calc( 100% + 2px ); height: 402px; z-index: 50; background-size: cover; background-position: center; background-repeat: no-repeat; background-color: transparent; filter: blur(2px); transition: all .5s ease; }
	                        	.img_portada_pet_normal{ position: absolute; top: 0px; left: 0px; width: 100%; height: 380px; z-index: 100; background-size: contain; background-position: center; background-repeat: no-repeat; background-color: transparent; margin: 10px 0px; transition: all .5s ease; }
	                        	.cambiar_portada_pet{ position: absolute; bottom: 10px; right: 10px; width: auto; padding: 10px; font-size: 16px; color: #FFF; background: #000; border: solid 1px #777; z-index: 200; }
	                        	.cambiar_portada_pet input{ position: absolute; top: -24px; left: 0px; width: 100%; height: 167%; z-index: 100; opacity: 0; cursor: pointer; }
	                        	
	                        	.jj_dash_cel50{float: left; width: calc(50% - 9px);}
								.jj_dash2_cel50{float: right; width: calc(50% - 9px);}

								@media (max-width: 568px) { 
									.jj_dash_cel50{float: left; width: calc(100% - 9px);}
									.jj_dash2_cel50{float: left; width: calc(100% - 9px);} 
								}
	                        </style>
							<section>
								<div class="img_portada_pet">
	                                <div class="img_portada_pet_fondo" style="background-image: url('.$photo_pet.');"></div>
	                                <div class="img_portada_pet_normal" style="background-image: url('.$photo_pet.');"></div>
	                                <div class="cambiar_portada_pet">
	                                	Cambiar Foto
	                                	<input type="file" id="portada_pet" name="portada_pet" accept="image/*" />
	                                </div>
                            	</div>
                            </section>

                           <div class="cell50">
                               <section>
                                    <label for="pet_name" class="lbl-text">'.esc_html__('Nombre de la Mascota','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<input type="hidden" name="pet_id" value="'.$current_pet['pet_id'].'" />
                                    	<input type="text" name="pet_name" class="input" value="'.$current_pet['name'].'" />
                                    </label>
                               </section>
                           </div>

                           <div class="cell50">
                           	   <section>
                                    <label for="pet_type" class="lbl-text"><strong>'.esc_html__('Tipo de Mascota','pointfindert2d').'</strong>:</label>
                                    <label class="lbl-ui">
                                    	<select name="pet_type" class="input" id="pet_type" onchange="vlz_cambio_tipo()" />
                                            <option value="">Favor Seleccione</option>
                                            '.$tipos_str.'
                                        </select>
                                    </label>
                               </section>
                           </div>

                			<div id="razas_perros" style="display: none;">'.$razas_str.'</div>
                			<div id="razas_gatos" style="display: none;">'.$razas_str_gatos.'</div>
                           	<div class="cell50">
                               <section>
                                    <label for="pet_breed" class="lbl-text">'.esc_html__('Raza de la Mascota','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<select id="pet_breed" name="pet_breed" class="input" value="'.$current_pet['breed'].'" />
                                    		'.$razas_str.'
                                    	</select>
                                    </label>
                               </section>
                           </div>
                           <div class="cell50">
                               <section>
                                    <label for="pet_colors" class="lbl-text">'.esc_html__('Colores de la Mascota','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<input type="text" name="pet_colors" class="input" value="'.$current_pet['colors'].'" />
                                    </label>
                               </section>
                           </div>
                           <div class="cell25">
                               <section>
                                    <label for="pet_birthdate" class="lbl-text">'.esc_html__('Fecha de nacimiento','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<input type="date" name="pet_birthdate" min="'.date("Y-m-d", strtotime('Now -30 years')).'" max="'.date("Y-m-d", strtotime('Now -1 day')).'" class="input datepicker" value="'.$current_pet['birthdate'].'" />
                                    </label>
                               </section>
                           </div> 
                           <div class="cell25">
                               <section>
                                    <label for="pet_gender" class="lbl-text">'.esc_html__('Género de la mascota','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<select name="pet_gender" class="input" />
                                            <option value="">Favor Seleccione</option>
                                            '.$generos_str.'
                                        </select>
                                    </label>
                               	</section>
                           	</div>
                           	<div class="cell50">
                           	   	<section>
                                    <label for="pet_size" class="lbl-text"><strong>'.esc_html__('Tamaño de la Mascota','pointfindert2d').'</strong>:</label>
                                    <label class="lbl-ui">
                                    	<select name="pet_size" class="input" />
                                            <option value="">Favor Seleccione</option>
                                            '.$tamanos_str.'
                                        </select>
                                    </label>
                               	</section>
                           	</div> 
                           	<div class="cell25">
                               	<section>
                                    <label for="pet_sterilized" class="lbl-text">'.esc_html__('Mascota Esterilizada','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<select name="pet_sterilized" class="input" />
                                            <option value="">Favor Seleccione</option>
                                            '.$esterilizado_str.'
                                        </select>
                                    </label>
                               	</section> 
                           </div>
                           <div class="cell25">
                               <section>
                                    <label for="pet_sociable" class="lbl-text">'.esc_html__('Mascota Sociable','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<select name="pet_sociable" class="input" />
                                            <option value="">Favor Seleccione</option>
                                            '.$sociable_str.'
                                        </select>
                                    </label>
                               </section> 
                           </div>
                           <div class="cell25">
                               <section>
                                    <label for="aggresive_humans" class="lbl-text">'.esc_html__('Agresiva con Humanos','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<select name="aggresive_humans" class="input" />
                                            <option value="">Favor Seleccione</option>
                                            '.$aggresive_humans_str.'
                                        </select>
                                    </label>
                               </section> 
                           </div>
                           <div class="cell25">
                               <section>
                                    <label for="aggresive_pets" class="lbl-text">'.esc_html__('Agresiva c/otras Mascotas','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<select name="aggresive_pets" class="input" />
                                            <option value="">Favor Seleccione</option>
                                            '.$aggresive_pets_str.'
                                        </select>
                                    </label>
                               </section>
                           </div>    
                           <section>
                                <label for="pet_observations" class="lbl-text">'.esc_html__('Observaciones','pointfindert2d').':</label>
                                <label class="lbl-ui">
                                	<textarea name="pet_observations" class="textarea">'. $current_pet['observations'].'</textarea>
                                </label>
                                <label for="delete_pet" class="lbl-text" style="float: right; padding: 10px 0px;">
                                <input type="checkbox" name="delete_pet" value="1">
                                <strong>'.esc_html__('Eliminar esta mascota','pointfindert2d').'</strong>.</label>
                           </section>
                            <script>
                            	function vlz_cambio_tipo(){
                            		var valor = jQuery("#pet_type").val();
                            		if( valor == "2605" ){
                            			var opciones = jQuery("#razas_perros").html();
                            			jQuery("#pet_breed").html(opciones);
                            		}
                            		if( valor == "2608" ){
                            			var opciones = jQuery("#razas_gatos").html();
                            			jQuery("#pet_breed").html(opciones);
                            		}
                            	}

								function vista_previa_pet(evt) {
								  	var files = evt.target.files;
								  	for (var i = 0, f; f = files[i]; i++) {  
								       	if (!f.type.match("image.*")) {
								            continue;
								       	}
								       	var reader = new FileReader();
								       	reader.onload = (function(theFile) {
								           return function(e) {
								    			jQuery(".img_portada_pet_fondo").css("background-image", "url("+e.target.result+")");
								    			jQuery(".img_portada_pet_normal").css("background-image", "url("+e.target.result+")");
								           };
								       })(f);
								       reader.readAsDataURL(f);
								   	}
								}   

								document.getElementById("portada_pet").addEventListener("change", vista_previa_pet, false);
							</script> 
                        ';
					break;
                        
					case 'dirpets':
                        $formaction = 'pfpets_view_list';
                        $noncefield = wp_create_nonce($formaction);
                        $buttonid = 'pf-ajax-pets-view-list';
                        $buttontext = esc_html__('VER MIS MASCOTAS','pointfindert2d');
                        $this->ScriptOutput = 'jQuery("#pfuaprofileform").prop("action","?ua=mypets");';
					break;
                        
					case 'delpet':
                        $formaction = 'pfpet_delete_confirm';
                        $noncefield = wp_create_nonce($formaction);
                        $buttonid = 'pf-ajax-delete-confirm-button';
                        $buttontext = esc_html__('CONFIRMAR ELIMINACIÓN','pointfindert2d');
                        $this->FieldOutput .= '
                            <h1>Eliminación de Mascota de lista del cuidador</h1><hr><br>
                                  <section>
                                    <label for="confirm_delete" class="lbl-text">
                                    <input type="hidden" name="pet_id" value="'.$_GET['id'].'">
                                    <input type="checkbox" name="confirm_delete" id="confirm_delete" value="1">
                                    <strong>'.esc_html__('Estoy realmente seguro de querer eliminar esta mascota','pointfindert2d').'</strong>.</label>
                                </section>
                            <br>
                            jQuery("#pf-ajax-delete-confirm-button").prop("disabled",true);
                            jQuery("#pfuaprofileform").prop("action","?ua=delpet");
                            jQuery("#confirm_delete").on("click",function(e){
                                if(jQuery(this).is(":checked")) jQuery("#pf-ajax-delete-confirm-button").prop("disabled",false);
                            });
						';
					break;

					case 'myissues':
                        $user_id = $current_user->ID;
                        $count = ($params['count']!='')? $params['count']: 0;
                        $this->FieldOutput .= '<div class="lista_pendientes" data-user="'.$user_id.'"><ul>';
	                        if($count>0) {
	                            $issues = explode(",",$params['list']);
	                            $this->FieldOutput .= '<div class="inside">';
	                            $this->FieldOutput .= '<ul>';
	                            foreach($issues as $issue){ 
	                                $this->FieldOutput .= '<li><a href="'.$params['detail_url'].$issue.'">'. get_the_title($issue).'</a></li>';
	                            }
	                            $this->FieldOutput .= '</ul>';
	                            $this->FieldOutput .= '<br><p>Total: '.count($issues).' asuntos pendientes</p>';
	                            $this->FieldOutput .= '</div>';
	                        }else{
	                        	$this->FieldOutput .=  '<p>No tienes ningún asunto pendiente</p>';
	                        }
                        $this->FieldOutput .=  '</ul><br></div>';
					break;

					case 'myservices':
						include("./wp-content/themes/pointfinder/vlz/admin/mis_servicios.php");
					break;

					case 'mypictures':
							$current_user = get_user_by( 'id', $params['current_user'] ); 
                            $formaction = 'pfadd_new_picture';
                            $noncefield = wp_create_nonce($formaction);
							$buttonid = 'pf-ajax-add-picture-button';
							$buttontext = esc_html__('AGREGAR FOTO','pointfindert2d');
							$user_id = $current_user->ID;
                            $pics_count = ($params['count']!='')? $params['count']: 0;

                            global $wpdb;
                            $cuidador = $wpdb->get_row("SELECT * FROM cuidadores WHERE user_id = {$user_id}");

							$this->FieldOutput .= '<ul class="pfitemlists-content-elements pf3col" data-layout-mode="fitRows" style="position: relative; margin: 20px -15px 20px 0px;">';
                            $exist_file = false;
                            $tmp_user_id = ($cuidador->id) - 5000;
							$path_galeria = "wp-content/uploads/cuidadores/galerias/".$tmp_user_id."/";
							$count_picture =0;
							if( is_dir($path_galeria) ){
								if ($dh = opendir($path_galeria)) { 
									$imagenes = array();
							        while (($file = readdir($dh)) !== false) { 
							            if (!is_dir($path_galeria.$file) && $file!="." && $file!=".."){ 
				                           $exist_file = true;
				                           $count_picture++;               
									    $this->FieldOutput .= '
										<li class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wpfitemlistdata isotope-item">
											<div class="pflist-item" style="background-color:#ffffff;">  
												<div class="pflist-item-inners">
													<div class="pflist-imagecontainer pflist-subitem" style="
														background-image: url('.get_option('siteurl').'/'.$path_galeria.$file.')!important;
														background-size:contain;
														background-repeat:no-repeat;
														background-position:center;
													">
														<div class="vlz_postada_cuidador" style="height:160px;width:100%;background-color:transparent;"></div>
													</div>
													<a href="'.get_option('siteurl').'/perfil-usuario/?ua=mypicturesdel&p='.$file.'" style="color:red;">Eliminar</a>
												</div>
											</div>
										</li>';
							            } 
							        } 
							      	closedir($dh);
								}
							}					
                            if(!$exist_file)
                            {
                            	$this->FieldOutput .=  '<li><p>No tienes ninguna foto cargada</p></li>';
                            }
						    $this->FieldOutput .= '</ul>';
						if($count_picture >= 10){
							$hide_button = true;
                    	}

						$this->ScriptOutput .= "
                        jQuery('#pf-ajax-add-picture-button').on('click',function(e){
                            e.preventDefault();
                            jQuery('#pfuaprofileform').attr('action','?ua=newpicture');
                            jQuery('#pfuaprofileform').submit();
                        });
                        jQuery('.img_gallery').on('click',function(e){
                            e.preventDefault();
                            var id = jQuery(this).attr('data-id');
                            var num = jQuery(this).attr('title');
                            jQuery('#pfuaprofileform').attr('action','?ua=mypicture&id='+id+'&num='+num);
                            jQuery('#pfuaprofileform').submit();
                        });
                        ";   
					break;
    
					case 'mypicture':
						
                        $formaction = 'pfupdate_my_picture';
                        $noncefield = wp_create_nonce($formaction);
                        $buttonid = 'pf-ajax-update-picture-button';
                        $buttontext = esc_html__('ACTUALIZAR FOTO','pointfindert2d');
                        $picture_id = $params['picture_id'];
                        $pictures = $params['pictures_count'];

                        $this->FieldOutput .= '
	                        <section>
	                              <div class="photo-container" style="text-align: center;">
	                       		  '.wp_get_attachment_image($picture_id, array(800,600)).'
	                       		  </div>
	                        </section>';

                        if($_GET['ua']=='newpicture') $this->FieldOutput .= '     
								<style>
		                        	.cell50 {width: 50%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
		                        	.cell25 {width: 25%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
		                        	.cell33 {width: 33.333333333%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
		                        	.img_portada_picture{ position: relative; height: 400px; overflow: hidden; border: solid 1px #777; background: #EEE; }
		                        	.img_portada_picture_fondo{ position: absolute; top: -1px; left: -1px; width: calc( 100% + 2px ); height: 402px; z-index: 50; background-size: cover; background-position: center; background-repeat: no-repeat; background-color: transparent; filter: blur(2px); transition: all .5s ease; }
		                        	.img_portada_picture_normal{ position: absolute; top: 0px; left: 0px; width: 100%; height: 380px; z-index: 100; background-size: contain; background-position: center; background-repeat: no-repeat; background-color: transparent; margin: 10px 0px; transition: all .5s ease; }
		                        	.cambiar_portada_picture{ position: absolute; bottom: 10px; right: 10px; width: auto; padding: 10px; font-size: 16px; color: #FFF; background: #000; border: solid 1px #777; z-index: 200; }
		                        	.cambiar_portada_picture input{ position: absolute; top: -24px; left: 0px; width: 100%; height: 167%; z-index: 100; opacity: 0; cursor: pointer; }
		                        	
		                        	.jj_dash_cel50{float: left; width: calc(50% - 9px);}
									.jj_dash2_cel50{float: right; width: calc(50% - 9px);}

									@media (max-width: 568px) { 
										.jj_dash_cel50{float: left; width: calc(100% - 9px);}
										.jj_dash2_cel50{float: left; width: calc(100% - 9px);} 
									}
		                        </style>
								<section>
									<div class="img_portada_picture">
		                                <div class="img_portada_picture_fondo" style="background-image: url('.$photo_picture.');"></div>
		                                <div class="img_portada_picture_normal" style="background-image: url('.$photo_picture.');"></div>
		                                <div class="cambiar_portada_picture">
		                                	Cargar Foto
		                                	<input type="file" id="portada_picture" name="petsitter_photo" accept="image/*" />
		                                </div>
                                	</div>                              	
                                </section>
								<script>
								function vista_previa_picture(evt) {
									var files = evt.target.files;
									for (var i = 0, f; f = files[i]; i++) {  
								   	if (!f.type.match("image.*")) {
								        continue;
								   	}
								   	var reader = new FileReader();
								   	reader.onload = (function(theFile) {
								       return function(e) {
											jQuery(".img_portada_picture_fondo").css("background-image", "url("+e.target.result+")");
											jQuery(".img_portada_picture_normal").css("background-image", "url("+e.target.result+")");
											jQuery("#portada_picture_base64").val(e.target.result);
								       };
								   })(f);
								   reader.readAsDataURL(f);
									}
								}      
								document.getElementById("portada_picture").addEventListener("change", vista_previa_picture, false);
								</script> 
								';

                        else $this->FieldOutput .= '     
		                               <section>
		                                    <label for="delete_picture" class="lbl-text" style="float: right;">
                                            <input type="checkbox" name="delete_picture" value="1">
                                            <strong>'.esc_html__('Eliminar esta foto','pointfindert2d').'</strong>.</label>
		                               </section>';
						break;
  
					case 'cancelreq':

								$formaction = 'pfbepetsitter_cancel_confirm';
								$noncefield = wp_create_nonce($formaction);
								$buttonid = 'pf-ajax-cancel-confirm-button';
								$buttontext = esc_html__('SOLICITAR CANCELACIÓN','pointfindert2d');
                            $this->FieldOutput .= '
                                    <h1>Cancelación de Postulación para ser cuidador</h1><hr><br>
		                                  <section>
		                                    <label for="confirm_cancel" class="lbl-text">
                                            <input type="checkbox" name="confirm_cancel" id="confirm_cancel" value="1">
                                            <strong>'.esc_html__('Estoy realmente seguro de querer cancelar mi postulación','pointfindert2d').'</strong>.</label>
                                        </section>
                                    <br>';
								$this->ScriptOutput = '
                                    jQuery("#pf-ajax-cancel-confirm-button").prop("disabled",true);
                                    jQuery("#confirm_cancel").on("click",function(e){
                                        if(jQuery(this).is(":checked")) jQuery("#pf-ajax-cancel-confirm-button").prop("disabled",false);
                                    });
								';

					break;

					case 'profile':

						$noncefield = wp_create_nonce('pfget_updateuserprofile');
						$formaction = 'pfget_updateuserprofile';
						$buttonid = 'pf-ajax-profileupdate-button';
						$buttontext = esc_html__('ACTUALIZAR INFORMACIÓN','pointfindert2d');
						$current_user = get_user_by( 'id', $params['current_user'] ); 
						$user_id = $current_user->ID;
						$usermetaarr = get_user_meta($user_id);
						$setup4_membersettings_paymentsystem = PFSAIssetControl('setup4_membersettings_paymentsystem','','1');

						$stp_prf_vat = PFSAIssetControl('stp_prf_vat','','1');
						$stp_prf_country = PFSAIssetControl('stp_prf_country','','1');
						$stp_prf_address = PFSAIssetControl('stp_prf_address','','1');
						
						if(!isset($usermetaarr['first_name'])){$usermetaarr['first_name'][0] = '';}
						if(!isset($usermetaarr['last_name'])){$usermetaarr['last_name'][0] = '';}
						if(!isset($usermetaarr['user_referred'])){$usermetaarr['user_referred'][0] = '';}
						if(!isset($usermetaarr['user_phone'])){$usermetaarr['user_phone'][0] = '';}
						if(!isset($usermetaarr['user_mobile'])){$usermetaarr['user_mobile'][0] = '';}
						if(!isset($usermetaarr['description'])){$usermetaarr['description'][0] = '';}
						if(!isset($usermetaarr['nickname'])){$usermetaarr['nickname'][0] = '';}
						if(!isset($usermetaarr['user_twitter'])){$usermetaarr['user_twitter'][0] = '';}
						if(!isset($usermetaarr['user_facebook'])){$usermetaarr['user_facebook'][0] = '';}
						if(!isset($usermetaarr['user_googleplus'])){$usermetaarr['user_googleplus'][0] = '';}
						if(!isset($usermetaarr['user_linkedin'])){$usermetaarr['user_linkedin'][0] = '';}
						if(!isset($usermetaarr['user_vatnumber'])){$usermetaarr['user_vatnumber'][0] = '';}
						if(!isset($usermetaarr['user_country'])){$usermetaarr['user_country'][0] = '';}
						if(!isset($usermetaarr['user_address'])){$usermetaarr['user_address'][0] = '';}

						if(!isset($usermetaarr['user_photo'])){
							$usermetaarr['user_photo'][0] = '0';
						}

						$this->ScriptOutput = "
							$.pfAjaxUserSystemVars4 = {};
							$.pfAjaxUserSystemVars4.email_err = '".esc_html__('Por favor, escriba un correo electrónico','pointfindert2d')."';
							$.pfAjaxUserSystemVars4.email_err2 = '".esc_html__('Su dirección de correo electrónico debe estar en el formato de nombre@dominio.com','pointfindert2d')."';
							$.pfAjaxUserSystemVars4.nickname_err = '".esc_html__('Por favor, escriba apodo','pointfindert2d')."';
							$.pfAjaxUserSystemVars4.nickname_err2 = '".esc_html__('Por favor, introduzca al menos 3 caracteres por el apodo.','pointfindert2d')."';
							$.pfAjaxUserSystemVars4.passwd_err = '".esc_html__('Introduzca al menos 7 caracteres','pointfindert2d')."';
							$.pfAjaxUserSystemVars4.passwd_err2 = '".esc_html__('Introduzca la misma contraseña que el anterior','pointfindert2d')."';
						";

						$user = new WP_User( $user_id );

                        $referred = $usermetaarr['name_photo'][0];
                        if( $referred == "" ){
							$referred = "0";
						}
						if( $user->roles[0] == "vendor" ){
							global $wpdb;
							$cuidador = $wpdb->get_row("SELECT id, portada FROM cuidadores WHERE user_id = '$user_id'");
							$user_id_tipo = $cuidador->id;

							$name_photo = get_user_meta($user_id, "name_photo", true);
							if( empty($name_photo)  ){ $name_photo = "0.jpg"; }

							if( file_exists("wp-content/uploads/cuidadores/avatares/".$cuidador->id."/{$name_photo}") ){
								$imagen = get_home_url()."/wp-content/uploads/cuidadores/avatares/".$cuidador->id."/{$name_photo}";
							}elseif( file_exists("/wp-content/uploads/cuidadores/avatares/".$cuidador->id."/0.jpg") ){
								$imagen = get_home_url()."/wp-content/uploads/cuidadores/avatares/".$cuidador->id."/0.jpg";
							}else{
								$imagen = get_template_directory_uri().'/images/noimg.png';
							}
						}else{
							$user_id_tipo = $user_id;
							$name_photo = get_user_meta($user_id, "name_photo", true);
							if( empty($name_photo)  ){ $name_photo = "0"; }
							if( file_exists("wp-content/uploads/avatares_clientes/".$user_id."/{$name_photo}") ){
								$imagen = get_home_url()."/wp-content/uploads/avatares_clientes/".$user_id."/{$name_photo}";
							}elseif( file_exists("wp-content/uploads/avatares_clientes/".$user_id."/0.jpg") ){
								$imagen = get_home_url()."/wp-content/uploads/avatares_clientes/".$user_id."/0.jpg";
							}else{
								$imagen = get_template_directory_uri().'/images/noimg.png';
							}
							
						}

                        $referred = $usermetaarr['user_referred'][0];

                        $opciones = get_referred_list_options(); $ref_str = "";
                        foreach($opciones as $key=>$value){
                            $selected = ($referred==$key)? ' selected':'';
                            $ref_str .= '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
                        }

						$this->FieldOutput .= '
							<style>
	                        	.cell50 {width: 50%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
	                        	.cell25 {width: 25%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
	                        	.cell33 {width: 33.333333333%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
	                        	.img_portada{ position: relative; height: 400px; overflow: hidden; border: solid 1px #777; background: #EEE; }
	                        	.img_portada_fondo{ position: absolute; top: -1px; left: -1px; width: calc( 100% + 2px ); height: 402px; z-index: 50; background-size: cover; background-position: center; background-repeat: no-repeat; background-color: transparent; filter: blur(2px); transition: all .5s ease; }
	                        	.img_portada_normal{ position: absolute; top: 0px; left: 0px; width: 100%; height: 380px; z-index: 100; background-size: contain; background-position: center; background-repeat: no-repeat; background-color: transparent; margin: 10px 0px; transition: all .5s ease; }
	                        	.cambiar_portada{ position: absolute; bottom: 10px; right: 10px; width: auto; padding: 10px; font-size: 16px; color: #FFF; background: #000; border: solid 1px #777; z-index: 200; }
	                        	.cambiar_portada input{ position: absolute; top: -24px; left: 0px; width: 100%; height: 167%; z-index: 100; opacity: 0; cursor: pointer; }
	                        	
	                        	.jj_dash_cel50{float: left; width: calc(50% - 9px);}
								.jj_dash2_cel50{float: right; width: calc(50% - 9px);}

								@media (max-width: 568px) { 
									.jj_dash_cel50{float: left; width: calc(100% - 9px);}
									.jj_dash2_cel50{float: left; width: calc(100% - 9px);} 
								}
	                        </style>

							<section>
								<input type="hidden" name="tipo_user" value="'.$user->roles[0].'" />
								<input type="hidden" name="user_tipo" value="'.$user_id_tipo.'" />
								<div class="img_portada">
	                                <div class="img_portada_fondo" style="background-image: url('.$imagen.');"></div>
	                                <div class="img_portada_normal" style="background-image: url('.$imagen.');"></div>
	                                <div class="cambiar_portada">
	                                	Cambiar Foto
	                                	<input type="file" id="portada" name="portada" accept="image/*" />
	                                </div>
                            	</div>
                            </section>

                           	<div class="jj_dash_cel50">
                           		<section>
                                    <label for="firstname" class="lbl-text">'.esc_html__('Nombres','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<input type="text" name="firstname" class="input" value="'.$usermetaarr['first_name'][0].'" />
                                    </label>
                                </section>
                            </div>
                            <div class="jj_dash2_cel50">  
                                <section>
                                    <label for="lastname" class="lbl-text">'.esc_html__('Apellidos','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<input type="text" name="lastname" class="input" value="'.$usermetaarr['last_name'][0].'" />
                                    </label>
                                </section> 
                            </div>
                            <div class="jj_dash_cel50">
                            <!--<div class="col6 first">-->
                               	<section>
                                    <label for="nickname" class="lbl-text"><strong>'.esc_html__('Apodo (Nombre a mostrar)','pointfindert2d').'(*)</strong>:</label>
                                    <label class="lbl-ui">
                                    	<input  type="text" name="nickname" class="input" value="'.$usermetaarr['nickname'][0].'" />
                                    </label>
                                </section>  

                                <section>
                                    <label for="phone" class="lbl-text">'.esc_html__('Teléfono','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<input type="tel" name="phone" maxlength="12" class="input" placeholder="" value="'.$usermetaarr['user_phone'][0].'" />
                                    </label>                            
                                </section> 
                                <section>
                                    <label for="mobile" class="lbl-text">'.esc_html__('Móvil','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<input type="tel" name="mobile" maxlength="12" class="input" placeholder="" value="'.$usermetaarr['user_mobile'][0].'"/>
                                    </label>                            
                                </section> 

                           </div>

                           <div class="jj_dash2_cel50">
                           <!--<div class="col6 last">-->
                           		<section>
                                    <label for="referred" class="lbl-text">'.esc_html__('¿Como nos conoció?','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<select name="referred" class="input">
                                            <option value="">Por favor seleccione</option>
                                            '.$ref_str.'
                                        </select>
                                    </label>
                                </section>  
                                          
                               	<section>
                                    <label for="descr" class="lbl-text">'.esc_html__('Información biográfica','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<textarea name="descr" class="textarea mini" style="border:1px solid #848484; height: 112px;">'.$usermetaarr['description'][0].'</textarea>
                                    </label>                          
                               	</section> 
                           	</div>
                           	
                           	
                           	<div class="jj_dash_cel50">
                           		<section>
                                    <label for="username" class="lbl-text"><strong>'.esc_html__('Usuario','pointfindert2d').'</strong>:</label>
                                    <label class="lbl-ui">
                                    	<input type="text" id="username" class="input" value="'.$current_user->user_login.'" disabled />
                                    </label>
                               </section>
                            </div>
                            <div class="jj_dash2_cel50">
                               <section>
                                    <label for="email" class="lbl-text"><strong>'.esc_html__('Email Address','pointfindert2d').'</strong>:</label>
                                    <label class="lbl-ui">
                                    	<input  type="email" id="email" class="input" value="'.$current_user->user_email.'" disabled />
                                    </label>
                                </section> 
                           	</div>
                           	<div class="jj_dash_cel50">
	                           	<section>
                                    <label for="password" class="lbl-text">'.esc_html__('Nueva contraseña','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<input type="password"
										placeholder="Contraseña" 
										autocomplete="off" name="password" id="password" class="input" />
                                    </label>                          
                               	</section> 

                           	</div>
                           	<div class="jj_dash2_cel50">
                           		<section>
                                    <label for="password2" class="lbl-text">'.esc_html__('Repita la nueva contraseña','pointfindert2d').':</label>
                                    <label class="lbl-ui">
                                    	<input type="password" placeholder="Repita la Contraseña" autocomplete="off" name="password2" class="input" />
                                    </label>                          
                               	</section> 

                           	</div>

                          	<script>
						      	function vista_previa(evt) {
							      	var files = evt.target.files;
							      	for (var i = 0, f; f = files[i]; i++) {  
							           	if (!f.type.match("image.*")) {
							                continue;
							           	}
							           	var reader = new FileReader();
							           	reader.onload = (function(theFile) {
							               return function(e) {
			                        			jQuery(".img_portada_fondo").css("background-image", "url("+e.target.result+")");
			                        			jQuery(".img_portada_normal").css("background-image", "url("+e.target.result+")");
							               };
							           })(f);
							           reader.readAsDataURL(f);
							       	}
								}      
						      	document.getElementById("portada").addEventListener("change", vista_previa, false);
					      	</script> 
			            ';

					break;

					case 'mybookings':
						include("./wp-content/themes/pointfinder/vlz/admin/page_bookings.php");
					break;

					case 'favorites':
						$formaction = 'pf_refinefavlist';
						$noncefield = wp_create_nonce($formaction);
						$buttonid = 'pf-ajax-itemrefine-button';

							$user_favorites_arr = get_user_meta( $params['current_user'], 'user_favorites', true );

                            if (!empty($user_favorites_arr)) {
								$user_favorites_arr = json_decode($user_favorites_arr,true);
							}else{
								$user_favorites_arr = array();
							}


							$output_arr = '';
							$countarr = count($user_favorites_arr);
							
							if($countarr>0){
								// Contenedor de los favoritos del usuario
								$this->FieldOutput .= '<div class="pfmu-itemlisting-container">';
									
									if ($params['fields']!= '') {
										$fieldvars = $params['fields'];
									}else{
										$fieldvars = '';
									}

									$selected_lfs = $selected_lfl = $selected_lfo2 = $selected_lfo = '';

									$paged = ( esc_sql(get_query_var('paged')) ) ? esc_sql(get_query_var('paged')) : '';
									if (empty($paged)) {
										$paged = ( esc_sql(get_query_var('page')) ) ? esc_sql(get_query_var('page')) : 1;
									}

									$setup3_pointposttype_pt1 = 'petsitters';
									$setup3_pointposttype_pt7 = PFSAIssetControl('setup3_pointposttype_pt7','','Listing Types');

									if (PFControlEmptyArr($fieldvars)) {

				                        if(isset($fieldvars['listing-filter-ltype'])){
				                       		if ($fieldvars['listing-filter-ltype'] != '') {
				                       			$selected_lfl = $fieldvars['listing-filter-ltype'];
				                       		}
				                        }

			                            if(isset($fieldvars['listing-filter-orderby'])){
			                           		if ($fieldvars['listing-filter-orderby'] != '') {
			                           			$selected_lfo = $fieldvars['listing-filter-orderby'];
			                           		}
			                            }

			                            if(isset($fieldvars['listing-filter-order'])){
			                           		if ($fieldvars['listing-filter-order'] != '') {
			                           			$selected_lfo2 = $fieldvars['listing-filter-order'];
			                           		}
			                            }

									}

									$user_id = $params['current_user'];

									$output_args = array(
											'post_type'	=> $setup3_pointposttype_pt1,
											'posts_per_page' => 10,
											'paged' => $paged,
											'order'	=> 'ASC',
											'orderby' => 'Title',
											'post__in' => $user_favorites_arr
									);

									if($selected_lfs != ''){$output_args['post_status'] = $selected_lfs;}
									if($selected_lfo != ''){$output_args['orderby'] = $selected_lfo;}
									if($selected_lfo2 != ''){$output_args['order'] = $selected_lfo2;}
									if($selected_lfl != ''){
										$output_args['tax_query']=
											array(
												'relation' => 'AND',
												array(
													'taxonomy' => 'pointfinderltypes',
													'field' => 'id',
													'terms' => $selected_lfl,
													'operator' => 'IN'
												)
											);
									}

									if($params['post_id'] != ''){
										$output_args['p'] = $params['post_id'];
									}

									$output_loop = new WP_Query( $output_args );
									
									if ( $output_loop->have_posts() ) {
										
										$this->FieldOutput .= '<section>';
										$this->FieldOutput .= '<div class="pfhtitle pf-row clearfix hidden-xs" style="border-top-width: 0px !important;">';

										$setup3_pointposttype_pt4 = PFSAIssetControl('setup3_pointposttype_pt4s','','Item Type');
										$setup3_pointposttype_pt4_check = PFSAIssetControl('setup3_pointposttype_pt4_check','','1');
										$setup3_pointposttype_pt5 = PFSAIssetControl('setup3_pointposttype_pt5s','','Location');
										$setup3_pointposttype_pt5_check = PFSAIssetControl('setup3_pointposttype_pt5_check','','1');
										$setup3_pointposttype_pt7s = PFSAIssetControl('setup3_pointposttype_pt7s','','Listing Type');
										
										$this->FieldOutput .= '</div>';

										while ( $output_loop->have_posts() ) {
											$output_loop->the_post(); 

											$author_post_id = get_the_ID();
												
												$this->FieldOutput .= '<div class="pfmu-itemlisting-inner pf-row clearfix">';
														
														$permalink_item = get_permalink($author_post_id);
														$name_photo = get_user_meta($xuser_id, "name_photo", true);
														$idUser = $xuser_id - 5000;
													    if( $name_photo == "" ){ $name_photo = "0"; }
														if( file_exists("./wp-content/uploads/avatares/".$idUser."/{$name_photo}") ){
															$user_photo_field_output = get_home_url()."/wp-content/uploads/avatares/".$idUser."/{$name_photo}";
														}elseif( file_exists("./wp-content/uploads/avatares/".$idUser."/{$name_photo}.jpg") ){
															$user_photo_field_output = get_home_url()."/wp-content/uploads/avatares/".$idUser."/{$name_photo}.jpg";
														}else{
															$user_photo_field_output = get_template_directory_uri().'/images/noimg.png';
														}


														/*Item Photo Area*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-photo col-lg-1 col-md-1 col-sm-2 hidden-xs">';

															global $wpdb;
															$cuidador = $wpdb->get_row("SELECT * FROM cuidadores WHERE id_post = ".$author_post_id);

															$name_photo = get_user_meta($author_post_id, "name_photo", true);
															$cuidador_id = $cuidador->id;

															if( empty($name_photo)  ){ $name_photo = "0"; }
															if( file_exists("wp-content/uploads/cuidadores/avatares/".$cuidador_id."/{$name_photo}") ){
																$foto = get_home_url()."/wp-content/uploads/cuidadores/avatares/".$cuidador_id."/{$name_photo}";
															}elseif( file_exists("wp-content/uploads/cuidadores/avatares/".$cuidador_id."/0.jpg") ){
																$foto = get_home_url()."/wp-content/uploads/cuidadores/avatares/".$cuidador_id."/0.jpg";
															}else{
																$foto = get_template_directory_uri().'/images/noimg.png';
															}

															$this->FieldOutput .= '<a href="' . $foto . '" title="' . the_title_attribute('echo=0') . '" rel="prettyPhoto">';
														   $this->FieldOutput .= '<img src="'.aq_resize($foto,60,60,true).'" alt="" />';
														   $this->FieldOutput .= '</a>';

														$this->FieldOutput .= '</div>';



														/* Item Title */
														$this->FieldOutput .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 pfmu-itemlisting-title-wd">';
														$this->FieldOutput .= '<div class="pfmu-itemlisting-title">';
														$this->FieldOutput .= '<a href="'.$permalink_item.'">'.get_the_title().'</a>';
														$this->FieldOutput .= '</div>';


														/*Other Infos*/
														$output_data = PFIF_DetailText_ld($author_post_id);
														$rl_pfind = '/pflistingitem-subelement pf-price/';
														$rl_pfind2 = '/pflistingitem-subelement pf-onlyitem/';
					                                    $rl_preplace = 'pf-fav-listing-price';
					                                    $rl_preplace2 = 'pf-fav-listing-item';
					                                    $mcontent = preg_replace( $rl_pfind, $rl_preplace, $output_data);
					                                    $mcontent = preg_replace( $rl_pfind2, $rl_preplace2, $mcontent );

					                                    if (isset($mcontent['content'])) {
					                                    	$this->FieldOutput .= '<div class="pfmu-itemlisting-info pffirst">';
						                                    $this->FieldOutput .= $mcontent['content'];
															$this->FieldOutput .= '</div>';
					                                    }

					                                    if (isset($mcontent['priceval'])) {
					                                    	$this->FieldOutput .= '<div class="pfmu-itemlisting-info pffirst">';
						                                    $this->FieldOutput .= $mcontent['priceval'];
															$this->FieldOutput .= '</div>';
					                                    }

					                                    $this->FieldOutput .= '</div>';
														

														
														
														/*Type of item*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-info pfflast col-lg-2 col-md-2 col-sm-2 hidden-xs">';
															$this->FieldOutput .= '<ul class="pfiteminfolist" style="padding-left:10px">';														
																$this->FieldOutput .= '<li>'.GetPFTermName($author_post_id, 'pointfinderltypes').'</li>';
															$this->FieldOutput .= '</ul>';
														$this->FieldOutput .= '</div>';

														/*Location*/
														$this->FieldOutput .= '<div class="pfmu-itemlisting-info pfflast col-lg-3 col-md-3 col-sm-2 hidden-xs">';
															$this->FieldOutput .= '<ul class="pfiteminfolist" style="padding-left:10px">';
																if($setup3_pointposttype_pt5_check == 1){
																	$this->FieldOutput .= '<li>'.GetPFTermName($author_post_id, 'pointfinderlocations').'</li>';
																}else{
																	if($setup3_pointposttype_pt4_check == 1){
																		$this->FieldOutput .= '<li>'.GetPFTermName($author_post_id, 'pointfinderitypes').'</li>';
																	}
																}
															$this->FieldOutput .= '</ul>';
														$this->FieldOutput .= '</div>';



														


														/*Item Footer*/
															
														
														$fav_check = 'true';
														$favtitle_text = esc_html__('Remover de favoritos','pointfindert2d');
														
														
														
														$this->FieldOutput .= '<div class="pfmu-itemlisting-footer col-lg-2 col-md-2 col-sm-2 col-xs-12">';
													    $this->FieldOutput .= '<ul class="pfmu-userbuttonlist">';
															$this->FieldOutput .= '<li class="pfmu-userbuttonlist-item"><a class="button pf-delete-item-button wpf-transition-all pf-favorites-link" data-pf-num="'.$author_post_id.'" data-pf-active="'.$fav_check.'" data-pf-item="false" title="'.$favtitle_text.'"><i class="pfadmicon-glyph-644"></i></a></li>';
															$this->FieldOutput .= '<li class="pfmu-userbuttonlist-item"><a class="button pf-view-item-button wpf-transition-all" href="'.$permalink_item.'" target="_blank" title="'.esc_html__('Vista','pointfindert2d').'"><i class="pfadmicon-glyph-410"></i></a></li>';
														$this->FieldOutput .= '</ul>';
														
														$this->FieldOutput .= '</div>';


													$this->FieldOutput .= '</div>';

												
										}

										$this->FieldOutput .= '</section>';
									}else{
										$this->FieldOutput .= '<section>';
										$this->FieldOutput .= '<div class="notification warning" id="pfuaprofileform-notify-warning"><p>';
										if (PFControlEmptyArr($fieldvars)) {
											$this->FieldOutput .= '<strong>'.esc_html__('No se encontró el registro!','pointfindert2d').'</strong><br>'.esc_html__('Por favor, revise sus criterios de búsqueda y tratar de comprobar de nuevo. O puede presionar el botón <strong>Reiniciar</ strong> para ver todas.','pointfindert2d').'</p></div>';
										}else{
											$this->FieldOutput .= '<strong>'.esc_html__('No se encontró el registro!','pointfindert2d').'</strong></p></div>';
										}
										$this->FieldOutput .= '</section>';
									}
									$this->FieldOutput .= '<div class="pfstatic_paginate" >';
									$big = 999999999;
									$this->FieldOutput .= paginate_links(array(
										//'base' => @add_query_arg('page','%#%'),
										//'format' => '?page=%#%',
										'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
										'format' => '?paged=%#%',
										'current' => max(1, $paged),
										'total' => $output_loop->max_num_pages,
										'type' => 'list',
									));
									$this->FieldOutput .= '</div>';
									

								$this->FieldOutput .= '</div>';
							}else{
								$this->FieldOutput .= '<section>';
								$this->FieldOutput .= '<div class="notification warning" id="pfuaprofileform-notify-warning"><p>'.esc_html__('No se encontró el registro!','pointfindert2d').'</p></div>';
								$this->FieldOutput .= '</section>';
							}
				
					break;

					case 'invoices':
						$formaction = 'pf_refineinvlist';
						$noncefield = wp_create_nonce($formaction);
						$buttonid = 'pf-ajax-invrefine-button';
					break;

				}

				$this->FieldOutput .= '</div>';/*row*/
				$this->FieldOutput .= '</div>';/*form-section*/
				$this->FieldOutput .= '</div>';/*form-enclose*/

				if($params['formtype'] != 'myitems' && $params['formtype'] != 'myissues' && $params['formtype'] != 'mybookings' && $params['formtype'] != 'favorites' && $params['formtype'] != 'reviews'){$xtext = '';}else{$xtext = 'style="background:transparent;background-color:transparent;display:none!important"';}
				
				$this->FieldOutput .= '<div class="pfalign-right" '.$xtext.'>';
				if($params['formtype'] != 'errorview' && $params['formtype'] != 'banktransfer'){
					if($params['formtype'] != 'myitems' && $params['formtype'] != 'favorites' && $params['formtype'] != 'reviews' && $params['formtype'] != 'invoices' && $params['dontshowpage'] != 1 && $main_package_expire_problem != true){
			            
	                	$this->FieldOutput .='    
		                <section '.$xtext.'> ';
		                if($params['formtype'] == 'upload'){
			                $setup31_userpayments_recurringoption = PFSAIssetControl('setup31_userpayments_recurringoption','','1');
			         
		                }elseif ($params['formtype'] == 'edititem') {
		                	
		                	$this->FieldOutput .='
			                   <input type="hidden" name="edit_pid" value="'.$params['post_id'].'">';
		                }
		                if ($main_package_purchase_permission == true || $main_package_upgrade_permission == true) {
		                	$this->FieldOutput .='<input type="hidden" name="selectedpackageid" value="">';
		                }elseif ($main_package_renew_permission == true && !empty($membership_user_package_id)) {
		                	$this->FieldOutput .='<input type="hidden" name="selectedpackageid" value="'.$membership_user_package_id.'">';
		                }
		                if ($main_package_renew_permission == true) {
		                	$this->FieldOutput .='<input type="hidden" name="subaction" value="r">';
		                }elseif ($main_package_purchase_permission == true) {
		                	$this->FieldOutput .='<input type="hidden" name="subaction" value="n">';
		                }elseif ($main_package_upgrade_permission == true) {
		                	$this->FieldOutput .='<input type="hidden" name="subaction" value="u">';
		                }

		                $this->FieldOutput .= '
		                   <input type="hidden" value="'.$formaction.'" name="action" />
		                   <input type="hidden" value="'.$noncefield.'" name="security" />
		                   ';
		                if (!$hide_button) {
		                	$this->FieldOutput .= '
			                   <input type="submit" value="'.$buttontext.'" id="'.$buttonid.'" class="button blue pfmyitempagebuttonsex" data-edit="'.$params['post_id'].'"  />
		                   ';
		                }

		                $this->FieldOutput .= '</section>';
 
		         	}else{
		       			$this->FieldOutput .='    
			                <section  '.$xtext.'> 
			                   <input type="hidden" value="'.$formaction.'" name="action" />
			                   <input type="hidden" value="'.$noncefield.'" name="security" />
			                </section>  
			            ';
		       		}
		       	}
	        
	            $this->FieldOutput.='</div>';
				$this->FieldOutput .= '</form>';
				$this->FieldOutput .= '</div>';
		}

		/**
		*Start: Class Functions
		**/
			public function PFGetList($params = array())
			{
			    $defaults = array( 
			        'listname' => '',
			        'listtype' => '',
			        'listtitle' => '',
			        'listsubtype' => '',
			        'listdefault' => '',
			        'listgroup' => 0,
			        'listgroup_ex' => 1,
			        'listmultiple' => 0,
			        'parentonly' => 0
			    );
				
			    $params = array_merge($defaults, $params);
			    	
			    	$output_options = '';
			    	if($params['listmultiple'] == 1){ $multiplevar = ' multiple';$multipletag = '[]';}else{$multiplevar = '';$multipletag = '';};

			    	if ($params['parentonly'] == 1) {
			    		$fieldvalues = get_terms($params['listsubtype'],array('hide_empty'=>false,'parent'=>0));
			    	}else{
			    		$fieldvalues = get_terms($params['listsubtype'],array('hide_empty'=>false));
			    	}
					 

					
					if($params['listgroup'] == 1){
						foreach( $fieldvalues as $parentfieldvalue){
							if($parentfieldvalue->parent == 0){
								$output_options .=  '<optgroup label="'.$parentfieldvalue->name.'">';
								
									if ($params['listgroup_ex'] == 1) {
								
										if(is_array($params['listdefault'])){
											if(in_array($parentfieldvalue->term_id, $params['listdefault'])){ $fieldtaxSelectedValuex = 1;}else{ $fieldtaxSelectedValuex = 0;}
										}else{
											if(strcmp($params['listdefault'],$parentfieldvalue->term_id) == 0){ $fieldtaxSelectedValuex = 1;}else{ $fieldtaxSelectedValuex = 0;}
										}
										if($fieldtaxSelectedValuex == 1){
											$output_options .= '<option value="'.$parentfieldvalue->term_id.'" selected>'.$parentfieldvalue->name.' ('.esc_html__('Todos','pointfindert2d').')</option>';
										}else{
											$output_options .= '<option value="'.$parentfieldvalue->term_id.'">'.$parentfieldvalue->name.' ('.esc_html__('Todos','pointfindert2d').')</option>';
										}
									}
									foreach( $fieldvalues as $fieldvalue){
										if($fieldvalue->parent == $parentfieldvalue->term_id){
											if($params['listdefault'] != ''){
												if(is_array($params['listdefault'])){
													if(in_array($fieldvalue->term_id, $params['listdefault'])){ $fieldtaxSelectedValue = 1;}else{ $fieldtaxSelectedValue = 0;}
												}else{
													if(strcmp($params['listdefault'],$fieldvalue->term_id) == 0){ $fieldtaxSelectedValue = 1;}else{ $fieldtaxSelectedValue = 0;}
												}
											}else{
												$fieldtaxSelectedValue = 0;
											}
											
											if($fieldtaxSelectedValue == 1){
												$output_options .= '	<option value="'.$fieldvalue->term_id.'" selected>'.$fieldvalue->name.'</option>';
											}else{
												$output_options .= '	<option value="'.$fieldvalue->term_id.'">'.$fieldvalue->name.'</option>';
											}
										}
									}
									
								$output_options .= '</optgroup>';
							
							}
						}
					}else{
						foreach( $fieldvalues as $fieldvalue){
							if($fieldvalue->parent != 0){$hasparentitem = ' ';}else{$hasparentitem = '';}
							if($params['listdefault'] != ''){
								if(is_array($params['listdefault'])){
									if(in_array($fieldvalue->term_id, $params['listdefault'])){ $fieldtaxSelectedValue = 1;}else{ $fieldtaxSelectedValue = 0;}
								}else{
									if(strcmp($params['listdefault'],$fieldvalue->term_id) == 0){ $fieldtaxSelectedValue = 1;}else{ $fieldtaxSelectedValue = 0;}
								}
							}else{
								$fieldtaxSelectedValue = 0;
							}
							
							if($fieldtaxSelectedValue == 1){
								$output_options .= '	<option value="'.$fieldvalue->term_id.'" selected>'.$hasparentitem.$fieldvalue->name.'</option>';
							}else{
								$output_options .= '	<option value="'.$fieldvalue->term_id.'">'.$hasparentitem.$fieldvalue->name.'</option>';
							}
									
						}
					}
					


			    	$output = '';
					$output .= '<div class="pf_fr_inner" data-pf-parent="">';
		   			
			   		switch ($params['listtype']) {
			   			/**
			   			*Listing Types,Item Types,Locations,Features
			   			**/
			   			case 'listingtypes':
			   			case 'itemtypes':
			   			case 'locations':
			   			case 'features':
			   			case 'conditions':
			   				if (!empty($params['listtitle'])) {
				   				$output .= '<label for="'.$params['listname'].'" class="lbl-text">'.$params['listtitle'].':</label>';
			   				}

			   				$as_mobile_dropdowns = PFASSIssetControl('as_mobile_dropdowns','','0');

							if ($as_mobile_dropdowns == 1) {
								$as_mobile_dropdowns_text = 'class="pf-special-selectbox"';
							} else {
								$as_mobile_dropdowns_text = '';
							}
							
			   				$output .= '
			                <label class="lbl-ui select">
			                <select'.$multiplevar.' name="'.$params['listname'].$multipletag.'" id="'.$params['listname'].'" '.$as_mobile_dropdowns_text.'>';
			                $output .= '<option></option>';
			                $output .= $output_options.'
			                </select>
			                </label>';
			   			break;
			   		}

			   		$output .= '</div>';

	            return $output;
			}

			private function PFValidationCheckWrite($field_validation_check,$field_validation_text,$itemid){
				
				$itemname = (string)trim($itemid);
				$itemname = (strpos($itemname, '[]') == false) ? $itemname : "'".$itemname."'" ;

				if($field_validation_check == 1){
					if($this->VSOMessages != ''){
						$this->VSOMessages .= ','.$itemname.':"'.$field_validation_text.'"';
					}else{
						$this->VSOMessages = $itemname.':"'.$field_validation_text.'"';
					}

					if($this->VSORules != ''){
						$this->VSORules .= ','.$itemname.':"required"';
					}else{
						$this->VSORules = $itemname.':"required"';
					}
				}
			}

			private function PF_UserLimit_Check($action,$post_status){
	
				switch ($post_status) {
					case 'publish':
							switch ($action) {
								case 'edit':
									$output = (PFSAIssetControl('setup31_userlimits_useredit','','1') == 1) ? 1 : 0 ;
									break;
								
								case 'delete':
									$output = (PFSAIssetControl('setup31_userlimits_userdelete','','1') == 1) ? 1 : 0 ;
									break;
							}

						break;
					
					case 'pendingpayment':
							switch ($action) {
								case 'edit':
									$output = (PFSAIssetControl('setup31_userlimits_useredit_pendingpayment','','1') == 1) ? 1 : 0 ;
									break;
								
								case 'delete':
									$output = (PFSAIssetControl('setup31_userlimits_userdelete_pendingpayment','','1') == 1) ? 1 : 0 ;
									break;
							}

						break;

					case 'rejected':
							switch ($action) {
								case 'edit':
									$output = (PFSAIssetControl('setup31_userlimits_useredit_rejected','','1') == 1) ? 1 : 0 ;
									break;
								
								case 'delete':
									$output = (PFSAIssetControl('setup31_userlimits_userdelete_rejected','','1') == 1) ? 1 : 0 ;
									break;
							}

						break;

					case 'pendingapproval':
							switch ($action) {
								case 'edit':
									$output = 0 ;
									break;
								
								case 'delete':
									$output = (PFSAIssetControl('setup31_userlimits_userdelete_pendingapproval','','1') == 1) ? 1 : 0 ;
									break;
							}

						break;
				}

				return $output;
			}
	    /**
		*End: Class Functions
		**/


	   function __destruct() {
		  $this->FieldOutput = '';
		  $this->ScriptOutput = '';
	    }
	}
}

?>