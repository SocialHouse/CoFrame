<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'third_party/facebook-php-sdk/src/Facebook/autoload.php');
use Facebook\FacebookRequest;
// use Facebook\FacebookSession;

class Cron extends CI_Controller {

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
        // $this->load->model('user_model');
        $this->load->model('timeframe_model');
        $this->load->model('post_model');
        $this->load->config('twitter');
        $this->load->config('tumblr');     
        
        $this->load->library('twitteroauth');
        $this->load->library('tblr');
        ini_set('max_execution_time', 2000);
    }

    function index()
    {
        $fb = new Facebook\Facebook([
          'app_id' => '1711815429100433',
          'app_secret' => '270b6c6d8620a4d43375bbb96f98cc69',
          'default_graph_version' => 'v2.5',
        ]);

        $fb->setDefaultAccessToken('EAAYU4xaSk5EBAP8ZA5nT9vnYhVLWW3GZByRxGc5pCcUyLNRKbyuhiFCnCYx3DEyN3tbfHBY41CJBF2iCehtvge5dDua1j5iZCuLMY2TCfvzqNlZBWF14s50TZASTlRkB5rsD6yek9cshO695evUZAzXD4TpZAmu0pZCWzbYSRaExkZBauUzkq1LBT');

        $linkData = [
          'link' => 'http://www.example.com',
          'message' => 'User provided message',
          ];

         $response = $fb->post('/318999534866425/feed', $linkData, 'EAAYU4xaSk5EBANPBLRxcZCy7JIvb0nk2x2dJEQb3Rjuzx9EEEcGT9ADgT5lJbjnrD5wYnIZAYYuV0ivF9o6V5esNynN27temZBoC6bjvy6lHOTViCcU0KGEtAZAASpRxtQmWljERIZB7WroheEdBHGgHwHeZCxSTT2Sbnz37Dqk4ZAkKRKCxSYbX3KzrT62ZAHsZD');

         print_r($response);
         die;
    }

    public function get_posts()
    {
        // $posts = $this->timeframe_model->get_data_by_condition('posts',array('status' => 'scheduled','DATE_FORMAT(posts.slate_date_time,"%m-%d-%Y")' => date('m-d-Y')));
        // echo $this->db->last_query();

        // $posts = $this->post_model->get_post_by_date('','',date('Y-m-d'),'scheduled');
        $posts = $this->post_model->get_posts_with_outlet(date('Y-m-d'));

        
        if(!empty($posts))
        {
            $previous_owner = '';
            $previous_outlet = '';
            foreach($posts as $post)
            {
                $flag = 0;
                if(empty($previous_owner) AND empty($previous_outlet))
                {
                    $previous_owner = $post->created_by;
                    $previous_outlet = $post->outlet_constant;
                    $flag = 1;
                }

                if($previous_owner != $post->created_by OR $previous_outlet != $post->outlet_constant)
                {
                    $previous_owner = $post->created_by;
                    $previous_outlet = $post->outlet_constant;
                    $flag = 1;
                }
                if($post->outlet_constant == "TWITTER")
                {
                    $this->twitter_post($post,$flag);
                }
                if($post->outlet_constant == "TUMBLR")
                {
                    $this->tumblr_post($post,$flag);
                }
            }
        }
    }

    function tumblr_post($post_data,$flag)
    {
        $upload = 0;
        $condition = array('user_id' => $post_data->created_by,'type' => 'tumblr');
        $is_key_exist = $this->timeframe_model->get_data_by_condition('social_media_keys',$condition);     
        if(!empty($is_key_exist))
        {
            if($is_key_exist[0]->access_token && $is_key_exist[0]->access_token_secret)
            {
                if($flag == 1)
                {
                    $this->tumblr_connection = $this->tblr->create($this->config->item('tumblr_consumer_key'), $this->config->item('tumblr_secret_key'), $is_key_exist[0]->access_token,  $is_key_exist[0]->access_token_secret);

                    
                    $user_info = $user_info = $this->tumblr_connection->get('user/info');                   
                        
                    if(!isset($user_info->errors))
                    {                           
                        $upload = 1;    
                    }                    
                }
                else
                {
                    $user_info = $user_info = $this->tumblr_connection->get('user/info');
                    $upload = 1;                    
                }

                if($upload == 1)
                {
                    echo "<pre>";
                    $media = $this->post_model->get_images($post_data->id);                    
                    
                    if (is_object($user_info->response)) 
                    {
                        //array of all users blogs
                        $blogs = $user_info->response->user->blogs;
                        foreach ($blogs as $blog) 
                        {
                            $str_user_blog = trim(str_replace('/', '', str_replace('http://', '', $blog->url)));
                        }
                    }
                    if(!empty($str_user_blog))
                    {
                        $post_message = array('type' => 'regular', 'title' => $post_data->content, 'format' => 'html');
                        // $post_message = array('type' => 'regular', 'title' => $post_data->content, 'format' => 'html');
                        $is_video = 0;
                        if(!empty($media))
                        {                        
                            if(!empty($media))
                            {
                                $post_message = array('type' => 'photo', 'caption' => $post_data->content,'format' => 'html');
                                foreach($media as $file)
                                {
                                    if($file->type == 'images')
                                    {
                                        $post_message['data'] = file_get_contents(upload_path().$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$file->name);
                                    }
                                    else
                                    {
                                        $post_message['type'] = 'video';
                                        $post_message['data'] = file_get_contents(upload_path().$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$file->name);                             
                                    }
                                }                       
                            }
                        }

                        $post_status = $this->tumblr_connection->post('blog/'.$str_user_blog.'/post', $post_message);
                        if(!empty($post_message))
                        {
                            if(isset($post_status->meta->status) AND $post_status->meta->status == 201)
                            {                           
                                $status_data = array(
                                                'status' => 'posted'
                                            );
                                $this->timeframe_model->update_data('posts',$status_data,array('id' => $post_data->id));
                            }
                        }
                    }                    
                }
                return;

            }
        }
    }

    public function twitter_post($post_data,$flag)
    {
        $upload = 0;
        $condition = array('user_id' => $post_data->created_by,'type' => 'twitter');
        $is_key_exist = $this->timeframe_model->get_data_by_condition('social_media_keys',$condition);      
        if(!empty($is_key_exist))
        {
            if($is_key_exist[0]->access_token && $is_key_exist[0]->access_token_secret)
            {
                if($flag == 1)
                {
                    $this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $is_key_exist[0]->access_token,  $is_key_exist[0]->access_token_secret);                   
                    
                    $content = $this->connection->get('account/verify_credentials'); 
                        
                    if(!isset($content->errors))
                    {                           
                        $upload = 1;    
                    }                    
                }
                else
                {
                    $upload = 1;                    
                }

                if($upload == 1)
                {
                    $media = $this->post_model->get_images($post_data->id);
                    $media_ids = [];
                    $is_video = 0;
                    if(!empty($media))
                    {                        
                        if(!empty($media))
                        {                        
                            foreach($media as $file)
                            {
                                if($file->type == 'images')
                                {
                                    $file_path = file_get_contents(upload_path().$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$file->name);
                                    $base = base64_encode($file_path);
                                    $data = array(
                                               'media' => $base
                                            );

                                    $result = $this->connection->post('media/upload', $data);
                                    $media_ids[] = $result->media_id_string;
                                }
                                else
                                {
                                    $is_video = 1;
                                    $file_path = upload_path().$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$file->name;
                                    $size_bytes = (int)filesize($file_path);
                                    $fp         = fopen($file_path, 'r');

                                    // INIT the upload
                                    $media_data = array(
                                          'command'     => 'INIT',
                                          'media_type'  => $file->mime,
                                          'total_bytes' => $size_bytes
                                        );
                                    $reply = $this->connection->post('media/upload',$media_data);                                 
                                    $media_id = $reply->media_id_string;

                                    // APPEND data to the upload

                                    $segment_id = 0;

                                    while (! feof($fp)) {
                                      $chunk = fread($fp, 1048576); // 1MB per chunk for this sample

                                      $reply = $this->connection->post('media/upload',[
                                        'command'       => 'APPEND',
                                        'media_id'      => $media_id,
                                        'segment_index' => $segment_id,
                                        'media_data' => base64_encode($chunk)
                                        // 'media'         => $chunk
                                      ]);

                                      $segment_id++;
                                    }

                                    fclose($fp);

                                    // FINALIZE the upload
                                    $reply = $this->connection->post('media/upload',[
                                      'command'       => 'FINALIZE',
                                      'media_id'      => $media_id
                                    ]);

                                    var_dump($reply);
                                    

                                    // Now use the media_id in a Tweet
                                    $reply = $this->connection->post('statuses/update',[
                                      'status'    => $post_data->content,
                                      'media_ids' => $media_id
                                    ]);

                                    if(!isset($reply->errors))
                                    {                           
                                        $status_data = array(
                                                        'status' => 'posted'
                                                    );
                                        $this->timeframe_model->update_data('posts',$status_data,array('id' => $post_data->id));
                                    }
                                }
                            }                       
                        }
                    }
                   
                    if($is_video == 0)
                    {
                        $parameters = [
                            'status' => !empty($post_data->content) ? $post_data->content : '',
                            'media_ids' => implode(',', $media_ids)
                        ];
                        if(empty($media))
                        {
                            unset($parameters['media_ids']);
                        } 

                        $reply = $this->connection->post('statuses/update', $parameters);                       
                        if(!isset($reply->errors))
                        {                           
                            $status_data = array(
                                            'status' => 'posted'
                                        );
                            $this->timeframe_model->update_data('posts',$status_data,array('id' => $post_data->id));
                        }
                    }
                }
                return;
            }         
        }        
        
    }

    function connect_to_twitter()
    {
        $this->load->view('social_media/facebook');
    }

    function set_reminders()
    {
        $posts = $this->timeframe_model->get_data_by_condition('posts',array('status !=' => 'sceduled','date_format(slate_date_time,"%Y-%m-%d %H:%i") >=' => date('Y-m-d H:i'),'date_format(slate_date_time,"%Y-%m-%d %H:%i") <=' => date('Y-m-d H:i',strtotime('+1 hours'))));

        if(!empty($posts))
        {
            foreach($posts as $post)
            {
                $is_reminder = $this->timeframe_model->get_data_by_condition('reminders',array('post_id' => $post->id,'added_through_cron' => 1),'id');

                if(empty($is_reminder))
                {
                    $reminder_data = array(
                                        'post_id' => $post->id,
                                        'user_id' => $post->user_id,
                                        'type' => 'reminder',
                                        'brand_id' => $post->brand_id,
                                        'due_date' => $post->slate_date_time,
                                        'text' => 'Post '.date('Y-m-d h:i a',strtotime($post->slate_date_time)).' '.get_outlet_by_id($post->outlet_id).' post now',
                                        'added_through_cron' => 1
                                    );
                    $this->timeframe_model->insert_data('reminders',$reminder_data);
                }
            }            
        }
    }

}