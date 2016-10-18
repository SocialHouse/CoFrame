<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {
	
	/**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
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
		$this->load->model('post_model');
		$this->load->model('user_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
	}

	public function day()
	{
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);
		$post_data = $this->input->post();
		// $this->session->set_userdata( 'selected_date' ,'2016-09-20');
		if(!empty($this->session->userdata('selected_date')))
		{
			$post_data['selected_date'] = $this->session->userdata('selected_date');
			$this->session->unset_userdata('selected_date');
		}
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

			if(check_user_perm($this->user_id,'view',$brand[0]->id))
			{
				$additional_group = $this->data['user_group'];
			}
			check_access('approve',$brand,$additional_group);

			$this->data['selected_date'] = '';
			if(isset($post_data) AND !empty($post_data))
			{
				$this->data['selected_date'] = $post_data['selected_date'];
			}
			else
			{
				$this->data['selected_date'] = date("Y-m-d");
			}
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['brand'] = $brand[0];
			$this->data['post_details'] = $this->post_model->get_post_by_date($brand[0]->id,$this->user_id,$this->data['selected_date']);
			$this->data['filters'] = $this->timeframe_model->get_data_by_condition('filters',array('user_id' => $this->user_id,'brand_id' => $brand[0]->id));
			$this->data['view_type'] = 'day_view';
			
					
			$this->data['css_files'] = array(css_url().'fullcalendar.css', 'https://fonts.googleapis.com/css?family=Roboto:400,500');
			$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'vendor/jquery.dotdotdot.min.js?ver=1.8.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0', js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'custom_validation.js?ver=1.0.0', js_url().'tumblr-preview.js?ver=1.0.0' );
			$this->data['view'] = 'calendar/day_view';
	        _render_view($this->data);
	    }
	}

	public function month()
    {
    	$this->data = array();
		$slug = $this->uri->segment(3);	
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

			if(check_user_perm($this->user_id,'view',$brand[0]->id))
			{
				$additional_group = $this->data['user_group'];
			}
			check_access('approve',$brand,$additional_group);

			$this->data['brand'] = $brand[0];
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['slug'] = $slug;

			$this->data['filters'] = $this->timeframe_model->get_data_by_condition('filters',array('user_id' => $this->user_id,'brand_id' => $brand[0]->id));

			$this->data['css_files'] = array(css_url().'fullcalendar.css');
			$this->data['view_type'] = 'month_view';
			$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'vendor/jquery.dotdotdot.min.js?ver=1.8.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0', js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'custom_validation.js?ver=1.0.0', js_url().'tumblr-preview.js?ver=1.0.0' );

			$this->data['view'] = 'calendar/month_view';
	        _render_view($this->data);
	    }
    }

    public function week()
    {
    	
    	$this->data = array();
		$slug = $this->uri->segment(3);	
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

			if(check_user_perm($this->user_id,'view',$brand[0]->id))
			{
				$additional_group = $this->data['user_group'];
			}
			check_access('approve',$brand,$additional_group);

			
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['brand'] = $brand[0];
			$this->data['slug'] = $slug;

			$this->data['filters'] = $this->timeframe_model->get_data_by_condition('filters',array('user_id' => $this->user_id,'brand_id' => $brand[0]->id));
			
			$this->data['css_files'] = array(css_url().'fullcalendar.css');
			$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'vendor/jquery.dotdotdot.min.js?ver=1.8.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0', js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'custom_validation.js?ver=1.0.0', js_url().'tumblr-preview.js?ver=1.0.0' );
			$this->data['view_type'] = 'week_view';
			$this->data['view'] = 'calendar/week_view';
	        _render_view($this->data);
	    }
    }

    public function get_events()
    {
    	$brand_id = $this->input->post('brand_id');
    	$outlets = $this->input->post('outlets');
    	$statuses = $this->input->post('statuses');
    	$start_date = $this->input->post('start');
    	$end_date = $this->input->post('end');
    	$tags =  $this->input->post('tags');
    	$posts = $this->post_model->get_posts_by_time($brand_id,$start_date,$end_date,$outlets,$statuses,$tags);
    	echo json_encode($posts);    	
    }

    public function post_filters()
    {
    	$this->data = array();
    	$brand_id = $this->uri->segment(3);
    	$this->data['brand_id'] = $brand_id;
    	if($this->user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND $this->user_data['user_group'] == "Master Admin"))
		{
			$this->data['outlets'] = $this->brand_model->get_brand_outlets($brand_id);
		}
		else
		{
			$this->data['outlets'] = $this->post_model->get_user_outlets($brand_id,$this->user_id);
		}
    	// $this->data['outlets'] = $this->post_model->get_brand_outlets($brand_id);
    	$this->data['tags'] = $this->post_model->get_brand_tags($brand_id);
    	$this->data['filters'] = $this->timeframe_model->get_data_array_by_condition('filters',array('brand_id' => $brand_id,'user_id' => $this->user_id));
    	
    	$mobile_view = 'mobile/';
        $this->load->library('user_agent');
        if($this->agent->is_mobile())
        {
            $mobile_view = 'mobile/';
        }
    	echo $this->load->view($mobile_view.'partials/post_filters',$this->data,true);
    }

    public function print_posts()
    {
    	$this->data['brand_id'] =$this->uri->segment(3);
    	$this->load->view('partials/print_posts',$this->data);
    }


    public function get_post_by_date()
    {
    	$brand_id = $this->input->post('brand_id');
    	$sdate = $this->input->post('sdate');
	    if(!empty($brand_id)){
	    	$this->data['post_details'] = $this->post_model->get_post_by_date($brand_id,$this->user_id,$sdate);
	    	echo $this->load->view('calendar/post_preview/day_post',$this->data,true);
	    }else{
	    	echo false;
	    }
    }

    public function get_view()
	{
		$this->data = '';
		$path = $this->uri->segment(3);

		if(!empty($path)){
			if($path == 'edit_menu' || $path == 'edit_date' ){
				$this->data['slug'] = $this->uri->segment(4);
				$this->data['post_id'] = $this->uri->segment(5);
				$this->data['user_is'] = $this->uri->segment(6) ? $this->uri->segment(6) : '';
				$this->data['post_details'] = $this->post_model->get_post($this->data['post_id']);
			}
			$this->load->library('user_agent');
			$this->data['is_mobile'] = 1;
			if($this->agent->is_mobile())
		    {
		    	$this->data['is_mobile'] = 1;
		    }
			$this->load->view('calendar/'.$path, $this->data);
		}
		else{

		}
	} 

	public function edit_post_calendar()
	{	
		$redirect_url = $this->uri->segment(3);
		if($redirect_url == 'drafts')
		{
			$this->data['redirect_url'] = 'drafts';
		}
		elseif($redirect_url == 'approvals')
		{
			$this->data['redirect_url'] = 'approvals';
		}
		else if($redirect_url == 'day')
		{
			$this->data['redirect_url'] = 'calendar/day';
		}
		else if($redirect_url == 'view_request')
		{
			$this->data['redirect_url'] = 'view-request';
		}
		else if($redirect_url == 'edit-request')
		{
			$this->data['redirect_url'] = 'edit-request';
		}
		else{
			$this->data['redirect_url'] = 'calendar/'.$redirect_url;
		}
		$this->data['slug'] = $this->uri->segment(4);
		$this->data['post_id'] = $this->uri->segment(5);
		$this->data['timezones'] = $this->user_model->get_timezones();

		foreach ($this->data['timezones']  as $key => $values) 
		{
			if($this->user_data['timezone'] == $values->value)
			{
				$this->data['user_timezone'] = array(
									'name' =>  $values->timezone,
									'value' => $values->value
									);
				unset($this->data['timezones'][$key]);
			}
		}



		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$this->data['slug']);
		if(!empty($brand))
		{
			$this->user_data['timezone'] = $brand[0]->timezone;
			$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['brand'] = $brand[0];
			$this->data['users'] = $this->brand_model->get_approvers($brand[0]->id);
			$this->data['tags'] = $this->post_model->get_brand_tags($brand[0]->id);

			if(!empty($this->data['post_id'])){
				$post_id = $this->data['post_id'];
				$post_details = $this->post_model->get_post($this->data['post_id']);
				$this->data['post_details'] = $post_details;
				$this->data['post_images'] = $this->post_model->get_images($post_id);
				// $this->data['outlets'] = $this->post_model->get_user_outlets($brand[0]->id,$this->user_id);
				if($this->user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND $this->user_data['user_group'] == "Master Admin"))
				{
					$this->data['outlets'] = $this->brand_model->get_brand_outlets($brand[0]->id);
				}
				else
				{
					$this->data['outlets'] = $this->post_model->get_user_outlets($brand[0]->id,$this->user_id);
				}
			
				$post_phases = $this->post_model->get_post_phases($post_id);
				$this->data['selected_tags'] = $this->post_model->get_post_tags($post_id);		
				if(!empty($post_phases))
				{
					foreach($post_phases as $phase)
					{
						$this->data['phases'][$phase->phase][] = $phase;
					}
				}
			}

			$this->data['css_files'] = array(css_url().'fullcalendar.css');
			$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0', js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'datepicker.js',js_url().'timepicker.js',js_url().'custom_validation.js?ver=1.0.0', js_url().'tumblr-preview.js?ver=1.0.0' );
			// echo '<pre>'; print_r($this->data['timezone_list']);echo '</pre>';
			$this->load->view('calendar/edit_post_calendar', $this->data);
		}
	}

	public function reschedule_post()
	{
		$sdate = '';
		$post_data = $this->input->post();

		$previous_post_details = $this->post_model->get_post($post_data['post_id']);
		$approvers = get_post_approvers($post_data['post_id']);
	
		$schedule_date = $post_data['post_date'].' '.add_leading_zero($post_data['post_hour']).':'.add_leading_zero($post_data['post_minute']).' '.$post_data['post_ampm'];
		$schedule_date = date("Y-m-d H:i", strtotime($schedule_date));
		$condition = array('id' => $post_data['post_id']);
		$scheduler_array = array('slate_date_time'=> $schedule_date,'updated_at' => date('Y-m-d H:i:s'));
		$result = $this->timeframe_model->update_data('posts',$scheduler_array,$condition);
		if($result)
		{
			$post_details = $this->post_model->get_post($post_data['post_id']);
			if(!empty($approvers) AND !empty($approvers['result']))
			{
				foreach($approvers['result'] as $approver)
				{
					$reminder_data = array(
	    								'post_id' => $post_data['post_id'],
	    								'user_id' => $approver['user_id'],
	    								'type' => 'reminder',
	    								'brand_id' => $post_details->brand_id,
	    								'due_date' => $approver['approve_by'],
	    								'text' => 'Date change: '.date('d/n g:i a',strtotime($post_details->slate_date_time)).' '.get_outlet_by_id($post_details->outlet_id).' post has been rescheduled to '.date('d/n g:i a',strtotime($schedule_date)).' by '.get_users_full_name($post_details->user_id),
	    								'phase_id' => $approver['id']
    								);

					$this->timeframe_model->insert_data('reminders',$reminder_data);
				}
			}

			if(!empty($post_data['selcted_data'])){
				$sdate = $post_data['selcted_data'];
			}
			$this->data['post_details'] = $this->post_model->get_post_by_date( $post_details->brand_id, $this->user_id, $sdate);
	    	echo $this->load->view('calendar/post_preview/day_post',$this->data,true);
		}else{
			echo 'false';
		}
	}

	public function get_brand_users_by_post($brand_id, $post_id,$phase_count)
	{
		$this->data = array();
		$this->data['phases'] = array();
		if(!empty($post_id)){
			$this->data['post_details'] =  $this->post_model->get_post($post_id);
			$post_phases = $this->post_model->get_post_phases($post_id);
			if(!empty($post_phases))
			{
				foreach($post_phases as $phase)
				{
					$this->data['phases'][$phase->phase][] = $phase;
				}
			}
			// $this->data['users'] = $this->brand_model->get_brand_users($brand_id);
			$this->data['users'] = $this->brand_model->get_approvers($brand_id);
			// echo "<pre>";
			// print_r($this->data['users']);
			// echo "</pre>";
			$this->data['current_phase'] = $phase_count;
			$this->data['brand_id'] = $brand_id;
			// echo '<pre>'; print_r($this->data);echo '</pre>'; 
		}
		echo $this->load->view('calendar/post_user_list',$this->data,true);
	}


	public function approval_list($post_id)
	{
		$this->data = array();
		if(!empty($post_id)){
			$post_phases = $this->post_model->get_post_phases($post_id);			
			if(!empty($post_phases))
			{
				foreach($post_phases as $phase)
				{
					if($phase->status == 'approved' ){
						$this->data['approved'][] = $phase;
					}
					if($phase->status == 'pending' ){
						$this->data['pending'][] = $phase;
					}
				}
			}
			//echo '<pre>'; print_r($this->data);echo '</pre>'; die;
			$this->load->view('calendar/approval_list', $this->data);			
		}
		
	}


	public function edit_post()
	{
		$this->data = array();
		$error = '';
		$uploaded_files = array();
		$post_data = $this->input->post();
		// echo '<pre>'; print_r($post_data);echo '</pre>'; die;
		if(!empty($post_data['post_id'])){

			$previous_post_details = $this->post_model->get_post($post_data['post_id']);

			$date_time =  $post_data['post-date'].' '.add_leading_zero($post_data['post-hour']).':'.add_leading_zero($post_data['post-minute']).' '.$post_data['post-ampm'];
		    $slate_date_time = date("Y-m-d H:i:s", strtotime($date_time));
		   /* if(!empty($post_data['post_outlet']))
    		{*/
				$condition = array('id' => $post_data['post_outlet']);
				$post_condition = array('id' => $post_data['post_id']);
				//$outlet_data = $this->timeframe_model->get_data_by_condition('outlets',$condition,'outlet_name');
				
				//  updates tags of posts (Add and delete tags )
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

				//  updates images of post (Add new images )
				if(isset($post_data['uploaded_files'][0]) AND !empty($post_data['uploaded_files'][0]))
				{
					$files = json_decode($post_data['uploaded_files'][0])->success;
				}

				if(!empty($post_data['delete_img']))
				{
					$delete_image_array = explode(',', $post_data['delete_img']);
					foreach($delete_image_array as $img)
					{
						$this->timeframe_model->delete_data('post_media',array('id' => $img));
					}
				}

	    		if(isset($files) AND !empty($files))
	    		{
	    			foreach($files as $file)
	    			{
	    				$post_media_data = array(
	    										'post_id' 	=> $post_data['post_id'],
	    										'name' 		=> $file->file,
	    										'type' 		=> $file->type,
	    										'mime'		=> $file->mime
	    									);

	    				$this->timeframe_model->insert_data('post_media',$post_media_data);
	    			}
	    		}
				
	        	// update the post data like contect and start date
				$post = array(
							'outlet_id' 		=> $post_data['post_outlet'],
    						'content'			=> $this->input->post('post_copy'),
    						'slate_date_time' 	=> $slate_date_time,
    						'time_zone' 		=>$post_data['time_zone'],
    						'updated_at' 		=>date("Y-m-d H:i:s")
    					);

				$outlet = strtolower(get_outlet_by_id($post_data['post_outlet']));
    				
				if($outlet == 'youtube')
				{
					$post['video_title'] = $post_data['ytVideoTitle'];
					$post['share_with'] = NULL;
					$post['pinterest_board'] = NULL;
					$post['pinterest_source'] = NULL;
				}

				if($outlet == 'linkedin')
				{
					$post['share_with'] = $post_data['shareWithLinkedin'];
					$post['video_title'] = NULL;
					$post['pinterest_board'] = NULL;
					$post['pinterest_source'] = NULL;
				}

				if($outlet == 'pinterest')
				{
					$post['pinterest_board'] = $post_data['pinterestBoard'];
					$post['pinterest_source'] = $post_data['pinSource'];
					$post['share_with'] = NULL;
					$post['video_title'] = NULL;
				}

				if($outlet == 'tumblr')
				{
					if($post_data['tumblrContent'] == 'Text')
					{
						$post['tumblr_title'] = $post_data['tb_text_title'];
    					$post['tumblr_text_content'] = $post_data['tumblr_post_copy'];
    					$post['tumblr_tags'] = $post_data['tb_text_tags'];
    					$post['tumblr_custom_url'] = $post_data['tb_text_url'];
    					
    					$post['tumblr_caption'] = NULL;
    					$post['tumblr_content_source'] = NULL;
    					$post['tumblr_quote'] = NULL;
    					$post['tumblr_source'] = NULL;
    					$post['tumblr_link'] = NULL;
    					$post['tumblr_link_description'] = NULL;
    					$post['tumblr_chat_title'] = NULL;
    					$post['tumblr_chat'] = NULL;
    					$post['tumblr_audio_description'] = NULL;
    					$post['tumblr_source'] = NULL;
    					$post['tumblr_video_caption'] = NULL;
					}
					elseif($post_data['tumblrContent'] == 'Photo')
					{
    					$post['tumblr_tags'] = $post_data['tbCaption'];
    					$post['tumblr_caption'] = $post_data['tb_photo_tags'];
    					$post['tumblr_content_source'] = $post_data['tbPhotoSource'];

    					$post['tumblr_title'] = NULL;
    					$post['tumblr_text_content'] = NULL;
    					$post['tumblr_custom_url'] = NULL;
    					$post['tumblr_quote'] = NULL;
    					$post['tumblr_source'] = NULL;
    					$post['tumblr_link'] = NULL;
    					$post['tumblr_link_description'] = NULL;
    					$post['tumblr_chat_title'] = NULL;
    					$post['tumblr_chat'] = NULL;
    					$post['tumblr_audio_description'] = NULL;
    					$post['tumblr_source'] = NULL;
    					$post['tumblr_video_caption'] = NULL;
					}
					elseif($post_data['tumblrContent'] == 'Quote')
					{

    					$post['tumblr_tags'] = $post_data['tb_quote_tags'];
    					$post['tumblr_custom_url'] = $post_data['tb_quote_url'];
    					$post['tumblr_quote'] = $post_data['tumblr_quote_post_copy'];
    					$post['tumblr_source'] = $post_data['tbSource'];

    					$post['tumblr_title'] = NULL;
    					$post['tumblr_text_content'] = NULL;
    					$post['tumblr_caption'] = NULL;
    					$post['tumblr_content_source'] = NULL;
    					$post['tumblr_link'] = NULL;
    					$post['tumblr_link_description'] = NULL;
    					$post['tumblr_chat_title'] = NULL;
    					$post['tumblr_chat'] = NULL;
    					$post['tumblr_audio_description'] = NULL;
    					$post['tumblr_video_caption'] = NULL;
					}
					elseif($post_data['tumblrContent'] == 'Link')
					{
    					$post['tumblr_link'] = $post_data['tbLink'];
    					$post['tumblr_custom_url'] = $post_data['tb_link_url'];
    					$post['tumblr_link_description'] = $post_data['tbLinkDesc'];

    					$post['tumblr_title'] = NULL;
    					$post['tumblr_text_content'] = NULL;
    					$post['tumblr_tags'] = NULL;
    					$post['tumblr_caption'] = NULL;
    					$post['tumblr_content_source'] = NULL;
    					$post['tumblr_quote'] = NULL;
    					$post['tumblr_source'] = NULL;
    					$post['tumblr_chat_title'] = NULL;
    					$post['tumblr_chat'] = NULL;
    					$post['tumblr_audio_description'] = NULL;
    					$post['tumblr_source'] = NULL;
    					$post['tumblr_video_caption'] = NULL;
					}
					elseif($post_data['tumblrContent'] == 'Chat')
					{
    					$post['tumblr_tags'] = $post_data['tb_chat_tags'];
    					$post['tumblr_custom_url'] = $post_data['tb_chat_url'];
    					$post['tumblr_chat_title'] = $post_data['tb_chat_title'];
    					$post['tumblr_chat'] = $post_data['tumblr_chat_post_copy'];

    					$post['tumblr_title'] = NULL;
    					$post['tumblr_text_content'] = NULL;
    					$post['tumblr_caption'] = NULL;
    					$post['tumblr_content_source'] = NULL;
    					$post['tumblr_quote'] = NULL;
    					$post['tumblr_source'] = NULL;
    					$post['tumblr_link'] = NULL;
    					$post['tumblr_link_description'] = NULL;
    					$post['tumblr_audio_description'] = NULL;
    					$post['tumblr_source'] = NULL;
    					$post['tumblr_video_caption'] = NULL;
					}
					elseif($post_data['tumblrContent'] == 'Audio')
					{
    					$post['tumblr_tags'] = $post_data['tb_audio_tags'];
    					$post['tumblr_custom_url'] = $post_data['tb_audio_url'];
    					$post['tumblr_audio_description'] = $post_data['tbAudioDescr'];

    					$post['tumblr_title'] = NULL;
    					$post['tumblr_text_content'] = NULL;
    					$post['tumblr_caption'] = NULL;
    					$post['tumblr_content_source'] = NULL;
    					$post['tumblr_quote'] = NULL;
    					$post['tumblr_source'] = NULL;
    					$post['tumblr_link'] = NULL;
    					$post['tumblr_link_description'] = NULL;
    					$post['tumblr_chat_title'] = NULL;
    					$post['tumblr_chat'] = NULL;
    					$post['tumblr_source'] = NULL;
    					$post['tumblr_video_caption'] = NULL;
					}
					elseif($post_data['tumblrContent'] == 'Video')
					{
    					$post['tumblr_tags'] = $post_data['tb_video_tags'];
    					$post['tumblr_custom_url'] = $post_data['tb_video_url'];
    					$post['tumblr_source'] = $post_data['tbVideoSource'];
    					$post['tumblr_video_caption'] = $post_data['tbVideoDescr'];

    					$post['tumblr_title'] = NULL;
    					$post['tumblr_text_content'] = NULL;
    					$post['tumblr_caption'] = NULL;
    					$post['tumblr_content_source'] = NULL;
    					$post['tumblr_quote'] = NULL;
    					$post['tumblr_link'] = NULL;
    					$post['tumblr_link_description'] = NULL;
    					$post['tumblr_chat_title'] = NULL;
    					$post['tumblr_chat'] = NULL;
    					$post['tumblr_audio_description'] = NULL;
					}

					$post['tumblr_content_type'] = $post_data['tumblrContent'];
					$post['share_with'] = NULL;
					$post['pinterest_board'] = NULL;
					$post['pinterest_source'] = NULL;
					$post['video_title'] = NULL;
				}
				else
				{
					$post['tumblr_tags'] = NULL;
					$post['tumblr_custom_url'] = NULL;
					$post['tumblr_source'] = NULL;
					$post['tumblr_video_caption'] = NULL;
					$post['tumblr_title'] = NULL;
					$post['tumblr_text_content'] = NULL;
					$post['tumblr_caption'] = NULL;
					$post['tumblr_content_source'] = NULL;
					$post['tumblr_quote'] = NULL;
					$post['tumblr_link'] = NULL;
					$post['tumblr_link_description'] = NULL;
					$post['tumblr_chat_title'] = NULL;
					$post['tumblr_chat'] = NULL;
					$post['tumblr_audio_description'] = NULL;
					$post['tumblr_content_type'] = NULL;
				}

				//  fetch all phases of post
				$post_phases = $this->post_model->get_post_phases($post_data['post_id']);
				if(!empty($post_phases))
				{
					foreach($post_phases as $phase)
					{
						$this->data['phases'][$phase->phase][] = $phase->user_id;
					}
				}

				$ph_number;
				if(!empty($post_data['phase'])){
				
					foreach($post_data['phase'] as $ph => $new_phase){
						$ph_number = $ph+1;
						$user_to_add = '';
						$user_to_delete = '';
						$current_phase_id= '';
						if(!empty($new_phase['approver'])){
							
							if(!empty($this->data['phases'][$ph_number])){
								$user_to_add = array_diff($new_phase['approver'],$this->data['phases'][$ph_number]); 
								$current_phase_id = $new_phase['phase_id'];
								$user_to_delete = array_diff($this->data['phases'][$ph_number], $new_phase['approver']); // old tags that we want to remove 

								// Insert new phase 
								if(!empty($user_to_add)){
									foreach ($user_to_add as $newuser) {
										$phasesdata = '';
										$phasesdata = array(
		    										'phase_id' 	=> $current_phase_id,
		    										'user_id' 	=> $newuser
		    									);
										$this->timeframe_model->insert_data('phases_approver',$phasesdata);
									}
								}

								// delete old phase  
								if(!empty($user_to_delete)){
									foreach ($user_to_delete as $olduser) {
										$phasesdata = '';
										$phasescondition= array(
		    										'phase_id' 	=> $current_phase_id,
		    										'user_id' 	=> $olduser
		    									);
										$this->timeframe_model->delete_data('phases_approver',$phasescondition);
									}
								}
							}
							else
							{
								// add new phase and users  
								$phase_data = '';
								$hour = !empty($new_phase['approve_hour'])? $new_phase['approve_hour'] :'';
								$minute = !empty($new_phase['approve_minute'])? $new_phase['approve_minute'] :'';
								$ampm = !empty($new_phase['approve_ampm'])? $new_phase['approve_ampm'] :'am';
								$date_time = !empty($new_phase['approve_date'])? $new_phase['approve_date'] :'';
								$date_time =  $date_time.' '.add_leading_zero($hour).':'.add_leading_zero($minute).' '.$ampm;

								$approve_date_time = date("Y-m-d H:i:s", strtotime($date_time));
								// insert new phase 
								$phase_data = array(
		    										'phase' 	=> $ph_number,
		    										'brand_id' 	=> $post_data['brand_id'],
		    										'post_id' 	=>$post_data['post_id'],
		    										'approve_by'=> $approve_date_time,
			    									'note' 		=> $new_phase['note'],
			    									'time_zone' => $new_phase['time_zone']
		    									);
		    					$phase_insert_id = $this->timeframe_model->insert_data('phases',$phase_data);

		    					// add users to newly added phase 
								foreach ($new_phase['approver'] as $value) {
									$phasesdata = '';
									$phasesdata = array(
		    										'phase_id' 	=> $phase_insert_id,
		    										'user_id' 	=> $value
		    									);
								$this->timeframe_model->insert_data('phases_approver',$phasesdata);
								}
							}

							// update the phase information 

							$phase_data = '';
							$hour = !empty($new_phase['approve_hour'])? $new_phase['approve_hour'] :'';
							$minute = !empty($new_phase['approve_minute'])? $new_phase['approve_minute'] :'';
							$ampm = !empty($new_phase['approve_ampm'])? $new_phase['approve_ampm'] :'am';
							$date_time = !empty($new_phase['approve_date'])? $new_phase['approve_date'] :'';
							$date_time =  $date_time.' '.add_leading_zero($hour).':'.add_leading_zero($minute).' '.$ampm;

							$approve_date_time = date("Y-m-d H:i:s", strtotime($date_time));

							if(!empty($post_data['resubmit'])){

								$phase_data = array(
	    										'status' => 'pending',
	    									);
								$this->timeframe_model->update_data('phases_approver',$phase_data,array('phase_id' => $new_phase['phase_id']));

								$this->timeframe_model->update_data('posts',$phase_data,array('id' => $post_data['post_id']));

								$post['status'] = 'pending';

								$reminder_users = get_phase_users($new_phase['phase_id']);

								// add reminder 
								if(!empty($reminder_users)){
									foreach ($reminder_users as $key => $objs) {
										$reminder_data = array(
											'post_id' 	=> $post_data['post_id'],
											'user_id' 	=> $objs->aauth_user_id,
											'type' 		=> 'reminder',
											'brand_id' 	=> $post_data['brand_id'],
											'due_date' 	=> $approve_date_time,
											'text' 		=> 'The approval process of '.get_outlet_by_id($previous_post_details->outlet_id).'  has been reset '.date('d/n g:i a',strtotime($slate_date_time)),
											'phase_id'  => $new_phase['phase_id']
											);
										$this->timeframe_model->insert_data('reminders',$reminder_data);
									}
								}
								
							}
							
							if(!empty($new_phase['phase_id'])){
								$ph_condition ='';
								$ph_condition = array('id' =>$new_phase['phase_id'] );	
								$phase_data['approve_by'] = $approve_date_time;
			    				$phase_data['note'] = $new_phase['note'];
			    				$phase_data['time_zone'] = $new_phase['time_zone'];
								
		    					$phase_insert_id = $this->timeframe_model->update_data('phases',$phase_data,$ph_condition);

							}
						}else{
							if(!empty($new_phase['phase_id'])){
								$phasescondition = '';
								$phasescondition = array(
		    										'id' => $new_phase['phase_id'],
		    									);
								$this->timeframe_model->delete_data('phases',$phasescondition);
								if(!empty($new_phase['approver'])){
									$phasescondition = '';
									$phasescondition = array(
			    										'phase_id' => $new_phase['phase_id'],
			    									);
									$this->timeframe_model->delete_data('phases_approver',$phasescondition);
								}
							}
						}
					}					
				}
				if($post_data['save_as'] == 'draft')
				{
					$post['status'] = 'draft';
				}
				$result = $this->timeframe_model->update_data('posts', $post, $post_condition);
				$this->session->set_flashdata('message','Post has been updated successfuly.');
				
				if($post_data['redirect_url']== 'view-request' || $post_data['redirect_url']== 'edit-request' ){
					redirect(base_url().$post_data['redirect_url'].'/'.$post_data['post_id']);
				}else{
					redirect(base_url().$post_data['redirect_url'].'/'.$post_data['brand_slug']);
				}
		}
	}

	public function selected_tag_list($brand_id, $post_id)
	{
		if(!empty($post_id)){
			$this->data['tags'] = $this->post_model->get_brand_tags($brand_id);
			$this->data['selected_tags'] = $this->post_model->get_post_tags($post_id);
    		echo $this->load->view('calendar/selected_tag_list',$this->data,true);
		}
	}

	function save_filters()
	{
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$save_data = [];
			if(!empty($post_data['tags']))
				$save_data['tags'] = implode(',',$post_data['tags']);
			if(!empty($post_data['outlets']))
				$save_data['outlets'] = implode(',',$post_data['outlets']);
			if(!empty($post_data['statuses']))
				$save_data['statuses'] = implode(',',$post_data['statuses']);
		
			$save_data['brand_id'] = $post_data['brand_id'];
			$save_data['user_id'] = $this->user_id;
			if(!empty($post_data['filter_id']))
			{
				if(empty($post_data['tags']) AND empty($post_data['outlets']) AND empty($post_data['statuses']))
				{
					$this->timeframe_model->delete_data('filters',array('id' => $post_data['filter_id']));
				}
				else
					$this->timeframe_model->update_data('filters',$save_data,array('id' => $post_data['filter_id']));
			}
			else
			{
				$this->timeframe_model->insert_data('filters',$save_data);
			}

			echo "1";
		}
	}

	function reset_filter()
	{
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$this->timeframe_model->delete_data('filters',array('id' => $post_data['filter_id']));
		}
		echo "1";
	}

	function reschedule()
	{
		echo $this->load->view('calendar/reschedule','',true);
	}

	function save_reschedule()
	{
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$previous_post_details = $this->post_model->get_post($post_data['post_id']);
			$approvers = get_post_approvers($post_data['post_id']);

			$date_time =  $post_data['post_date'].' '.add_leading_zero($post_data['post_hour']).':'.add_leading_zero($post_data['post_minute']).' '.$post_data['post_ampm'];
			
			$save_data = array(
							'slate_date_time' => date('Y-m-d H:i:s',strtotime($date_time)),
							'updated_at' => date('Y-m-d H:i:s')
						);
			$this->timeframe_model->update_data('posts',$save_data,array('id' => $post_data['post_id']));

			if(!empty($approvers) AND !empty($approvers['result']))
			{
				$post_details = $this->post_model->get_post($post_data['post_id']);
				foreach($approvers['result'] as $approver)
				{
					$reminder_data = array(
	    								'post_id' => $post_data['post_id'],
	    								'user_id' => $approver['user_id'],
	    								'type' => 'reminder',
	    								'brand_id' => $post_details->brand_id,
	    								'due_date' => $approver['approve_by'],
	    								'text' => 'Date change: '.date('d/n g:i a',strtotime($post_details->slate_date_time)).' '.get_outlet_by_id($post_details->outlet_id).' post has been rescheduled to '.date('d/n g:i a',strtotime($date_time)).' by '.get_users_full_name($post_details->user_id),
	    								'phase_id' => $approver['id']
    								);
					$this->timeframe_model->insert_data('reminders',$reminder_data);
				}
			}
		}
	}
}