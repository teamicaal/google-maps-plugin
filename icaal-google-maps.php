<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.icaal.co.uk
 * @since             1.0.0
 * @package           Icaal_Google_Maps
 *
 * @wordpress-plugin
 * Plugin Name:       ICAAL Google Maps
 * Plugin URI:        http://www.icaal.co.uk
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            ICAAL
 * Author URI:        http://www.icaal.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       icaal-google-maps
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-icaal-google-maps-activator.php
 */
function activate_icaal_google_maps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-icaal-google-maps-activator.php';
	Icaal_Google_Maps_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-icaal-google-maps-deactivator.php
 */
function deactivate_icaal_google_maps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-icaal-google-maps-deactivator.php';
	Icaal_Google_Maps_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_icaal_google_maps' );
register_deactivation_hook( __FILE__, 'deactivate_icaal_google_maps' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-icaal-google-maps.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_icaal_google_maps() {

	$plugin = new Icaal_Google_Maps();
	$plugin->run();

}
run_icaal_google_maps();
