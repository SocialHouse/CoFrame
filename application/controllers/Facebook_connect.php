<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// use Facebook\FacebookRequest;

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
		$this->fb = $this->facebook->object();

		if($this->session->userdata('brand_id')){
			$this->brand_id = $this->session->userdata('brand_id');
		}
		if($this->session->userdata('outlet_id')){
			$this->outlet_id = $this->session->userdata('outlet_id');
		}

	}

	public function facebook($brand_id,$outlet_id)
	{
		if(!empty($brand_id)){
			$this->session->set_userdata('brand_id',$brand_id);
		}

		if(!empty($outlet_id)){
			$this->session->set_userdata('outlet_id',$outlet_id);
		}
		
		$is_key_exist = $this->social_media_model->get_token('facebook',$brand_id);
		
        if(!empty($is_key_exist))
        {
            $access_token = $is_key_exist->access_token;
            $this->session->set_userdata('fb_access_token',$access_token);
        }else{
        	$this->facebook->destroy_session();
        }

		if (!$this->facebook->is_authenticated())
		{
			redirect($this->facebook->login_url());
		}else{
			redirect(base_url().'facebook_connect/login');
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

	public function pages()
	{
		$data['user'] = array();
		// Check if user is logged in
		if ($this->facebook->is_authenticated())
		{
			// User logged in, get user details
			$user = $this->facebook->request('get', '/me?fields=accounts');
			if (!isset($user['error']))
			{
				echo "<select id='select'>";
				foreach ($user['accounts']['data'] as $key => $pages) 
				{
					echo "<option value='".$pages ['id']."'>".$pages['name']."</option>";
				}
				echo '</select>';
			}
			?>
			<script type='text/javascript'>			
				$('#select').on('change',function(){
					alert('test');
				});
			</script>
			<?php

		}
	}

	public function upload_images($page_id = "", $images = "", $token = "")
	{
		$user_info = $this->facebook->request('get', '/me?fields=accounts');
		$page_token = $page_name = $page_id = '';
		if (!isset($user_info['error']))
		{
			foreach ($user_info['accounts']['data'] as $key => $pages) {
				if( $pages['id'] == '318999534866425')
				{
					$page_token = $pages['access_token'];
					$page_name = $pages['name'];
					$page_id = $pages['id'];
				}
				// echo '<pre>'; print_r($pages);echo '</pre>';
			}
		}
		if(empty($page_token))
		{
			$page_id = 'me';
			$page_token = '';
		}
		// echo $page_token;
		// die();
		$images = array(
				'0' => 'https://scontent-hkg3-1.xx.fbcdn.net/v/t1.0-9/72823_353978524701859_1004954157_n.jpg?oh=ea72175a35c3c763eedd9077640d5289&oe=5852BC34',
				'1' => 'http://timeframe-dev.blueshoon.com/uploads/18/brands/9/posts/57bed9b786fa1.jpg',
				'2' => 'https://fbcdn-sphotos-a-a.akamaihd.net/hphotos-ak-xfa1/v/t1.0-9/26002_318999581533087_1706257821_n.jpg?oh=f0b68e416b614a495a22b36ce8498ca3&oe=585A3737&__gda__=1480353161_38809f7b2f5e8842cadf33b34d4b5bc8'
			);
		if(count($images) > 1){
			// Creating new photo album
			$album_id = $this->create_album('Nikhil','this is album',$page_id, $page_token );
			$response = $this->add_imgs_to_album($album_id, $images, $page_token);
		}
	}

	public function upload_video($page_id = "",$video="", $token ="")
	{
		$user_info = $this->facebook->request('get', '/me?fields=accounts');
		$page_token = $page_name = $page_id = '';
		if (!isset($user_info['error']))
		{
			foreach ($user_info['accounts']['data'] as $key => $pages) {
				if( $pages['id'] =='318999534866425')
				{
					$page_token = $pages['access_token'];
					$page_name = $pages['name'];
					$page_id = $pages['id'];
				}
				// echo '<pre>'; print_r($pages);echo '</pre>';
			}
		}
		if(empty($page_token)){
			$page_id = 'me';
			$page_token = '';
		}
		// echo $page_token;
		// die();
		$video_path = array(
				'0' => 'http://timeframe-dev.blueshoon.com/uploads/18/brands/9/posts/57c407f699a8d.mp4'				
			);
		$parms = array(
                'message'	=> 'sample video',
                'picture'	=> $video_path[0] ,
                'source '	=> $this->fb->videoToUpload($video_path[0] )
            );
		$video_response = $this->facebook->request('POST',$page_id."/videos",$parms,$page_token);
		echo json_encode($video_response);
		
	}

	public function create_album( $name,$msg,$page_id,$page_token)
	{
		$privacy = array(
				'value' => 'EVERYONE' //EVERYONE, ALL_FRIENDS, NETWORKS_FRIENDS, FRIENDS_OF_FRIENDS, CUSTOM .
            );

		$album_details = array(
					'name'		=> $name,
			        'message'	=> $msg,
			        'privacy'	=> $privacy,
			        'published'	=> 'true'
			);

		$album_response = $this->facebook->request('POST', $page_id.'/albums', $album_details,$page_token);
		if (!isset($album_response['error']))
		{
			echo '<br/>album created<br/>'.json_encode($album_response);
			return $album_response['id'];
		}
		return FALSE;
	}

	public function add_imgs_to_album( $album_id, $images, $token)
	{
		$error = TRUE;
		foreach ($images as $key => $img_path) {
			$parms = array('message' => 'Photo Caption');
			$parms['url'] =  $img_path;
			$data = $this->facebook->request('POST','/'. $album_id .'/photos',$parms, $token);
			echo '<br/>'.json_encode($data);
			// echo '<pre>'; print_r($parms);echo '</pre>';
			if (isset($data['error'])){
				$is_error = FALSE;
			}
		}
		return $error;
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

			$user = $this->facebook->request('get', '/me?fields=accounts');
			if (!isset($user['error']))
			{
				echo "<div style='margin-left:25%'>";
				echo "<form method='post' action='".base_url()."facebook_connect/save_page_id'>";
				// echo "<input type='hidden' name='social_media_id' value='".$last_id."'>";
				echo "<input type='hidden' name='access_token' value='".$token['accessToken']."'>";
				echo "<input type='hidden' name='response' value='".json_encode($token)."'>";
				

				echo "<h3>Please select page on which you want to upload your posts<h3><br>";
				if(!empty($user['accounts']['data']))
				{
					echo "<select name='page'>";				
					foreach ($user['accounts']['data'] as $key => $pages) 
					{
						if($pages['perms'][0] == 'ADMINISTER')
							echo "<option value='".$pages ['id']."'>".$pages['name']."</option>";
					}
					echo '</select><br/><br/>';
					echo "<input type='submit' value='save'>";
				}
				else
				{
					echo $this->lang->line('no_fb_page');
				}
				echo "</form></div>";
			}			
		}
		// redirect(base_url().'facebook_connect/me','refresh',200);
	}

	function save_page_id()
	{
		$post_data = $this->input->post();
		if(isset($post_data) AND !empty($post_data))
		{
			$data = array(
					'access_token' => $post_data['access_token'],
					'user_id' => $this->user_id,
					'brand_id' => $this->brand_id,
					'outlet_id' => $this->outlet_id,
					'response' => $post_data['response'],
					'type' => 'facebook',
					'fb_page_id' => $post_data['page']
				);

			$last_id = $this->social_media_model->save_token($data);
			$status 	= true;
			$outlet 	= 'facebook';
			$title 		= 'Successful';
			$message 	= str_replace('%type%', 'facebook', $this->lang->line('save_successfully'));
			echo social_callbacks($status, $outlet,$title, $message );
		}
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