<?php
    
    $userdata = get_user_meta($user_id);

    $CONTENIDO .= '
        <form id="form_perfil">
            <input type="hidden" name="tipo_user" value="'.$user->roles[0].'" />
            <input type="hidden" name="user_tipo" value="'.$user_id_tipo.'" />

            <section>
                <div class="vlz_img_portada_perfil">
                    <div class="vlz_img_portada_fondo" style="background-image: url('.$avatar.');"></div>
                    <div class="vlz_img_portada_normal" style="background-image: url('.$avatar.');"></div>
                    <div class="cambiar_portada">
                        Cambiar Foto
                        <input type="file" id="portada" name="portada" accept="image/*" />
                    </div>
                </div>
            </section>

            <div class="box_3">

                <section>
                    <label for="firstname" class="lbl-text">Nombres:</label>
                    <label class="lbl-ui">
                        <input type="text" name="firstname" class="input" value="'.$userdata['first_name'][0].'" />
                    </label>
                </section>

                <section>
                    <label for="lastname" class="lbl-text">Apellidos:</label>
                    <label class="lbl-ui">
                        <input type="text" name="lastname" class="input" value="'.$userdata['last_name'][0].'" />
                    </label>
                </section>

                <section>
                    <label for="nickname" class="lbl-text">Apodo (Nombre a mostrar):</label>
                    <label class="lbl-ui">
                        <input  type="text" name="nickname" class="input" value="'.$userdata['nickname'][0].'" />
                    </label>
                </section>

            </div>

            <div class="box_3">

                <section>
                    <label for="phone" class="lbl-text">'.esc_html__('Teléfono','pointfindert2d').':</label>
                    <label class="lbl-ui">
                        <input type="tel" name="phone" maxlength="12" class="input" placeholder="" value="'.$userdata['user_phone'][0].'" />
                    </label>
                </section>

                <section>
                    <label for="mobile" class="lbl-text">'.esc_html__('Móvil','pointfindert2d').':</label>
                    <label class="lbl-ui">
                        <input type="tel" name="mobile" maxlength="12" class="input" placeholder="" value="'.$userdata['user_mobile'][0].'"/>
                    </label>
                </section>

                <section>
                    <label for="referred" class="lbl-text">'.esc_html__('¿Como nos conoció?','pointfindert2d').':</label>
                    <label class="lbl-ui">
                        <select name="referred" class="input">
                            <option value="">Por favor seleccione</option>
                            '.$ref_str.'
                        </select>
                    </label>
                </section>

            </div>

            <section>
                <label for="descr" class="lbl-text">'.esc_html__('Información biográfica','pointfindert2d').':</label>
                <label class="lbl-ui">
                    <textarea name="descr" class="textarea mini" style="border:1px solid #848484; height: 112px;">'.$userdata['description'][0].'</textarea>
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
    ';
?>


