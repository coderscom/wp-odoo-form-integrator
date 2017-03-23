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

class Wp_Odoo_Form_Integrator_Form_Contact_7 {

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function get_plugin_slug(){
        return "wp-contact-form-7";
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function get_action_tag(){
        return "wpcf7_mail_sent";
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function get_plugin_name(){
        return "Contact Form 7";
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function get_all_forms(){
        $result = array();
        $args = array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1 );
        if ( $cf7Forms = get_posts( $args ) ) {
            foreach ( $cf7Forms as $cf7Form ) {
                $result[] = array( 'id' => $cf7Form->ID, 'label' => $cf7Form->post_title );
            }
        }
        return $result;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function get_form_fields($form_id){
        $args = get_post_meta( $form_id, '_form', 'true' );
        preg_match_all( '/\[([^\]]*)\]/', $args, $matches );
        if ( isset( $matches['1'] ) ) {
            foreach ( $matches['1'] as $fields ) {
                $split      = explode( ' ', $fields );
                $result[]   = array( 'id' => $split[1], 'label' => $fields );
            }
        }
        return $result;
    }

    /**
     * Callback argument count
     *
     * @since    1.0.0
     */
    public function get_callback_argument_count(){
        return 1;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function handle_callback($contact_form){
        $submission = WPCF7_Submission::get_instance();
        if ( $submission ) {
            $form_id        = $contact_form->id();
            $posted_data    = $submission->get_posted_data();
            error_log("CF7 ".print_r($posted_data, TRUE), 0);
            do_action( 'wp_odoo_form_integrator_push_to_odoo', __CLASS__, $form_id, $posted_data );
        }
    }
}