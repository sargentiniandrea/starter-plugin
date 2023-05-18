<?php
/**
* Classe per gestione pagine impostazioni
* nell'area admin del sito.
**/

/*
 * Riferimenti al link https://github.com/boospot/boo-settings-helper/wiki/Detailed-Example
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Starter_Plugin_Settings{

    public function __construct(){
        
        // Impostazioni generali plugin
        add_action( 'admin_menu', array($this, 'admin_menu_setting_helper_as'));

    }


    /*
     * Impostazioni generali plugin
     */

    public function admin_menu_setting_helper_as(){
        require_once SP_PLUG_PATH . 'vendor/class-boo-settings-helper.php';
        $array_data_setting_helper             = array();
        $array_data_setting_helper['tabs']     = true;
        $array_data_setting_helper['menu']     = array(
				'page_title' => __( 'Impostazioni per '.SP_NAME, SP_SLUG ),
				'menu_title' => __( SP_NAME, SP_SLUG ),
				'capability' => 'manage_options',
				'slug'       => SP_SLUG,
				'icon'       => 'dashicons-admin-generic',
				'position'   => 4,
        );
        $array_data_setting_helper['sections'] = array(
            array(
                'id'    => 'impostazioni_generali',
                'title' => __( 'Impostazioni generali', SP_SLUG ),
                'desc'  => __( 'Impostazioni generali per la configurazione del plugin', SP_SLUG ),
            ),
            array(
                'id'    => 'setting_aggiornamenti',
                'title' => __( 'Aggiornamenti', SP_SLUG ),
                'desc'  => __( 'Collegamento per aggiornamenti', SP_SLUG )
            ),
        );
        $array_data_setting_helper['fields']   = array(

            // Impostazioni generali
            'impostazioni_generali' => array(
                array(
					'id'    => 'text_field_id',
					'label' => __( 'Text Field', DR_TXT_DOM ),
				),
				array(
					'id'    => 'color_field_id',
					'label' => __( 'Color Field', DR_TXT_DOM ),
					'type'  => 'color',
				),
				array(
					'id'      => 'radio_field_id',
					'label'   => __( 'Radio Button', DR_TXT_DOM ),
					'desc'    => __( 'A radio button', DR_TXT_DOM ),
					'type'    => 'radio',
					'options' => array(
						'radio_1' => 'Radio 1',
						'radio_2' => 'Radio 2',
						'radio_3' => 'Radio 3'
					),
					'default' => 'radio_2',
				),
				array(
					'id'      => 'select_field_id',
					'label'   => __( 'A Dropdown Select', DR_TXT_DOM ),
					'desc'    => __( 'Dropdown description', DR_TXT_DOM ),
					'type'    => 'select',
					'default' => 'option_2',
					'options' => array(
						'option_1' => 'Option 1',
						'option_2' => 'Option 2',
						'option_3' => 'Option 3'
					),
				),
            ),

            'setting_aggiornamenti' => array(
                array(
                    'id'    => 'branch_updates',
                    'label' => __( 'Branch aggiornamenti', DR_TXT_DOM ),
                    'desc'    => __( 'Inserisci il branch di collegamento. Valore di default: master.', DR_TXT_DOM ),
                    'type'  => 'text'
                ),
                array(
                    'id'    => 'token_updates',
                    'label' => __( 'Token aggiornamenti', DR_TXT_DOM ),
                    'desc'    => __( '<strong>In caso di repository privata.</strong> Inserisci il token di collegamento.', DR_TXT_DOM ),
                    'type'  => 'text'
                ),
            ),
        );
        $Boo_Settings_Helper = new Boo_Settings_Helper( $array_data_setting_helper );
    }

}