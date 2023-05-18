<?php 

/*
 * Update checker
 */

// Slug repository GitHub
$slugGitPlugin = DR_SLUG;

// Ramo. Es. Stable
$branchGitPlugin = get_option('branch_updates') ? get_option('branch_updates') : 'master';

// Link repository GitHub.
$linkGitPlugin = 'https://github.com/sargentiniandrea/'.$slugGitPlugin.'/';

// Token
$token = get_option('token_updates') ? get_option('token_updates') : '';

require SP_PLUG_PATH . 'vendor/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
$myUpdateChecker = PucFactory::buildUpdateChecker($linkGitPlugin, SP_MAIN_FILE_PATH, SP_SLUG );
$myUpdateChecker->setBranch($branchGitPlugin);
$myUpdateChecker->setAuthentication($token);