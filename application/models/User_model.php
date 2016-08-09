<?php if ( ! defined("BASEPATH")) exit("");

class User_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'user_info';
	}	

	public function get_timezones()
	{
		$query = $this->db->get('timezone');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return false;
	}

	public function get_billing_details($user_id)
	{
		$this->db->select('*');
        $this->db->limit(1);
        $this->db->order_by('id','DESC');
		$query = $this->db->get_where('billing_details',array('user_id' => $user_id));
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return FALSE;
	}

	public function is_user_exist($email) 
	{
		$this->db->select('user_info.id as id,name');
        $this->db->where('email',$email);
        $this->db->join('user_info','user_info.aauth_user_id = aauth_users.id');
        $query = $this->db->get('aauth_users');
        if($query->num_rows() > 0){
            return $query->row();
        }
        return FALSE;
    }

    public function get_id_by_token($token)
    {
    	$this->db->select('id,aauth_user_id');
    	$query = $this->db->get_where($this->table, array('forgot_token' => $token));
    	if($query->num_rows() > 0)
    	{
    		return $query->row();
    	}
    	return FALSE;

    }

    public function save_password($password, $user_id) 
	{
		return $this->_set_password($password,$user_id);
	}

	public function check_login_attempt($user_id)
	{
		$this->db->select('id');
		$query = $this->db->get_where('login_attempts',array('user_id' => $user_id,'ip_address' => $_SERVER['REMOTE_ADDR']));
		if($query->num_rows() > 0)
		{
			return $query->row();
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

    public function get_verify_user($verify_token)
    {
    	$this->db->select('user_info.id,aauth_user_id,name');
    	$this->db->join('aauth_users','aauth_users.id = user_info.aauth_user_id');
		$this->db->where('login_verify_token',$verify_token);
    	$query = $this->db->get($this->table);
    	if($query->num_rows() > 0)
    	{
    		return $query->row();
    	}
    	return FALSE;
    }

    public function get_sub_users($owner_id)
    {
    	$this->db->select('id,first_name,last_name,username,email');
    	$this->db->where('parent_id',$owner_id);
    	$query = $this->db->get($this->data);
    	if($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    	return FALSE;
    }

    public function get_current_plan($user_id)
    {
    	$this->db->select('plan');
    	$query = $this->db->get_where('user_info',array('aauth_user_id' => $user_id));
    	if($query->num_rows() > 0)
    	{
    		return $query->row()->plan;
    	}
    	return FALSE;
    }

    public function get_users_by_parent_id($parent_id)
    {
        $this->db->select('aauth_users.id as aauth_user_id, aauth_users.email, user_info.first_name, user_info.last_name, user_info.title, user_info.img_folder, aauth_groups.name as role');
        $this->db->join('aauth_users','aauth_users.id = aauth_user_to_group.user_id');
        $this->db->join('user_info','user_info.aauth_user_id = aauth_users.id');

        $this->db->join('aauth_groups','aauth_groups.id = aauth_user_to_group.group_id');
        $this->db->where('aauth_user_to_group.parent_id',$parent_id);
        $this->db->where('aauth_user_to_group.brand_id' , NULL);

        $query = $this->db->get('aauth_user_to_group');

        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        return FALSE;
    }

    public function delete_user_permissions($user_id,$account_id)
    {   
        $this->db->select('brands.id as brand_id');
        $this->db->join('brands','brands.id = brand_user_map.brand_id');
        $this->db->where('brand_user_map.access_user_id', $user_id);
        $this->db->where('brands.account_id', $account_id);
        $query = $this->db->get('brand_user_map');
       
        if($query->num_rows() > 0)
        {
            //delete from user to permission table 
            $brand_ids = $query->result_array();
            $brand_ids = array_column($brand_ids, 'brand_id');
            $this->db->where_in('brand_id', $brand_ids);
            $this->db->where('user_id', $user_id);
            $this->db->delete('aauth_perm_to_user');

            // delete  from brand_user_map table 
            $this->db->where_in('brand_id', $brand_ids);
            $this->db->where('access_user_id', $user_id);
            $this->db->delete('brand_user_map');


            // delete  from aauth_user_to_group table 
            $this->db->where_in('brand_id', $brand_ids);
            $this->db->where('user_id', $user_id);
            $this->db->delete('aauth_user_to_group');
          
        }
        return TRUE;
    }
}