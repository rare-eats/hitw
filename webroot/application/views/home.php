<?php
	
	$this->restaurants_model->load_food_categories();
?>

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
<div class="container-fluid">
	<div class="row">
		<div class="col">
			<h2 class="display-2">Featured Lists</h2>
		</div>
	</div>
	<div class="row">
		<div class="col d-lg-flex justify-content-sm-center">
		<?php foreach ($recommended as $playlist): ?>
			<div class="card" style="width: 20rem; display: inline-block; margin: 1rem;">
				<img class="card-img-top" src="http://via.placeholder.com/350x150" alt="Card image cap">
				<div class="card-body">
					<h4 class="card-title"><?php echo $playlist['title']; ?></h4>
					<p class="card-text"><?php echo $playlist['desc']; ?></p>
					<a href="#" class="btn btn-primary">Taste It</a>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<h2 class="display-2">My Lists</h2>
		</div>
	</div>
	<div class="row">
		<div class="col d-lg-flex justify-content-sm-center">
		<?php foreach ($playlists as $playlist): ?>
			<div class="card" style="width: 20rem; display: inline-block; margin: 1rem;">
				<img class="card-img-top" src="http://via.placeholder.com/350x150" alt="Card image cap">
				<div class="card-body">
					<h4 class="card-title"><?php echo $playlist['title']; ?></h4>
					<p class="card-text"><?php echo $playlist['desc']; ?></p>
					<a href="#" class="btn btn-primary">Taste It</a>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</div>