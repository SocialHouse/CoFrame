<?php if ( ! defined("BASEPATH")) exit("");

class Phase_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();		
	}

	public function get_approver_phases($brand_id)
	{
		$this->db->select('phases_approver.id as phases_approver_id,phase_id,user_id,first_name,last_name,phases.id as phase_id,phase,brand_id,post_id');
		$this->db->join('user_info','phases_approver.user_id = user_info.aauth_user_id');
		$this->db->join('phases','phases_approver.phase_id = phases.id');
		$this->db->where('brand_id',$brand_id);
		$this->db->where('post_id',0);
		$this->db->order_by('phase','ASC');
		$query = $this->db->get('phases_approver');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_phase($phase_id)
	{
		$this->db->where('phases.id',$phase_id);
		$query = $this->db->get('phases');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return FALSE;
	}

}