<?php
class Autoplaylists_model extends CI_Model {
    public function __construct() {
        $this->load->database();
        $this->load->model('tags_model');
    }

    public function get_most_popular_tag($author_id) {
        if ($author_id) {
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
                    upc.restaurant_id = rt.restaurant_id and
                    up.author_id = {$author_id}
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

    public function get_user_restaurants($author_id) {
        $query = $this->db->query(<<<sql
            SELECT
                DISTINCT upc.restaurant_id
            FROM
                user_playlist_contents as upc,
                user_playlists as up
            WHERE
                upc.playlist_id = up.id and
                up.author_id = {$author_id}
sql
        );
        $row = $query->result_array();
        return $row;
    }

    public function create_recommendation_list($user_id, $r_ids) {
        if (isset($r_ids) && isset($user_id)) {
                $data = [
                    'user_id'   => $user_id,
                    'title'     => 'Weekly Recommendations',
                    'desc'      => 'Explore New Restaurants'
                ];
                $this->db->insert('auto_playlists', $data);
                $playlist_id = $this->db->insert_id();

                if ($playlist_id) {
                    $r_insert = [];
                    $len = count($r_ids) < 6 ? count($r_ids) : 6;
                    for($i = 0; $i < $len; $i++) {
                        $random = mt_rand(0, $len-1);
                        $r_insert[$i]['restaurant_id'] = $r_ids[$random];
                        $r_insert[$i]['playlist_id'] = $playlist_id;
                    }

                    $this->db->insert_batch('auto_playlist_contents', $r_insert);
                }
        }
    }

    public function get_recommended_playlist($user_id) {
        $query = [];
        if (isset($user_id)) {
            $this->db->order_by('t_created', 'DESC');
            $query = $this->db->get_where('auto_playlists', [
                'user_id'   => $user_id,
                'title'     => 'Weekly Recommendations'
            ], 1);
        }
        return $query->row_array();

    }

    public function get_playlist($id) {
        $query = FALSE;
        if (isset($id)) {
            $query = $this->db->get_where('auto_playlists', ['id' => $id]);
        }

        return $query->row_array();
    }

    public function get_restaurants($id) {
        $query = FALSE;
        if (isset($id)) {
            $this->db->select('restaurant_id');
            $query = $this->db->get_where('auto_playlist_contents', ['playlist_id' => $id]);
        }

        return $query->result_array();
    }

    public function initiate_recommendation($author_id) {
        $get_recommendations = $this->autoplaylists_model->get_recommended_playlist($author_id);

        if (!isset($get_recommendations) || $get_recommendations['t_created'] - date("Y-m-d H:i:s") >= 7) {

            $tag_count = $this->autoplaylists_model->get_most_popular_tag($author_id);

            if ($tag_count) {
                $restaurant_tags = $this->tags_model->get_tags_by_id($tag_count[0]['tag_id']);
                $restaurant_users = $this->autoplaylists_model->get_user_restaurants($author_id);
                $ru = [];
                $rt = [];

                array_walk_recursive($restaurant_users, function($a) use (&$ru) { $ru[] = $a; });
                array_walk_recursive($restaurant_tags, function($a) use (&$rt) { $rt[] = $a; });

                //find restaurants that are not in restaurants_users
                $recommended = [];
                foreach ($rt as $r) {
                    if (!in_array($r, $ru)) {
                        $recommended[] = $r;
                    }
                }

                if ($recommended) {
                    $this->autoplaylists_model->create_recommendation_list($author_id, $recommended);
                }
            }
        } else {
            return $get_recommendations;
        }

    }



}