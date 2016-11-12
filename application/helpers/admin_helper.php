<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('is_admin_logged')) 
{
    function is_admin_logged() 
    {
       $CI = & get_instance();
        if(!$CI->session->userdata('admin_logged_in')){
            redirect(base_url('admin'));
        }
        return true;
    }
}

if(!function_exists('_render_admin_view')) 
{
    function _render_admin_view($data)
    {
        if(!isset($data['layout']))
        {
            $data['layout'] = 'admin/layouts/layout';
        }      

        if(isset($data['view']) AND !empty($data['view']))
        {
            $CI = & get_instance();

            //send error messages to layout
            if(isset($data['error']))
            {
                $CI->data['error'] = $data['error'];
            }

            $CI->data['yield'] = $CI->load->view($data['view'],$data,true);
            echo $CI->load->view($data['layout'],$CI->data,true);
        }
        else
        {
            echo "please define the view to be loaded";
        }
    }
}