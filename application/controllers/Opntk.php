<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
use OpenTok\OpenTok;

class Opntk extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->config('opentok');
	}

	public function opentok()
    {
        $opentok = new OpenTok($this->config->item('opentok_key'), $this->config->item('opentok_secret'));
        $session = $opentok->createSession();
        $data = array(
            'sessionId' => $session->getSessionId(),
            'token' => $session->generateToken()
        );
        $this->load->view('opentok/opentok', $data);
    }
}

