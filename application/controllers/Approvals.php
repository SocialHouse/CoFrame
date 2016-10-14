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
		$this->load->model('phase_model');
		$this->load->model('post_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
	}

	function index()
	{
		$this->data = array();		
		$slug = $this->uri->segment(2);	
		$this->data['inserted_post'] = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);
		
		if(!empty($brand))
		{
			$this->user_data['timezone'] = $brand[0]->timezone;
			$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);

			$additional_group = '';
			
			if(check_user_perm($this->user_id,'create',$brand[0]->id))
			{
				$additional_group = $this->data['user_group'];
			}

			if(check_user_perm($this->user_id,'master',$brand[0]->id))
			{
				$additional_group = $this->data['user_group'];
			}

			$message = $this->lang->line('access_denied_approval_page');
			check_access('approve',$brand,$additional_group,$message);

			$this->data['brand_id'] = $brand[0]->id;
			$this->data['brand'] = $brand[0];
			
			$approvals = $this->approval_model->get_approvals($this->user_id,$brand[0]->id,$this->data['user_group']);
			$this->data['filters'] = $this->timeframe_model->get_data_by_condition('filters',array('user_id' => $this->user_id,'brand_id' => $brand[0]->id));
			
			$this->data['approval_list'] = array();
			if(!empty($approvals))
			{							
				foreach($approvals as $approval)
				{
					$this->data['approval_list'][date('D n/d',strtotime($approval->slate_date_time))][$approval->phase_id] = $approval;
				}
			}
			
			$this->data['css_files'] = array(css_url().'fullcalendar.css');

			$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'vendor/jquery.dotdotdot.min.js?ver=1.8.1',js_url().'calendar-config.js?ver=1.0.0', js_url().'drag-drop-file-upload.js?ver=1.0.0', js_url().'custom_validation.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0',js_url().'view-n-edit-request.js?ver=1.0.0', js_url().'tumblr-preview.js?ver=1.0.0');

			$this->data['view'] = 'approvals/approval_list';
			$this->data['layout'] = 'layouts/new_user_layout';

	        _render_view($this->data);
	    }
	}

	function edit_request()
	{
		$this->data = array();
		$post_id = $this->uri->segment(2);
		$this->data['post_id'] = $post_id;
		$this->data['post_details'] = $this->post_model->get_post($post_id);
		$this->data['post_images'] = $this->post_model->get_images($post_id);
		if(!empty($this->data['post_details'])){			
			$brand = $this->brand_model->get_users_brands($this->user_id,$this->data['post_details']->brand_id);
			$this->data['selected_tags'] = $this->post_model->get_post_tags($post_id);
			if(!empty($brand))
			{
				$this->data['phase'] = $this->approval_model->get_approval_phase($post_id,$this->user_id);
				//echo '<pre>'; print_r($this->data['phase']);echo '</pre>'; die;
				if(!empty($this->data['phase']))
				{
					$this->data['brand_id'] = $brand[0]->id;
					$this->data['brand'] = $brand[0];
					$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);
					$this->data['view'] = 'approvals/edit_request';
					$this->data['layout'] = 'layouts/new_user_layout';
					$this->data['css_files'] = array(css_url().'fullcalendar.css');
					$this->data['js_files'] = array(js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'view-n-edit-request.js?ver=1.0.0',js_url().'custom_validation.js?ver=1.0.0', js_url().'tumblr-preview.js?ver=1.0.0');
			        _render_view($this->data);
			    }
			    else
			    {
			    	redirect(base_url().'approvals/'.$this->data['post_details']->slug);
			    }
		    }
		}else{
			// show_404();
			// $message = "record not found";
			// $status_code = 404;
			// show_error($message, $status_code, $heading = 'An Error Was Encountered');
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
				$status = upload_file('attachment',$randname,$this->user_data['account_id'].'/brands/'.$post_data['brand_id'].'/requests/');					       
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

		    	$post = $this->timeframe_model->get_data_by_condition('posts',array('id' => $post_data['post_id']),'user_id,brand_id,slate_date_time,outlet_id');

		    	if(isset($post_data['parent_id']) AND !isset($post_data['suggest_id']))
		    	{
		    		$parent_data = array(
		    				'parent_id' => $post_data['parent_id']
		    			);
		    		$request_data = array_merge($request_data, $parent_data);

		    		$parent_comment = $this->timeframe_model->get_data_by_condition('post_comments',array('id' => $post_data['parent_id']),'user_id');

		    		if(!empty($parent_comment) AND $parent_comment[0]->user_id != $this->user_id)
		    		{
		    			$reminder_data = array(
					    				'type' => 'reminder',
					    				'text' => 'Please check comment from '.ucfirst($this->user_data['first_name']).' '.ucfirst($this->user_data['last_name']).' on '.date('d/n g:i a',strtotime($post[0]->slate_date_time)).' '.get_outlet_by_id($post[0]->outlet_id).' post',
					    				'brand_id' => $post[0]->brand_id,
					    				'user_id' => $parent_comment[0]->user_id,
					    				'post_id' => $post_data['post_id'],
					    				'phase_id' => $post_data['phase_id']
					    			);			    		
		    		}

		    	}
		    	else
		    	{
		    		if($this->user_id != $post[0]->user_id AND !isset($post_data['suggest_id']))
		    		{
			    		$reminder_data = array(
					    				'type' => 'reminder',
					    				'text' => 'Review feedback from '.ucfirst($this->user_data['first_name']).' '.ucfirst($this->user_data['last_name']).' on '.date('d/n g:i a',strtotime($post[0]->slate_date_time)).' '.get_outlet_by_id($post[0]->outlet_id).' post',
					    				'brand_id' => $post[0]->brand_id,
					    				'user_id' => $post[0]->user_id,
					    				'post_id' => $post_data['post_id'],
					    				'phase_id' => $post_data['phase_id']
					    			);
			    		
			    	}
		    	}

		    	if(isset($reminder_data) AND !empty($reminder_data))
		    	{
		    		$this->timeframe_model->insert_data('reminders',$reminder_data);
		    	}

		    	if(isset($post_data['suggest_id']) AND !empty($post_data['suggest_id']))
		    	{
		    		if(isset($post_data['remove_img']))
		    		{
		    			$request_data['media'] = '';
		    		}
		    		$this->timeframe_model->update_data('post_comments',$request_data,array('id' => $post_data['suggest_id']));
		    		$inserted_id = $post_data['suggest_id'];
		    	}
		    	else
		    	{
		    		$inserted_id = $this->timeframe_model->insert_data('post_comments',$request_data);
		    	}

		    	$this->data['comment'] = $this->approval_model->get_comment($inserted_id);

		    	$this->data['brand_owner'] = $post_data['brand_owner'];
		    	$this->data['post_id'] = $post_data['post_id'];
		    	$this->data['brand_id'] = $post_data['brand_id'];

		    	if(isset($post_data['suggest_id']) AND !empty($post_data['suggest_id']))
		    	{
		    		$response_html = '<p class="text">'.$this->data['comment']->comment.'</p>';
		    		if(!empty($this->data['comment']->media))
		    		{
			    		$response_html .= '<div class="comment-asset">';
			    		$response_html .= '<a title="Download Asset" href="'.upload_url().$this->user_data['account_id'].'/brands/'.$post[0]->brand_id.'/requests/'.$this->data['comment']->media.'" download="'.base_url().'uploads/'.$this->user_data['account_id'].'/brands/'.$post[0]->brand_id.'/requests/'.$this->data['comment']->media.'" title="Download Asset"><i class="tf-icon-download"></i> <img width="60" height="60" alt="" src="'.upload_url().$this->user_data['account_id'].'/brands/'.$post[0]->brand_id.'/requests/'.$this->data['comment']->media.'" /></div>';
			    	}
		    	}
		    	else
		    	{
		    		$this->load->library('user_agent');		    		
		    		if($this->agent->is_mobile())
		    		{
		    			$this->data['is_mobile'] = 1;
		    		}
		    		$response_html = $this->load->view('partials/request_html',$this->data,true);
		    	}
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

				$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'vendor/jquery.dotdotdot.min.js?ver=1.8.1',js_url().'calendar-config.js?ver=1.0.0', js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'view-n-edit-request.js?ver=1.0.0');
				
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

	public function edit_approval_phase()
	{
		$this->data = '';
		$phase_id = $this->uri->segment(3);
		$post_id = $this->uri->segment(4);
		$this->data['phase_id'] = $phase_id;
		$this->data['post_id'] = $post_id;
		$this->data['phase_users'] = $this->approval_model->get_phase_users($phase_id);
		$this->data['post_details'] = $this->post_model->get_post($post_id);
		$this->data['phase_details'] = $this->post_model->get_phase($phase_id);

		if( $this->uri->segment(5) == 'edit')
		{
			$post_data = $this->input->post();
			$phase_users = object_to_array($this->data['phase_users']);
			$selected_users  = array_column($phase_users, 'aauth_user_id');	
			$post_data['phase_approver'] = $post_data['phase'][$this->data['phase_details']->phase]['approver'];
			$post_data['phase_id'] = $post_data['phase'][$this->data['phase_details']->phase]['phase_id'];
			
			$user_to_add = array_diff($post_data['phase_approver'],$selected_users);
		    $user_to_delete = array_diff($selected_users,$post_data['phase_approver']);
			// echo '<pre>'; print_r($post_data);echo '</pre>';
			// echo '<pre>'; print_r([$user_to_add,$user_to_delete]);echo '</pre>'; die;

			// Add new users
			if(!empty($user_to_add)){
				foreach ($user_to_add as $newuser) {
					$phasesdata = '';
					$phasesdata = array(
								'phase_id' => $phase_id,
								'user_id' => $newuser
							);
					$this->timeframe_model->insert_data('phases_approver',$phasesdata);
				}
			}
			// delete old users  
			if(!empty($user_to_delete)){
				foreach ($user_to_delete as $olduser) {
					$phasesdata = '';
					$phasescondition= array(
								'phase_id' => $phase_id,
								'user_id' => $olduser
							);
					$this->timeframe_model->delete_data('phases_approver',$phasescondition);
				}
			}

			$hour = !empty($post_data['post-hour'])? $post_data['post-hour'] :'';
			$minute = !empty($post_data['post-minute'])? $post_data['post-minute'] :'';
			$ampm = !empty($post_data['post-ampm'])? $post_data['post-ampm'] :'am';
			$date_time = !empty($post_data['post-date'])? $post_data['post-date'] :'';
			$date_time =  $date_time.' '.add_leading_zero($hour).':'.add_leading_zero($minute).' '.$ampm;

			$approve_date_time = date("Y-m-d H:i:s", strtotime($date_time));
			

			if(!empty($post_data['phase_id'])){
				$ph_condition ='';
				$ph_condition = array('id' =>$post_data['phase_id'] );
				$phase_data['approve_by'] = $approve_date_time;
				$phase_data['note'] = $post_data['note'];
				
				$phase_insert_id = $this->timeframe_model->update_data('phases',$phase_data,$ph_condition);
			}
			echo json_encode(array('status'=>true));
		}
		else
		{
			if($this->data['phase_details']->phase == 1){
				$this->data['pre_ph_date'] = '';
				$this->data['end_ph_date'] = '';

				$condition = array('post_id' => $post_id,'phase' => '2');
				$ph_2 = $this->timeframe_model->get_data_by_condition('phases',$condition,'approve_by');
				if($ph_2){
					$this->data['end_ph_date'] = $ph_2[0]->approve_by;
				}
			}else if($this->data['phase_details']->phase == 2){
				$this->data['end_ph_date'] = '';
				$condition = array('post_id' => $post_id,'phase' => '1');
				$ph_1 = $this->timeframe_model->get_data_by_condition('phases',$condition,'approve_by');
				$this->data['pre_ph_date'] = $ph_1[0]->approve_by;

				$condition = array('post_id' => $post_id,'phase' => '3');
				$ph_3 = $this->timeframe_model->get_data_by_condition('phases',$condition,'approve_by');
				if($ph_3){
					$this->data['end_ph_date'] = $ph_3[0]->approve_by;
				}
			}else if($this->data['phase_details']->phase == 3){
				$condition = array('post_id' => $post_id,'phase' => '2');
				$ph_2 = $this->timeframe_model->get_data_by_condition('phases',$condition,'approve_by');
				$this->data['pre_ph_date'] = $ph_2[0]->approve_by;
				$this->data['end_ph_date'] = '';
			}		
			$brand_id = $this->data['phase_details']->brand_id;
			$this->data['brand_id'] = $brand_id;
			$this->data['brand'] = $this->brand_model->get_brand_by_id($brand_id);
			echo $this->load->view('approvals/edit_approval_phase' ,$this->data ,true);
		}
	}


	public function phase_user_list($phase_id)
	{
		$this->data['phase_users'] = $this->approval_model->get_phase_users($phase_id);
		$this->data['phase_details'] = $this->post_model->get_phase($phase_id);
		$brand_id = $this->data['phase_details']->brand_id;
		$this->data['brand_id'] = $brand_id;
		$this->data['users'] = $this->brand_model->get_approvers($brand_id);
		$this->data['brand'] = $this->brand_model->get_brand_by_id($brand_id);
		$post_phases= $this->post_model->get_post_phases($this->data['phase_details']->post_id);
		if(!empty($post_phases))
		{
			foreach($post_phases as $phase)
			{
				if($this->data['phase_details']->phase == $phase->phase){
					$this->data['phases']['selceted'][] = $phase->user_id;
				}else{
					$this->data['phases']['hidden'][] = $phase->user_id;
				}
			}
		}
		echo $this->load->view('approvals/phase_user_list', $this->data, TRUE);
	}

	function send_mail_pending_approvers()
	{
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$approvers = $this->approval_model->get_post_approvers($post_data['post_id'],'pending');
			if(!empty($approvers) AND isset($approvers['result']) AND !empty($approvers['result']))
			{
				$this->data['post_details'] = $this->post_model->get_post($approvers['result'][0]['post_id']);
				$this->data['owner_id'] = $approvers['owner_id'];
				foreach($approvers['result'] as $approver)
				{
					$user = $this->timeframe_model->get_data_by_condition('aauth_users',array('id' => $approver['user_id']),'email');					
					if(!empty($user))
					{
						$this->data['name'] = ucfirst($approver['first_name'].' '.ucfirst($approver['last_name']));						 
						$message = $this->load->view('mails/approve_post_request',$this->data,true);
						email_send($user[0]->email,'Approve post',$message);
					}
				}
			}
			echo "1";
		}
		else
		{
			echo "0";
		}
	}

	function edit_request_modal($post_id)
	{
		$this->data = array();
		$this->data['post_id'] = $post_id;
		$this->data['post_details'] = $this->post_model->get_post($post_id);
		$this->data['post_images'] = $this->post_model->get_images($post_id);

		$brand = $this->brand_model->get_users_brands($this->user_id,$this->data['post_details']->brand_id);
		$this->data['selected_tags'] = $this->post_model->get_post_tags($post_id);
		if(!empty($brand))
		{
			$this->data['phase'] = $this->approval_model->get_approval_phase($post_id,$this->user_id);
			//echo '<pre>'; print_r($this->data['phase']);echo '</pre>'; die;
			if(!empty($this->data['phase']))
			{
				$this->data['brand_id'] = $brand[0]->id;
				$this->data['brand'] = $brand[0];
				$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);
				// echo '<pre>'; print_r($this->data);echo '</pre>'; die;				
				echo $this->load->view('approvals/edit-request-modal', $this->data, TRUE);
		    }
	    }
	}

	function delete_suggest_edit()
	{
		$suggesion_id = $this->input->post('suggesion_id');
		if($suggesion_id)
		{
			$this->timeframe_model->delete_data('post_comments',array('id'=>$suggesion_id));
			echo "1";
		}
		else
		{
			echo "0";
		}
	}

	function approvals_menu()
	{
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);		
		if(!empty($brand))
		{
			$this->data['show_filter'] = 1;
			$this->data['brand'] = $brand[0];
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['view'] = 'approvals/approval_menu';
			$this->data['layout'] = 'layouts/new_user_layout';

	        _render_view($this->data);
	    }
	}

	function approvals_today()
	{
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);		
		if(!empty($brand))
		{
			$this->data['show_filter'] = 1;
			$approvals = $this->approval_model->get_approvals($this->user_id,$brand[0]->id,'',date('Y-m-d',strtotime('+1 days')));
			
			$this->data['approval_list'] = array();
			if(!empty($approvals))
			{							
				foreach($approvals as $approval)
				{
					$this->data['approval_list'][$approval->id] = $approval;
				}
			}
			
			$this->data['brand'] = $brand[0];
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['view'] = 'approvals/approvals_today';
			$this->data['layout'] = 'layouts/new_user_layout';

	        _render_view($this->data);
	    }
	}

	function approvals_week()
	{
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);		
		if(!empty($brand))
		{
			$this->data['show_filter'] = 1;
			$approvals = $this->approval_model->approvals_between_date($this->user_id,$brand[0]->id,date('Y-m-d'),date('Y-m-d',strtotime('+7 days')));
			
			$this->data['approval_list'] = array();
			if(!empty($approvals))
			{							
				foreach($approvals as $approval)
				{
					$this->data['approval_list'][$approval->id] = $approval;
				}
			}
			
			$this->data['brand'] = $brand[0];
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['view'] = 'approvals/approvals_week';
			$this->data['layout'] = 'layouts/new_user_layout';

	        _render_view($this->data);
	    }
	}

	function approvals_month()
	{
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);		
		if(!empty($brand))
		{
			$this->data['show_filter'] = 1;
			$approvals = $this->approval_model->approvals_between_date($this->user_id,$brand[0]->id,date('Y-m-d'),date('Y-m-d',strtotime('+1 month')));
			
			$this->data['approval_list'] = array();
			if(!empty($approvals))
			{							
				foreach($approvals as $approval)
				{
					$this->data['approval_list'][$approval->id] = $approval;
				}
			}
			
			$this->data['brand'] = $brand[0];
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['view'] = 'approvals/approvals_month';
			$this->data['layout'] = 'layouts/new_user_layout';

	        _render_view($this->data);
	    }
	}

	function approvals_outlet()
	{
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);		
		if(!empty($brand))
		{
			$this->data['show_filter'] = 1;
			$approvals = $this->approval_model->approvals_between_date($this->user_id,$brand[0]->id);
			
			$this->data['approval_list'] = array();
			if(!empty($approvals))
			{							
				foreach($approvals as $approval)
				{
					$this->data['approval_list'][$approval->id] = $approval;
				}
			}
			
			$this->data['outlets'] = $this->brand_model->get_brand_outlets($brand[0]->id);
			$this->data['brand'] = $brand[0];
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['view'] = 'approvals/approvals_outlet';
			$this->data['layout'] = 'layouts/new_user_layout';

	        _render_view($this->data);
	    }
	}

	function get_outlet_approvals()
	{
		$outlet_id = $this->input->post('outlet_id');
		$this->data['brand_id'] = $this->input->post('brand_id');
		$approvals = $this->approval_model->approvals_between_date($this->user_id,$this->data['brand_id'],'','',$outlet_id);

		$this->data['approval_list'] = array();
		if(!empty($approvals))
		{							
			foreach($approvals as $approval)
			{
				$this->data['approval_list'][$approval->id] = $approval;
			}
		}
		echo $this->load->view('mobile/approvals/approval_post',$this->data,true);
	}

	function get_approval_list()
	{
		$date = $this->input->post('date');
		$this->data['brand_id'] = $this->input->post('brand_id');
		$btn_clicked = $this->input->post('btn_clicked');
		$type = $this->input->post('type');
		if($type == 'today')
		{
			$start_date = $date;
			$end_date = $date;
			$previous = date('Y-m-d',strtotime($date.' -1 days'));
			$next = date('Y-m-d',strtotime($date.' +1 days'));			
			$current = date('F d, Y',strtotime($date));
		}

		if($type == 'week')
		{
			$start_date = date('Y-m-d',strtotime($date));
			$end_date = date('Y-m-d',strtotime($date.' +7 days'));
			$previous = date('Y-m-d',strtotime($date.' -8 days'));
			$next = date('Y-m-d',strtotime($date.' +8 days'));			
			$current = date('M d, Y',strtotime($date)).'-'.date('M d, Y', strtotime($date.'+7 days' ));
		}

		if($type == 'month')
		{
			$start_date = date('Y-m-d',strtotime($date));
			$end_date = date('Y-m-d',strtotime($date.' +1 month'));
			$previous = date('Y-m-d',strtotime($date.' -1 month'));
			$next = date('Y-m-d',strtotime($date.' +1 month'));			
			$current = date('F, Y',strtotime($date));
		}

		$approvals = $this->approval_model->approvals_between_date($this->user_id,$this->data['brand_id'],$start_date,$end_date);	

		$this->data['approval_list'] = array();
		if(!empty($approvals))
		{							
			foreach($approvals as $approval)
			{
				$this->data['approval_list'][$approval->id] = $approval;
			}
		}
		
		$date_header = '<div class="col-sm-12">';
		$date_header .= '<div class="pull-xs-left">';
		$date_header .= '<a href="#" data-date="'.$previous.'" class="next-date previous"><i class="fa fa-angle-left fa-custom-circle bg-black"></i></a>
				</div>
				<div class="pull-xs-right">
					<a href="#" data-date="'.$next.'" class="next-date next"><i class="fa fa-angle-right fa-custom-circle bg-black"></i></a>
				</div>
				<div class="center-title"><a href="#calendarSelectModal" data-toggle="modal">'.$current.'</a></div>
			</div>';

		$html = $this->load->view('mobile/approvals/approval_post',$this->data,true);
		echo json_encode(array('response' => $html,'date_header' => $date_header));
	}

	function view_approvals()
	{
		$post_id = $this->uri->segment(3);
		$post_phases = $this->post_model->get_post_phases($post_id);
		if(!empty($post_phases))
		{
			foreach($post_phases as $phase)
			{
				$this->data['phases'][$phase->phase][] = $phase;
			}
		}
		$this->data['post_details'] = $this->post_model->get_post($post_id);
		echo $this->load->view('mobile/approvals/approvals',$this->data,true);
	}

	function get_outlet_list()
	{
		$post_id = $this->uri->segment(3);
		$this->data['post'] = $this->timeframe_model->get_data_by_condition('posts',array('id' => $post_id),'brand_id,id,outlet_id');
		if(!empty($this->data['post']))
		{
			$this->load->model('post_model');			
			$this->data['outlets'] = $this->post_model->get_brand_outlets($this->data['post'][0]->brand_id);
			echo $this->load->view('mobile/approvals/oultet_list',$this->data,true);
		}
	}

	function save_post_outlet()
	{
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$this->timeframe_model->update_data('posts',array('outlet_id' => $post_data['post_outlet']),array('id' => $post_data['post_id']));
			$brand = $this->brand_model->get_brand_by_id($post_data['brand_id']);
			redirect(base_url().'posts/edit_post/approvals/'.$brand->slug.'/'.$post_data['post_id']);
		}
	}

	function get_brand_tags()
	{
		$post_id = $this->uri->segment(3);
		$this->data['post'] = $this->timeframe_model->get_data_by_condition('posts',array('id' => $post_id),'brand_id,id,outlet_id');
		if(!empty($this->data['post']))
		{
			$this->data['tags'] = $this->post_model->get_brand_tags($this->data['post'][0]->brand_id);
			$this->data['selected_tags'] = $this->post_model->get_post_tags($post_id);
			if(!empty($this->data['selected_tags']))
			{
				$this->data['selected_tags'] = object_to_array($this->data['selected_tags']);			
				$this->data['selected_tags'] = array_column($this->data['selected_tags'],'id');
			}
			echo $this->load->view('mobile/approvals/tag_list',$this->data,true);
		}
	}

	function save_post_tags()
	{
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			if(!empty($post_data['post_tag'])){

				$selected_tags = $this->post_model->get_post_tags($post_data['post_id']);
				
				$tags_to_add = isset($post_data['post_tag']) ? $post_data['post_tag']: array();

				if(!empty($selected_tags )){
					$selected_tags_ids = array_column($selected_tags,'id'); // list of selected tags ids
					
					$tags_to_add = array_diff($post_data['post_tag'],$selected_tags_ids); // new tags to add 
		        	
		        	$tags_to_delete = array_diff($selected_tags_ids,$post_data['post_tag']); // old tags that we want to remove 
		        	foreach ($tags_to_delete as $tag)
		        	{
		        		$condition = array('brand_tag_id' => $tag,'post_id' => $post_data['post_id']);
		        		$this->timeframe_model->delete_data('post_tags',$condition);
		        	}
				}
				
				foreach($tags_to_add as $tag)
    			{

    				$post_tag_data = array(
    										'post_id' => $post_data['post_id'],
    										'brand_tag_id' => $tag
    									);
    			
    				$this->timeframe_model->insert_data('post_tags',$post_tag_data);
    			}

			}

			$brand = $this->brand_model->get_brand_by_id($post_data['brand_id']);
			redirect(base_url().'posts/edit_post/approvals/'.$brand->slug.'/'.$post_data['post_id']);
		}
	}

	function save_mobile_post()
	{
		$post_data = $this->input->post();
		echo "<pre>";
		print_r($post_data);
		if(!empty($post_data))
		{
			if(!empty($post_data['delete_img']))
			{
				$delete_image_array = explode(',', $post_data['delete_img']);
				foreach($delete_image_array as $img)
				{
					$this->timeframe_model->delete_data('post_media',array('id' => $img));
				}
			}
		}
		if(!empty($post_data['images']))
		{
			$files = explode('___', $_POST['images']);
			if(!empty($files))
			{
				foreach($files as $file)
				{
					$image_name = uniqid().'.png';					
	    		  	$base64_str = substr($file, strpos($file, ",")+1);

		        	//decode base64 string
			        $decoded = base64_decode($base64_str);

			        //create jpeg from decoded base 64 string and save the image in the parent folder
			        if(!is_dir(upload_path().$this->user_data['account_id'].'/brands/'.$post_data['brand_id'].'/posts')){
			        	mkdir(upload_path().$this->user_data['account_id'].'/brands/'.$post_data['brand_id'].'/posts',0755,true);
			        }
			        echo $url = upload_path().$this->user_data['account_id'].'/brands/'.$post_data['brand_id'].'/posts'.$image_name;
			        $result = file_put_contents($url, $decoded);
			        // $source_url = imagecreatefrompng($url);

			        // header('Content-Type: image/png');
			        // imagepng($source_url, $url, 8);

			        $post_media_data = array(
											'post_id' 	=> $post_data['post_id'],
											'name' 		=> $image_name,
											'type' 		=> $post_data['type']
										);
			        if($post_data['type'] == 'images')
			        {
			        	$post_media_data['mime'] = 'image/jpeg';
			        }
			        else
			        {
			        	$post_media_data['mime'] = 'video/mp4';
			        }
					$this->timeframe_model->insert_data('post_media',$post_media_data);
				}
			}
		}		
		
	}
}