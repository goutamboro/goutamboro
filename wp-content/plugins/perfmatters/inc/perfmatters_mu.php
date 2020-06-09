<?php
/*
Plugin Name: Perfmatters MU
Plugin URI: https://perfmatters.io/
Description: Perfmatters is a lightweight performance plugin developed to speed up your WordPress site.
Version: 1.5.5
Author: forgemedia
Author URI: https://forgemedia.io/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: perfmatters
Domain Path: /languages
*/

add_filter('option_active_plugins', 'perfmatters_mu_disable_plugins', 1);

function perfmatters_mu_disable_plugins($plugins) {

	//admin check
	if(is_admin()) {
		return $plugins;
	}

	//base plugin active check
	if(is_array($plugins) && !in_array('perfmatters/perfmatters.php', $plugins)) {
		return $plugins;
	}

	//make sure MU is enabled
	$pmsm_settings = get_option('perfmatters_script_manager_settings');
	if(empty($pmsm_settings['mu_mode'])) {
		return $plugins;
	}

	//script manager is being viewed
	if(isset($_GET['perfmatters'])) {

		//store active plugins for script manager UI in case they get disabled completely
		global $pmsm_active_plugins;
		$pmsm_active_plugins = $plugins;
	}

	//check for manual override
	if(!empty($_GET['mu_mode']) && $_GET['mu_mode'] == 'off') {
		return $plugins;
	}

	//get script manager configuration
	$pmsm = get_option('perfmatters_script_manager');

	//we have some plugins that are disabled
	if(!empty($pmsm['disabled']['plugins'])) {

		//attempt to get post id
		$currentID = perfmatters_mu_get_current_ID();

		//assign disable/enable arrays
		$disabled = $pmsm['disabled']['plugins'];
		$enabled = $pmsm['enabled']['plugins'];

		//loop through disabled plugins
		foreach($disabled as $handle => $data) {

			//current plugin disable is set
			if(!empty($data['everywhere']) || (!empty($data['current']) && in_array($currentID, $data['current'])) || !empty($data['regex'])) {

				//enable current url check
				if(!empty($enabled[$handle]['current']) && in_array($currentID, $enabled[$handle]['current'])) {
					continue;
				}

				//disable regex check
				if(!empty($data['regex'])) {
					global $wp;
		  			$current_url = home_url(add_query_arg(array(), $_SERVER['REQUEST_URI']));
					if(!preg_match($data['regex'], $current_url)) {
						continue;
					}
				}

				//enable regex
				if(!empty($enabled[$handle]['regex'])) {
					global $wp;
		  			$current_url = home_url(add_query_arg(array(), $_SERVER['REQUEST_URI']));

		  			if(preg_match($enabled[$handle]['regex'], $current_url)) {
						continue;
					}
				}

				//home page as post type
				if($currentID === 0) {
					if(get_option('show_on_front') == 'page' && !empty($enabled[$handle]['post_types']) && in_array('page', $enabled[$handle]['post_types'])) {
						continue;
					}
				}
				elseif(!empty($currentID)) {
					
					//grab post details
					$post = get_post($currentID);

					//post type enable check
					if(!empty($post->post_type) && !empty($enabled[$handle]['post_types']) && in_array($post->post_type, $enabled[$handle]['post_types'])) {
						continue;
					}
				}

				//remove plugin from list
				$m_array = preg_grep('/^' . $handle . '.*/', $plugins);
				if(!empty($m_array) && is_array($m_array)) {
					unset($plugins[key($m_array)]);
				}
			}
		}
	}

	return $plugins;
}

//remove our filter after plugins have loaded
function perfmatters_mu_remove_filters() {
	remove_filter('option_active_plugins', 'perfmatters_mu_disable_plugins', 1, 1);
}
add_action('plugins_loaded', 'perfmatters_mu_remove_filters', 1);

//attempt to get the current id for mu mode
function perfmatters_mu_get_current_ID() {

	//load necessary parts for url_to_postid
	require_once(wp_normalize_path(ABSPATH) . 'wp-includes/pluggable.php');
	global $wp_rewrite;
	global $wp;
 	$wp_rewrite = new WP_Rewrite();
 	$wp = new WP();
 	

	//attempt to get post id from url
	$currentID = perfmatters_url_to_postid(home_url($_SERVER['REQUEST_URI']));

	//id wasn't found
	if($currentID === 0) {

		//check for home url match
		$request = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if(trailingslashit(home_url()) !== trailingslashit($request)) {
			$currentID = '';
		}
	}

	//clean up
	unset($wp_rewrite);
	unset($wp);

	return $currentID;
}

