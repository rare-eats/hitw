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
			'javascript' => '/script/restaurant_view'
		];
		$this->reviews_model->put_review($data);
		redirect("/restaurants/".$restaurant_id);
	}

	public function thumbs_up($restaurant_id)
	{
			$this->load->model('restaurants_model');
			$author_id = $this->session->id;
			$result = $this->reviews_model->thumbs_up($restaurant_id, $author_id);
			$message = $result['message'];
			if($message === "liked"){
				// var_dump('message', $message);
				$this->restaurants_model->update_rating($restaurant_id, 'upvote', TRUE);
			}
			if($message === "unliked"){
				// var_dump('message', $message);
				$this->restaurants_model->update_rating($restaurant_id, 'upvote', FALSE);
			}
			if($message === "changed mind"){
					// var_dump('message', $message);
					$this->restaurants_model->update_rating($restaurant_id, 'upvote', TRUE);
					$this->restaurants_model->update_rating($restaurant_id, 'downvote', FALSE);
			}
			return $result;
	}
	public function thumbs_down($restaurant_id)
	{
			$this->load->model('restaurants_model');
			$author_id = $this->session->id;
			$result = $this->reviews_model->thumbs_down($restaurant_id, $author_id);
			$message = $result['message'];
			if($message === "disliked"){
				// var_dump('message', $message);
				$this->restaurants_model->update_rating($restaurant_id, 'downvote', TRUE);
			}
			if($message === "undisliked"){
				// var_dump('message', $message);
				$this->restaurants_model->update_rating($restaurant_id, 'downvote', FALSE);
			}
			if($message === "changed mind"){
					// var_dump('message', $message);
					$this->restaurants_model->update_rating($restaurant_id, 'downvote', TRUE);
					$this->restaurants_model->update_rating($restaurant_id, 'upvote', FALSE);
			}
			return $result;
	}

	// Needs restaurant_id so we can redirect
	public function delete($restaurant_id, $review_id)
	{
		$this->reviews_model->delete($review_id);
		redirect("/restaurants/".$restaurant_id);
	}

}
