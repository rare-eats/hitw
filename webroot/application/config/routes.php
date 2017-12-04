<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['userplaylists/create'] = 'userplaylists/create';
$route['userplaylists/edit/(:any)'] = 'userplaylists/edit/$1';
$route['userplaylists/add_to_list'] = 'userplaylists/add_to_list';
$route['userplaylists/user/(:num)'] = 'userplaylists/user/$1';
$route['userplaylists/(:num)/content/(:num)/delete'] = 'userplaylists/content_delete/$1/$2';
$route['userplaylists/search'] = 'userplaylists/search';
$route['userplaylists/(:any)'] = 'userplaylists/view/$1';
$route['userplaylists'] = 'userplaylists/search';

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['restaurants/tags']['PUT'] = 'restaurant_tags/add_tag';
$route['restaurants/tags']['DELETE'] = 'restaurant_tags/remove_tag';
$route['restaurants/tags']['GET'] = 'restaurant_tags';

$route['restaurants/(:num)/tags/(:num)']['DELETE'] = 'restaurants/remove_tag/$1/$2';

$route['restaurants/create'] = 'restaurants/create';
$route['restaurants/edit/(:any)'] = 'restaurants/edit/$1';

$route['restaurants/search/(:any)'] = 'restaurants/search/$1';
$route['restaurants/search'] = 'restaurants/search';
$route['restaurants/(:any)'] = 'restaurants/view/$1';

$route['restaurants'] = 'restaurants/search';

$route['restaurants/(:num)/reviews'] = 'restaurants/reviews/$1';

// I'd use HTTP verbs for this, but I didn't feel like making the JS for it
$route['restaurants/(:num)/review/(:num)/edit'] = 'reviews/edit/$1/$2';
$route['restaurants/(:num)/review/(:num)/delete'] = 'reviews/delete/$1/$2';
$route['restaurants/(:num)/review/put'] = 'reviews/put/$1';

$route['reviews/edit/(:num)'] = 'reviews/edit/$1';
// $route['restaurants/(:num)/reviews/thumbs_up'] = 'reviews/thumbs_up/$1';
// $route['restaurants/(:num)/reviews/thumbs_down'] = 'reviews/thumbs_down/$1';
$route['restaurants/(:num)/reviews/thumbs_up']['PUT'] = 'reviews/thumbs_up/$1';
$route['restaurants/(:num)/reviews/thumbs_down']['PUT'] = 'reviews/thumbs_down/$1';
$route['restaurants/(:num)/upvote']['PUT'] = 'restaurants/upvote/$1';
$route['restaurants/(:num)/downvote']['PUT'] = 'restaurants/downvote/$1';

$route['users/login/(.+)'] = 'users/login/$1';
