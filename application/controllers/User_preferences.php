<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
class User_preferences extends CI_Controller {

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
        $this->load->model('user_model');
        $this->load->model('timeframe_model');
        $this->load->model('brand_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
	}

	public function index()
	{
		$page = $this->uri->segment(2);
		
		if(empty($page))
		{
			$page = 'user_info';
		}

		$this->data['css_files'] = array(css_url().'intlTelInput.css',css_url().'fullcalendar.css',css_url().'jquery.Jcrop.css');

		$this->data['js_files'] = array(js_url().'vendor/jquery-ui-sortable.min.js',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'jquery.mask.min.js?ver=2.11.0', js_url().'jquery.validate.min.js?ver=2.11.0', js_url().'timeframe_forms.js?ver=2.11.0',js_url().'jquery.Jcrop.js?ver=1.0.0',js_url().'jquery.SimpleCropper.js?ver=1.0.0', js_url().'vendor/intlTelInput.min.js?ver=9.0.2', js_url().'user_preference.js?ver=2.11.0');

		$this->data['background_image'] = 'bg-admin-overview.jpg';
		$this->data['view_name'] = $page;
		$this->data['view'] = 'user_preferences/preference_layout';
		$this->data['layout'] = 'layouts/new_user_layout';
		
		if($page == 'user_info')
		{
			$this->data['timezones_list'] = $this->user_model->get_timezones();
			$this->data['user_details'] = $this->user_model->get_user($this->user_id);
			$master_info = $this->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id' => $this->user_data['account_id']),'company_name,company_email,company_url');
			if(!empty($master_info))
			{
				$this->data['user_details']->company_name = $master_info[0]->company_name;
				$this->data['user_details']->company_email = $master_info[0]->company_email;
				$this->data['user_details']->company_url = $master_info[0]->company_url;
			}			
		}

		$this->data['billing_details'] = $this->user_model->get_billing_details($this->user_data['account_id']);

		if($page == 'user_plan')
		{			
			$this->data['user_details'] = $this->user_model->get_user($this->user_id);			

			$this->load->model('brand_model');
			$this->data['all_users'] = $this->brand_model->get_all_users($this->user_data['account_id']);

			$this->data['master_users'] = $this->brand_model->get_all_master_users($this->user_data['account_id']);

			$brands = $this->timeframe_model->get_data_by_condition('brands',array('account_id' => $this->user_data['account_id']),'id');
			$this->data['brand_count'] = 0;
			if(!empty($brands))
			{
				$this->data['brand_count'] = count($brands);
			}

			$this->data['brand_wise_tags'] = $this->brand_model->get_brand_wise_tags();
			$this->data['brand_wise_outlets'] = $this->brand_model->get_brand_wise_outlets();
		}

		if($page == 'billing_info')
		{
			$this->data['plan'] = $this->user_model->get_current_plan($this->user_id);
			$this->data['countries'] = $this->timeframe_model->get_table_data('countries');
			$this->data['email'] = $this->session->userdata('email');
			
			$this->data['js_files'][] = 'https://js.stripe.com/v2/';
			$this->data['js_files'][] = js_url().'stripe.js?ver=2.11.0';
		}
		
		if($page == 'users')
		{
			$this->data['js_files'][] = js_url().'add-brand.js?ver=2.11.0';
			$this->data['js_files'][] = js_url().'vendor/bootstrap-colorpicker.min.js?ver=2.3.3';

			$this->data['groups'] = $this->aauth->list_groups();

			$this->load->model('brand_model');
			
			$this->data['added_users']  = $this->user_model->get_users_by_parent_id( $this->user_data['account_id']);
			$users_ids = array();
			if(!empty($this->data['added_users']))
			{
				foreach ($this->data['added_users']  as $key => $user) 
				{
					$users_id[] =  $user->aauth_user_id;
				}
			}
			$this->data['users'] = $this->brand_model->get_users_sub_users($this->user_id,'',$users_ids);
			$this->data['all_users_count'] = $this->brand_model->get_all_users();
			$this->data['master_user_count'] = $this->brand_model->get_all_master_users();
		}
		_render_view($this->data);
	}

