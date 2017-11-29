<div class="container">
	<div class="card">
		<div class="card-body">
			<h2><?php echo $playlist['title']; ?>
				<br><small class="text-muted">
					<!-- <a href="<?php echo site_url('/users/'.$author_id); ?>">author: <?php echo $author_name?></a> -->
					<?php echo $author_name?>
				</small>
			</h2>
			<p class="card-text">
				<?php 
				echo $playlist['desc']; 
				?>
			</p>
			<ol>
				<?php foreach ($restaurants as $restaurant) { ?>
					<?php echo '<li><a href=' . site_url('/restaurants/'.$restaurant['id']).'>'.$restaurant['name'].'</a></li>'; ?>
				<?php } ?>
			</ol>
			<a href="<?php echo site_url('/userplaylists/edit/'.$playlist['id']); ?>" class="btn btn-secondary">Edit</a>
			<a class="btn btn-outline-primary" href="<?php echo site_url('/'); ?>">Go back</a>
		</div>
	</div>
</div>
