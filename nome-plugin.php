<?php
/*
Plugin Name: Nome Plugin
Description: Descrizione
Version:     1.0.0
Text Domain: nome_plugin
Domain Path: /languages
License:     GPL2
*/

/*
 * Cambiare intestazione e file readme.txt
 * Cambiare NP_MAIN_FILE_PATH sostituendo il prefisso
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/*
 * Percorso file principale
 */
Define('NP_MAIN_FILE_PATH' , __FILE__);

/*
 * Costanti
 */
require_once plugin_dir_path(__FILE__) . 'includes/constants.php';

/**
 * Codice avviato durante attivazione
 */
function activate_area_riservata() {
	require_once NP_PLUG_PATH . 'includes/class-area-riservata-activator.php';
	Area_Riservata_Activator::activate();
}

/**
 * Codice avviato durante disattivazione
 */
function deactivate_area_riservata() {
	require_once NP_PLUG_PATH . 'includes/class-area-riservata-deactivator.php';
	Area_Riservata_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_area_riservata' );
register_deactivation_hook( __FILE__, 'deactivate_area_riservata' );

/*
 * Controllo aggiornamenti
 */
require NP_PLUG_PATH . 'includes/update-checker.php';


/**
 * Classe principale
 */
require NP_PLUG_PATH . 'includes/class-area-riservata.php';

/**
 * Esecuzione
 */
$initPlugin = new Area_Riservata();
