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
            $CI->data['current_brand'] = isset($data['brand_id']) ? $data['brand_id'] : NULL;
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
    function get_post_approvers($post_id,$status='') 
    {
        $CI = & get_instance();

        $CI->load->model('approval_model');
        $approvers = $CI->approval_model->get_post_approvers($post_id,$status);
        if($approvers)
        {
            return $approvers;
        }
        return FALSE;

    }
}

if(!function_exists('get_user_groups')) 
{
    function get_user_groups($user_id,$brand_id = NULL,$parent_id=NULL) 
    {
        $CI = & get_instance();            
        $user_group = $CI->aauth->get_user_groups($user_id,$brand_id,$parent_id);
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
    function check_user_perm($permission,$perm,$brand_id = NULL, $account_id = NULL)
    {
        $CI = & get_instance();        
        return $CI->aauth->check_user_perm($permission,$perm,$brand_id,$account_id);
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
        $CI->load->model('approval_model');          
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

        return nl2br($string);
    }
}

if(!function_exists('check_access'))
{
    function check_access($perm,$brand,$additional_group = '',$message = '')
    {
        $CI = & get_instance();      
        $group = get_user_groups($CI->user_id,$brand[0]->id);
        $has_perm = $CI->aauth->check_user_perm($CI->user_id,$perm,$brand[0]->id);
        if(!$has_perm AND !empty($group) AND !$additional_group AND $group != 'Master admin')
        {
            $CI->data['user_group'] = $group;
            $CI->data['brand_id'] = $brand[0]->id;
            $CI->data['brand'] = $brand[0];
            $CI->data['access_denied_msg'] = $message;
            $CI->data['view'] = 'partials/no_permission';
            $CI->data['js_files'] = array(js_url().'vendor/moment.min.js?ver=2.11.0');
            _render_view($CI->data);
            die;
        }       
    }
}

if(!function_exists('plan_access'))
{
    function plan_access($plan,$brand,$group,$message = '')
    {
        if($plan == 0)
        {
            $CI->data['user_group'] = $group;
            $CI->data['brand_id'] = $brand[0]->id;
            $CI->data['brand'] = $brand[0];
            $CI->data['access_denied_msg'] = $message;
            $CI->data['view'] = 'partials/no_permission';
            $CI->data['js_files'] = array(js_url().'vendor/moment.min.js?ver=2.11.0');
            _render_view($CI->data);
            die;
        }
    }
}

if(!function_exists('no_of_brand_allowed'))
{
    function no_of_brand_allowed($current_count,$allowed_count,$message = '')
    {
        if($current_count >= $allowed_count)
        {
            $CI->data['access_denied_msg'] = $message;
            $CI->data['view'] = 'partials/limit_exceed_error';
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

if(!function_exists('get_master_user'))
{
    function get_master_user($user_id)
    {
        $CI = & get_instance();   
        $CI->load->model('timeframe_model');
        return $CI->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id' => $user_id));
    }
}

if(!function_exists('get_approval_list_buttons'))
{
    function get_approval_list_buttons($post,$deadline,$phase_status,$user_group,$approver_status,$phase_id,$brand_id,$is_any_pending_approver)
    {
        $CI = & get_instance(); 
        $html_to_return = '';
        if((check_user_perm($CI->user_id,'approve',$brand_id) OR ($CI->user_id == $CI->user_data['account_id']) OR $CI->user_data['user_group'] == 'Master Admin') AND !empty($phase_status))
        {
            if($approver_status == 'pending' AND $post->status == 'pending')
            {               
                $html_to_return .= '<div class="before-approve">
                    <a class="btn btn-sm btn-default color-success change-approve-status" data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="approved">Approve</a>
                </div>

                <div class="after-approve post-actions hide">
                    <button class="btn btn-default color-success btn-disabled btn-sm" disabled>Approved</button>
                    <a class="change-approve-status"  data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="pending" href="#">Undo</a>
                </div>';                
            }            
            elseif($approver_status == 'approved')
            {
                $html_to_return .= '<a class="btn btn-sm btn-disabled btn-default color-success">Approved</a> ';
            }

            // if(!empty($approver_status))
            // {
                // $html_to_return .= '<a href="'.base_url().'edit-request/'.$post->id.'" class="btn btn-xs btn-wrap btn-default">Suggest an<br>Edit</a>';
                $html_to_return .= '<a href="'.base_url().'edit-request/'.$post->id.'" class="btn btn-xs btn-wrap btn-default">Edit<br>Requests</a>';
            // }
        }
        elseif(check_user_perm($CI->user_id,'create',$brand_id) OR $post->user_id == $CI->user_id OR (($CI->user_id == $CI->user_data['account_id']) OR ( isset($CI->user_data['user_group']) AND $CI->user_data['user_group'] == 'Master Admin')))
        {
            if($post->status == 'scheduled')
            {
                $html_to_return .= '<div class="before-approve post-actions">';
                $html_to_return .= '<button class="btn btn-default color-success btn-disabled btn-sm" disabled>Scheduled</button>
                    <a class="change-approve-status"  data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="unschedule" href="#">Undo</a>
                </div>

                <div class="after-approve hide">
                    <a class="btn btn-sm btn-default color-success change-approve-status" data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'>" data-phase-status="scheduled">Schedule</a>
                </div>';
            }
            elseif($post->status == 'pending' OR $post->status == 'approved')
            {
                $btn_class = 'change-approve-status';
                $modal_attr = '';
                if($is_any_pending_approver == 1)
                {
                    $btn_class = 'set_schedule_id';
                    $modal_attr = 'data-toggle="modal" data-target="#schedule_post" data-append="body"';
                }
                $html_to_return .= '<div class="before-approve">
                    <a class="btn btn-sm btn-default color-success '.$btn_class.'" data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="scheduled" '.$modal_attr.'>Schedule</a>
                </div>

                <div class="after-approve hide post-actions">
                    <button class="btn btn-disabled btn-default color-success btn-sm" disabled>Scheduled</button>
                    <a class="change-approve-status"  data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="unschedule" href="#">Undo</a>
                </div>';
            }
            elseif($post->status == 'posted')
            {
                $html_to_return .= '<button class="btn btn-approved btn-sm btn-default">View Live</button>';
            }

            // $is_edit_request = is_edit_request($post->id);
            // if($is_edit_request AND empty($approver_status))
            // {
                $html_to_return .= '<a href="'.base_url().'edit-request/'.$post->id.'" class="btn btn-xs btn-wrap btn-default">Edit<br>Requests</a>';
            // }
        }
        else
        {
            if($post->status == 'scheduled')
            {
                $html_to_return .= '<div class="before-approve post-actions">';
                $html_to_return .= '<button class="btn btn-default color-success btn-disabled btn-sm" disabled>Scheduled</button><br>
                    <a class="change-approve-status"  data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="unschedule" href="#">Undo</a>
                </div>

                <div class="after-approve hide">
                    <a class="btn btn-sm btn-default color-success change-approve-status" data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'>" data-phase-status="scheduled">Schedule</a>
                </div>';
            }
            elseif($post->status == 'pending')
            {
                $html_to_return .= '<div class="before-approve">
                    <a class="btn btn-sm btn-default color-success change-approve-status" data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="scheduled">Schedule</a>
                </div>

                <div class="after-approve post-actions hide">
                    <button class="btn btn-disabled btn-default color-success btn-sm" disabled>Scheduled</button>
                    <a class="change-approve-status"  data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="unschedule" href="#">Undo</a>
                </div>';
            }
            elseif($post->status == 'posted')
            {
                $html_to_return .= '<button class="btn btn-approved btn-sm btn-default">View Live</button>';
            }

            // $is_edit_request = is_edit_request($post->id);
            // if($is_edit_request AND empty($approver_status))
            // {
                $html_to_return .= '<a href="'.base_url().'edit-request/'.$post->id.'" class="btn btn-xs btn-wrap btn-default">Edit<br>Requests</a>';
            // }
        }
        return $html_to_return;
    }
}

if(!function_exists('get_day_cal_buttons'))
{
    function get_day_cal_buttons($user_is,$approver_status,$phase_status,$phase_id,$post)
    {
        $CI = & get_instance(); 
        $html_to_return = '';
        if($user_is == 'approver')
        {
            if($approver_status == 'pending' AND $phase_status == 'pending')
            {
                $html_to_return .= '<div class="before-approve">
                    <button class="btn btn-approved btn-sm btn-secondary change-approve-status"  data-post-id="'. $post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="approved">Approve</button>
                </div>

                <div class="after-approve hide post-actions">
                    <button class="btn btn-secondary btn-disabled btn-sm" disabled>Approved</button>
                    <a class="change-approve-status"  data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="pending" href="#">Undo</a>
                </div>';
            }
            elseif($post->status == 'posted')
            {
                $html_to_return .= '<button class="btn btn-approved btn-sm btn-default">View Live</button>';
            }
            else
            {
                $html_to_return .= '<div class="before-approve post-actions">    
                    <button class="btn btn-secondary btn-disabled btn-sm" disabled>Approved</button>';

                if($phase_status == 'pending' AND $post->status == 'pending')
                {
                    $html_to_return .= '<a class="change-approve-status"  data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="pending" href="#">Undo</a>';
                }

                $html_to_return .= '</div>';

                $html_to_return .= '<div class="after-approve hide">
                    <button class="btn btn-approved btn-sm btn-secondary change-approve-status" data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="approved">Approve</button>';
                $html_to_return .= '</div>';
            }
        }
        else
        {
            if($post->status == 'pending' OR $post->status == 'approved')
            {
                $undo_stat = 'pending';
                if($post->status == 'approved')
                {
                    $undo_stat = 'unschedule';
                }

                $html_to_return .= '<div class="before-approve">
                    <a class="btn btn-xs btn-secondary change-approve-status" data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="scheduled">Schedule</a>
                </div>';

                $html_to_return .= '<div class="after-approve hide post-actions">
                    <button class="btn btn-secondary btn-disabled btn-sm" disabled>Scheduled</button>
                    <a class="change-approve-status"  data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="'.$undo_stat.'" href="#">Undo</a>
                </div>';
            }
            elseif($post->status == 'posted')
            {
                $html_to_return .= '<button class="btn btn-approved btn-sm btn-default">View Live</button>';
            }
            elseif($post->status == 'scheduled')
            {
                $html_to_return .= '<div class="before-approve post-actions">
                    <button class="btn btn-secondary btn-disabled btn-sm" disabled>Scheduled</button>
                    <a class="change-approve-status"  data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="unschedule" href="#">Undo</a>
                </div>

                <div class="after-approve hide">
                    <a class="btn btn-xs btn-secondary change-approve-status" data-post-id="'.$post->id.'" data-phase-id="'.$phase_id.'" data-phase-status="scheduled">Schedule</a>
                </div>';
            }
        }
        return $html_to_return;
    }
}

if(!function_exists('week_month_overlay_buttons'))
{
    function week_month_overlay_buttons($user_is,$approver_status,$phase_status,$phase_id,$post_details,$view_type)
    {
        $CI = & get_instance(); 
        $html_to_return = '';
        if($user_is == 'approver')
        {
            if($approver_status == 'pending' AND $post_details->status != 'scheduled')
            {
                $html_to_return .= '<div class="before-approve post-actions">
                    <button class="btn btn-approved btn-xs btn-default color-success change-approve-status"  data-post-id="'.$post_details->id.'" data-phase-id="'.$phase_id.'" data-phase-status="approved">Approve</button>
                </div>

                <div class="after-approve hide post-actions">
                    <button class="btn btn-secondary btn-disabled btn-xs" disabled>Approved</button>
                    <a class="change-approve-status" data-post-id="'.$post_details->id.'" data-phase-id="'.$phase_id.'" data-phase-status="pending" href="#">Undo</a>
                </div>';
            }
            elseif($phase_status == 'posted')
            {
                $html_to_return .= '<button class="btn btn-approved btn-xs btn-default">View Live</button>';                
            }
            elseif($approver_status == 'approved' AND $post_details->status != 'scheduled')
            {
                $html_to_return .= '<div class="before-approve post-actions">
                    <button class="btn btn-default btn-disabled btn-xs" disabled>Approved</button>';                    
                    if($phase_status == 'pending')
                    {                                       
                        $html_to_return .= '<a  class="change-approve-status"  data-post-id="'.$post_details->id.'" data-phase-id="'.$phase_id.'" data-phase-status="pending" href="#">Undo</a>';
                    }
                $html_to_return .= '</div>';

                $html_to_return .= '<div class="after-approve post-actions hide">
                    <button class="btn btn-approved btn-xs btn-default color-success change-approve-status" data-post-id="'.$post_details->id.'" data-phase-id="'.$phase_id.'" data-phase-status="approved">Approve</button>
                </div>';
            }
            elseif($post_details->status == 'scheduled')
            {
                $html_to_return .= '<button type="button" class="btn btn-xs btn-disabled btn-default">Scheduled</button>';
            }
        }
        else
        {
            if($post_details->user_id == $CI->user_id)
            {
                $html_to_return .= '<div class="btn-group pull-md-right" role="group">
                    <a href="#" data-clear="yes" class="btn btn-xs btn-default edit_post"  data-toggle="modal-ajax" data-modal-id="edit-post-modal" data-modal-size="lg" data-modal-src="'.base_url().'calendar/edit_post_calendar/'.$view_type.'/'.$post_details->slug.'/'.$post_details->id.'">Edit</a>';

                if($post_details->status == 'scheduled')
                {
                    $html_to_return .= '<button type="button" class="btn btn-xs btn-default" disabled>Scheduled</button>    
                    <button type="button" class="btn btn-xs btn-default">Post Now</button>';
                }
                elseif($post_details->status == 'pending')
                {
                    $html_to_return .= '<button class="btn btn-xs btn-default schedule-post" id="'.$post_details->id.'">Schedule</button>
                    <button type="button" class="btn btn-xs btn-default">Post Now</button>';
                }
                elseif($post_details->status == 'posted')
                {
                    $html_to_return .= '<button type="button" class="btn btn-xs btn-default">Posted</button>';
                }
                $html_to_return .= '</div>';
            }
        }
        return $html_to_return;
    }
}

if(!function_exists('get_plan'))
{
    function get_plan($user_id)
    {
        $CI = & get_instance(); 
        $CI->load->model('timeframe_model');
        $plan = $CI->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id'=>$user_id),'plan');
        if($plan)
        {
            return $plan[0]->plan;
        }
        return FALSE;
    }
}


if(!function_exists('relative_date'))
{
    function relative_date($time) {
        $today = strtotime(date('M j, Y'));
        $reldays = ($time - $today) / 86400;
        if ($reldays >= 0 && $reldays < 1) {
            return 'Today '.date('\a\t g:i a' , $time);
        } else
        if ($reldays >= 1 && $reldays < 2) {
            return 'Tomorrow '.date('\a\t g:i a' ,$time);
        } else
        if ($reldays >= -1 && $reldays < 0) {
            return 'Yesterday '.date('\a\t g:i a' , $time);
        }

        if (abs($reldays) < 7) 
        {
            if ($reldays > 0)
            {
                $reldays = floor($reldays);
                return 'In '.$reldays.' day'.($reldays != 1 ? 's' : '');
            }
            else
            {
                $reldays = abs(floor($reldays));
                return $reldays.' day'.($reldays != 1 ? 's' : '').' ago at date ' . date('g:i a', $time);
            }
        }

        if (abs($reldays) < 182)
        {
            return date('F j \a\t g:i a', $time ? $time : time());
        }
        else
        {
            return date('j F, Y \a\t g:i a', $time ? $time : time());
        }
    }
}

if(!function_exists('get_tag_data'))
{
    function get_tag_data($tag_id)
    {
        $CI = & get_instance();
        $CI->load->model('timeframe_model');
        return $CI->timeframe_model->get_data_by_condition('brand_tags',array('id' => $tag_id),'name,color');
    }
}



if(!function_exists('print_user_image'))
{
    function print_user_image($created_by, $user_id)
    {
        $path = img_url()."default_profile.jpg";
        $CI = & get_instance(); 
        $CI->load->model('timeframe_model');
        $data = $CI->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id'=>$user_id),"CONCAT('first_name',' ','last_name') as name");
        if($data)
        {
            $name = $data[0]->name;
        }

        if (file_exists(upload_path().$created_by.'/users/'.$user_id.'.png'))
        {
            $path = upload_url().$created_by.'/users/'.$user_id.'.png?'.uniqid();
        }
        $image = '<img src="'.$path.'" width="36" height="36" alt="'.$name.'" class="circle-img"/>';
        return $image;
    }
}

if(!function_exists('deleteDirectory'))
{
    function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }
}

if(!function_exists('get_company_name'))
{
    function get_company_name($id)
    {
        $CI = &get_instance();
        $CI->load->model('timeframe_model');
        $result = $CI->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id' => $id),'company_name');
        if(!empty($result))
        {
            return $result[0]->company_name;
        }
        return FALSE;
    }
}

if(!function_exists('get_users_full_name'))
{
    function get_users_full_name($user_id)
    {
        $CI = &get_instance();
        $CI->load->model('timeframe_model');
        $result = $CI->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id' => $user_id),'first_name,last_name');
        if(!empty($result))
        {
            return ucfirst($result[0]->first_name).' '.ucfirst($result[0]->last_name);
        }
        return FALSE;
    }
}

if(!function_exists('calculate_date_diff'))
{
    function calculate_date_diff($first_date,$second_date = '')
    {
        $first_date = date('Y-m-d',strtotime($first_date));
        $first_date = strtotime($first_date);
        if(empty($second_date)){
             $second_date = strtotime(date('Y-m-d'));
        }
        $offset = $second_date-$first_date; 
        return floor($offset/60/60/24);
    }
}

if(!function_exists('timezone_list'))
{
    function timezone_list()
    {
        $CI = & get_instance();
        $timezone = $CI->timeframe_model->get_table_data('timezone');
        if($timezone)
        {
            return $timezone;
        }
        return FALSE;

    }
}


