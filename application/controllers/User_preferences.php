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
		$this->user_id = $this->session->userdata('id');
		$this->email = $this->session->userdata('email');
		$this->user_data = $this->session->userdata('user_info');
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
	}

	function index()
	{
		$page = $this->uri->segment(2);
		
		if(empty($page))
		{
			$page = 'user_info';
		}

		$this->data['css_files'] = array(css_url().'intlTelInput.css',css_url().'fullcalendar.css',css_url().'jquery.Jcrop.css',css_url().'custom.css');
		$this->data['js_files'] = array(js_url().'vendor/jquery-ui-sortable.min.js', js_url().'reorder-brands.js?ver=1.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'jquery.mask.min.js?ver=2.11.0', js_url().'jquery.validate.min.js?ver=2.11.0', js_url().'timeframe_forms.js?ver=2.11.0',js_url().'jquery.Jcrop.js?ver=1.0.0',js_url().'jquery.SimpleCropper.js?ver=1.0.0', js_url().'vendor/intlTelInput.min.js?ver=9.0.2', js_url().'user_preference.js?ver=2.11.0');

		$this->data['background_image'] = 'bg-admin-overview.jpg';
		$this->data['view_name'] = $page;
		$this->data['view'] = 'user_preferences/preference_layout';
		$this->data['layout'] = 'layouts/new_user_layout';
		
		if($page == 'user_info')
		{
			$this->data['timezones_list'] = $this->user_model->get_timezones();
			$this->data['user_details'] = $this->user_model->get_user($this->user_id);			
		}
				
		// if($this->user_id == $this->user_data['account_id'])
		// {
			if($page == 'user_plan')
			{
				$this->data['billing_details'] = $this->user_model->get_billing_details($this->user_id);
				$this->data['user_details'] = $this->user_model->get_user($this->user_id);
			}

			if($page == 'billing_info')
			{
				$this->data['billing_details'] = $this->user_model->get_billing_details($this->user_id);
				$this->data['plan'] = $this->user_model->get_current_plan($this->user_id);
				$this->data['countries'] = $this->timeframe_model->get_table_data('countries');
				
				$this->data['js_files'][] = 'https://js.stripe.com/v2/';
				$this->data['js_files'][] = js_url().'stripe.js?ver=2.11.0';
			}
			
			_render_view($this->data);
		// }
		// else
		// {
		// 	_render_view($this->data);
		// }
	}

	function edit_my_info()
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
							'company_name' => $post_data['company_name'],
							'company_email' => $post_data['company_email'],
							'company_url' => $post_data['company_url'],
							'email_notification' =>$email_notification,
							'desktop_notification' =>$desktop_notification,
							'urgent_notification' =>$urgent_notification
						);
            $this->timeframe_model->update_data('user_info',$user_data,$condition);
           	$img_folder = $this->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id' => $this->user_id),'img_folder');

           	$user_data['user_info_id'] = $post_data['aauth_user_id'];
           	$user_data['created_by'] = $this->user_data['created_by'];
           	$user_data['img_folder'] = $this->user_data['img_folder'];
           	$user_data['accounts'] = $this->user_data['accounts'];
           	$user_data['account_id'] = $this->user_data['account_id'];
           	$user_data['plan'] = $this->user_data['plan'];

           	$this->session->set_userdata('user_info',$user_data);

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
        	redirect(base_url().'user_preferences/user_info');
		}
	}

	function change_plan()
	{

		if($this->user_data['account_id'] == $this->user_id)
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

	        	$condition = array('id' => $this->user_data['user_info_id']);
				$select =array('stripe_customer_id','stripe_subscription_id');
				$strip_info = $this->timeframe_model->get_data_by_condition('user_info',$condition,$select);
				$last_transaction = $this->user_model->get_last_transaction($this->user_id);
				
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
											'user_id' => $this->user_id
										);
							$this->timeframe_model->insert_data('transactions',$transaction_data);

							$user_info = array(								
											'plan' => $subscription_info['plan']['id']									
										);						

							$this->timeframe_model->update_data('user_info',$user_info,array('id' => $this->user_data['user_info_id']));

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
	}

	public function save_payment()
	{
		if($this->user_data['account_id'] == $this->user_id)
		{
			$user_id = $this->user_id;
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
					$last_transaction = $this->user_model->get_last_transaction($this->user_id);
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
							$condition = array('id' => $this->user_data['user_info_id']);
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
				$this->data['billing_details'] = $this->user_model->get_billing_details($this->user_id);			
				$this->data['plan'] = $this->user_model->get_current_plan($this->user_id);
				$this->data['countries'] = $this->timeframe_model->get_table_data('countries');
		        //addition js files to be added in page
		        $this->data['js_files'] = array(js_url().'vendor/jquery-ui-sortable.min.js', js_url().'reorder-brands.js?ver=1.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'jquery.mask.min.js?ver=2.11.0', js_url().'jquery.validate.min.js?ver=2.11.0', js_url().'timeframe_forms.js?ver=2.11.0',js_url().'user_preference.js?ver=2.11.0','https://js.stripe.com/v2/',js_url().'stripe.js');

		        _render_view($this->data);
			}
		}
	}

}