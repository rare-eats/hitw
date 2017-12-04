<!doctype html>
<html lang="en">
  <head>
  	<title>Rare Eats<?php if(isset($title)){ echo " - ".$title; }?></title>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

	<!-- Fontawesome -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

	<link rel="stylesheet" href="/css/site.css"></link>
	<!-- Load additional CSS files passed in $data, should they exist -->
	<?php if(isset($css)): ?>
		<?php foreach($css as $style): ?>
			<link rel="stylesheet" href="<?php echo $style.'.css'; ?>"></link>
		<?php endforeach; ?>
	<?php endif; ?>
  </head>
  <body>
  	<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-primary">
		<a class="navbar-brand" href="/"><img src="/logo_256.png" alt="Rare Eats" /></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="/restaurants/search"><i class="fa fa-search" aria-label="Search"></i> Restaurants</a>
				</li>
		<?php if($this->session->has_userdata('id')): ?>
				<li class="nav-item">
					<a class="nav-link" href="/users/view"><i class="fa fa-list" aria-hidden="true"></i> My Playlists</a>
				</li>
		<?php endif; ?>
				<li class="nav-item">
					<a class="nav-link" href="/userplaylists/search"><i class="fa fa-search" aria-label="Search"></i> Playlists</a>
				</li>
		<?php if($this->session->has_userdata('id')): ?>
				<li class="nav-item">
					<a class="nav-link" href="/restaurants/create"><i class="fa fa-plus" aria-hidden="true"></i> Add a Restaurant</a>
				</li>
			<?php if($this->users_model->is_admin()): ?>
				<li class="nav-item">
					<a class="nav-link" href="/restaurants/tags"><i class="fa fa-tags" aria-hidden="true"></i> Tag Management</a>
				</li>
			<?php endif; ?>
		<?php endif; ?>
			</ul>
			<ul class="navbar-nav ml-auto">
			<?php if($this->session->has_userdata('id')): ?>
				<li class="nav-item">
					<a class="nav-link" href="/users/view"><i class="fa fa-user" aria-hidden="true"></i> View Profile</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/users/logout"> <i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
				</li>
			</ul>
    <?php else:?>
				<a class="nav-link" href="/users/login<?php echo $_SERVER['REQUEST_URI'];?>"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
			<?php endif ?>
		</div>
	</nav>
