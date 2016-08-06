<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Linkedin_connect extends CI_Controller {

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
	 * map to /index.php/welcome/<method_name></method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		is_user_logged();
		$this->load->model('user_model');
		$this->load->model('timeframe_model');
		$this->load->model('social_media_model');
		$this->user_data = $this->session->userdata('user_info');
		$this->user_id = $this->session->userdata('id');
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
		//for linkedin
		$this->load->config('linkedin');
		$this->data['appKey'] = $this->config->item('linked_in_api_key');
		$this->data['appSecret'] = $this->config->item('linked_in_secret_key');
		$this->data['callbackUrl'] = $this->config->item('linked_in_callback_url');
		$this->load->library('linkedin', $this->data);
		$this->linkedin->setResponseFormat($this->config->item('response_type'));
	}

	public function login()
	{
		$is_key_exist = $this->social_media_model->get_token('linkedin');
		
		$token = $this->linkedin->retrieveTokenRequest();
		
		$data = array('access_token' => $token['linkedin']['oauth_token'], 'access_token_secret' => $token['linkedin']['oauth_token_secret'], 'user_id' => $this->user_id,'response' => json_encode($token),'type' => 'linkedin');
		$this->social_media_model->save_token($data);
		$link = "https://api.linkedin.com/uas/oauth/authorize?oauth_token=". $token['linkedin']['oauth_token'];  
		redirect($link);
	}

	public function callback() 
	{	
		$is_key_exist = $this->social_media_model->get_token('linkedin');

		$oauth_token = $is_key_exist->access_token;
		$oauth_token_secret = $is_key_exist->access_token_secret;
		$oauth_verifier = $this->input->get('oauth_verifier');
		$response = $this->linkedin->retrieveTokenAccess($oauth_token, $oauth_token_secret, $oauth_verifier);
		$data = array('access_token' => $response['linkedin']['oauth_token'], 'access_token_secret' => $response['linkedin']['oauth_token_secret'], 'user_id' => $this->user_id,'response' => json_encode($response),'type' => 'linkedin');
		$this->social_media_model->save_token($data);
		$profile = $this->linkedin->profile('~:(id,first-name,last-name,picture-url)');
		echo '<pre>'; print_r($profile );echo '</pre>'; 
	}

	public function create_post() 
	{
		$access_token = $this->session->userdata('linkedin_token');
		$this->linkedin->setToken($access_token);
		$content = array();
		$content['comment'] = 'Nullam dictum felis eu pede mollis pretium. Integer tincidunt.';
		$content['title'] = 'Testing';
		$content['submitted-url'] = 'http://timeframe-dev.blueshoon.com/uploads/4/brands/3/posts/579c9e17bf338.jpg';
		$content['submitted-image-url'] = 'http://timeframe-dev.blueshoon.com/uploads/4/brands/3/posts/579c9e17bf338.jpg';
		$content['description'] = 'df gfdg fdg dfg fdgf fdg';
		$private = FALSE;
		$twitter = FALSE;
		$response = $this->linkedin->share('new', $content, $private, $twitter);
		if($response['success'] === TRUE) {
			echo 'sharing content:<br /><br />RESPONSE:<br /><br /><pre>'; print_r($response);echo '</pre>'; 
		}else{
			echo "Error sharing content:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br />";
		}
	}

	public function check_token() 
	{
		$is_token_expired = false;
		$is_key_exist = $this->social_media_model->get_token('linkedin');
		$token = json_decode($is_key_exist->response,true);
		if($token['success']){
			$token_expires_in = floor ($token['linkedin']['oauth_expires_in']/ 86400);
			if($token_expires_in <= 0){
				$is_token_expired = true;
			}
			$this->linkedin->setToken($token['linkedin']);
			$this->session->set_userdata('linkedin_token',$token['linkedin']);
			return true;
		}else{
			$is_token_expired = true;
		}
		if($is_token_expired){
			echo 'Token is expired or rejected ';
			echo '<a href="'.base_url().'linkedin_connect/login"> Please click heare to login</a>';
			exit();
		}
	}
}
?>
