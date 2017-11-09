<?php
class Restaurants extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('restaurants_model');
		$this->load->helper('url_helper');
	}

	public function view($id = NULL) {
		$data['restaurant'] = $this->restaurants_model->get_restaurant($id);

		if (empty($data['restaurant'])) {
			show_404();
		}

		$data['title'] = $data['name'];

		$this->load->view('partials/header', $data);
		$this->load->view('restaurants/view', $data);
		$this->load->view('partials/footer');

	}

	public function create() {
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Add New Restaurant';

		$this->form_validation->set_rules('name', 'Restaurant Name', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('partials/header', $data);
			$this->load->view('restaurants/create', $data);
			$this->load->view('partials/footer');
		}
		else 
		{
			$this->restaurants_model->set_restaurant();

			$this->load->view('restaurants/success', $data);
		}
	}

	public function edit($id = NULL) {
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['restaurant'] = $this->restaurants_model->get_restaurant($id);

		if (empty($data['restaurant'])) {
			show_404();
		}

		$data['title'] = 'Edit Restaurant';

		$this->form_validation->set_rules('name', 'Restaurant Name', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('partials/header', $data);
			$this->load->view('restaurants/create', $data);
			$this->load->view('partials/footer');
		}
		else 
		{
			$this->restaurants_model->set_restaurant($id);
			$this->load->view('partials/header', $data);
			$this->load->view('restaurants/success', $data);
			$this->load->view('partials/footer');
		}
	}

	private function _delete($id = NULL) {
		if (empty($id)) {
			show_404();
		}

		$this->restaurants_model->delete_restaurant($id);
		redirect(base_url());
	}
}