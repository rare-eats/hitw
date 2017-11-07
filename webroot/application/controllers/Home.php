<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index()
	{
		$this->load->library('migration');

		if ($this->migration->current() === FALSE)
		{
			show_error($this->migration->error_string());
		}
		
		$this->load->view('partials/header.php');
		$this->load->view('home.php');
		$this->load->view('partials/footer.php');
	}
}
