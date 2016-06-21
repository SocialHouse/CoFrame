<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */	

	public function __construct()
	{
		parent::__construct();		
        is_user_logged();
		$this->load->model('timeframe_model');
		$this->load->model('brand_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	public function index()
	{
		$this->data = array();
		$user_id = $this->user_id;
		$this->data['brands'] = $this->brand_model->get_users_brand($user_id);
		
		$this->data['view'] = 'brands/brand_list';
        _render_view($this->data);
	}

	public function add()
	{
		$this->data = array();
		$this->load->model('user_model');
		$this->data['timezones'] = $this->user_model->get_timezones();
		$this->data['outlets'] = $this->timeframe_model->get_table_data('outlets');		
		$this->data['groups'] = $this->aauth->list_groups();

		$this->data['background_image'] = 'bg-admin-overview.jpg';
		$this->data['js_files'] = array(js_url().'vendor/bootstrap-colorpicker.min.js?ver=2.3.3',js_url().'add-brand.js?ver=1.0.0',js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'facebook.js');

        $this->data['layout'] = 'layouts/new_user_layout';

		$this->data['view'] = 'brands/add_brand';
        _render_view($this->data);
	}

	public function save_brand()
	{
		$brand_id = $this->input->post('brand_id');
		$slug = $this->input->post('slug');
		
		$brand_data = array(
    						'name' => $this->input->post('name'),    						
    						'created_by' => $this->user_id,
    						'timezone' => $this->input->post('timezone'),
    						'is_hidden' => 1
    					);
		
    	if(empty($brand_id))
    	{
    		$insert_id = $this->timeframe_model->insert_data('brands',$brand_data);
    		$slug = create_slug_url($insert_id,'brands',$this->input->post('name'));
    		$brand_id = $insert_id;    		
    	}
    	else
    	{
    		$condition = array('id' => $brand_id);
    		$this->timeframe_model->update_data('brands',$brand_data,$condition);
    	}

    	if(isset($_FILES['file']) && !empty( $_FILES['file']['name'][0]) )
		{			
			$_FILES['file']['name'] = $_FILES['file']['name'][0];
			if(!empty($_FILES['file']['name'])){
				$filename = $brand_id.'.png';
			}
	        $_FILES['file']['type'] = $_FILES['file']['type'][0];
	        $_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name'][0];
	        $_FILES['file']['error'] = $_FILES['file']['error'][0];
	        $_FILES['file']['size'] = $_FILES['file']['size'][0];
	        if(isset($filename))
			{
				//helper function to delete files
				if(file_exists(upload_path().$this->user_id.'/brands/'.$brand_id.'/'.$filename)){
					delete_file(upload_path().$this->user_id.'/brands/'.$brand_id.'/'.$filename);
				}
			}

	        $status = upload_file('file',$filename,$this->user_id.'/brands/'.$brand_id);

	        if(array_key_exists("upload_errors",$status))
	        {
	        	$error = $status['upload_errors'];	        	
	        }
	        else
	        {
	        	$filename = $status['file_name'];	        	
	        }
		}
		if(!isset($error))
		{
			echo json_encode(array('response'=>'success','brand_id' => $brand_id,'slug'=>$slug));
		}
    	else
    	{
    		echo json_encode(array('response'=>'fail'));
    	}
    }

    public function save_outlet()
    {
    	$post_data = $this->input->post();
    	if(!empty($post_data['outlets']))
    	{
    		$outlets_to_add = $post_data['outlets'];

    		$condition = array('brand_id' => $post_data['brand_id']);
        	$brand_outlets = $this->timeframe_model->get_data_array_by_condition('brand_outlets',$condition);
        	if(!empty($brand_outlets))
        	{
	        	$outlet_ids = array_column($brand_outlets,'outlet_id');
	        	$outlets_to_add = array_diff($post_data['outlets'],$outlet_ids);
	        	$outlets_to_delete = array_diff($outlet_ids,$post_data['outlets']);
	        	foreach ($outlets_to_delete as $outlet)
	        	{
	        		$data = array('brand_id' => $post_data['brand_id'],'outlet_id' => $outlet);
	        		$outlet_info = $this->timeframe_model->get_data_by_condition('brand_outlets',$data);
	        		$this->timeframe_model->delete_data('brand_outlets',$data);

	        		if(!empty($outlet_info))
	        		{
	        			$data = array('brand_outlet_id' => $outlet_info[0]->id);
	        			$this->timeframe_model->delete_data('social_media_keys',$data);
	        		}
	        	}
	        }

        	foreach ($outlets_to_add as $outlet)
        	{
        		$data = array('brand_id' => $post_data['brand_id'],'outlet_id' => $outlet);
        		$brand_outlet_id = $this->timeframe_model->insert_data('brand_outlets',$data);

        		if(isset($post_data[$outlet]) and !empty($post_data[$outlet]))
        		{
        			$token_response = json_decode($post_data[$outlet]);
        			
        			$data = array(
						'access_token' => $token_response->authResponse->accessToken,
						'social_media_id' => $token_response->authResponse->userID,
						'user_id' => $this->user_id,
						'brand_outlet_id' => $brand_outlet_id,
						'response' => json_encode($token_response),
						'type' => 'facebook'
					);
					$this->timeframe_model->insert_data('social_media_keys',$data);
				}
			}
			echo json_encode(array('response'=>'success'));
		}
    	else
    	{
    		echo json_encode(array('response'=>'fail'));
    	}

    }

    public function save_tags()
    {
		$post_data = $this->input->post();
    	if(!empty($post_data))
    	{
    		$tags = $post_data['tags'];
    		$labels = $post_data['labels'];

    		$condition = array('brand_id' => $post_data['brand_id']);
        	$this->timeframe_model->delete_data('brand_tags',$condition);

        	foreach ($tags as $key=>$tag)
        	{
        		$data = array(
	        				'name' => $post_data['labels'][$key],
	        				'color' => $tag,
	        				'brand_id' => $post_data['brand_id']
	        			);        		
        		$this->timeframe_model->insert_data('brand_tags',$data);
	        }
	        echo json_encode(array('response'=>'success','brand_id' => $post_data['brand_id']));
    	}
    	else
    	{
    		echo json_encode(array('response'=>'fail'));
    	}

    }

    public function add_user()
    {
    	$post_data = $this->input->post();

    	if(!empty($post_data))
    	{
    		$password = uniqid();
        	$user_data = array(
        					'first_name' => $this->input->post('first_name'),
        					'last_name' => $this->input->post('last_name'),	        					
        					'title' => $this->input->post('title'),	        					
        					'company_name' => $this->user_data['company_name'],
        					'company_email' => $this->user_data['company_email'],
        					'company_url' =>  $this->user_data['company_url'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'password' => $password,
                            'username' => $this->input->post('first_name')
        				);
        	
        	$this->load->helper('email');

        	$this->data['user'] = $user_data;
          
            try
            {
                
            	$inserted_id = $this->aauth->create_user_without_name($post_data['email'],$password,'');
            	$group_id = $this->aauth->get_group_id($post_data['role']);
            	if($inserted_id)
            	{
            		$brand_status = array(
            							'is_hidden' => 0            							
            						);
                    $condition = array(
                    				'id' => $post_data['brand_id']
                    			);                 
                    $this->timeframe_model->update_data('brands',$brand_status,$condition);

                	$this->aauth->add_member($inserted_id,$group_id);
                	//add permission to user
                	if(!empty($post_data['permissions']))
                	{
                		foreach($post_data['permissions'] as $permission)
                		{
                			$matching_perms = $this->aauth->get_matching_perms($permission);                			
                			foreach($matching_perms as $perm)
                			{
                				$this->aauth->allow_user($inserted_id,$perm->id);
                			}
                		}
                	}

                	if(!empty($post_data['image_name']))
                	{
                		$old_path = upload_path().$this->user_id.'/users/'.$post_data['image_name'];
		        		$new_path = upload_path().$this->user_id.'/users/'.$inserted_id.'.png';		        		
		        		rename_file($old_path, $new_path);
                	}

                	unset($user_data['password']);
                	unset($user_data['username']);
                	$user_data['aauth_user_id'] = $inserted_id;
                	
                	$this->timeframe_model->insert_data('user_info',$user_data);
                    $brand_user_map = array(
                    							'brand_id' => $post_data['brand_id'],
                    							'access_user_id' => $inserted_id
                    						);
                    
                    $this->timeframe_model->insert_data('brand_user_map',$brand_user_map);

                    $outlets = $this->input->post('outlets');
                    if(!empty($outlets))
                    {
                    	$outlets = explode(',',$outlets);
                    	foreach($outlets as $outlet)
                    	{
                    		 $user_outlets = array(
	                    							'outlet_id' => $outlet,
	                    							'user_id' => $inserted_id
	                    						);
	                    	$this->timeframe_model->insert_data('user_outlets',$user_outlets);
                    	}
                    }

                    $image_path = img_url().'default_profile.jpg';
					if(file_exists(upload_path().$this->user_id.'/users/'.$inserted_id.'.png'))
					{
						$image_path = upload_url().$this->user_id.'/users/'.$inserted_id.'.png';
					}

                    $response = '<div class="table">';
					$response .= '<div class="table-cell">';
					$response .= '<div class="pull-sm-left"><img src="'.$image_path.'" width="36" height="36" alt="'.ucfirst($post_data['first_name']).' '.ucfirst($post_data['last_name']).'" class="circle-img"/></div>';
					$response .= '<div class="pull-sm-left post-approver-name"><strong>'.ucfirst($post_data['first_name']).' '.ucfirst($post_data['last_name']).'</strong>'.$post_data['role'].'</div>';
					$response .= '</div>';
					$response .= '<div class="table-cell text-xs-center vertical-middle has-permission">';
					if(in_array('create',$post_data['permissions']))
					{ 
						$response .= '<i class="fa fa-check"></i>';
					}
					$response .= '</div>';
					$response .= '<div class="table-cell text-xs-center vertical-middle has-permission">';
					if(in_array('edit',$post_data['permissions']))
					{ 
						$response .= '<i class="fa fa-check"></i>';
					}
					$response .= '</div>';
					$response .= '<div class="table-cell text-xs-center vertical-middle has-permission">';
					if(in_array('approve',$post_data['permissions']))
					{ 
						$response .= '<i class="fa fa-check"></i>';
					}
					$response .= '</div>';

					$response .= '<div class="table-cell text-xs-center vertical-middle has-permission">';
					if(in_array('view',$post_data['permissions']))
					{ 
						$response .= '<i class="fa fa-check"></i>';
					}
					$response .= '</div>';

					$response .= '<div class="table-cell text-xs-center vertical-middle has-permission">';
					if(in_array('settings',$post_data['permissions']))
					{ 
						$response .= '<i class="fa fa-check"></i>';
					}
					$response .= '</div>';

					$response .= '<div class="table-cell text-xs-center vertical-middle has-permission">';
					if(in_array('billing',$post_data['permissions']))
					{ 
						$response .= '<i class="fa fa-check"></i>';
					}
					$response .= '</div></div>';
					
                    echo json_encode(array('response' => 'success','html' => $response));
                }
                else
                {
             		echo json_encode(array('response' => 'fail'));   	
                }            
            }
            catch(Exception $ex)
            {
                echo json_encode(array('response' => 'fail'));
            }
    	}
    }

    function success()
    {
    	$this->data = array();
    	$slug = $this->uri->segment(3);
    	$this->data['brand'] = $this->brand_model->get_brand_by_slug($this->user_id,$slug);
    	if(!empty($this->data['brand']))
    	{
    		$brand_id = $this->data['brand'][0]->id;
			$condition = array('brand_id' => $brand_id);
			$this->data['brand_tags'] = $this->timeframe_model->get_data_by_condition('brand_tags',$condition);
			$this->load->model('post_model');
			$this->data['outlets'] = $this->post_model->get_brand_outlets($brand_id);			
			$this->data['brands_user'] = $this->brand_model->get_brand_users($brand_id);
			$this->data['background_image'] = 'bg-admin-overview.jpg';
			$this->data['js_files'] = array(js_url().'vendor/bootstrap-colorpicker.min.js?ver=2.3.3',js_url().'add-brand.js?ver=1.0.0',js_url().'drag-drop-file-upload.js?ver=1.0.0');

	        $this->data['layout'] = 'layouts/new_user_layout';

			$this->data['view'] = 'brands/brand_save_success';
	        _render_view($this->data);
	    }
    }

    function upload_profile_pic()
    {
       	$post_data = $this->input->post();
    	if(isset($_FILES['file']['name'][0]) AND !empty($_FILES['file']['name'][0]))
		{			
			$_FILES['file']['name'] = $_FILES['file']['name'][0];
	        $filename = $_FILES["file"]["name"];
	        $_FILES['file']['type'] = $_FILES['file']['type'][0];
	        $_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name'][0];
	        $_FILES['file']['error'] = $_FILES['file']['error'][0];
	        $_FILES['file']['size'] = $_FILES['file']['size'][0];
	        $status = upload_file('file',$filename,$post_data['user_id'].'/users');
	        if(array_key_exists("upload_errors",$status))
	        {
	        	$error = $status['upload_errors'];
	        	echo json_encode(array('response' => 'fail'));   	        	
	        }
	        else
	        {
	        	$filename = $status['file_name'];
	     		echo json_encode(array('response' => 'success','file' => $filename));  
	        }			
    	}
    	else
    	{
    		echo json_encode(array('response' => 'success'));
    	}
    }

	public function edit($brand_id)
	{
		$this->data = array();
		$this->load->model('user_model');
		$this->data['timezones'] = $this->user_model->get_timezones();
		$brand = get_users_brand($brand_id);
		if(!empty($brand))
		{
			$this->data['brand'] = $brand[0];
			$this->data['view'] = 'brands/add_brand';
	        _render_view($this->data);
	    }
	    else
	    {
	    	$this->session->set_flashdata('error','Brand is not available');
	    	redirect(base_url().'brands');
	    }
	}

	public function hide_brand($brand_id)
	{
		$brand = get_users_brand($brand_id);
		if(!empty($brand))
		{
			$brand_data = array(
								'is_hidden' => 1
							);
			$condition = array('id' => $brand_id);
			$this->timeframe_model->update_data('brands',$brand_data,$condition);
			$this->session->set_flashdata('message','Brand hide successfull');
			redirect(base_url().'brands');
		}
	}

	public function un_hide_brand($brand_id)
	{
		$brand = get_users_brand($brand_id);
		if(!empty($brand))
		{
			$brand_data = array(
								'is_hidden' => 0
							);
			$condition = array('id' => $brand_id);
			$this->timeframe_model->update_data('brands',$brand_data,$condition);
			$this->session->set_flashdata('message','Brand unhide successfull');
			redirect(base_url().'brands');
		}
	}

	public function overview()
	{
		$this->data = array();
		$user_id = $this->user_id;
		$this->data['brands'] = $this->brand_model->get_users_brands($user_id);
		
		$this->data['js_files'] = array(js_url().'vendor/jquery-ui-sortable.min.js',js_url().'reorder-brands.js?ver=1.0.0');
		
		$this->data['background_image'] = 'bg-admin-overview.jpg';
		$this->data['view'] = 'brands/overview';
		$this->data['layout'] = 'layouts/new_user_layout';
        _render_view($this->data);
	}

	public function dashboard()
	{
		$this->data = array();
		$slug = $this->uri->segment(3);
		$this->load->model('user_model');		
		$this->data['timezones'] = $this->user_model->get_timezones();
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);
		

		if(!empty($brand))
		{
			$this->load->model('reminder_model');
			$this->data['reminders'] = $this->reminder_model->get_brand_reminders($this->user_id,$brand[0]->id);				
			$this->data['brand'] = $brand[0];
			$this->data['brand_id'] = $brand[0]->id;
 			$this->data['css_files'] = array(css_url().'fullcalendar.css');
			$this->data['js_files'] = array(js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0');

			$this->data['background_image'] = 'bg-brand-management.jpg';
			$this->data['view'] = 'brands/dashboard';
			$this->data['layout'] = 'layouts/new_user_layout';
	        _render_view($this->data);
	    }
	}

	public function brand_list()
	{
		$this->data['brands'] =  $this->brand_model->get_users_brands($this->user_id);		
		echo $this->load->view('partials/brand_list',$this->data,true);		
	}

	public function reorder_brands()
	{
		$this->data['brands'] =  $this->brand_model->get_users_brands($this->user_id);
		
		echo $this->load->view('partials/reorder_brands',$this->data,true);		
	}

	public function get_brand_users($brand_id)
	{
		$this->data['users'] = $this->brand_model->get_brand_users($brand_id);
		$this->data['brand'] =  $this->brand_model->get_users_brands($this->user_id,$brand_id);
		echo $this->load->view('partials/user_list',$this->data,true);
	}
}
