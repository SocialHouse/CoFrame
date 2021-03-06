<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tumblr_connect extends CI_Controller {

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
		$this->load->model('timeframe_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');

		$this->load->library('tumblr');
        $this->config->load('tumblr');
		if(!isset($this->tumblr_consumer_key)) {
			$this->tumblr_consumer_key = $this->config->item('tumblr_consumer_key');
		}
		
		if(!isset($this->tumblr_secret_key)) {
			$this->tumblr_secret_key = $this->config->item('tumblr_secret_key');
		}
		
		if(!isset($this->tumblr_url)) {
			$this->tumblr_url = $this->config->item('tumblr_url');
		}
		
		if(!isset($this->callback_url)) {
			$this->callback_url = $this->config->item('callback_url');
		}
		
		if(!isset($this->auth_callback)) {
			$this->auth_callback = $this->config->item('auth_callback');
		}
		
		/*
		 * Establish a connection
		 */
		if($this->session->userdata('tumblr_access_token') && $this->session->userdata('tumblr_access_token_secret'))
		{
			// If user already logged in
			$this->tumblr_authenticated = true;
			$this->tumblr_connection = $this->tumblr->create($this->tumblr_consumer_key, $this->tumblr_secret_key, $this->session->userdata('tumblr_access_token'),  $this->session->userdata('tumblr_access_token_secret'));
		}
		elseif($this->session->userdata('tumblr_request_token') && $this->session->userdata('tumblr_request_token_secret'))
		{
			// If user in process of authentication
			$this->tumblr_authenticated = 'processing';
			$this->tumblr_connection = $this->tumblr->create($this->tumblr_consumer_key, $this->tumblr_secret_key, $this->session->userdata('tumblr_request_token'), $this->session->userdata('tumblr_request_token_secret'));
		}
		else
		{
			// Unknown user
			$this->tumblr_authenticated = false;
			$this->tumblr_connection = $this->tumblr->create($this->tumblr_consumer_key, $this->tumblr_secret_key);
		}
	}

	public function tumblr($brand_id='',$outlet_id='')
	{
		$this->session->set_userdata('brand_id',$brand_id);
		$this->session->set_userdata('outlet_id',$outlet_id);
		$condition = array('user_id' => $this->user_id,'type' => 'tumblr');
		$is_key_exist = $this->timeframe_model->get_data_by_condition('social_media_keys',$condition);
		
		if(!empty($is_key_exist))
		{
			$this->session->set_userdata('tumblr_access_token', $is_key_exist[0]->access_token);
			$this->session->set_userdata('tumblr_access_token_secret', $is_key_exist[0]->access_token_secret);
			$this->session->set_userdata('tumblr_user_id', $is_key_exist[0]->social_media_id);
		}

		if(isset($is_key_exist[0]->access_token) && isset($is_key_exist[0]->access_token_secret))
		{
			echo 'Your tumblr access_token has already been saved';
		}
		else
		{
			$request_token = $this->tumblr_connection->get_request_token($this->config->item('auth_callback'));
			
			$this->session->set_userdata('tumblr_request_token', $request_token['oauth_token']);
			$this->session->set_userdata('tumblr_request_token_secret', $request_token['oauth_token_secret']);
			
			if($this->tumblr_connection->http_code == 200)
			{
				$url = $this->tumblr_connection->get_authorize_url($request_token);				
				redirect($url);
			}
			else
			{
				redirect(base_url('social_media/tumblr'));
			}
		}
	}

	public function tumblr_callback()
	{
		if($this->input->get('oauth_token') && $this->session->userdata('tumblr_request_token') !== $this->input->get('oauth_token'))
		{
			$this->reset_tumblr_session();
			echo "Some error occured please try again";
		}
		else
		{
			$access_token = $this->tumblr_connection->get_access_token($this->input->get('oauth_verifier'));
			print_r($access_token);
			if ($this->tumblr_connection->http_code == 200)
			{
				$this->session->set_userdata('tumblr_access_token', $access_token['oauth_token']);
				$this->session->set_userdata('tumblr_access_token_secret', $access_token['oauth_token_secret']);
				
				$this->session->unset_userdata('tumblr_request_token');
				$this->session->unset_userdata('tumblr_request_token_secret');

				$data = array(
						'access_token' => $access_token['oauth_token'],
						'access_token_secret' => $access_token['oauth_token_secret'],						
						'user_id' => $this->user_id,
						'response' => json_encode($access_token),
						'type' => 'tumblr',
						'brand_id' => $this->session->userdata('brand_id'),
						'outlet_id' => $this->session->userdata('outlet_id')
					);

				$condition = array('user_id' => $this->user_id,'type' => 'tumblr');
				$is_key_exist = $this->timeframe_model->get_data_by_condition('social_media_keys',$condition);

				if(!empty($is_key_exist))
				{
					$condition = array('id' => $is_key_exist[0]->id,'type' => 'twitter');
					$this->timeframe_model->update_data('social_media_keys',$data,$condition);
				}
				else
				{				
					$this->timeframe_model->insert_data('social_media_keys',$data);
				}

				$this->reset_tumblr_session();
				$this->load->view('social_media/twitter_success');
			}
			else
			{
				$this->reset_tumblr_session();
				// An error occured. Add your notification code here.
				redirect(base_url('/social_media/tumblr'));
			}
		}
	}

	function reset_tumblr_session()
	{
		$this->session->unset_userdata('tumblr_access_token');
		$this->session->unset_userdata('tumblr_access_token_secret');
		$this->session->unset_userdata('tumblr_request_token');
		$this->session->unset_userdata('tumblr_request_token_secret');
	}

	function blog_post($post_data = array())
	{
		if($this->session->userdata('tumblr_access_token') && $this->session->userdata('tumblr_access_token_secret'))
		{
			$result = $this->tumblr_connection->post('blog/' . $this->tumblr_url . '/post', $post_data);
			print_r($result);
		}
		else
		{
			// User is not authenticated.
			$this->handle_auth();
		}
	}

	function post()
	{
	 // $arrMessage = ['data' => file_get_contents(upload_path().'1/users/109.png')];
	 
	 $arrMessage = array('type'=>'text', 'body'=>'This is a test post');
		if($this->session->userdata('tumblr_access_token') && $this->session->userdata('tumblr_access_token_secret'))
		{
			$blog_info = $this->tumblr_connection->post('blog/' .$this->config->item('tumblr_url') . '/post', $arrMessage);
			echo "<pre>";
		print_r($blog_info);
			// echo "<pre>";
			// $result = $this->tumblr_connection->posts($this->config->item('tumblr_url'));
			// print_r($result);			
		die;
		}
		

		// $blog_info = $this->tumblr_connection->blog_post($arrMessage);
		
		
		$blogname = "blog/ninadtechfive";
		//API Call For Getting User Information
		 $arrParam = array(  
            'offset' => 1,
            'limit' => 10,
            'api_key' => $this->tumblr_consumer_key // App_key
            );

 		$strBlogUrl = "blog/YOUR BLOG URL/post";
		// $arrProfileUpdates = $this->tumblr_connection->get('blog/ninadtechfive/post',$arrParam);
		// $objArrUserInfo = $this->tumblr_connection->get('user/info');
		$arrProfileUpdates = $this->tumblr_connection->get('user/info');
		echo "<pre>";
		print_r($arrProfileUpdates);
		die;
		
		// oauth_gen("POST", "http://api.tumblr.com/v2/blog/$blogname/post", $params, $headers);
	}


	
}