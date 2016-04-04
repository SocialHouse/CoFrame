<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Users extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 11,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'first_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'null'=> FALSE
                        ),
                        'last_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'null'=> FALSE
                        ),
	                    'email' => array(
	                                'type' => 'VARCHAR',
	                                'constraint' => '255',
	                                'null'=> FALSE
	                    ),
	                    'phone' => array(
	                                'type' => 'VARCHAR',
	                                'constraint' => '20',
	                                'null' => TRUE
	                    ),
	                    'timezone' => array(
	                                'type' => 'VARCHAR',
	                                'constraint' => '250',
	                                'null' => FALSE
	                    ),
                        'salt' => array(
                                'type' => 'VARCHAR',
                                'constraint'=> '255',
                                'null' => FALSE
                    	),
                    	'username' => array(
                                'type' => 'VARCHAR',
                                'constraint'=> '255',
                                'null' => FALSE
                    	),
                    	'password' => array(
                                'type' => 'VARCHAR',
                                'constraint'=> '255',
                                'null' => FALSE
                    	),
                    	'company_name' => array(
                                'type' => 'VARCHAR',
                                'constraint'=> '255',
                                'null' => FALSE
                    	),
                    	'company_email' => array(
                                'type' => 'VARCHAR',
                                'constraint'=> '255',
                                'null' => FALSE
                    	),
                    	'company_url' => array(
                                'type' => 'VARCHAR',
                                'constraint'=> '255',
                                'null' => FALSE
                    	),
                        'status' => array(
                            'type' => "ENUM('Active','Inactive')",
                            'default'=> 'Active',
                            'null' => FALSE
                    	),                 	
                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->add_field('created_at  DATETIME'); 
                $this->dbforge->add_field('updated_at TIMESTAMP');           		
                $this->dbforge->create_table('users');
        }

        public function down()
        {
                $this->dbforge->drop_table('users');
        }
}