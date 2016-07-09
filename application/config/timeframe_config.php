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