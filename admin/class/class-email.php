<?php
/**
* classe per gestione nuove email
**/

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Admin_Email{

    public function __construct(){

        add_action( 'wppb_edit_profile_success', array($this, 'wppb_in_epaa_send_notification_to_admin_2'), 10, 3);
        add_action( 'updated_user_meta', array($this, 'email_avvisi'), 10, 4);

    }

    // Funzione che invia una mail nel momento in cui un utente aggiorna il profilo e sono presenti dei campi che richiedono l'approvazione di un amministratore.
    // Nella mail sono presenti i campi che l'utente ha modificato con i valori precedenti e successivi alla modifica e un link per accedere per poi andare a revisionare le modifiche
    public function wppb_in_epaa_send_notification_to_admin_2( $request, $form_name, $user_id ){
        global $wppb_epaa_fields_awaiting_approval;
        if( !empty( $wppb_epaa_fields_awaiting_approval ) ){
            $site_name = get_bloginfo( 'name' );
            $admin_email = get_bloginfo( 'admin_email' );
		    $site_url = get_site_url();
            $url_accedi = $site_url.'/accedi';
            $userdata = get_userdata( $user_id );
            $approve_url = '<a href="'. esc_url_raw( add_query_arg( array( 
                'edit_user' => $user_id,
                'wppb_epaa_review_users' => 'true' ), wppb_in_epaa_determine_url_from_form_name($form_name) ) ) .'" target="_blank">Clicca qui</a>';
            $content = '<div style="font-family: Arial, sans-serif; font-size: 14px;">';
            $content .= '<br>L\'operatore <strong>'.$userdata->display_name.'</strong> ha aggiornato il suo profilo e alcuni campi richiedo l\'approvazione di un amministratore:<br><br><hr>';
            foreach( $wppb_epaa_fields_awaiting_approval as $field_awaiting_approval ){
                $fieldTitle = $field_awaiting_approval[0]['field-title'];
                $fieldMetaName = $field_awaiting_approval[0]['meta-name'];
                $sep = ' a ';
                if($fieldTitle == 'Riposo'){
                    if($field_awaiting_approval[2] == 'Si'){
                        $campoPre = 'Si'; 
                        $campoPost = 'No'; 
                    }
                    if($field_awaiting_approval[1] == 'Si'){
                        $campoPre = 'No';
                        $campoPost = 'Si';  
                    }
                } elseif($fieldMetaName == 'chi_sono' || $fieldMetaName == 'esperienza' || $fieldMetaName == 'consulto'){
                    $campoPre = '<br>'.$field_awaiting_approval[2];
                    $campoPost = $field_awaiting_approval[1]; 
                    $sep = '<br>Nuovo contenuto:<br>';
                    if($field_awaiting_approval[2] == ''){
                        $campoPre = '< vuoto >';
                    }
                    if($field_awaiting_approval[1] == ''){
                        $campoPost = '< vuoto >';
                    }
                } else {
                    $campoPre = str_replace(',', ':', $field_awaiting_approval[2]);
                    $campoPost = str_replace(',', ':', $field_awaiting_approval[1]);
                    if($campoPre == ''){
                        $campoPre = '//://'; 
                    }
                    if($campoPost == ''){
                        $campoPost = '//://'; 
                    }
                }
                $parole = explode('_', $fieldMetaName);
                $paroleDiff = array_diff($parole, array('approv'));
                foreach ($paroleDiff as $key => $value) {
                    if(is_numeric($value)){
                        $nuovoValore = $value + 1;
                        $paroleDiff = array_replace($paroleDiff, array($key => $nuovoValore));
                    }
                }
                $nuovaStringa = ucwords(implode( ' ', $paroleDiff ));
                $content .= '<strong style="color: #0000a1">' . $nuovaStringa . '</strong> è cambiato da: ';
                $content .= '<strong>' . $campoPre . '</strong>';
                $content .= $sep;
                $content .= '<strong>' . $campoPost . '</strong>';
                $content .= '<hr>';
            }
            $content .= '<br>Per revisionare le modifiche accedi alla tua area riservata: <a href="'.$url_accedi.'" target="_blank">Clicca qui</a>';
            $content .= '<br></div>';
            $to = apply_filters( 'wppb_epaa_admin_email_to', get_option('admin_email') );
            $admin_email = get_option( 'email_mittente' );
            $wppb_toolbox_admin_settings = get_option('wppb_toolbox_admin_settings');
            if( isset( $wppb_toolbox_admin_settings['admin-emails'] ) && !empty( $wppb_toolbox_admin_settings['admin-emails'] ) ) {
                $to2 = $wppb_toolbox_admin_settings['admin-emails'];
            } else {
                $to2 = $to;
            }
            $from = array('Content-Type: text/html; charset=UTF-8','From: '.$site_name.' <'.$admin_email.'>');
            wp_mail( $to2, '['.$site_name.'] '.$userdata->display_name.' ha modificato il suo profilo', $content, $from );
        }
    }


    // Invio email quando un utente modifica la domanda del form sugli avvisi
    public function email_avvisi($meta_id, $object_id, $meta_key, $_meta_value){
        if($meta_key == 'check_avvisi'){
           $site_name = get_bloginfo( 'name' );
           $admin_email = get_bloginfo( 'email_mittente' );
           $userdata = get_userdata( $object_id );
           $risposta = ucfirst($_meta_value);
           $wppb_toolbox_admin_settings = get_option('wppb_toolbox_admin_settings');
           $to = $wppb_toolbox_admin_settings['admin-emails'];
           $operatore = $userdata->display_name;
           $content = '<br>L\'operatore <strong>'.$operatore.'</strong> ha modificato la scelta degli avvisi su:<br><br><strong>'.$risposta.'</strong>';
           $subject = '['.$site_name.'] Un operatore ha modificato la scelta sugli avvisi';
           $from = array('Content-Type: text/html; charset=UTF-8','From: '.$site_name.' <'.$admin_email.'>');
           wp_mail( $to, $subject, $content, $from );
        }  
    }

}