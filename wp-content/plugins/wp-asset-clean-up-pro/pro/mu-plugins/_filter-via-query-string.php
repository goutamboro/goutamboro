<?php
if (! isset($activePlugins, $pluggableFile)) {
	exit;
}

// It needs to have 'wpacu_filter_plugins' parameter passed to the query string
$isFilterRequestedViaQueryString = isset($_GET['wpacu_filter_plugins']);

if ($isFilterRequestedViaQueryString && is_file($pluggableFile)) {
	require_once $pluggableFile;

	if (! wpacu_current_user_can('administrator')) {
		return $activePlugins;
	}

	$filterRequestedPluginsRequests = trim($_GET['wpacu_filter_plugins'], ' ,');
	$activePluginsToFilter = $filterRequestedPluginStrings = array();

	//removeIf(development)
	/*
		$isCartPage     = strpos($requestUri, '/cart/') !== false;
		$isCheckoutPage = strpos($requestUri, '/checkout/') !== false;

		// Do not enable "woocommerce-gateway-stripe" on product pages as it sets a WooCommerce cookie and prevents caching
		if (strpos($requestUri, '/product/') !== false) {
			$pluginsToFilter[] = 'woocommerce-gateway-stripe/woocommerce-gateway-stripe.php';
		}

		// Keep specific plugins active only in the Homepage
		$isHomePage = ($_SERVER['REQUEST_URI'] === '/'); // can be further extended
	*/
	//removeIf(development)

	// Disable plugins on page request for testing purposes
	if (strpos($filterRequestedPluginsRequests, ',') !== false) {
		// With comma? Could be something like /?wpacu_filter_plugins=cache,woocommerce that will deactivate all plugins containing "cache" and "woocommerce"
		foreach (explode(',', $filterRequestedPluginsRequests) as $filterRequestedPluginString) {
			if (trim($filterRequestedPluginString)) {
				$filterRequestedPluginStrings[] = $filterRequestedPluginString;
			}
		}
	} else {
		// Without any comma? Could be something like /?wpacu_filter_plugins=cache that will deactivate all plugins containing "cache"
		$filterRequestedPluginStrings[] = $filterRequestedPluginsRequests;
	}

	foreach ($activePlugins as $activePlugin) {
		// Does the plugin name/path match anything from the query string?
		// Either one if no comma was used, or multiple of them
		foreach ($filterRequestedPluginStrings as $filterRequestedPluginString) {
			if ( strpos( $activePlugin, $filterRequestedPluginString ) !== false ) {
				$activePluginsToFilter[] = $activePlugin;
				continue;
			}
		}
	}

	// Any matches? Strip them from the active list
	if ( ! empty($activePluginsToFilter) ) {
		@ini_set('display_errors', 'off');
		@error_reporting(0);

		if ( ! defined('WP_DEBUG') ) {
			define( 'WP_DEBUG', false );
		}

		if ( ! defined('WP_DEBUG_DISPLAY') ) {
			define( 'WP_DEBUG_DISPLAY', false );
		}

		$GLOBALS['wpacu_filtered_plugins'] = $activePluginsToFilter;

		return array_diff($activePlugins, $activePluginsToFilter);
	}
}
