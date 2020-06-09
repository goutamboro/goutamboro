<?php
function perfmatters_network_admin_menu() {

	//Add Network Settings Menu Item
    $perfmatters_network_settings_page = add_submenu_page('settings.php', 'Perfmatters Network Settings', 'Perfmatters', 'manage_network_options', 'perfmatters', 'perfmatters_network_page_callback');

    //Add Load Action to Enqueue Scripts
	add_action('load-' . $perfmatters_network_settings_page, 'perfmatters_settings_load');

    //Create Site Option if Not Found
    if(get_site_option('perfmatters_network') == false) {    
        add_site_option('perfmatters_network', true);
    }
 
 	//Add Settings Section
    add_settings_section('perfmatters_network', 'Network Setup', 'perfmatters_network_callback', 'perfmatters_network');
   
   	//Add Options Fields
	add_settings_field(
		'access', 
		'<label for=\'access\'>' . __('Network Access', 'perfmatters') . '</label>' . perfmatters_tooltip('https://perfmatters.io/docs/wordpress-multisite/'),
		'perfmatters_network_access_callback', 
		'perfmatters_network', 
		'perfmatters_network'
	);

	add_settings_field(
		'default', 
		'<label for=\'default\'>' . __('Network Default', 'perfmatters') . '</label>' . perfmatters_tooltip('https://perfmatters.io/docs/wordpress-multisite/'),
		'perfmatters_network_default_callback', 
		'perfmatters_network', 
		'perfmatters_network'
	);

	//Clean Uninstall
    add_settings_field(
        'clean_uninstall', 
        perfmatters_title(__('Clean Uninstall', 'perfmatters'), 'clean_uninstall') . perfmatters_tooltip('https://perfmatters.io/docs/clean-uninstall/'), 
        'perfmatters_print_input', 
        'perfmatters_network', 
        'perfmatters_network', 
        array(
            'id' => 'clean_uninstall',
            'option' => 'perfmatters_network',
            'tooltip' => __('When enabled, this will cause all Perfmatters options data to be removed from your database when the plugin is uninstalled.', 'perfmatters')
        )
    );

	//Register Setting
	register_setting('perfmatters_network', 'perfmatters_network');
}
add_filter('network_admin_menu', 'perfmatters_network_admin_menu');

//Perfmatters Network Section Callback
function perfmatters_network_callback() {
	echo '<p class="perfmatters-subheading">' . __('Manage network access control and setup a network default site.', 'perfmatters') . '</p>';
}
 
//Perfmatters Network Access
function perfmatters_network_access_callback() {
	$perfmatters_network = get_site_option('perfmatters_network');
	echo "<div style='display: table; width: 100%;'>";
		echo "<div class='perfmatters-input-wrapper'>";
			echo "<select name='perfmatters_network[access]' id='access'>";
				echo "<option value=''>" . __('Site Admins (Default)', 'perfmatters') . "</option>";
				echo "<option value='super' " . ((!empty($perfmatters_network['access']) && $perfmatters_network['access'] == 'super') ? "selected" : "") . ">" . __('Super Admins Only', 'perfmatters') . "</option>";
			echo "<select>";
		echo "</div>";
		echo "<div class='perfmatters-tooltip-text-wrapper'>";
			echo "<div class='perfmatters-tooltip-text-container' style='display: none;'>";
				echo "<div style='display: table; height: 100%; width: 100%;'>";
					echo "<div style='display: table-cell; vertical-align: middle;'>";
						echo "<span class='perfmatters-tooltip-text'>" . __('Choose who has access to manage Perfmatters plugin settings.', 'perfmatters') . "</span>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
}

//Perfmatters Network Default
function perfmatters_network_default_callback() {
	$perfmatters_network = get_site_option('perfmatters_network');
	echo "<div style='display: table; width: 100%;'>";
		echo "<div class='perfmatters-input-wrapper'>";
			echo "<select name='perfmatters_network[default]' id='default'>";
				$sites = array_map('get_object_vars', get_sites(array('deleted' => 0)));
				if(is_array($sites) && $sites !== array()) {
					echo "<option value=''>" . __('None', 'perfmatters') . "</option>";
					foreach($sites as $site) {
						echo "<option value='" . $site['blog_id'] . "' " . ((!empty($perfmatters_network['default']) && $perfmatters_network['default'] == $site['blog_id']) ? "selected" : "") . ">" . $site['blog_id'] . ": " . $site['domain'] . $site['path'] . "</option>";
					}
				}
			echo "<select>";
		echo "</div>";
		echo "<div class='perfmatters-tooltip-text-wrapper'>";
			echo "<div class='perfmatters-tooltip-text-container' style='display: none;'>";
				echo "<div style='display: table; height: 100%; width: 100%;'>";
					echo "<div style='display: table-cell; vertical-align: middle;'>";
						echo "<span class='perfmatters-tooltip-text'>" . __('Choose a subsite that you want to pull default settings from.', 'perfmatters') . "</span>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
}
 
