<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ratings extends CI_Migration {


	public function up()
	{
		$fields = [
			'rating' => [
				'type' 	=> 'BOOL',
				'null'	=>	TRUE
			]
		];
		$this->dbforge->add_column('reviews', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('reviews', 'rating');
	}
}
