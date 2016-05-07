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
        $this->load->view('tour/tour');
        $this->load->view('partials/modals');
    }

    public function check_login()
    {
        $this->data = array();
        $post_data = $this->input->post();
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
                        'value'  => $post_data['username'],
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
                echo json_encode(array('response' => 'success'));                
            }
            else
            {
                $email_send = $this->send_verification_link($user_id);
                echo json_encode(array('response' => 'verify','message'=>'Verification link sent to your email address.'));                
            }
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
                    echo json_encode(array('response' => 'success','message' => 'We’ve sent an email to '.$email.' with instructions on resetting your password.'));
                }
                else
                {
                    echo json_encode(array('response' => 'fail', 'message' => 'Mail could not be send'));
                }
            }
            catch(Exception $ex)
            {
                echo json_encode(array('response' => 'fail', 'message' => 'Mail could not be send'));
            }
            $url = 'welcome';
        }
        else
        {
             echo json_encode(array('response' => 'not_exist', 'message' => 'Email address does not exist'));
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
        $this->load->view('tour/tour',$this->data);
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
                echo json_encode(array('response' => 'success','message' => 'Your password has been reset successfully'));
            }
            else
            {
                echo json_encode(array('response' => 'faile','message' => 'Error in reseting password please try to reset once again'));
            }
        }
        else
        {
            echo json_encode(array('response' => 'faile','message' => 'Error in reseting password please try to reset once again'));
        }
    }

}