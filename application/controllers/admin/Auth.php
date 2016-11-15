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
		$admin_user_id = $this->session->userdata('admin_user_id');
		if(!empty($admin_user_id))
			redirect(base_url()."admin/accounts");
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

			$remember_me = isset($post_data['remember_me_admin']) ? $post_data['remember_me_admin'] : '';
            if(isset($remember_me) AND !empty($remember_me))
            {
                $cookie = array(
                    'name'   => 'admin_pass',
                    'value'  =>  $post_data['password'],
                    'expire' => '0'
                );
                $this->input->set_cookie($cookie);

                $cookie = array(
                    'name'   => 'admin_name',
                    'value'  => $post_data['user_name'],
                    'expire' => '0'
                );
                $this->input->set_cookie($cookie);
            }
            else
            {
                $this->load->helper('cookie');
                //if not check then check already set in cookie or not & delete as per
                $user_pass=$this->input->cookie('admin_pass', TRUE);
                if(isset($user_pass) && !empty($user_pass))
                {
                    delete_cookie("admin_pass");
                }

                $user_name=$this->input->cookie('admin_name', TRUE);
                if(isset($user_name) && !empty($user_name))
                {
                    delete_cookie("admin_name");
                }
            }

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

	function change_password()
	{
		is_admin_logged();
		$this->data['view'] = 'admin/auth/change_password';
		$this->data['layout'] = 'admin/layouts/layout';
		_render_admin_view($this->data);
	}

	function update_password()
	{
		is_admin_logged();
		$post_data = $this->input->post();
		$user_id = $this->session->userdata('admin_user_id');
		$message = 'Unable to change password';
		$this->load->model('admin_account_model');
		$user = $this->admin_account_model->get_admin_user($user_id);
		$message = 'Unable to change password';
		if($user->password == md5($post_data['old_password']))
		{
			$data['password'] = $post_data['password'];
			$data['id'] = $user_id;
			$response = $this->admin_account_model->save_password($data);
			if($response)
			{
				$message = 'Password changed sucessfully';
			}
		}
		$this->session->set_flashdata('message',array('message' => $message,'class' => 'success'));
		redirect(base_url().'admin/accounts');
	}

	function check_old_password()
	{
		$post_data = $this->input->post();
		$data = $this->timeframe_model->get_data_by_condition('admin_users',array('password' => md5($post_data['old_password'])));
		if(!empty($data))
		{
			 echo "true";
		}
		else
		{
			echo "false";
		}

	}

}