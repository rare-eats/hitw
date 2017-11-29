<?php
class Userplaylists_model extends CI_Model {
	public function __construct() {
		$this->load->database();
	}

	public function update_playlist($id, $data) {
		if ($id) {
            $this->db->where('id', $id);
            $this->db->update('user_playlists', $data);
        }
	}
	# Create or update playlist (update if id is provided)
	public function set_playlist($id = FALSE) {
		$private = ($this->input->post('private') === 'true');
		$restaurant = $this->input->post('restaurant');

		if ($id === FALSE) {
			$data = [
				'author_id' => $this->session->id,
				'private' => $private,
				'title' => $this->input->post('title'),
				'desc' => $this->input->post('desc')
			];
			$this->db->insert('user_playlists', $data);
			return $this->db->insert_id();
		}
		else {
			$data = [
				'private' => $private,
				'title' => $this->input->post('title'),
				'desc' => $this->input->post('desc')
			];
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

	public function get_by_author($author_id, $limit = FALSE) {
		if (!isset($author_id)) {
			return False;
		} else {
			$query = $this->db->get_where('user_playlists', ['author_id' => $author_id], $limit);
			return $query->result_array();
		}
	}
	
	# Add a restaurant to a playlist by adding a row to user_playlist_contents
	public function add_restaurant($data = NULL) {
		if ($data === NULL) {
			return False;
		}

		$this->db->insert('user_playlist_contents', $data);
		return $this->db->insert_id();
	}
	
	# Returns all playlist contents for the given playlist id
	public function get_contents($id = FALSE) {
		if ($id === FALSE) {
			return False;
		}
		$this->db->where('playlist_id', $id);
		$query = $this->db->get('user_playlist_contents');
		return $query->result_array();
	}
	
	# Delete a user_playlist_contents entry, removing the restaurant from the playlist
	public function delete_content($id = FALSE) {
		if ($id === FALSE) {
			show_404();
		}

		$this->db->where('id', $id);
		return $this->db->delete('user_playlist_contents');
	}
}