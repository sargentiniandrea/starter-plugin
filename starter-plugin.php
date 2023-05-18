<?php
/*
Plugin Name: Starter Plugin
Description: Descrizione
Version:     1.0.0
Text Domain: starter_plugin
Domain Path: /languages
License:     GPL2
*/

/*
 * Cambiare nome file principale: starter-plugin.php
 * Cambiare nome file classe principale: class-starter-plugin.php
 * Cambiare intestazione e file readme.txt
 * Cambiare le stringhe SP_, starter-plugin, starter_plugin e Starter_Plugin per i prefissi di costanti, riferimenti, funzioni e classi.
 * 
 * Per attivare pagina impostazioni togliere commenti alle relative righe nel file class-admin.php
 * Per attivare plugin richiesti togliere commenti alle relative righe nel file class-admin.php
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/*
 * Percorso file principale e slug
 */
Define('SP_MAIN_FILE_PATH' , __FILE__);
define('SP_SLUG', 'starter-plugin');

/*
 * Costanti
 */
require_once plugin_dir_path(__FILE__) . 'includes/constants.php';

/**
 * Codice avviato durante attivazione
 */
function activate_starter_plugin() {
	require_once SP_PLUG_PATH . 'includes/activator-deactivator/class-activator.php';
	Starter_Plugin_Activator::activate();
}

/**
 * Codice avviato durante disattivazione
 */
function deactivate_starter_plugin() {
	require_once SP_PLUG_PATH . 'includes/activator-deactivator/class-deactivator.php';
	Starter_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_starter_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_starter_plugin' );

/*
 * Controllo aggiornamenti
 */
require SP_PLUG_PATH . 'includes/update-checker.php';


/**
 * Classe principale
 */
require SP_PLUG_PATH . 'includes/class-starter-plugin.php';

/**
 * Esecuzione
 */
$initPlugin = new Starter_Plugin();
