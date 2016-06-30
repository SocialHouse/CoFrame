<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drafts extends CI_Controller {

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
		$this->load->model('timeframe_model');
		$this->load->model('post_model');
		$this->load->model('brand_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	function index()
	{
		$this->data = array();
		$slug = $this->uri->segment(2);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);
		check_access('create',$brand);
		if(!empty($brand))
		{
			$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);
			$brand_id = $brand[0]->id;
			$this->data['brand_id'] = $brand_id;
			$this->data['brand'] = $brand[0];

			$this->data['drafts'] = $this->timeframe_model->get_data_by_condition('posts',array('status' => 'draft','user_id' => $this->user_id));

			$this->data['js_files'] = array(js_url().'vendor/isotope.pkgd.min.js?ver=3.0.0',js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'post-filters.js?ver=1.0.0', js_url().'drag-drop-file-upload.js?ver=1.0.0');

			$this->data['view'] = 'drafts/draft_list';
			$this->data['layout'] = 'layouts/new_user_layout';		
			
			$this->data['background_image'] = 'bg-brand-management.jpg';
			_render_view($this->data);
		}
	}

	public function duplicate($slug,$post_id)
	{
		$status = $this->post_model->duplicate_post($post_id);
		$message = "Post has been duplicated successfully";
		if($atatus)
		{
			$message = "Unable to duplicate post please try again";
		}
		redirect(base_url().'drafts/'.$slug);
	}
}