//custom url_to_postid() replacement - modified from https://gist.github.com/Webcreations907/ce5b77565dfb9a208738
function perfmatters_url_to_postid($url) {
    global $wp_rewrite;

    if ( isset( $_GET['post'] ) && ! empty( $_GET['post'] ) && is_numeric( $_GET['post'] ) ) {
        return $_GET['post'];
    }

    // First, check to see if there is a 'p=N' or 'page_id=N' to match against
    // added post to match, even though it's above
    if ( preg_match( '#[?&](p|post|page_id|attachment_id)=(\d+)#', $url, $values ) ) {
        $id = absint( $values[2] );
        if ( $id ) {
            return $id;
        }
    }

    // Check to see if we are using rewrite rules
    if ( isset( $wp_rewrite ) ) {
        $rewrite = $wp_rewrite->wp_rewrite_rules();
    }

    // Not using rewrite rules, and 'p=N' and 'page_id=N' methods failed, so we're out of options
    if ( empty( $rewrite ) ) {
        if ( isset( $_GET ) && ! empty( $_GET ) ) {

            /************************************************************************
            * ADDED: Trys checks URL for ?posttype=postname
            *************************************************************************/

            // Assign $url to $tempURL just incase. :)
            $tempUrl = $url;

            // Get rid of the #anchor
            $url_split = explode( '#', $tempUrl );
            $tempUrl = $url_split[0];

            // Get rid of URL ?query=string
            $url_query = explode( '&', $tempUrl );
            $tempUrl = $url_query[0];

            // Get rid of ? mark
            $url_query = explode( '?', $tempUrl);

            if(isset($url_query[1]) && !empty($url_query[1]) && strpos( $url_query[1], '=' )){

                $url_query = explode( '=', $url_query[1] );

                if(isset($url_query[0]) && isset($url_query[1])){

                     $args = array(
                        'name'      => $url_query[1],
                        'post_type' => $url_query[0],
                        'showposts' => 1,
                    );
                    if ( $post = get_posts( $args ) ) {
                       return $post[0]->ID;
                    }
                }
            }

            /************************************************************************
            * END ADD
            *************************************************************************/
            
            // Add custom rules for non-rewrite URLs
            foreach ( $GLOBALS['wp_post_types'] as $key => $value ) {
                if ( isset( $_GET[ $key ] ) && ! empty( $_GET[ $key ] ) ) {
                    $args = array(
                        'name'      => $_GET[ $key ],
                        'post_type' => $key,
                        'showposts' => 1,
                    );
                    if ( $post = get_posts( $args ) ) {
                        return $post[0]->ID;
                    }
                }
            }
        }
    }

    // Get rid of the #anchor
    $url_split = explode( '#', $url );
    $url       = $url_split[0];

    // Get rid of URL ?query=string
    $url_query = explode( '?', $url );
    $url       = $url_query[0];

    // Add 'www.' if it is absent and should be there
    if ( false !== strpos( home_url(), '://www.' ) && false === strpos( $url, '://www.' ) ) {
        $url = str_replace( '://', '://www.', $url );
    }

    // Strip 'www.' if it is present and shouldn't be
    if ( false === strpos( home_url(), '://www.' ) ) {
        $url = str_replace( '://www.', '://', $url );
    }

    // Strip 'index.php/' if we're not using path info permalinks
    if ( isset( $wp_rewrite ) && ! $wp_rewrite->using_index_permalinks() ) {
        $url = str_replace( 'index.php/', '', $url );
    }

    if ( false !== strpos( $url, home_url() ) ) {
        // Chop off http://domain.com
        $url = str_replace( home_url(), '', $url );
    } else {
        // Chop off /path/to/blog
        $home_path = parse_url( home_url() );
        $home_path = isset( $home_path['path'] ) ? $home_path['path'] : '';
        $url       = str_replace( $home_path, '', $url );
    }

    // Trim leading and lagging slashes
    $url = trim( $url, '/' );

    $request = $url;
    if ( empty( $request ) && ( ! isset( $_GET ) || empty( $_GET ) ) ) {
        return get_option( 'page_on_front' );
    }

    // Look for matches.
    $request_match = $request;

    foreach ( (array) $rewrite as $match => $query ) {

        // If the requesting file is the anchor of the match, prepend it
        // to the path info.
        if ( ! empty( $url ) && ( $url != $request ) && ( strpos( $match, $url ) === 0 ) ) {
            $request_match = $url . '/' . $request;
        }

        if ( preg_match( "!^$match!", $request_match, $matches ) ) {

            // Got a match.
            // Trim the query of everything up to the '?'.
            $query = preg_replace( "!^.+\?!", '', $query );

            // Substitute the substring matches into the query.
            $query = addslashes( WP_MatchesMapRegex::apply( $query, $matches ) );

            // Filter out non-public query vars
            global $wp;
            parse_str( $query, $query_vars );
            $query = array();
            foreach ( (array) $query_vars as $key => $value ) {
                if ( in_array( $key, $wp->public_query_vars ) ) {
                    $query[ $key ] = $value;
                }
            }

            /************************************************************************
            * ADDED: $GLOBALS['wp_post_types'] doesn't seem to have custom postypes
            * Trying below to find posttypes in $rewrite rules
            *************************************************************************/

            // PostType Array
            $custom_post_type = false;
            $post_types = array();
            foreach ($rewrite as $key => $value) {

                if(preg_match('/post_type=([^&]+)/i', $value, $matched)){

                    if(isset($matched[1]) && !in_array($matched[1], $post_types)){
                         
                        $post_types[] = $matched[1];
                    }
                }
            }

            foreach ((array) $query_vars as $key => $value) {
                if(in_array($key, $post_types)){

                    $custom_post_type = true;

                    $query['post_type'] = $key;
                    $query['postname'] = $value;
                }
            }

            /************************************************************************
            * END ADD
            *************************************************************************/

            // Taken from class-wp.php
            foreach ( $GLOBALS['wp_post_types'] as $post_type => $t ) {
                if ( $t->query_var ) {
                    $post_type_query_vars[ $t->query_var ] = $post_type;
                }
            }

            foreach ( $wp->public_query_vars as $wpvar ) {
                if ( isset( $wp->extra_query_vars[ $wpvar ] ) ) {
                    $query[ $wpvar ] = $wp->extra_query_vars[ $wpvar ];
                } elseif ( isset( $_POST[ $wpvar ] ) ) {
                    $query[ $wpvar ] = $_POST[ $wpvar ];
                } elseif ( isset( $_GET[ $wpvar ] ) ) {
                    $query[ $wpvar ] = $_GET[ $wpvar ];
                } elseif ( isset( $query_vars[ $wpvar ] ) ) {
                    $query[ $wpvar ] = $query_vars[ $wpvar ];
                }


                if ( ! empty( $query[ $wpvar ] ) ) {
                    if ( ! is_array( $query[ $wpvar ] ) ) {
                        $query[ $wpvar ] = (string) $query[ $wpvar ];
                    } else {
                        foreach ( $query[ $wpvar ] as $vkey => $v ) {
                            if ( ! is_object( $v ) ) {
                                $query[ $wpvar ][ $vkey ] = (string) $v;
                            }
                        }
                    }

                    if ( isset( $post_type_query_vars[ $wpvar ] ) ) {
                        $query['post_type'] = $post_type_query_vars[ $wpvar ];
                        $query['name']      = $query[ $wpvar ];
                    }
                }
            }

            // Do the query
            if ( isset( $query['pagename'] ) && ! empty( $query['pagename'] ) ) {
                $args = array(
                    'name'      => $query['pagename'],
                    'post_type' => array('post','page'), // Added post for custom permalink eg postname
                    'showposts' => 1,
                );
                if ( $post = get_posts( $args ) ) {
                    return $post[0]->ID;
                }
            }
            $query = new WP_Query( $query );

            if ( ! empty( $query->posts ) && $query->is_singular ) {
                return $query->post->ID;
            } else {

                /************************************************************************
                * Added:
                * $query->is_singular seems to not be set on custom post types, trying
                * below. Made it this far without return, worth a try? :)
                *************************************************************************/
                
                if(!empty( $query->posts ) && isset($query->post->ID) && $custom_post_type == true){

                    return $query->post->ID;
                }
                
                /************************************************************************
                * Will match posttype when query_var => true, will not work with
                * custom query_var set ie query_var => 'acme_books'.
                *************************************************************************/

                if(isset($post_types)){

                    foreach ($rewrite as $key => $value) {

                        if(preg_match('/\?([^&]+)=([^&]+)/i', $value, $matched)){

                            if(isset($matched[1]) && !in_array($matched[1], $post_types) && array_key_exists($matched[1], $query_vars)){

                                $post_types[] = $matched[1];

                                $args = array(
                                        'name'      => $query_vars[$matched[1]],
                                        'post_type' => $matched[1],
                                        'showposts' => 1,
                                    );

                                if ( $post = get_posts( $args ) ) {
                                    return $post[0]->ID;
                                }
                            }
                        }
                    }
                }

	            /************************************************************************
	            * END ADD
	            *************************************************************************/

                return 0;
            }
        }
    }

    return 0;
}