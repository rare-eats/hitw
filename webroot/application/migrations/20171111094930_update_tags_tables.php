<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_update_tags_tables extends CI_Migration {

	public function up()
	{
		// Alter tags table to add a name column
		$fields = array(
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255
			),
            'api_id' => array(
                'type' => 'VARCHAR',
                'constraint' => 24,
                'unique' => TRUE,
                'null' => TRUE
            )
		);
		$this->dbforge->add_column('tags', $fields);
	}

	public function down()
	{
		// Remove the name column from tags
		$this->dbforge->drop_column('tags', 'name');
	}
}