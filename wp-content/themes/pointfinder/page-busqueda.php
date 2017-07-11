<?php 
    /*
        Template Name: Busqueda
    */

    wp_enqueue_style('beneficios_kmimos', $home."/wp-content/themes/pointfinder/css/busqueda.css", array(), '1.0.0');
	wp_enqueue_style('beneficios_responsive', $home."/wp-content/themes/pointfinder/css/responsive/busqueda_responsive.css", array(), '1.0.0');

	wp_enqueue_script('buscar_home', $home."/wp-content/themes/pointfinder/js/busqueda.js", array("jquery"), '1.0.0');

    get_header();

    if( !isset($_SESSION)){ session_start(); }

	if( isset($_SESSION['busqueda'])){ $_POST = unserialize($_SESSION['busqueda']); }

	$pagina = vlz_get_page();
	$total  = vlz_num_resultados();
	$paginacion = vlz_get_paginacion($total, $pagina);
	$resultados = $_SESSION['resultado_busqueda'];
	$favoritos = get_favoritos();
	
	$pines = unserialize($_SESSION['pines_array']);
	$pines_visibles = array();

	$CUIDADORES = "";
	if( $total > 0 ){
		for ($i=$paginacion["inicio"]; $i < $paginacion["fin"]; $i++) {
			$cuidador = $resultados[$i];
			$pines_visibles[] = $pines[$i];
			$CUIDADORES .= get_ficha_cuidador($cuidador, $i, $favoritos);
		}
	}else{
		$CUIDADORES .= "<h2 style='padding-right: 20px!important;'>No tenemos resultados para esta búsqueda, si quieres intentarlo de nuevo pícale <a  style='color: #00b69d; font-weight: 600;' href='".$home."/#jj-landing-page'>aquí,</a> o aplica otro filtro de búsqueda.</h2>";
	}

	$PINES = json_encode($pines_visibles);

	$busqueda = unserialize($_SESSION['busqueda']);
	$CAMPOS = json_encode($busqueda);

    $HTML = "
    	<div id='mapa'></div>
    	<script>var pines = eval('".$PINES."'); var CAMPOS = eval('[".$CAMPOS."]');</script>
    	<div class='container listado'>
    		<div class='columna_listado'>
		    	<ul id='listado'>
		    		<div class='total_resultados'>Listado: {$total} cuidador(es)</div>
		    		".$CUIDADORES."
		    	</ul>
		    	<div class='vlz_nav_cont'>
					<div class='vlz_nav_cont_interno'>".$paginacion["html"]."</div>
				</div>
			</div>
			<div class='columna_formulario'>
				<div class='total_resultados'>Filtrar Cuidadores</div>
				".get_formulario($_POST)."
			</div>
		</div>
    ";

	echo comprimir_styles($HTML);

    get_footer(); 
?>