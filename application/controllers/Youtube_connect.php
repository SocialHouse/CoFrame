<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
class Youtube_connect extends CI_Controller {

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
		
		$this->load->config('youtube');	
		$this->client_id = $this->config->item('youtube_client_id');
		$this->client_secret = $this->config->item('youtube_client_secret');
		$this->redirect_uri = $this->config->item('redirect_uri');
		$this->client = new Google_Client();
		$this->client->setClientId($this->client_id);
		$this->client->setClientSecret($this->client_secret);
		$this->client->setRedirectUri($this->redirect_uri);
		$this->client->setAccessType('offline');
		$this->client->setApprovalPrompt('force');
		$this->client->addScope("https://www.googleapis.com/auth/youtube");

		if($this->session->userdata('brand_id')){
			$this->brand_id = $this->session->userdata('brand_id');
		}
		if($this->session->userdata('outlet_id')){
			$this->outlet_id = $this->session->userdata('outlet_id');
		}
	}

	public function youtube($brand_id='',$outlet_id='')
	{
		if(!empty($brand_id) && !empty($outlet_id))
		{
			$this->session->set_userdata('brand_id',$brand_id);
			$this->session->set_userdata('outlet_id',$outlet_id);
		}

		$is_key_exist = $this->social_media_model->get_token('youtube');
		
		if(!empty($is_key_exist))
		{
			$token = (json_decode($is_key_exist->response,true));
			$this->client->setAccessToken($token);
			$token_info = $this->client->getAccessToken();
			if($this->client->isAccessTokenExpired()){
				$token_info['refresh_token']= $is_key_exist->refresh_token;
				$new_token_info = $this->client->refreshToken($token_info);
				$this->client->setAccessToken($new_token_info);
			}
			$token_data = $this->client->getAccessToken();
			if(!empty($token_data))
			{
				$token_data = json_decode(json_encode($token_data));
				
				$data = array(
					'access_token' => $token_data->access_token,
					'user_id' => $this->user_id,
					'response' => json_encode($token_data),
					'type' => 'youtube'
					);
				if(!empty($token_data->refresh_token))
				{
					$data['refresh_token']= $token_data->refresh_token;
				}
				$response = $this->social_media_model->save_token($data);
			}
			echo str_replace('%type%', 'youtube', $this->lang->line('already_saved'));
			// echo "<script>window.close();</script>";
			// redirect(base_url().'instagram_connect/profile');
		}else{
			$this->reset_session();
			$this->youtube_auth();
		}
	}


	function youtube_auth()
	{	
		$authUrl = $this->client->createAuthUrl();
		$youtube = new Google_Service_YouTube($this->client);
		redirect($authUrl);
	}


	function youtube_callback()
	{
		$this->client->authenticate($_GET['code']);
		$this->session->set_userdata('youtube_token', $this->client->getAccessToken());
		$youtube_access_token = $this->session->userdata('youtube_token');
		if (isset($youtube_access_token)) 
		{
			$this->client->setAccessToken($this->session->userdata('youtube_token'));
		}
		if ($this->client->getAccessToken()) 
		{
			$token_info = $this->client->getAccessToken();

			$token_info = json_decode(json_encode($token_info));
			
			$data = array(
				'access_token' => $token_info->access_token,
				'refresh_token' => $token_info->refresh_token,
				'user_id' => $this->user_id,
				'brand_id' => $this->brand_id,
				'outlet_id' => $this->outlet_id,
				'response' => json_encode($token_info),
				'type' => 'youtube'
				);
			$response = $this->social_media_model->save_token($data);
			echo str_replace('%type%', 'YouTube', $this->lang->line('save_successfully'));
		}
	}


	function reset_session()
	{
		$this->session->unset_userdata('youtube_token');
	}
}