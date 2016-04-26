<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

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
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	function delete_phase()
	{
		$phase_id = $this->input->post('phase_id');

		$this->load->model('phase_model');
		$phase_data = $this->phase_model->get_phase($phase_id);
		// delete phase
		$status = $this->timeframe_model->delete_data('phases',array('id' => $phase_id));
		if($status)
		{
			$condition = array(
							'phase >' => $phase_data->phase,
							'brand_id' => $phase_data->brand_id
						);
			$phases = $this->timeframe_model->get_data_by_condition('phases',$condition);
			//decrement phase number by one if there are phases after the phase which we are deleting
			if(!empty($phases))
			{
				foreach($phases as $phase)
				{						
					$condition = array(
									'id' => $phase->id
								);
					$data = array(
								'phase' => --$phase->phase
							);
					$this->timeframe_model->update_data('phases',$data,$condition);
				}
			}
			//delete users in approval phase
			$phases_approver = $this->timeframe_model->delete_data('phases_approver',array('phase_id' => $phase_id));
			echo json_encode(array('status' => 'success'));
		}
		else
		{
			echo json_encode(array('status' => 'fail'));
		}
	}

	
}