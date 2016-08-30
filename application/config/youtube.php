<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$ci = & get_instance();

if($ci->config->item('enable_server_app'))
{
	// Server App setting
	$config['youtube_client_id'] = '914837030152-u3ja0c3db5tlpucn44e0gv02ultjmsoc.apps.googleusercontent.com';
	$config['youtube_client_secret'] = 'ZiiE3FGZ8gsWsR_svPnfTvJu';	
}
else
{
	// Local App setting
	$config['youtube_client_id'] = '495277179424-i6ekqt1hqur10r1iq2th91tl80es69at.apps.googleusercontent.com';
	$config['youtube_client_secret'] = 'Osp3L21dglv4XKya5kxeHQsQ';
}

$config['redirect_uri'] = $ci->config->item('base_url')."youtube_connect/youtube_callback";

