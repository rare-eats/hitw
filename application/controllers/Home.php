<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct() {
		parent::__construct();
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

		$data['playlists'] = array(
			array(
				"title" => "Out of ideas",
				"desc" => "Coming up with these is really hard..."
			),
			array(
				"title" => "Placeholders",
				"desc" => "I'm just going to start using placeholders"
			),
			array(
				"title" => "Lorem Ipsum",
				"desc" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
			),
			array(
				"title" => "Dolor Sit",
				"desc" => "dolor sit amet, consectetur adipiscing elit. Nulla eget condimentum ex"
			)
		);

		$this->load->view('partials/header.php', $data);
		$this->load->view('home.php', $data);
		$this->load->view('partials/footer.php', $data);
	}
}
