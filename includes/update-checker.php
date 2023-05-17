<?php 

/*
 * Update checker
 */

// Link repository GitHub
$linkGitPlugin = 'https://github.com/sargentiniandrea/area-riservata/';
// Ramo 
$branchGitPlugin = 'stable';
// Token
$token = get_option('token_updates') ? get_option('token_updates') : '';


require NP_PLUG_PATH . 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
$myUpdateChecker = PucFactory::buildUpdateChecker($linkGitPlugin, NP_MAIN_FILE_PATH, NP_SLUG );
$myUpdateChecker->setBranch($branchGitPlugin);
$myUpdateChecker->setAuthentication($token);