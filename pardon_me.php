<?php

/**
 * @package pardon_me
 * @version 0.0.1
 */
/*
Plugin Name: Pardon Me
Plugin URI: http://benpolinsky.com
Description: Pardot Gated Content Beyond Forms
Author: Ben Polinsky
License: GPL2
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
Version: 0.0.1
Author URI: http://benpolinsky.com
*/

# no direct access
if (!defined('ABSPATH')) exit;

# Constants
define( 'PARDON_ME_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PARDON_ME_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PARDON_ME_ASSETS_URL', PARDON_ME_PLUGIN_URL . 'assets' );
define( 'PARDON_ME_IMAGES_URL', PARDON_ME_ASSETS_URL . '/images' );
define( 'PARDON_ME_JS_URL', PARDON_ME_ASSETS_URL . '/js' );
define( 'PARDON_ME_STYLES_URL', PARDON_ME_ASSETS_URL . '/styles' );
# Set it off: 

require_once( PARDON_ME_PLUGIN_DIR . 'class.pardon_me.php' );
require_once( PARDON_ME_PLUGIN_DIR . 'pm-admin-pages.php' );
require_once( PARDON_ME_PLUGIN_DIR . 'pm-admin-settings.php' );
require_once( PARDON_ME_PLUGIN_DIR . 'pm-shortcodes.php' );
require_once( PARDON_ME_PLUGIN_DIR . 'pm-template-tags.php' );


function bp_gather_scripts(){
	wp_enqueue_script('pm-index-js',  PARDON_ME_JS_URL . '/admin-scripts.js', false);
	wp_enqueue_style('pm-styles', PARDON_ME_STYLES_URL . '/admin-forms.css', false, false);
}

add_action('admin_enqueue_scripts', 'bp_gather_scripts');

?>

<?php
	# Testing
	$pkey = get_option('pm_pardot_api_key');
	$pemail = get_option('pm_pardot_email');
	$ppass = get_option('pm_pardot_password');	
	
	$me = new PardonMeAPI($pemail, $ppass, $pkey);
	$visitor_id = $me->current_visitor_id($_COOKIE);
	$me->has_filled_out_form();
	# print_r($me->get_competitors());
	# echo '<pre>';
	# print_r($me->get_campaigns());
	# echo '</pre>';
		
# $response = $me->data();
?>
