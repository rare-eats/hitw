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
                    COUNT(rt.tag_id) DESC
                LIMIT 2
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
                $len = count($r_ids) < 10 ? count($r_ids) : 10;
                for($i = 0; $i < $len; $i++) {
                    $random = mt_rand(0, $len-1);
                    $r_insert[$i]['restaurant_id'] = $r_ids[$random];
                    $r_insert[$i]['playlist_id'] = $playlist_id;
                }

                $this->db->insert_batch('auto_playlist_contents', $r_insert);
            }
        }
    }

    public function get_playlist_by_time($user_id) {
        date_default_timezone_set('America/Vancouver');

        $now = (int)date('G');
        $query = FALSE;

        if ($now > 6 && $now <= 11) {
            $query = $this->db->get_where('auto_playlists', [
                'user_id'   => $user_id,
                'title'     => 'Good Morning!'
            ], 1);
        } elseif ($now > 11 && $now <= 15) {
            $query = $this->db->get_where('auto_playlists', [
                'user_id'   => $user_id,
                'title'     => 'Good Afternoon!'
            ], 1);
        } else {
            $query = $this->db->get_where('auto_playlists', [
                'user_id'   => $user_id,
                'title'     => 'Good Evening!'
            ], 1);
        }
        if (!empty($query)) {
            return $query->row_array();
        }
    }

    public function create_playlist_by_data($data, $tag_names) {

        if (!empty($data)) {
            $this->db->insert('auto_playlists', $data);
            $playlist_id = $this->db->insert_id();
        }

        $r_insert = [];
        if ($playlist_id) {
            $ri = [];

            $r_ids = $this->tags_model->get_restaurants_by_tags($tag_names);
            if (!empty($r_ids)) {
                array_walk_recursive($r_ids, function($a) use (&$ri) { $ri[] = $a; });

                for($i = 0; $i < count($ri); $i++) {
                    $r_insert[$i]['restaurant_id'] = $ri[$i];
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
            return $query->row_array();
        }

    }

    public function get_playlist($id) {
        $query = FALSE;
        if (isset($id)) {
            $query = $this->db->get_where('auto_playlists', ['id' => $id]);
            return $query->row_array();
        }

    }

    public function get_restaurants($id) {
        $query = FALSE;
        if (isset($id)) {
            $this->db->select('restaurant_id');
            $query = $this->db->get_where('auto_playlist_contents', ['playlist_id' => $id]);
            return $query->result_array();
        }
    }

    public function initiate_recommendations($author_id) {
        $get_recommendations = $this->autoplaylists_model->get_recommended_playlist($author_id);

        if (empty($get_recommendations) || $get_recommendations['t_created'] - date("Y-m-d H:i:s") >= 7) {

            $tag_count = $this->autoplaylists_model->get_most_popular_tag($author_id);
            $tc = [];
            array_walk_recursive($tag_count, function($a) use (&$tc) { $tc[] = $a; });

            if ($tc) {
                $restaurant_tags = $this->tags_model->get_tags_by_id($tc);
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
                    return $this->autoplaylists_model->get_recommended_playlist($author_id);
                }
            }
        } else {
            return $get_recommendations;
        }

    }

    public function initiate_time_lists($user_id) {
        $get_playlist_by_time = $this->autoplaylists_model->get_playlist_by_time($user_id);

        if (!empty($get_playlist_by_time)) {
            return $get_playlist_by_time;
        } else {
            $now = (int)date('G');
            $data = [];

            if ($now > 6 && $now <= 11) {
                $data = [
                    'user_id'   => $user_id,
                    'title'     => 'Good Morning!',
                    'desc'      => 'What do you want for breakfast?'
                ];
                $tag_name = ['Breakfast', 'Bakery'];
            } elseif ($now > 11 && $now <= 15) {
                $data = [
                    'user_id'   => $user_id,
                    'title'     => 'Good Afternoon!',
                    'desc'      => 'What do you want for lunch?'
                ];
                $tag_name = ['Sandwich', 'Salad'];
            } else {
                $data = [
                    'user_id'   => $user_id,
                    'title'     => 'Good Evening!',
                    'desc'      => 'What do you want for dinner?'
                ];
                $tag_name = ['American', 'Chinese'];
            }
            $this->autoplaylists_model->create_playlist_by_data($data, $tag_name);
            return $this->autoplaylists_model->get_playlist_by_time($user_id);
        }
    }


    public function get_playlist_by_season($user_id) {
        date_default_timezone_set('America/Vancouver');

        $now = (int)date('n');
        $query = FALSE;

        if ($now == 12 || $now <= 2 ) {
            $query = $this->db->get_where('auto_playlists', [
                'user_id'   => $user_id,
                'title'     => 'Its Winter!'
            ], 1);
        } elseif ($now > 2 && $now <= 4) {
            $query = $this->db->get_where('auto_playlists', [
                'user_id'   => $user_id,
                'title'     => 'Its Spring'
            ], 1);
        } elseif ($now > 4 && $now <= 7) {
            $query = $this->db->get_where('auto_playlists', [
                'user_id'   => $user_id,
                'title'     => 'Its Summer!'
            ], 1);
        } else {
            $query = $this->db->get_where('auto_playlists', [
                'user_id'   => $user_id,
                'title'     => 'Its Fall!'
            ], 1);
        }

        if (!empty($query)) {
            return $query->row_array();
        }
    }

    public function initiate_season_lists($user_id) {

        $get_playlist_by_season = $this->autoplaylists_model->get_playlist_by_season($user_id);

        if (!empty($get_playlist_by_season)) {
            return $get_playlist_by_season;
        } else {
            $now = (int)date('n');
            $data = [];

            if ($now == 12 || $now <= 2 ) {
                $data = [
                    'user_id'   => $user_id,
                    'title'     => 'Its Winter!',
                    'desc'      => 'Get warm at these places'
                ];
                $tag_name = ['Comfort Food', 'Cafe'];
            } elseif ($now > 2 && $now <= 4) {
                $data = [
                    'user_id'   => $user_id,
                    'title'     => 'Its Spring!',
                    'desc'      => 'Cherry Blossoms everywhere!'
                ];
                $tag_name = ['Bakery', 'French'];
            } elseif ($now > 4 && $now <= 7) {
                $data = [
                    'user_id'   => $user_id,
                    'title'     => 'Its Summer!',
                    'desc'      => 'Cool off at these places'
                ];
                $tag_name = ['Sandwich', 'Salad'];
            } else {
                $data = [
                    'user_id'   => $user_id,
                    'title'     => 'Its Fall!',
                    'desc'      => 'Have something pumpkin flavored at these places!'
                ];
                $tag_name = ['Cafe', 'Dessert'];
            }
            $this->autoplaylists_model->create_playlist_by_data($data, $tag_name);
            return  $this->autoplaylists_model->get_playlist_by_season($user_id);
        }
    }


}