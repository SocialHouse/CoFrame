<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'third_party/facebook-php-sdk/src/Facebook/autoload.php');
use Facebook\FacebookRequest;
// use Facebook\FacebookSession;

class Cron extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('user_model');
        // $this->load->model('timeframe_model');        
    }

    function index()
    {
        $fb = new Facebook\Facebook([
          'app_id' => '1711815429100433',
          'app_secret' => '270b6c6d8620a4d43375bbb96f98cc69',
          'default_graph_version' => 'v2.5',
        ]);

        $fb->setDefaultAccessToken('EAAYU4xaSk5EBAP8ZA5nT9vnYhVLWW3GZByRxGc5pCcUyLNRKbyuhiFCnCYx3DEyN3tbfHBY41CJBF2iCehtvge5dDua1j5iZCuLMY2TCfvzqNlZBWF14s50TZASTlRkB5rsD6yek9cshO695evUZAzXD4TpZAmu0pZCWzbYSRaExkZBauUzkq1LBT');

        $linkData = [
          'link' => 'http://www.example.com',
          'message' => 'User provided message',
          ];

         $response = $fb->post('/318999534866425/feed', $linkData, 'EAAYU4xaSk5EBANPBLRxcZCy7JIvb0nk2x2dJEQb3Rjuzx9EEEcGT9ADgT5lJbjnrD5wYnIZAYYuV0ivF9o6V5esNynN27temZBoC6bjvy6lHOTViCcU0KGEtAZAASpRxtQmWljERIZB7WroheEdBHGgHwHeZCxSTT2Sbnz37Dqk4ZAkKRKCxSYbX3KzrT62ZAHsZD');

         print_r($response);
         die;
    }

}