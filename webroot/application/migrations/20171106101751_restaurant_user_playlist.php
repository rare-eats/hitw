<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_restaurant_user_playlist extends CI_Migration {


	public function up()
	{
		$fields = array(
			'private' => array(
				'type' => 'BOOLEAN',
				'default' => 'TRUE'
			),
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
		// Alter user_playlist Table to fit specifications
		$this->dbforge->add_column('user_playlists', $fields);
				// Auto-generated from creation time
		$this->dbforge->add_column('user_playlists', 't_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
		// Resets to current_timestamp on update
		$this->dbforge->add_column('user_playlists', 't_modified TIMESTAMP');
	}

	public function down()
	{
		$this->dbforge->drop_column('user_playlists', 'private');
		$this->dbforge->drop_column('user_playlists', 'title');
		$this->dbforge->drop_column('user_playlists', 'desc');
		$this->dbforge->drop_column('user_playlists', 't_created');
		$this->dbforge->drop_column('user_playlists', 't_modified');
	}
}