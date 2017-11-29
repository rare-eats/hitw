<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_restaurant_auto_playlist extends CI_Migration {


    public function up()
    {
        $fields = array(
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'desc' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            )
        );
        // Alter auto_playlist Table to fit specifications
        $this->dbforge->add_column('auto_playlists', $fields);
        // Auto-generated from creation time
        $this->dbforge->add_column('auto_playlists', 't_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
        // Resets to current_timestamp on update
        $this->dbforge->add_column('auto_playlists', 't_modified TIMESTAMP');
    }

    public function down()
    {
        $this->dbforge->drop_column('auto_playlists', 'title');
        $this->dbforge->drop_column('auto_playlists', 'desc');
        $this->dbforge->drop_column('auto_playlists', 't_created');
        $this->dbforge->drop_column('auto_playlists', 't_modified');
    }
}