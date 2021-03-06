<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tour extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
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
        $this->load->model('user_model');
        $this->load->model('timeframe_model');        
    }

    public function index()
    {
        $this->user_data = $this->session->userdata('user_info');
        if($this->user_data['user_info_id']){
            redirect(base_url().'brands/overview');
        }
        //echo '<pre>'; print_r($this->user_data );echo '</pre>'; die;
        $this->data['timezones'] = $this->user_model->get_timezones();
        load_tour_view($this->data);
        // $this->load->view('tour/tour',$this->data);
        $this->load->view('partials/modals');
    }

    public function check_login()
    {
        $this->data = array();
        $post_data = $this->input->post();
        if($this->aauth->login($post_data['email'], $post_data['password']))
        {
            $user_id = $this->session->userdata('id');
            // $is_exists = $this->user_model->check_login_attempt($user_id);
            // if($is_exists)
            // {
                $user = $this->user_model->get_user($user_id);

                // if($user->is_trial_period_expired){
                //     echo json_encode(array('response' => 'fail','message'=>$this->lang->line('trial_period_expiried')));
                //     $this->aauth->logout();
                //     exit();
                // }

                // get brand id to find my brand owner  
                // if $my_brand_id (in else case ) id null then me as brand owner 
                $my_brand_id = get_my_brand($user_id);
                if(empty($my_brand_id)){
                   // get_my_brand
                    $created_by = $user_id;
                }else{
                    $select ='created_by';
                    $table = 'brands';
                    $condition= array('id'=>$my_brand_id);
                    $result= $this->timeframe_model->get_data_by_condition($table,$condition,$select);
                    if(!empty($result)){
                         $created_by = $result[0]->created_by;
                    }
                }

                $user_info = array(
                            'user_info_id' => $user->id,
                            'first_name' => $user->first_name,
                            'last_name' => $user->last_name,
                            'phone' => $user->phone,
                            'timezone' => $user->timezone,
                            'company_name' => $user->company_name,
                            'company_email' => $user->company_email,
                            'company_url' => $user->company_url,
                            'created_by' => $created_by,
                            'email_notification' => $user->email_notification,
                            'urgent_notification' => $user->urgent_notification,
                            'desktop_notification' => $user->desktop_notification,
                            'img_folder' => $user->img_folder
                        );


                $this->user_id = $user_id;
                $this->user_data = $user_info;
                $accounts = $this->timeframe_model->get_accounts();
                $user_info['accounts'] = $accounts;
                $user_info['account_id'] = $accounts[0];

                $is_ac_with_sub = 1;
                //if current user is owner of any account then it should redirect to that account
                if(in_array($user_id, $accounts))
                {
                    $user_info['account_id'] = $user_id;
                    $is_sub_expired = check_subscription_expinred($user_id);
                }
               
                if($is_sub_expired AND count($accounts) > 1)
                {
                    $is_ac_with_sub = 0;
                    foreach($accounts as $account)
                    {
                        $ac_sub_expired = check_subscription_expinred($account);
                        if(!$ac_sub_expired)
                        {
                            $user_info['account_id'] = $account;
                            $is_ac_with_sub = 1;
                            break;
                        }
                    }
                }               

                //if login through join request so it should redirect to account form which he got request
                if(isset($post_data['account_id']) AND !empty($post_data['account_id']))
                {
                    $is_ac_with_sub = 1;
                    $user_info['account_id'] = $post_data['account_id'];
                }

                if($is_ac_with_sub == 0){
                    echo json_encode(array('response' => 'fail','message'=>$this->lang->line('trial_period_expiried')));
                    $this->aauth->logout();
                    exit();
                }

                $user_info['plan'] = strtolower(get_plan($user_info['account_id']));
                //is user added through account preference means he is account user or brand user
                $check_user = $this->timeframe_model->check_user_is_account_user($user_info['account_id']);
                if($check_user)
                {
                    $user_info['user_group'] = $check_user;
                }

                $this->session->set_userdata('user_info',$user_info);

                // $date_diff = calculate_date_diff($user->created_at,'');
                
                // if($date_diff >= 30 ){

                //     $this->load->model('transaction_model');
                //     $is_any_record = $this->transaction_model->get_last_transaction($user_info['account_id']);
                //     if(!$is_any_record){
                //         $data = array('is_trial_period_expired'=>1);
                //         $this->timeframe_model->update_data('user_info',$data,array('aauth_user_id' => $user_id));
                //         // Account Banned or Suspended
                //         echo json_encode(array('response' => 'fail','message'=>$this->lang->line('trial_period_expiried')));
                //         $this->aauth->logout();
                //         exit();
                //     }
                // }
                
                $remember_me = isset($post_data['remember_me']) ? $post_data['remember_me'] : '';
                if(isset($remember_me) AND !empty($remember_me))
                {
                    $cookie = array(
                        'name'   => 'user_pass',
                        'value'  =>  $post_data['password'],
                        'expire' => '0'
                    );
                    $this->input->set_cookie($cookie);

                    $cookie = array(
                        'name'   => 'user_name',
                        'value'  => $post_data['email'],
                        'expire' => '0'
                    );
                    $this->input->set_cookie($cookie);
                }
                else
                {
                    $this->load->helper('cookie');
                    //if not check then check already set in cookie or not & delete as per
                    $user_pass=$this->input->cookie('user_pass', TRUE);
                    if(isset($user_pass) && !empty($user_pass))
                    {
                        delete_cookie("user_pass");
                    }

                    $user_name=$this->input->cookie('user_name', TRUE);
                    if(isset($user_name) && !empty($user_name))
                    {
                        delete_cookie("user_name");
                    }
                }
                if(!empty($post_data['slug']) AND !empty($post_data['request_string']))
                {
                    echo json_encode(array('response' => 'success','slug' => $post_data['slug'],'request_string' => $post_data['request_string']));
                }
                else
                    echo json_encode(array('response' => 'success'));
            // }
            // else
            // {
            //     $email_send = $this->send_verification_link($user_id);
            //     echo json_encode(array('response' => 'verify','message'=>'Verification link sent to your email address.'));                
            // }
        }
        else
        {
            echo json_encode(array('response' => 'fail','message'=>$this->aauth->print_errors()));
        }
    }

    private function send_verification_link($user_id)
    {
        $verify_token = uniqid();
        $data = array(
                    'login_verify_token' => $verify_token
                );
        $this->timeframe_model->update_data('user_info',$data,array('aauth_user_id' => $user_id));        
        $this->data['user'] = $this->user_model->get_user($user_id);
        if($this->data['user'])
        {
            $this->load->helper('email');
            $content = $this->load->view('mails/verify_email',$this->data,true);          
            $subject = 'Timeframe - Verify user';
            $email = $this->data['user']->email;
           
            try
            {
                $mail_send = email_send($email, $subject,$content);
                if($mail_send)
                {
                    $this->session->set_flashdata('message','Verify user link has been sent successfully.');
                    return TRUE;
                }
                else
                {
                    $this->session->set_flashdata('message','Unable to send verificationa link please try to login again.');
                    return FALSE;
                }
            }
            catch(Exception $ex)
            {
                $this->session->set_flashdata('message','Unable to send verificationa link please try to login again.');
                return FALSE;
            }
        }
    }

    public function verify_user($verify_token)
    {
        $user = $this->user_model->get_verify_user($verify_token);       
        if($user)
        {
            $login_attempt = array(
                            'ip_address' => $_SERVER['REMOTE_ADDR'],
                            'user_name' => $user->name,
                            'user_id' => $user->aauth_user_id
                        );
            $inserted_id = $this->timeframe_model->insert_data('login_attempts',$login_attempt);
            if($inserted_id)
            {
                $data = array(
                            'login_verify_token' => NULL
                        );
                $condition = array('id' => $user->id);
                $data = $this->timeframe_model->update_data('user_info',$data,$condition);
                $this->session->set_flashdata('message','User verified successfully. Please login now');               
            }
            else
            {
                $this->session->set_flashdata('error','Unable to verify user. Please try again');                
            }
        }
        else
        {
            $this->session->set_flashdata('error','Invalid verify link');
        }
        redirect(base_url().'tour');
    }

    public function reset_password()
    {
        $this->data = array();
        $email = $this->input->post('email');
        $this->data['user'] = $this->user_model->is_user_exist($email);
        if(!empty($this->data['user']))
        {
            $this->data['token'] = uniqid();
            $this->update_token($this->data['token'],$this->data['user']->id);

            $this->load->helper('email');
            $content = $this->load->view('mails/reset_password',$this->data,true);
            $subject = 'Timeframe - Reset Password';
            try
            {
                $mail_send = email_send($email, $subject,$content);
                if($mail_send)
                {
                    echo json_encode(array('response' => 'success','message' => str_replace('%email%', $email ,$this->lang->line('reset_pass_msg'))));
                }
                else
                {
                    echo json_encode(array('response' => 'fail', 'message' => $this->lang->line('mail_sending_fail')));
                }
            }
            catch(Exception $ex)
            {
                echo json_encode(array('response' => 'fail', 'message' => $this->lang->line('mail_sending_fail')));
            }
            $url = 'welcome';
        }
        else
        {
             echo json_encode(array('response' => 'not_exist', 'message' => $this->lang->line('email_not_exist')));
        }
    }

    private function update_token($token,$user_id)
    {
        $data = array(
                        'forgot_token' => $token
                    );
        $condition = array('id' => $user_id);
        $data = $this->timeframe_model->update_data('user_info',$data,$condition);
    }

    public function set_password($token = '')
    {
        $this->data = array();        
        $user_id = $this->user_model->get_id_by_token($token);
        if(!empty($user_id))
        {
            $this->data['token'] = $token;
        }
        else
        {
            $this->data['error'] = "error";
        }
        // $this->load->view('tour/tour',$this->data);
        load_tour_view($this->data);
        $this->load->view('partials/modals');
    }

    public function join_co_create()
    {
        $this->data = array();
        $slug = $this->uri->segment(2);
        $request_string = $this->uri->segment(3);
        $request = $this->timeframe_model->get_data_by_condition('co_create_requests', array('request_string' => $request_string,'brand_slug' => $slug));
        $user_id = $this->session->userdata('id');       
       
        if(!empty($request))
        {
            if(isset($user_id) AND !empty($user_id))
            {
                $this->load->model('brand_model');
                $this->user_data = $this->session->userdata('user_info');
                $this->user_data['account_id'] = $request[0]->account_id;
                $brand =  $this->brand_model->get_brand_by_slug($user_id,$slug);          
                if(!empty($brand))
                {
                    $session_data = $this->user_data;
                    $account_id = $this->user_data['account_id'];
                    $check_user = $this->timeframe_model->check_user_is_account_user($this->user_data['account_id']);
                    if($check_user)
                    {
                        $session_data['user_group'] = $check_user;               
                    }
                    $session_data['account_id'] = $account_id;

                    $session_data['plan'] = strtolower(get_plan($account_id));

                    $this->session->set_userdata('user_info',$session_data);
                    redirect(base_url().'co_create/cocreate_post/'.$slug.'/'.$request_string);
                }
            }
        
            $this->data['slug'] = $slug;
            $this->data['request_string'] = $request_string;
            $this->data['request_id'] = $request[0]->id;
            $this->data['account_id'] = $request[0]->account_id;
        }
        else
        {
            $this->data['request_error'] = "error";
        }
        // $this->load->view('tour/tour',$this->data);
        load_tour_view($this->data);
        $this->load->view('partials/modals');
    }



    public function save_password()
    {
        $this->data = array();       
        $token = $this->input->post('token');
            
        if(!empty($token))
        {
            $user = $this->user_model->get_id_by_token($token);         
            $password = $this->input->post('password');
            $status = $this->aauth->update_user($user->aauth_user_id,'',$password,'');
            if($status)
            {
                $this->update_token(NULL,$user->id);
                echo json_encode(array('response' => 'success','message' => $this->lang->line('password_reset_success')));
            }
            else
            {
                echo json_encode(array('response' => 'faile','message' => $this->lang->line('password_reset_error')));
            }
        }
        else
        {
            echo json_encode(array('response' => 'faile','message' => $this->lang->line('password_reset_error')));
        }
    }

    public function check_email_exist()
    {
        $email = $this->input->post('email');
        $user = $this->aauth->user_exist_by_email($email);
        if($user)
        {
            echo "true";
        }
        else
        {
            echo "false";
        }

    }

    public function  check_username_exist()
    {
        $username = $this->input->post('username');
        $user = $this->aauth->user_exist_by_name($username);
        if($user)
        {
            echo "false";
        }
        else
        {
            echo "true";
        }
    }

    public function register()
    {
        $this->data = array();
        $this->form_validation->set_rules('first_name','first name','required',                                            
                                            array('required' => 'First name is required')
                                        );
        $this->form_validation->set_rules('last_name','last name','required',
                                            array('required' => 'Last name is required')
                                        );
        $this->form_validation->set_rules('email','email','required|valid_email|is_unique[aauth_users.email]',
                                            array('required' => 'Email is required')
                                        );
        $this->form_validation->set_rules('timezone','timezone','required',
                                            array('required' => 'Timezone is required')
                                        );
        // $this->form_validation->set_rules('username','username','required|is_unique[aauth_users.name]',
        //                                     array('required' => 'Username is required')
        //                                 );
        $this->form_validation->set_rules('password','password','required',
                                            array('required' => 'Password is required')
                                        );
        $this->form_validation->set_rules('confirm_password','confirm password','required|matches[password]',
                                            array('required' => 'Confirm password is required','matches' => 'Password field and confirm password field does not match')
                                        );
        // $this->form_validation->set_rules('phone','phone','regex_match[/^[0-9().-]+$/]',
        //                                     array('regex_match' => 'Please enter valid phone number')
        //                                 );
        // $this->form_validation->set_rules('company_email','company_email','valid_email',
        //                                     array('valid_email' => 'Please enter valid email')
        //                                 );        

        if ($this->form_validation->run() === FALSE)
        {
            echo json_encode(array('response' => 'fail','message' => $this->lang->line('validation_fails')));
        }
        else
        {
            $user_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'phone' => $this->input->post('phone'),
                'timezone' => $this->input->post('timezone'),
                'company_name' => $this->input->post('company_name'),
                'title' => $this->input->post('title'),
                            //'company_url' => $this->input->post('company_url'),
                'created_at' => date('Y-m-d H:i:s'),
                'plan' => $this->input->post('plan')
                );
            
            $inserted_id = $this->aauth->create_user($this->input->post('email'),$this->input->post('password'),$this->input->post('username'));
            
            if($inserted_id)
            {
                $user_data['aauth_user_id']= $inserted_id;
                $user_data['img_folder']= $inserted_id;
                $this->timeframe_model->insert_data('user_info',$user_data);
                $login_attempt = array(
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'user_name' => $this->input->post('email'),
                    'user_id' => $inserted_id
                    );
                $this->timeframe_model->insert_data('login_attempts',$login_attempt);
                echo json_encode(array('response' => 'success','message' => $this->lang->line('registered_success_link')));
            }
            else
            {
                echo json_encode(array('response' => 'fail','message' => $this->lang->line('unable_to_register_user')));
            }
        }
    }

    public function verify_user_email()
    {
        $user_id = $this->uri->segment(3);
        $verification_code = $this->uri->segment(4);
        $status = $this->aauth->verify_user($user_id,$verification_code);
        if($status)
        {
            //check if ip already available
            $condition = array('user_id' => $user_id,'ip_address' => $_SERVER['REMOTE_ADDR']);
            $login_attempt = $this->timeframe_model->get_data_by_condition('login_attempts',$condition,'id');
            if(empty($login_attempt))
            {
                $user = $this->aauth->get_user($user_id);
                if(!empty($user))
                {
                    $login_attempt = array(
                                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                                    'user_name' => $user->name,
                                    'user_id' => $user_id
                                );
                    $this->timeframe_model->insert_data('login_attempts',$login_attempt);

                }
            }
            $this->data['verify'] = 'success';
        }
        else
        {
            $this->data['verify'] = 'fail';   
        }
        // $this->load->view('tour/tour',$this->data);
        load_tour_view($this->data);
        $this->load->view('partials/modals');
    }

    public function register_sub_user($user_id = '',$verification_code = '')
    {
        $this->data['user_id'] = $user_id;
        $this->data['verification_code'] = $verification_code;
        
        $user = $this->timeframe_model->get_data_by_condition('aauth_users',array('id' => $user_id,'verification_code' => $verification_code));  
        // echo '<pre>'; print_r($user);echo '</pre>'; 
        $this->data['user_email'] = isset($user[0]->email) ? $user[0]->email :'';
        $this->data['is_user'] = 'fail';
        if($user)
        {
            $this->data['timezones'] = $this->user_model->get_timezones();
            $this->data['is_user'] = 'success';
        }

        // $this->load->view('tour/tour',$this->data);
        load_tour_view($this->data);
        $this->load->view('partials/modals');
    }

    public function save_sub_user()
    {
        $post_data = $this->input->post();

        $status = $this->aauth->update_user($post_data['user_id'],$post_data['email'],$post_data['password'],'');
        // echo '<pre>'; print_r($status);echo '</pre>'; die;
        if($status)
        {
            $data = array(
                    'timezone' => $post_data['timezone']
                );
            $this->timeframe_model->update_data('user_info',$data,array('aauth_user_id' => $post_data['user_id']));

            $verification_status = $this->aauth->verify_user($post_data['user_id'],$post_data['verification_code']);

            if($verification_status)
            {
                $user = $this->aauth->get_user($post_data['user_id']);
                if(!empty($user))
                {
                    $login_attempt = array(
                                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                                    'user_name' => $user->name,
                                    'user_id' => $post_data['user_id']
                                );
                    $this->timeframe_model->insert_data('login_attempts',$login_attempt);

                }
                echo json_encode(array('response' => 'success','message'=>$this->lang->line('registered_success')));
            }
            else
            {
                echo json_encode(array('response' => 'fail','message'=>$this->lang->line('unable_to_register_user')));
            }
        }
        else
        {
           echo json_encode(array('response' => 'fail','message'=>$this->lang->line('unable_to_register_user')));
        }

    }

    public function logout() {
        $this->aauth->logout();
        redirect(base_url().'tour');
    }

    function login_fast()
    {
        $user_id = $this->uri->segment(3);
        if($this->aauth->login_without_pass($user_id))
        {
            $user_id = $this->session->userdata('id');            
            $user = $this->user_model->get_user($user_id);
            // get brand id to find my brand owner  
            // if $my_brand_id (in else case ) id null then me as brand owner 
            $my_brand_id = get_my_brand($user_id);
            if(empty($my_brand_id)){
               // get_my_brand
                $created_by = $user_id;
            }else{
                $select ='created_by';
                $table = 'brands';
                $condition= array('id'=>$my_brand_id);
                $result= $this->timeframe_model->get_data_by_condition($table,$condition,$select);
                if(!empty($result)){
                     $created_by = $result[0]->created_by;
                }
            }

            $user_info = array(
                        'user_info_id' => $user->id,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'phone' => $user->phone,
                        'timezone' => $user->timezone,
                        'company_name' => $user->company_name,
                        'company_email' => $user->company_email,
                        'company_url' => $user->company_url,
                        'created_by' => $created_by,
                        'email_notification' => $user->email_notification,
                        'urgent_notification' => $user->urgent_notification,
                        'desktop_notification' => $user->desktop_notification,
                        'img_folder' => $user->img_folder
                    );


            $this->user_id = $user_id;
            $this->user_data = $user_info;
            $accounts = $this->timeframe_model->get_accounts();
            $user_info['accounts'] = $accounts;
            $user_info['account_id'] = $accounts[0];

            $is_ac_with_sub = 1;
            //if current user is owner of any account then it should redirect to that account
            if(in_array($user_id, $accounts))
            {
                $user_info['account_id'] = $user_id;
                $is_sub_expired = check_subscription_expinred($user_id);
            }

            //if login through join request so it should redirect to account form which he got request
            if(isset($post_data['account_id']) AND !empty($post_data['account_id']))
            {
                $is_ac_with_sub = 1;
                $user_info['account_id'] = $post_data['account_id'];
            }

            $user_info['plan'] = strtolower(get_plan($user_info['account_id']));
            //is user added through account preference means he is account user or brand user
            $check_user = $this->timeframe_model->check_user_is_account_user($user_info['account_id']);
            if($check_user)
            {
                $user_info['user_group'] = $check_user;
            }

            $this->session->set_userdata('user_info',$user_info);
            redirect(base_url().'brands/overview');
        }
    }
}