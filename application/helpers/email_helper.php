<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    function email_send($to,$subject,$message) 
    {
        $CI = & get_instance();

        $config = $CI->config->item('smtp_config');
        $from = $CI->config->item('from_mail');
        $CI->load->library('email',$config);
        $CI->email->initialize($config);
        $CI->email->from($from);
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);
        if($CI->email->send())
        {
            return TRUE;
        }
        return FALSE;
    }

    function email_send_with_attachment($to,$subject,$message,$attachment) 
    {
        echo $attachment;
        $CI = & get_instance();

        $config = $CI->config->item('smtp_config');
        $from = $CI->config->item('from_mail');
        $CI->load->library('email',$config);
        $CI->email->initialize($config);
        $CI->email->from($from);
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);
        $CI->email->attach($attachment);
        if($CI->email->send())
        {
            return TRUE;
        }
        echo $CI->email->print_debugger();
        return FALSE;
    }