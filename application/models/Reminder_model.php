<?php if ( ! defined("BASEPATH")) exit("");

class Reminder_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_reminders($user_id,$brand_id)
	{		
		$this->db->join('posts','posts.id = phases.post_id');
		$this->db->join('phases_approver','phases_approver.phase_id = phases.id');
		$this->db->where('posts.brand_id',$brand_id);
		if($user_id)
			$this->db->where('phases_approver.user_id',$user_id);
		$this->db->order_by('approve_by','DESC');
		$query = $this->db->get('phases');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}

}