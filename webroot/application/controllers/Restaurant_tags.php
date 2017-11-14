<?php
class Restaurant_tags extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('tags_model');
	}

	public function index()
	{
		$data['title'] = "Restaurant Tags";

		$result = $this->tags_model->get_tags();
		if ($result['success'])
		{
			$data['tags'] = $result['data'];
		}
		else
		{
			$data['tags'] = [];
		}

		$this->load->view("partials/header", $data);
		$this->load->view("restaurants/tags", $data);
		$this->load->view("partials/footer", $data);
	}

	public function add_tag()
	{
		header('Content-type: application/json');
		$data = [
			'name'=>$this->input->input_stream("name")
		];
		$result = $this->tags_model->add_tag($data);
		if($result['success'])
		{
			$response = [
				'success'=>TRUE,
				'message'=>'Created tag',
				'data'=>$result['data']
			];
		}
		else
		{
			$response['data']['id'] = -1;
			$response = [
				'success'=>FALSE,
				'message'=>"Unable to add tag",
				'data'=> $response['data']
			];
		}
		echo json_encode($response);
	}

	public function remove_tag()
	{
		header('Content-type: application/json');
		$data = [
			'id'=>$this->input->input_stream('id'),
			'name'=>$this->input->input_stream("name")
		];
		$result = $this->tags_model->delete_tag($data);
		if($result['success'])
		{
			$response = [
				'success'=>TRUE,
				'message'=>'Created tag',
				'data'=>$result['data']
			];
		}
		else
		{
			$response['data']['id'] = -1;
			$response = [
				'success'=>FALSE,
				'message'=>"Unable to add tag",
				'data'=> $response['data']
			];
		}
		echo json_encode($response);
	}
}