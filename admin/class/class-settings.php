<?php
/**
* Classe per gestione pagine impostazioni
* nell'area admin del sito.
**/

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Settings{

    public function __construct(){
        
        // Impostazioni generali area riservata
        add_action( 'admin_menu', array($this, 'admin_menu_setting_helper_area_ris'));

        // Impostazioni editor box lista operatori
        add_action( 'admin_menu', array($this, 'add_submenu_page_area_riservata'));
        add_action( 'admin_init', array($this, 'add_setting_editor_lista_op_cb'));

        // Impostazioni custom css
        add_action( 'admin_menu', array($this, 'add_submenu_page_area_riservata_css'));
        add_action( 'admin_init', array($this, 'add_setting_custom_css_ar_cb'));

    }


    /*
     * Impostazioni generali area riservata
     */

    public function admin_menu_setting_helper_area_ris(){
        require_once NP_PLUG_PATH . 'vendor/class-boo-settings-helper.php';
        $array_data_setting_helper             = array();
        $array_data_setting_helper['tabs']     = true;
        $array_data_setting_helper['menu']     = array(
				'page_title' => __( 'Impostazioni per Area Riservata', NP_SLUG ),
				'menu_title' => __( 'Area Riservata', NP_SLUG ),
				'capability' => 'manage_options',
				'slug'       => NP_SLUG,
				'icon'       => 'dashicons-groups',
				'position'   => 4,
        );
        $array_data_setting_helper['sections'] = array(
            array(
                'id'    => 'impostazioni_generali',
                'title' => __( 'Impostazioni generali', NP_SLUG ),
                'desc'  => __( 'Impostazioni generali per la configurazione dell\'area riservata', NP_SLUG ),
            ),
            array(
                'id'    => 'tabella_orari',
                'title' => __( 'Tabella orari', NP_SLUG ),
                'desc'  => __( 'Impostazioni per tabella orari', NP_SLUG )
            ),
            array(
                'id'    => 'lista_operatori',
                'title' => __( 'Lista operatori', NP_SLUG ),
                'desc'  => __( 'Impostazioni per la lista degli operatori', NP_SLUG )
            ),
            array(
                'id'    => 'pagina_operatore',
                'title' => __( 'Pagina operatore', NP_SLUG ),
                'desc'  => __( 'Impostazioni per la pagina del singolo operatore', NP_SLUG )
            ),
            array(
                'id'    => 'setting_colori',
                'title' => __( 'Impostazione colori', NP_SLUG ),
                'desc'  => __( 'Impostazioni per colori globali', NP_SLUG )
            ),
            array(
                'id'    => 'setting_aggiornamenti',
                'title' => __( 'Aggiornamenti', NP_SLUG ),
                'desc'  => __( 'Collegamento per aggiornamenti', NP_SLUG )
            ),
        );
        $SelPageTemplates = array_keys(get_page_templates());;
        // var_dump($SelPageTemplates); die;
        $array_data_setting_helper['fields']   = array(

            // Impostazioni generali
            'impostazioni_generali' => array(
                array(
                    'id'                => 'shortcode_single_op',
                    'label'             => __( 'Shortcode template per pagina singolo operatore', NP_SLUG ),
                    'desc'              => __( 'Inserire qui lo shortcode relativo al template del singolo operatore.<br>
                    <strong>Nello shortcode non devono essere presenti doppi apici ("). Se sono presenti sostituirli con il singolo apice (\').</strong><br>
                    <strong>P.S.</strong> Eventuale cambio dello shortcode non avrà effetto sulle pagine create precedentemente alla modifica.', NP_SLUG ),
                    'type'              => 'text',
                    'sanitize_callback' => 'htmlspecialchars'
                ),
                array(
                    'id'    => 'html_hr_orari',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'      => 'pagina_accedi',
                    'label'   => __( 'Pagina di login', NP_SLUG ),
                    'desc'    => __( 'Selezionare la pagina di accesso per gli operatori', NP_SLUG ),
                    'type'    => 'pages',
                ),
                array(
                    'id'      => 'pagina_modifica',
                    'label'   => __( 'Pagina di modifica', NP_SLUG ),
                    'desc'    => __( 'Selezionare la pagina di modifica degli operatori', NP_SLUG ),
                    'type'    => 'pages',
                ),
                array(
                    'id'      => 'pagina_registrazione',
                    'label'   => __( 'Pagina di registrazione', NP_SLUG ),
                    'desc'    => __( 'Selezionare la pagina di registrazione degli operatori', NP_SLUG ),
                    'type'    => 'pages',
                ),
                array(
                    'id'    => 'html_hr_orari_0',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'      => 'eliminazione_operatore',
                    'label'   => __( 'Cosa fare quando viene eliminato un operatore?', NP_SLUG ),
                    'desc'    => __( 'Selezionare quale azione eseguire per quanto riguarda la <strong>pagina</strong> e le <strong>recensioni</strong> dell\'operatore nel momento in cui viene eliminato.', NP_SLUG ),
                    'type'    => 'select',
                    'default' => 'cestina',
                    'options' => array(
                        'cestina' => 'Sposta nel cestino',
                        'elimina' => 'Elimina direttamente',
                        'bozza' => 'Metti in bozza'
                    ),
                ),
                array(
                    'id'    => 'hr_email',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'                => 'email_mittente',
                    'label'             => __( 'Indirizzo Email mittente', NP_SLUG ),
                    'desc'              => __( 'Inserire l\'indirizzo email da utilizzare come mittente per le email di approvazione e notifiche.', NP_SLUG ),
                    'type'              => 'text',
                    'sanitize_callback' => ''
                ),
                array(
                    'id'    => 'html_hr_orari_10',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'    => 'btn_json_pb',
                    'label' => 'Scarica i settaggi di Profile Builder',
                    'desc'  => '<a href="' . NP_PLUG_URL. 'includes/lib/files/PB_set_export.json" download class="btn-setting-as">Scarica Settaggi</a><br><br>
                                Scarica un file Json con i settaggi di base per Profile Builder. Utilizza l\'estensione "Importazione ed esportazione" per importarlo.',
                    'type'  => 'html'
                ),
                array(
                    'id'    => 'html_hr_orari_11',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'    => 'btn_json_trad_pb',
                    'label' => 'Scarica le traduzioni di Profile Builder',
                    'desc'  => '<a href="' . NP_PLUG_URL. 'includes/lib/files/PB_strings_export.json" download class="btn-setting-as">Scarica Traduzioni</a><br><br>
                                Scarica un file Json con le traduzioni per Profile Builder.<br>
                                <strong>Vai su <a href="/wp-admin/admin.php?page=pb-labels-edit">Profile Builder > Modifica etichette</a>, clicca il pulsante blu "Rescan" sulla colonna a destra e importare il file tramite i pulsanti in basso.</strong>',
                    'type'  => 'html'
                ),
                array(
                    'id'    => 'html_hr_orari_12',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
            ),

            // Tabella orari
            'tabella_orari' => array(
                array(
                    'id'                => 'txt_giorno_riposo',
                    'label'             => __( 'Testo per giorno di riposo', NP_SLUG ),
                    'desc'              => __( 'Indicare il testo da mostrare negli spazi degli giorni di riposo.<br>In caso di campo vuoto verrà visualizzato "-".', NP_SLUG ),
                    'type'              => 'text',
                    'default'           => '',
                ),
                array(
                    'id'      => 'link_pagina_tab_orari',
                    'label'   => __( 'Link a pagina operatore', NP_SLUG ),
                    'desc'    => __( 'Mostrare nome operatore come link alla relativa pagina nella tabella orari?', NP_SLUG ),
                    'type'    => 'select',
                    'default' => 'si',
                    'options' => array(
                        'si' => 'Si',
                        'no' => 'No'
                    ),
                    'size'    => 'small'
                ),
                array(
                    'id'    => 'html_hr_orari_1',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'    => 'html_tab_orari',
                    'label' => __( 'Shortcodes', NP_SLUG ),
                    'desc'  => '<h3 class="tit-shortcode"><strong>[tabella_orari]</strong></h3>
                                Shortcode per visualizzare una tabella globale con nome, link e orari di tutti gli operatori.<br><br>
                                <h3 class="tit-shortcode"><strong>[tabella_orari_singolo]</strong></h3>
                                Shortcode per visualizzare una tabella con gli orari di un singolo operatore.<br>
                                Da inserire dentro il template del singolo operatore, prende in automatico l\'utente collegato alla pagina.',
                    'type'  => 'html'
                ),
            ),

            // Lista operatori
            'lista_operatori' => array(
                array(
                    'id'      => 'order_by_lista_op',
                    'label'   => __( 'Ordina per', NP_SLUG ),
                    'desc'    => __( 'Selezionare per quale parametro ordinare i box degli operatori.<br>
                                    <strong>Nota:</strong> Il parametro <strong>"ID"</strong> eseguirà un ordinamento apparentemente casuale, in realtà li ordinerà per data di registrazione ma rimarrà fisso ad ogni caricamento di pagina.<br>
                                    <strong>Nota:</strong> Il parametro <strong>"Random"</strong> farà si che ad ogni caricamento della pagina genererà un ordinamento casuale e sempre diverso.', NP_SLUG ),
                    'type'    => 'select',
                    'default' => 'name',
                    'options' => array(
                        'ID' => 'ID',
                        'name' => 'Nome',
                        'rand' => 'Random'
                    ),
                    'size'    => 'small'
                ),
                array(
                    'id'      => 'order_lista_op',
                    'label'   => __( 'Ordine', NP_SLUG ),
                    'desc'    => __( 'Selezionare se ordinare i box in ordine ascendente o discendente.', NP_SLUG ),
                    'type'    => 'select',
                    'default' => 'ASC',
                    'options' => array(
                        'ASC' => 'Ascendente',
                        'DISC' => 'Discendente'
                    ),
                    'size'    => 'small'
                ),
                array(
                    'id'    => 'html_hr_lista_op_2',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'    => 'html_hr_lista_op_tit1',
                    'desc'  => '<h4 class="tit-impost-area-ris">Pulsanti toggle mostra/nascondi</h4>
                                <p class="description"><strong>Nota:</strong> Se il valore del campo <strong>"quanti operatori mostrare inizialmente"</strong> risulta <strong><u>maggiore o uguale</u></strong> al totale degli operatori impostati sullo shortcode i pulsanti non saranno visibili.</p>',
                    'type'  => 'html'
                ),
                array(
                    'id'      => 'toggle_btn_lista_op',
                    'label'   => __( 'Mostra pulsanti toggle mostra/nascondi operatori', NP_SLUG ),
                    'desc'    => __( 'Mostrare i pulsanti per mostrare/nascondere i box degli operatori?', NP_SLUG ),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'si' => 'Si',
                        'no' => 'No'
                    ),
                    'size'    => 'small'
                ),
                array(
                    'id'          => 'show_item_operatori',
                    'label'       => __( 'Quanti operatori mostrare inizialmente', NP_SLUG ),
                    'desc'    => __( 'Inserire quanti box dovranno essere visualizzati all\'inizio.', NP_SLUG ),
                    'options'     => array(
                        'min'  => 1,
                        'max'  => 500,
                        'step' => '1',
                    ),
                    'type'        => 'number',
                    'default'     => 8,
                    'size'    => 'small'
                ),
                array(
                    'id'          => 'add_item_operatori',
                    'label'       => __( 'Quanti operatori aggiuntivi mostrare al click', NP_SLUG ),
                    'desc'    => __( 'Inserire quanti box aggiungere al click del pulsante "mostra di più".', NP_SLUG ),
                    'options'     => array(
                        'min'  => 1,
                        'max'  => 500,
                        'step' => '1',
                    ),
                    'type'        => 'number',
                    'default'     => 4,
                    'size'    => 'small'
                ),
                array(
                    'id'    => 'html_hr_lista_op_3',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'    => 'html_hr_lista_op_tit2',
                    'desc'  => '<h4 class="tit-impost-area-ris">Barra di ricerca</h4>',
                    'type'  => 'html'
                ),
                array(
                    'id'      => 'search_lista_op',
                    'label'   => __( 'Mostra barra di ricerca', NP_SLUG ),
                    'desc'    => __( 'Mostrare la barra di ricerca sopra la lista globale degli operatori?', NP_SLUG ),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'si' => 'Si',
                        'no' => 'No'
                    ),
                    'size'    => 'small'
                ),
                array(
                    'id'    => 'html_hr_lista_op_4',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'    => 'html_lista_op',
                    'label' => __( 'Shortcodes', NP_SLUG ),
                    'desc'  => '<h3 class="tit-shortcode"><strong>[lista_operatori]</strong><br></h3>
                                Shortcode per visualizzare una lista degli operatori registrati.<br><br>E\' possibile inserire alcuni parametri opzionali:<br><br>
                                <h3 class="tit-shortcode"><strong>[lista_operatori totale="" col="" gap="" class=""]</strong></h3>
                                <strong>totale</strong> : inserire un numero per indicare il numero di operatori da visualizzare.<br><u>Valore di default:</u> -1. Con questo valore vengono visualizzati tutti.<br><br>
                                <strong>col</strong> : inserire un numero da 1 a 8 per cambiare il numero di colonne (valido per visualizzazione da desktop).<br><u>Valore di default:</u> 4.<br><br>
                                <strong>gap</strong> : inserire un numero compreso tra 0 e 4 con salti di 0.5 (es. 2.5) per impostare un gap in rem tra le colonne e le righe.<br><u>Valore di default:</u> 2.<br><br>
                                <strong>class</strong> : inserire una stringa per aggiungere una classe personalizzata al container<br><u>Valore di default:</u> \'\'.',
                    'type'  => 'html'
                ),
            ),

            // Pagina operatore
            'pagina_operatore' => array(
                array(
                    'id'                => 'suffisso_pagina',
                    'label'             => __( 'Prefisso pagina', NP_SLUG ),
                    'desc'              => __( 'Indicare il prefisso da inserire prima del nome dell\'operatore sul titolo della pagina.<br>Lasciare vuoto per non inserire un prefisso.', NP_SLUG ),
                    'type'              => 'text',
                    'default'           => 'Cartomante',
                ),
                array(
                    'id'    => 'html_hr_lista_op_sfx',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'                => 'titolo_chi_sono',
                    'label'             => __( 'Titolo sezione "Chi sono"', NP_SLUG ),
                    'desc'              => __( 'Indicare il titolo da inserire nella sezione "Chi sono"', NP_SLUG ),
                    'type'              => 'text',
                    'default'           => 'Chi sono',
                ),
                array(
                    'id'                => 'titolo_esperienza',
                    'label'             => __( 'Titolo sezione "Esperienza"', NP_SLUG ),
                    'desc'              => __( 'Indicare il titolo da inserire nella sezione "Esperienza"', NP_SLUG ),
                    'type'              => 'text',
                    'default'           => 'Esperienza',
                ),
                array(
                    'id'                => 'titolo_consulto',
                    'label'             => __( 'Titolo sezione "Consulto"', NP_SLUG ),
                    'desc'              => __( 'Indicare il titolo da inserire nella sezione "Consulto"', NP_SLUG ),
                    'type'              => 'text',
                    'default'           => 'Consulto',
                ),
                array(
                    'id'      => 'tag_titoli_pagina_op',
                    'label'   => __( 'Tag dei titoli', NP_SLUG ),
                    'desc'    => __( 'Selezionare in quale tag titolo devono essere inseriti i titoli', NP_SLUG ),
                    'type'    => 'select',
                    'default' => 'h4',
                    'options' => array(
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',
                    ),
                    'size'    => 'small'
                ),
                array(
                    'id'    => 'html_hr_lista_op_5',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'          => 'sr_form_id',
                    'label'       => __( 'ID Form Site Reviews', NP_SLUG ),
                    'desc'    => __( 'Inserire l\'ID del form di Site Reviews per far visualizzare i campi corretti.', NP_SLUG ),
                    'type'        => 'text',
                ),
                array(
                    'id'          => 'sr_theme_id',
                    'label'       => __( 'ID Tema Site Reviews', NP_SLUG ),
                    'desc'    => __( 'Inserire l\'ID del tema di Site Reviews per ereditare lo stile anche nella pagina degli operatori.', NP_SLUG ),
                    'type'        => 'text',
                ),
                array(
                    'id'    => 'html_hr_lista_op_99',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'    => 'html_pagina_op',
                    'label' => __( 'Shortcodes', NP_SLUG ),
                    'desc'  => '<h3 class="tit-shortcode"><strong>[descrizioni_operatori]</strong></h3>
                                Shortcode da inserire all\'interno del template del singolo operatore.<br>Di base restituisce una struttura predefinita con tutti e 3 i campi, se presenti, con titolo e contenuto della descrizione uno dopo l\'altro.<br><br>
                                E\' possibile anche inserire alcuni parametri per decidere quale campo visualizzare e scegliere tra titolo e contenuto. Questi parametri possono essere utilizzati per creare strutture più complesse,
                                ad esempio inserendo più shortcode con parametri diversi dentro lo stesso template.<br><br>
                                <u>Nel caso in cui un campo non fosse presente non viene visualizzato.</u><br><br>
                                Parametri disponibili:<br><br>
                                <h3 class="tit-shortcode"><strong>[descrizioni_operatori campo="" tipo=""]</strong></h3>
                                <strong>campo</strong> : si può inserire un valore tra "<strong>chi_sono</strong>", "<strong>esperienza</strong>" e "<strong>consulto</strong>" per far visualizzare solo uno dei 3 campi.<br>Se non si definisce anche il parametro "<strong>tipo</strong>" di default mostrerà sia titolo che campo uno sotto l\'altro.<br><u>Valore di default:</u> \'\'.<br><br>
                                <strong>tipo</strong> : si può inserire un valore tra "<strong>titolo</strong>" e "<strong>contenuto</strong>" per decidere se far visualizzare titolo o contenuto.<br>Questo parametro si può utilizzare anche senza il parametro "<strong>campo</strong>", in questo caso lo shortcode restituirà tutti e 3 i campi ma verrà visualizzato appunto o solo i titoli o solo i contenuti.<br><u>Valore di default:</u> \'\'.
                                <br><br><br><hr style="border:0px; border-top:1px solid lightgray"><br><br>
                                <h3 class="tit-shortcode"><strong>[mostra_recensioni]</strong></h3>
                                Shortcode da inserire all\'interno della pagina del singolo operatore.<br>
                                Mostra tutte le recensioni, prende in automatico l\'id dell\'utente dalla pagina.<br><br><br>
                                <h3 class="tit-shortcode"><strong>[form_recensioni]</strong></h3>
                                Shortcode da inserire all\'interno della pagina del singolo operatore.<br>
                                Mostra il form per scrivere la recensione. Il form legge l\'id dell\'operatore collegato alla pagina e lo collega in automatico.',
                    'type'  => 'html'
                ),
            ),

            // Impostazione colori
            'setting_colori' => array(
                array(
                    'id'    => 'colore_primario',
                    'label' => __( 'Colore primario', NP_SLUG ),
                    'desc'    => __( 'Default: #696969', NP_SLUG ),
                    'type'  => 'color',
                    'default' => '#696969',
                ),
                array(
                    'id'    => 'colore_secondario',
                    'label' => __( 'Colore secondario', NP_SLUG ),
                    'desc'    => __( 'Default: #f0f0f0', NP_SLUG ),
                    'type'  => 'color',
                    'default' => '#f0f0f0',
                ),
                array(
                    'id'    => 'html_hr_colors',
                    'desc'  => '<hr class="hr-impost-area-ris">',
                    'type'  => 'html'
                ),
                array(
                    'id'    => 'colore_primario_ar',
                    'label' => __( 'Colore primario area riservata', NP_SLUG ),
                    'desc'    => __( 'Default: #f9c268', NP_SLUG ),
                    'type'  => 'color',
                    'default' => '#f9c268',
                ),
                array(
                    'id'    => 'colore_secondario_ar',
                    'label' => __( 'Colore primario area riservata', NP_SLUG ),
                    'desc'    => __( 'Default: #ffefd8', NP_SLUG ),
                    'type'  => 'color',
                    'default' => '#ffefd8',
                ),
            ),
            'setting_aggiornamenti' => array(
                array(
                    'id'    => 'token_updates',
                    'label' => __( 'Token aggiornamenti', NP_SLUG ),
                    'desc'    => __( 'Inserisci il token di collegamento per gli aggiornamenti', NP_SLUG ),
                    'type'  => 'text'
                ),
            ),
        );
        $Boo_Settings_Helper = new Boo_Settings_Helper( $array_data_setting_helper );
    }


    /*
     * Impostazioni editor box lista operatori
     */

    // Aggiunta pagina menu
    public function add_submenu_page_area_riservata() {
        add_submenu_page( NP_SLUG, 'Editor template', 'Editor template lista operatori', 'manage_options', 'editor-template-lista-op', array($this, 'editor_template_lista_operatori_settings') );
    }

    // Aggiunta settaggi
    public function add_setting_editor_lista_op_cb(){

        // Sezioni
        add_settings_section(
            'section_editor_lista_op_id',
            'Editor per template lista operatori',
            array($this, 'add_setting_section_editor_lista_op_cb'),
            'editor_lista_op_page'
        );

        // Campi
        add_settings_field(
            'col_lista_op_id',
            'Anteprima colonne',
            array($this, 'add_setting_col_editor_lista_op_cb'),
            'editor_lista_op_page',
            'section_editor_lista_op_id',
            array(
                'name' => 'editor-template-lista-op-col',
                'value' => get_option('editor-template-lista-op-col'),
                'options' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                )
            )
        );
        add_settings_field(
            'gap_lista_op_id',
            'Anteprima gap',
            array($this, 'add_setting_gap_editor_lista_op_cb'),
            'editor_lista_op_page',
            'section_editor_lista_op_id',
            array(
                'name' => 'editor-template-lista-op-gap',
                'value' => get_option('editor-template-lista-op-gap'),
                'options' => array(
                    '0' => '0',
                    '0.5' => '0.5',
                    '1' => '1',
                    '1.5' => '1.5',
                    '2' => '2',
                    '2.5' => '2.5',
                    '3' => '3',
                    '3.5' => '3.5',
                    '4' => '4',
                )
            )
        );
        add_settings_field(
            'html_lista_op_id',
            'Template HTML',
            array($this, 'add_setting_html_editor_lista_op_cb'),
            'editor_lista_op_page',
            'section_editor_lista_op_id'
        );
        add_settings_field(
            'css_lista_op_id',
            'Stile CSS',
            array($this, 'add_setting_css_editor_lista_op_cb'),
            'editor_lista_op_page',
            'section_editor_lista_op_id'
        );

        // Registrazione campi
        register_setting(
            'editor_lista_op_page_group',
            'editor-template-lista-op-col',
            array()
        );

        register_setting(
            'editor_lista_op_page_group',
            'editor-template-lista-op-gap',
            array()
        );

        register_setting(
            'editor_lista_op_page_group',
            'editor-template-lista-op-html',
            array()
        );

        register_setting(
            'editor_lista_op_page_group',
            'editor-template-lista-op-css',
            array()
        );
    }


    // Funzioni di callback

    public function add_setting_shortcode_single_op(){ ?>
        <input type="text" name="shortcode_single_op" id="shortcode_single_op" value="<?php echo htmlspecialchars(get_option('shortcode_single_op')) ?>">
    <?php }

    // Descrizione sezione
    public function add_setting_section_editor_lista_op_cb(){
        echo 'In questa sezione si può costruire il template per il singolo box visibile nella lista operatori. Le modifiche sono visibili in tempo reale nell\'anteprima sotto.<br><br>
        I font e il colore del testo, se non definito nel css, saranno diversi tra preview e visualizzazione effettiva perchè il file css del tema è visibile solo nel front-end.<br>
        Se si vuole creare una preview più fedele possibile dare una regola font-family alla classe .box-op con il font scelto nel sito e impostare i colori del testo altrimenti andranno sovrascritti dal tema.<br>
        <p><u>Il template è avvolto di default da un "div" con classe "box-op". Questa classe si può stilizzare nell\'editor css.</u></p>
        <p><strong>Tag disponibili:</strong> {{link_pagina_op}} {{nome_op}}</p>';
    }


    // Textarea html editor
    public function add_setting_html_editor_lista_op_cb(){ ?>
        <p>&lt;div class="box-op"&gt;</p>
        <textarea name="editor-template-lista-op-html" rows="30" cols="70" id="editor-template-lista-op-html"><?php echo get_option('editor-template-lista-op-html'); ?></textarea>
        <p>&lt;/div&gt;</p>
    <?php }


    // Textarea css editor
    public function add_setting_css_editor_lista_op_cb(){ ?>
        <textarea name="editor-template-lista-op-css" rows="30" cols="70" id="editor-template-lista-op-css"><?php echo get_option('editor-template-lista-op-css'); ?></textarea>
    <?php }


    // Campo select per selezione colonne
    public function add_setting_col_editor_lista_op_cb($args){
        $options = (isset($args['options']) && is_array($args['options']) ? $args['options'] : array());
        $value = (isset($args['value'])) ? $args['value'] : '';?>
        <select name="editor-template-lista-op-col" id="editor-template-lista-op-col">
            <?php foreach ($options as $key => $valore) { ?>
                <option <?php selected($value, $key) ?> valore="<?php echo $key ?>"><?php echo $valore ?></option>
            <?php } ?>
        </select>
        <span>Selezionare quante colonne visualizzare. La selezione delle colonne con questo select <strong>è solo per l'anteprima.</strong> Le colonne effettive vanno impostate come parametro sullo shortcode.</span>
    <?php }


    // Campo select per selezione gap
    public function add_setting_gap_editor_lista_op_cb($args){
        $options = (isset($args['options']) && is_array($args['options']) ? $args['options'] : array());
        $value = (isset($args['value'])) ? $args['value'] : '';?>
        <select name="editor-template-lista-op-gap" id="editor-template-lista-op-gap">
            <?php foreach ($options as $key => $valore) { ?>
                <option <?php selected($value, $key) ?> valore="<?php echo $key ?>"><?php echo $valore ?></option>
            <?php } ?>
        </select>
        <span><strong>rem</strong>. Selezionare quanto gap impostare tra i box. La selezione del gap con questo select <strong>è solo per l'anteprima.</strong> Il gap effettivo va impostato come parametro sullo shortcode.</span>
    <?php }


    // File template per pagina impostazioni Editor box lista operatori
    public function editor_template_lista_operatori_settings(){
        include NP_PLUG_PATH . 'admin/template/admin-setting-editor-lista-op.php';
    }


    /*
     * Impostazioni pagina custom CSS
     */

    // Aggiunta pagina menu
    public function add_submenu_page_area_riservata_css() {
        add_submenu_page( NP_SLUG, 'Custom CSS Area Riservata', 'Custom CSS', 'manage_options', 'custom-css-area-riservata', array($this, 'custom_css_ar_settings') );
    }

    // Aggiunta settaggi
    public function add_setting_custom_css_ar_cb(){

        // Sezioni
        add_settings_section(
            'section_custom_css_ar_id',
            'Editor per CSS personalizzato',
            array($this, 'add_setting_section_custom_css_ar_cb'),
            'custom_css_ar_page'
        );

        // Campi
        add_settings_field(
            'css_lista_op_id',
            'Stile CSS',
            array($this, 'add_setting_css_editor_ar_cb'),
            'custom_css_ar_page',
            'section_custom_css_ar_id'
        );

        // Registrazione campi
        register_setting(
            'editor_css_ar_page_group',
            'editor-css-ar',
            array()
        );
    }

    // Descrizione sezione
    public function add_setting_section_custom_css_ar_cb(){
        echo 'In questa sezione si può inserire CSS personalizzato che sarà caricato solo nelle pagine dell\'area riservata di Profile Builder o dove presenti uno qualsiasi degli shortcode di questo plugin.';
    }

    // Textarea css editor
    public function add_setting_css_editor_ar_cb(){ ?>
        <textarea name="editor-css-ar" rows="30" cols="70" id="editor-css-ar"><?php echo get_option('editor-css-ar'); ?></textarea>
    <?php }

    // File template per pagina impostazioni Custom CSS
    public function custom_css_ar_settings(){
        include NP_PLUG_PATH . 'admin/template/admin-setting-custom-css-ar.php';
    }
}