<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approvals extends CI_Controller {

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
		$this->load->model('approval_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	function index()
	{
		$this->data = array();
		$brand_id = $this->uri->segment(2);
		$group = get_user_groups($this->user_id);
		
		$user_id = '';
		if($group == 'Approver')
		{
			$user_id = $this->user_id;
		}

		$approvals = $this->approval_model->get_approvals($user_id,$brand_id);		
		$this->data['approval_list'] = array();
		if(!empty($approvals))
		{
			foreach($approvals as $approval)
			{
				$this->data['approval_list'][date('D m/d',strtotime($approval->slate_date_time))][$approval->post_id] = $approval;
			}
		}

		$this->data['view'] = 'approvals/approval_list';

        _render_view($this->data);
	}

	
}