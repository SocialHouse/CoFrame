<?php if ( ! defined("BASEPATH")) exit("");

class Admin_account_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_account_holders()
	{
		$this->db->select('aauth_users.id,user_info.id as user_info_id,first_name,last_name,email,phone,company_name,plan,banned');
		$this->db->join('aauth_users','aauth_user_id = aauth_users.id');
		$this->db->where('(plan IS NOT NULL)');
		$result =  $this->db->get('user_info');
		if($result->num_rows() > 0)
		{
			return $result->result();
		}
		return FALSE;
	}

	function all_account_count()
	{
		$this->db->select('user_info.id');
		$this->db->where('(plan IS NOT NULL)');
		$result =  $this->db->get('user_info');
		return $result->num_rows();
	}

	function get_account_users($parent_id)
	{
		$this->db->select('aauth_user_id,first_name,last_name,email,phone,title');
		$this->db->join('aauth_groups','aauth_groups.id = aauth_user_to_group.group_id');
		$this->db->join('user_info','aauth_user_to_group.user_id = user_info.aauth_user_id');
		$this->db->join('aauth_users','aauth_users.id = aauth_user_to_group.user_id');

        $this->db->where('aauth_user_to_group.parent_id',$parent_id);
        $this->db->where('aauth_user_to_group.brand_id',NULL);
        $this->db->group_by('user_id');
        $query = $this->db->get('aauth_user_to_group');
        if($query->num_rows() > 0)
        {
        	return $query->result();
        }
        return FALSE;
	}

	public function get_account_brands($user_id, $brand_id = 0)
	{
		$this->db->select('brands.id,name,created_by,brands.created_at,timezone,is_hidden,slug');	
		$this->db->where('brands.account_id', $user_id);
		if($brand_id > 0)
		{
			$this->db->where('brands.id',$brand_id);
		}
		$query = $this->db->get('brands');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_user($user_id)
	{
		$this->db->join('user_info','aauth_users.id = user_info.aauth_user_id');
		$this->db->where('aauth_users.id',$user_id);
        $query = $this->db->get('aauth_users');
        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        return FALSE;
    }

}