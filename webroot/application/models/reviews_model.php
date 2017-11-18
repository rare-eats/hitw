<?php

class Reviews_model extends CI_Model {

    public function __construct()   {
        $this->load->database();
    }

    public function get_reviews($restaurant_id) {
        $query = $this->db->get_where('reviews',['restaurant_id'=>$restaurant_id]);
        if ($query !== False) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function delete($id) {
      // if ($id === FALSE) {
  		// 	show_404();
  		// }
      return $this->db->delete('reviews', ['id' => $id]);
    }

    public function leave_review($restaurant_id, $author_id){
      echo "reviews_model";
      $this->load->helper('url');
      // $slug = url_title($this->input->post('rating'), 'dash', TRUE);
      $data = array(
        'restaurant_id' => $restaurant_id,
        'author_id' => $author_id,
        // 'rating' => $this->input->post('rating'),
        // 'slug' => $slug,
        'body' => $this->input->post('body')

      );
      // $match = $this->db->get_where('reviews',['restaurant_id'=>$restaurant_id, 'author_id'=>$author_id]);
      // if(empty($match)){
      //   return $this->db->insert('reviews', $data);
      // }
      // else{
      //   $this->db->where('id', $id);
      //   return $this->db->update('reviews', $data);
      // }
      return $this->db->insert('reviews', $data);
     }

    public function edit($id) {
        $data['body'] = $this->input->get('body');
        echo "reviews_model edit";
        $this->db->where('id', $id);
        $this->db->update('reviews', $data);
    }

    public function get_review($id){
      $query = $this->db->get_where('reviews',['id'=>$id]);
      if ($query !== False) {
          return $query->result_array();
      } else {
          return FALSE;
      }
    }
}
