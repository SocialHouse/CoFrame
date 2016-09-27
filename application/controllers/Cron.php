<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
use DirkGroenen\Pinterest\Pinterest;
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
        $this->load->model('social_media_model');
        $this->load->config('twitter');
        $this->load->config('tumblr');     
        
        $this->load->library('twitteroauth');
        $this->load->library('tblr');
        ini_set('max_execution_time', 2000);
    }

    function index()
    {
        // $fb = new Facebook\Facebook([
        //   'app_id' => '1711815429100433',
        //   'app_secret' => '270b6c6d8620a4d43375bbb96f98cc69',
        //   'default_graph_version' => 'v2.5',
        // ]);

        // $fb->setDefaultAccessToken('EAAYU4xaSk5EBAP8ZA5nT9vnYhVLWW3GZByRxGc5pCcUyLNRKbyuhiFCnCYx3DEyN3tbfHBY41CJBF2iCehtvge5dDua1j5iZCuLMY2TCfvzqNlZBWF14s50TZASTlRkB5rsD6yek9cshO695evUZAzXD4TpZAmu0pZCWzbYSRaExkZBauUzkq1LBT');

        // $linkData = [
        //   'link' => 'http://www.example.com',
        //   'message' => 'User provided message',
        //   ];

        //  $response = $fb->post('/318999534866425/feed', $linkData, 'EAAYU4xaSk5EBANPBLRxcZCy7JIvb0nk2x2dJEQb3Rjuzx9EEEcGT9ADgT5lJbjnrD5wYnIZAYYuV0ivF9o6V5esNynN27temZBoC6bjvy6lHOTViCcU0KGEtAZAASpRxtQmWljERIZB7WroheEdBHGgHwHeZCxSTT2Sbnz37Dqk4ZAkKRKCxSYbX3KzrT62ZAHsZD');

        //  print_r($response);
        //  die;
    }

    public function get_posts(){
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

                if($post->outlet_constant == "YOUTUBE")
                {
                   $this->youtube_post($post,$flag);
                }

                if($post->outlet_constant == "LINKEDIN")
                {
                    $this->linkedin_post($post,$flag);
                }

                if($post->outlet_constant == "PINTEREST")
                {
                    // echo '<pre>'; print_r($post);echo '</pre>';
                    $this->pintrest_post($post,$flag);
                }
                if($post->outlet_constant == "FACEBOOK")
                {
                    // echo '<pre>'; print_r($post);echo '</pre>';
                    $this->facebook_post($post,$flag);
                }
            }
        }
    }

    public function get_media($post_id,$type,$limit = NULL){
        $result = array('images'=>array(),'video'=>array());
        $all_media = $this->post_model->get_images($post_id);

        if($all_media){
            foreach ($all_media as $key => $media) {
                if($media->type == 'images'){
                    $result['images'][] = $media;
                }
                if($media->type == 'video'){
                    $result['video'][] = $media;
                }
            }
        }

        if($type == 'images' && !empty($result['images'])){
            if(!empty($limit)){
                if($limit == 1){
                    return $result['images'][0];
                }
                return array_slice($result['images'], 0, $limit);
            }
            return $result['images'];
        }

        if($type == 'video' && !empty($result['video'])){
            if(!empty($limit)){
                if($limit == 1){
                   return $result['video'][0];
                }
                return array_slice($result['video'], 0, $limit);
            }
            return $result['video'];
        }
        return FALSE;
    }

    public function set_reminders(){
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

    public function tumblr_post($post_data,$flag){
        $upload = 0;
        $is_key_exist = $this->social_media_model->get_token('tumblr', $post_data->brand_id);

        if(!empty($is_key_exist))
        {
            if($is_key_exist->access_token && $is_key_exist->access_token_secret)
            {
                if($flag == 1)
                {
                    $this->tumblr_connection = $this->tblr->create($this->config->item('tumblr_consumer_key'), $this->config->item('tumblr_secret_key'), $is_key_exist->access_token,  $is_key_exist->access_token_secret);

                    
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
                        if($post_data->tumblr_content_type == "Text")
                        {
                            $post_message = array('type' => 'text', 'title' => $post_data->tumblr_title,'body'=>$post_data->tumblr_text_content, 'format' => 'html','tags' => $post_data->tumblr_tags);                            
                        }
                        elseif($post_data->tumblr_content_type == "Photo")
                        {
                            if(!empty($media))
                            {
                                //for uploaded image
                                $post_message = array('type' => 'photo', 'caption' => $post_data->tumblr_caption,'format' => 'html','tags' => $post_data->tumblr_tags);
                                foreach($media as $file)
                                {
                                    if($file->type == 'images')
                                    {
                                        $post_message['data'] = file_get_contents(upload_path().$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$file->name);
                                    }
                                }                       
                            }
                            else
                            {
                                //for image source
                                $post_message = array('type' => 'photo', 'caption' => $post_data->tumblr_caption,'format' => 'html','tags' => $post_data->tumblr_tags,'source' => $post_data->tumblr_content_source);
                            }
                        }
                        elseif($post_data->tumblr_content_type == "Quote")
                        {
                            $post_message = array('type' => 'quote', 'quote' => $post_data->tumblr_quote,'format' => 'html','tags' => $post_data->tumblr_tags,'source' => $post_data->tumblr_source);
                        }
                        elseif($post_data->tumblr_content_type == "Link")
                        {
                            $post_message = array('type' => 'link', 'url' => $post_data->tumblr_link,'format' => 'html','description' => $post_data->tumblr_link_description);
                        }
                        elseif($post_data->tumblr_content_type == "Chat")
                        {
                            $post_message = array('type' => 'chat', 'title' => $post_data->tumblr_chat_title,'format' => 'html','conversation' => $post_data->tumblr_chat,'tags' => $post_data->tumblr_tags);
                        }
                        elseif($post_data->tumblr_content_type == "Audio")
                        {
                            $post_message = array('type' => 'audio', 'caption' => $post_data->tumblr_audio_description,'format' => 'html','external_url' => $post_data->tumblr_custom_url,'tags' => $post_data->tumblr_tags);
                        }
                        elseif($post_data->tumblr_content_type == "Video")
                        {
                            if(!empty($media))
                            {
                                //for uploaded video
                                $post_message = array('type' => 'video', 'caption' => $post_data->tumblr_video_caption,'format' => 'html','tags' => $post_data->tumblr_tags);
                                foreach($media as $file)
                                {
                                    if($file->type == 'images')
                                    {
                                        $post_message['data'] = file_get_contents(upload_path().$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$file->name);
                                    }
                                }                       
                            }
                            else
                            {
                                //for video source
                                $post_message = array('type' => 'video', 'caption' => $post_data->tumblr_video_caption,'format' => 'html','tags' => $post_data->tumblr_tags,'embed' => '<embed src="'.$post_data->tumblr_source.'">');

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

    public function twitter_post($post_data,$flag){
        $upload = 0;
        $is_key_exist = $this->social_media_model->get_token('twitter', $post_data->brand_id);
        if(!empty($is_key_exist))
        {
            if($is_key_exist->access_token && $is_key_exist->access_token_secret)
            {
                if($flag == 1)
                {
                    $this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $is_key_exist->access_token,  $is_key_exist->access_token_secret);                   
                    
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

    public function youtube_post($post_data,$flag) {
        $upload = 0;
        $this->load->config('youtube');
        $this->client_id = $this->config->item('youtube_client_id');
        $this->client_secret = $this->config->item('youtube_client_secret');
        $this->redirect_uri = $this->config->item('redirect_uri');
        $this->client = new Google_Client();
        $this->client->setClientId($this->client_id);
        $this->client->setClientSecret($this->client_secret);
        $this->client->setRedirectUri($this->redirect_uri);

        $is_key_exist = $this->social_media_model->get_token('youtube', $post_data->brand_id);
        if(!empty($is_key_exist))
        {
            $token = (json_decode($is_key_exist->response,true));
            if(empty($token['refresh_token'])){
                $token['refresh_token']= $is_key_exist->refresh_token;
            }
            $this->client->setAccessToken($token);
            $token_info = $this->client->getAccessToken();
            /*
            *  checked token is valid or not (Expired).  
            *  if not valid(Expired) then update the token info by using refresh token
            */
            if($this->client->isAccessTokenExpired()){
                $new_token_info = $this->client->fetchAccessTokenWithRefreshToken();
                $this->client->setAccessToken($new_token_info);
                $token_data = $this->client->getAccessToken();
                $token_data = json_decode(json_encode($token_data));
                $data = array(
                    'access_token' => $token_data->access_token,
                    'user_id' => $post_data->created_by,
                    'brand_id' => $post_data->brand_id,
                    'response' => json_encode($token_data),
                    'type' => 'youtube'
                    );
                if(!empty($token_data->refresh_token))
                {
                    $data['refresh_token']= $token_data->refresh_token;
                }
                $response = $this->social_media_model->save_token($data);
            }

            $video_list = $this->post_model->get_images($post_data->id);
           
            $htmlBody = '';
            foreach ($video_list as $obj => $video) 
            {
                try
                {
                    $tags = array();
                    if(!empty($post_data->post_tags))
                    {
                        $tags = array_column($post_data->post_tags, 'tag_name');
                    }

                    $youtube = new Google_Service_YouTube($this->client);
                    $videoPath = upload_path().'/'.$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$video->name;
                    if($video->mime == 'video/mp4')
                    {
                        if(file_exists($videoPath))
                        {
                            echo gmdate("Y-m-d\Th:i:s.sZ", strtotime($post_data->slate_date_time));
                            $snippet = new Google_Service_YouTube_VideoSnippet();
                            $snippet->setTitle("POST ID".$post_data->id);
                            $snippet->setDescription($post_data->content);
                            $snippet->setTags($tags);
                            // Numeric video category. See
                            // https://developers.google.com/youtube/v3/docs/videoCategories/list
                            $snippet->setCategoryId("22");
                            
                            // Set the video's status to "public". Valid statuses are "public",
                            // "private" and "unlisted".
                            // 2016-08-04
                            
                            $status = new Google_Service_YouTube_VideoStatus();
                            $status->privacyStatus = "private";
                            $status->setPublishAt(date("Y-m-d\Th:i:s.s\Z", strtotime($post_data->slate_date_time)));
                            
                            // Associate the snippet and status objects with a new video resource.

                            $video = new Google_Service_YouTube_Video();
                            $video->setSnippet($snippet);
                            $video->setStatus($status);
                            $chunkSizeBytes = 1 * 1024 * 1024;
                            $this->client->setDefer(true);
                            
                            // Create a request for the API's videos.insert method to create and upload the video.
                            
                            $insertRequest = $youtube->videos->insert("status,snippet", $video);
                            
                            // Create a MediaFileUpload object for resumable uploads.
                            
                            $media = new Google_Http_MediaFileUpload(
                                $this->client, $insertRequest, 'video/*', null, true, $chunkSizeBytes
                                );
                            $media->setFileSize(filesize($videoPath));
                            // Read the media file and upload it chunk by chunk.
                            $status = false;
                            $handle = fopen($videoPath, "rb");
                            while (!$status && !feof($handle)) 
                            {
                                $chunk = fread($handle, $chunkSizeBytes);
                                $status = $media->nextChunk($chunk);
                            }
                            fclose($handle);
                            // If you want to make other calls after the file upload, set setDefer back to false
                            $this->client->setDefer(false);

                            $htmlBody .= "<h3>Video Uploaded</h3><ul>";
                            $htmlBody .= sprintf('<li>%s (%s)</li>', $status['snippet']['title'], $status['id']);
                            $htmlBody .= '</ul>';
                        }else{
                            $htmlBody='Invalid file path or file dose not exits';
                        }
                    }
                } 
                catch (Google_Service_Exception $e) 
                {
                    $errors = json_decode($e->getMessage())->error->errors[0];
                    echo '<pre>'; print_r($errors);echo '</pre>';
                    //$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
                } 
                catch (Google_Exception $e) 
                {
                    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
                }
                catch (Exception $e) 
                {
                    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
                }
            }
            echo $htmlBody;
            return;
        }
    }

    public function linkedin_post($post_data,$flag){
        $token=''; 
        $image_url = '';
        if($this->session->userdata('linkedin_token') && $flag == 1 ){
            $token['linkedin'] = $this->session->userdata('linkedin_token');
            $token['success'] ='1';
           // $this->session->unset_userdata('linkedin_token');
        }else{
            $is_key_exist = $this->social_media_model->get_token('linkedin',$post_data->brand_id);
            if(!empty($is_key_exist)){
                $token = json_decode($is_key_exist->response,true);
            }
        }
        
        $media = $this->get_media($post_data->id,'images',1);
        if($media){
            if(file_exists(upload_path().$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$media->name)){
                $image_url = base_url().'uploads/'.$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$media->name;
            }
        }
        
        $tags = array();
        if(!empty($post_data->post_tags))
        {
            $tags = implode(", ", array_column($post_data->post_tags, 'tag_name')) ;
        }
       
        if(!empty($token))
        {
            $this->load->config('linkedin');
            $data['appKey'] = $this->config->item('linked_in_api_key');
            $data['appSecret'] = $this->config->item('linked_in_secret_key');
            $data['callbackUrl'] = $this->config->item('linked_in_callback_url');
            $this->load->library('linkedin', $data);
            $this->linkedin->setResponseFormat($this->config->item('response_type'));
            if($token['success']){
                $token_expires_in = floor ($token['linkedin']['oauth_expires_in']/ 86400);
                if($token_expires_in > 55){
                    $this->linkedin->setToken($token['linkedin']);
                    $this->session->set_userdata('linkedin_token',$token['linkedin']);
                    $content = array();
                    $content['comment'] = (!empty($tags))? $tags :'' ;
                    $content['title'] = (!empty($post_data->content))? $post_data->content :'' ;
                    $content['description'] = (!empty($post_data->content))? $post_data->content :'' ;

                    if(!empty($image_url)){
                        $content['submitted-image-url'] = $image_url;
                        $content['submitted-url']       = $image_url;
                    }

                    /*$content['submitted-url'] = 'http://timeframe-dev.blueshoon.com/uploads/4/brands/3/posts/579c9e17bf338.jpg';
                    $content['submitted-image-url'] = 'http://timeframe-dev.blueshoon.com/uploads/4/brands/3/posts/579c9e17bf338.jpg';*/
                   
                    $private = FALSE;
                    $twitter = FALSE;
                    $response = $this->linkedin->share('new', $content, $private, $twitter);
                    if($response['success'] === TRUE) {
                     // echo 'SHARING content:<br /><br />RESPONSE:<br /><br /><pre>'; print_r($response);echo '</pre>'; 
                    }else{
                        // send mail to creator 
                      // echo "Error SHARING content:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br />";
                    }
                }
            }
        }
    }

    public function pintrest_post($post_data,$flag){
        
        $upload = 0;
        $image_url = "";

        if($this->session->userdata('pinterest_access_token') && $flag == 1 ){
            $token = $this->session->userdata('pinterest_access_token');
           // $this->session->unset_userdata('pinterest_access_token');
            // echo 'In Session <br/>';
        }else{
            $is_key_exist = $this->social_media_model->get_token('pinterest', $post_data->brand_id);
            if(!empty($is_key_exist)){
                $token = json_decode($is_key_exist->response,true);
                $this->session->set_userdata('pinterest_access_token',$token);
                // echo 'record found <br/>'; 
            }
            // echo 'record not found <br/>';  
        }

        $media = $this->get_media($post_data->id,'images',1);
        if($media){
            if(file_exists(upload_path().$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$media->name)){
                $image_url = base_url().'uploads/'.$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$media->name;
            }
        }
        
        if(!empty( $token )){
            //echo 'got Token <br/>';
            $this->load->config('pinterest');
            $this->pinterest = new Pinterest($this->config->item('pinterest_app_id'), $this->config->item('pinterest_app_secret'));
            $this->pinterest->auth->setOAuthToken($token['access_token']);
            $result = '';
            $result = $this->pinterest->pins->create(
                                        array(
                                            "note"          => (!empty($post_data->content))? $post_data->content :'' ,
                                            "image_url"     => $image_url,
                                            "media"         => $image_url,
                                            // "image_url"     => 'http://timeframe-dev.blueshoon.com/uploads/4/brands/3/posts/579c9e17bf338.jpg',
                                            // "media"         => 'http://timeframe-dev.blueshoon.com/uploads/4/brands/3/posts/579c9e17bf338.jpg',
                                            "board"         => "309481874332798366"
                                        )
                                    );
           // echo $result;
        }
    }

    public function facebook_post($post_data ,$flag){
        $upload = 0;
        $image_url = "";

        if($this->session->userdata('fb_access_token') && $flag == 1 )
        {
            // $this->session->userdata('fb_access_token', $access_token->getValue());
            $access_token = $this->session->userdata('fb_access_token');
            $fb_page_id = $this->session->userdata('fb_page_id');
            echo 'In session <br/>';
        }
        else
        {
            $is_key_exist = $this->social_media_model->get_token('facebook', $post_data->brand_id);
            if(!empty($is_key_exist))
            {
                $access_token = $is_key_exist->access_token;
                $fb_page_id = $is_key_exist->fb_page_id;
                $this->session->set_userdata('fb_access_token',$access_token);
                $this->session->set_userdata('fb_page_id',$fb_page_id);
                echo 'Set session <br/>';
            }
            else
            {
                echo 'record not found <br/>';     
            }
        }
        if(!empty( $access_token ))
        {
            $this->load->library('facebook');
            $tags = array();
            if(!empty($post_data->post_tags))
            {
                $tags = implode(", @", array_column($post_data->post_tags, 'tag_name')) ;
                $tags = '@'.$tags;
            }
            if ($this->facebook->is_authenticated())
            {
                $post_array = array();               
                $all_images = $this->get_media($post_data->id,'images');
                $all_videos = $this->get_media($post_data->id,'video',1);
                
                $user_info = $this->facebook->request('get', '/me?fields=accounts');
                $page_token = $page_name = $page_id = '';
                if (!isset($user_info['error']))
                {
                    foreach ($user_info['accounts']['data'] as $key => $pages) {
                        if( $pages['id'] == $fb_page_id)
                        {
                            $page_token = $pages['access_token'];
                            $page_name = $pages['name'];
                            $page_id = $pages['id'];
                        }
                        // echo '<pre>'; print_r($pages);echo '</pre>';
                    }
                }
                if(empty($page_token)){
                    $page_id = 'me';
                    $page_token = '';
                }

                if(empty( $all_images) && empty( $all_videos) && !empty($post_data->content)){
                    $privacy = array(
                        'value' => 'EVERYONE' //EVERYONE, ALL_FRIENDS, NETWORKS_FRIENDS, FRIENDS_OF_FRIENDS, CUSTOM .
                    );
                    $result = $this->facebook->request(
                        'POST',
                        $page_id.'/feed',
                        ['message' => $post_data->content],
                        $page_token
                    );
                    echo "only text is posted <br/>".json_encode($result);
                }

                $this->fb = $this->facebook->object();
                
                if(!empty($all_images))
                {
                    if(count($all_images)>1){
                        echo 'multiple ';
                        $images =[];

                        foreach ($all_images as $key => $img) {
                            if(file_exists(upload_path().$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$img->name))
                            {
                                $path = base_url().'uploads/'.$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$img->name;
                                $images[$key]['img_url'] = str_replace("https://", "http://", $path);
                                $images[$key]['desc']   = $post_data->content;
                            }
                        }
                        
                        $this->facebook_upload_images($page_id, $images,$page_token);
                    }else{
                        // if only one image is present
                        if(file_exists(upload_path().$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$all_images[0]->name))
                        {
                            $path = base_url().'uploads/'.$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$all_images[0]->name;
                            $result = $this->facebook->request(
                                                'POST',
                                                $page_id.'/photos',
                                                ['message' => $post_data->content,'picture' => $path,'source'  => $this->fb->fileToUpload($path)],
                                                $page_token
                                            );
                            echo json_encode($result);
                        }else{
                            echo '<br/> file not found <br/>';
                        }
                    }
                    // echo '<pre>'; print_r($data);echo '</pre>'; die;                     
                }

                if(!empty($all_videos))
                {
                    $videos = array();
                    if(file_exists(upload_path().$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$all_videos->name))
                    {
                        $videos['video_url']    = base_url().'uploads/'.$post_data->created_by.'/brands/'.$post_data->brand_id.'/posts/'.$all_videos->name;
                        $videos['desc']   = $post_data->content;
                    }
                    $this->facebook_upload_video($page_id, $videos, $page_token);
                }

            }else{
                echo "is_not_authenticated <br/>";
            }
        }
    }

    public function facebook_upload_images($page_id, $images, $page_token){
        // echo '<pre>'; print_r([$page_id, $images,$token]);echo '</pre>';
        if(!empty($page_id) && !empty($page_token)){
            // Creating new photo album
        
            $album_id = $this->create_album('6 album','this is album',$page_id, $page_token );
            $response = $this->add_imgs_to_album($album_id, $images, $page_token);
        }
    }

    public function facebook_upload_video($page_id ,$video, $token){
        // echo $page_token;
        // die();
        $parms = array(
                'message'   => $video['desc'] ,
                'picture'   => $video['video_url'] ,
                'source '   => $this->fb->videoToUpload($video['video_url'])
            );
        $video_response = $this->facebook->request('POST',$page_id."/videos",$parms,$token);
        echo json_encode($video_response);
    }

    public function add_imgs_to_album( $album_id, $images, $token){
        $error = TRUE;
        foreach ($images as $key => $img) {
            $parms = array('message' =>  $img['desc']);
            $parms['url'] = $img['img_url'];
            $data = $this->facebook->request('POST','/'. $album_id .'/photos',$parms, $token);
            echo '<br/>'.json_encode($data);
            if (isset($data['error'])){
                $is_error = FALSE;
            }
        }
        return $error;
    }

    public function create_album($name,$msg,$page_id,$page_token){
        $privacy = array(
                'value' => 'EVERYONE' //EVERYONE, ALL_FRIENDS, NETWORKS_FRIENDS, FRIENDS_OF_FRIENDS, CUSTOM .
            );

        $album_details = array(
                    'name'      => $name,
                    'message'   => $msg,
                    'privacy'   => $privacy,
                    'published' => 'true'
            );

        $album_response = $this->facebook->request('POST', $page_id.'/albums', $album_details,$page_token);
        if (!isset($album_response['error']))
        {
            echo '<br/>album created<br/>'.json_encode($album_response);
            return $album_response['id'];
        }
        return FALSE;
    }
}