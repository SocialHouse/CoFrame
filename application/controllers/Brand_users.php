<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand_users extends CI_Controller {

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

	public function index($brand_id)
	{
		$brand = get_users_brand($brand_id);
		if(!empty($brand))
		{
			$this->data['brand_name'] = $brand[0]->name;
			$this->data['brands_user'] = $this->brand_model->get_brand_users($brand_id);
			$this->data['view'] = 'brand_users/brand_users';
	        _render_view($this->data);
	    }
	    else
	    {
	    	$this->session->set_flashdata('error','Brand is not available');
	    	redirect(base_url().'brands');
	    }
	}	

	public function add_user($brand_id)
	{
		if($brand_id)
		{
			$this->data = array();			
			$brand = get_users_brand($brand_id);			
			if(!empty($brand))
			{
				$this->load->model('user_model');
				$this->data['brand_id'] = $brand[0]->id;
				$this->data['brand_name'] = $brand[0]->name;
				$this->data['permissions'] = $this->aauth->list_groups();

				$this->data['view'] = 'brand_users/add_user';
		        _render_view($this->data);
		    }
		    else
		    {
		    	$this->session->set_flashdata('error','Brand is not available');
		    	redirect(base_url().'brands');
		    }
		}
		else
	    {
	    	$this->session->set_flashdata('error','Brand is not available');
	    	redirect(base_url().'brands');
	    }
	}

	public function edit_user($brand_map_id)
	{
		$this->data = array();
		$user_id = $this->user_id;
		$brands_user = $this->brand_model->check_brand_owner($brand_map_id,$user_id);
		if(!empty($brands_user))
		{
			$this->data['brand_map_id'] = $brand_map_id;
			$this->load->model('user_model');
			$this->data['user'] =$this->user_model->get_user($brands_user->access_user_id);
			$this->data['permissions'] = $this->aauth->list_groups();
			$this->data['current_perm'] = $this->aauth->get_user_groups($brands_user->access_user_id);			

			$this->data['view'] = 'brand_users/edit_user';
	        _render_view($this->data);
		}
	}

	public function save_user()
	{
		$brand_id = $this->input->post('brand_id');
		$brand = get_users_brand($brand_id);

		if(!empty($brand))
		{
			$this->data = array();

			$this->load->model('user_model');

			$this->form_validation->set_rules('first_name','first name','required',                                            
	                                            array('required' => 'First name is required')
	                                        );
			$this->form_validation->set_rules('last_name','last name','required',
	                                            array('required' => 'Last name is required')
	                                        );
			$this->form_validation->set_rules('email','email','required|valid_email|is_unique[aauth_users.email]',
	                                            array(
	                                            	'required' => 'Email is required',
	                                            	'is_unique' => 'This email is already present'
	                                            	)
	                                        );
			$this->form_validation->set_rules('permission','permission','required',
	                                            array('required' => 'Permission is required')
	                                        );
			$this->form_validation->set_rules('username','username','required|is_unique[aauth_users.name]',
	                                            array(
	                                            	'required' => 'Username is required',
	                                            	'is_unique' => 'This username is already present'
	                                            	)
	                                        );

			if($this->form_validation->run() === FALSE)
	        {
	        	$this->data['brand_id'] = $brand[0]->id;
	        	$this->data['brand_name'] = $brand[0]->name;
	        	$this->data['permissions'] = $this->aauth->list_groups();
	            $this->data['view'] = 'brand_users/add_user';

	            _render_view($this->data);
	        }
	        else
	        {
	        	$password = uniqid();
	        	$user_data = array(
	        					'first_name' => $this->input->post('first_name'),
	        					'last_name' => $this->input->post('last_name'),	        					
	        					'title' => $this->input->post('title'),	        					
	        					'company_name' => $this->user_data['company_name'],
	        					'company_email' => $this->user_data['company_email'],
	        					'company_url' =>  $this->user_data['company_url'],
	                            'created_at' => date('Y-m-d H:i:s'),
	                            'password' => $password,
	                            'username' => $this->input->post('username')
	        				);
	        	
	        	$this->load->helper('email');

	        	$this->data['user'] = $user_data;

	            $content = $this->load->view('mails/login_details',$this->data,true);
	            
	            $subject = 'Timeframe - login details';

	            try
	            {
	                $mail_send = email_send($this->input->post('email'), $subject,$content);
	                if($mail_send)
	                {
	                	$inserted_id = $this->aauth->create_user($this->input->post('email'),$password,$this->input->post('username'));
	                	$this->aauth->add_member($inserted_id,$this->input->post('permission'));
	                	unset($user_data['password']);
	                	unset($user_data['username']);
	                	$user_data['aauth_user_id'] = $inserted_id;
	                	$this->timeframe_model->insert_data('user_info',$user_data);
	                    $brand_user_map = array(
	                    							'brand_id' => $brand_id,
	                    							'access_user_id' => $inserted_id
	                    						);
	                    $this->timeframe_model->insert_data('brand_user_map',$brand_user_map);	                    
	                    $this->session->set_flashdata('message','User has been saved successfully');
	                    redirect(base_url().'brand_users/index/'.$brand_id);
	                }
	                else
	                {
	                    $this->session->set_flashdata('error','Unable to save user, please try again');
	                }
	            }
	            catch(Exception $ex)
	            {
	                $this->session->set_flashdata('error','Unable to save user, please try again');
	            }            
	    		redirect(base_url().'brands');
		    }
		}
		else
		{
			$this->session->set_flashdata('error','Unable to add user, please try again');
			redirect(base_url().'brands');
		}
	}

	public function update_user()
	{
		$this->data = array();
		$user_id = $this->user_id;
		$brand_map_id = $this->input->post('brand_map_id');
		$brands_user = $this->brand_model->check_brand_owner($brand_map_id,$user_id);

		if(!empty($brands_user))
		{
			$this->data = array();

			$this->load->model('user_model');

			$this->form_validation->set_rules('first_name','first name','required',                                            
	                                            array('required' => 'First name is required')
	                                        );
			$this->form_validation->set_rules('last_name','last name','required',
	                                            array('required' => 'Last name is required')
	                                        );
			
			$this->form_validation->set_rules('permission','permission','required',
	                                            array('required' => 'Permission is required')
	                                        );

			if($this->form_validation->run() === FALSE)
	        {
	        	$this->data['brand_id'] = $brand_map_id;
	        	$this->data['brand_name'] = $brands_user->name;
	        	$this->data['permissions'] = $this->aauth->list_groups();
	            $this->data['view'] = 'brands/edit_user';

	            _render_view($this->data);
	        }
	        else
	        {
	        	$user_data = array(
	        					'first_name' => $this->input->post('first_name'),
	        					'last_name' => $this->input->post('last_name'),
	        					'title' => $this->input->post('title'),
	        					'timezone' => $this->input->post('timezone'),
	        					'company_name' => $this->user_data['company_name'],
	        					'company_email' => $this->user_data['company_email'],
	        					'company_url' =>  $this->user_data['company_url']
	        				);
	            $condition = array('id' => $this->input->post('user_id'));
                $this->timeframe_model->update_data('user_info',$user_data,$condition);

                //get previous permission
                $current_perm = $this->aauth->get_user_groups($brands_user->access_user_id);
                //remove previous permission and add new                
                $this->aauth->remove_member($brands_user->access_user_id,$current_perm[0]->group_id);
                $this->aauth->add_member($brands_user->access_user_id,$this->input->post('permission'));

                $this->session->set_flashdata('message','User has been updated successfully');
	                       
	    		redirect(base_url().'brand_users/index/'.$brands_user->brand_id);
		    }
		}
		else
		{
			$this->session->set_flashdata('error','Unable to update user, please try again');
			redirect(base_url().'brands');
		}
	}

	public function delete_user($brand_map_id)
	{
		if($brand_map_id)
		{
			$user_id = $this->user_id;
			$brands_user = $this->brand_model->check_brand_owner($brand_map_id,$user_id);
			if(!empty($brands_user))
			{
				$this->aauth->delete_user($brands_user->access_user_id);
				$this->timeframe_model->delete_data('user_info',array('aauth_user_id' => $brands_user->access_user_id));
				$this->timeframe_model->delete_data('brand_user_map',array('brand_id' => $brands_user->brand_id,'access_user_id' => $brands_user->access_user_id));
				$this->timeframe_model->delete_data('login_attempts',array('user_id' => $brands_user->access_user_id));
				$this->session->set_flashdata('message','Sub user deleted successfully');
				redirect(base_url().'brand_users/index/'.$brands_user->brand_id);
			}			
		}
		$this->session->set_flashdata('error','User is not available');
		redirect(base_url().'brands');
	}
}