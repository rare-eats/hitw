<?php
class Restaurants extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('restaurants_model');
		$this->load->model('tags_model');
		$this->load->model('reviews_model');
		$this->load->helper('url_helper');
	}

	public function view($id = FALSE) {
		if ($id === FALSE) {
			$data['title'] = "Restaurants";
			$data['restaurants'] = $this->restaurants_model->get_restaurant();

			$this->load->view('partials/header', $data);
			$this->load->view('restaurants/view_all', $data);
			$this->load->view('partials/footer');
		}
		else
		{
			$data['restaurant'] = $this->restaurants_model->get_restaurant($id)[0];

			if (!isset($data['restaurant'])) {
			redirect('restaurants');
		}

		$data['title'] = $data['restaurant']['name'];
		$data['javascript'] = ['/script/restaurant_view'];

		$this->load->view('partials/header', $data);
		$this->load->view('restaurants/view', $data);
		$this->load->view('partials/footer');
		}
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

		$data['restaurant'] = $this->restaurants_model->get_restaurant($id)[0];

		if (empty($data['restaurant'])) {
			show_404();
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

	public function reviews($restaurant_id)
	{
		var_dump($restaurant_id, "Restuarants controller review: restaurant_id");
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('body', 'Body', 'required');
		$data['restaurant'] = $this->restaurants_model->get_restaurant($restaurant_id)[0];
		$data['title'] = 'Reviews';
		$data['reviews']=$this->reviews_model->get_reviews($restaurant_id);
		$author_id = $this->session->id;

		if(!empty($author_id)){
			if ($this->form_validation->run() === TRUE){
					echo "validation form ran";
					$this->reviews_model->leave_review($restaurant_id, $author_id);
					redirect('/restaurants/reviews/'.$restaurant_id);
				}
		}
		else{
			echo "form invalid";
			// $message = "Please log in to leave a review";
			// echo "<script type='text/javascript'>alert('$message');</script>";
		}
		$this->load->view('partials/header', $data);
		$this->load->view('restaurants/reviews', $data);
		$this->load->view('partials/footer');
	}
}
