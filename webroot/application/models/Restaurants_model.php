<?php

class Restaurants_model extends CI_Model {
	
	public function __construct() {
		$this->load->database();
	}

	#a temporary function that will block loading more restaurants if there are already 5 - this is currently required
    #until we figure out a graceful way to deal with api_id collisions when adding restaurants.
	public function check_if_restaurants_loaded(){
	    $query = $this->db->get('restaurants');
	    if (sizeof($query->result()) > 5) return true;
	    return false;
    }

    public function check_if_reviews_loaded(){
        $query = $this->db->get('reviews');
        if (sizeof($query->result()) > 5) return true;
        return false;
    }

    public function make_photos_api_call($restaurant_id){
        #Example: "I want 3 general photos from this venue"
        #check if photos exist for this restaurant, if they do, don't load in more.
        #if ($this->check_if_reviews_loaded($venueId)){
#	        return true;
#       }
        #https://api.foursquare.com/v2/venues/4aa7f646f964a5203d4e20e3/photos?v=20171125&client_id=WCJXKICZZ3FVGLCCQNJQ3XL3WXDCX5GVFRF5E1PYLQ5MUEMI&client_secret=WQU20OQPUUCLSTZUFNL5C3DH52JZ3AHFT1XQ1WYIRZM3QTMH
        #&group=venue&limit=5
        #{"meta":{"code":200,"requestId":"5a19f690f594df3e1542aeae"},"response":{"photos":{"count":1830,"items":[{"id":"5a080569bed483485caa0db3","createdAt":1510475113,"source":{"name":"Swarm for iOS","url":"https:\/\/www.swarmapp.com"},"prefix":"https:\/\/igx.4sqi.net\/img\/general\/","suffix":"\/129685696_sc_R5gl5efHuHtuNmY1sA_AtorTxfyIdYfcRxxTEsbk.jpg","width":1920,"height":1279,"user":{"id":"129685696","firstName":"Polina","lastName":"Komisarova","gender":"female","photo":{"prefix":"https:\/\/igx.4sqi.net\/img\/user\/","suffix":"\/129685696-VP2OK4NSBQQM2YKH.jpg"}},"visibility":"public"},{"id":"5a0769e80802d42aa2d5fa94","createdAt":1510435304,"source":{"name":"Swarm for iOS","url":"https:\/\/www.swarmapp.com"},"prefix":"https:\/\/igx.4sqi.net\/img\/general\/","suffix":"\/1771373_fSqYkTY8b8Z-smAs55-3R0H3jcpBoTWC9gOMkkjbKLg.jpg","width":1920,"height":1440,"user":{"id":"1771373","firstName":"Stanford","gender":"male","photo":{"prefix":"https:\/\/igx.4sqi.net\/img\/user\/","suffix":"\/JEPKZYXLYV02KOJV.jpg"}},"visibility":"public"},{"id":"5a076530c0f16370f3a110ab","createdAt":1510434096,"source":{"name":"Swarm for iOS","url":"https:\/\/www.swarmapp.com"},"prefix":"https:\/\/igx.4sqi.net\/img\/general\/","suffix":"\/804080_cMHcsfH9VAEkxF3jXBHLVDhvmEO5AU4nLNxH8Fwvr5g.jpg","width":1920,"height":1440,"user":{"id":"804080","firstName":"Runar","lastName":"Petursson","gender":"male","photo":{"prefix":"https:\/\/igx.4sqi.net\/img\/user\/","suffix":"\/804080-PSS0EQO4ZEG5PHN3.jpg"}},"visibility":"public"}]}}}
        $client_id = "WCJXKICZZ3FVGLCCQNJQ3XL3WXDCX5GVFRF5E1PYLQ5MUEMI";
        $client_secret = "WQU20OQPUUCLSTZUFNL5C3DH52JZ3AHFT1XQ1WYIRZM3QTMH";

        $fourSearch = file_get_contents("https://api.foursquare.com/v2/venues/" .
            $restaurant_id . "/photos?client_id=" . $client_id . "&client_secret=" . $client_secret .
            "&v=20171123&group=venue&limit=5");

        $this->preload_photo_urls($fourSearch, $restaurant_id);
    }