//Perfmatters Network Settings Page
function perfmatters_network_page_callback() {
	if(isset($_POST['perfmatters_apply_defaults'])) {
		check_admin_referer('perfmatters-network-apply');
		if(isset($_POST['perfmatters_network_apply_blog']) && is_numeric($_POST['perfmatters_network_apply_blog'])) {
			$blog = get_blog_details($_POST['perfmatters_network_apply_blog']);
			if($blog) {

				//apply default settings to selected blog
				if(is_multisite()) {
					$perfmatters_network = get_site_option('perfmatters_network');

					if(!empty($perfmatters_network['default'])) {

						if($blog->blog_id != $perfmatters_network['default']) {

							$option_names = array(
								'perfmatters_options',
								'perfmatters_cdn',
								'perfmatters_extras'
							);

							foreach($option_names as $option_name) {

								//clear selected blog previous option
								delete_blog_option($blog->blog_id, $option_name);

								//grab new option from default blog
								$new_option = get_blog_option($perfmatters_network['default'], $option_name);

								//remove options we don't want to copy
								if($option_name == 'perfmatters_cdn') {
									unset($new_option['cdn_url']);
								}

								//update selected blog with default option
								update_blog_option($blog->blog_id, $option_name, $new_option);

							}

							//Default Settings Updated Notice
							echo "<div class='notice updated is-dismissible'><p>" . __('Default settings applied!', 'perfmatters') . "</p></div>";
						}
						else {
							//Can't Apply to Network Default
							echo "<div class='notice error is-dismissible'><p>" . __('Select a site that is not already the Network Default.', 'perfmatters') . "</p></div>";
						}
					}
					else {
						//Network Default Not Set
						echo "<div class='notice error is-dismissible'><p>" . __('Network Default not set.', 'perfmatters') . "</p></div>";
					}
				}
			}
			else {
				//Blog Not Found Notice
				echo "<div class='notice error is-dismissible'><p>" . __('Error: Blog Not Found.', 'perfmatters') . "</p></div>";
			}
		}
	}

	//Options Updated
	if(isset($_GET['updated'])) {
		echo "<div class='notice updated is-dismissible'><p>" . __('Options saved.', 'perfmatters') . "</p></div>";
	}

	//if no tab is set, default to first/network tab
	if(empty($_GET['tab'])) {
		$_GET['tab'] = 'network';
	} 

	echo "<div class='wrap perfmatters-admin'>";

		//Admin Page Title
  		echo "<h1>" . __('Perfmatters Network Settings', 'perfmatters') . "</h1>";

  		//Tab Navigation
		echo "<h2 class='nav-tab-wrapper'>";
			echo "<a href='?page=perfmatters&tab=network' class='nav-tab " . ($_GET['tab'] == 'network' ? 'nav-tab-active' : '') . "'>" . __('Network', 'perfmatters') . "</a>";
			echo "<a href='?page=perfmatters&tab=license' class='nav-tab " . ($_GET['tab'] == 'license' ? 'nav-tab-active' : '') . "'>" . __('License', 'perfmatters') . "</a>";
			echo "<a href='?page=perfmatters&tab=support' class='nav-tab " . ($_GET['tab'] == 'support' ? 'nav-tab-active' : '') . "'>" . __('Support', 'perfmatters') . "</a>";
		echo "</h2>";

		//Network Tab Content
		if($_GET['tab'] == 'network') {

	  		echo "<form method='POST' action='edit.php?action=perfmatters_update_network_options' style='overflow: hidden;'>";
			    settings_fields('perfmatters_network');
			    do_settings_sections('perfmatters_network');
			    submit_button();
	  		echo "</form>";

	  		echo "<form method='POST'>";
	 
	  			echo "<h2>" . __('Apply Default Settings', 'perfmatters') . "</h2>";
	  			echo '<p class="perfmatters-subheading">' . __('Choose a site to apply the settings from your network default site.', 'perfmatters') . '</p>';

				wp_nonce_field('perfmatters-network-apply', '_wpnonce', true, true);
				echo "<p>" . __('Select a site from the dropdown and click to apply the settings from your network default (above).', 'perfmatters') . "</p>";

				echo "<select name='perfmatters_network_apply_blog'>";
					$sites = array_map('get_object_vars', get_sites(array('deleted' => 0)));
					if(is_array($sites) && $sites !== array()) {
						echo "<option value=''>" . __('Select a Site', 'perfmatters') . "</option>";
						foreach($sites as $site) {
							echo "<option value='" . $site['blog_id'] . "'>" . $site['blog_id'] . ": " . $site['domain'] . $site['path'] . "</option>";
						}
					}
				echo "<select>";

				echo "<input type='submit' name='perfmatters_apply_defaults' value='" . __('Apply Default Settings', 'perfmatters') . "' class='button' />";
			echo "</form>";
		}
		//License Tab Content
		elseif($_GET['tab'] == 'license') {
			if(isset($_POST['perfmatters_save_license'])) {
				if(isset($_POST['perfmatters_edd_license_key'])) {
					//Save License Key
					update_site_option('perfmatters_edd_license_key', $_POST['perfmatters_edd_license_key']);
				}
			}
			if(isset($_POST['perfmatters_edd_license_activate'])) {
				perfmatters_edd_activate_network_license();
			}
			if(isset($_POST['perfmatters_edd_license_deactivate'])) {
				perfmatters_edd_deactivate_network_license();
			}

			$license_info = perfmatters_edd_check_network_license();
			$license = get_site_option('perfmatters_edd_license_key');
			$status = get_site_option('perfmatters_edd_license_status');

			echo "<form method='POST'>";
				echo "<table class='form-table'>";
					echo "<tbody>";

						//License Key
						echo "<tr>";
							echo "<th><label for='perfmatters_edd_license_key'>" . __('License Key', 'perfmatters') . "</label></th>";
							echo "<td>";
								echo "<input id='perfmatters_edd_license_key' name='perfmatters_edd_license_key' type='password' class='regular-text' value='" . $license . "' />";
								echo "<label class='description' for='perfmatters_edd_license_key'>" . __('Enter your license key', 'perfmatters') . "</label>";
							echo "</td>";
						echo "</tr>";
						
						if($license !== false) {

							//Activate/Deactivate License
							echo "<tr>";
								echo "<th>" . __('Activate License', 'permatters') . "</th>";
								echo "<td>";
									wp_nonce_field('perfmatters_edd_nonce', 'perfmatters_edd_nonce');
									if($status !== false && $status == 'valid') {
										echo "<input type='submit' class='button-secondary' name='perfmatters_edd_license_deactivate' value='" . __('Deactivate License', 'perfmatters') . "' />";
										echo "<span style='color:green; display: block; margin-top: 10px;'>" . __('License is activated.', 'perfmatters') . "</span>";
									} else {
										if(!empty($license_info->activations_left) && $license_info->activations_left == 'unlimited') {
											echo "<input type='submit' class='button-secondary' name='perfmatters_edd_license_activate' value='" . __('Activate License', 'perfmatters') . "' />";
											echo "<span style='color:red; display: block; margin-top: 10px;'>" . __('License is not activated.', 'perfmatters') . "</span>";
										}
										else {
											echo "<span style='color:red; display: block;'>" . __('Unlimited License needed for use in a multisite environment. Please contact support to upgrade.', 'perfmatters') . "</span>";
										}
									}
								echo "</td>";
							echo "</tr>";

							if(!empty($license_info)) {

								//Customer Email Address
								if(!empty($license_info->customer_email)) {
									echo "<tr>";
										echo "<th>" . __('Customer Email', 'perfmatters') . "</th>";
										echo "<td>" . $license_info->customer_email . "</td>";
									echo "</tr>";
								}

								//License Status (Active/Expired)
								if(!empty($license_info->license)) {
									echo "<tr>";
										echo "<th>" . __('License Status', 'perfmatters') . "</th>";
										echo "<td " . ($license_info->license == "expired" ? "style='color: red;'" : "") . ">";
											echo $license_info->license;
											if(!empty($license) && $license_info->license == "expired") {
												echo "<br /><a href='https://perfmatters.io/checkout/?edd_license_key=" . $license . "&download_id=696' class='button-primary' style='margin-top: 10px;' target='_blank'>" . __('Renew Your License for Updates + Support!', 'perfmatters') . "</a>";
											}
										echo "</td>";
									echo "</tr>";
								}

								//Licenses Used
								if(!empty($license_info->site_count) && !empty($license_info->license_limit)) {
									echo "<tr>";
										echo "<th>" . __('Licenses Used', 'perfmatters') . "</th>";
										echo "<td>" . $license_info->site_count . "/" . $license_info->license_limit . "</td>";
									echo "</tr>";
								}
							}
						}
					echo "</tbody>";
				echo "</table>";
 
 				//Save License Button
				echo "<p class='submit'><input type='submit' name='perfmatters_save_license' class='button button-primary' value='" . __('Save License', 'perfmatters') . "'></p>";

			echo "</form>";
		}

		//Support Tab Content
		elseif($_GET['tab'] == 'support') {
			echo "<h2>" . __('Support', 'perfmatters') . "</h2>";
			echo "<p>" . __("For plugin support and documentation, please visit <a href='https://perfmatters.io/' title='perfmatters' target='_blank'>perfmatters.io</a>.", 'perfmatters') . "</p>";
		}

		//Tooltip Legend
		if($_GET['tab'] != 'support' && $_GET['tab'] != 'license') {
			echo "<div id='perfmatters-legend'>";
				echo "<div id='perfmatters-tooltip-legend'>";
					echo "<span>?</span>" . __('Click on tooltip icons to view full documentation.', 'perfmatters');
				echo "</div>";
			echo "</div>";
		}

		//Tooltip Display Script
		echo "<script>
			(function ($) {
				$('.perfmatters-tooltip').hover(function(){
				    $(this).closest('tr').find('.perfmatters-tooltip-text-container').show();
				},function(){
				    $(this).closest('tr').find('.perfmatters-tooltip-text-container').hide();
				});
			}(jQuery));
		</script>";

	echo "</div>";
}
 
