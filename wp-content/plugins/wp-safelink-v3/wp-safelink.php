<?php
/*
Plugin Name: WP Safelink V3.2
Plugin URI: http://themeson.com
Description: Safelink for any wordpress
Version: 3.2
Author: themeson
Author URI:  http://themeson.com
*/
define('WPSAF_URL',plugins_url( '',__FILE__));
define('WPSAF_DIR',plugin_dir_path(__FILE__));

require(WPSAF_DIR .'wp-safelink.core.php');

register_activation_hook(__FILE__,'wpsafelink_activation'); 
function wpsafelink_activation(){
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'wpsafelink';
	$sql = "CREATE TABLE $table_name (
		ID bigint(0) NOT NULL AUTO_INCREMENT, 
		date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, 
		date_view datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, 
		date_click datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, 
		safe_id varchar(8) NOT NULL,
		link longtext NOT NULL,
		view bigint(0) NOT NULL,
		click bigint(0) NOT NULL,
		UNIQUE KEY id (ID)
	) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql ); 
	if(get_settings('wpsaf_options')=='') wpsaf_default();
}
function wpsaf_default(){ 	 
	$wpsaf_def = array(
			'permalink1' 	=> 'go',
			'permalink2' 	=> 'go',
			'permalink'		=> 2,
			'linkr'			=> 'redirect',
			'content' 		=> 0,
			'contentid' 	=> '',
			'template' 		=> 'template1',
			'delay' 		=> 5,
			'delaytext' 	=> 'Silakan tunggu {time} detik...',
			'logo'			=> WPSAF_URL.'/assets/logo.png',
			'image1'		=> WPSAF_URL.'/assets/generate4.png',
			'image2'		=> WPSAF_URL.'/assets/wait4.png',
			'image3'		=> WPSAF_URL.'/assets/target4.png',
			'ads1'			=> '',
			'ads2'			=> '',
		); 
	$wpsaf = json_encode($wpsaf_def);
	update_option('wpsaf_options', $wpsaf);
}