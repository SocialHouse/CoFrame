<?php if ( ! defined("BASEPATH")) exit("");

class Approval_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_approvals($user_id,$brand_id,$user_group,$date='')
	{
		$this->db->select('slate_date_time,posts.outlet_id,content,posts.status,posts.id as id');
		$this->db->join('posts','posts.id = phases.post_id');
		$this->db->join('phases_approver','phases_approver.phase_id = phases.id');
		$this->db->where('posts.brand_id',$brand_id);

		if(!empty($date))
		{
			$this->db->where('(DATE_FORMAT(posts.slate_date_time,"%m-%d-%Y")) = "'.date("m-d-Y",strtotime($date)).'"');
		}		
		
		if($user_group == 'Creator')
		{
			$this->db->where('posts.user_id',$user_id);			
		}
		$this->db->where('posts.status','pending');

		$this->db->order_by('slate_date_time','ASC');
		$query = $this->db->get('phases');		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_approvers_by_phase($phase_id)
	{
		$this->db->select('first_name');
		$this->db->join('user_info','user_info.aauth_user_id = phases_approver.user_id');
		$this->db->where('phases_approver.phase_id',$phase_id);
		$query = $this->db->get('phases_approver');
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return FALSE;
	}

	public function get_post_approvers($post_id)
	{
		$this->db->select('created_by');
		$this->db->join('brands','brands.id = posts.brand_id');
		$this->db->where('posts.id',$post_id);
		$query = $this->db->get('posts');
		if($query->num_rows() > 0)
		{
			$result = [];
			$result['owner_id'] = $query->row()->created_by;		

			$this->db->select('phases.id as id,phases.phase,post_id,note,approve_by,phases_approver.user_id,first_name,last_name,phases_approver.status,phases.status as phase_status');
			$this->db->join('phases','phases.id = phases_approver.phase_id');
			$this->db->join('user_info','user_info.aauth_user_id = phases_approver.user_id');
			$this->db->where('phases.post_id',$post_id);
			$query = $this->db->get('phases_approver');
		
			if($query->num_rows() > 0)
			{
				$result['result'] = $query->result_array();
			}
			return $result;
		}	
		return FALSE;
	}

	function get_approval_phase($post_id,$user_id)
	{
		$this->db->select('phases.id');
		$this->db->join('phases_approver','phases_approver.phase_id = phases.id');
		$this->db->where('phases_approver.user_id',$user_id);
		$this->db->where('phases.post_id',$post_id);
		$query = $this->db->get('phases');
		
		if($query->num_rows() > 0)
		{
			$phase_id = $query->row()->id;
			$this->db->select('phases.id,phases.phase,user_info.aauth_user_id,first_name,last_name,post_id,note,approve_by,phase,phases_approver.status,phases.status as phase_status');
			$this->db->join('user_info','user_info.aauth_user_id = phases_approver.user_id');
			$this->db->join('phases','phases_approver.phase_id = phases.id');		
			$this->db->where_in('phases_approver.phase_id',$phase_id);
			$query = $this->db->get('phases_approver');
			
			if($query->num_rows() > 0)
			{
				$result['phase_users'] = $query->result();
				
				$phase_comments = $this->get_phase_comments($phase_id);
				if($phase_comments)
				{
					$result['phase_comments'] = $phase_comments;
				}
				
				return $result;
			}
		}
		return FALSE;
	}

	function all_approval_phases($post_id)
	{
		$this->db->select('phases.id as id,phases.phase,post_id,note,approve_by,phase,phases_approver.status,phases.status as phase_status,phases_approver.user_id');		
		$this->db->join('phases','phases_approver.phase_id = phases.id');
		$this->db->where('post_id',$post_id);
		$this->db->group_by('phase');
		$query = $this->db->get('phases_approver');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	function get_comment_reply($comment_id)
	{
		$this->db->select('post_comments.id,comment,post_comments.created_at,first_name,last_name,post_comments.user_id,post_comments.status,media');
		$this->db->join('user_info','user_info.aauth_user_id = post_comments.user_id');
		$this->db->where('parent_id',$comment_id);
		$query = $this->db->get('post_comments');
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return FALSE;
	}

	function get_comment($comment_id)
	{
		$this->db->select('post_comments.id,comment,post_comments.created_at,first_name,last_name,post_comments.user_id,post_comments.status,media');
		$this->db->join('user_info','user_info.aauth_user_id = post_comments.user_id');
		$this->db->where('post_comments.id',$comment_id);
		$query = $this->db->get('post_comments');
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return FALSE;
	}

	function get_phase_users($phase_id)
	{
		$this->db->select('user_info.aauth_user_id,first_name,last_name,phases_approver.status');
		$this->db->join('user_info','user_info.aauth_user_id = phases_approver.user_id');		
		$this->db->where('phases_approver.phase_id',$phase_id);
		$query = $this->db->get('phases_approver');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	function get_phase_comments($phase_id)
	{
		$this->db->select('post_comments.id,comment,post_comments.created_at,first_name,last_name,post_comments.user_id,post_comments.status,media');
		$this->db->join('user_info','user_info.aauth_user_id = post_comments.user_id');
		$this->db->where('phase_id',$phase_id);
		$this->db->where('(parent_id IS NULL OR parent_id = "")');
		$this->db->order_by('id','DESC');
		$query = $this->db->get('post_comments');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}
}