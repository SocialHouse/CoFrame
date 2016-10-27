<?php if ( ! defined("BASEPATH")) exit("");

class Approval_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_approvals($user_id,$brand_id,$user_group='',$date='')
	{
		$result = [];
		if(check_user_perm($user_id,'create',$brand_id) OR $user_id == $this->user_data['account_id']  OR (isset($this->user_data['user_group']) AND $this->user_data['user_group'] == "Master Admin"))
		{
			$this->db->select('slate_date_time,posts.outlet_id,content,posts.status,posts.id as id,posts.user_id as user_id,phases.id as phase_id,tumblr_content_type,tumblr_caption,tumblr_title,tumblr_quote,tumblr_custom_url,tumblr_chat_title,tumblr_video_caption');
			$this->db->join('posts','posts.id = phases.post_id');
			$this->db->join('phases_approver','phases_approver.phase_id = phases.id');
			$this->db->where('posts.brand_id',$brand_id);
			$this->db->where('posts.status !=','posted');
			$this->db->where('posts.status !=','deleted');
			$this->db->where('posts.status !=','draft');

			if(!empty($date))
			{
				$this->db->where('(DATE_FORMAT(posts.slate_date_time,"%m-%d-%Y")) = "'.date("m-d-Y",strtotime($date)).'"');
			}

			//if user creator he can see only posts which is created by him
			if(check_user_perm($user_id,'create',$brand_id))
			{
				$this->db->where('posts.user_id',$user_id);
			}			
			$this->db->group_by('posts.id');
			$this->db->order_by('slate_date_time','ASC');			
			$query = $this->db->get('phases');		
			if($query->num_rows() > 0)
			{
				$result =  $query->result();
			}			
		}
		if(check_user_perm($user_id,'approve',$brand_id) OR $user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND $this->user_data['user_group'] == "Master Admin"))
		{
			$this->db->select('slate_date_time,posts.outlet_id,content,posts.status,posts.id as id,posts.user_id as user_id,phases.id as phase_id,tumblr_content_type,tumblr_caption,tumblr_title,tumblr_quote,tumblr_custom_url,tumblr_chat_title,tumblr_video_caption');
			$this->db->join('posts','posts.id = phases.post_id');
			$this->db->join('phases_approver','phases_approver.phase_id = phases.id');
			$this->db->where('posts.brand_id',$brand_id);

			if(!empty($date))
			{
				$this->db->where('(DATE_FORMAT(posts.slate_date_time,"%m-%d-%Y")) = "'.date("m-d-Y",strtotime($date)).'"');
			}
			$this->db->where('posts.status !=','approved');
			$this->db->where('posts.status !=','deleted');
			$this->db->where('posts.status !=','draft');
			$this->db->where('phases_approver.user_id',$user_id);
			$this->db->order_by('slate_date_time','ASC');
			$query = $this->db->get('phases');		
			if($query->num_rows() > 0)
			{
				if(!empty($result))
				{
					$result = array_merge($result,$query->result());
				}
				else
					$result =  $query->result();

				if(!empty($result))
				{
					usort($result, function($a,$b){
						$t1 = strtotime($a->slate_date_time);
					    $t2 = strtotime($b->slate_date_time);
					    return $t1 - $t2;
					});
				}
			}
		}

		return $result;
	}

	function approvals_between_date($user_id,$brand_id,$start_date='',$end_date='',$outlet ='',$search = '')
	{
		$result = [];
		$post_data = $this->input->post();

		if(check_user_perm($user_id,'create',$brand_id) OR $user_id == $this->user_data['account_id']  OR (isset($this->user_data['user_group']) AND $this->user_data['user_group'] == "Master Admin"))
		{
			$this->db->select('slate_date_time,posts.outlet_id,content,posts.status,posts.id as id,posts.user_id as user_id,phases.id as phase_id,tumblr_content_type,tumblr_caption,tumblr_title,tumblr_quote,tumblr_custom_url,tumblr_chat_title,tumblr_video_caption');
			$this->db->join('posts','posts.id = phases.post_id');
			$this->db->join('phases_approver','phases_approver.phase_id = phases.id');
			$this->db->where('posts.brand_id',$brand_id);
			$this->db->where('posts.status !=','posted');
			$this->db->where('posts.status !=','deleted');
			$this->db->where('posts.status !=','draft');
			
			if(isset($post_data) AND !empty($post_data) AND (isset($post_data['statuses']) OR isset($post_data['tags']) OR isset($post_data['outlets'])))
			{
				$statuses = $post_data['statuses'];
				if(!empty($statuses))
				{
					$statuses = explode(',', $post_data['statuses']);
					$this->db->where_in('posts.status',$statuses);
				}
				$tags = $post_data['tags'];
				if(!empty($tags))
				{
					$this->db->join('post_tags','post_tags.post_id = posts.id','left');
					$tags = explode(',', $tags);
					foreach($tags as $tag)
					{						
						$this->db->where('post_tags.id',$tag);
					}
				}
				$outlets = $post_data['outlets'];
				if(!empty($outlets))
				{
					$outlets = explode(',', $post_data['outlets']);
					$this->db->where_in('posts.outlet_id',$outlets);
				}
			}

			if(!empty($search))
			{
				$this->db->like('content',$search);
			}

			if(!empty($start_date))
			{
				$this->db->where('(DATE_FORMAT(posts.slate_date_time,"%m-%d-%Y")) >= "'.date("m-d-Y",strtotime($start_date)).'"');
			}

			if(!empty($end_date))
			{
				$this->db->where('(DATE_FORMAT(posts.slate_date_time,"%m-%d-%Y")) <= "'.date("m-d-Y",strtotime($end_date)).'"');
			}

			if(!empty($outlet))
			{
				$this->db->where('posts.outlet_id',$outlet);
			}

			//if user creator he can see only posts which is created by him
			if(check_user_perm($user_id,'create',$brand_id))
			{
				$this->db->where('posts.user_id',$user_id);
			}			
			$this->db->group_by('posts.id');
			$this->db->order_by('slate_date_time','ASC');			
			$query = $this->db->get('phases');	
			if($query->num_rows() > 0)
			{
				$result =  $query->result();
			}			
		}
		if(check_user_perm($user_id,'approve',$brand_id) OR $user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND $this->user_data['user_group'] == "Master Admin"))
		{
			$this->db->select('slate_date_time,posts.outlet_id,content,posts.status,posts.id as id,posts.user_id as user_id,phases.id as phase_id,tumblr_content_type,tumblr_caption,tumblr_title,tumblr_quote,tumblr_custom_url,tumblr_chat_title,tumblr_video_caption');
			$this->db->join('posts','posts.id = phases.post_id');
			$this->db->join('phases_approver','phases_approver.phase_id = phases.id');
			$this->db->where('posts.brand_id',$brand_id);

			if(!empty($search))
			{
				$this->db->like('content',$search);
			}
			
			if(!empty($start_date))
			{
				$this->db->where('(DATE_FORMAT(posts.slate_date_time,"%m-%d-%Y")) >= "'.date("m-d-Y",strtotime($start_date)).'"');
			}

			if(!empty($end_date))
			{
				$this->db->where('(DATE_FORMAT(posts.slate_date_time,"%m-%d-%Y")) <= "'.date("m-d-Y",strtotime($end_date)).'"');
			}

			if(!empty($outlet))
			{
				$this->db->where('posts.outlet_id',$outlet);
			}

			if(isset($post_data) AND !empty($post_data) AND (isset($post_data['statuses']) OR isset($post_data['tags']) OR isset($post_data['outlets'])))
			{
				$statuses = $post_data['statuses'];
				if(!empty($statuses))
				{
					$statuses = explode(',', $post_data['statuses']);
					$this->db->where_in('posts.status',$statuses);
				}
				$tags = $post_data['tags'];
				if(!empty($tags))
				{
					$this->db->join('post_tags','post_tags.post_id = posts.id','left');
					$tags = explode(',', $tags);
					foreach($tags as $tag)
					{
						$this->db->where('post_tags.id',$tag);
					}
				}
				$outlets = $post_data['outlets'];
				if(!empty($outlets))
				{
					$outlets = explode(',', $post_data['outlets']);
					$this->db->where_in('posts.outlet_id',$outlets);
				}
			}

			$this->db->where('posts.status !=','approved');
			$this->db->where('posts.status !=','deleted');
			$this->db->where('posts.status !=','draft');
			$this->db->where('phases_approver.user_id',$user_id);
			$this->db->order_by('slate_date_time','ASC');
			$query = $this->db->get('phases');
			if($query->num_rows() > 0)
			{
				if(!empty($result))
				{
					$result = array_merge($result,$query->result());
				}
				else
					$result =  $query->result();

				if(!empty($result))
				{
					usort($result, function($a,$b){
						$t1 = strtotime($a->slate_date_time);
					    $t2 = strtotime($b->slate_date_time);
					    return $t1 - $t2;
					});
				}
			}
		}

		return $result;
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

	public function get_cocreate_approvers($cocreate_id)
	{
		$this->db->select('first_name,last_name,img_folder,aauth_user_id,cocreate_approvers.status');
		$this->db->join('user_info','user_info.aauth_user_id = cocreate_approvers.user_id');
		$this->db->where('cocreate_post_id',$cocreate_id);
		$query = $this->db->get('cocreate_approvers');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_post_approvers($post_id,$status = '')
	{
		$this->db->select('account_id');
		$this->db->join('brands','brands.id = posts.brand_id');
		$this->db->where('posts.id',$post_id);
		$query = $this->db->get('posts');
		if($query->num_rows() > 0)
		{
			$result = [];
			$result['owner_id'] = $query->row()->account_id;		

			$this->db->select('phases.id as id,phases.phase,post_id,note,approve_by,phases_approver.user_id,first_name,last_name,phases_approver.status,phases.status as phase_status,img_folder');
			$this->db->join('phases','phases.id = phases_approver.phase_id');
			$this->db->join('user_info','user_info.aauth_user_id = phases_approver.user_id');
			$this->db->where('phases.post_id',$post_id);

			if(!empty($status))
			{
				$this->db->where('phases_approver.status',$status);
			}

			$this->db->order_by('phases_approver.status','desc');
			// $this->db->group_by('user_info.aauth_user_id');
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
		$this->db->order_by('phase','ASC');
		$query = $this->db->get('phases');		
		if($query->num_rows() > 0 && $this->user_id !== $this->user_data['account_id'] )
		{
			$result = array();
			foreach($query->result() as $phase)
			{
				$phase_id = $phase->id;
				$this->db->select('phases.id,phases.phase,user_info.aauth_user_id,first_name,last_name,post_id,note,approve_by,phase,phases_approver.status,phases.status as phase_status,user_info.img_folder');
				$this->db->join('user_info','user_info.aauth_user_id = phases_approver.user_id');
				$this->db->join('phases','phases_approver.phase_id = phases.id');		
				$this->db->where_in('phases_approver.phase_id',$phase_id);
				$query = $this->db->get('phases_approver');
				
				if($query->num_rows() > 0)
				{
					$phase_result =$query->result();				
					$result[$phase_result[0]->phase]['phase_users'] = $phase_result;
					$phase_comments = $this->get_phase_comments($phase_id);
					if($phase_comments)
					{
						$result[$phase_result[0]->phase]['phase_comments'] = $phase_comments;
					}					
				}
			}
			return $result;
		}
		else
		{
			$this->db->select('phases.id');
			$this->db->where('phases.post_id',$post_id);
			$this->db->order_by('phase','ASC');
			$query = $this->db->get('phases');
			if($query->num_rows() > 0)
			{
				$phase_result =$query->result();
				$result = array();
				foreach ($phase_result as $key => $value) {
					$this->db->select('phases.id,phases.phase,user_info.aauth_user_id,first_name,last_name,post_id,note,approve_by,phase,phases_approver.status,phases.status as phase_status,user_info.img_folder');
					$this->db->join('user_info','user_info.aauth_user_id = phases_approver.user_id');
					$this->db->join('phases','phases_approver.phase_id = phases.id');		
					$this->db->where_in('phases_approver.phase_id',$value->id);
					$query = $this->db->get('phases_approver');
				
					if($query->num_rows() > 0)
					{
						$phase_users = $query->result();
						$result[$phase_users[0]->phase]['phase_users'] = $query->result();
						$phase_comments = $this->get_phase_comments($value->id);
						if($phase_comments)
						{
							$result[$phase_users[0]->phase]['phase_comments'] = $phase_comments;
						}
					}
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
		$this->db->select('post_comments.id,comment,post_comments.created_at,first_name,last_name,post_comments.user_id,post_comments.status,media,user_info.img_folder,parent_id');
		$this->db->join('user_info','user_info.aauth_user_id = post_comments.user_id');
		$this->db->where('parent_id',$comment_id);
		$this->db->order_by('created_at','ASC');
		$query = $this->db->get('post_comments');
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			foreach ($result as $key => $value) {
				$comments = $this->get_comment_reply($value->id);
				if(!empty($comments)){
					$result[$key]->replies = $comments;
				}
			}
			return $result;
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
		$this->db->select('user_info.aauth_user_id,first_name,last_name,phases_approver.status,user_info.img_folder');
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