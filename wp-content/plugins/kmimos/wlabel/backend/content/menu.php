<?php
    //var_dump($_kmimos_wlabel_user->wlabel_result);
    $title=$_wlabel_user->wlabel_result->title;
    $image=$_wlabel_user->wlabel_data->image;
    $color=$_wlabel_user->wlabel_data->color;
?>
<div class="menu" style="background-color:<?php echo $color; ?>;">
    <?php
        if($image!=''){
            echo '<img class="image" src="'.$image.'" alt='.$title.';>';
        }

    ?>
    <div class="item">111</div>
    <div class="item">222</div>
    <div class="item">333</div>
    <div class="item">444</div>
    <div class="item">555</div>
</div>
