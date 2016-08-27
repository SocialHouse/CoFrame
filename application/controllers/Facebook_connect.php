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
		// $img_path = "http://timeframe-dev.blueshoon.com/uploads/18/brands/9/posts/57bed9b786fa1.jpg";
		
		// $responses = $this->facebook->user_upload_request($img_path, ['message' => 'This is a test upload','no_story'=>1]);

		// $params = array (
		// 			array(
		// 			    'message' => 'M1',
		// 			    'source' => 'https://s-media-cache-ak0.pinimg.com/564x/ae/2d/b2/ae2db2286ead909b2417cf04f1ca4b32.jpg'
		// 			),
		// 			array(
		// 			    'message' => 'M2',
		// 			    'source' => 'https://scontent-sin6-1.xx.fbcdn.net/v/t1.0-9/14102276_239300659797576_6250570989027139384_n.jpg?oh=7f5ee0b4061d86aa7834e888588ff8f0&oe=583E5C48'
		// 			)
		// 			,
		// 			array(
		// 			    'message' => 'M3',
		// 			    'source' => 'https://scontent-sin6-1.xx.fbcdn.net/v/t1.0-9/14051598_239300653130910_2564493108314673867_n.jpg?oh=2b0f72cc3a8cc7f9c3bfd5ce4b1182ad&oe=58417F7A'
		// 			)
		// 		);
		// foreach ($params as $key => $obj) {
		// 	$this->facebook->add_to_batch_pool('upload', 'POST', '/me/photos',$obj);
		// }
		// $responses = $this->facebook->send_batch_pool();
		$this->fb = $this->facebook->object();
		$user = $this->facebook->request('get', '/me?fields=id,name,email');

		$tmp_type ="me/photos";

        $batch = [
        'photo_1' => $this->fb->request('POST', $tmp_type, [
         	'message' => 'photo_1',
         	'url' => 'https://s-media-cache-ak0.pinimg.com/564x/ae/2d/b2/ae2db2286ead909b2417cf04f1ca4b32.jpg',
         	
         ]),
        'photo_2' => $this->fb->request('POST', $tmp_type, [
        	'message' => 'photo_2',
         	'url' => 'https://scontent-sin6-1.xx.fbcdn.net/v/t1.0-9/14141801_239300636464245_5202942603565279194_n.jpg?oh=8c742ec76ec97aa052fe387e3ab5d939&oe=584AB324'         	
          ]),

        'photo_3' => $this->fb->request('POST', $tmp_type, [
        	'message' => 'photo_3',
         	'url' => 'https://scontent-sin6-1.xx.fbcdn.net/v/t1.0-9/14068241_239300676464241_3380064916531236447_n.jpg?oh=16446eb4bb0be26bd9fcff13df66c346&oe=585E994A'
          ]),

        'photo_4' => $this->fb->request('POST', $tmp_type, [
        	'message' => 'photo_4',
         	'url' => 'https://scontent-sin6-1.xx.fbcdn.net/v/t1.0-9/14051598_239300653130910_2564493108314673867_n.jpg?oh=2b0f72cc3a8cc7f9c3bfd5ce4b1182ad&oe=58417F7A'         	
          ]),

        'photo_5' => $this->fb->request('POST', $tmp_type, [
        	'message' => 'photo_5',
         	'url' => 'https://scontent-sin6-1.xx.fbcdn.net/v/t1.0-9/14102276_239300659797576_6250570989027139384_n.jpg?oh=7f5ee0b4061d86aa7834e888588ff8f0&oe=583E5C48'         	
          ]),
        
        ];

        $response = $this->fb->sendBatchRequest($batch);
         $data = [];
            foreach ($response as $key => $response)
            {
                $data[$key] = $response->getDecodedBody();
            }
         '<pre>'; print_r($data);echo '</pre>'; 
	
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