<?php
/**
* classe per personalizzazione pannello area Admin
**/

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Admin_Panel_Custom{

    public function __construct(){
        
        add_action( 'wp_before_admin_bar_render', array($this, 'wps_admin_bar'));
        add_action( 'admin_bar_menu', array($this, 'add_link_to_admin_bar'), 999);
        add_action( 'admin_head', array($this, 'style_admin_bar'));
        add_action( 'wp_head', array($this, 'style_admin_bar'));

        add_filter( 'pre_get_users', array($this, 'show_only_operatori_for_admin_area'));

    }


    // Se amministratore Area Utenti rimuovi voci di menu dalla toolbar
    public function wps_admin_bar() {
        if ( current_user_can('amministratore_area_utenti') ) {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('new-content');
        $wp_admin_bar->remove_menu('wp-logo');
        }
    }


    // Aggiunge voci di menu alla toolbar con collegamenti pagine di Profile Builder
    public function add_link_to_admin_bar($admin_bar) {
        $loginLink = get_permalink(get_option('pagina_accedi'));
        $modificaLink = get_permalink(get_option('pagina_modifica'));
        $registraLink = get_permalink(get_option('pagina_registrazione'));
        $logoutLink = wp_logout_url($loginLink);
        $argsHome = array(
            'id' => 'home-link',
            'title' => 'Home', 
            'href' => '/',
            'meta'   => array(
                'class' => 'toolbar-profilo'
            )
        );
        $args1 = array(
            'id' => 'utenti-link',
            'title' => 'Lista Utenti', 
            'href' => '/wp-admin/users.php?role=operatore',
            'meta'   => array(
                'class' => 'toolbar-profilo'
            )
        );
        $args2 = array(
            'id' => 'modifica-link',
            'title' => 'Modifica Utenti', 
            'href' => $modificaLink,
            'meta'   => array(
                'class' => 'toolbar-profilo'
            )
        );
        $args3 = array(
            'id' => 'registra-link',
            'title' => 'Registra Utenti', 
            'href' => $registraLink,
            'meta'   => array(
                'class' => 'toolbar-profilo'
            )
        );
        $argsOut = array(
            'id' => 'logout-link',
            'title' => 'Esci >>', 
            'href' => $logoutLink,
            'meta'   => array(
                'class' => 'toolbar-profilo'
            )
        );
        if ( current_user_can('amministratore_area_utenti') ) {
        $admin_bar->add_node($argsHome);
        $admin_bar->add_node($args1);
        $admin_bar->add_node($args2);
        $admin_bar->add_node($args3);
        $admin_bar->add_node($argsOut);
        }
        if ( current_user_can('administrator') ) {
        $admin_bar->add_node($args1);
        $admin_bar->add_node($args2);
        $admin_bar->add_node($args3);
        }
    }


    // Stile per toolbar
    public function style_admin_bar() { ?>
	<style type="text/css">
    <?php require_once NP_PLUG_PATH . 'admin/css/admin-toolbar.css'; ?>
	</style>
    <?php }


    // Se Amministratore Area Utenti mostrare solo utenti con ruolo 'operatore' nella lista utenti del back-end
    public function show_only_operatori_for_admin_area($user_query) {
        if ( current_user_can('amministratore_area_utenti') ) { 
            $user_query->set('role__not_in', ['administrator', 'amministratore_area_utenti']);
        }
    }

}