<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Footer extends CI_Controller {
	
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
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
	}

	public function terms_of_use()
    {
        $this->data['view'] = 'tour/terms_of_use';
        _render_view($this->data);
    }
}
?>