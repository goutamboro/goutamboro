<?php
namespace WpAssetCleanUp;

use WpAssetCleanUp\OptimiseAssets\OptimizeCommon;

/**
 * Class Debug
 * @package WpAssetCleanUp
 */
class Debug
{
	/**
	 * Debug constructor.
	 */
	public function __construct()
	{
		if (array_key_exists('wpacu_debug', $_GET)) {
			add_action('wp_footer', array($this, 'showDebugOptions'), PHP_INT_MAX);
		}

		foreach(array('wp', 'admin_init') as $wpacuActionHook) {
			add_action( $wpacuActionHook, static function() {
				if ( isset( $_GET['wpacu_get_cache_dir_size'] ) && Menu::userCanManageAssets() ) {
					self::printCacheDirInfo();
				}

				} );
		}
	}

	/**
	 *
	 */
	public function showDebugOptions()
	{
	    if (! Menu::userCanManageAssets()) {
	        return;
        }

	    $markedCssListForUnload = array_unique(Main::instance()->allUnloadedAssets['css']);
		$markedJsListForUnload  = array_unique(Main::instance()->allUnloadedAssets['js']);

		$allDebugOptions = array(
			// CSS
			'wpacu_no_css_unload'    => 'Do not apply any CSS unload rules',
			'wpacu_no_css_minify'    => 'Do not minify any CSS',
			'wpacu_no_css_combine'   => 'Do not combine any CSS',

			// JS
			'wpacu_no_js_unload'     => 'Do not apply any JavaScript unload rules',
			'wpacu_no_js_minify'     => 'Do not minify any JavaScript',
			'wpacu_no_js_combine'    => 'Do not combine any JavaScript',

			// [wpacu_pro]
			'wpacu_no_async'         => 'Do not async load any JavaScript',
			'wpacu_no_defer'         => 'Do not defer load any JavaScript',
			// [/wpacu_pro]

			// Others
			'wpacu_no_frontend_show' => 'Do not show the bottom CSS/JS managing list',
			'wpacu_no_admin_bar'     => 'Do not show the admin bar',
			'wpacu_no_html_changes'  => 'Do not alter the HTML DOM (this will also load all assets non-minified and non-combined)',
		);
		?>
		<style type="text/css">
			#wpacu-debug-options {
                background: white;
                width: 90%;
                margin: 10px;
				border: 1px solid #cdcdcd;
				border-radius: 5px;
				padding: 12px;
			}

