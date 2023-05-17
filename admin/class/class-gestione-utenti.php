<?php 

/*
* Gestione Utenti
* Tutte le funzionalità legate agli utenti e le azioni legate
* a qualsiasi modifica dell'utente
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}


class Area_Riservata_Gestione_Utenti {

	public function __construct() {

        $option = get_option('shortcode_single_op');
        // var_dump($option);
        // die;

        add_action( 'user_register', array($this, 'creazione_pagina_reg_utente'), 10, 1 );

        add_action( 'delete_user', array($this, 'elimina_elementi_utenti') );

	}


    // Alla registrazione di un utente crea una pagina e gli assegna user-id come meta data
    public function creazione_pagina_reg_utente( $user_id ) {
        $user_meta = get_userdata($user_id);
        $user_roles = $user_meta->roles;
        $ruolo = $user_roles[0];
        if($ruolo == 'operatore'){
            $authorName = get_the_author_meta( 'user_login', $user_id );
            preg_match('/[^\d]+/', $authorName, $nomeOpArr);
            preg_match('/\d+/', $authorName, $codOpArr);
            $nomeOp = ucfirst($nomeOpArr[0]);
            $codOp = $codOpArr[0];
            $shortcode = get_option('shortcode_single_op');
            $sfxPage = get_option('suffisso_pagina') ? get_option('suffisso_pagina') . ' ' : '';
            $nomeOpCompleto = $nomeOp . ' ' . $codOp;
            wp_update_user([
                'ID' => $user_id,
                'first_name' => $nomeOp,
                'last_name' => $codOp,
                'display_name' => $nomeOpCompleto
            ]);
            //------
            $authorName = get_the_author_meta( 'user_login', $user_id );
              $my_post = array(
                'post_title'    => $sfxPage . $nomeOpCompleto,
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_content' => $shortcode,
                'meta_input' => array(
                'user_id' => $user_id
                )
              );
              wp_insert_post( $my_post );
        }
    }
    //-----------------------------

    // Eliminazione pagina e recensioni collegate all'utente alla sua eliminazione
    public function elimina_elementi_utenti($user_id){
        $this->eliminaPaginaUtente($user_id);
        $this->eliminaRecensioniUtente($user_id);
    }

    // Funzione per eliminare pagina collegata all'utente
    public function eliminaPaginaUtente($user_id){
        $user_id_int = intval($user_id);
        $user_meta = get_userdata($user_id);
        $user_roles = $user_meta->roles;
        $ruolo = $user_roles[0];
        $settings = get_option('eliminazione_operatore');
        if($ruolo == 'operatore'){
            if (method_exists('Area_Riservata_Utility', 'get_post_by_meta')){
                $post = Area_Riservata_Utility::get_post_by_meta( array(
                    'meta_key' => 'user_id',
                    'meta_value' => $user_id_int
                    ) );
                if ($settings == 'cestina'){
                    $args = array(
                        'ID'            => $post->ID,
                        'post_content'  => '',
                    );
                    wp_update_post( $args );
                    wp_trash_post( $post->ID );
                } else if ($settings == 'elimina'){
                    wp_delete_post($post->ID, true);
                } else if($settings == 'bozza'){
                    $args = array(
                        'ID'            => $post->ID,
                        'post_status'   => 'draft',
                        'post_content'  => '',
                    );
                    wp_update_post( $args );
                } else {
                    $args = array(
                        'ID'            => $post->ID,
                        'post_content'  => '',
                    );
                    wp_update_post( $args );
                    wp_trash_post( $post->ID ); 
                }
            }
        }
    }
    //-----------------------------
    
    // Funzione per eliminare recensioni collegate all'utente
    public function eliminaRecensioniUtente($user_id){
        if (function_exists('glsr_get_reviews')){
            $reviews = glsr_get_reviews([
                'assigned_users' => $user_id
            ]);
            $settings = get_option('eliminazione_operatore');
            foreach ($reviews as $review){
                $post_id = $review->ID;
                if ($settings == 'cestina'){
                    wp_trash_post( $post_id );
                } else if ($settings == 'elimina'){
                    wp_delete_post($post->ID, true);
                } else if($settings == 'bozza'){
                    $args = array(
                        'ID'            => $post_id,
                        'post_status'   => 'draft',
                    );
                    wp_update_post( $args );
                } else {
                    wp_trash_post( $post_id ); 
                }
            }
        }
    }
    //-----------------------------


}