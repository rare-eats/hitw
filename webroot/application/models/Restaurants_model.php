<?php

class Restaurants_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

    public function get_id_and_secret(){
        #backup client id: IREJNTZAUVFPPDAEJ2EY0L4AHKFGYMPUB4RKEHJG5QK20AXS
        #backup secret: WVP24YF0O504XZ4QMOQ3TPKZ3DZI3KYYO3ODP3DR0SKHZ2FX
        $client_id = "WCJXKICZZ3FVGLCCQNJQ3XL3WXDCX5GVFRF5E1PYLQ5MUEMI";
        $client_secret = "WQU20OQPUUCLSTZUFNL5C3DH52JZ3AHFT1XQ1WYIRZM3QTMH";
        return array($client_id, $client_secret);
    }

    //TODO: make this call the api at a static URL.
        //THEN ->> Modify the api call to be modular.
    public function make_restaurants_api_call(){

        #Instead of checking if restaurants are loaded up here, we now do a check for every restaurant if its loaded or not.  Slow, but guaranteed to work.
        $id_secret = $this->get_id_and_secret();

        #this is the general 'food' category.  All other restaurant categories we want sit inside of it.
        #$categoryId = "4d4b7105d754a06374d81259";
        #"Food": 4d4b7105d754a06374d81259
        $categoryId = "4d4b7105d754a06374d81259";
        $fourSearch = file_get_contents("https://api.foursquare.com/v2/venues/search?client_id=" . $id_secret[0] .
            "&client_secret=" . $id_secret[1] . "&categoryId=" . $categoryId .
            "&v=20171111&limit=25&intent=browse&near=Vancouver%2C%20BC");
        if (is_null($fourSearch)){return;}
        $this->preload_restaurants($fourSearch);

        #"Breakfast Spot": 4bf58dd8d48988d143941735
        $categoryId = "4bf58dd8d48988d143941735";
        $fourSearch = file_get_contents("https://api.foursquare.com/v2/venues/search?client_id=" . $id_secret[0] .
            "&client_secret=" . $id_secret[1] . "&categoryId=" . $categoryId .
            "&v=20171111&limit=25&intent=browse&near=Vancouver%2C%20BC");
        if (is_null($fourSearch)){return;}
        $this->preload_restaurants($fourSearch);

        #'Sandwich Place': 4bf58dd8d48988d1c5941735
        $categoryId = "4bf58dd8d48988d1c5941735";
        $fourSearch = file_get_contents("https://api.foursquare.com/v2/venues/search?client_id=" . $id_secret[0] .
            "&client_secret=" . $id_secret[1] . "&categoryId=" . $categoryId .
            "&v=20171111&limit=25&intent=browse&near=Vancouver%2C%20BC");
        if (is_null($fourSearch)){return;}
        $this->preload_restaurants($fourSearch);

        #'Comfort Food': 52e81612bcbc57f1066b7a00
        $categoryId = "52e81612bcbc57f1066b7a00";
        $fourSearch = file_get_contents("https://api.foursquare.com/v2/venues/search?client_id=" . $id_secret[0] .
            "&client_secret=" . $id_secret[1] . "&categoryId=" . $categoryId .
            "&v=20171111&limit=25&intent=browse&near=Vancouver%2C%20BC");
        if (is_null($fourSearch)){return;}
        $this->preload_restaurants($fourSearch);

        #'Cafe': 4bf58dd8d48988d16d941735
        $categoryId = "4bf58dd8d48988d16d941735";
        $fourSearch = file_get_contents("https://api.foursquare.com/v2/venues/search?client_id=" . $id_secret[0] .
            "&client_secret=" . $id_secret[1] . "&categoryId=" . $categoryId .
            "&v=20171111&limit=25&intent=browse&near=Vancouver%2C%20BC");
        if (is_null($fourSearch)){return;}
        $this->preload_restaurants($fourSearch);
    }


    public function make_reviews_api_call($restaurant_table_id, $restaurant_id){
        $fourSearch = $this->build_api_url($restaurant_id, "tips", "recent", "2");

        if (is_null($fourSearch)){return;}
        $this->preload_reviews($fourSearch, $restaurant_table_id);
    }

    #Looking on a way to generalize this - not having success.
    private function build_api_url($restaurant_id, $endpoint, $sort, $limit){
        $id_secret = $this->get_id_and_secret();
        $url = "https://api.foursquare.com/v2/venues/" . $restaurant_id . "/" . $endpoint . "?client_id=" . $id_secret[0] . "&client_secret=" .
            $id_secret[1] . "&v=20171123&sort=" . $sort . "&limit=" . $limit . "&offset=" . $limit;
        return file_get_contents($url);
    }

    #Example: "I want 3 general photos from this venue".  check if photos exist for this restaurant, if they do, don't load in more.
    #https://api.foursquare.com/v2/venues/4aa7f646f964a5203d4e20e3/photos?v=20171125&client_id=WCJXKICZZ3FVGLCCQNJQ3XL3WXDCX5GVFRF5E1PYLQ5MUEMI&client_secret=WQU20OQPUUCLSTZUFNL5C3DH52JZ3AHFT1XQ1WYIRZM3QTMH&group=venue&limit=5
    #{"meta":{"code":200,"requestId":"5a19f690f594df3e1542aeae"},"response":{"photos":{"count":1830,"items":[{"id":"5a080569bed483485caa0db3","createdAt":1510475113,"source":{"name":"Swarm for iOS","url":"https:\/\/www.swarmapp.com"},"prefix":"https:\/\/igx.4sqi.net\/img\/general\/","suffix":"\/129685696_sc_R5gl5efHuHtuNmY1sA_AtorTxfyIdYfcRxxTEsbk.jpg","width":1920,"height":1279,"user":{"id":"129685696","firstName":"Polina","lastName":"Komisarova","gender":"female","photo":{"prefix":"https:\/\/igx.4sqi.net\/img\/user\/","suffix":"\/129685696-VP2OK4NSBQQM2YKH.jpg"}},"visibility":"public"},{"id":"5a0769e80802d42aa2d5fa94","createdAt":1510435304,"source":{"name":"Swarm for iOS","url":"https:\/\/www.swarmapp.com"},"prefix":"https:\/\/igx.4sqi.net\/img\/general\/","suffix":"\/1771373_fSqYkTY8b8Z-smAs55-3R0H3jcpBoTWC9gOMkkjbKLg.jpg","width":1920,"height":1440,"user":{"id":"1771373","firstName":"Stanford","gender":"male","photo":{"prefix":"https:\/\/igx.4sqi.net\/img\/user\/","suffix":"\/JEPKZYXLYV02KOJV.jpg"}},"visibility":"public"},{"id":"5a076530c0f16370f3a110ab","createdAt":1510434096,"source":{"name":"Swarm for iOS","url":"https:\/\/www.swarmapp.com"},"prefix":"https:\/\/igx.4sqi.net\/img\/general\/","suffix":"\/804080_cMHcsfH9VAEkxF3jXBHLVDhvmEO5AU4nLNxH8Fwvr5g.jpg","width":1920,"height":1440,"user":{"id":"804080","firstName":"Runar","lastName":"Petursson","gender":"male","photo":{"prefix":"https:\/\/igx.4sqi.net\/img\/user\/","suffix":"\/804080-PSS0EQO4ZEG5PHN3.jpg"}},"visibility":"public"}]}}}

    #If we want ratings as well, we can expand this photos api call by removing the /photos endpoint and taking just /venues/{venue_id}.
    #  This will give us rating, as well as other information for the api we may need.
    public function make_photos_api_call($restaurant_table_id, $restaurant_id){
        $id_secret = $this->get_id_and_secret();
        $fourSearch = file_get_contents("https://api.foursquare.com/v2/venues/" .
            $restaurant_id . "/photos?client_id=" . $id_secret[0] . "&client_secret=" . $id_secret[1] .
            "&v=20171123&group=venue&limit=5");

        if (is_null($fourSearch)){return;}
        $this->preload_photo_urls($fourSearch, $restaurant_table_id);
    }

    public function preload_photo_urls($fourSearch, $restaurant_table_id){
        $parsedJson = json_decode($fourSearch);

        if  (!$this->check_response_code($parsedJson->meta)){
            return FALSE;
        }

        foreach ($parsedJson->response->photos->items as $photo){
            #Load image data for each image found.
            try {
                #Build the image URL.
                $image_url = $photo->prefix . $photo->width . "x" . $photo->height . $photo->suffix;
                $data = array('api_id' => $photo->id,
                    'image_url' => $image_url,
                    'restaurant_id' => $restaurant_table_id
                );
                $this->load_item('photos', $data);
            }catch(Exception $e){
                #var_dump($e);
            }
        }
    }

    public function get_restaurant_photos($restaurant_id, $limit = 5, $order = 'ASC'){
    	$this->db->where('restaurant_id', $restaurant_id);
    	$this->db->limit($limit);
    	$this->db->order_by('id', $order);
    	$query = $this->db->get('photos');

    	if (empty($query)) {
    		return FALSE;
    	}

    	return $query->result_array();
    }

    private function preload_reviews($fourSearch, $restaurant_table_id){
        #Parse through the resulting JSON and load it into the database.
        $parsedJson = json_decode($fourSearch);

        #something something if code not 200, don't load.
        if  (!$this->check_response_code($parsedJson->meta)){
            return FALSE;
        }

        #foreach tip in items
        foreach ($parsedJson->response->tips->items as $review){
            try {
                $api_id = $review->id;
                $body = $review->text;

                $data = array('restaurant_id' => $restaurant_table_id,
                    'author_id' => 2,
                    'body' => $body,
                    'api_id' => $api_id
                );
                $this->load_item('reviews', $data);
                #'author_id' = $author_id,
            }catch(Exception $e){
                #var_dump($e);
            }
        }
    }

	#do a load of restaurants from the API (this data is static for demonstration purposes).
	private function preload_restaurants($srJson){
		$parsedJson = json_decode($srJson);

        if  (!$this->check_response_code($parsedJson->meta)){
            return FALSE;
        }

		foreach($parsedJson->response->venues as $v)
		{
		    $loadable_venue = TRUE;
			try{
			    #If there is a venue, and it has categories, and it has nothing in the venuechains JSON, it passes muster.
			    if ($v != null && $v->categories != null && empty($v->venueChains)){
			        $venue_categories = array();
			        foreach ($v->categories as $cat){
			            #Look for this category, associate it with that category in the joining table if it exists.  If it doesn't exist, it's not a restaurant we want.
                        $catQuery = $this->db->select('id')->where('api_id', $cat->id)->get('tags');
                        $result = $catQuery->row();
                        if (!is_null($result)){
                            $venue_categories[] = $result->id;
                        }
                        else{
                            $loadable_venue = FALSE;
                        }
                    }

                    $restQuery = $this->db->select('id')->where('api_id', $v->id)->get('restaurants');
                    $restResult = $restQuery->row();
                    if (!is_null($restResult)){
                        $loadable_venue = FALSE;
                    }
                    if (!$loadable_venue){continue;}
                    $data = array(
                        'restaurant_type' => $v->categories[0]->id,
                        'name' => $v->name,
                        'addr_1' => $v->location->address,
                        'city' => $v->location->city,
                        'state_prov_code' => $v->location->state,
                        'country' => $v->location->country,
                        'api_id' => $v->id
                    );
                    #'api_id' => $v->id
                    #api_id is a reference to the loaded api category, and is likely no longer needed now that the joining table is set up.
                    #This is the 'cuisine type' of the restaurant - IMO it belongs here somewhere, but The People don't want a cuisine table, so that doesnt exist.

                    #Might want to eventually load the joining table - is it needed?
                    $restaurant_id = $this->load_item('restaurants', $data);

                    #Restaurant loaded in - add in the values to the joining table.
                    foreach ($result as $tag_id){
                        $data = array(
                            'restaurant_id' => $restaurant_id,
                            'tag_id' => $tag_id
                        );
                        $this->load_item('restaurant_tags', $data);
                    }

                    #Add associated reviews and photos.
                    $this->make_reviews_api_call($restaurant_id, $v->id);
                    $this->make_photos_api_call($restaurant_id, $v->id);
                }
			}
			catch(Exception $e){
                #var_dump($e);
			}
		}
	}

    public function load_item($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

	// WIP
	public function add_tags_to_restaurant($restaurant_id, $tag_ids){
		if ( !isset($restaurant_id) || !isset($tag_ids) || empty($tag_ids)) {
			return FALSE; // Not enough data
		}

		$ids = [];

		foreach ($tag_ids as $tag)
		{
			// Check if this association is already in the database
			$this->db->where("restaurant_id", $restaurant_id);
			$this->db->where("tag_id", $tag);

			$query = $this->db->get("restaurant_tags");
			if ($query->num_rows() <= 0)
			{
				$data = [
					'restaurant_id' => $restaurant_id,
					'tag_id'		=> $tag
				];
				$this->db->insert("restaurant_tags", $data);
				$id = $this->db->insert_id();
				$ids[] = $id;
			}
			else
			{
				$row = $query->row();
				if (isset($row))
				{
					$ids[] = $row->id;
				}
				else
				{
					$ids[] = -1;
				}
			}
		}
		return $ids;
	}

	public function clear_tags_from_restaurant($restaurant_id)
	{
		$this->db->where('restaurant_id', $restaurant_id);
		$this->db->delete('restaurant_tags');
	}

	public function remove_tag_from_restaurant($restaurant_id, $tag_id)
	{
		$this->db->where('restaurant_id', $restaurant_id);
		$this->db->where('tag_id', $tag_id);
		$this->db->delete('restaurant_tags');
	}

	# Create or update restaurant (update if id is provided)
	public function set_restaurant($id = FALSE) {
		$data = array(
			'restaurant_type' => $this->input->post('restaurant_type'),
			'name' => $this->input->post('name'),
			'addr_1' => $this->input->post('addr_1'),
			'city' => $this->input->post('city'),
			'state_prov_code' => $this->input->post('state_prov_code'),
			'country' => $this->input->post('country')
		);

		if ($id === FALSE) {
			$this->db->insert('restaurants', $data);
			$id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('id', $id);
			$this->db->update('restaurants', $data);
		}

		// Add the tags to this restaurant
		$this->add_tags_to_restaurant($id, $this->input->post('tags'));

		return $id;
	}


	// Get all tags assigned to this restaurant
	public function get_restaurant_tags($id) {
		if (!isset($id))
		{
			return [
				'success'=>FALSE,
				'message'=>'No Restaurant ID Specified',
				'data'=>[]
			];
		}

		$this->db->select('restaurant_id, tags.name AS tag_name, tags.id AS tag_id');
		$this->db->from('restaurant_tags');
		$this->db->join('tags', 'restaurant_tags.tag_id = tags.id');
		$this->db->where('restaurant_tags.restaurant_id', $id);
		$query = $this->db->get();

		return [
			'success'=>TRUE,
			'message'=>'Got all tags',
			'data'=>$query->result_array()
		];
	}

	public function get_amount_of_restaurants($amount = FALSE) {
		if (!isset($amount)) {
			$amount = 4;
		}

		$this->db->limit($amount);
		$this->db->order_by('id', 'RANDOM');
		$query = $this->db->get('restaurants');

		return $query->result_array();
	}

	# Returns all restaurants if no id is specified
	public function get_restaurant($id = NULL) {

		if (isset($id)) {
			$this->db->where('restaurants.id', $id);
		}
		$query = $this->db->get('restaurants');

		$result = [];
		foreach($query->result_array() as $row)
		{
			// Get the tags for this restaurant
			$tagResult = $this->get_restaurant_tags($row['id']);
			if($tagResult['success'])
			{
				$row['tags'] = [];
				foreach($tagResult['data'] as $tag)
				{
					// Push the tag into the row's tag array
					$row['tags'][] = [
						'name'	=>$tag['tag_name'],
						'id'	=>$tag['tag_id']
					];
				}
				// Push the row into the result
				$result[] = $row;
			}
		}

		return $result;
	}

	# Return list of [amt] restaurants by [term] in a given [column]
	# Ordering column defaults to rating, while ordering type defaults to descending
	public function search_restaurants($terms, $column = 'all', $ord_col = 'rating', $ord_val = 'desc') {
		# Limit search scope
		$search_amount = 100;
		$term = strtolower($terms);

		if ($column == 'all') {
			$this->db->like('LOWER(name)', $term);
			$this->db->or_like('LOWER(restaurant_type)', $term);
			$this->db->or_like('LOWER(city)', $term);
		}
		else
		{
			$this->db->like('LOWER('.$column.')', $term, 'both');
		}
		$this->db->order_by($ord_col, $ord_val);
		$this->db->limit($search_amount);
		$query = $this->db->get('restaurants');
		return $query->result_array();
	}

	# Delete a restaurant
	public function delete_restaurant($id = FALSE) {
		if ($id === FALSE || !$this->users_model->isadmin()) {
			show_404();
			return;
		}

		$this->clear_tags_from_restaurant($id);

		$this->db->where('id', $id);
		return $this->db->delete('restaurants');
	}
	# Returns the name of a single restaurant (for playlists)
	public function get_name($id = NULL) {

		if (!isset($id)){
			return FALSE;
		}

		$this->db->where('restaurants.id', $id);
		$result = $this->db->get('restaurants')->row()->name;

		return $result;
	}
  public function check_response_code($meta){
      if (is_numeric($meta->code)){
          if ((int)$meta->code == 200){
              return TRUE;
          }else{
              var_dump($meta->code);
              var_dump($meta->errorDetail);
              return FALSE;
          }
      }
  }

  public function get_restaurants_by_ids($ids) {
      if (isset($ids) && !empty($ids)) {
          $this->db->where_in('id', $ids);
          $query = $this->db->get('restaurants');
          return $query->result_array();
      }
  }

	public function update_rating($restaurant_id, $mode, $sign){
		if (!isset($restaurant_id)) {
			return ['message'=>"no restaurant"];
		}

		if($mode == 'upvote'){
			if($sign == TRUE){
				$this->db->set('upvotes','upvotes+1', FALSE);
			}
			else{
				$this->db->set('upvotes', 'upvotes-1', FALSE);
			}
		}
		else{
			if($sign == TRUE){
				$this->db->set('downvotes', 'downvotes+1', FALSE);
			}
			else{
				$this->db->set('downvotes', 'downvotes-1', FALSE);
			}
		}
		$this->db->where('id', $restaurant_id);
		$this->db->update('restaurants');
		//get the upvotes and the downvotes from restaurants
		$query = $this->db->select('upvotes, downvotes')->get_where('restaurants',['id'=>$restaurant_id])->result_array();
		$result = $query[0];
		return $result;
	}

}