	public function edit_my_info()
	{
		$post_data = $this->input->post();
		$email_notification = $desktop_notification = $urgent_notification = 1 ;
		$old_hashed_pass = $this->aauth->hash_password($post_data['current_password'],$this->user_id);
		$user_info = $this->aauth->get_user();	
		if(!empty($post_data['aauth_user_id']))
		{
			if(!empty($post_data['current_password']))
			{
				if($user_info->pass == $old_hashed_pass ){
					$status = $this->aauth->update_user($this->user_id,'',$post_data['new_password'],'');
				}else{
					$this->session->set_flashdata('message', $this->lang->line('wrong_current_pass'));
					redirect(base_url().'user_preferences/user_info');
				}
			}

			if(!empty($post_data['email_notification']) && $post_data['email_notification'] == 'yes' )
			{
				$email_notification = 0;
			}
			if(!empty($post_data['desktop_notification']) && $post_data['desktop_notification'] == 'yes' )
			{
				$desktop_notification = 0;
			}
			if(!empty($post_data['urgent_notification']) && $post_data['urgent_notification'] == 'yes' )
			{
				$urgent_notification = 0;
			}
			
			$condition = array('aauth_user_id'=>$this->user_id);
			
			$user_data = array(
							'first_name' => $post_data['first_name'],
							'last_name' => $post_data['last_name'],
							'phone' => $post_data['phoneNumber'],
							'timezone' => $post_data['timezone'],							
							'email_notification' =>$email_notification,
							'desktop_notification' =>$desktop_notification,
							'urgent_notification' =>$urgent_notification
						);
            $this->timeframe_model->update_data('user_info',$user_data,$condition);
            $master_user_data = array(
            				'company_name' => $post_data['company_name'],
							'company_email' => $post_data['company_email'],
							'company_url' => $post_data['company_url']
						);
            $this->timeframe_model->update_data('user_info',$master_user_data,array('aauth_user_id' => $this->user_data['account_id']));
            
           	$img_folder = $this->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id' => $this->user_id),'img_folder');

           	$user_data['user_info_id'] = $post_data['aauth_user_id'];
           	$user_data['created_by'] = $this->user_data['created_by'];
           	$user_data['img_folder'] = $this->user_data['img_folder'];
           	$user_data['accounts'] = $this->user_data['accounts'];
           	$user_data['account_id'] = $this->user_data['account_id'];
           	$user_data['plan'] = $this->user_data['plan'];

           	$this->session->set_userdata('user_info',$user_data);

           	if($post_data['is_user_image'] == 'yes'){
	            if(!empty($post_data['user_pic_base64'])){
	        		$base64_image = $post_data['user_pic_base64'];
	    		  	$base64_str = substr($base64_image, strpos($base64_image, ",")+1);

		        	//decode base64 string
			        $decoded = base64_decode($base64_str);

			        //create jpeg from decoded base 64 string and save the image in the parent folder

			        if(!is_dir(upload_path().$img_folder[0]->img_folder.'/users/')){
			        	mkdir(upload_path().$img_folder[0]->img_folder.'/users/',0755,true);
			        }
			        $url = upload_path().$img_folder[0]->img_folder.'/users/'.$this->user_id.'.png';
			        $result = file_put_contents($url, $decoded);
			        $source_url = imagecreatefrompng($url);

			        header('Content-Type: image/png');
			        imagepng($source_url, $url, 8);
	        	}
        	}else{
	        	$url = upload_path().$img_folder[0]->img_folder.'/users/'.$this->user_id.'.png';
	        	delete_file($url);
	        }
        	redirect(base_url().'user_preferences/user_info');
		}
	}

