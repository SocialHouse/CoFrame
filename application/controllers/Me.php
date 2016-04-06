<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');

class Me extends CI_Controller {

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
		$this->load->model('user_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	public function edit_profile()
	{
		$this->data = array();
		$this->data['user'] = $this->user_model->get_user($this->user_id);
		$this->data['timezones'] = $this->user_model->get_timezones();
		$this->data['view'] = 'me/edit_profile';
        _render_view($this->data);
	}

	public function update_user()
	{
		$this->data = array();
        $this->form_validation->set_rules('first_name','first name','required',                                            
                                            array('required' => 'First name is required')
                                        );
        $this->form_validation->set_rules('last_name','last name','required',
                                            array('required' => 'Last name is required')
                                        );
        $this->form_validation->set_rules('timezone','timezone','required',
                                            array('required' => 'Timezone is required')
                                        );
        $this->form_validation->set_rules('password','password','required',
                                            array('required' => 'Password is required')
                                        );       
        $this->form_validation->set_rules('phone','phone','regex_match[/^[0-9().-]+$/]',
                                            array('regex_match' => 'Please enter valid phone number')
                                        );
        $this->form_validation->set_rules('company_email','company_email','valid_email',
                                            array('valid_email' => 'Please enter valid email')
                                        );

        

        if ($this->form_validation->run() === FALSE)
        {
            $this->data['timezones'] = $this->user_model->get_timezones();
            $this->data['view'] = 'register';
            $this->data['layout'] = 'layouts/login_layout';

            _render_view($this->data);
        }
        else
        {
            $user_data = array(
                            'first_name' => $this->input->post('first_name'),
                            'last_name' => $this->input->post('last_name'),
                            'phone' => $this->input->post('phone'),
                            'timezone' => $this->input->post('timezone'),
                            'company_name' => $this->input->post('company_name'),
                            'company_email' => $this->input->post('company_email'),
                            'company_url' => $this->input->post('company_url')                            
                        );
            
            $status = $this->aauth->update_user($this->user_id,'',$this->input->post('password'),'');
            
            if($status)
            {
            	$condition = array('id' => $this->user_data['user_info_id']);
                $this->timeframe_model->update_data('user_info',$user_data,$condition);
            	
                $class = 'message';
                $message = 'Your information has been updated successfully';
            }
            else
            {
            	$class = 'error';
                $message = 'Unable to update information please try again';
            }

            $this->session->set_flashdata($class,$message);
            redirect(base_url().'me/edit_profile');
        }
	}

	public function edit_billing_details()
	{
		$this->data = array();
		$this->data['billing_details'] = $this->user_model->get_billing_details($this->user_id);
		$this->data['timezones'] = $this->user_model->get_timezones();
		$this->data['countries'] = $this->timeframe_model->get_table_data('countries');

		$this->data['js_files'] = array('https://js.stripe.com/v2/',js_url().'stripe.js');

		$this->data['view'] = 'me/edit_billing_details';
        _render_view($this->data);
	}

	public function save_billing_details()
	{
		$user_id = $this->user_id;
		// $user_token =  $this->input->post('stripe_token');

		if(!empty($user_id))
		{
			// $this->stripe_test_mode = $this->config->item('stripe_test_mode');
	  //   	if($this->stripe_test_mode == TRUE)
	  //   	{
	  //     		$this->stripe_public_key = $this->config->item('stripe_key_test_public');
	  //     		$this->stripe_secret_key = $this->config->item('stripe_key_test_secret');
	  //       }
		 //    else
		 //    {
		 //    	$this->stripe_public_key = $this->config->item('stripe_key_live_public'); 
		 //      	$this->stripe_secret_key = $this->config->item('stripe_key_live_secret');
		 //    }

	  //   	\Stripe\Stripe::setApiKey($this->stripe_secret_key);

			// $condition = array('id' => $this->user_data['user_info_id']);
			// $select =array('stripe_customer_id');
			// $strip_token = $this->timeframe_model->get_data_by_condition('user_info',$condition,$select);
			

			// $customer = \Stripe\Customer::retrieve($strip_token[0]->stripe_customer_id);

			// $card_id = $this->user_model->get_last_transaction($this->user_id);
			
			// $card = $customer->sources->retrieve($card_id->card_id);

			// $card->name = $this->input->post('name_on_card');
			// $card->exp_month = $this->input->post('expiry_month');
			// $card->exp_year = $this->input->post('expiry_year');
			// $card->zip = $this->input->post('zip');
			// $card->country = $this->input->post('country');
			// $card->save();

			$billing_data = array(
									'cc_number' => substr($this->input->post('cc_number'), -4),
									'cvc' => '***',
									'user_id' => $user_id,
									'name' => $this->input->post('name'),
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
	    		$this->timeframe_model->insert_data('billing_details',$billing_data);
	    	}
	    	redirect(base_url().'me/edit_billing_details');
		}
	}


}