<?php
/**
 * Client Exchange plugin
 *
 * Extends wordpress for Client exchanes needs
 *
 * @package   client-exchange-plugin
 * @author    C.J.Churchill <churchill.c.j@gmail.com>
 * @license   GPL-2.0+
 * @link      http://buildawebdoctor.com
 * @copyright 7-13-2014 BAWD
 *
 * @wordpress-plugin
 * Plugin Name: Client Exchange plugin
 * Plugin URI:  http://buildawebdoctor.com
 * Description: Extends wordpress for Client exchanes needs
 * Version:     1.0.0
 * Author:      C.J.Churchill
 * Author URI:  http://buildawebdoctor.com
 * Text Domain: client-exchange-plugin-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if (!defined("WPINC")) {
	die;
}

require_once(plugin_dir_path(__FILE__) . "ClientExchangePlugin.php");

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook(__FILE__, array("ClientExchangePlugin", "activate"));
register_deactivation_hook(__FILE__, array("ClientExchangePlugin", "deactivate"));

ClientExchangePlugin::get_instance();