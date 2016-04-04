<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
        $this->data['capcha'] = $this->aauth->generate_recaptcha_field();
        $post_data = $this->input->post();
        if(isset($post_data) AND !empty($post_data))
        {            
            $this->form_validation->set_rules('username', 'username', 'required',
                                                array('required' => 'Username is required')
                                            );
            $this->form_validation->set_rules('password', 'password', 'required',
                                                array('required' => 'Password is required')
                                            );
            
            if($this->form_validation->run() === true) 
            {                
                if($this->aauth->login($post_data['username'], $post_data['password']))
                {
                    $user_id = $this->session->userdata('id');
                    $is_exists = $this->user_model->check_login_attempt($user_id);
                    if($is_exists)
                    {
                        $user = $this->user_model->get_user($user_id);
                        $user_info = array(
                                    'user_info_id' => $user->id,
                                    'first_name' => $user->first_name,
                                    'last_name' => $user->last_name,
                                    'phone' => $user->phone,
                                    'timezone' => $user->timezone,
                                    'company_name' => $user->company_name,
                                    'company_email' => $user->company_email,
                                    'company_url' => $user->company_url
                                );

                        $this->session->set_userdata('user_info',$user_info);
                        redirect(base_url().'payment');
                    }
                    else
                    {
                        $email_send = $this->send_verification_link($user_id);
                        redirect(base_url().'welcome');
                    }
                }
                $this->data['error'] = $this->aauth->print_errors();               
            }
            
        }

        $this->data['view'] = 'login';
        $this->data['layout'] = 'layouts/login_layout';

        _render_view($this->data);
    }

    private function send_verification_link($user_id)
    {
        $verify_token = uniqid();
        $data = array(
                    'login_verify_token' => $verify_token
                );
        $this->timeframe_model->update_data('user_info',$data,array('id' => $user_id));        
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
        redirect(base_url().'welcome');
    }

    public function register()
    {
        $this->data = array();
        $this->data['timezones'] = $this->user_model->get_timezones();
        //name for main content view
        $this->data['view'] = 'register';
        //name for layout
        $this->data['layout'] = 'layouts/login_layout';

        //helper function to load view by passing name of view and layout
        _render_view($this->data);      
    }

    public function save()
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
        $this->form_validation->set_rules('username','username','required|is_unique[aauth_users.name]',
                                            array('required' => 'Username is required')
                                        );
        $this->form_validation->set_rules('password','password','required',
                                            array('required' => 'Password is required')
                                        );
        $this->form_validation->set_rules('confirm_password','confirm password','required|matches[password]',
                                            array('required' => 'Confirm password is required','matches' => 'Password field and confirm password field does not match')
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
                            'company_url' => $this->input->post('company_url'),
                            'created_at' => date('Y-m-d H:i:s')
                        );
            
            $inserted_id = $this->aauth->create_user($this->input->post('email'),$this->input->post('password'),$this->input->post('username'));
            
            if($inserted_id)
            {
                $user_data['aauth_user_id']= $inserted_id;
                $this->timeframe_model->insert_data('user_info',$user_data);
                $login_attempt = array(
                            'ip_address' => $_SERVER['REMOTE_ADDR'],
                            'user_name' => $this->input->post('username'),
                            'user_id' => $inserted_id
                        );
                $this->timeframe_model->insert_data('login_attempts',$login_attempt);
                $this->session->set_flashdata('message','You have registered successfully');
                redirect(base_url().'welcome');
            }           
        }
    }   

    public function logout()
    {
        $this->aauth->logout();
        redirect(base_url().'welcome');
    }

    public function forgot_password()
    {
        $this->data['view'] = 'forgot_password';
        $this->data['layout'] = 'layouts/login_layout';
        _render_view($this->data);     
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
                    $this->session->set_flashdata('message','Password reset link has been sent successfully');
                }
                else
                {
                    $this->session->set_flashdata('message','Mail could not be send');
                }
            }
            catch(Exception $ex)
            {
                 $this->session->set_flashdata('message','Mail could not be send');
            }
            $url = 'welcome';
        }
        else
        {
            $this->session->set_flashdata('message','Email address does not exist');
            $url = 'welcome/forgot_password';
        }
        redirect(base_url().$url);
    }

    public function set_password($token)
    {
        $this->data = array();
        $this->data['token'] = $token;
        $user_id = $this->user_model->get_id_by_token($token);
        if(!empty($user_id))
        {
            $this->data['view'] = 'set_password';
            $this->data['layout'] = 'layouts/login_layout';
            _render_view($this->data); 
        }
        else
        {
            $this->session->set_flashdata('error', 'Link is not available');
            redirect(base_url().'welcome');
        }
    }

    public function save_password()
    {
        $this->data = array();
        $this->form_validation->set_rules('password','password','required');
        $this->form_validation->set_rules('confirm_password','confirm password','required|matches[password]');

        if($this->form_validation->run() === FALSE)
        {
            $this->data['token'] = $this->input->post('token');
            $this->data['view'] = 'set_password';
            $this->data['layout'] = 'layouts/login_layout';

            _render_view($this->data);
        }
        else
        {
            $token = $this->input->post('token');
            
            if(!empty($token))
            {
                $user = $this->user_model->get_id_by_token($token);
                $password = $this->input->post('password');
                $status = $this->aauth->update_user($user->aauth_user_id,'',$password,'');
                if($status)
                {
                    $this->update_token(NULL,$user->id);

                    $this->session->set_flashdata('message','Your password has been reset successfully');
                    redirect(base_url().'welcome');
                }
            }
            else
            {
                $this->session->set_flashdata('error','Error in reseting password please try to reset once again');
                redirect(base_url().'welcome');
            }
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
}
