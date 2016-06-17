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
		$this->user_data = $this->session->userdata('user_info');
	}

	function index()
	{
		$page = $this->uri->segment(2);
		
		if(empty($page))
		{
			$page = 'user_info';
		}
		$this->data['background_image'] = 'bg-admin-overview.jpg';
		$this->data['view_name'] = $page;
		$this->data['view'] = 'user_preferences/preference_layout';
		$this->data['layout'] = 'layouts/new_user_layout';
		
		if($page == 'user_info')
		{
			$this->data['timezones_list'] = $this->user_model->get_timezones();
			$this->data['user_details'] = $this->user_model->get_user($this->user_id);
		}
		
		if($page == 'user_plan')
		{
			$this->data['user_details'] = $this->user_model->get_user($this->user_id);
		}

		if($page == 'billing_info')
		{
			$this->data['countries'] = $this->timeframe_model->get_table_data('countries');
			//echo '<pre>'; print_r($this->data['countries'] );echo '</pre>'; die;
		}
		$this->data['css_files'] = array(css_url().'fullcalendar.css');
		$this->data['js_files'] = array(js_url().'vendor/jquery-ui-sortable.min.js', js_url().'reorder-brands.js?ver=1.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'jquery.mask.min.js?ver=2.11.0', js_url().'jquery.validate.min.js?ver=2.11.0', js_url().'timeframe_forms.js?ver=2.11.0',js_url().'user_preference.js?ver=2.11.0');
        _render_view($this->data);

	}

	function edit_my_info()
	{
		$post_data = $this->input->post();
		if(!empty($post_data['aauth_user_id']))
		{
			if(!empty($post_data['password']))
			{
				 $status = $this->aauth->update_user($this->user_id,'',$post_data['password'],'');
			}
			
			$condition = array('aauth_user_id'=>$this->user_id	);
			
			$user_data = array(
							'first_name' => $post_data['first_name'],
							'last_name' => $post_data['last_name'],
							'phone' => $post_data['phone'],
							'timezone' => $post_data['timezone'],
							'company_name' => $post_data['company_name'],
							'company_email' => $post_data['company_email'],
							'company_url' => $post_data['company_url'],
						);
            $this->timeframe_model->update_data('user_info',$user_data,$condition);
            
            redirect(base_url().'user_preferences/user_info');
		}
	}

	function change_plan()
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

						$this->session->set_flashdata('message','Plan changed successfully');
		            }
		            else
		            {
		            	$this->session->set_flashdata('error','Unable to change plan, Please try again');
		            }
		            redirect(base_url().'user_preferences/user_plan');
		        }
		        catch(Exception $ex){
					$this->session->set_flashdata('error', 'Problem encountered while processing payment, please try again');

					redirect(base_url().'user_preferences/user_plan');
				}
			}

        }
	}


}