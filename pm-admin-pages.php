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


?>
