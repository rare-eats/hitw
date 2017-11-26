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

        #Sorry, I couldnt figure out how to put both into the same statement.
        $data = [
            'first_name'	=> 'Foursquare',
            'last_name'		=> 'User',
            'password'		=> password_hash('nimad', PASSWORD_DEFAULT),
            'email'			=> 'foursquareuser@example.com',
            'permissions'	=> 'admin'
        ];
        $this->db->insert('users', $data);
	}

	public function down()
	{
		$this->db->where('email', 'overlord@example.com');
		$this->db->delete('users');

        $this->db->where('email', 'foursquareuser@example.com');
        $this->db->delete('users');
	}
}