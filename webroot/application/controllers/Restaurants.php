<?php
class Restaurants extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('restaurants_model');
		$this->load->model('tags_model');
		$this->load->model('reviews_model');
		$this->load->helper('url_helper');
		$this->load->helper('form');
	}

	public function view($id = NULL) {
		$this->load->helper('form');

		if (!isset($id)) {
			redirect('restaurants');
			return; // Ensure the rest of the function doesn't run when redirecting
		}
		// Control will only reach this block if $id exists

		$data['restaurant'] = $this->restaurants_model->get_restaurant($id)[0];

		if (!isset($data['restaurant'])) {
			redirect('restaurants');
			return; // Don't continue if there was no data
		}

		$data['restaurant_id']	= $id;

		$data['reviews'] = $this->reviews_model->get_reviews(
			[
				'restaurant_id' => $id
			],
			TRUE
		);

		$data['photos'] = $this->restaurants_model->get_restaurant_photos($id);

		$data['user_left_review'] = $this->reviews_model->count_reviews(
			[
				'restaurant_id'	=>	$id,
				'author_id'		=>	$this->session->id
			]
		);

		$data['user_id'] = $this->session->id;
		$data['admin'] = $this->users_model->is_admin();
		$data['title'] = $data['restaurant']['name'];

		$data['css'] = [
			'/css/restaurants',
			'/css/chosen.min'
		];
		$data['javascript'] = [
			'/script/chosen.min',
			'/script/add_to_playlist',
			'/script/init_chosen',
			'/script/restaurant_view'
		];

		// Get current user's playlists, so restaurant can be added to them.
		$this->load->model('userplaylists_model');
		$data['playlists'] = $this->userplaylists_model->get_by_author($data['user_id']);


		$this->load->view('partials/header', $data);
		$this->load->view('restaurants/view', $data);
		$this->load->view('partials/footer', $data);
	}


	public function search() {
		$this->load->helper('form');

		$data['title'] = "Restaurants";
		$data['css'] = ['/css/restaurants'];

		if (!isset($_GET['terms'])) {
			$data['restaurants'] = $this->restaurants_model->get_restaurant();
		}
		else
		{
			$data['terms'] = $this->input->get('terms');
			$data['restaurants'] = $this->restaurants_model->search_restaurants($data['terms']);
		}

		$this->load->view('partials/header', $data);
		$this->load->view('restaurants/search', $data);
		$this->load->view('partials/footer');
	}

	public function create() {
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Add New Restaurant';

		$this->form_validation->set_rules('name', 'Restaurant Name', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');

		if ($this->form_validation->run() === FALSE) {
			$result = $this->tags_model->get_tags();
			if ($result['success'])
			{
				$data['tags'] = $result['data'];
			}
			else
			{
				$data['tags'] = [];
			}

			$this->load->view('partials/header', $data);
			$this->load->view('restaurants/create', $data);
			$this->load->view('partials/footer');
		}
		else
		{
			$query = $this->restaurants_model->set_restaurant();
			redirect('/restaurants/'.$query);
		}
	}

	public function edit($id = NULL) {
		$this->load->helper('form');
		$this->load->library('form_validation');

		if($this->users_model->is_admin() === FALSE) {
			show_404();
		}

		$data['restaurant'] = $this->restaurants_model->get_restaurant($id)[0];

		if (empty($data['restaurant'])) {
			redirect('/restaurants/search');
		}

		$data['title'] = 'Edit Restaurant';

		$this->form_validation->set_rules('name', 'Restaurant Name', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');

		if ($this->form_validation->run() === FALSE) {
			$result = $this->tags_model->get_tags();
			if ($result['success'])
			{
				$data['tags'] = $result['data'];
			}
			else
			{
				$data['tags'] = [];
			}
			$this->load->view('partials/header', $data);
			$this->load->view('restaurants/edit', $data);
			$this->load->view('partials/footer');
		}
		else
		{
			$this->restaurants_model->set_restaurant($id);
			redirect('/restaurants/'.$id);
		}
	}

	public function delete($id = NULL) {
		if (empty($id)) {
			show_404();
		}

		# Check for proper authentication first
		if ($this->users_model->is_admin()) {
			$this->restaurants_model->delete_restaurant($id);
		}
		redirect(base_url());
	}

	public function remove_tag($restaurant_id, $tag_id)
	{
		header('Content-type: application/json');
		$this->restaurants_model->remove_tag_from_restaurant($restaurant_id, $tag_id);
		$response = [
			'success'=>TRUE,
			'message'=>'Removed tag'
		];
		echo json_encode($response);
	}
}