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

# Set it off: 
require_once( PARDON_ME_PLUGIN_DIR . 'pm-admin-pages.php' );
require_once( PARDON_ME_PLUGIN_DIR . 'pm-shortcodes.php' );
?>
