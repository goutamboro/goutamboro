<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
	exit;
}

include_once '_top-area.php';

do_action('wpacu_admin_notices');

if ($data['mu_file_missing']) {
    ?>
    <div style="border-radius: 5px; line-height: 20px; background: white; padding: 8px; margin-bottom: 16px; width: 95%; border-left: 4px solid #CC0000; border-top: 1px solid #e7e7e7; border-right: 1px solid #e7e7e7; border-bottom: 1px solid #e7e7e7;">
        The MU plugin file that is filtering the plugins' rules wasn't copied successfully to <code><?php echo $data['mu_file_rel_path']; ?></code>. Please make sure the MU plugin directory is writeable or copy the file manually from <code>/wp-content/plugins/wp-asset-clean-up-pro/pro/mu-plugins/to-copy/wpacu-plugins-filter.php</code> to <code><?php echo $data['mu_file_rel_path']; ?></code>.
    </div>
    <?php
}
?>
<div style="border-radius: 5px; line-height: 20px; background: white; padding: 8px; margin-bottom: 16px; width: 95%; border-left: 4px solid #004567; border-top: 1px solid #e7e7e7; border-right: 1px solid #e7e7e7; border-bottom: 1px solid #e7e7e7;">
    <strong>Remember:</strong> Please be careful when using this feature as it would not only unload all the CSS/JS that is loading from a plugin, but everything else (e.g. its backend PHP code, HTML output printed via <code>wp_head()</code> or <code>wp_footer()</code> action hooks , cookies that are set). It would be like the plugin is deactivated for the pages where it's chosen to be unloaded. Consider enabling "Test Mode" in plugin's "Settings" if you're unsure about anything. Managing the plugin rules per page the same way it works with the CSS/JS manager is a feature that is not available yet as managing plugin rules is an option that has just been released. However, the RegEx unload rules can often achieve the same results. <span class="dashicons dashicons-info"></span> <a target="_blank" href="https://assetcleanup.com/docs/?p=372#wpacu-unload-plugins-via-regex"> Read more</a>