	public function change_plan()
	{
		$this->data = array();		
        $this->form_validation->set_rules('plan','plan','required',                                            
                                            array('required' => 'Plan is required')
                                        );

        if ($this->form_validation->run() === FALSE)
        {
            redirect(base_url().'user_preferences/user_plan');
        }
        else
        {
        	$this->stripe_test_mode = $this->config->item('stripe_test_mode');
	    	if($this->stripe_test_mode == TRUE)
	    	{
	      		$this->stripe_public_key = $this->config->item('stripe_key_test_public');
	      		$this->stripe_secret_key = $this->config->item('stripe_key_test_secret');
	        }
		    else
		    {
		    	$this->stripe_public_key = $this->config->item('stripe_key_live_public'); 
		      	$this->stripe_secret_key = $this->config->item('stripe_key_live_secret');
		    }

		    \Stripe\Stripe::setApiKey($this->stripe_secret_key);

        	$condition = array('id' => $this->user_data['account_id']);
			$select =array('stripe_customer_id','stripe_subscription_id');
			$strip_info = $this->timeframe_model->get_data_by_condition('user_info',$condition,$select);
			
			$this->load->model('transaction_model');
			$last_transaction = $this->transaction_model->get_last_transaction($this->user_data['account_id']);
			
			if(!empty($last_transaction))
			{
				try
				{
					$cu = \Stripe\Customer::retrieve($strip_info[0]->stripe_customer_id);
					$subscription = $cu->subscriptions->retrieve($strip_info[0]->stripe_subscription_id);
					$subscription->plan = $this->input->post('plan');
					$response = $subscription->save();
					$response = $response->__toArray(true);				
					
					$card_id = $last_transaction->card_id;
					$subscription_key_id = $response['id'];
					$customer_stripe_key = $response['customer'];
					$subscription_info = $response;
					
					if(!empty($response))
					{
						$transaction_data = array(								
										'plan' => $subscription_info['plan']['id'],
										'amount' => $subscription_info['plan']['amount'],
										'current_period_start' => $subscription_info['current_period_start'],
										'current_period_end' => $subscription_info['current_period_end'],
										'stripe_customer_id' => $customer_stripe_key,
										'subscription_id' => $subscription_key_id,
										'card_id' => $card_id,
										'transaction_status' => $subscription_info['status'],
										'paid_date' => date('Y-m-d H:i:s',$subscription_info['start']),
										'response' => json_encode($response),
										'user_id' => $this->user_data['account_id']
									);
						$this->timeframe_model->insert_data('transactions',$transaction_data);

						$user_info = array(								
										'plan' => $subscription_info['plan']['id']									
									);						

						$this->timeframe_model->update_data('user_info',$user_info,array('aauth_user_id' => $this->user_data['account_id']));

						$this->session->set_flashdata('message',$this->lang->line('unable_to_change_plan'));
		            }
		            else
		            {
		            	$this->session->set_flashdata('error',$this->lang->line('unable_to_change_plan'));
		            }
		            redirect(base_url().'user_preferences/user_plan');
		        }
		        catch(Exception $ex){
					$this->session->set_flashdata('error', $this->lang->line('payment_processing_error'));

					redirect(base_url().'user_preferences/user_plan');
				}
			}
			redirect(base_url().'user_preferences/user_plan');
		}
	}

