<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$ci = & get_instance();

if($ci->config->item('enable_server_app'))
{
	// Server App Setting
	$config['instagram_client_name'] 	= 'timeframe';
	$config['instagram_client_id']      = '5006be098c904a438f637ae00a0b160b';
	$config['instagram_client_secret']  = '6e6043e6a83f4147ac5a52ced062871e';
}
else
{
	// Local App Setting
	$config['instagram_client_name'] 	= 'timeframe';
	$config['instagram_client_id'] 		= '991636185b5340d98f2967242153d97e';
	$config['instagram_client_secret'] 	= '99c81859edb74c5994a085c492e24962';	
}
	$config['instagram_callback_url'] 	= $ci->config->item('base_url')."instagram_connect/insta_callback";
	$config['instagram_website'] 		= $ci->config->item('base_url');
	$config['instagram_description'] 	= 'these for shearing and login';
	$config['instagram_scope'] 			= '';
	$config['instagram_ssl_verify']		= FALSE;




