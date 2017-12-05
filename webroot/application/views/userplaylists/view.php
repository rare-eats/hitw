<div class="container">
	<div class="card">
		<div class="card-body">
		<?php if ($user_id === $author_id || $admin || $playlist['private'] == False): ?>
				<div class="clearfix">
					<a class="btn btn-secondary float-right" aria-label="Return to Playlist Search" href="/userplaylists"><i class="fa fa-level-up" aria-label="return to list"></i></a>
					<h2><?php echo $playlist['title']; ?>
						<br><small class="text-muted">
						author: <a href="<?php echo site_url('userplaylists/user/'.$author_id); ?>"><?php echo $author_name?></a>
					</small></h2>
				</div>
				<p class="card-text">
					<?php
					echo $playlist['desc'];
					?>
				</p>
			<?php if ($user_id === $author_id || $admin): ?>
			<div class="mb-2">
				<a href="<?php echo site_url('/userplaylists/edit/'.$playlist['id']); ?>" class="btn btn-secondary mb-2">Edit</a>
			<?php elseif ($this->session->has_userdata('id')): ?>
				<?php if ($subscribed): ?>
					<a href="<?php echo site_url('/userplaylists/unsubscribe/'.$playlist['id']); ?>" class="btn btn-primary">Unsubscribe</a>
				<?php else: ?>
					<a href="<?php echo site_url('/userplaylists/subscribe/'.$playlist['id']); ?>" class="btn btn-primary">Subscribe</a>
				<?php endif ?>
			</div>
			<?php endif ?>
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
		<?php else: ?>
			<h2 class="text-muted">You do not have permission to view this private playlist, please <a href="<?php echo site_url('users/login'); ?>">log in</a>.</h2>
		<?php endif; ?>
		</div>
	</div>
</div>