	public function save_payment()
	{
		$user_id = $this->user_data['account_id'];
		$user_token =  $this->input->post('stripe_token');

		if(!empty($user_token) && !empty($user_id))
		{
			$plan = $this->input->post('plan');			
			try
			{
				$this->stripe_test_mode = $this->config->item('stripe_test_mode');
		    	if($this->stripe_test_mode == TRUE)
		    	{
		      		$this->stripe_public_key = $this->config->item('stripe_key_test_public');
		      		$this->stripe_secret_key = $this->config->item('stripe_key_test_secret');
		        }
			    else
			    {
			    	$this->stripe_public_key = $this->config->item('stripe_key_live_public'); 
			      	$this->stripe_secret_key = $this->config->item('stripe_key_live_secret');
			    }

		   		\Stripe\Stripe::setApiKey($this->stripe_secret_key);

				//check customer is already subscribed
				$condition = array('id' => $this->user_data['user_info_id']);
				$select =array('stripe_customer_id','stripe_subscription_id');
				$strip_info = $this->timeframe_model->get_data_by_condition('user_info',$condition,$select);
				
				$this->load->model('transaction_model');
				$last_transaction = $this->transaction_model->get_last_transaction($this->user_data['account_id']);
				if(!empty($last_transaction))
				{
					$customer = \Stripe\Customer::retrieve($strip_info[0]->stripe_customer_id);
					$response = $customer->sources->create(array("source" => $user_token));
					$response = $response->__toArray(true);					
					$credit_card_id =  $response['id'];
					$customer->default_source=$credit_card_id;
					$customer->save();
				}
				else
				{

					$customer_info =  array(
									'email' => $this->input->post('email'),
									'description'=> ucfirst($plan)." Subscription",									
									'plan'=> $plan,
									"source" => $user_token
								);


					$response = \Stripe\Customer::create($customer_info);
					$response = $response->__toArray(true);						
					$customer_stripe_key = $response['id'];
					$subscription_info =  $response['subscriptions']['data'][0];
					$subscription_key_id = $subscription_info['id'];
					$card_id = $response['sources']['data'][0]['id'];

					$transaction_data = array(								
								'plan' => $subscription_info['plan']['id'],
								'amount' => $subscription_info['plan']['amount'],
								'current_period_start' => $subscription_info['current_period_start'],
								'current_period_end' => $subscription_info['current_period_end'],								
								'stripe_customer_id' => $customer_stripe_key,
								'subscription_id' => $subscription_key_id,
								'card_id' => $card_id,
								'transaction_status' => $subscription_info['status'],
								'paid_date' => date('Y-m-d H:i:s',$subscription_info['start']),
								'response' => json_encode($response),
								'user_id' => $user_id
							);
					$this->timeframe_model->insert_data('transactions',$transaction_data);
					
				}	

				if(!empty($response))
				{
					//billing details
					$billing_data = array(
									'user_id' => $user_id,
									'cc_number' => substr($this->input->post('cc_number'), -4),
									'cvc' => '***',
									'name' => $this->input->post('name'),
									'address' => $this->input->post('address'),
									'city' => $this->input->post('city'),
									'state' => $this->input->post('state'),
									'zip' => $this->input->post('zip'),
									'country' => $this->input->post('country'),
									'email' => $this->input->post('email'),
									'exp_month' => $this->input->post('expiry_month'),
									'exp_year' => $this->input->post('expiry_year')
								);

					$billing_id = $this->input->post('billing_id');
					if(!empty($billing_id))
					{
						$condition = array('id' => $billing_id);
						$this->timeframe_model->update_data('billing_details',$billing_data,$condition);
					}
					else
					{
						// //insert billing details
			    		$this->timeframe_model->insert_data('billing_details',$billing_data);
			    		$stripe_info = array(
										'stripe_customer_id' => $customer_stripe_key,
										'stripe_subscription_id' => $subscription_key_id,
									);					
						$condition = array('id' => $this->user_data['account_id']);
	                    $this->timeframe_model->update_data('user_info',$stripe_info,$condition);
			    	}					

					$this->session->set_flashdata('message', $this->lang->line('subscription_thank_you'));
					redirect(base_url()."user_preferences/billing_info");
				}
			}
			catch(Exception $ex){
				$this->session->set_flashdata('error', $this->lang->line('payment_processing_error'));
				redirect(base_url()."user_preferences/billing_info");
			}

		}
		else
		{
			$this->data['billing_details'] = $this->user_model->get_billing_details($this->user_data['account_id']);			
			$this->data['plan'] = $this->user_model->get_current_plan($this->user_id);
			$this->data['countries'] = $this->timeframe_model->get_table_data('countries');
	        //addition js files to be added in page
	        $this->data['js_files'] = array(js_url().'vendor/jquery-ui-sortable.min.js', js_url().'reorder-brands.js?ver=1.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'jquery.mask.min.js?ver=2.11.0', js_url().'jquery.validate.min.js?ver=2.11.0', js_url().'timeframe_forms.js?ver=2.11.0',js_url().'user_preference.js?ver=2.11.0','https://js.stripe.com/v2/',js_url().'stripe.js');

	        _render_view($this->data);
		}
	}

	public function add_user()
	{
    	$post_data = $this->input->post();
    	$is_present = $this->aauth->user_exist_by_email($post_data['email']);
    	$user_in_other_brand = 0;
    	if($is_present)
		{
			$user_in_other_brand = 1;
			$inserted_id = $this->aauth->get_user_id($post_data['email']);
			$this->user_model->delete_user_permissions($inserted_id,$this->user_data['account_id']);
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
                            'username' => $this->input->post('first_name'),
                            'img_folder' => $this->user_data['account_id']
        				);

        	$this->load->helper('email');

        	$this->data['user'] = $user_data;
            
        	$inserted_id = $this->aauth->create_user_without_email($post_data['email'],$password);
        	unset($user_data['password']);
        	unset($user_data['username']);
        }
       
        $group_id = $this->aauth->get_group_id($post_data['role']);

        if($inserted_id)
    	{
    		$brands = $this->brand_model->get_accounts_brands();
    		if(!empty($brands))
    		{
    			$brand_order = $this->timeframe_model->get_data_by_condition('brand_order',array('user_id' => $inserted_id,'account_id' => $this->user_data['account_id']));
    			if(!empty($brand_order))
    			{
    				$this->timeframe_model->delete_data('brand_order',array('user_id' => $inserted_id,'account_id' => $this->user_data['account_id']));
    			}

    			$order = $this->timeframe_model->get_max('brand_order','order',array('user_id' => $inserted_id,'account_id' => $this->user_data['account_id']));
    			foreach($brands as $brand)
    			{
		            $brand_order_data = array(
		            					'order' => $order !== FALSE ? ++$order : 0,
		            					'account_id' => $this->user_data['account_id'],
		            					'user_id' => $inserted_id,
		            					'brand_id' => $brand->id
		            				);
		            $this->timeframe_model->insert_data('brand_order',$brand_order_data);
    			}
    		}
    		$this->aauth->add_member($inserted_id, $group_id, NULL , $this->user_data['account_id']);

    		$permissions = $this->aauth->get_groups_perm($group_id);
    		if(!empty($permissions))
        	{
        		foreach($permissions as $permission)
        		{
        			$this->aauth->allow_user($inserted_id,$permission->perm_id,NULL,$this->user_data['account_id']);
        		}
        	}

        	$user_data['aauth_user_id'] = $inserted_id;
        	$user_data['img_folder'] = $this->user_data['account_id'];

        	if($user_in_other_brand == 0)
    		{
        		$this->timeframe_model->insert_data('user_info',$user_data);
        	}

        	$user_img_folder = $this->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id' => $inserted_id),'img_folder');
        	
        	//add permission to user

        	if(isset($post_data['user_pic_base64']) && !empty($post_data['user_pic_base64'])){
        		$base64_image = $post_data['user_pic_base64'];
    		  	$base64_str = substr($base64_image, strpos($base64_image, ",")+1);

	        	//decode base64 string
		        $decoded = base64_decode($base64_str);

		        //create jpeg from decoded base 64 string and save the image in the parent folder

		        if(!is_dir(upload_path().$user_img_folder[0]->img_folder.'/users/')){
		        	mkdir(upload_path().$user_img_folder[0]->img_folder.'/users/',0755,true);
		        }
		        $url = upload_path().$user_img_folder[0]->img_folder.'/users/'.$inserted_id.'.png';	
		        $result = file_put_contents($url, $decoded);

		        $source_url = imagecreatefrompng($url);
		        
		        header('Content-Type: image/png');
		        imagepng($source_url, $url, 8);
        	}
        	
        	if(isset($is_present))
			{
				$this->data['company_name'] = get_company_name($this->user_data['account_id']);
				$this->data['role'] = $post_data['role'];
				try
				{
			    	$email = $post_data['email'];
			    	$subject = "You have been addded in new account";
			    	$content = $this->load->view('mails/new_account_info',$this->data,true);
			    	$mail_send = email_send($email, $subject,$content);
			    	$this->session->set_flashdata('message', $this->lang->line('user_add_success'));
			    }
				catch (SomeException $e)
				{
					$this->session->set_flashdata('message', $this->lang->line('user_add_success'));
				}
			}
			
			redirect(base_url().'user_preferences/users');
        }
        else
        {
        	$this->session->set_flashdata('message',$this->lang->line('unable_to_add_user'));
        	
     		redirect();
        }
    }

