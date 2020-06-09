<?php
if (! isset($activePlugins)) {
	exit;
}

// Are there specific plugin AJAX (admin/ajax-admin.php) calls? Only trigger Asset CleanUp plugin as loading other plugins is useless (save resources)
$wpacuIsAjaxRequest = (! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

if ( isset( $_POST['action'], $_SERVER['REQUEST_URI'] ) && $wpacuIsAjaxRequest
     && strpos( $_POST['action'], 'wpassetcleanup_' ) !== false
     && strpos( $_SERVER['REQUEST_URI'], '/admin-ajax.php' ) !== false
	 && is_admin() // extra check to make sure /admin/admin-ajax.php is accessed
) {
	$isWpacuOwnAjaxCall = true;

	foreach ($activePlugins as $activePlugin) {
		if ($activePlugin === 'wp-asset-clean-up-pro/wpacu.php') {
			$activePlugins = array(
				'wp-asset-clean-up-pro/wpacu.php'
			);
		} elseif ($activePlugin === 'wp-asset-clean-up/wpacu.php') {
			$activePlugins = array(
				'wp-asset-clean-up/wpacu.php'
			);
		}
	}
}
