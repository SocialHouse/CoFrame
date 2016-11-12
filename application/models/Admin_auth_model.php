<?php if ( ! defined("BASEPATH")) exit("");

class Admin_auth_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function check_login($login_data)
	{
		$this->db->select('id,username');
		$this->db->where('username',$login_data['user_name']);
		$this->db->where('password',md5($login_data['password']));
		$query = $this->db->get('admin_users');
		if($query->num_rows())
		{
			return $query->row();
		}
		return FALSE;
	}
}