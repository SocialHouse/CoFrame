<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phases extends CI_Controller {

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
		$this->load->model('phase_model');
		$this->load->model('brand_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	public function index()
	{
		$this->data = array();
		$brand_id = $this->uri->segment(3);
		if($brand_id)
		{
			$phases = $this->phase_model->get_approver_phases($brand_id);

			$this->data['phases'] = array();
			if(!empty($phases))
			{
				foreach($phases as $phase)
				{
					$this->data['phases'][$phase->phase][] = $phase;
				}
			}

			$this->data['view'] = 'phases/phases';
	        _render_view($this->data);
	    }
	}

	public function add()
	{
		$this->data = array();
		//check previous approver version increment by one and add next version
		$brand_id = $this->uri->segment(3);
		if($brand_id)
		{
			$phases = $this->phase_model->get_approver_phases($brand_id);
			$this->data['next_phase'] = 1;
			if(!empty($phases))
			{
				$this->data['next_phase'] = $phases[count($phases) - 1]->phase + 1;
			}
			
			$this->data['brand_id'] = $brand_id;
			$this->data['users'] = $this->brand_model->get_brand_users($brand_id);
			
			$this->data['view'] = 'phases/add_phase';
	        _render_view($this->data);
		}	
	}

	public function save()
	{
		$this->data = array();
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$this->form_validation->set_rules('users[]','users','required',
		                                            array('required' => 'At least select one user for approval')
		                                        );
			if($this->form_validation->run() === true)
			{
				if(isset($post_data['brand_id']) AND!empty($post_data['brand_id']))
				{
					$phase_data = array(
									'phase' => $post_data['phase'],
									'brand_id' => $post_data['brand_id']
								);
					$inserted_id = $this->timeframe_model->insert_data('phases',$phase_data);
					if($inserted_id)
					{
						foreach($post_data['users'] as $user)
						{
							$phases_approver = array(
												'phase_id' => $inserted_id,
												'user_id' => $user
		 									);

							$this->timeframe_model->insert_data('phases_approver',$phases_approver);
						}
						redirect(base_url().'phases/index/'.$post_data['brand_id']);
					}
				}
			}

			$phases = $this->phase_model->get_approver_phases($post_data['brand_id']);
			$this->data['next_phase'] = 1;
			if(!empty($phases))
			{
				$this->data['next_phase'] = $phases[count($phases) - 1]->phase + 1;
			}

			$this->data['next_phase'] = $post_data['phase'];
			$this->data['brand_id'] = $post_data['brand_id'];
			$this->data['users'] = $this->brand_model->get_brand_users($post_data['brand_id']);
			
			$this->data['view'] = 'phases/add_phase';
	        _render_view($this->data);
	    }
	}

	public function edit()
	{
		$this->data = array();
		$phase_id = $this->uri->segment(3);
		$this->data['phase_data'] = $this->phase_model->get_phase($phase_id);
		if(!empty($this->data['phase_data']))
		{			
			$this->data['users'] = $this->brand_model->get_brand_users($this->data['phase_data']->brand_id);

			//get users present in phase
			$condition = array('phase_id' => $phase_id);
			$selected_users = $this->timeframe_model->get_data_array_by_condition('phases_approver',$condition);
		
			$this->data['selected_users'] = array();
			if(!empty($selected_users))
			{
				$this->data['selected_users'] = array_column($selected_users,'user_id');
			}

			$this->data['view'] = 'phases/edit_phase';
	        _render_view($this->data);		
		}
	}

	public function update()
	{
		$this->data = array();
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$this->form_validation->set_rules('users[]','users','required',
		                                            array('required' => 'At least select one user for approvel')
		                                        );
			if($this->form_validation->run() === true)
			{
				$approvers_to_add = $post_data['users'];
				
				if(!empty($approvers_to_add))
				{
					//get previous users present in phase
					$condition = array('phase_id' =>  $post_data['phase']);
					$previous_users = $this->timeframe_model->get_data_array_by_condition('phases_approver',$condition);
				
					if(!empty($previous_users))
					{
						$user_ids = array_column($previous_users,'user_id');
			        	$approvers_to_add = array_diff($post_data['users'],$user_ids);
			        	$approvers_to_delete = array_diff($user_ids,$post_data['users']);
			        	foreach ($approvers_to_delete as $user)
			        	{
			        		$data = array('phase_id' => $post_data['phase'],'user_id' => $user);
			        		$this->timeframe_model->delete_data('phases_approver',$data);
			        	}
					}				

					foreach ($approvers_to_add as $user)
		        	{
		        		$data = array('phase_id' => $post_data['phase'],'user_id' => $user);
		        		$this->timeframe_model->insert_data('phases_approver',$data);
		        	}
		        	$this->session->set_flashdata('message','Phase has been updated successfully');
		        	redirect(base_url().'phases/index/'.$post_data['brand_id']);
				}
			}

			$this->data['users'] = $this->brand_model->get_brand_users($post_data['brand_id']);
			$this->data['phase_number'] = $post_data['phase_number'];
 			$this->data['selected_users'] = array();
			if(!empty($selected_users))
			{
				$this->data['selected_users'] = array_column($selected_users,'user_id');
			}

			$this->data['view'] = 'phases/edit_phase';
	        _render_view($this->data);
		}
	}

	public function delete()
	{
		$phase_id = $this->uri->segment(3);
		if($phase_id)
		{
			$phase_data = $this->phase_model->get_phase($phase_id);
			if(!empty($phase_data))
			{
				//delete phase
				$condition = array('id' => $phase_data->id);
				$this->timeframe_model->delete_data('phases',$condition);

				//delete users in phase
				$condition = array('phase_id' => $phase_data->id);
				$this->timeframe_model->delete_data('phases_approver',$condition);

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

				$this->session->set_flashdata('message','Phase has been deleted successfully');
				redirect(base_url().'phases/index/'.$phase_data->brand_id);
			}
		}
	}

	public function add_phases_number()
	{
		$this->load->view('phases/add_phases_number');
	}

}