<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_reviews extends CI_Migration {


	public function up()
	{
		$fields = array(
			'body' => array(
				'type' => 'VARCHAR',
				'default' => 'TRUE'
			)
		);
		$this->dbforge->add_column('reviews', $fields);
				// Auto-generated from creation time
		$this->dbforge->add_column('reviews', 't_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
		// Resets to current_timestamp on update
		$this->dbforge->add_column('reviews', 't_modified TIMESTAMP');
	}

	public function down()
	{
		$this->dbforge->drop_column('reviews', 'restaurant_id');
		$this->dbforge->drop_column('reviews', 'author_id');
		$this->dbforge->drop_column('reviews', 'body');
		$this->dbforge->drop_column('reviews', 't_created');
		$this->dbforge->drop_column('reviews', 't_modified');
	}
}
