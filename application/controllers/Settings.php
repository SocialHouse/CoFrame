<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

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
		$this->load->model('post_model');
		$this->load->model('brand_model');
		$this->load->model('user_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	function index()
	{ 
	}

	function view()
	{
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);

		if(!empty($brand))
		{
			$brand_id = $brand[0]->id;
			$this->data['users'] = $this->brand_model->get_brand_users($brand_id);
			$this->data['outlets'] = $this->post_model->get_brand_outlets($brand_id);
			$this->data['tags'] = $this->post_model->get_brand_tags($brand_id);	

			$timezone_str = $this->brand_model->get_brand_timezone_string($brand_id);
			$this->data['timezone'] = $timezone_str[0]->timezone; 
			$this->data['selected_outlets'] = $this->post_model->get_brand_outlets($brand[0]->id);
			$this->data['selected_tags'] = $this->post_model->get_brand_tags($brand[0]->id);			
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['brand'] = $brand[0];
			$this->data['view'] = 'settings/settings';
			//echo '<pre>'; print_r($this->data);echo '</pre>'; die;
			$this->data['layout'] = 'layouts/new_user_layout';
			$this->data['js_files'] = array(js_url().'vendor/bootstrap-colorpicker.min.js?ver=2.3.3',js_url().'add-brand.js?ver=1.0.0',js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'facebook.js');
			$this->data['background_image'] = 'bg-brand-management.jpg';  

			_render_view($this->data);
		}
	}

	public function edit_step(){
		$this->data = array();
		$slug = $this->input->post('brand_slug');
		$step_number = $this->input->post('step_no');
		$is_load = $this->input->post('reload');

		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);
		$this->data['brand_id'] = $brand[0]->id;
		$this->data['brand'] = $brand[0];
		$this->data['users'] = $this->brand_model->get_brand_users( $brand[0]->id);



		if(!empty($step_number) && !empty($slug)){

			if($step_number == 1 ){
				$timezone_str = $this->brand_model->get_brand_timezone_string($brand[0]->id);
				$this->data['timezone'] = $timezone_str[0]->timezone; 
				$this->data['timezones_list'] = $this->user_model->get_timezones();
			}

			if($step_number == 2 ){
				$this->data['selected_outlets'] = $this->post_model->get_brand_outlets($brand[0]->id);
				$this->data['outlets'] = $this->timeframe_model->get_table_data('outlets');
				
			}

			if($step_number == 3 ){
				$this->data['selected_tags'] = $this->post_model->get_brand_tags($brand[0]->id);
			} 

			if($step_number == 4 ){
				$this->data['selected_tags'] = $this->post_model->get_brand_tags($brand[0]->id);
			}
			//echo '<pre>'; print_r($this->data);echo '</pre>'; die;

			if($is_load == 'true'){
				echo $this->load->view('settings/step_'.$step_number,$this->data,true);	
			}else{
				
				$this->data['js_files'] = array(js_url().'vendor/bootstrap-colorpicker.min.js?ver=2.3.3',js_url().'add-brand.js?ver=1.0.0',js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'facebook.js');
				echo $this->load->view('settings/edit_brand/step_'.$step_number,$this->data,true);
			}
		}else{
			echo 'false';
		}
	}

}