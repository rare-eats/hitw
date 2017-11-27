<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_photos_fields extends CI_Migration {

	public function up()
	{
        // photos Table Setup
        $this->dbforge->add_field('id');
        $this->dbforge->create_table('photos');
        // End photos table setup

        //restaurant_photos Table Setup
        $this->dbforge->add_field('id');
        $this->dbforge->add_field('restaurant_id integer references restaurants(id)');
        $this->dbforge->add_field('photo_id integer references photos(id)');
        $this->dbforge->create_table('restaurant_photos');
        //end restaurant_photos table setup

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
        $this->dbforge->drop_table('restaurant_photos');
        $this->dbforge->drop_table('photos');
	}
}