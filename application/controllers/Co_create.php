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
	}	

	public function create()
	{		
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);

		if(!empty($brand))
		{
			$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);
			$brand_id = $brand[0]->id;
			$this->data['users'] = $this->brand_model->get_users_without_me($brand_id);
			$this->data['outlets'] = $this->post_model->get_user_outlets($brand[0]->id,$this->user_id);
			
			$opentok = new OpenTok($this->config->item('opentok_key'), $this->config->item('opentok_secret'));
	        $session = $opentok->createSession();
	        $this->data['sessionId']= $session->getSessionId();
	        $this->data['token']= $session->generateToken();

			$this->data['brand_id'] = $brand_id;
			$this->data['brand'] = $brand[0];
			$this->data['view'] = 'co_create/co-create';
			$this->data['layout'] = 'layouts/new_user_layout';
			$this->data['background_image'] = 'bg-brand-management.jpg';
			$this->data['css_files'] = array(css_url().'fullcalendar.css', css_url().'search.css', css_url().'chat.css', 'https://fonts.googleapis.com/css?family=Roboto:400,500');
			$this->data['js_files'] = array(js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0','https://static.opentok.com/v2/js/opentok.js',js_url().'co-create.js?ver=1.0.0');

			_render_view($this->data);
		}
	}

	public function demo()
	{		
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$request_string = $this->uri->segment(4);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);

		if(!empty($brand))
		{
			$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);
			$brand_id = $brand[0]->id;

			if(!empty($request_string))
			{
				$request = $this->timeframe_model->get_data_by_condition('co_create_requests', array('request_string' => $request_string,'brand_slug' => $slug));
				if(!empty($request))
				{
					$this->data['sessionId'] = $request[0]->session_id;
			        $this->data['token'] = $request[0]->token;
			    }
			}

			if(empty($request))
			{
				$this->data['users'] = $this->brand_model->get_users_without_me($brand_id);
				$is_request = $this->timeframe_model->get_data_by_condition('co_create_requests', array('user_id' => $this->user_id,'brand_slug' => $slug));
		        if(empty($is_request))
		        {
					$opentok = new OpenTok($this->config->item('opentok_key'), $this->config->item('opentok_secret'));
			        $session = $opentok->createSession();
			        $this->data['sessionId'] = $session->getSessionId();
			        $this->data['token'] = $session->generateToken();
		        
		       
			        $request_data = array(
			        		'session_id' => $this->data['sessionId'],
			        		'token' => $this->data['token'],
			        		'request_string' => uniqid(),
			        		'brand_slug' => $slug,
			        		'user_id' => $this->user_id
			        	);

			        $this->timeframe_model->insert_data('co_create_requests',$request_data);
			        $this->data['request_string'] = $request_data['request_string'];
			    }
			    else
			    {
			    	$this->data['sessionId'] = $is_request[0]->session_id;
			        $this->data['token'] = $is_request[0]->token;
			        $this->data['request_string'] = $is_request[0]->request_string;
			    }
		    }

			$this->data['brand_id'] = $brand_id;
			$this->data['brand'] = $brand[0];
			$this->data['view'] = 'co_create/demo';
			$this->data['layout'] = 'layouts/new_user_layout';
			$this->data['background_image'] = 'bg-brand-management.jpg';
			$this->data['css_files'] = array(css_url().'fullcalendar.css', css_url().'search.css', css_url().'chat.css');
			$this->data['js_files'] = array(js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0','https://static.opentok.com/v2/js/opentok.js',js_url().'co-create.js?ver=1.0.0');

			_render_view($this->data);
		}
	}

	public function send_join_request()
	{
		$post_data = $this->input->post();

		if(!empty($post_data))
		{
			if(!empty($post_data['selected_users']))
			{
				$subject = "Co create requst";
				$message = "To join co create click below link <br/> <a href=".base_url()."join-co-create/".$post_data['slug']."/".$post_data['request_string'].">".base_url()."join-co-create/".$post_data['slug']."/".$post_data['request_string']."</a>";
				foreach($post_data['selected_users'] as $email)
				{
					email_send($email,$subject,$message);
				}
			}			
		}
	}

	//create post in brand
	public function post()
	{		
		$this->data = array();
		$brand_id = $this->uri->segment(3);
		$brand = get_users_brand($brand_id);
		if(!empty($brand))
		{
			$this->data['brand_id'] = $brand[0]->id;
        	$this->data['brand_name'] = $brand[0]->name;
			$this->data['outlets'] = $this->post_model->get_brand_outlets($brand_id);
			$this->data['tags'] = $this->post_model->get_brand_tags($brand_id);
			$this->data['users'] = $this->post_model->get_brand_users($brand_id);
			$this->data['view'] = 'posts/create';

			$this->data['css_files'] = array(css_url().'datepicker.css',css_url().'timepicker.css');
			$this->data['js_files'] = array(js_url().'datepicker.js',js_url().'timepicker.js');

        	_render_view($this->data);
		}
		else
		{
			$this->session->set_flashdata('error','Brand is not available');
			redirect(base_url().'brands');
		}		
	}

	public function save_post()
	{
		$this->data = array();
		$error = '';
		$uploaded_files = array();
		$post_data = $this->input->post();

		$brand = get_users_brand(isset($post_data['brand_id'])?$post_data['brand_id']:'');

		if($brand)
		{
	        $this->form_validation->set_rules('outlets[]','Outlets','required',                                            
	                                            array('required' => 'At least select one outlet')
	                                        );
	        $this->form_validation->set_rules('post_copy','post copy','required',
	                                            array('required' => 'Post copy is required')
	                                        );
	        $this->form_validation->set_rules('date','date','required',
	                                            array('required' => 'Date is required')
	                                        );
	        $this->form_validation->set_rules('time','time','required',
	                                            array('required' => 'Time is required')
	                                        );
	        $this->form_validation->set_rules('users[]','users','required',
	                                            array('required' => 'At least select one user for approval')
	                                        );
	       	
	       	if($this->form_validation->run() === TRUE)
	        {
		       	if(isset($_FILES['media_files']) && !empty($_FILES['media_files']))
				{
					$number_of_files = sizeof($_FILES['media_files']['tmp_name']);
					$files = $_FILES['media_files'];
					
					for ($i = 0; $i < $number_of_files; $i++)
					{
						if(!empty($files['name'][$i]))
						{
					        $_FILES['uploadedimage']['name'] = $files['name'][$i];
					        $ext = pathinfo($_FILES['uploadedimage']['name'], PATHINFO_EXTENSION);
					        $randname = uniqid().'.'.$ext;
					        $_FILES['uploadedimage']['type'] = $files['type'][$i];
					        $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
					        $_FILES['uploadedimage']['error'] = $files['error'][$i];
					        $_FILES['uploadedimage']['size'] = $files['size'][$i];
					        $status = upload_file('uploadedimage',$randname,'posts');
					       
					        if(array_key_exists("upload_errors",$status))
					        {
					        	$error =  $status['upload_errors'];				        	
					        	break;
					        }
					        else
					        {
					        	$uploaded_files[$i]['file'] = $status['file_name'];
					        	$uploaded_files[$i]['type'] = 'images';
					        	$uploaded_files[$i]['mime'] = $_FILES['uploadedimage']['type'];					        	
					        	
					        	if(strpos($_FILES['uploadedimage']['type'],'video') !== false)
					        	{
					        		$uploaded_files[$i]['type'] = 'video';
					        	}
					        }
					    }
			      	}			      
			    }
			    if(empty($error))
			    {
			    	$date_time = $post_data['date']." ".$post_data['time'];
			    	$slate_date_time = date("Y-m-d H:i:s", strtotime($date_time));

			    	if(!empty($post_data['outlets']))
		    		{
		    			foreach($post_data['outlets'] as $outlet)
		    			{
		    				$post = array(
			    						'content' => $this->input->post('post_copy'),
			    						'slate_date_time' => $slate_date_time,
			    						'brand_id' => $post_data['brand_id'],
			    						'outlet_id' => $outlet
			    					);

		    				$inserted_id = $this->timeframe_model->insert_data('posts',$post);

		    				if($inserted_id)
					    	{
					    		if(!empty($post_data['tags']))
					    		{
					    			foreach($post_data['tags'] as $tag)
					    			{
					    				$post_tag_data = array(
					    										'post_id' => $inserted_id,
					    										'brand_tag_id' => $tag
					    									);
					    			
					    				$this->timeframe_model->insert_data('post_tags',$post_tag_data);
					    			}
					    		}					    		

					    		if(!empty($post_data['users']))
					    		{
					    			foreach($post_data['users'] as $user)
					    			{
					    				$post_approver_data = array(
					    										'post_id' => $inserted_id,
					    										'user_id' => $user
					    									);

					    				$this->timeframe_model->insert_data('post_approvers',$post_approver_data);
					    			}
					    		}

					    		if(!empty($uploaded_files))
					    		{
					    			foreach($uploaded_files as $file)
					    			{
					    				$post_media_data = array(
					    										'post_id' => $inserted_id,
					    										'name' => $file['file'],
					    										'type' => $file['type'],
					    										'mime' => $file['mime']
					    									);

					    				$this->timeframe_model->insert_data('post_media',$post_media_data);
					    			}
					    		}
			    			}
			    		}			    	
			    		$this->session->set_flashdata('message','Post has been saved successfuly');
			    		redirect(base_url().'posts/index/'.$brand[0]->id);
			    	}
			    }
			    $this->data['error'] = "Unable to save post please try again";
		    }

		    $this->data['brand_id'] = $brand[0]->id;
	    	$this->data['brand_name'] = $brand[0]->name;
			$this->data['outlets'] = $this->post_model->get_brand_outlets($brand[0]->id);
			$this->data['tags'] = $this->post_model->get_brand_tags($brand[0]->id);
			$this->data['users'] = $this->post_model->get_brand_users($brand[0]->id);

			$this->data['view'] = 'posts/create';

			$this->data['css_files'] = array(css_url().'datepicker.css',css_url().'timepicker.css');
			$this->data['js_files'] = array(js_url().'datepicker.js',js_url().'timepicker.js');

	    	_render_view($this->data);
	    }
	}
}