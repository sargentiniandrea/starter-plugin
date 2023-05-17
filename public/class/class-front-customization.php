<?php 

/*
* Funzioni per modifiche al layout front end del plugin Profile Builder e impostazione nuove funzionalità
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Front_Customization {


	public function __construct() {

        add_filter( 'wppb_before_form_fields', array($this, 'intro_form_logout') );
        add_filter( 'wppb_login_message', array($this, 'link_modifica') );
        add_filter( 'wppb_edit_profile_user_not_logged_in_message', array($this, 'link_accedi') );

        add_action( 'wp_loaded', array($this, 'rimuovi_notif_standard_approv') );
        add_action( 'wppb_edit_profile_success', array($this, 'wppb_in_epaa_show_edit_profile_notification2'), 10, 3 );

	}
    

    // Inserisce link per logout sopra i form di modifica e registrazione
    public function intro_form_logout($content){
        if( !is_user_logged_in() ){
            return;
        }
        $user = wp_get_current_user();
        $userName = $user->display_name;
        echo do_shortcode('[wppb-logout text="Sei attualmente connesso come <strong>' . $userName .'</strong>."]');
        echo '<div class="container-btn-step"><span class="btn-orari btn-active">ORARI</span><span class="btn-info">INFORMAZIONI</span></div>';
        echo $content;
    }

    // Inserisce link per accedere alla pagina di modifica se utente è loggato e si trova su pagina di login
    public function link_modifica(){
        if( !is_user_logged_in() ){
            return;
        }
        $modificaLink = get_permalink(get_option('pagina_modifica'));
        echo do_shortcode('[wppb-logout text="Sei attualmente connesso come <strong>{{meta_user_name}}</strong>."]');
        echo '<p class="link-modifica"><a href="'.$modificaLink.'">Vai alla pagina di modifica</a></p>';
    }


    // Inserisce link per accedere alla pagina di login se utente è su pagina di modifica e non è connesso
    public function link_accedi(){
        $loginLink = get_permalink(get_option('pagina_accedi'));
        echo '<p class="warning" id="wppb_edit_profile_user_not_logged_in_message">'.esc_html(__( 'You must be logged in to edit your profile.', 'profile-builder' )) .'</p>';
        echo '<p class="link-accedi"><a href="'.$loginLink.'">Accedi</a></p>';
    }


    // Modifica messaggio quando un utente modifica il profilo e sono presenti campi da far approvare
    public function rimuovi_notif_standard_approv () {
        remove_action( 'wppb_edit_profile_success', 'wppb_in_epaa_show_edit_profile_notification', 10, 3 );
    }
    //--------
    public function wppb_in_epaa_show_edit_profile_notification2( $request, $form_name, $user_id ){
        global $wppb_epaa_fields_awaiting_approval;
        if( !empty( $wppb_epaa_fields_awaiting_approval ) ){
            echo '<p class="wppb-epaa-warning">Alcuni campi richiedono l\'approvazione di un amministratore</p>';
        }
    }
}