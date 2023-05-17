<?php

/*
 * Set plugins obbligatori o raccomandati
 */

/*
 * Riferimenti al link https://github.com/TGMPA/TGM-Plugin-Activation
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

$plugins = array(  

		// Questo è un esempio di come includere un plugin in bundle con il plugin ospitante.
		array(
			'name'               => 'TGM Example Plugin', // Nome plugin.
			'slug'               => 'tgm-example-plugin', // Slug plugin (tipicamente nome cartella).
			'source'             => SP_PLUG_PATH . 'includes/lib/plugins/tgm-example-plugin.zip', // Origine plugin.
			'required'           => true, // Se false, il plug-in è solo "consigliato" anziché richiesto.
			'version'            => '', // Es. 1.0.0. Se dichiarato, rappresenta la versione minima che deve avere il plugin. Nel caso la versione sià inferiore un messaggio notificherà l'utente di aggiornare.
			'force_activation'   => false, // Se true, il plug-in viene attivato all'attivazione del plugin ospitante e non può essere disattivato fino al cambio del plugin ospitante.
			'force_deactivation' => false, // Se true, il plug-in viene disattivato alla disattivazione del plugin ospitante, utile per plug-in specifici del plugin ospitante.
			'external_url'       => '', // Se impostato, sovrascrive l'URL API predefinito e punta a un URL esterno.
			'is_callable'        => '', // Se impostato, verrà verificata la disponibilità di questo callable per determinare se un plug-in è attivo.
		),

		// Questo è un esempio di come includere un plugin da una fonte esterna al plugin ospitante.
		array(
			'name'         => 'TGM New Media Plugin', // Nome plugin.
			'slug'         => 'tgm-new-media-plugin', // Slug plugin (tipicamente nome cartella).
			'source'       => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // Origine plugin.
			'required'     => true, // Se false, il plug-in è solo "consigliato" anziché richiesto.
			'external_url' => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // Se impostato, sovrascrive l'URL API predefinito e punta a un URL esterno.
		),

		// Questo è un esempio di come includere un plugin da un repository GitHub nel plugin ospitante.
		// Ciò presuppone che il codice del plug-in sia basato nella radice del repository GitHub
		// e non in una sottodirectory ('/src') del repository.
		array(
			'name'   => 'Adminbar Link Comments to Pending',
			'slug'   => 'adminbar-link-comments-to-pending',
			'source' => 'https://github.com/jrfnl/WP-adminbar-comments-to-pending/archive/master.zip',
		),

		// Questo è un esempio di come includere un plugin dal repository dei plugin di WordPress.
		array(
			'name'     => 'BuddyPress',
			'slug'     => 'buddypress',
			'required' => false,
		),

		// Questo è un esempio dell'uso della funzionalità 'is_callable'. Un utente potrebbe, ad esempio, avere installato Yoast SEO *o* Yoast SEO Premium.
		// Lo slug in quest'ultimo caso sarebbe stato diverso, es. 'wordpress-seo-premium'.
		// Impostando 'is_callable' su una funzione di quel plugin o su un metodo di classe
        // "array( 'class', 'method' )" simile a come ci si collega ad azioni e filtri,
        // TGMPA può ancora riconoscere il plugin come installato.
		array(
			'name'        => 'Yoast SEO',
			'slug'        => 'wordpress-seo',
			'is_callable' => 'wpseo_init',
		),

	);

/*
 * Configurazioni generali
 */

