<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/autoload.php');
class Payment extends CI_Controller {

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
	var $stripe_test_mode = '';
   	var $stripe_public_key = '';
    var $stripe_secret_key = '';	

	public function __construct()
	{
		parent::__construct();		
        is_user_logged();
        $this->load->model('user_model');
		$this->load->model('timeframe_model');

		$this->user_id = $this->session->userdata('id');

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
	}

	public function index()
	{
		$this->data = array();
		$user_id = $this->user_id;
		$this->data['billing_details'] = $this->user_model->get_billing_details($user_id);
		$this->data['plan'] = $this->user_model->get_current_plan($user_id);
		$this->data['countries'] = $this->timeframe_model->get_table_data('countries');
		
		$this->data['view'] = 'payment/make_payment';
        //addition js files to be added in page
        $this->data['js_files'] = array('https://js.stripe.com/v2/',js_url().'stripe.js');
        _render_view($this->data);
	}

	public function save_payment()
	{
		$user_id = $this->user_id;
		$user_token =  $this->input->post('stripe_token');

		if(!empty($user_token) && !empty($user_id))
		{
			$plan = $this->input->post('plan');
			
			$customer_info =  array(
									'email' => $this->input->post('email'),
									'description'=> ucfirst($plan)." Subscription",									
									'plan'=> $plan,
									"source" => $user_token
								);
			
			try
			{
				$response = \Stripe\Customer::create($customer_info);
				$response = $response->__toArray(true);

				if(!empty($response))
				{
					//billing details
					$billing_data = array(								
									'user_id' => $user_id,
									'name' => $this->input->post('name'),
									'address' => $this->input->post('address'),
									'city' => $this->input->post('city'),
									'state' => $this->input->post('state'),
									'zip' => $this->input->post('zip'),
									'country' => $this->input->post('country'),
									'email' => $this->input->post('email')
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
			    	}

					$customer_stripe_key = $response['id'];
					$subscription_info =  $response['subscriptions']['data'][0];
					$subscription_key_id = $subscription_info['id'];
					
					$transaction_data = array(								
								'plan' => $subscription_info['plan']['id'],
								'amount' => $subscription_info['plan']['amount'],
								'current_period_start' => $subscription_info['current_period_start'],
								'current_period_end' => $subscription_info['current_period_end'],								
								'stripe_customer_id' => $customer_stripe_key,
								'subscription_id' => $subscription_key_id,
								'card_id' => $response['sources']['data'][0]['id'],
								'transaction_status' => $subscription_info['status'],
								'paid_date' => date('Y-m-d H:i:s',strtotime($subscription_info['start'])),
								'response' => json_encode($response),
								'user_id' => $user_id
							);
					
					$this->timeframe_model->insert_data('transactions',$transaction_data);

					$user_data = array(
										'stripe_customer_id' => $customer_stripe_key,
										'stripe_subscription_id' => $subscription_key_id,
									);

					$condition = array('id' => $billing_id);
					$this->timeframe_model->update_data('user_info',$user_data,$condition);

					$this->session->set_flashdata('message', 'Thank you for your Subscription');
					redirect(base_url()."payment");
				}
			}
			catch(Exception $ex){
				$this->session->set_flashdata('error', 'Problem encountered while processing payment, please try again');
				redirect(base_url()."payment");
			}

		}
		else
		{
			$this->data = array();
			$this->data['countries'] = $this->timeframe_model->get_table_data('countries');
			$this->data['error'] = "The Stripe Token was not generated correctly";

			$this->data['view'] = 'payment/make_payment';
	        $this->data['layout'] = 'layouts/user_layout';       
	        //addition js files to be added in page
	        $this->data['js_files'] = array('https://js.stripe.com/v2/',js_url().'stripe.js');
	        _render_view($this->data);
		}
	}
}
