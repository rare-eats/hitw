<?php
  // class name and file name must be the same
   Class Reviews_model extends CI_Model {
     public function __construct() {
       $this->load->database();
     }
   public function add($restaurant_id){
   $data = array(
       'restaurant_id' => $restaurant_id,
       'user_id'  => $this->input->user('id'),
       'review'   => $this->input->user('review')
   );

     $this->db->insert('comments', $post_data);

     if ($this->db->affected_rows()) {
         return $this->db->insert_id();
     }
     return false;
  }
}
?>