//Update Perfmatters Network Options
function perfmatters_update_network_options() {

	//Verify Post Referring Page
  	check_admin_referer('perfmatters_network-options');
 
	//Get Registered Options
	global $new_whitelist_options;
	$options = $new_whitelist_options['perfmatters_network'];

	//Loop Through Registered Options
	foreach($options as $option) {
		if(isset($_POST[$option])) {

			//Update Site Uption
			update_site_option($option, $_POST[$option]);
		}
	}

	//Redirect to Network Settings Page
	wp_redirect(add_query_arg(array('page' => 'perfmatters', 'updated' => 'true'), network_admin_url('settings.php')));

	exit;
}
add_action('network_admin_edit_perfmatters_update_network_options',  'perfmatters_update_network_options');

function perfmatters_edd_activate_network_license() {

	//retrieve the license from the database
	$license = trim(get_site_option('perfmatters_edd_license_key'));

	//data to send in our API request
	$api_params = array(
		'edd_action'=> 'activate_license',
		'license' 	=> $license,
		'item_name' => urlencode(PERFMATTERS_ITEM_NAME), // the name of our product in EDD
		'url'       => home_url()
	);

	//Call the custom API.
	$response = wp_remote_post(PERFMATTERS_STORE_URL, array('timeout' => 15, 'sslverify' => true, 'body' => $api_params));

	//make sure the response came back okay
	if(is_wp_error($response)) {
		return false;
	}

	//decode the license data
	$license_data = json_decode(wp_remote_retrieve_body($response));

	//$license_data->license will be either "valid" or "invalid"
	update_site_option('perfmatters_edd_license_status', $license_data->license);
}