    public function preload_photo_urls($fourSearch, $restaurant_id){

        $parsedJson = json_decode($fourSearch);

        #TODO: If code not 200, don't load, something like that goes here.
        $meta = $parsedJson->meta;
        $code = $meta->code;

        $response = $parsedJson->response;
        $items = $response->photos->items;
        foreach ($items as $photo){
            #Build image URL string
            $imgId = $photo->id;
            $imgTaken = $photo->createdAt;
            $imgUrl = $photo->prefix . $photo->width . "x" . $photo->height . $photo->suffix;

            #Load image data into SOMEWHERE.
        }
    }

    public function make_reviews_api_call($restaurant_id){
        #want this in when we get the ability to load in by api key - then check to see how many reviews are associated with a specific restaurant.
	    #if ($this->check_if_reviews_loaded($venueId)){
#	        return true;
#        }

        #backup client id: IREJNTZAUVFPPDAEJ2EY0L4AHKFGYMPUB4RKEHJG5QK20AXS
        #backup secret: WVP24YF0O504XZ4QMOQ3TPKZ3DZI3KYYO3ODP3DR0SKHZ2FX
        $client_id = "WCJXKICZZ3FVGLCCQNJQ3XL3WXDCX5GVFRF5E1PYLQ5MUEMI";
        $client_secret = "WQU20OQPUUCLSTZUFNL5C3DH52JZ3AHFT1XQ1WYIRZM3QTMH";

        #https://api.foursquare.com/v2/venues/4aa7f646f964a5203d4e20e3/tips?v=20171123&sort=friends&limit=5
        #https://api.foursquare.com/v2/venues/4aa7f646f964a5203d4e20e3/tips?client_id=
        #WCJXKICZZ3FVGLCCQNJQ3XL3WXDCX5GVFRF5E1PYLQ5MUEMI&client_secret=WQU20OQPUUCLSTZUFNL5C3DH52JZ3AHFT1XQ1WYIRZM3QTMH
        #&v=20171123&sort=recent&limit=5&offset=5

        $fourSearch = file_get_contents("https://api.foursquare.com/v2/venues/" .
            $restaurant_id . "/tips?client_id=" . $client_id . "&client_secret=" . $client_secret .
            "&v=20171123&sort=recent&limit=5&offset=5");

        $this->preload_reviews($fourSearch, $restaurant_id);
    }

    public function preload_reviews($fourSearch, $restaurant_id){
        #Parse through the resulting JSON and load it into the database.
        $parsedJson = json_decode($fourSearch);
        #something something if code not 200, don't load.
        $meta = $parsedJson->meta;
        $code = $meta->code;

        $response = $parsedJson->response;
        $items = $response->tips->items;

        #foreach tip in items
        #foreach($venues as $v)
        foreach ($items as $review){
            $api_id = $review->id;
            $body = $review->text;
            #https:\/\/igx.4sqi.net\/img\/general\/original\/7711715_gjwwPjf3psCUv8Ftx4fe2MDakydOJ6qZ3gvdxalu6ZA.jpg
            $reviewImage = $review->photourl;
            $author_id = $review->user->id;

            try {
                $data = array('restaurant_id' => $restaurant_id,
                    'body' => $body,
                    'api_id' => $api_id);
                $this->load_review($data);
                #'author_id' = $author_id,
            }catch(Exception $e){

            }
        }
    }
    public function load_review($data){
        $this->db->insert('reviews', $data);
        return $this->db->insert_id();
    }

    #public function load_restaurant_tag($restaurant_id, $tag_id){
    #$data = array(
    #'restaurant_id' => $restaurant_id,
    #'tag_id' => $tag_id
    #);
    #$this->db->insert('restaurant_tags', $data);
    #return $this->db->insert_id();
    #}

    #Dream: User clicks on category, we load from that category if not yet loaded.

