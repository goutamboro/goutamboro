<?php
if (! isset($activePlugins, $activePluginsToFilter, $wpacuIsTestMode, $pluggableFile)) {
	exit;
}

$pluginsRulesDbListJson = get_option('wpassetcleanup_global_data');

if ($pluginsRulesDbListJson) {
	$pluginsRulesDbList = @json_decode( $pluginsRulesDbListJson, true );

	// Are there any valid load exceptions / unload RegExes? Fill $activePluginsToFilter
	if ( isset( $pluginsRulesDbList[ 'plugins' ] ) && ! empty( $pluginsRulesDbList[ 'plugins' ] ) ) {
		$pluginsRules = $pluginsRulesDbList[ 'plugins' ];

		// Unload site-wide
		foreach ($pluginsRules as $pluginPath => $pluginRule) {
			if (! in_array($pluginPath, $activePlugins)) {
				// Only relevant if the plugin is active
				// Otherwise it's unloaded (inactive) anyway
				continue;
			}
			if (isset($pluginRule['status']) && $pluginRule['status']) {
				// Are there any load exceptions?
				$isLoadExceptionRegExMatch = isset($pluginRule['load_via_regex']['enable'], $pluginRule['load_via_regex']['value'])
				                        && $pluginRule['load_via_regex']['enable'] && wpacuPregMatchInput($pluginRule['load_via_regex']['value'], $_SERVER['REQUEST_URI']);

				if ( $isLoadExceptionRegExMatch ) {
					continue; // Skip to the next plugin as this one has a load exception matching the condition
				}

				$isLoadExceptionIfLoggedInEnable = isset($pluginRule['load_logged_in']['enable']) && $pluginRule['load_logged_in']['enable'];

				// Should the plugin be always loaded as a if the user is logged-in?
				if ($isLoadExceptionIfLoggedInEnable) {
					if (! defined('WPACU_PLUGGABLE_LOADED')) {
						require_once $pluggableFile;
						define('WPACU_PLUGGABLE_LOADED', true);
					}

					if (function_exists('wpacu_is_user_logged_in') && wpacu_is_user_logged_in()) {
						continue;
					}
				}

				if ( $pluginRule['status'] === 'unload_site_wide' ) {
					$activePluginsToFilter[] = $pluginPath; // Add it to the unload list
				} elseif ($pluginRule['status'] === 'unload_via_regex') {
					$isUnloadRegExMatch = isset($pluginRule['unload_via_regex']['value']) && wpacuPregMatchInput($pluginRule['unload_via_regex']['value'], $_SERVER['REQUEST_URI']);
					if ($isUnloadRegExMatch) {
						$activePluginsToFilter[] = $pluginPath; // Add it to the unload list
					}
				}
			}
		}
	}
}
