<?php 
//if no tab is set, default to first/options tab
if(empty($_GET['tab'])) {
	$_GET['tab'] = 'options';
} 
?>
<div class="wrap perfmatters-admin">

	<h2 style="display: none;"></h2>

    <!-- Tab Navigation -->
	<div class="nav-tab-wrapper">
		<a href="?page=perfmatters&tab=options" class="nav-tab <?php echo $_GET['tab'] == 'options' || '' ? 'nav-tab-active' : ''; ?>"><?php _e('Options', 'perfmatters'); ?></a>
		<a href="?page=perfmatters&tab=cdn" class="nav-tab <?php echo $_GET['tab'] == 'cdn' ? 'nav-tab-active' : ''; ?>"><?php _e('CDN', 'perfmatters'); ?></a>
		<a href="?page=perfmatters&tab=ga" class="nav-tab <?php echo $_GET['tab'] == 'ga' ? 'nav-tab-active' : ''; ?>"><?php _e('Google Analytics', 'perfmatters'); ?></a>
		<a href="?page=perfmatters&tab=extras" class="nav-tab <?php echo $_GET['tab'] == 'extras' ? 'nav-tab-active' : ''; ?>"><?php _e('Extras', 'perfmatters'); ?></a>
		<?php if(!is_plugin_active_for_network('perfmatters/perfmatters.php')) { ?>
			<a href="?page=perfmatters&tab=license" class="nav-tab <?php echo $_GET['tab'] == 'license' ? 'nav-tab-active' : ''; ?>"><?php _e('License', 'perfmatters'); ?></a>
		<?php } ?>
	</div>

	<!-- Plugin Options Form -->
	<form method="post" action="options.php" id='perfmatters-options-form' <?php echo $_GET['tab'] == 'extras' ? "enctype='multipart/form-data'" : ""; ?>>

		<!-- Main Options Tab -->
		<?php if($_GET['tab'] == 'options') { ?>

			    <?php settings_fields('perfmatters_options'); ?>
			    <?php do_settings_sections('perfmatters_options'); ?>
				<?php submit_button(); ?>

		<!-- CDN Tab -->
		<?php } elseif($_GET['tab'] == 'cdn') { ?>

				<?php settings_fields('perfmatters_cdn'); ?>
			    <?php do_settings_sections('perfmatters_cdn'); ?>
				<?php submit_button(); ?>

		<!-- Google Analytics Tab -->
		<?php } elseif($_GET['tab'] == 'ga') { ?>

				<?php settings_fields('perfmatters_ga'); ?>
			    <?php do_settings_sections('perfmatters_ga'); ?>
				<?php submit_button(); ?>

		<!-- Extras Tab -->
		<?php } elseif($_GET['tab'] == 'extras') { ?>

				<?php

				//extras subnav
				echo "<input type='hidden' name='section' id='subnav-section' />";
				echo "<div class='perfmatters-subnav'>";
					echo "<a href='#extras-general' id='general-section' rel='general' class='active'><span class='dashicons dashicons-dashboard'></span>" . __('General', 'novashare') . "</a>";
					echo "<a href='#extras-tools' id='tools-section' rel='tools'><span class='dashicons dashicons-admin-tools'></span>" . __('Tools', 'novashare') . "</a>";
				echo "</div>";

				?>

				<?php settings_fields('perfmatters_extras'); ?>

				<section id='extras-general' class='section-content active'>
			    	<?php perfmatters_settings_section('perfmatters_extras', 'general'); ?>
			    	<?php submit_button(); ?>
			    </section>

				<section id='extras-tools' class='section-content hide'>
					<?php perfmatters_settings_section('perfmatters_extras', 'tools'); ?>
					<?php submit_button(); ?>
				</section>

		<!-- License and Activation Tab -->
		<?php } elseif($_GET['tab'] == 'license') { ?>

			<?php require_once('license.php'); ?>

		<?php } ?>

	</form>

	<?php if($_GET['tab'] != 'license') { ?>

		<div id="perfmatters-legend">
			<div id="perfmatters-tooltip-legend">
				<span>?</span><?php _e('Click on tooltip icons to view full documentation.', 'perfmatters'); ?>
			</div>
		</div>

	<?php } ?>

	<script>
		(function ($) {
			$(".perfmatters-tooltip").hover(function(){
			    $(this).closest("tr").find(".perfmatters-tooltip-text-container").show();
			},function(){
			    $(this).closest("tr").find(".perfmatters-tooltip-text-container").hide();
			});
		}(jQuery));
	</script>
	
</div>