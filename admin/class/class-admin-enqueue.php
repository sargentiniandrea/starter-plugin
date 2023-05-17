<?php 

/*
* Caricamento e registrazione stili e script per area ADMIN
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Admin_Enqueue {


	public function __construct() {
		
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_styles'), 999 );
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts'), 999 );

		add_action( 'admin_enqueue_scripts', array($this, 'codemirror_enqueue_scripts'));

	}

    // Registrazione stile per area admin.
	public function enqueue_styles() {

		wp_enqueue_style('custom-styles', NP_PLUG_URL . 'admin/css/admin.css', array(), NP_VERSION, 'all');

	}

	// Registrazione script per area admin.
	public function enqueue_scripts() {

		wp_enqueue_script('main_custom_js', NP_PLUG_URL . 'admin/js/admin.js', array(), NP_VERSION, true );

	}

	public function codemirror_enqueue_scripts($hook) {
		if ( 'area-riservata_page_editor-template-lista-op' != $hook && 'area-riservata_page_custom-css-area-riservata' != $hook) {
		return;
		}
		$cm_settings['codeEditor'] = wp_enqueue_code_editor(['type' => 'text/html']);
		wp_localize_script('jquery', 'cm_settings', $cm_settings);
		wp_enqueue_script('wp-theme-plugin-editor');
		wp_enqueue_style('wp-codemirror');
		}

}