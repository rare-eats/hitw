<?php
class Restaurants extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('restaurants_model');
		$this->load->model('tags_model');
		$this->load->model('reviews_model');
		$this->load->helper('url_helper');
	}


	#https://api.foursquare.com/v2/venues/4aa7f646f964a5203d4e20e3?v=20171125&client_id=WCJXKICZZ3FVGLCCQNJQ3XL3WXDCX5GVFRF5E1PYLQ5MUEMI&client_secret=WQU20OQPUUCLSTZUFNL5C3DH52JZ3AHFT1XQ1WYIRZM3QTMH&group=venue&limit=5
	public function getLatLng($api_id){
	    $id_secret = $this->restaurants_model->get_id_and_secret();
        $url = "https://api.foursquare.com/v2/venues/" . $api_id . "?v=20171125&client_id=" . $id_secret[0] . "&client_secret=" .
            $id_secret[1] . "&group=venue&limit=5";

        $fourSearch = file_get_contents($url);
        if (!is_null($fourSearch)){
            #Parse
            $parsedJson = json_decode($fourSearch);
            $lat = $parsedJson->response->venue->location->lat;
            $lng = $parsedJson->response->venue->location->lng;
            return array($lat, $lng);
        }

        return null;
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

		#https://www.google.com/maps/search/?api=1&query=47.5951518,-122.3316393
        $latlng = $this->getLatLng($data['restaurant']['api_id']);
		$data['restaurant']['latlng'] = $latlng;

		$data['restaurant_id']	= $id;

		$data['reviews'] = $this->reviews_model->get_reviews(
			[
				'restaurant_id' => $id
			],
			TRUE
		);

		$data['user_left_review'] = $this->reviews_model->count_reviews(
			[
				'restaurant_id'	=>	$id,
				'author_id'		=>	$this->session->id
			]
		);

		$data['user_id'] = $this->session->id;

		$data['title'] = $data['restaurant']['name'];
		$data['javascript'] = ['/script/restaurant_view'];

		$this->load->view('partials/header', $data);
		$this->load->view('restaurants/view', $data);
		$this->load->view('partials/footer');
	}

	public function search() {
		$this->load->helper('form');

		$data['title'] = "Restaurants";

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

		$data['restaurant'] = $this->restaurants_model->get_restaurant($id)[0];

		if (empty($data['restaurant'])) {
			redirect('/restaurants');
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
}
