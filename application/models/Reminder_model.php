<?php if ( ! defined("BASEPATH")) exit("");

class Reminder_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_reminders($user_id = 0,$brand_id,$limit = 0)
	{		
		$this->db->join('posts','posts.id = phases.post_id');
		$this->db->join('phases_approver','phases_approver.phase_id = phases.id');
		$this->db->where('posts.brand_id',$brand_id);
		if($user_id > 0)
			$this->db->where('phases_approver.user_id',$user_id);
		$this->db->order_by('approve_by','DESC');
		if($limit > 0)
		{
			$this->db->limit($limit);
		}

		$query = $this->db->get('phases');		
		// die;
		if($query->num_rows() > 0)
		{
			return $query->result();
		}

		return FALSE;
	}

	function get_brand_reminders($user_id = 0, $brand_id, $limit = 0, $type='all')
	{
	
		if($user_id > 0)
			$this->db->where('user_id',$user_id);
		if($limit > 0)
			$this->db->limit($limit);
		if($type !== 'all')
			$this->db->where('type',$type);

		$this->db->where('brand_id',$brand_id);



		$query = $this->db->get('reminders');
		

		if($query->num_rows() > 0)
		{
			return $query->result();
		}

		return FALSE;
	}

}