<?php
    include('Requests.php');

    extract($_POST);

    if($usu != ""){

        Requests::register_autoloader();

        $options = array(
            'wstoken'               =>  "61331bc52bfb74f944fd84b8b6458c14",
            'wsfunction'            =>  "kmimos_user_create_users",
            'moodlewsrestformat'    =>  "json",
            'users' => array(
                0 => array(
                    'username'      => $usu,
                    'password'      => "1",
                    'firstname'     => "Nombre ".$usu,
                    "lastname"      => "Apellido ".$usu,
                    "email"         => "prueba_{$usu}@mail.com",
                    "preferences"   => array(
                        0 => array(
                            "type"  => 'kmimostoken',
                            "value" => "Este_es_el_token_identificativo_kmimos2"
                        )
                    ),
                    "cohorts" => array(
                        0 => array(
                            "type"  => 'idnumber',
                            "value" => "kmi-qsc"
                        )
                    )
                )
            )
        );

        $request = Requests::post('http://kmimos.ilernus.com/webservice/rest/server.php', array(), $options );

        if( substr($request->body, 0, 13) == "/user/lib.php"){
            $request->body = substr($request->body, 14);
        }

        $respuesta = json_decode($request->body);
    } ?>

    <form action="?" method="POST">
        <b>Nombre de usuario:</b> <input name="usu" value="<?php echo $usu; ?>" />
        <input type="submit" value="Registrar">
    </form>

<?php

    if($usu != ""){
        echo "<pre>";
            echo "<b>Parametros:</b><br>";
            print_r($options);
            echo "<b>Respuesta:</b><br>";
            if( $request->body != "" ){
                print_r($respuesta);
            }else{
                echo "Usuario creado!";
            }
        echo "</pre>";
    }
?>