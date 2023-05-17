<?php
/**
* classe per gestione ed estensione REST API di Wordpress
* Aggiunta di endpoint per visualizzare i dati degli operatori
**/

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Rest_Api{

    public function __construct(){

        $this->utility = new Area_Riservata_Utility();
        
        add_action( 'rest_api_init', array($this, 'operatoriJsonEndpoint'));

    }

    public function operatoriJsonEndpoint(){
        register_rest_route('dati-op/v1', 'operatori', array(
            'methods' => WP_REST_SERVER::READABLE,
            'callback' => [$this, 'operatoriDataJson'],
            'permission_callback' => '__return_true'
        ));
    }

    public function operatoriDataJson(){
        $operatori = $this->utility->get_array_operatori();
        $operatoriJson = json_encode($operatori, JSON_INVALID_UTF8_IGNORE);
        return $operatori;
    }


}