<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$ci = & get_instance();

if($ci->config->item('enable_server_app'))
{
	// Server App Setting
	$config['twitter_consumer_token'] = 'RPxLUIE5akk6ZLtXEzfFUs7ay';
	$config['twitter_consumer_secret'] = 'DCpSTBz9sjw4OpRfWqScKRI5ROAJ9P7Dk4cWlTLwCVP3hdEP1O';
}
else
{
	// Local App Setting
	$config['twitter_consumer_token'] = 'jDgEtAcZtZQ9sqZXIMXzS9SrF';
	$config['twitter_consumer_secret'] = 'n5miugAviOKQYTAOtpNQBIA2zsNOnsVexYoeBEDVdARLUF580F';	
}


