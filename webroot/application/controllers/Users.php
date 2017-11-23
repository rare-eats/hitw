<?php
class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper(['form', 'url']);
        $this->load->model('userplaylists_model');

        $this->load->library('form_validation');
    }

    public function search() {

        $title['title'] = 'Search Results';

        $results = $this->input->post('search');
        $return = [];
        if ($results) {
            $return['users'] = $this->users_model->get_users_by_email($results);
        }

        $this->load->view('partials/header', $title);
        $this->load->view('users/search', $return);
        $this->load->view('partials/footer');
    }

    public function index() {
        // Need to figure out pagination. Not a good idea to list
        // all users
        $title['title'] = 'List';

        $data = [];
        $data['users'] = $this->users_model->get_all_users();
        $this->load->view('partials/header', $title);
        $this->load->view('users/index', $data);
        $this->load->view('partials/footer');
    }

    public function view() {

        $id = $this->session->id;
        $title['title'] = 'View My Profile';

        $user = $this->users_model->get_user($id);
        $data['playlists'] = $this->userplaylists_model->get_by_author($id);

        if ($user) {
            $data['user'] = $user[0];
        }
        $this->load->view('partials/header', $title);
        $this->load->view('users/view', $data);
        $this->load->view('partials/footer');

    }

    public function create() {

        $title['title'] = 'Create your Account';

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

        $email = [
            'name'          => 'email',
            'type'          => 'email',
            'class'         => 'form-control',
            'placeholder'   => 'Email'
        ];

        $password = [
            'name'          => 'password',
            'type'          => 'password',
            'minlength'     => '10',
            'class'         => 'form-control',
            'placeholder'   => 'Password'
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

            $this->load->view('partials/header', $title);
            $this->load->view('users/create', $data);
            $this->load->view('partials/footer');

        } else {
            if ($this->users_model->get_users_by_email($this->input->post('email'))) {
                $data['error_msg'] = "An account with this email already exists";
            } else {
                $save_data = [
                    'first_name' => $this->input->post('first_name'),
                    'last_name'  => $this->input->post('last_name'),
                    'password'   => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'email'      => $this->input->post('email'),
                    'permissions' => 'user'
                ];

                $id = $this->users_model->create_user($save_data);
                //Figure out a way to confirm to users their account has been created
                //without duplicating the view or
                if ($id) {
                    $this->session->set_userdata(
                        'success_msg',
                        'Welcome! Your account has been successfully created! Login here'
                    );
                    redirect('users/login');
                } else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }

            $this->load->view('partials/header', $title);
            $this->load->view('users/create', $data);
            $this->load->view('partials/footer');
        }

    }

    public function edit($id = null) {

        $title['title'] = 'Edit Profile';

        if ($id === null) {
            echo "no id";
        }

        $users = $this->users_model->get_user($id);

        $id = $users[0]['id'];

        $first_name = [
            'name'      => 'first_name',
            'type'      => 'text',
            'class'     => 'form-control',
            'value'     => $users[0]['first_name']
        ];

        $last_name = [
            'name'      => 'last_name',
            'type'      => 'text',
            'class'     => 'form-control',
            'value'     => $users[0]['last_name']
        ];

        $email = [
            'name'      => 'email',
            'type'      => 'email',
            'class'     => 'form-control',
            'value'     => $users[0]['email']
        ];

        $data = [
            'id'         => $users[0]['id'],
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email
        ];

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

        if ($this->form_validation->run() === FALSE) {

            $this->load->view('partials/header', $title);
            $this->load->view('users/edit', $data);
            $this->load->view('partials/footer');

        } else {

            $save_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'email'      => $this->input->post('email'),
            ];

            $this->users_model->edit_user($id ,$save_data);
            redirect('users/view/'.$id);

        }
    }

    public function login(){

        $title['title'] = 'Login';

        $data = [];

        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }
        if($this->input->post('loginSubmit')) {

            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');

            if ($this->form_validation->run() === True) {
                $con['returnType'] = 'single';
                $con['conditions'] = [
                    'email'      => $this->input->post('email')
                ];
                $checkLogin = $this->users_model->getRows($con);
                if($checkLogin) {
                    if (password_verify($this->input->post('password'), $checkLogin['password'])) {
                        $this->session->set_userdata('isUserLoggedIn',TRUE);
                        $this->session->set_userdata('id', $checkLogin['id']);
                        redirect();
                    } else {
                         $data['error_msg'] = 'Wrong email or password, please try again.';
                    }
                } else {
                    $data['error_msg'] = 'Wrong email or password, please try again.';
                }
            }
        }
        //load the view
        $this->load->view('partials/header', $title);
        $this->load->view('users/login', $data);
        $this->load->view('partials/footer');
    }

    public function logout(){

        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('id');
        $this->session->sess_destroy();
        redirect();
    }

    // Delete a user and all its private playlists
    // Set public playlists to a an author called "Deleted"
    public function delete($id = null) {

        if ($id === null) {
            redirect();
        }

        $playlists = $this->userplaylists_model->get_by_author($id);
        // this is terrible. Write a function that batch sets it instead
        // of accessing the database every iteration
        foreach ($playlists as $playlist) {
            if (!$playlist['private']) {
                $playlist['author_id'] = 4;
                $this->userplaylists_model->update_playlist($playlist['id'], $playlist);
            } else {
                $this->userplaylists_model->delete_playlist($playlist['id']);
            }
        }

        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('id');
        $this->session->sess_destroy();
        $this->users_model->remove_user($id);
        redirect();

    }

}