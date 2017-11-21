<?php
class Restaurants extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('restaurants_model');
		$this->load->model('tags_model');
		$this->load->helper('url_helper');
	}

	public function view($id = FALSE) {
		if ($id === FALSE) {
			redirect('restaurants');
		}
		else
		{
			$data['restaurant'] = $this->restaurants_model->get_restaurant($id)[0];

			if (!isset($data['restaurant'])) {
			redirect('restaurants');
		}

		$data['title'] = $data['restaurant']['name'];
		$data['css'] = ['/css/restaurants'];
		$data['javascript'] = ['/script/restaurant_view'];

		$this->load->view('partials/header', $data);
		$this->load->view('restaurants/view', $data);
		$this->load->view('partials/footer');
		}
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
			$search_terms = $this->input->get('terms');
			$data['terms'] = $search_terms;
			$data['restaurants'] = $this->restaurants_model->search_restaurants($search_terms);
		}

		$this->load->view('partials/header', $data);
		$this->load->view('restaurants/search', $data);
		$this->load->view('partials/footer');
	}

	public function create() {
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Add New Restaurant';
		$data['css'] = ['/css/restaurants'];

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

		$data['restaurant'] = $this->restaurants_model->get_restaurant($id)[0];

		if (empty($data['restaurant'])) {
			show_404();
		}

		$data['title'] = 'Edit Restaurant';
		$data['css'] = ['/css/restaurants'];

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
		$this->restaurants_model->delete_restaurant($id);
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