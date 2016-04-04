<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outlets extends CI_Controller {

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
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	public function add_outlet($brand_id = 0)
	{
		if($brand_id)
		{
			$this->data = array();
			$brand = get_users_brand($brand_id);
			if(!empty($brand))
			{
				$this->data['brand_id'] = $brand[0]->id;
				$this->data['brand_name'] = $brand[0]->name;
				$this->data['outlets'] = $this->timeframe_model->get_table_data('outlets');
				$condition = array('brand_id' => $brand[0]->id);
				$selected_outlets = $this->timeframe_model->get_data_array_by_condition('brand_outlets',$condition);
				$this->data['selected_outlets'] = array();
				if(!empty($selected_outlets))
				{
					$this->data['selected_outlets'] = array_column($selected_outlets,'outlet_id');
				}

				$this->data['view'] = 'outlets/add_outlet';
		        _render_view($this->data);
		    }
		    else
		    {
		    	$this->session->set_flashdata('error','Brand is not available');
		    	redirect(base_url().'brands');
		    }
		}		
	}

	public function save_outlet()
	{
		$this->data = array();
		$post_data = $this->input->post();
		$brand_id = $post_data['brand_id'];
		$brand = get_users_brand($brand_id);

		if(!empty($brand))
		{
			$this->data = array();

			$this->form_validation->set_rules('outlets[]','outlets','required',
	                                            array('required' => 'At least select one outlet')
	                                        );
			if($this->form_validation->run() === FALSE)
	        {
	        	$this->data['brand_id'] = $brand[0]->id;
				$this->data['brand_name'] = $brand[0]->name;
				$this->data['outlets'] = $this->timeframe_model->get_table_data('outlets');
				$this->data['selected_outlets'] = array();
				$this->data['view'] = 'outlets/add_outlet';
		        _render_view($this->data);
	        }
	        else
	        {
	        	$outlets_to_add = $post_data['outlets'];
	        	//check outlerts already added for this brand or not
	        	$condition = array('brand_id' => $brand_id);
	        	$brand_outlets = $this->timeframe_model->get_data_array_by_condition('brand_outlets',$condition);
	        	if(!empty($brand_outlets))
	        	{
		        	$outlet_ids = array_column($brand_outlets,'outlet_id');
		        	$outlets_to_add = array_diff($post_data['outlets'],$outlet_ids);
		        	$outlets_to_delete = array_diff($outlet_ids,$post_data['outlets']);
		        	foreach ($outlets_to_delete as $outlet)
		        	{
		        		$data = array('brand_id' => $post_data['brand_id'],'outlet_id' => $outlet);
		        		$this->timeframe_model->delete_data('brand_outlets',$data);
		        	}
		        }
	        	

	        	foreach ($outlets_to_add as $outlet)
	        	{
	        		$data = array('brand_id' => $post_data['brand_id'],'outlet_id' => $outlet);
	        		$this->timeframe_model->insert_data('brand_outlets',$data);
	        	}
	        	$this->session->set_flashdata('message','Outlet has bee added to brand');
	        	redirect(base_url().'brands');
	        }
		}
		else
		{
			$this->session->set_flashdata('message','Unable to add outlet, please try again');
			redirect(base_url().'brands');
		}
	}
}