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
								'brands' => 'unlimited',
								'master_admins' => 'unlimited',
								'users' => 'unlimited',
								'outlets' => 8,
								'real_time_notification' => 1,
								'email_notification' => 1,
								'co_create' => 1,
								'tags' => 'unlimited',
								'phase_approvers' => 1
							),
						'corporate' => array(
								'brands' => 8,
								'master_admins' => 'unlimited',
								'users' => 35,
								'outlets' => 'unlimited',
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
								'phase_approvers' => 1
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
								'phase_approvers' => 0
							)
					);