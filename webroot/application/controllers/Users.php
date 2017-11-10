<?php
class Users extends CI_Controller {

    public function view() {
        $users = $this->users_model->get_all_users();
        // var_dump($users);
        // $data['first_name'] = $users['first_name'];
        // $data['last_name'] = $users['last_name'];
        $this->load->view('partials/header');
        $this->load->view('users_view', $users[0]);
        $this->load->view('partials/footer');

    }

    public function create() {
        $this->load->helper('form');

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');



        $first_name = [
            'name'          => 'first_name',
            'type'          => 'text',
            'class'         => 'form-control',
            'placeholder'   => 'First Name'
        ];

        $last_name = [
            'name'          => 'last_name',
            'type'          => 'text',
            'class'         => 'form-control',
            'placeholder'   => 'Last Name'
        ];

        $password = [
            'name'          => 'password',
            'type'          => 'password',
            'class'         => 'form-control',
            'placeholder'   => 'password'
        ];

        $email = [
            'name'          => 'email',
            'type'          => 'email',
            'class'         => 'form-control',
            'placeholder'   => 'email'
        ];

        $data = [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'password'   => $password
        ];

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');



        if ($this->form_validation->run() == FALSE) {
            $this->load->view('partials/header');
            $this->load->view('users_create', $data);
            $this->load->view('partials/footer');
        } else {

            $save_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'email'      => $this->input->post('email'),
                'password'   => $this->input->post('password')
            ];

            $this->users_model->create_user($save_data);
            $this->load->view('users_view');

        }

    }

}