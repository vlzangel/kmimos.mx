<?php
$datos = kmimos_get_info_syte();
$HTML = "
    <a class='subir'><i class='pfadmicon-glyph-859'></i></a>
    <footer>   
        <div class='container'>
            <div>
                <h2>Contáctanos</h2>
                <p>
                    <strong>Email: </strong> ".$datos['email']."<br>
                    <strong>Tlf: </strong> 
                    <div class='footer_telfs'>".$datos['telefono']."</div>
                </p>
            </div>
            <div>
                <h2>Navega</h2>
                <ul>
                    <li><a href='#'>Nosotros</a></li>
                    <li><a href='".get_home_url()."/tips-e-informacion-sobre-perros/'>Blog</a></li>
                    <li><a href='#'>Preguntas y Respuestas</a></li>
                    <li><a href='#'>Cobertura Veterinaria</a></li>
                    <li><a href='#'>Comunicados de prensa</a></li>
                    <li><a href='".get_home_url()."/terminos-y-condiciones/'>Términos y Condiciones</a></li>
                    <li><a href='#'>Nuestros Aliados</a></li>
                    <li><a href='".get_home_url()."/contacto/'>Contáctanos</a></li>
                </ul>
            </div>

            <div>
                <h2>¡B&uacute;scanos en nuestra redes sociales!</h2>
                <div class='socialBtns'>
                    <a href='https://www.facebook.com/".$datos['facebook']."/' target='_blank' class='facebookBtn socialBtn' title='".$datos['facebook']."'></a>
                    <a href='https://twitter.com/".$datos['twitter']."/' target='_blank' class='twitterBtn socialBtn' title='@".$datos['twitter']."'></a>
                    <a href='#' target='_blank' class='instagramBtn socialBtn' title='@".$datos['instagram']."'></a>
                </div>
            </div>
        </div>   

        <div class='sub_footer'>
            <span>
                <script async type='text/javascript'>
                    function verifySeal() {
                        var bgHeight = '460';
                        var bgWidth = '593';
                        var url = 'https://seal.godaddy.com/verifySeal?sealID=c5u9pjdoyKXQ6dRtmwnDmY0bV6KVBrdZGPEAnPkeSt7ZRCetPjIUzVK0bnHa';
                        window.open(url,'SealVerfication','menubar=no,toolbar=no,personalbar=no,location=yes,status=no,resizable=yes,fullscreen=no,scrollbars=no,width=' + bgWidth + ',height=' + bgHeight);
                    }
                </script>
                <img src='https://seal.godaddy.com/images/3/en/siteseal_gd_3_h_l_m.gif' onclick='verifySeal();' />
            </span>  
        </div>
    </footer>";

    if(  $_SESSION['admin_sub_login'] == 'YES' ){
        $HTML .= "
            <a href='".get_home_url()."/?i=".md5($_SESSION['id_admin'])."&admin=YES' class='theme_button' style='
                position: fixed;
                display: inline-block;
                left: 50px;
                bottom: 50px;
                padding: 20px;
                font-size: 48px;
                font-family: Roboto;
                z-index: 999999999999999999;
            '>
                X
            </a>
        ";
    }

    // Modificacion Ángel Veloz
    $DS = kmimos_session();
    if( $DS ){
        if( isset($DS['reserva']) ){
            $HTML .= "
                <a href='".get_home_url()."/wp-content/themes/pointfinder/vlz/admin/process/mybookings_modificar.php?b=".$user_id."' class='theme_button' style='
                    position: fixed;
                    display: inline-block;
                    left: 50px;
                    bottom: 50px;
                    padding: 8px;
                    font-size: 20px;
                    font-family: Roboto;
                    z-index: 999999999999999999;
                    color: #FFF;
                    border: solid 1px #7b7b7b;
                '>
                    Salir de modificar reserva
                </a>
            ";
        }
    }

    /*
    if( is_front_page() ){
        $HTML .= "
            <script>      
            mixpanel.identify();
            var distinct_ID = mixpanel.get_distinct_id();
            document.getElementById('pf-search-button-manual').addEventListener('click', ClickBuscar);
            function ClickBuscar() {
                p=document.getElementsByClassName('boton_portada boton_servicio activo');
                for (i = 0; i< p.length; i++) {
                    var tt = p[i].getElementsByTagName('input');
                    var id = '#' + jQuery (tt).attr('id');
                    if( jQuery (id).prop('checked')){
                        var nombre = jQuery (tt).attr('value')
                        mixpanel.people.set({ nombre: 'si' });
                    }
                }
                var estadoss = document.getElementById('estado_cuidador');
                var municipioss = document.getElementById('municipio_cache');
                mixpanel.people.set({ 'estadoBuscado' : estadoss });
                mixpanel.people.set({ 'municipioBuscado' : municipioss });
                var FechadeBusqueda = new Date();
                mixpanel.people.set({ 'UltimaFechaDeBusqueda' : FechadeBusqueda });
            }
        </script>";
    }

    if(isset($_GET['ua'])){
        if($_GET['ua'] == 'profile'){
            $HTML .= "
            <script>
                mixpanel.identify();
                var distinct_ID = mixpanel.get_distinct_id();
                sidebarList= document.getElementsByTagName('ul')[7];
                verificarCuidador= sidebarList.getElementsByTagName('li')[5];
                if (verificarCuidador.innerText == 'CUIDADOR') {
                    mixpanel.people.set({ 'TipoDeUsuario': 'Cuidador' });
                } else {
                    mixpanel.people.set({ 'TipoDeUsuario': 'Cliente' });
                }
                perfil=document.getElementsByClassName('input');
                for (i = 0; i<perfil.length; i++){
                    if (i == 7){
                        var perfilvalue = perfil[i].value
                        mixpanel.people.set({ $email: perfilvalue });
                    }else{
                        var perfilname = perfil[i].name
                        var perfilvalue = perfil[i].value
                        mixpanel.people.set({ perfilname: perfilvalue });
                    }
                }
                document.getElementById('pf-ajax-profileupdate-button').addEventListener('click', ActualizarPerfil);
                function ActualizarPerfil() {
                    perfil=document.getElementsByClassName('input');
                    for (i = 0; i<perfil.length; i++){
                        if (i == 7){
                            var perfilvalue = perfil[i].value
                            mixpanel.people.set({ $email: perfilvalue });
                        } else {
                            var perfilname = perfil[i].name
                            var perfilvalue = perfil[i].value
                            mixpanel.people.set({ perfilname: perfilvalue });
                        }
                    }
                }   
            </script>";
        }
    } 
    */

    echo comprimir_styles($HTML);
 
    wp_footer();

    $HTML = "
        <!--
        <script type='text/javascript'>(function(e,a){if(!a.__SV){var b=window;try{var c,l,i,j=b.location,g=j.hash;c=function(a,b){return(l=a.match(RegExp(b+'=([^&]*)')))?l[1]:null};g&&c(g,'state')&&(i=JSON.parse(decodeURIComponent(c(g,'state'))),'mpeditor'===i.action&&(b.sessionStorage.setItem('_mpcehash',g),history.replaceState(i.desiredHash||'',e.title,j.pathname+j.search)))}catch(m){}var k,h;window.mixpanel=a;a._i=[];a.init=function(b,c,f){function e(b,a){var c=a.split('.');2==c.length&&(b=b[c[0]],a=c[1]);b[a]=function(){b.push([a].concat(Array.prototype.slice.call(arguments,
            0)))}}var d=a;'undefined'!==typeof f?d=a[f]=[]:f='mixpanel';d.people=d.people||[];d.toString=function(b){var a='mixpanel';'mixpanel'!==f&&(a+='.'+f);b||(a+=' (stub)');return a};d.people.toString=function(){return d.toString(1)+'.people (stub)'};k='disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user'.split(' ');
            for(h=0;h<k.length;h++)e(d,k[h]);a._i.push([b,c,f])};a.__SV=1.2;b=e.createElement('script');b.type='text/javascript';b.async=!0;b.src='undefined'!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:'file:'===e.location.protocol&&'//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js'.match(/^\/\//) ? '".get_home_url()."/wp-content/plugins/kmimos/javascript/mixpanel-2-latest.min.js':'".get_home_url()."/wp-content/plugins/kmimos/javascript/mixpanel-2-latest.min.js';c=e.getElementsByTagName('script')[0];c.parentNode.insertBefore(b,c)}})(document,window.mixpanel||[]);
            mixpanel.init('972817bb3a7c91a4b95c1641495dfeb7');
        </script>
        -->
        
        <!--[if lt IE 9]>
            <script src='".get_home_url()."/wp-content/themes/pointfinder/js/html5shiv.js'></script>
        <![endif]-->
        <script type='text/javascript'>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','".get_home_url().'/wp-content/plugins/kmimos/javascript/analytics.js'."','ga');

            ga('create', 'UA-56422840-1', 'auto');
            ga('send', 'pageview');
        </script>
    ";

    echo comprimir_styles($HTML);

    echo "</body></html>";
?>
        
