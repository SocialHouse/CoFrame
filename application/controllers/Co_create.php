<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
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
			$this->data['view'] = 'co_create/create';

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
	                                            array('required' => 'At least select one user for approvel')
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
					        	if(strpos($_FILES['uploadedimage']['type'],'video'))
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
					    										'type' => $file['type']
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