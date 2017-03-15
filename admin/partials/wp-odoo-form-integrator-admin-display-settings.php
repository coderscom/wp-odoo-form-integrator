<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.coderscom.com/
 * @since      1.0.0
 *
 * @package    Wp_Odoo_Form_Integrator
 * @subpackage Wp_Odoo_Form_Integrator/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<h1><?php esc_html_e( 'WP Odoo Form Integrator Settings', 'wp-odoo-form-integrator' ); ?></h1>
<div class="wrap">
<?php
	if (isset($_POST['wp_odoo_form_odoo_properties'])){
		update_option( 'cc_odoo_integrator_odoo_url', $_POST['cc_odoo_integrator_odoo_url']);
		update_option( 'cc_odoo_integrator_odoo_database', $_POST['cc_odoo_integrator_odoo_database']);
		update_option( 'cc_odoo_integrator_odoo_username', $_POST['cc_odoo_integrator_odoo_username']);
		update_option( 'cc_odoo_integrator_odoo_password', $_POST['cc_odoo_integrator_odoo_password']);
?>
<div id="div_notice" class="notice notice-success"><p id="p_notice"><?php esc_html_e( 'Settings successfully saved', 'wp-odoo-form-integrator' ); ?></p></div>
<?php
	}else{
?>
<div id="div_notice" class="notice hidden"><p id="p_notice"></p></div>
<?php	
	}
?>
<form id="wp_odoo_form_odoo_properties_form" method="post" action="<?php echo admin_url( 'admin.php?page=wp-odoo-form-integrator-settings'); ?>">
	<span class="description"><?php esc_attr_e( 'Odoo server properties', 'wp-odoo-form-integrator' ); ?></span>
	<hr>
	<table class="form-table haw_mautic_integration_settings">
		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'URL', 'wp-odoo-form-integrator' ); ?></th>
			<td>
				<input type="text" class="regular-text" name="cc_odoo_integrator_odoo_url" id="cc_odoo_integrator_odoo_url" value="<?php echo get_option('cc_odoo_integrator_odoo_url'); ?>" />
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Database', 'wp-odoo-form-integrator' ); ?></th>
			<td>
				<input type="text" class="all-options" name="cc_odoo_integrator_odoo_database" id="cc_odoo_integrator_odoo_database" value="<?php echo get_option('cc_odoo_integrator_odoo_database'); ?>" />
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Username', 'wp-odoo-form-integrator' ); ?></th>
			<td>
				<input type="text" class="all-options" name="cc_odoo_integrator_odoo_username" id="cc_odoo_integrator_odoo_username" value="<?php echo get_option('cc_odoo_integrator_odoo_username'); ?>" />
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Password', 'wp-odoo-form-integrator' ); ?></th>
			<td>
				<input type="text" class="all-options" name="cc_odoo_integrator_odoo_password" id="cc_odoo_integrator_odoo_password" value="<?php echo get_option('cc_odoo_integrator_odoo_password'); ?>" />
			</td>
		</tr>

	</table>
	<hr>
	<table>
		<tr>
			<td>
				<input type="hidden" name="wp_odoo_form_odoo_properties" id="wp_odoo_form_odoo_properties" value="wp_odoo_form_odoo_properties" />
				<input class="button-primary" type="button" id="wp_odoo_form_odoo_submit" value="<?php esc_attr_e( 'Save Changes' ); ?>" />
			</td>
			<td><input class="button-secondary" type="button" id="wp_odoo_form_odoo_test" value="<?php esc_attr_e( 'Test Authentication' ); ?>"/></td>
		</tr>
	</table>

</form>
</div>
<div id="loading_gif"><!-- Place at bottom of page --></div>