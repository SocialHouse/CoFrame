<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$ci = & get_instance();

if($ci->config->item('use_server_app'))
{
	// Server App Setting
	$config['twitter_consumer_token'] = 'Sg5NZKx6DQOB8biYBSybBn8vA';
	$config['twitter_consumer_secret'] = '6JPOar8w3Zm6DmT1WcnrKJKrXpkc5rOntygqUcu4C34Rnl5xOd';
}
else
{
	// Local App Setting
	$config['twitter_consumer_token'] = 'jDgEtAcZtZQ9sqZXIMXzS9SrF';
	$config['twitter_consumer_secret'] = 'n5miugAviOKQYTAOtpNQBIA2zsNOnsVexYoeBEDVdARLUF580F';	
}


