<?php
class Tags_model extends CI_Model {
	public function __construct() {
		$this->load->database();
	}

	public function add_tag($data)
	{
		if( !isset($data) )
		{
			return [
				'success'=>FALSE,
				'message'=>'Insufficient data provided to add_restaurant_tag',
				'data'=>$data
			]; // Not enough data
		}

		$this->db->insert('tags', $data);
		$data['id'] = $this->db->insert_id();
		return [
			'success'=>TRUE,
			'message'=>'Inserted new tag',
			'data'=>$data
		];
	}

	public function delete_tag($data)
	{
		if (!isset($data))
		{
			return [
				'success'=>FALSE,
				'message'=>'Insufficient data provided to delete_restaurant_tag',
				'data'=>$data
			]; // Not enough data
		}

		// Remove this tag from all associations
		$this->db->where('tag_id', $data['id']);
		$this->db->delete('restaurant_tags');

		// Remove the tag
		$this->db->where('id', $data['id']);
		$this->db->delete('tags');
		return [
			'success'=>TRUE,
			'message'=>'Removed existing tag',
			'data'=>$data
		];
	}

	public function get_tags($restaurant_id = NULL)
	{
		if (isset($restaurant_id))
		{
			$this->db->where('restaurant_id', $restaurant_id);
		}
        $this->db->order_by('name','ASC');
		$query = $this->db->get('tags');
		return [
			'success'=>TRUE,
			'data'=>$query->result_array()
		];
	}

    public function get_restaurants_by_tags($name) {
        $query = FALSE;
        if (!empty($name)) {
            $query = $this->db->query(<<<sql
                SELECT
                    rt.restaurant_id
                FROM
                    tags AS t,
                    restaurant_tags AS rt
                WHERE
                    t.id = rt.tag_id AND
                    (t.name LIKE '%{$name[0]}%' OR t.name LIKE '%{$name[1]}%')
sql
            );
            $row = $query->result_array();
            return $row;
        }
    }

    // get tags by id
    public function get_tags_by_id($tag_ids = NULL) {
        $query = FALSE;
        if (isset($tag_ids)) {
            $this->db->select('restaurant_id');
            $this->db->where_in('tag_id', $tag_ids);
            $query = $this->db->get('restaurant_tags');
            return $query->result_array();
        }

    }

    #a temporary function that will block loading more tags from the API if there are already 5 - this is currently required
    #until we figure out a graceful way to deal with api_id collisions when adding tags.
    public function check_if_loaded(){
        $query = $this->db->get('tags');
        if (sizeof($query->result()) > 5){
            return true;
        };
        return false;
    }

	#pre-load restaurant categories into the DB.
    public function make_tags_api_call(){
        #check if we should load.
        if ($this->check_if_loaded()){
            return true;
        }


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
                    try{
                        $this->load_tag($split[0], $split[1]);
                    }catch(Exception $f){

                    }

                }
            }

            #we now have all IDs and all category shortNames, and these can be written to the database.
            #The only other relevant data here is an icon url which feels not relevant enough for our purposes.

            #var_dump($catNames);

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

    public function load_tag($name, $api_id){
        //Filter out food categories we don't want.
        if (in_array(strtolower($name), array('food', 'coffee shop', 'restaurant', 'bubble tea shop', 'cafeteria', 'deli / bodega', 'diner', 'fast food', 'food court', 'labour canteen', 'hot dog joint', 'juice bar', 'tea room', 'truck stop', 'market', 'grocery store', 'food & drink shop', 'supermarket')))
        {
            return;
        }

        $data = array(
            'name' => $name,
            'api_id' => $api_id
        );

        try{
            $this->db->insert('tags', $data);
            return $this->db->insert_id();
        }catch(Exception $e){
            return;
        }

    }

}