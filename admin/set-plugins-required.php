<?php

/*
 * Set plugins obbligatori o raccomandati
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

$plugins = array(  

    // Profile Builder
    array(
    'name'               => 'Nome Plugin',
    'slug'               => 'profile-builder',
    'required'           => true,
    'version'            => '3.9.3',
    ),

    // Profile Builder Pro
    array(
    'name'               => 'Profile Builder Pro',
    'slug'               => 'profile-builder-pro',
    'source'             => NP_PLUG_PATH . 'includes/lib/plugins/profile-builder-pro.zip',
    'required'           => true,
    'version'            => '3.9.1',
    'force_activation'   => false,
    'force_deactivation' => false,
    'external_url'       => '',
    'is_callable'        => '',
    ),

    // Check & Log Email
    array(
    'name'               => 'Check & Log Email',
    'slug'               => 'check-email',
    'version'            => '1.0.7',
    'required'           => false,
    ),

);

/*
 * Configurazioni generali
 */

$config = array(
    'id'           => NP_SLUG,                 // Unique ID for hashing notices for multiple instances of TGMPA.
    'default_path' => '',                      // Default absolute path to bundled plugins.
    'menu'         => 'tgmpa-install-plugins', // Menu slug.
    'parent_slug'  => 'plugins.php',           // Parent menu slug.
    'capability'   => 'manage_options',        // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
    'has_notices'  => true,                    // Show admin notices or not.
    'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
    'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
    'is_automatic' => false,                   // Automatically activate plugins after installation or not.
    'message'      => '',                      // Message to output right before the plugins table.


    /*
    * Traduzione stringhe
    */
    
    'strings'      => array(
    'page_title'                      => __( 'Installa i plugins richiesti', NP_TXT_DOM ),
    'menu_title'                      => __( 'Installa i plugins', NP_TXT_DOM ),
    /* translators: %s: plugin name. */
    'installing'                      => __( 'Installazione Plugin: %s', NP_TXT_DOM ),
    /* translators: %s: plugin name. */
    'updating'                        => __( 'Aggiornamento Plugin: %s', NP_TXT_DOM ),
    'oops'                            => __( 'Qualcosa è andato storto con le API del plugin', NP_TXT_DOM ),
    'notice_can_install_required'     => _n_noop(
        /* translators: 1: plugin name(s). */
        'Area Riservata richiede il seguente plugin: %1$s.',
        'Area Riservata richiede i seguenti plugins: %1$s.',
        NP_TXT_DOM
    ),
    'notice_can_install_recommended'  => _n_noop(
        /* translators: 1: plugin name(s). */
        'Area Riservata raccomanda il seguente plugin: %1$s.',
        'Area Riservata raccomanda i seguenti plugins: %1$s.',
        NP_TXT_DOM
    ),
    'notice_ask_to_update'            => _n_noop(
        /* translators: 1: plugin name(s). */
        'Il seguente plugin deve essere aggiornato per garantire la piena compatibilità con Area Riservata: %1$s.',
        'I seguenti plugins devono essere aggiornati per garantire la piena compatibilità con Area Riservata: %1$s.',
        NP_TXT_DOM
    ),
    'notice_ask_to_update_maybe'      => _n_noop(
        /* translators: 1: plugin name(s). */
        'Un aggiornamento è disponibile per: %1$s.',
        'Un aggiornamento è disponibile per i seguenti plugins: %1$s.',
        NP_TXT_DOM
    ),
    'notice_can_activate_required'    => _n_noop(
        /* translators: 1: plugin name(s). */
        'Il seguente plugin richiesto è inattivo: %1$s.',
        'I seguenti plugin richiesti sono inattivi: %1$s.',
        NP_TXT_DOM
    ),
    'notice_can_activate_recommended' => _n_noop(
        /* translators: 1: plugin name(s). */
        'Il seguente plugin raccomandato è inattivo: %1$s.',
        'I seguenti plugin raccomandati sono inattivi: %1$s.',
        NP_TXT_DOM
    ),
    'install_link'                    => _n_noop(
        'Installa il plugin',
        'Installa i plugins',
        NP_TXT_DOM
    ),
    'update_link' 					  => _n_noop(
        'Aggiorna il plugin',
        'Aggiorna i plugins',
        NP_TXT_DOM
    ),
    'activate_link'                   => _n_noop(
        'Attiva il plugin',
        'Attiva i plugins',
        NP_TXT_DOM
    ),
    'return'                          => __( 'Torna all’installazione dei plugin richiesti', NP_TXT_DOM ),
    'plugin_activated'                => __( 'Plugin attivato con successo', NP_TXT_DOM ),
    'activated_successfully'          => __( 'Il seguente plugin è stato attivato con successo:', NP_TXT_DOM ),
    /* translators: 1: plugin name. */
    'plugin_already_active'           => __( 'Nessuna azione eseguita. Il plugin %1$s è già attivato.', NP_TXT_DOM ),
    /* translators: 1: plugin name. */
    'plugin_needs_higher_version'     => __( 'Plugin non attivato. Una versione maggiore di %s è richiesta per Area Riservata. Per favore aggiorna il plugin.', NP_TXT_DOM ),
    /* translators: 1: dashboard link. */
    'complete'                        => __( 'Tutti i plugin sono stati installati e attivati con successo. %1$s', NP_TXT_DOM ),
    'dismiss'                         => __( 'Chiudi la notifica', NP_TXT_DOM ),
    'notice_cannot_install_activate'  => __( 'Ci sono uno o più plugin richiesti o consigliati da installare, aggiornare o attivare', NP_TXT_DOM ),
    'contact_admin'                   => __( 'Per favore contatta un amministratore di questo sito per richiedere aiuto', NP_TXT_DOM ),

    'nag_type'                        => '',
    ),
);

tgmpa( $plugins, $config );