<?php

$WP_path_load =dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-load.php';
if(file_exists($WP_path_load)){
    include_once($WP_path_load);
}

//CLASS
include_once(dirname(__FILE__).'/includes/class/class_subscribe.php');
$_subscribe = new Class_Subscribe();


//SCRIPT
add_action('wp_enqueue_scripts', 'subscribe_enqueue_scripts');
function subscribe_enqueue_scripts() {
    wp_enqueue_script('subscribe_script', plugin_dir_url(__DIR__).'subscribe/includes/js/script.js');//
}

//DOWNLOAD FILE
function subscribe_download(){
    global $_subscribe;
    include_once(__DIR__.'/panel/panel.php');
    $link=plugin_dir_url(__FILE__).'subscribe/subscribe.csv';
    echo '<div style="padding:30px 0; font-size:25px;">';
    echo '<a href="'.$link.'" target="_blank">Descargar Archivo CSV</a>';
    echo '</div>';

}

/** ADMIN MENU **/
add_action('admin_menu', 'single_subscribe_add_menu');
function single_subscribe_add_menu(){
    if(function_exists('add_menu_page')){
        add_menu_page('subscribe', 'Subscribe', 8, basename(__FILE__), 'subscribe_download', '', 996);
    }
}


function subscribe_input($section='any'){
    global $_subscribe;

    $html='<div class="subscribe" data-subscribe="'.plugin_dir_url(__DIR__).'">';
    $html.='<form onsubmit="form_subscribe(this); return false;">';
    $html.='<input type="hidden" name="section" value="'.$section.'"/>';
    $html.='<input type="mail" name="mail" value="" placeholder="" required/>';
    $html.='<button type="submit"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>';
    $html.='</form>';
    $html.='<div class="message"></div>';
    $html.='</div>';
    return $html;
}
?>