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
	$config['youtube_client_id'] = '265699630744-7i8p8849pnpdtiodj4hq6d4b90d7mlu2.apps.googleusercontent.com';
	$config['youtube_client_secret'] = 'ct0NZwsQnKlYlURciTXMj8Pu';
}

$config['redirect_uri'] = $ci->config->item('base_url')."youtube_connect/youtube_callback";

