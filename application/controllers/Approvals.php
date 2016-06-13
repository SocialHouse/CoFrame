<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approvals extends CI_Controller {

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
		$this->load->model('approval_model');
		$this->load->model('brand_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	function index()
	{
		$this->data = array();		
		$slug = $this->uri->segment(2);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);
		if(!empty($brand))
		{
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['brand'] = $brand[0];

			$approvals = $this->approval_model->get_approvals($this->user_id,$brand[0]->id);
			
			$this->data['approval_list'] = array();
			if(!empty($approvals))
			{
				foreach($approvals as $approval)
				{
					$this->data['approval_list'][date('D m/d',strtotime($approval->slate_date_time))][$approval->post_id] = $approval;
				}
			}

			$this->data['view'] = 'approvals/approval_list';
			$this->data['layout'] = 'layouts/new_user_layout';

	        _render_view($this->data);
	    }
	}

	function edit_request()
	{
		$this->data = array();		
		$post_id = $this->uri->segment(2);
		$this->load->model('post_model');
		$this->data['post_id'] = $post_id;
		$this->data['post_details'] = $this->post_model->get_post($post_id);
		$this->data['post_images'] = $this->post_model->get_images($post_id);
		$brand = $this->brand_model->get_users_brands($this->user_id,$this->data['post_details']->brand_id);
		$this->data['selected_tags'] = $this->post_model->get_post_tags($post_id);

		if(!empty($brand))
		{
			$this->data['phase'] = $this->approval_model->get_approval_phase($post_id,$this->user_id);
			if(!empty($this->data['phase']))
			{
				$this->data['brand_id'] = $brand[0]->id;
				$this->data['brand'] = $brand[0];
				$this->data['view'] = 'approvals/edit_request';
				$this->data['layout'] = 'layouts/new_user_layout';

		        _render_view($this->data);
		    }
	    }
	}

	function save_edit_request()
	{
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$uploaded_file = '';
			if(isset($_FILES) AND !empty($_FILES))
			{
		        $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
		        $randname = uniqid().'.'.$ext;
				$status = upload_file('attachment',$randname,$post_data['brand_owner'].'/brands/'.$post_data['brand_id'].'/requests/');					       
		        if(array_key_exists("upload_errors",$status))
		        {
		        	$error =  $status['upload_errors'];	        	
		        }
		        else
		        {
		        	$uploaded_file = $status['file_name'];	        	
		        }
		    }

		    if(!isset($error))
		    {
		    	$request_data =array(
		    			'post_id' => $post_data['brand_owner'],
		    			'phase_id' => $post_data['phase_id'],
		    			'user_id' => $post_data['user_id'],
		    			'comment' => $post_data['comment'],
		    			'media' => $uploaded_file
		    		);

		    	$inserted_id = $this->timeframe_model->insert_data('post_comments',$request_data);

		    	$this->data['comment'] = $this->approval_model->get_comment($inserted_id);		    	
		    	$this->data['brand_owner'] = $post_data['brand_owner'];
		    	$this->data['post_id'] = $post_data['post_id'];
		    	$this->data['brand_id'] = $post_data['brand_id'];

		    	$response_html = $this->load->view('partials/request_html',$this->data,true);
		    	echo json_encode(array('response' => 'success','html' => $response_html));
		    }
		    else
		    {
		    	echo json_encode(array('response' => 'fail'));	
		    }
		}
	}
}