<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_reviews extends CI_Migration {


	public function up()
	{
		$fields = array(
			'restaurant_id' => array(
				'type' => 'NUMERIC',
			),
			'user_id' => array(
				'type' => 'NUMERIC',
			),
			'body' => array(
				'type' => 'TEXT',
				'constraint' => 1000,
			),
		);
		// Alter restaurants Table to fit specifications
		$this->dbforge->add_column('reviews',$fields);
		// Auto-generated from creation time
		$this->dbforge->add_column('reviews', 't_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
		// Resets to current_timestamp on update
		$this->dbforge->add_column('reviews', 't_modified TIMESTAMP');
	}

	public function down()
	{
		$this->dbforge->drop_column('user_id');
		$this->dbforge->drop_column('restaurant_id');
		$this->dbforge->drop_column('body', 't_modified');
	}
}
