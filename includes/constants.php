<?php 

$plugin_data = get_file_data( SP_MAIN_FILE_PATH, array(
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
define('SP_NAME', $pluginName);
// Versione Plugin
define('SP_VERSION', $version);
// Text Domain Plugin
define('SP_TXT_DOM', $textDomain);
// Slug Plugin
define('SP_SLUG', plugin_basename(dirname(SP_MAIN_FILE_PATH)));
// Percorso Plugin
Define('SP_PLUG_PATH' , plugin_dir_path(SP_MAIN_FILE_PATH));
// URL Plugin
Define('SP_PLUG_URL' , plugin_dir_url(SP_MAIN_FILE_PATH));
