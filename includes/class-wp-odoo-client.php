<?php

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'lib/ripcord-master/ripcord.php';

/**
 * Utility class to call Odoo APIs 
 *
 * This call provides methods to access Odoo APIs. This class have to be used 
 * across the plugin for accessing XML-RPC
 *
 * @link       http://www.coderscom.com/
 * @since      1.0.0
 *
 * @package    Wp_Odoo_Form_Integrator
 * @subpackage Wp_Odoo_Form_Integrator/includes
 */

/**
 * Utility class to call Odoo APIs 
 *
 * This call provides methods to access Odoo APIs. This class have to be used 
 * across the plugin for accessing XML-RPC
 *
 * @since      1.0.0
 * @package    Wp_Odoo_Form_Integrator
 * @subpackage Wp_Odoo_Form_Integrator/includes
 * @author     Coderscom <coderscom@outlook.com>
 */
class Wp_Odoo_Client {

	/**
	 * The Odoo URL.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $url    The Odoo URL.
	 */
	protected $url;

	/**
	 * The Odoo database.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $database    The Odoo database.
	 */
	protected $database;

	/**
	 * The Odoo username.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $username    The Odoo username.
	 */
	protected $username;

	/**
	 * The Odoo password.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $password    The Odoo password.
	 */
	protected $password;

	/**
	 * The version of Odoo server.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The version of Odoo server.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct($url, $database, $username, $password) {

		$this->url = $url;
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;

	}

	public function get_version(){
		if (!$this->version) {
			$common = ripcord::client($this->url."/xmlrpc/2/common");
			$this->version = $common->version();
		}
		return $this->version;
	}

	/**
	 * Get user id of authenticated user.
	 *
	 * @since    1.0.0
	 */
	private function get_uid() {
		$common = ripcord::client($this->url."/xmlrpc/2/common");
		$uid = $common->authenticate($this->database, $this->username, 
									 $this->password, array());
		return $uid;
	}

	public function test_authentication(){
		$ret = array();
		$res = $this->get_uid();
		if (is_array($res)){
			$ret['status'] = false;
			$ret['message'] = $res['faultString']; 
			return $ret;
		}elseif (is_integer($res)) {
			$ret['status'] = true;
			$ret['message'] = 'success'; 
			return $ret;
		}
		$ret['status'] = false;
		$ret['message'] = __( 'Authentication failed on the Odoo server', 'wp-odoo-form-integrator' ); 
		return $ret;
	}

	public function get_models(){
		$ret = array();
		$res = $this->get_uid();
		if (is_array($res)){
			$ret['status'] = false;
			$ret['message'] = $res['faultString']; 
			return $ret;
		}elseif (is_integer($res)) {
			$rclient = ripcord::client($this->url."/xmlrpc/2/object");
			$ret = $rclient->execute_kw($this->database, $this->get_uid(), 
									   $this->password, 'ir.model', 'search', 
									   array(array()));
			if (!$ret[faultCode]){
				$ret = $rclient->execute_kw($this->database, $this->get_uid(), 
										   $this->password, 'ir.model', 'read', 
    									   array($ret), 
    									   array('fields'=>array('model', 'name')));
				if (!$ret[faultCode]){
					$ret['status'] = true;
					return $ret;
				}
			}
			$ret['status'] = false;
			$ret['message'] = __( 'Unable to fetch models from Odoo', 'wp-odoo-form-integrator' ); 
			return $ret;
		}
		$ret['status'] = false;
		$ret['message'] = __( 'Authentication failed on the Odoo server', 'wp-odoo-form-integrator' ); 
		return $ret;
	}

	public function get_fields($model){
		$ret = array();
		$res = $this->get_uid();
		if (is_array($res)){
			$ret['status'] = false;
			$ret['message'] = $res['faultString']; 
			return $ret;
		}elseif (is_integer($res)) {
			$rclient = ripcord::client($this->url."/xmlrpc/2/object");
			$ret = $rclient->execute_kw($this->database, $this->get_uid(), 
									   $this->password, $model, 'fields_get', 
									   array(), array('attributes' => array('string', 'required', 'help', 'type')));
			if (!$ret[faultCode]){
				$ret['status'] = true;
			}else{
				$ret['status'] = false;
				$ret['message'] = __( 'Unable to fetch fields from selected Odoo model', 'wp-odoo-form-integrator' ); 
			}
			return $ret;
		}
		$ret['status'] = false;
		$ret['message'] = __( 'Authentication failed on the Odoo server', 'wp-odoo-form-integrator' ); 
		return $ret;
	}

	public function push_to_odoo($type, $id, $data){
		try {
			$res = $this->get_uid();
			if (is_integer($res)) {
				$rclient = ripcord::client($this->url."/xmlrpc/2/object");
				global $wpdb;
				$cc_odoo_integrator_forms = $wpdb->prefix . 'cc_odoo_integrator_forms';	
				$cc_odoo_integrator_field_mapping = $wpdb->prefix . 'cc_odoo_integrator_field_mapping';
				$sql = "SELECT A.id, A.odoo_model FROM " . $cc_odoo_integrator_forms . " as A " .
					   "WHERE A.form_type = '".$type."' AND A.form = ".$id;
				$form_ids = $wpdb->get_results($sql);
				foreach ( $form_ids as $form_row ) {
					$sql = "SELECT A.odoo_field,  A.field_type, A.form_field FROM ".
							$cc_odoo_integrator_field_mapping . " A WHERE A.parent_id = ".$form_row->id;
					$mappings = $wpdb->get_results($sql);
					$fields = array();
					foreach ( $mappings as $map_row ) {
						if ($map_row->form_field!=='') {
							$fields[$map_row->odoo_field] = $data[$map_row->form_field];
						}
					}
					$data_fields = array();
					array_push($data_fields, $fields);
					$ret = $rclient->execute_kw($this->database, $this->get_uid(), 
											   $this->password, $form_row->odoo_model, 'create', 
											   $data_fields);
				}
			}
		} catch (Exception $e) {
			error_log($e->getMessage(), 0);
		}		
	}

}
