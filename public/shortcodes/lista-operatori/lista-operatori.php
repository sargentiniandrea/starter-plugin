<?php

/*
 * Template per mostrare una lista di operatori con un input testuale per la ricerca e
 * pulsanti per mostrare / nascondere gli operatori
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

$tot = $atts[ 'totale' ] ? intval($atts[ 'totale' ]) : -1;
$orderBy = get_option('order_by_lista_op') ? get_option('order_by_lista_op') : 'ID';
$order = get_option('order_lista_op') ? get_option('order_lista_op') : 'ASC';
$args = array(
    'role'    => 'operatore',
    'orderby' => $orderBy,
    'order'   => $order,
    'number'  => $tot,
);
$users = get_users( $args );

if(!$users){
	return;
}

$css_op = get_option('editor-template-lista-op-css');
$gapAttr = str_replace('.', '_', $atts[ 'gap' ]);
echo '<style>'.$css_op.'</style>';

?>

<div class="cont-lista-carto lista-op-<?php echo $atts[ 'col' ] ?>-col lista-op-<?php echo $gapAttr ?>-gap <?php echo $atts[ 'class' ] ?>">
    <?php if(get_option('search_lista_op') == 'si'){ ?>
   <input type="text" id="search_carto" onkeyup="carto_search()" placeholder="Cerca cartomante..">
   <?php } ?>
   <div class="container-lista-op">

   <?php foreach ( $users as $user ) {
   $user_id = $user->ID;
   $user_id_int = intval($user_id);
   $nomeOp = $user->display_name;
   $post = Area_Riservata_Utility::get_post_by_meta( array(
	   'meta_key' => 'user_id',
	   'meta_value' => $user_id_int
	   ) );
   $link = get_permalink($post);
   $tmpl_op = get_option('editor-template-lista-op-html');
   $tmpl_op_rpl = str_replace(
    ['{{link_pagina_op}}', '{{nome_op}}'],
    [$link, $nomeOp],
    $tmpl_op);
    echo '<div class="box-op">'.$tmpl_op_rpl.'</div>';

   } ?>

   </div>
   <?php
   if(get_option('toggle_btn_lista_op') == 'si'){
       $show_item_op = get_option('show_item_op');
       $show_item_operatori = get_option('show_item_operatori');
       if($tot > $show_item_operatori || $tot == 0 || $tot == -1){?>
            <div class="cont-btn-toggle">
                    <span class="button carto-show-more">Mostra di più</span>
                    <span class="button carto-show-all">Mostra tutti</span>
                    <span class="button carto-show-less hide-btn">Mostra meno</span>
            </div>
    <?php
        } 
    }
    ?>
</div>