<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('restaurants_model');
		$this->load->model('userplaylists_model');
		#move once we get a tags page
		$this->load->model('tags_model');

		#move once we find a nicer place in reviews to put it
        $this->load->model('reviews_model');

		$this->load->helper('url_helper');
		$this->load->model('restaurants_model');
	}

	public function index()
	{
		$this->load->library('migration');

		if ($this->migration->current() === FALSE)
		{
			show_error($this->migration->error_string());
		}

		$data['title'] = "Home";

		$data['restaurants'] = $this->restaurants_model->get_amount_of_restaurants(4);

		$data['restaurant_images'] = [];

		foreach ($data['restaurants'] as $restaurant) {
			$data['restaurant_images'][] = $this->restaurants_model->get_restaurant_photos((string)$restaurant['id'],1,'RANDOM')[0];
		}

		$data['recommended'] = array(
			array(
				"title" => "Grove And Chew",
				"desc" => "Get your chow on while you grove at these totally rad diners"
			),
			array(
				"title" => "Rainy Days",
				"desc" => "Come in from the rain and warm up with these comforting menus"
			),
			array(
				"title" => "Health is Might",
				"desc" => "No cheaters in here! Treat your body right with this selection of health food restaurants"
			),
			array(
				"title" => "Cheat Day",
				"desc" => "We all need a break sometimes, so come pig out at these delectably unhealthy dives"
			)
		);
		$data['playlists'] = $this->userplaylists_model->get_by_author($this->session->id, 4);

		$this->load->view('partials/header.php', $data);
		$this->load->view('home.php', $data);
		$this->load->view('partials/footer.php', $data);
	}
}
