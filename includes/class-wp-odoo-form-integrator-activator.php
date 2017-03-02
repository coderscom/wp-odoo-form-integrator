<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.coderscom.com/
 * @since      1.0.0
 *
 * @package    Wp_Odoo_Form_Integrator
 * @subpackage Wp_Odoo_Form_Integrator/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Odoo_Form_Integrator
 * @subpackage Wp_Odoo_Form_Integrator/includes
 * @author     Coderscom <coderscom@outlook.com>
 */
class Wp_Odoo_Form_Integrator_Activator {

	/**
	 * Activates the plugin.
	 *
	 * Creates options and tables in the database when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		add_option('cc_odoo_integrator_odoo_url');
		add_option('cc_odoo_integrator_odoo_database');
		add_option('cc_odoo_integrator_odoo_username');
		add_option('cc_odoo_integrator_odoo_password');

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'cc_odoo_integrator_forms';
		if ( $wpdb->get_var( "show tables like '$table_name'") != $table_name ) {
			$sql = "CREATE TABLE $table_name (
			    id int(11) NOT NULL AUTO_INCREMENT,
			    title varchar(255) DEFAULT '' NOT NULL,
			    form_type varchar(255) DEFAULT '' NOT NULL,
			    form varchar(255) DEFAULT '' NOT NULL,
			    odoo_model varchar(255) DEFAULT '' NOT NULL,
			    UNIQUE KEY id (id)
			) $charset_collate;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}

		$table_name = $wpdb->prefix . 'cc_odoo_integrator_field_mapping';
		if ( $wpdb->get_var( "show tables like '$table_name'") != $table_name ) {
			$sql = "CREATE TABLE $table_name (
			    id int(11) NOT NULL AUTO_INCREMENT,
			    parent_id int(11) NOT NULL,
			    odoo_field varchar(255) DEFAULT '' NOT NULL,
			    field_type varchar(255) DEFAULT '' NOT NULL,
			    form_field varchar(255) DEFAULT '' NOT NULL,
			    UNIQUE KEY id (id)
			) $charset_collate;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}


	}

}
