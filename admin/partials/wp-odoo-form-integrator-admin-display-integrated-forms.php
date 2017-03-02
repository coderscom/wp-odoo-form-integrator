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

<h1><?php esc_html_e( 'WP Odoo Form Integrator', 'wp-odoo-form-integrator' ); ?></h1>
<div class="wrap">
<?php
	global $wpdb;
	$cc_odoo_integrator_forms = $wpdb->prefix . 'cc_odoo_integrator_forms';	
	$cc_odoo_integrator_field_mapping = $wpdb->prefix . 'cc_odoo_integrator_field_mapping';
	if (isset($_POST['wp_odoo_form_add_new_record'])){
		$form_data = array(
						'title' => $_POST['wp_odoo_form_add_new_title'],
						'form_type' => $_POST['wp_odoo_form_add_new_form_type'],
						'form' => $_POST['wp_odoo_form_add_new_plugin_form'],
						'odoo_model' => $_POST['wp_odoo_form_add_new_odoo_model']
					);
		$wpdb->insert($cc_odoo_integrator_forms, $form_data);
		unset($_POST['wp_odoo_form_add_new_title']);
		unset($_POST['wp_odoo_form_add_new_form_type']);
		unset($_POST['wp_odoo_form_add_new_plugin_form']);
		unset($_POST['wp_odoo_form_add_new_odoo_model']);
		unset($_POST['wp_odoo_form_add_new_record']);
		foreach ($_POST as $key => $value) {
			$form_data = array(
							'parent_id' => $wpdb->insert_id,
							'odoo_field' => $key,
							'field_type' => 'char',
							'form_field' => $value
						);
			$wpdb->insert($cc_odoo_integrator_field_mapping,$form_data);
		}
?>
<div id="div_notice" class="notice notice-success"><p id="p_notice"><?php esc_html_e( 'Odoo-Form Mapping is successfully saved', 'wp-odoo-form-integrator' ); ?></p></div>
<?php
	}else{
?>
<div id="div_notice" class="notice hidden"><p id="p_notice"></p></div>
<?php	
	}

	$sql = "SELECT A.id, A.title, A.form_type, A.form, A.odoo_model, COUNT(B.id) as field_mapping ".
		   "FROM ". $cc_odoo_integrator_forms ." as A LEFT JOIN ".
		   $cc_odoo_integrator_field_mapping." as B ON A.id = B.parent_id GROUP BY A.id";
	$result = $wpdb->get_results($sql);
?>

<table>
	<tr>
		<td>
			<form method="post" action="<?php echo admin_url( 'admin.php?page=wp-odoo-form-integrator-add-new'); ?>">
				<input class="button-primary" type="submit" value="<?php esc_html_e( 'Add New', 'wp-odoo-form-integrator' ); ?>" />
			</form>	
		</td>
	</tr>
</table>
<table class="widefat">
	<thead>
	<tr>
		<th width='20%'><strong><?php esc_attr_e( 'Title', 'wp-odoo-form-integrator' ); ?></strong></th>
		<th width='17%'><strong><?php esc_attr_e( 'Form Type', 'wp-odoo-form-integrator' ); ?></strong></th>
		<th width='17%'><strong><?php esc_attr_e( 'Form', 'wp-odoo-form-integrator' ); ?></strong></th>
		<th width='26%'><strong><?php esc_attr_e( 'Odoo Model', 'wp-odoo-form-integrator' ); ?></strong></th>
		<th width='10%'><strong><?php esc_attr_e( 'Fields Mapped', 'wp-odoo-form-integrator' ); ?></strong></th>
		<th width='10%'><strong><?php esc_attr_e( 'Action', 'wp-odoo-form-integrator' ); ?></strong></th>
	</tr>
	</thead>
	<tbody>
	<?php
	$count = 0;
	foreach ( $result as $row ) {
	?>
	<tr <?php echo "".(++$count%2 ? "class='alternate'" : "") ?>>
		<td><?php echo $row->title ?></td>
		<td><?php echo $row->form_type ?></td>
		<td><?php echo $row->form ?></td>
		<td><?php echo $row->odoo_model ?></td>
		<td>12</td>
		<td>
			<div>
				<span class="edit">
					<a href="?page=">Edit</a> | 
				</span>
				<span class="delete"><a href="?page=">Delete</a>
				</span>
			</div>
		</td>
	</tr>
	<?php
	}
	?>
	</tbody>
</table>
<div class="tablenav">
	<div class="tablenav-pages">
		<a class='first-page disabled' title='Go to first page' href='#'>&laquo;</a>
		<a class='prev-page disabled' title='Go to previous page' href='#'>&lsaquo;</a>
		<span class="paging-input"><input class='current-page' title='Current page' type='text' 
name='paged' value='1' size='1' /> of <span class='total-pages'>5</span></span>
		<a class='next-page' title='Go to next page' href='#'>&rsaquo;</a>
		<a class='last-page' title='Go to last page' href='#'>&raquo;</a>
	</div>
</div>
</div>