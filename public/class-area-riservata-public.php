<?php

/**
 * Le funzionalità del plugin per l'area public.
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Public {

	/**
	 * Inizializzazione classe.
	 */
	public function __construct() {

		$this->loadDipendenze();
		$this->getClassiPublic();

	}

	private function loadDipendenze(){
		// Classe stile e script per area public
		require_once NP_PLUG_PATH . 'public/class/class-public-enqueue.php';
		// Classe per customizzazioni sul front end per il plugin Profile Builder
		require_once NP_PLUG_PATH . 'public/class/class-front-customization.php';
		// Classe per shortcodes
		require_once NP_PLUG_PATH . 'public/class/class-shortcodes.php';

	}

	private function getClassiPublic(){

		$classPublicEnqueue = new Area_Riservata_Public_Enqueue();
		$classFrontCustomization = new Area_Riservata_Front_Customization();
		$classShortcodes = new Area_Riservata_Shortcodes();

	}

}
