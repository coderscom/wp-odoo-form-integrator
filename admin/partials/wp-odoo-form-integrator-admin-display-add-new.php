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

<h1 id='pagetitle'></h1>
<div class="wrap">
<div id="div_notice" class="notice hidden"><p id="p_notice"></p></div>
<form id="wp_odoo_form_add_new_form" method="post" action="<?php echo admin_url( 'admin.php?page=wp-odoo-form-integrator-integrated-forms'); ?>">
	<hr>
	<input type="hidden" name="wp_odoo_form_add_new_id" id="wp_odoo_form_add_new_id" value="" />
	<table class="form-table haw_mautic_integration_settings">
		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Title', 'wp-odoo-form-integrator' ); ?></th>
			<td>
				<input type="text" class="large-text" name="wp_odoo_form_add_new_title" id="wp_odoo_form_add_new_title" />
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Form Type', 'wp-odoo-form-integrator' ); ?></th>
			<td>
				<select name="wp_odoo_form_add_new_form_type" id="wp_odoo_form_add_new_form_type" class="regular-text">
				</select>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Form', 'wp-odoo-form-integrator' ); ?></th>
			<td>
				<select name="wp_odoo_form_add_new_plugin_form" id="wp_odoo_form_add_new_plugin_form" class="regular-text">
				</select>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Odoo Model', 'wp-odoo-form-integrator' ); ?></th>
			<td>
				<select name="wp_odoo_form_add_new_odoo_model" id="wp_odoo_form_add_new_odoo_model" class="large-text" style="font-family: Courier New, Courier, monospace">
				</select>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Field Mapping', 'wp-odoo-form-integrator' ); ?></th>
			<td>
				<table class="widefat" id="wp_odoo_form_add_new_mapping_table">
					<thead>
					<tr>
						<th width='35%' class="row-title"><?php esc_attr_e( 'Odoo Field', 'wp-odoo-form-integrator' ); ?></th>
						<th width='20%'><?php esc_attr_e( 'Field Key', 'wp-odoo-form-integrator' ); ?></th>
						<th width='15%'><?php esc_attr_e( 'Field Type', 'wp-odoo-form-integrator' ); ?></th>
						<th width='10%'><?php esc_attr_e( 'Required', 'wp-odoo-form-integrator' ); ?></th>
						<th width='20%'><?php esc_attr_e( 'Form Field', 'wp-odoo-form-integrator' ); ?></th>
					</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</td>
		</tr>

	</table>
	<hr>
	<table>
		<tr>
			<td>
				<input type="hidden" name="wp_odoo_form_add_new_record" id="wp_odoo_form_add_new_record" value="wp_odoo_form_add_new_record" />
				<input class="button-primary" type="button" id="wp_odoo_form_add_new_submit" value="<?php esc_html_e( 'Save Mapping', 'wp-odoo-form-integrator' ); ?>" />
			</td>
		</tr>
	</table>

</form>
</div>
<div id="loading_gif" class="modal"><!-- Place at bottom of page --></div>