<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
    exit;
}

include_once '_top-area.php';
?>
<div class="wrap wpacu-get-help-wrap">
    <h2><?php _e('In case you are stuck and need assistance, I can help you!', 'wp-asset-clean-up'); ?></h2>

    <p><span class="dashicons dashicons-info"></span> If you believe <?php echo WPACU_PLUGIN_TITLE; ?> has a bug (e.g. you're getting JavaScript or PHP errors generated by Asset CleanUp or the selected scripts are not unloading etc.) that needs to be fixed, then <a target="_blank" href="https://www.gabelivan.com/contact/">please report it by opening a support ticket</a>. Note that the support is only for reporting bugs and not for custom work request.</p>

    <p>In case you need professional help in one of the following scenarios and you don't have a developer available to provide what you need, then me or any of my colleagues from <a href="https://app.codeable.io/tasks/new?ref=d3TOr">Codeable</a>, would be able to assist you:</p>

    <ul class="hire-reasons">
        <li><span class="dashicons dashicons-yes"></span> You have many CSS and JavaScript files loaded in a page and you're not sure which ones you could prevent from loading, worrying that something could be messed up. A Codeable expert could analyse your pages and give the advices needed.</li>
        <li><span class="dashicons dashicons-yes"></span> You want to improve the speed of your website and you need help getting a faster loading page and a better Google PageSpeed score.</li>
        <li><span class="dashicons dashicons-yes"></span> You need help with a WordPress task and you're looking for a professional to help you with whatever you need.</li>
    </ul>

    <div class="wpacu-btns">
        <a class="btn btn-success" href="https://app.codeable.io/tasks/new?ref=d3TOr&preferredContractor=28168">Hire an Expert</a>
        &nbsp;&nbsp;
        <a class="btn btn-secondary" href="https://codeable.io/?ref=d3TOr">Find out more</a>
    </div>
</div>