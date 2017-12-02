<div class="container">
	<div class="card">
		<div class="card-body">
			<div class="clearfix">
				<a class="btn btn-secondary float-right" aria-label="Return to Playlist Search" href="/userplaylists">&times;</a>
				<h2><?php echo $playlist['title']; ?>
					<br><small class="text-muted">
					<!-- Uncomment the following once we have public profiles available to view -->
					<!-- <a href="<?php echo site_url('/users/'.$author_id); ?>">author: <?php echo $author_name?></a> -->
					<?php echo $author_name; ?>
				</small></h2>
			</div>
			<p class="card-text">
				<?php
				echo $playlist['desc'];
				?>
			</p>
			<?php if (empty($restaurants)): ?>
				<p class="text-muted">This playlist is empty.</p>
			<?php else: ?>
			<table class="table">
				<?php foreach ($restaurants as $key => $restaurant): ?>
				<tr>
					<th scope="row"><?php echo $key+1; ?></th>
					<td><a href="<?php echo site_url('/restaurants/'.$restaurant['id']); ?>"><?php echo $restaurant['name']; ?></a></td>
				</tr>
				<?php endforeach; ?>
			</table>
			<?php endif; ?>
		<?php if ($user_id === $author_id || $admin): ?>
			<a href="<?php echo site_url('/userplaylists/edit/'.$playlist['id']); ?>" class="btn btn-secondary">Edit</a>
		<?php endif; ?>
		</div>
	</div>
</div>
