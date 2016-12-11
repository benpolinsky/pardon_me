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


# Add Admin Page

function pm_add_admin_page(){

	# create wp-admin settings page
	add_options_page(
		'Pardon Me Settings', 
		'Pardon Me', 
		'manage_options', 
		'pardon-me-settings', 
		'pardon_me_main_page'
	);
	
}

function pardon_me_main_page(){

  # ensure user has proper credentials
	if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to access this page.'));
	}
	
	$content = "";
	
	$content .= "<div class='wrap'>";
	$content .= "<h1>Check out this Settings Menu</h1>";
	$content .= "</div>";
		
	echo $content;
	
}

# register page with the admin hook
add_action('admin_menu', 'pm_add_admin_page');
	
?>
