<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'english';

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
|
| If you would like to use the 'hooks' feature you must enable it by
| setting this variable to TRUE (boolean).  See the user guide for details.
|
*/
$config['enable_hooks'] = FALSE;

/*
|--------------------------------------------------------------------------
| Enable/Disable Json Compile 
|--------------------------------------------------------------------------
|
| when you want to compile set true  or update messages
| By default this variable to FALSE (boolean).
|
*/

$config['compile_json_message_js'] = true; 	//when you want to compile set true  or update messages
$config['json_msg_file'] = 'assets/js/json_message.json';

$config['plans'] = array(
						'premiere' => array(
								'brands' => 15,
								'master_admins' => 70,
								'users' => 70,
								'outlets' => 8,
								'real_time_notification' => 1,
								'email_notification' => 1,
								'co_create' => 1,
								'tags' => 'unlimited',
								'phase_approvals' => 1
							),
						'corporate' => array(
								'brands' => 8,
								'master_admins' => 35,
								'users' => 35,
								'outlets' => 8,
								'real_time_notification' => 1,
								'email_notification' => 0,
								'co_create' => 1,
								'tags' => 15,
								'phase_approvals' => 1
							),
						'business' => array(
								'brands' => 3,
								'master_admins' => 2,
								'users' => 12,
								'outlets' => 5,
								'real_time_notification' => 1,
								'email_notification' => 0,
								'co_create' => 0,
								'tags' => 8,
								'phase_approvals' => 1
							),
						'start-up' => array(
								'brands' => 1,
								'master_admins' => 1,
								'users' => 3,
								'outlets' => 3,
								'real_time_notification' => 1,
								'email_notification' => 0,
								'co_create' => 0,
								'tags' => 3,
								'phase_approvals' => 0
							)
					);

$config['upload_limit'] = array(
						'facebook' =>array(
								'image_size' => 3000000, 		//03 MB  ( = 03*1000000  byte )
								'video' => 5000000, 			//05 MB  ( = 05*1000000  byte )
								'height'=>'',
								'width' =>''
							),
						'instagram' =>array(
								'image_size' => 5000000, 		//05 MB  ( = 05*1000000  byte )
								'video' => 5000000 			//05 MB  ( = 05*1000000  byte )
								'height'=>'',
								'width' =>''
							),
						'linkedin' => array(
								'image_size' => 3000000, 		//03 MB  ( = 03*1000000  byte )
								'video' => 5000000 			//05 MB  ( = 05*1000000  byte )
								'height'=>'',
								'width' =>''
							),
						'pinterest' => array(
								'image_size' => 5000000, 		//05 MB  ( = 05*1000000  byte )
								'video' => 5000000 			//05 MB  ( = 05*1000000  byte )
								'height'=>'',
								'width' =>''
							),
						'tumblr' => array(
								'image_size' => 10000000, 		//10 MB  ( = 10*1000000 byte )
								'video' => 5000000 			//05 MB  ( = 05*1000000  byte )
								'height'=>'',
								'width' =>''
							),
						'twitter' => array(
								'image_size' => 5000000, 		//05 MB  ( = 05*1000000  byte )
								'video' => 5000000 			//05 MB  ( = 05*1000000  byte )
								'height'=>'',
								'width' =>''
							),
						'youtube' => array(
								'image' => 5000000, 		//05 MB  ( = 05*1000000  byte )
								'video' => 5000000 			//05 MB  ( = 05*1000000  byte )
								'height'=>'',
								'width' =>''
							)
					);
