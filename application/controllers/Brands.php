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
		$this->plan_data = $this->config->item('plans')[$this->user_data['plan']];
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
		$this->data['brands'] = $this->brand_model->get_users_brand($this->user_data['account_id']);
		$this->data['all_users'] = $this->brand_model->get_all_users($this->user_data['account_id']);
		
		if(!empty($this->data['brands']) && $this->plan_data['brands'] != 'unlimited')
		{
			$message = 'Your plan supports '.$this->plan_data['brands'].' brands';
			no_of_brand_allowed(count($this->data['brands']),$this->plan_data['brands'],$message);
		}

		$this->data['timezones'] = $this->user_model->get_timezones();
		$this->data['outlets'] = $this->timeframe_model->get_table_data('outlets');		
		$this->data['users'] = $this->brand_model->get_users_sub_users($this->user_data['account_id']);	
		
		$this->data['groups'] = $this->aauth->list_groups();

		$this->data['background_image'] = 'bg-admin-overview.jpg';
		$this->data['css_files'] = array(css_url().'jquery.Jcrop.css');
		$this->data['js_files'] = array(js_url().'vendor/bootstrap-colorpicker.min.js?ver=2.3.3',js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'add-brand.js?ver=1.0.0',js_url().'jquery.Jcrop.js?ver=1.0.0',js_url().'jquery.SimpleCropper.js?ver=1.0.0',js_url().'facebook.js',js_url().'twitter.js?ver=1.0.0');

        $this->data['layout'] = 'layouts/new_user_layout';

		$this->data['view'] = 'brands/add_brand';
        _render_view($this->data);
	}

	public function save_brand()
	{
		$brand_id = $this->input->post('brand_id');
		$slug = $this->input->post('slug');
		$base64_image = $this->input->post('base64_image');
		$is_brand_image_save = $this->input->post('is_brand_image');

		$brand_data = array(
    						'name' => $this->input->post('name'),    						
    						'created_by' => $this->user_id,
    						'timezone' => $this->input->post('timezone'),
    						'account_id' => $this->user_data['account_id']
    						//'is_hidden' => $is_hidden
    					);		
    	if(empty($brand_id))
    	{
    		$insert_id = $this->timeframe_model->insert_data('brands',$brand_data);

    		$order = $this->timeframe_model->get_max('brand_order','order',array('user_id' => $this->user_id,'account_id' => $this->user_data['account_id']));
    		
    		$brand_order_data = array(
    						'brand_id' => $insert_id,
    						'user_id' => $this->user_id,
    						'account_id' => $this->user_data['account_id'],
    						'order' => $order !== FALSE ? ++$order : 0
    					);
    		$this->timeframe_model->insert_data('brand_order',$brand_order_data);

    		$user_ids = $this->timeframe_model->get_account_users($this->user_data['account_id']);
    		if(!empty($user_ids))
    		{
    			foreach ($user_ids as $id)
    			{
    				$order = $this->timeframe_model->get_max('brand_order','order',array('user_id' => $id->user_id,'account_id' => $this->user_data['account_id']));
    				
    				$brand_order_data = array(
    						'brand_id' => $insert_id,
    						'user_id' => $id->user_id,
    						'account_id' => $this->user_data['account_id'],
    						'order' => $order !== FALSE ? ++$order : 0
    					);
    				$this->timeframe_model->insert_data('brand_order',$brand_order_data);
    			}
    		}
    		$slug = create_slug_url($insert_id,'brands',$this->input->post('name'));
    		$brand_id = $insert_id;    		
    	}
    	else
    	{
    		$condition = array('id' => $brand_id);
    		$this->timeframe_model->update_data('brands',$brand_data,$condition);
    	}

    	if(isset($base64_image) && !empty( $base64_image ) && $base64_image != 'undefined')
    	{

    		if(!empty($base64_image)){
				$filename = $brand_id.'.png';
			}
			if(isset($filename))
			{
				//helper function to delete files
				if(file_exists(upload_path().$this->user_data['account_id'].'/brands/'.$brand_id.'/'.$filename))
				{
					delete_file(upload_path().$this->user_data['account_id'].'/brands/'.$brand_id.'/'.$filename);
				}

				if($is_brand_image_save == 'yes')
				{
					$base64_str = substr($base64_image, strpos($base64_image, ",")+1);

		        	//decode base64 string
			        $decoded = base64_decode($base64_str);

			        //create jpeg from decoded base 64 string and save the image in the parent folder
			        if(!is_dir(upload_path().$this->user_data['account_id'].'/brands/'.$brand_id)){
			        	mkdir(upload_path().$this->user_data['account_id'].'/brands/'.$brand_id,0755,true);
			        }
			        $url = upload_path().$this->user_data['account_id'].'/brands/'.$brand_id.'/'.$brand_id.'.png';
			        $result = file_put_contents($url, $decoded);

			        $source_url = imagecreatefrompng($url);
			       // $source_url = imagecreatefromstring(file_get_contents($url));
			        
			        header('Content-Type: image/png');
			        imagepng($source_url, $url, 8);
			        
			        if(!$result)
			        {
			        	$error = 'Failed to upload the file, Please try again !';
			        }
				}			
			}
    	}
    	if($is_brand_image_save == 'no')
		{
			delete_file(upload_path().$this->user_data['account_id'].'/brands/'.$brand_id.'/'.$brand_id.'.png');
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
	        			$data = array('outlet_id' => $outlet,'brand_id' => $post_data['brand_id']);
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
						'response' => json_encode($token_response),
						'type' => 'facebook',
						'brand_id' => $post_data['brand_id'],
						'outlet_id' => $post_data['outlet_id']
					);
					$this->timeframe_model->insert_data('social_media_keys',$data);
				}
			}
			// $all_outlets = $this->timeframe_model->get_table_data_array('outlets');
			// $brand_outlets = $this->timeframe_model->get_data_array_by_condition('brand_outlets',array('brand_id' => $post_data['brand_id']));
			// //access token that need to be deleted
			
			// $outlet_ids = array_column($all_outlets,'id');	
			// $brand_outlet_ids = array_column($brand_outlets,'outlet_id');		
			// $access_token_delete = array_diff($outlet_ids,$outlets_to_add);		
			// if(!empty($access_token_delete))
			// {
			// 	foreach($access_token_delete as $outlet_id)
			// 	{
			// 		$data = array('outlet_id' => $outlet_id,'brand_id' => $post_data['brand_id']);
   //      			$this->timeframe_model->delete_data('social_media_keys',$data);
			// 	}
			// }

			$outlets = $this->brand_model->get_brand_outlets($post_data['brand_id']);
			if(!empty($outlets))
			{
				$user_outlet_html = '';
				$user_outlet_html .='<ul>';
				foreach($outlets as $outlet)
				{					
					$user_outlet_html .='<li class="disabled sub-user-outlet" data-selected-outlet-name="'.strtolower($outlet->outlet_name).'" data-selected-outlet="'.strtolower($outlet->id).'"><i class="fa fa-'.strtolower($outlet->outlet_name).'"><span class="bg-outlet bg-'.strtolower($outlet->outlet_name).'"></span></i></li><li data-group="post-tag" data-value="disabled" class="check-all-user-outlet"><i class="fa fa-circle tag-custom"></i><span class="tag-title">All</span></li>';					
				}
				$user_outlet_html .='</ul>';
			}
			echo json_encode(array('response'=>'success','html' => $user_outlet_html));
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

     public function update_tags()
    {
		$post_data = $this->input->post();
    	if(!empty($post_data))
    	{
    		$tags = isset($post_data['tags']) ? $post_data['tags'] : array();
    		$labels = isset($post_data['labels']) ? $post_data['labels'] : array();
    		$previous_tags = $this->timeframe_model->get_data_array_by_condition('brand_tags',array('brand_id' => $post_data['brand_id']));
    		
    		if(!empty($previous_tags))
    		{
    			$post_data['tag_ids'] = isset($post_data['tag_ids']) ? $post_data['tag_ids'] : array();
    			$previous_tag_ids = array_column($previous_tags,'id');
    			$tags_to_delete = array_diff($previous_tag_ids,$post_data['tag_ids']);    			
    			foreach($tags_to_delete as $tag)
    			{
    				$this->timeframe_model->delete_data('brand_tags',array('id' =>$tag));
    			}
    		}
        	foreach ($tags as $key=>$tag)
        	{
        		$data = array(
	        				'name' => $post_data['labels'][$key],
	        				'color' => $tag,
	        				'brand_id' => $post_data['brand_id']
	        			);
        		if(!empty($post_data['tag_ids'][$key]))
        		{
        			$condition = array('id' => $post_data['tag_ids'][$key]);
        			$this->timeframe_model->update_data('brand_tags',$data,$condition);
        		}
        		else
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
            try
            {
            	$user_in_other_brand = 0;
            	$inserted_id = $post_data['selected_user'];
            	if($post_data['selected_user'] == 'Add New')
            	{
            		$is_present = $this->aauth->user_exist_by_email($post_data['email']);            		
            		if($is_present)
            		{
            			$user_in_other_brand = 1;
            			$inserted_id = $this->aauth->get_user_id($post_data['email']);
            		}
            		else
            		{
			    		$password = uniqid();
			    		//$password = 123456;
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
		                
		            	$inserted_id = $this->aauth->create_user_without_email($post_data['email'],$password);
		            	unset($user_data['password']);
	                	unset($user_data['username']);
	                }
	            }
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

                	$this->aauth->add_member($inserted_id,$group_id,$post_data['brand_id'],null);

                	$user_data['aauth_user_id'] = $inserted_id;
                	$user_data['img_folder'] = $this->user_data['account_id'];


                	if($post_data['selected_user'] == 'Add New' AND $user_in_other_brand == 0)
            		{
                		$this->timeframe_model->insert_data('user_info',$user_data);
                	}

                	$user_img_folder = $this->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id' => $inserted_id),'img_folder');
                	
                	//add permission to user
            
                	if(!empty($post_data['permissions']))
                	{
                		foreach($post_data['permissions'] as $permission)
                		{
                			$matching_perms = $this->aauth->get_matching_perms($permission);
                			foreach($matching_perms as $perm)
                			{
                				if(!empty($perm)){
                					$this->aauth->allow_user($inserted_id,$perm->id,$post_data['brand_id']);
                				}
                			}
                			
                		}
                	}

                	if(isset($post_data['file']) && !empty($post_data['file'])){
                		$base64_image = $post_data['file'];
	        		  	$base64_str = substr($base64_image, strpos($base64_image, ",")+1);

			        	//decode base64 string
				        $decoded = base64_decode($base64_str);

				        //create jpeg from decoded base 64 string and save the image in the parent folder

				        if(!is_dir(upload_path().$user_img_folder[0]->img_folder.'/users/')){
				        	mkdir(upload_path().$user_img_folder[0]->img_folder.'/users/',0755,true);
				        }
				        $url = upload_path().$user_img_folder[0]->img_folder.'/users/'.$inserted_id.'.png';	
				        $result = file_put_contents($url, $decoded);

				        $source_url = imagecreatefrompng($url);
				        
				        header('Content-Type: image/png');
				        imagepng($source_url, $url, 8);
		        	}
                	
                	
                    $brand_user_map = array(
                    							'brand_id' => $post_data['brand_id'],
                    							'access_user_id' => $inserted_id
                    						);
                    
                    $this->timeframe_model->insert_data('brand_user_map',$brand_user_map);
                    
                    $order = $this->timeframe_model->get_max('brand_order','order',array('user_id' => $inserted_id,'account_id' => $this->user_data['account_id']));                    
                    $brand_order_data = array(
                    					'order' => $order !== FALSE ? ++$order : 0,
                    					'account_id' => $this->user_data['account_id'],
                    					'user_id' => $inserted_id,
                    					'brand_id' => $post_data['brand_id']
                    				);
                    $this->timeframe_model->insert_data('brand_order',$brand_order_data);

                    $outlets = $this->input->post('outlets');
                    if(!empty($outlets))
                    {
                    	$outlets = explode(',',$outlets);
                    	if(!empty($outlets))
                    	{
                    		$outlets = array_unique($outlets);
                    	}
                    	foreach($outlets as $outlet)
                    	{
                    		 $user_outlets = array(
	                    							'outlet_id' => $outlet,
	                    							'user_id' => $inserted_id,
	                    							'brand_id' => $post_data['brand_id']
	                    						);
	                    	$this->timeframe_model->insert_data('user_outlets',$user_outlets);
                    	}
                    }

                    $image_path = img_url().'default_profile.jpg';
					if(file_exists(upload_path().$user_img_folder[0]->img_folder.'/users/'.$inserted_id.'.png'))
					{
						$image_path = upload_url().$user_img_folder[0]->img_folder.'/users/'.$inserted_id.'.png';
					}

                    $response = '<div class="table" id="table_id_'.$inserted_id.'">';
					$response .= '<div class="table-cell">';

					$response .= '<div class="pull-sm-left post-approver-img">';
					$response .= '<a href="#" class="btn-icon btn-gray edit-user-permission show-hide" href="#addUser" data-hide="#addUserLink, #outletStep3Btns, #userPermissionsList" data-show="#addNewUser, #addUserBtns" data-user-id="'.$inserted_id.'" data-brand-id="'.$post_data["brand_id"].'"><i class="fa fa-pencil"></i></a>';
					$response .= '<i title="Remove User" data-user-id="'.$inserted_id.'" class="tf-icon-circle remove-item remove-user">x</i><img src="'.$image_path.'" width="36" height="36" alt="'.ucfirst($post_data['first_name']).' '.ucfirst($post_data['last_name']).'" class="circle-img"/></div>';
					$response .= '<div class="pull-sm-left post-approver-name"><strong>'.ucfirst($post_data['first_name']).' '.ucfirst($post_data['last_name']).'</strong>'.$post_data['role'].'</div>';
					$response .= '</div>';
					$response .= '<div class="table-cell text-xs-center vertical-middle has-permission">';
					if(in_array('create',$post_data['permissions']))
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
					$response .= '</div>';

					$response .= '<div class="table-cell text-xs-center vertical-middle has-permission">';
					if(in_array('master',$post_data['permissions']))
					{ 
						$response .= '<i class="fa fa-check"></i>';
					}
					$response .= '</div></div>';

					$all_users = $this->brand_model->get_all_users($this->user_data['account_id']);

					if(isset($is_present) AND !empty($is_present))
					{
						$this->data['company_name'] = get_company_name($this->user_data['account_id']);
						$this->data['role'] = $post_data['role'];
						try
					    {
					    	$email = $post_data['email'];
					    	$subject = "You have been addded in new account";
					    	$content = $this->load->view('mails/new_account_info',$this->data,true);
					    	$mail_send = email_send($email, $subject,$content);
					    }
						catch (SomeException $e)
						{
						  // do nothing... php will ignore and continue    
						}
						
		                
					}

                    echo json_encode(array('response' => 'success','html' => $response,'inserted_id' => $inserted_id,'all_user_count' => $all_users));
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

    	$brand_data = array(
								'is_hidden' => 0
							);
    	$condition = array('account_id' => $this->user_data['account_id'],'slug'=>$slug);
    	$this->timeframe_model->update_data('brands',$brand_data,$condition);


    	$this->data['brand'] = $this->timeframe_model->get_data_by_condition('brands',array('slug' => $slug,'account_id' => $this->user_data['account_id']));

    	// $this->data['brand'] = $this->brand_model->get_brand_by_slug($this->user_id,$slug);
    	// echo $this->db->last_query();
    	// print_r($this->data['brand']);
    	// die;
    	if(!empty($this->data['brand']))
    	{
    		$brand_id = $this->data['brand'][0]->id;
    		// Check if user has added brands previously
            $existing_brands = $this->timeframe_model->get_data_by_condition('brands',array('account_id'=>$this->user_data['account_id']),'id');
            if (count($existing_brands) > 1){
                $this->data['isFirstBrand'] = FALSE;
            }
            else{
                $this->data['isFirstBrand'] = TRUE;
            }
            
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

	public function overview()
	{
		
		$this->data = array();
		$this->data['trial_message'] ='';
		$user_id = $this->user_id;

		$this->data['brands'] = $this->brand_model->get_users_brands($user_id);
		
		$created_at = $this->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id'=>$this->user_data['account_id']),'DATE_FORMAT(created_at,"%Y-%m-%d") AS created_at');
		
	    $date_diff = calculate_date_diff($created_at[0]->created_at,'');
	    
	    if($date_diff >= 20 && $date_diff < 25){

	    	$this->load->model('transaction_model');
	    	$is_any_record = $this->transaction_model->get_last_transaction($this->user_data['account_id']);
	    	if(!$is_any_record){
	    		//echo 'is_trial_account';
	    		$this->data['trial_message']= str_replace("%days%", 30-$date_diff,  $this->lang->line('trial_period_expiring_days'));
	    	}
	    }
	   // echo  $date_diff;

	    $this->data['css_files'] = array(css_url().'fullcalendar.css');
		$this->data['js_files'] = array(js_url().'vendor/jquery-ui-sortable.min.js',js_url().'reorder-brands.js?ver=1.0.0', js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'view-n-edit-request.js?ver=1.0.0',js_url().'custom_validation.js?ver=1.0.0', js_url().'tumblr-preview.js?ver=1.0.0');
		
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
			$this->user_data['timezone'] = $brand[0]->timezone;
			$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);
			
			$this->load->model('reminder_model');
			$this->data['reminders'] = $this->reminder_model->get_brand_reminders($this->user_id,$brand[0]->id,0,'reminder');				
			$this->data['brand'] = $brand[0];
			$this->data['brand_id'] = $brand[0]->id;
 			$this->data['css_files'] = array(css_url().'fullcalendar.css');
			$this->data['js_files'] = array(js_url().'vendor/moment.min.js?ver=2.11.0',js_url().'vendor/fullcalendar.min.js?ver=2.6.1',js_url().'calendar-config.js?ver=1.0.0',js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'view-n-edit-request.js?ver=1.0.0',js_url().'custom_validation.js?ver=1.0.0', js_url().'tumblr-preview.js?ver=1.0.0',js_url().'vendor/jquery.dotdotdot.min.js?ver=1.8.1');

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
		$this->data['users'] = $this->brand_model->get_approvers($brand_id);
		$this->data['brand'] =  $this->brand_model->get_users_brands($this->user_id,$brand_id);
		echo $this->load->view('partials/user_list',$this->data,true);
	}

	public function is_name_exist()
	{
		$post_data = $this->input->post();
		if(isset($post_data))
		{
			$is_exist = $this->timeframe_model->get_data_by_condition('user_info',array('first_name' => $post_data['first_name'],'last_name' => $post_data['last_name']));
			if($is_exist)
			{
				echo "1";
			}
			else
			{
				echo "0";
			}
		}
	}

	public function delete_user()
	{
		$post_data = $this->input->post();
		if(isset($post_data['aauth_user_id']))
		{
			if(isset($post_data['brand_id']))
			{
				$this->timeframe_model->delete_data('brand_user_map',array('brand_id' => $post_data['brand_id'],'access_user_id' => $post_data['aauth_user_id']));

				$this->timeframe_model->delete_data('aauth_perm_to_user',array('brand_id' => $post_data['brand_id'],'user_id' => $post_data['aauth_user_id']));

				$this->timeframe_model->delete_data('aauth_user_to_group',array('brand_id' => $post_data['brand_id'],'user_id' => $post_data['aauth_user_id']));

				$this->timeframe_model->delete_data('user_outlets',array('brand_id' => $post_data['brand_id'],'user_id' => $post_data['aauth_user_id']));
			}

			//check this user is master user(added through user preferences) of current account
			$is_ac_user = $this->timeframe_model->get_data_by_condition('aauth_user_to_group',array('user_id' => $post_data['aauth_user_id'],'parent_id' => $this->user_data['account_id']),'user_id');

			if(!empty($is_ac_user))
			{
				$this->timeframe_model->delete_data('aauth_user_to_group',array('user_id' => $post_data['aauth_user_id'],'parent_id' => $this->user_data['account_id']));
				$this->timeframe_model->delete_data('aauth_perm_to_user',array('user_id' => $post_data['aauth_user_id'],'parent_id' => $this->user_data['account_id']));
			}


			//check this user is present in another brand or account
			$is_present = $this->timeframe_model->get_data_by_condition('aauth_user_to_group',array('user_id' => $post_data['aauth_user_id']),'user_id');

			//check this user is owner of any account
			$is_account_owner = $this->timeframe_model->get_data_by_condition('user_info',array('aauth_user_id' => $post_data['aauth_user_id']),'plan');

			if(empty($is_present) AND empty($is_account_owner[0]->plan))
			{
				$this->aauth->delete_user($post_data['aauth_user_id']);
				$this->timeframe_model->delete_data('user_info',array('aauth_user_id' => $post_data['aauth_user_id']));
			}

			$all_users = $this->brand_model->get_all_users($this->user_data['account_id']);
			$master_user_count = $this->brand_model->get_all_master_users();
			if(empty($all_users))
			{
				$all_users = 1;
			}
			if(empty($master_user_count))
			{
				$master_user_count = 1;
			}
			echo json_encode(array('response' => 'success','all_users' => $all_users,'master_user_count' => $master_user_count));
			return;
		}else{
			echo json_encode(array('response' => 'fail'));
			return;
		}
	}

	function get_summary()
	{
		$post_data = $this->input->post();
		if(!empty($post_data))
		{
			$summary_posts = get_summary($post_data['brand_id'],$post_data['selected_date']); 			
			$html = '<li class="post-summary">No summary on this date</li>';
			if(!empty($summary_posts))
			{
				$html = '';
				foreach($summary_posts as $post)
				{
					$html .= "<li class='post-summary'><a  class='got-to-calender' data-post-date='".date('Y-m-d',strtotime($post->slate_date_time))."' data-post_id='".$post->id."' href='".base_url().'calendar/day/'.$post_data['slug']."'>";
					$html .= "<i class='fa fa-".strtolower($post->outlet_name)."'><span class='bg-outlet bg-".strtolower($post->outlet_name)."'></span></i>";
					$html .= date('g:i A',strtotime($post->slate_date_time))."<span class='excerpt-summary'>".$post->content."</span>";
					$html .= "</a></li>";
				}				
			}
			echo json_encode(array('html'=>$html));
		}
	}

	function get_active_notifications()
	{
		$this->load->model('reminder_model');
		$notifications = $this->reminder_model->get_active_notifications();
		echo json_encode($notifications);
	}

	function delete($brand_id){
		$status = 'fail';
		if(!empty($brand_id)){
			$brand = $this->timeframe_model->get_data_by_condition('brands',array('id'=>$brand_id),'account_id');
			
			$condition = array('brand_id'=> $brand_id);

			// delete brand outlet from brand_outlets table
			$this->timeframe_model->delete_data('brand_outlets',$condition);

			// delete brand user_outlets from brand_outlets table
			$this->timeframe_model->delete_data('user_outlets',$condition);

			// delete brand reminders from reminders table
			$this->timeframe_model->delete_data('reminders',$condition);

			// delete brand tags from brand_tags table
			$this->timeframe_model->delete_data('brand_tags',$condition);

			// delete users filters from filters table
			$this->timeframe_model->delete_data('filters',$condition);

			// delete brand Users from brand_user_map table
			$this->timeframe_model->delete_data('brand_user_map',$condition);

			// delete brand post from posts table
			$this->timeframe_model->delete_data('posts',$condition);

			// delete brand data from brand table
			$responce = $this->timeframe_model->delete_data('brands',array('id'=> $brand_id));
			
			if(!empty($brand[0])){
				$dir = FCPATH.'uploads/'.$brand[0]->account_id.'/brands/'.$brand_id;
				if(is_dir($dir)){
					$responce = deleteDirectory($dir);
				}
			}
			$status ='success';	
		}
		echo json_encode(array('status' => $status));
	}

	public function change_account()
	{
		$account_id = $this->uri->segment(3);
		if($account_id)
		{
			$session_user_type = $this->session->userdata('user_type');
			if(check_subscription_expinred($account_id) AND empty($session_user_type))
			{
				$this->session->set_flashdata('subscription_error', 'Subscription of account to which you are switching is expired.');
				// $this->session->set_flashdata()
			}
			else
			{
				$session_data = $this->user_data;
				
				$check_user = $this->timeframe_model->check_user_is_account_user($account_id);
	            if($check_user)
	            {
	                $session_data['user_group'] = $check_user;
	            }			
				$session_data['account_id'] = $account_id;

				$session_data['plan'] = strtolower(get_plan($account_id));

				$this->session->set_userdata('user_info',$session_data);
			}
		}
		redirect(base_url().'brands/overview');
	}

	public function check_email_exist()
    {
        $email = $this->input->post('email');
        $brand_id = $this->input->post('brand_id');
        $response = $this->brand_model->check_user_exist_in_account($email,$brand_id);
        echo json_encode($response);
    }

    function update_brand_order()
    {
    	$order = $this->input->post('order');
    	if(!empty($order))
    	{
	    	$brands =  $this->brand_model->get_brand_order($this->user_id);
	    	if(!empty($brands))
	    	{

	    		foreach($brands as $key=>$brand)
	    		{
	    			$update_data = array(
	    						'order' => $order[$key]
	    					);

	    			$this->timeframe_model->update_data('brand_order',$update_data,array('brand_id' => $brand->id,'user_id' => $this->user_id,'account_id' => $this->user_data['account_id']));
	    		}

	    	}
	    }
    }

    function delete_reminders()
    {
    	$reminder_id = $this->input->post('reminder_id');
    	$brand_id = $this->input->post('brand_id');
    	if($reminder_id)
    	{
    		$this->timeframe_model->delete_data('reminders',array('id' => $reminder_id));
    		$this->data['brand'] = $this->brand_model->get_brand_by_id($brand_id);
    		$html = $this->load->view('brands/reminder_list_html',$this->data,true);
    		echo json_encode(array('response' => 'success', 'html' => $html));
    	}
    }


    function report_bug_form()
    {
    	$this->data['page'] = $this->uri->segment('3');
    	$this->data['role'] = $this->uri->segment('4');
    	$this->data['current_brand'] = $this->uri->segment('5');
    	echo $this->load->view('partials/report_bug',$this->data, TRUE);
    }

    function create_ticket()
    {
    	$redirect = str_replace('__', '/', $_POST['page']);
    	$error = '';
    	if(isset($_FILES['attachment']) AND !empty($_FILES['attachment']['name']))
		{
	        $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
	        $randname = uniqid().'.'.$ext;	      
	        $status = upload_file('attachment',$randname,'bug_attachment');
	       
	        if(array_key_exists("upload_errors",$status))
	        {
	        	$error =  $status['upload_errors'];	        	
	        }
	        else
	        {
	        	$uploaded_file = $status['file_name'];	        	
	        }
	    }

	    if(empty($error))
	    {
	    	if(isset($uploaded_file))
	    	{
	    		$_POST['attachment'] = $uploaded_file;
	    		$attachment = upload_path().'bug_attachment/'.$_POST['attachment'];
	    	}
	    	$_POST['page'] = base_url().str_replace('__', '/', $_POST['page']);
	    	$_POST['role'] = str_replace('_', ' ', $_POST['role']);
	    	
	    	$_POST['name'] = ucfirst($this->user_data['first_name']).' '.ucfirst($this->user_data['last_name']);

	    	$to_email = $this->config->item('zendesk_email');
	    	$subject = $this->input->post('subject');
	    	$description = $this->input->post('description');
	    	$description = $description."\n".print_r($_POST,true);	    	
	    	// if(isset($_POST['attachment']) AND !empty($_POST['attachment']))
	    	// 	email_send_with_attachment($to_email,$subject,$description,$attachment);
	    	// else
	    	// 	email_send($to_email,$subject,$description);
	    }
	    redirect(base_url().$redirect);
    }
}





