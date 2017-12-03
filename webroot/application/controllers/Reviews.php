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
			header('Content-type: application/json');
			$this->load->model('restaurants_model');
			$author_id = $this->session->id;
			$response = $this->reviews_model->thumbs_up($restaurant_id, $author_id);
			$message = $response['message'];
			if($message === "liked"){
				// var_dump('message', $message);
				$result = $this->restaurants_model->update_rating($restaurant_id, 'upvote', TRUE);
			}
			if($message === "unliked"){
				// var_dump('message', $message);
				$result = $this->restaurants_model->update_rating($restaurant_id, 'upvote', FALSE);
			}
			if($message === "changed mind"){
					// var_dump('message', $message);
				$result = $this->restaurants_model->update_rating($restaurant_id, 'upvote', TRUE);
				$result = $this->restaurants_model->update_rating($restaurant_id, 'downvote', FALSE);

			}
			$result['message'] = $message;
			echo json_encode($result);
	}
	public function thumbs_down($restaurant_id)
	{
			header('Content-type: application/json');
			$this->load->model('restaurants_model');
			$author_id = $this->session->id;
			$response = $this->reviews_model->thumbs_down($restaurant_id, $author_id);
			$message = $response['message'];
			if($message === "disliked"){
				// var_dump('message', $message);
				$result = $this->restaurants_model->update_rating($restaurant_id, 'downvote', TRUE);
			}
			if($message === "undisliked"){
				// var_dump('message', $message);
				$result = $this->restaurants_model->update_rating($restaurant_id, 'downvote', FALSE);
			}
			if($message === "changed mind"){
					// var_dump('message', $message);
					$result = $this->restaurants_model->update_rating($restaurant_id, 'downvote', TRUE);
					$result = $this->restaurants_model->update_rating($restaurant_id, 'upvote', FALSE);
			}
			$result['message'] = $message;
			echo json_encode($result);
	}

	// Needs restaurant_id so we can redirect
	public function delete($restaurant_id, $review_id)
	{
		$this->reviews_model->delete($review_id);
		redirect("/restaurants/".$restaurant_id);
	}

}
