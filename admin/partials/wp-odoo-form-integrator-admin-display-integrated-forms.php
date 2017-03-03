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
<div id="div_notice" class="notice hidden"><p id="p_notice"></p></div>
<table>
	<tr>
		<td>
			<form method="post" action="<?php echo admin_url( 'admin.php?page=wp-odoo-form-integrator-add-new'); ?>">
				<input class="button-primary" type="submit" value="<?php esc_html_e( 'Add New', 'wp-odoo-form-integrator' ); ?>" />
			</form>	
		</td>
	</tr>
</table>
<form id="wp_odoo_form_integrated_forms_delete" method="post" action="<?php echo admin_url( 'admin.php?page=wp-odoo-form-integrator-integrated-forms'); ?>">
	<input type='hidden' id='wp_odoo_form_form_to_delete' name='wp_odoo_form_form_to_delete' value=''>
</form>
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
	$count = 2;
	foreach ( $result as $row ) {
	?>
	<tr <?php echo "".(++$count%2 ? "class='alternate'" : "") ?>>
		<td><?php echo $row->title ?></td>
		<?php
			$formtype = $row->form_type; 
			$object = new $formtype();
			$plugin_name = $object->get_plugin_name();
		?>
		<td><?php echo $plugin_name ?></td>
		<td><?php echo $row->form ?></td>
		<td><?php echo $row->odoo_model ?></td>
		<td><?php echo $row->mapped_fields_count ?></td>
		<td>
			<div>
				<span class="edit" onclick="window.location.href='<?php echo admin_url( 'admin.php?page=wp-odoo-form-integrator-edit-mapping&wp_odoo_form_form_to_edit=').$row->id; ?>'">
					<?php esc_attr_e( 'Edit', 'wp-odoo-form-integrator' ); ?>
				</span>
				|
				<span class="delete" onclick="if (confirm('Please confirm to delete.')) {document.getElementById('wp_odoo_form_form_to_delete').value = '<?php echo $row->id ?>'; document.getElementById('wp_odoo_form_integrated_forms_delete').submit(); return true;} return false;">
				   <?php esc_attr_e( 'Delete', 'wp-odoo-form-integrator' ); ?>
				</span>
			</div>
		</td>
	</tr>
	<?php
	}
	if (!$count){
	?>
	<!-- <tr>
		<td colspan="6" align="center"> No form is integrated with Odoo</td>
	</tr> -->
	<?php
	}
	?>
	</tbody>
</table>
<?php
	if (!($max_page == 1)){
?>
	<div class="tablenav">
		<div class="tablenav-pages">
			<a class='first-page disabled' title='<?php esc_attr_e( 'Go to first page', 'wp-odoo-form-integrator' ); ?>' href='<?php echo admin_url( 'admin.php?page=wp-odoo-form-integrator-integrated-forms&pageno=1'); ?>'>&laquo;</a>
			<a class='prev-page disabled' title='<?php esc_attr_e( 'Go to previous page', 'wp-odoo-form-integrator' ); ?>' href='<?php echo admin_url( 'admin.php?page=wp-odoo-form-integrator-integrated-forms&pageno='.(($page > 1) ? ($page) : 1)); ?>'>&lsaquo;</a>
			<span class="paging-input"> <?php echo $page + 1 ?> of <span class='total-pages'><?php echo $max_page; ?></span></span>
			<a class='next-page' title='<?php esc_attr_e( 'Go to next page', 'wp-odoo-form-integrator' ); ?>' href='<?php echo admin_url( 'admin.php?page=wp-odoo-form-integrator-integrated-forms&pageno='.((($page+1) < $max_page) ? ($page+2) : $max_page) ) ?>'>&rsaquo;</a>
			<a class='last-page' title='<?php esc_attr_e( 'Go to last page', 'wp-odoo-form-integrator' ); ?>' href='<?php echo admin_url( 'admin.php?page=wp-odoo-form-integrator-integrated-forms&pageno='.$max_page ) ?>'>&raquo;</a>
		</div>
	</div>
<?php
	}
?>
</div>