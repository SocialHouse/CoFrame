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
            $data['layout'] = 'layouts/new_user_layout';
        }

        if(!isset($data['background_image']))
        {
            $data['background_image'] = 'bg-brand-management.jpg';
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

        if (!is_dir($upload_path))
        {       
            mkdir($upload_path, 0777,true);
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

if(!function_exists('delete_file')) 
{
    function delete_file($path) 
    {
        if(file_exists($path))
            unlink($path);
    }
}

if(!function_exists('rename_file')) 
{
    function rename_file($old_path,$new_path) 
    {
        if (!is_dir($new_path))
        {       
            mkdir($new_path, 0777,true);
        }
        rename($old_path, $new_path);
    }
}


if(!function_exists('get_post_tags')) 
{
    function get_post_tags($post_id) 
    {
        $CI = & get_instance();

        $CI->load->model('post_model');

        return $CI->post_model->get_post_tags($post_id);

    }
}

if(!function_exists('get_my_brand')) 
{
    function get_my_brand($user_id) 
    {
        $CI = & get_instance();

        $CI->load->model('brand_model');

        return $CI->brand_model->get_my_brand($user_id);

    }
}

if(!function_exists('get_outlet_by_id')) 
{
    function get_outlet_by_id($outlet_id) 
    {
        $CI = & get_instance();

        $CI->load->model('timeframe_model');
        $outlet = $CI->timeframe_model->get_data_by_condition('outlets',array('id' => $outlet_id));
        if($outlet)
        {
            return $outlet[0]->outlet_name;
        }
        return FALSE;

    }
}

if(!function_exists('get_approvers_by_phase')) 
{
    function get_approvers_by_phase($phase_id) 
    {
        $CI = & get_instance();

        $CI->load->model('approval_model');
        $approvers = $CI->approval_model->get_approvers_by_phase($phase_id);
        if($approvers)
        {
            return $approvers;
        }
        return FALSE;

    }
}

if(!function_exists('get_user_groups')) 
{
    function get_user_groups($user_id) 
    {
        $CI = & get_instance();

        // $CI->load->('approval_model');
        $user_group = $CI->aauth->get_user_groups($user_id);
        if($user_group)
        {
            return $user_group[0]->name;
        }
        return FALSE;

    }
}

if(!function_exists('get_brand_reminders'))
{
    function get_brand_reminders($user_id,$brand_id,$limit = 0)
    {
        $CI = & get_instance();

        $CI->load->model('reminder_model');
        $reminders = $CI->reminder_model->get_brand_reminders($user_id,$brand_id,$limit);
        if($reminders)
        {
            return $reminders;
        }
        return FALSE;

    }
}

if(!function_exists('get_time_zone'))
{
    function get_time_zone($timezone)
    {
        $CI = & get_instance();
        $condition = array('value' => $timezone);
        $timezone = $CI->timeframe_model->get_data_by_condition('timezone',$condition);
        if($timezone)
        {
            return $timezone[0]->timezone;
        }
        return FALSE;

    }
}

if(!function_exists('check_user_perm'))
{
    function check_user_perm($permission,$perm)
    {
        $CI = & get_instance();        
        return $CI->aauth->check_user_perm($permission,$perm);
    }
}




