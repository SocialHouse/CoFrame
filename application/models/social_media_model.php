<?php if ( ! defined("BASEPATH")) exit("");

class Social_media_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'social_media_keys';
	}

	public function get_user_tokens($type = '', $user_id ='')
	{
		$this->db->select('access_token, access_token_secret, social_media_id, user_id, brand_id, outlet_id, response, 	type');	
		if(!empty($user_id)){
			$this->db->where('user_id',$user_id);
		}else{
			$this->db->where('user_id',$this->user_id);  
		}
		if(!empty($type)){
			$this->db->where('type',$type);
		}
		$query = $this->db->get($this->table);
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}

		return FALSE;

	}

}