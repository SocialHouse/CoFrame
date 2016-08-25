<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
* Local App Setting
*/

$ci = & get_instance();

$config['pinterest_callback_url'] = $ci->config->item('base_url').'pinterest_connect/pinterest_callback';

$config['pinterest_app_id'] = '4822853923106735580';
$config['pinterest_app_secret'] = 'b7c295f87014b544cc2621dfc63d81ad3383ce6aa07c7239f9fb9c3034733c2b';
/*
* Server App Setting
*/
$config['pinterest_app_id'] = '4822853923106735580';
$config['pinterest_app_secret'] = 'b7c295f87014b544cc2621dfc63d81ad3383ce6aa07c7239f9fb9c3034733c2b';
