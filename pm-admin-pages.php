<?php

# Check if we've entered an api key:
if (empty(get_option('pm_pardot_api_key'))) {
	add_action('admin_notices', 'pm_admin_notices');
}

# ---Add Admin Main Page---
function pm_add_admin_main_page(){
	add_menu_page('Pardon Me', 
		"Pardon Me", 
		'manage_options', 
		'pardon-me-admin', 
		'pm_main_page', 
		'dashicons-admin-network'
	);
}

function pm_main_page(){
  # ensure user has proper credentials
	if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to access this page.'));
	}
	
	$content = "";
	
	$content .= "<div class='wrap'>";
	$content .= "<h1>Check out this Main Page</h1>";
	$content .= "</div>";
		
	echo $content;
	
}

add_action('admin_menu', 'pm_add_admin_main_page');

# ---Add Admin Page Settings Page---

function pm_add_settings_page(){

	# create wp-admin settings page
	# and grab the hook suffix
	$hook_suffix = add_submenu_page(
		'pardon-me-admin',
		'Pardon Me Settings', 
		'Settings', 
		'manage_options', 
		'pardon-me-settings', 
		'pm_settings_page'
	);
	
	add_action("load-$hook_suffix", 'ensure_api_key_submitted');
}

function ensure_api_key_submitted(){
	# remove if options page
	remove_action('admin_notices', 'pm_admin_notices');
}

function pm_admin_notices(){
	echo "<div id='notice' class='updated fade'><p>My Plugin is not configured yet. Please do it now.</p></div>\n";
}

function pm_settings_page(){

  # ensure user has proper credentials
	if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to access this page.'));
	}
	
	$content = "";
	
	$api_key_name = 'pm_pardot_api_key';	

	$api_key_value = get_option($api_key_name);

	$hidden_field_name = 'pm_submit_hidden';

	# If we've already gotten some info via post,
	# we'll update our option
	if (isset($_POST[$hidden_field_name]) && $_POST[$hidden_field_name] == 'Y') {
		$api_key_value = $_POST[$api_key_name];
		update_option($api_key_name, $api_key_value);
		
		$settings_saved = __('Settings Saved.', 'menu-test');
		$content .= "<div class='updated'><p><strong>$settings_saved</strong></p></div>";
	}
	
	$content .= "<div class='wrap'>";
	$content .= "<h2>";
	$content .= __('Menu Test Plugin Settings', 'menu-test');
	$content .= "</h2>";
	
	# Form
	
	$content .= "<form name='form1' method='post' action=''>";
	$content .= "<input type='hidden' name='$hidden_field_name' value='Y' />";
	$content .= "<p>Favorite Color:";
	$content .= "<input type='text' name='$api_key_name' value='$api_key_value' size='20' />";
	$content .= "</p> <hr />";
	$content .= "<p class='submit'>";
	$content .= "<input type='submit' name='Submit' class='button-primary' value='Save Changes' />";
	$content .= "</p>";
	$content .= "</form>";	
	$content .= "</div>";
		
	echo $content;
	
}

# register page with the admin hook
add_action('admin_menu', 'pm_add_settings_page');


?>
