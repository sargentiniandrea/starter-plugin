<?php 

$plugin_data = get_file_data( NP_MAIN_FILE_PATH, array(
    'Plugin Name' => 'Plugin Name',
	'Version' => 'Version',
    'Text Domain' => 'Text Domain'
) );
$pluginName = $plugin_data['Plugin Name'] ? $plugin_data['Plugin Name'] : '';
$version = $plugin_data['Version'] ? $plugin_data['Version'] : '';
$textDomain = $plugin_data['Text Domain'] ? $plugin_data['Text Domain'] : '';

/**
 * Costanti
 */
// Nome Plugin
define('NP_NAME', $pluginName);
// Versione Plugin
define('NP_VERSION', $version);
// Text Domain Plugin
define('NP_TXT_DOM', $textDomain);
// Slug Plugin
define('NP_SLUG', plugin_basename(dirname(NP_MAIN_FILE_PATH)));
// Percorso Plugin
Define('NP_PLUG_PATH' , plugin_dir_path(NP_MAIN_FILE_PATH));
// URL Plugin
Define('NP_PLUG_URL' , plugin_dir_url(NP_MAIN_FILE_PATH));
