<?php

/**
 * Classe principale del plugin
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata {

	/**
	 * Collegamento classi e dipendenze
	 */
	public function __construct() {

		$this->load_dependencies();
		$plugin_utility = new Area_Riservata_Utility();
		$plugin_color_variables = new Area_Riservata_Color_Variables();
		$plugin_admin = new Area_Riservata_Admin();
		$plugin_public = new Area_Riservata_Public();
	}

	/**
	 * Caricamento dipendenze richieste dal plugin.
	 */
	public function load_dependencies() {

		// Classe per funzioni di utility generale 
		require_once NP_PLUG_PATH . 'includes/class-area-riservata-utility.php';

		// Classe per gestione variabili colore 
		require_once NP_PLUG_PATH . 'includes/class-area-riservata-color-variables.php';

		// Classe per definizione azioni relative all'area admin.
		require_once NP_PLUG_PATH . 'admin/class-area-riservata-admin.php';

		// Classe per definizione azioni relative all'area public.
		require_once NP_PLUG_PATH . 'public/class-area-riservata-public.php';

	}

}
