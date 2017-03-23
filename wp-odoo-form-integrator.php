<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.coderscom.com/
 * @since             1.0.0
 * @package           Wp_Odoo_Form_Integrator
 *
 * @wordpress-plugin
 * Plugin Name:       WP Odoo Form Integrator
 * Plugin URI:        http://www.coderscom.com/
 * Description:       WP Odoo Form Integrator plugin is a bridge between several highly used Wordpress form plugins and Odoo.
 * Version:           1.0.0
 * Author:            Coderscom
 * Author URI:        http://www.coderscom.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-odoo-form-integrator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Register class name of modules here.
$wp_odoo_form_modules = array( 'Wp_Odoo_Form_Integrator_Form_Contact_7',
							   'Wp_Odoo_Form_Integrator_Ninja_Forms',
							   'Wp_Odoo_Form_Integrator_Formidable_Forms' );


/**
 * Include all of the form integration files
 */
foreach ( glob( dirname( __FILE__ ) . "/modules/*.*" ) as $filename ) {
	require_once $filename;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-odoo-form-integrator-activator.php
 */
function activate_wp_odoo_form_integrator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-odoo-form-integrator-activator.php';
	Wp_Odoo_Form_Integrator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-odoo-form-integrator-deactivator.php
 */
function deactivate_wp_odoo_form_integrator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-odoo-form-integrator-deactivator.php';
	Wp_Odoo_Form_Integrator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_odoo_form_integrator' );
register_deactivation_hook( __FILE__, 'deactivate_wp_odoo_form_integrator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-odoo-form-integrator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_odoo_form_integrator() {

	$plugin = new Wp_Odoo_Form_Integrator();
	$plugin->run();

}
run_wp_odoo_form_integrator();