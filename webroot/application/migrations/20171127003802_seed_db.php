<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_seed_db extends CI_Migration {

	public function up()
	{
        $this->load->model('tags_model');
        $this->load->model('restaurants_model');

        $this->tags_model->make_tags_api_call();
        #Get restaurants, and within restaurants get a few associated reviews if available.
        $this->restaurants_model->make_restaurants_api_call();
	}

	public function down()
	{

	}
}