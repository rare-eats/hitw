<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_user extends CI_Migration {


    public function up()
    {
        $fields = array(
            // Optional
            'first_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'last_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'permissions' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ),
        );
        // Alter restaurants Table to fit specifications
        $this->dbforge->add_column('users', $fields);
        // Auto-generated from creation time
        $this->dbforge->add_column('users', 't_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
        // Resets to current_timestamp on update
        $this->dbforge->add_column('users', 't_modified TIMESTAMP');
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'first_name');
        $this->dbforge->drop_column('users', 'last_name');
        $this->dbforge->drop_column('users', 'rating');
        $this->dbforge->drop_column('users', 'email');
        $this->dbforge->drop_column('users', 'password');
        $this->dbforge->drop_column('users', 'restaurant_list');
        $this->dbforge->drop_column('users', 'permissions');
    }
}