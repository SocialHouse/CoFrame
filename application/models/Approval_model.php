<?php if ( ! defined("BASEPATH")) exit("");

class Approval_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_approvals($user_id,$brand_id)
	{		
		$this->db->join('posts','posts.id = phases.post_id');
		$this->db->join('phases_approver','phases_approver.phase_id = phases.id');
		$this->db->where('posts.brand_id',$brand_id);
		if($user_id)
			$this->db->where('phases_approver.user_id',$user_id);
		$this->db->order_by('slate_date_time','ASC');
		$query = $this->db->get('phases');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_approvers_by_phase($phase_id)
	{
		$this->db->select('first_name');
		$this->db->join('user_info','user_info.aauth_user_id = phases_approver.user_id');
		$this->db->where('phases_approver.phase_id',$phase_id);
		$query = $this->db->get('phases_approver');
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return FALSE;
	}

}