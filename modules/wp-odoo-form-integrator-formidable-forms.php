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

class Wp_Odoo_Form_Integrator_Formidable_Forms {

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function get_plugin_slug(){
        return "formidable";
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function get_action_tag(){
        return "frm_after_create_entry";
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function get_plugin_name(){
        return "Formidable Forms";
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function get_all_forms(){
        global $wpdb;
        $query = 'select id, name from ' . $wpdb->prefix . 'frm_forms';
        $formidable_forms = $wpdb->get_results( $query );
        foreach( $formidable_forms as $form ) {
            $result[] = array( 'id' => $form->id , 'label' => $form->name );
        }
        return $result;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function get_form_fields($form_id){
        global $wpdb;
        $query = 'select id,default_value,name from '. $wpdb->prefix . 'frm_fields where form_id=%d';
        $form_fields = $wpdb->get_results(
                            $wpdb->prepare(
                                $query,
                                $form_id
                            )
                        );

        foreach ( $form_fields as $field ) {
            $label = empty( $field->name )? $field->default_value : $field->name;
            $result[] = array( 'id' => $field->id, 'label' => $label );
        }
        return $result;
    }

    /**
     * Callback argument count
     *
     * @since    1.0.0
     */
    public function get_callback_argument_count(){
        return 2;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function handle_callback($entry_id, $form_id){
        error_log("entry_id = $entry_id", 0);
        error_log("form_id = $form_id", 0);
        $posted_data = $_POST['item_meta'];
        error_log( print_r($posted_data, TRUE) );
        do_action( 'wp_odoo_form_integrator_push_to_odoo', __CLASS__, $form_id, $posted_data );
    }
}