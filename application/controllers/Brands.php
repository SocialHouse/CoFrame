<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands extends CI_Controller {

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
		$this->load->model('brand_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	public function index()
	{
		$this->data = array();
		$user_id = $this->user_id;
		$this->data['brands'] = $this->brand_model->get_users_brand($user_id);
		
		$this->data['view'] = 'brands/brand_list';
        _render_view($this->data);
	}

	public function add()
	{
		$this->data = array();
		$this->load->model('user_model');
		$this->data['timezones'] = $this->user_model->get_timezones();
		$this->data['view'] = 'brands/add_brand';
        _render_view($this->data);
	}

	public function save_brand()
	{
		$this->data = array();
		$user_id = $this->user_id;
		$brand_id = $this->input->post('id');

        $this->form_validation->set_rules('name', 'name', 'required',
                                            array('required' => 'Brand name is required')
                                        );
         $this->form_validation->set_rules('timezone', 'timezone', 'required',
                                            array('required' => 'Timezone is required')
                                        );
        if(isset($brand_id) AND !empty($brand_id))
        {
        	$this->form_validation->set_rules('is_hidden', '', 'required',
                                            	array('required' => 'Please check one of radio')
                                        	);
        }

        if($this->form_validation->run() === true) 
        {
        	
        	if(!empty($_FILES['logo']['name']))
			{
				$filename = $_FILES["logo"]["name"];
				$upload_path = upload_path();
				$config['upload_path'] = $upload_path.'brands/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = '40000';
				
				$this->load->library('upload',$config);

				$status =  upload_file('logo',$filename,'brands');

				if(array_key_exists("upload_errors",$status))
		        {
		        	$error =  array('error' => $status['upload_errors']);
		        }
		        else
		        {
		        	$image = $status['file_name'];
		        }
			}
			
        	$brand_data = array(
        						'name' => $this->input->post('name'),
        						'user_id' => $user_id,
        						'created_by' => $user_id,
        						'timezone' => $this->input->post('timezone'),
        						'is_hidden' => $this->input->post('is_hidden') ? $this->input->post('is_hidden') : 0
        					);
        	//save brand data        	
        	if(!isset($error) AND empty($brand_id))
        	{
        		$insert_id = $this->timeframe_model->insert_data('brands',$brand_data);
        		$old_path = upload_path().'brands/'.$image;
        		$new_path = upload_path().'brands/'.$insert_id.'.png';
        		rename($old_path, $new_path);
	        	redirect(base_url().'brands');
        	}
        	elseif(!isset($error['error']) AND !empty($brand_id))
        	{
        		$condition = array('id' => $brand_id);
        		$this->timeframe_model->update_data('brands',$brand_data,$condition);
        		if(isset($image))
        		{
        			if(file_exists(upload_path().'brands/'.$brand_id.'.png'))
	        			unlink(upload_path().'brands/'.$brand_id.'.png');

	        		$old_path = upload_path().'brands/'.$image;
        			$new_path = upload_path().'brands/'.$brand_id.'.png';
        			rename($old_path, $new_path);
	        	}
        		redirect(base_url().'brands');
        	}
        	else
        	{
        		$this->data['error'] = 'Unable to upload image please try again';
        	}
        }       	
		$this->load->model('user_model');
		$this->data['timezones'] = $this->user_model->get_timezones();
		$this->data['view'] = 'brands/add_brand';
        _render_view($this->data);
	}

	public function edit($brand_id)
	{
		$this->data = array();
		$this->load->model('user_model');
		$this->data['timezones'] = $this->user_model->get_timezones();
		$brand = get_users_brand($brand_id);
		if(!empty($brand))
		{
			$this->data['brand'] = $brand[0];
			$this->data['view'] = 'brands/add_brand';
	        _render_view($this->data);
	    }
	    else
	    {
	    	$this->session->set_flashdata('error','Brand is not available');
	    	redirect(base_url().'brands');
	    }
	}

	public function hide_brand($brand_id)
	{
		$brand = get_users_brand($brand_id);
		if(!empty($brand))
		{
			$brand_data = array(
								'is_hidden' => 1
							);
			$condition = array('id' => $brand_id);
			$this->timeframe_model->update_data('brands',$brand_data,$condition);
			$this->session->set_flashdata('message','Brand hide successfull');
			redirect(base_url().'brands');
		}
	}

	public function un_hide_brand($brand_id)
	{
		$brand = get_users_brand($brand_id);
		if(!empty($brand))
		{
			$brand_data = array(
								'is_hidden' => 0
							);
			$condition = array('id' => $brand_id);
			$this->timeframe_model->update_data('brands',$brand_data,$condition);
			$this->session->set_flashdata('message','Brand unhide successfull');
			redirect(base_url().'brands');
		}
	}

	public function overview()
	{
		$this->data = array();
		$user_id = $this->user_id;
		$this->data['brands'] = $this->brand_model->get_users_brands($user_id);
		
		$this->data['js_files'] = array(js_url().'vendor/jquery-ui-sortable.min.js',js_url().'reorder-brands.js?ver=1.0.0');
		$this->data['view'] = 'brands/overview';
		$this->data['layout'] = 'layouts/new_user_layout';
        _render_view($this->data);
	}

	public function dashboard()
	{
		$this->data = array();
		$brand_id = $this->uri->segment(3);
		$this->load->model('user_model');
		$this->data['timezones'] = $this->user_model->get_timezones();
		$brand =  $this->brand_model->get_users_brands($this->user_id);
		
		if(!empty($brand))
		{
			$this->load->model('reminder_model');
			$this->data['reminders'] = $this->reminder_model->get_brand_reminders($this->user_id,$brand_id);			
			$this->data['brand'] = $brand[0];
			$this->data['brand_id'] = $brand[0]->id;
 			$this->data['css_files'] = array(css_url().'fullcalendar.css');
			$this->data['js_files'] = array(js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0');

			$this->data['view'] = 'brands/dashboard';
			$this->data['layout'] = 'layouts/new_user_layout';
	        _render_view($this->data);
	    }
	}

	public function brand_list()
	{
		$this->data['brands'] =  $this->brand_model->get_users_brands($this->user_id);		
		echo $this->load->view('partials/brand_list',$this->data,true);		
	}

	public function reorder_brands()
	{
		$this->data['brands'] =  $this->brand_model->get_users_brands($this->user_id);
		
		echo $this->load->view('partials/reorder_brands',$this->data,true);		
	}
}
