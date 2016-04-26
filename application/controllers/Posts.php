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
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
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

	//create post in brand
	//create post in brand
	public function create()
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

			//get default approvers which we added in brand
			$phases = $this->post_model->get_default_phases($brand_id);
			$this->data['default_phases'] = array();
			if(!empty($phases))
			{
				foreach($phases as $phase)
				{
					$this->data['default_phases'][$phase->phase][] = $phase;					
				}
			}

			$this->data['users'] = $this->post_model->get_brand_users($brand_id);

			$this->data['view'] = 'posts/create';

			// $this->data['css_files'] = array(css_url().'datepicker.css',css_url().'timepicker.css',css_url().'custom.css');
			// $this->data['js_files'] = array(js_url().'datepicker.js',js_url().'timepicker.js');
			$this->data['css_files'] = array(css_url().'datepicker.css',css_url().'timepicker.css',css_url().'jquery_ui.css',css_url().'custom.css');
			$this->data['js_files'] = array(js_url().'datepicker.js',js_url().'jquery_ui.js',js_url().'timepicker.js');

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


		$default_phases = $this->post_model->get_default_phases($post_data['brand_id']);

		if($brand)
		{
	        $this->form_validation->set_rules('outlets[]','Outlets','required',                                            
	                                            array('required' => 'At least select one outlet')
	                                        );
	        $this->form_validation->set_rules('post_copy','post copy','required',
	                                            array('required' => 'Post copy is required')
	                                        );
	        $this->form_validation->set_rules('slate_date_month','month','required',
	                                            array('required' => 'Date is required')
	                                        );
	        $this->form_validation->set_rules('slate_date_day','time','required',
	                                            array('required' => 'Time is required')
	                                        );
	         $this->form_validation->set_rules('slate_date_year','year','required',
	                                            array('required' => 'Date is required')
	                                        );
	        $this->form_validation->set_rules('slate_time','time','required',
	                                            array('required' => 'Time is required')
	                                        );
	        // $this->form_validation->set_rules('users[]','users','required',
	        //                                     array('required' => 'At least select one user for approvel')
	        //                                 );
	       	
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
			    	$date_time =  $post_data['slate_date_year'].'-'.$post_data['slate_date_month'].'-'.$post_data['slate_date_day']." ".$post_data['slate_time'];
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

					    		// if(!empty($post_data['users']))
					    		// {
					    		// 	foreach($post_data['users'] as $user)
					    		// 	{
					    		// 		$post_approver_data = array(
					    		// 								'post_id' => $inserted_id,
					    		// 								'user_id' => $user
					    		// 							);

					    		// 		$this->timeframe_model->insert_data('post_approvers',$post_approver_data);
					    		// 	}
					    		// }

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

			    			if(isset($post_data['load_default']))
			    			{
			    				$default_phases = $this->post_model->get_default_phases($post_data['brand_id']);
			    				if(!empty($default_phases))
			    				{
			    					foreach($default_phases as $phase)
			    					{
			    						$date_time = $post_data['default_phase_year']."-".$post_data['default_phase_month']."-".$post_data['default_phase_day']." ".$post_data['default_phase_time'];
								    	$default_date_time = date("Y-m-d H:i:s", strtotime($date_time));

			    						$phase_data = array(
			    										'phase' => $phase->phase,
			    										'brand_id' => $post_data['brand_id'],
			    										'post_id' => $inserted_id
			    									);
			    						//add new phase data for the post with same data as default phase
			    						$phase_insert_id = $this->timeframe_model->insert_data('phases',$phase_data);

			    						$phases_approver = array(
			    											'user_id' => $phase->user_id,
			    											'phase_id' => $phase_insert_id,
			    											'approve_by' => $default_date_time,
			    											'note' => $post_data['default_note']

			    										);

										$phase_approver_id = $this->timeframe_model->insert_data('phases_approver',$phases_approver);
									}
			    				}
			    			}
			    			else
			    			{
			    				if(isset($post_data['phase']['users']) AND !empty($post_data['phase']['users']))
			    				{
			    					$phase_number = 1;
			    					foreach($post_data['phase']['users'] as $key=>$phase)
			    					{
			    						$date_time = $post_data['phase']['approve_year'][$key][0]."-".$post_data['phase']['approve_month'][$key][0]."-".$post_data['phase']['approve_day'][$key][0]." ".$post_data['phase']['approve_time'][$key][0];
									    	$approve_date_time = date("Y-m-d H:i:s", strtotime($date_time));

			    						$phase_data = array(
			    										'phase' => $phase_number,
			    										'brand_id' => $post_data['brand_id'],
			    										'post_id' => $inserted_id,
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

			// $this->data['css_files'] = array(css_url().'datepicker.css',css_url().'timepicker.css');
			// $this->data['js_files'] = array(js_url().'datepicker.js',js_url().'timepicker.js');
			$this->data['css_files'] = array(css_url().'datepicker.css',css_url().'timepicker.css',css_url().'jquery_ui.css',css_url().'custom.css');
			$this->data['js_files'] = array(js_url().'datepicker.js',js_url().'jquery_ui.js',js_url().'timepicker.js');

	    	_render_view($this->data);
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

	public function drafts()
	{
		$this->data = array();
		$brand_id = $this->uri->segment(3);

		$brand = get_users_brand($brand_id);
		if(!empty($brand))
		{
			$this->data['posts'] = $this->post_model->get_draft_posts($brand_id);
			$this->data['view'] = 'posts/drafts';

        	_render_view($this->data);
		}
	}

	public function edit()
	{
		$this->data = array();
		$post_id = $this->uri->segment(3);
		if($post_id)
		{
			$this->data['post'] = $this->post_model->get_post($post_id);
			if(!empty($this->data['post']))
			{
				$tags_array = $this->post_model->get_post_tags($post_id);
				$this->data['selected_tags'] = array();
				if(!empty($tags_array))
				{
					$this->data['selected_tags'] = array_column($tags_array,'id');
				}
				
				// $approvers_array = $this->post_model->get_post_approvers($post_id);
				// $this->data['selected_approvers'] = array_column($approvers_array,'aauth_user_id');
				$phases = $this->post_model->get_post_phases($post_id);		

				$this->data['phases'] = array();
				if(!empty($phases))
				{
					foreach($phases as $phase)
					{
						$this->data['phases'][$phase->phase][] = $phase;
					}
				}

				$condition = array('post_id'=>$post_id);
				$this->data['post_media'] = $this->timeframe_model->get_data_by_condition('post_media',$condition);
			

				$this->data['tags'] = $this->post_model->get_brand_tags($this->data['post']->brand_id);
				$this->data['users'] = $this->post_model->get_brand_users($this->data['post']->brand_id);
				$this->data['brand_id'] = $this->data['post']->brand_id;

				$this->data['view'] = 'posts/edit_post';

				$this->data['css_files'] = array(css_url().'datepicker.css',css_url().'timepicker.css');
				$this->data['js_files'] = array(js_url().'datepicker.js',js_url().'timepicker.js');
	        	_render_view($this->data);
	        }
		}
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

	public function duplicate($brand_id,$post_id)
	{
		$status = $this->post_model->duplicate_post($post_id);
		$message = "Post has been duplicated successfully";
		if($atatus)
		{
			$message = "Unable to duplicate post please try again";
		}
		redirect(base_url().'posts/drafts/'.$brand_id);
	}
}
