<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');

class Social_media extends CI_Controller {

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
		$this->load->model('user_model');
		$this->load->model('timeframe_model');
		$this->load->config('twitter');
		$this->user_data = $this->session->userdata('user_info');
		$this->user_id = $this->session->userdata('id');
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];

        //for twittr
		$this->load->library('twitteroauth');
  //       if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
		// {
			// If user already logged in
			// $this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('access_token'),  $this->session->userdata('access_token_secret'));
		// }
		// elseif($this->session->userdata('request_token') && $this->session->userdata('request_token_secret'))
		// {
		// 	// If user in process of authentication
		// 	$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('request_token'), $this->session->userdata('request_token_secret'));
		// }
		// else
		// {
		// 	// Unknown user
		// 	$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'));
		// }

		//for linkedin
		$this->load->config('linkedin');       

		//for youtube
		$this->load->config('youtube');	
		$this->client_id = $this->config->item('youtube_client_id');
		$this->client_secret = $this->config->item('youtube_client_secret');
		$this->redirect_uri = $this->config->item('redirect_uri');
		$this->client = new Google_Client();
		$this->client->setClientId($this->client_id);
		$this->client->setClientSecret($this->client_secret);
		$this->client->setRedirectUri($this->redirect_uri);
		$this->client->addScope("https://www.googleapis.com/auth/youtube");


		//for tumblr
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

		//for pinterest
		$this->load->config('pinterest');
	}

	public function index()
	{
		$this->data = array();
		$this->data['view'] = 'social_media/facebook';  
        //addition js files to be added in page 
		$this->data['js_files'] = array(js_url().'facebook.js');
		_render_view($this->data);
	}	

	public function save_fb_data()
	{
		$data = array(
			'access_token' => $this->input->post('authResponse')['accessToken'],
			'social_media_id' => $this->input->post('authResponse')['userID'],
			'user_id' => $this->user_id,
			'response' => json_encode($this->input->post()),
			'type' => 'facebook'
			);

		$condition = array('user_id' =>  $this->user_id,'type' => 'facebook');
		$is_key_exist = $this->timeframe_model->get_data_by_condition('social_media_keys',$condition);
		if(!empty($is_key_exist))
		{
			$condition = array('id' => $is_key_exist[0]->id,'type' => 'facebook');
			$this->timeframe_model->update_data('social_media_keys',$data,$condition);
		}
		else
			$this->timeframe_model->insert_data('social_media_keys',$data);
	}

	public function twitter()
	{
		$condition = array('user_id' => $this->user_id,'type' => 'twitter');
		$is_key_exist = $this->timeframe_model->get_data_by_condition('social_media_keys',$condition);
		
		if(!empty($is_key_exist))
		{
			$this->session->set_userdata('access_token', $is_key_exist[0]->access_token);
			$this->session->set_userdata('access_token_secret', $is_key_exist[0]->access_token_secret);
			$this->session->set_userdata('twitter_user_id', $is_key_exist[0]->social_media_id);
		}

		if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
		{
			echo 'Your twitter access_token has already been saved';
		}
		else
		{
			// Making a request for request_token
			$request_token = $this->connection->getRequestToken(base_url('/social_media/callback'));
			
			$this->session->set_userdata('request_token', $request_token['oauth_token']);
			$this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
			
			if($this->connection->http_code == 200)
			{
				$url = $this->connection->getAuthorizeURL($request_token);
				redirect($url);
			}
			else
			{
				redirect(base_url('social_media/twitter'));
			}
		}
	}

	public function callback()
	{
		if($this->input->get('oauth_token') && $this->session->userdata('request_token') !== $this->input->get('oauth_token'))
		{
			$this->reset_session();
			redirect(base_url('/social_media/twitter'));
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
					'type' => 'twitter'
					);

				$condition = array('user_id' => $this->user_id,'type' => 'twitter');
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

				
				redirect(base_url('/social_media/twitter'));
			}
			else
			{
				// An error occured. Add your notification code here.
				redirect(base_url('/social_media/twitter'));
			}
		}
	}
	
	public function post($in_reply_to='')
	{
		$condition = array('user_id' => $this->user_id,'type' => 'twitter');
		$is_key_exist = $this->timeframe_model->get_data_by_condition('social_media_keys',$condition);
		if(!empty($is_key_exist))
		{
			$this->session->set_userdata('access_token', $is_key_exist[0]->access_token);
			$this->session->set_userdata('access_token_secret', $is_key_exist[0]->access_token_secret);
			$this->session->set_userdata('twitter_user_id', $is_key_exist[0]->social_media_id);
		}
		
		$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('access_token'),  $this->session->userdata('access_token_secret'));

		$message = 'messageasdas';
		if(!$message || mb_strlen($message) > 140 || mb_strlen($message) < 1)
		{
			echo "d";
			die;
			// Restrictions error. Notification here.
			redirect(base_url('/social_media/twitter'));
		}
		else
		{
			if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
			{
				$content = $this->connection->get('account/verify_credentials');
				// echo "<pre>";
				// print_r($content);
				if(isset($content->errors))
				{
					echo "test";
					die;
					// Most probably, authentication problems. Begin authentication process again.
					$this->reset_session();
					redirect(base_url('/social_media/twitter'));
				}
				else
				{
					// $data = array(
					// 	'status' => $message,
					// 	// 'in_reply_to_status_id' => $in_reply_to
					// );
					// $result = $this->connection->post('statuses/update', $data);
					$data = array(
						'media' => upload_path().'1/brands/1/1.png',
						// 'in_reply_to_status_id' => $in_reply_to
						);
					print_r($data);
					$file = file_get_contents(upload_path().'1/brands/1/1.png');
					$base = base64_encode($file);
					$data = array(
						'media' => $base
								// 'in_reply_to_status_id' => $in_reply_to
						);
					$result = $this->connection->post('media/upload', $data);

					echo "<pre>";
					print_r($result);
					echo "</pre>";
					$parameters = [
					'status' => 'Meow Meow Meow',
					'media_ids' => $result->media_id_string
					];
					$result = $this->connection->post('statuses/update', $parameters);
					die;

					if(!isset($result->errors))
					{
						echo "ok";
						die;
						// Everything is OK
						redirect(base_url('/'));
					}
					else
					{
						echo "wrong";
						die;
						// Error, message hasn't been published
						redirect(base_url('/'));
					}
				}
			}
			else
			{
				echo "else";
				die;
				// User is not authenticated.
				redirect(base_url('/social_media/twitter'));
			}
		}
	}
	
	/**
	 * Reset session data
	 * @access	private
	 * @return	void
	 */
	public function reset_session()
	{
		$this->session->unset_userdata('access_token');
		$this->session->unset_userdata('access_token_secret');
		$this->session->unset_userdata('request_token');
		$this->session->unset_userdata('request_token_secret');
		$this->session->unset_userdata('twitter_user_id');
		$this->session->unset_userdata('twitter_screen_name');
	}

	public function linkedin()
	{
		$this->data['appKey'] = $this->config->item('api_key');
		$this->data['appSecret'] = $this->config->item('secret_key');
		$this->data['callbackUrl'] = $this->config->item('callback_url');
		$this->load->library('linkedin', $this->data);
		$this->linkedin->setResponseFormat(LINKEDIN::_RESPONSE_JSON);
		$token = $this->linkedin->retrieveTokenRequest();
		
		$data = array('access_token' => $token['linkedin']['oauth_token'], 'access_token_secret' => $token['linkedin']['oauth_token_secret'], 'user_id' => $this->user_data["user_id"],'response' => json_encode($token),'type' => 'linkedin');
		$this->timeframe_model->insert_data('social_media_keys',$data);		
		$link = "https://api.linkedin.com/uas/oauth/authorize?oauth_token=". $token['linkedin']['oauth_token'];  
		redirect($link);
	}

	function callback_linked_in() 
	{
		$this->data['appKey'] = $this->config->item('api_key');
		$this->data['appSecret'] = $this->config->item('secret_key');
		$this->data['callbackUrl'] = $this->config->item('callback_url');
		$this->load->library('linkedin', $this->data);
		$this->linkedin->setResponseFormat(LINKEDIN::_RESPONSE_JSON);		
		$condition = array('user_id' => $this->user_data['user_id'],'type' => 'linkedin');
		$is_key_exist = $this->timeframe_model->get_data_by_condition('social_media_keys',$condition);

		$oauth_token = $is_key_exist[0]->access_token;
		$oauth_token_secret = $is_key_exist[0]->access_token_secret;
		$oauth_verifier = $this->input->get('oauth_verifier');
		
		$response = $this->linkedin->retrieveTokenAccess($oauth_token, $oauth_token_secret, $oauth_verifier);
		$profile = $this->linkedin->profile('~:(id,first-name,last-name,picture-url)');
	}

	function youtube_auth()
	{	
		$authUrl = $this->client->createAuthUrl();
		$youtube = new Google_Service_YouTube($this->client);
		echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";		
	}

	function youtube()
	{
		
		$youtube_access_token = $this->session->userdata('youtube_access_token');
		
		if(empty($youtube_access_token))
		{
			$this->client->authenticate($_GET['code']);
			$this->session->set_userdata('youtube_access_token', $this->client->getAccessToken());
		}

		//echo '<pre>'; print_r($youtube_access_token);echo '</pre>';die();
		$youtube_access_token = $this->session->userdata('youtube_access_token');
		if (isset($youtube_access_token)) 
		{
			$this->client->setAccessToken($this->session->userdata('youtube_access_token'));
		}
		if ($this->client->getAccessToken()) 
		{
			$token_info = $this->client->getAccessToken();

			$token_info = json_decode(json_encode($token_info));
			
			$data = array(
				'access_token' => $token_info->access_token,
				'user_id' => $this->user_id,
				'response' => json_encode($token_info),
				'type' => 'youtube'
				);
			
			//$this->timeframe_model->insert_data('social_media_keys',$data);
		}
	}

	function instagram()
	{
		$this->load->library('instagram_api');
		redirect($this->instagram_api->instagram_login());
	}

	function insta_callback()
	{
		$this->load->library('instagram_api');
		$auth_response = $this->instagram_api->authorize($_GET['code']);
		if(isset($auth_response->access_token))
		{
			$data = array(
				'access_token' => $auth_response->access_token,			
				'user_id' => $this->user_data['user_id'],
				'response' => json_encode($auth_response),
				'type' => 'instagram'
				);
			$this->timeframe_model->insert_data('social_media_keys',$data);
		}
	}

	public function tumblr()
	{
		$condition = array('user_id' => $this->user_id,'type' => 'tumblr');
		$is_key_exist = $this->timeframe_model->get_data_by_condition('social_media_keys',$condition);
		
		if(!empty($is_key_exist))
		{
			$this->session->set_userdata('tumblr_access_token', $is_key_exist[0]->access_token);
			$this->session->set_userdata('tumblr_access_token_secret', $is_key_exist[0]->access_token_secret);
			$this->session->set_userdata('tumblr_user_id', $is_key_exist[0]->social_media_id);
		}

		if($this->session->userdata('tumblr_access_token') && $this->session->userdata('tumblr_access_token_secret'))
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
			redirect(base_url('/social_media/tumb'));
		}
		else
		{
			$access_token = $this->tumblr_connection->get_access_token($this->input->get('oauth_verifier'));			
			if ($this->tumblr_connection->http_code == 200)
			{
				$this->session->set_userdata('tumblr_access_token', $access_token['oauth_token']);
				$this->session->set_userdata('tumblr_access_token_secret', $access_token['oauth_token_secret']);
				
				$this->session->unset_userdata('tumblr_request_token');
				$this->session->unset_userdata('tumblr_request_token_secret');

				$data = array(
					'access_token' => $access_token['oauth_token'],
					'access_token_secret' => $access_token['oauth_token_secret'],						
					'user_id' => $this->user_data['user_id'],
					'response' => json_encode($access_token),
					'type' => 'tumblr'
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

				
				redirect(base_url('/social_media/tumblr'));
			}
			else
			{
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

	function pinterest()
	{
		$condition = array('user_id' => $this->user_data['user_id'],'type' => 'pinterest');
		$is_key_exist = $this->timeframe_model->get_data_by_condition('social_media_keys',$condition);
		if(empty($is_key_exist))
		{
			$auth_url = "https://api.pinterest.com/oauth/?response_type=code&redirect_uri=".$this->config->item('pinterest_callback_url')."&client_id=".$this->config->item('pinterest_app_id')."&scope=read_public,write_public&state=".uniqid();
			redirect($auth_url);
		}
	}

	function pinterest_callback()
	{
		$get = $this->input->get();

		if(isset($get) AND isset($get['code']))
		{
			$url = "https://api.pinterest.com/v1/oauth/token";
			$post = array(
				"grant_type" => 'authorization_code',
				"client_id" => $this->config->item('pinterest_app_id'),
				"client_secret" => $this->config->item('pinterest_app_secret'),
				"code" => $get['code']
				);
			$response = $this->fetch_access_token($url,"POST",$post);
			if($response)
			{
				$response = json_decode($response);
				$data = array(
					'access_token' => $response->access_token,
					'user_id' => $this->user_data['user_id'],
					'response' => json_encode($response),
					'type' => 'pinterest'
					);

				$condition = array('user_id' => $this->user_data['user_id'],'type' => 'pinterest');
				$is_key_exist = $this->timeframe_model->get_data_by_condition('social_media_keys',$condition);
				if(empty($is_key_exist))
				{
					$this->timeframe_model->insert_data('social_media_keys',$data);
				}
				else
				{
					$this->timeframe_model->update_data('social_media_keys',$data,$condition);
				}
			}
		}
	}

	function fetch_access_token($url, $method, $postfields = NULL) 
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url."?client_id=".$postfields['client_id']."&client_secret=".$postfields['client_secret']."&code=".$postfields['code']."&grant_type=authorization_code",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_SSL_VERIFYPEER => FALSE
			)
		);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if($err)
		{
			return 0;
		} 
		else
		{
			return $response;
		}
	}

	function vine()
	{
		$vine_key = $this->session->userdata('vine_key');
		if($vine_key)
		{
			echo "You are logged in to vine";
			$user_id = explode('-',$vine_key);
			$url = "https://api.vineapp.com/users/profiles/".$user_id[0];
			$response = $this->vine_auth($url,"GET");
			$response = json_decode($response);
			echo "<pre>";
			print_r($response);
			echo "</pre>";
		}
		else
		{
			$post = $this->input->post();
			if(isset($post) AND !empty($post))
			{			
				$url = "https://api.vineapp.com/users/authenticate";
				$url .= "?username=".$post['email']."&password=".$post['password'];
				$response = $this->vine_auth($url,"POST");
				$response = json_decode($response);
				if(!empty($response->error) OR !$response)
				{
					if(!$response)
					{
						$error = "Some error occured please try again";
					}
					else
					{
						$error = $response->error;
					}
					$this->session->set_flashdata('error',$error);
					redirect(base_url('social_media/vine'));
				}
				$this->session->set_userdata('vine_key',$response->data->key);
			}
			else
			{
				$this->data = array();
				$this->data['view'] = 'social_media/vine_login'; 
				_render_view($this->data);
			}
		}
	}

	function vine_auth($url,$method)
	{		
		$curl = curl_init();
		$vine_key = $this->session->userdata('vine_key');
		if(isset($vine_key))
		{
			$header = array(
				"cache-control: no-cache",
				"vine-session-id: ".$vine_key
				);
		}
		else
		{
			$header = array(
				"cache-control: no-cache"					    
				);
		}

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $method,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_HTTPHEADER => $header
			)
		);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if($err)
		{
			return 0;
		} 
		else
		{
			return $response;
		}
	}

	public function my_uplaod_lists()
	{
		// Define an object that will be used to make all API requests.
		$this->youtube();
		$youtube = new Google_Service_YouTube($this->client);
		
		// Check if an auth token exists for the required scopes
		
		// Check to ensure that the access token was successfully acquired.
		if (!$this->session->userdata('access_token')) {
			try {
			    // Call the channels.list method to retrieve information about the
			    // currently authenticated user's channel.
				$channelsResponse = $youtube->channels->listChannels('contentDetails', array(
					'mine' => 'true',
					));
				$htmlBody = '';
				foreach ($channelsResponse['items'] as $channel) {
			      // Extract the unique playlist ID that identifies the list of videos
			      // uploaded to the channel, and then call the playlistItems.list method
			      // to retrieve that list.
					$uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
					$playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
						'playlistId' => $uploadsListId,
						'maxResults' => 50
						));
					$htmlBody .= "<h3>Videos in list $uploadsListId</h3><ul>";
					foreach ($playlistItemsResponse['items'] as $playlistItem) {
						
						$htmlBody .= sprintf('<li>%s (%s)</li>', $playlistItem['snippet']['title'], $playlistItem['snippet']['resourceId']['videoId']);
					}
					$htmlBody .= '</ul>';
				}
			} catch (Google_Service_Exception $e) {
				$htmlBody = sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
			} catch (Google_Exception $e) {
				$htmlBody = sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
			}
			echo $htmlBody;
		}else{
			
		}
	}

	public function upload_video()
	{
		$this->youtube();
		$youtube = new Google_Service_YouTube($this->client);
		echo $this->session->userdata('access_token');
    	// Check to ensure that the access token was successfully acquired.
		if (!$this->session->userdata('access_token')) {
			$htmlBody = '';
			try{
				$videoPath = upload_path().'1/brands/1/posts/57a1dbb6a8710.mp4';
				
				$snippet = new Google_Service_YouTube_VideoSnippet();
				$snippet->setTitle("Test title");
				$snippet->setDescription("Test description");
				$snippet->setTags(array("tag1", "tag2"));
	            // Numeric video category. See
	            // https://developers.google.com/youtube/v3/docs/videoCategories/list
				$snippet->setCategoryId("22");
	            // Set the video's status to "public". Valid statuses are "public",
	            // "private" and "unlisted".
	            // 2016-08-04
				$status = new Google_Service_YouTube_VideoStatus();
				$status->privacyStatus = "private";
				echo date("Y-m-d\TH:i:s.Z\Z", strtotime("3 day"));
				$status->setPublishAt(date("Y-m-d\TH:i:s.z\Z", strtotime("3 day")));
            	// Associate the snippet and status objects with a new video resource.
				$video = new Google_Service_YouTube_Video();
				$video->setSnippet($snippet);
				$video->setStatus($status);
				$chunkSizeBytes = 1 * 1024 * 1024;
				$this->client->setDefer(true);
            	// Create a request for the API's videos.insert method to create and upload the video.
				$insertRequest = $youtube->videos->insert("status,snippet", $video);
            	// Create a MediaFileUpload object for resumable uploads.
				$media = new Google_Http_MediaFileUpload(
					$this->client, $insertRequest, 'video/*', null, true, $chunkSizeBytes
					);
				$media->setFileSize(filesize($videoPath));
            	// Read the media file and upload it chunk by chunk.
				$status = false;
				$handle = fopen($videoPath, "rb");
				while (!$status && !feof($handle)) {
					$chunk = fread($handle, $chunkSizeBytes);
					$status = $media->nextChunk($chunk);
				}
				fclose($handle);
            	// If you want to make other calls after the file upload, set setDefer back to false
				$this->client->setDefer(false);

				$htmlBody .= "<h3>Video Uploaded</h3><ul>";
				$htmlBody .= sprintf('<li>%s (%s)</li>', $status['snippet']['title'], $status['id']);
				$htmlBody .= '</ul>';
			} catch (Google_Service_Exception $e) {
				$errors = json_decode($e->getMessage())->error->errors[0];
				echo '<pre>'; print_r($errors);echo '</pre>';
				//$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
			} catch (Google_Exception $e) {
				$htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
			}
			echo $htmlBody;
		}else{

		}
	}
}
