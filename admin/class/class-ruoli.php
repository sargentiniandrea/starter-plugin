<?php
/**
* classe per creazione nuovi ruoli
**/

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Ruoli{

    public function __construct(){
        
        add_action( 'init', array($this, 'add_roles_area_riservata'));

    }

    public function add_roles_area_riservata(){
        global $wp_roles;
        if(! isset($wp_roles)){
            $wp_roles = new WP_Roles();
        }
        // Operatore
        $wp_roles->add_role(
            'operatore',
            'Operatore',
            array(
                'read' => true
            )
        );
        // Amministratore Area Utenti
        $wp_roles->add_role(
            'amministratore_area_utenti',
            'Amministratore Area Utenti',
            array(
                'remove_users' => true,
                'promote_users' => true,
                'list_users' => true,
                'edit_users' => true,
                'delete_users' => true,
                'create_users' => true,
                'add_users' => true,
                'read_private_pages' => true,
                'read' => true,
                'manage_options' => true
            )
        );
        // Impostazione operatore come ruolo predfinito
        update_option( 'default_role', 'operatore' );
    }

}