    public function edit_user_info()
    {
    	$post_data = $this->input->post();
    	if(!empty($post_data['user_id']))
    	{
    		$user_id = $post_data['user_id'];
    		$user_info = array(
	        		'first_name'=> $post_data['first_name'],
	        		'last_name'=> $post_data['last_name'],
	        		'title'=> $post_data['title']
	        	);

    		$condition = array('aauth_user_id' => $user_id);
	       	$this->timeframe_model->update_data('user_info',$user_info,$condition);

	        // Update user profile image
    		$user_img = $this->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id' => $user_id),'img_folder');

    		if(empty($post_data['previous_group']))
    		{
	    		$brands = $this->brand_model->get_accounts_brands();
	    		if(!empty($brands))
	    		{
	    			$brand_order = $this->timeframe_model->get_data_by_condition('brand_order',array('user_id' => $user_id,'account_id' => $this->user_data['account_id']));
	    			if(!empty($brand_order))
	    			{
	    				$this->timeframe_model->delete_data('brand_order',array('user_id' => $user_id,'account_id' => $this->user_data['account_id']));
	    			}

	    			$order = $this->timeframe_model->get_max('brand_order','order',array('user_id' => $user_id,'account_id' => $this->user_data['account_id']));
	    			foreach($brands as $brand)
	    			{
			            $brand_order_data = array(
			            					'order' => $order !== FALSE ? ++$order : 0,
			            					'account_id' => $this->user_data['account_id'],
			            					'user_id' => $user_id,
			            					'brand_id' => $brand->id
			            				);
			            $this->timeframe_model->insert_data('brand_order',$brand_order_data);
	    			}
	    		}
	    	}
	        if($post_data['is_user_image'] == 'yes')
	        {
	        	if(isset($post_data['user_pic_base64']) && !empty($post_data['user_pic_base64']))
	        	{
	        		$base64_image = $post_data['user_pic_base64'];
	    		  	$base64_str = substr($base64_image, strpos($base64_image, ",")+1);

		        	//decode base64 string
			        $decoded = base64_decode($base64_str);

			        //create jpeg from decoded base 64 string and save the image in the parent folder

			        if(!is_dir(upload_path().$user_img[0]->img_folder.'/users/')){
			        	mkdir(upload_path().$user_img[0]->img_folder.'/users/',0755,true);
			        }
			        $url = upload_path().$user_img[0]->img_folder.'/users/'.$user_id.'.png';	
			        
			        $result = file_put_contents($url, $decoded);
			        
			        $source_url = imagecreatefrompng($url);
			        
			        header('Content-Type: image/png');
			        
			        imagepng($source_url, $url, 8);
	        	}
	        }
	        else if($post_data['is_user_image'] == 'no')
	        {
	        	$url = upload_path().$user_img[0]->img_folder.'/users/'.$user_id.'.png';
	        	delete_file($url);
	        }
	        // Delete all permissions of user  
	        $this->user_model->delete_user_permissions($user_id,$this->user_data['account_id']);

	        //  Get user old Permissions and Groups and remove old and add New 
        	$old_role = strtolower(get_user_groups($user_id,NULL,$this->user_data['account_id']));
        	$group_id = $this->aauth->get_group_id($post_data['role']);
	        $this->aauth->remove_member($user_id, $old_role,NULL,$this->user_data['account_id']);
	       	$this->aauth->add_member($user_id, $group_id, '' , $this->user_data['account_id']);
	       	$old_permissions = $this->aauth->get_user_perm($user_id,NULL,$this->user_data['account_id']);
	       	if(!empty($old_permissions)){
        		foreach ($old_permissions as $key => $per_obj) {
        			$this->aauth->deny_user($user_id, $per_obj->perm_id,NULL,$this->user_data['account_id']);
        		}
        	}
        	$permissions = $this->aauth->get_groups_perm($group_id);
        	
	        if(!empty($permissions))
        	{
        		foreach($permissions as $permission)
        		{
	        		$this->aauth->allow_user($user_id,$permission->perm_id,NULL,$this->user_data['account_id']);
        		}
        	}
        	redirect(base_url().'user_preferences/users');
    	}
    }

}