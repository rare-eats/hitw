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
$route['userplaylists/(:any)'] = 'userplaylists/view/$1';
$route['userplaylists'] = 'userplaylists/view';
// remove 'user in userplaylists routes possibly (left side)'

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['restaurants/tags']['PUT'] = 'restaurant_tags/add_tag';
$route['restaurants/tags']['DELETE'] = 'restaurant_tags/remove_tag';
$route['restaurants/tags']['GET'] = 'restaurant_tags';

$route['restaurants/(:num)/tags/(:num)']['DELETE'] = 'restaurants/remove_tag/$1/$2';

$route['restaurants/create'] = 'restaurants/create';
$route['restaurants/edit/(:any)'] = 'restaurants/edit/$1';
$route['restaurants/(:any)'] = 'restaurants/view/$1';
$route['restaurants'] = 'restaurants/view';