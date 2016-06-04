<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calender extends CI_Controller {
	
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
			$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0');
			$this->data['view'] = 'calender/day_view';
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

			$this->data['view'] = 'calender/month_view';
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

			$this->data['view'] = 'calender/week_view';
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

    public function edit_date()
    {
    	$this->load->view('calender/edit_date');
    }

    public function edit_menu()
    {
    	$this->load->view('calender/edit_menu');
    }

    public function get_post_by_date(){
    	$brand_id = $this->input->post('brand_id');
    	$sdate = $this->input->post('sdate');
	    if(!empty($brand_id)){
	    	$this->data['post_details'] = $this->post_model->get_post_by_date($brand_id,$sdate);
	    	echo $this->load->view('calender/post_preview/day_post',$this->data,true);
	    }else{
	    	echo false;
	    }
    }
}