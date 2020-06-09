<?php
namespace WpAssetCleanUp;

/**
 * Class Maintenance
 * @package WpAssetCleanUp
 */
class Maintenance
{
	public function __construct()
	{
		if (is_admin() && isset($_GET['page']) && strpos($_GET['page'], WPACU_PLUGIN_ID.'_') === 0) {
			add_action('admin_init', static function() {
				Maintenance::cleanUnusedAssetsFromInfoArea();
			});
		}
	}

	/**
	 *
	 */
	public static function cleanUnusedAssetsFromInfoArea()
	{
		$allAssetsWithAtLeastOneRule = Overview::handlesWithAtLeastOneRule();

		if (empty($allAssetsWithAtLeastOneRule)) {
			return;
		}

		// Stored in the "assets_info" key from "wpassetcleanup_global_data" option name (from `{$wpdb->prefix}options` table)
		$allAssetsFromInfoArea = Main::getHandlesInfo();

		$handlesToClearFromInfo = array('styles' => array(), 'scripts' => array());

		foreach (array('styles', 'scripts') as $assetType) {
			if ( isset( $allAssetsFromInfoArea[$assetType] ) && ! empty( $allAssetsFromInfoArea[$assetType] ) ) {
				foreach ( array_keys( $allAssetsFromInfoArea[$assetType] ) as $assetHandle ) {
					if ( ! isset($allAssetsWithAtLeastOneRule[$assetType][$assetHandle]) ) { // not found in $allAssetsWithAtLeastOneRule? Add it to the clear list
						$handlesToClearFromInfo[$assetType][] = $assetHandle;
					}
				}
			}
		}

		if (! empty($handlesToClearFromInfo['styles']) || ! empty($handlesToClearFromInfo['scripts'])) {
			self::removeHandlesInfoFromGlobalDataOption($handlesToClearFromInfo);
		}
	}

	/**
	 * @param $handlesToClearFromInfo
	 */
	public static function removeHandlesInfoFromGlobalDataOption($handlesToClearFromInfo)
	{
		$optionToUpdate = WPACU_PLUGIN_ID . '_global_data';
		$globalKey = 'assets_info';

		$existingListEmpty = array('styles' => array($globalKey => array()), 'scripts' => array($globalKey => array()));
		$existingListJson = get_option($optionToUpdate);

		$existingListData = Main::instance()->existingList($existingListJson, $existingListEmpty);
		$existingList = $existingListData['list'];

		// $assetType could be 'styles' or 'scripts'
		foreach ($handlesToClearFromInfo as $assetType => $handles) {
			foreach ($handles as $handle) {
				if ( isset( $existingList[ $assetType ][ $globalKey ][ $handle ] ) ) {
					unset( $existingList[ $assetType ][ $globalKey ][ $handle ] );
				}
			}
		}

		Misc::addUpdateOption($optionToUpdate, json_encode(Misc::filterList($existingList)));
	}
}
