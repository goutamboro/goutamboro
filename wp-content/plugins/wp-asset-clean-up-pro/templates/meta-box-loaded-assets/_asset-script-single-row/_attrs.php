<?php
/*
 * The file is included from /templates/meta-box-loaded-assets/_asset-script-single-row.php
*/

if (! isset($data)) {
	exit; // no direct access
}
?>

<!-- [wpacu_pro] -->
<?php if (isset($data['row']['obj']->src) && $data['row']['obj']->src !== '') {
	$isAsyncGlobal = (in_array($data['row']['obj']->handle, $data['scripts_attributes']['everywhere']['async']));
	$isDeferGlobal = (in_array($data['row']['obj']->handle, $data['scripts_attributes']['everywhere']['defer']));
	?>
	<div class="wpacu-script-attributes-area wpacu-pro">
		<div <?php if ($isAsyncGlobal || $isDeferGlobal) { echo 'style="display: block; width: 100%;"'; } ?>>If kept loaded, set the following attributes:</div>
		<ul class="wpacu-script-attributes-settings wpacu-first">
			<li><strong><u>async</u></strong> &#10230;</li>
			<li><label for="async_on_this_page_<?php echo $data['row']['obj']->handle; ?>"><input
						<?php if ( $isAsyncGlobal ) { ?>disabled="disabled"<?php } ?>
						id="async_on_this_page_<?php echo $data['row']['obj']->handle; ?>"
						class="wpacu_script_attr_rule_input"
						type="checkbox"
						name="wpacu_async[<?php echo $data['row']['obj']->handle; ?>]" <?php if ( in_array( $data['row']['obj']->handle,
						$data['scripts_attributes']['on_this_page']['async'] ) ) {
						echo 'checked="checked"';
					} ?> value="on_this_page"/>on this page <?php if ( $isAsyncGlobal ) { ?><br/><small>*
						locked by site-wide rule</small><?php } ?></label></li>
			<li>
				<?php if ($isAsyncGlobal) { ?>
					<div><strong>Set everywhere</strong> <small>* site-wide</small></div>
					<div>
						<label><input data-handle="<?php echo $data['row']['obj']->handle; ?>"
						              type="radio"
						              name="wpacu_options_global_attribute_scripts[async][<?php echo $data['row']['obj']->handle; ?>]"
						              checked="checked"
						              value="default"/>
							Keep rule</label>

						&nbsp;&nbsp;&nbsp;&nbsp;

						<label><input data-handle="<?php echo $data['row']['obj']->handle; ?>"
						              type="radio"
						              name="wpacu_options_global_attribute_scripts[async][<?php echo $data['row']['obj']->handle; ?>]"
						              value="remove"/>
							Remove rule</label>
					</div>
				<?php } else { ?>
					<label for="async_everywhere_<?php echo $data['row']['obj']->handle; ?>"><input
							id="async_everywhere_<?php echo $data['row']['obj']->handle; ?>"
							class="wpacu_script_attr_rule_input wpacu_script_attr_rule_global"
							type="checkbox"
							name="wpacu_async[<?php echo $data['row']['obj']->handle; ?>]"
							value="everywhere"/>everywhere</label>
				<?php } ?>
			</li>
			<li class="wpacu-script-attr-make-exception <?php if (! $isAsyncGlobal) { ?>wpacu_hide<?php } ?>">
				<label for="async_none_<?php echo $data['row']['obj']->handle; ?>">
					<input id="async_none_<?php echo $data['row']['obj']->handle; ?>"
					       type="checkbox"
					       name="wpacu_async[no_load][]"
						<?php if (in_array($data['row']['obj']->handle, $data['scripts_attributes']['not_on_this_page']['async'])) { ?>
							checked="checked"
						<?php } ?>
						   value="<?php echo $data['row']['obj']->handle; ?>" />not here (exception)
				</label>
			</li>
		</ul>
		<ul class="wpacu-script-attributes-settings">
			<li><strong><u>defer</u></strong> &#10230;</li>
			<li><label for="defer_on_this_page_<?php echo $data['row']['obj']->handle; ?>"><input
						<?php if ( $isDeferGlobal ) { ?>disabled="disabled"<?php } ?>
						id="defer_on_this_page_<?php echo $data['row']['obj']->handle; ?>"
						class="wpacu_script_attr_rule_input"
						type="checkbox"
						name="wpacu_defer[<?php echo $data['row']['obj']->handle; ?>]" <?php if ( in_array( $data['row']['obj']->handle,
						$data['scripts_attributes']['on_this_page']['defer'] ) ) {
						echo 'checked="checked"';
					} ?> value="on_this_page"/>on this page <?php if ( $isDeferGlobal ) { ?><br/><small>*
						locked by site-wide rule</small><?php } ?></label></li>
			<li>
				<?php if ($isDeferGlobal) { ?>
					<div><strong>Set everywhere</strong> <small>* site-wide</small></div>
					<div>
						<label><input data-handle="<?php echo $data['row']['obj']->handle; ?>"
						              type="radio"
						              name="wpacu_options_global_attribute_scripts[defer][<?php echo $data['row']['obj']->handle; ?>]"
						              checked="checked"
						              value="default"/>
							Keep rule</label>

						&nbsp;&nbsp;&nbsp;&nbsp;

						<label><input data-handle="<?php echo $data['row']['obj']->handle; ?>"
						              type="radio"
						              name="wpacu_options_global_attribute_scripts[defer][<?php echo $data['row']['obj']->handle; ?>]"
						              value="remove"/>
							Remove rule</label>
					</div>
				<?php } else { ?>
					<label for="defer_everywhere_<?php echo $data['row']['obj']->handle; ?>"><input
							id="defer_everywhere_<?php echo $data['row']['obj']->handle; ?>"
							class="wpacu_script_attr_rule_input wpacu_script_attr_rule_global"
							type="checkbox"
							name="wpacu_defer[<?php echo $data['row']['obj']->handle; ?>]"
							value="everywhere"/>everywhere</label>
				<?php } ?>
			</li>
			<li class="wpacu-script-attr-make-exception <?php if (! $isDeferGlobal) { ?>wpacu_hide<?php } ?>">
				<label for="defer_none_<?php echo $data['row']['obj']->handle; ?>">
					<input id="defer_none_<?php echo $data['row']['obj']->handle; ?>"
					       type="checkbox"
					       name="wpacu_defer[no_load][]"
						<?php if (in_array($data['row']['obj']->handle, $data['scripts_attributes']['not_on_this_page']['defer'])) { ?>
							checked="checked"
						<?php } ?>
						   value="<?php echo $data['row']['obj']->handle; ?>" />not here (exception)
				</label>
			</li>
		</ul>
		<div class="wpacu-clearfix"></div>
	</div>
	<div class="wpacu-clearfix"></div>
<?php } ?>
<!-- [/wpacu_pro] -->