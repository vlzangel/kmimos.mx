<?php

$page = 0;
if(isset($_POST['page'])){
    $page = $_POST['page'];
}

$limit = 1;
$row = $limit*$page;
$table = $_subscribe->table;
$total = $_subscribe->result("SELECT * FROM $table");
$result = $_subscribe->result("SELECT * FROM $table LIMIT $row, $limit");
//var_dump($result);

if(count($total)>count($result)){
    echo '<div class="navigate">';
    echo '<i class="fa fa-angle-left" aria-hidden="true"></i>';
    echo '<i class="fa fa-angle-right" aria-hidden="true"></i>';
    echo '</div>';

}

if(count($result)>0){
    ?>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Email</td>
                <td>Origen</td>
                <td></td>
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
            </tr>
    <?php
    }
    ?>
        </tbody>
    </table>

    <?php


}else{
    '<div>No hay personas regstradas</div>';
}

?>


