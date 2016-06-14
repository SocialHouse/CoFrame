<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_preferences extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
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
        $this->load->model('user_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	function index()
	{
		$page = $this->uri->segment(2);
		if(empty($page)){
			$page = 'user_info';
		}
		$this->data['background_image'] = 'bg-admin-overview.jpg';
		$this->data['view_name'] = $page;
		$this->data['view'] = 'user_preferences/preference_layout';
		$this->data['layout'] = 'layouts/new_user_layout';
		if($page == 'user_info'){
			$this->data['timezones_list'] = $this->user_model->get_timezones();
			$this->data['user_details'] = $this->user_model->get_user($this->user_id);
		}
		if($page == 'user_plan'){
			$this->data['user_details'] = $this->user_model->get_user($this->user_id);
		}
		$this->data['css_files'] = array(css_url().'fullcalendar.css');
		$this->data['js_files'] = array(js_url().'vendor/jquery-ui-sortable.min.js', js_url().'reorder-brands.js?ver=1.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',);
        _render_view($this->data);

	}

}