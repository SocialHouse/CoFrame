<?php if ( ! defined("BASEPATH")) exit("");

class Post_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = '';
	}

	public function get_brand_outlets($brand_id)
	{
		$this->db->select('outlets.id,outlet_name');
		$this->db->join('outlets','outlets.id = brand_outlets.outlet_id');
		$this->db->where('brand_outlets.brand_id',$brand_id);
		$query = $this->db->get('brand_outlets');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_brand_tags($brand_id)
	{
		$this->db->select('id,name');		
		$this->db->where('brand_tags.brand_id',$brand_id);
		$this->db->where('brand_tags.status',1);
		$this->db->group_by('name');
		$query = $this->db->get('brand_tags');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_post_tags($post_id)
	{
		$this->db->select('brand_tags.id,name');		
		$this->db->join('post_tags','brand_tags.id = post_tags.brand_tag_id');
		$this->db->where('brand_tags.status',1);
		$this->db->where('post_tags.post_id',$post_id);		
		$query = $this->db->get('brand_tags');
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return FALSE;
	}

	public function get_posts($brand_id)
	{
		$query = $this->db->get_where('posts',array('brand_id' => $brand_id));
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_brand_users($brand_id)
	{
		$this->db->select('user_info.aauth_user_id,first_name,last_name');
		$this->db->join('user_info','user_info.aauth_user_id = access_user_id');
		$this->db->where('brand_id',$brand_id);
		$query = $this->db->get('brand_user_map');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_draft_posts($brand_id)
	{
		$this->db->select('posts.id as id,content,brand_id,outlet_id,slate_date_time,created_at,outlet_name');
		$this->db->join('outlets','outlets.id = posts.outlet_id');
		$query = $this->db->get_where('posts',array('brand_id' => $brand_id));
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_post($post_id)
	{
		$this->db->where('id',$post_id);
		$query = $this->db->get('posts');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return FALSE;
	}

	public function get_post_approvers($post_id)
	{
		$this->db->select('aauth_user_id');
		$this->db->join('post_approvers','post_approvers.user_id = user_info.aauth_user_id');
		$this->db->where('post_id',$post_id);
		$query = $this->db->get('user_info');
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return FALSE;
	}

	public function duplicate_post($post_id)
	{
		$status = $this->db->query('INSERT INTO posts (content,brand_id,outlet_id,slate_date_time) SELECT content,brand_id,outlet_id,slate_date_time FROM posts WHERE id='.$post_id);
		$last_id = $this->db->insert_id();
		if($status)
		{
			$this->db->select('brand_tag_id');
			$query = $this->db->get_where('post_tags',array('post_id' => $post_id));
			if($query->num_rows())
			{
				foreach($query->result_array() as $row)
				{
					$row['post_id'] = $last_id;
					$this->db->insert('post_tags',$row);
				}
			}

			$this->db->select('name,type,mime');
			$query = $this->db->get_where('post_media',array('post_id' => $post_id));
			if($query->num_rows())
			{
				foreach($query->result_array() as $row)
				{
					$row['post_id'] = $last_id;
					$this->db->insert('post_media',$row);
				}
			}

			$this->db->select('user_id');
			$query = $this->db->get_where('post_approvers',array('post_id' => $post_id));
			if($query->num_rows())
			{
				foreach($query->result_array() as $row)
				{
					$row['post_id'] = $last_id;
					$this->db->insert('post_approvers',$row);
				}
			}
			
			return TRUE;
		}
		return FALSE;
	}

	public function get_default_phases($brand_id)
	{
		$this->db->select('first_name,last_name,phases_approver.user_id,phase,brand_id');
		$this->db->join('user_info','user_info.aauth_user_id = phases_approver.user_id');
		$this->db->join('phases','phases.id = phases_approver.phase_id');
		$this->db->where('brand_id',$brand_id);
		$this->db->where('post_id',0);
		$query = $this->db->get('phases_approver');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_post_phases($post_id)
	{
		$this->db->select('first_name,last_name,phases_approver.user_id,phase,brand_id,post_id,approve_by,note');
		$this->db->join('user_info','user_info.aauth_user_id = phases_approver.user_id');
		$this->db->join('phases','phases.id = phases_approver.phase_id');
		// $this->db->where('brand_id',$brand_id);
		$this->db->where('post_id',$post_id);
		$query = $this->db->get('phases_approver');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

}