<?php
class Reviews extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('reviews_model');
		$this->load->model('users_model');
		$this->load->helper('url_helper');
	}

	public function put($restaurant_id)
	{
		$data = [
			'restaurant_id'	=>	$restaurant_id,
			'author_id'		=>	$this->session->id,
			'body'			=>	$this->input->post('body'),
		];
		$this->reviews_model->put_review($data);
		redirect("/restaurants/".$restaurant_id);
	}

	// Needs restaurant_id so we can redirect
	public function delete($restaurant_id, $review_id)
	{
		$this->reviews_model->delete($review_id);
		redirect("/restaurants/".$restaurant_id);
	}

}
