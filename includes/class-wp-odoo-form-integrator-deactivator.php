<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.coderscom.com/
 * @since      1.0.0
 *
 * @package    Wp_Odoo_Form_Integrator
 * @subpackage Wp_Odoo_Form_Integrator/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Odoo_Form_Integrator
 * @subpackage Wp_Odoo_Form_Integrator/includes
 * @author     Coderscom <coderscom@outlook.com>
 */
class Wp_Odoo_Form_Integrator_Deactivator {

	/**
	 * Deactivates the plugin.
	 *
	 * Deletes options and tables from the database when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option('cc_odoo_integrator_odoo_url');
		delete_option('cc_odoo_integrator_odoo_database');
		delete_option('cc_odoo_integrator_odoo_username');
		delete_option('cc_odoo_integrator_odoo_password');
	}

}
