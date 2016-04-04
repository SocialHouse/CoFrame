<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//mail config settings
$config['smtp_config'] = array(
			            'protocol'  =>  'smtp',
			            'smtp_host' =>  'mail.techfivesystems.com',
			            'smtp_user' =>  'deepakb@techfivesystems.com',
			            'smtp_pass' =>  '5@eNg~$-a~nh',
			            'mailtype' =>  'html',
			            'wordwrap' => TRUE,
			            'charset' => 'iso-8859-1',
			            'mailpath' =>'/usr/sbin/sendmail'
			        );

$config['from_mail'] = 'deepakb@techfivesystems.com';