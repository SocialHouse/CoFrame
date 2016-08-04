<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 * @property Login_control $Login_control
 * @property Aauth $aauth Description
 * @version 1.0
 */
class Example extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        // $this->load->library("Aauth");
    }

    public function index() {
        $this->aauth->create_user('admin@admin.com','12345','admin');
        $this->aauth->create_user('manager@manager.com','12345','manager');
        $this->aauth->create_user('creator@creator.com','12345','creator');
        $this->aauth->create_user('approver@approver.com','12345','approver');
        $this->aauth->create_user('analyst@analyst.com','12345','analyst');
        $this->aauth->create_user('billing@billing.com','12345','billing');
        // if ($this->aauth->login('admin1', '12345'))
        //     echo 'tmm';
        // else
        //     echo 'hyr';

        // echo $this->aauth->generate_recaptcha_field();
        // $this->aauth->print_errors();
    }

    public function logout() {

        $this->aauth->logout();
    }

    function create() {
        $a = $this->aauth->create_group("Master Admin");
        $a = $this->aauth->create_group("Manager");
        $a = $this->aauth->create_group("Creator");
        $a = $this->aauth->create_group("Approver");
        $a = $this->aauth->create_group("Billing");

        $a = $this->aauth->create_perm("create","Create new post drafts");
        $a = $this->aauth->create_perm("edit","Edit posts");
        $a = $this->aauth->create_perm("approve","Approve posts");
        $a = $this->aauth->create_perm("view","View posts");
        $a = $this->aauth->create_perm("settings","Edit application settings");
        $a = $this->aauth->create_perm("billing","View billing data");

         $a = $this->aauth->create_perm("master","All access");


        $a = $this->aauth->allow_group("Admin","create");
        $a = $this->aauth->allow_group("Admin","edit"); 
        $a = $this->aauth->allow_group("Admin","approve");
        $a = $this->aauth->allow_group("Admin","view");
        $a = $this->aauth->allow_group("Admin","settings");
        $a = $this->aauth->allow_group("Admin","billing");
        $a = $this->aauth->allow_group("Admin","master");
        $a = $this->aauth->allow_group("Manager","create");
        $a = $this->aauth->allow_group("Manager","edit");
        $a = $this->aauth->allow_group("Manager","approve");
        $a = $this->aauth->allow_group("Manager","view");
        $a = $this->aauth->allow_group("Manager","settings");
        $a = $this->aauth->allow_group("Creator","create");
        $a = $this->aauth->allow_group("Creator","edit");
        $a = $this->aauth->allow_group("Creator","view");
        $a = $this->aauth->allow_group("Approver","approve");
        $a = $this->aauth->allow_group("Billing","billing");
    }

    function delete()
    {
        $a = $this->aauth->delete_group("Admin");
        $a = $this->aauth->delete_group("Manager");
        $a = $this->aauth->delete_group("Creator");
        $a = $this->aauth->delete_group("Approver");
        $a = $this->aauth->delete_group("Analyst");
        $a = $this->aauth->delete_group("Billing");

        // $a = $this->aauth->delete_perm("Create","Create");
        // $a = $this->aauth->delete_perm("Edit","Edit");
        // $a = $this->aauth->delete_perm("Approve","Approve");
        // $a = $this->aauth->delete_perm("View Content","View Content");
        // $a = $this->aauth->delete_perm("Settings","Settings");
        // $a = $this->aauth->delete_perm("Analytics","Analytics");
        // $a = $this->aauth->delete_perm("Billing","Billing");


        $a = $this->aauth->delete_perm("create.post","Create new post drafts");
        $a = $this->aauth->delete_perm("create.slate_post","Slate posts");
        $a = $this->aauth->delete_perm("create.schedule_post","Schedule posts");
        $a = $this->aauth->delete_perm("create.submit_post","Submit posts");
        $a = $this->aauth->delete_perm("create.co_create","Co-create interaction");

        $a = $this->aauth->delete_perm("edit.post","Edit posts");
        $a = $this->aauth->delete_perm("edit.co_create","Co-create interaction");
        $a = $this->aauth->delete_perm("edit.overview","Overview");

        $a = $this->aauth->delete_perm("approve.approve_post","Approve posts");
        $a = $this->aauth->delete_perm("approve.retract_approve_post","Retract approval of posts");
        $a = $this->aauth->delete_perm("approve.co_create","Co-create interaction");
        $a = $this->aauth->delete_perm("approve.overview","Overview");

        $a = $this->aauth->delete_perm("view.view_posts","View posts");
        $a = $this->aauth->delete_perm("view.view_calendar","View Calendar");

        $a = $this->aauth->delete_perm("settings.edit_app_setting","Edit application settings");
        $a = $this->aauth->delete_perm("settings.edit_brand_setting","Edit brand settings");

        $a = $this->aauth->delete_perm("analytics.view_analytics","View analytics");
        $a = $this->aauth->delete_perm("billing.billing","View billing data");

        $a = $this->aauth->delete_perm("master","All access");
    }

    function update_group_perm()
    {
        $a = $this->aauth->create_perm("master","All access");
        $a = $this->aauth->allow_group("Admin","master");
    }

    function add_group()
    {
        $this->aauth->add_member(2, 'Admin');
        $this->aauth->add_member(3, 'Manager');
        $this->aauth->add_member(4, 'Creator');
        $this->aauth->add_member(5, 'Approver');
        $this->aauth->add_member(6, 'Analyst');
        $this->aauth->add_member(7, 'Billing');
    }
    
    function is_group_allowed()
    {
        echo $a = $this->aauth->is_group_allowed('Create','Admin');
    }

    function generate_recaptcha_field()
    {
        echo $this->aauth->generate_recaptcha_field();
    }

    function create_user()
    {
        $a = $this->aauth->create_user("ninadg@techfivesystems.com", "12345", "ninadg");
    }

}//end

/* End of file welcome.php */
