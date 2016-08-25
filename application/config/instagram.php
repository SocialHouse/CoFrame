<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$ci = & get_instance();

$config['instagram_client_name'] 	= 'timeframe';
$config['instagram_client_id'] 		= '5006be098c904a438f637ae00a0b160b';
$config['instagram_client_secret'] 	= '6e6043e6a83f4147ac5a52ced062871e';
$config['instagram_callback_url'] 	= $ci->config->item('base_url')."instagram_connect/insta_callback";
$config['instagram_website'] 		= $ci->config->item('base_url');
$config['instagram_description'] 	= 'these for shearing and login';
$config['instagram_scope'] 			= '';
$config['instagram_ssl_verify']		= FALSE;


