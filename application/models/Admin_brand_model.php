<?php if ( ! defined("BASEPATH")) exit("");

class Admin_brand_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_brand_outlets($brand_id)
	{
		$this->db->join('outlets','outlets.id = brand_outlets.outlet_id');
		$this->db->order_by('outlets.id','ASC');
		$query = $this->db->get_where('brand_outlets',array('brand_id' => $brand_id));		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_brand_users($brand_id)
	{
		$this->db->select('brand_user_map.id,user_info.first_name,user_info.last_name,aauth_users.email,user_info.aauth_user_id,img_folder');
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

}