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
	
	$pardot_userkey_name = 'pm_pardot_api_key';	
	$pardot_userkey_value = get_option($pardot_userkey_name);
	
	$pardot_email_name = 'pm_pardot_email';	
	$pardot_email = get_option($pardot_email_name);

	$pardot_password_name = 'pm_pardot_password';	
	$pardot_password = get_option($pardot_password_name);

	$hidden_field_name = 'pm_submit_hidden';

	# If we've already gotten some info via post,
	# we'll update our option
	if (isset($_POST[$hidden_field_name]) && $_POST[$hidden_field_name] == 'Y') {
		$pardot_userkey_value = $_POST[$pardot_userkey_name];
		$pardot_email = $_POST[$pardot_email_name];
		$pardot_password = $_POST[$pardot_password_name];
		
		update_option($pardot_userkey_name, $pardot_userkey_value);
		update_option($pardot_email_name, $pardot_email);
		update_option($pardot_password_name, $pardot_password);
		
		$settings_saved = __('Settings Saved.', 'menu-test');
		$content .= "<div class='updated'><p><strong>$settings_saved</strong></p></div>";
	}
	
	$content .= "<div class='wrap'>";
	$content .= "<h2>";
	$content .= __('Pardon Me Settings', 'menu-test');
	$content .= "</h2>";
	
	# Form
	
	$content .= "<form class='pardot-settings' name='pardot-settings' method='post' action=''>";
	$content .= "<input type='hidden' name='$hidden_field_name' value='Y' />";
	
	$content .= "<p><label for='$pardot_userkey_name'>Pardot User Key:</label>";
	$content .= "<input type='text' name='$pardot_userkey_name' value='$pardot_userkey_value' size='20' />";
	$content .= "</p> <hr />";
	
	$content .= "<p><label for='$pardot_email_name'>Pardot Email:</label>";
	$content .= "<input type='text' name='$pardot_email_name' value='$pardot_email' size='20' />";
	$content .= "</p> <hr />";
	
	$content .= "<p><label for='$pardot_password_name'>Pardot Password:</label>";
	$content .= "<input type='text' name='$pardot_password_name' value='$pardot_password' size='20' />";
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
