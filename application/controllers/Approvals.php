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
			$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);

			$additional_group = '';
			if($this->data['user_group'] == 'Creator')
			{
				$additional_group = $this->data['user_group'];
			}
			check_access('approve',$brand,$additional_group);

			$this->data['brand_id'] = $brand[0]->id;
			$this->data['brand'] = $brand[0];
			
			$approvals = $this->approval_model->get_approvals($this->user_id,$brand[0]->id,$this->data['user_group']);
			$this->data['filters'] = $this->timeframe_model->get_data_by_condition('filters',array('user_id' => $this->user_id,'brand_id' => $brand[0]->id));
			
			$this->data['approval_list'] = array();
			if(!empty($approvals))
			{
				foreach($approvals as $approval)
				{
					$this->data['approval_list'][date('D m/d',strtotime($approval->slate_date_time))][$approval->id] = $approval;
				}
			}
			
			$this->data['css_files'] = array(css_url().'fullcalendar.css');

			$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'vendor/jquery.dotdotdot.min.js?ver=1.8.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0');

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
				$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);
				$this->data['view'] = 'approvals/edit_request';
				$this->data['layout'] = 'layouts/new_user_layout';
				$this->data['js_files'] = array(js_url().'vendor/moment.min.js?ver=2.11.0');

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
		    			'post_id' => $post_data['post_id'],
		    			'phase_id' => $post_data['phase_id'],
		    			'user_id' => $post_data['user_id'],
		    			'comment' => $post_data['comment'],
		    			'media' => $uploaded_file
		    		);

		    	if(isset($post_data['parent_id']))
		    	{
		    		$parent_data = array(
		    				'parent_id' => $post_data['parent_id']
		    			);
		    		$request_data = array_merge($request_data, $parent_data);
		    	}
		    	else
		    	{
		    		$post = $this->timeframe_model->get_data_by_condition('posts',array('id' => $post_data['post_id']),'user_id,brand_id,slate_date_time,outlet_id');

		    		$reminder_data = array(
				    				'type' => 'notification',
				    				'text' => 'Review feedback from '.ucfirst($this->user_data['first_name']).' '.ucfirst($this->user_data['last_name']).' on '.date('m/d',strtotime($post[0]->slate_date_time)).' '.get_outlet_by_id($post[0]->outlet_id).' post',
				    				'brand_id' => $post[0]->brand_id,
				    				'user_id' => $post[0]->user_id,
				    				'post_id' => $post_data['post_id']
				    			);
		    		$this->timeframe_model->insert_data('reminders',$reminder_data);
		    	}

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

	function view_request()
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
			$this->data['phases'] = $this->approval_model->all_approval_phases($post_id);			
			if(!empty($this->data['phases']))
			{
				$this->data['brand_id'] = $brand[0]->id;
				$this->data['brand'] = $brand[0];
				$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);

				$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'vendor/jquery.dotdotdot.min.js?ver=1.8.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0', js_url().'drag-drop-file-upload.js?ver=1.0.0');
				
				$this->data['view'] = 'approvals/view_request';
				$this->data['layout'] = 'layouts/new_user_layout';

		        _render_view($this->data);
		    }
	    }
	}

	function change_comment_status()
	{
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$new_data = array(
					'status' => $post_data['status']
				);
			$status = $this->timeframe_model->update_data('post_comments',$new_data,array('id' => $post_data['comment_id']));
			if($status)
				echo "1";
			else
				echo "0";
		}
	}

	function get_approvals_by_date()
	{
		$this->data = array();
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$approvals = $this->approval_model->get_approvals($this->user_id,$post_data['brand_id'],$this->user_group,$post_data['date']);
				
			$this->data['approval_list'] = array();
			if(!empty($approvals))
			{
				foreach($approvals as $approval)
				{
					$this->data['approval_list'][date('D m/d',strtotime($approval->slate_date_time))][$approval->id] = $approval;
				}
			}
			echo $this->load->view('approvals/approval_table_html',$this->data,true);
		}		
	}
}