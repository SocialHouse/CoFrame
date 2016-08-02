<?php if ( ! defined("BASEPATH")) exit("");

class Brand_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'brands';
	}

	//get brands which is created by user
	public function get_users_brand($user_id, $brand_id = 0)
	{
		$this->db->select('id,name,created_by,created_at,is_hidden,timezone');
		$this->db->where('created_by', $user_id);
		if($brand_id > 0)
			$this->db->where('id', $brand_id);
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_users_brands($user_id, $brand_id = 0)
	{
		$this->db->select('brands.id,name,created_by,brands.created_at,timezone,is_hidden,slug');		
		$this->db->join('brand_user_map','brands.id = brand_user_map.brand_id','left');
		if($brand_id > 0)
			$this->db->where('brands.id', $brand_id);
		
		$this->db->group_start();
		$this->db->where('created_by', $user_id);
		$this->db->or_where('access_user_id',$user_id);
		$this->db->group_end();
		// $this->db->where('brand_user_map.account_id',$this->user_data['account_id']);
		$this->db->where('is_hidden',0);
		$this->db->where('account_id',$this->user_data['account_id']);
		$this->db->group_by('brands.id');
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_brand_by_slug($user_id, $slug = '')
	{
		$this->db->select('brands.id,name,created_by,brands.created_at,timezone,is_hidden,slug,account_id');
		$this->db->join('brand_user_map','brands.id = brand_user_map.brand_id','left');
		if($slug)
		{			
			$this->db->where('brands.slug', $slug);
		}
		$this->db->where('brands.account_id',$this->user_data['account_id']);
		$this->db->group_start();
		$this->db->where('created_by', $user_id);
		$this->db->or_where('access_user_id',$user_id);
		$this->db->group_end();		
		$this->db->where('is_hidden',0);
		$this->db->group_by('brands.id');
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_brand_by_id($brand_id)
	{
		$this->db->select('brands.id,name,created_by,brands.created_at,timezone,is_hidden,slug');
		$this->db->group_by('brands.id');
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return FALSE;
	}

	//get user assosiate with brands
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

	//get user assosiate with brands except me
	public function get_users_without_me($brand_id)
	{
		$this->db->select('brand_user_map.id,user_info.first_name,user_info.last_name,aauth_users.email,user_info.aauth_user_id');
		$this->db->where('brand_id', $brand_id);
		$this->db->where('user_info.aauth_user_id != ', $this->user_id);
		$this->db->join('aauth_users','aauth_users.id = brand_user_map.access_user_id');
		$this->db->join('user_info','user_info.aauth_user_id = brand_user_map.access_user_id');
		$query = $this->db->get('brand_user_map');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	//get user assosiate who have approve permission
	public function get_approvers($brand_id)
	{
		$this->db->where('name', 'approve.approve_post');
		$query = $this->db->get('aauth_perms');
		if($query->num_rows() > 0)
		{
			$this->db->select('user_info.aauth_user_id,first_name,last_name,perm_id,aauth_perm_to_user.user_id,img_folder');
			$this->db->join('user_info','user_info.aauth_user_id = access_user_id');
			$this->db->join('aauth_perm_to_user','aauth_perm_to_user.user_id = access_user_id');
			$this->db->where('perm_id',$query->row()->id);
			$this->db->where('aauth_perm_to_user.user_id != ',$this->user_id);
			$this->db->where('aauth_perm_to_user.brand_id',$brand_id);
			$this->db->group_by('user_info.aauth_user_id');
			$query = $this->db->get('brand_user_map');			
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
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

	public function get_tags($brand_id = '')
	{
		$this->db->select('name');
		$this->db->group_by('name');
		if($brand_id)
		{
			$this->db->where('brand_id',$brand_id);
		}
		$query = $this->db->get('brand_tags');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_my_brand($user_id)
	{
		$this->db->where('access_user_id',$user_id);
		$query = $this->db->get('brand_user_map');
		if($query->num_rows() > 0)
		{
			return $query->row()->brand_id;
		}
		return FALSE;
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

	public function get_all_sub_users($user_id,$brand_id)
	{
		$this->db->select('brand_id,access_user_id,aauth_user_id,first_name,last_name');
		$this->db->join('user_info','user_info.aauth_user_id = brand_user_map.access_user_id');
		$this->db->join('brands','brands.id = brand_user_map.brand_id');
		$this->db->where('created_by',$user_id);
		$this->db->where('brand_id !=',$brand_id);
		$this->db->group_by('aauth_user_id');
		$query = $this->db->get('brand_user_map');
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}

		return FALSE;
	}

	public function get_brand_timezone_string($brand_id)
	{ 
		$this->db->select('timezone.timezone');
		$this->db->join('brands','timezone.value = brands.timezone'); 
		$query = $this->db->where('brands.id',$brand_id);
		$query = $this->db->get('timezone');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	function get_users_sub_users($user_id,$brand_id = '',$user_ids = array())
	{
		$this->db->select('aauth_user_id,first_name,last_name');
		$this->db->join('brands','brands.id = brand_user_map.brand_id');
		$this->db->join('user_info','brand_user_map.access_user_id = user_info.aauth_user_id');
		$this->db->where('created_by',$user_id);
		if($brand_id)
			$this->db->where('brands.id !=',$brand_id);
		if(!empty($user_ids))
			$this->db->where_not_in('aauth_user_id',$user_ids);
		$this->db->group_by('aauth_user_id');
		$query = $this->db->get('brand_user_map');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_all_brand_by_slug($user_id, $slug = '')
	{
		$this->db->select('brands.id,name,created_by,brands.created_at,timezone,is_hidden,slug');
		$this->db->join('brand_user_map','brands.id = brand_user_map.brand_id','left');
		if($slug)
			$this->db->where('brands.slug', $slug);

		$this->db->group_start();
		$this->db->where('created_by', $user_id);
		$this->db->or_where('access_user_id',$user_id);
		$this->db->group_end();
		$this->db->group_by('brands.id');
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	function get_all_users()
	{
		$this->db->select('brands.id,brand_user_map.access_user_id');
		$this->db->join('brand_user_map','brands.id = brand_user_map.brand_id');
		$this->db->where('is_hidden',0);
		$this->db->where('account_id',$this->user_data['account_id']);
		$this->db->group_by('brand_user_map.access_user_id');
		$query = $this->db->get($this->table);		
		// plus one for master user who added the brand because above query only
		// users who are present in brand can be calculated
		//whe nwe complete with functionality like add multiple master users we need to change this
		$all_users = $query->num_rows() + 1;

		$this->db->select('aauth_users.id as aauth_user_id');
		$this->db->join('aauth_users','aauth_users.id = aauth_user_to_group.user_id');
        $this->db->join('user_info','user_info.aauth_user_id = aauth_users.id');

        $this->db->join('aauth_groups','aauth_groups.id = aauth_user_to_group.group_id');
        $this->db->where('aauth_user_to_group.parent_id',$this->user_data['account_id']);
        $this->db->where('aauth_user_to_group.brand_id' , NULL);
        $query = $this->db->get('aauth_user_to_group');

        if($query->num_rows() > 0)
        {
           $all_users = $query->num_rows() + $all_users;
        }
        return $all_users;
	}

	function get_all_master_users()
	{
		$this->db->select('aauth_users.id as aauth_user_id');
		$this->db->join('aauth_users','aauth_users.id = aauth_user_to_group.user_id');
        $this->db->join('user_info','user_info.aauth_user_id = aauth_users.id');

        $this->db->join('aauth_groups','aauth_groups.id = aauth_user_to_group.group_id');
        $this->db->where('aauth_user_to_group.parent_id',$this->user_data['account_id']);
        $this->db->where('aauth_user_to_group.brand_id' , NULL);
        $query = $this->db->get('aauth_user_to_group');

        if($query->num_rows() > 0)
        {
           $master_users = $query->num_rows() + 1;
           return $master_users;
        }
        return 1;
	}

	function get_brand_wise_tags()
	{
		$this->db->select('brands.name,count(brand_tags.name) as count');
		$this->db->join('brand_tags','brands.id = brand_tags.brand_id');
		$this->db->where('account_id',$this->user_data['account_id']);
		$this->db->group_by('brands.id');
		$query = $this->db->get('brands');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	function get_brand_wise_outlets()
	{
		$this->db->select('brands.name,count(brand_outlets.id) as count');
		$this->db->join('brand_outlets','brands.id = brand_outlets.brand_id');
		$this->db->where('account_id',$this->user_data['account_id']);
		$this->db->group_by('brands.id');
		$query = $this->db->get('brands');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	function check_user_exist_in_account($email,$brand_id)
	{
		//check user is already present in current brand
		$this->db->select('brand_user_map.id');
		$this->db->join('aauth_users','aauth_users.id = brand_user_map.access_user_id');
		$this->db->join('brands','brands.id = brand_user_map.brand_id');
		$this->db->where('aauth_users.email',$email);
		$this->db->where('brands.id',$brand_id);
		$query = $this->db->get('brand_user_map');
		if($query->num_rows() > 0)
		{
			return array('response'=> 'current_brand');
		}

		//check user is already present in current account
		$this->db->select('brand_user_map.id');
		$this->db->join('aauth_users','aauth_users.id = brand_user_map.access_user_id');
		$this->db->join('brands','brands.id = brand_user_map.brand_id');
		$this->db->where('aauth_users.email',$email);
		$this->db->where('account_id',$this->user_data['account_id']);
		$query = $this->db->get('brand_user_map');
		if($query->num_rows() > 0)
		{
			return array('response'=> 'current_account');
		}

		//check user is admin of current account
		$this->db->select('brands.id');
		$this->db->join('aauth_users','aauth_users.id = brands.created_by');
		$this->db->where('aauth_users.email',$email);
		$this->db->where('account_id',$this->user_data['account_id']);
		$query = $this->db->get('brands');
		if($query->num_rows() > 0)
		{
			return array('response'=> 'current_admin');
		}

		//check user is already present in other account
		$this->db->select('brand_user_map.id');
		$this->db->join('aauth_users','aauth_users.id = brand_user_map.access_user_id');
		$this->db->join('brands','brands.id = brand_user_map.brand_id');
		$this->db->where('aauth_users.email',$email);
		$query = $this->db->get('brand_user_map');
		if($query->num_rows() > 0)
		{
			return array('response'=> 'other_account');
		}
		return array('response' => 'false');
	}
}