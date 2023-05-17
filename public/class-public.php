<?php

/**
 * Le funzionalità del plugin per l'area public.
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Starter_Plugin_Public {

	/**
	 * Inizializzazione classe.
	 */
	public function __construct() {

		$this->loadDipendenze();
		$this->getClassiPublic();

	}

	private function loadDipendenze(){
		// Classe stile e script per area public
		require_once SP_PLUG_PATH . 'public/class/class-public-enqueue.php';

	}

	private function getClassiPublic(){

		$classPublicEnqueue = new Starter_Plugin_Public_Enqueue();

	}

}
