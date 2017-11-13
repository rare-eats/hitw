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