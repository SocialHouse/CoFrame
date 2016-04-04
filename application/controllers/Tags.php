<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags extends CI_Controller {

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

	public function index($brand_id = 0)
	{
		if($brand_id)
		{
			$this->data = array();			
			$brand = get_users_brand($brand_id);
			if(!empty($brand))
			{
				$this->data['brand_id'] = $brand[0]->id;
				$this->data['brand_name'] = $brand[0]->name;				
				$this->data['view'] = 'tags/brand_tags';
				$condition = array('brand_id' => $brand_id);
				$this->data['brand_tags'] = $this->timeframe_model->get_data_by_condition('brand_tags',$condition);
		        _render_view($this->data);
		    }
		    else
		    {
		    	$this->session->set_flashdata('error','Brand is not available');
		    	redirect(base_url().'brands');
		    }
		}		
	}


	public function add_tags($brand_id = 0)
	{
		if($brand_id)
		{
			$this->data = array();			
			$brand = get_users_brand($brand_id);			
			if(!empty($brand))
			{
				$this->data['brand_id'] = $brand[0]->id;
				$this->data['brand_name'] = $brand[0]->name;
				$this->data['tags'] = $this->brand_model->get_tags();
				$this->data['view'] = 'tags/add_tags';
		        _render_view($this->data);
		    }
		    else
		    {
		    	$this->session->set_flashdata('error','Brand is not available');
		    	redirect(base_url().'brands');
		    }
		}		
	}

	public function edit_tags($tag_id = 0)
	{
		if($tag_id)
		{
			$this->data = array();
			$condition = array('id' => $tag_id);
			$tag_data = $this->timeframe_model->get_data_by_condition('brand_tags',$condition);

			if(!empty($tag_data))
			{
				$brand = get_users_brand($tag_data[0]->brand_id);
				if(!empty($brand))
				{
					$this->data['tag_data'] = $tag_data[0];
					$this->data['brand_id'] = $brand[0]->id;
					$this->data['brand_name'] = $brand[0]->name;
					$this->data['tags'] = $this->brand_model->get_tags();
					$this->data['view'] = 'tags/add_tags';
			        _render_view($this->data);
			    }
			    else
			    {
			    	$this->session->set_flashdata('error','Brand is not available');
			    	redirect(base_url().'brands');
			    }
			}
		}		
	}

	public function save_brand_tag()
	{
		$this->data = array();
		$post_data = $this->input->post();
		$brand_id = $post_data['brand_id'];
		$brand = get_users_brand($brand_id);

		if(!empty($brand))
		{
			$this->data = array();

			$this->form_validation->set_rules('color','color','required');
			if(empty($post_data['new_label']) AND empty($post_data['label']))
			{
				$this->form_validation->set_rules('label','label','required',
													array('required' => 'Atleast one field required from Label and New label')
												);
			}

			if($this->form_validation->run() === FALSE)
	        {
	        	$this->data['brand_id'] = $brand[0]->id;
				$this->data['brand_name'] = $brand[0]->name;
				$this->data['tags'] = $this->brand_model->get_tags();
				$this->data['view'] = 'tags/add_tags';
		        _render_view($this->data);
	        }
	        else
	        {	        	
	        	$label = $post_data['new_label'];
	        	if(empty($label))
	        	{
	        		$label = $post_data['label'];
	        	}
	        
	        	$data = array(
	        				'name' => $label,
	        				'color' => $post_data['color'],
	        				'brand_id' => $brand_id
	        			);

	        	if(!empty($post_data['id']))
	        	{
	        		$condition = array('id' => $post_data['id']);
	        		$this->timeframe_model->update_data('brand_tags',$data,$condition);
	        		$message = "Tag has been updated successfully";
	        	}
	        	else
	        	{
	        		$this->timeframe_model->insert_data('brand_tags',$data);
	        		$message = "Tag has been added successfully";
	        	}
	        	$this->session->set_flashdata('message',$message);
	        	redirect(base_url().'tags/index/'.$brand_id);
	        }
		}
		else
		{
			$this->session->set_flashdata('error','Unable to add tag, please try again');
			redirect(base_url().'brands');
		}
	}	

	public function activate($tag_id)
	{
		$condition = array('id' => $tag_id);
		$tag_data = $this->timeframe_model->get_data_by_condition('brand_tags',$condition);
		if(!empty($tag_data))
		{
			$brand = get_users_brand($tag_data[0]->brand_id);
			if(!empty($brand))
			{
				$brand_data = array(
									'status' => 1
								);
				$condition = array('id' => $tag_id);
				$this->timeframe_model->update_data('brand_tags',$brand_data,$condition);
				$this->session->set_flashdata('message','Tag has been activated');
				redirect(base_url().'tags/index/'.$tag_data[0]->brand_id);
			}
		}
	}

	public function deactivate($tag_id)
	{
		$condition = array('id' => $tag_id);
		$tag_data = $this->timeframe_model->get_data_by_condition('brand_tags',$condition);
		if(!empty($tag_data))
		{
			$brand = get_users_brand($tag_data[0]->brand_id);
			if(!empty($brand))
			{
				$brand_data = array(
									'status' => 0
								);
				$condition = array('id' => $tag_id);
				$this->timeframe_model->update_data('brand_tags',$brand_data,$condition);
				$this->session->set_flashdata('message','Tag has been deactivated');
				redirect(base_url().'tags/index/'.$tag_data[0]->brand_id);
			}
		}
	}
}