            #wpacu-debug-options p {
                margin-bottom: 15px;
            }

            #wpacu-debug-options ul.wpacu-options {
                list-style: none;
                padding-left: 0;
                margin-top: 0;
                margin-left: 8px;
            }

            #wpacu-debug-options ul.wpacu-options li {
                line-height: normal;
                font-size: inherit;
            }

			#wpacu-debug-options ul.wpacu-options li label {
				cursor: pointer;
                font-size: inherit;
			}

            #wpacu-debug-options table td {
                padding: 20px;
            }

            ul#wpacu-debug-timing {
                margin-left: 0;
                padding-left: 0;
            }

			ul#wpacu-debug-timing > li {
				list-style: none;
				padding-left: 20px;
			}

			ul#wpacu-debug-timing li > ul > li {
				list-style: disc;
				padding-left: 0;
			}
		</style>

		<div id="wpacu-debug-options">
            <table>
                <tr>
                    <td valign="top">
                        <p>View the page with the following options <strong>disabled</strong> (for debugging purposes):</p>
                        <form>
                            <ul class="wpacu-options">
                            <?php
                            foreach ($allDebugOptions as $debugKey => $debugText) {
                            ?>
                                <li>
                                    <label><input type="checkbox"
                                                  name="<?php echo $debugKey; ?>"
                                                  <?php if (array_key_exists($debugKey, $_GET)) { echo 'checked="checked"'; } ?> /> &nbsp;<?php echo $debugText; ?></label>
                                </li>
                            <?php
                            }
                            ?>
                            </ul>
                            <div>
                                <input type="submit"
                                       value="View page with the chosen options turned off" />
                            </div>
                            <input type="hidden" name="wpacu_debug" value="on" />
                        </form>
                    </td>
                    <td valign="top">
                        <?php
                        // [wpacu_pro]
                        if (isset($GLOBALS['wpacu_filtered_plugins']) && $wpacuFilteredPlugins = $GLOBALS['wpacu_filtered_plugins']) {
                            sort($wpacuFilteredPlugins);
                            ?>
                            <p><strong>Unloaded plugins:</strong> The following plugins were unloaded on this page using the rules from "Plugins Manager" (within Asset CleanUp Pro's menu):</p>
                            <ul>
                                <?php
                                foreach ($wpacuFilteredPlugins as $filteredPlugin) {
                                    echo '<li style="color: darkred;">'.$filteredPlugin.'</li>'."\n";
                                }
                                ?>
                            </ul>
                        <?php
                        }
                        // [/wpacu_pro]
                        ?>

	                    <div style="margin: 0 0 10px; padding: 10px 0;">
	                        <strong>CSS handles marked for unload:</strong>&nbsp;
	                        <?php
	                        if (! empty($markedCssListForUnload)) {
	                            sort($markedCssListForUnload);
		                        $markedCssListForUnloadFiltered = array_map(static function($handle) {
		                        	return '<span style="color: darkred;">'.$handle.'</span>';
		                        }, $markedCssListForUnload);
	                            echo implode(' &nbsp;/&nbsp; ', $markedCssListForUnloadFiltered);
	                        } else {
	                            echo 'None';
	                        }
	                        ?>
	                    </div>

	                    <div style="margin: 0 0 10px; padding: 10px 0;">
	                        <strong>JS handles marked for unload:</strong>&nbsp;
	                        <?php
	                        if (! empty($markedJsListForUnload)) {
	                            sort($markedJsListForUnload);
		                        $markedJsListForUnloadFiltered = array_map(static function($handle) {
			                        return '<span style="color: darkred;">'.$handle.'</span>';
		                        }, $markedJsListForUnload);

	                            echo implode(' &nbsp;/&nbsp; ', $markedJsListForUnloadFiltered);
	                        } else {
	                            echo 'None';
	                        }
	                        ?>
	                    </div>

	                    <hr />

                        <div style="margin: 0 0 10px; padding: 10px 0;">
							<ul style="list-style: none; padding-left: 0;">
                                <li style="margin-bottom: 10px;">Dequeue any chosen styles (.css): <?php echo Misc::printTimingFor('filter_dequeue_styles',  '{wpacu_filter_dequeue_styles_exec_time} ({wpacu_filter_dequeue_styles_exec_time_sec})'); ?></li>
                                <li style="margin-bottom: 20px;">Dequeue any chosen scripts (.js): <?php echo Misc::printTimingFor('filter_dequeue_scripts', '{wpacu_filter_dequeue_scripts_exec_time} ({wpacu_filter_dequeue_scripts_exec_time_sec})'); ?></li>

                                <li style="margin-bottom: 10px;">Prepare CSS files to optimize: {wpacu_prepare_optimize_files_css_exec_time} ({wpacu_prepare_optimize_files_css_exec_time_sec})</li>
                                <li style="margin-bottom: 20px;">Prepare JS files to optimize: {wpacu_prepare_optimize_files_js_exec_time} ({wpacu_prepare_optimize_files_js_exec_time_sec})</li>

                                <li style="margin-bottom: 10px;">OptimizeCommon - HTML alteration via <em>wp_loaded</em>: {wpacu_alter_html_source_exec_time} ({wpacu_alter_html_source_exec_time_sec})
                                    <ul id="wpacu-debug-timing">
                                        <li style="margin-top: 10px; margin-bottom: 10px;">&nbsp;OptimizeCSS: {wpacu_alter_html_source_for_optimize_css_exec_time} ({wpacu_alter_html_source_for_optimize_css_exec_time_sec})
                                            <ul>
                                                <li>Google Fonts Optimization/Removal: {wpacu_alter_html_source_for_google_fonts_optimization_removal_exec_time}</li>
                                                <li>From CSS file to Inline: {wpacu_alter_html_source_for_inline_css_exec_time}</li>
                                                <li>Update Original to Optimized: {wpacu_alter_html_source_original_to_optimized_css_exec_time}</li>
                                                <li>Move CSS LINKs (HEAD to BODY and vice-versa): {wpacu_alter_html_source_for_change_css_position_exec_time}</li>
                                                <li>Preloads: {wpacu_alter_html_source_for_preload_css_exec_time}</li>
	                                            <!-- [wpacu_pro] -->
                                                    <li>Preloads (NOSCRIPT fallback): {wpacu_alter_html_source_for_add_async_preloads_noscript_exec_time}</li>
	                                            <!-- [/wpacu_pro] -->
                                                <!-- -->
                                                <li>Combine: {wpacu_alter_html_source_for_combine_css_exec_time}</li>
                                                <li>Minify Inline Tags: {wpacu_alter_html_source_for_minify_inline_style_tags_exec_time}</li>
                                                <li>Unload (ignore dependencies): {wpacu_alter_html_source_unload_ignore_deps_css_exec_time}</li>
	                                            <!-- [wpacu_pro] -->
                                                    <li>Defer Footer CSS: {wpacu_alter_html_source_for_defer_footer_css_exec_time}</li>
	                                                <li>Alter Inline CSS (font-display): {wpacu_local_fonts_display_style_inline_exec_time}</li>
	                                            <!-- [/wpacu_pro] -->
                                            </ul>
                                        </li>

                                        <li style="margin-top: 10px; margin-bottom: 10px;">OptimizeJs: {wpacu_alter_html_source_for_optimize_js_exec_time} ({wpacu_alter_html_source_for_optimize_js_exec_time_sec})
                                            <ul>
	                                            <!-- [wpacu_pro] -->
                                                    <li>From JS File to Inline: {wpacu_alter_html_source_for_inline_js_exec_time}</li>
	                                            <!-- [/wpacu_pro] -->
                                                <li>Update Original to Optimized: {wpacu_alter_html_source_original_to_optimized_js_exec_time}</li>
                                                <li>Preloads: {wpacu_alter_html_source_for_preload_js_exec_time}</li>
                                                <!-- -->
                                                <li>Combine: {wpacu_alter_html_source_for_combine_js_exec_time}</li>
	                                            <!-- [wpacu_pro] -->
	                                                <li>Move scripts to BODY: {wpacu_alter_html_source_move_scripts_to_body_exec_time}</li>
                                                    <li>Minify Inline Tags: {wpacu_alter_html_source_for_minify_inline_script_tags_exec_time}</li>
	                                            <!-- [/wpacu_pro] -->
                                                <li>Unload (ignore dependencies): {wpacu_alter_html_source_unload_ignore_deps_js_exec_time}</li>
                                                <li>Move any inline wih jQuery code after jQuery library: {wpacu_alter_html_source_move_inline_jquery_after_src_tag_exec_time}</li>
                                            </ul>
                                        </li>

                                        <li style="margin-top: 10px; margin-bottom: 10px;">Hardcoded CSS/JS (fetch &amp; strip): {wpacu_fetch_strip_hardcoded_assets_exec_time}
                                            <ul>
	                                            <li>Fetch Marked for Unload: {wpacu_fetch_marked_for_unload_hardcoded_assets_exec_time}</li>
	                                            <li>Fetch All from the Current Page: {wpacu_fetch_all_hardcoded_assets_exec_time}</li>
	                                            <li>Strip Marked For Unload: {wpacu_strip_marked_hardcoded_assets_exec_time}</li>
                                            </ul>
                                        </li>

                                        <li>HTML CleanUp: {wpacu_alter_html_source_cleanup_exec_time}
                                            <ul>
                                                <li>Strip HTML Comments: {wpacu_alter_html_source_for_remove_html_comments_exec_time}</li>
	                                            <li>Remove Generator Meta Tags: {wpacu_alter_html_source_for_remove_meta_generators_exec_time}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

								<li style="margin-bottom: 10px;">Output CSS &amp; JS Management List: {wpacu_output_css_js_manager_exec_time} ({wpacu_output_css_js_manager_exec_time_sec})</li>

                                <!-- -->
							</ul>
	                    </div>
                    </td>
                </tr>
            </table>
		</div>
		<?php
	}

	/**
	 *
	 */
	public static function printCacheDirInfo()
    {
    	$assetCleanUpCacheDirRel = OptimizeCommon::getRelPathPluginCacheDir();
	    $assetCleanUpCacheDir  = WP_CONTENT_DIR . $assetCleanUpCacheDirRel;

	    echo '<h3>'.WPACU_PLUGIN_TITLE.': Caching Directory Stats</h3>';

	    if (is_dir($assetCleanUpCacheDir)) {
	    	$printCacheDirOutput = str_replace($assetCleanUpCacheDirRel, '<strong>'.$assetCleanUpCacheDirRel.'</strong>', $assetCleanUpCacheDir).'</em>';
		    if (! is_writable($assetCleanUpCacheDir)) {
			    echo '<span style="color: red;">'.
			            'The '.$printCacheDirOutput.' directory is <em>not writable</em>.</span>'.
			         '<br /><br />';
		    } else {
			    echo '<span style="color: green;">The '.$printCacheDirOutput.' directory is <em>writable</em>.</span>' . '<br /><br />';
		    }

		    $dirItems = new \RecursiveDirectoryIterator( $assetCleanUpCacheDir,
			    \RecursiveDirectoryIterator::SKIP_DOTS );

		    $totalFiles = 0;
		    $totalSize  = 0;

		    foreach (
			    new \RecursiveIteratorIterator( $dirItems, \RecursiveIteratorIterator::SELF_FIRST,
				    \RecursiveIteratorIterator::CATCH_GET_CHILD ) as $item
		    ) {
			    if ($item->isDir()) {
			    	echo '<br />';

				    $appendAfter = ' - ';

			    	if (is_writable($item)) {
					    $appendAfter .= ' <em><strong>writable</strong> directory</em>';
				    } else {
					    $appendAfter .= ' <em><strong style="color: red;">not writable</strong> directory</em>';
				    }
			    } elseif ($item->isFile()) {
			    	$appendAfter = '(<em>'.Misc::formatBytes($item->getSize()).'</em>)';

			    	echo '&nbsp;-&nbsp;';
			    }
			    echo $item.' '.$appendAfter.'<br />';
			    if ( $item->isFile() ) {
				    $totalSize += $item->getSize();
				    $totalFiles ++;
			    }
		    }

		    echo '<br />'.'Total Files: <strong>'.$totalFiles.'</strong> / Total Size: <strong>'.Misc::formatBytes($totalSize).'</strong>';
	    } else {
		    echo 'The directory does not exists.';
	    }

	    exit();
    }
}
