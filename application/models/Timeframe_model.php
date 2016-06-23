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
	
}