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
		$this->load->model('timeframe_model');
		$this->load->model('admin_account_model');
		$this->load->model('admin_brand_model');
	}


	function index()
	{
		$ac_id = $this->uri->segment(3);
		$brand_id = $this->uri->segment(4);
		if($brand_id)
		{
			$this->data['brand'] = $this->timeframe_model->get_data_by_condition('brands',array('id' => $brand_id,'account_id' => $ac_id));

			if(!empty($this->data['brand']))
	    	{
	    		$brand_id = $this->data['brand'][0]->id;	            
				$condition = array('brand_id' => $brand_id);
				$this->data['brand_tags'] = $this->timeframe_model->get_data_by_condition('brand_tags',$condition);
				$this->load->model('post_model');
				$this->data['outlets'] = $this->admin_brand_model->get_brand_outlets($brand_id);			
				$this->data['brands_user'] = $this->admin_brand_model->get_brand_users($brand_id);
				$this->data['timezones'] = $this->timeframe_model->get_table_data('timezone');
				$this->load->view('admin/partials/header');
				$this->load->view('admin/brand/brand_details',$this->data);
				$this->load->view('admin/partials/footer');
				
		    }
		}
	}

	function chane_brand_status()
	{
		$ac_id = $this->uri->segment(4);
		$brand_id = $this->uri->segment(5);
		$status = $this->uri->segment(6);
		$data = array(
				'is_hidden' => !$status
			);
		$this->timeframe_model->update_data('brands',$data,array('id' => $brand_id));
		
		$message = 'User unhide successfull';
		if($status == 1)
		{
			$massage = "User hide successfull";
		}
		$flash_data = array(
				'message' => $message,
				'class' => 'success'
			);

		$this->session->set_flashdata('message',$flash_data);
		redirect(base_url('accounts/brands/'.$ac_id));
	}
}