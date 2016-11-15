<?php if ( ! defined("BASEPATH")) exit("");

class Admin_account_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	// function get_account_holders()
	// {
	// 	$this->db->select('aauth_users.id,user_info.id as user_info_id,first_name,last_name,email,phone,company_name,plan,banned,count(brands.id) as brands_count');
	// 	$this->db->join('aauth_users','aauth_user_id = aauth_users.id');
	// 	$this->db->join('brands','brands.account_id = user_info.aauth_user_id','left');
	// 	$this->db->where('(plan IS NOT NULL)');
	// 	$this->db->group_by('brands.account_id');
	// 	$result =  $this->db->get('user_info');
	// 	if($result->num_rows() > 0)
	// 	{
	// 		return $result->result();
	// 	}
	// 	return FALSE;
	// }

	function get_accounts($post_data = ''){
    	if(isset($post_data['order'][0]['column'])){
			if(isset($post_data['order'][0]['column'])){
				$column_array = array( 
					0 => 'first_name',
					1 => 'last_name',
					2 => 'email',
					3 => 'phone',
					4 => 'company_name',
					5 => 'plan',
					);
				$this->db->order_by($column_array[$post_data['order'][0]['column']],$post_data['order'][0]['dir']);
			}

		}

		if(isset($post_data['length']) AND isset($post_data['start'])){
			$this->db->limit($post_data['length'],$post_data['start']);
		}

		$this->db->select('aauth_users.id,user_info.id as user_info_id,first_name,last_name,email,phone,company_name,plan,banned,plan');
		$this->db->join('aauth_users','aauth_user_id = aauth_users.id');
		$this->db->where('(plan IS NOT NULL)');
		if(!empty($post_data['search']['value'])) {
			$this->db->group_start();
			$this->db->like('first_name',$post_data['search']['value']);
			$this->db->or_like('last_name',$post_data['search']['value']);
			$this->db->or_like('phone',$post_data['search']['value']);
			$this->db->or_like('company_name',$post_data['search']['value']);
			$this->db->or_like('plan',$post_data['search']['value']);
			$this->db->group_end();
		}
		$this->db->group_by('aauth_users.id');
		$query =  $this->db->get('user_info');
		// echo $this->db->last_query();
		if($query->num_rows() > 0){
			// echo "test";
			return $query->result();
		}

		return FALSE;
	}

	function get_accounts_count($post_data = ''){
    	if(isset($post_data['order'][0]['column'])){
			if(isset($post_data['order'][0]['column'])){
				$column_array = array( 
					0 => 'first_name',
					1 => 'last_name',
					2 => 'email',
					3 => 'phone',
					4 => 'company_name',
					5 => 'plan'
					);
				$this->db->order_by($column_array[$post_data['order'][0]['column']],$post_data['order'][0]['dir']);
			}

		}

		$this->db->select('aauth_users.id');
		$this->db->join('aauth_users','aauth_user_id = aauth_users.id');
		$this->db->where('(plan IS NOT NULL)');
		if(!empty($post_data['search']['value'])) {
			$this->db->group_start();
			$this->db->like('first_name',$post_data['search']['value']);
			$this->db->or_like('last_name',$post_data['search']['value']);
			$this->db->or_like('phone',$post_data['search']['value']);
			$this->db->or_like('company_name',$post_data['search']['value']);
			$this->db->or_like('plan',$post_data['search']['value']);
			$this->db->group_end();
		}		
		$this->db->group_by('aauth_users.id');
		$query =  $this->db->get('user_info');
		// print_r($this->db->last_query());
		return $query->num_rows();
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
		$result = [];
		$this->db->select('aauth_user_id,first_name,last_name,email,phone,title,verification_code,banned');
		$this->db->join('aauth_groups','aauth_groups.id = aauth_user_to_group.group_id');
		$this->db->join('user_info','aauth_user_to_group.user_id = user_info.aauth_user_id');
		$this->db->join('aauth_users','aauth_users.id = aauth_user_to_group.user_id');

        $this->db->where('aauth_user_to_group.parent_id',$parent_id);
        $this->db->where('aauth_user_to_group.brand_id',NULL);
        $this->db->group_by('user_id');
        $query = $this->db->get('aauth_user_to_group');
        if($query->num_rows() > 0)
        {
        	$result = $query->result();
        }

        $brand_ids = $this->get_users_brands_id($parent_id);
        if(!empty($brand_ids))
        {
        	$brand_ids = array_column($brand_ids,'id');

	        $this->db->select('aauth_user_id,first_name,last_name,email,phone,title,verification_code,banned');
			$this->db->join('aauth_groups','aauth_groups.id = aauth_user_to_group.group_id');
			$this->db->join('user_info','aauth_user_to_group.user_id = user_info.aauth_user_id');
			$this->db->join('aauth_users','aauth_users.id = aauth_user_to_group.user_id');

			$this->db->where_in('brand_id',$brand_ids);

	        $this->db->group_by('user_id');
	        $query = $this->db->get('aauth_user_to_group');

	        if($query->num_rows() > 0)
	        {
	        	$result = array_merge($query->result(),$result);
	        }
	    }
        return $result;
	}

	function get_account_users_count($parent_id)
	{
		$result = [];
		$this->db->select('aauth_user_id');
		$this->db->join('aauth_groups','aauth_groups.id = aauth_user_to_group.group_id');
		$this->db->join('user_info','aauth_user_to_group.user_id = user_info.aauth_user_id');
		$this->db->join('aauth_users','aauth_users.id = aauth_user_to_group.user_id');

        $this->db->where('aauth_user_to_group.parent_id',$parent_id);
        $this->db->where('aauth_user_to_group.brand_id',NULL);
        $this->db->group_by('user_id');
        $query = $this->db->get('aauth_user_to_group');
        if($query->num_rows() > 0)
        {
        	$result = $query->result();
        }

        $brand_ids = $this->get_users_brands_id($parent_id);
        if(!empty($brand_ids))
        {
        	$brand_ids = array_column($brand_ids,'id');

	        $this->db->select('aauth_user_id');
			$this->db->join('aauth_groups','aauth_groups.id = aauth_user_to_group.group_id');
			$this->db->join('user_info','aauth_user_to_group.user_id = user_info.aauth_user_id');
			$this->db->join('aauth_users','aauth_users.id = aauth_user_to_group.user_id');

			$this->db->where_in('brand_id',$brand_ids);

	        $this->db->group_by('user_id');
	        $query = $this->db->get('aauth_user_to_group');

	        if($query->num_rows() > 0)
	        {
	        	$result = array_merge($query->result(),$result);
	        }
	    }
        return count($result);
	}

	function account_post_count($account_id)
	{
		$result = [];
		$brand_ids = $this->get_users_brands_id($account_id);		
        if(!empty($brand_ids))
        {
        	$brand_ids = array_column($brand_ids,'id');
	        $this->db->select('id');
			$this->db->where_in('brand_id',$brand_ids);
	        $query = $this->db->get('posts');
	        if($query->num_rows() > 0)
	        {
	        	$result = $query->result();
	        }
	    }
        return count($result);
	}

	function get_users_brands_id($user_id)
	{
		$this->db->select('brands.id');
		$this->db->where('brands.account_id', $user_id);		
		$query = $this->db->get('brands');
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return FALSE;
	}

	public function get_account_brands($user_id, $brand_id = 0)
	{
		$this->db->select('brands.id,name,created_by,brands.created_at,timezone,is_hidden,slug,account_id');	
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

    public function get_last_transaction($user_id)
    {
        $this->db->select('card_id,current_period_end,created_at');
        $this->db->order_by('id','DESC');
        $query = $this->db->get_where('transactions',array('user_id'=>$user_id));
        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        return FALSE;
    }

    function get_account_brand_count($account_id)
    {
    	$this->db->select('id');
    	$this->db->where('account_id',$account_id);
    	$query = $this->db->get('brands');
    	return $query->num_rows();
    }

    public function get_admin_user($user_id)
    {
    	$this->db->select('*');
    	$this->db->where('id',$user_id);
    	$query = $this->db->get('admin_users');
    	if($query->num_rows() > 0)
    	{
    		return $query->row();
    	}
    	return FALSE;
    }

    function save_password($data){
		if(!empty($data['password']) && !empty($data['password'])){
			$this->db->set('password',md5($data['password']));
			$this->db->where('id',$data['id']);
			return $this->db->update('admin_users');
		}
		return FALSE;
	}
}