function perfmatters_edd_deactivate_network_license() {

	// retrieve the license from the database
	$license = trim(get_site_option('perfmatters_edd_license_key'));

	// data to send in our API request
	$api_params = array(
		'edd_action'=> 'deactivate_license',
		'license' 	=> $license,
		'item_name' => urlencode(PERFMATTERS_ITEM_NAME), // the name of our product in EDD
		'url'       => home_url()
	);

	// Call the custom API.
	$response = wp_remote_post(PERFMATTERS_STORE_URL, array('timeout' => 15, 'sslverify' => true, 'body' => $api_params));

	// make sure the response came back okay
	if(is_wp_error($response)) {
		return false;
	}

	// decode the license data
	$license_data = json_decode(wp_remote_retrieve_body($response));

	// $license_data->license will be either "deactivated" or "failed"
	if($license_data->license == 'deactivated') {
		delete_site_option('perfmatters_edd_license_status');
	}
}

function perfmatters_edd_check_network_license() {

	global $wp_version;

	$license = trim(get_site_option('perfmatters_edd_license_key'));

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode(PERFMATTERS_ITEM_NAME),
		'url'       => home_url()
	);

	// Call the custom API.
	$response = wp_remote_post(PERFMATTERS_STORE_URL, array('timeout' => 15, 'sslverify' => true, 'body' => $api_params));

	if(is_wp_error($response)) {
		return false;
	}

	$license_data = json_decode(wp_remote_retrieve_body($response));

	if($license_data->license == 'valid') {
		update_site_option('perfmatters_edd_license_status', "valid");
	}
	else {
		update_site_option('perfmatters_edd_license_status', "invalid");
	}
	
	return($license_data);
}