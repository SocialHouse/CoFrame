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
		$brand_user_result = [];
		$account_user_result = [];
		$owner_user_result = [];

		//check user associates with any brand and get account_id from there
		$this->db->select('account_id');
		$this->db->join('brand_user_map','brand_user_map.brand_id = brands.id','left');
		$this->db->or_where('access_user_id',$this->user_id);

		$this->db->order_by('brands.id','ASC');
		$this->db->group_by('account_id');
		$query = $this->db->get('brands');
		if($query->num_rows() > 0)
		{
			$brand_user_result = $query->result_array();
			$brand_user_result = array_column($brand_user_result,'account_id');
		}

		//if current user is owner
		$this->db->select('aauth_user_id');
		$this->db->where('(plan IS NOT NULL)');
		$this->db->where('aauth_user_id',$this->user_id);
		$query = $this->db->get('user_info');
		if($query->num_rows() > 0)
		{
			$owner_user_result = $query->result_array();
			$owner_user_result = array_column($owner_user_result,'aauth_user_id');
		}


		$this->db->select('aauth_users.id as aauth_user_id,parent_id');
		$this->db->join('aauth_users','aauth_users.id = aauth_user_to_group.user_id');
        $this->db->join('user_info','user_info.aauth_user_id = aauth_users.id');

        $this->db->join('aauth_groups','aauth_groups.id = aauth_user_to_group.group_id');
        $this->db->where('aauth_user_to_group.user_id',$this->user_id);
        $this->db->where('aauth_user_to_group.brand_id' , NULL);
        $query = $this->db->get('aauth_user_to_group');
        if($query->num_rows() > 0)
		{
			$account_user_result = $query->result_array();			
			$account_user_result = array_column($account_user_result,'parent_id');				
		}

        if(!empty($brand_user_result) OR !empty($account_user_result) OR !empty($owner_user_result))
        {
        	$result = array_merge($brand_user_result,$account_user_result);
        	$result = array_merge($result,$owner_user_result);
        	return $result;
        }

		$result[0] = $this->user_id;
		return $result;
	}

	function check_user_is_account_user($parent_id)
	{
		$this->db->select('name');
		$this->db->join('aauth_groups','aauth_groups.id = aauth_user_to_group.group_id');
        $this->db->where('aauth_user_to_group.user_id',$this->user_id);
        $this->db->where('aauth_user_to_group.parent_id',$parent_id);
        $query = $this->db->get('aauth_user_to_group');
        if($query->num_rows() > 0)
        {
        	return $query->row()->name;
        }
        return FALSE;
	}	
}