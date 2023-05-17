<?php

/**
 * Le funzionalità del plugin per l'area admin.
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Admin {

	/**
	 * Inizializzazione classe.
	 */
	public function __construct() {

		$this->loadDipendenze();
		$this->getClassiPublic();

		add_action( 'tgmpa_register', array($this, 'area_riservata_plugin_required') );

	}


	private function loadDipendenze(){
		// Classe plugin installazioni richieste
		require_once NP_PLUG_PATH . 'includes/lib/class-tgm-plugin-activation.php';
		// Classe stile e script per area admin
		require_once NP_PLUG_PATH . 'admin/class/class-admin-enqueue.php';
		// Classe gestione nuovi ruoli
		require_once NP_PLUG_PATH . 'admin/class/class-ruoli.php';
		// Classe gestione utenti
		require_once NP_PLUG_PATH . 'admin/class/class-gestione-utenti.php';
		// Classe personalizzazione pannello Admin
		require_once NP_PLUG_PATH . 'admin/class/class-custom-admin-panel.php';
		// Classe per gestione email
		require_once NP_PLUG_PATH . 'admin/class/class-email.php';
		// Classe per gestione REST API
		require_once NP_PLUG_PATH . 'admin/class/class-rest-api.php';
		// Classe per gestione pagine impostazioni del plugin
		require_once NP_PLUG_PATH . 'admin/class/class-settings.php';
	}


	private function getClassiPublic(){
		$classAdminEnqueue = new Area_Riservata_Admin_Enqueue();
		$classRuoli = new Area_Riservata_Ruoli();
		$classGestioneUtenti = new Area_Riservata_Gestione_Utenti();
		$classPannelloAdmin = new Area_Riservata_Admin_Panel_Custom();
		$classAdminEmail = new Area_Riservata_Admin_Email();
		$classRestApi = new Area_Riservata_Rest_Api();
		$classSettingApi = new Area_Riservata_Settings();
	}


	// Collegamento a file per settare plugin installazioni richieste 
	public function area_riservata_plugin_required() {
		require_once NP_PLUG_PATH . 'admin/set-plugins-required.php';
	}

}
