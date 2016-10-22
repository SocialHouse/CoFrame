<?php if ( ! defined("BASEPATH")) exit("");

class Social_media_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'social_media_keys';
	}

	public function get_token($type, $brand_id, $user_id ='')
	{
		if(empty($type) && empty($brand_id)) return FALSE;
		
		$this->db->select('access_token, access_token_secret, social_media_id, user_id, brand_id, outlet_id, response, type, refresh_token,fb_page_id');
		if(!empty($user_id))
		{
			$this->db->where('user_id',$user_id);
		}
		$this->db->where('brand_id',$brand_id);		
		$this->db->where('type',$type);
		$query = $this->db->get($this->table);
		// echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return FALSE;
	}


	function save_token($data) {
		if(empty($data['type']) && empty($data['brand_id'])) return FALSE;

		if(empty($data['user_id']))
		{
			$user_id = $this->user_id;
		}
		else
		{
			$user_id = $data['user_id'];
		}

		$this->db->where('brand_id',$data['brand_id']);
		$this->db->where('type',$data['type']);
		$query = $this->db->get($this->table);
		if($query->num_rows() > 0)
		{
			// Update record
			$this->db->where('type',$data['type']);
			$this->db->where('brand_id', $data['brand_id']);
			$this->db->update($this->table, $data);
			return TRUE;
		}
		else
		{
			// Insert record
			$data['created_at'] = date('Y-m-d h:i:s');
			$this->db->insert($this->table, $data);
			$last_id = $this->db->insert_id();
			return TRUE;
		}
		return FALSE;
	}

	public function delete_token($type, $brand_id = '', $outlet_id = '', $user_id = '')
	{
		if(empty($type)) return FALSE;

		if(!empty($brand_id)){
			$this->db->where('brand_id',$brand_id);
		}
		
		if(!empty($outlet_id)){
			$this->db->where('outlet_id',$outlet_id);
		}

		if(empty($user_id)){
			$user_id = $this->user_id;
		}
		
		$this->db->where('user_id',$user_id);
		$this->db->where('type',$type);
		
		$this->db->delete($this->table);
		echo $this->db->last_query();
		return TRUE;
	}


}