<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
use OpenTok\OpenTok;

class Co_create extends CI_Controller {

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
		$this->load->config('opentok');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');		
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
	}	

	public function create()
	{		
		$this->data = array();
		$slug = $this->uri->segment(3);
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);

		if(!empty($brand))
		{
			$brand_id = $brand[0]->id;
			$this->data['slug'] = $slug;
			$this->data['users'] = $this->brand_model->get_approvers($brand_id);
			$this->user_data['timezone'] = $brand[0]->timezone;
			$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);
		
			$brand_id = $brand[0]->id;			

			$this->data['brand_id'] = $brand_id;
			$this->data['brand'] = $brand[0];
			$this->data['view'] = 'co_create/co-create';
			$this->data['layout'] = 'layouts/new_user_layout';
			$this->data['background_image'] = 'bg-brand-management.jpg';
			$this->data['css_files'] = array(css_url().'fullcalendar.css', css_url().'chat.css');
			$this->data['js_files'] = array(js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0');

			_render_view($this->data);
		}
	}

	function cocreate_post()
	{
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$request_string = $this->uri->segment(4);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);

		if(!empty($brand))
		{
			$this->user_data['timezone'] = $brand[0]->timezone;
			$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);
			$this->data['full_name'] = ucfirst($this->user_data['first_name']).' '.ucfirst($this->user_data['last_name']);
			$brand_id = $brand[0]->id;

			$path = img_url()."default_profile.jpg";
			if(file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$this->user_id.'.png'))
			{
				$path = upload_url().$this->user_data['img_folder'].'/users/'.$this->user_id.'.png';
			}

			$connection_metadata = ucfirst($this->user_data['first_name']).",".$this->user_id.",".$path;			

			$opentok = new OpenTok($this->config->item('opentok_key'), $this->config->item('opentok_secret'));					

			$generate_new_session = 1;			
			if(!empty($request_string))
			{
				$request = $this->timeframe_model->get_data_by_condition('co_create_requests', array('request_string' => $request_string,'brand_slug' => $slug));
				if(!empty($request) AND !empty($request[0]->session_id))
				{					
					$generate_new_session = 0;
					$this->data['sessionId'] = $request[0]->session_id;
					$this->data['req_id'] = $request[0]->id;
					
					if($request[0]->user_id == $this->user_id)
					{
						$this->data['is_sender'] = true;

						$cocreate_post_info = $this->timeframe_model->get_data_by_condition('cocreate_post_info',array('request_id' => $request[0]->id),'id');
						if(!empty($cocreate_post_info))
						{
							$this->timeframe_model->delete_data('cocreate_post_media',array('cocreate_post_id' => $cocreate_post_info[0]->id));
							$this->timeframe_model->delete_data('cocreate_approvers',array('cocreate_post_id' => $cocreate_post_info[0]->id));
							$this->timeframe_model->delete_data('cocreate_post_info',array('request_id' => $request[0]->id));							
						}
					}
							
					$this->data['token'] = $opentok->generateToken($this->data['sessionId'],array('user_id'=> $this->user_id,'data' => $connection_metadata));
			    }
			}

			if($generate_new_session == 1)
			{
				$is_request = $this->timeframe_model->get_data_by_condition('co_create_requests', array('user_id' => $this->user_id,'account_id' => $this->user_data['account_id'], 'brand_slug' => $slug,'request_string' => $request_string));
		        if(empty($is_request) OR (!empty($is_request) AND empty($is_request[0]->session_id)))
		        {
			        $session = $opentok->createSession();
			        $this->data['sessionId'] = $session->getSessionId();
			        $this->data['req_id'] = $is_request[0]->id;
					$this->data['token'] = $opentok->generateToken($this->data['sessionId'],array('data' => $connection_metadata));
		        
		       
			        $request_data = array(
			        		'session_id' => $this->data['sessionId'],
			        	);

			        $this->timeframe_model->update_data('co_create_requests',$request_data,array('request_string' => $request_string));
			        $this->data['request_string'] = $request_string;
			    }
			    else
			    {
			    	$this->data['req_id'] = $is_request[0]->id;
			    	$this->data['sessionId'] = $is_request[0]->session_id;
			        $this->data['token'] = $opentok->generateToken($this->data['sessionId'],array('data' => $connection_metadata));
			        $this->data['request_string'] = $is_request[0]->request_string;
			    }

			    if($is_request[0]->user_id == $this->user_id)
				{
					$this->data['is_sender'] = true;
				}
		    }

		    $this->load->model('user_model');
		    $this->data['users'] = $this->brand_model->get_approvers($brand_id);
			if($this->user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND $this->user_data['user_group'] == "Master Admin"))
			{
				$this->data['outlets'] = $this->brand_model->get_brand_outlets($brand_id);
			}
			else
			{
				$this->data['outlets'] = $this->post_model->get_user_outlets($brand_id,$this->user_id);
			}
			$this->data['tags'] = $this->post_model->get_brand_tags($brand_id);
			$this->data['brand_id'] = $brand_id;
			$this->data['brand'] = $brand[0];
			$this->data['timezones'] = $this->user_model->get_timezones();
			foreach ($this->data['timezones']  as $key => $values) 
			{
				if($this->data['brand']->timezone  == $values->value)
				{
					$this->data['brand_timezone'] = array(
											'name' =>  $values->timezone,
											'value' => $values->value
											);
					unset($this->data['timezones'] [$key]);
				}
				
				if($this->user_data['timezone'] == $values->value)
				{
					$this->data['user_timezone'] = array(
										'name' =>  $values->timezone,
										'value' => $values->value
										);
					if($this->data['brand']->timezone  != $this->user_data['timezone'] )
					{
						unset($this->data['timezones'] [$key]);
					}
				}
			}
				
			if(isset($this->data['req_id']) AND !empty($this->data['req_id']) AND !isset($this->data['is_sender']))
			{
				$this->data['is_cocreate'] = true;				
				$this->data['post_images'] = [];
				if(!empty($this->data['post_details']))
				{
					$this->data['post_images'] = $this->post_model->get_cocreate_images($this->data['post_details']->id);
					$this->data['post_details'] = $this->post_model->get_cocreate_post($this->data['req_id']);
				}
				
			}
			if(isset($this->data['req_id']) AND !empty($this->data['req_id']))
			{
				$this->data['view'] = 'co_create/cocreate_post';
				$this->data['layout'] = 'layouts/new_user_layout';
				$this->data['background_image'] = 'bg-brand-management.jpg';
				$this->data['css_files'] = array(css_url().'fullcalendar.css', css_url().'chat.css');
				$this->data['js_files'] = array(js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'custom_validation.js?ver=1.0.0','https://static.opentok.com/v2/js/opentok.js','https://apis.google.com/js/api.js',js_url().'co-create.js?ver=1.0.0');

				_render_view($this->data);
			}
			else
			{
				redirect(base_url().'co_create/create/'.$slug);
			}
		}
	}

	public function send_join_request()
	{
		$post_data = $this->input->post();

		if(!empty($post_data))
		{
			if(!empty($post_data['selected_users']))
			{
				$this->timeframe_model->insert_data('co_create_requests',array('request_string' => $post_data['request_string'],'brand_slug' => $post_data['slug'],'user_id' => $this->user_id,'account_id' => $this->user_data['account_id']));

				$subject = "Co create request";
				$this->data['url'] = base_url()."join-co-create/".$post_data['slug']."/".$post_data['request_string'];
				$message = $this->load->view('mails/join_co_create',$this->data,true);
				foreach($post_data['selected_users'] as $email)
				{
					$user_id = $this->aauth->get_user_id($email);

					$reminder_data = array(
		    								'user_id' => $user_id,
		    								'type' => 'reminder',
		    								'brand_id' => $post_data['brand_id'],
		    								'due_date' => date('Y-m-d H:i:s',strtotime('+1 days')),
		    								'text' => 'Please join cocreate here <a href="'.base_url().'co_create/join_co_create/'.$this->user_data['account_id'].'/'.$post_data['slug'].'/'.$post_data['request_string'].'"> '.base_url().'co_create/join_co_create/'.$this->user_data['account_id'].'/'.$post_data['slug'].'/'.$post_data['request_string'].'</a>'
		    							);

					$this->timeframe_model->insert_data('reminders',$reminder_data);

					email_send($email,$subject,$message);
				}
			}			
		}
	}

	function join_co_create()
	{
		$account_id = $this->uri->segment(3);	
		$slug = $this->uri->segment(4);	
		$request_string = $this->uri->segment(5);

		if($account_id && $slug && $request_string)
		{
			$this->timeframe_model->delete_data('reminders',array('text like' => '%'.base_url(uri_string()).'%','user_id' => $this->user_id));

			$session_data = $this->user_data;
			
			$check_user = $this->timeframe_model->check_user_is_account_user($account_id);
            if($check_user)
            {
                $session_data['user_group'] = $check_user;               
            }
            $session_data['account_id'] = $account_id;

			$session_data['plan'] = strtolower(get_plan($account_id));

			$this->session->set_userdata('user_info',$session_data);
            redirect(base_url().'co_create/cocreate_post/'.$slug.'/'.$request_string);
		}		
	}

	function save_cocreate_info()
	{
		$this->data = array();
		$error = '';
		$uploaded_files = array();
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			if(!empty($post_data['brand_id']))
			{
				$slate_date_time = '';
				if(!empty($post_data['post-date']) && !empty($post_data['post-hour']) && !empty($post_data['post-minute']) && !empty($post_data['post-ampm'])){
					$date_time =  $post_data['post-date'].' '.add_leading_zero($post_data['post-hour']).':'.add_leading_zero($post_data['post-minute']).' '.$post_data['post-ampm'];
		    		$slate_date_time = date("Y-m-d H:i:s", strtotime($date_time));
				}


		    	if(!empty($post_data['post_outlet']))
	    		{
    				$condition = array('id' => $post_data['post_outlet']);
					$outlet_data = $this->timeframe_model->get_data_by_condition('outlets',$condition,'outlet_name');

					$status = 'pending';
					if($post_data['save_as'] == 'draft')
					{
						$status = 'draft';
					}

    				$post = array(
	    						'content' => $this->input->post('post_copy'),
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id
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
    						$post = array(
	    						'tumblr_title' => $post_data['tb_text_title'],
	    						'tumblr_text_content' => $post_data['tumblr_post_copy'],
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'tumblr_tags' => $post_data['tb_text_tags'],
	    						'tumblr_custom_url' => $post_data['tb_text_url']
	    					);
    					}
    					elseif($post_data['tumblrContent'] == 'Photo')
    					{
    						$post = array(	    						
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'tumblr_tags' => $post_data['tb_photo_tags'],
	    						'tumblr_caption' => $post_data['tbCaption'],
	    						'tumblr_content_source' => $post_data['tbPhotoSource']
	    					);
    					}
    					elseif($post_data['tumblrContent'] == 'Quote')
    					{
    						$post = array(	    						
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'tumblr_tags' => $post_data['tb_quote_tags'],
	    						'tumblr_custom_url' => $post_data['tb_quote_url'],
	    						'tumblr_quote' => $post_data['tumblr_quote_post_copy'],
	    						'tumblr_source' => $post_data['tbSource']
	    					);
    					}
    					elseif($post_data['tumblrContent'] == 'Link')
    					{
    						$post = array(	    						
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'tumblr_link' => $post_data['tbLink'],
	    						'tumblr_custom_url' => $post_data['tb_link_url'],
	    						'tumblr_link_description' => $post_data['tbLinkDesc']
	    					);
    					}
    					elseif($post_data['tumblrContent'] == 'Chat')
    					{
    						$post = array(	    						
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'tumblr_tags' => $post_data['tb_chat_tags'],
	    						'tumblr_custom_url' => $post_data['tb_chat_url'],
	    						'tumblr_chat_title' => $post_data['tb_chat_title'],
	    						'tumblr_chat' => $post_data['tumblr_chat_post_copy'],
	    					);
    					}
    					elseif($post_data['tumblrContent'] == 'Audio')
    					{
    						$post = array(	    						
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'tumblr_tags' => $post_data['tb_audio_tags'],
	    						'tumblr_custom_url' => $post_data['tb_audio_url'],
	    						'tumblr_audio_description' => $post_data['tbAudioDescr']
	    					);
    					}
    					elseif($post_data['tumblrContent'] == 'Video')
    					{
    						$post = array(	    						
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'tumblr_tags' => $post_data['tb_video_tags'],
	    						'tumblr_custom_url' => $post_data['tb_video_url'],
	    						'tumblr_source' => $post_data['tbVideoSource'],
	    						'tumblr_video_caption' => $post_data['tbVideoDescr']
	    					);
    					}

    					$post['tumblr_content_type'] = $post_data['tumblrContent'];
    				}
    				

    				if(!empty($slate_date_time)){
    					$post['slate_date_time'] =  $slate_date_time;
    				}

    				$post['request_id'] = $post_data['co_create_req_id'];

    				if(isset($post_data['cocreate_info_id']) AND !empty($post_data['cocreate_info_id']))
    				{
    					$inserted_id = $post_data['cocreate_info_id'];
    					$this->timeframe_model->update_data('cocreate_post_info',$post,array('id' => $post_data['cocreate_info_id']));
    				}
    				else
    				{
    					$inserted_id = $this->timeframe_model->insert_data('cocreate_post_info',$post);
    				}

    				$approver_html = '';
    				$participant_html = '';
    				if($inserted_id)
			    	{
			    		if(!empty($post_data['post_tag']))
			    		{
			    			foreach($post_data['post_tag'] as $tag)
			    			{
			    				$post_tag_data = array(
			    										'post_id' => $inserted_id,
			    										'brand_tag_id' => $tag
			    									);
			    			
			    				$this->timeframe_model->insert_data('post_tags',$post_tag_data);
			    			}
			    		}
	    				if(isset($post_data['uploaded_files'][0]) AND !empty($post_data['uploaded_files'][0]) AND $post_data['uploaded_files'][0] !== ' ')
						{
	    					$files = json_decode($post_data['uploaded_files'][0])->success;
	    				}

	    				$media = $this->timeframe_model->get_data_array_by_condition('cocreate_post_media',array('cocreate_post_id' => $inserted_id),'name');
	    				if(!empty($media))
	    				{
	    					$media_array = array_column($media,'name');
	    					if(!empty($media_array))
	    					{
	    						foreach($media_array as $media_file)
	    						{
	    							delete_file(upload_path().$this->user_data['account_id'].'/brands/'.$post_data['brand_id'].'/posts/co_create/'.$media_file);
	    						}
	    					}
	    					
	    				}

	    				$this->timeframe_model->delete_data('cocreate_post_media',array('cocreate_post_id' => $inserted_id));
	    				
			    		if(isset($files) AND !empty($files))
			    		{			    			
			    			foreach($files as $file)
			    			{
			    				$post_media_data = array(
			    										'cocreate_post_id' => $inserted_id,
			    										'name' => $file->file,
			    										'type' => $file->type,
			    										'mime' => $file->mime
			    									);

			    				$this->timeframe_model->insert_data('cocreate_post_media',$post_media_data);
			    			}
			    		}

			    		$this->load->model('approval_model');
			    		$approvers = $this->approval_model->get_cocreate_approvers($inserted_id);

						if(!empty($approvers))
						{
							foreach($approvers as $approver)
							{
								$path = img_url()."default_profile.jpg";
								if (file_exists(upload_path().$approver->img_folder.'/users/'.$approver->aauth_user_id.'.png'))
						        {
						            $path = upload_url().$approver->img_folder.'/users/'.$approver->aauth_user_id.'.png?'.uniqid();
						        }
						        $approver_html .= '<li class="pull-sm-left '.$approver->status.'">
									<img src="'.$path.'" width="36" height="36" alt="'.ucfirst($approver->first_name).' '.ucfirst($approver->last_name).'" class="circle-img" data-toggle="popover-hover" data-content="'.ucfirst($approver->first_name).' '.ucfirst($approver->last_name).'">
								</li>';

								$participant_html .= ucfirst($approver->first_name).' '.ucfirst($approver->last_name);
							}
						}
		    		}	    		

		    		echo json_encode(array('response' => 'success','inserted_id' => $inserted_id,'approver_html' => $approver_html,'participant_html' => $participant_html));
	    		}		    		
		    }
		}
	}

	function save_post()
	{
		$this->data = array();
		$error = '';
		$uploaded_files = array();
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			if(!empty($post_data['brand_id']))
			{
				if(isset($post_data['cocreate_info_id']) AND !empty($post_data['cocreate_info_id']))
				{
					$media = $this->timeframe_model->get_data_by_condition('cocreate_post_media',array('cocreate_post_id' => $post_data['cocreate_info_id']),'name');
					if(!empty($media))
					{
						foreach($media as $media_file)
						{
							delete_file(upload_path().$this->user_data['account_id'].'/brands/'.$post_data['brand_id'].'/posts/co_create/'.$media_file);
						}
					}

					$this->timeframe_model->delete_data('cocreate_post_media',array('cocreate_post_id' => $post_data['cocreate_info_id']));
					$this->timeframe_model->delete_data('cocreate_approvers',array('cocreate_post_id' => $post_data['cocreate_info_id']));
					$this->timeframe_model->delete_data('cocreate_post_info',array('id' => $post_data['cocreate_info_id']));
					$this->timeframe_model->delete_data('co_create_requests',array('id' => $post_data['co_create_req_id']));;
				}

				$slate_date_time = '';
				if(!empty($post_data['post-date']) && !empty($post_data['post-hour']) && !empty($post_data['post-minute']) && !empty($post_data['post-ampm'])){
					$date_time =  $post_data['post-date'].' '.add_leading_zero($post_data['post-hour']).':'.add_leading_zero($post_data['post-minute']).' '.$post_data['post-ampm'];
		    		$slate_date_time = date("Y-m-d H:i:s", strtotime($date_time));
				}


		    	if(!empty($post_data['post_outlet']))
	    		{
    				$condition = array('id' => $post_data['post_outlet']);
					$outlet_data = $this->timeframe_model->get_data_by_condition('outlets',$condition,'outlet_name');

					$status = 'pending';
					if($post_data['save_as'] == 'draft')
					{
						$status = 'draft';
					}

    				$post = array(
	    						'content' => $this->input->post('post_copy'),
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'status' => $status,
	    						'updated_at' => date('Y-m-d H:i:s')
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
    						$post = array(
	    						'tumblr_title' => $post_data['tb_text_title'],
	    						'tumblr_text_content' => $post_data['tumblr_post_copy'],
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'status' => $status,
	    						'updated_at' => date('Y-m-d H:i:s'),
	    						'tumblr_tags' => $post_data['tb_text_tags'],
	    						'tumblr_custom_url' => $post_data['tb_text_url']
	    					);
    					}
    					elseif($post_data['tumblrContent'] == 'Photo')
    					{
    						$post = array(	    						
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'status' => $status,
	    						'updated_at' => date('Y-m-d H:i:s'),
	    						'tumblr_tags' => $post_data['tb_photo_tags'],
	    						'tumblr_caption' => $post_data['tbCaption'],
	    						'tumblr_content_source' => $post_data['tbPhotoSource']
	    					);
    					}
    					elseif($post_data['tumblrContent'] == 'Quote')
    					{
    						$post = array(	    						
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'status' => $status,
	    						'updated_at' => date('Y-m-d H:i:s'),
	    						'tumblr_tags' => $post_data['tb_quote_tags'],
	    						'tumblr_custom_url' => $post_data['tb_quote_url'],
	    						'tumblr_quote' => $post_data['tumblr_quote_post_copy'],
	    						'tumblr_source' => $post_data['tbSource']
	    					);
    					}
    					elseif($post_data['tumblrContent'] == 'Link')
    					{
    						$post = array(	    						
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'status' => $status,
	    						'updated_at' => date('Y-m-d H:i:s'),
	    						'tumblr_link' => $post_data['tbLink'],
	    						'tumblr_custom_url' => $post_data['tb_link_url'],
	    						'tumblr_link_description' => $post_data['tbLinkDesc']
	    					);
    					}
    					elseif($post_data['tumblrContent'] == 'Chat')
    					{
    						$post = array(	    						
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'status' => $status,
	    						'updated_at' => date('Y-m-d H:i:s'),
	    						'tumblr_tags' => $post_data['tb_chat_tags'],
	    						'tumblr_custom_url' => $post_data['tb_chat_url'],
	    						'tumblr_chat_title' => $post_data['tb_chat_title'],
	    						'tumblr_chat' => $post_data['tumblr_chat_post_copy'],
	    					);
    					}
    					elseif($post_data['tumblrContent'] == 'Audio')
    					{
    						$post = array(	    						
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'status' => $status,
	    						'updated_at' => date('Y-m-d H:i:s'),
	    						'tumblr_tags' => $post_data['tb_audio_tags'],
	    						'tumblr_custom_url' => $post_data['tb_audio_url'],
	    						'tumblr_audio_description' => $post_data['tbAudioDescr']
	    					);
    					}
    					elseif($post_data['tumblrContent'] == 'Video')
    					{
    						$post = array(	    						
	    						'brand_id' => $post_data['brand_id'],
	    						'outlet_id' =>$post_data['post_outlet'],
	    						'time_zone'=>$post_data['time_zone'],
	    						'user_id' =>$this->user_id,
	    						'status' => $status,
	    						'updated_at' => date('Y-m-d H:i:s'),
	    						'tumblr_tags' => $post_data['tb_video_tags'],
	    						'tumblr_custom_url' => $post_data['tb_video_url'],
	    						'tumblr_source' => $post_data['tbVideoSource'],
	    						'tumblr_video_caption' => $post_data['tbVideoDescr']
	    					);
    					}

    					$post['tumblr_content_type'] = $post_data['tumblrContent'];
    				}
    				

    				if(!empty($slate_date_time)){
    					$post['slate_date_time'] =  $slate_date_time;
    				}

    				$inserted_id = $this->timeframe_model->insert_data('posts',$post);

    				if($inserted_id)
			    	{
			    		if(!empty($post_data['post_tag']))
			    		{
			    			foreach($post_data['post_tag'] as $tag)
			    			{
			    				$post_tag_data = array(
			    										'post_id' => $inserted_id,
			    										'brand_tag_id' => $tag
			    									);
			    			
			    				$this->timeframe_model->insert_data('post_tags',$post_tag_data);
			    			}
			    		}
			    		
	    				if(isset($post_data['uploaded_files'][0]) AND !empty($post_data['uploaded_files'][0]))
						{
	    					$files = json_decode($post_data['uploaded_files'][0])->success;
	    				}
			    		if(isset($files) AND !empty($files))
			    		{
			    			foreach($files as $file)
			    			{
			    				$post_media_data = array(
			    										'post_id' => $inserted_id,
			    										'name' => $file->file,
			    										'type' => $file->type,
			    										'mime' => $file->mime
			    									);			    				

			    				$this->timeframe_model->insert_data('post_media',$post_media_data);
			    			}
			    		}
			    		
			    		$multiple_phases = 0;
			    		$phase_number = 1;
	    				if(isset($post_data['phase']) AND !empty($post_data['phase']))
	    				{
	    					foreach($post_data['phase'] as $key=>$phase)
	    					{
	    						if(isset($phase['approver']) AND !empty($phase['approver']))
	    						{
	    							$multiple_phases = 1;
	    							$date_time =  $phase['approve_date'].' '.add_leading_zero($phase['approve_hour']).':'.add_leading_zero($phase['approve_minute']).' '.$phase['approve_ampm'];
								    	
								    $approve_date_time = date("Y-m-d H:i:s", strtotime($date_time));

		    						$phase_data = array(
		    										'phase' => $phase_number,
		    										'brand_id' => $post_data['brand_id'],
		    										'post_id' => $inserted_id,
		    										'approve_by' => $approve_date_time,
		    										'time_zone' => $phase['time_zone'],
			    									'note' => $phase['note']
		    									);
		    						$phase_insert_id = $this->timeframe_model->insert_data('phases',$phase_data);
		    						$phase['approver'] = array_unique($phase['approver']);
		    						foreach($phase['approver'] as $user)
		    						{
		    							// $user_info = $this->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id' => $post_data['user_id']),'first_name,last_name');
		    							$phases_approver = array(
		    								'user_id' => $user,
		    								'phase_id' => $phase_insert_id
		    								);
		    							$phase_approver_id = $this->timeframe_model->insert_data('phases_approver',$phases_approver);

		    							$reminder_data = array(
		    								'post_id' => $inserted_id,
		    								'user_id' => $user,
		    								'type' => 'reminder',
		    								'brand_id' => $post_data['brand_id'],
		    								'due_date' => $approve_date_time,
		    								'text' => 'Approve '.date('d/n g:i a',strtotime($slate_date_time)).' '.$outlet_data[0]->outlet_name.' post by '.ucfirst($this->user_data['first_name']).' '.ucfirst($this->user_data['last_name']).' by '.date('m/d',strtotime($approve_date_time)),
		    								'phase_id' => $phase_insert_id
		    								);

	    								$this->timeframe_model->insert_data('reminders',$reminder_data);
	    							}
	    							$phase_number++;
	    						}
	    					}	    					

	    					if($phase_number == 1 AND $status != 'draft')
	    					{
	    						$post = array(
		    							'status' => 'approved'
		    						);

	    						$condition = array('id' => $inserted_id);
    							$this->timeframe_model->update_data('posts',$post,$condition);
    						}
	    				}


	    				if($multiple_phases == 0)
	    				{
	    					if(isset($post_data['single_phase']) AND !empty($post_data['single_phase']))
		    				{    					
		    					foreach($post_data['single_phase'] as $key=>$phase)
		    					{
		    						if(isset($phase['approver']) AND !empty($phase['approver']))
		    						{
		    							$multiple_phases = 1;
		    							$date_time =  $phase['approve_date'].' '.add_leading_zero($phase['approve_hour']).':'.add_leading_zero($phase['approve_minute']).' '.$phase['approve_ampm'];
									    	
									    $approve_date_time = date("Y-m-d H:i:s", strtotime($date_time));

			    						$phase_data = array(
			    										'phase' => $phase_number,
			    										'brand_id' => $post_data['brand_id'],
			    										'post_id' => $inserted_id,
			    										'approve_by' => $approve_date_time,
			    										'time_zone' => $phase['time_zone'],
				    									'note' => $phase['note']
			    									);
			    						$phase_insert_id = $this->timeframe_model->insert_data('phases',$phase_data);
			    						$phase['approver'] = array_unique($phase['approver']);
			    						foreach($phase['approver'] as $user)
			    						{
			    							// $user_info = $this->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id' => $post_data['user_id']),'first_name,last_name');
			    							$phases_approver = array(
			    								'user_id' => $user,
			    								'phase_id' => $phase_insert_id
			    								);
			    							$phase_approver_id = $this->timeframe_model->insert_data('phases_approver',$phases_approver);

			    							$reminder_data = array(
			    								'post_id' => $inserted_id,
			    								'user_id' => $user,
			    								'type' => 'reminder',
			    								'brand_id' => $post_data['brand_id'],
			    								'due_date' => $approve_date_time,
			    								'text' => 'Approve '.date('d/n g:i a',strtotime($slate_date_time)).' '.$outlet_data[0]->outlet_name.' post by '.ucfirst($this->user_data['first_name']).' '.ucfirst($this->user_data['last_name']).' by '.date('m/d',strtotime($approve_date_time)),
			    								'phase_id' => $phase_insert_id
			    								);

		    								$this->timeframe_model->insert_data('reminders',$reminder_data);
		    							}
		    							$phase_number++;
		    						}
		    					}	    					

		    					if($phase_number == 1 AND $status != 'draft')
		    					{
		    						$post = array(
			    							'status' => 'approved'
			    						);

		    						$condition = array('id' => $inserted_id);
	    							$this->timeframe_model->update_data('posts',$post,$condition);
	    						}
		    				}
	    				}
		    			
		    		}

		    		if($status == 'draft')
		    		{
		    			$redirect_url = base_url().'drafts/'.$post_data['slug'];
		    		}		    		
		    		elseif($multiple_phases == 1)
		    		{
		    			$redirect_url = base_url().'approvals/'.$post_data['slug'].'/'.$inserted_id;
		    		}
		    		else
		    		{
			    		$this->session->set_userdata( 'selected_date' , $slate_date_time);			    		
			    		$redirect_url = base_url().'calendar/day/'.$post_data['slug'];
		    		}
		    		$this->session->set_flashdata('message','Post has been saved successfuly');
		    		redirect($redirect_url);
	    		}		    		
		    }
		}
	}

	function update_preview()
	{
		$request_id = $this->input->post('req_id');

		if(isset($request_id) AND !empty($request_id))
		{
			$this->data['post_details'] = $this->post_model->get_cocreate_post($request_id);
			if(!empty($this->data['post_details']))
			{
				$this->data['post_images'] = $this->post_model->get_cocreate_images($this->data['post_details']->id);

				$approver_present = $this->timeframe_model->get_data_by_condition('cocreate_approvers',array('user_id' => $this->user_id,'cocreate_post_id' => $this->data['post_details']->id));
				if(empty($approver_present))
				{
					$this->timeframe_model->insert_data('cocreate_approvers',array('user_id' => $this->user_id,'cocreate_post_id' => $this->data['post_details']->id));
				}
				$status = 'pending';
				$approver_status = $this->timeframe_model->get_data_by_condition('cocreate_approvers',array('cocreate_post_id' => $this->data['post_details']->id,'user_id' => $this->user_id),'status');
				if(!empty($approver_status))
				{
					$status = $approver_status[0]->status;
				}

				$this->load->model('approval_model');
	    		$approvers = $this->approval_model->get_cocreate_approvers($this->data['post_details']->id);
	    		$approver_html = '';
	    		$participant_html = '';
				if(!empty($approvers))
				{
					foreach($approvers as $approver)
					{
						$path = img_url()."default_profile.jpg";
						if (file_exists(upload_path().$approver->img_folder.'/users/'.$approver->aauth_user_id.'.png'))
				        {
				            $path = upload_url().$approver->img_folder.'/users/'.$approver->aauth_user_id.'.png?'.uniqid();
				        }
				        $approver_html .= '<li class="pull-sm-left '.$approver->status.'">
							<img src="'.$path.'" width="36" height="36" alt="'.ucfirst($approver->first_name).' '.ucfirst($approver->last_name).'" class="circle-img" data-toggle="popover-hover" data-content="'.ucfirst($approver->first_name).' '.ucfirst($approver->last_name).'">
						</li>';

						$participant_html .= ucfirst($approver->first_name).' '.ucfirst($approver->last_name);
					}
				}

				$this->data['is_cocreate'] = true;
				$html = $this->load->view('calendar/post_preview/'.strtolower($this->data['post_details']->outlet_name),$this->data,true);
				echo json_encode(array('response' => 'success','html' => $html,'approver_status' => $status,'approver_html' => $approver_html,'participant_html' => $participant_html));
			}
			else
			{
				echo json_encode(array('response' => 'success'));	
			}
		}
	}

	function approve_cocreate()
	{
		$request_id = $this->input->post('req_id');

		if(isset($request_id) AND !empty($request_id))
		{
			$post = $this->timeframe_model->get_data_by_condition('cocreate_post_info',array('request_id' => $request_id),'id');

			if(!empty($post))
			{
				$this->timeframe_model->update_data('cocreate_approvers',array('status'=>'approved'),array('cocreate_post_id' => $post[0]->id,'user_id' => $this->user_id));
				echo json_encode(array('response' => 'success'));
			}
			else
			{
				echo json_encode(array('response' => 'fail'));
			}
		}
	}
}