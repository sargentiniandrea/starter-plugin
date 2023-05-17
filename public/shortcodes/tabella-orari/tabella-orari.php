<?php 

/*
 * Template per tabella orari globale
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

$sepRiposo = get_option('txt_giorno_riposo') ? get_option('txt_giorno_riposo') : '-';
$operatori = $this->utility->get_array_operatori($sepRiposo);
if(!$operatori){
	return;
}

?>

<div class="cont-tab-op">
    <table class="tabella-op tabella-op-glob">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Lunedì</th>
                <th>Martedì</th>
                <th>Mercoledì</th>
                <th>Giovedì</th>
                <th>Venerdì</th>
                <th>Sabato</th>
                <th>Domenica</th>
            </tr>
        </thead>
        <tbody>

        <?php
        foreach ( $operatori as $operatore ) {
        $user_id = $operatore->ID;
        $user_id_int = intval($user_id);
        $post = $this->utility->get_post_by_meta( array(
            'meta_key' => 'user_id',
            'meta_value' => $user_id_int
        ));
        $link = get_permalink($post);
        $meta = get_user_meta( $user_id );
        $nomeOp = $operatore->nome;
        $orari = $operatore->orari;
        $setLink = get_option('link_pagina_tab_orari') ? get_option('link_pagina_tab_orari') : 'si';
        ?>
        <tr>
            <td>
                <?php if($setLink == 'si'){ ?>
                <a href="<?php echo $link ?>">
                    <?php echo $nomeOp ?>
                </a>
                <?php } else { ?>
                <?php echo $nomeOp ?>
                <?php } ?>
            </td>
            <?php
            foreach ($orari as $giorno => $arrayOrario) { ?>
            <td>
            <div class="tab-giorno-mob"><?php echo $giorno ?></div>
            <div class="tab-orario">
                <?php
                foreach ($arrayOrario as $orario ) { ?>
                    <div><?php echo $orario ?></div>
                <?php } ?>
            </div>
            </td>
            <?php }
            ?>
        </tr>
    <?php } ?>
        </tbody>
    </table>
</div>

