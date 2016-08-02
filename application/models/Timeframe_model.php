<?php if ( ! defined("BASEPATH")) exit("");

class Timeframe_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'users';
	}

	public function insert_data($table,$data)
	{
		$this->db->insert($table , $data);
		return $this->db->insert_id();
	}

	public function update_data($table,$data,$condition)
	{
		$this->db->where($condition);
		return $this->db->update($table,$data);
	}

	public function delete_data($table,$condition)
	{
		$this->db->where($condition);
		return $this->db->delete($table);
	}

	public function get_table_data($table,$select = '')
	{
		if(!empty($select))
		{
			$this->db->select($select);
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_table_data_array($table,$select = '')
	{
		if(!empty($select))
		{
			$this->db->select($select);
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return FALSE;
	}

	public function get_data_by_condition($table,$condition,$select = '')
	{
		if(!empty($select))
		{
			$this->db->select($select);
		}

		$this->db->where($condition);
		$query = $this->db->get($table);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_data_array_by_condition($table,$condition)
	{
		$this->db->where($condition);
		$query = $this->db->get($table);
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return FALSE;
	}

	public function get_accounts()
	{
		$this->db->select('account_id');
		$this->db->join('brand_user_map','brand_user_map.brand_id = brands.id','left');
		// $this->db->where('access_user_id',$this->user_id);
		$this->db->group_start();
		$this->db->where('account_id', $this->user_id);
		$this->db->or_where('access_user_id',$this->user_id);
		$this->db->group_end();

		$this->db->order_by('brands.id','ASC');
		$this->db->group_by('account_id');
		$query = $this->db->get('brands');
		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			$result = array_column($result,'account_id');
			return $result;
		}
		else
		{
			$this->db->select('aauth_users.id as aauth_user_id,parent_id');
			$this->db->join('aauth_users','aauth_users.id = aauth_user_to_group.user_id');
	        $this->db->join('user_info','user_info.aauth_user_id = aauth_users.id');

	        $this->db->join('aauth_groups','aauth_groups.id = aauth_user_to_group.group_id');
	        $this->db->where('aauth_user_to_group.user_id',$this->user_id);
	        $this->db->where('aauth_user_to_group.brand_id' , NULL);
	        $query = $this->db->get('aauth_user_to_group');

	        if($query->num_rows() > 0)
	        {

				$this->db->select('account_id');
				$this->db->join('brand_user_map','brand_user_map.brand_id = brands.id','left');
				$this->db->where('account_id', $query->row()->parent_id);
				$this->db->order_by('brands.id','ASC');
				$this->db->group_by('account_id');
				$query = $this->db->get('brands');				
				if($query->num_rows() > 0)
				{
					return $query->row()->account_id;
				}
	        }
		}

		$result[0] = $this->user_id;
		return $result;
	}	
}