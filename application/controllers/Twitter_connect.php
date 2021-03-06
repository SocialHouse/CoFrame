<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Twitter_connect extends CI_Controller {

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
        is_user_logged();
		$this->load->model('timeframe_model');
		$this->load->model('social_media_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
		
		$this->load->config('twitter');
		$this->load->library('twitteroauth');
        if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
		{
			// If user already logged in
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('access_token'),  $this->session->userdata('access_token_secret'));
		}
		elseif($this->session->userdata('request_token') && $this->session->userdata('request_token_secret'))
		{
			// If user in process of authentication
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('request_token'), $this->session->userdata('request_token_secret'));
		}
		else
		{
			// Unknown user
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'));
		}
	}

	public function twitter($brand_id,$outlet_id)
	{
		$this->reset_session();
		echo $this->session->set_userdata('brand_id',$brand_id);
		echo $this->session->set_userdata('outlet_id',$outlet_id);
		

		$is_key_exist = $this->social_media_model->get_token('twitter', $brand_id);
		
		if(!empty($is_key_exist))
		{
			$this->session->set_userdata('access_token', $is_key_exist->access_token);
			$this->session->set_userdata('access_token_secret', $is_key_exist->access_token_secret);
			$this->session->set_userdata('twitter_user_id', $is_key_exist->social_media_id);
		}

		if(isset($is_key_exist->access_token) && isset($is_key_exist->access_token_secret))
		{
			$this->reset_session();
			$status 	= true;
			$outlet 	= 'twitter';
			$title 		= 'Successful';
			$message 	= str_replace('%type%', 'twitter', $this->lang->line('already_saved'));
			echo social_callbacks($status, $outlet,$title, $message );
		}
		else
		{
			// Making a request for request_token
			$request_token = $this->connection->getRequestToken(base_url('/twitter_connect/callback'));
			
			$this->session->set_userdata('request_token', $request_token['oauth_token']);
			$this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
			
			if($this->connection->http_code == 200)
			{
				$url = $this->connection->getAuthorizeURL($request_token);
				redirect($url);
			}
			else
			{
				redirect(base_url('twitter_connect/twitter'));
			}
		}
	}

	public function callback()
	{
		if($this->input->get('oauth_token') && $this->session->userdata('request_token') !== $this->input->get('oauth_token'))
		{
			$this->reset_session();
			redirect(base_url('/twitter_connect/twitter'));
		}
		else
		{
			$access_token = $this->connection->getAccessToken($this->input->get('oauth_verifier'));
		
			if ($this->connection->http_code == 200)
			{
				$this->session->set_userdata('access_token', $access_token['oauth_token']);
				$this->session->set_userdata('access_token_secret', $access_token['oauth_token_secret']);
				$this->session->set_userdata('twitter_user_id', $access_token['user_id']);
				$this->session->set_userdata('twitter_screen_name', $access_token['screen_name']);
				$this->session->unset_userdata('request_token');
				$this->session->unset_userdata('request_token_secret');

				$data = array(
						'access_token' => $access_token['oauth_token'],
						'access_token_secret' => $access_token['oauth_token_secret'],
						'social_media_id' => $access_token['user_id'],
						'user_id' => $this->user_id,
						'response' => json_encode($access_token),
						'type' => 'twitter',
						'brand_id' => $this->session->userdata('brand_id'),
						'outlet_id' => $this->session->userdata('outlet_id'),
					);

				$is_key_exist = $this->social_media_model->get_token('twitter', $this->session->userdata('brand_id'));

				if(!empty($is_key_exist))
				{
					$condition = array('id' => $is_key_exist->id,'type' => 'twitter');
					$this->timeframe_model->update_data('social_media_keys',$data,$condition);
				}
				else
				{				
					$this->timeframe_model->insert_data('social_media_keys',$data);
				}

				$this->reset_session();

				$status 	= true;
				$outlet 	= 'twitter';
				$title 		= 'Successful';
				$message 	= str_replace('%type%', 'twitter', $this->lang->line('save_successfully'));
				echo social_callbacks($status, $outlet,$title, $message );
				
			}
			else
			{
				$this->reset_session();
				redirect(base_url('/twitter_connect/twitter'));
			}
		}
	}

	public function reset_session()
	{
		$this->session->unset_userdata('access_token');
		$this->session->unset_userdata('access_token_secret');
		$this->session->unset_userdata('request_token');
		$this->session->unset_userdata('request_token_secret');
		$this->session->unset_userdata('twitter_user_id');
		$this->session->unset_userdata('twitter_screen_name');
		$this->session->unset_userdata('brand_id');
		$this->session->unset_userdata('outlet_id');
	}

}