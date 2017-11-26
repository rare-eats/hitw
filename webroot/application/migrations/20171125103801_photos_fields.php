<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_photos_fields extends CI_Migration {


	public function up()
	{
		$fields = array(
            'api_id' => array(
                'type' => 'VARCHAR',
                'constraint' => 24,
                'unique' => FALSE,
                'null' => TRUE
            ),
            'image_url' => array(
                'type' => 'VARCHAR',
                'constraint' => 150,
                'unique' => FALSE,
                'null' => TRUE
            ),
            'restaurant_id' => array(
                'type'=> 'VARCHAR',
                'constraint' => 24,
                'unique' => FALSE,
                'null' => TRUE
            )
		);
		$this->dbforge->add_column('photos', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('photos', 'api_id');
        $this->dbforge->drop_column('photos', 'image_url');
        $this->dbforge->drop_column('photos', 'restaurant_id');
	}
}