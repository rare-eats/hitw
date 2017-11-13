<?php
class Tags_model extends CI_Model {
	public function __construct() {
		$this->load->database();
	}

	public function add_restaurant_tag($data) 
	{
		if( !isset($data) )
		{
			return [
				'success'=>FALSE,
				'message'=>'Insufficient data provided to add_restaurant_tag',
				'data'=>$data
			]; // Not enough data
		}

		$this->db->insert('tags', $data);
		$data['id'] = $this->db->insert_id();
		return [
			'success'=>TRUE,
			'message'=>'Inserted new tag',
			'data'=>$data
		];
	}

	public function delete_restaurant_tag($data)
	{
		if (!isset($data))
		{
			return [
				'success'=>FALSE,
				'message'=>'Insufficient data provided to delete_restaurant_tag',
				'data'=>$data
			]; // Not enough data
		}

		// Remove this tag from all associations
		$this->db->where('tag_id', $data['id']);
		$this->db->delete('restaurant_tags');

		// Remove the tag
		$this->db->where('id', $data['id']);
		$this->db->delete('tags');
		return [
			'success'=>TRUE,
			'message'=>'Removed existing tag',
			'data'=>$data
		];
	}

	public function get_restaurant_tags($restaurant_id = NULL)
	{
		if (isset($restaurant_id))
		{
			$this->db->where('restaurant_id', $restaurant_id);
		}
		$query = $this->db->get('tags');
		return [
			'success'=>TRUE,
			'data'=>$query->result_array()
		];
	}

}