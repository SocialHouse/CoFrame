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
		$this->load->model('social_media_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];

		$this->load->library('tblr');
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
		// $this->reset_tumblr_session();
		/*
		 * Establish a connection
		 */
		if($this->session->userdata('tumblr_access_token') && $this->session->userdata('tumblr_access_token_secret'))
		{
			// If user already logged in
			$this->tumblr_authenticated = true;
			$this->tumblr_connection = $this->tblr->create($this->tumblr_consumer_key, $this->tumblr_secret_key, $this->session->userdata('tumblr_access_token'),  $this->session->userdata('tumblr_access_token_secret'));
		}
		elseif($this->session->userdata('tumblr_request_token') && $this->session->userdata('tumblr_request_token_secret'))
		{
			// If user in process of authentication
			$this->tumblr_authenticated = 'processing';
			$this->tumblr_connection = $this->tblr->create($this->tumblr_consumer_key, $this->tumblr_secret_key, $this->session->userdata('tumblr_request_token'), $this->session->userdata('tumblr_request_token_secret'));
		}
		else
		{
			// Unknown user
			$this->tumblr_authenticated = false;
			$this->tumblr_connection = $this->tblr->create($this->tumblr_consumer_key, $this->tumblr_secret_key);
		}		
	}

	public function tumblr($brand_id,$outlet_id)
	{
		if(!empty($brand_id)){
			$this->session->set_userdata('brand_id',$brand_id);
		}

		if(!empty($outlet_id)){
			$this->session->set_userdata('outlet_id',$outlet_id);
		}

		$is_key_exist = $this->social_media_model->get_token('tumblr', $brand_id);
		
		if(!empty($is_key_exist))
		{
			$this->session->set_userdata('tumblr_access_token', $is_key_exist->access_token);
			$this->session->set_userdata('tumblr_access_token_secret', $is_key_exist->access_token_secret);
			$this->session->set_userdata('tumblr_user_id', $is_key_exist->social_media_id);
		}

		if(isset($is_key_exist->access_token) && isset($is_key_exist->access_token_secret))
		{
			echo 'Your tumblr access_token has already been saved';
		}
		else
		{
			$request_token = $this->tumblr_connection->getRequestToken($this->config->item('auth_callback'));
			
			$this->session->set_userdata('tumblr_request_token', $request_token['oauth_token']);
			$this->session->set_userdata('tumblr_request_token_secret', $request_token['oauth_token_secret']);
			
			if($this->tumblr_connection->http_code == 200)
			{
				$url = $this->tumblr_connection->getAuthorizeURL($request_token);				
				redirect($url);
			}
			else
			{
				redirect(base_url('tumblr_connect/tumblr'));
			}
		}
	}

	public function tumblr_callback()
	{
		if($this->input->get('oauth_token') && $this->session->userdata('tumblr_request_token') !== $this->input->get('oauth_token'))
		{
			$this->reset_tumblr_session();
			// redirect(base_url('/social_media/tumb'));
		}
		else
		{
			$access_token = $this->tumblr_connection->getAccessToken($this->input->get('oauth_verifier'));			
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
						'outlet_id' => $this->session->userdata('outlet_id'),
					);

				$is_key_exist = $this->social_media_model->get_token('tumblr',$this->session->userdata('brand_id'));

				if(!empty($is_key_exist))
				{
					$condition = array('id' => $is_key_exist->id,'type' => 'tumblr');
					$this->timeframe_model->update_data('social_media_keys',$data,$condition);
				}
				else
				{				
					$this->timeframe_model->insert_data('social_media_keys',$data);
				}
				echo "Access token has been saved successfully";
			}
			else
			{
				$this->reset_tumblr_session();
				// An error occured. Add your notification code here.
				redirect(base_url('/tumblr_connect/tumblr'));
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

	function test()
	{
		$this->reset_tumblr_session();
		$is_key_exist = $this->social_media_model->get_token('tumblr',$this->session->userdata('brand_id'));
        if(!empty($is_key_exist))
        {
            if($is_key_exist->access_token && $is_key_exist->access_token_secret)
            {
            	echo $this->config->item('tumblr_consumer_key')."<br>";
            	echo $this->config->item('tumblr_secret_key')."<br>";
            	echo $is_key_exist->access_token."<br>";
            	echo $is_key_exist->access_token_secret."<br>";
                $this->tumblr_connection = $this->tblr->create($this->config->item('tumblr_consumer_token'), $this->config->item('tumblr_secret_key'), $is_key_exist->access_token,  $is_key_exist->access_token_secret);

                 $arrMessage = array('type' => 'regular', 'title' => 'Testing by ninad ', 'body' => 'Details', 'format' => 'html');

               $user_info = $user_info = $this->tumblr_connection->get('user/info');
                     print_r($user_info);
                    die;            
            }
        }
	}	
}