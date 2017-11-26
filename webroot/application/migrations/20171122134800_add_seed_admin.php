<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_seed_admin extends CI_Migration {

	public function up()
	{
		$data = [
			'first_name'	=> 'Overlord',
			'last_name'		=> 'Admin',
			'password'		=> password_hash('admin', PASSWORD_DEFAULT),
			'email'			=> 'overlord@example.com',
			'permissions'	=> 'admin'
		];
		$this->db->insert('users', $data);
	}

	public function down()
	{
		$this->db->where('email', 'overlord@example.com');
		$this->db->delete('users');
	}
}