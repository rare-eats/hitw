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

	# Returns all if no terms specified
	public function search_playlists($terms = FALSE) {
			
		$user_id = $this->session->id;
		$admin = $this->users_model->is_admin();
		
		$term = strtolower($terms);

		if(!($admin)) {	
			$query = $this->db->select('*')->from('user_playlists')
				->group_start()
					->where('private', FALSE)
					->or_where('author_id', $user_id)
				->group_end()
				->group_start()
					->like('LOWER(title)', $term)
					->or_like('desc', $term)
				->group_end()
				->limit(64)
			->get();
		}
		else 
		{
			$query = $this->db->select('*')->from('user_playlists')->get();
		}
		
		return $query->result_array();
	}

	# Returns all playlists if no id is specified
	public function get_playlist($id = FALSE) {
		$user_id = $this->session->id;

		if ($id === FALSE) {
			$this->db->where('author_id', $user_id);
			if (!$this->users_model->is_admin()) {
				$this->db->or_where('private', 'FALSE');
			}
			$this->db->limit(64);
			$query = $this->db->get('user_playlists');
			return $query->result_array();
		}

		# Check for authentication to view inside the controller
		$this->db->where('id', $id);
		$query = $this->db->get('user_playlists');
		return $query->row_array();
	}

	# Returns all restaurants in the specified playlist
	public function get_restaurants($id = FALSE) {
		$query = FALSE;
		if ($id !== FALSE) {
			$query = $this->db->get_where('user_playlist_contents', ['playlist_id' => $id]);
			return $query->result_array();
		}
	}

	# Delete a playlist
	public function delete_playlist($id = FALSE) {
		if ($id === FALSE) {
			show_404();
		}

		$this->db->where('playlist_id', $id);
		$query = $this->db->delete('user_playlist_contents');
		
		$this->db->where('playlist_id', $id);
		$query = $this->db->delete('user_playlist_subscriptions');

		$this->db->where('id', $id);
		$this->db->delete('user_playlists');
	}

	# Returns a specific author's playlists, only returning those that the current user is authorized to see
	public function get_by_author($author_id, $limit = FALSE) {
		if (!isset($author_id)) {
			return False;
		} else {
			$user_id = $this->session->id;
			if (!isset($user_id)){
				$user_id = -1;
			}
			
			$query = $this->db
				->group_start()
				->where('author_id =', $user_id)
				->or_where('private =', 'FALSE')
				->group_end()
				->where('author_id', $author_id)
				->get('user_playlists', $limit);
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
	
	# Adds a row to user_playlist_subscriptions, subscribing the specified user to the specified playlist
	public function subscribe_playlist($data = NULL) {
		if ($data === NULL) {
			return False;
		}

		$this->db->insert('user_playlist_subscriptions', $data);
		return $this->db->insert_id();
	}
	
	# Removes a row from user_playlist_subscriptions, un-subscribing the specified user from the specified playlist
	public function unsubscribe_playlist($user_id, $playlist_id) {
		if (!isset($user_id) or !isset($playlist_id)) {
			return False;
		}

		$this->db->where('user_id', $user_id);
		$this->db->where('playlist_id', $playlist_id);
		return $this->db->delete('user_playlist_subscriptions');
	}
	
	# Returns the id of the user_playlist_subscriptions row for the specified user/playlist if it exists, -1 otherwise
	public function check_subscribed($user_id, $playlist_id){
		if (!isset($user_id) or !isset($playlist_id)) {
			return False;
		}
		
		$this->db->where('user_id', $user_id);
		$this->db->where('playlist_id', $playlist_id);
		$query = $this->db->get('user_playlist_subscriptions');
		
		if ($query-> num_rows() == 0){
			$sub_id = -1;
		} else {
			$sub_id = $query->row()->id;
		}
		
		return $sub_id;
	}
	
	# Returns ids of all playlists a given user is subscribed to
	public function get_subscribed($user_id){
		if (!isset($user_id)) {
			return False;
		}
		
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_playlist_subscriptions');
		
		$result = array();
		foreach($query->result() as $row){
			$result[] = $row->playlist_id;
		}
		
		return $result;
	}
}