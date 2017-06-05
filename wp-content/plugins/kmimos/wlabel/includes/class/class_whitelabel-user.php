<?php

class Class_WhiteLabel_User{

    var $args;

    function __construct($args=array()){
        global $wpdb, $_GET, $_POST, $_SESSION, $_wlabel;
        if (!isset($_SESSION)) {
            session_start();
        }

        $this->args = $args;
        $this->wpdb = $wpdb;

        $this->GET = $_GET;
        $this->POST = $_POST;
        $this->SESSION = $_SESSION;

        $this->user = array();
        if(array_key_exists('user',$this->SESSION)){
            $this->user=$this->SESSION['user'];
        }

        $this->login = false;
        if(array_key_exists('login',$this->SESSION)){
            $this->login=$this->SESSION['login'];
        }

        $this->wlabel_table = $_wlabel->wlabel_table;
        $this->wlabel_table_user = $_wlabel->wlabel_table_user;

        $this->wlabel = '';
        $this->wlabel_result = '';
        $this->wlabel_data=array();
        if(array_key_exists('label',$this->SESSION)){
            $this->wLabel_Result($this->SESSION['label']->title);
        }
    }

    function LogIn(){
        global $_SESSION;
        $table_user =  $this->wlabel_table_user;
        if(array_key_exists('user',$this->POST) && array_key_exists('pass',$this->POST)){
            $user=$this->POST['user'];
            $pass=$this->POST['pass'];

            if($user!='' && $pass!=''){
                $pass=md5($pass);
                $query="SELECT * FROM $table_user WHERE user='$user' AND pass='$pass'";
                $result=$this->wpdb->get_results($query);

                if(count($result)==1){
                    $this->user=$result[0];
                    $this->login = true;
                    $this->wlabel = $this->user->wlabel;
                    $this->wlabel_result=$this->wLabel_Result($this->wlabel);

                    $_SESSION['user']=$this->user;
                    $_SESSION['login']=$this->login;
                    $_SESSION['label']=$this->wlabel_result;
                    $this->SESSION = $_SESSION;

                    return 'Usuario Confirmado<script>location.reload();</script>';
                }else{
                    return 'Usuario o Clave Incorrecto';
                }

            }else{
                return 'Completar formulario';
            }
        }else{
            return 'Error en formulario';
        }
        return 'Empty';
    }

    function LogOut(){
        global $_SESSION;
        if($this->login>0){
            $this->login=0;
            $this->user=array();
            $this->wlabel_result=array();
            $_SESSION['user']=$this->user;
            $_SESSION['login']=$this->login;
            $_SESSION['label']=$this->wlabel_result;
            $this->SESSION = $_SESSION;
            return 'Saliendo...<script>location.reload();</script>';
        }
        return 'No esta Logueado ...<script>location.reload();</script>';
    }

    function LogOut_Html(){
        $html='<div class="logout" data-logout="'.plugin_dir_url(dirname(dirname(__FILE__))).'backend/user/logout.php" onclick="WhiteLabel_panel_logout(this)">';
        $html.='Salir';
        $html.='</div>';
        echo $html;
    }

    function GETuser(){
        return $this->user;
    }

    function wLabel_Result($label=''){
        if($label==''){
            $label =  $this->wlabel;
        }
        if($label!=''){
            $table =  $this->wlabel_table;
            $query="SELECT * FROM $table WHERE wlabel='$label';";
            $result=$this->wpdb->get_results($query);

            if(count($result)>0){
                $this->wlabel=$label;
                $this->wlabel_result=$result[0];

                $data = preg_replace('[\n|\r|\n\r|\r\n]','', $this->wlabel_result->data);
                $this->wlabel_data=json_decode($data);//,true
                return $this->wlabel_result;
            }
        }
        return array();
    }


}