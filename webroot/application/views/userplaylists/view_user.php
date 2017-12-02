<div class="container">

<div class="card">
	<div class="card-body">
		<h2 class="text-center"><?php echo $title ?></h2>

<?php if(empty($playlists)): ?>
	<h3 class="text-center text-muted">No playlists available.</h3>
<?php endif; ?>
<?php foreach ($playlists as $playlist): ?>
	<a style="text-decoration: none;" href="<?php echo site_url('userplaylists/'.$playlist['id']); ?>">
		<div class="card">
			<div class="card-body">
				<h3><?php echo $playlist['title']; ?> 
					<small class="text-muted">
						by <?php echo $playlist['author_name'][0]; ?>
					</small></h3>
				<p class="card-text text-dark"><?php echo $playlist['desc']; ?></p>
			</div>
		</div>
	</a>
<?php endforeach; ?>
</div>
</div>