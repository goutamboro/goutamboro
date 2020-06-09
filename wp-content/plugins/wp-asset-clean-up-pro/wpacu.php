<?php
/*
 * Plugin Name: Asset CleanUp Pro: Page Speed Booster
 * Plugin URI: https://www.gabelivan.com/items/wp-asset-cleanup-pro/
 * Version: 1.1.7.2
 * Description: Prevent Chosen Scripts & Styles from loading to reduce HTTP Requests and get faster page load | Add "async" & "defer" attributes to loaded JS | Combine/Minify CSS/JS files
 * Author: Gabriel Livan
 * Author URI: http://www.gabelivan.com/
 * Text Domain: wp-asset-clean-up
 * Domain Path: /languages
*/

define('WPACU_PRO_PLUGIN_VERSION', '1.1.7.2');

// Make sure the Lite constant is defined in case other plugins (such as Oxygen Builder) use it
if (! defined('WPACU_PLUGIN_VERSION')) {
	define('WPACU_PLUGIN_VERSION', WPACU_PRO_PLUGIN_VERSION);
}

// Exit if accessed directly
if (! defined('ABSPATH')) {
    exit;
}

if (! defined('WPACU_PLUGIN_ID')) {
	define( 'WPACU_PLUGIN_ID', 'wpassetcleanup' ); // unique prefix (same plugin ID name for 'lite' and 'pro')
}

if ( ! defined('WPACU_PLUGIN_TITLE') ) {
	define( 'WPACU_PLUGIN_TITLE', 'Asset CleanUp Pro' ); // a short version of the plugin name
}

if (! defined('WPACU_EARLY_TRIGGERS_CALLED')) {
	require_once __DIR__ . '/early-triggers.php';
}

if (assetCleanUpNoLoad()) {
	return; // do not continue
}

// Is "Lite" version enabled?
// It needs to be deactivated as the "Pro" version starting from version 1.0.3 works independently
if (defined('WPACU_PLUGIN_CLASSES_PATH')) {
	return;
}

define('WPACU_PRO_NO_LITE_NEEDED', true); // no LITE parent plugin needed anymore (since 1.0.3)

define('WPACU_PLUGIN_FILE',        __FILE__);
define('WPACU_PLUGIN_BASE',        plugin_basename(WPACU_PLUGIN_FILE));

define('WPACU_ADMIN_PAGE_ID_START', WPACU_PLUGIN_ID . '_getting_started');

// Do not load the plugin if the PHP version is below 5.4
$wpacuProWrongPhp = ((! defined('PHP_VERSION_ID')) || (defined('PHP_VERSION_ID') && PHP_VERSION_ID < 50400));

if ($wpacuProWrongPhp && is_admin()) { // Dashboard
    add_action('admin_init',    'wpAssetCleanUpProWrongPhp');
    add_action('admin_notices', 'wpAssetCleanUpProWrongPhpNotice');

    /**
     * Deactivate the plugin because it has the wrong PHP version installed
     */
    function wpAssetCleanUpProWrongPhp()
    {
        deactivate_plugins(WPACU_PLUGIN_BASE);
    }

    /**
     * Print the message to the user after the plugin was deactivated
     */
    function wpAssetCleanUpProWrongPhpNotice()
    {
	    echo '<div class="error is-dismissible"><p>'.

	         sprintf(
		         __('%1$s requires %2$s PHP version installed. You have %3$s.', 'wp-asset-clean-up'),
		         '<strong>'.WPACU_PLUGIN_TITLE.'</strong>',
		         '<span style="color: green;"><strong>5.4+</strong></span>',
		         '<strong>'.PHP_VERSION.'</strong>'
	         ) . ' '.
	         __('If your website is compatible with PHP 7+ (e.g. you can check with your developers or contact the hosting company), it\'s strongly recommended to upgrade for a better performance.', 'wp-asset-clean-up').' '.
	         __('The plugin has been deactivated.', 'wp-asset-clean-up').

	         '</p></div>';

        if (array_key_exists('active', $_GET)) {
            unset($_GET['activate']);
        }
    }
} elseif ($wpacuProWrongPhp) { // Front
    return;
}

define('WPACU_PLUGIN_DIR',                  __DIR__);
define('WPACU_PLUGIN_CLASSES_PATH',         WPACU_PLUGIN_DIR.'/classes/');
define('WPACU_PLUGIN_URL',                  plugins_url('', WPACU_PLUGIN_FILE));
define('WPACU_PLUGIN_FEATURE_REQUEST_URL', 'https://www.gabelivan.com/asset-cleanup-pro-feature-request/');

// Global Values
define('WPACU_LOAD_ASSETS_REQ_KEY', WPACU_PLUGIN_ID . '_load');

$wpacuGetLoadedAssetsAction = ((isset($_REQUEST[WPACU_LOAD_ASSETS_REQ_KEY]) && $_REQUEST[WPACU_LOAD_ASSETS_REQ_KEY])
                               || (isset($_REQUEST['action']) && $_REQUEST['action'] === WPACU_PLUGIN_ID.'_get_loaded_assets'));
define('WPACU_GET_LOADED_ASSETS_ACTION', $wpacuGetLoadedAssetsAction);

require_once WPACU_PLUGIN_DIR.'/wpacu-load.php';

if (WPACU_GET_LOADED_ASSETS_ACTION === true || ! is_admin()) {
	add_action('init', static function() {
		// "Smart Slider 3" & "WP Rocket" compatibility fix | triggered ONLY when the assets are fetched
		if ( ! function_exists('get_rocket_option') && class_exists( 'NextendSmartSliderWPRocket' ) ) {
			function get_rocket_option($option) { return ''; }
		}
	});

	add_action('parse_query', static function() { // very early triggering to set WPACU_ALL_ACTIVE_PLUGINS_LOADED
		if (defined('WPACU_ALL_ACTIVE_PLUGINS_LOADED')) { return; } // only trigger it once in this action
		define('WPACU_ALL_ACTIVE_PLUGINS_LOADED', true);
		\WpAssetCleanUp\Plugin::preventAnyChanges();
	}, 1);

	require_once WPACU_PLUGIN_DIR . '/vendor/autoload.php';
}

// [wpacu_pro]
define('WPACU_PRO_DIR',          WPACU_PLUGIN_DIR.'/pro/');
define('WPACU_PRO_CLASSES_PATH', WPACU_PRO_DIR.'classes/');

// Trigger premium functions
// namespace: WpAssetCleanUpPro
require_once WPACU_PRO_DIR.'wpacu-pro-load.php';
// [/wpacu_pro]
