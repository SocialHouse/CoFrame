<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->input->is_cli_request();
        $this->load->library('migration');
    }
    /* run the following command to execute the migration
        drive(c/d):\xampp\htdocs\rental_web\php index.php migrate
    */
    public function index() {
        if(!$this->migration->latest()) {
          show_error($this->migration->error_string());
        }else{
            echo "Migration created successfully.";
        }
    }
} 