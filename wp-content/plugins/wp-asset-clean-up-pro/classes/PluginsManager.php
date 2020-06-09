<?php
namespace WpAssetCleanUp;

/**
 *
 * Class PluginsManager
 * @package WpAssetCleanUp
 */
class PluginsManager
{
    /**
     * @var array
     */
    public $data = array();

	/**
	 * PluginsManager constructor.
	 */
	public function __construct()
    {
        // Note: The rules update takes place in /pro/classes/UpdatePro.php
	    if (Misc::getVar('get', 'page') === WPACU_PLUGIN_ID . '_plugins_manager') {
		    add_action('wpacu_admin_notices', array($this, 'notices'));
	    }
    }

	/**
	 *
	 */
	public function page()
    {
    	// Get active plugins and their basic information
	    $this->data['active_plugins'] = self::getActivePlugins();
	    $this->data['plugins_icons']  = Misc::getAllActivePluginsIcons();
	    $this->data['rules']          = self::getAllRules(); // get all rules from the database

	    // [wpacu_pro]
	    $this->data['mu_file_missing']  = false; // default
	    $this->data['mu_file_rel_path'] = '/' . str_replace(ABSPATH, '', WPMU_PLUGIN_DIR)
	                                      . '/' . \WpAssetCleanUpPro\PluginPro::$muPluginFileName;

	    if ( ! is_file(WPMU_PLUGIN_DIR . '/' . \WpAssetCleanUpPro\PluginPro::$muPluginFileName) ) {
			$this->data['mu_file_missing']  = true; // alert the user in the "Plugins Manager" area
	    }
        // [/wpacu_pro]

	    Main::instance()->parseTemplate('admin-page-plugins-manager', $this->data, true);
    }

	/**
	 *
	 * @return array|mixed
	 */
	public static function getAllRules()
	{
		$pluginsRulesDbListJson = get_option(WPACU_PLUGIN_ID . '_global_data');

		$mainGlobalKey = 'plugins';

		if ($pluginsRulesDbListJson) {
			$regExDbList = @json_decode($pluginsRulesDbListJson, true);

			// Issues with decoding the JSON file? Return an empty list
			if (Misc::jsonLastError() !== JSON_ERROR_NONE) {
				return array();
			}

			// Are there any load exceptions / unload RegExes?
			if ( isset( $regExDbList[$mainGlobalKey] ) && ! empty( $regExDbList[$mainGlobalKey] ) ) {
				return $regExDbList[$mainGlobalKey];
			}
		}

		return array();
	}

	/**
	 * @return array
	 */
	public static function getActivePlugins()
    {
	    $activePluginsFinal = array();

	    // Get active plugins and their basic information
	    $activePlugins = array_unique(get_option('active_plugins', array()));

	    foreach ($activePlugins as $plugin) {
		    // Skip Asset CleanUp as it's obviously needed for the functionality
		    if (strpos($plugin, 'wp-asset-clean-up') !== false) {
			    continue;
		    }

		    $pluginData = get_plugin_data(WP_CONTENT_DIR . '/plugins/'.$plugin);
		    $activePluginsFinal[] = array('title' => $pluginData['Name'], 'path' => $plugin);
	    }

	    usort($activePluginsFinal, static function($a, $b)
	    {
		    return strcmp($a['title'], $b['title']);
	    });

	    return $activePluginsFinal;
    }

	/**
	 * Make sure there is a status for the rule, otherwise it's likely set to "Load it",
	 * thus the rule wouldn't count
	 * @param bool $checkIfPluginIsActive
     *
	 * @return array
	 */
	public static function getPluginRulesFiltered($checkIfPluginIsActive = true)
    {
	    $pluginsWithRules = array();

		$pluginsAllDbRules = self::getAllRules();

		// Are there any load exceptions / unload RegExes?
	    if (! empty( $pluginsAllDbRules ) ) {
		    foreach ($pluginsAllDbRules as $pluginPath => $pluginData) {
		        // Only the rules for the active plugins are retrieved
			    if ($checkIfPluginIsActive && ! Misc::isPluginActive($pluginPath)) {
				    continue;
			    }

			    $pluginStatus = isset($pluginData['status']) && trim($pluginData['status']) ? $pluginData['status'] : false;

			    if ($pluginStatus) {
				    $pluginsWithRules[$pluginPath] = $pluginData;
			    }
		    }

		    }

	    return $pluginsWithRules;
    }

	/**
	 *
	 */
	public function notices()
	{
		// After "Save changes" is clicked
		if (get_transient('wpacu_plugins_manager_updated')) {
			delete_transient('wpacu_plugins_manager_updated');
			?>
			<div style="margin-bottom: 15px; margin-left: 0; width: 90%;" class="notice notice-success is-dismissible">
				<p><span class="dashicons dashicons-yes"></span> <?php _e('The plugins\' rules were successfully updated.', 'wp-asset-clean-up'); ?></p>
			</div>
			<?php
		}
	}
}
