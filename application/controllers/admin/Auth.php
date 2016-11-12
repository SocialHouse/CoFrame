<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('timeframe_model');
		$this->load->model('admin_auth_model');
	}

	function index()
	{
		$this->load->view('admin/auth/login');
	}

	function check_login()
	{
		$post_data = $this->input->post();
		$user = $this->admin_auth_model->check_login($post_data);
		if($user){
			$new_session_data = array(
				'admin_user_id' 	=> $user->id,
				'admin_username' => $user->username,
				'admin_logged_in' => TRUE,
				'user_type'	=>'admin'
			);
			$this->session->set_userdata($new_session_data);
			$path = "admin/accounts";
 		}
		else{
			$flash_data = array(
				'message' => 'User not found. Please try again.',
				'class' => 'danger'
			);
			$this->session->set_flashdata('message',$flash_data);
			$path = "admin";
		}
		redirect(base_url().$path);
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'admin');
	}

}