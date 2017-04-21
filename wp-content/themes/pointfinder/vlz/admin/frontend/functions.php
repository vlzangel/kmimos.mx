<style type="text/css">

    .theme_tite.table_title{
        margin: 20px 0 0 0;
        padding: 10px;
    }

    .theme_btn{
        font-weight: 600;
        background: #54c8a7;
        padding: 3px 5px;
        border-radius: 2px;
        color: #FFF !important;
        float: left;
        width: 100%;
        text-align: center;
        margin-bottom: 3px!important;
    }
    .theme_btn.cancelled{
        background: #e80000;
    }

</style>

<?php

if(!function_exists('date_boooking')){
    function date_boooking($date=''){
        $date=strtotime($date);
        $date=date('d/m/Y',$date);
        //$date=substr($date, 6, 2)."/".substr($date, 4, 2)."/".substr($date, 0, 4);
        return $date;
    }
}

if(!function_exists('build_table')){
    function build_table($args=array()){
        $table='';
        foreach($args as $data){
            if(count($data['tr'])>0){
                $table.='<h1 class="vlz_h1 jj_h1 theme_tite table_title">'.$data['title'].'</h1>';
                $table.='<table class="vlz_tabla jj_tabla table table-striped table-responsive">';
                $table.='<tr>';
                foreach($data['th'] as $th){
                    $table.='<th class="'.$th['class'].'">'.$th['data'].'</th>';
                }
                $table.='</tr>';


                foreach($data['tr'] as $tr){
                    $table.='<tr>';
                    foreach($tr as $td){
                        $table.='<td class="'.$td['class'].'">'.$td['data'].'</th>';
                    }
                    $table.='</tr>';
                }

                $table.='</table>';
            }
        }
        return $table;
    }
}
?>