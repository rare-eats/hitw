<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_reviews extends CI_Migration {


	public function up()
	{
		$fields = [
			'body' => [
				'type' 	=> 'TEXT',
				'null'	=>	TRUE
			],
			'api_id'	=>	[
				'type'	=>	'VARCHAR',
				'constraint' => 24,
				'unique'=> TRUE,
				'null' 	=> TRUE
			],
			't_created'	=>	[
				'type'	=>	'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
			],
			't_modified'=>	[
				'type'	=>	'TIMESTAMP'
			]
		];
		$this->dbforge->add_column('reviews', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('reviews', 'body');
		$this->dbforge->drop_column('reviews', 'api_id');
		$this->dbforge->drop_column('reviews', 't_created');
		$this->dbforge->drop_column('reviews', 't_modified');
	}
}
