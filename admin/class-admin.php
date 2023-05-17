<?php

/**
 * Le funzionalità del plugin per l'area admin.
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Starter_Plugin_Admin {

	/**
	 * Inizializzazione classe.
	 */
	public function __construct() {

		$this->loadDipendenze();
		$this->getClassiPublic();

		// Azione per attivare controllo plugin richiesti
		//add_action( 'tgmpa_register', array($this, 'plugin_required') );

	}


	private function loadDipendenze(){
		// Classe plugin installazioni richieste
		//require_once SP_PLUG_PATH . 'vendor/class-tgm-plugin-activation.php';

		// Classe stile e script per area admin
		require_once SP_PLUG_PATH . 'admin/class/class-admin-enqueue.php';

		// Classe per gestione pagine impostazioni del plugin
		//require_once SP_PLUG_PATH . 'admin/class/class-settings.php';
	}


	private function getClassiPublic(){
		$classAdminEnqueue = new Starter_Plugin_Admin_Enqueue();
		
		//$classSettingApi = new Starter_Plugin_Settings();
	}


	// Collegamento a file per settare plugin installazioni richieste 
	public function plugin_required() {
		require_once SP_PLUG_PATH . 'admin/set-plugins-required.php';
	}

}