	//TODO: make this call the api at a static URL.
		//THEN ->> Modify the api call to be modular.
	public function make_restaurants_api_call(){
	    #check if we should load.
        if ($this->check_if_restaurants_loaded()){
            return true;
        }

		$client_id = "WCJXKICZZ3FVGLCCQNJQ3XL3WXDCX5GVFRF5E1PYLQ5MUEMI";
		$client_secret = "WQU20OQPUUCLSTZUFNL5C3DH52JZ3AHFT1XQ1WYIRZM3QTMH";
		
		#this is the general 'food' category.
		$categoryId = "4d4b7105d754a06374d81259";
		$fourSearch = file_get_contents("https://api.foursquare.com/v2/venues/search?client_id=" . $client_id .
										"&client_secret=" . $client_secret . "&categoryId=" . $categoryId .
										"&v=20171111&limit=40&intent=browse&near=Vancouver%2C%20BC");
		$this->preload_restaurants($fourSearch);
	}
	
	#Dummy data for restaurants.
	public function preload_restaurants($srJson = null){
		#Some json data taken from foursquare.  This should be taken on an api request.
		if (is_null($srJson)){
			return;
		}
		
		$parsedJson = json_decode($srJson);
		$response = $parsedJson->response;
		$venues = $response->venues;
		
		$tags = "";
		$name = "";
		$streetAddress = "";
		$city = "";
		$pvCode = "";
		$country = "";
		
		foreach($venues as $v)
		{
			try{
				$name = $v->name;
				$location = $v->location;
				$category_id = $v->categories[0]->id;
				$restaurant_type = $v->categories[0]->id;
				$lat = $location->lat;
				$lng = $location->lng;
				
				$api_id = $v->id;
				$streetAddress = $location->address;
				$city = $location->city;
				$prvCode = $location->state;
				$country = $location->country;
				$postalCode = "";
				if (!empty($location->postalCode)){
					$postalCode = ", " . $location->postalCode;
				}
				$address = "";
				
				$address .= $streetAddress . ", " . $city . ", " . $prvCode . $postalCode;

				#foreach ($categories as $cat)
				#{
					#Extract each tag name for this restaurant.
					#$tags .= $cat->shortName;
				#}

                #Instead of this, just grab the first category listed.  Most only have 1 anyways.


                #once the restaurant is loaded, load the association table between restaurants and tags.
				$this->load_restaurant($restaurant_type, $name, $streetAddress, $city, $prvCode, $country, $api_id);

				#for when we have restaurant to tag linking working.
				#$this->load_restaurant_tag($api_id, $category_id);
			}
			catch(Exception $e){
				#Some value above was null.
			}
		}
	}
	public function load_restaurant_tag($restaurant_id, $tag_id){
	    $data = array(
	        'restaurant_id' => $restaurant_id,
            'tag_id' => $tag_id
        );
        $this->db->insert('restaurant_tags', $data);
        $this->make_reviews_api_call($restaurant_id);
        return $this->db->insert_id();
    }


	
	public function load_restaurant($restaurant_type, $name, $addr1, $city, $prv, $country, $api_id){
	    #load restaurants.
		$data = array(
			'restaurant_type' => $restaurant_type,
			'name' => $name,
			'addr_1' => $addr1,
			'city' => $city,
			'state_prov_code' => $prv,
			'country' => $country,
            'api_id' => $api_id
		);
		try {
            #should have some sort of try/catch here.
            $this->db->insert('restaurants', $data);
            return $this->db->insert_id();
        }catch(Exception $f){
		    return;
        }
	}

	// TODO: add_tags_by_name_to_restaurant($restaurant_id, $tag_names, $create_if_needed = FALSE)

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

		// echo var_dump($term);
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

	# Get a list of [amt] restaurants by list of [terms]
	public function get_restaurant_by_search($terms, $ord_col, $ord_val) {
		$query = search_restaurant('all', $terms, $ord_col, $ord_val);
		return $query;
	}

	# Delete a restaurant
	public function delete_restaurant($id = FALSE) {
		if ($id === FALSE) {
			show_404();
		}

		$this->clear_tags_from_restaurant($id);

		$this->db->where('id', $id);
		return $this->db->delete('restaurants');
	}
}