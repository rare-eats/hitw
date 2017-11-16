<?php
class Userplaylists_model extends CI_Model {
	public function __construct() {
		$this->load->database();
	}

	# Create or update playlist (update if id is provided)
	public function set_playlist($id = FALSE) {
		$data = array(
			#'author_id' => intval($this->input->post('author_id')),
			'author_id' => 2,
			'private' => 'FALSE',
			'title' => $this->input->post('title'),
			'desc' => $this->input->post('desc')
		);

		if ($id === FALSE) {
			$this->db->insert('user_playlists', $data);
			return $this->db->insert_id();
		}
		else
		{
			$this->db->where('id', $id);
			$this->db->update('user_playlists', $data);
			return $id;
		}
	}

	// # Return list of [amt] restaurants by [term] in a given [column]
	// # Ordering column defaults to rating, while ordering type defaults to descending
	// public function search_restaurant($column = 'all', $term, $amt = 5, $ord_col = 'rating', $ord_val = 'desc') {
		// # Limit search scope
		// if ($amt < 1) {
			// $amt = 1;
		// }
		// if ($amt > 100) {
			// $amt = 100;
		// }

		// if ($column == 'all') {
			// $this->db->like('restaurant_type', $term);
			// $this->db->or_like('name', $term);
		// }
		// else 
		// {
			// $this->db->like($column, $term, 'both');
		// }
		// $this->db->order_by($ord_col, $ord_val);
		// $this->db->limit($amt);
		// return $this;
	// }

	# Returns all playlists if no id is specified
	public function get_playlist($id = FALSE) {
		if ($id === FALSE) {
			$query = $this->db->get('user_playlists');
			return $query->result_array();
		}

		$this->db->where('id', $id);
		$query = $this->db->get('user_playlists');
		return $query->row_array();
	}

	# Delete a playlist
	public function delete_playlist($id = FALSE) {
		if ($id === FALSE) {
			show_404();
		}

		$this->db->where('id', $id);
		return $this->db->delete('user_playlists');
	}
}