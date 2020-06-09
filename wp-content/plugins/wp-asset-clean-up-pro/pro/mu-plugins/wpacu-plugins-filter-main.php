<?php
if (! defined('WP_PLUGIN_DIR')) {
	return;
}
// For debugging purposes
if (array_key_exists('wpacu_clean_load', $_GET)) {
	// Autoptimize
	$_GET['ao_noptimize'] = $_REQUEST['ao_noptimize'] = '1';

	// LiteSpeed Cache
	if ( ! defined( 'LITESPEED_DISABLE_ALL' ) ) {
		define('LITESPEED_DISABLE_ALL', true);
	}
}

if (! defined('WPACU_PLUGIN_ID')) {
	define( 'WPACU_PLUGIN_ID', 'wpassetcleanup' ); // unique prefix (same plugin ID name for 'lite' and 'pro')
}

if (! defined('WPACU_MU_FILTER_PLUGIN_DIR')) {
	define( 'WPACU_MU_FILTER_PLUGIN_DIR', __DIR__ );
}

/* [START] Filter Plugins Hook */
add_filter('option_active_plugins', static function ($activePlugins) {
	// Only valid if the constant is defined as some themes are calling automatically functions from other functions
	// e.g. if the theme calls "the_field" without checking if the function (belonging to Advanced Custom Fields) exists
	// then the following filtering will trigger an error, so if the admin decides to enable it, he/she needs to be careful and test it properly
	if (defined('WPACU_SKIP_OTHER_ACTIVE_PLUGINS_ON_ADMIN_AJAX_CALL') && WPACU_SKIP_OTHER_ACTIVE_PLUGINS_ON_ADMIN_AJAX_CALL !== false) {
		$isWpacuOwnAjaxCall = false;
		include_once WPACU_MU_FILTER_PLUGIN_DIR . '/_if-wpacu-own-ajax-calls.php';
		if ( $isWpacuOwnAjaxCall ) {
			return $activePlugins; // only the "Asset CleanUp Pro" plugin should be triggered (no other plugin is relevant in this case)
		}
	}

	// Do not filter any plugins for REST calls or if the user is within the Dashboard
	$restUrlPrefix = function_exists('rest_get_url_prefix') ? rest_get_url_prefix() : 'wp-json';
	$wpacuIsRestRequest = (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/'.$restUrlPrefix.'/') !== false);

	if ($wpacuIsRestRequest || is_admin()) {
		return $activePlugins;
	}

	$pluggableFile = __DIR__.'/pluggable-custom.php';

	// Any /?wpacu_filter_plugins=[...] requests
	include_once WPACU_MU_FILTER_PLUGIN_DIR.'/_filter-via-query-string.php';

	// Is "Test Mode" enabled and the user is a guest (not admin)? Do not continue with any filtering
	// No rules will be triggered including any in "Plugins Manager" as the MU plugin is part of Asset CleanUp Pro
	$wpacuSettingsJson = get_option('wpassetcleanup_settings');
	$wpacuSettingsDbList = @json_decode($wpacuSettingsJson, true);
	$wpacuIsTestMode = isset($wpacuSettingsDbList['test_mode']) && $wpacuSettingsDbList['test_mode'];

	if ($wpacuIsTestMode) {
		if (! defined('WPACU_PLUGGABLE_LOADED')) {
			require_once $pluggableFile;
			define('WPACU_PLUGGABLE_LOADED', true);
		}

		if ( ! wpacu_current_user_can('administrator') ) {
			// Return the list as it is (no unloading)
			return $activePlugins;
		}
	}

	if (! defined('WPACU_EARLY_TRIGGERS_CALLED')) {
		require_once dirname( dirname( WPACU_MU_FILTER_PLUGIN_DIR ) ) . '/early-triggers.php';
	}

	if (assetCleanUpNoLoad() || ($wpacuSettingsNoLoadPatternMatched = assetCleanUpHasNoLoadMatches())) {
		if ( isset($wpacuSettingsNoLoadPatternMatched) && $wpacuSettingsNoLoadPatternMatched && isset( $_REQUEST['wpassetcleanup_load'] ) && $_REQUEST['wpassetcleanup_load'] ) {
			$msg = __('This page\'s URL is matched by one of the RegEx rules you have in <em>"Settings"</em> -&gt; <em>"Plugin Usage Preferences"</em> -&gt; <em>"Do not load the plugin on certain pages"</em>, thus Asset CleanUp Pro is not loaded on that page and no CSS/JS are to be managed. If you wish to view the CSS/JS manager, please remove the matching RegEx rule and reload this page.', 'wp-asset-clean-up');
			exit($msg);
		}

		// Do not load Asset CleanUp Pro at all due to the rules from /early-triggers.php OR due to the request in the settings
		// As a result, no other plugin rules (e.g from "Plugins Manager") should be triggered either
		// Stop here with the plugin filtering
		return array_diff($activePlugins, array('wp-asset-clean-up-pro/wpacu.php'));
	}

	$activePluginsToFilter = array();

	// Is "Test Mode" disabled OR enabled but the admin is viewing the page? Continue
	// Fetch the existing rules (unload, load exceptions, etc.)
	include_once __DIR__ . '/_filter-from-rules.php';

	// If there are any plugins in $activePluginsToFilter, then $activePlugins will be filtered to avoid loading the targeted plugins
	if (! empty($activePluginsToFilter)) {
		$GLOBALS['wpacu_filtered_plugins'] = $activePluginsToFilter;
		$activePlugins = array_diff($activePlugins, $activePluginsToFilter);
	}

	// Return final list of active plugins (filtered or not)
	return $activePlugins;
});
/* [END] Filter Plugins Hook */

