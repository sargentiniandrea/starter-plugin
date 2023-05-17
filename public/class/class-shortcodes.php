<?php 

/*
* Registrazione shortcodes
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Shortcodes {

    private $utility;

	public function __construct() {

        $this->utility = new Area_Riservata_Utility();

        // Tabella orari
        add_shortcode( 'tabella_orari', array($this, 'shortcodeTabellaOrari') );
        add_shortcode( 'tabella_orari_singolo', array($this, 'shortcodeTabellaOrariSingolo') );

        // Lista operatori
        add_shortcode( 'lista_operatori', array($this, 'shortcodeListaUtenti') );

        // Campi descrizione operatori
        add_shortcode( 'descrizioni_operatori', array($this, 'shortcodeDescrizioniUtenti') );

        // Recensioni singolo operatore
        add_shortcode( 'mostra_recensioni', array($this, 'showRecensioni') );
        add_shortcode( 'form_recensioni', array($this, 'showFormRecensioni') );

	}

    //-------------------------------


    // Shortcode Tabella Orari
    public function shortcodeTabellaOrari() {
        ob_start();
        // Template
        include NP_PLUG_PATH . 'public/shortcodes/tabella-orari/tabella-orari.php';
        return ob_get_clean();
    }

    // Shortcode Tabella Orari per singolo operatore
    public function shortcodeTabellaOrariSingolo() {
        ob_start();
        // Template
        include NP_PLUG_PATH . 'public/shortcodes/tabella-orari/tabella-orari-singolo.php';
        return ob_get_clean();
    }

    //-------------------------------


    // Shortcode lista operatori
    public function shortcodeListaUtenti($atts) {
        $atts = shortcode_atts( [
            "totale" => '-1',
            "col" => '4',
            "gap" => '1',
            "class" => '',
          ], $atts );
        ob_start();
        // Template
        include NP_PLUG_PATH . 'public/shortcodes/lista-operatori/lista-operatori.php';
        return ob_get_clean();
    }

    //-------------------------------


    // Shortcode descrizioni Utenti
    public function shortcodeDescrizioniUtenti($attr) {
        ob_start();
        // Template
        include NP_PLUG_PATH . 'public/shortcodes/campi-single-operatore/descrizioni-utente.php';
        return ob_get_clean();
    }

    //-------------------------------


    // Shortcode mostra recensioni per pagina singolo operatore
    public function showRecensioni() {
        ob_start();
        $meta = get_post_meta(get_the_ID());
        $srThemeId = get_option('sr_theme_id') ? 'theme="'.get_option('sr_theme_id').'"' : '';
        $srFormId = get_option('sr_form_id') ? 'theme="'.get_option('sr_form_id').'"' : '';
        if(isset($meta['user_id'][0]) && !empty($meta['user_id'][0])){
            $user_id = $meta['user_id'][0];
            echo do_shortcode('[site_reviews '.$srThemeId.' '.$srFormId.' assigned_users="'.$user_id.'"]');
        }
        return ob_get_clean();
    }


    // Shortcode form recensioni per pagina singolo operatore
    public function showFormRecensioni() {
        ob_start();
        $meta = get_post_meta(get_the_ID());
        $srThemeId = get_option('sr_theme_id') ? 'theme="'.get_option('sr_theme_id').'"' : '';
        $srFormId = get_option('sr_form_id') ? 'theme="'.get_option('sr_form_id').'"' : '';
        if(isset($meta['user_id'][0]) && !empty($meta['user_id'][0])){
            $user_id = $meta['user_id'][0];
            echo do_shortcode('[site_reviews_form '.$srThemeId.' '.$srFormId.' assigned_users="'.$user_id.'"]');
        }
        return ob_get_clean();
    }


}