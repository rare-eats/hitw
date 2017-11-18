<?php
class Reviews extends CI_Controller {

  public function __construct() {
		parent::__construct();
		$this->load->model('reviews_model');
    $this->load->model('restaurants_model');
    $this->load->model('users_model');
    $this->load->helper('url_helper');
    //$this->load->helper('form_validation');
	}
  // public function leave_review() {
  //   $this->load->helper('form')
  //   $this->load->library('form_validation');
  //   $this->form_validation->set_rules('rating', 'Rating', 'required')
  //   $this->form_validation->set_rules('body', 'Body', 'required')
  //   if ($this->form_validation->run() === FALSE)
  //   {
  //       $this->load->view('partials/header', $data);
  //       $this->load->view('restaurants/review_form', $data);
  //       $this->load->view('partials/footer');
  //   }
  //   else
  //   {
  //       $this->reviews_model->leave_review();
  //       $this->load->view('restaurants/reviews');
  //   }
  // }
  public function edit($id = NULL) {
    var_dump("reviews controller edit");
    if (empty($id)) {
      show_404();
    }
    $this->load->helper('form');
    $this->load->helper('url_helper');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('author_id', 'Author', 'required');
    //
    $data['title'] = 'Edit Review';
    $data['review_id'] = $id;
    // $data = $this->reviews_model->get_review($id)[0];
    //
    // $this->load->view('partials/header', $data);
    // $this->load->view('reviews/edit/', $data);
    // $this->load->view('partials/footer');
    $this->reviews_model->edit($id);
    // redirect('/restaurants/reviews/edit/'.$id);
    // redirect(base_url());
  }

  public function delete($id=NULL) {
   if (empty($id)) {
     show_404();
   }
   $review = $this->reviews_model->get_review($id)[0];
   $this->reviews_model->delete($id);
   redirect(site_url('/restaurants/reviews/'.$review["restaurant_id"]));
  }
}


//
//   public function view($restaurant_id){
//     $data['restaurant_id'] = $this->restaurant_model->get_restaurant($restaurant_id)[0];
//     if (empty($data['restaurant'])) {
// 			show_404();
//     }
//     $this->load->view('partials/header', $data);
//     $this->load->view('restaurants/review', $data);
//     $this->load->view('partials/footer');
// }
//
