<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_restaurant_api_field extends CI_Migration {


	public function up()
	{
		$fields = array(
			'api_id' => array(
				'type' => 'VARCHAR',
				'constraint' => 24,
				'unique' => TRUE,
				'null' => TRUE
			)
		);
		$this->dbforge->add_column('restaurants', $fields);
		$this->dbforge->drop_column('restaurants', 'addr_2');
	}

	public function down()
	{
		$fields = array(
			'addr_2' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			)
		);

		$this->dbforge->add_column('restaurants', $fields);
		$this->dbforge->drop_column('restaurants', 'api_id');
	}
}