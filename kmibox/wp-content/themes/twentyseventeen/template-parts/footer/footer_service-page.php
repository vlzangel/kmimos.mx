<?php

	global $wpdb;
	$result = $wpdb->get_results("
		SELECT 
			p.ID,
			mt.meta_value as size, 
			t.name as category,  
			pa.post_title as product_name, 
			mp.meta_value as plan, 
			pr.meta_value as price,
			p.post_parent as parent
		FROM wp_posts as p 
			inner join wp_postmeta as mp ON mp.post_id = p.ID and mp.meta_key = 'attribute_plan'
			inner join wp_postmeta as mt ON mt.post_id = p.ID and mt.meta_key = 'attribute_tamano'
			inner join wp_postmeta as pr ON pr.post_id = p.ID and pr.meta_key = '_price'
			inner join wp_posts as pa ON pa.ID = p.post_parent

			inner join wp_term_relationships as tr ON tr.object_id = p.post_parent
			inner join wp_term_taxonomy as tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
			inner join wp_terms as t ON t.term_id = tt.term_id
		WHERE 
			p.post_type = 'product_variation'
			AND t.name <> 'variable'
		ORDER BY size, category, product_name, plan DESC
	", ARRAY_A);


	$service = [];
	$posts = [];
	foreach ($result as $row) {

		$row['size'] =  ucfirst($row['size']);
		$row['category'] = strtolower($row['category']);
		$row['product_name'] = strtolower($row['product_name']);
		$row['plan'] = strtolower($row['plan']);

		$post;
		if(array_key_exists($row['parent'], $posts)){
			$post = $posts[$row['parent']];
		}else{
			$post = get_post($row['parent']);
			$posts[$row['parent']] = $post;
		}

		$service[ $row['category'] ][ $row['size'] ][ $row['product_name'] ]['plan'][ $row['plan'] ] = $row;
		$service[ $row['category'] ][ $row['size'] ][ $row['product_name'] ][ 'content' ] = $post;
		$service[ $row['category'] ][ $row['size'] ][ $row['product_name'] ][ 'gallery' ] = $gallery;
	}

	$s = json_encode( $service, JSON_UNESCAPED_UNICODE );
?>
<script type='text/javascript'>

	var json = JSON.stringify(eval( <?php echo $s; ?>)); //convert to json string
	var services = $.parseJSON(json);
	var service = services["<?php echo (isset($_GET['source']))? strtolower($_GET['source']) : 'default' ; ?>"];
	var icons = {
		'Grande' : '/img/grande.png',
		'Pequeño' : '/img/pequeno.png'
	};

	var col = 4;
	var count_items = Object.keys(service).length;
	if( count_items > 0 && count_items < 3 ){
		col = 12 / count_items;
	}

	$(function($){

		// Fase #1 - Tamaño ( Constructor )
		var obj1 = $('[data-fase="1"] article');
		$.each(service, function(key, val){
			var r = obj1.clone();
				r.addClass('col-sm-'+col);
				r.find('h2')
					.text( key );
				r.find('img')
					.attr('src', icons[key])
					.attr('width', '300px')
					.addClass('img-responsive');
				r.find('button')
					.addClass('btn')
					.addClass('btn-sm-kmibox')
					.attr('data-type', key)
					.attr('data-action', 'next');
				r.removeClass('hidden');
			$('[data-fase="1"]').append(r);
		});
		// Action - Fase #2		
		$('[data-action="next"]').on('click', function(){
			console.log( service[ $(this).attr('data-type') ] );
			console.log( $(this).attr('data-type') );
		});

	});

</script>
