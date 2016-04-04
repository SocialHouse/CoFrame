<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('is_user_logged')) 
{
    function is_user_logged() 
    {
        //get an instance of CI so we can access our configuration
        $CI = & get_instance();
        if($CI->aauth->is_loggedin())
        {
           return true;
        }
        redirect(base_url().'welcome');
    }
}

if(!function_exists('_create_salt')) 
{
    function _create_salt() 
    {
        $CI = & get_instance();
        $CI->load->helper('string');
        return sha1(random_string('alnum', 32));
    }
}

if(!function_exists('_render_view')) 
{
    function _render_view($data)
    {
        if(!isset($data['layout']))
        {
            $data['layout'] = 'layouts/user_layout';
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
            $CI->load->view($data['layout'],$CI->data);
        }
        else
        {
            echo "please define the view to be loaded";
        }
    }
}

if(!function_exists('get_users_brand')) 
{
    function get_users_brand($brand_id) 
    {
        $CI = & get_instance();
        $CI->load->model('brand_model');       
        $user_id = $CI->user_id;
        return $CI->brand_model->get_users_brand($user_id,$brand_id);
    }
}

if(!function_exists('upload_file')) 
{
    function upload_file($control,$file_name,$upload_folder) 
    {
        $CI = & get_instance();
        $upload_path = upload_path().$upload_folder.'/';

        if (!file_exists($upload_path))
        {       
            mkdir($upload_path, 0777);
        }

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|3gp|mp4|mov';
        $config['max_size'] = '40000';
        $config['file_name'] = $file_name;

        $CI->load->library('upload',$config);
        $CI->upload->initialize($config);
        // we retrieve the number of files that were uploaded
        if ($CI->upload->do_upload($control))
        {
            $file_array = $CI->upload->data(); 
            $file_array['file_name'];
            return $file_array;
        }
        else
        {
            $data['upload_errors'] = $CI->upload->display_errors();
            return $data;
        }
    }
}

if(!function_exists('get_post_tags')) 
{
    function get_post_tags($post_id) 
    {
        $CI = & get_instance();

        $CI->load->model('timeframe_model');

        return $CI->post_model->get_post_tags($post_id);

    }
}

