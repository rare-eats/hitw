<?php
class Autoplaylists extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('autoplaylists_model');
        $this->load->model('restaurants_model');
        $this->load->helper('url_helper');
    }

    public function view($id = NULL) {

        $data['playlist'] = $this->autoplaylists_model->get_playlist($id);
        $restaurant_ids = $this->autoplaylists_model->get_restaurants($id);
        $r_ids = [];
        array_walk_recursive($restaurant_ids, function($a) use (&$r_ids) { $r_ids[] = $a; });

        $data['restaurants'] = $this->restaurants_model->get_restaurants_by_ids($r_ids);
        if (empty($data['playlist'])) {
            show_404();
        }

        $this->load->view('partials/header', $data);
        $this->load->view('autoplaylists/view', $data);
        $this->load->view('partials/footer');
    }
}