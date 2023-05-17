<?php

/*
 * Template per mostrare i campi con le descrizioni del singolo operatore con
 * possibilità di selezionare il campo specifico tramite gli attributi.
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

$args = shortcode_atts( array(
	'campo' => '',
	'tipo' => ''
), $attr );
$user_id = get_post_meta(get_the_ID(), 'user_id', true);
$meta = get_user_meta( $user_id );

if(!$meta){
	return;
}

$tagTitolo = get_option('tag_titoli_pagina_op') ? get_option('tag_titoli_pagina_op') : 'h4';
$titoloChiSono = get_option('titolo_chi_sono') ? get_option('titolo_chi_sono') : 'Chi sono';
$titoloEsperienza = get_option('titolo_esperienza') ? get_option('titolo_esperienza') : 'Esperienza';
$titoloConsulto = get_option('titolo_consulto') ? get_option('titolo_consulto') : 'Consulto';

if($args['campo'] == 'chi_sono'){
	if(!empty($meta["chi_sono"][0])){
		$chi_sono = $meta["chi_sono"][0];
		if($args['tipo'] == 'titolo'){
			echo "<div class='desc-gen desc-chi-sono-titolo'><{$tagTitolo}>{$titoloChiSono}</{$tagTitolo}></div>";
		} else if($args['tipo'] == 'contenuto'){
			echo "<div class='desc-gen desc-chi-sono-contenuto'>".$chi_sono."</div>";
		} else {
			echo "<div class='desc-gen desc-chi-sono'>";
			echo "<{$tagTitolo}>{$titoloChiSono}</{$tagTitolo}>";
			echo $chi_sono;
			echo "</div>";
		}
	}
} else if($args['campo'] == 'esperienza'){
	if(!empty($meta["esperienza"][0])){
		$esperienza = $meta["esperienza"][0];
		if($args['tipo'] == 'titolo'){
			echo "<div class='desc-gen desc-esperienza-titolo'><{$tagTitolo}>{$titoloEsperienza}</{$tagTitolo}></div>";
		} else if($args['tipo'] == 'contenuto'){
			echo "<div class='desc-gen desc-esperienza-contenuto'>".$esperienza."</div>";
		} else {
			echo "<div class='desc-gen desc-esperienza'>";
			echo "<{$tagTitolo}>{$titoloEsperienza}</{$tagTitolo}></div>";
			echo $esperienza;
			echo "</div>";
		}
	}
} else if($args['campo'] == 'consulto'){
	if(!empty($meta["consulto"][0])){
		$consulto = $meta["consulto"][0];
		if($args['tipo'] == 'titolo'){
			echo "<div class='desc-gen desc-consulto-titolo'><{$tagTitolo}>{$titoloConsulto}</{$tagTitolo}></div>";
		} else if($args['tipo'] == 'contenuto'){
			echo "<div class='desc-gen desc-consulto-contenuto'>".$consulto."</div>";
		} else {
			echo "<div class='desc-gen desc-consulto'>";
			echo "<{$tagTitolo}>{$titoloConsulto}</{$tagTitolo}>";
			echo $consulto;
			echo "</div>";
		}
	}
} else {
	echo '<div class="cont-gen-descrizioni">';
    if(!empty($meta["chi_sono"][0])){
		$chi_sono = $meta["chi_sono"][0];
		echo "<div class='desc-gen cont-desc-pagina desc-chi-sono'>";
		echo "<{$tagTitolo}>{$titoloChiSono}</{$tagTitolo}>";
		echo $chi_sono;
		echo "</div>";
    }
    if(!empty($meta["esperienza"][0])){
		$esperienza = $meta["esperienza"][0];
		echo '<div class="desc-gen cont-desc-pagina desc-esperienza">';
		echo "<{$tagTitolo}>{$titoloEsperienza}</{$tagTitolo}>";
		echo $esperienza;
		echo '</div>';
    }
    if(!empty($meta["consulto"][0])){
		$consulto = $meta["consulto"][0];
		echo '<div class="desc-gen cont-desc-pagina desc-consulto">';
		echo "<{$tagTitolo}>{$titoloConsulto}</{$tagTitolo}>";
		echo $consulto;
		echo '</div>';
    }
    echo '</div>';
}