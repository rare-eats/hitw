<?php

class Reviews_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	// Used by the model to apply filters to whatever query is run next
	private function filter_results($fields = NULL)
	{
		if (!empty($fields)){
			// Filter by the fields
			foreach($fields as $column => $value){
				$this->db->where($column, $value);
			}
		}
	}
	/**
	get_reviews()
	- Returns an array containing all results which match the supplied
		filters
	@param $fields - Filter values
	[
		'db_column'	=>	'filter_value'
	]

	@param $join_users - Whether or not to join the users table for info on who left the review
	TRUE or FALSE

	@param $limit - The limit on the number of results to return. Fun fact: Queries are faster if you limit it to 1 result!

	@param $offset - How far into the db to start the results (used for pagination)

	*/
	public function get_reviews($fields = NULL, $join_users = FALSE, $limit = NULL, $offset = NULL)
	{
		$this->filter_results($fields);
		$this->db->select("reviews.*");

		if($join_users)
		{
			$this->db->select("users.first_name, users.last_name, users.email");
			$this->db->join('users', 'reviews.author_id = users.id');
		}

		if(isset($limit))
		{
			$this->db->limit($limit);
		}
		if(isset($offset))
		{
			$this->db->offset($offset);
		}

		$this->db->order_by('t_created', 'ASC');
		$query = $this->db->get('reviews');
		return $query->result_array();
	}

	// Similar to get_reviews, but will return an integer count of results. (Faster than counting the number of elements returned by get_reviews)
	public function count_reviews($fields = NULL)
	{
		$this->filter_results($fields);
		return $this->db->count_all_results('reviews');
	}
	// Delete all reviews which match the fields
	public function delete_reviews($fields = NULL)
	{
		$this->db->delete('reviews', $fields);
		var_dump($this->db->last_query());
	}

	// Delete the review with the specified id
	public function delete($id) {
		$this->delete_reviews(['id'=>$id]);
	}

	// Add a review to the database. Will replace existing user reviews (essentially edit)
	public function put_review($data)
	{
		$review_count = $this->count_reviews([
			'restaurant_id'	=>	$data['restaurant_id'],
			'author_id'		=>	$data['author_id']
		]);
		if ($review_count < 1)
		{
			unset($data['javascript']);
			$this->db->insert('reviews', $data);
		}
		else
		{
			$this->filter_results([
				'restaurant_id'	=>	$data['restaurant_id'],
				'author_id'	=>	$data['author_id']
			]);
			unset($data['javascript']);
			$this->db->update('reviews', $data);
		}
	}
	public function thumbs_up($author_id, $restaurant_id){
		echo("thumbs up model");
		var_dump("author id: ", $author_id, "restaurant id:", $restaurant_id);
		$this->db->where('reviews.author_id',$author_id);
		$this->db->where('reviews.restaurant_id',$restaurant_id);
		$this->db->select('rating');
		$rating = $this->db->get("reviews");
		if ($rating === NULL){
			$this->db->update('rating', false);
		}
		else{
			$this->db->update('rating', NULL);
		}
	}
	public function thumbs_down($author_id, $restaurant_id){
		echo("thumbs down model");
		var_dump("author id: ", $author_id, "restaurant id:", $restaurant_id);
		$this->db->where('reviews.author_id',$author_id);
		$this->db->where('reviews.restaurant_id',$restaurant_id);
		$this->db->select('rating');
		$rating = $this->db->get("reviews");
		if ($rating === NULL){
			$this->db->update('rating', false);
		}
		else{
			$this->db->update('rating', NULL);
		}
	}
}
