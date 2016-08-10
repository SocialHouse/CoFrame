<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
use DirkGroenen\Pinterest\Pinterest;

class Pinterest_connect extends CI_Controller {

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
		$this->load->config('pinterest');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
		$this->callback_url = $this->config->item('pinterest_callback_url');
		$this->app_id = $this->config->item('pinterest_app_id');
		$this->app_secret = $this->config->item('pinterest_app_secret');
		

		if($this->session->userdata('brand_id')){
			$this->brand_id = $this->session->userdata('brand_id');
		}

		if($this->session->userdata('outlet_id')){
			$this->outlet_id = $this->session->userdata('outlet_id');
		}

		$this->pin = new Pinterest($this->app_id, $this->app_secret );
		
	}

	public function pinterest($brand_id='',$outlet_id='')
	{
		$this->session->set_userdata('brand_id',$brand_id);
		$this->session->set_userdata('outlet_id',$outlet_id);
		$is_key_exist = $this->social_media_model->get_token('pinterest');
		
		if(empty($is_key_exist))
		{
			$loginurl = $this->pin->auth->getLoginUrl($this->callback_url,array('read_public', 'write_public'));
			redirect($loginurl);
		}else{
			$this->session->set_userdata('pinterest_access_token',object_to_array($is_key_exist));
			echo str_replace('%type%', 'pinterest', $this->lang->line('already_saved'));
			//$this->me();
		}
	}


	function pinterest_callback()
	{
		$is_key_exist = $this->social_media_model->get_token('pinterest');
		$token = $this->session->userdata("pinterest_access_token");
		if(empty($token['access_token']) || empty($is_key_exist))
		{
			if(isset($_GET["code"]))
			{
				$data =array();
				$token = $this->pin->auth->getOAuthToken($_GET["code"]);
				$temp_array = array(
					'access_token' =>$token->access_token,
					'token_type' =>$token->token_type,
					'scope' => implode(",",$token->scope)
					);

				$this->pin->auth->setOAuthToken($token->access_token);

				$data = array(
					'access_token' => $token->access_token,
					'user_id' => $this->user_id,
					'brand_id' => $this->brand_id,
					'outlet_id' => $this->outlet_id,
					'response' => json_encode($temp_array),
					'type' => 'pinterest'
					);
				$this->social_media_model->save_token($data);

				$this->session->set_userdata('pinterest_access_token', $temp_array);
				echo str_replace('%type%', 'pinterest', $this->lang->line('save_successfully'));
				//redirect(base_url().'pinterest_connect/me');
			}
		}
	}

	public function me()
	{
		$token = $this->session->userdata("pinterest_access_token");

		if(!empty($token['access_token']))
		{
			$this->pin->auth->setOAuthToken($token['access_token']);
			$me =$this->pin->users->me(array(
				'fields' => 'username,first_name,last_name,image[small,large]'
				)
			);
			$mybords =$this->pin->users->getMeBoards();
			$my_pins = array();
			echo '<div><table><thead><tr><th>Id</th><th>Name</th><th>Name</th><th>Description</th></tr></thead><tbody>';
			foreach ($mybords as $key => $board) {
				$result = json_decode($this->pin->pins->fromBoard($board->id));
				if(!empty($result->data)){
					$my_pins[] = $result->data;
				}
				echo '<tr>';
				echo '<td>'.$board->id.'</td>';
				echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.$board->name.'</td>';
				echo '<td>'.$board->url.'</td>';
				echo '<td>'.$board->description.'</td>';
				echo '</tr>';
			}
			echo '</tbody></table><br/><br/><br/>';
			echo '<p>Id : '.$me->id.'</p>';
			echo '<p>Username : '.$me->username.'</p>';
			echo '<p>first name : '.$me->first_name.'&nbsp;&nbsp;'.$me->last_name.'</p>';
			echo 'My Pins';
			foreach ($my_pins as $key => $pins) {
				foreach ($pins as $obj => $pin) {
					echo '<pre>'; print_r($pin);echo '</pre>';
					echo '<br/><br/>';
				}
			}
			echo '</div>';
		}
		else
		{
			$is_key_exist = $this->social_media_model->get_token('pinterest');
			if($is_key_exist){
				$this->session->set_userdata('pinterest_access_token',object_to_array($is_key_exist));
				$this->me();
			}
			else{
				$this->pinterest($this->brand_id,$this->outlet_id);
			}
		}
	}

	function reset_session()
	{
		$this->session->unset_userdata('pinterest_access_token');
	}
}