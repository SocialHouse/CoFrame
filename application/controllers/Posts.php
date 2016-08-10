<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

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
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
	}

	public function index()
	{
		$this->data = array();
		$brand_id = $this->uri->segment(3);

		$brand = get_users_brand($brand_id);
		if(!empty($brand))
		{
			$this->data['posts'] = $this->post_model->get_posts($brand_id);
			$this->data['view'] = 'posts/post_list';		

        	_render_view($this->data);
		}
	}

	public function create()
	{		
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);
		check_access('create',$brand);
		if(!empty($brand))
		{
			//$this->user_data['timezone'] = $brand[0]->timezone;
			$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);		
			$brand_id = $brand[0]->id;
			//get user who as permission to approve
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
			//echo '<pre>'; print_r($this->user_data);echo '</pre>';
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
			
			$this->data['view'] = 'posts/create-post';
			$this->data['layout'] = 'layouts/new_user_layout';		
			
			$this->data['background_image'] = 'bg-brand-management.jpg';
			$this->data['css_files'] = array(css_url().'fullcalendar.css', 'https://fonts.googleapis.com/css?family=Roboto:400,500');
			$this->data['js_files'] = array(js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'custom_validation.js?ver=1.0.0');

			_render_view($this->data);
		}
	}

	public function save_post()
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
					$date_time =  $post_data['post-date'].' '.$post_data['post-hour'].':'.$post_data['post-minute'].' '.$post_data['post-ampm'];
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
			    		
	    				if(isset($post_data['phase']) AND !empty($post_data['phase']))
	    				{
	    					$phase_number = 1;		    					
	    					foreach($post_data['phase'] as $key=>$phase)
	    					{
	    						if(isset($phase['approver']) AND !empty($phase['approver']))
	    						{
	    							$date_time =  $phase['approve_date'].' '.$phase['approve_hour'].':'.$phase['approve_minute'].' '.$phase['approve_ampm'];
								    	
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
		    								'text' => 'Approve '.date('n/d',strtotime($slate_date_time)).' '.$outlet_data[0]->outlet_name.' post by '.ucfirst($this->user_data['first_name']).' '.ucfirst($this->user_data['last_name']).' by '.date('m/d',strtotime($approve_date_time))
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
	    			$this->session->set_flashdata('message','Post has been saved successfuly');
	    			redirect(base_url().'brands/dashboard/'.$post_data['slug']);
	    		}		    		
		    }
		}
	}

	public function delete($brand_id,$post_id)
	{
		$condition = array('id' => $post_id,'brand_id' => $brand_id);
		$status = $this->timeframe_model->delete_data('posts',$condition);

		if($status)
		{
			$condition = array('post_id' => $post_id);
			$this->timeframe_model->delete_data('post_tags',$condition);			
			$this->timeframe_model->delete_data('post_media',$condition);			

			$phases = $this->timeframe_model->get_data_by_condition('phases',array('post_id' => $post_id));
			if(!empty($phases))
			{
				foreach($phases as $phase)
				{
					$condition = array('phase_id' => $phase->id);
					$this->timeframe_model->delete_data('phases_approver',$condition);
				}
				$condition = array('post_id' => $post_id);
				$this->timeframe_model->delete_data('phases',$condition);
			}


			$this->session->set_flashdata('message','Post has been deleted successfully');
		}
		else
		{
			$this->session->set_flashdata('error','Unable to delete post please try again');
		}
		redirect(base_url().'posts/index/'.$brand_id);
	}	

	public function update_post()
	{
		$this->data = array();
		$error = '';
		$uploaded_files = array();
		$post_data = $this->input->post();		

		if(!empty($post_data))
		{
			$this->data['post'] = $this->post_model->get_post($post_data['id']);

	        $this->form_validation->set_rules('post_copy','post copy','required',
	                                            array('required' => 'Post copy is required')
	                                        );
	        $this->form_validation->set_rules('date','date','required',
	                                            array('required' => 'Date is required')
	                                        );
	        $this->form_validation->set_rules('time','time','required',
	                                            array('required' => 'Time is required')
	                                        );
	        // $this->form_validation->set_rules('users[]','users','required',
	                                            // array('required' => 'At least select one user for approvel')
	                                        // );

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
					        	if(strpos($_FILES['uploadedimage']['type'],'video') !==false)
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

			    	$post = array(
		    						'content' => $this->input->post('post_copy'),
		    						'slate_date_time' => $slate_date_time
		    					);
			    	
			    	$condition = array('id' => $post_data['id']);
    				$update_status = $this->timeframe_model->update_data('posts',$post,$condition);

    				if($update_status)
			    	{
		    			$tags_to_add = isset($post_data['tags']) ? $post_data['tags']: array();

		    			$previous_tags = $this->post_model->get_post_tags($post_data['id']);
		    		
						if(!empty($previous_tags))
						{
							$selected_tags = array_column($previous_tags,'id');
							if(!empty($post_data['tags']))
							{	
								$tags_to_add = array_diff($post_data['tags'],$selected_tags);							
		        				$tags_to_delete = array_diff($selected_tags,$post_data['tags']);
					        }
					        else
					        {
					        	$tags_to_delete = $selected_tags;
					        }

					        foreach ($tags_to_delete as $tag)
				        	{
				        		$condition = array('brand_tag_id' => $tag,'post_id' => $post_data['id']);
				        		$this->timeframe_model->delete_data('post_tags',$condition);
				        	}
						}

						foreach($tags_to_add as $tag)
		    			{

		    				$post_tag_data = array(
		    										'post_id' => $post_data['id'],
		    										'brand_tag_id' => $tag
		    									);
		    			
		    				$this->timeframe_model->insert_data('post_tags',$post_tag_data);
		    			}		   

			    		if(!empty($uploaded_files))
			    		{
			    			foreach($uploaded_files as $file)
			    			{
			    				$post_media_data = array(
			    										'post_id' => $post_data['id'],
			    										'name' => $file['file'],
			    										'type' => $file['type'],
			    										'mime' => $file['mime']
			    									);

			    				$this->timeframe_model->insert_data('post_media',$post_media_data); 
			    			}
			    		}

			    		$condition = array('post_id' => $post_data['id']);
			    		$phases = $this->timeframe_model->get_data_by_condition('phases',$condition,'id');
			    		$phase_number = 1;
			    		if(!empty($phases))
			    		{
			    			$phase_number = count($phases) + 1;
			    		}

			    		if(isset($post_data['phase']['users']) AND !empty($post_data['phase']['users']))
	    				{
	    					foreach($post_data['phase']['users'] as $key=>$phase)
	    					{
	    						$date_time = $post_data['phase']['approve_year'][$key][0]."-".$post_data['phase']['approve_month'][$key][0]."-".$post_data['phase']['approve_day'][$key][0]." ".$post_data['phase']['approve_time'][$key][0];
							    	$approve_date_time = date("Y-m-d H:i:s", strtotime($date_time));

	    						$phase_data = array(
	    										'phase' => $phase_number,
	    										'brand_id' => $post_data['brand_id'],
	    										'post_id' => $post_data['id'],
	    										'approve_by' => $approve_date_time,
		    									'note' => $post_data['phase']['note'][$key][0]
	    									);			    						
	    						$phase_insert_id = $this->timeframe_model->insert_data('phases',$phase_data);			    						

	    						foreach($phase as $user)
	    						{ 
		    						$phases_approver = array(
		    											'user_id' => $user,
		    											'phase_id' => $phase_insert_id  
		    										);

									$phase_approver_id = $this->timeframe_model->insert_data('phases_approver',$phases_approver);											
								}

	    						$phase_number++;
	    					}
	    				}




			    		$this->session->set_flashdata('message','Post has been saved successfuly');
			    		redirect(base_url().'posts/drafts/'.$this->data['post']->brand_id);
			    	}
			    }
			    $this->data['error'] = "Unable to save post please try again";
		    }

		    

		    $this->data['tags'] = $this->post_model->get_brand_tags($this->data['post']->brand_id);
			// $this->data['users'] = $this->post_model->get_brand_users($this->data['post']->brand_id);
			$phases = $this->post_model->get_post_phases($post_id);

			$this->data['phases'] = array();
			if(!empty($phases))
			{
				foreach($phases as $phase)
				{
					$this->data['phases'][$phase->phase][] = $phase;
				}
			}	

			$this->data['view'] = 'posts/edit_post';

			$this->data['css_files'] = array(css_url().'datepicker.css',css_url().'timepicker.css');
			$this->data['js_files'] = array(js_url().'datepicker.js',js_url().'timepicker.js');

	    	_render_view($this->data);
	    }
	}	

	public function tag_list($brand_id)
	{
		$this->data['tags'] = $this->post_model->get_brand_tags($brand_id);
		echo $this->load->view('partials/tag_list',$this->data,true);
	}

	public function upload()
	{
		$post_data = $this->input->post();
		//echo '<pre>'; print_r( $_FILES['file']);echo '</pre>';
		if(isset($_FILES['file']['name'][0]))
		{
			$files = $_FILES['file'];
			
			$files_count = count($files['tmp_name']);
			$error = '';
			if($files_count > 0)
			{
				for($i = 0;$i < $files_count; $i++)
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
				        $status = upload_file('uploadedimage',$randname,$this->user_data['account_id'].'/brands/'.$post_data['brand_id'].'/posts');
				      
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
			else
			{
				$error = "Please select atleast one file";
			}

			if(!empty($error))
			{
				echo json_encode(array('error' => $error));
			}
			else
			{
				echo json_encode(array('success'=>$uploaded_files));
			}
		}
		else
		{
			echo json_encode(array('success'=>'no_files'));
		}
	}

	public function add_phase_details($brand_id)
	{
		$this->data = array();
		$this->data['brand_id'] = $brand_id;
		$this->data['brand'] = $this->brand_model->get_brand_by_id($brand_id);
		$this->data['timezone_list'] = $this->user_model->get_timezones();
		//echo '<pre>'; print_r($this->user_data);echo '</pre>';
		foreach ($this->data['timezone_list']  as $key => $value) 
		{
			if($this->data['brand']->timezone  == $value->value)
			{
				$this->data['brand_timezone'] = array(
										'name' =>  $value->timezone,
										'value' => $value->value
										);
				 unset($this->data['timezone_list'][$key]);
			}
			
			if($this->user_data['timezone'] == $value->value)
			{
				$this->data['user_timezone'] = array(
									'name' =>  $value->timezone,
									'value' => $value->value
									);
				if($this->data['brand']->timezone  != $this->user_data['timezone'] )
				{
					unset($this->data['timezone_list'][$key]);
				}
			}
		}	
		echo $this->load->view('posts/add_phase_details',$this->data,true);
	}

	public function get_post_info($post_id,$view_type){
		if(!empty($post_id)){
			$this->data['view_type'] = $view_type;
			$this->data['post_details'] = $this->post_model->get_post($post_id);
			$this->data['post_images'] = $this->post_model->get_images($post_id);
			$post_phases= $this->post_model->get_post_phases($post_id);
		
			if(!empty($post_phases))
			{
				foreach($post_phases as $phase)
				{
					$this->data['phases'][$phase->phase][] = $phase;
				}
			}
			//echo '<pre>'; print_r($this->data);echo '</pre>';
			echo $this->load->view('calendar/post_preview',$this->data,true);
		}
	}

	public function delete_post()
	{
		$post_data = $this->input->post();
		if(isset($post_data) AND !empty($post_data))
		{
			foreach($post_data['post_ids'] as $post_id)
			{
				$condition = array('id' => $post_id);
				$array = array('status'=> 'deleted' );
				$this->timeframe_model->update_data('posts',$array,$condition);				
			}
			echo 'true';
		}

	}

	function resubmit_phases()
	{
		$post_data = $this->input->post();
		if(isset($post_data['phase_ids']))
		{
			foreach($post_data['phase_ids'] as $phase_id)
			{
				$phase_data = array(
						'status' => 'pending'
					);
				$this->timeframe_model->update_data('phases',$phase_data,array('id' => $phase_id));
				$phase = $this->timeframe_model->get_data_by_condition('phases',array('id' => $phase_id),'post_id,brand_id,approve_by');
				
				$post_id = $phase[0]->post_id;
				$brand_id = $phase[0]->brand_id;
				$outlet = get_outlet_by_id($post_data['outlet']);

				$approvers = $this->timeframe_model->get_data_by_condition('phases_approver',array('id' => $phase_id));
				foreach($approvers as $approver)
				{					
					$this->timeframe_model->update_data('phases_approver',$phase_data,array('id' => $approver->id));

					//delete old reminders of this post to this user
					$this->timeframe_model->delete_data('reminders',array('post_id' => $post_id,'user_id' => $approver->user_id));

					//add new reminser
					$reminder_data = array(
							'type' => 'reminder',
							'brand_id' => $brand_id,
							'post_id' => $post_id,
							'user_id' => $approver->user_id,
							'due_date' => $phase[0]->approve_by,
							'text' => 'Recheck '.ucfirst($outlet).' post'

						);
					$this->timeframe_model->insert_data('reminders',$reminder_data);

				}				
			}
			echo json_encode(array('response' => 'success'));
		}
		else
		{
			echo json_encode(array('response' => 'fail'));
		}
	}

	public function post_approve($post_id, $user_id)
	{
		if(!empty($post_id)){
			$phases = $this->post_model->get_post_phases($post_id);		

			$phases_array = array();
			if(!empty($phases))
			{
				foreach($phases as $phase)
				{
					$phases_array[$phase->phase][] = $phase;
				}
			}
			echo count($phases_array);
			// $condition = array('id' => $post_id);
			// $array = array('status'=> 'scheduled' );
			// $this->timeframe_model->update_data('posts',$array,$condition);
		}
	}

	function change_post_status()
	{
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$approver_data = array(
						'status' => $post_data['status']
					);

			if($post_data['status'] == 'scheduled')
			{
				$this->timeframe_model->update_data('posts',$approver_data,array('id'=>$post_data['post_id']));
			}
			elseif($post_data['status'] == 'unschedule')
			{
				$approver_data['status'] = 'pending';
				$this->timeframe_model->update_data('posts',$approver_data,array('id'=>$post_data['post_id']));
			}
			else
			{				
				$this->timeframe_model->update_data('phases_approver',$approver_data,array('phase_id'=>$post_data['phase_id'],'user_id' => $post_data['user_id']));

				
				if($post_data['status'] == 'pending')
				{
					$this->timeframe_model->update_data('phases',$approver_data,array('id'=>$post_data['phase_id']));
					$post_update = array(
								'status' => 'pending'
							);
					$this->timeframe_model->update_data('posts',$post_update,array('id'=>$post_data['post_id']));
				}
				else
				{
					$phase_user = $this->timeframe_model->get_data_by_condition('phases_approver',array('phase_id' => $post_data['phase_id']),'count(id) as count');

					$approved_phase_user = $this->timeframe_model->get_data_by_condition('phases_approver',array('phase_id' => $post_data['phase_id'],'status' => 'approved'),'count(id) as count');

					if($phase_user[0]->count == $approved_phase_user[0]->count)
					{
						$this->timeframe_model->update_data('phases',$approver_data,array('id'=>$post_data['phase_id']));
						
						$phases = $this->timeframe_model->get_data_by_condition('phases',array('post_id' => $post_data['post_id']),'count(id) as count');

						$approved_phases = $this->timeframe_model->get_data_by_condition('phases',array('post_id' => $post_data['post_id'],'status' => 'approved'),'count(id) as count');

						if($phases[0]->count == $approved_phases[0]->count)
						{
							$post_update = array(
								'status' => 'approved'
							);
							$this->timeframe_model->update_data('posts',$post_update,array('id'=>$post_data['post_id']));

							$post_details = $this->post_model->get_post($post_data['post_id']);

							$reminder_data = array(
	    								'post_id' => $post_data['post_id'],
	    								'user_id' => $post_details->user_id,
	    								'type' => 'reminder',
	    								'brand_id' => $post_details->brand_id,
	    								'due_date' => $post_details->slate_date_time,
	    								'text' => 'Schedule '.get_outlet_by_id($post_details->outlet_id).' post having slate date '.date('Y-m-d h:i a',strtotime($post_details->slate_date_time))
    								);
							$this->timeframe_model->insert_data('reminders',$reminder_data);
						}
					}
				}
			}
			echo "1";
		}
	}

	function finish_phase($phase_id)
	{
		if(!empty($phase_id)){
			$phase_data = array(
						'status' => 'finished'
					);
			$this->timeframe_model->update_data('phases_approver',$phase_data,array('id' => $phase_id));
			echo json_encode(array('response'=>'success'));
		}
		else{
			echo json_encode(array('response'=>'fail'));
		}
	}

	function schedule_post()
	{
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$post_sataus = array(
					'status' => 'scheduled'
				);

			$this->timeframe_model->update_data('posts',$post_sataus,array('id' => $post_data['post_id']));
			echo "1";
		}
		else
		{
			echo "0";
		}
	}

	function search()
	{
		$this->data = array();
		$get_data = $this->input->get();
		if(isset($get_data))
		{
			$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$get_data['slug']);			

			if(!empty($brand))
			{
				$this->user_data['timezone'] = $brand[0]->timezone;
				$this->data['search'] = $get_data['search'];
				$brand_id = $brand[0]->id;				
				$this->data['outlets'] = $this->post_model->get_brand_outlets($brand_id);
    			$this->data['tags'] = $this->post_model->get_brand_tags($brand_id);

    			$this->data['posts'] = $this->post_model->get_posts($brand_id,$get_data['search']);

				$this->data['brand_id'] = $brand_id;
				$this->data['brand'] = $brand[0];
				$this->data['view'] = 'posts/search';
				$this->data['layout'] = 'layouts/new_user_layout';		
				
				$this->data['background_image'] = 'bg-brand-management.jpg';			
		
				$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'vendor/jquery.dotdotdot.min.js?ver=1.8.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0', js_url().'drag-drop-file-upload.js?ver=1.0.0');

				_render_view($this->data);
			}
		}
	}
}
