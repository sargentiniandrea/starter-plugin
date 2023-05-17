<?php

/**
 * Classe principale del plugin
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Starter_Plugin {

	/**
	 * Collegamento classi e dipendenze
	 */
	public function __construct() {

		$this->load_dependencies();
		$plugin_utility = new Starter_Plugin_Utility();
		$plugin_admin = new Starter_Plugin_Admin();
		$plugin_public = new Starter_Plugin_Public();
	}

	/**
	 * Caricamento dipendenze richieste dal plugin.
	 */
	public function load_dependencies() {

		// Classe per funzioni di utility generale 
		require_once SP_PLUG_PATH . 'includes/class-utility.php';

		// Classe per definizione azioni relative all'area admin.
		require_once SP_PLUG_PATH . 'admin/class-admin.php';

		// Classe per definizione azioni relative all'area public.
		require_once SP_PLUG_PATH . 'public/class-public.php';

	}

}
