<?php
class Userplaylists extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('userplaylists_model');
		$this->load->helper('url_helper');
	}

	public function view($id = NULL) {
		$data['title'] = "Playlists";
		$data['user_id'] = $this->session->id;
		$data['admin'] = $this->users_model->is_admin();
		
		if ($id === NULL) {
			redirect('/userplaylists/search');
			return;
		}
		
		$data['playlist'] = $this->security->xss_clean($this->userplaylists_model->get_playlist($id));
		if (empty($data['playlist'])) {
			redirect('/userplaylists/search');
			return;
		}

		$data['restaurants'] = $this->security->xss_clean($this->userplaylists_model->get_restaurants($id));
		
		// Load contents from user_playlist_contents table, each row is id, playlist_id, restaurant_id
		$contents = $this->security->xss_clean($this->userplaylists_model->get_contents($id));
		
		// Get restaurant name and id from contents
		$this->load->model('restaurants_model');
		$data['restaurants'] = [];
		foreach ($contents as $content_row){
			$data['restaurants'][] = [
				'id' => $content_row['restaurant_id'],
				'name' => $this->security->xss_clean($this->restaurants_model->get_name($content_row['restaurant_id'])),
			];
		}

		$data['subscribed'] = $this->userplaylists_model->check_subscribed($this->session->id, $id) != -1;
			
		$author = ($this->users_model->get_user($data['playlist']['author_id']))[0];
		$data['author_name'] = $author['first_name'] . ' ' . $author['last_name'];
		$data['author_id'] = $author['id'];

		$this->load->view('partials/header', $data);
		$this->load->view('userplaylists/view', $data);
		$this->load->view('partials/footer');
	}

	public function search() {
		$this->load->helper('form');

		$data['title'] = "User Playlists";
		$data['user_id'] = $this->session->id;
		
		if (!isset($_GET['terms'])) {
			$data['playlists'] = $this->security->xss_clean($this->userplaylists_model->search_playlists());
		}
		else
		{
			$data['terms'] = $this->input->get('terms');
			$data['playlists'] = $this->security->xss_clean($this->userplaylists_model->search_playlists($data['terms']));
		}

		// var_dump($data['playlists']);

		foreach ($data['playlists'] as $key => $playlist) {
			$author = $this->security->xss_clean(($this->users_model->get_user($playlist['author_id']))[0]);
			$author_name = $author['first_name'] . ' ' . $author['last_name'];
			
			$data['playlists'][$key]['author_name'] = [];
			$data['playlists'][$key]['author_name'][] = (string)$author_name;	
		}

		$this->load->view('partials/header', $data);
		$this->load->view('userplaylists/search', $data);
		$this->load->view('partials/footer');
	}

	public function create() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('restaurants_model');

		$data['css'] = ["/css/component-chosen.min"];
		
		$data['javascript'] = [
			'/script/chosen.min', 
			'/script/init_chosen'
		];
		$data['title'] = 'Add New Playlist';
		$data['restaurants'] = $this->security->xss_clean($this->restaurants_model->get_restaurant());

		$this->form_validation->set_rules(
			'title', 'Playlist Name', 'required|max_length[100]');
		$this->form_validation->set_rules(
			'desc', 'Description', 'required|max_length[255]');

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
		$contents = $this->security->xss_clean($this->userplaylists_model->get_contents($id));
		
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

		$this->form_validation->set_rules('title', 'Playlist Name', 'required|max_length[100]');
		$this->form_validation->set_rules('desc', 'Description', 'required|max_length[255]');

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
	
	
	public function subscribe($id = NULL) {
		if (empty($id) or !($this->session->has_userdata('id'))) {
			show_404();
		}
		
		$data = [
		'user_id' => $this->session->id,
		'playlist_id' => $id,
		];
		
		$this->userplaylists_model->subscribe_playlist($data);
		redirect('/userplaylists/'.$id);
	}
	
	public function unsubscribe($id = NULL) {
		if (empty($id) or !($this->session->has_userdata('id'))) {
			show_404();
		}
		
		
		$this->userplaylists_model->unsubscribe_playlist($this->session->id, $id);
		redirect('/userplaylists/'.$id);
	}

	public function user($id = NULL) {
		if ($id === NULL) {
			show_404();
			return;
		}
		
		$author = $this->security->xss_clean(($this->users_model->get_user($id))[0]);
		$author_name = $author['first_name'] . ' ' . $author['last_name'];
		
		$data['title'] = "Playlists by " . $author_name;
		
		$data['playlists'] = $this->userplaylists_model->get_by_author($id);
		
		foreach ($data['playlists'] as $key => $playlist) {
			$data['playlists'][$key]['author_name'] = [];
			$data['playlists'][$key]['author_name'][] = (string)$author_name;	
		}

		$this->load->view('partials/header', $data);
		$this->load->view('userplaylists/view_user', $data);
		$this->load->view('partials/footer');
	}
}