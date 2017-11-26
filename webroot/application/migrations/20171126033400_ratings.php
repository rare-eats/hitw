<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_reviews extends CI_Migration {


	public function up()
	{
		$this->dbforge->add_field('rating');
		$this->dbforge->add_field('restaurant_id integer references restaurants (id)');
		$this->dbforge->add_field('author_id integer references users (id)');
		$this->dbforge->create_table('ratings');
	}

	public function down()
	{
		$this->dbforge->drop_table("ratings");
	}
}
