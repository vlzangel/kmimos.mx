<?php

$query = "SELECT * FROM destacados ORDER BY rand() LIMIT 4";
$featureds = $wpdb->get_results($query);

foreach ($featureds as $featured){
    $caregiver = $wpdb->get_row("SELECT * FROM cuidadores WHERE id = {$featured->cuidador}");
    $price='$0.00';
    $img = kmimos_get_foto_cuidador($featured->cuidador);
    $url = get_home_url()."/petsitters/".$data->url;


    $img=str_replace('http://kmimos.dev.mx/','https://kmimos.com.mx/',$img);

    echo '<div class="product scroll_animate" data-position="self" data-scale="small">';
    echo '<div class="image easyload" data-original="'.$img.'" style="background-image:url();"></div>';

    echo '<div class="detail">';
    echo '<div class="title">'.$data->nom.'</div>';
    echo '<div class="content price">'.$price.'</div>';
    echo '<div class="button">VER MAS</div>';
    echo '</div>';

    echo '<a class="absolute" href="'.$url.'" title="'.$data->nom.'"></a>';
    echo '</div>';
}
?>