<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'third_party/facebook-php-sdk/src/Facebook/autoload.php');

use Facebook\FacebookRequest;

class Facebook_connect extends CI_Controller {

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
		$this->load->library('facebook');

		if($this->session->userdata('brand_id')){
			$this->brand_id = $this->session->userdata('brand_id');
		}
		if($this->session->userdata('outlet_id')){
			$this->outlet_id = $this->session->userdata('outlet_id');
		}

	}

	public function fb($brand_id,$outlet_id)
	{
		if(!empty($brand_id)){
			$this->session->set_userdata('brand_id',$brand_id);
		}

		if(!empty($outlet_id)){
			$this->session->set_userdata('outlet_id',$outlet_id);
		}
		if (!$this->facebook->is_authenticated())
		{
			redirect($this->facebook->login_url());
		}else{
			$this->me();
		}
	}

	public function me()
	{
		$data['user'] = array();
		// Check if user is logged in
		if ($this->facebook->is_authenticated())
		{
			// User logged in, get user details
			$user = $this->facebook->request('get', '/me?fields=id,name,email');
			echo $user['id'];
			if (!isset($user['error']))
			{
				$data['user'] = $user;
			}
			echo '<pre>'; print_r($data);echo '</pre>';
		}
	}

	public function upload()
	{
		$img_path = "http://timeframe-dev.blueshoon.com/uploads/18/brands/9/posts/57bed9b786fa1.jpg";
		
		$responses = $this->facebook->user_upload_request($img_path, ['message' => 'This is a test upload','no_story'=>1]);

		// $params = array (
		// 			array(
		// 			    'message' => 'M1',
		// 			    'source' => 'https://s-media-cache-ak0.pinimg.com/564x/ae/2d/b2/ae2db2286ead909b2417cf04f1ca4b32.jpg'
		// 			),
		// 			array(
		// 			    'message' => 'M2',
		// 			    'source' => 'http://timeframe-dev.blueshoon.com/uploads/18/brands/9/posts/57bed9b786fa1.jpg'
		// 			)
		// 			,
		// 			array(
		// 			    'message' => 'M3',
		// 			    'source' => 'https://img1.etsystatic.com/035/0/7305913/il_340x270.641782141_s2yw.jpg'
		// 			)
		// 		);
		// foreach ($params as $key => $obj) {
		// 	$this->facebook->add_to_batch_pool('upload', 'POST', '/me/photos',$obj);
		// }
		// $responses = $this->facebook->send_batch_pool();
		echo json_encode($responses);
	
	}

	public function login()
	{
		// redirect('url', 'location_or_refresh', response_code)
		if ($this->facebook->is_authenticated())
		{
			$user = $this->facebook->request('get', '/me?fields=id,name,email');
			
			$token = array(
					'userID'=>$user['id'],
					'accessToken'=>$this->session->userdata('fb_access_token'),
					'expiresIn'=>$this->session->userdata('fb_expire')
				);
			$data = array(
					'access_token' => $token['accessToken'],
					'user_id' => $this->user_id,
					'brand_id' => $this->brand_id,
					'outlet_id' => $this->outlet_id,
					'response' => json_encode($token),
					'type' => 'facebook'
				);
				$this->social_media_model->save_token($data);			
		}
		redirect(base_url().'facebook_connect/me','refresh',200);
	}

	public function logout()
	{
		if ($this->facebook->is_authenticated())
		{
			redirect($this->facebook->logout_url());
		}
	}
	

	function reset_session()
	{
		$this->facebook->destroy_session();
	}
}