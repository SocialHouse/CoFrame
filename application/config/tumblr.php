<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$ci = & get_instance();
if($ci->config->item('enable_server_app'))
{
	// Server App Setting
	$config['tumblr_consumer_key']			= 'KgKmMXItUtiA9b7SJY1K6H3vBeUbBHScGl01TwCXFebP5arVUO';
	$config['tumblr_secret_key']			= '61sqolLktTYpVsSyQCafuCDIybEE2oZsgGkmLgBgaUw65wtqih';
	$config['tumblr_url']					= 'ninadtechfive.tumblr.com';
}
else
{
	// Local App Setting
	$config['tumblr_consumer_key']			= 'KgKmMXItUtiA9b7SJY1K6H3vBeUbBHScGl01TwCXFebP5arVUO';
	$config['tumblr_secret_key']			= '61sqolLktTYpVsSyQCafuCDIybEE2oZsgGkmLgBgaUw65wtqih';
	$config['tumblr_url']					= 'ninadtechfive.tumblr.com';
}

$config['callback_url']					= $ci->config->item('base_url').'tumblr_connect/tumblr_callback';
$config['auth_callback']				= $ci->config->item('base_url').'tumblr_connect/tumblr_callback';

$config['callback_url_post']			= $ci->config->item('base_url').'tumblr_connect/tumblr_callback';
$config['auth_callback_post']			= $ci->config->item('base_url').'tumblr_connect/tumblr_callback';