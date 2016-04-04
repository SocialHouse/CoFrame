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
    	$this->db->order_by('id','desc');
    	$query = $this->db->get_where('transactions',array('user_id' => $user_id));
    	if($query->num_rows() > 0)
    	{
    		return $query->row()->plan;
    	}
    	return FALSE;
    }
}