<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_tags extends CI_Migration {

    public function up()
    {
        $data = [
            'Summer', 'Winter', 'Spring', 'Fall',
            'Lunch', 'Dinner', 'Brunch',
        ];

        $insert = [];

        for($i=0; $i<count($data); $i++) {
            $insert[$i]['name'] = $data[$i];
        }

        $this->db->insert_batch('tags', $insert);
    }

    public function down()
    {
        $this->db->where('email', 'foursquareuser@example.com');
        $this->db->delete('users');
    }
}