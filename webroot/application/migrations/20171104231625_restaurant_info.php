<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_restaurant_info extends CI_Migration {


	public function up()
	{
		$fields = array(
			// Optional
			'restaurant_type' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'rating' => array(
				'type' => 'NUMERIC',
				'null' => TRUE
			),
			// Optional
			'addr_1' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			// Optional
			'addr_2' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'city' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			// Optional if country doesn't use the 2-digit state code
			'state_prov_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE
			),
			'country' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			)
		);
		// Alter restaurants Table to fit specifications
		$this->dbforge->add_column('restaurants', $fields);
		// Auto-generated from creation time
		$this->dbforge->add_column('restaurants', 't_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
		// Resets to current_timestamp on update
		$this->dbforge->add_column('restaurants', 't_modified TIMESTAMP');
	}

	public function down()
	{
		$this->dbforge->drop_column('restaurants', 'restaurant_type');
		$this->dbforge->drop_column('restaurants', 'name');
		$this->dbforge->drop_column('restaurants', 'rating');
		$this->dbforge->drop_column('restaurants', 'addr_1');
		$this->dbforge->drop_column('restaurants', 'addr_2');
		$this->dbforge->drop_column('restaurants', 'city');
		$this->dbforge->drop_column('restaurants', 'state_prov_code');
		$this->dbforge->drop_column('restaurants', 'country');
		$this->dbforge->drop_column('restaurants', 't_created');
		$this->dbforge->drop_column('restaurants', 't_modified');
	}
}