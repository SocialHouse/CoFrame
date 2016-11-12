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
		is_admin_logged();
		$this->load->model('timeframe_model');
		$this->load->model('admin_account_model');
	}

	function index()
	{
		$this->data['accounts'] = $this->admin_account_model->get_account_holders();
		$this->data['accounts_count'] = $this->admin_account_model->all_account_count();
		// $this->load->view('admin/partials/header');
		// $this->load->view('admin/account/account_list',$this->data);
		// $this->load->view('admin/partials/footer');
		$this->data['view'] = 'admin/account/account_list';
		$this->data['layout'] = 'admin/layouts/layout';
		_render_admin_view($this->data);
	}

	function account_users()
	{
		$parent_id = $this->uri->segment(3);
		if(!empty($parent_id))
		{
			$this->data['account_id'] = $parent_id;
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
		$account_id = $this->uri->segment(6);

		if($status == 0)
		{
			$message = "Unable to ban user";
			$success = 'banned';
			$ban_status = $this->aauth->ban_user($user_id);
		}
		else
		{			
			$message = "Unable to unban user";
			$success = 'unbanned';
			$ban_status = $this->aauth->unban_user($user_id);
		}

		$flash_data = array(
				'message' => $message,
				'class' => 'danger'
			);

		if($ban_status == 1)
		{
			$message = "User has been ".$success;
			$flash_data = array(
				'message' => $message,
				'class' => 'success'
			);			
		}
		$this->session->set_flashdata('message',$flash_data);

		$redirect = 'accounts';
		if(!empty($account_id))
		{
			$redirect = 'accounts/sub-users/'.$account_id;
		}
		redirect(base_url().$redirect);
	}

	function edit_account()
	{
		$redirect_slug = $this->uri->segment(1);
		$user_id = $this->uri->segment(3);
		$account_id = $this->uri->segment(4);
		if(!empty($user_id))
		{
			$this->data['account_id'] = $account_id;

			$this->data['redirect_slug'] = $redirect_slug;
			$this->data['user_details'] = $this->admin_account_model->get_user($user_id);
			$this->load->view('admin/partials/header');
			$this->load->view('admin/account/user_details',$this->data);
			$this->load->view('admin/partials/footer');
		}
	}

	function update_account()
	{
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$account_data = array(
					'first_name'=>$post_data['first_name'],
					'last_name'=>$post_data['last_name'],
					'phone'=>$post_data['phone']
				);
			$status = $this->timeframe_model->update_data('user_info',$account_data,array('aauth_user_id' => $post_data['aauth_user_id']));

			if($post_data['status'] == 1)
			{
				$status = $this->aauth->ban_user($post_data['aauth_user_id']);
			}
			else
			{
				$status = $this->aauth->unban_user($post_data['aauth_user_id']);
			}

			$message = 'Unable update account';
			$class = 'danger';
			if($status)
			{
				$message = 'Account has been updated successfully';
				$class = 'success';
			}
			$this->session->set_flashdata('message',array('message' => $message, 'class' => $class));
			redirect(base_url($post_data['redirect']));
		}
	}

	function statastics()
	{
		$account_id = $this->uri->segment(3);
		if($account_id)
		{
			
		}
	}

}