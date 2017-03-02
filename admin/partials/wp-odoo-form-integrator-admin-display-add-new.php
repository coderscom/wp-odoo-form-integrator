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

<h1><?php esc_html_e( 'Add New Odoo-Form Mapping', 'wp-odoo-form-integrator' ); ?></h1>
<div class="wrap">
<?php
	if (isset($_POST['wp_odoo_form_add_new_record'])){
		global $wpdb;
		$table_name = $wpdb->prefix . 'cc_odoo_integrator_forms';
		$form_data = array(
						'title' => $_POST['wp_odoo_form_add_new_title'],
						'form_type' => $_POST['wp_odoo_form_add_new_form_type'],
						'form' => $_POST['wp_odoo_form_add_new_plugin_form'],
						'odoo_model' => $_POST['wp_odoo_form_add_new_odoo_model']
					);
		$wpdb->insert($table_name, $form_data);
		unset($_POST['wp_odoo_form_add_new_title']);
		unset($_POST['wp_odoo_form_add_new_form_type']);
		unset($_POST['wp_odoo_form_add_new_plugin_form']);
		unset($_POST['wp_odoo_form_add_new_odoo_model']);
		unset($_POST['wp_odoo_form_add_new_record']);
		$table_name = $wpdb->prefix . 'cc_odoo_integrator_field_mapping';
		$parent_id = $wpdb->insert_id;
		foreach ($_POST as $key => $value) {
			$form_data = array(
							'parent_id' => $parent_id,
							'odoo_field' => $key,
							'field_type' => 'char',
							'form_field' => $value
						);
			$wpdb->insert($table_name,$form_data);
		}
?>
<div id="div_notice" class="notice notice-success"><p id="p_notice"><?php esc_html_e( 'Odoo-Form Mapping is successfully saved', 'wp-odoo-form-integrator' ); ?></p></div>
<?php
	}else{
?>
<div id="div_notice" class="notice hidden"><p id="p_notice"></p></div>
<?php	
	}
?>
<div id="loading_gif" class="modal"><!-- Place at bottom of page --></div>
<div id="div_notice" class="notice hidden"><p id="p_notice"></p></div>

<form id="wp_odoo_form_add_new_form" method="post" action="<?php echo admin_url( 'admin.php?page=wp-odoo-form-integrator-integrated-forms'); ?>">
	<hr>
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
						<th class="row-title"><?php esc_attr_e( 'Odoo Fields', 'wp-odoo-form-integrator' ); ?></th>
						<th><?php esc_attr_e( 'Field Type', 'wp-odoo-form-integrator' ); ?></th>
						<th><?php esc_attr_e( 'Form Fields', 'wp-odoo-form-integrator' ); ?></th>
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
