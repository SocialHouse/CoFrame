<?php if ( ! defined("BASEPATH")) exit("");

class Brand_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'brands';
	}

	//get brands which is created by user
	public function get_users_brand($user_id, $brand_id)
	{
		$this->db->select('id,name,created_by,created_at,is_hidden,timezone');
		$this->db->where('created_by', $user_id);		
		$this->db->where('id', $brand_id);
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_users_brands($user_id)
	{
		$this->db->select('id,name,created_by,created_at,is_hidden');
		$this->db->where('created_by', $user_id);		
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	//get user assosiate with brands
	public function get_brand_users($brand_id)
	{
		$this->db->select('brand_user_map.id,user_info.first_name,user_info.last_name,aauth_users.email,user_info.aauth_user_id');
		$this->db->where('brand_id', $brand_id);
		$this->db->join('aauth_users','aauth_users.id = brand_user_map.access_user_id');
		$this->db->join('user_info','user_info.aauth_user_id = brand_user_map.access_user_id');
		$query = $this->db->get('brand_user_map');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function check_brand_owner($brand_map_id,$user_id)
	{
		$this->db->select('brand_user_map.access_user_id,brand_id,name');
		$this->db->join('brands','brands.id = brand_user_map.brand_id');
		$this->db->where('brands.created_by',$user_id);
		$this->db->where('brand_user_map.id',$brand_map_id);
		$query = $this->db->get('brand_user_map');
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return FALSE;
	}

	public function get_tags()
	{
		$this->db->select('name');
		$this->db->group_by('name');
		$query = $this->db->get('brand_tags');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}
}