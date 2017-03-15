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
class Wp_Odoo_Form_Integrator_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $js_object = array();
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		/**
		 * Defining ajax error messages that common for all admin screens
		 */
		$this->js_object['str_notice_ajax_failed'] = __( 'Ajax service is failed due to internal server error', 'wp-odoo-form-integrator' );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Odoo_Form_Integrator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Odoo_Form_Integrator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-odoo-form-integrator-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Odoo_Form_Integrator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Odoo_Form_Integrator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-odoo-form-integrator-admin.js', array( 'jquery' ), $this->version, true );

		$js_object = array(
			'str_error_odoo_url' => __( 'Please provide valid URL', 'wp-odoo-form-integrator' ),
			'str_error_odoo_database' => __( 'Please provide valid database', 'wp-odoo-form-integrator' ),
			'str_error_odoo_username' => __( 'Please provide valid username', 'wp-odoo-form-integrator' ),
			'str_error_odoo_password' => __( 'Please provide valid password', 'wp-odoo-form-integrator' ),
			'ajx_url' => admin_url(),
			'str_notice_ajax_failed' => __( 'Unable to test due to internal server error', 'wp-odoo-form-integrator' ),
			'str_notice_odoo_connected' => __( 'Successfully connects to Odoo Server', 'wp-odoo-form-integrator' ),
		);
		wp_localize_script( $this->plugin_name, 'wp_odoo_form_integrator_admin_settings', $js_object );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
	    
	    add_menu_page(
	        __( 'WP Odoo Form Integrator', 'wp-odoo-form-integrator' ),
	        __( 'WP Odoo Form Integrator', 'wp-odoo-form-integrator' ),
	        'manage_options',
	        $this->plugin_name,
	        array($this, 'display_plugin_settings_page'),
	        'dashicons-welcome-widgets-menus'
    	);

    	add_submenu_page(
	        $this->plugin_name,
	        __( 'Integrated Forms', 'wp-odoo-form-integrator' ),
	        __( 'Integrated Forms', 'wp-odoo-form-integrator' ),
	        'manage_options',
	        'wp-odoo-form-integrator-integrated-forms',
	        array($this, 'display_plugin_integrated_forms_page')
    	);

    	add_submenu_page(
	        $this->plugin_name,
	        __( 'Add New', 'wp-odoo-form-integrator' ),
	        __( 'Add New', 'wp-odoo-form-integrator' ),
	        'manage_options',
	        'wp-odoo-form-integrator-add-new',
	        array($this, 'display_plugin_add_new_page')
    	);

    	add_submenu_page(
	        null,
	        __( 'Edit Mapping', 'wp-odoo-form-integrator' ),
	        __( 'Edit Mapping', 'wp-odoo-form-integrator' ),
	        'manage_options',
	        'wp-odoo-form-integrator-edit-mapping',
	        array($this, 'display_plugin_edit_mapping_page')
    	);

    	add_submenu_page(
	        $this->plugin_name,
	        __( 'Settings', 'wp-odoo-form-integrator' ),
	        __( 'Settings', 'wp-odoo-form-integrator' ),
	        'manage_options',
	        'wp-odoo-form-integrator-settings',
	        array($this, 'display_plugin_settings_page')
    	);

    	remove_submenu_page('wp-odoo-form-integrator','wp-odoo-form-integrator');

	}

	/**
	 * This tests Odoo connection. It's called through AJAX service.
	 *
	 * @since    1.0.0
	 */
	public function test_odoo_connection() {

		/**
		 * This is RPC client library used to call Odoo APIs.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-odoo-client.php';

		$client = new Wp_Odoo_Client($_POST['cc_odoo_integrator_odoo_url'],
									 $_POST['cc_odoo_integrator_odoo_database'],
									 $_POST['cc_odoo_integrator_odoo_username'],
									 $_POST['cc_odoo_integrator_odoo_password']);
		try {
			echo json_encode($client->test_authentication());
		} catch (Exception $e) {
			$ret = array();
			$ret['status'] = false;
			$ret['message'] = $e->getMessage(); 
			echo json_encode($ret);
		}
		wp_die();
	}

	/**
	 * This gets all types of supported form types. 
	 * It's called through AJAX service.
	 *
	 * @since    1.0.0
	 */
	public function get_form_types() {

		global $wp_odoo_form_modules;

		$result = array();
		foreach ($wp_odoo_form_modules as $module) {
			$object = new $module();
			$result[$module] = $object->get_plugin_name();
		}
		echo json_encode($result);
		wp_die();

	}

	/**
	 * This gets all types of supported form types. 
	 * It's called through AJAX service.
	 *
	 * @since    1.0.0
	 */
	public function get_all_forms() {

		$result = array();
		$object = new $_POST['module']();
		$all_forms = $object->get_all_forms();
		foreach ($all_forms as $form) {
			$result[$form['id']] = $form['label'];
		}
		echo json_encode($result);
		wp_die();

	}

	/**
	 * This gets all types of supported form types. 
	 * It's called through AJAX service.
	 *
	 * @since    1.0.0
	 */
	public function get_form_fields() {

		$result = array();
		$object = new $_POST['module']();
		$all_forms = $object->get_form_fields($_POST['form_id']);
		foreach ($all_forms as $form) {
			$result[$form['id']] = $form['label'];
		}
		echo json_encode($result);
		wp_die();

	}

	/**
	 * This gets all types of supported form types. 
	 * It's called through AJAX service.
	 *
	 * @since    1.0.0
	 */
	public function get_odoo_models() {

		$result = array();
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-odoo-client.php';
		$client = new Wp_Odoo_Client(get_option('cc_odoo_integrator_odoo_url'),
									 get_option('cc_odoo_integrator_odoo_database'),
									 get_option('cc_odoo_integrator_odoo_username'),
									 get_option('cc_odoo_integrator_odoo_password'));
		try {
			echo json_encode($client->get_models());
		} catch (Exception $e) {
			$ret = array();
			$ret['status'] = false;
			$ret['message'] = $e->getMessage(); 
			echo json_encode($ret);
		}
		wp_die();

	}

	/**
	 * This gets all types of supported form types. 
	 * It's called through AJAX service.
	 *
	 * @since    1.0.0
	 */
	public function get_odoo_fields() {

		/**
		 * This is RPC client library used to call Odoo APIs.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-odoo-client.php';
		$client = new Wp_Odoo_Client(get_option('cc_odoo_integrator_odoo_url'),
									 get_option('cc_odoo_integrator_odoo_database'),
									 get_option('cc_odoo_integrator_odoo_username'),
									 get_option('cc_odoo_integrator_odoo_password'));
		try {
			echo json_encode($client->get_fields($_POST['module']));
		} catch (Exception $e) {
			$ret = array();
			$ret['status'] = false;
			$ret['message'] = $e->getMessage(); 
			echo json_encode($ret);
		}
		wp_die();

	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {
	   $settings_link = array(
	    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_settings_page() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-odoo-form-integrator-admin-settings.css', array(), $this->version, 'all' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-odoo-form-integrator-admin-settings.js', array( 'jquery' ), $this->version, true );

		$this->js_object['str_error_odoo_url'] = __( 'Please provide valid URL', 'wp-odoo-form-integrator' );
		$this->js_object['str_error_odoo_database'] = __( 'Please provide valid database', 'wp-odoo-form-integrator' );
		$this->js_object['str_error_odoo_username'] = __( 'Please provide valid username', 'wp-odoo-form-integrator' );
		$this->js_object['str_error_odoo_password'] = __( 'Please provide valid password', 'wp-odoo-form-integrator' );
		$this->js_object['str_notice_odoo_connected'] = __( 'WP successfully connected to Odoo Server', 'wp-odoo-form-integrator' );
		wp_localize_script( $this->plugin_name, 'wp_odoo_form_integrator_admin_settings', $this->js_object );
	    
	    include_once( 'partials/wp-odoo-form-integrator-admin-display-settings.php' );

	}

	/**
	 * Render integrated forms page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_integrated_forms_page() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-odoo-form-integrator-admin-integrated-forms.css', array(), $this->version, 'all' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-odoo-form-integrator-admin-integrated-forms.js', array( 'jquery' ), $this->version, true );

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
			$update_action = false;
			if (isset($_POST['wp_odoo_form_add_new_id'])){
				$wpdb->update(
					$cc_odoo_integrator_forms, 
					$form_data, 
					array( 'ID' => $_POST['wp_odoo_form_add_new_id'] ), 
					array( '%s', '%s', '%s', '%s'), 
					array( '%d' )
				);
				$update_action = true;
				$parent_id = $_POST['wp_odoo_form_add_new_id'];
				unset($_POST['wp_odoo_form_add_new_id']);
			}else{
				$wpdb->insert($cc_odoo_integrator_forms, $form_data);			
				$parent_id = $wpdb->insert_id;
			}
			unset($_POST['wp_odoo_form_add_new_title']);
			unset($_POST['wp_odoo_form_add_new_form_type']);
			unset($_POST['wp_odoo_form_add_new_plugin_form']);
			unset($_POST['wp_odoo_form_add_new_odoo_model']);
			unset($_POST['wp_odoo_form_add_new_record']);
			if ($update_action){
				$wpdb->delete( $cc_odoo_integrator_field_mapping, 
							   array( 'parent_id' => $parent_id ), array( '%d' ) );
			}
			foreach ($_POST as $key => $value) {
				$form_data = array(
								'parent_id' => $parent_id,
								'odoo_field' => $key,
								'field_type' => 'char',
								'form_field' => $value
							);
				$wpdb->insert($cc_odoo_integrator_field_mapping, $form_data);
			}
			$this->js_object['str_notice_success_message'] = __( 'Odoo-Form Mapping is successfully saved', 'wp-odoo-form-integrator' );
		}else if (isset($_POST['wp_odoo_form_form_to_delete'])){
			$ret = $wpdb->delete( $cc_odoo_integrator_forms, array( 'id' => $_POST['wp_odoo_form_form_to_delete'] ), array( '%d' ) );
			$ret = $wpdb->delete( $cc_odoo_integrator_field_mapping, array( 'parent_id' => $_POST['wp_odoo_form_form_to_delete'] ), array( '%d' ));
			$this->js_object['str_notice_success_message'] = __( 'Odoo-Form Mapping is successfully deleted', 'wp-odoo-form-integrator' );
		}

		$rec_limit = 50;
		$sql = "SELECT count(id) as total FROM ". $cc_odoo_integrator_forms;
		$result = $wpdb->get_row($sql);
		$rec_count = $result->total;
		if( isset($_GET{'pageno'} ) ) {
	        $page = $_GET{'pageno'}-1;
	        $offset = $rec_limit * $page ;
	    }else {
	        $page = 0;
	        $offset = 0;
	    }
	    $left_rec = $rec_count - ($page * $rec_limit);
	    $max_page = ceil($rec_count / $rec_limit);
		$sql = "SELECT A.id, A.title, A.form_type, A.form, A.odoo_model, COUNT(B.id) as mapped_fields_count ".
			   "FROM ". $cc_odoo_integrator_forms ." as A LEFT JOIN ".
			   $cc_odoo_integrator_field_mapping." as B ON A.id = B.parent_id GROUP BY A.id ".
			   "LIMIT $rec_limit OFFSET $offset";
		$result = $wpdb->get_results($sql);
		wp_localize_script( $this->plugin_name, 'wp_odoo_form_integrator_integrated_forms', $this->js_object );
	    include_once( 'partials/wp-odoo-form-integrator-admin-display-integrated-forms.php' );
	}

	/**
	 * Render integrated forms page for this plugin.
	 *
	 * @since    1.0.0
	 */
	private function include_common_form_mapping() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-odoo-form-integrator-admin-settings.css', array(), $this->version, 'all' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-odoo-form-integrator-admin-add-new.js', array( 'jquery' ), $this->version, true );

		$this->js_object['str_select_form_type'] = __( 'Please select form type', 'wp-odoo-form-integrator' );
		$this->js_object['str_select_form'] = __( 'Please select form', 'wp-odoo-form-integrator' );
		$this->js_object['str_select_form_fields'] = __( 'Please select form fields', 'wp-odoo-form-integrator' );
		$this->js_object['str_select_odoo_model'] = __( 'Please select odoo model', 'wp-odoo-form-integrator' );
		$this->js_object['str_form_type_change_warning'] = __( 'Change of form type will reset form and field mapping. Do you want to continue?', 'wp-odoo-form-integrator' );
		$this->js_object['str_form_change_warning'] = __( 'Change of form will reset field mapping. Do you want to continue?', 'wp-odoo-form-integrator' );
		$this->js_object['str_odoo_model_change_warning'] = __( 'Change of Odoo model will reset field mapping. Do you want to continue?', 'wp-odoo-form-integrator' );
		$this->js_object['str_unable_fetch_odoo_model'] = __( 'Unable to fetch Odoo models. Please check Settings', 'wp-odoo-form-integrator' );

		$this->js_object['str_error_mapping_title'] = __( 'Please provide title', 'wp-odoo-form-integrator' );
		$this->js_object['str_error_mapping_form_type'] = __( 'Please select form type', 'wp-odoo-form-integrator' );
		$this->js_object['str_error_mapping_form'] = __( 'Please select form', 'wp-odoo-form-integrator' );
		$this->js_object['str_error_mapping_model'] = __( 'Please select model', 'wp-odoo-form-integrator' );
		$this->js_object['str_error_mapping_no_fields'] = __( 'No fields are mapped', 'wp-odoo-form-integrator' );

		wp_localize_script( $this->plugin_name, 'wp_odoo_form_integrator_admin_add_new', $this->js_object );

	    include_once( 'partials/wp-odoo-form-integrator-admin-display-add-new.php' );
	}

	/**
	 * Render integrated forms page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_add_new_page() {

		$this->js_object['str_page_title'] = __( 'Add New Odoo-Form Mapping', 'wp-odoo-form-integrator' );
		$this->include_common_form_mapping();

	}

	/**
	 * Render integrated forms page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_edit_mapping_page() {
		if (isset($_GET['wp_odoo_form_form_to_edit'])){
			global $wpdb;
			$cc_odoo_integrator_forms = $wpdb->prefix . 'cc_odoo_integrator_forms';	
			$cc_odoo_integrator_field_mapping = $wpdb->prefix . 'cc_odoo_integrator_field_mapping';
			$sql = "SELECT A.id, A.title, A.form_type, A.form, A.odoo_model FROM ". 
					$cc_odoo_integrator_forms ." A WHERE A.id = ".$_GET['wp_odoo_form_form_to_edit'];
			$result = $wpdb->get_row($sql);
			$this->js_object['str_odoo_form_id'] = $result->id;
			$this->js_object['str_odoo_form_title'] = $result->title;
			$this->js_object['str_odoo_form_form_type'] = $result->form_type;
			$this->js_object['str_odoo_form_form'] = $result->form;
			$this->js_object['str_odoo_form_odoo_model'] = $result->odoo_model;

			$sql = "SELECT A.odoo_field,  A.field_type, A.form_field FROM ".
					$cc_odoo_integrator_field_mapping . " A WHERE A.parent_id = ".$result->id;
			$result = $wpdb->get_results($sql);
			$this->js_object['str_odoo_form_odoo_mapped_fields'] = $result;
		}
		$this->js_object['str_page_title'] = __( 'Edit Odoo-Form Mapping', 'wp-odoo-form-integrator' );
		$this->include_common_form_mapping();
	}

}
