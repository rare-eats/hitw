<?php

class Restaurants_model extends CI_Model {
	
	public function __construct() {
		$this->load->database();
	}
	
	public function load_food_categories(){
		$client_id = "WCJXKICZZ3FVGLCCQNJQ3XL3WXDCX5GVFRF5E1PYLQ5MUEMI";
		$client_secret = "WQU20OQPUUCLSTZUFNL5C3DH52JZ3AHFT1XQ1WYIRZM3QTMH";
		
		#This is all venue categories.
		$fourSearch = file_get_contents("https://api.foursquare.com/v2/venues/categories?client_id=" . $client_id .
										"&client_secret=" . $client_secret . "&v=20171111");
		$this->parse_categories($fourSearch);
	}
	
	public function parse_categories($srJson){
		#Some json data taken from foursquare.  This should be taken on an api request.
		
		try{
			$parsedJson = json_decode($srJson);
			$response = $parsedJson->response;
			$categories = $response->categories;
			$foodCat = "";
			
			#Iterate through top level categories until we find the one labeled as Food.
			foreach ($categories as $cat){
				if ($cat->name == 'Food' || $cat->name == 'food'){
					$foodCat = $cat;
					continue;
				}
			}

			#A CSV List of category names and IDs.
            $listOfNames = $this->get_subcategories($foodCat);

            $catNameIdArray = explode(",", $listOfNames);
            $catIds = array();
            $catNames = array();
            foreach ($catNameIdArray as $entry){
                if (!empty($entry)) {
                    $split = explode(':', $entry);
                    array_push($catNames, $split[0]);
                    array_push($catIds, $split[1]);
                }
            }

            #we now have all IDs and all category shortNames, and these can be written to the database.
            #The only other relevant data here is an icon url which feels not relevant enough for our purposes.

		}catch(Exception $e){
		}
	}

	#Yey Recursion, get dem category names.
	public function get_subcategories($srJson){
	    if (sizeof($srJson->categories) <= 0){
	        #end recursion.
            return $srJson->shortName . ":" . $srJson->id . ",";
        }
        else {
            $listOfNames = "";
            foreach ($srJson->categories as $subcat) {
                $listOfNames .= $this->get_subcategories($subcat);
            }
            return $srJson->shortName . ":" . $srJson->id .  "," . $listOfNames;
        }
    }

	
	//TODO: make this call the api at a static URL.
		//THEN ->> Modify the api call to be modular.
	public function make_restaurants_api_call(){
		$client_id = "WCJXKICZZ3FVGLCCQNJQ3XL3WXDCX5GVFRF5E1PYLQ5MUEMI";
		$client_secret = "WQU20OQPUUCLSTZUFNL5C3DH52JZ3AHFT1XQ1WYIRZM3QTMH";
		
		#this is the general 'food' category.
		$categoryId = "4d4b7105d754a06374d81259";
		$fourSearch = file_get_contents("https://api.foursquare.com/v2/venues/search?client_id=" . $client_id .
										"&client_secret=" . $client_secret . "&categoryId=" . $categoryId .
										"&v=20171111&limit=10&intent=browse&near=Vancouver%2C%20BC");
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
				$categories = $v->categories;
				$lat = $location->lat;
				$lng = $location->lng;
				
				$apiID = $v->id;
				$streetAddress = $location->address;
				$city = $location->city;
				$prvCode = $location->state;
				$country = $location->country;
				$postalCode = "";
				if (!empty($location->postalCode)){
					$postalCode = ", " . $location->postalCode;
				}
				$address = "";
				$tags = "";
				
				$address .= $streetAddress . ", " . $city . ", " . $prvCode . $postalCode;
				
				
				foreach ($categories as $cat)
				{
					#Extract each tag name for this restaurant.
					$tags .= $cat->shortName;
				}
				
				$this->load_restaurant($tags, $name, $streetAddress, $city, $prvCode, $country);
			}
			catch(Exception $e){
				#Some value above was null.
			}
		}
	}
	
	public function load_restaurant($tag, $name, $addr1, $city, $prv, $country){
		$data = array(
			'restaurant_type' => $tag,
			'name' => $name,
			'addr_1' => $addr1,
			'city' => $city,
			'state_prov_code' => $prv,
			'country' => $country
		);
		
		#should have some sort of try/catch here.
		$this->db->insert('restaurants', $data);
		return $this->db->insert_id();
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
			return $this->db->insert_id();
		}
		else
		{
			$this->db->where('id', $id);
			$this->db->update('restaurants', $data);
			return $id;
		}
	}

	# Return list of [amt] restaurants by [term] in a given [column]
	# Ordering column defaults to rating, while ordering type defaults to descending
	public function search_restaurant($column = 'all', $term, $amt = 5, $ord_col = 'rating', $ord_val = 'desc') {
		# Limit search scope
		if ($amt < 1) {
			$amt = 1;
		}
		if ($amt > 100) {
			$amt = 100;
		}

		if ($column == 'all') {
			$this->db->like('restaurant_type', $term);
			$this->db->or_like('name', $term);
		}
		else 
		{
			$this->db->like($column, $term, 'both');
		}
		$this->db->order_by($ord_col, $ord_val);
		$this->db->limit($amt);
		return $this;
	}

	# Returns all restaurants if no id is specified
	public function get_restaurant($id = FALSE) {
		if ($id === FALSE) {
			$query = $this->db->get('restaurants');
			return $query->result_array();
		}

		$this->db->where('id', $id);
		$query = $this->db->get('restaurants');
		return $query->row_array();
	}

	# Get a list of [amt] restaurants by [type]
	public function get_restaurants_by_type($type = 'happy', $amt, $ord_col, $ord_val) {
		$query = search_restaurant('restaurant_type', $type, $amt, $ord_col, $ord_val);
		return $query->result_array();
	}

	# Get a list of [amt] restaurants in [city]
	public function get_restaurants_by_city($city = 'Vancouver', $amt, $ord_col, $ord_val) {
		$query = search_restaurant('city', $city, $amt, $ord_col, $ord_val);
		return $query->result_array();
	}

	# Get a list of [amt] restaurants by list of [terms]
	public function get_restaurant_by_search($terms, $amt, $ord_col, $ord_val) {
		$query = search_restaurant('all', $terms, $amt, $ord_col, $ord_val);
		return $query->result_array();
	}

	# Delete a restaurant
	public function delete_restaurant($id = FALSE) {
		if ($id === FALSE) {
			show_404();
		}

		$this->db->where('id', $id);
		return $this->db->delete('restaurants');
	}
}