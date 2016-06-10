<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class calendar extends CI_Controller {
	
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
		is_user_logged();
		$this->load->model('timeframe_model');
		$this->load->model('brand_model');
		$this->load->model('post_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	public function day()
	{
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);

		if(!empty($brand))
		{
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['brand'] = $brand[0];

			$this->data['post_details'] = $this->post_model->get_post_by_date($brand[0]->id);
			
			//echo '<pre>'; print_r($this->data['post_details'] );echo '</pre>'; die;			
			$this->data['css_files'] = array(css_url().'fullcalendar.css');
			$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0', js_url().'drag-drop-file-upload.js?ver=1.0.0');
			$this->data['view'] = 'calendar/day_view';
	        _render_view($this->data);
	    }
	}

	public function month()
    {
    	$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);

		if(!empty($brand))
		{
			$this->data['brand'] = $brand[0];
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['css_files'] = array(css_url().'fullcalendar.css');
			$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0');

			$this->data['view'] = 'calendar/month_view';
	        _render_view($this->data);
	    }
    }

    public function week()
    {
    	
    	$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);

		if(!empty($brand))
		{
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['brand'] = $brand[0];
			$this->data['css_files'] = array(css_url().'fullcalendar.css');
			$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'vendor/jquery.dotdotdot.min.js?ver=1.8.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0');

			$this->data['view'] = 'calendar/week_view';
	        _render_view($this->data);
	    }
    }

    public function get_events()
    {
    	$brand_id = $this->input->post('brand_id');
    	$outlets = $this->input->post('outlets');
    	$statuses = $this->input->post('statuses');
    	$start_date = $this->input->post('start');
    	$end_date = $this->input->post('end');
    	$tags =  $this->input->post('tags');
    	$posts = $this->post_model->get_posts_by_time($brand_id,$start_date,$end_date,$outlets,$statuses,$tags);
    	echo json_encode($posts);    	
    }

    public function post_filters()
    {
    	$this->data = array();
    	$brand_id = $this->uri->segment(3);
    	$this->data['outlets'] = $this->post_model->get_brand_outlets($brand_id);
    	$this->data['tags'] = $this->post_model->get_brand_tags($brand_id);
    	echo $this->load->view('partials/post_filters',$this->data,true);
    }

    public function print_posts()
    {
    	$brand_id = $this->uri->segment(3);
    	$this->load->view('partials/print_posts');
    }


    public function get_post_by_date(){
    	$brand_id = $this->input->post('brand_id');
    	$sdate = $this->input->post('sdate');
	    if(!empty($brand_id)){
	    	$this->data['post_details'] = $this->post_model->get_post_by_date($brand_id,$sdate);
	    	echo $this->load->view('calendar/post_preview/day_post',$this->data,true);
	    }else{
	    	echo false;
	    }
    }

    public function get_view()
	{
		$this->data = '';
		$path = $this->uri->segment(3);

		if(!empty($path)){
			if($path == 'edit_menu' || $path == 'edit_date' ){
				$this->data['slug'] = $this->uri->segment(4);
				$this->data['post_id'] = $this->uri->segment(5);
			}
			$this->load->view('calendar/'.$path, $this->data);
		}
		else{

		}
	} 

	public function edit_post_calendar()
	{		
		$this->data['slug'] = $this->uri->segment(3);
		$this->data['post_id'] = $this->uri->segment(4);
		if(!empty($this->data['post_id'])){
			$post_id = $this->data['post_id'];
			$post_details = $this->post_model->get_post($this->data['post_id']);
			$this->data['post_details'] = $post_details;
			$this->data['post_images'] = $this->post_model->get_images($post_id);
			$this->data['outlets'] = $this->post_model->get_brand_outlets($post_details->brand_id);
			$post_phases = $this->post_model->get_post_phases($post_id);
			$this->data['selected_tags'] = $this->post_model->get_post_tags($post_id);		
			if(!empty($post_phases))
			{
				foreach($post_phases as $phase)
				{
					$this->data['phases'][$phase->phase][] = $phase;
				}
			}

			
		}
			$this->data['css_files'] = array(css_url().'fullcalendar.css');
			$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0', js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'datepicker.js',js_url().'timepicker.js');
		// echo '<pre>'; print_r($post_phases);echo '</pre>';
		$this->load->view('calendar/edit_post_calendar', $this->data);
	}

	public function reschedule_post()
	{
		$sdate = '';
		$post_data = $this->input->post();
		$schedule_date = $post_data['post_date'].' '.$post_data['post_hour'].':'.$post_data['post_minute'].' '.$post_data['post_ampm'];
		$schedule_date = date("Y-m-d H:i", strtotime($schedule_date));
		$condition = array('id' => $post_data['post_id']);
		$scheduler_array = array('slate_date_time'=> $schedule_date );
		$result = $this->timeframe_model->update_data('posts',$scheduler_array,$condition);
		if($result){
			$post_details = $this->post_model->get_post($post_data['post_id']);
			if(!empty($post_data['selcted_data'])){
				$sdate = $post_data['selcted_data'];
			}
			$this->data['post_details'] = $this->post_model->get_post_by_date( $post_details->brand_id,$sdate);
	    	echo $this->load->view('calendar/post_preview/day_post',$this->data,true);
		}else{
			echo 'false';
		}
	}

	public function get_brand_users_by_post($brand_id, $post_id,$phase_count)
	{
		$this->data = '';
		$this->data['phases'] = '';
		if(!empty($post_id)){
			$this->data['post_details'] =  $this->post_model->get_post($post_id);
			$post_phases = $this->post_model->get_post_phases($post_id);
			if(!empty($post_phases))
			{
				foreach($post_phases as $phase)
				{
					$this->data['phases'][$phase->phase][] = $phase;
				}
			}
			$this->data['users'] = $this->brand_model->get_brand_users($brand_id);
			$this->data['current_phase'] = $phase_count;
			// echo '<pre>'; print_r($this->data);echo '</pre>'; 
		}
		echo $this->load->view('calendar/post_user_list',$this->data,true);
	}


	public function approval_list($post_id){
		$this->data ='';
		if(!empty($post_id)){
			$post_phases = $this->post_model->get_post_phases($post_id);
			if(!empty($post_phases))
			{
				foreach($post_phases as $phase)
				{
					if($phase->status == 'approved' ){
						$this->data['approved'][] = $phase;
					}
					if($phase->status == 'pending' ){
						$this->data['pending'][] = $phase;
					}
				}
			}
			//echo '<pre>'; print_r($this->data);echo '</pre>'; die;
			$this->load->view('calendar/approval_list', $this->data);			
		}
		
	}


	public function edit_post()
	{
		$this->data = array();
		$error = '';
		$uploaded_files = array();
		$post_data = $this->input->post();
		echo '<pre>'; print_r($post_data);echo '</pre>';
		if(!empty($post_data['post_id'])){
			$date_time =  $post_data['post-date'].' '.$post_data['post-hour'].':'.$post_data['post-minute'].' '.$post_data['post-ampm'];
		    $slate_date_time = date("Y-m-d H:i:s", strtotime($date_time));
		   /* if(!empty($post_data['post_outlet']))
    		{*/
				$condition = array('id' => $post_data['post_outlet']);
				$post_condition = array('id' => $post_data['post_id']);
				$outlet_data = $this->timeframe_model->get_data_by_condition('outlets',$condition,'outlet_name');
				
				if(!empty($post_data['post_tag'])){

					$selected_tags = $this->post_model->get_post_tags($post_data['post_id']);
					
					$tags_to_add = isset($post_data['post_tag']) ? $post_data['post_tag']: array();

					if(!empty($selected_tags )){
						$selected_tags_ids = array_column($selected_tags,'id'); // list of selected tags ids
						
						$tags_to_add = array_diff($post_data['post_tag'],$selected_tags_ids); // new tags to add 
			        	
			        	$tags_to_delete = array_diff($selected_tags_ids,$post_data['post_tag']); // old tags that we want to remove 

			        	foreach ($tags_to_delete as $tag)
			        	{
			        		$condition = array('brand_tag_id' => $tag,'post_id' => $post_data['post_id']);
			        		$this->timeframe_model->delete_data('post_tags',$condition);
			        	}
					}
					
					foreach($tags_to_add as $tag)
		    			{

		    				$post_tag_data = array(
		    										'post_id' => $post_data['post_id'],
		    										'brand_tag_id' => $tag
		    									);
		    			
		    				$this->timeframe_model->insert_data('post_tags',$post_tag_data);
		    			}

				}

				if(isset($post_data['uploaded_files'][0]) AND !empty($post_data['uploaded_files'][0]))
				{
					$files = json_decode($post_data['uploaded_files'][0])->success;
				}
	    		if(isset($files) AND !empty($files))
	    		{
	    			foreach($files as $file)
	    			{
	    				$post_media_data = array(
	    										'post_id' => $post_data['post_id'],
	    										'name' => $file->file,
	    										'type' => $file->type,
	    										'mime' => $file->mime
	    									);

	    				$this->timeframe_model->insert_data('post_media',$post_media_data);
	    			}
	    		}
				
	        	
				$post = array(
    						'content' => $this->input->post('post_copy'),
    						'slate_date_time' => $slate_date_time,
    					);

				$result = $this->timeframe_model->update_data('posts', $post, $post_condition);
				$this->session->set_flashdata('message','Post has been updated successfuly.');
	    		redirect(base_url().'calendar/day/'.$post_data['brand_slug']);

		}
	}

	public function selected_tag_list($brand_id, $post_id)
	{
		if(!empty($post_id)){
			$this->data['tags'] = $this->post_model->get_brand_tags($brand_id);
			$this->data['selected_tags'] = $this->post_model->get_post_tags($post_id);
    		echo $this->load->view('calendar/selected_tag_list',$this->data,true);
		}
	}	
}