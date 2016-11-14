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
								'brands' => 15,
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
								'image_size' 	=> 15000000, 		//15 MB  ( = 15*10,45,504  byte )
								'video' 		=> 10000000, 		//05 MB  (5242880 byte= 5mb )
								'height'		=>'1200',
								'width' 		=>'1200'
							),
						'instagram' =>array(
								'image_size' 	=> 10000000, 		//10 MB  ( = 10*1000000  byte )
								'video' 		=> 1000000000, 			//05 MB  ( = 05*1000000  byte )
								'height'		=>'1080',
								'width' 		=>'1080'
							),
						'linkedin' => array(
								'image_size' 	=> 10000000, 		//10 MB  ( = 10*1000000  byte )
								'video' 		=> 10000000, 			//05 MB  ( = 05*1000000  byte )
								'height'		=>'1500',
								'width' 		=>'1500'
							),
						'pinterest' => array(
								'image_size' 	=> 10000000, 		//10 MB  ( = 10*1000000  byte )
								'video' 		=> 10000000, 			//05 MB  ( = 05*1000000  byte )
								'height'		=>'1080',
								'width' 		=>'1080'
							),
						'tumblr' => array(
								'image_size' 	=> 10000000, 		//10 MB  ( = 10*1000000 byte )
								'video' 		=> 10000000, 			//05 MB  ( = 05*1000000  byte )
								'height'		=>'1280',
								'width' 		=>'1290'
							),
						'twitter' => array(
								'image_size' 	=> 5000000, 		//5 MB  ( = 10*1000000  byte )
								'video' 		=> 10000000, 			//05 MB  ( = 05*1000000  byte )
								'height'		=>'1024',
								'width' 		=>'512'
							),
						'youtube' => array(
								'image_size' 	=> '1000000000', 				//10 MB  ( = 10*1000000  byte )
								'video' 		=> 10000000,				//05 MB  ( = 05*1000000  byte )
								'height'		=>'',
								'width' 		=>''
							)
					);

//On server it is set to TRUE and loacal it is set to FALSE
// FALSE 	:- It uses local App configuration. 
// TRUE 	:- It uses Sercer App configuration.

$config['enable_server_app'] = FALSE;

$config['zendesk_email'] = 'support@coframeapp.zendesk.com';
