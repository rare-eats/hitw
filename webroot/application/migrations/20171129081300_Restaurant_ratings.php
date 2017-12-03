<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Restaurant_ratings extends CI_Migration {


	public function up()
	{
		$fields = [
			'upvotes' => [
				'type' 	=> 'NUMERIC',
				'null'	=>	TRUE,
				'default' => 0
			],
			'downvotes'=>[
				'type' => 'NUMERIC',
				'null' => TRUE,
				'default' => 0
			]
		];
		$this->dbforge->add_column('restaurants', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('restaurants', 'upvotes');
		$this->dbforge->drop_column('restaurants', 'downvotes');
	}
}
