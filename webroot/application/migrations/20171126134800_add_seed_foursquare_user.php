<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_seed_foursquare_user extends CI_Migration {

	public function up()
	{
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
        $this->db->where('email', 'foursquareuser@example.com');
        $this->db->delete('users');
	}
}