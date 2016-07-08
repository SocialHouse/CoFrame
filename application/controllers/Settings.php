<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

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
		$this->load->model('post_model');
		$this->load->model('brand_model');
		$this->load->model('user_model');
		$this->user_id = $this->session->userdata('id');
		$this->user_data = $this->session->userdata('user_info');
	}

	function index()
	{ 
	}

	function view()
	{
		$this->data = array();
		$slug = $this->uri->segment(3);	
		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);

		if(!empty($brand))
		{
			$this->data['user_group'] = get_user_groups($this->user_id,$brand[0]->id);
			$brand_id = $brand[0]->id;
			$this->data['users'] = $this->brand_model->get_brand_users($brand_id);
			$this->data['outlets'] = $this->post_model->get_brand_outlets($brand_id);
			$this->data['tags'] = $this->post_model->get_brand_tags($brand_id);	

			$timezone_str = $this->brand_model->get_brand_timezone_string($brand_id);
			$this->data['timezone'] = $timezone_str[0]->timezone; 
			$this->data['selected_outlets'] = $this->post_model->get_brand_outlets($brand[0]->id);
			$this->data['selected_tags'] = $this->post_model->get_brand_tags($brand[0]->id);			
			$this->data['brand_id'] = $brand[0]->id;
			$this->data['brand'] = $brand[0];
			$this->data['view'] = 'settings/settings';
			//echo '<pre>'; print_r($this->data);echo '</pre>'; die;
			$this->data['layout'] = 'layouts/new_user_layout';
			$this->data['css_files'] = array(css_url().'jquery.Jcrop.css');
			$this->data['js_files'] = array(js_url().'vendor/bootstrap-colorpicker.min.js?ver=2.3.3',js_url().'add-brand.js?ver=1.0.0',js_url().'drag-drop-file-upload.js?ver=1.0.0',js_url().'jquery.Jcrop.js?ver=1.0.0',js_url().'jquery.SimpleCropper.js?ver=1.0.0', js_url().'facebook.js',js_url().'vendor/moment.min.js?ver=2.11.0');
			
			$this->data['background_image'] = 'bg-brand-management.jpg';  

			_render_view($this->data);
		}
	}

	public function edit_step(){
		$this->data = array();
		$slug = $this->input->post('brand_slug');
		$step_number = $this->input->post('step_no');
		$is_load = $this->input->post('reload');

		$brand =  $this->brand_model->get_brand_by_slug($this->user_id,$slug);
		$this->data['brand_id'] = $brand[0]->id;
		$this->data['brand'] = $brand[0];

		if(!empty($step_number) && !empty($slug)){

			if($step_number == 1 ){
				$timezone_str = $this->brand_model->get_brand_timezone_string($brand[0]->id);
				$this->data['timezone'] = $timezone_str[0]->timezone; 
				$this->data['timezones_list'] = $this->user_model->get_timezones();
			}

			if($step_number == 2 ){
				$this->data['selected_outlets'] = $this->post_model->get_brand_outlets($brand[0]->id);
				$this->data['outlets'] = $this->timeframe_model->get_table_data('outlets');
				
			}

			if($step_number == 3 ){
				$this->data['groups'] = $this->aauth->list_groups();
				$this->data['added_users'] = $this->brand_model->get_brand_users($brand[0]->id);

				$current_brand_users = $this->timeframe_model->get_data_array_by_condition('brand_user_map',array('brand_id' => $brand[0]->id),'access_user_id');

				$brands_users = [];
				if(!empty($current_brand_users))
					$brands_users = array_column($current_brand_users,'access_user_id');

				//$this->data['users'] = $this->brand_model->get_users_sub_users($this->user_id,$brand[0]->id,$brands_users);	
				$this->data['users'] = $this->brand_model->get_brand_users($brand[0]->id);
				
				$this->data['outlets'] = $this->post_model->get_brand_outlets($brand[0]->id);
			} 

			if($step_number == 4 ){
				$this->data['selected_tags'] = $this->post_model->get_brand_tags($brand[0]->id);
			}
			
			if($is_load == 'true'){
				echo $this->load->view('settings/step_'.$step_number,$this->data,true);	
			}else{
				$this->data['css_files'] = array(css_url().'jquery.Jcrop.css');
				$this->data['js_files'] = array(js_url().'vendor/bootstrap-colorpicker.min.js?ver=2.3.3',js_url().'add-brand.js?ver=1.0.0',js_url().'jquery.Jcrop.js?ver=1.0.0',js_url().'jquery.SimpleCropper.js?ver=1.0.0',js_url().'facebook.js',js_url().'twitter.js?ver=1.0.0');
				echo $this->load->view('settings/edit_brand/step_'.$step_number,$this->data,true);
			}
		}else{
			echo 'false';
		}
	}



	public function get_user_info()
	{
		$aauth_user_id = $this->input->post('aauth_user_id');
		$brand_id = $this->input->post('brand_id');
		if(!empty($brand_id) && !empty($aauth_user_id)){
			$this->data['user_details'] = $this->user_model->get_user($aauth_user_id);
			$this->data['user_outlets'] = $this->post_model->get_user_outlets($brand_id,$aauth_user_id);
			$this->data['user_role'] = strtolower(get_user_groups($aauth_user_id,$brand_id));
			if(!empty($this->data)){
				echo json_encode(array('status' => 'success' , 'result'=> $this->data));
			}else{
				echo json_encode(array('status' => 'fail' , 'result'=> 'Fail'));
			}	
		}else{
			echo json_encode(array('status' => 'fail' , 'result'=> 'Fail'));			
		}
	}


	public function edit_user()
	{
		$post_data = $this->input->post();
		if(!empty($post_data) && !empty($post_data['user_id'])){
			$user_id = $post_data['user_id'];
			$brand_id = $post_data['brand_id'];

        	$old_outlets = object_to_array($this->post_model->get_user_outlets($brand_id,$user_id));
        	if(!empty($old_outlets))
        	{
	        	$outlet_ids = array_column($old_outlets,'id');

	        	$new_selected_outlets = explode(',', $post_data['outlets']);

	        	$outlets_to_add = array_diff($new_selected_outlets,$outlet_ids); // outlets to add
	        	
	        	$outlets_to_delete = array_diff($outlet_ids,$new_selected_outlets); //outlets to delete

	        	// echo '$new_selected_outlets <pre>'; print_r($new_selected_outlets );echo '</pre>'; 
	        	
	        	// echo '$outlet_ids <pre>'; print_r($outlet_ids );echo '</pre>'; 

	        	// echo '$outlets_to_add <pre>'; print_r($outlets_to_add );echo '</pre>'; 

	        	// echo '$outlets_to_delete <pre>'; print_r($outlets_to_delete );echo '</pre>'; 
	        	foreach ($outlets_to_delete as $key => $o_id) {
	        		$condition = array(
	        				'user_id' => $user_id,
	        				'outlet_id' => $o_id ,
	        				'brand_id' => $brand_id
	        			);
	        		$this->timeframe_model->delete_data('user_outlets',$condition);
	        	}
	        	foreach ($outlets_to_add as $key_1 => $o_id_1) {
	        		$data = array(
	        			'user_id' => $user_id,
	        			'outlet_id' => $o_id_1,
	        			'brand_id' => $brand_id
	        			);
	        		$this->timeframe_model->insert_data('user_outlets',$data);
	        	}
	        }
	        $user_info = array(
	        		'first_name'=> $post_data['first_name'],
	        		'last_name'=> $post_data['last_name'],
	        		'title'=> $post_data['title'],
	        		'first_name'=> $post_data['first_name']
	        	);
	        $condition = array('aauth_user_id' => $user_id);
	        $this->timeframe_model->update_data('user_info',$user_info,$condition);

	        if(isset($post_data['file']) && !empty($post_data['file'])){
        		$base64_image = $post_data['file'];
    		  	$base64_str = substr($base64_image, strpos($base64_image, ",")+1);

	        	//decode base64 string
		        $decoded = base64_decode($base64_str);

		        //create jpeg from decoded base 64 string and save the image in the parent folder

		        if(!is_dir(upload_path().$this->user_id.'/users/')){
		        	mkdir(upload_path().$this->user_id.'/users/',0755,true);
		        }
		        $url = upload_path().$this->user_id.'/users/'.$user_id.'.png';	
		        
		        $result = file_put_contents($url, $decoded);
		        
		        $source_url = imagecreatefrompng($url);
		        
		        header('Content-Type: image/png');
		        
		        imagepng($source_url, $url, 8);

		        // $old_role = strtolower(get_user_groups($aauth_user_id,$brand_id));
		        
		        // $this->aauth->remove_member($user_id, $old_role);

		        // $group_id = $this->aauth->get_group_id($post_data['role']);

		        // $this->aauth->add_member($user_id,$group_id,$brand_id);
		        
		        // $this->aauth->deny_user($user_id, $old_role);

		        //add permission to user
            
            	// if(!empty($post_data['permissions']))
            	// {
            	// 	foreach($post_data['permissions'] as $permission)
            	// 	{
            	// 		$matching_perms = $this->aauth->get_matching_perms($permission);

            	// 		foreach($matching_perms as $perm)
            	// 		{
            	// 			$this->aauth->allow_user($inserted_id,$perm->id,$post_data['brand_id']);
            	// 		}
            	// 	}
            	// }
            	echo 'success';
        	}
		}
	}
}