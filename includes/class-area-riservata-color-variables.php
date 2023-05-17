<?php 
/*
* Gestione variabili colore da panello opzioni del plugin
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Area_Riservata_Color_Variables {

    public function __construct() {

		// on backend area
		add_action( 'admin_head', array($this, 'settings_color_ar') );
		// on frontend area
		add_action( 'wp_head', array($this, 'settings_color_ar') );

	}


	// Definizione variabili css per admin e public
	public function settings_color_ar(){
    
    $primary = get_option('colore_primario') ? get_option('colore_primario') : '#696969';
    $secondary = get_option('colore_secondario') ? get_option('colore_secondario') : '#f0f0f0';

    $primaryAR = get_option('colore_primario_ar') ? get_option('colore_primario_ar') : '#f9c268';
    $secondaryAR = get_option('colore_secondario_ar') ? get_option('colore_secondario_ar') : '#ffefd8';
    
    ?>
        <style>
        :root {
            --primary: <?php echo $primary ?>;
            --secondary: <?php echo $secondary ?>;
    
            --primaryAR: <?php echo $primaryAR ?>;
            --secondaryAR: <?php echo $secondaryAR ?>;
        }
        </style>
  <?php }

}