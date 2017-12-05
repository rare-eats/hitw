<div class="container">

<div class="card">
	<div class="card-body">
		<div class="clearfix">
            <a class="btn btn-secondary float-right" href="/"><i class="fa fa-level-up" aria-label="return to list"></i></a>
			<h2 class="text-center"><?php echo $title; ?></h2>
		</div>

<?php if(empty($playlists)): ?>
	<h3 class="text-center text-muted">No playlists available.</h3>
<?php endif; ?>
<?php foreach ($playlists as $playlist): ?>
	<a style="text-decoration: none;" href="<?php echo site_url('userplaylists/'.$playlist['id']); ?>">
		<div class="card">
			<div class="card-body">
				<h3><?php if ($playlist['private']): ?>
						<span class="text-dark"><i class="fa fa-lock" aria-label="private"></i> (Private)</span>
					<?php endif; ?>
					<?php echo $playlist['title']; ?> 
					<small class="text-muted">
						by <?php if ($this->session->id !== $playlist['author_id']) { echo $playlist['author_name'][0]; }
						else { echo 'you'; } ?>
					</small></h3>
				<p class="card-text text-dark"><?php echo $playlist['desc']; ?></p>
			</div>
		</div>
	</a>
<?php endforeach; ?>
</div>
</div>
</div>