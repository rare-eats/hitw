<!doctype html>
<html lang="en">
  <head>
  	<title>Rare Eats - <?php echo $title;?></title>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body>
  	<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-primary">
		<a class="navbar-brand" href="#">Rare Eats</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">My Playlists</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Recommended</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo site_url('restaurants/create'); ?>">Add a 	Restaurant</a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
			<?php if($this->session->has_userdata('id')): ?>
				<li class="nav-item">
					<a class="nav-link" href="users/view/<?php echo $this->session->userdata('id');?>">View Profile</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="users/logout">Logout</a>
				</li>
			</ul>
			<?php else: ?>
				<a class="nav-link" href="users/login">Login</a>
			<?php endif ?>
		</div>
	</nav>