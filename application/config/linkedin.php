<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$ci = & get_instance();

$config['linked_in_api_key'] = "75jgbgpc3aqcn7";
$config['linked_in_secret_key'] = "tUBnhalkTgC3GDeL";

$config['linked_in_callback_url'] =  $ci->config->item('base_url')."linkedin_connect/callback";

$config['response_type'] = "LINKEDIN::_RESPONSE_JSON";
