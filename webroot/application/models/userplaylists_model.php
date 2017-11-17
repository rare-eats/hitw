<?php
class Userplaylists_model extends CI_Model {
	public function __construct() {
		$this->load->database();
	}

	# Create or update playlist (update if id is provided)
	public function set_playlist($id = FALSE) {
		$private = False or (bool)$this->input->post('private');
		$data = array(
			'author_id' => $this->session->id,
			'private' => $private,
			'title' => $this->input->post('title'),
			'desc' => $this->input->post('desc')
		);
		$restaurant = $this->input->post('restaurant');

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

	public function get_by_author($author_id) {
		if (!isset($author_id)) {
			return False;
		} else {
			$query = $this->db->get_where('user_playlists', ['author_id' => $author_id]);
			return $query->result_array();
		}
	}
}