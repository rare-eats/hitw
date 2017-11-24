<?php
class Autoplaylists_model extends CI_Model {
    public function __construct() {
        $this->load->database();

    }

    public function get_most_popular_tag($author_id) {
        $query = $this->db->query(<<<sql
            SELECT
                COUNT(rt.tag_id) as tag_count,
                tag_id
            FROM
                user_playlist_contents as upc,
                user_playlists as up,
                restaurant_tags as rt
            WHERE
                upc.playlist_id = up.id and
                upc.restaurant_id = rt.restaurant_id
            GROUP BY
                tag_id
            ORDER BY
                tag_count DESC
            LIMIT 1
sql
);
        $row = $query->result_array();
        return $row;
    }


}