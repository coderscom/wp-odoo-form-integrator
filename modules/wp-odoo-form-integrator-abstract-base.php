<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.coderscom.com/
 * @since      1.0.0
 *
 * @package    Wp_Odoo_Form_Integrator
 * @subpackage Wp_Odoo_Form_Integrator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Odoo_Form_Integrator
 * @subpackage Wp_Odoo_Form_Integrator/admin
 * @author     Coderscom <coderscom@outlook.com>
 */

abstract class Wp_Odoo_Form_Integrator_Abstract_Base {

	abstract public function get_plugin_slug();

	abstract public function get_action_tag();

	abstract public function get_plugin_name();

	abstract public function get_all_forms();

	abstract public function get_form_fields($form_id);

	abstract public function handle_callback($contact_form);

}