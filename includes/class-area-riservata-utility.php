<?php 

/*
 * Desctiption: Classe per funzioni di utility generale
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Utility {

    public function __construct(){

        add_action('pre_user_query', array($this, 'random_user_query') );
        add_action('init', array($this, 'print_user_classes'));
        
    }


    /*
     * Funzione che restituisce i post che hanno una
     * specifica associazione meta_key/meta_value
     */
    public static function get_post_by_meta( $args = array() ){
        $args = ( object )wp_parse_args( $args );
        $args = array(
            'meta_query'        => array(
                array(
                    'key'       => $args->meta_key,
                    'value'     => $args->meta_value
                )
            ),
            'post_type'         => 'page',
            'posts_per_page'    => '1'
        );
        $posts = get_posts( $args );
        if ( ! $posts || is_wp_error( $posts ) ) return false;
        return $posts[0];
    }


    /*
     * Funzione che aggiunge ordinamento Random per la query get_users
     */
    public function random_user_query( $class ) {
        if( 'rand' == $class->query_vars['orderby'] )
            $class->query_orderby = str_replace( 'user_login', 'RAND()', $class->query_orderby );
        return $class;
    }


    /*
     * Funzione che inserisce nel body una classe riferita al ruolo
     * dell'utente collegato, sia nel front-end che nel back-end
     */
    public function print_user_classes() {
    if ( is_user_logged_in() ) {
        add_filter('body_class', array($this, 'class_to_body'));
        add_filter('admin_body_class', array($this, 'class_to_body_admin'));
        }
    }
    //------
    public function class_to_body($classes) {
        global $current_user;
        $user_role = array_shift($current_user->roles);
        $classes[] = $user_role.' ';
        return $classes;
    }
    //------
    public function class_to_body_admin($classes) {
        global $current_user;
        $user_role = array_shift($current_user->roles);
        $classes .= ' ' . $user_role . ' ';
        return $classes;
    }


    /*
     * Funzione che restituisce un array di oggetti contenenti Id, nome e tutti gli orari di tutti gli utenti con
     * ruolo 'operatore'. Utilizzabile per formattare tabelle o per conversioni in formato JSON.
     */
    public function get_array_operatori($riposo = '-'){
        $args = array(
            'role'    => 'operatore',
            'orderby' => 'user_nicename',
            'order'   => 'ASC'
        );
        $users = get_users( $args );
        $operatori = [];
        foreach ($users as $user) {
            $operatore = $this->get_operatore_data($user, $riposo);
            array_push($operatori, $operatore);
        }
        return $operatori;
    }


    /*
     * Funzione che restituisce un oggetto contentente id, nome e orari
     * di un utente con ruolo 'operatore'.
     */
    public function get_operatore_data($user, $riposo = '-'){
        $arrGiorni = [
            'lunedi' => 'Lunedì',
            'martedi' => 'Martedì',
            'mercoledi' => 'Mercoledì',
            'giovedi' => 'Giovedì',
            'venerdi' => 'Venerdì',
            'sabato' => 'Sabato',
            'domenica' => 'Domenica'
        ];
        $operatore = new stdClass();
        if($user instanceof WP_User){
            $user_id = $user->ID;
            $meta = get_user_meta( $user_id );
            $userName = $user->display_name;
            $tmpOp = (array) $operatore;
            $meta = get_user_meta( $user_id );
            $operatore->ID = $user_id;
            $operatore->nome = $userName;
        }
        $orari = array();
        foreach ($arrGiorni as $giorno => $giornoFormat){
            if(isset($meta["{$giorno}_blocca"][0])){
                if($meta["{$giorno}_blocca"][0] == 'Blocca'){
                    $orari[$giornoFormat] = $this->getOrariApprov($meta, $giorno, $riposo);
                } else {
                    $orari[$giornoFormat] = $this->getOrari($meta, $giorno, $riposo);
                } 
            } else {
                $orari[$giornoFormat] = $this->getOrari($meta, $giorno, $riposo);
            }
        }
        $operatore->orari = $orari;
        return $operatore;
    }


    /*
     * Funzione che restituisce un array con gli orari di un singolo giorno.
     * Relativa ai campi normali (senza approvazione)
     */
    public function getOrari($meta, $giorno, $riposo){
        $orariArr = array();

        $metaRiposo = isset($meta["{$giorno}_riposo"][0]) ? $meta["{$giorno}_riposo"][0] : '';
        $metaInizio = isset($meta["{$giorno}_inizio"][0]) ? $meta["{$giorno}_inizio"][0] : '';
        $metaFine = isset($meta["{$giorno}_fine"][0]) ? $meta["{$giorno}_fine"][0] : '';
        $metaRptCount = isset($meta["wppb_repeater_field_orario-{$giorno}_extra_groups_count"][0]) ? $meta["wppb_repeater_field_orario-{$giorno}_extra_groups_count"][0] : '0';

        if(isset($metaRiposo) && $metaRiposo == 'Si'){
            $orariArr[] = $riposo;
        } else {
            if(isset($metaInizio) && !empty($metaFine)){
                $orariArr[] = $metaInizio . ' - ' . $metaFine;
                if(isset($metaRptCount) && $metaRptCount > '0'){
                    for ($i=1; $i <= $metaRptCount; $i++) {
                        $metaInizioRpt = $meta["{$giorno}_inizio_{$i}"][0];
                        $metaFineRpt = $meta["{$giorno}_fine_{$i}"][0];
                        if(isset($metaInizioRpt) && !empty($metaFineRpt)){
                            $orariArr[] = $metaInizioRpt . ' - ' . $metaFineRpt; 
                        }
                    }
                }
            }
        }
        return $orariArr;
    }


    /*
     * Funzione che restituisce un array con gli orari di un singolo giorno.
     * Relativa ai campi che richiede approvazione di un admin
     */
    public function getOrariApprov($meta, $giorno, $riposo){
        $orariArr = array();

        $metaRiposo = isset($meta["{$giorno}_riposo_approv"][0]) ? $meta["{$giorno}_riposo_approv"][0] : '';
        $metaInizio = isset($meta["{$giorno}_inizio_approv"][0]) ? $meta["{$giorno}_inizio_approv"][0] : '';
        $metaFine = isset($meta["{$giorno}_fine_approv"][0]) ? $meta["{$giorno}_fine_approv"][0] : '';
        $metaRptCount = isset($meta["wppb_repeater_field_orario-{$giorno}-approv_extra_groups_count"][0]) ? $meta["wppb_repeater_field_orario-{$giorno}-approv_extra_groups_count"][0] : '0';

        if(isset($metaRiposo) && $metaRiposo == 'Si'){
            $orariArr[] = $riposo;
        } else {
            if(isset($metaInizio) && !empty($metaFine)){
                $orariArr[] = $metaInizio . ' - ' . $metaFine;
                if(isset($metaRptCount) && $metaRptCount > '0'){
                    for ($i=1; $i <= $metaRptCount; $i++) {
                        $metaInizioRpt = $meta["{$giorno}_inizio_approv_{$i}"][0];
                        $metaFineRpt = $meta["{$giorno}_fine_approv_{$i}"][0];
                        if(isset($metaInizioRpt) && !empty($metaFineRpt)){
                            $orariArr[] = $metaInizioRpt . ' - ' . $metaFineRpt; 
                        }
                    }
                }
            }
        }
        return $orariArr;
    }


}

