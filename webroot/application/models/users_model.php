<?php

class Users_model extends CI_Model {

    public function __construct()   {
        $this->load->database();
    }

    public function get_all_users() {
        $query = $this->db->get('users');
        if ($query !== False) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function remove_user($id) {
        $this->db->delete('users', ['id' => $id]);
    }

    public function get_user($id) {
        $query = $this->db->get_where('users', ['id' => $id]);
        if ($query !== False) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function create_user($data) {
        $this->db->insert('users', $data);

        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function edit_user($id, $data) {
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('users', $data);
        }
    }

    public function get_first_name($id) {
        $this->db->select('first_name');
        $query = $this->db->get_where('users', ['id' => $id]);
        if ($query !== False) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function is_admin() {
        if ($this->session->userdata('permissions') === 'admin') {
            return True;
        }
        return False;
    }

    public function get_users_by_email($email) {
        $this->db->select('first_name, last_name, email');
        $query = $this->db->get_where('users', ['email' => $email]);
        if ($query !== False) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('users');

        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key,$value);
            }
        }

        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            $query = $this->db->get();
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $query->num_rows();
            }elseif(array_key_exists("returnType",$params) && $params['returnType'] == 'single'){
                $result = ($query->num_rows() > 0)?$query->row_array():FALSE;
            }else{
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }

        //return fetched data
        return $result;
    }
}