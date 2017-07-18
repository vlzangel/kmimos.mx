<style type="text/css">
    .subscribe{position:relative; padding:20px;}
    .subscribe .title{padding: 20px 0; font-size: 30px;}
    .subscribe .navigate{padding:20px 0;}
    .subscribe .navigate .icon{padding:20px; font-size: 20px;}

    .subscribe table{}
    .subscribe table tr{}
    .subscribe table td{padding: 10px; border: 1px solid #CCC;}
    .subscribe table thead{background: #CCC;}
</style>
<div class="subscribe">
    <div class="title">
        USUARIOS SUBSCRITOS
    </div>

<?php

$paged = 0;
if(isset($_GET['paged'])){
    $paged = $_GET['paged'];
}

$limit = 1;
$row = $limit*$paged;
$table = $_subscribe->table;
$total = $_subscribe->result("SELECT * FROM $table ORDER BY id DESC");
$result = $_subscribe->result("SELECT * FROM $table ORDER BY id DESC");// LIMIT $row, $limit
//var_dump($result);

/*//Navigate
$paged_link = (isset($_SERVER['HTTPS']) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$paged_total=count($total)/$limit;
$paged_prev=$paged;
if($paged>0){
    $paged_prev=$paged-1;
}

$paged_next=$paged;
if(($paged+1)<$paged_total){
    $paged_next=$paged+1;
}

if(count($total)>count($result)){
    echo '<div class="navigate">';
    echo '<a href="'.$paged_link.'&paged='.$paged_prev.'"><i class="icon fa fa-angle-left" aria-hidden="true"></i></a>';
    echo 'Pagina '.($paged+1).' de '.$paged_total;
    echo '<a href="'.$paged_link.'&paged='.$paged_next.'"><i class="icon fa fa-angle-right" aria-hidden="true"></i></a>';
    echo '</div>';

}
*/
if(count($result)>0){
    ?>
    <table id="tblusers" class="table table-striped table-bordered dt-responsive table-hover table-responsive nowrap datatable-buttons"
           cellspacing="0" width="100%">
        <thead>
            <tr>
                <td>ID</td>
                <td>Email</td>
                <td>Origen</td>
                <td>Fecha</td>
            </tr>
        </thead>
        <tbody>

    <?php
    foreach($result as $row){
    ?>

            <tr>
                <td><?php echo $row->id; ?></td>
                <td><?php echo $row->email; ?></td>
                <td><?php echo $row->source; ?></td>
                <td><?php echo date('d/m/Y',$row->time); ?></td>
            </tr>
    <?php
    }
    ?>
        </tbody>
    </table>

    <?php


}else{
    '<div class="message">No hay personas regstradas</div>';
}

?>
</div>

