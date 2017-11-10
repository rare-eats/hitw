<?php

class Users_model extends CI_Model {

    public function __construct()   {
        $this->load->database();
    }

    public function get_all_users() {
        // Retreiving everything currently
        $query = $this->db->get('users');
        if ($query !== False) {
            return $query->result_array();
        }
        else {
            return FALSE;
        }
    }

    public function create_user($data) {
        return $this->db->insert('users', $data);
    }

}