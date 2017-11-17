<?php
class Userplaylists extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('userplaylists_model');
		$this->load->helper('url_helper');
	}

	public function view($id = NULL) {
		if ($id === NULL) {
			$data['title'] = "Playlists";
			$data['playlists'] = $this->userplaylists_model->get_playlist();

			$this->load->view('partials/header', $data);
			$this->load->view('userplaylists/view_all', $data);
			$this->load->view('partials/footer');
		}
		else{
			$data['playlist'] = $this->userplaylists_model->get_playlist($id);

			if (empty($data['playlist'])) {
				show_404();
			}
			
			$this->load->model('users_model');
			$author = ($this->users_model->get_user($data['playlist']['author_id']))[0];
			$data['author_name'] = $author['first_name'] . ' ' . $author['last_name'];
			$data['author_id'] = $author['id'];

			$this->load->view('partials/header', $data);
			$this->load->view('userplaylists/view', $data);
			$this->load->view('partials/footer');
		}
	}

	public function create() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('restaurants_model');

		$data['title'] = 'Add New Playlist';
		$data['restaurants'] = $this->restaurants_model->get_restaurant();

		$this->form_validation->set_rules('title', 'Playlist Name', 'required');
		$this->form_validation->set_rules('desc', 'Description', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('partials/header', $data);
			$this->load->view('userplaylists/create', $data);
			$this->load->view('partials/footer');
		}
		else 
		{
			$query = $this->userplaylists_model->set_playlist();

			redirect('/userplaylists/'.$query);
		}
	}

	public function edit($id = NULL) {
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['playlist'] = $this->userplaylists_model->get_playlist($id);

		if (empty($data['playlist'])) {
			show_404();
		}

		$data['title'] = 'Edit Playlist';

		$this->form_validation->set_rules('title', 'Playlist Name', 'required');
		$this->form_validation->set_rules('desc', 'Description', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('partials/header', $data);
			$this->load->view('userplaylists/edit', $data);
			$this->load->view('partials/footer');
		}
		else 
		{
			$this->userplaylists_model->set_playlist($id);
			redirect('/userplaylists/'.$playlist['id']);
		}
	}

	public function delete($id = NULL) {
		if (empty($id)) {
			show_404();
		}

		# Check for proper authentication first
		$this->userplaylists_model->delete_playlist($id);
		redirect(base_url());
	}
}