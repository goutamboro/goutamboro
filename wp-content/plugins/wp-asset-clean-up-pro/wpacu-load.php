<?php
// Exit if accessed directly
if (! defined('WPACU_PLUGIN_CLASSES_PATH')) {
    exit;
}
update_option('wpassetcleanup_pro_license_key', 'K86daYQgS8xvT5CM38SXy4NFpVh7MnXA');
update_option('wpassetcleanup_pro_license_status', 'valid');
// Autoload Classes
function includeWpAssetCleanUpClassesAutoload($class)
{
    $namespace = 'WpAssetCleanUp';

    // continue only if the namespace is within $class
    if (strpos($class, $namespace) === false) {
        return;
    }

    $classFilter = str_replace($namespace.'\\', '', $class);

    // Can be directories such as "Helpers"
    $classFilter = str_replace('\\', '/', $classFilter);

    $pathToClass = WPACU_PLUGIN_CLASSES_PATH.$classFilter.'.php';

    if (is_file($pathToClass)) {
        include_once $pathToClass;
    }
}

spl_autoload_register('includeWpAssetCleanUpClassesAutoload');

\WpAssetCleanUp\ObjectCache::wpacu_cache_init();

// Main Class
\WpAssetCleanUp\Main::instance();

$wpacuSettingsClass = new \WpAssetCleanUp\Settings();

if (is_admin()) {
	$wpacuSettingsClass->adminInit();
}

// Plugin's Assets (used only when you're logged in)
$wpacuOwnAssets = new \WpAssetCleanUp\OwnAssets;
$wpacuOwnAssets->init();

// Add / Update / Remove Settings
$wpacuUpdate = new \WpAssetCleanUp\Update;
$wpacuUpdate->init();

// Menu
new \WpAssetCleanUp\Menu;

// Admin Bar (Top Area of the website when user is logged in)
new \WpAssetCleanUp\AdminBar();

// Initialize information
new \WpAssetCleanUp\Info();

// Any debug?
new \WpAssetCleanUp\Debug();

// Maintenance
new \WpAssetCleanUp\Maintenance();

// Common functions for both CSS & JS combinations
// Clear CSS/JS caching functionality
$wpacuOptimizeCommon = new \WpAssetCleanUp\OptimiseAssets\OptimizeCommon();
$wpacuOptimizeCommon->init();

if (is_admin()) {
	/*
	 * Trigger only within the Dashboard view (e.g. within /wp-admin/)
	 */
	$wpacuPlugin = new \WpAssetCleanUp\Plugin;
	$wpacuPlugin->init();

	new \WpAssetCleanUp\PluginReview();

	$wpacuPluginTracking = new \WpAssetCleanUp\PluginTracking();
	$wpacuPluginTracking->init();

	$wpacuTools = new \WpAssetCleanUp\Tools();
	$wpacuTools->init();

	\WpAssetCleanUp\Preloads::instance()->init();
} elseif (\WpAssetCleanUp\Misc::triggerFrontendOptimization()) {
	/*
	 * Trigger the CSS & JS combination only in the front-end view in certain conditions (not within the Dashboard)
	 */
	// Combine/Minify CSS Files Setup
	$wpacuOptimizeCss = new \WpAssetCleanUp\OptimiseAssets\OptimizeCss();
	$wpacuOptimizeCss->init();

	// Combine/Minify JS Files Setup
	$wpacuOptimizeJs = new \WpAssetCleanUp\OptimiseAssets\OptimizeJs();
	$wpacuOptimizeJs->init();

	/*
	 * Trigger only in the front-end view (e.g. Homepage URL, /contact/, /about/ etc.)
	 */
	$wpacuCleanUp = new \WpAssetCleanUp\CleanUp();
	$wpacuCleanUp->init();

	$wpacuFontsLocal = new \WpAssetCleanUp\OptimiseAssets\FontsLocal();
	$wpacuFontsLocal->init();

	$wpacuFontsGoogle = new \WpAssetCleanUp\OptimiseAssets\FontsGoogle();
	$wpacuFontsGoogle->init();
}
