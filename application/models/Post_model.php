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
		$this->db->select('outlets.id, outlet_name, outlet_constant');
		$this->db->join('outlets','outlets.id = brand_outlets.outlet_id');
		$this->db->where('brand_outlets.brand_id',$brand_id);
		$query = $this->db->get('brand_outlets');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_user_outlets($brand_id,$user_id)
	{
		$this->db->select('outlets.id, outlet_name, outlet_constant');
		$this->db->join('outlets','outlets.id = user_outlets.outlet_id');
		$this->db->where('user_outlets.brand_id',$brand_id);
		$this->db->where('user_outlets.user_id',$user_id);
		$this->db->order_by('outlets.id','ASC');
		$query = $this->db->get('user_outlets');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_brand_tags($brand_id)
	{

		//$this->db->select('id,name,color');
		$this->db->select('id,name,color, REPLACE(name, " ", "") as tag_name');				
		$this->db->where('brand_tags.brand_id',$brand_id);
		$this->db->where('brand_tags.status',1);
		//$this->db->group_by('name');
		$query = $this->db->get('brand_tags');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_post_tags($post_id)
	{
		$this->db->select('brand_tags.id,name,color as tag_color, REPLACE(name, " ", "") as tag_name');		
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

	public function get_posts($brand_id,$search='')
	{
		$this->db->where('brand_id',$brand_id);
		if(!empty($search))
		{
			$this->db->like('content',$search);
		}
		
		$query = $this->db->get('posts');
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
		if(empty($post_id))
			return FALSE;

		$this->db->select('posts.id,posts.content,posts.video_title,share_with,pinterest_board,pinterest_source,tumblr_tags,tumblr_custom_url,tumblr_content_source,tumblr_title,tumblr_caption,tumblr_quote,tumblr_source,tumblr_link,tumblr_link_description,tumblr_chat_title,tumblr_chat,tumblr_audio_description,tumblr_video_caption,tumblr_text_content,tumblr_content_type ,posts.outlet_id, posts.brand_id, posts.slate_date_time, posts.created_at, CONCAT (CONCAT(UCASE(LEFT(user.first_name,1)), 
                             SUBSTRING(user.first_name, 2))," ",CONCAT(UCASE(LEFT(user.last_name,1)), 
                             SUBSTRING(user.last_name, 2))) as user ,user.aauth_user_id as user_id,brands.created_by,LOWER(outlets.outlet_constant) as outlet_name,posts.status,brands.slug, posts.time_zone,outlets.outlet_constant');
		$this->db->join('user_info as user','user.aauth_user_id = posts.user_id');
		$this->db->join('outlets','outlets.id = posts.outlet_id','left');
		$this->db->join('brands','brands.id = posts.brand_id','left');
		$this->db->where('posts.id',$post_id);
		$query = $this->db->get('posts');

		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return FALSE;
	}

	function get_cocreate_post($req_id)
	{
		$this->db->select('cocreate_post_info.id,cocreate_post_info.content,cocreate_post_info.video_title,share_with,pinterest_board,pinterest_source,tumblr_tags,tumblr_custom_url,tumblr_content_source,tumblr_title,tumblr_caption,tumblr_quote,tumblr_source,tumblr_link,tumblr_link_description,tumblr_chat_title,tumblr_chat,tumblr_audio_description,tumblr_video_caption,tumblr_text_content,tumblr_content_type ,cocreate_post_info.outlet_id, cocreate_post_info.brand_id, cocreate_post_info.slate_date_time, cocreate_post_info.created_at, CONCAT (CONCAT(UCASE(LEFT(user.first_name,1)), 
                             SUBSTRING(user.first_name, 2))," ",CONCAT(UCASE(LEFT(user.last_name,1)), 
                             SUBSTRING(user.last_name, 2))) as user ,user.aauth_user_id as user_id,brands.created_by,LOWER(outlets.outlet_constant) as outlet_name,brands.slug, cocreate_post_info.time_zone,outlets.outlet_constant');
		$this->db->join('user_info as user','user.aauth_user_id = cocreate_post_info.user_id');
		$this->db->join('brands','brands.id = cocreate_post_info.brand_id','left');
		$this->db->join('outlets','outlets.id = cocreate_post_info.outlet_id','left');
		$this->db->where('cocreate_post_info.request_id',$req_id);
		$query = $this->db->get('cocreate_post_info');
		// echo $this->db->last_query();
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
		$status = $this->db->query('INSERT INTO posts (content, brand_id, user_id, outlet_id, slate_date_time, status,time_zone, updated_at) SELECT content,brand_id, user_id, outlet_id, slate_date_time, status, time_zone, now() FROM posts WHERE id='.$post_id);
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

			$this->db->select('post_media.name,post_media.type,post_media.mime,posts.brand_id,brands.account_id');
			$this->db->join('posts','posts.id = post_media.post_id');
			$this->db->join('brands','brands.id = posts.brand_id');
			$query = $this->db->get_where('post_media',array('post_id' => $post_id));
			if($query->num_rows())
			{
				foreach($query->result_array() as $row)
				{
					$row['post_id'] = $last_id;
					$old_path = upload_path().$row['account_id'].'/brands/'.$row['brand_id'].'/posts/'.$row['name'];
					if(file_exists($old_path)){
						$ext = pathinfo($old_path, PATHINFO_EXTENSION);
						$file_name = uniqid().'.'.$ext;
		        		$new_path =upload_path().$row['account_id'].'/brands/'.$row['brand_id'].'/posts/'.$file_name;
		        		copy($old_path,$new_path);
		        		$row['name'] = $file_name;
		        		$img_data =	array(
			        			'post_id'=>$row['post_id'],
			        			'name'=>$row['name'],
			        			'type'=>$row['type'],
			        			'mime'=>$row['mime']
			        			);
						$this->db->insert('post_media',$img_data);
					}
				}
			}

			$query = $this->db->get_where('phases',array('post_id' => $post_id));
	
			if($query->num_rows() > 0)
			{
				foreach($query->result_array() as $row)
				{
					$previous_phase_id = $row['id'];
					unset($row['id']);
					$row['post_id'] = $last_id;					
					$this->db->insert('phases',$row);
					$phase_id = $this->db->insert_id();

					$approver_query = $this->db->get_where('phases_approver',array('phase_id' => $previous_phase_id));
					if($approver_query->num_rows() > 0)
					{
						foreach($approver_query->result_array() as $phase_approver)
						{
							unset($phase_approver['id']);
							$phase_approver['phase_id'] = $phase_id;
							$phase_id = $this->db->insert('phases_approver',$phase_approver);							
						}
					}
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
		$this->db->select('phases.id as phase_id,first_name,last_name,phases_approver.user_id,phase,brand_id,post_id,approve_by,note,phases.time_zone,phases_approver.status,phases.status as phase_status,user_info.img_folder');
		$this->db->join('user_info','user_info.aauth_user_id = phases_approver.user_id');
		$this->db->join('phases','phases.id = phases_approver.phase_id');
		// $this->db->where('brand_id',$brand_id);
		$this->db->where('post_id',$post_id);
		$this->db->order_by('phases.phase');
		$query = $this->db->get('phases_approver');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_posts_by_time($brand_id, $start, $end, $outlets = '',$statuses = '',$tags)
	{
		$this->db->select('posts.id,content as title,REPLACE(slate_date_time, " ", "T") as start,LOWER(outlets.outlet_name) as className,IF(slate_date_time >= "'.date('Y-m-d H:i:s').'",("true" = "true"), ("true" = "false")) as editable,tumblr_tags,tumblr_custom_url,tumblr_content_source,tumblr_title,tumblr_caption,tumblr_quote,tumblr_source,tumblr_link,tumblr_link_description,tumblr_chat_title,tumblr_chat,tumblr_audio_description,tumblr_video_caption,tumblr_text_content,tumblr_content_type');
		$this->db->join('outlets','outlets.id = posts.outlet_id');
		$this->db->join('post_media','post_media.post_id = posts.id','left');		
		$this->db->where('(slate_date_time between "'.$start.'" AND "'.$end.'")');
		$this->db->where('posts.brand_id',$brand_id);
		$this->db->where('posts.status != "deleted"');
		$this->db->where('posts.status != "draft"');
		if(get_user_groups($this->user_id,$brand_id) == 'Creator')
		{
			$this->db->where('posts.user_id',$this->user_id);
		}
		
		if(check_user_perm($this->user_id,'create',$brand_id) OR check_user_perm($this->user_id,'create',NULL,$this->user_data['account_id']) OR $this->user_id == $this->user_data['account_id'])
		{
			
		}
		else
		{
			$this->db->where('posts.status != "draft"');
		}

		if($outlets)
		{
			$outlets = explode(',', $outlets);
			$this->db->where_in('outlets.id',$outlets);
		}
		if($tags)
		{
			$this->db->join('post_tags','post_tags.post_id = posts.id','left');
			$this->db->join('brand_tags','brand_tags.id = post_tags.brand_tag_id','left');
			$tags = explode(',', $tags);
			foreach($tags as $tag)
			{
				$tag = explode('__',$tag);
				$this->db->where('brand_tags.color',$tag[0]);
				$this->db->where('brand_tags.name',$tag[1]);
				$this->db->where('brand_tags.color IS NOT NULL');
				$this->db->where('brand_tags.name IS NOT NULL');
			}
			
		}
		if($statuses)
		{
			$statuses = explode(',', $statuses);
			$this->db->where_in('posts.status',$statuses);
		}
		$this->db->group_by('posts.id');
		$query = $this->db->get('posts');
		 // echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			$posts = $query->result();
			if(!empty($posts))
	    	{
		    	foreach($posts as $key=>$post)
		    	{
		    		$title = '';
					if(!empty($post->tumblr_content_type))
					{
						if($post->tumblr_content_type == 'Photo')
						{
							$title = $post->tumblr_caption;
						}
						else if($post->tumblr_content_type == 'Text')
						{
							$title = $post->tumblr_title;
						}
						else if($post->tumblr_content_type == 'Quote')
						{
							$title = $post->tumblr_quote;
						}
						else if($post->tumblr_content_type == 'Link')
						{
							$title = $post->tumblr_custom_url;
						}
						else if($post->tumblr_content_type == 'Chat')
						{
							$title = $post->tumblr_chat_title;
						}
						else if($post->tumblr_content_type == 'Video')
						{
							$title = $post->tumblr_video_caption;
						}
					}
					else
						$title = $post->title;

		    		$posts[$key]->title = strip_tags($title);
		    		if(!is_bool($post->editable))
		    		{
		    			$posts[$key]->editable = (bool)$post->editable;
		    		}
		    	}
		    }
		    return $posts;
		}
		return FALSE;
	}

	public function get_posts_info_by_time($brand_id,$start,$end)
	{
		$this->db->select('posts.id,content as title,REPLACE(slate_date_time, " ", "T") as start,LOWER(outlets.outlet_name) as className');
		$this->db->join('outlets','outlets.id = posts.outlet_id');
		$this->db->where('(slate_date_time between "'.$start.'" AND "'.$end.'")');
		
		$this->db->where('brand_id',$brand_id);
		$query = $this->db->get('posts');

		// echo $this->db->last_query();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_images($post_id){
		$this->db->select('post_media.id,post_media.name, post_media.type, post_media.mime');
		$this->db->where('post_media.post_id',$post_id);
		$query = $this->db->get('post_media');

		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	public function get_cocreate_images($cocreate_post_id){
		$this->db->select('cocreate_post_media.id,cocreate_post_media.name, cocreate_post_media.type, cocreate_post_media.mime');
		$this->db->where('cocreate_post_media.cocreate_post_id',$cocreate_post_id);
		$query = $this->db->get('cocreate_post_media');

		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}


	public function get_post_by_date($brand_id='',$user_id='', $date='',$status = ''){
		$this->db->select('posts.id,posts.content,posts.outlet_id, posts.brand_id, posts.slate_date_time, posts.created_at,posts.status, CONCAT (user.first_name," ",user.last_name) as user ,user.aauth_user_id as user_id,brands.created_by,LOWER(outlets.outlet_constant) as outlet_name, brands.slug,tumblr_tags,tumblr_custom_url,tumblr_content_source,tumblr_title,tumblr_caption,tumblr_quote,tumblr_source,tumblr_link,tumblr_link_description,tumblr_chat_title,tumblr_chat,tumblr_audio_description,tumblr_video_caption,tumblr_text_content,tumblr_content_type');
		$this->db->join('user_info as user','user.aauth_user_id = posts.user_id');
		$this->db->join('outlets','outlets.id = posts.outlet_id','left');
		$this->db->join('brands','brands.id = posts.brand_id','left');
		$this->db->where('posts.status != "deleted"');
		$this->db->where('posts.status != "draft"');
		if(empty($date))
		{
			$date = date("Y-m-d");
		}
		$this->db->where('(DATE_FORMAT(posts.slate_date_time,"%m-%d-%Y")) = "'.date("m-d-Y",strtotime($date)).'"');

		if(!empty($brand_id))
		{
			$this->db->where('posts.brand_id',$brand_id);
		}

		if(empty($date))
		{
			$this->db->where('posts.status',$status);
		}
		$this->db->order_by('posts.slate_date_time','ASC');
		$query = $this->db->get('posts');
		// echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			if(!empty($result)){
				foreach ($result as $key => $post) {
					$result[$key]->post_images = $this->get_images($post->id);
					$result[$key]->post_tags = $this->get_post_tags($post->id);
				}
				return $result;
			}
			return FALSE;
		}
		return FALSE;
	}

	public function get_summary($brand_id,$date = '')
	{
		$this->db->select('posts.id,posts.content,outlets.outlet_name,posts.slate_date_time');
		$this->db->join('outlets','outlets.id = posts.outlet_id');
		$this->db->where('status != "deleted"');
		$this->db->where('status != "draft"');
		$this->db->where('brand_id',$brand_id);
		if(get_user_groups($this->user_id,$brand_id) == 'Creator')
		{
			$this->db->where('user_id',$this->user_id);			
		}
		
		if(empty($date))
		{
			$date = date("Y-m-d");
		}
		
		$this->db->where('(DATE_FORMAT(`slate_date_time`, \'%Y-%m-%d\') = "'.$date.'")');
		$this->db->order_by('slate_date_time','desc');
		$query = $this->db->get('posts');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}


	public function export_post($brand_id,$start_date,$end_date,$type, $tags, $outlets){
		$this->db->select('posts.id,posts.content,posts.outlet_id, user.aauth_user_id as user_id,,brands.name, posts.slate_date_time,posts.status, CONCAT (user.first_name," ",user.last_name) as user ,LOWER(outlets.outlet_constant) as outlet_name,brands.created_by,posts.created_at,brands.id as brand_id');
		$this->db->join('user_info as user','user.aauth_user_id = posts.user_id');
		$this->db->join('outlets','outlets.id = posts.outlet_id','LEFT');
		$this->db->join('brands','brands.id = posts.brand_id','LEFT');
		$this->db->join('post_tags','post_tags.post_id = posts.id','LEFT');
		$this->db->join('brand_tags','brand_tags.id = post_tags.brand_tag_id','LEFT');
		$this->db->where('posts.status != "deleted"');
		$this->db->where('posts.status != "draft"');
		
		$this->db->where('(DATE_FORMAT(`slate_date_time`, \'%Y-%m-%d\') >= "'.date("Y-m-d",strtotime($start_date)).'")');
		$this->db->where('(DATE_FORMAT(`slate_date_time`, \'%Y-%m-%d\') <= "'.date("Y-m-d",strtotime($end_date)).'")');
		
		if(!empty($outlets))
		{
			$this->db->where_in('outlets.outlet_constant',$outlets);
		}
		if(!empty($tags))
		{
			$tags_str = implode(', ', $tags);
			$this->db->where('`posts`.`id` in (SELECT DISTINCT (post_tags.post_id) FROM post_tags WHERE post_tags.brand_tag_id in ('.$tags_str.'))');
		}
		$this->db->group_by('posts.id');
		$query = $this->db->get('posts');
		//echo $this->db->last_query();	
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			if(!empty($result))
			{
				if($type == 'CSV')
				{
					$post_images = array();
					$post_tags = array();
					foreach ($result as $key => $post) 
					{
						$post_images = $this->get_images($post->id);
						$post_tags = $this->get_post_tags($post->id);
						$created_by = $post->created_by;
						unset($post->created_by);
						unset($post->outlet_id);
						unset($post->user_id);
						unset($post->brand_id);
						if(!empty($post_images))
						{
							foreach ($post_images as $obj => $value)
							{
								if(!empty($result[$key]->media))
								{
									$result[$key]->media .= ', '.base_url().$created_by.'/brands/'.$brand_id.'/'.$value->name ;
								}
								else
								{
									$result[$key]->media =base_url().$created_by.'/brands/'.$brand_id.'/'. $value->name ;
								}
							}
						}
						if(!empty($post_tags))
						{
							$result[$key]->post_tags = (implode(',',array_column($post_tags, 'name')));
						}
					}
				}
				else
				{
					foreach ($result as $key => $post) {
						$result[$key]->post_images = $this->get_images($post->id);
						$result[$key]->post_tags = $this->get_post_tags($post->id);
					}
				}
				return $result;
			}
			return FALSE;
		}
		return FALSE;
	}

	function get_posts_with_outlet($date)
	{
		$this->db->select('posts.id,content,slate_date_time,status,user_id,brands.created_by,outlet_constant,posts.brand_id,tumblr_tags,tumblr_custom_url,tumblr_content_source,tumblr_title,tumblr_caption,tumblr_quote,tumblr_source,tumblr_link,tumblr_link_description,tumblr_chat_title,tumblr_chat,tumblr_audio_description,tumblr_video_caption,tumblr_text_content,tumblr_content_type');
		$this->db->join('brands','brands.id = posts.brand_id');
		$this->db->join('outlets','outlets.id = posts.outlet_id');
		$this->db->where('posts.status','scheduled');
		$this->db->where('(DATE_FORMAT(`slate_date_time`, \'%Y-%m-%d\') = "'.date("Y-m-d",strtotime($date)).'")');
		$this->db->order_by('created_by','asc');
		$this->db->order_by('outlet_constant','asc');
		$query = $this->db->get('posts');
		// echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			if(!empty($result)){
				foreach ($result as $key => $post) {
					// $result[$key]->post_images = $this->get_images($post->id);
					$result[$key]->post_tags = $this->get_post_tags($post->id);
				}
				return $result;
			}
			return FALSE;
		}
		return FALSE;
	}

	public function get_phase($phase_id)
	{
		$this->db->where('phases.id',$phase_id);
		$query = $this->db->get('phases');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return FALSE;
	}

	public function delete_comments($comment_id ='',$phase_id='',$post_id='')
	{
		if(!empty($comment_id) || (!empty($phase_id) && !empty($post_id)) ){
			if(!empty($comment_id)){
				$this->db->where('comment_id',$phase_id);
			}
			else
			{
				$this->db->where('phase_id',$phase_id);
				$this->db->where('post_id',$phase_id);				
			}
			$this->db->delete('post_comments');
			return TRUE;
		}
		return FALSE;
	}

	function save_cocreate($cocreate_info_id)
	{
		$query = $this->db->query('INSERT into posts select content,video_title,share_with,pinterest_board,	pinterest_source,tumblr_content_type,tumblr_tags,tumblr_custom_url,tumblr_content_source,tumblr_title,tumblr_text_content,tumblr_caption,tumblr_quote,tumblr_source,tumblr_link,tumblr_link_description,tumblr_chat_title,tumblr_chat_title,tumblr_audio_description,tumblr_video_caption,brand_id,user_id,	outlet_id,slate_date_time,time_zone WHERE id='.$cocreate_info_id);
		if($query->num_rows() > 0)
		{
			return $this->db->insert_id();
		}
		return FALSE;
	}
}