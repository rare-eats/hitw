<?php
  class Reviews extends CI_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->model('Restaurants_model')
       $this->load->model('Reviews_model');
       $this->load->helper('url_helper');
    }
    public function create($restaurant_id) {
  		$this->load->helper('form');
  		$this->load->library('form_validation');

  		$data['restaurant'] = 'Write a Review';

  		$this->form_validation->set_rules('Rating', 'Body', 'required');
  	}
    public function index(){
      $data['restuarant_id'] = $this->Restaurants_model->
    }
    public function view(){
      $this->load->view('Reviews');
    }
    public function model(){
      $this->load->model('Reviews_model');
    }

  }
?>
