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
        redirect(base_url());
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
            echo $CI->load->view($data['layout'],$CI->data,true);
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
           @unlink($path);
    }
}

if(!function_exists('rename_file')) 
{
    function rename_file($old_path,$new_path) 
    {
        @rename($old_path,$new_path);
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

if(!function_exists('get_post_approvers')) 
{
    function get_post_approvers($post_id) 
    {
        $CI = & get_instance();

        $CI->load->model('approval_model');
        $approvers = $CI->approval_model->get_post_approvers($post_id);
        if($approvers)
        {
            return $approvers;
        }
        return FALSE;

    }
}

if(!function_exists('get_user_groups')) 
{
    function get_user_groups($user_id,$brand_id) 
    {
        $CI = & get_instance();            
        $user_group = $CI->aauth->get_user_groups($user_id,$brand_id);
        if($user_group)
        {
            return $user_group[0]->name;
        }
        return 'Master admin';

    }
}

if(!function_exists('get_brand_reminders'))
{
    function get_brand_reminders($user_id,$brand_id,$limit = 0,$type = 'all')
    {
        $CI = & get_instance();

        $CI->load->model('reminder_model');
        $reminders = $CI->reminder_model->get_brand_reminders($user_id,$brand_id,$limit,$type);
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

if(!function_exists('get_abbreviation'))
{
    function get_abbreviation($timezone)
    {
        $CI = & get_instance();
        $condition = array('value' => $timezone);
        $timezone = $CI->timeframe_model->get_data_by_condition('timezone',$condition);
        if($timezone)
        {
            return $timezone[0]->abbreviation;
        }
        return FALSE;
    }
}


if(!function_exists('check_user_perm'))
{
    function check_user_perm($permission,$perm,$brand_id)
    {
        $CI = & get_instance();        
        return $CI->aauth->check_user_perm($permission,$perm,$brand_id);
    }
}

if(! function_exists('create_slug_url')){

        function create_slug_url($id, $table_name, $title){
            $ci =& get_instance();
            $ci->load->database();
            $config = array(
                        'table' => $table_name,
                        'id' => 'id',
                        'field' => 'slug',
                        'title' => 'name',
                        'replacement' => 'dash' // Either dash or underscore
                    );  
            $ci->load->library('slug', $config);

            $slug = $ci->slug->create_uri($title);
            $fields = array('slug'=>$slug);
            $ci->db->where('id',$id);
            $ci->db->update($table_name,$fields);
            return $slug;
        }

}

if(!function_exists('get_post_count_status'))
{
    function get_post_count_status($brand_id,$status)
    {
        $CI = & get_instance();        
        $result = $CI->timeframe_model->get_data_by_condition('posts',array('brand_id' => $brand_id,'status' => $status),'count(id) as count');        
        return $result[0]->count;
    }
}

if (!function_exists('read_more')) 
{
    function read_more($content, $word_limit=null)
    {
        
        //get an instance of CI so we can access our configuration
        if(empty($word_limit)){
            $word_limit = 30;
        }
         $out = strlen($content) > $word_limit ? substr($content,0,$word_limit)."..." : $content;
      
        return $out;
    }
}

if(!function_exists('get_comment_reply'))
{
    function get_comment_reply($comment_id)
    {
        $CI = & get_instance();
        $CI->load->model('approval_model');
        return $CI->approval_model->get_comment_reply($comment_id);
    }
}

if(!function_exists('is_edit_request'))
{
    function is_edit_request($post_id)
    {
        $CI = & get_instance();        
        return $CI->timeframe_model->get_data_by_condition('post_comments',array('post_id' => $post_id,'status ' => NULL));
    }
}

if(!function_exists('get_phase_comments'))
{
    function get_phase_comments($phase_id)
    {
        $CI = & get_instance();        
        return $CI->approval_model->get_phase_comments($phase_id);
    }
}

if(!function_exists('get_phase_users'))
{
    function get_phase_users($phase_id)
    {
        $CI = & get_instance();   
        $CI->load->model('approval_model');     
        return $CI->approval_model->get_phase_users($phase_id);
    }
}

if(!function_exists('get_summary'))
{
    function get_summary($brand_id,$date = '')
    {
        $CI = & get_instance();   
        $CI->load->model('post_model');     
        return $CI->post_model->post_by_status($brand_id,'scheduled',$date);
    }
}

if(!function_exists('replace_with_expression'))
{
    function replace_with_expression($string)
    {
        preg_match_all('/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/',$string,$output, PREG_PATTERN_ORDER);

        if(!empty($output))
        {
            foreach($output[0] as $out)
            {
                $string = str_replace($out,'<a href="#">'.$out.'</a>',$string);
            }
        }

        preg_match_all("/(#\w+)/",$string,$output, PREG_PATTERN_ORDER);
        if(!empty($output))
        {
            foreach($output[0] as $out)
            {
                $string = str_replace($out,'<a href="#">'.$out.'</a>',$string);
            }
        }

        preg_match_all("/(@\w+)/",$string,$output, PREG_PATTERN_ORDER);
        if(!empty($output))
        {
            foreach($output[0] as $out)
            {
                $string = str_replace($out,'<a href="#">'.$out.'</a>',$string);
            }
        }

        return $string;
    }
}

if(!function_exists('check_access'))
{
    function check_access($perm,$brand,$additional_group = '')
    {
        $CI = & get_instance();      
        $group = get_user_groups($CI->user_id,$brand[0]->id);
        $has_perm = $CI->aauth->check_user_perm($CI->user_id,$perm,$brand[0]->id);
        if(!$has_perm AND !empty($group) AND !$additional_group AND $group != 'Master admin')
        {
            $CI->data['user_group'] = $group;
            $CI->data['brand_id'] = $brand[0]->id;
            $CI->data['brand'] = $brand[0];
            $CI->data['view'] = 'partials/no_permission';
            $CI->data['js_files'] = array(js_url().'vendor/moment.min.js?ver=2.11.0');
            _render_view($CI->data);
            die;
        }       
    }
}
if(!function_exists('object_to_array'))
{
    function object_to_array($data)
    {
        if (is_array($data) || is_object($data))
        {
            $result = array();
            foreach ($data as $key => $value)
            {
                $result[$key] = object_to_array($value);
            }
            return $result;
        }
        return $data;
    }
}

if(!function_exists('is_set_permmition'))
{
    function is_set_permmition($user_id ,$brand_id)
    {
        if (!empty($user_id) && !empty($brand_id))
        {
            $CI = & get_instance();

            $CI->load->model('timeframe_model');
            $result = $CI->timeframe_model->get_data_by_condition('brand_user_map',array('brand_id' => $brand_id, 'access_user_id' => $user_id));
            if($result)
            {
               return true;
            }
            return false;
        }
        return false;
    }
}