1. In database.php configuration file add database settings
2. Add following settings in application/config/stripe.php

$config['test_secret_key'] = '';
$config['test_public_key'] = '';
$config['live_secret_key'] = '';
$config['live_public_key'] = '';
$config['stripe_test_mode'] = TRUE;
$config['stripe_verify_ssl'] = FALSE;

and in assets/js/timeframe.js
Stripe.setPublishableKey('');

add test public key in quotes


3. Add following mail settings in application/config/mail.php

$config['smtp_config'] = array(
			            'protocol'  =>  '',
			            'smtp_host' =>  '',
			            'smtp_user' =>  '',
			            'smtp_pass' =>  '',
			            'mailtype' =>  '',
			            'wordwrap' => TRUE,
			            'charset' => '',
			            'mailpath' =>''
			        );

$config['from_mail'] = '';

4. Sql scema is added in "sql" folder