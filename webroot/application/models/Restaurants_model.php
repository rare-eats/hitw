<?php
class Restaurants_model extends CI_Model {
	public function __construct() {
		$this->load->database();
	}

	// TODO: add_tags_by_name_to_restaurant($restaurant_id, $tag_names, $create_if_needed = FALSE)

	// WIP
	public function add_tags_to_restaurant($restaurant_id, $tag_ids){
		if ( !isset($restaurant_id) || !isset($tag_ids) || empty($tag_ids)) {
			return FALSE; // Not enough data
		}

		$ids = [];

		foreach ($tag_ids as $tag)
		{
			// Check if this association is already in the database
			$this->db->where("restaurant_id", $restuarant_id);
			$this->db->where("tag_id", $tag_id);

			$query = $this->db->get("restaurant_tags");
			if ($query->num_rows() <= 0)
			{
				$data = [
					'restaurant_id' => $restaurant_id,
					'tag_id'		=> $tag
				];
				$this->db->insert("restaurant_tags", $data);
				$id = $this->db->insert_id();
				array_push($ids, $id);
			}
			else
			{
				$row = $query->row();
				if (isset($row))
				{
					array_push($ids, $row['id']);
				}
				else
				{
					array_push($ids, -1);
				}
			}
		}

		return $ids;
	}

	# Create or update restaurant (update if id is provided)
	public function set_restaurant($id = FALSE) {
		$data = array(
			'restaurant_type' => $this->input->post('restaurant_type'),
			'name' => $this->input->post('name'),
			'addr_1' => $this->input->post('addr_1'),
			'city' => $this->input->post('city'),
			'state_prov_code' => $this->input->post('state_prov_code'),
			'country' => $this->input->post('country')
		);

		if ($id === FALSE) {
			$this->db->insert('restaurants', $data);
			return $this->db->insert_id();
		}
		else
		{
			$this->db->where('id', $id);
			$this->db->update('restaurants', $data);
			return $id;
		}
	}

	# Return list of [amt] restaurants by [term] in a given [column]
	# Ordering column defaults to rating, while ordering type defaults to descending
	public function search_restaurant($column = 'all', $term, $amt = 5, $ord_col = 'rating', $ord_val = 'desc') {
		# Limit search scope
		if ($amt < 1) {
			$amt = 1;
		}
		if ($amt > 100) {
			$amt = 100;
		}

		if ($column == 'all') {
			$this->db->like('restaurant_type', $term);
			$this->db->or_like('name', $term);
		}
		else 
		{
			$this->db->like($column, $term, 'both');
		}
		$this->db->order_by($ord_col, $ord_val);
		$this->db->limit($amt);
		return $this;
	}

	# Returns all restaurants if no id is specified
	public function get_restaurant($id = FALSE) {
		if ($id === FALSE) {
			$query = $this->db->get('restaurants');
			return $query->result_array();
		}

		$this->db->where('id', $id);
		$query = $this->db->get('restaurants');
		return $query->row_array();
	}

	# Get a list of [amt] restaurants by [type]
	public function get_restaurants_by_type($type = 'happy', $amt, $ord_col, $ord_val) {
		$query = search_restaurant('restaurant_type', $type, $amt, $ord_col, $ord_val);
		return $query->result_array();
	}

	# Get a list of [amt] restaurants in [city]
	public function get_restaurants_by_city($city = 'Vancouver', $amt, $ord_col, $ord_val) {
		$query = search_restaurant('city', $city, $amt, $ord_col, $ord_val);
		return $query->result_array();
	}

	# Get a list of [amt] restaurants by list of [terms]
	public function get_restaurant_by_search($terms, $amt, $ord_col, $ord_val) {
		$query = search_restaurant('all', $terms, $amt, $ord_col, $ord_val);
		return $query->result_array();
	}

	# Delete a restaurant
	public function delete_restaurant($id = FALSE) {
		if ($id === FALSE) {
			show_404();
		}

		$this->db->where('id', $id);
		return $this->db->delete('restaurants');
	}
}