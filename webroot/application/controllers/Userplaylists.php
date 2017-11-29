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
			$data['user_id'] = $this->session->id;
			
			$this->load->model('users_model');
			$playlists = $this->userplaylists_model->get_playlist();
			foreach ($playlists as $playlist){
				$author = ($this->users_model->get_user($playlist['author_id']))[0];
				$playlist['author_name'] = $author['first_name'] . ' ' . $author['last_name'];
				$data['playlists'][] = $playlist;
			}
			$this->load->view('partials/header', $data);
			$this->load->view('userplaylists/view_all', $data);
			$this->load->view('partials/footer');
		}
		else{
			$data['playlist'] = $this->userplaylists_model->get_playlist($id);

			if (empty($data['playlist'])) {
				show_404();
			}
			
			// Load contents from user_playlist_contents table, each row is id, playlist_id, restaurant_id
			$contents = $this->userplaylists_model->get_contents($id);
			
			// Get restaurant name and id from contents
			$this->load->model('restaurants_model');
			$restaurants = array();
			foreach ($contents as $content_row){
				$restaurant = [
					'id' => $content_row['restaurant_id'],
					'name' => $this->restaurants_model->get_name($content_row['restaurant_id']),
				];
				$restaurants[] = $restaurant;
			}
			$data['restaurants'] = $restaurants;

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

		$data['css'] = ["/css/chosen.min"];
		// $data['javascript'] = ["/script/chosen.min"];
		$data['title'] = 'Add New Playlist';
		$data['restaurants'] = $this->restaurants_model->get_restaurant();

		$this->form_validation->set_rules('title', 'Playlist Name', 'required');
		$this->form_validation->set_rules('desc', 'Description', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('partials/header', $data);
			$this->load->view('userplaylists/create', $data);
			$this->load->view('partials/footer', $data);
		}
		else
		{
			$query = $this->userplaylists_model->set_playlist();
			
			if ($this->input->post('restaurant') != '-1'){
				$content = [
				'playlist_id' => $query,
				'restaurant_id' => $this->input->post('restaurant'),
				];
				$this->userplaylists_model->add_restaurant($content);
			}
			
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
		
		// Load contents from user_playlist_contents table, each row is id, playlist_id, restaurant_id
		$contents = $this->userplaylists_model->get_contents($id);
		
		// Get restaurant name and id from contents
		$this->load->model('restaurants_model');
		$restaurants = array();
		foreach ($contents as $content_row){
			$restaurant = [
				'content_id' => $content_row['id'],
				'id' => $content_row['restaurant_id'],
				'name' => $this->restaurants_model->get_name($content_row['restaurant_id']),
			];
			$restaurants[] = $restaurant;
		}
		$data['restaurants'] = $restaurants;

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
	
	public function add_to_list(){
		$data = [
			'playlist_id' => $this->input->post('playlist_id'),
			'restaurant_id' => $this->input->post('restaurant_id'),
		];
		
		$this->userplaylists_model->add_restaurant($data);
	}
	
	public function content_delete($playlist_id, $content_id) {
		if (empty($playlist_id) or empty($content_id)) {
			show_404();
		}
		echo($content_id);
		# Check for proper authentication first
		$this->userplaylists_model->delete_content($content_id);
		redirect('/userplaylists/edit/'.$playlist_id);
	}
}