$config = array(
    'id'           => SP_SLUG,                 // Unique ID for hashing notices for multiple instances of TGMPA.
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
    'page_title'                      => __( 'Installa i plugins richiesti', SP_TXT_DOM ),
    'menu_title'                      => __( 'Installa i plugins', SP_TXT_DOM ),
    /* translators: %s: plugin name. */
    'installing'                      => __( 'Installazione Plugin: %s', SP_TXT_DOM ),
    /* translators: %s: plugin name. */
    'updating'                        => __( 'Aggiornamento Plugin: %s', SP_TXT_DOM ),
    'oops'                            => __( 'Qualcosa è andato storto con le API del plugin', SP_TXT_DOM ),
    'notice_can_install_required'     => _n_noop(
        /* translators: 1: plugin name(s). */
        SP_NAME.' richiede il seguente plugin: %1$s.',
        SP_NAME.' richiede i seguenti plugins: %1$s.',
        SP_TXT_DOM
    ),
    'notice_can_install_recommended'  => _n_noop(
        /* translators: 1: plugin name(s). */
        SP_NAME.' raccomanda il seguente plugin: %1$s.',
        SP_NAME.' raccomanda i seguenti plugins: %1$s.',
        SP_TXT_DOM
    ),
    'notice_ask_to_update'            => _n_noop(
        /* translators: 1: plugin name(s). */
        'Il seguente plugin deve essere aggiornato per garantire la piena compatibilità con '.SP_NAME.': %1$s.',
        'I seguenti plugins devono essere aggiornati per garantire la piena compatibilità con '.SP_NAME.': %1$s.',
        SP_TXT_DOM
    ),
    'notice_ask_to_update_maybe'      => _n_noop(
        /* translators: 1: plugin name(s). */
        'Un aggiornamento è disponibile per: %1$s.',
        'Un aggiornamento è disponibile per i seguenti plugins: %1$s.',
        SP_TXT_DOM
    ),
    'notice_can_activate_required'    => _n_noop(
        /* translators: 1: plugin name(s). */
        'Il seguente plugin richiesto è inattivo: %1$s.',
        'I seguenti plugin richiesti sono inattivi: %1$s.',
        SP_TXT_DOM
    ),
    'notice_can_activate_recommended' => _n_noop(
        /* translators: 1: plugin name(s). */
        'Il seguente plugin raccomandato è inattivo: %1$s.',
        'I seguenti plugin raccomandati sono inattivi: %1$s.',
        SP_TXT_DOM
    ),
    'install_link'                    => _n_noop(
        'Installa il plugin',
        'Installa i plugins',
        SP_TXT_DOM
    ),
    'update_link' 					  => _n_noop(
        'Aggiorna il plugin',
        'Aggiorna i plugins',
        SP_TXT_DOM
    ),
    'activate_link'                   => _n_noop(
        'Attiva il plugin',
        'Attiva i plugins',
        SP_TXT_DOM
    ),
    'return'                          => __( 'Torna all’installazione dei plugin richiesti', SP_TXT_DOM ),
    'plugin_activated'                => __( 'Plugin attivato con successo', SP_TXT_DOM ),
    'activated_successfully'          => __( 'Il seguente plugin è stato attivato con successo:', SP_TXT_DOM ),
    /* translators: 1: plugin name. */
    'plugin_already_active'           => __( 'Nessuna azione eseguita. Il plugin %1$s è già attivato.', SP_TXT_DOM ),
    /* translators: 1: plugin name. */
    'plugin_needs_higher_version'     => __( 'Plugin non attivato. Una versione maggiore di %s è richiesta per '.SP_NAME.'. Per favore aggiorna il plugin.', SP_TXT_DOM ),
    /* translators: 1: dashboard link. */
    'complete'                        => __( 'Tutti i plugin sono stati installati e attivati con successo. %1$s', SP_TXT_DOM ),
    'dismiss'                         => __( 'Chiudi la notifica', SP_TXT_DOM ),
    'notice_cannot_install_activate'  => __( 'Ci sono uno o più plugin richiesti o consigliati da installare, aggiornare o attivare', SP_TXT_DOM ),
    'contact_admin'                   => __( 'Per favore contatta un amministratore di questo sito per richiedere aiuto', SP_TXT_DOM ),

    'nag_type'                        => '',
    ),
);

tgmpa( $plugins, $config );