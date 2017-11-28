<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('restaurants_model');
		$this->load->model('userplaylists_model');
		#move once we get a tags page
		$this->load->model('tags_model');

		$this->load->model('autoplaylists_model');
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

		$author_id = $this->session->id;

		if (isset($author_id)) {
        	$recommended_playlist = $this->autoplaylists_model->get_recommended_playlist($author_id);
        	$data['recommended'] = $recommended_playlist;
			$data['playlists'] = $this->userplaylists_model->get_by_author($author_id, 4);

		}

        if (isset($recommended_playlist) && $recommended_playlist['t_created'] - date("Y-m-d H:i:s") >= 7) {

        		$tag_count = $this->autoplaylists_model->get_most_popular_tag($author_id);

	        	$restaurant_tags = $this->tags_model->get_tags_by_id($tag_count[0]['tag_id']);
	        	$restaurant_users = $this->autoplaylists_model->get_user_restaurants($author_id);
	        	$ru = [];
		        $rt = [];

		        array_walk_recursive($restaurant_users, function($a) use (&$ru) { $ru[] = $a; });
		        array_walk_recursive($restaurant_tags, function($a) use (&$rt) { $rt[] = $a; });

		        //find restaurants that are not in restaurants_users
		        $recommended = [];
		        foreach ($rt as $r) {
		        	if (!in_array($r, $ru)) {
		        		$recommended[] = $r;
		        	}
		        }
		        $this->autoplaylists_model->create_recommendation_list($author_id, $recommended);
        }


        $data['author_id'] = $author_id;

		$this->load->view('partials/header.php', $data);
		$this->load->view('home.php', $data);
		$this->load->view('partials/footer.php', $data);
	}
}
