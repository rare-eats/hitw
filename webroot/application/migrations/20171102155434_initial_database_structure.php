<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Initial_database_structure extends CI_Migration {

	public function up()
	{
		// restaurants Table Setup
		$this->dbforge->add_field('id');
		$this->dbforge->create_table('restaurants');
		// End restaurants Table Setup

		// tags Table Setup
		$this->dbforge->add_field('id');
		$this->dbforge->create_table('tags');
		// End tags Table Setup

		// users Table Setup
		$this->dbforge->add_field('id');
		$this->dbforge->create_table('users');
		// End users Table Setup

		// resturant_tags Table Setup
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('restaurant_id integer references restaurants (id)');
		$this->dbforge->add_field('tag_id integer references tags (id)');
		$this->dbforge->create_table('restaurant_tags');
		// End resturant_tags Table Setup

		// reviews Table Setup
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('restaurant_id integer references restaurants (id)');
		$this->dbforge->add_field('author_id integer references users (id)');
		$this->dbforge->create_table('reviews');
		// End reviews Table Setup

		// user_playlists Table Setup
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('author_id integer references users (id)');
		$this->dbforge->create_table('user_playlists');
		// End user_playlists Table Setup

		// user_playlist_contents Table Setup
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('playlist_id integer references user_playlists (id)');
		$this->dbforge->add_field('restaurant_id integer references restaurants (id)');
		$this->dbforge->create_table('user_playlist_contents');
		// End user_playlist_contents Table Setup

		// auto_playlists Table Setup
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('user_id integer references users (id)');
		$this->dbforge->create_table('auto_playlists');
		// End auto_playlists Table Setup

		// auto_playlist_contents Table Setup
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('playlist_id integer references auto_playlists (id)');
		$this->dbforge->add_field('restaurant_id integer references restaurants (id)');
		$this->dbforge->create_table('auto_playlist_contents');
		// End auto_playlist_contents Table Setup

		// user_playlist_subscriptions Table Setup
		$this->dbforge->add_field('id');
		$this->dbforge->add_field('user_id integer references users (id)');
		$this->dbforge->add_field('playlist_id integer references user_playlists (id)');
		$this->dbforge->create_table('user_playlist_subscriptions');
		// End user_playlist_subscriptions Table Setup
	}

	public function down()
	{
		// Drop tables in reverse order of creating them
		$this->dbforge->drop_table('user_playlist_subscriptions');
		$this->dbforge->drop_table('auto_playlist_contents');
		$this->dbforge->drop_table('auto_playlists');
		$this->dbforge->drop_table('user_playlist_contents');
		$this->dbforge->drop_table('user_playlists');
		$this->dbforge->drop_table('reviews');
		$this->dbforge->drop_table('restaurant_tags');
		$this->dbforge->drop_table('users');
		$this->dbforge->drop_table('tags');
		$this->dbforge->drop_table('restaurant');
	}
}