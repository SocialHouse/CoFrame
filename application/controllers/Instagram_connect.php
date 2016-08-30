<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instagram_connect extends CI_Controller {

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
		// is_user_logged();
		$this->load->model('user_model');
		$this->load->model('timeframe_model');
		$this->load->model('social_media_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
		$this->load->library('instagram_api');
		if($this->session->userdata('brand_id')){
			$this->brand_id = $this->session->userdata('brand_id');
		}
		if($this->session->userdata('outlet_id')){
			$this->outlet_id = $this->session->userdata('outlet_id');
		}

		if($this->session->userdata('instagram_access_token'))
		{
			// If user already logged in
			$this->instagram_api->access_token = $this->session->userdata('instagram_access_token');
		}
		if($this->session->userdata('instagram_user_id')){
			$this->client_id = $this->session->userdata('instagram_user_id');
		}
		
	}

	public function instagram($brand_id='',$outlet_id='')
	{
		$this->session->set_userdata('brand_id',$brand_id);
		$this->session->set_userdata('outlet_id',$outlet_id);
		$is_key_exist = $this->social_media_model->get_token('instagram', $brand_id);
		
		if(!empty($is_key_exist))
		{
			$token = (json_decode($is_key_exist->response,true));
			$this->session->set_userdata('instagram_access_token', $token['access_token']);
			$this->session->set_userdata('instagram_username', $token['user']['username']);
			$this->session->set_userdata('instagram_user_id', $token['user']['id']);
			$this->instagram_api->access_token = $token['access_token'];
			echo str_replace('%type%', 'instagram', $this->lang->line('already_saved'));
			// echo "<script>window.close();</script>";
			// redirect(base_url().'instagram_connect/profile');
		}else{
			$this->reset_session();
			redirect($this->instagram_api->instagram_login());
		}
	}


	function insta_callback()
	{
		$auth_response = $this->instagram_api->authorize($_GET['code']);

		if(isset($auth_response->access_token))
		{
			$data = array(
				'access_token' => $auth_response->access_token,
				'user_id' => $this->user_id,
				'brand_id' => $this->brand_id,
				'outlet_id' => $this->outlet_id,
				'response' => json_encode($auth_response),
				'type' => 'instagram'
				);
			$response = $this->social_media_model->save_token($data);
			if($response){
				$this->session->set_userdata('instagram_access_token', $auth_response->access_token);
				$this->session->set_userdata('instagram_username', $auth_response->user->username);
				$this->session->set_userdata('instagram_user_id', $auth_response->user->id);
				echo str_replace('%type%', 'instagram', $this->lang->line('save_successfully'));
				// echo "<script>window.close();</script>";
				//redirect(base_url().'instagram_connect/profile');
			}else{
				echo $auth_response->error_message;
			}
		}
	}

	public function profile()
	{
		if(empty($this->client_id)){
			$this->client_id = $this->session->userdata('instagram_user_id');
		}
		// Get the user data
		$user_data = $this->instagram_api->get_user($this->client_id);
	}

	function reset_session()
	{
		$this->session->unset_userdata('instagram_access_token');
		$this->session->unset_userdata('instagram_username');
		$this->session->unset_userdata('instagram_user_id');
	}
}