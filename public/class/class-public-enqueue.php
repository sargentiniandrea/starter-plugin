<?php 

/*
* Caricamento e registrazione stili e script per area PUBLIC
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Public_Enqueue {


	public function __construct() {
		
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_styles'), 999 );
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts'), 999 );
        add_action( 'wp_enqueue_scripts', array($this, 'render_scripts_and_styles_shortcodes'), 999 );

		add_action( 'wp_head', array($this, 'custom_css_ar_head'), 999 );

	}

	/**
	 * Registrazione stile per area public.
	 */
	public function enqueue_styles() {

		// Main custom css
		wp_enqueue_style('main_public_css', NP_PLUG_URL . 'public/css/main-public.css', array(), NP_VERSION, 'all');

		
		// Da caricare solo se presenti i corrispettivi shortcodes

		// Area riservata css
		wp_register_style('area_utenti_css', NP_PLUG_URL . 'public/css/area-utenti.css', array(), NP_VERSION, 'all');
		// Tabella orari css
		wp_register_style('tabella_orari_css', NP_PLUG_URL . 'public/css/tabella-orari.css', array(), NP_VERSION, 'all');
		// Lista operatori css
		wp_register_style('lista_operatori_css', NP_PLUG_URL . 'public/css/lista-operatori.css', array(), NP_VERSION, 'all');
		// Pagina operatore css
		wp_register_style('pagina_operatore_css', NP_PLUG_URL . 'public/css/pagina-operatore.css', array(), NP_VERSION, 'all');

		// Css scaricabile del plugin Profile Builder per velocizzare il caricamento
		wp_register_style('form_pb_css', NP_PLUG_URL . 'includes/lib/files/form-pb.css', array(), NP_VERSION, 'all');

	}

	/**
	 * Registrazione script per area public.
	 */
	public function enqueue_scripts() {

		// Script per shortcodes
		wp_register_script('area_riservata_js', NP_PLUG_URL . 'public/js/area-riservata.js', array(), NP_VERSION, true );
		wp_register_script('tabela_orari_js', NP_PLUG_URL . 'public/js/tabella-orari.js', array(), NP_VERSION, true );	
		wp_register_script('lista_op_js', NP_PLUG_URL . 'public/js/lista-op.js', array(), NP_VERSION, true);
		wp_add_inline_script( 'lista_op_js', 'const OPT_LISTA_OP = ' . json_encode( array(
			'showSearchBar' => get_option('search_lista_op'),
			'showToggleBtn' => get_option('toggle_btn_lista_op'),
			'addItemOp' => get_option('add_item_operatori'),
			'getShowItem' => get_option('show_item_operatori'),
		) ), 'before' );

		// Main public js
		wp_enqueue_script('main_custom_js', NP_PLUG_URL . 'public/js/main.js', array(), NP_VERSION, true );

	}

	/**
	 * Registrazione script e style per shortcodes.
	 */
	public function render_scripts_and_styles_shortcodes() {

		$shortPaginaOp = get_option('shortcode_single_op');
		$shortPaginaOp = substr($shortPaginaOp, 0, strrpos($shortPaginaOp, ' '));
		$shortPaginaOp = str_replace(array( '[', ']' ), '', $shortPaginaOp);

        global $post;
        if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'wppb-edit-profile') ) {
			wp_enqueue_style( 'area_utenti_css');
			wp_enqueue_style( 'form_pb_css');
            wp_enqueue_script( 'area_riservata_js');
        }
        if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'wppb-register') ) {
			wp_enqueue_style( 'area_utenti_css');
			wp_enqueue_style( 'form_pb_css');
            wp_enqueue_script( 'area_riservata_js');
        }
		if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'wppb-login') ) {
			wp_enqueue_style( 'area_utenti_css');
			wp_enqueue_style( 'form_pb_css');
        }
		if( is_a( $post, 'WP_Post' ) && (has_shortcode( $post->post_content, 'tabella_orari') || has_shortcode( $post->post_content, $shortPaginaOp)) ) {
			wp_enqueue_style( 'tabella_orari_css');
            wp_enqueue_script( 'tabela_orari_js');
        }
        if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'lista_operatori') ) {
			wp_enqueue_style( 'lista_operatori_css');
            wp_enqueue_script( 'lista_op_js');
        }
		if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, $shortPaginaOp) ) {
			wp_enqueue_style( 'pagina_operatore_css');
			wp_enqueue_script( 'tabela_orari_js');
        }


	}

	public function custom_css_ar_head(){
		if(get_option('editor-css-ar')){
			echo '<style>'.get_option('editor-css-ar').'</style>';
		}
	}

}