</div>
<p style="width: 95%;"><small><strong>Remember:</strong> All the rules are applied in the front-end view only. They are not taking effect within the Dashboard (the function <code style="font-size: inherit;">is_admin()</code> is used to verify that) to make sure nothing will get broken while you're configuring any plugins' settings. If you wish to completely stop using a plugin, the most effective way would be to deactivate it from the "Plugins" -&gt; "Installed Plugins" area.</small></p>
<div class="wpacu-wrap" id="wpacu-plugins-load-manager-wrap">
    <form method="post" action="">
        <?php
        $pluginsRows = array();

        foreach ($data['active_plugins'] as $pluginData) {
            $pluginPath = $pluginData['path'];
            list($pluginDir) = explode('/', $pluginPath);

            $pluginStatus = isset($data['rules'][$pluginPath]['status']) ? $data['rules'][$pluginPath]['status'] : '';

            ob_start();
        ?>
            <tr>
                <td class="wpacu_plugin_icon" width="40">
                    <?php if(isset($data['plugins_icons'][$pluginDir])) { ?>
                        <img width="40" height="40" alt="" src="<?php echo $data['plugins_icons'][$pluginDir]; ?>" />
                    <?php } else { ?>
                        <div><span class="dashicons dashicons-admin-plugins"></span></div>
                    <?php } ?>
                </td>
                <td class="wpacu_plugin_details">
                    <span class="wpacu_plugin_title"><?php echo $pluginData['title']; ?></span> <span class="wpacu_plugin_path">&nbsp;<small><?php echo $pluginData['path']; ?></small></span>
                    <div class="wpacu-clearfix"></div>

                    <div class="wrap_plugin_unload_rules_options">
                        <!-- [Start] Unload Rules -->
                        <div class="wpacu_plugin_rules_wrap">
                            <ul class="wpacu_plugin_rules">
                                <li>
                                    <label for="wpacu_global_load_plugin_<?php echo $pluginPath; ?>">
                                        <input data-wpacu-plugin-path="<?php echo $pluginPath; ?>"
                                               class="wpacu_plugin_load_it wpacu_plugin_load_rule_input"
                                               id="wpacu_global_load_plugin_<?php echo $pluginPath; ?>"
                                               type="radio"
                                               <?php if ($pluginStatus === '') { echo 'checked="checked"'; } ?>
                                               name="wpacu_plugins[<?php echo $pluginPath; ?>][status]"
                                               value="" />
                                        Always load it <small>(default)</small></label>
                                </li>
                            </ul>
                        </div>

	                    <?php
	                    $isUnloadSiteWide = ($pluginStatus === 'unload_site_wide');
	                    ?>
                        <div class="wpacu_plugin_rules_wrap">
                            <ul class="wpacu_plugin_rules">
                                <li>
                                    <label for="wpacu_global_unload_plugin_<?php echo $pluginPath; ?>"
                                        <?php if ($isUnloadSiteWide) { echo 'class="wpacu_plugin_unload_rule_input_checked"'; } ?>>
                                        <input data-wpacu-plugin-path="<?php echo $pluginPath; ?>"
                                               class="wpacu_plugin_unload_site_wide wpacu_plugin_unload_rule_input"
                                               id="wpacu_global_unload_plugin_<?php echo $pluginPath; ?>"
                                               type="radio"
                                               name="wpacu_plugins[<?php echo $pluginPath; ?>][status]"
	                                        <?php if ($isUnloadSiteWide) { echo 'checked="checked"'; } ?>
                                               value="unload_site_wide" />
                                        Unload site-wide (everywhere) <small>&amp; add exception</small></label>
                                </li>
                            </ul>
                        </div>

                        <?php
                        $isUnloadViaReEx = ($pluginStatus === 'unload_via_regex');
                        ?>
                        <div class="wpacu_plugin_rules_wrap">
                            <ul class="wpacu_plugin_rules">
                                <li>
                                    <label for="wpacu_unload_it_regex_option_<?php echo $pluginPath; ?>"
                                           <?php if ($isUnloadViaReEx) { echo 'class="wpacu_plugin_unload_rule_input_checked"'; } ?>
                                           style="margin-right: 0;">
                                        <input data-wpacu-plugin-path="<?php echo $pluginPath; ?>"
                                               id="wpacu_unload_it_regex_option_<?php echo $pluginPath; ?>"
                                               class="wpacu_plugin_unload_regex_radio wpacu_plugin_unload_rule_input"
                                               type="radio"
	                                        <?php if ($isUnloadViaReEx) { echo 'checked="checked"'; } ?>
                                               name="wpacu_plugins[<?php echo $pluginPath; ?>][status]"
                                               value="unload_via_regex">&nbsp;<span>Unload it only for URLs with request URI matching this RegEx(es):</span></label>
                                    <a class="help_link unload_it_regex"
                                       target="_blank"
                                       href="https://assetcleanup.com/docs/?p=372#wpacu-unload-plugins-via-regex"><span style="color: #74777b;" class="dashicons dashicons-editor-help"></span></a>
                                    <div data-wpacu-plugin-path="<?php echo $pluginPath; ?>"
                                         class="wpacu_plugin_unload_regex_input_wrap <?php if (! $isUnloadViaReEx) { ?>wpacu_hide<?php } ?>">
                                        <textarea name="wpacu_plugins[<?php echo $pluginPath; ?>][unload_via_regex][value]"><?php if (isset($data['rules'][$pluginPath]['unload_via_regex']['value']) && $data['rules'][$pluginPath]['unload_via_regex']['value']) {
		                                        echo esc_attr($data['rules'][$pluginPath]['unload_via_regex']['value']); } ?></textarea>
                                        <p><small><span style="font-weight: 500;">Note:</span> Multiple RegEx rules can be added as long as they are one per line.</small></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="wpacu-clearfix"></div>
                    </div>
                    <!-- [End] Unload Rules -->

                    <!-- [Start] Make exceptions: Load Rules -->
                    <?php
                    $isLoadViaRegExEnabled = isset($data['rules'][$pluginPath]['load_via_regex']['enable']) && $data['rules'][$pluginPath]['load_via_regex']['enable'];
                    $isLoadIfLoggedInEnabled = isset($data['rules'][$pluginPath]['load_logged_in']['enable']) && $data['rules'][$pluginPath]['load_logged_in']['enable'];
                    ?>
                    <div data-wpacu-plugin-path="<?php echo $pluginPath; ?>"
                         class="wrap_plugin_load_exception_options <?php if ( ! ($isUnloadSiteWide || $isUnloadViaReEx) ) { ?>wpacu_hide<?php } ?>">
                        <div class="wpacu_plugin_rules_wrap">
                            <ul class="wpacu_plugin_rules wpacu_exception_options_area">
                                <li>
                                    <label for="wpacu_load_it_regex_option_plugin_<?php echo $pluginPath; ?>" style="margin-right: 0;">
                                        <input data-wpacu-plugin-path="<?php echo $pluginPath; ?>"
                                               id="wpacu_load_it_regex_option_plugin_<?php echo $pluginPath; ?>"
                                               class="wpacu_plugin_load_exception_regex"
                                               type="checkbox"
		                                      <?php if ($isLoadViaRegExEnabled) { echo 'checked="checked"'; } ?>
                                               name="wpacu_plugins[<?php echo $pluginPath; ?>][load_via_regex][enable]"
                                               value="1" />&nbsp;<span>Make an exception and always load it if the URL (its URI) is matched by a RegEx(es):</span>
                                    </label>&nbsp;<a style="color: #74777b;" class="help_link" target="_blank" href="https://assetcleanup.com/docs/?p=372#wpacu-unload-plugins-via-regex"><span class="dashicons dashicons-editor-help"></span></a>&nbsp;
                                    <div class="wpacu_load_regex_input_wrap <?php if (! $isLoadViaRegExEnabled) { echo 'wpacu_hide'; } ?>"
                                         data-wpacu-plugin-path="<?php echo $pluginPath; ?>">
                                        <textarea name="wpacu_plugins[<?php echo $pluginPath; ?>][load_via_regex][value]"><?php if (isset($data['rules'][$pluginPath]['load_via_regex']['value']) && $data['rules'][$pluginPath]['load_via_regex']['value']) {
		                                        echo esc_attr($data['rules'][$pluginPath]['load_via_regex']['value']); } ?></textarea>
                                        <p><small><span style="font-weight: 500;">Note:</span> Multiple RegEx rules can be added as long as they are one per line.</small></p>
                                    </div>
                                </li>
                                <li>
                                    <label for="wpacu_load_it_logged_in_plugin_<?php echo $pluginPath; ?>" style="margin-right: 0;">
                                        <input data-wpacu-plugin-path="<?php echo $pluginPath; ?>"
                                               id="wpacu_load_it_logged_in_plugin_<?php echo $pluginPath; ?>"
                                               class="wpacu_plugin_load_exception_logged_in"
                                               type="checkbox"
			                                <?php if ($isLoadIfLoggedInEnabled) { echo 'checked="checked"'; } ?>
                                               name="wpacu_plugins[<?php echo $pluginPath; ?>][load_logged_in][enable]"
                                               value="1" />&nbsp;<span>Always load it if the user is logged in</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="wpacu-clearfix"></div>
                    <!-- [End] Make exceptions: Load Rules -->
                </td>
            </tr>
            <?php
            $trOutput = ob_get_clean();

            if ($pluginStatus === '') {
                $pluginsRows['always_loaded'][] = $trOutput;
            } else {
	            $pluginsRows['has_unload_rules'][] = $trOutput;
            }
        }

        if (isset($pluginsRows['has_unload_rules']) && ! empty($pluginsRows['has_unload_rules'])) {
            $totalWithUnloadRulesPlugins = count($pluginsRows['has_unload_rules']);
            ?>
            <h3><span style="color: #c00;" class="dashicons dashicons-admin-plugins"></span> <span style="color: #c00;"><?php echo $totalWithUnloadRulesPlugins; ?></span> plugin<?php echo ($totalWithUnloadRulesPlugins > 1) ? 's' : ''; ?> with active unload rules</h3>
            <table class="wp-list-table wpacu-list-table widefat plugins striped">
                <?php
                foreach ( $pluginsRows['has_unload_rules'] as $pluginRowOutput ) {
                    echo $pluginRowOutput . "\n";
                }
                ?>
            </table>
            <?php
        }

        if (isset($pluginsRows['always_loaded']) && ! empty($pluginsRows['always_loaded'])) {
            if (isset($pluginsRows['has_unload_rules']) && count($pluginsRows['has_unload_rules']) > 0) {
                ?>
                <div style="margin-top: 35px;"></div>
                <?php
            }

            $totalAlwaysLoadedPlugins = count($pluginsRows['always_loaded']);
            ?>

            <h3><span style="color: green;" class="dashicons dashicons-admin-plugins"></span> <span style="color: green;"><?php echo $totalAlwaysLoadedPlugins; ?></span> plugin<?php echo ($totalAlwaysLoadedPlugins > 1) ? 's' : ''; ?> with no active unload rules (loaded by default)</h3>
            <table class="wp-list-table wpacu-list-table widefat plugins striped">
                <?php
                foreach ( $pluginsRows['always_loaded'] as $pluginRowOutput ) {
                    echo $pluginRowOutput . "\n";
                }
                ?>
            </table>
            <?php
        }
        ?>
        <div id="wpacu-update-button-area" style="margin-left: 0;">
            <?php
            wp_nonce_field('wpacu_plugin_manager_update', 'wpacu_plugin_manager_nonce');
            submit_button('Apply changes');
            ?>
            <div id="wpacu-updating-settings" style="margin-left: 148px; top: 30px;">
                <img src="<?php echo admin_url('images/spinner.gif'); ?>" align="top" width="20" height="20" alt="" />
            </div>
            <input type="hidden" name="wpacu_plugins_manager_submit" value="1" />
        </div>
    </form>
</div>