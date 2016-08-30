<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Facebook App details
| -------------------------------------------------------------------
|
| To get an facebook app details you have to be a registered developer
| at http://developer.facebook.com and create an app for your project.
|
|  facebook_app_id               string   Your facebook app ID.
|  facebook_app_secret           string   Your facebook app secret.
|  facebook_login_type           string   Set login type. (web, js, canvas)
|  facebook_login_redirect_url   string   URL tor redirect back to after login. Do not include domain.
|  facebook_logout_redirect_url  string   URL tor redirect back to after login. Do not include domain.
|  facebook_permissions          array    The permissions you need.
|  facebook_graph_version        string   Set Facebook Graph version to be used. Eg v2.6
|  facebook_auth_on_load         boolean  Set to TRUE to have the library to check for valid access token on every page load.
*/

$ci = & get_instance();

if($ci->config->item('use_server_app'))
{
	// Server App Setting
	$config['facebook_app_id']              = '557299351140684';
	$config['facebook_app_secret']          = '0537ef639898feaf895cb2365de7b473';
}
else
{
	// Local App Setting
	$config['facebook_app_id']              = '1711815429100433';
	$config['facebook_app_secret']          = '270b6c6d8620a4d43375bbb96f98cc69';	
}

	$config['facebook_login_type']          = 'web';
	$config['facebook_login_redirect_url']  = 'facebook_connect/login';
	$config['facebook_logout_redirect_url'] = 'facebook_connect/reset_session';
	$config['facebook_permissions']         = array('public_profile', 'publish_actions', 'email','user_posts','read_insights','manage_pages','read_custom_friendlists','user_photos','user_videos','user_website');
	$config['facebook_graph_version']       = 'v2.5';
	$config['facebook_auth_on_load']        = TRUE;

