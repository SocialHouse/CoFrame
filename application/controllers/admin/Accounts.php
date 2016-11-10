<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

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
		$this->load->model('admin_account_model');
	}

	function index()
	{
		$this->data['accounts'] = $this->admin_account_model->get_account_holders();
		$this->data['accounts_count'] = $this->admin_account_model->all_account_count();
		$this->load->view('admin/partials/header');
		$this->load->view('admin/account/account_list',$this->data);
		$this->load->view('admin/partials/footer');
	}

	function account_users()
	{
		$parent_id = $this->uri->segment(3);
		if(!empty($parent_id))
		{		
			$this->data['sub_users'] = $this->admin_account_model->get_account_users($parent_id);
			$this->load->view('admin/partials/header');
			$this->load->view('admin/account/sub_users',$this->data);
			$this->load->view('admin/partials/footer');
		}
	}

	public function get_account_brands()
	{
		$parent_id = $this->uri->segment(3);
		if(!empty($parent_id))
		{
			$this->data['brands'] = $this->admin_account_model->get_account_brands($parent_id);
			$this->load->view('admin/partials/header');
			$this->load->view('admin/account/brands',$this->data);
			$this->load->view('admin/partials/footer');
		}
	}

	function change_status()
	{
		$user_id = $this->uri->segment(4);
		$status = $this->uri->segment(5);	

		if($status == 0)
		{
			$message = "Unable to ban user";
			$success = 'banned';
			$status = $this->aauth->ban_user($user_id);
		}
		else
		{			
			$message = "Unable to unban user";
			$success = 'unbanned';
			$status = $this->aauth->unban_user($user_id);
		}

		$flash_data = array(
				'message' => $message,
				'class' => 'danger'
			);

		if($status)
		{
			$massage = "User has been ".$success;
			$flash_data = array(
				'message' => $message,
				'class' => 'success'
			);
			
		}
		$this->session->set_flashdata('message');
		redirect(base_url().'accounts');
	}

	function edit_account()
	{
		$user_id = $this->uri->segment(3);
		if(!empty($user_id))
		{
			$this->data['user_details'] = $this->admin_account_model->get_user($user_id);
			$this->load->view('admin/partials/header');
			$this->load->view('admin/account/user_details',$this->data);
			$this->load->view('admin/partials/footer');
		}
	}

}