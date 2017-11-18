<div class="container">
	<div class="card">
		<div class="card-body">
			<h2><?php echo $playlist['title']; ?>
				<br><small class="text-muted">author: (<?php echo $playlist['author_id']?>)</small>
			</h2>
			<p class="card-text">
				<?php 
				echo $playlist['desc']; 
				?>
			</p>
			<ul>
				<li> Put a link to a Restaurant here! Probably also the restaurant's display image/icon!</li>
				<li> Here's another restaurant in this playlist! </li>
			</ul>
			<a href="<?php echo site_url('/userplaylists/edit/'.$playlist['id']); ?>" class="btn btn-secondary">Edit</a>
			<hr />
		</div>
	</div>
	<div class="row" style="margin-top: 1rem;">
		<div class="col text-center">
			<a class="btn btn-outline-primary" href="<?php echo site_url('/'); ?>">Go back</a>
		</div>
	</div>
</div>