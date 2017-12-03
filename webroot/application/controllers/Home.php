<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('restaurants_model');
		$this->load->model('userplaylists_model');
		$this->load->model('autoplaylists_model');

		#move once we find a nicer place in reviews to put it
        $this->load->model('reviews_model');

		$this->load->helper('url_helper');
	}

	public function index()
	{
		$this->load->library('migration');

		if ($this->migration->current() === FALSE)
		{
			show_error($this->migration->error_string());
		}

		$data['title'] = "Home";

		$data['restaurants'] = $this->security->xss_clean($this->restaurants_model->get_amount_of_restaurants(4));

		$author_id = $this->session->id;

		foreach ($data['restaurants'] as $key => $restaurant) {
			$data['restaurants'][$key]['image_url'] = [];
			$photo = $this->restaurants_model->get_restaurant_photos((string)$restaurant['id'],1,'RANDOM');
			if (!empty($photo)) {
				$data['restaurants'][$key]['image_url'][] = $photo[0]['image_url'];
			}
		}

		if (isset($author_id)) {
			$data['author_id'] = $author_id;
			$data['time_list'] = $this->autoplaylists_model->initiate_time_lists($author_id);
			$data['recommended'] = $this->autoplaylists_model->initiate_recommendations($author_id);
			$data['season_list'] = $this->autoplaylists_model->initiate_season_lists($author_id);

			$data['playlists'] = $this->security->xss_clean($this->userplaylists_model->get_by_author($author_id, 4));

		}

		$this->load->view('partials/header.php', $data);
		$this->load->view('home.php', $data);
		$this->load->view('partials/footer.php', $data);
	}
}
