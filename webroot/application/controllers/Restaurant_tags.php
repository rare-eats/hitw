<?php
class Restaurant_tags extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = "Restaurant Tags";

		$data['tags'] = [
			['id'=>0, 'name'=>'Happy'],
			['id'=>1, 'name'=>'Spicy'],
			['id'=>2, 'name'=>'Date Night']
		];

		$this->load->view("partials/header", $data);
		$this->load->view("restaurants/tags", $data);
		$this->load->view("partials/footer", $data);
	}

	public function add_tag()
	{
		header('Content-type: application/json');
		$data = [
			'success'=>FALSE,
			'message'=>"Unable to add tag",
			'data'=> [
				'id'=>-1,
				'name'=>$this->input->input_stream("name")
			]
		];
		echo json_encode($data);
	}

	public function remove_tag()
	{
		header('Content-type: application/json');
		$data = [
			'success'=>FALSE,
			'message'=>'Unable to remove tag',
			'data'=>[
				'id'=>$this->input->input_stream('id'),
				'name'=>$this->input->input_stream('name')
			]
		];
		echo json_encode($data);
	}
}