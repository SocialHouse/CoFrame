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
		$this->db->select('id, due_date, created_at, text, post_id, brand_id, status');	
		if($user_id > 0)
			$this->db->where('user_id',$user_id);
		if($limit > 0)
			$this->db->limit($limit);
		if($type !== 'all')
			$this->db->where('type',$type);

		$this->db->where('brand_id',$brand_id);
		$this->db->where('status',0);
		$this->db->order_by('due_date','ASC');
		$query = $this->db->get('reminders');
		

		if($query->num_rows() > 0)
		{
			return $query->result();
		}

		return FALSE;
	}

	function get_reminder_count($user_id = 0, $brand_id)
	{
		$this->db->select('id');
		if($user_id > 0)
			$this->db->where('user_id',$user_id);	

		$this->db->where('brand_id',$brand_id);
		$this->db->where('status',0);
		$this->db->order_by('due_date','ASC');
		$query = $this->db->get('reminders');
		if($query->num_rows() > 0)
		{
			return $query->num_rows();
		}
		return FALSE;
	}

	public function get_active_notifications()
	{
		$this->db->select('id,text');
		$this->db->where('status',0);
		$this->db->where('desktop_notification_status',0);
		$this->db->where('user_id',$this->user_id);
		$this->db->where('type','reminder');
		$this->db->group_start();
		$this->db->where('due_date',NULL);
		$this->db->or_where('due_date >=', date('Y-m-d H:i:s'));
		$this->db->group_end();
		$this->db->limit(1);
		$this->db->order_by('due_date','ASC');
		$query = $this->db->get('reminders');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$this->db->where('id',$row->id);			
			$this->db->update('reminders',array('desktop_notification_status' => 1)); 
			return $row;
		}
		return FALSE;
	}

	function get_brand_outlet_name($brand_id)
	{
		$this->db->select('outlets.outlet_name');
		$this->db->join('brand_outlets','outlets.id = brand_outlets.outlet_id');
		$this->db->where('brand_id',$brand_id);
		$query = $this->db->get('outlets');
		if($query->num_rows() > 0)
		{
			return $query->row()->outlet_name;
		}
		return FALSE;
	}
}