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

	public function youtube($brand_id ,$outlet_id )
	{
		if(!empty($brand_id) && !empty($outlet_id))
		{
			$this->session->set_userdata('brand_id',$brand_id);
			$this->session->set_userdata('outlet_id',$outlet_id);
		}

		$is_key_exist = $this->social_media_model->get_token('youtube', $brand_id);
		
		if(!empty($is_key_exist))
		{
			$token = (json_decode($is_key_exist->response,true));
			if(empty($token['refresh_token'])){
				$token['refresh_token']= $is_key_exist->refresh_token;
			}
			$this->client->setAccessToken($token);
			$token_info = $this->client->getAccessToken();
			
			if($this->client->isAccessTokenExpired()){
				// echo 'Token is Revenued';
				$new_token_info = $this->client->fetchAccessTokenWithRefreshToken();
				// echo '<pre>new token info: '; print_r($new_token_info);echo '</pre>';
				$this->client->setAccessToken($new_token_info);
			}
			$token_data = $this->client->getAccessToken();

			if(!empty($token_data))
			{
				$token_data = json_decode(json_encode($token_data));
				// echo '<pre>'; print_r($token_data);echo '</pre>';
				$data = array(
					'access_token' => $token_data->access_token,
					'user_id' => $this->user_id,
					'brand_id' => $is_key_exist->brand_id,
					'response' => json_encode($token_data),
					'type' => 'youtube'
					);
				if(!empty($token_data->refresh_token))
				{
					$data['refresh_token']= $token_data->refresh_token;
				}
				$response = $this->social_media_model->save_token($data);

			// 	$youtube = new Google_Service_YouTube($this->client);
			// 	$channelsResponse = $youtube->channels->listChannels('snippet', array(
			// 			'mine' => 'true',
			// 			));
			// 	$htmlBody = '';
			// 	if(!empty($channelsResponse) AND isset($channelsResponse['items']) AND !empty($channelsResponse['items']))
			// 	{
			// 		// echo "tewst".$channel['contentDetails']['relatedPlaylists']['uploads'];
			// 		echo "<div style='margin-left:25%'>";
			// 		echo "<form method='post' action='".base_url()."youtube_connect/save_channel'>";
			// 		// echo "<input type='hidden' name='social_media_id' value='".$last_id."'>";
			// 		echo "<input type='hidden' name='access_token' value='".$token_data->access_token."'>";
			// 		if(isset($token_data->refresh_token) AND !empty($token_data->refresh_token))
			// 		{
			// 			echo "<input type='hidden' name='refresh_token' value='".$token_data->refresh_token."'>";
			// 		}

			// 		echo "<input type='hidden' name='response' value='".json_encode($token_info)."'>";
					

			// 		echo "<h3>Please select channel on which you want to upload your posts<h3><br>";
			// 		echo "<select name='channel'>";				
			// 		foreach ($channelsResponse['items'] as $channel) 
			// 		{
			// 			echo "<option value='".$channel['id']."'>".$channel['snippet']['title']."</option>";
			// 		}
			// 		echo '</select><br/><br/>';
			// 		echo "<input type='submit' value='save'>";
					
					
			// 		echo "</form></div>";
			// 	}
			// 	else
			// 	{
			// 		$this->lang->line('no_channel');
			// 	}
			}
			
			$status 	= true;
			$outlet 	= 'youtube';
			$title 		= 'Successful';
			$message 	= str_replace('%type%', 'youtube', $this->lang->line('already_saved'));
			echo social_callbacks($status, $outlet,$title, $message );

			

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
			
			$status 	= true;
			$outlet 	= 'youtube';
			$title 		= 'Successful';
			$message 	= str_replace('%type%', 'YouTube', $this->lang->line('save_successfully'));

			// $youtube = new Google_Service_YouTube($this->client);
			// $channelsResponse = $youtube->channels->listChannels('snippet', array(
			// 		'mine' => 'true',
			// 		));
			// $htmlBody = '';
			// if(!empty($channelsResponse) AND isset($channelsResponse['items']) AND !empty($channelsResponse['items']))
			// {
			// 	// echo "tewst".$channel['contentDetails']['relatedPlaylists']['uploads'];
			// 	echo "<div style='margin-left:25%'>";
			// 	echo "<form method='post' action='".base_url()."youtube_connect/save_channel'>";
			// 	// echo "<input type='hidden' name='social_media_id' value='".$last_id."'>";
			// 	echo "<input type='hidden' name='access_token' value='".$token_info->access_token."'>";
			// 	echo "<input type='hidden' name='refresh_token' value='".$token_info->refresh_token."'>";

			// 	echo "<input type='hidden' name='response' value='".json_encode($token_info)."'>";
				

			// 	echo "<h3>Please select channel on which you want to upload your posts<h3><br>";
			// 	echo "<select name='channel'>";				
			// 	foreach ($channelsResponse['items'] as $channel) 
			// 	{
			// 		echo "<option value='".$channel['id']."'>".$channel['snippet']['title']."</option>";
			// 	}
			// 	echo '</select><br/><br/>';
			// 	echo "<input type='submit' value='save'>";
				
				
			// 	echo "</form></div>";
			// }
			// else
			// {
			// 	$this->lang->line('no_channel');
			// }
			echo social_callbacks($status, $outlet,$title, $message );
		}
	}

	// function save_channel()
	// {
	// 	$post_data = $this->input->post();
	// 	if(isset($post_data) AND !empty($post_data))
	// 	{
	// 		$data = array(
	// 				'access_token' => $post_data['access_token'],					
	// 				'user_id' => $this->user_id,
	// 				'brand_id' => $this->session->userdata('brand_id'),
	// 				'outlet_id' => $this->session->userdata('outlet_id'),
	// 				'response' => $post_data['response'],
	// 				'type' => 'youtube',
	// 				'youtube_channel_id' => $post_data['channel']
	// 			);

	// 		if(isset($post_data['refresh_token']))
	// 		{
	// 			$data['refresh_token'] = $post_data['refresh_token'];
	// 		}

	// 		$last_id = $this->social_media_model->save_token($data);
	// 		$status 	= true;
	// 		$outlet 	= 'youtube';
	// 		$title 		= 'Successful';
	// 		$message 	= str_replace('%type%', 'youtube', $this->lang->line('save_successfully'));
	// 		echo social_callbacks($status, $outlet,$title, $message );
	// 	}
	// }

	public function my_uplaod_lists()
	{
		// Define an object that will be used to make all API requests.
		//$this->youtube();
		$is_key_exist = $this->social_media_model->get_token('youtube', $this->brand_id);
		
		if($my_tokens)
		{
			$token = (json_decode($my_tokens->response,true));
			if(empty($token['refresh_token'])){
				$token['refresh_token']= $my_tokens->refresh_token;				
			}
			$this->client->setAccessToken($token);
			$token_info = $this->client->getAccessToken();
			$this->session->set_userdata('youtube_token',$token_info );

		}else{
			$this->session->unset_userdata('youtube_token');
			$this->youtube_auth();
		}
		
		$youtube = new Google_Service_YouTube($this->client);
		
		// Check if an auth token exists for the required scopes
		
		// Check to ensure that the access token was successfully acquired.
		if ($this->session->userdata('youtube_token')) {
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



	function reset_session()
	{
		$this->session->unset_userdata('youtube_token');
	}
}