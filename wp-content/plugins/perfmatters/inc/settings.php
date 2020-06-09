<?php
//register settings + options
function perfmatters_settings() {
	if(get_option('perfmatters_options') == false) {	
		add_option('perfmatters_options', apply_filters('perfmatters_default_options', perfmatters_default_options()));
	}

    //Options Primary Section
    add_settings_section('perfmatters_options', __('Options', 'perfmatters'), 'perfmatters_options_callback', 'perfmatters_options');

    //Disable Emojis
    add_settings_field(
    	'disable_emojis', 
    	perfmatters_title(__('Disable Emojis', 'perfmatters'), 'disable_emojis') . perfmatters_tooltip('https://perfmatters.io/docs/disable-emojis-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
            'id' => 'disable_emojis',
            'tooltip' => __('Removes WordPress Emojis JavaScript file (wp-emoji-release.min.js).', 'perfmatters')
        )
    );

    //Disable Embeds
    add_settings_field(
    	'disable_embeds', 
    	perfmatters_title(__('Disable Embeds', 'perfmatters'), 'disable_embeds') . perfmatters_tooltip('https://perfmatters.io/docs/disable-embeds-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'disable_embeds',
    		'tooltip' => __('Removes WordPress Embed JavaScript file (wp-embed.min.js).', 'perfmatters')   		
    	)
    );

    //Remove Query Strings
    add_settings_field(
    	'remove_query_strings', 
    	perfmatters_title(__('Remove Query Strings', 'perfmatters'), 'remove_query_strings') . perfmatters_tooltip('https://perfmatters.io/docs/remove-query-strings-from-static-resources/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'remove_query_strings',
    		'tooltip' => __('Remove query strings from static resources (CSS, JS).', 'perfmatters')
    	)
    );

	//Disable XML-RPC
    add_settings_field(
    	'disable_xmlrpc', 
    	perfmatters_title(__('Disable XML-RPC', 'perfmatters'), 'disable_xmlrpc') . perfmatters_tooltip('https://perfmatters.io/docs/disable-xml-rpc-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'disable_xmlrpc',
    		'tooltip' => __('Disables WordPress XML-RPC functionality.', 'perfmatters')
    	)
    );

	//Remove jQuery Migrate
    add_settings_field(
    	'remove_jquery_migrate', 
    	perfmatters_title(__('Remove jQuery Migrate', 'perfmatters'), 'remove_jquery_migrate') . perfmatters_tooltip('https://perfmatters.io/docs/remove-jquery-migrate-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'remove_jquery_migrate',
    		'tooltip' => __('Removes jQuery Migrate JavaScript file (jquery-migrate.min.js).', 'perfmatters')
    	)
    );

    //Hide WP Version
    add_settings_field(
    	'hide_wp_version', 
    	perfmatters_title(__('Hide WP Version', 'perfmatters'), 'hide_wp_version') . perfmatters_tooltip('https://perfmatters.io/docs/remove-wordpress-version-number/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'hide_wp_version',
    		'tooltip' => __('Removes WordPress version meta tag.', 'perfmatters')
    	)
    );

    //Remove wlmanifest Link
    add_settings_field(
    	'remove_wlwmanifest_link', 
    	perfmatters_title(__('Remove wlwmanifest Link', 'perfmatters'), 'remove_wlwmanifest_link') . perfmatters_tooltip('https://perfmatters.io/docs/remove-wlwmanifest-link-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options',
        array(
        	'id' => 'remove_wlwmanifest_link',
        	'tooltip' => __('Remove wlwmanifest (Windows Live Writer) link tag.', 'perfmatters')
        )
    );

    //Remove RSD Link
    add_settings_field(
    	'remove_rsd_link', 
    	perfmatters_title(__('Remove RSD Link', 'perfmatters'), 'remove_rsd_link') . perfmatters_tooltip('https://perfmatters.io/docs/remove-rsd-link-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'remove_rsd_link',
    		'tooltip' => __('Remove RSD (Real Simple Discovery) link tag.', 'perfmatters')
    	)
    );

    //Remove Shortlink
    add_settings_field(
    	'remove_shortlink', 
    	perfmatters_title(__('Remove Shortlink', 'perfmatters'), 'remove_shortlink') . perfmatters_tooltip('https://perfmatters.io/docs/remove-shortlink-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'remove_shortlink',
    		'tooltip' => __('Remove Shortlink link tag.', 'perfmatters')
    	)
    );

    //Disable RSS Feeds
    add_settings_field(
    	'disable_rss_feeds', 
    	perfmatters_title(__('Disable RSS Feeds', 'perfmatters'), 'disable_rss_feeds') . perfmatters_tooltip('https://perfmatters.io/docs/disable-rss-feeds-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'disable_rss_feeds',
    		'tooltip' => __('Disable WordPress generated RSS feeds and 301 redirect URL to parent.', 'perfmatters')
    	)
    );

    //Remove Feed Links
    add_settings_field(
    	'remove_feed_links', 
    	perfmatters_title(__('Remove RSS Feed Links', 'perfmatters'), 'remove_feed_links') . perfmatters_tooltip('https://perfmatters.io/docs/remove-rss-feed-links-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'remove_feed_links',
    		'tooltip' => __('Disable WordPress generated RSS feed link tags.', 'perfmatters')
    	)
    );

    //Disable Self Pingbacks
    add_settings_field(
    	'disable_self_pingbacks', 
    	perfmatters_title(__('Disable Self Pingbacks', 'perfmatters'), 'disable_self_pingbacks') . perfmatters_tooltip('https://perfmatters.io/docs/disable-self-pingbacks-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'disable_self_pingbacks',
    		'tooltip' => __('Disable Self Pingbacks (generated when linking to an article on your own blog).', 'perfmatters')
    	)
    );

    //Disable REST API
    add_settings_field(
    	'disable_rest_api', 
    	perfmatters_title(__('Disable REST API', 'perfmatters'), 'disable_rest_api') . perfmatters_tooltip('https://perfmatters.io/docs/disable-wordpress-rest-api/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'disable_rest_api',
    		'input' => 'select',
    		'options' => array(
    			''                   => __('Default (Enabled)', 'perfmatters'),
    			'disable_non_admins' => __('Disable for Non-Admins', 'perfmatters'),
    			'disable_logged_out' => __('Disable When Logged Out', 'perfmatters')
    		),
    		'tooltip' => __('Disables REST API requests and displays an error message if the requester doesn\'t have permission.', 'perfmatters')
    	)
    );

    //Remove REST API Links
    add_settings_field(
    	'remove_rest_api_links', 
    	perfmatters_title(__('Remove REST API Links', 'perfmatters'), 'remove_rest_api_links') . perfmatters_tooltip('https://perfmatters.io/docs/remove-wordpress-rest-api-links/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'remove_rest_api_links',
    		'tooltip' => __('Removes REST API link tag from the front end and the REST API header link from page requests.', 'perfmatters')
    	)
    );

    //Disable Dashicons
    add_settings_field(
        'disable_dashicons', 
        perfmatters_title(__('Disable Dashicons', 'perfmatters'), 'disable_dashicons') . perfmatters_tooltip('https://perfmatters.io/docs/remove-dashicons-wordpress/'), 
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_options', 
        array(
            'id' => 'disable_dashicons',
            'tooltip' => __('Disables dashicons on the front end when not logged in.', 'perfmatters')
        )
    );

    //Disable Google Maps
    add_settings_field(
        'disable_google_maps', 
        perfmatters_title(__('Disable Google Maps', 'perfmatters'), 'disable_google_maps') . perfmatters_tooltip('https://perfmatters.io/docs/disable-google-maps-api-wordpress/'), 
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_options', 
        array(
            'id' => 'disable_google_maps',
            'tooltip' => __('Removes any instances of Google Maps being loaded across your entire site.', 'perfmatters')
        )
    );

    //Disable Google Fonts
    add_settings_field(
        'disable_google_fonts', 
        perfmatters_title(__('Disable Google Fonts', 'perfmatters'), 'disable_google_fonts') . perfmatters_tooltip('https://perfmatters.io/docs/disable-google-fonts/'), 
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_options', 
        array(
            'id' => 'disable_google_fonts',
            'tooltip' => __('Removes any instances of Google Fonts being loaded across your entire site.', 'perfmatters')
        )
    );

    //Disable Password Strength Meter
    add_settings_field(
        'disable_password_strength_meter', 
        perfmatters_title(__('Disable Password Strength Meter', 'perfmatters'), 'disable_password_strength_meter') . perfmatters_tooltip('https://perfmatters.io/docs/disable-password-meter-strength/'),
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_options', 
        array(
            'id' => 'disable_password_strength_meter',
            'tooltip' => __('Removes WordPress and WooCommerce Password Strength Meter scripts from non essential pages.', 'perfmatters')
        )
    );

    //Disable Comments
    add_settings_field(
        'disable_comments', 
        perfmatters_title(__('Disable Comments', 'perfmatters'), 'disable_comments') . perfmatters_tooltip('https://perfmatters.io/docs/wordpress-disable-comments/'),
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_options', 
        array(
            'id' => 'disable_comments',
            'tooltip' => __('Disables WordPress comments across your entire site.', 'perfmatters')
        )
    );

    //Remove Comment URLs
    add_settings_field(
        'remove_comment_urls', 
        perfmatters_title(__('Remove Comment URLs', 'perfmatters'), 'remove_comment_urls') . perfmatters_tooltip('https://perfmatters.io/docs/remove-wordpress-comment-author-link'),
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_options', 
        array(
            'id' => 'remove_comment_urls',
            'tooltip' => __('Removes the WordPress comment author link and website field from blog posts.', 'perfmatters')
        )
    );

    //Lazy Loading
    add_settings_field(
        'lazy_loading', 
        perfmatters_title(__('Lazy Loading', 'perfmatters') . '<span class="perfmatters-beta">BETA</span>', 'lazy_loading') . perfmatters_tooltip('https://perfmatters.io/docs/lazy-load-wordpress/'), 
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_options', 
        array(
            'id' => 'lazy_loading',
            'tooltip' => __('Enable lazy loading on images.', 'perfmatters')
        )
    );

    //Use Native
    add_settings_field(
        'lazy_loading_native', 
        perfmatters_title(__('Use Native', 'perfmatters'), 'lazy_loading_native') . perfmatters_tooltip('https://perfmatters.io/docs/lazy-load-wordpress/'), 
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_options', 
        array(
            'id' => 'lazy_loading_native',
            'tooltip' => __('Use browser-level native lazy loading when available.', 'perfmatters')
        )
    );

    //Disable Heartbeat
    add_settings_field(
    	'disable_heartbeat', 
    	'<label for=\'disable_heartbeat\'>' . __('Disable Heartbeat', 'perfmatters') . '</label>' . perfmatters_tooltip('https://perfmatters.io/docs/disable-wordpress-heartbeat-api/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'disable_heartbeat',
    		'input' => 'select',
    		'options' => array(
    			''                   => __('Default', 'perfmatters'),
    			'disable_everywhere' => __('Disable Everywhere', 'perfmatters'),
    			'allow_posts'        => __('Only Allow When Editing Posts/Pages', 'perfmatters')
    		),
    		'tooltip' => __('Disable WordPress Heartbeat everywhere or in certain areas (used for auto saving and revision tracking).', 'perfmatters')
    	)
    );

    //Heartbeat Frequency
    add_settings_field(
    	'heartbeat_frequency', 
    	'<label for=\'heartbeat_frequency\'>' . __('Heartbeat Frequency', 'perfmatters') . '</label>' . perfmatters_tooltip('https://perfmatters.io/docs/change-heartbeat-frequency-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'heartbeat_frequency',
    		'input' => 'select',
    		'options' => array(
    			''   => sprintf(__('%s Seconds', 'perfmatters'), '15') . ' (' . __('Default', 'perfmatters') . ')',
                '30' => sprintf(__('%s Seconds', 'perfmatters'), '30'),
                '45' => sprintf(__('%s Seconds', 'perfmatters'), '45'),
                '60' => sprintf(__('%s Seconds', 'perfmatters'), '60')
    		),
    		'tooltip' => __('Controls how often the WordPress Heartbeat API is allowed to run.', 'perfmatters')
    	)
    );

    //Limit Post Revisions
    add_settings_field(
    	'limit_post_revisions', 
    	'<label for=\'limit_post_revisions\'>' . __('Limit Post Revisions', 'perfmatters') . '</label>' . perfmatters_tooltip('https://perfmatters.io/docs/disable-limit-post-revisions-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'limit_post_revisions',
    		'input' => 'select',
    		'options' => array(
    			''      => __('Default', 'perfmatters'),
    			'false' => __('Disable Post Revisions', 'perfmatters'),
    			'1'     => '1',
    			'2'     => '2',
    			'3'     => '3',
    			'4'     => '4',
    			'5'     => '5',
    			'10'    => '10',
    			'15'    => '15',
    			'20'    => '20',
    			'25'    => '25',
    			'30'    => '30'
    		),
    		'tooltip' => __('Limits the maximum amount of revisions that are allowed for posts and pages.', 'perfmatters')
    	)
    );

    //Autosave Interval
    add_settings_field(
    	'autosave_interval', 
    	'<label for=\'autosave_interval\'>' . __('Autosave Interval', 'perfmatters') . '</label>' . perfmatters_tooltip('https://perfmatters.io/docs/change-autosave-interval-wordpress/'), 
    	'perfmatters_print_input', 
    	'perfmatters_options', 
    	'perfmatters_options', 
    	array(
    		'id' => 'autosave_interval',
    		'input' => 'select',
    		'options' => array(
    			''    => __('1 Minute', 'perfmatters') . ' (' . __('Default', 'perfmatters') . ')',
                '120' => sprintf(__('%s Minutes', 'perfmatters'), '2'),
                '180' => sprintf(__('%s Minutes', 'perfmatters'), '3'),
                '240' => sprintf(__('%s Minutes', 'perfmatters'), '4'),
                '300' => sprintf(__('%s Minutes', 'perfmatters'), '5')
    		),
    		'tooltip' => __('Controls how often WordPress will auto save posts and pages while editing.', 'perfmatters')
    	)
    );

    //Change Login URL
    add_settings_field(
        'login_url', 
        perfmatters_title(__('Change Login URL', 'perfmatters'), 'login_url') . perfmatters_tooltip('https://perfmatters.io/docs/change-wordpress-login-url/'), 
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_options', 
        array(
            'id' => 'login_url',
            'input' => 'text',
            'placeholder' => 'hideme',
            'tooltip' => __('When set, this will change your WordPress login URL (slug) to the provided string and will block wp-admin and wp-login endpoints from being directly accessed.', 'perfmatters')
        )
    );

    //WooCommerce Options Section
    add_settings_section('perfmatters_woocommerce', 'WooCommerce', 'perfmatters_woocommerce_callback', 'perfmatters_options');

    //Disable WooCommerce Scripts
    add_settings_field(
        'disable_woocommerce_scripts', 
        perfmatters_title(__('Disable Scripts', 'perfmatters'), 'disable_woocommerce_scripts') . perfmatters_tooltip('https://perfmatters.io/docs/disable-woocommerce-scripts-and-styles/'), 
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_woocommerce', 
        array(
            'id' => 'disable_woocommerce_scripts',
            'tooltip' => __('Disables WooCommerce scripts and styles except on product, cart, and checkout pages.', 'perfmatters')
        )
    );

    //Disable WooCommerce Cart Fragmentation
    add_settings_field(
        'disable_woocommerce_cart_fragmentation', 
        perfmatters_title(__('Disable Cart Fragmentation', 'perfmatters'), 'disable_woocommerce_cart_fragmentation') . perfmatters_tooltip('https://perfmatters.io/docs/disable-woocommerce-cart-fragments-ajax/'), 
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_woocommerce', 
        array(
            'id' => 'disable_woocommerce_cart_fragmentation',
            'tooltip' => __('Completely disables WooCommerce cart fragmentation script.', 'perfmatters')
        )
    );

    //Disable WooCommerce Status Meta Box
    add_settings_field(
        'disable_woocommerce_status', 
        perfmatters_title(__('Disable Status Meta Box', 'perfmatters'), 'disable_woocommerce_status') . perfmatters_tooltip('https://perfmatters.io/docs/disable-woocommerce-status-meta-box/'), 
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_woocommerce', 
        array(
            'id' => 'disable_woocommerce_status',
            'tooltip' => __('Disables WooCommerce status meta box from the WP Admin Dashboard.', 'perfmatters')
        )
    );

    //Disable WooCommerce Widgets
    add_settings_field(
        'disable_woocommerce_widgets', 
        perfmatters_title(__('Disable Widgets', 'perfmatters'), 'disable_woocommerce_widgets') . perfmatters_tooltip('https://perfmatters.io/docs/disable-woocommerce-widgets/'), 
        'perfmatters_print_input', 
        'perfmatters_options', 
        'perfmatters_woocommerce', 
        array(
            'id' => 'disable_woocommerce_widgets',
            'tooltip' => __('Disables all WooCommerce widgets.', 'perfmatters')
        )
    );

    register_setting('perfmatters_options', 'perfmatters_options');

    //CDN Option
    if(get_option('perfmatters_cdn') == false) {    
        add_option('perfmatters_cdn', apply_filters('perfmatters_default_cdn', perfmatters_default_cdn()));
    }

    //CDN Section
    add_settings_section('perfmatters_cdn', 'CDN', 'perfmatters_cdn_callback', 'perfmatters_cdn');

    //CDN URL
    add_settings_field(
        'enable_cdn', 
        perfmatters_title(__('Enable CDN Rewrite', 'perfmatters'), 'enable_cdn') . perfmatters_tooltip('https://perfmatters.io/docs/cdn-rewrite/'), 
        'perfmatters_print_input', 
        'perfmatters_cdn', 
        'perfmatters_cdn', 
        array(
            'id' => 'enable_cdn',
            'option' => 'perfmatters_cdn',
            'tooltip' => __('Enables rewriting of your site URLs with your CDN URLs which can be configured below.', 'perfmatters')
        )
    );

    //CDN URL
    add_settings_field(
        'cdn_url', 
        perfmatters_title(__('CDN URL', 'perfmatters'), 'cdn_url') . perfmatters_tooltip('https://perfmatters.io/docs/cdn-url/'), 
        'perfmatters_print_input', 
        'perfmatters_cdn', 
        'perfmatters_cdn', 
        array(
            'id' => 'cdn_url',
            'option' => 'perfmatters_cdn',
            'input' => 'text',
            'placeholder' => 'https://cdn.example.com',
            'tooltip' => __('Enter your CDN URL without the trailing backslash. Example: https://cdn.example.com', 'perfmatters')
        )
    );

    //CDN Included Directories
    add_settings_field(
        'cdn_directories', 
        perfmatters_title(__('Included Directories', 'perfmatters'), 'cdn_directories') . perfmatters_tooltip('https://perfmatters.io/docs/cdn-included-directories/'), 
        'perfmatters_print_input', 
        'perfmatters_cdn', 
        'perfmatters_cdn', 
        array(
            'id' => 'cdn_directories',
            'option' => 'perfmatters_cdn',
            'input' => 'text',
            'placeholder' => 'wp-content,wp-includes',
            'tooltip' => __('Enter any directories you would like to be included in CDN rewriting, separated by commas (,). Default: wp-content,wp-includes', 'perfmatters')
        )
    );

    //CDN Exclusions
    add_settings_field(
        'cdn_exclusions', 
        perfmatters_title(__('CDN Exclusions', 'perfmatters'), 'cdn_exclusions') . perfmatters_tooltip('https://perfmatters.io/docs/cdn-exclusions/'), 
        'perfmatters_print_input', 
        'perfmatters_cdn', 
        'perfmatters_cdn', 
        array(
            'id' => 'cdn_exclusions',
            'option' => 'perfmatters_cdn',
            'input' => 'text',
            'placeholder' => '.php',
            'tooltip' => __('Enter any directories or file extensions you would like to be excluded from CDN rewriting, separated by commas (,). Default: .php', 'perfmatters')
        )
    );

    register_setting('perfmatters_cdn', 'perfmatters_cdn');

    //Google Analytics Option
    if(get_option('perfmatters_ga') == false) {    
        add_option('perfmatters_ga', apply_filters('perfmatters_default_ga', perfmatters_default_ga()));
    }

    //Google Analytics Section
    add_settings_section('perfmatters_ga', __('Google Analytics', 'perfmatters'), 'perfmatters_ga_callback', 'perfmatters_ga');

    //Enable Local GA
    add_settings_field(
        'enable_local_ga', 
        perfmatters_title(__('Enable Local Analytics', 'perfmatters'), 'enable_local_ga') . perfmatters_tooltip('https://perfmatters.io/docs/local-analytics/'),
        'perfmatters_print_input', 
        'perfmatters_ga', 
        'perfmatters_ga', 
        array(
            'id' => 'enable_local_ga',
            'option' => 'perfmatters_ga',
            'tooltip' => __('Enable syncing of the Google Analytics script to your own server.', 'perfmatters')
        )
    );

    //Google Analytics ID
    add_settings_field(
        'tracking_id', 
        perfmatters_title(__('Tracking ID', 'perfmatters'), 'tracking_id') . perfmatters_tooltip('https://perfmatters.io/docs/local-analytics/#trackingid'), 
        'perfmatters_print_input', 
        'perfmatters_ga', 
        'perfmatters_ga', 
        array(
            'id' => 'tracking_id',
            'option' => 'perfmatters_ga',
            'input' => 'text',
            'tooltip' => __('Input your Google Analytics tracking ID.', 'perfmatters')
        )
    );

    //Tracking Code Position
    add_settings_field(
        'tracking_code_position', 
        perfmatters_title(__('Tracking Code Position', 'perfmatters'), 'tracking_code_position') . perfmatters_tooltip('https://perfmatters.io/docs/local-analytics/#trackingcodeposition'), 
        'perfmatters_print_input', 
        'perfmatters_ga', 
        'perfmatters_ga', 
        array(
            'id' => 'tracking_code_position',
            'option' => 'perfmatters_ga',
            'input' => 'select',
            'options' => array(
            	"" => __('Header', 'perfmatters') . ' (' . __('Default', 'perfmatters') . ')',
            	"footer" => __('Footer', 'perfmatters')
            	),
            'tooltip' => __('Load your analytics script in the header (default) or footer of your site. Default: Header', 'perfmatters')
        )
    );

    //Disable Display Features
    add_settings_field(
        'disable_display_features', 
        perfmatters_title(__('Disable Display Features', 'perfmatters'), 'disable_display_features') . perfmatters_tooltip('https://perfmatters.io/docs/local-analytics/#disabledisplayfeatures'), 
        'perfmatters_print_input', 
        'perfmatters_ga', 
        'perfmatters_ga', 
        array(
            'id' => 'disable_display_features',
            'option' => 'perfmatters_ga',
            'tooltip' => __('Disable remarketing and advertising which generates a 2nd HTTP request.', 'perfmatters')
        )
    );

    //Anonymize IP
    add_settings_field(
        'anonymize_ip', 
        perfmatters_title(__('Anonymize IP', 'perfmatters'), 'anonymize_ip') . perfmatters_tooltip('https://perfmatters.io/docs/local-analytics/#anonymize-ip'), 
        'perfmatters_print_input', 
        'perfmatters_ga', 
        'perfmatters_ga', 
        array(
            'id' => 'anonymize_ip',
            'option' => 'perfmatters_ga',
            'tooltip' => __('Shorten visitor IP to comply with privacy restrictions in some countries.', 'perfmatters')
        )
    );

    //Track Logged In Admins
    add_settings_field(
        'track_admins', 
        perfmatters_title(__('Track Logged In Admins', 'perfmatters'), 'track_admins') . perfmatters_tooltip('https://perfmatters.io/docs/local-analytics/#track-logged-in-admins'), 
        'perfmatters_print_input', 
        'perfmatters_ga', 
        'perfmatters_ga', 
        array(
            'id' => 'track_admins',
            'option' => 'perfmatters_ga',
            'tooltip' => __('Include logged-in WordPress admins in your Google Analytics reports.', 'perfmatters')
        )
    );

    //Adjusted Bounce Rate
    add_settings_field(
        'adjusted_bounce_rate', 
        perfmatters_title(__('Adjusted Bounce Rate', 'perfmatters'), 'adjusted_bounce_rate') . perfmatters_tooltip('https://perfmatters.io/docs/local-analytics/#adjusted-bounce-rate'), 
        'perfmatters_print_input', 
        'perfmatters_ga', 
        'perfmatters_ga', 
        array(
            'id' => 'adjusted_bounce_rate',
            'option' => 'perfmatters_ga',
            'input' => 'text',
            'tooltip' => __('Set a timeout limit in seconds to better evaluate the quality of your traffic. (1-100)', 'perfmatters')
        )
    );

    //Use MonsterInsights
    add_settings_field(
        'use_monster_insights', 
        perfmatters_title(__('Use MonsterInsights', 'perfmatters'), 'use_monster_insights') . perfmatters_tooltip('https://perfmatters.io/docs/local-analytics/#monster-insights'), 
        'perfmatters_print_input', 
        'perfmatters_ga', 
        'perfmatters_ga', 
        array(
            'id' => 'use_monster_insights',
            'option' => 'perfmatters_ga',
            'tooltip' => __('Allows MonsterInsights to manage your Google Analaytics while still using the locally hosted analytics.js file generated by Perfmatters.', 'perfmatters')
        )
    );

    //Google Analytics Section
    /*add_settings_section('perfmatters_facebook', __('Facebook', 'perfmatters'), 'perfmatters_ga_callback', 'perfmatters_ga');*/

    register_setting('perfmatters_ga', 'perfmatters_ga');

    if(get_option('perfmatters_extras') == false) {    
        add_option('perfmatters_extras', apply_filters('perfmatters_default_extras', perfmatters_default_extras()));
    }
    add_settings_section('general', __('General', 'perfmatters'), 'perfmatters_extras_general_callback', 'perfmatters_extras');

    //Script Manager
    add_settings_field(
        'script_manager', 
        perfmatters_title(__('Script Manager', 'perfmatters'), 'script_manager') . perfmatters_tooltip('https://perfmatters.io/docs/disable-scripts-per-post-page/'), 
        'perfmatters_print_input', 
        'perfmatters_extras', 
        'general', 
        array(
        	'id' => 'script_manager',
        	'option' => 'perfmatters_extras',
        	'tooltip' => __('Enables the Perfmatters Script Manager, which gives you the ability to disable CSS and JS files on a page by page basis.', 'perfmatters')
        )
    );

    //DNS Prefetch
    add_settings_field(
        'dns_prefetch', 
        perfmatters_title(__('DNS Prefetch', 'perfmatters'), 'dns_prefetch') . perfmatters_tooltip('https://perfmatters.io/docs/dns-prefetching/'), 
        'perfmatters_print_dns_prefetch', 
        'perfmatters_extras', 
        'general', 
        array(
            'id' => 'dns_prefetch',
            'option' => 'perfmatters_extras',
            'tooltip' => __('Resolve domain names before a user clicks. Format: //domain.tld (one per line)', 'perfmatters')
        )
    );

    //Preconnect
    add_settings_field(
        'preconnect', 
        perfmatters_title(__('Preconnect', 'perfmatters'), 'preconnect') . perfmatters_tooltip('https://perfmatters.io/docs/preconnect/'), 
        'perfmatters_print_preconnect', 
        'perfmatters_extras', 
        'general', 
        array(
            'id' => 'preconnect',
            'option' => 'perfmatters_extras',
            'tooltip' => __('Preconnect allows the browser to set up early connections before an HTTP request, eliminating roundtrip latency and saving time for users. Format: scheme://domain.tld', 'perfmatters')
        )
    );

    //Blank Favicon
    add_settings_field(
        'blank_favicon', 
        perfmatters_title(__('Add Blank Favicon', 'perfmatters'), 'blank_favicon') . perfmatters_tooltip('https://perfmatters.io/docs/blank-favicon/'), 
        'perfmatters_print_input', 
        'perfmatters_extras', 
        'general', 
        array(
            'id' => 'blank_favicon',
            'option' => 'perfmatters_extras',
            'tooltip' => __('Adds a blank favicon to your WordPress header which will prevent a Missing Favicon or 404 error from showing up on certain website speed testing tools.', 'perfmatters')
        )
    );

    //Header Code
    add_settings_field(
        'header_code', 
        perfmatters_title(__('Add Header Code', 'perfmatters'), 'header_code') . perfmatters_tooltip('https://perfmatters.io/docs/wordpress-add-code-to-header-footer/'), 
        'perfmatters_print_input', 
        'perfmatters_extras', 
        'general', 
        array(
            'id' => 'header_code',
            'option' => 'perfmatters_extras',
            'input' => 'textarea',
            'tooltip' => __('Code added here will be printed in the head section on every page of your website.', 'perfmatters')
        )
    );

    //Body Code
    if(function_exists('wp_body_open') && version_compare(get_bloginfo('version'), '5.2' , '>=')) {

        add_settings_field(
            'body_code', 
            perfmatters_title(__('Add Body Code', 'perfmatters'), 'body_code') . perfmatters_tooltip('https://perfmatters.io/docs/wordpress-add-code-to-header-footer/'), 
            'perfmatters_print_input', 
            'perfmatters_extras', 
            'general', 
            array(
                'id' => 'body_code',
                'option' => 'perfmatters_extras',
                'input' => 'textarea',
                'tooltip' => __('Code added here will be printed below the opening body tag on every page of your website.', 'perfmatters')
            )
        );
    }

    //Footer Code
    add_settings_field(
        'footer_code', 
        perfmatters_title(__('Add Footer Code', 'perfmatters'), 'footer_code') . perfmatters_tooltip('https://perfmatters.io/docs/wordpress-add-code-to-header-footer/'), 
        'perfmatters_print_input', 
        'perfmatters_extras', 
        'general', 
        array(
            'id' => 'footer_code',
            'option' => 'perfmatters_extras',
            'input' => 'textarea',
            'tooltip' => __('Code added here will be printed above the closing body tag on every page of your website.', 'perfmatters')
        )
    );

    //click to tweet section
    add_settings_section('tools', __('Tools', 'perfmatters'), 'perfmatters_extras_tools_callback', 'perfmatters_extras');

    if(!is_multisite()) {

        //Clean Uninstall
        add_settings_field(
            'clean_uninstall', 
            perfmatters_title(__('Clean Uninstall', 'perfmatters'), 'clean_uninstall') . perfmatters_tooltip('https://perfmatters.io/docs/clean-uninstall/'), 
            'perfmatters_print_input', 
            'perfmatters_extras', 
            'tools', 
            array(
                'id' => 'clean_uninstall',
                'option' => 'perfmatters_extras',
                'tooltip' => __('When enabled, this will cause all Perfmatters options data to be removed from your database when the plugin is uninstalled.', 'perfmatters')
            )
        );

    }

    //Accessibility Mode
    add_settings_field(
        'accessibility_mode', 
        perfmatters_title(__('Accessibility Mode', 'perfmatters'), 'accessibility_mode', true), 
        'perfmatters_print_input',
        'perfmatters_extras', 
        'tools', 
        array(
        	'id' => 'accessibility_mode',
        	'input' => 'checkbox',
        	'option' => 'perfmatters_extras',
        	'tooltip' => __('Disable the use of visual UI elements in the plugin settings such as checkbox toggles and hovering tooltips.', 'perfmatters')
        )
    );

    //Export Settings
    add_settings_field(
        'export_settings', 
        perfmatters_title(__('Export Settings', 'perfmatters'), 'export_settings', true) . perfmatters_tooltip('https://perfmatters.io/docs/import-export/'), 
        'perfmatters_print_input',
        'perfmatters_extras', 
        'tools', 
        array(
            'id' => 'export_settings',
            'input' => 'button',
            'title' => __('Export Plugin Settings', 'perfmatters'),
            'option' => 'perfmatters_extras',
            'tooltip' => __('Export your Perfmatters settings for this site as a .json file. This lets you easily import the configuration into another site.', 'perfmatters')
        )
    );

    //Import Settings
    add_settings_field(
        'import_settings', 
        perfmatters_title(__('Import Settings', 'perfmatters'), 'import_settings', true) . perfmatters_tooltip('https://perfmatters.io/docs/import-export/'), 
        'perfmatters_print_import_settings',
        'perfmatters_extras', 
        'tools', 
        array(
            'tooltip' => __('Import Perfmatters settings from an exported .json file.', 'perfmatters')
        )
    );

    register_setting('perfmatters_extras', 'perfmatters_extras', 'perfmatters_sanitize_extras');

    //edd license option
	register_setting('perfmatters_edd_license', 'perfmatters_edd_license_key', 'perfmatters_edd_sanitize_license');
}
add_action('admin_init', 'perfmatters_settings');

//options default values
function perfmatters_default_options() {
	$defaults = array(
		'disable_emojis' => "0",
		'disable_embeds' => "0",
		'remove_query_strings' => "0",
		'disable_xmlrpc' => "0",
		'remove_jquery_migrate' => "0",
		'hide_wp_version' => "0",
		'remove_wlwmanifest_link' => "0",
		'remove_rsd_link' => "0",
		'remove_shortlink' => "0",
		'disable_rss_feeds' => "0",
		'remove_feed_links' => "0",
		'disable_self_pingbacks' => "0",
		'disable_rest_api' => "",
		'remove_rest_api_links' => "0",
        'disable_dashicons' => "0",
        'disable_google_maps' => "0",
        'disable_password_strength_meter' => "0",
        'disable_comments' => "0",
        'remove_comment_urls' => "0",
        'lazy_loading' => "",
        'lazy_loading_native' => "",
		'disable_heartbeat' => "",
		'heartbeat_frequency' => "",
		'limit_post_revisions' => "",
		'autosave_interval' => "",
        'login_url' => "",
        'disable_woocommerce_scripts' => "0",
        'disable_woocommerce_cart_fragmentation' => "0",
        'disable_woocommerce_status' => "0",
        'disable_woocommerce_widgets' => "0"
	);
    perfmatters_network_defaults($defaults, 'perfmatters_options');
	return apply_filters('perfmatters_default_options', $defaults);
}

//cdn default values
function perfmatters_default_cdn() {
    $defaults = array(
        'enable_cdn' => "0",
        'cdn_url' => "0",
        'cdn_directories' => "wp-content,wp-includes",
        'cdn_exclusions' => ".php"
    );
    perfmatters_network_defaults($defaults, 'perfmatters_cdn');
    return apply_filters( 'perfmatters_default_cdn', $defaults );
}

//google analytics default values
function perfmatters_default_ga() {
    $defaults = array(
    	'enable_local_ga' => "0",
        'tracking_id' => "",
        'tracking_code_position' => "",
        'disable_display_features' => "0",
        'anonymize_ip' => "0",
        'track_admins' => "0",
        'adjusted_bounce_rate' => "",
        'use_monster_insights' => "0"
    );
    perfmatters_network_defaults($defaults, 'perfmatters_ga');
    return apply_filters('perfmatters_default_ga', $defaults);
}

//extras default values
function perfmatters_default_extras() {
    $defaults = array(
        'script_manager' => "0",
        'dns_prefetch' => "",
        'preconnect' => "",
        'blank_favicon' => "0",
        'header_code' => "",
        'footer_code' => "",
        'accessibility_mode' => "0"
    );
    perfmatters_network_defaults($defaults, 'perfmatters_extras');
    return apply_filters( 'perfmatters_default_extras', $defaults );
}

function perfmatters_network_defaults(&$defaults, $option) {
    if(is_multisite() && is_plugin_active_for_network('perfmatters/perfmatters.php')) {
        $perfmatters_network = get_site_option('perfmatters_network');
        if(!empty($perfmatters_network['default'])) {
            $networkDefaultOptions = get_blog_option($perfmatters_network['default'], $option);
            if($option == 'perfmatters_cdn') {
                unset($networkDefaultOptions['cdn_url']);
            }
            if(!empty($networkDefaultOptions)) {
                foreach($networkDefaultOptions as $key => $val) {
                    $defaults[$key] = $val;
                }
            }
        }
    }
}

//main options group callback
function perfmatters_options_callback() {
	echo '<p class="perfmatters-subheading">' . __('Select which performance options you would like to enable.', 'perfmatters') . '</p>';
}

//woocommerce options group callback
function perfmatters_woocommerce_callback() {
    echo '<p class="perfmatters-subheading">' . __('Disable specific elements of WooCommerce.', 'perfmatters') . '</p>';
}

//cdn group callback
function perfmatters_cdn_callback() {
    echo '<p class="perfmatters-subheading">' . __('CDN options that allow you to rewrite your site URLs with your CDN URLs.', 'perfmatters') . '</p>';
}

//google analytics group callback
function perfmatters_ga_callback() {
    echo '<p class="perfmatters-subheading">' . __('Optimization options for Google Analytics.', 'perfmatters') . '</p>';
}

//extras group callback
function perfmatters_extras_general_callback() {
    echo '<p class="perfmatters-subheading">' . __('Extra options that pertain to Perfmatters plugin functionality.', 'perfmatters') . '</p>';
}

 function perfmatters_extras_tools_callback() {
    echo '<p class="perfmatters-subheading">' . __('Perfmatters plugin management tools.', 'perfmatters') . '</p>';
}

//print settings section
function perfmatters_settings_section($page, $section) {
    global $wp_settings_sections;
    if(!empty($wp_settings_sections[$page][$section])) {
        echo '<h2>' . __($wp_settings_sections[$page][$section]['title'], 'perfmatters') . '</h2>';
        echo $wp_settings_sections[$page][$section]['callback']();

        echo "<table class='form-table'>";
            echo "<tbody>";
                do_settings_fields($page, $section);
            echo "</tbody>";
        echo "</table>";
    }
}

//print form inputs
function perfmatters_print_input($args) {

    if(!empty($args['option'])) {
        $option = $args['option'];
        if($args['option'] == 'perfmatters_network') {
            $options = get_site_option($args['option']);
        }
        else {
            $options = get_option($args['option']);
        }
    }
    else {
        $option = 'perfmatters_options';
        $options = get_option('perfmatters_options');
    }
    if(!empty($args['option']) && $args['option'] == 'perfmatters_extras') {
        $extras = $options;
    }
    else {
        $extras = get_option('perfmatters_extras');
    }

    echo "<div style='display: table; width: 100%;'>";
        echo "<div class='perfmatters-input-wrapper'>";

            //Text
            if(!empty($args['input']) && ($args['input'] == 'text' || $args['input'] == 'color')) {
                echo "<input type='text' id='" . $args['id'] . "' name='" . $option . "[" . $args['id'] . "]' value='" . (!empty($options[$args['id']]) ? $options[$args['id']] : '') . "' placeholder='" . (!empty($args['placeholder']) ? $args['placeholder'] : '') . "' />";
            }

            //Select
            elseif(!empty($args['input']) && $args['input'] == 'select') {
                echo "<select id='" . $args['id'] . "' name='" . $option . "[" . $args['id'] . "]'>";
                    foreach($args['options'] as $value => $title) {
                        echo "<option value='" . $value . "' "; 
                        if(!empty($options[$args['id']]) && $options[$args['id']] == $value) {
                            echo "selected";
                        } 
                        echo ">" . $title . "</option>";
                    }
                echo "</select>";
            }

            //button
            elseif(!empty($args['input']) && $args['input'] == 'button') {
                echo "<button id='" . $args['id'] . "' name='" . $option . "[" . $args['id'] . "]' value='1' class='button button-secondary'";
                    if(!empty($args['confirmation'])) {
                        echo " onClick=\"return confirm('" . $args['confirmation'] . "');\"";
                    }
                echo ">";
                    echo $args['title'];
                echo "</button>";
            }

            //Text Area
            elseif(!empty($args['input']) && $args['input'] == 'textarea') {
                echo "<textarea id='" . $args['id'] . "' name='" . $option . "[" . $args['id'] . "]'>";
                    echo (!empty($options[$args['id']]) ? $options[$args['id']] : '');
                echo "</textarea>";
            }

            //Checkbox + Toggle
            else {
                if((empty($extras['accessibility_mode']) || $extras['accessibility_mode'] != "1") && (empty($args['input']) || $args['input'] != 'checkbox')) {
                    echo "<label for='" . $args['id'] . "' class='switch'>";
                }
                    echo "<input type='checkbox' id='" . $args['id'] . "' name='" . $option . "[" . $args['id'] . "]' value='1' style='display: block; margin: 0px;' ";
                    if(!empty($options[$args['id']]) && $options[$args['id']] == "1") {
                        echo "checked";
                    }
                    echo ">";
                if((empty($extras['accessibility_mode']) || $extras['accessibility_mode'] != "1") && (empty($args['input']) || $args['input'] != 'checkbox')) {
                       echo "<div class='slider'></div>";
                   echo "</label>";
                }
            }
            
        echo "</div>";

        if(!empty($args['tooltip'])) {
            if((empty($extras['accessibility_mode']) || $extras['accessibility_mode'] != "1") && $args['id'] != 'accessibility_mode') {
                echo "<div class='perfmatters-tooltip-text-wrapper'>";
                    echo "<div class='perfmatters-tooltip-text-container'>";
                        echo "<div style='display: table; height: 100%; width: 100%;'>";
                            echo "<div style='display: table-cell; vertical-align: top;'>";
                                echo "<span class='perfmatters-tooltip-text'>" . $args['tooltip'] . "</span>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }
            else {
                echo "<p style='font-size: 12px; font-style: italic;'>" . $args['tooltip'] . "</p>";
            }
        }
    echo "</div>";
}

//print DNS Prefetch
function perfmatters_print_dns_prefetch($args) {
    $extras = get_option('perfmatters_extras');
     echo "<div style='display: table; width: 100%;'>";
        echo "<div class='perfmatters-input-wrapper'>";
            echo "<textarea id='" . $args['id'] . "' name='perfmatters_extras[" . $args['id'] . "]' placeholder='//example.com'>";
                if(!empty($extras['dns_prefetch'])) {
                    foreach($extras['dns_prefetch'] as $line) {
                        echo $line . "\n";
                    }
                }
            echo "</textarea>";
        echo "</div>";
        if(!empty($args['tooltip'])) {
            if(empty($extras['accessibility_mode']) || $extras['accessibility_mode'] != "1") {
                echo "<div class='perfmatters-tooltip-text-wrapper'>";
                    echo "<div class='perfmatters-tooltip-text-container'>";
                        echo "<div style='display: table; height: 100%; width: 100%;'>";
                            echo "<div style='display: table-cell; vertical-align: top;'>";
                                echo "<span class='perfmatters-tooltip-text'>" . $args['tooltip'] . "</span>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }
            else {
                echo "<p style='font-size: 12px; font-style: italic;'>" . $args['tooltip'] . "</p>";
            }
        }
    echo "</div>";
}

//print Preconnect
function perfmatters_print_preconnect($args) {
    $extras = get_option('perfmatters_extras');
    echo "<div style='display: table; width: 100%;'>";

        echo "<div id='perfmatters-preconnect-wrapper' class='perfmatters-input-wrapper'>";

            $rowCount = 0;

            if(!empty($extras['preconnect'])) {

                foreach($extras['preconnect'] as $line) {

                    //check for previous vs new format
                    if(is_array($line)) {
                        $url = $line['url'];
                        $crossorigin = isset($line['crossorigin']) ? $line['crossorigin'] : 0;
                    }
                    else {
                        $url = $line;
                        $crossorigin = 1;
                    }

                    //print row
                    echo "<div class='perfmatters-preconnect-row'>";
                        echo "<input type='text' id='" . $args['id'] . "-" . $rowCount . "-url' name='perfmatters_extras[" . $args['id'] . "][" . $rowCount . "][url]' value='" . $url . "' placeholder='https://example.com' />";
                        echo "<label for='" . $args['id'] . "-" . $rowCount . "-crossorigin'>";
                            echo "<input type='checkbox' id='" . $args['id'] . "-" . $rowCount . "-crossorigin' name='perfmatters_extras[" . $args['id'] . "][" . $rowCount . "][crossorigin]' " . ($crossorigin == 1 ? "checked" : "") . " value='1' /> CrossOrigin";
                        echo "</label>";
                        echo "<a href='#' class='perfmatters-delete-preconnect' title='" . __('Remove', 'perfmatters') . "'><span class='dashicons dashicons-no'></span></a>";
                    echo "</div>";

                    $rowCount++;
                }
            }

            //print empty row at the end
            echo "<div class='perfmatters-preconnect-row'>";
                echo "<input type='text' id='preconnect-" . $rowCount . "-url' name='perfmatters_extras[preconnect][" . $rowCount . "][url]' value='' placeholder='https://example.com' />";
                echo "<label for='" . $args['id'] . "-" . $rowCount . "-crossorigin'>";
                    echo "<input type='checkbox' id='preconnect-" . $rowCount . "-crossorigin' name='perfmatters_extras[preconnect][" . $rowCount . "][crossorigin]' value='1' /> CrossOrigin";
                echo "</label>";
                echo "<a href='#' class='perfmatters-delete-preconnect' title='" . __('Remove', 'perfmatters') . "'><span class='dashicons dashicons-no'></span></a>";
            echo "</div>";

        echo "</div>";

        //add new row
        echo "<a href='#' id='perfmatters-add-preconnect' rel='" . $rowCount . "'>" . __('Add New', 'perfmatters') . "</a>";

        if(!empty($args['tooltip'])) {
            if(empty($extras['accessibility_mode']) || $extras['accessibility_mode'] != "1") {
                echo "<div class='perfmatters-tooltip-text-wrapper'>";
                    echo "<div class='perfmatters-tooltip-text-container'>";
                        echo "<div style='display: table; height: 100%; width: 100%;'>";
                            echo "<div style='display: table-cell; vertical-align: top;'>";
                                echo "<span class='perfmatters-tooltip-text'>" . $args['tooltip'] . "</span>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }
            else {
                echo "<p style='font-size: 12px; font-style: italic;'>" . $args['tooltip'] . "</p>";
            }
        }
    echo "</div>";
}

//print Import Settings
function perfmatters_print_import_settings($args) {
    echo "<div style='display: table; width: 100%;'>";
        echo "<div class='perfmatters-input-wrapper'>";
        	echo "<input type='file' name='perfmatters_import_settings_file' /><br />";
       		echo "<button id='import_settings' name='perfmatters_extras[import_settings]' value='1' class='button button-secondary'>" . __("Import Plugin Settings", 'perfmatters') . "</button>";
        echo "</div>";
        if(!empty($args['tooltip'])) {
            if(empty($extras['accessibility_mode']) || $extras['accessibility_mode'] != "1") {
                echo "<div class='perfmatters-tooltip-text-wrapper'>";
                    echo "<div class='perfmatters-tooltip-text-container'>";
                        echo "<div style='display: table; height: 100%; width: 100%;'>";
                            echo "<div style='display: table-cell; vertical-align: top;'>";
                                echo "<span class='perfmatters-tooltip-text'>" . $args['tooltip'] . "</span>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }
            else {
                echo "<p style='font-size: 12px; font-style: italic;'>" . $args['tooltip'] . "</p>";
            }
        }
    echo "</div>";
}

//sanitize extras
function perfmatters_sanitize_extras($values) {
    if(!empty($values['dns_prefetch']) && !is_array($values['dns_prefetch'])) {
        $text = trim($values['dns_prefetch']);
        $text_array = explode("\n", $text);
        $text_array = array_filter($text_array, 'trim');
        $values['dns_prefetch'] = $text_array;
    }
    if(!empty($values['preconnect'])) {
        foreach($values['preconnect'] as $key => $line) {
            if(empty(trim($line['url']))) {
                unset($values['preconnect'][$key]);
            }
        }
        $values['preconnect'] = array_values($values['preconnect']);
    }
    return $values;
}

//sanitize EDD license
function perfmatters_edd_sanitize_license($new) {
	$old = get_option( 'perfmatters_edd_license_key' );
	if($old && $old != $new) {
		delete_option( 'perfmatters_edd_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

//print tooltip
function perfmatters_tooltip($link) {
	$var = "<a ";
        if(!empty($link)) {
            $var.= "href='" . $link . "' title='" . __('View Documentation', 'perfmatters') . "' ";
        }
        $var.= "class='perfmatters-tooltip' target='_blank'>?";
    $var.= "</a>";
    return $var;
}

//print title
function perfmatters_title($title, $id, $checkbox = false) {
    if(!empty($title)) {
        $var = $title;
        if(!empty($id)) {
            $extras = get_option('perfmatters_extras');
            if((!empty($extras['accessibility_mode']) && $extras['accessibility_mode'] == "1") || $checkbox == true) {
                $var = "<label for='" . $id . "'>" . $var . "</label>";
            }
        }
        return $var;
    }
}